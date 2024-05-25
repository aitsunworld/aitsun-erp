<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\FinancialYears;
use App\Models\AccountingModel;
use App\Models\ProductsModel;
use App\Models\InvoiceModel;
use App\Models\PaymentsModel;
use App\Models\PayrollitemsModel;
use App\Models\StockValuesTable;
 

class Accounting_library extends BaseController {

        public function index()
        {  
            $session=session(); 
            if($session->has('isLoggedIn')){ 
	            $UserModel=new Main_item_party_table;
	            $ProductsModel= new Main_item_party_table;
	            $AccountingModel=new AccountingModel;
	            $PayrollitemsModel=new PayrollitemsModel;
	            $InvoiceModel= new InvoiceModel;
	            $PaymentsModel= new PaymentsModel;
	            $StockValuesTable = new StockValuesTable;

	            $myid=session()->get('id');
	            $mytoken=session()->get('user_token');

	            $con = array( 
	                'id' => session()->get('id') 
	            );
	            $user=$UserModel->where('id',$myid)->first(); 
     
	            $acti=activated_year(company($myid));


	            //////////////////// Product final closing update///////////
	            $all_products_to_final_close=$ProductsModel->where('company_id',company($myid))->where('created_by',$myid)->where('user_token',$mytoken)->where('product_method!=','service')->groupStart()->where('ready_to_update',1)->orWhere('edit_effected',0)->groupEnd()->findAll();

	            foreach ($all_products_to_final_close as $fp) {
	                update_final_closing_value($fp['id']);
	            }
	            //////////////////// Product final closing update///////////

	            /////////////////////////////  CUSTOMER TABLE /////////////////////////
	            $all_customers=$UserModel->where('company_id',company($myid))->where('created_by',$myid)->where('user_token',$mytoken)->groupStart()->where('effected',0)->orWhere('edit_effected',0)->groupEnd()->findAll();

	            foreach ($all_customers as $us) {

	            	if (!is_ledger_exist(company($myid),$us['id'],'ledger')) {
	            		$ac_data = [
                            'company_id' => company($myid),
                            'group_head'=>user_name($us['id']),
                            'parent_id'=>id_of_group_head(company($myid),activated_year(company($myid)),'Sundry Debtors'),
                            'type'=>'ledger',
                            'customer_id'=>$us['id'],
                            'default'=>1, 
                            'opening_balance'=>$us['opening_balance'], 
                            'closing_balance'=>$us['opening_balance'],
                            'customer_default_user'=>$us['default_user'],
                        ];

                        $AccountingModel->save($ac_data);

                        $UserModel->update($us['id'],array('effected'=>1));
	            	}else{
	            		// Ledger update
                            $geac=$AccountingModel->where('customer_id',$us['id'])->where('type','ledger')->first(); 

                            if ($geac) {
                            	$st_old_cl_bl=$geac['closing_balance'];
	 							$old_op_bl=$geac['opening_balance'];
								$new_op_bl=$us['opening_balance'];
	                            $st_closing_balance=($st_old_cl_bl-$old_op_bl)+$new_op_bl;

                        	    $ac_data = [ 
		                            'group_head'=>user_name($us['id']), 
		                            'opening_balance'=>$us['opening_balance'], 
		                            'closing_balance'=>$st_closing_balance, 
		                        ];
		                        $AccountingModel->update($geac['id'],$ac_data);

                            }
                        // Ledger update

                        $UserModel->update($us['id'],array('effected'=>1,'edit_effected'=>1));
                        if ($us['deleted']==1) {
                        	$dac_data = [ 
	                            'deleted'=>1,
	                        ];
	                        $AccountingModel->update($geac['id'],$dac_data);
                        }
	            	}

	            }

	            /////////////////////////////  CUSTOMER TABLE /////////////////////////
 



	            /////////////////////////////  PRODUCTS TABLE /////////////////////////


	            $all_products=$ProductsModel->where('company_id',company($myid))->where('created_by',$myid)->where('user_token',$mytoken)->where('product_method!=','service')->groupStart()->where('effected',0)->orWhere('edit_effected',0)->groupEnd()->findAll();
	            
	            foreach ($all_products as $pr) { 

	            	if (!is_ledger_exist(company($myid),$pr['id'],'stock')) {
	            		$p_ac_data = [
                            'company_id' => company($myid),
                            'group_head'=>$pr['product_name'],
                            'type'=>'stock',
                            'customer_id'=>$pr['id'],
                            'default'=>1, 
                            'opening_balance'=>$pr['stock'], 
                            'closing_balance'=>$pr['stock'], 
                            'opening_value'=>$pr['stock']*$pr['purchased_price'], 
                            'closing_value'=>$pr['stock']*$pr['purchased_price'], 
                        ];
                        $AccountingModel->save($p_ac_data);
                        // echo $pr['stock'].'<br>';
                        $ProductsModel->update($pr['id'],array('effected'=>1));
                        

                        // product stock value
                        
		            		
                        // product stock value

	            	}else{

	            		// Ledger update
                        $pgeac=$AccountingModel->where('customer_id',$pr['id'])->where('type','stock')->first(); 
                        $pstc=$StockValuesTable->where('product_id',$pr['id'])->first(); 

                            if ($pgeac) {
                            	$st_old_cl_bl=$pgeac['closing_balance'];
	 							$old_op_bl=$pgeac['opening_balance'];
								$new_op_bl=$pr['stock'];
	                            $st_closing_balance=($st_old_cl_bl-$old_op_bl)+$new_op_bl;

                        	    $ac_data = [ 
		                            'group_head'=>product_name($pr['id']), 
		                            'opening_balance'=>$pr['stock'], 
		                            'closing_balance'=>$st_closing_balance, 
		                            'opening_value'=>$pr['stock']*$pr['purchased_price'], 
		                            'closing_value'=>$st_closing_balance*$pr['purchased_price'], 
		                        ];
		                        $AccountingModel->update($pgeac['id'],$ac_data);

                            }
                        // Ledger update

                        $ProductsModel->update($pr['id'],array('effected'=>1,'edit_effected'=>1));
                        if ($pr['deleted']==1) {
                        	$dac_data = [ 
	                            'deleted'=>1,
	                        ];
	                        $AccountingModel->update($pgeac['id'],$dac_data);
                        }

                       
	            	}

	            	init_update_final_closing_product($pr['id']); 
	            } 


	            /////////////////////////////  PRODUCTS TABLE /////////////////////////


 





		        /////////////////////////////  INVOICES TABLE /////////////////////////


	   			$all_invoices=$InvoiceModel->where('company_id',company($myid))->where('created_by',$myid)->where('user_token',$mytoken)->where('type!=','manufactured')->groupStart()->where('effected',0)->orWhere('edit_effected',0)->groupEnd()->findAll();

		            foreach ($all_invoices as $in) {




		            	if ($in['effected']==0) {
		            	 	
		            	 	// Ledger update
	                            $i_geac=$AccountingModel->where('customer_id',$in['customer'])->first();

	                            $i_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$in['customer']),'closing_balance'); 

	                            $i_closing_balance=0;

	                            if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {
	                            		$i_closing_balance=$i_old_closing_balance+$in['total'];

	                            		// echo $i_old_closing_balance.'[][]'.$in['total'];
	                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
	                            		$i_closing_balance=$i_old_closing_balance-$in['total'];
	                            		// echo $i_old_closing_balance.'[][]'.$in['total'];
	                            	}

	                            

	                            if ($i_geac) {
	                        	    $i_ac_data = [   
			                            'closing_balance'=>$i_closing_balance, 
			                        ];

			                        if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return' || $in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
			                        	$AccountingModel->update($i_geac['id'],$i_ac_data);
			                        }
			                        
	                            }

	                            
	                        // Ledger update
	                        

	                        // Product stock update
	                        foreach (invoice_items_array_for_accounts($in['id']) as $pros){
	                            $pgeac=$AccountingModel->where('customer_id',$pros['product_id'])->where('type','stock')->first(); 


// 
	                            $pstc=$StockValuesTable->where('product_id',$pros['product_id'])->where('invoice_type','purchase')->orderBy('invoice_id','desc')->first(); 


	                            if ($pgeac) {

	                            	$i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$pros['product_id']),'closing_balance','stock'); 

	                            	$at_price=0;
	                            	$i_closing_balance=0;
	                            	$final_closing_value=0;

	                            	$is_sold_in_primary=true;

	                            	if ($pros['unit']!=$pros['in_unit']) {
	                            		$is_sold_in_primary=false;
	                            	}

	                            	if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {

	                            		$at_price=accounting_purchase_price($pros['product_id']);
	                            		if ($is_sold_in_primary) {
	                            			$i_closing_balance=$i_old_closing_balance-$pros['quantity']; 
	                            		}else{
	                            			if ($pros['conversion_unit_rate']>0) {
			                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
			                            			}else{
			                            				$ans_qty=$pros['quantity']*1;
			                            			}
	                            			$i_closing_balance=$i_old_closing_balance-$ans_qty; 
	                            		}

	                            		
	                            		$final_closing_value=$i_closing_balance*$at_price;


	                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
	                            		$at_price=accounting_purchase_price($pros['product_id']);
	                            		if ($is_sold_in_primary) {
	                            			$i_closing_balance=$i_old_closing_balance+$pros['quantity']; 
	                            		}else{
	                            			if ($pros['conversion_unit_rate']>0) {
			                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
			                            			}else{
			                            				$ans_qty=$pros['quantity']*1;
			                            			}   
	                            			$i_closing_balance=$i_old_closing_balance+$ans_qty; 
	                            		}
	                            		
	                            		$final_closing_value=$i_closing_balance*$at_price;
	                            	}



	                            	$ac_data = [   
			                            'closing_balance'=>$i_closing_balance,  
			                            'closing_value'=>$final_closing_value, 
			                        ];
			                        if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return' || $in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
			                        $AccountingModel->update($pgeac['id'],$ac_data);

			                        // echo $final_closing_value;
			                        }

	                            }

	                            init_update_final_closing_product($pros['product_id']);
	                        }
	                        // Product stock update

	                        

	                        $InvoiceModel->update($in['id'],array('effected'=>1,'edit_effected'=>1));

		            	}else{

		            		if ($in['edit_effected']==0 && $in['deleted']==0) {
		            			 

		            			// Ledger update
		                            $ii_geac=$AccountingModel->where('customer_id',$in['customer'])->first();

		                             
		                             
		                            $ii_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$in['customer']),'closing_balance'); 

		                            $ii_closing_balance=0;

		                            if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {
	                            		$ii_closing_balance=($ii_old_closing_balance-$in['old_total'])+$in['total'];
	                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
	                            		$ii_closing_balance=($ii_old_closing_balance-$in['old_total'])-$in['total'];
	                            	}

		                            if ($ii_geac) {
		                        	    $ii_ac_data = [   
				                            'closing_balance'=>$ii_closing_balance, 
				                        ];
				                         if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return' || $in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
				                        $AccountingModel->update($ii_geac['id'],$ii_ac_data);
				                        }
		                            }
		                        // Ledger update


	                            // Concession Ledger update
		                            $ci_geac=$AccountingModel->where('id',id_of_group_head(company($myid),activated_year(company($myid)),'Discount allowed'))->first();

		                             
		                             
		                            $ci_old_closing_balance=balance(company($myid),id_of_group_head(company($myid),activated_year(company($myid)),'Discount allowed'),'closing_balance'); 

		                            $ci_closing_balance=($ci_old_closing_balance-$in['old_concession'])+$in['discount'];

		                            if ($ci_geac) {
		                        	    $ci_ac_data = [   
				                            'closing_balance'=>$ci_closing_balance, 
				                        ];
				                        $AccountingModel->update($ci_geac['id'],$ci_ac_data);
		                            }
		                        // Concession Ledger update




	                            // Product stock update
			                        foreach (invoice_items_array_for_accounts($in['id']) as $pros){
			                            $pgeac=$AccountingModel->where('customer_id',$pros['product_id'])->where('type','stock')->first(); 
			                            
			                            if ($pgeac) {

			                            	$i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$pros['product_id']),'closing_balance','stock'); 

			                            	$at_price=0;
			                            	$i_closing_balance=0;
			                            	$old_quantity=$pros['old_quantity'];
			                            	$final_closing_value=0;
			                            	
			                            	$is_sold_in_primary=true; 

											if ($pros['unit']!=$pros['in_unit']) {
												$is_sold_in_primary=false;
											}

			                            	if ($pros['deleted']==0) {
			                            		if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {
				                            		$at_price=accounting_purchase_price($pros['product_id']);

				                            		if ($is_sold_in_primary) {
														$i_closing_balance=($i_old_closing_balance+$old_quantity)-$pros['quantity']; 
													}else{
														if ($pros['conversion_unit_rate']>0) {
				                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
				                            			}else{
				                            				$ans_qty=$pros['quantity']*1;
				                            			}
														$i_closing_balance=($i_old_closing_balance+$old_quantity)-$ans_qty; 
													}

				                            		

				                            		$final_closing_value=$i_closing_balance*$at_price;
				                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
				                            		$at_price=accounting_purchase_price($pros['product_id']);

				                            		if ($is_sold_in_primary) {
														$i_closing_balance=($i_old_closing_balance-$old_quantity)+$pros['quantity'];
													}else{
														if ($pros['conversion_unit_rate']>0) {
			                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
			                            			}else{
			                            				$ans_qty=$pros['quantity']*1;
			                            			}
														$i_closing_balance=($i_old_closing_balance-$old_quantity)+$ans_qty;
													}

				                            		
				                            		$final_closing_value=$i_closing_balance*$at_price;
				                            	}
			                            	}else{
			                            		if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {
				                            		$at_price=accounting_purchase_price($pros['product_id']);

				                            		
				                            		if ($is_sold_in_primary) {
														$i_closing_balance=$i_old_closing_balance+$pros['quantity'];
													}else{
														if ($pros['conversion_unit_rate']>0) {
			                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
			                            			}else{
			                            				$ans_qty=$pros['quantity']*1;
			                            			}
														$i_closing_balance=$i_old_closing_balance+$ans_qty;
													}


				                            		$final_closing_value=$i_closing_balance*$at_price;
				                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
				                            		$at_price=accounting_purchase_price($pros['product_id']);

				                            		if ($is_sold_in_primary) {
														$i_closing_balance=$i_old_closing_balance-$pros['quantity']; 
													}else{
														if ($pros['conversion_unit_rate']>0) {
				                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
				                            			}else{
				                            				$ans_qty=$pros['quantity']*1;
				                            			}
														$i_closing_balance=$i_old_closing_balance-$ans_qty; 
													}

				                            		
				                            		$final_closing_value=$i_closing_balance*$at_price;
				                            	}

			                            	}
 
 
			                                

			                        	    $ac_data = [   
					                            'closing_balance'=>$i_closing_balance,  
					                            'closing_value'=>$final_closing_value, 
					                        ];
					                         if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return' || $in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {	
					                        $AccountingModel->update($pgeac['id'],$ac_data);
					                        }
	

			                            }

			                            init_update_final_closing_product($pros['product_id']);
			                        }
			                        // Product stock update

		            			 $InvoiceModel->update($in['id'],array('effected'=>1,'edit_effected'=>1));


		            		}
		            	}



		            	if ($in['effected']==0 || $in['edit_effected']==0) {
		            		
		            		if ($in['deleted']==1) {

		            			// echo 'dkjdsdhsdkjds';
		            		// Ledger delete
		                            $iid_geac=$AccountingModel->where('customer_id',$in['customer'])->first();

		                             
		                             
		                            $iid_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$in['customer']),'closing_balance'); 

		                            // echo $iid_old_closing_balance;

		                            ////problem is here

		                            if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {
	                            		$iid_closing_balance=$iid_old_closing_balance-$in['total'];
	                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
	                            		$iid_closing_balance=$iid_old_closing_balance+$in['total'];

	                            		echo $iid_old_closing_balance.'-----'.$in['total'];
	                            	}else{
	                            		$iid_closing_balance=0;
	                            	}

		                            if ($iid_geac) {
		                        	    $iid_ac_data = [   
				                            'closing_balance'=>$iid_closing_balance, 
				                        ];
				                         if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return' || $in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
				                        $AccountingModel->update($iid_geac['id'],$iid_ac_data);
				                        }
		                            }
		                        // Ledger delete



		                        // Concession Ledger delete
		                            $cid_geac=$AccountingModel->where('id',id_of_group_head(company($myid),activated_year(company($myid)),'Discount allowed'))->first();

		                             
		                             
		                            $cid_old_closing_balance=balance(company($myid),id_of_group_head(company($myid),activated_year(company($myid)),'Discount allowed'),'closing_balance'); 

		                            $cid_closing_balance=$cid_old_closing_balance-$in['old_concession'];

		                            if ($cid_geac) {
		                        	    $cid_ac_data = [   
				                            'closing_balance'=>$cid_closing_balance, 
				                        ];
				                        $AccountingModel->update($cid_geac['id'],$cid_ac_data);
		                            }
		                        // Concession Ledger delete


		                           // Product stock update
			                        foreach (invoice_items_array_for_accounts($in['id']) as $pros){
			                            $pgeac=$AccountingModel->where('customer_id',$pros['product_id'])->where('type','stock')->first(); 

			                            if ($pgeac) {

			                            	$i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$pros['product_id']),'closing_balance','stock'); 

			                            	$at_price=0;
			                            	$i_closing_balance=0;
			                            	$final_closing_value=0;
			                            	$is_sold_in_primary=true;

											if ($pros['unit']!=$pros['in_unit']) {
												$is_sold_in_primary=false;
											}


			                            	if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return') {
			                            		$at_price=accounting_purchase_price($pros['product_id']);

			                            		if ($is_sold_in_primary) {
													$i_closing_balance=$i_old_closing_balance+$pros['quantity'];
												}else{
													if ($pros['conversion_unit_rate']>0) {
			                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
			                            			}else{
			                            				$ans_qty=$pros['quantity']*1;
			                            			}
													$i_closing_balance=$i_old_closing_balance+$ans_qty;
												}

			                            		
			                            		$final_closing_value=$i_closing_balance*$at_price;
			                            	}elseif ($in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
			                            		$at_price=accounting_purchase_price($pros['product_id']);
			                            		

			                            		if ($is_sold_in_primary) {
													$i_closing_balance=$i_old_closing_balance-$pros['quantity'];
												}else{
													if ($pros['conversion_unit_rate']>0) {
			                            				$ans_qty=$pros['quantity']*1/$pros['conversion_unit_rate'];
			                            			}else{
			                            				$ans_qty=$pros['quantity']*1;
			                            			}
													$i_closing_balance=$i_old_closing_balance-$ans_qty;
												}


			                            		$final_closing_value=$i_closing_balance*$at_price;
			                            	}


			                        	    $ac_data = [   
					                            'closing_balance'=>$i_closing_balance,  
					                            'closing_value'=>$final_closing_value, 
					                        ];
					                         if ($in['invoice_type']=='sales' || $in['invoice_type']=='proforma_invoice' || $in['invoice_type']=='challan' || $in['invoice_type']=='purchase_return' || $in['invoice_type']=='purchase' || $in['invoice_type']=='sales_return') {
					                        $AccountingModel->update($pgeac['id'],$ac_data);
					                        }


			                            }

			                            init_update_final_closing_product($pros['product_id']);
			                        }
			                        // Product stock update

		                             $InvoiceModel->update($in['id'],array('effected'=>1,'edit_effected'=>1));

		            		}



		            	}
 

		            }


	            /////////////////////////////  INVOICES TABLE /////////////////////////



