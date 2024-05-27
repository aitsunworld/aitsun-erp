<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\PermissionModel;
use App\Models\Companies;



class User_master extends BaseController
{
	public function index()
	{
		$session=session(); 
	    $myid=session()->get('id');
	    $Companies = new Companies;
	    $Main_item_party_table=new Main_item_party_table; 

	   $pager = \Config\Services::pager();

	    $results_per_page = 12; 
	    
	    if ($session->has('isLoggedIn')) {
	    	

	    	
 

	    
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		// if (user_data(session()->get('id'),'activated_financial_year')<1) {
                //             return redirect()->to(base_url('settings/financial_years'));
                //         }


                 

	    		if ($_GET) {
		            if (isset($_GET['serachname'])) {
		                if (!empty($_GET['serachname'])) {
		                    $Main_item_party_table->like('display_name', $_GET['serachname'], 'both'); 
		                }
		            }
		            if (isset($_GET['usertype'])) {
		                if (!empty($_GET['usertype'])) {
		                    $Main_item_party_table->like('u_type', $_GET['usertype'], 'both'); 
		                }
		            }  
		        }


	    		

	    		$get_branches=$Companies->where('parent_company', main_company_id($myid))->findAll();


	    		$Main_item_party_table->where('main_compani_id',main_company_id($myid));
	    		$Main_item_party_table->where('u_type!=', 'vendor');
	    		$Main_item_party_table->where('u_type!=', 'customer');
	    		$Main_item_party_table->where('u_type!=', 'student');
	    		$Main_item_party_table->where("main_type", 'user');
	    		$Main_item_party_table->where("deleted", 0);

	    		$company_members_array = $Main_item_party_table->orderBy('id','DESC')->paginate(25);

	    		$data=[
	    			'title'=>'User Master | Aitsun ERP',
	    			'user'=>$Main_item_party_table->where('id', session()->get('id'))->first(),
	    			'company_members_array'=>$company_members_array,
	    			'pager' =>$Main_item_party_table->pager,
	    			'branches'=>$get_branches

	    		];
	    		
		    		echo view('header',$data);
		    		echo view('user_master/staffs');
		    		echo view('footer');
		    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function add_staff($org=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new Main_item_party_table(); 
				


				$emailphone=strip_tags($this->request->getVar('staff_email'));

				 $f_org=$org;

		            if (strip_tags($this->request->getVar('u_type'))=='admin') {
		            	$f_org=$org;
		            }

				if (!empty($_FILES['user_img']['name'])) {

					if($_FILES['user_img']['size'] > 500000) { //10 MB (size is also in bytes)
				        
				    } else {
		            $target_dir = "public/uploads/users/";
		            $target_file = $target_dir . time().basename($_FILES["user_img"]["name"]);
		            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		            $imgName = time().basename($_FILES["user_img"]["name"]);
		            move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file);

		           
		            

				$newData = [
					  'profile_pic'=>$imgName,
					  'display_name' => strip_tags($this->request->getVar('staff_name')),
			          'email' => $emailphone,
			          'main_type'=>'user',
			          'password' => strip_tags($this->request->getVar('password')),
			          'phone' => strip_tags($this->request->getVar('contact_number')),
			          'company_id' => $f_org,
			          'main_compani_id'=>main_company_id($myid),
			          'u_type' => strip_tags($this->request->getVar('u_type')),
			          'category' => strip_tags($this->request->getVar('category')),
			          'subcategory' => strip_tags($this->request->getVar('subcategory')),
			          'opening_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
			          'closing_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
			           'billing_address' => strip_tags($this->request->getVar('address')),
						          'phone_2' => strip_tags($this->request->getVar('phone2')),
						          'adhar' => strip_tags($this->request->getVar('aadhar_no')),
						          'bank_name' => strip_tags($this->request->getVar('bank_name')),
						          'account_number' => strip_tags($this->request->getVar('account_number')),
						          'ifsc' => strip_tags($this->request->getVar('ifsc')),
						          'designation' => strip_tags($this->request->getVar('designation')),
						          'saved_as' => strip_tags($this->request->getVar('staff_additional')),
	                    
	                            'password_2' => strip_tags($this->request->getVar('password')),
								'main_subject' => strip_tags($this->request->getVar('main_subject')),
								'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
								 'gender' => strip_tags($this->request->getVar('gender')),
								 'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
								'stdage' => strip_tags($this->request->getVar('age')),
								'religion' => strip_tags($this->request->getVar('religion')),
								'nature_of_appointment' => strip_tags($this->request->getVar('nature_of_appointment')),
								'qualification' => strip_tags($this->request->getVar('qualification')),
								'blood_group' => strip_tags($this->request->getVar('blood_gp')),




				];
			}

				}else{


					$newData = [
					  'display_name' => strip_tags($this->request->getVar('staff_name')),
			          'email' => $emailphone,
			          'main_type'=>'user',
			          'password' => strip_tags($this->request->getVar('password')),
			          'phone' => strip_tags($this->request->getVar('contact_number')),
			          'company_id' => $f_org,
			          'main_compani_id'=>main_company_id($myid),
			          'u_type' => strip_tags($this->request->getVar('u_type')),
			          'category' => strip_tags($this->request->getVar('category')),
			          'subcategory' => strip_tags($this->request->getVar('subcategory')),
			          'opening_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
			          'closing_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
			           'billing_address' => strip_tags($this->request->getVar('address')),
						          'phone_2' => strip_tags($this->request->getVar('phone2')),
						          'adhar' => strip_tags($this->request->getVar('aadhar_no')),
						          'bank_name' => strip_tags($this->request->getVar('bank_name')),
						          'account_number' => strip_tags($this->request->getVar('account_number')),
						          'ifsc' => strip_tags($this->request->getVar('ifsc')),
						          'designation' => strip_tags($this->request->getVar('designation')),
						          'saved_as' => strip_tags($this->request->getVar('staff_additional')),
	                    
	                            'password_2' => strip_tags($this->request->getVar('password')),
								'main_subject' => strip_tags($this->request->getVar('main_subject')),
								'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
								 'gender' => strip_tags($this->request->getVar('gender')),
								 'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
								'stdage' => strip_tags($this->request->getVar('age')),
								'religion' => strip_tags($this->request->getVar('religion')),
								'nature_of_appointment' => strip_tags($this->request->getVar('nature_of_appointment')),
								'qualification' => strip_tags($this->request->getVar('qualification')),
								'blood_group' => strip_tags($this->request->getVar('blood_gp')),
				];
			}


				$checkemail=$model->where('email',$emailphone)->where('deleted',0)->first();

				if ($_FILES['user_img']['size'] < 500000) {
					if (!$checkemail) {
						$maxuser=user_limit(company($myid));
						$current_user=total_user(company($myid));
						
						if ($current_user>=$maxuser) {
							echo 'failed';
						}else{
							$model->save($newData);
							$insidd=$model->insertID();
 
						 

                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New staff <b>'.user_name($insidd).'</b> is joined.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////

							echo 'passed';
						}
					}else{
						echo 'email_exist';
					}
				}else{
					echo 'big_file';
				}
				


				

			}
		
	}



