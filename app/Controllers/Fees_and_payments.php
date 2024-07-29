<?php namespace App\Controllers; 
use App\Models\OrganisationModel;
use App\Models\ProductsModel;
use App\Models\StudentcategoryModel;	
use App\Models\PricetableModel;
use App\Models\FeesModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceitemsModel;
use App\Models\PaymentsModel;
use App\Models\FeesitemsModal;
use App\Models\Classtablemodel; 
use App\Models\InstallmentsModel; 
use App\Models\AccountingModel; 
use App\Models\ClassModel; 
use App\Models\CompanySettings2; 
use App\Models\Main_item_party_table;
 


class Fees_and_payments extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $FeesModel= new FeesModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	 
	    		 if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
	    		

	    	



	    		 

	    		$pager = \Config\Services::pager();

	    		if ($_GET) {

		    		if (isset($_GET['fee_name'])) {
				        $FeesModel->like('fees_name',$_GET['fee_name'],'both');
				     }
				     
				     if (isset($_GET['added_by'])) {
				     	if (!empty($_GET['added_by'])) {
				        	$FeesModel->where('added_by',$_GET['added_by']);
				        }
				    }

				    if (isset($_GET['class'])) {
				     	if (!empty($_GET['class'])) {
				        	$FeesModel->where('class',$_GET['class']);
				        }
				    }
				}
	    		

	    		$fees_type=$FeesModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(12);


	    		
	    		
	    		$data=[
	    			'title'=>'Fees And Payments | Aitsun ERP',
	    			'user'=>$usaerdata,
	    			'pager' => $FeesModel->pager,
	    			'fees_type'=>$fees_type

	    		];

	    		 

		    		echo view('header',$data); 
		    		echo view('fees/fees_and_payments');
		    		echo view('footer');
		 

	    	 
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	public function details($fees_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first(); 

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    	

		    		

		    		$InvoiceModel->where('company_id',company($myid))->where('invoice_type','challan')->where('deleted',0);

		    		if ($_GET) {
		    			if (isset($_GET['status'])) {
		    				if ($_GET['status']=='paid') {
		    					$InvoiceModel->where('paid_status','paid');
		    				}elseif ($_GET['status']=='unpaid') {
		    					$InvoiceModel->where('paid_amount',0); 
		    				}else{
		    					$InvoiceModel->where('paid_amount>',0); 
		    					$InvoiceModel->where('due_amount>',0); 
		    				}
		    			}
		    		}

		    		$all_invoices=$InvoiceModel->where('fees_id',$fees_id)->orderBy('id','DESC')->findAll();

		    		$fees_type=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();



		    		if ($fees_type) {
		    			$data=[
			    			'title'=>'Fees And Payments | Aitsun ERP',
			    			'user'=>$usaerdata,
			    			'ft'=>$fees_type,
			    			'invoices'=>$all_invoices, 
			    		];

			    		$etype='';
		                if ($_GET) {
		                  if (isset($_GET['etype'])) {
		                      if (!empty($_GET['etype'])) {
		                          $etype=$_GET['etype'];
		                      }
		                  }
		                }
		                if ($etype=='ajaxex') {
		                  echo view('fees/details',$data);
		                }else{
				    		echo view('header',$data);
				    		
				    		echo view('fees/details');
				    		echo view('footer');
				    	}
		    		}else{
			    		return redirect()->to(base_url());
			    	}

 
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}	
		}else{
    		return redirect()->to(base_url());
    	}
			
	}

	public function installments(){
		$session=session();
	    $user=new Main_item_party_table();
	    $FeesModel= new FeesModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	if (is_organisation($usaerdata['company_id'])) {
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
	    		

	    		 
	    		
	    		
	    		$data=[
	    			'title'=>'Coming soon | Aitsun ERP',
	    			'user'=>$usaerdata, 

	    		];
	    		$etype='';
                if ($_GET) {
                  if (isset($_GET['etype'])) {
                      if (!empty($_GET['etype'])) {
                          $etype=$_GET['etype'];
                      }
                  }
                }
                if ($etype=='ajaxex') {
                  echo view('comming_soon',$data);
                }else{
		    		echo view('header',$data); 
		    		echo view('comming_soon');
		    		echo view('footer');
	    		}


	    	}else{
	    		return redirect()->to(base_url());
	    	}
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}
	}



public function generate_invoices_for_transport($fees_id='',$student_id='',$location_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();
		    $AccountingModel= new Main_item_party_table();
		    $Classtablemodel= new Classtablemodel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first(); 

	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		

	    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();

 					if ($this->request->getMethod() == 'post') {

		    		if ($ft) {

		    			$student_array=$Classtablemodel->where('company_id', company($myid))->where('academic_year', academic_year($myid))->where('class_id', current_class_of_student(company($myid),$student_id))->where('deleted', 0)->where('student_id',$student_id)->orderby('first_name','ASC')->where('transfer','')->findAll();


		    			foreach ($student_array as $student) { 
		    				$subtotal=0;
		    				$total=0;

		    				$subtotal=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$location_id);
			    			$total=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$location_id);


			    			// generate_invoice_here
		    				$invoice_data=[
		    					'company_id'=>company($myid),
		    					'customer'=>$student['student_id'],
		    					'alternate_name'=>user_name($student['student_id']),
		    					'invoice_date'=>now_time($myid),
		    					'class_id'=>current_class_of_student(company($myid),$student['student_id']),
		    					'notes'=>'',
		    					'private_notes'=>'',
		    					'tax'=>'',
		    					'created_at'=>now_time($myid),
		    					'discount'=>0,
		    					'sub_total'=>$subtotal,
		    					'total'=>$total,
		    					'main_total'=>$total,
		    					'status'=>'sent',
		    					'paid_status'=>'unpaid',
		    					'paid_amount'=>0,
		    					'due_amount'=>$total,
		    					'invoice_type'=>'challan',
		    					'converted'=>1,
		    					'serial_no'=>serial_no(company($myid),'challan'),
		    					'phone'=>user_phone($student['student_id']),
		    					'fees_id'=>$fees_id,
		    					'billed_by'=>$myid,
		    					'fees_type'=>get_fees_data(company($myid),$fees_id,'fees_type'),
		    					'due_date'=>$ft['due_date']
		    				];


		    				
		    				 
		    				$check_in_exist=$InvoiceModel->where('fees_id',$fees_id)->where('customer',$student['student_id'])->where('deleted',0)->first();

		    				$vehicle_id=0;
								$driver_id=0;

		    				if ($check_in_exist) {
		    					$ins_id=0;
		    				}else{

		    					$saveinvoice=$InvoiceModel->save($invoice_data);
			    				$ins_id=$InvoiceModel->insertID();

			    				// ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			            //CUSTOMER
			            $bal_customer=$student['student_id'];

			            $current_closing_balance=user_data($bal_customer,'closing_balance');
			            $new_closing_balance=$current_closing_balance;
 
			                $new_closing_balance=$new_closing_balance+aitsun_round($total,get_setting(company($myid),'round_of_value'));
			             


			            $bal_customer_data=[ 
			                'closing_balance'=>$new_closing_balance,
			            ];
			            $user->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????


			    				if ($saveinvoice) {
			    					$in_item=[
                      'invoice_id'=>$ins_id,
                      'product'=>get_products_data($location_id,'product_name'),
                      'product_id'=>$location_id,
                      'quantity'=> 1,
                      'price'=>fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$location_id),
                      'discount'=>0,
                      'amount'=>fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$location_id),
                      'desc'=>get_products_data($location_id,'description'),
                      'type'=>'single',
                      'tax'=>0
                  	]; 
                  	$vehicle_id=get_products_data($location_id,'vehicle');
                    $InvoiceitemsModel->save($in_item);
			    				}

			    				
					        $vd_data=[
					        	'vehicle_id'=>$vehicle_id,
										'driver_id'=>get_vehicle_data($vehicle_id,'driver')
									];

									$InvoiceModel->update($ins_id,$vd_data);
		    					
								}
		    				
		    			}


							

							$ins_id=1;

		    			if (empty($student_id)) {
		    				echo 1;
		    			}else{
		    				echo $ins_id;
		    			}

						}else{
			    		echo 0;
			    	}

					}
		    	
		    }else{
		   		echo 3;
		   	}	
		}else{
    		echo 4;
    	}
			
	}





	public function generate_for_all_transport($fees_id='',$student_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();
		    $AccountingModel= new Main_item_party_table();
		    $Classtablemodel= new Classtablemodel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();
		    
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();

		    		if ($this->request->getMethod() == 'post') {

		    		if ($ft) {

		    			 $student_array=vehicle_students_array(company($myid));
		    			  
		    			
		    			foreach ($student_array as $student) {
		    				// echo $student['first_name'];echo "<br>";
		    				$subtotal=0;
		    				$total=0;

	    					$subtotal+=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$student['item_id']);
			    			$total+=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$student['item_id']); 
		    				

		    				// generate_invoice_here
		    				$invoice_data=[
		    					'company_id'=>company($myid),
		    					'customer'=>$student['student_id'],
		    					'alternate_name'=>user_name($student['student_id']),
		    					'invoice_date'=>now_time($myid),
		    					'class_id'=>current_class_of_student(company($myid),$student['student_id']),
		    					'notes'=>'',
		    					'private_notes'=>'',
		    					'tax'=>'',
		    					'created_at'=>now_time($myid),
		    					'discount'=>0,
		    					'sub_total'=>$subtotal,
		    					'total'=>$total,
		    					'main_total'=>$total,
		    					'status'=>'sent',
		    					'paid_status'=>'unpaid',
		    					'paid_amount'=>0,
		    					'due_amount'=>$total,
		    					'invoice_type'=>'challan',
		    					'converted'=>1,
		    					'serial_no'=>serial_no(company($myid),'challan'),
		    					'phone'=>user_phone($student['student_id']),
		    					'fees_id'=>$fees_id,
		    					'billed_by'=>$myid,
		    					'fees_type'=>get_fees_data(company($myid),$fees_id,'fees_type'),
		    					'due_date'=>$ft['due_date']
		    				];


		    				
		    				 
		    				$check_in_exist=$InvoiceModel->where('fees_id',$fees_id)->where('customer',$student['student_id'])->where('deleted',0)->first();

		    				if ($check_in_exist) {
		    					$ins_id=0;
		    				}else{
		    					

		    					$saveinvoice=$InvoiceModel->save($invoice_data);
			    				$ins_id=$InvoiceModel->insertID();

			    				if ($saveinvoice) {


			    					 // ??????????????????????????  customer and cash balance calculation start ????????????
				            // ??????????????????????????  customer and cash balance calculation start ????????????
				            //CUSTOMER
				            $bal_customer=$student['student_id'];

				            $current_closing_balance=user_data($bal_customer,'closing_balance');
				            $new_closing_balance=$current_closing_balance;
	 
				                $new_closing_balance=$new_closing_balance+aitsun_round($total,get_setting(company($myid),'round_of_value'));
				             


				            $bal_customer_data=[ 
				                'closing_balance'=>$new_closing_balance,
				            ];
				            $user->update($bal_customer,$bal_customer_data);
				            // ??????????????????????????  customer and cash balance calculation end ??????????????
				            // ??????????????????????????  customer and cash balance calculation end ??????????????

			    					
			    						$in_item=[
                            'invoice_id'=>$ins_id,
                            'product'=>get_products_data($student['item_id'],'product_name'),
                            'product_id'=>$student['item_id'],
                            'quantity'=> 1,
                            'price'=>fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$student['item_id']),
                            'discount'=>0,
                            'amount'=>fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$student['item_id']),
                            'desc'=>get_products_data($student['item_id'],'description'),
                            'type'=>'single',
                            'tax'=>0
                        ];

                          $InvoiceitemsModel->save($in_item); 

                          $vehicle_id=0;
													$driver_id=0;
													$vehicle_id=get_products_data($student['item_id'],'vehicle');
													$vd_data=[
									        	'vehicle_id'=>$vehicle_id,
														'driver_id'=>get_vehicle_data($vehicle_id,'driver')
													];

													$InvoiceModel->update($ins_id,$vd_data);

													// $vd_data=[
									        // 	'vehicle_id'=>$vehicle_id,
													// 	'driver_id'=>get_vehicle_data($vehicle_id,'driver')
													// ];

													// $InvoiceModel->update($ins_id,$vd_data);
			    					
			    				}
		    				
		    			}

		    				
		    			}

		    			if (empty($student_id)) {
		    				echo 1;
		    			}else{
		    				echo $ins_id;
		    			}
		    			
 

		    		}else{
			    		echo 0;
			    	}
			    }
		    	
		    	
		    }else{
		   		echo 3;
		   	}	
		}else{
    		echo 4;
    	}
			
	}


	public function generate_invoices($fees_id='',$student_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();
		    $AccountingModel= new Main_item_party_table();
		    $Classtablemodel= new Classtablemodel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();
		    	 
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();

		    		if ($this->request->getMethod() == 'post') {

		    		if ($ft) {

		    			if (empty($student_id)) {
		    				$student_array=students_array_of_class(company($myid),$ft['class']);
		    			}else{
		    				$student_array=$Classtablemodel->where('company_id', company($myid))->where('academic_year', academic_year($myid))->where('class_id', current_class_of_student(company($myid),$student_id))->where('deleted', 0)->where('student_id',$student_id)->orderby('first_name','ASC')->where('transfer','')->findAll();
		    			}
		    			
		    			foreach ($student_array as $student) {
		    				// echo $student['first_name'];echo "<br>";
		    				$subtotal=0;
		    				$total=0;

	    					foreach (fees_items_array($fees_id) as $it) { 

	    						

		    						$subtotal+=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']);
			    				    $total+=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']); 
		    				   

	    					}
		    				

		    				// generate_invoice_here
		    				$invoice_data=[
		    					'company_id'=>company($myid),
		    					'customer'=>$student['student_id'],
		    					'alternate_name'=>user_name($student['student_id']),
		    					'invoice_date'=>now_time($myid),
		    					'class_id'=>current_class_of_student(company($myid),$student['student_id']),
		    					'notes'=>'',
		    					'private_notes'=>'',
		    					'tax'=>'',
		    					'created_at'=>now_time($myid),
		    					'discount'=>0,
		    					'sub_total'=>aitsun_round($subtotal,get_setting(company($myid),'round_of_value') ),
		    					'total'=>aitsun_round($total,get_setting(company($myid),'round_of_value') ),
		    					'main_total'=>aitsun_round($total,get_setting(company($myid),'round_of_value') ),
		    					'status'=>'sent',
		    					'paid_status'=>'unpaid',
		    					'paid_amount'=>0,
		    					'due_amount'=>aitsun_round($total,get_setting(company($myid),'round_of_value') ),
		    					'invoice_type'=>'challan',
		    					'converted'=>1,
		    					'serial_no'=>serial_no(company($myid),'challan'),
		    					'phone'=>user_phone($student['student_id']),
		    					'fees_id'=>$fees_id,
		    					'billed_by'=>$myid,
		    					'fees_type'=>get_fees_data(company($myid),$fees_id,'fees_type'),
		    					'due_date'=>$ft['due_date']
		    				];


		    				
		    				 
		    				$check_in_exist=$InvoiceModel->where('fees_id',$fees_id)->where('customer',$student['student_id'])->where('deleted',0)->first();

		    				if ($check_in_exist) {
		    					$ins_id=0;
		    				}else{
		    					

		    					$saveinvoice=$InvoiceModel->save($invoice_data);
			    				$ins_id=$InvoiceModel->insertID();

			    				if ($saveinvoice) {



			    				// ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			            //CUSTOMER
			            $bal_customer=$student['student_id'];

			            $current_closing_balance=user_data($bal_customer,'closing_balance');
			            $new_closing_balance=$current_closing_balance;
 
			                $new_closing_balance=$new_closing_balance+aitsun_round($total,get_setting(company($myid),'round_of_value'));
			             


			            $bal_customer_data=[ 
			                'closing_balance'=>$new_closing_balance,
			            ];
			            $user->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????



			    					foreach (fees_items_array($fees_id) as $it){
			    						$in_item=[
			                                'invoice_id'=>$ins_id,
			                                'product'=>get_products_data($it['product_id'],'product_name'),
			                                'product_id'=>$it['product_id'],
			                                'quantity'=> 1,
			                                'price'=>aitsun_round(fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']),get_setting(company($myid),'round_of_value')),
			                                'discount'=>0,
			                                'amount'=>aitsun_round(fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']),get_setting(company($myid),'round_of_value')),
			                                'desc'=>get_products_data($it['product_id'],'description'),
			                                'type'=>'single',
			                                'tax'=>0
			                            ];

		                                $InvoiceitemsModel->save($in_item);
			    					}
			    					
			    					
			    					
			    						
			    					
			    				}
		    				
		    			}

		    				
		    			}

		    			if (empty($student_id)) {
		    				echo 1;
		    			}else{
		    				echo $ins_id;
		    			}
		    			




		    		}else{
			    		echo 0;
			    	}
			    }


		    	}else{
		    		echo 2;
		    	}
		    
		}else{
    		echo 4;
    	}
			
	}




