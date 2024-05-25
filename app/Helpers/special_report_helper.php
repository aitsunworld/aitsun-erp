<?php 
	use App\Models\Main_item_party_table as Main_item_party_table; 
	use App\Models\PaymentsModel as PaymentsModel;
	use App\Models\InvoiceitemsModel as InvoiceitemsModel; 
	use App\Models\InvoiceModel as InvoiceModel;


	function company_balance($user_id,$type){
		$Main_item_party_table=new Main_item_party_table;

		$Main_item_party_table->select('sum(closing_balance) as total')->where('company_id',company($user_id))->where('main_type','user')->where('deleted',0);
		if ($type=='receive') {
			$Main_item_party_table->where('closing_balance>=',0);
		}else{
			$Main_item_party_table->where('closing_balance<',0);
		}
		$ball=$Main_item_party_table->first();
		if (!empty($ball['total'])) {
			return $ball['total'];
		}else{
			return 0;
		}
	}

	function company_stock_value($user_id,$type){
		$Main_item_party_table=new Main_item_party_table;

		if ($type=='average') {
			$Main_item_party_table->select('sum(final_closing_value) as total');
		}else{
			$Main_item_party_table->select('sum(final_closing_value_fifo) as total');
		}

		$Main_item_party_table->where('company_id',company($user_id))->where('main_type','product')->where('product_method','product')->where('deleted',0);
		
		$ball=$Main_item_party_table->first();
		if (!empty($ball['total'])) {
			return $ball['total'];
		}else{
			return 0;
		}
		
	}
	

	function get_inventories_summary($myid,$invoice_type,$result_type,$value_column,$from,$to,$customer){
		$InvoiceModel=new InvoiceModel;

		$InvoiceModel->where('company_id',company($myid))->where('deleted',0);

		
		if ($result_type=='value') {
			$InvoiceModel->select('sum('.$value_column.') as total_value');
		}

		//Invoice type
		if ($invoice_type!='') {
			$InvoiceModel->where('invoice_type',$invoice_type);
		}

		if ($customer!='') {
			$InvoiceModel->where('customer',$customer);
		}


		//date manipulation
		if ($from=='' && $to=='') {
			$InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
		}else{
			if (!empty($from) && empty($to)) {
                $InvoiceModel->where('invoice_date',$from);
            }
            if (!empty($to) && empty($from)) {
                $InvoiceModel->where('invoice_date',$to);
            }

            if (!empty($to) && !empty($from)) {
                $InvoiceModel->where("invoice_date BETWEEN '$from' AND '$to'");
            }
		}

		//result_type
		if ($result_type=='value') {
			$pre_res=$InvoiceModel->first();
			if ($pre_res) {
				$result=$pre_res['total_value'];
			}else{
				$result=0;
			}
			return aitsun_round($result,get_setting(company($myid),'round_of_value'));
		}elseif($result_type=='quantity'){
			$result=$InvoiceModel->countAllResults();
			return aitsun_round($result,get_setting(company($myid),'round_of_value'));
		}else{
			$result=$InvoiceModel->findAll();
			return $result;
		}

		
 

	}




	function get_payments_summary($myid,$invoice_type,$result_type,$value_column,$from,$to,$customer){
		$PaymentsModel=new PaymentsModel;

		$PaymentsModel->where('company_id',company($myid))->where('deleted',0);

		
		if ($result_type=='value') {
			$PaymentsModel->select('sum('.$value_column.') as total_value');
		}

		//Invoice type
		if ($invoice_type!='') {
			$PaymentsModel->where('bill_type',$invoice_type);
		}

		if ($customer!='') {
			$PaymentsModel->where('customer',$customer);
		}



		//date manipulation
		if ($from=='' && $to=='') {
			$PaymentsModel->where('datetime',get_date_format(now_time($myid),'Y-m-d'));
		}else{
			if (!empty($from) && empty($to)) {
                $PaymentsModel->where('datetime',$from);
            }
            if (!empty($to) && empty($from)) {
                $PaymentsModel->where('datetime',$to);
            }

            if (!empty($to) && !empty($from)) {
                $PaymentsModel->where("datetime BETWEEN '$from' AND '$to'");
            }
		}

		//result_type
		if ($result_type=='value') {
			$pre_res=$PaymentsModel->first();
			if ($pre_res) {
				$result=$pre_res['total_value'];
			}else{
				$result=0;
			}
			
		}elseif($result_type=='quantity'){
			$result=$PaymentsModel->countAllResults();
		}else{
			$result=$PaymentsModel->findAll();
		}

		return aitsun_round($result,get_setting(company($myid),'round_of_value'));
 

	}

	function other_income_expenses($myid,$from,$to,$customer){
		$PaymentsModel=new PaymentsModel;

		$PaymentsModel->where('company_id',company($myid))->where('deleted',0);

		
	
		//Invoice type
		$PaymentsModel->where('invoice_id',0);
		

		if ($customer!='') {
			$PaymentsModel->where('customer',$customer);
		}



		//date manipulation
		if ($from=='' && $to=='') {
			$PaymentsModel->where('datetime',get_date_format(now_time($myid),'Y-m-d'));
		}else{
			if (!empty($from) && empty($to)) {
                $PaymentsModel->where('datetime',$from);
            }
            if (!empty($to) && empty($from)) {
                $PaymentsModel->where('datetime',$to);
            }

            if (!empty($to) && !empty($from)) {
                $PaymentsModel->where("datetime BETWEEN '$from' AND '$to'");
            }
		}

		 $result=$PaymentsModel->findAll();

		return $result;
 

	}
	
	function total_products_of_company($company_id){
		$ProductsModel=new Main_item_party_table;
		$tp=0;
		$tp=$ProductsModel->where('company_id',$company_id)->where('main_type','product')->where('deleted',0)->countAllResults();
		return $tp;
	}


	function get_chart_data($myid,$result_type,$from,$to,$customer){
		$PaymentsModel=new PaymentsModel;
		$datetimes='';
        $sales_incomes='';
        $purchase_expenses='';
        $fresult='';

        //datetimes
		if ($from=='' && $to=='') {
			$datetimes=calculate_date(get_date_format(now_time($myid),'Y-m-d'),'-2').','.calculate_date(get_date_format(now_time($myid),'Y-m-d'),'-1').','.get_date_format(now_time($myid),'Y-m-d');
		}else{
			if (!empty($from) && empty($to)) {
                $datetimes=calculate_date($from,'-2').','.calculate_date($from,'-1').','.$from;
            }
            if (!empty($to) && empty($from)) {
                $datetimes=calculate_date($to,'-2').','.calculate_date($to,'-1').','.$to;
            }

            if (!empty($to) && !empty($from)) {
                $datesInRange = getDatesInRange($from, $to);
                $dc=1;
                foreach ($datesInRange as $dda) {
                	$dc++;
                	$com='';
                	if ($dc>2) {
                		$com=',';
                	} 
                	$datetimes.=$com.$dda;
                }
            }
		}

		$dts=explode(',', $datetimes);

		$ic=0;
		foreach ($dts as $dateee) {
				$ic++;

				$PaymentsModel->where('company_id',company($myid))->where('deleted',0);

				
				if ($customer!='') {
					$PaymentsModel->where('customer',$customer);
				}
		
			
				$PaymentsModel->select('sum(amount) as total_value');
				

				//Invoice type
				if ($result_type=='sales_incomes') {
					$PaymentsModel->groupStart();
					$PaymentsModel->where('bill_type','receipt');
					$PaymentsModel->orWhere('bill_type','sales');
					$PaymentsModel->groupEnd();
				}elseif ($result_type=='purchase_expenses') {
					$PaymentsModel->groupStart();
					$PaymentsModel->where('bill_type','expense');
					$PaymentsModel->orWhere('bill_type','purchase');
					$PaymentsModel->groupEnd();
				}else{
					$PaymentsModel->where('bill_type','expense');
				} 


				$PaymentsModel->where('datetime',$dateee);

				$pre_res=$PaymentsModel->first();
				if ($pre_res) {
					$result=aitsun_round($pre_res['total_value'],get_setting(company($myid),'round_of_value'));
				}else{
					$result=0;
				}
 				 
            	$comc='';
            	if ($ic>1) {
            		$comc=',';
            	} 
            	$fresult.=$comc.$result;

		} 

		if ($result_type=='sales_incomes') {
			return $fresult;
		}elseif ($result_type=='purchase_expenses') {
			return $fresult;
		}else{
			return $datetimes;
		} 
		
	}

	function getDatesInRange($startDate, $endDate) {
	    $datesArray = array();

	    $currentDate = new DateTime($startDate);
	    $endDate = new DateTime($endDate);

	    while ($currentDate <= $endDate) {
	        $datesArray[] = $currentDate->format('Y-m-d');
	        $currentDate->modify('+1 day');
	    }

	    return $datesArray;
	}

    function get_total_parties_data($myid,$party_type,$result_type)
	{
		$UserModel=new Main_item_party_table;
		$res=$UserModel->where('company_id',company($myid))->where('u_type',$party_type)->where('main_type','user')->where('deleted',0)->countAllResults();
		return $res;
		if(
			yrehreepoty
		);
	}

 ?>