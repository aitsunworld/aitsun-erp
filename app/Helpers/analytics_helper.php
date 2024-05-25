<?php 
	use App\Models\InvoiceModel as InvoiceModel;
	use App\Models\InvoiceitemsModel as InvoiceitemsModel;
	use App\Models\ProductsModel as ProductsModel;
	use App\Models\AccountingModel as AccountingModel;


	
	////////////////////////////////  ANALYTICS //////////////////////////////////////
	function this_year_cost($company,$year,$now_time){
		$InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
		$ProductsModel= new ProductsModel();
	    $cost=0;

	    $acti=activated_year($company);

	    $invoices=$InvoiceModel->where('company_id',$company)->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('invoice_type','purchase')->where('deleted', 0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id',$inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$products=$ProductsModel->where('id',$items['product_id']);
	    				foreach ($products->findAll() as $product) {
	    					$taaxxx=$product['purchased_price']*percent_of_tax($product['tax'])/100;
	    					$propuprice=$product['purchased_price']+$taaxxx;
	    					$precost=$propuprice*$items['quantity'];
	    					$cost+=$precost;
	    				}
	    		}
	    }
	    return $cost-this_year_purchase_return($company,$year,$now_time);
		
	}

	function this_year_sold($company,$year,$now_time){
	   	$InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
	    $sold=0;
	    $acti=activated_year($company);

	    $invoices=$InvoiceModel->where('company_id', $company)->where('invoice_type','sales')->where('invoice_date', get_date_format($now_time,'Y-m-d'))->where('deleted', 0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id', $inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$sold+=$items['amount'];
	    		}
	    }
	    return $sold-this_year_sold_return($company,$year,$now_time);

	}

	function this_year_sold_return($company,$year,$now_time){
	    $InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
	    $sold=0;
	    $acti=activated_year($company);

	    $invoices=$InvoiceModel->where('company_id',$company)->where('invoice_type','sales_return')->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('deleted',0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id', $inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$sold+=$items['amount'];
	    		}
	    }
	    return $sold;

	}

	function this_year_purchase_return($company,$year,$now_time){
	    $InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
	    $sold=0;
	    $acti=activated_year($company);

	    $invoices=$InvoiceModel->where('company_id',$company)->where('invoice_type','purchase_return')->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('deleted',0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id' ,$inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$sold+=$items['amount'];
	    		}
	    }
	    return $sold;

	}


	function cost($company,$month,$year,$now_time){
		$InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
		$ProductsModel= new ProductsModel();
	    $cost=0;
	    $acti=activated_year($company);

	    $invoices=$InvoiceModel->where('company_id', $company)->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('month(invoice_date)',$month)->where('invoice_type','purchase')->where('deleted' ,0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id',$inv['id']);

	    		foreach ($invoice_items->findAll() as $items) {
	    			$products=$ProductsModel->where('id',$items['product_id']);
	    				foreach ($products->findAll() as $product) {
	    					$precost=$product['purchased_price']*$items['quantity'];
	    					$cost+=$precost;
	    				}
	    		}
	    }
	    return $cost-cost_return($company,$month,$year,$now_time);
	}

	function sold($company,$month,$year,$now_time){
		$InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
	    $sold=0;
	    $acti=activated_year($company);
	    $invoices=$InvoiceModel->where('company_id',$company)->where('invoice_type','sales')->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('month(invoice_date)',$month)->where('deleted',0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id',$inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$sold+=$items['amount'];
	    		}
	    }
	    return $sold-sold_return($company,$month,$year,$now_time);

	}

	function sold_return($company,$month,$year,$now_time){
		$InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
	    $sold=0;
	    $acti=activated_year($company);
	    $invoices=$InvoiceModel->where('company_id' ,$company)->where('invoice_type','sales_return')->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('month(invoice_date)',$month)->where('deleted',0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id',$inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$sold+=$items['amount'];
	    		}
	    }
	    return $sold;

	}

	function cost_return($company,$month,$year,$now_time){
		$InvoiceModel = new InvoiceModel();
		$InvoiceitemsModel= new InvoiceitemsModel();
	    $sold=0;
	    $acti=activated_year($company);
	    $invoices=$InvoiceModel->where('company_id',$company)->where('invoice_type','purchase_return')->where('invoice_date',get_date_format($now_time,'Y-m-d'))->where('deleted',0);
	    
	    foreach ($invoices->findAll() as $inv) {
	    	$invoice_items=$InvoiceitemsModel->where('invoice_id',$inv['id'])->where('type','single');

	    		foreach ($invoice_items->findAll() as $items) {
	    			$sold+=$items['amount'];
	    		}
	    }
	    return $sold;

	}

	function due_amount_of_company($company_id){
	    $InvoiceModel = new InvoiceModel();
	    $dueamount=0; 
	    $un=$InvoiceModel->select('sum(due_amount) as total_due_amount')->where('company_id',$company_id)->where('deleted',0)->first();
	    
	    $dueamount = $un['total_due_amount'];
	    
	    return $dueamount; 


	}

	function total_stock_value_company($company){
    $AccountingModel = new AccountingModel();
    $stockvalue=0; 
    
    $stock_data=$AccountingModel->select('sum(closing_value) as total_closing_value')->where('company_id',$company)->where('type','stock')->where('deleted',0)->first();
 
		$stockvalue = $stock_data['total_closing_value'];
 
    return $stockvalue;

}

?>