/////////////////////////////  PAYMENTS TABLE /////////////////////////


		            $all_payments=$PaymentsModel->where('company_id',company($myid))->where('created_by',$myid)->where('user_token',$mytoken)->groupStart()->where('effected',0)->orWhere('edit_effected',0)->groupEnd()->findAll();

foreach ($all_payments as $pmt) {

	if ($pmt['effected']==0) { 
		if ($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales'){ 
			if ($pmt['bill_type']=='sales') {
            	// Ledger Account Name
                $iip_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first();
                $iip_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance'); 
                $iip_closing_balance=$iip_old_closing_balance-$pmt['amount']; 


                if ($iip_geac) {
            	    $iip_ac_data = [   
                        'closing_balance'=>aitsun_round($iip_closing_balance,2), 
                    ];
                    $AccountingModel->update($iip_geac['id'],$iip_ac_data);
                }
            	// Ledger Account Name
            }else{ 
            	// Ledger Account Name
                $iip_geac=$AccountingModel->where('id',$pmt['account_name'])->first(); 
                $iip_old_closing_balance=balance(company($myid),$pmt['account_name'],'closing_balance');  
                $iip_closing_balance=$iip_old_closing_balance-$pmt['amount']; 

                  echo $iip_old_closing_balance.'   #####  '.$pmt['amount'];

                if ($iip_geac) {
            	    $iip_ac_data = [   
                        'closing_balance'=>aitsun_round($iip_closing_balance,2), 
                    ];
                    $AccountingModel->update($iip_geac['id'],$iip_ac_data);
                }
            	// Ledger Account Name
            }  
        	//Ledger For cash and bank 
            $icb_geac=$AccountingModel->where('id',$pmt['type'])->first(); 
            $icb_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
            $icb_closing_balance=$icb_old_closing_balance+$pmt['amount']; 
            if ($icb_geac) {
        	    $icb_ac_data = [   
                    'closing_balance'=>aitsun_round($icb_closing_balance,2), 
                ];
                $AccountingModel->update($icb_geac['id'],$icb_ac_data);
            } 
        	//Ledger For cash and bank

         	$PaymentsModel->update($pmt['id'],array('effected'=>1)); 

            if ($pmt['deleted']==1) { 
                if ($pmt['bill_type']=='sales') { 
                	// Ledger Account Name
                    $iipd_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first(); 
                    $iipd_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance');  
                    $iipd_closing_balance=$iipd_old_closing_balance+$pmt['old_total']; 

                    if ($iipd_geac) {
                	    $iipd_ac_data = [   
                            'closing_balance'=>aitsun_round($iipd_closing_balance,2), 
                        ];
                        $AccountingModel->update($iipd_geac['id'],$iipd_ac_data);  
                    }
                	// Ledger Account Name 
                }else{ 
                 	// Ledger Account Name
                    $iipd_geac=$AccountingModel->where('id',$pmt['account_name'])->first();   
                    $iipd_old_closing_balance=balance(company($myid),$pmt['account_name'],'closing_balance');  
                    $iipd_closing_balance=$iipd_old_closing_balance+$pmt['old_total']; 
                    if ($iipd_geac) {
                	    $iipd_ac_data = [   
                            'closing_balance'=>aitsun_round($iipd_closing_balance,2), 
                        ];
                        $AccountingModel->update($iipd_geac['id'],$iipd_ac_data);
                    }
                    // Ledger Account Name
                } 

                //Ledger For cash and bank 
                $icbd_geac=$AccountingModel->where('id',$pmt['type'])->first(); 
                $icbd_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
                $icbd_closing_balance=$icbd_old_closing_balance-$pmt['old_total'];  
                if ($icbd_geac) {
            	    $icbd_ac_data = [   
                        'closing_balance'=>aitsun_round($icbd_closing_balance,2), 
                    ];
                    $AccountingModel->update($icbd_geac['id'],$icbd_ac_data);
                } 
            	//Ledger For cash and bank

             	$PaymentsModel->update($pmt['id'],array('effected'=>1,'edit_effected'=>1)); 
            } 
		}else{ 
			// Ledger Account Name
            $ipay_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first();
            $ipay_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance');  
            $ipay_closing_balance=$ipay_old_closing_balance+$pmt['amount']; 

              // echo $ipay_old_closing_balance.'   #####  '.$pmt['amount'];

            if ($ipay_geac) {
        	    $ipay_ac_data = [   
                    'closing_balance'=>aitsun_round($ipay_closing_balance,2), 
                ];
                $AccountingModel->update($ipay_geac['id'],$ipay_ac_data);
            }
        	// Ledger Account Name 

            //Ledger For cash and bank 
            $ipaycb_geac=$AccountingModel->where('id',$pmt['type'])->first(); 
            $ipaycb_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance');  
            $ipaycb_closing_balance=$ipaycb_old_closing_balance-$pmt['amount']; 
            if ($ipaycb_geac) {
        	    $ipaycb_ac_data = [   
                    'closing_balance'=>aitsun_round($ipaycb_closing_balance,2), 
                ];
                $AccountingModel->update($ipaycb_geac['id'],$ipaycb_ac_data);
            } 
        	//Ledger For cash and bank 

        	$PaymentsModel->update($pmt['id'],array('effected'=>1,'edit_effected'=>1));

        	if ($pmt['deleted']==1) { 
             	// Ledger Account Name
                $ipayd_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first(); 
                $ipayd_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance');  
                $ipayd_closing_balance=$ipayd_old_closing_balance-$pmt['old_total']; 
                if ($ipayd_geac) {
            	    $ipayd_ac_data = [   
                        'closing_balance'=>aitsun_round($ipayd_closing_balance,2), 
                    ];
               		$AccountingModel->update($ipayd_geac['id'],$ipayd_ac_data);
                }
                // Ledger Account Name 

            	//Ledger For cash and bank 
                $ipaycbd_geac=$AccountingModel->where('id',$pmt['type'])->first();
                $ipaycbd_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance');
                $ipaycbd_closing_balance=$ipaycbd_old_closing_balance+$pmt['old_total'];

                if ($ipaycbd_geac) {
            	    $ipaycbd_ac_data = [   
                        'closing_balance'=>aitsun_round($ipaycbd_closing_balance,2), 
                    ];
                    $AccountingModel->update($ipaycbd_geac['id'],$ipaycbd_ac_data);
                }
            	//Ledger For cash and bank

             	$PaymentsModel->update($pmt['id'],array('effected'=>1,'edit_effected'=>1)); 
            }
		} 
	}else{ 
    	if ($pmt['edit_effected']==0) { 

			if ($pmt['deleted']==1) { 
				if ($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales') {
	             	if ($pmt['bill_type']=='sales') { 
	                	// Ledger Account Name
	                    $ipayud_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first();
	                    $ipayud_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance'); 
	                    $ipayud_closing_balance=$ipayud_old_closing_balance+$pmt['amount'];

	                    if ($ipayud_geac) {
	                	    $ipayud_ac_data = [   
	                            'closing_balance'=>aitsun_round($ipayud_closing_balance,2), 
	                        ];
	                        $AccountingModel->update($ipayud_geac['id'],$ipayud_ac_data);
	                    }
	                	// Ledger Account Name
	                }else{ 

	                 	// Ledger Account Name
	                    $ipayud_geac=$AccountingModel->where('id',$pmt['account_name'])->first();  
	                    $ipayud_old_closing_balance=balance(company($myid),$pmt['account_name'],'closing_balance'); 
	                    $ipayud_closing_balance=$ipayud_old_closing_balance+$pmt['amount'];

	                        if ($ipayud_geac) {
	                    	    $ipayud_ac_data = [   
		                            'closing_balance'=>aitsun_round($ipayud_closing_balance,2), 
		                        ];
		                    	$AccountingModel->update($ipayud_geac['id'],$ipayud_ac_data);
	                        }
	                    // Ledger Account Name
	                } 

	                //Ledger For cash and bank
	                $ipayucbd_geac=$AccountingModel->where('id',$pmt['type'])->first();
	                $ipayucbd_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
	                $ipayucbd_closing_balance=$ipayucbd_old_closing_balance-$pmt['amount'];

	                if ($ipayucbd_geac) {
	            	    $ipayucbd_ac_data = [   
	                        'closing_balance'=>aitsun_round($ipayucbd_closing_balance,2), 
	                    ];
	                    $AccountingModel->update($ipayucbd_geac['id'],$ipayucbd_ac_data);
	                }
	                //Ledger For cash and bank
	        }else{

	        	// Ledger Account Name
                $ipayud_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first();  
                $ipayud_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance'); 
                $ipayud_closing_balance=$ipayud_old_closing_balance-$pmt['amount'];

                    if ($ipayud_geac) {
                	    $ipayud_ac_data = [   
                            'closing_balance'=>aitsun_round($ipayud_closing_balance,2), 
                        ];
                    	$AccountingModel->update($ipayud_geac['id'],$ipayud_ac_data);
                    }
                // Ledger Account Name

                     //Ledger For cash and bank
	                $ipayucbd_geac=$AccountingModel->where('id',$pmt['type'])->first();
	                $ipayucbd_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
	                $ipayucbd_closing_balance=$ipayucbd_old_closing_balance+$pmt['amount'];

	                if ($ipayucbd_geac) {
	            	    $ipayucbd_ac_data = [   
	                        'closing_balance'=>aitsun_round($ipayucbd_closing_balance,2), 
	                    ];
	                    $AccountingModel->update($ipayucbd_geac['id'],$ipayucbd_ac_data);
	                }
	                //Ledger For cash and bank

            }

             	$PaymentsModel->update($pmt['id'],array('effected'=>1,'edit_effected'=>1)); 
        	}else{ 
                if ($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales') {
	    			if ($pmt['bill_type']=='sales') {
                    	// Ledger Account Name
                        $ipu_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first();
                        $ipu_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance'); 
                        $ipu_closing_balance=($ipu_old_closing_balance+$pmt['old_total'])-$pmt['amount'];

                        if ($ipu_geac) {
                    	    $ipu_ac_data = [   
	                            'closing_balance'=>aitsun_round($ipu_closing_balance,2), 
	                        ];
	                        $AccountingModel->update($ipu_geac['id'],$ipu_ac_data);
                        }
                    	// Ledger Account Name
                	}else{
            	    	// Ledger Account Name
                        $ipu_geac=$AccountingModel->where('id',$pmt['account_name'])->first();
                        $ipu_old_closing_balance=balance(company($myid),$pmt['account_name'],'closing_balance'); 
                        $ipu_closing_balance=($ipu_old_closing_balance+$pmt['old_total'])-$pmt['amount'];

                        if ($ipu_geac) {
                    	    $ipu_ac_data = [   
	                            'closing_balance'=>aitsun_round($ipu_closing_balance,2), 
	                        ];
	                        $AccountingModel->update($ipu_geac['id'],$ipu_ac_data);
                        }
                        // Ledger Account Name
                	}
                    //Ledger For cash and bank
                    $icbu_geac=$AccountingModel->where('id',$pmt['type'])->first();
                    $icbu_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
                    $icbu_closing_balance=($icbu_old_closing_balance-$pmt['old_total'])+$pmt['amount'];

                    if ($icbu_geac) {
                	    $icbu_ac_data = [   
                            'closing_balance'=>aitsun_round($icbu_closing_balance,2), 
                        ];
                        $AccountingModel->update($icbu_geac['id'],$icbu_ac_data);
                    }
                    //Ledger For cash and bank

                    $PaymentsModel->update($pmt['id'],array('edit_effected'=>1));

                    if ($pmt['deleted']==1) {
                 	 	if ($pmt['bill_type']=='sales') {
                        	// Ledger Account Name
                            $ipud_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first();
                            $ipud_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance'); 
                            $ipud_closing_balance=$ipud_old_closing_balance+$pmt['old_total'];
                            if ($ipud_geac) {
                        	    $ipud_ac_data = [   
		                            'closing_balance'=>aitsun_round($ipud_closing_balance,2), 
		                        ];
		                        $AccountingModel->update($ipud_geac['id'],$ipud_ac_data);
                            }
                        	// Ledger Account Name  
	                    }else{ 
                         	// Ledger Account Name
	                        $ipud_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$pmt['customer']))->first(); 
	                        $ipud_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$pmt['customer']),'closing_balance'); 
	                        $ipud_closing_balance=$ipud_old_closing_balance+$pmt['old_total'];
                            if ($ipud_geac) {
                        	    $ipud_ac_data = [   
		                            'closing_balance'=>aitsun_round($ipud_closing_balance,2), 
		                        ];
		                        $AccountingModel->update($ipud_geac['id'],$ipud_ac_data);
                            }
	                        // Ledger Account Name
	                    } 

                    	//Ledger For cash and bank
                        $iucbd_geac=$AccountingModel->where('id',$pmt['type'])->first();
                        $iucbd_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
                        $iucbd_closing_balance=$iucbd_old_closing_balance-$pmt['old_total'];

                        if ($iucbd_geac) {
                    	    $iucbd_ac_data = [   
	                            'closing_balance'=>aitsun_round($iucbd_closing_balance,2), 
	                        ];
	                        $AccountingModel->update($iucbd_geac['id'],$iucbd_ac_data);
                        }
                    	//Ledger For cash and bank

                     	$PaymentsModel->update($pmt['id'],array('effected'=>1,'edit_effected'=>1));
                    }
	    
	    		}else{	 
        	    	// Ledger Account Name
                    $ipayu_geac=$AccountingModel->where('id',$pmt['account_name'])->first();
                    $ipayu_old_closing_balance=balance(company($myid),$pmt['account_name'],'closing_balance'); 
                    $ipayu_closing_balance=($ipayu_old_closing_balance-$pmt['old_total'])+$pmt['amount'];

                    if ($ipayu_geac) {
                	    $ipayu_ac_data = [   
                            'closing_balance'=>aitsun_round($ipayu_closing_balance,2), 
                        ];
                        $AccountingModel->update($ipayu_geac['id'],$ipayu_ac_data);
                    }
                    // Ledger Account Name

                    //Ledger For cash and bank
                    $ipaycbu_geac=$AccountingModel->where('id',$pmt['type'])->first();
                    $ipaycbu_old_closing_balance=balance(company($myid),$pmt['type'],'closing_balance'); 
                    $ipaycbu_closing_balance=($ipaycbu_old_closing_balance+$pmt['old_total'])-$pmt['amount'];

                    if ($ipaycbu_geac) {
                	    $ipaycbu_ac_data = [   
                            'closing_balance'=>aitsun_round($ipaycbu_closing_balance,2), 
                        ];
                        $AccountingModel->update($ipaycbu_geac['id'],$ipaycbu_ac_data);
                    }
                    //Ledger For cash and bank

                    $PaymentsModel->update($pmt['id'],array('edit_effected'=>1));
				}
            } 
	    }
	}

}