public function generate_invoices_custom($fees_id='',$student_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();
		    $AccountingModel= new Main_item_party_table();
		    $Classtablemodel= new Classtablemodel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();
		    	 
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();

		    		if ($this->request->getMethod() == 'post') {


		    		if ($ft) {

		    			$cus_class=$this->request->getVar('cus_class');
		    			$challan_for=$this->request->getVar('challan_for');
		    			
		    			if ($challan_for=='for_student') {
		    				$student_array=$Classtablemodel->where('company_id', company($myid))->where('academic_year', academic_year($myid))->where('class_id', current_class_of_student(company($myid),$student_id))->where('deleted', 0)->where('student_id',$student_id)->orderby('first_name','ASC')->where('transfer','')->findAll();
		    			}elseif ($challan_for=='for_class') {
		    				$student_array=students_array_of_class(company($myid),$cus_class);
		    			}else{
		    				$student_array=students_array(company($myid));
		    			}

		    			 
		    			
		    			foreach ($student_array as $student) {
		    				// echo $student['first_name'];echo "<br>";
		    				$subtotal=0;
		    				$total=0;

		    				if ($challan_for=='for_student') {
			    			 $student_iid=$student['student_id']; 
			    			}elseif ($challan_for=='for_class') {
			    				 $student_iid=$student['student_id'];
			    			}else{
			    				 $student_iid=$student['id'];
			    			}

		    				foreach ($_POST["custom_fees_name"] as $i => $value ) {
                  $custom_fees_name=trim(strip_tags($_POST["custom_fees_name"][$i]));
                  $custom_fees_amount=trim(strip_tags($_POST["custom_fees_amount"][$i]));

                  if (!empty($custom_fees_name)) {
                  	if ($custom_fees_amount>0) {
                  		$subtotal+=$custom_fees_amount;
			    				    $total+=$custom_fees_amount;
                  	}
                  }  
                             
                }
	    					 
		    				

		    				// generate_invoice_here
		    				$invoice_data=[
		    					'company_id'=>company($myid),
		    					'customer'=>$student_iid,
		    					'alternate_name'=>user_name($student_iid),
		    					'invoice_date'=>now_time($myid),
		    					'class_id'=>current_class_of_student(company($myid),$student_iid),
		    					'notes'=>'',
		    					'private_notes'=>'',
		    					'tax'=>'',
		    					'created_at'=>now_time($myid),
		    					'discount'=>0,
		    					'sub_total'=>aitsun_round($subtotal,get_setting(company($myid),'round_of_value') ),
		    					'total'=>aitsun_round($total,get_setting(company($myid),'round_of_value') ),
		    					'main_total'=>aitsun_round($total,get_setting(company($myid),'round_of_value') ),
		    					'status'=>'sent',
		    					'paid_status'=>'unpaid',
		    					'paid_amount'=>0,
		    					'due_amount'=>aitsun_round($total,get_setting(company($myid),'round_of_value') ),
		    					'invoice_type'=>'challan',
		    					'converted'=>1,
		    					'serial_no'=>serial_no(company($myid),'challan'),
		    					'phone'=>user_phone($student_iid),
		    					'fees_id'=>$fees_id,
		    					'billed_by'=>$myid,
		    					'is_custom'=>1,
		    					'fees_type'=>get_fees_data(company($myid),$fees_id,'fees_type'),
		    					'due_date'=>$ft['due_date']
		    				];


		    				
		    				 
		    				$check_in_exist=$InvoiceModel->where('fees_id',$fees_id)->where('customer',$student_iid)->where('deleted',0)->first();

		    				if ($check_in_exist) {
		    					$ins_id=0;
		    				}else{
		    					

		    					$saveinvoice=$InvoiceModel->save($invoice_data);
			    				$ins_id=$InvoiceModel->insertID();

			    				if ($saveinvoice) {

			    					foreach ($_POST["custom_fees_name"] as $j => $value ) {
		                  $j_custom_fees_name=trim(strip_tags($_POST["custom_fees_name"][$j]));
		                  $j_custom_fees_amount=trim(strip_tags($_POST["custom_fees_amount"][$j]));
		                  $priceee=0;
		                  if (!empty($j_custom_fees_name)) {
		                  	 
		                  	if ($j_custom_fees_amount>0) {
		                  		$priceee+=$j_custom_fees_amount; 
		                  	}



		                  	$in_item=[
                          'invoice_id'=>$ins_id,
                          'product'=>$j_custom_fees_name,
                          'product_id'=>0,
                          'is_custom'=>1,
                          'quantity'=> 1,
                          'price'=>aitsun_round($priceee,get_setting(company($myid),'round_of_value')),
                          'discount'=>0,
                          'amount'=>aitsun_round($priceee,get_setting(company($myid),'round_of_value')),
                          'desc'=>'',
                          'type'=>'single',
                          'tax'=>0
                      ];

		                  $InvoiceitemsModel->save($in_item);

		                  }  
		                             
		                }
 
			    						
			    					
			    				}
		    				
		    			}

		    				
		    			}

		    			if (empty($student_id)) {
		    				echo 1;
		    			}else{
		    				echo $ins_id;
		    			}
		    			




		    		}else{
			    		echo 0;
			    	}
			    }


		    	}else{
		    		echo 2;
		    	}
		    
		}else{
    		echo 4;
    	}
			
	}