	public function update_staff($tech=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$model = new Main_item_party_table(); 

				$myid=session()->get('id');

				$session=session();
					$img = $this->request->getFile('user_img');
					$password = strip_tags($this->request->getVar('password'));
					$emailphone=strip_tags($this->request->getVar('staff_email'));

				if (!empty(trim($img))) {
					if($_FILES['user_img']['size'] > 500000) { //10 MB (size is also in bytes)
				        $filename = strip_tags($this->request->getVar('old_profile_pic'));
					    } else {
					    	$filename = $img->getRandomName();
							$mimetype=$img->getClientMimeType();
				            $img->move('public/uploads/users/',$filename);
					    }
						

			        }else{


			        $filename = strip_tags($this->request->getVar('old_profile_pic'));
			    }


				 $op_balance=strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value'));

		        $current_closing_balance=floatval(strip_tags($this->request->getVar('current_closing_balance')));
		        $current_opening_balance=floatval(strip_tags($this->request->getVar('current_opening_balance')));


		        $closing_balance=($current_closing_balance-$current_opening_balance) + floatval($op_balance);

				 if (!empty(trim($password))) {

					$newData = [
						'profile_pic'=>$filename,
			            'display_name' => strip_tags($this->request->getVar('staff_name')),
			            'email' =>$emailphone,
			            'password' =>$password,
			            'u_type' => strip_tags($this->request->getVar('u_type')),
			            'phone' => strip_tags($this->request->getVar('contact_number')),
			            'category' => strip_tags($this->request->getVar('category')),
			            'subcategory' => strip_tags($this->request->getVar('subcategory')),
			            'edit_effected'=>0,
			            'opening_balance'=>$op_balance,
            			'closing_balance'=>$closing_balance,
            			'billing_address' => strip_tags($this->request->getVar('address')),
			            'phone_2' => strip_tags($this->request->getVar('phone2')),
			            'adhar' => strip_tags($this->request->getVar('aadhar_no')),
			            'bank_name' => strip_tags($this->request->getVar('bank_name')),
			            'account_number' => strip_tags($this->request->getVar('account_number')),
			            'ifsc' => strip_tags($this->request->getVar('ifsc')),
			            'designation' => strip_tags($this->request->getVar('designation')),
			            'saved_as' => strip_tags($this->request->getVar('staff_additional')),
						'password_2' =>$password,
						'main_subject' => strip_tags($this->request->getVar('main_subject')),
						'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
						'gender' => strip_tags($this->request->getVar('gender')),
						 'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
						'stdage' => strip_tags($this->request->getVar('age')),
						'religion' => strip_tags($this->request->getVar('religion')),
						'nature_of_appointment' => strip_tags($this->request->getVar('nature_of_appointment')),
						'qualification' => strip_tags($this->request->getVar('qualification')),
						'blood_group' => strip_tags($this->request->getVar('blood_gp')),

					];
				}else{
					$newData = [
						'profile_pic'=>$filename,
						'display_name' => strip_tags($this->request->getVar('staff_name')),
						'email' =>$emailphone,
						'u_type' => strip_tags($this->request->getVar('u_type')),
			            'phone' => strip_tags($this->request->getVar('contact_number')),
			            'category' => strip_tags($this->request->getVar('category')),
			            'subcategory' => strip_tags($this->request->getVar('subcategory')),
			             'opening_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
			            'edit_effected'=>0,
			            'opening_balance'=>$op_balance,
            			'closing_balance'=>$closing_balance,
            			'billing_address' => strip_tags($this->request->getVar('address')),
				            'phone_2' => strip_tags($this->request->getVar('phone2')),
				            'adhar' => strip_tags($this->request->getVar('aadhar_no')),
				            'bank_name' => strip_tags($this->request->getVar('bank_name')),
				            'account_number' => strip_tags($this->request->getVar('account_number')),
				            'ifsc' => strip_tags($this->request->getVar('ifsc')),
				            'designation' => strip_tags($this->request->getVar('designation')),
				            'saved_as' => strip_tags($this->request->getVar('staff_additional')),
							'password_2' =>$password,
							'main_subject' => strip_tags($this->request->getVar('main_subject')),
							'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
							'gender' => strip_tags($this->request->getVar('gender')),
							 'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
							'stdage' => strip_tags($this->request->getVar('age')),
							'religion' => strip_tags($this->request->getVar('religion')),
							'nature_of_appointment' => strip_tags($this->request->getVar('nature_of_appointment')),
							'qualification' => strip_tags($this->request->getVar('qualification')),
							'blood_group' => strip_tags($this->request->getVar('blood_gp')),

					];
				}

				$myem=$model->where('id',$tech)->first();

				if ($_FILES['user_img']['size'] < 500000) {


					if ($myem['email']==$emailphone) {
						$model->update($tech,$newData);
 

						 
                        ////////////////////////CREATE ACTIVITY LOG//////////////
                        $log_data=[
                            'user_id'=>$myid,
                            'action'=>'Staff <b>'.user_name($tech).'</b> details is updated.',
                            'ip'=>get_client_ip(),
                            'mac'=>GetMAC(),
                            'created_at'=>now_time($myid),
                            'updated_at'=>now_time($myid),
                            'company_id'=>company($myid),
                        ];

                        add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////


					}else{
						$checkemail=$model->where('email',$emailphone)->where('deleted',0)->first();

						if (!$checkemail) {
							$model->update($tech,$newData);

							

							 
                                ////////////////////////CREATE ACTIVITY LOG//////////////
		                        $log_data=[
		                            'user_id'=>$myid,
		                            'action'=>'Staff <b>'.user_name($tech).'</b> details is updated.',
		                            'ip'=>get_client_ip(),
		                            'mac'=>GetMAC(),
		                            'created_at'=>now_time($myid),
		                            'updated_at'=>now_time($myid),
		                            'company_id'=>company($myid),
		                        ];

		                        add_log($log_data);
		                        ////////////////////////END ACTIVITY LOG/////////////////
						}else{
							echo 'email_exist';
						}
					}
					}else{
				echo 'big_file';
				}

				
			}
		

	}


	public function delete_staff($tid=0)
	{
		$model = new Main_item_party_table();
		$myid=session()->get('id');
		

		if ($this->request->getMethod() == 'post') {
				$model->find($tid);

				$deledata=[
                    'deleted'=>1,
                    'edit_effected'=>0
                ];

				$model->update($tid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'Staff <b>'.user_name($tid).'</b> is deleted.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////

				
		}else{
   			return redirect()->to(base_url('user_master'));
		}

	}





	public function user_permission($userid=""){
		
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$session=session();
			$PermissionModel= new PermissionModel();
				
			
			if (isset($_POST['manage_parties'])) {
               $manage_parties=$_POST['manage_parties'];
           }else{
            $manage_parties=0;
           }


           if (isset($_POST['manage_sales'])) {
               $manage_sales=$_POST['manage_sales'];
           }else{
            $manage_sales=0;
           }


           if (isset($_POST['manage_sales_quotation'])) {
               $manage_sales_quotation=$_POST['manage_sales_quotation'];
           }else{
            $manage_sales_quotation=0;
           }


           if (isset($_POST['manage_sales_order'])) {
               $manage_sales_order=$_POST['manage_sales_order'];
           }else{
            $manage_sales_order=0;
           }

           if (isset($_POST['manage_sales_return'])) {
               $manage_sales_return=$_POST['manage_sales_return'];
           }else{
            $manage_sales_return=0;
           }


           if (isset($_POST['manage_sales_delivery_note'])) {
               $manage_sales_delivery_note=$_POST['manage_sales_delivery_note'];
           }else{
            $manage_sales_delivery_note=0;
           }


           if (isset($_POST['manage_purc'])) {
               $manage_purchase=$_POST['manage_purc'];
           }else{
            $manage_purchase=0;
           }
           if (isset($_POST['manage_purchase_order'])) {
               $manage_purchase_order=$_POST['manage_purchase_order'];
           }else{
            $manage_purchase_order=0;
           }

           if (isset($_POST['manage_purchase_return'])) {
               $manage_purchase_return=$_POST['manage_purchase_return'];
           }else{
            $manage_purchase_return=0;
           }

           if (isset($_POST['manage_purchase_delivery_note'])) {
               $manage_purchase_delivery_note=$_POST['manage_purchase_delivery_note'];
           }else{
            $manage_purchase_delivery_note=0;
           }

           if (isset($_POST['manage_cash_ex'])) {
               $manage_cash=$_POST['manage_cash_ex'];
           }else{
            $manage_cash=0;
           }

           if (isset($_POST['manage_pro_ser'])) {
               $manage_product=$_POST['manage_pro_ser'];
           }else{
            $manage_product=0;
           }

           if (isset($_POST['manage_reports'])) {
               $manage_reports=$_POST['manage_reports'];
           }else{
            $manage_reports=0;
           }

           if (isset($_POST['manage_orders'])) {
               $manage_orders=$_POST['manage_orders'];
           }else{
            $manage_orders=0;
           }

           if (isset($_POST['manage_appearance'])) {
               $manage_appearance=$_POST['manage_appearance'];
           }else{
            $manage_appearance=0;
           }


           if (isset($_POST['manage_trash'])) {
               $manage_trash=$_POST['manage_trash'];
           }else{
            $manage_trash=0;
           }

           if (isset($_POST['manage_product_requestes'])) {
               $manage_pro_requests=$_POST['manage_product_requestes'];
           }else{
            $manage_pro_requests=0;
           }

           if (isset($_POST['manage_settings'])) {
               $manage_settings=$_POST['manage_settings'];
           }else{
            $manage_settings=0;
           }

           if (isset($_POST['manage_aitsun_keys'])) {
               $manage_aitsun_keys=$_POST['manage_aitsun_keys'];
           }else{
            $manage_aitsun_keys=0;
           }


           if (isset($_POST['manage_enquires'])) {
               $manage_enquires=$_POST['manage_enquires'];
           }else{
            $manage_enquires=0;
           }


           if (isset($_POST['manage_crm'])) {
               $manage_crm=$_POST['manage_crm'];
           }else{
            $manage_crm=0;
           }

           if (isset($_POST['manage_document_renew'])) {
               $manage_document_renew=$_POST['manage_document_renew'];
           }else{
            $manage_document_renew=0;
           }

           if (isset($_POST['manage_work_updates'])) {
               $manage_work_updates=$_POST['manage_work_updates'];
           }else{
            $manage_work_updates=0;
           }

           if (isset($_POST['manage_hr'])) {
               $manage_hr=$_POST['manage_hr'];
           }else{
            $manage_hr=0;
           }

           if (isset($_POST['manage_invoice_submit'])) {
               $manage_invoice_submit=$_POST['manage_invoice_submit'];
           }else{
            $manage_invoice_submit=0;
           }

           if (isset($_POST['manage_financial_year'])) {
               $manage_financial_year=$_POST['manage_financial_year'];
           }else{
            $manage_financial_year=0;
           }

           if (isset($_POST['manage_sms_config'])) {
               $manage_sms_config=$_POST['manage_sms_config'];
           }else{
            $manage_sms_config=0;
           }

           if (isset($_POST['manage_account_setting'])) {
               $manage_account_setting=$_POST['manage_account_setting'];
           }else{
            $manage_account_setting=0;
           }

           if (isset($_POST['stock_management'])) {
               $stock_management=$_POST['stock_management'];
           }else{
            $stock_management=0;
           }

           if (isset($_POST['manage_library'])) {
               $manage_library=$_POST['manage_library'];
           }else{
            $manage_library=0;
           }

           if (isset($_POST['manage_sports'])) {
               $manage_sports=$_POST['manage_sports'];
           }else{
            $manage_sports=0;
           }

           if (isset($_POST['manage_eccc'])) {
               $manage_eccc=$_POST['manage_eccc'];
           }else{
            $manage_eccc=0;
           }

           if (isset($_POST['manage_messaging'])) {
               $manage_messaging=$_POST['manage_messaging'];
           }else{
            $manage_messaging=0;
           }

           if (isset($_POST['manage_timetable'])) {
               $manage_timetable=$_POST['manage_timetable'];
           }else{
            $manage_timetable=0;
           }

           if (isset($_POST['manage_notices'])) {
               $manage_notices=$_POST['manage_notices'];
           }else{
            $manage_notices=0;
           }

           if (isset($_POST['manage_health'])) {
               $manage_health=$_POST['manage_health'];
           }else{
            $manage_health=0;
           }


           if (isset($_POST['manage_fees'])) {
               $manage_fees=$_POST['manage_fees'];
           }else{
            $manage_fees=0;
           }


           if (isset($_POST['manage_academic_year'])) {
               $manage_academic_year=$_POST['manage_academic_year'];
           }else{
            $manage_academic_year=0;
           }

            if (isset($_POST['delete_receipts_and_payments'])) {
               $delete_receipts_and_payments=$_POST['delete_receipts_and_payments'];
           }else{
            $delete_receipts_and_payments=0;
           }

           

           


           
          
          
           $check_per=$PermissionModel->where('user',$userid)->where('company_id',company($myid))->first();
           if (!$check_per) {
               $insper = [
                 'user'=>$userid,
                 'company_id'=>company($myid),
                 'manage_parties'=>$manage_parties,
                 'manage_sales'=>$manage_sales,
                 'manage_sales_quotation'=>$manage_sales_quotation,
                 'manage_sales_order'=>$manage_sales_order,
                 'manage_sales_return'=>$manage_sales_return,
                 'manage_sales_delivery_note'=>$manage_sales_delivery_note,
                 'manage_purchase'=>$manage_purchase,
                 'manage_purchase_order'=>$manage_purchase_order,
                 'manage_purchase_return'=>$manage_purchase_return,
                 'manage_purchase_delivery_note'=>$manage_purchase_delivery_note,
                 'manage_cash_ex'=>$manage_cash,
                 'manage_pro_ser'=>$manage_product,
                 'manage_reports'=>$manage_reports,
                 'manage_orders'=>$manage_orders,
                 'manage_appearance'=>$manage_appearance,
                 'manage_trash'=>$manage_trash,
                 'manage_product_requestes'=>$manage_pro_requests,
                 'manage_settings'=>$manage_settings,
                 'manage_aitsun_keys'=>$manage_aitsun_keys,
                 'manage_enquires'=>$manage_enquires,
                 'manage_crm'=>$manage_crm,
                 'manage_document_renew'=>$manage_document_renew,
                 'manage_work_updates'=>$manage_work_updates,
                 'manage_hr'=>$manage_hr,
                 'manage_invoice_submit'=>$manage_invoice_submit,
                 'manage_sms_config'=>$manage_sms_config,
                 'manage_account_setting'=>$manage_account_setting,
                 'stock_management'=>$stock_management,
                 'manage_library'=>$manage_library,
                 'manage_sports'=>$manage_sports,
                 'manage_eccc'=>$manage_eccc,
                 'manage_messaging'=>$manage_messaging,
                 'manage_timetable'=>$manage_timetable,
                 'manage_notices'=>$manage_notices,
                 'manage_health'=>$manage_health,
                 'manage_fees'=>$manage_fees,
                 'manage_academic_year'=>$manage_academic_year,
                 'delete_receipts_and_payments'=>$delete_receipts_and_payments,

                 ];
             $apl=$PermissionModel->save($insper);
           }else{
            $insper = [ 
                 'manage_parties'=>$manage_parties,
                 'manage_sales'=>$manage_sales,
                 'manage_sales_quotation'=>$manage_sales_quotation,
                 'manage_sales_order'=>$manage_sales_order,
                 'manage_sales_return'=>$manage_sales_return,
                 'manage_sales_delivery_note'=>$manage_sales_delivery_note,
                 'manage_purchase'=>$manage_purchase,
                 'manage_purchase_order'=>$manage_purchase_order,
                 'manage_purchase_return'=>$manage_purchase_return,
                 'manage_purchase_delivery_note'=>$manage_purchase_delivery_note,
                 'manage_cash_ex'=>$manage_cash,
                 'manage_pro_ser'=>$manage_product,
                 'manage_reports'=>$manage_reports,
                 'manage_orders'=>$manage_orders,
                 'manage_appearance'=>$manage_appearance,
                 'manage_trash'=>$manage_trash,
                 'manage_product_requestes'=>$manage_pro_requests,
                 'manage_settings'=>$manage_settings,
                 'manage_aitsun_keys'=>$manage_aitsun_keys,
                 'manage_enquires'=>$manage_enquires,
                 'manage_crm'=>$manage_crm,
                 'manage_document_renew'=>$manage_document_renew,
                 'manage_work_updates'=>$manage_work_updates,
                 'manage_hr'=>$manage_hr,
                 'manage_invoice_submit'=>$manage_invoice_submit,
                 'manage_sms_config'=>$manage_sms_config,
                 'manage_account_setting'=>$manage_account_setting,
                 'stock_management'=>$stock_management,
                 'manage_library'=>$manage_library,
                 'manage_sports'=>$manage_sports,
                 'manage_eccc'=>$manage_eccc,
                 'manage_messaging'=>$manage_messaging,
                 'manage_timetable'=>$manage_timetable,
                 'manage_notices'=>$manage_notices,
                 'manage_health'=>$manage_health,
                 'manage_fees'=>$manage_fees,
                 'manage_academic_year'=>$manage_academic_year,
                 'delete_receipts_and_payments'=>$delete_receipts_and_payments,

                 

             ];
             

             $apl=$PermissionModel->update($check_per['id'],$insper);
         	}
	        

	        if ($apl) {
                $session->setFlashdata('pu_msg', 'Permission Granted!');
                return redirect()->to(base_url('user_master?page=1'));
            }else{
               $session->setFlashdata('pu_er_msg', 'Failed!');
                return redirect()->to(base_url('user_master?page=1'));
            }
		
		}
	}




	public function save_branch_permission($user_id)

        {
           $session=session();

           if($session->has('isLoggedIn')){

            $UserModel= new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            $user=$UserModel->where('id',$myid)->first();
            $new_active_company=0;

            if ($this->request->getMethod() == 'post') {
                $allowedcomp='';

                if ($this->request->getVar('allowed_branches')) {
                    foreach ($this->request->getVar('allowed_branches') as $allw) {
                        $allowedcomp.=$allw.',';

                        if (get_cust_data($user_id,'company_id')==$allw) {
                            $new_active_company=$allw;
                        }else{
                            $new_active_company=$allw;
                        }
                    }

                }
                
                $ac_data = [
                    'allowed_branches'=>$allowedcomp,
                    'is_branch_changed'=>1,
                    'company_id'=>$new_active_company 
                ]; 

                $update_user=$UserModel->update($user_id,$ac_data);


            if ($update_user) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('user_master?page=1'));
            }else{
               $session->setFlashdata('pu_er_msg', 'Failed!');
               return redirect()->to(base_url('user_master?page=1'));
            }

          }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

}