/////////////////////////////  PAYMENTS TABLE /////////////////////////












/////////////////////////////  PAYSlIP /////////////////////////

$all_payslip=$PayrollitemsModel->where('company_id',company($myid))->where('created_by',$myid)->where('user_token',$mytoken)->groupStart()->where('effected',0)->orWhere('edit_effected',0)->groupEnd()->findAll();

	foreach ($all_payslip as $ps) {
		if ($ps['effected']==0) { 
			
				// Ledger Account Name
	            $ipay_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$ps['employee_id']))->first();
	            $ipay_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$ps['employee_id']),'closing_balance');  
	            $ipay_closing_balance=$ipay_old_closing_balance+$ps['net_salary']; 

	            if ($ipay_geac) {
	        	    $ipay_ac_data = [   
	                    'closing_balance'=>$ipay_closing_balance, 
	                ];
	                $AccountingModel->update($ipay_geac['id'],$ipay_ac_data);
	            }
	        	// Ledger Account Name 

	            //Ledger For cash and bank 
	            $ipaycb_geac=$AccountingModel->where('id',$ps['type'])->first(); 
	            $ipaycb_old_closing_balance=balance(company($myid),$ps['type'],'closing_balance');  
	            $ipaycb_closing_balance=$ipaycb_old_closing_balance-$ps['net_salary']; 
	            if ($ipaycb_geac) {
	        	    $ipaycb_ac_data = [   
	                    'closing_balance'=>$ipaycb_closing_balance, 
	                ];
	                $AccountingModel->update($ipaycb_geac['id'],$ipaycb_ac_data);
	            } 
	        	//Ledger For cash and bank 

	        	$PayrollitemsModel->update($ps['id'],array('effected'=>1,'edit_effected'=>1));

	        	if ($ps['deleted']==1) { 
	             	// Ledger Account Name
	                $ipayd_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$ps['employee_id']))->first(); 
	                $ipayd_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$ps['employee_id']),'closing_balance');  
	                $ipayd_closing_balance=$ipayd_old_closing_balance-$ps['old_total']; 
	                if ($ipayd_geac) {
	            	    $ipayd_ac_data = [   
	                        'closing_balance'=>$ipayd_closing_balance, 
	                    ];
	               		$AccountingModel->update($ipayd_geac['id'],$ipayd_ac_data);
	                }
	                // Ledger Account Name 

	            	//Ledger For cash and bank 
	                $ipaycbd_geac=$AccountingModel->where('id',$ps['type'])->first();
	                $ipaycbd_old_closing_balance=balance(company($myid),$ps['type'],'closing_balance');
	                $ipaycbd_closing_balance=$ipaycbd_old_closing_balance+$ps['old_total'];

	                if ($ipaycbd_geac) {
	            	    $ipaycbd_ac_data = [   
	                        'closing_balance'=>$ipaycbd_closing_balance, 
	                    ];
	                    $AccountingModel->update($ipaycbd_geac['id'],$ipaycbd_ac_data);
	                }
	            	//Ledger For cash and bank

	             	$PayrollitemsModel->update($ps['id'],array('effected'=>1,'edit_effected'=>1)); 

	            }
			
		}else{ 
	    	if ($ps['edit_effected']==0) { 

				if ($ps['deleted']==1) { 
					
		        	// Ledger Account Name
	                $ipayud_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$ps['employee_id']))->first();  
	                $ipayud_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$ps['employee_id']),'closing_balance'); 
	                $ipayud_closing_balance=$ipayud_old_closing_balance-$ps['net_salary'];

	                    if ($ipayud_geac) {
	                	    $ipayud_ac_data = [   
	                            'closing_balance'=>$ipayud_closing_balance, 
	                        ];
	                    	$AccountingModel->update($ipayud_geac['id'],$ipayud_ac_data);
	                    }
	                // Ledger Account Name

	                     //Ledger For cash and bank
		                $ipayucbd_geac=$AccountingModel->where('id',$ps['type'])->first();
		                $ipayucbd_old_closing_balance=balance(company($myid),$ps['type'],'closing_balance'); 
		                $ipayucbd_closing_balance=$ipayucbd_old_closing_balance+$ps['net_salary'];

		                if ($ipayucbd_geac) {
		            	    $ipayucbd_ac_data = [   
		                        'closing_balance'=>$ipayucbd_closing_balance, 
		                    ];
		                    $AccountingModel->update($ipayucbd_geac['id'],$ipayucbd_ac_data);
		                }
		                //Ledger For cash and bank

	            

	             	$PayrollitemsModel->update($ps['id'],array('effected'=>1,'edit_effected'=>1)); 
	             	 
	        	}else{ 
	                // Ledger Account Name
	                    $ipayu_geac=$AccountingModel->where('id',ledger_id_of_user(company($myid),$ps['employee_id']))->first();
	                    $ipayu_old_closing_balance=balance(company($myid),ledger_id_of_user(company($myid),$ps['employee_id']),'closing_balance'); 
	                    $ipayu_closing_balance=($ipayu_old_closing_balance-$ps['old_total'])+$ps['net_salary'];

	                    if ($ipayu_geac) {
	                	    $ipayu_ac_data = [   
	                            'closing_balance'=>$ipayu_closing_balance, 
	                        ];
	                        $AccountingModel->update($ipayu_geac['id'],$ipayu_ac_data);
	                    }
	                    // Ledger Account Name

	                    //Ledger For cash and bank
	                    $ipaycbu_geac=$AccountingModel->where('id',$ps['type'])->first();
	                    $ipaycbu_old_closing_balance=balance(company($myid),$ps['type'],'closing_balance'); 
	                    $ipaycbu_closing_balance=($ipaycbu_old_closing_balance+$ps['old_total'])-$ps['net_salary'];

	                    if ($ipaycbu_geac) {
	                	    $ipaycbu_ac_data = [   
	                            'closing_balance'=>$ipaycbu_closing_balance, 
	                        ];
	                        $AccountingModel->update($ipaycbu_geac['id'],$ipaycbu_ac_data);
	                    }
	                    //Ledger For cash and bank

	                    $PayrollitemsModel->update($ps['id'],array('edit_effected'=>1));
	                    
	            } 
		    }
		}
	}

	// if ($user['is_logout']==1) {
    //     return redirect()->to(base_url('users/logout'));
    // }

/////////////////////////////  PAYSlIP /////////////////////////
        }else{
                return redirect()->to(base_url('users/login'));
        }
    }
}