public function generate_invoices_for_class($fees_id='',$class_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();
		    $AccountingModel= new Main_item_party_table();
		    $Classtablemodel= new Classtablemodel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();
		    	 
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();

		    		if ($this->request->getMethod() == 'post') {

		    		if ($ft) {

		    			 
		    			$student_array=students_array_of_class(company($myid),$class_id);
		    			  
		    			
		    			foreach ($student_array as $student) {
		    				// echo $student['first_name'];echo "<br>";
		    				$subtotal=0;
		    				$total=0;

	    					foreach (fees_items_array($fees_id) as $it) { 

	    						

		    						$subtotal+=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']);
			    				    $total+=fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']); 
		    				   

	    					}
		    				

		    				// generate_invoice_here
		    				$invoice_data=[
		    					'company_id'=>company($myid),
		    					'customer'=>$student['student_id'],
		    					'alternate_name'=>user_name($student['student_id']),
		    					'invoice_date'=>now_time($myid),
		    					'class_id'=>current_class_of_student(company($myid),$student['student_id']),
		    					'notes'=>'',
		    					'private_notes'=>'',
		    					'tax'=>'',
		    					'created_at'=>now_time($myid),
		    					'discount'=>0,
		    					'sub_total'=>$subtotal,
		    					'total'=>$total,
		    					'main_total'=>$total,
		    					'status'=>'sent',
		    					'paid_status'=>'unpaid',
		    					'paid_amount'=>0,
		    					'due_amount'=>$total,
		    					'invoice_type'=>'challan',
		    					'converted'=>1,
		    					'serial_no'=>serial_no(company($myid),'challan'),
		    					'phone'=>user_phone($student['student_id']),
		    					'fees_id'=>$fees_id,
		    					'billed_by'=>$myid,
		    					'fees_type'=>get_fees_data(company($myid),$fees_id,'fees_type'),
		    					'due_date'=>$ft['due_date']
		    				];


		    				
		    				 
		    				$check_in_exist=$InvoiceModel->where('fees_id',$fees_id)->where('customer',$student['student_id'])->where('deleted',0)->first();

		    				if ($check_in_exist) {
		    					$ins_id=0;
		    				}else{
		    					

		    					$saveinvoice=$InvoiceModel->save($invoice_data);
			    				$ins_id=$InvoiceModel->insertID();

			    				if ($saveinvoice) {

			    					// ??????????????????????????  customer and cash balance calculation start ????????????
				            // ??????????????????????????  customer and cash balance calculation start ????????????
				            //CUSTOMER
				            $bal_customer=$student['student_id'];

				            $current_closing_balance=user_data($bal_customer,'closing_balance');
				            $new_closing_balance=$current_closing_balance;
	 
				                $new_closing_balance=$new_closing_balance+aitsun_round($total,get_setting(company($myid),'round_of_value'));
				             


				            $bal_customer_data=[ 
				                'closing_balance'=>$new_closing_balance,
				            ];
				            $user->update($bal_customer,$bal_customer_data);
				            // ??????????????????????????  customer and cash balance calculation end ??????????????
				            // ??????????????????????????  customer and cash balance calculation end ??????????????

			    					foreach (fees_items_array($fees_id) as $it){
			    						$in_item=[
			                                'invoice_id'=>$ins_id,
			                                'product'=>get_products_data($it['product_id'],'product_name'),
			                                'product_id'=>$it['product_id'],
			                                'quantity'=> 1,
			                                'price'=>fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']),
			                                'discount'=>0,
			                                'amount'=>fees_of_student(company($myid),get_student_data(company($myid),$student['student_id'],'category'),current_class_of_student(company($myid),$student['student_id']),$it['product_id']),
			                                'desc'=>get_products_data($it['product_id'],'description'),
			                                'type'=>'single',
			                                'tax'=>0
			                            ];

		                                $InvoiceitemsModel->save($in_item);
			    					}
			    					
			    					
			    					
			    						
			    					
			    				}
		    				
		    			}

		    				
		    			}

		    			if (empty($student_id)) {
		    				echo 1;
		    			}else{
		    				echo $ins_id;
		    			}
		    			




		    		}else{
			    		echo 0;
			    	}
			    }


		     
		    	
		    }else{
		   		echo 3;
		   	}	
		}else{
    		echo 4;
    	}
			
	}


	public function generate_challan_for_all($fees_id='',$student_id='')
	{
		if (!empty($fees_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();
		    $AccountingModel= new Main_item_party_table();
		    $Classtablemodel= new Classtablemodel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first(); 
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$fees_id)->where('academic_year',academic_year($myid))->where('deleted',0)->first();

		    		if ($this->request->getMethod() == 'post') {

		    		if ($ft) {

		    			 
		    			$student_array=students_array(company($myid));
		    			  
		    			
		    			foreach ($student_array as $student) {
		    				// echo $student['first_name'];echo "<br>";
		    				$subtotal=0;
		    				$total=0;

	    					foreach (fees_items_array($fees_id) as $it) { 

	    						

		    						$subtotal+=fees_of_student(company($myid),get_student_data(company($myid),$student['id'],'category'),current_class_of_student(company($myid),$student['id']),$it['product_id']);
			    				    $total+=fees_of_student(company($myid),get_student_data(company($myid),$student['id'],'category'),current_class_of_student(company($myid),$student['id']),$it['product_id']); 
		    				   

	    					}
		    				

		    				// generate_invoice_here
		    				$invoice_data=[
		    					'company_id'=>company($myid),
		    					'customer'=>$student['id'], 
		    					'alternate_name'=>user_name($student['id']),
		    					'invoice_date'=>now_time($myid),
		    					'class_id'=>current_class_of_student(company($myid),$student['id']),
		    					'notes'=>'',
		    					'private_notes'=>'',
		    					'tax'=>'',
		    					'created_at'=>now_time($myid),
		    					'discount'=>0,
		    					'sub_total'=>aitsun_round($subtotal,get_setting(company($myid),'round_of_value')),
		    					'total'=>aitsun_round($total,get_setting(company($myid),'round_of_value')),
		    					'main_total'=>aitsun_round($total,get_setting(company($myid),'round_of_value')),
		    					'status'=>'sent',
		    					'paid_status'=>'unpaid',
		    					'paid_amount'=>0,
		    					'due_amount'=>aitsun_round($total,get_setting(company($myid),'round_of_value')),
		    					'invoice_type'=>'challan',
		    					'converted'=>1,
		    					'serial_no'=>serial_no(company($myid),'challan'),
		    					'phone'=>user_phone($student['id']),
		    					'fees_id'=>$fees_id,
		    					'billed_by'=>$myid,
		    					'fees_type'=>get_fees_data(company($myid),$fees_id,'fees_type'),
		    					'due_date'=>$ft['due_date']
		    				];


		    				
		    				 
		    				$check_in_exist=$InvoiceModel->where('fees_id',$fees_id)->where('customer',$student['id'])->where('deleted',0)->first();

		    				if ($check_in_exist) {
		    					$ins_id=0;
		    				}else{
		    					

		    					$saveinvoice=$InvoiceModel->save($invoice_data);
			    				$ins_id=$InvoiceModel->insertID();

			    				if ($saveinvoice) {



			            // ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			            //CUSTOMER
			            $bal_customer=$student['id'];

			            $current_closing_balance=user_data($bal_customer,'closing_balance');
			            $new_closing_balance=$current_closing_balance;
 
			                $new_closing_balance=$new_closing_balance+aitsun_round($total,get_setting(company($myid),'round_of_value'));
			             


			            $bal_customer_data=[ 
			                'closing_balance'=>$new_closing_balance,
			            ];
			            $user->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????


			    					foreach (fees_items_array($fees_id) as $it){
			    						$in_item=[
			                                'invoice_id'=>$ins_id,
			                                'product'=>get_products_data($it['product_id'],'product_name'),
			                                'product_id'=>$it['product_id'],
			                                'quantity'=> 1,
			                                'price'=>aitsun_round(fees_of_student(company($myid),get_student_data(company($myid),$student['id'],'category'),current_class_of_student(company($myid),$student['id']),$it['product_id']),get_setting(company($myid),'round_of_value')),
			                                'discount'=>0,
			                                'amount'=>aitsun_round(fees_of_student(company($myid),get_student_data(company($myid),$student['id'],'category'),current_class_of_student(company($myid),$student['id']),$it['product_id']),get_setting(company($myid),'round_of_value')),
			                                'desc'=>get_products_data($it['product_id'],'description'),
			                                'type'=>'single',
			                                'tax'=>0
			                            ];

		                                $InvoiceitemsModel->save($in_item);
			    					}
			    					
			    					
			    					
			    						
			    					
			    				}
		    				
		    			}

		    				
		    			}

		    			if (empty($student_id)) {
		    				echo 1;
		    			}else{
		    				echo $ins_id;
		    			}
		    			




		    		}else{
			    		echo 0;
			    	}
			    }


		    	 
		    	
		    }else{
		   		echo 3;
		   	}	
		}else{
    		echo 4;
    	}
			
	}






	public function delete_invoice($fees_id="",$invoice_id=""){
		if (!empty($invoice_id)) {
			$myid=session()->get('id');
			$InvoiceModel= new InvoiceModel();
			$AccountingModel= new Main_item_party_table();
			$PaymentsModel= new PaymentsModel();

			$acti=activated_year(company($myid));
			
			 $multyiple = explode(',', $invoice_id);

			 foreach ($multyiple as $inid) {

			 	$check_payments=$PaymentsModel->where('invoice_id',$inid)->where('deleted',0)->first();

				if (!$check_payments) {
					
						 	delete_from_payments($inid);
						 	$data=[
								'deleted'=>1,
								'edit_effected'=>0
							];



							if ($InvoiceModel->update($inid,$data)) {

								$in_type=$InvoiceModel->where('id',$inid)->first();

								// ??????????????????????????  customer and cash balance calculation start ????????????
		            // ??????????????????????????  customer and cash balance calculation start ????????????
		            //CUSTOMER
		            $bal_customer=$in_type['customer'];

		            $current_closing_balance=user_data($bal_customer,'closing_balance');
		            $new_closing_balance=$current_closing_balance;

		            $new_closing_balance=$new_closing_balance-aitsun_round($in_type['due_amount'],get_setting(company($myid),'round_of_value')); 

		            $bal_customer_data=[ 
		                'closing_balance'=>$new_closing_balance,
		            ];
		            $AccountingModel->update($bal_customer,$bal_customer_data);
		            // ??????????????????????????  customer and cash balance calculation end ??????????????
		            // ??????????????????????????  customer and cash balance calculation end ??????????????


								////////////////////////CREATE ACTIVITY LOG//////////////
				                $log_data=[
				                    'user_id'=>$myid,
				                    'action'=>'Challan <b>#'.$inid.'</b> is deleted.',
				                    'ip'=>get_client_ip(),
				                    'mac'=>GetMAC(),
				                    'created_at'=>now_time($myid),
				                    'updated_at'=>now_time($myid),
				                    'company_id'=>company($myid),
				                ];

				                add_log($log_data);
			                ////////////////////////END ACTIVITY LOG/////////////////

								
								
							}

				}
			
				
			 }

			session()->setFlashdata('pu_msg', 'Deleted successfully');
		 
			if (count($multyiple)>1) {
				return redirect()->to(base_url('fees_and_payments/details/'.$fees_id));
			} 
		}
	}


	public function view_challan($invoice_id='')
	{
		if (!empty($invoice_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $InvoiceitemsModel= new InvoiceitemsModel();

		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		



		    		$all_invoices=$InvoiceModel->where('company_id',company($myid))->where('id',$invoice_id)->first();

		    		$all_invoices=$InvoiceModel->where('company_id',company($myid))->where('id',$invoice_id)->first();

		    		
		    			$data=[
			    			'title'=>'Challan | Aitsun ERP',
			    			'user'=>$usaerdata,
			    			'invoice'=>$all_invoices,
			    		];

			    		$etype='';
		                if ($_GET) {
		                  if (isset($_GET['etype'])) {
		                      if (!empty($_GET['etype'])) {
		                          $etype=$_GET['etype'];
		                      }
		                  }
		                }
		                if ($etype=='ajaxex') {
		                  echo view('fees/view_challan',$data);
		                }else{
				    		echo view('header',$data);
				    		
				    		echo view('fees/view_challan');
				    		echo view('footer');
				    	}
		    		
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}	
		}else{
    		return redirect()->to(base_url());
    	}
			
	}

	
	public function get_challan($invoice_id='',$type='view')
	{
		if (!empty($invoice_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first(); 

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		



		    		$invoice_data=$InvoiceModel->where('company_id',company($myid))->where('id',$invoice_id)->first();
					$fees_type=$FeesModel->where('company_id',company($myid))->where('id',$invoice_data['fees_id'])->where('deleted',0)->first();

						$filename="uknown file.pdf";
              $cusname="CASH CUSTOMER";

              if ($invoice_data['customer']!='CASH'){
                $cusname=user_name($invoice_data['customer']);
              }elseif ($invoice_data['alternate_name']!=''){
                $cusname= $invoice_data['alternate_name'];
              } 


             $page_size='A4';
                $orientation='portrait';

                if (!empty($page_size)) {
                    $page_size=strtoupper(get_setting2(company($myid),'challan_page_size')); 
                }

                if (!empty($page_size)) {
                    $orientation=get_setting2(company($myid),'challan_orientation'); 
                }


		    		$filename=inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']).' - '.$cusname.' - '.inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'.pdf';

		    			$data=[
			    			'title'=>$filename,
			    			'user'=>$usaerdata,
			    			'invoice'=>$invoice_data,
			    			'ft'=>$fees_type,
			    		];  
                   
              $dompdf = new \Dompdf\Dompdf();
              $dompdf->set_option('isJavascriptEnabled', TRUE);
              $dompdf->set_option('isRemoteEnabled', TRUE); 

              $dompdf->loadHtml(view('fees/challan_design',$data));
              $dompdf->setPaper($page_size, $orientation);
              $dompdf->render();

              if ($type=='download') {
                $dompdf->stream($filename, array("Attachment" => true));
              }else{
                $dompdf->stream($filename, array("Attachment" => false));
              }
			    	
		    		 exit();
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}	
		}else{
    		return redirect()->to(base_url());
    	}
			
	}
	






	public function add_fees_type()
		{
			$FeesModel = new FeesModel();
			$FeesitemsModal =new FeesitemsModal();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

					$feesdata=[
						'company_id' => company($myid),
						'academic_year' => academic_year($myid),
						'fees_name' => strip_tags($this->request->getVar('feesname')),
						'description' => strip_tags($this->request->getVar('description')),
						'datetime' => now_time($myid),
						'class' => strip_tags($this->request->getVar('classes')),
						'due_date' => strip_tags($this->request->getVar('due_date')),
						'fees_type' => strip_tags($this->request->getVar('fees_type')),
						'added_by'=>$myid
	        ];

					$save=$FeesModel->save($feesdata);
					$inid=$FeesModel->insertID();

					if ($save) {
						
						if (is_array($this->request->getVar('item_id'))) {
							foreach ($this->request->getVar('item_id') as $i => $value) { 

    						$itemid=$_POST['item_id'][$i];

			                if ($_POST['itemchecked'][$i]!=0) {
			                	$fee_item=[
	                                'company_id'=>company($myid),
	                                'fees_id'=>$inid,
	                                'product_id'=>strip_tags($itemid),
	                                
	                            ];

                                $FeesitemsModal->save($fee_item);
			                }
    						

    					}
						}
						

					$session = session();
					$session->setFlashdata('pu_msg', 'Added successfully');
					return redirect()->to(base_url('fees_and_payments'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments'));
			}

		}
	}

	public function edit_fees_type($fe_id=0)
		{
			$FeesModel = new FeesModel();
			$FeesitemsModal = new FeesitemsModal();

			$myid=session()->get('id');


			if ($this->request->getMethod() == 'post') {

			

					$feesdata=[
						'fees_name' => strip_tags($this->request->getVar('feesname')),
						'description' => strip_tags($this->request->getVar('description')),
            'class' => strip_tags($this->request->getVar('classes')),
						'due_date' => strip_tags($this->request->getVar('due_date')),
						'fees_type' => strip_tags($this->request->getVar('fees_type')),
						
	                ];


	                

					$FeesModel->update($fe_id,$feesdata);

					foreach($this->request->getVar('item_id') as $i => $value) { 

						$itemid=$_POST['item_id'][$i];

		                if ($_POST['itemchecked'][$i]==0) { 
		                	$getexits=$FeesitemsModal->where('fees_id',$fe_id)->where('product_id',$itemid)->first();
		                	if ($getexits) {
		                		$FeesitemsModal->where('id',$getexits['id'])->delete();
		                	}
                            
		                }else{ 
		                	$fee_item=[
                                'company_id'=>company($myid),
                                'fees_id'=>$fe_id,
                                'product_id'=>strip_tags($itemid),
                                
                            ]; 
                            $egetexits=$FeesitemsModal->where('fees_id',$fe_id)->where('product_id',$itemid)->first();
                            if (!$egetexits) {
                            	$FeesitemsModal->save($fee_item); 
                            }
		                }
						

					}


					$session = session();
					$session->setFlashdata('pu_msg', 'Updated successfully');
					return redirect()->to(base_url('fees_and_payments'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments'));
			}

		}



		public function edit_fees_name($fe_id=0)
		{
			$FeesModel = new FeesModel();
			$FeesitemsModal = new FeesitemsModal();

			$myid=session()->get('id');


			if ($this->request->getMethod() == 'post') {

			

					$feesdata=[
						'fees_name' => strip_tags($this->request->getVar('feesname')), 
						'fees_type' => strip_tags($this->request->getVar('fees_type')),
						
	                ]; 

					$FeesModel->update($fe_id,$feesdata); 

					$session = session();
					$session->setFlashdata('pu_msg', 'Updated successfully');
					return redirect()->to(base_url('fees_and_payments'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments'));
			}

		}

		


	public function delete_fees_type($fe_id=0)
		{
			$FeesModel = new FeesModel();
			

			if ($this->request->getMethod() == 'get') {

					$FeesModel->find($fe_id);

					$stdcat=[
						'deleted' => 1,
						
	                ];

					$FeesModel->update($fe_id,$stdcat);
					$session = session();
					$session->setFlashdata('pu_msg', 'Deleted successfully');
					return redirect()->to(base_url('fees_and_payments'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments'));
			}

		}



	public function price_table()
		{
			$session=session();
		    $myid=session()->get('id');
		    $user=new Main_item_party_table();
		    $ProductsModel = new Main_item_party_table();
		    $StudentcategoryModel = new StudentcategoryModel();
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$items=$ProductsModel->where('company_id',company($myid))->where('product_method','service')->where('main_type','product')->where('product_type','fees')->where('view_as!=','transport')->where('deleted',0)->orderBy('id','DESC')->findAll();

		    		$student_cat=$StudentcategoryModel->where('company_id',company($myid))->where('deleted',0)->where('type','main')->findAll();
		    		
		    		$data=[
		    			'title'=>'Price Table | Aitsun ERP',
		    			'user'=>$usaerdata,
		    			'items'=>$items,
		    			'student_cat'=>$student_cat,
		    		];

		    		$etype='';
	                if ($_GET) {
	                  if (isset($_GET['etype'])) {
	                      if (!empty($_GET['etype'])) {
	                          $etype=$_GET['etype'];
	                      }
	                  }
	                }
	                if ($etype=='ajaxex') {
	                  echo view('fees/price_table',$data);
	                }else{
			    		echo view('header',$data); 
			    		echo view('fees/price_table');
			    		echo view('footer');
			    	}


		    
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}		
		}

 

		public function price_table_transport()
		{
			$session=session();
		    $myid=session()->get('id');
		    $user=new Main_item_party_table();
		    $ProductsModel = new Main_item_party_table();
		    $StudentcategoryModel = new StudentcategoryModel();
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		

		    		$items=$ProductsModel->where('company_id',company($myid))->where('product_method','service')->where('main_type','product')->where('main_type','product')->where('product_type','fees')->where('view_as','transport')->where('deleted',0)->orderBy('id','DESC')->findAll();

		    		$student_cat=$StudentcategoryModel->where('company_id',company($myid))->where('deleted',0)->where('type','main')->findAll();
		    		
		    		$data=[
		    			'title'=>'Transport Price Table | Aitsun ERP',
		    			'user'=>$usaerdata,
		    			'items'=>$items,
		    			'student_cat'=>$student_cat,
		    		];

		    
	              echo view('header',$data);
			    		
			    		echo view('fees/price_table_transport');
			    		echo view('footer');
 
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}		
		}



		public function add_items()
		{
			$ProductsModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

					$feesdata=[
						'company_id' => company($myid),
						'product_name' => strip_tags($this->request->getVar('itemname')),
						'unit' => 'qt',
						'description' => strip_tags($this->request->getVar('description')),
						'created_at' => now_time($myid),
						'serial_no' => 1,
						'product_type' => 'fees',
						'main_type' => 'product',
						'product_method' => 'service',
						'deleted' => 0,
						'editable'=>strip_tags($this->request->getVar('editable'))
	                ];

					$ProductsModel->save($feesdata);
					$session = session();
					$session->setFlashdata('pu_msg', 'Added successfully');
					return redirect()->to(base_url('fees_and_payments/price_table'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table'));
			}

		}

		public function add_transport_items()
		{
			$ProductsModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

					$feesdata=[
						'company_id' => company($myid),
						'product_name' => strip_tags($this->request->getVar('itemname')),
						'vehicle' => strip_tags($this->request->getVar('vehicle')),
						'unit' => 'qt',
						'description' => strip_tags($this->request->getVar('description')),
						'created_at' => now_time($myid),
						'serial_no' => 1,
						'product_type' => 'fees',
						'product_method' => 'service',
						'main_type' => 'product',
						'view_as' => 'transport',
						'deleted' => 0,
						'editable'=>strip_tags($this->request->getVar('editable'))
	                ];

					$ProductsModel->save($feesdata);
					$session = session();
					$session->setFlashdata('pu_msg', 'Added successfully');
					return redirect()->to(base_url('fees_and_payments/price_table_transport'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table_transport'));
			}

		}

		public function edit_transport_items($item_id=0)
		{
			$ProductsModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

					$feesdata=[
						'product_name' => strip_tags($this->request->getVar('itemname')),
						'vehicle' => strip_tags($this->request->getVar('vehicle')),
						'description' => strip_tags($this->request->getVar('description')),
						'editable'=>strip_tags($this->request->getVar('editable'))
						
	                ];

					$ProductsModel->update($item_id,$feesdata);
					$session = session();
					$session->setFlashdata('pu_msg', 'Updated successfully');
					return redirect()->to(base_url('fees_and_payments/price_table_transport'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table_transport'));
			}

		}
		

		public function edit_items($item_id=0)
		{
			$ProductsModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

					$feesdata=[
						'product_name' => strip_tags($this->request->getVar('itemname')),
						'description' => strip_tags($this->request->getVar('description')),
						'editable'=>strip_tags($this->request->getVar('editable'))
						
	                ];

					$ProductsModel->update($item_id,$feesdata);
					$session = session();
					$session->setFlashdata('pu_msg', 'Updated successfully');
					return redirect()->to(base_url('fees_and_payments/price_table'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table'));
			}

		}

		public function deleteitem($item_id=0)
		{
			$ProductsModel = new Main_item_party_table();
			

			if ($this->request->getMethod() == 'get') {

					$ProductsModel->find($item_id);

					$item=[
						'deleted' => 1,
						
	                ];

					$ProductsModel->update($item_id,$item);
					$session = session();
					$session->setFlashdata('pu_msg', 'Deleted successfully');
					return redirect()->to(base_url('fees_and_payments/price_table'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table'));
			}

		}

		public function deleteitem_trans($item_id=0)
		{
			$ProductsModel = new Main_item_party_table();
			

			if ($this->request->getMethod() == 'get') {

					$ProductsModel->find($item_id);

					$item=[
						'deleted' => 1,
						
	                ];

					$ProductsModel->update($item_id,$item);
					$session = session();
					$session->setFlashdata('pu_msg', 'Deleted successfully');
					return redirect()->to(base_url('fees_and_payments/price_table_transport'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table_transport'));
			}

		}



		public function deletecat($cat_id=0)
		{
			$StudentcategoryModel = new StudentcategoryModel();
			

			if ($this->request->getMethod() == 'get') {

					$StudentcategoryModel->find($cat_id);

					$stdcat=[
						'deleted' => 1,
						
	                ];

					$StudentcategoryModel->update($cat_id,$stdcat);
					$session = session();
					$session->setFlashdata('pu_msg', 'Category deleted successfully');
					return redirect()->to(base_url('fees_and_payments/price_table'));

			}else{
	   			return redirect()->to(base_url('fees_and_payments/price_table'));
			}

		}



		public function add_item_price(){
		$session=session();
	    $user=new Main_item_party_table();
	    $PricetableModel=new PricetableModel();
	    $myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('category_id')) {

				$ac_data = [
					'company_id'=>company($myid),
					'category_id'=>$this->request->getVar('category_id'),
					'item_id'=>$this->request->getVar('item_id'),
					'price'=>aitsun_round($this->request->getVar('price'),get_setting(company($myid),'round_of_value')),
					'class'=>$this->request->getVar('classid')
				];
				
				$checkexits=$PricetableModel->where('company_id',company($myid))->where('class',$this->request->getVar('classid'))->where('category_id',$this->request->getVar('category_id'))->where('item_id',$this->request->getVar('item_id'))->where('deleted',0)->first();

				if ($checkexits) {
					$items_price=$PricetableModel->update($checkexits['id'],$ac_data);
				}else{
					$items_price=$PricetableModel->save($ac_data);
				}
				

				if ($items_price) {
					echo 1;
				}else{
					echo 0;
				}
			}
		}
	}

	public function pdf_fees_challan($invoice_id="",$type="view")
	{
		if (!empty($invoice_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $FeesModel= new FeesModel();
		    $InvoiceModel= new InvoiceModel(); 
		     
		    	 
 


		    		$invoice_data=$InvoiceModel->where('id',$invoice_id)->first();
					$fees_type=$FeesModel->where('id',$invoice_data['fees_id'])->where('deleted',0)->first();

						$filename="uknown file.pdf";
              $cusname="CASH CUSTOMER";

              if ($invoice_data['customer']!='CASH'){
                $cusname=user_name($invoice_data['customer']);
              }elseif ($invoice_data['alternate_name']!=''){
                $cusname= $invoice_data['alternate_name'];
              } 


		    		$filename=inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']).' - '.$cusname.' - '.inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'.pdf';

		    			$data=[
			    			'title'=>$filename, 
			    			'invoice'=>$invoice_data,
			    			'ft'=>$fees_type,
			    		];  
                   
              $dompdf = new \Dompdf\Dompdf();
              $dompdf->set_option('isJavascriptEnabled', TRUE);
              $dompdf->set_option('isRemoteEnabled', TRUE); 

              $dompdf->loadHtml(view('fees/challan_design',$data));
              $dompdf->setPaper('A4', 'portrait');
              $dompdf->render();

              if ($type=='download') {
                $dompdf->stream($filename, array("Attachment" => true));
              }else{
                $dompdf->stream($filename, array("Attachment" => false));
              }
			    	
		    		 exit(); 
		 
		}else{
    		echo 'Invalid url';
    }
	}







		public function add_additional_fee()
		{
			$InvoiceModel = new InvoiceModel();
			$InvoiceitemsModel = new InvoiceitemsModel();
			$FeesModel = new FeesModel();

			$AccountingModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

				$subtotal=0;
		    	$total=0;

		    	

				$ft=$FeesModel->where('company_id',company($myid))->where('id',$this->request->getVar('fees_id'))->where('academic_year',academic_year($myid))->where('deleted',0)->first();

				if ($this->request->getVar('product_id')) {
					foreach ($this->request->getVar('product_id') as $i => $value) {
						if (isset($_POST['product_id'][$i])) {



			    			if ($_POST['itemchecked'][$i]==1) { 

			                    $checkexist=$InvoiceitemsModel->where('invoice_id',$this->request->getVar('invoice_id'))->where('product_id',$_POST['product_id'][$i])->first();
			                    if (!$checkexist) {

			                    	$subtotal+=fees_of_student(company($myid),get_student_data(company($myid),$this->request->getVar('student_id'),'category'),current_class_of_student(company($myid),$this->request->getVar('student_id')),$_POST['product_id'][$i]);
					    			$total+=fees_of_student(company($myid),get_student_data(company($myid),$this->request->getVar('student_id'),'category'),current_class_of_student(company($myid),$this->request->getVar('student_id')),$_POST['product_id'][$i]);
					    				$in_item=[
					                        'invoice_id'=>$this->request->getVar('invoice_id'),
					                        'product'=>$_POST['product'][$i],
					                        'product_id'=>$_POST['product_id'][$i],
					                        'quantity'=> 1,
					                        'price'=>aitsun_round(fees_of_student(company($myid),get_student_data(company($myid),$this->request->getVar('student_id'),'category'),current_class_of_student(company($myid),$this->request->getVar('student_id')),$_POST['product_id'][$i]),get_setting(company($myid),'round_of_value')),
					                        'discount'=>0,
					                        'amount'=>aitsun_round(fees_of_student(company($myid),get_student_data(company($myid),$this->request->getVar('student_id'),'category'),current_class_of_student(company($myid),$this->request->getVar('student_id')),$_POST['product_id'][$i]),get_setting(company($myid),'round_of_value')),
					                        'type'=>'single',
					                        'tax'=>0,
					                        'editable'=>1
					                    ];

			                    	$InvoiceitemsModel->save($in_item);
			                    }
			                    
			    			}else{

			    				$checkexist=$InvoiceitemsModel->where('invoice_id',$this->request->getVar('invoice_id'))->where('product_id',$_POST['product_id'][$i])->first();
			    				if ($checkexist) {

			    					$subtotal-=fees_of_student(company($myid),get_student_data(company($myid),$this->request->getVar('student_id'),'category'),current_class_of_student(company($myid),$this->request->getVar('student_id')),$_POST['product_id'][$i]);
					    			$total-=fees_of_student(company($myid),get_student_data(company($myid),$this->request->getVar('student_id'),'category'),current_class_of_student(company($myid),$this->request->getVar('student_id')),$_POST['product_id'][$i]);

			    					$InvoiceitemsModel->where('id',$checkexist['id'])->delete();

			    				} 

			    			}

		                   
		                }

		                $damt=($this->request->getVar('total')+$total)-$this->request->getVar('paid_amount');
		                if ($damt>0) {
		                	$pstat='unpaid';
		                }else{
		                	$pstat='paid';
		                }
		                $paid_amount=$this->request->getVar('paid_amount');

		                	

		                $indata=[
		                	'sub_total'=>aitsun_round($this->request->getVar('sub_total')+$subtotal,get_setting(company($myid),'round_of_value')),
			    			'total'=>aitsun_round($this->request->getVar('total')+$total,get_setting(company($myid),'round_of_value')),
			    			'main_total'=>aitsun_round($this->request->getVar('main_total')+$total,get_setting(company($myid),'round_of_value')),
							'due_amount'=>aitsun_round($damt,get_setting(company($myid),'round_of_value')),
							'paid_status'=>$pstat,
							'edit_effected'=>0,
							'old_total'=>aitsun_round($this->request->getVar('total'),get_setting(company($myid),'round_of_value')),
		                ];




		                

		                	$old_due_amount=invoice_data($this->request->getVar('invoice_id'),'due_amount');
		                $in_type=invoice_data($this->request->getVar('invoice_id'),'invoice_type');



		                    $InvoiceModel->update($this->request->getVar('invoice_id'),$indata);




		               // ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			                    //CUSTOMER
			                    $bal_customer=invoice_data($this->request->getVar('invoice_id'),'customer');

			                    $current_closing_balance=user_data($bal_customer,'closing_balance');
			                    $new_closing_balance=$current_closing_balance;

			                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return' || $in_type=='challan') {
			                        $new_closing_balance=($new_closing_balance-$old_due_amount)+aitsun_round($damt,get_setting(company($myid),'round_of_value'));
			                    }elseif ($in_type=='purchase' || $in_type=='sales_return'){
			                        $new_closing_balance=($new_closing_balance+$old_due_amount)-aitsun_round($damt,get_setting(company($myid),'round_of_value'));
			                    }


			                    $bal_customer_data=[ 
			                        'closing_balance'=>$new_closing_balance,
			                    ];
			                    $AccountingModel->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????


						
						
					}
				}

					
					echo 1;

			}else{
	   			echo 0;
			}

		}


		
		public function add_concession_fee()
		{
			$InvoiceModel = new InvoiceModel();
			$InvoiceitemsModel = new InvoiceitemsModel();
			$FeesModel = new FeesModel();
			$AccountingModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');

				$subtotal=0;
		    	$total=0;



		    	

		    	$main_amount=$this->request->getVar('main_total');
		    	$paid_amount=$this->request->getVar('paid_amount');
		    	$discount_amount=$this->request->getVar('discount_amount');

		    	$payable=$main_amount-$paid_amount;

		    	

		    	if ($discount_amount<=$payable) {
		    		$ft=$FeesModel->where('company_id',company($myid))->where('id',$this->request->getVar('fees_id'))->where('academic_year',academic_year($myid))->where('deleted',0)->first();

					if ($this->request->getVar('invoice_id')) {
						$paid_status='unpaid';

				    	
						$duewww=aitsun_round(($this->request->getVar('main_total')-$this->request->getVar('discount_amount'))-$paid_amount,get_setting(company($myid),'round_of_value'));

						if ($duewww<=0) {
				    	$paid_status='paid';
				    }

						$indata=[
		                	'sub_total'=>aitsun_round($this->request->getVar('sub_total'),get_setting(company($myid),'round_of_value')),
			    			'total'=>aitsun_round($this->request->getVar('main_total')-$this->request->getVar('discount_amount'),get_setting(company($myid),'round_of_value')),
			    			'main_total'=>aitsun_round($this->request->getVar('main_total'),get_setting(company($myid),'round_of_value')),
							'due_amount'=>$duewww,
							'discount'=>aitsun_round($this->request->getVar('discount_amount'),get_setting(company($myid),'round_of_value')),
							'concession_for'=>$this->request->getVar('concession_for'), 
							'edit_effected'=>0,
							'paid_status'=>$paid_status,
							'old_total'=>aitsun_round(invoice_data($this->request->getVar('invoice_id'),'total'),get_setting(company($myid),'round_of_value')),
							'old_concession'=>aitsun_round(invoice_data($this->request->getVar('invoice_id'),'discount'),get_setting(company($myid),'round_of_value'))
		                ];
  

			             
		                $old_due_amount=invoice_data($this->request->getVar('invoice_id'),'due_amount');
		                $in_type=invoice_data($this->request->getVar('invoice_id'),'invoice_type');

		               $InvoiceModel->update($this->request->getVar('invoice_id'),$indata);


		               // ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			                    //CUSTOMER
			                    $bal_customer=invoice_data($this->request->getVar('invoice_id'),'customer');

			                    $current_closing_balance=user_data($bal_customer,'closing_balance');
			                    $new_closing_balance=$current_closing_balance;

			                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return' || $in_type=='challan') {
			                        $new_closing_balance=($new_closing_balance-$old_due_amount)+aitsun_round($duewww,get_setting(company($myid),'round_of_value'));
			                    }elseif ($in_type=='purchase' || $in_type=='sales_return'){
			                        $new_closing_balance=($new_closing_balance+$old_due_amount)-aitsun_round($duewww,get_setting(company($myid),'round_of_value'));
			                    }


			                    $bal_customer_data=[ 
			                        'closing_balance'=>$new_closing_balance,
			                    ];
			                    $AccountingModel->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
					}
						
						
						$session = session();
						$session->setFlashdata('pu_msg', 'Concession added successfully');
						return redirect()->to(base_url('fees_and_payments/view_challan/'.$this->request->getVar('invoice_id')));
		    	}else{
		    		    $session = session();
						$session->setFlashdata('pu_er_msg', 'Sorry! Balance is less than concession amount');
						return redirect()->to(base_url('fees_and_payments/view_challan/'.$this->request->getVar('invoice_id')));
		    	}

				

			}else{
	   			return redirect()->to(base_url('fees_and_payments/view_challan/'.$this->request->getVar('invoice_id')));
			}

		}


	public function delete_concession($inid="")
		{
			$InvoiceModel = new InvoiceModel();
			$AccountingModel = new Main_item_party_table();

			if ($this->request->getMethod() == 'post') {

				$myid=session()->get('id');


					if ($inid) {
						$paid_status='unpaid';

				    $discount_amount=0;

						$duewww=aitsun_round((invoice_data($inid,'due_amount')+invoice_data($inid,'discount')),get_setting(company($myid),'round_of_value'));

						

						if ($duewww<=0) {
				    	$paid_status='paid';
				    }

						$indata=[
		           

		          'sub_total'=>aitsun_round(invoice_data($inid,'sub_total'),get_setting(company($myid),'round_of_value')),
			    		'total'=>aitsun_round(invoice_data($inid,'total')+invoice_data($inid,'discount'),get_setting(company($myid),'round_of_value')),
			    		'main_total'=>aitsun_round(invoice_data($inid,'main_total'),get_setting(company($myid),'round_of_value')),
							'due_amount'=>$duewww,
							'discount'=>aitsun_round($discount_amount,get_setting(company($myid),'round_of_value')),
							'concession_for'=>$this->request->getVar('concession_for'), 
							'edit_effected'=>0,
							'old_total'=>aitsun_round(invoice_data($inid,'total'),get_setting(company($myid),'round_of_value')),
							'old_concession'=>aitsun_round(invoice_data($inid,'discount'),get_setting(company($myid),'round_of_value'))
		         ];
  	
  							  $old_due_amount=invoice_data($inid,'due_amount');
		                $in_type=invoice_data($inid,'invoice_type');

		              $InvoiceModel->update($inid,$indata);

		              // ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			                    //CUSTOMER
			                    $bal_customer=invoice_data($inid,'customer');

			                    $current_closing_balance=user_data($bal_customer,'closing_balance');
			                    $new_closing_balance=$current_closing_balance;

			                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return' || $in_type=='challan') {
			                        $new_closing_balance=($new_closing_balance-$old_due_amount)+aitsun_round($duewww,get_setting(company($myid),'round_of_value'));
			                    }elseif ($in_type=='purchase' || $in_type=='sales_return'){
			                        $new_closing_balance=($new_closing_balance+$old_due_amount)-aitsun_round($duewww,get_setting(company($myid),'round_of_value'));
			                    }


			                    $bal_customer_data=[ 
			                        'closing_balance'=>$new_closing_balance,
			                    ];
			                    $AccountingModel->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????


		              echo 1;
		              // $session = session();
									// $session->setFlashdata('pu_msg', 'Concession removed successfully');
									// return redirect()->to(base_url('fees_and_payments/view_challan/'.$inid));
							}
						
						
						
		    	
				}else{
	   			return redirect()->to(base_url('fees_and_payments/view_challan/'.$this->request->getVar('invoice_id')));
			}
		}




	public function payments($in_id=0)
		{

			$PaymentsModel= new PaymentsModel();
			$session=session();
		    $myid=session()->get('id');
		    $user=new Main_item_party_table();
		    $InvoiceModel= new InvoiceModel;
		    $StudentcategoryModel = new StudentcategoryModel();
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		if (usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}

		    		$invoice_data=$InvoiceModel->where('id',$in_id)->first();
		    		$payments=$PaymentsModel->where('company_id',company($myid))->where('deleted',0)->where('invoice_id',$invoice_data['id'])->findAll();
		    		
		    		$data=[
		    			'title'=>'Payments | Aitsun ERP',
		    			'user'=>$usaerdata,
		    			'invoice_id'=>$invoice_data,
		    			'allpayments'=>$payments,
		    			'data_count' => count($payments),
		    		];

 
			    		echo view('header',$data); 
			    		echo view('fees/payments');
			    		echo view('footer');
		 

 
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}		
		}




		public function update_pay(){
			$session=session();
			$InvoiceModel= new InvoiceModel();
			$PaymentsModel= new PaymentsModel();
			$InstallmentsModel= new InstallmentsModel();
      $AccountingModel= new Main_item_party_table;

      $user=new Main_item_party_table(); 
			if ($session->has('isLoggedIn')) {
				$usaerdata=$user->where('id', session()->get('id'))->first();
		    $myid=session()->get('id');

		    if (isset($_POST['payment_type'])) {
		    	$payeeamou=0;
          $payeeamou=$_POST['cash_amount'];
          $cash_date=$_POST['cash_date'];
 
          	$payment_type=strip_tags($_POST['payment_type']);
            $customer=strip_tags($_POST['customer']);
            $invoice=strip_tags($_POST['invoice']);
            $payment_note=strip_tags($_POST['payment_note']);
            $billtype=trim(strip_tags($_POST['biltype']));
            $total=strip_tags($_POST['total']);

            if($billtype=='sales') {
                $billtype_for_pay='sales';
            }elseif($billtype=='challan') {
                $billtype_for_pay='sales';
            }elseif($billtype=='purchase') {
                $billtype_for_pay='purchase';
            }elseif($billtype=='sales_return') {
                $billtype_for_pay='sale return';
            }elseif($billtype=='purchase_return') {
                $billtype_for_pay='purchase return';
            }else{
                $billtype_for_pay='';
            }

            $ro_amt=0;
            $check_nomber='';
            $check_date='';
            $payment_id=receipt_no_generate(5);
           	
           	$inidd='';

           	foreach ($_POST['installment_id'] as $l => $value) {             
              if (isset($_POST['installment_id'][$l])) {
              	if (!empty($_POST['installment_id'][$l])) {
              		if (pstat_of_install($_POST['installment_id'][$l])!=='paid') {
              			$inidd.=$_POST['installment_id'][$l].',';
              		} 
              	}   
              } 
            }

            $ro_amt=$_POST['cash_amount'];
                        $id_payment_id=add_payment($invoice,$_POST['payment_type'],$_POST['cash_amount'],'---',$customer,$_POST['alternate_name'],$payment_note,$cash_date,$payment_id,company($myid),$billtype_for_pay,$myid,$inidd);
                        $new_paid_amount=$_POST['cash_amount']+paid_amount($invoice);


                        // ??????????????????????????  customer and cash balance calculation end ?????????????? 
						            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
						                    //PAYMENT
						                    $bal_payment=$_POST['payment_type']; 

						                    $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
						                    $new_closing_pay_balance=$current_pay_closing_balance;

						                    if ($billtype=='sales' || $billtype=='proforma_invoice' || $billtype=='purchase_return' || $billtype=='challan') {
						                        $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round($_POST['cash_amount'],get_setting(company($myid),'round_of_value'));
						                    }elseif ($billtype=='purchase' || $billtype=='sales_return'){
						                        $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round($_POST['cash_amount'],get_setting(company($myid),'round_of_value'));
						                    }

						                    $bal_payment_data=[ 
						                        'closing_balance'=>$new_closing_pay_balance,
						                    ];
						                    $AccountingModel->update($bal_payment,$bal_payment_data); 
						            // ??????????????????????????  customer and cash balance calculation end ??????????????
						            // ??????????????????????????  customer and cash balance calculation end ??????????????
                        


	                        foreach ($_POST['installment_id'] as $ii => $value) { 
	                        	if (isset($_POST['installment_id'][$ii])) {
	                        		if (!empty($_POST['installment_id'][$l])) {
			                        	$indsata=[
			                        		'paid_status'=>'paid'
			                        	];
			                        	$InstallmentsModel->update($_POST['installment_id'][$ii],$indsata);
		                        	}

		                        }
	                        }
                       

                        
					               

                            
                            if ($new_paid_amount<$total) {
                                $paid_status='unpaid';
                            }else{
                                $paid_status='paid';
                            }



              

                    $pay_qry=update_paid_amount($invoice,$new_paid_amount,$paid_status);

                    if ($pay_qry) { 
            
             echo  '<iframe class="aitsun-embed" id="aitsun-embed" src="'.base_url('payments/get_receipt').'/'.$id_payment_id.'/view" width="900" height="600"/></iframe>';

                   
                		}


					 

				}

			}
			
    }



    public function update_status(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $PaymentsModel=new PaymentsModel;
        $myid=session()->get('id');

        if (isset($_POST['statusname'],$_POST['getid'])) {
            $cdad=[
                'receive_status'=>$_POST['statusname']
            ];

            $PaymentsModel->update($_POST['getid'],$cdad);

            if ($_POST['statusname']==1) {
                $stat='received';
            }else{
                $stat='not received';
            }

           
        }
    }


    public function delete($inid='',$invoice_id=''){

            $session=session();
            $myid=session()->get('id');
            $UserModel= new Main_item_party_table;
            $PaymentsModel= new PaymentsModel;
            $InvoiceModel= new InvoiceModel;
            $InstallmentsModel= new InstallmentsModel;
            $AccountingModel= new Main_item_party_table;



            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            
            if($session->has('isLoggedIn')){

                
                $deledata=[
                    'deleted'=>1,
                    'edit_effected'=>0 
                ];

                $del=$PaymentsModel->update($inid,$deledata);
                
                if ($del) {
                	$rec_amt=get_payment_data($inid,'amount');
                	$old_paid_amount=invoice_data($invoice_id,'paid_amount');
                	$old_due_amount=invoice_data($invoice_id,'due_amount');

                	$paid_amount=$old_paid_amount-$rec_amt;
					$due_amount=$old_due_amount+$rec_amt;
                	/////////////// RESET INVOICE DATA/////////////////////
                	$resindata=[
                		'paid_amount'=>$paid_amount,
                		'due_amount'=>$due_amount,
                		'paid_status'=>'unpaid',
                	];
                	$InvoiceModel->update($invoice_id,$resindata);
                	/////////////// RESET INVOICE DATA/////////////////////

                	$in_type=get_payment_data($inid,'bill_type');

                	 // ??????????????????????????  customer and cash balance calculation start ????????????
			            // ??????????????????????????  customer and cash balance calculation start ????????????
			            //CUSTOMER
			            $bal_customer=get_payment_data($inid,'customer');

			            $current_closing_balance=user_data($bal_customer,'closing_balance');
			            $new_closing_balance=$current_closing_balance;

			            if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
			                $new_closing_balance=($new_closing_balance-$old_due_amount)+aitsun_round($due_amount,get_setting(company($myid),'round_of_value'));
			            }elseif ($in_type=='purchase' || $in_type=='sales_return'){
			                $new_closing_balance=($new_closing_balance+$old_due_amount)-aitsun_round($due_amount,get_setting(company($myid),'round_of_value'));
			            }


			            $bal_customer_data=[ 
			                'closing_balance'=>$new_closing_balance,
			            ];
			            $UserModel->update($bal_customer,$bal_customer_data);
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????


			            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
			            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
			                    //PAYMENT
			                    $bal_payment=get_payment_data($inid,'type'); 

			                    $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
			                    $new_closing_pay_balance=$current_pay_closing_balance;

			                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
			                        $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round(get_payment_data($inid,'amount'),get_setting(company($myid),'round_of_value'));
			                    }elseif ($in_type=='purchase' || $in_type=='sales_return'){
			                        $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round(get_payment_data($inid,'amount'),get_setting(company($myid),'round_of_value'));
			                    }

			                    $bal_payment_data=[ 
			                        'closing_balance'=>$new_closing_pay_balance,
			                    ];
			                    $UserModel->update($bal_payment,$bal_payment_data); 
			            // ??????????????????????????  customer and cash balance calculation end ??????????????
			            // ??????????????????????????  customer and cash balance calculation end ??????????????




                	if (get_payment_data($inid,'install_id')!='') {

                		$inex=explode(',', get_payment_data($inid,'install_id'));
                		foreach ($inex as $iex) {
                			if (trim($iex)!='') {
                				$indsata=[
			                		'paid_status'=>'unpaid'
			                	];
			                	$InstallmentsModel->update($iex,$indsata);
                			}
                		}
                		
                	}

                	
                	

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Payment <b>#'.$inid.'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                    $session->setFlashdata('pu_msg', 'Deleted!');
                    return redirect()->to(base_url('fees_and_payments/payments/'.$invoice_id));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                    return redirect()->to(base_url('fees_and_payments/payments/'.$invoice_id));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



    public function split_to_challan_installment($inid=''){
		$session=session();
	    $user=new Main_item_party_table();
	    $InvoiceModel= new InvoiceModel();
	    $InstallmentsModel= new InstallmentsModel();
	    $myid=session()->get('id');
	    
	    if (!empty($inid)) {
	    	if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();
		
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
		    		

		    		 
		    		
		    		$invoice_data=$InvoiceModel->where('id', $inid)->where('deleted',0)->first();

		    		$all_installments=$InstallmentsModel->where('invoice_id',$inid)->where('deleted',0)->findAll();

		    		$data=[
		    			'title'=>'Student installment| Aitsun ERP',
		    			'user'=>$usaerdata,
		    			'invoice_data'=>$invoice_data,
		    			'all_installments'=>$all_installments
		    		];

		    		$etype='';
	                if ($_GET) {
	                  if (isset($_GET['etype'])) {
	                      if (!empty($_GET['etype'])) {
	                          $etype=$_GET['etype'];
	                      }
	                  }
	                }
	                if ($etype=='ajaxex') {
	                  echo view('fees/split_installments',$data);
	                }else{

			    		echo view('header',$data);
			    		
			    		echo view('fees/split_installments');
			    		echo view('footer');
			    	}


		    	
		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}
	    }else{
    		return redirect()->to(base_url());
    	}
	    
	}



	public function add_installments()
	{
		$InvoiceModel = new InvoiceModel();
		$InstallmentsModel = new InstallmentsModel();
	 

		if ($this->request->getMethod() == 'post') {

			$myid=session()->get('id');


	    	$invoice_id=$this->request->getVar('invoice_id'); 
	    	$no_of_installments=12/$this->request->getVar('no_of_installments'); 
	    	$day_for_payment=$this->request->getVar('day_for_payment');  
	    	$due_amount=$this->request->getVar('due_amount');   

	    	$invoice_data=$InvoiceModel->where('id',$invoice_id)->first();

	    	if ($invoice_data) {
	    		$ida=['is_installment'=>1];
	    		$InvoiceModel->update($invoice_id,$ida);
	    	}

	    	$effectiveDate=now_time($myid);

	    	
	 
	    	
	   			$no=0;
	   			$fullamt=0;
	   			$numItems = count($this->request->getVar('installments'));
				$each_i = 0;
				foreach ($this->request->getVar('installments') as $j => $value) { 

					$iamt=aitsun_round($this->request->getVar('installments')[$j],get_setting(company($myid),'round_of_value'));
					$fullamt+=$iamt;
					if(++$each_i === $numItems) {
					    $iamt=$iamt-($fullamt-$due_amount);
					}

					$no++;

					echo '<br>';
					echo $iamt;

                    $inst_items = [ 
                        'fees_id'=>$invoice_data['fees_id'],
                        'invoice_id'=>$invoice_id,
                        'installment_name'=>$no,
                        'amount'=>aitsun_round($iamt,get_setting(company($myid),'round_of_value')),
                        'paid_status'=>'unpaid',  
                        'date'=>get_date_format($effectiveDate,'Y-m').'-'.$day_for_payment
                    ];

                    $InstallmentsModel->save($inst_items);

                    $date = new \DateTime($effectiveDate);
					$date->modify('+1 month'); // or you can use '-90 day' for deduct
					$effectiveDate = $date->format('Y-m-d h:i:s');

            	}
					
					
				$session = session();
				
				echo 1; 

		}else{
   			echo 0;
		}

	}

	public function delete_all_installments($invoice_id=''){
		if (!empty($invoice_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $InvoiceModel= new InvoiceModel();
		    $InstallmentsModel= new InstallmentsModel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {

		    	 

		    	 

		    	$paiidcheck='unpaid';
		   		foreach (installments_array($invoice_id) as $cins) {
		   			if ($cins['paid_status']=='paid') {
		   				$paiidcheck='paid';
		   			}
		   		}

		   		if ($paiidcheck=='unpaid') {

		   			$invoice_data=$InvoiceModel->where('id',$invoice_id)->first();

			    	
			    		$ida=[
			    			'is_installment'=>0
			    		];

			    		$InvoiceModel->update($invoice_data['id'],$ida);
			    	


		   			foreach (installments_array($invoice_id) as $ins) { 

	                    $inst_items = [    
	                        'deleted'=>1
	                    ];

	                    $InstallmentsModel->update($ins['id'],$inst_items); 

	            	}


	            	$session = session();
					// $session->setFlashdata('pu_msg', 'Installments deleted');
					// return redirect()->to(base_url('fees_and_payments/split_to_challan_installment/'.$invoice_id));
					echo  1;
		   		}else{
		   			// $session->setFlashdata('pu_er_msg', 'Sorry, cant delete installments because some installments are paid');
					// return redirect()->to(base_url('fees_and_payments/split_to_challan_installment/'.$invoice_id));
		   			echo  0;
		   		}
				
						
						
					
		    }else{
				// return redirect()->to(base_url());
			}
			
		}else{
			// return redirect()->to(base_url());
		}
	}

	public function get_payment_form($in_id=0)
		{

			$PaymentsModel= new PaymentsModel();
			$session=session();
		    $myid=session()->get('id');
		    $user=new Main_item_party_table();
		    $InvoiceModel= new InvoiceModel;
		    $StudentcategoryModel = new StudentcategoryModel();
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first(); 

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		if (usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}

		    		$invoice_data=$InvoiceModel->where('id',$in_id)->first();
		    		$payments=$PaymentsModel->where('deleted',0)->where('invoice_id',$invoice_data['id'])->findAll();
		    		
		    		$data=[
		    			'title'=>'Payments | Aitsun ERP',
		    			'user'=>$usaerdata,
		    			'invoice_id'=>$invoice_data,
		    			'allpayments'=>$payments,
		    			'data_count' => count($payments),
		    		];

		    		 
		    		echo view('fees/add_payment_form',$data); 

 
		    	
		    }else{
		   		echo "";
		   	}		
		}




		public function consession_report(){
        $session=session();

        if($session->has('isLoggedIn')){


                $UserModel=new Main_item_party_table;
                $InvoiceModel= new InvoiceModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 

                  
                 $acti=activated_year(company($myid));

             

                

                if ($_GET) {
                    if (!isset($_GET['etype'])) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (!empty($from) && empty($dto)) {
                            $InvoiceModel->where('date(invoice_date)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $InvoiceModel->where('date(invoice_date)',$dto);
                        }

                        if (empty($dto) && empty($from)) {
                             $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                        }
                        if (!empty($dto) && !empty($from)) {
                            $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                        }

                        if (!empty($_GET['status'])) {
                             $InvoiceModel->where('lead_status',$_GET('status'));
                        }
                    }
                }else{
                    // $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
                }


                $consession_data = $InvoiceModel->where('company_id',company($myid))->where('invoice_type','challan')->where('discount>',0)->where('deleted',0)->findAll();


                

                $data = [
                    'title' => 'Erudite ERP-Consession report',
                    'user'=>$user,
                    'consession_data'=>$consession_data,
                ];
                
                    echo view('header',$data);
                    echo view('fees/consession_report');
                    echo view('footer');
               
        
            }else{
                return redirect()->to(base_url('users/login'));
            }
    }





  public function fees_collected(){
        $session=session();

        if($session->has('isLoggedIn')){


                $UserModel=new Main_item_party_table;
                $PaymentsModel= new PaymentsModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 

                  
                 $acti=activated_year(company($myid));

             

                

                if ($_GET) {
                    if (!isset($_GET['etype'])) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('collected_by',$_GET['collected_user']);
                            }
                        }

                        if (!empty($from) && empty($dto)) {
                            $PaymentsModel->where('date(datetime)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $PaymentsModel->where('date(datetime)',$dto);
                        }

                        
                        if (!empty($dto) && !empty($from)) {
                            $PaymentsModel->where("date(datetime) BETWEEN '$from' AND '$dto'");
                        }
                        

                        if (!empty($_GET['status'])) {
                             $PaymentsModel->where('lead_status',$_GET('status'));
                        }
                    }
                    
                }else{
                    // $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                }


                $fees_collected_data = $PaymentsModel->where('company_id',company($myid))->where('bill_type','sales')->where('fees_id>',0)->where('deleted',0)->findAll();

                $debit_sum=0;
                $credit_sum=0;

                foreach ($fees_collected_data as $sv) {

                    if ($sv['bill_type']=='expense' || $sv['bill_type']=='purchase' || $sv['bill_type']=='sales_return'){
                        $debit_sum+=$sv['amount'];
                    }elseif ($sv['bill_type']=='receipt' || $sv['bill_type']=='sales' || $sv['bill_type']=='purchase_return'){
                        $credit_sum+=$sv['amount'];
                    }
                    
                }

                $data = [
                    'title' => 'Erudite ERP-Fees collected',
                    'user'=>$user,
                    'fees_collected_data'=>$fees_collected_data,
                    'debit_sum'=>$debit_sum,
                    'credit_sum'=>$credit_sum,
                ];

                
                    echo view('header',$data);
                    echo view('fees/fees_collected',);
                    echo view('footer');
                        
            }else{
                return redirect()->to(base_url('users/login'));
            }
    }




   public function group_wise_fees_collected(){
        $session=session();

        if($session->has('isLoggedIn')){


                $UserModel=new Main_item_party_table;
                $PaymentsModel= new PaymentsModel;
                $FeesModel= new FeesModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

               

                if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 

                  
                 $acti=activated_year(company($myid));

             
                 $lim='1';
                
                 $all_fees_groups=$FeesModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0);

                if ($_GET) {
                    if (isset($_GET['fees'])) { 
                        if (!empty($_GET['fees'])) {
                            $all_fees_groups->where('id',$_GET['fees']);
                            $lim='';
                        }  
                    }

                    if (isset($_GET['type'])) { 
                        if (!empty($_GET['type'])) {
                            if ($_GET['type']==1) {
                                $all_fees_groups->where('fees_type',$_GET['type']);
                            }elseif ($_GET['type']==0) {
                                $all_fees_groups->where('fees_type',$_GET['type']);
                            }

                            $lim='';
                            
                        }  
                    }
                    
                }else{

                }  

              
                $alfee=$all_fees_groups->orderBy('id','DESC')->findAll();
                
                

                $debit_sum=0;
                $credit_sum=0; 

                $data = [
                    'title' => 'Erudite ERP-Group wise fees collected',
                    'user'=>$user, 
                    'all_fees_groups'=>$alfee,
                  
                ];

                
                    echo view('header',$data);
                    echo view('fees/group_wise_fees_collected');
                    echo view('footer');
               
            }else{
                return redirect()->to(base_url('users/login'));
            }
    }






   public function fees_wise_outstanding($account='sales'){
        $session=session();

            if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $InvoiceModel= new InvoiceModel;

                if (!empty($account)) {
                        
                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                     if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                    if (usertype($myid)=='customer') {
                       return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));


                    if (!$_GET) {
                    }else {


                        if (isset($_GET['customer'])) {
                            if (!empty($_GET['customer'])) {
                                $InvoiceModel->where('customer',$_GET['customer']);
                            }
                        }

                        if (isset($_GET['customer1'])) {
                            if (!empty($_GET['customer1'])) {
                                $InvoiceModel->where('customer',$_GET['customer1']);
                            }
                        }

                        if (isset($_GET['fees'])) {
                            if (!empty($_GET['fees'])) {
                                $InvoiceModel->where('fees_id',$_GET['fees']);
                            }
                        }

                        if (isset($_GET['class'])) {
                            if (!empty($_GET['class'])) {
                                $ic=0;
                                $InvoiceModel->groupStart();
                                foreach (students_array_of_class(company($myid),$_GET['class']) as $std){
                                    $ic++;
                                    if ($ic>1) {
                                        $InvoiceModel->orWhere('customer',$std['student_id']);
                                    }else{
                                        $InvoiceModel->where('customer',$std['student_id']);
                                    }
                                    
                                }
                                $InvoiceModel->groupEnd();
                                
                            }
                        }


                     
                    }
                    
                    
                    if ($account=='sales') {
                        $InvoiceModel->groupStart();
                        // $InvoiceModel->where('invoice_type','sales');
                        $InvoiceModel->orWhere('invoice_type','challan');
                        $InvoiceModel->groupEnd();
                    }else{
                        // $InvoiceModel->where('invoice_type','purchase');
                    }

                    $all_invoices=$InvoiceModel->where('company_id',company($myid))->where('paid_status','unpaid')->orderBy('fees_id','ASC')->where('deleted',0)->findAll();


                    $amounttt=0;
                    $due_amounttt=0;

                    foreach ($all_invoices as $sv) {
                        $amounttt+=$sv['total'];
                        $due_amounttt+=$sv['due_amount'];
                    }


                    

                    $data = [
                        'title' => 'Aitsun ERP - Credit Statement',
                        'user'=>$user,
                        'all_invoices'=>$all_invoices,
                        'total_amount'=>$amounttt,
                        'total_due_amount'=>$due_amounttt,
                        'acccount'=>$account
                    ];



                    echo view('header',$data);
                    echo view('fees/fees_wise_outstanding', $data);
                    echo view('footer');
                }else{
                   return redirect()->to(base_url());
                }

                }else{
                   return redirect()->to(base_url('users/login'));
                }
    }


    public function add_challan_settings($invoice_id=''){

    	$session=session();

        if($session->has('isLoggedIn')){

    			$myid=session()->get('id');
          $CompanySettings2= new CompanySettings2;

          $UserModel = new Main_item_party_table;
          $img = $this->request->getFile('sign_logo');
         $pay_slip_img = $this->request->getFile('payslip_signature');
         $qr_code = $this->request->getFile('qr_code');


         if (!empty(trim($img))) {

            if($_FILES['sign_logo']['size'] > 500000) { //10 MB (size is also in bytes)
                $filename = $this->request->getVar('old_sign');
              } else {
 
                $filename = $img->getRandomName();
                $mimetype=$img->getClientMimeType();
                  $img->move('public/uploads/signature',$filename);

                  }  

          }else{ 
            $filename=$this->request->getVar('old_sign');
          }

           if (!empty(trim($pay_slip_img))) {

            if($_FILES['payslip_signature']['size'] > 500000) { //10 MB (size is also in bytes)
                $pay_filename = $this->request->getVar('old_payslip_signature');
              } else {
 
                $pay_filename = $pay_slip_img->getRandomName();
                $mimetype=$pay_slip_img->getClientMimeType();
                  $pay_slip_img->move('public/uploads/signature',$pay_filename);

                  }  

          }else{ 
            $pay_filename=$this->request->getVar('old_payslip_signature');
          }


          if (!empty(trim($qr_code))) { 
            if($_FILES['qr_code']['size'] > 500000) { //10 MB (size is also in bytes)
              $qr_file=$this->request->getVar('upi');
            } else { 
              $qr_file = $qr_code->getRandomName();
              $mimetype=$qr_code->getClientMimeType();
              $qr_code->move('public/uploads/signature',$qr_file); 
            }   
          }else{ 
            $qr_file=$this->request->getVar('upi');
          }


        	if (isset($_POST['add_challan_settings'])) {
        		$ac_data = [
                'challan_page_size'=>strip_tags($this->request->getVar('challan_page_size')),
                'challan_orientation'=>strip_tags($this->request->getVar('challan_orientation')),
                'footer_title'=>$this->request->getVar('footer_title'),
		            'description'=>$this->request->getVar('description'),
		            'bank'=>$this->request->getVar('bank'),
		            'upi'=>$qr_file,
		            'sign_logo'=>$filename,
		            'payslip_signature'=>$pay_filename,           
                
            ];

            $update_user=$CompanySettings2->update(get_setting2(company($myid),'id'),$ac_data);
		        if ($update_user){
		        ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> Challan settings updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                     session()->setFlashdata('pu_msg', 'Saved!');
                     return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
                }else{
                    session()->setFlashdata('pu_er_msg', 'Failed to save!');
                   return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
                }
            }

      
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }



    public function transport_report(){
        $session=session();

            if($session->has('isLoggedIn')){

                
                $UserModel=new Main_item_party_table;
                $InvoiceModel= new InvoiceModel;
 
                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                     if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 

                    if (usertype($myid)=='customer') {
                       return redirect()->to(base_url('customer_dashboard'));
                    }

                    $acti=activated_year(company($myid));


                    if (!$_GET) {
                    }else {


                       if (isset($_GET['driver'])) {
                            if (!empty($_GET['driver'])) {
                                $InvoiceModel->where('driver_id',$_GET['driver']);
                            }
                        } 

                        if (isset($_GET['vehicle'])) {
                            if (!empty($_GET['vehicle'])) {
                                $InvoiceModel->where('vehicle_id',$_GET['vehicle']);
                            }
                        } 


                        if (isset($_GET['class'])) {
                            if (!empty($_GET['class'])) {
                                $ic=0;
                                $InvoiceModel->groupStart();
                                foreach (students_array_of_class(company($myid),$_GET['class']) as $std){
                                    $ic++;
                                    if ($ic>1) {
                                        $InvoiceModel->orWhere('customer',$std['student_id']);
                                    }else{
                                        $InvoiceModel->where('customer',$std['student_id']);
                                    }
                                    
                                }
                                $InvoiceModel->groupEnd();
                                
                            }
                        }
                     
                    }

                    
                     $InvoiceModel->where('invoice_type','challan');
                    

                    
                    $all_invoices=$InvoiceModel->where('company_id',company($myid))->where('paid_status','unpaid')->where('fees_type',1)->orderBy('vehicle_id','ASC')->where('deleted',0)->findAll();


                    $amounttt=0;
                    $due_amounttt=0;


                    foreach ($all_invoices as $sv) {
                        $amounttt+=$sv['total'];
                        $due_amounttt+=$sv['due_amount'];
                    }


                    

                    $data = [
                        'title' => 'Erudite ERP - Transport Report',
                        'user'=>$user,
                        'all_invoices'=>$all_invoices,
                        'total_amount'=>$amounttt,
                        'total_due_amount'=>$due_amounttt,
                        

                    ];

                        echo view('header',$data);
                        echo view('fees/transport_report', $data);
                        echo view('footer');
                   
                }else{
                   return redirect()->to(base_url('users/login'));
                }
    }



    public function collected_transport_report(){
        $session=session();

        if($session->has('isLoggedIn')){


                $UserModel=new Main_item_party_table;
                $PaymentsModel= new PaymentsModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 

                  
                 $acti=activated_year(company($myid));

             

                

                


                $PaymentsModel->select('payments.*, fees_table.fees_name,fees_table.fees_type,invoices.vehicle_id,vehicle_details.vehicle_name');
                $PaymentsModel->join('fees_table', 'fees_table.id = payments.fees_id', 'left');
                $PaymentsModel->join('invoices', 'invoices.id = payments.invoice_id', 'left');
                $PaymentsModel->join('vehicle_details', 'vehicle_details.id = invoices.vehicle_id', 'left');
                $PaymentsModel->where('payments.company_id',company($myid));

                if ($_GET) {
                    if (!isset($_GET['etype'])) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('payments.collected_by',$_GET['collected_user']);
                            }
                        }

                        
                        if (isset($_GET['vehicle'])) {
                            if (!empty($_GET['vehicle'])) {
                                $PaymentsModel->where('invoices.vehicle_id',$_GET['vehicle']);
                            }
                        }

                        if (!empty($from) && empty($dto)) {
                            $PaymentsModel->where('date(payments.datetime)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $PaymentsModel->where('date(payments.datetime)',$dto);
                        }

                        
                        if (!empty($dto) && !empty($from)) {
                            $PaymentsModel->where("date(payments.datetime) BETWEEN '$from' AND '$dto'");
                        }
                        

                        if (!empty($_GET['status'])) {
                             $PaymentsModel->where('payments.lead_status',$_GET('status'));
                        }


                    }
                    
                }else{
                    // $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                }

                $PaymentsModel->where('payments.bill_type','sales');
                $PaymentsModel->where('fees_table.fees_type',1);
                $PaymentsModel->where('payments.fees_id>',0);
                $PaymentsModel->where('payments.deleted',0);


                $fees_collected_data = $PaymentsModel->findAll();

                $debit_sum=0;
                $credit_sum=0;
 

                $data = [
                    'title' => 'Erudite ERP- Transport Fees collected',
                    'user'=>$user,
                    'fees_collected_data'=>$fees_collected_data, 
                ];

                
                    echo view('header',$data);
                    echo view('fees/collected_transport_report',);
                    echo view('footer');
                        
            }else{
                return redirect()->to(base_url('users/login'));
            }
    }




    public function get_all_fees_list($search_text='',$climit=0,$invoice_id){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $ProductsModel=new Main_item_party_table;
                $InvoiceModel=new InvoiceModel;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                

               if ($search_text!='all') {
                    $ProductsModel->like('product_name',$search_text,'both');
                }
                
                $ProductsModel->where('company_id', company($myid))->where('product_method','service')->where('main_type','product')->where('deleted',0);

                if ($climit>0) {
                    $products_optional_array=$ProductsModel->findAll($climit);
                }else{
                    $products_optional_array=$ProductsModel->findAll();
                }
                

                $lis='';
                 
                $sc=0;
                foreach ($products_optional_array as $li) {
                    $sc++;
                   

                   $fees_of_student=fees_of_student(company($myid),get_student_data(company($myid),invoice_data($invoice_id,'customer'),'category'),current_class_of_student(company($myid),invoice_data($invoice_id,'customer')),$li['id']);

                    if (is_exist_in_invoice_items($invoice_id,$li['id'])==true)
                    {
	                   	$checked_value='1';
	                   	$checked="checked";
	                   	$fees_of_student=get_exist_in_invoice_items_data($invoice_id,$li['id'],'amount');
	               		}else{
	                 	 	$checked_value='0';
	                 	 	$checked='';
	                 	}

                    $lis.='
                    	<tr>
                        <td class="px-2 py-1">
                            <div class="form-group mb-1 p-0 col-md-12 d-flex justify-content-start"> 

                                <input type="hidden" name="product[]" value="'.$li['product_name'].'" >
                                <input type="hidden" name="product_id[]" value="'.$li['id'].'" > 

                                <input type="checkbox" id="checkbox'.$li['id'].'" class="me-2 checkingrollbox checkBoxmrngAll add_and_remove_fees" '.$checked.' data-amount="'.$fees_of_student.'">

                                <input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="itemchecked[]" type="hidden"  value="'.$checked_value.'" '.$checked.'>
                                <label class="m-0 cursor-pointer w-100" for="checkbox'.$li['id'].'">'.$li['product_name'].' ('.currency_symbol(company($myid)).aitsun_round($fees_of_student,get_setting(company($myid),'round_of_value')).')</label> 

                            </div> 
                        </td>
                    </tr>  
                    ';
                }
                if ($sc<1) {
                    $lis.='<tr class="text-center"><td>No result</td></tr>';
                }
                

                echo $lis;

            }
        } 
    }



    public function remove_signature($cid="",$invoice_id){
    $CompanySettings2 = new CompanySettings2();

    $session=session();

    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );

        $deledata=[
            'sign_logo'=>'',
        ];

    $d_mg=$CompanySettings2->update($cid,$deledata);

    if ($d_mg) {

        $session->setFlashdata('pu_msg', 'Deleted!');
        return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
    }else{
        $session->setFlashdata('pu_er_msg', 'Failed to delete!');
        return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
    }
}



