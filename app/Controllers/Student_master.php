<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Classtablemodel;
use App\Models\InvoiceModel;
use App\Models\PaymentsModel;
use App\Models\AccountingModel;
use App\Models\StudentcategoryModel;
use App\Models\FeesModel;
use App\Models\MainexamModel;
use App\Models\AcademicYearModel;




class Student_master extends BaseController
{
	public function index()
	{
		$session=session();
	    $UserModel=new Main_item_party_table();
	    $Classtablemodel = new Classtablemodel();
	    $myid=session()->get('id');

	    $pager = \Config\Services::pager();

	    $results_per_page = 12; 
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$UserModel->where('id', session()->get('id'))->first();
	    
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		


	    		if ($_GET) {
		            if (isset($_GET['serachstudent'])) {
		                if (!empty($_GET['serachstudent'])) {
		                    $Classtablemodel->like('first_name', $_GET['serachstudent'], 'both'); 
		                }
		            }
		            
		            if (isset($_GET['classes'])) {
		                if (!empty($_GET['classes'])) {
		                    $Classtablemodel->where('class_id', $_GET['classes']); 
		                }
		            }
		            
		     
		        }


	    		$student_data=$Classtablemodel->where('deleted',0)->where('academic_year',academic_year($myid))->orderBy('first_name','ASC')->where('company_id',company($myid))->where('transfer','')->paginate(20);



	    		$student_dataaa=$Classtablemodel->where('deleted',0)->where('academic_year',academic_year($myid))->orderBy('first_name','ASC')->where('company_id',company($myid))->where('transfer','')->findAll();


	    		if (isset($_GET['get_excel'])) {
            

	            $fileName = "Student". ".xls"; 
	            
	                    // Column names 
	            $fields = array('S. No', 'Adm. No.', 'Student Name', 'Class', 'Contact No', 'Father', 'Mother', 'Address', 'Gender', 'Category', 'Joined date'); 

	            
	            
	                     // print_r($fields);

	                    // Display column names as first row 
	            $excelData = implode("\t", array_values($fields)) . "\n"; 
	            
	                    // Fetch records from database 
	            $query = $student_dataaa; 
	            if(count($query) > 0){ 
	                // Output each row of the data 
	                foreach ($query as $row) {

	                    $serial_no= school_code(company($usaerdata['id'])).''.location_code(company($usaerdata['id'])).''.get_student_data(company($usaerdata['id']),$row['student_id'],'serial_no');

	                    $admission_no=get_student_data(company($usaerdata['id']),$row['student_id'],'admission_no');

	                    $student_name=user_name($row['student_id']);
	                    $class=class_name(current_class_of_student(company($usaerdata['id']),$row['student_id']));
	                    $contact_no=get_student_data(company($usaerdata['id']),$row['student_id'],'phone');
	                    $father=get_student_data(company($usaerdata['id']),$row['student_id'],'father_name');
	                    $mother=get_student_data(company($usaerdata['id']),$row['student_id'],'mother_name');
	                    $address=get_student_data(company($usaerdata['id']),$row['student_id'],'billing_address');
	                    $gender=user_gender($row['student_id']);
	                    $category=student_category_name(get_student_data(company($usaerdata['id']),$row['student_id'],'category'));
	                    $jndate=get_date_format(get_student_data(company($usaerdata['id']),$row['student_id'],'date_of_join'),'d M Y');


	                    
	                    $colllumns=array($serial_no, $admission_no, $student_name, $class, $contact_no,$father,$mother,$address,$gender,$category,$jndate);
	                    

	                    array_walk($colllumns, 'filterData');
	                    $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
	                    
	                }
	            }else{ 
	                $excelData .= 'No records found...'. "\n"; 
	            } 
	            
	                    // // Headers for download 
	            header("Content-Type: application/vnd.ms-excel"); 
	            header("Content-Disposition: attachment; filename=\"$fileName\""); 
	            
	                    // Render excel data 
	            echo $excelData; 
	            
	            exit;
	        }

	    		
	    		$data=[
	    			'title'=>'Student Master | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'student_data'=>$student_data,
	    			'pager' => $Classtablemodel->pager,

	    		];
	    		
		    		echo view('header',$data);
		    		echo view('student_master/students');
		    		echo view('footer');
		    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function student_details($std_id="")
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $InvoiceModel=new InvoiceModel();
	    $Classtablemodel=new Classtablemodel();
	    $MainexamModel= new MainexamModel();
	    
	    if ($session->has('isLoggedIn')) {
	    	$myid=session()->get('id');
	    	$usaerdata=$user->where('id', session()->get('id'))->first();

	    		$student_data=$user->where('company_id',company($myid))->where('deleted',0)->where('id',$std_id)->first();
	    		$mainexam_data=$MainexamModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->findAll();

	    		$invoice_of_student=$InvoiceModel->where('company_id',company($myid))->where('invoice_type','challan')->where('deleted',0)->where('customer',$std_id)->orderBy('id','DESC')->findAll();

	    		
	    		$data=[
	    			'title'=>'Student Details | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'student_data'=>$student_data,
	    			'exam_data'=>$mainexam_data,
	    			'invoice_of_student'=>$invoice_of_student
	    			
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
                  echo view('student_master/student_details',$data);
                }else{

		    		echo view('header',$data);
		    		echo view('student_master/student_details');
		    		echo view('footer');
		    	}	    	
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	public function student_fees_details($std_id="",$type='view')
		{

			  $session=session();
		    $user=new Main_item_party_table();
		    $InvoiceModel=new InvoiceModel();
		    $Classtablemodel=new Classtablemodel();
		    $PaymentsModel=new PaymentsModel();
		    $MainexamModel= new MainexamModel();
		     

		    	

		    	$myid=$std_id; 

	    		$student_data=$user->where('company_id',company($myid))->where('deleted',0)->where('id',$std_id)->first();
	    		$mainexam_data=$MainexamModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->findAll();

	    		$invoice_of_student=$InvoiceModel->where('company_id',company($myid))->where('invoice_type','challan')->where('paid_status','unpaid')->where('deleted',0)->where('customer',$std_id)->orderBy('id','DESC')->findAll(); 


	    			


		    		$filename=$student_data['display_name'].' - '.class_name(current_class_of_student(company($student_data['id']),$student_data['id'])).' fees setails';
            $cusname="CASH CUSTOMER";
            $page_size='A4';
            $orientation='portrait';

            $acti=activated_year(company($myid));
						$payments_of_students=$PaymentsModel->where('company_id',company($myid))->where('deleted',0)->where('customer',$myid)->orderBy('id','DESC')->findAll();

            $data=[
		    			'title'=>$filename,
		    			'user'=>$student_data,
		    			'student_data'=>$student_data,
		    			'exam_data'=>$mainexam_data,
		    			'invoice_of_student'=>$invoice_of_student,
		    			'payments_of_students'=>$payments_of_students,
		    			
		    		];

		    		$dompdf = new \Dompdf\Dompdf();
            $dompdf->set_option('isJavascriptEnabled', TRUE);
            $dompdf->set_option('isRemoteEnabled', TRUE); 

            $dompdf->loadHtml(view('student_master/student_fees_details',$data));
            $dompdf->setPaper($page_size, $orientation);
            $dompdf->render();

            if ($type=='download') {
              $dompdf->stream($filename, array("Attachment" => true));
            }else{
              $dompdf->stream($filename, array("Attachment" => false));
            }
						exit();  
		 
		}


	public function deletestudent($stid=0)
	{
		$model = new Main_item_party_table();
		$Classtablemodel = new Classtablemodel();
		$myid=session()->get('id');
		

		if ($this->request->getMethod() == 'post') {
				
				$deledata=[
                    'deleted'=>1
                ];

				$model->update($stid,$deledata);


				
				$classtab_id =$Classtablemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$stid)->first(); 

				$deleteclsdata=[
                    'deleted'=>1
                ];
                $Classtablemodel->update($classtab_id['id'],$deleteclsdata);

                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'Student <b>'.user_name($stid).'</b> is deleted.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////

		}else{
   			return redirect()->to(base_url('student-master'));
		}

	}


	public function transfer_student($stid=0)
	{
		$model = new Main_item_party_table();
		$Classtablemodel = new Classtablemodel();
		$AccountingModel = new Main_item_party_table();
		$myid=session()->get('id');
		

		if ($this->request->getMethod() == 'post') {
				$model->find($stid);

				$deledata=[
          'transfer'=>'transferred',
        ];

				$model->update($stid,$deledata);

			
			
				
				$classtab_id =$Classtablemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$stid)->first(); 

				$deleteclsdata=[
                    'transfer'=>'transferred',
                ];
                $Classtablemodel->update($classtab_id['id'],$deleteclsdata);


   
	        	

                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'Student <b>'.user_name($stid).'</b> is transferred.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////

		}else{
   			return redirect()->to(base_url('student-master'));
		}

	}


