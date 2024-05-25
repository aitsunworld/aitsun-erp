<?php 
	
    use App\Models\PaymentsModel as PaymentsModel;
    use App\Models\AccountcategoryModel as AccountcategoryModel;
    use App\Models\InvoiceModel as InvoiceModel;
    use App\Models\StockModel as StockModel;
    use App\Models\ProductsModel as ProductsModel;

	function capital_amount($company,$financial_year,$from,$to){
		$PaymentsModel= new PaymentsModel();
	    $total=0;

	    $acid=account_name_of_capital('capital',$company);
	    $payments=$PaymentsModel->where('company_id',$company)->where('account_name',$acid)->where('bill_type','payment')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$total+=$pm->amount;
	    }
	    return $total;
	}

	function account_name_of_capital($billtype,$company){
	    $AccountcategoryModel = new AccountcategoryModel();
	    $AccountcategoryModel->where('company_id',$company);
	    $AccountcategoryModel->where('slug',$billtype);
	    $get_serial=$AccountcategoryModel->first();
	    if ($get_serial) {
	       return $get_serial['id'];
	    }else{
	        return 0;
	    }
	    
	}

	function account_category_amount($company,$financial_year,$billtype,$acid,$from,$to){
		$PaymentsModel= new PaymentsModel();
	    $total=0;
	    $payments=$PaymentsModel->where('company_id',$company)->where('account_name',$acid)->where('bill_type',$billtype)->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$total+=$pm['amount'];
	    }
	    return $total;
	}

	function indirect_expense_amount($company,$financial_year,$from,$to){
		$PaymentsModel= new PaymentsModel();
	    $total=0;
	    $payments=$PaymentsModel->where('company_id',$company)->where('bill_type','expense')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$total+=$pm['amount'];
	    }
	    return $total;
	}

	function direct_expenses_array($company){
		$AccountcategoryModel= new AccountcategoryModel();
	    $acccat=$AccountcategoryModel->where('company_id',$company)->where('group_head','direct_expenses')->where('deleted',0)->where('side','dr')->findAll();
	    return $acccat;
	}

	function indirect_expenses_array($company){
		$AccountcategoryModel= new AccountcategoryModel();
	    $acccat=$AccountcategoryModel->where('company_id',$company)->where('group_head','indirect_expenses')->where('deleted',0)->where('side','dr')->findAll();
	    return $acccat;
	}

	

	function get_tax($company,$financial_year,$from,$to,$type){
		$PaymentsModel= new PaymentsModel();
	    $cost=0;

	    if ($type=='payable') {  

	    	$payments=$PaymentsModel->where('company_id',$company)->where('bill_type!=','purchase')->where('bill_type!=','sale return')->where('bill_type!=','receipt')->where('bill_type!=','expense')->where('bill_type!=','payment')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    	foreach ($payments->findAll() as $pm) {
		    	$cost+=tax_amount_of_invoice($pm['invoice_id']);
		    }

	    }elseif ($type=='receivable') {
	    	$payments=$PaymentsModel->where('company_id',$company)->where('bill_type!=','sale')->where('bill_type!=','purchase return')->where('bill_type!=','receipt')->where('bill_type!=','expense')->where('bill_type!=','payment')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    	foreach ($payments->findAll() as $pm) {
		    	$cost+=tax_amount_of_invoice($pm['invoice_id']);
		    }
	    }

	    
	    return $cost;
		
	}

	function tax_amount_of_invoice($invoice)
	{
		$InvoiceModel= new InvoiceModel();
	    $tax=0;

	    $getin=$InvoiceModel->where('id',$invoice)->first();
	    if ($getin) {
	    	$tax+=$getin['tax'];
	    }
	    return $tax;
	}

	function sales($company,$financial_year,$from,$to){
		$PaymentsModel= new PaymentsModel();
	    $cost=0;

	    
	    $payments=$PaymentsModel->where('company_id',$company)->where('bill_type','sale')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$cost+=$pm['amount'];
	    }

	    return $cost;
		
	}

	function sales_return($company,$financial_year,$from,$to){
	    $PaymentsModel= new PaymentsModel();
	    $sold=0;


	    $payments=$PaymentsModel->where('company_id',$company)->where('bill_type','sale return')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$sold+=$pm['amount'];
	    }

	    return $sold;

	}

	function purchase($company,$financial_year,$from,$to){
		$PaymentsModel= new PaymentsModel();
	    $cost=0;

	    
	    $payments=$PaymentsModel->where('company_id',$company)->where('bill_type','purchase')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$cost+=$pm['amount'];
	    }

	    return $cost;
		
	}

	function purchase_return($company,$financial_year,$from,$to){
	    $PaymentsModel= new PaymentsModel();
	    $sold=0;


	    $payments=$PaymentsModel->where('company_id',$company)->where('bill_type','purchase return')->where('deleted',0)->where('DATE(datetime) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

	    foreach ($payments->findAll() as $pm) {
	    	$sold+=$pm['amount'];
	    }

	    return $sold;

	}

	

	function closing_stock($company,$financial_year){
		$StockModel= new StockModel();
		$ProductsModel= new ProductsModel();
		$opening_stock='000.00';
		$get_pro = $ProductsModel->where('deleted',0)->where('company_id',$company)->findAll();
			foreach ($get_pro as $gp) {
				$op_stock=$StockModel->where('company_id',$company)->where('product_id',$gp['id'])->first();
				if ($op_stock) {
					$opening_stock=$op_stock['closing_stock']*$gp['purchased_price'];
				}
			}

		
		return $opening_stock;
	}

	function opening_stock($company,$financial_year){
		$StockModel= new StockModel();
		$ProductsModel= new ProductsModel();
		$opening_stock='000.00';
		$get_pro = $ProductsModel->where('deleted',0)->where('company_id',$company)->findAll();
			foreach ($get_pro as $gp) {
				$op_stock=$StockModel->where('company_id',$company)->where('product_id',$gp['id'])->first();
				if ($op_stock) {
					$opening_stock=$op_stock['opening_stock']*$gp['purchased_price'];
				}
				
			}

		
		return $opening_stock;
	}

?>