public function add_reason($cid=""){
      $session=session();
      $PaymentsModel=new PaymentsModel;

      if ($this->request->getMethod('post')) {
      
          $clientdata=[
              
              'delete_reason'=>$this->request->getVar('delete_reason'),
             
          ];
    

          if ($PaymentsModel->update($cid,$clientdata)) {
            echo 1;
             
          }else{
             echo 0;
          }
  
      }
  }
  

public function remove_pay_slip_signature($cid="",$invoice_id){
    $CompanySettings2 = new CompanySettings2();

    $session=session();

    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );

        $deledata=[
            'payslip_signature'=>'',
        ];

    $d_mg=$CompanySettings2->update($cid,$deledata);

    if ($d_mg) {

        $session->setFlashdata('pu_msg', 'Deleted!');
        return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
    }else{
        $session->setFlashdata('pu_er_msg', 'Failed to delete!');
        return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
    }
}

public function remove_qr_code($cid="",$invoice_id){
    $CompanySettings2 = new CompanySettings2();

    $session=session();

    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );

        $deledata=[
            'upi'=>'',
        ];

    $d_mg=$CompanySettings2->update($cid,$deledata);

    if ($d_mg) {

        $session->setFlashdata('pu_msg', 'Deleted!');
        return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
    }else{
        $session->setFlashdata('pu_er_msg', 'Failed to delete!');
        return redirect()->to(base_url('fees_and_payments/view_challan/'.$invoice_id));
    }
}


}