	public function check_transaction_exist($stid=0)
	{
		$model = new Main_item_party_table();
		$InvoiceModel = new InvoiceModel();
		$PaymentsModel = new PaymentsModel();
		$myid=session()->get('id');
		$acti=activated_year(company($myid));

		$result='';

		$check_invoices=$InvoiceModel->where('customer',$stid)->where('deleted',0)->first();

		if ($check_invoices) {
			$result='exist';
		}
		
		$check_payments=$PaymentsModel->groupStart()->where('customer',$stid)->orWhere('account_name',$stid)->groupEnd()->where('deleted',0)->first();

		if ($check_payments) {
			$result='exist';
		}


		echo  $result;
	}


	public function update_student($orgid=""){
		if ($this->request->getMethod() == 'post') {

				$UserModel = new Main_item_party_table();
				$myid=session()->get('id');
				$Classtablemodel = new ClasstableModel();
				$AccountingModel = new Main_item_party_table();
				


				$session=session();
					$img = $this->request->getFile('student_img');
					$password = strip_tags($this->request->getVar('password'));
					$emailphone=strip_tags($this->request->getVar('mobileno'));
					
					if (!empty(trim($img))) {
						if($_FILES['student_img']['size'] > 500000) { //10 MB (size is also in bytes)
				        $filename = strip_tags($this->request->getVar('old_profile_pic'));
					    } else {
							$filename = $img->getRandomName();
							$mimetype=$img->getClientMimeType();
				            $img->move('public/uploads/students/',$filename);
				        }

			        }else{


			        $filename = strip_tags($this->request->getVar('old_profile_pic'));
			    }



			         $op_balance=strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value'));

			        $current_closing_balance=floatval(user_data($orgid,'opening_balance'));
			        $current_opening_balance=floatval(user_data($orgid,'closing_balance'));


			        $closing_balance=($current_closing_balance-$current_opening_balance) + floatval($op_balance);

			        if (!empty(trim($password))) {


			            	
			            	$newData = [
			                    'profile_pic'=>$filename,
			                    'first_name' => strip_tags($this->request->getVar('stdname')),
			                    'display_name' => strip_tags($this->request->getVar('stdname')),
													'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
													'stdage' => strip_tags($this->request->getVar('age')),
													'father_name' => strip_tags($this->request->getVar('fathername')),
													'mother_name' => strip_tags($this->request->getVar('mothername')),
													'gender' => strip_tags($this->request->getVar('gender')),
													'email' =>strip_tags($this->request->getVar('email')),
													'password' =>$password,
													'password_2' =>$password,
													'billing_address' => strip_tags($this->request->getVar('address')),
													'phone' => $emailphone,
													'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
													'category' => strip_tags($this->request->getVar('category')),
													'subcategory' => strip_tags($this->request->getVar('subcategory')),
													'admission_no' => strip_tags($this->request->getVar('admission_no')),
													'adhar' => strip_tags($this->request->getVar('aadhar_no')),
													'blood_group' => strip_tags($this->request->getVar('blood_gp')),
													'phone2'=>strip_tags($this->request->getVar('phone2')),
													'religion'=>strip_tags($this->request->getVar('religion')),
													'ration_card_no'=>strip_tags($this->request->getVar('ration_card_no')),
													'account_number'=>strip_tags($this->request->getVar('account_number')),
													'bank_name'=>strip_tags($this->request->getVar('bank_name')),
													'ifsc'=>strip_tags($this->request->getVar('ifsc')),
													'opening_balance'=>$op_balance,
                          'closing_balance'=>$closing_balance,
			           		 ];
							
					}else{
						$newData = [
							'profile_pic'=>$filename,
							'first_name' => strip_tags($this->request->getVar('stdname')),
							'display_name' => strip_tags($this->request->getVar('stdname')),
							'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
							'stdage' => strip_tags($this->request->getVar('age')),
							'father_name' => strip_tags($this->request->getVar('fathername')),
							'mother_name' => strip_tags($this->request->getVar('mothername')),
							'gender' => strip_tags($this->request->getVar('gender')),
							'email' =>strip_tags($this->request->getVar('email')),
							
							'billing_address' => strip_tags($this->request->getVar('address')),
							
							'phone' => $emailphone,
							'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
							'category' => strip_tags($this->request->getVar('category')),
							'subcategory' => strip_tags($this->request->getVar('subcategory')),
							'admission_no' => strip_tags($this->request->getVar('admission_no')),
							'adhar' => strip_tags($this->request->getVar('aadhar_no')),
							'blood_group' => strip_tags($this->request->getVar('blood_gp')),
							'phone2'=>strip_tags($this->request->getVar('phone2')),
							'religion'=>strip_tags($this->request->getVar('religion')),
							'ration_card_no'=>strip_tags($this->request->getVar('ration_card_no')),
							'account_number'=>strip_tags($this->request->getVar('account_number')),
							'bank_name'=>strip_tags($this->request->getVar('bank_name')),
							'ifsc'=>strip_tags($this->request->getVar('ifsc')),
							'opening_balance'=>$op_balance,
            	'closing_balance'=>$closing_balance,
						];
					}
				
				


				$myem=$UserModel->where('id',$orgid)->first();
				if ($_FILES['student_img']['size'] < 500000) {

					if ($myem['phone']==$emailphone) {
						$UserModel->update($orgid,$newData);


						

						$classtab_id =$Classtablemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$orgid)->where('deleted',0)->first();

						
						if ($classtab_id) {
							$newclass = [
								'first_name' => strip_tags($this->request->getVar('stdname')),
								'class_id' => strip_tags($this->request->getVar('classes')),
								'gender' => strip_tags($this->request->getVar('gender')),
								'category' => strip_tags($this->request->getVar('category')),
							];
							$Classtablemodel->update($classtab_id['id'],$newclass);
						}else{
							$newclassins = [
								'company_id' => company($myid),
								'academic_year' => academic_year($myid),
								'student_id' => $orgid,
								'first_name' => strip_tags($this->request->getVar('stdname')),
								'gender' => strip_tags($this->request->getVar('gender')),
								'class_id' => strip_tags($this->request->getVar('classes')),
								'category' => strip_tags($this->request->getVar('category')),
							];
							$Classtablemodel->save($newclassins);
						}


					 
 
                               

                        ////////////////////////CREATE ACTIVITY LOG//////////////
                        $log_data=[
                            'user_id'=>$myid,
                            'action'=>'Student <b>'.user_name($orgid).'('.class_name(strip_tags($this->request->getVar('classes'))).')</b> details is updated.',
                            'ip'=>get_client_ip(),
                            'mac'=>GetMAC(),
                            'created_at'=>now_time($myid),
                            'updated_at'=>now_time($myid),
                            'company_id'=>company($myid),
                        ];

                        add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////
						


					}else{
						$checkemail=$UserModel->where('phone',$emailphone)->where('deleted',0)->where('main_type','user')->first();

						// if (!$checkemail) {
							$UserModel->update($orgid,$newData);

								 
							 

                             ////////////////////////CREATE ACTIVITY LOG//////////////
		                        $log_data=[
		                            'user_id'=>$myid,
		                            'action'=>'Student <b>'.user_name($orgid).'('.class_name(strip_tags($this->request->getVar('classes'))).')</b> details is updated.',
		                            'ip'=>get_client_ip(),
		                            'mac'=>GetMAC(),
		                            'created_at'=>now_time($myid),
		                            'updated_at'=>now_time($myid),
		                            'company_id'=>company($myid),
		                        ];

		                        add_log($log_data);
		                        ////////////////////////END ACTIVITY LOG/////////////////


							
						// }else{
						// 	echo 'email_exist';
						// }
					}

			}else{
				echo 'big_file';
			}
					
				
		
		}
	}

	public function get_subcat_select($parent=""){

			if (!empty($parent)) {
				$StudentcategoryModel = new StudentcategoryModel();

	            $StudentcategoryModel->where('parent_id',$parent);
	            $StudentcategoryModel->where('type','sub');
	            $StudentcategoryModel->where('deleted',0);
	            $scs=$StudentcategoryModel->findAll();
	            echo '<option value="">Choose sub category</option>';
	            foreach ($scs as $sc) {
	                echo '<option value="'.$sc['id'].'">'.$sc['category_name'].'</option>';
	            }

				}else{
					echo '<option value="">Choose sub category</option>';
				}
	           
        }



    public function add_student($org=""){

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$studentmodel = new Main_item_party_table();
				$Classtablemodel = new ClasstableModel();

				$AccountingModel = new Main_item_party_table();
				


				$emailphone=strip_tags($this->request->getVar('mobileno'));

				if (!empty($_FILES['student_img']['name'])) {

					if($_FILES['student_img']['size'] > 500000) { //10 MB (size is also in bytes)
				        
				    } else {
				        $target_dir = "public/uploads/students/";
			            $target_file = $target_dir . time().basename($_FILES["student_img"]["name"]);
			            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			            $imgName = time().basename($_FILES["student_img"]["name"]);
			            move_uploaded_file($_FILES["student_img"]["tmp_name"], $target_file);

			            $newData = [
	                    
		                    'profile_pic'=>$imgName,
		                    'first_name' => strip_tags($this->request->getVar('stdname')),
		                    'display_name' => strip_tags($this->request->getVar('stdname')),
												'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
												'stdage' => strip_tags($this->request->getVar('age')),
												'father_name' => strip_tags($this->request->getVar('fathername')),
												'mother_name' => strip_tags($this->request->getVar('mothername')),
												'gender' => strip_tags($this->request->getVar('gender')),
												'email' => strip_tags($this->request->getVar('email')),
												'password' => strip_tags($this->request->getVar('password')),
												'password_2' => strip_tags($this->request->getVar('password')),
												'billing_address' => strip_tags($this->request->getVar('address')),
												'phone' => $emailphone,
												'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
												'category' => strip_tags($this->request->getVar('category')),
												'subcategory' => strip_tags($this->request->getVar('subcategory')),
												'company_id' => $org,
												'u_type' => 'student',
												'main_type' => 'user',
												'serial_no' => serial_no_student(company($myid)),
												'admission_no' => strip_tags($this->request->getVar('admission_no')),
												'adhar' => strip_tags($this->request->getVar('aadhar_no')),
												'blood_group' => strip_tags($this->request->getVar('blood_gp')),
												'phone2'=>strip_tags($this->request->getVar('phone2')),
												'religion'=>strip_tags($this->request->getVar('religion')),
												'ration_card_no'=>strip_tags($this->request->getVar('ration_card_no')),
												'account_number'=>strip_tags($this->request->getVar('account_number')),
												'bank_name'=>strip_tags($this->request->getVar('bank_name')),
												'ifsc'=>strip_tags($this->request->getVar('ifsc')),
												'opening_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
												'closing_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
		                    

		           		 ];
				    }

		            

					
            
	                

			        }else{
			           
			        $newData = [
	                    'first_name' => strip_tags($this->request->getVar('stdname')),
	                    'display_name' => strip_tags($this->request->getVar('stdname')),
						'date_of_birth' => strip_tags($this->request->getVar('date_of_birth')),
						'stdage' => strip_tags($this->request->getVar('age')),
						'father_name' => strip_tags($this->request->getVar('fathername')),
						'mother_name' => strip_tags($this->request->getVar('mothername')),
						'gender' => strip_tags($this->request->getVar('gender')),
						'email' => strip_tags($this->request->getVar('email')),
						'password' => strip_tags($this->request->getVar('password')),
						'password_2' => strip_tags($this->request->getVar('password')),
						'billing_address' => strip_tags($this->request->getVar('address')),
						'phone' => $emailphone,
						'date_of_join' => strip_tags($this->request->getVar('date_of_join')),
						'category' => strip_tags($this->request->getVar('category')),
						'subcategory' => strip_tags($this->request->getVar('subcategory')),
						'company_id' => $org,
						'u_type' => 'student',
						'main_type' => 'user',
						'serial_no' => serial_no_student(company($myid)),
						'admission_no' => strip_tags($this->request->getVar('admission_no')),
						'adhar' => strip_tags($this->request->getVar('aadhar_no')),
						'blood_group' => strip_tags($this->request->getVar('blood_gp')),
						'phone2'=>strip_tags($this->request->getVar('phone2')),
						'religion'=>strip_tags($this->request->getVar('religion')),
						'ration_card_no'=>strip_tags($this->request->getVar('ration_card_no')),
						'account_number'=>strip_tags($this->request->getVar('account_number')),
						'bank_name'=>strip_tags($this->request->getVar('bank_name')),
						'ifsc'=>strip_tags($this->request->getVar('ifsc')),
						'opening_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
						'closing_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
					];

			        }

				$checkemail=$studentmodel->where('phone',$emailphone)->where('deleted',0)->first();
				
				if ($_FILES['student_img']['size'] < 500000) {
					// if (!$checkemail) {
					$maxuser=user_limit(company($myid));
					$current_user=total_user(company($myid));
					
						if ($current_user>=$maxuser) {
							echo 'failed';
						}else{
							$studentmodel->save($newData);
							$std_id = $studentmodel->getInsertID();

							$newclass = [

								'company_id' => $org,
								'academic_year' => academic_year($myid),
								'student_id' => $std_id,
								'first_name' => strip_tags($this->request->getVar('stdname')),
								'class_id' => strip_tags($this->request->getVar('classes')),
								'gender' => strip_tags($this->request->getVar('gender')),
								'category' => strip_tags($this->request->getVar('category')),
								'deleted' => 0,
								
									];
								$Classtablemodel->save($newclass);

								

								 


	                            ////////////////////////CREATE ACTIVITY LOG//////////////
	                            $log_data=[
	                                'user_id'=>$myid,
	                                'action'=>'New student <b>'.user_name($std_id).'('.class_name(strip_tags($this->request->getVar('classes'))).')</b> is joined.',
	                                'ip'=>get_client_ip(),
	                                'mac'=>GetMAC(),
	                                'created_at'=>now_time($myid),
	                                'updated_at'=>now_time($myid),
	                                'company_id'=>company($myid),
	                            ];

	                            add_log($log_data);
	                            ////////////////////////END ACTIVITY LOG/////////////////

							echo $std_id;
						}
					// }else{
					// 	echo 'email_exist';
					// }
				}else{
					echo 'big_file';
				}
			}

	}


	public function get_fees_list_of_student($student_id=''){
		$session=session();
	    $user=new Main_item_party_table();
	    $FeesModel= new FeesModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	

	    		$fees_type=$FeesModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->findAll();

	    		if (check_permission($myid,'manage_fees')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}
	    		$count=0;
	    		foreach ($fees_type as $ft) { 
					$count++;
	    			?>
	    			<div class="col-12 mb-2 cursor-pointer generate_challan_for_student" data-fees_id="<?= $ft['id']; ?>" data-student_id="<?= $student_id; ?>">
	    				<div class="card bg-success">
	    					<div class="card-body">
	    						<h5 class="text-white mb-0"><?= $ft['fees_name']; ?></h5>
	    					</div>
	    				</div>
	    			</div>
	    			<?php
	    		}

	    		if ($count==0) {
					echo '<div class="col-md-12 text-center p-5">
		    				<h5 class="text-danger">No Fees</h5>
		    			</div>';
				}


	    	
	    	
	    } 
	}

	public function student_report()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $myid=session()->get('id');
	    $Classtablemodel= new Classtablemodel();
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

              

	    if (check_permission($myid,'manage_reports')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));} 



	    	if (!empty($_GET['stdname'])) {
        	$Classtablemodel->like('first_name',trim($_GET['stdname']),'both');
	        }

	        if (!empty($_GET['stdcls'])) {
	        	$Classtablemodel->where('class_id',$_GET['stdcls']);
	        }

	        if (!empty($_GET['stdyear'])) {
	        	$Classtablemodel->where('academic_year',$_GET['stdyear']);
	        }else{
               $Classtablemodel->where('academic_year', academic_year($myid));
            }


            $results_per_page = 12; 
	    	$students_data=$Classtablemodel->where('company_id',company($myid))->where('deleted','0')->orderBy('first_name','ASC')->paginate(50);
	    		
	    		
	    		
	    		$data=[
	    			'title'=>'Reports | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'students_data'=>$students_data,
	    			'pager' => $Classtablemodel->pager,
	    			

	    		];
                
               
    	    		echo view('header',$data);
    	    		echo view('student_master/student_reports');
    	    		echo view('footer');
                


	    	
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function category_wise_student_report()
    {
        $session=session();
        $user=new Main_item_party_table();
        $myid=session()->get('id');
        $Classtablemodel= new Classtablemodel();
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
            
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

        if (check_permission($myid,'manage_reports')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));} 

    

                $StudentcategoryModel = new StudentcategoryModel;

                if ($_GET) {
                    if (isset($_GET['cate'])) {
                        if (!empty($_GET['cate'])) {
                            $StudentcategoryModel->where('id',$_GET['cate']);
                        }
                    }
                }
                $results_per_page = 12; 
                $StudentcategoryModel->where('company_id', company($myid))->where('type', 'main')->where('deleted',0);
                 
                $starray=$StudentcategoryModel->paginate(50);
                
                $data=[
                    'title'=>'Category wise students | Erudite ERP',
                    'user'=>$usaerdata,  
                    'categories'=> $starray,
                    'pager' => $StudentcategoryModel->pager,

                ];
              
                    echo view('header',$data);
                    echo view('student_master/category_wise_student_report');
                    echo view('footer');
                


            
            
        }else{
            return redirect()->to(base_url('users'));
        }       
    }




    public function students_easy_edit()
		{
				$session=session();
		    $UserModel=new Main_item_party_table();
		    $Classtablemodel=new Classtablemodel();
		    
		    $myid=session()->get('id');

		    $pager = \Config\Services::pager();

		    $results_per_page = 12; 
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$UserModel->where('id', session()->get('id'))->first();
		    
		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		


        	if ($_GET) {
                if (isset($_GET['student_name'])) {
                    if (!empty($_GET['student_name'])) {
                        $Classtablemodel->like('first_name', $_GET['student_name']); 
                    }
                }

                if (isset($_GET['classes'])) {
		                if (!empty($_GET['classes'])) {
		                    $Classtablemodel->like('class_id', $_GET['classes'], 'both'); 
		                }else{
		                	$Classtablemodel->like('class_id','', 'both');
		                }
		            }
                 
            } 
		    		

		    		$student_data=$Classtablemodel->where('deleted',0)->where('academic_year',academic_year($myid))->where('company_id',company($myid))->paginate(100);
		    		$data=[
		    			'title'=>'Student Master | Erudite ERP',
		    			'user'=>$usaerdata,
		    			'student_data'=>$student_data,
		    			'pager' => $Classtablemodel->pager,

		    		];
		    		
			    		echo view('header',$data);
			    		echo view('student_master/students_easy_edit');
			    		echo view('footer');
			    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}		
		}


		public function update_student_easyedit($pid="",$cid=""){
            $session=session();
            $UserModel=new Main_item_party_table();
            $Classtablemodel=new Classtablemodel();
            $myid=session()->get('id');
            if ($this->request->getMethod() == 'post') {

            	$ptable=$this->request->getVar('p_table');

                $pele=strip_tags(trim($this->request->getVar('p_element')));
                $pele1=strip_tags(trim($this->request->getVar('p_element')));


                 if ($ptable=='user') {
                 	if ($pele=='student_name' )  {
              			$pele='display_name';
              		}
              		if ($pele=='class' )  {
              			$pele='class';
              		}
              		
                	$ac_data = [
                      $pele=>strip_tags(trim($this->request->getVar('p_element_val'))),
                  ]; 
                  
                  $pro_data=$UserModel->update($pid,$ac_data);
                }elseif ($ptable=='class') {
                	if ($pele=='student_name') {
              			$pele='first_name';
              		}
              		if ($pele=='class' )  {
              			$pele='class_id';
              		}
                	$cs_data = [
                      $pele=>strip_tags(trim($this->request->getVar('p_element_val'))), 
                  ]; 
                  $pro_data=$Classtablemodel->update($cid,$cs_data);
                }elseif ($ptable=='both') {
                	if ($pele=='student_name') {
              				$pele='display_name';
              				$pele1='first_name';

              		}
              		if ($pele=='class') {
              				$pele='class';
              				$pele1='class_id';

              		}
                	$both_ac_data = [
                      $pele=>strip_tags(trim($this->request->getVar('p_element_val'))),

                  ]; 
                  $pro_data=$UserModel->update($pid,$both_ac_data);
                	$bo_cs_data = [
                      $pele1=>strip_tags(trim($this->request->getVar('p_element_val'))), 
                  ]; 
                  $pro_data=$Classtablemodel->update($cid,$bo_cs_data);
                }

                 if ($pro_data) {
                    echo 1;
                }else{
                    echo 0;
                }
               
            }
        }



  public function promote($student_id=""){
		if ($this->request->getMethod() == 'post') {

				$UserModel = new Main_item_party_table();
				$myid=session()->get('id');
				$Classtablemodel = new ClasstableModel();
				$session=session();

				$classes=strip_tags($this->request->getVar('classes'));
				$years=strip_tags($this->request->getVar('years'));
					

				$classtab_id =$Classtablemodel->where('company_id',company($myid))->where('academic_year',$years)->where('student_id',$student_id)->where('deleted',0)->first();

				
				if ($classtab_id) {
					echo 'exist';
				}else{
					$newclassins = [
						'company_id' => company($myid),
						'academic_year' => $years,
						'student_id' => $student_id,
						'first_name' => user_name($student_id),
						'class_id' => $classes,
						'gender' => user_gender($student_id),
					];
					if ($Classtablemodel->save($newclassins)) {
						echo 'done';

						$log_data=[
				            'user_id'=>$myid,
				            'action'=>'<b>'.user_name($student_id).'</b> is promoted to <b>'.class_name($classes).'</b> class',
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
	}



	public function get_student_other_data($std_id){
        if (!empty($std_id)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();

                $data=[
                		'user'=>$user,
                    'std_id'=>$std_id
                ];
                echo view('student_master/student_other_details',$data);

            }
        } 
    }


    public function get_promote_student_data($std_id){
        if (!empty($std_id)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $Classtablemodel = new Classtablemodel();
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();

                $std_data_id =$Classtablemodel->where('student_id',$std_id)->where('deleted',0)->first();


                $data=[
                		'user'=>$user,
                    'std_data_id'=>$std_data_id
                ];
                echo view('student_master/promote_student',$data);

            }
        } 
    }


    public function get_edit_student_data($std_id){
        if (!empty($std_id)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $Classtablemodel = new Classtablemodel();
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();

                $stded_data_id =$Classtablemodel->where('student_id',$std_id)->where('deleted',0)->first();


                $data=[
                		'user'=>$user,
                    'stded_data_id'=>$stded_data_id
                ];
                echo view('student_master/edit_student_form',$data);

            }
        } 
    }

}