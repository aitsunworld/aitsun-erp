<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\MainCompanies;
use App\Models\CompanySettings;
use App\Models\NotificationsettingModel;
use App\Models\EmailtemplateModel;
use App\Models\ConfigurationModel;
use App\Models\AccountCategory;
use App\Models\ExpensestypeModel;
use App\Models\ExgroupheadsModel;
use App\Models\StudentcategoryModel;
use App\Models\SubjectModel;
use App\Models\CompanySettings2; 
use App\Models\ProductBrand; 
use App\Models\ProductCategories; 



class Branch_manager extends BaseController
{

	public function index()
    {
    	 $session=session();

         if($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $MainCompanies= new MainCompanies;
            $Companies= new Companies;
            $CompanySettings= new CompanySettings;
            $NotificationsettingModel= new NotificationsettingModel;
			$EmailtemplateModel=new EmailtemplateModel;            			
			$ConfigurationModel=new ConfigurationModel;
			$ExpensestypeModel=new ExpensestypeModel;	


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 


            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
            
            
            
            
            
            $get_main_company=$MainCompanies->where('id', main_company_id($myid));
            $get_branches=$Companies->where('parent_company', main_company_id($myid));

            $data = [
                'title' => 'Aitsun ERP-Branch Manager',
                'user'=>$user,
                'main_company'=>$get_main_company->first(),
                'branches'=>$get_branches->findAll()
            ];
           
           if (check_main_company($myid)==true) {
                if (check_branch_of_main_company(company($myid))==true) {
                    echo view('header',$data);
                    echo view('branch/branch', $data);
                    echo view('footer');
                }else{
                    return redirect()->to(base_url());
                }
               
           }else{
                return redirect()->to(base_url());
           }
 

         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }



    public function add_new_branch(){

    	$session=session();

         if($session->has('isLoggedIn')){

    	$UserModel=new Main_item_party_table;
            $MainCompanies= new MainCompanies;
            $Companies= new Companies;
            $CompanySettings= new CompanySettings;
            $NotificationsettingModel= new NotificationsettingModel;
			$EmailtemplateModel=new EmailtemplateModel;            			
			$ConfigurationModel=new ConfigurationModel;
            $ExpensestypeModel=new ExpensestypeModel;   
            $ProductBrand=new ProductBrand;   
			$ProductCategories=new ProductCategories;	

            


			$CompanySettings2= new CompanySettings2;

            $SubjectModel = new SubjectModel();
            $StudentcategoryModel= new StudentcategoryModel();


    	 if (isset($_POST['add_new_branch'])) {

    	 	$myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 

            	if (total_branch($myid)>=branch_limit(company($myid))) {

            		session()->setFlashdata('pu_er_msg', 'Sorry, reached limit! Please contact administrator.');
            		
                    return redirect()->to(current_url());
                }else{

                    if (!empty($_FILES['company_logo']['name'])) {
                        $target_dir = "public/images/company_docs/";
                        $target_file = $target_dir . time().basename($_FILES["company_logo"]["name"]);
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        $imgName = time().basename($_FILES["company_logo"]["name"]);
                        move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file);

                        $ac_data = [
                            'company_logo'=>$imgName,
                            'company_name'=>strip_tags($this->request->getVar('cname')),
                            'company_phone'=>strip_tags($this->request->getVar('cnumber')),
                            'email'=>strip_tags($this->request->getVar('cemail')),
                            'country'=>strip_tags($this->request->getVar('country')),
                            'state'=>strip_tags($this->request->getVar('state')),
                            'city'=>strip_tags($this->request->getVar('city')),
                            'postal_code'=>strip_tags($this->request->getVar('postal_code')),
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                            'uid'=>$myid,
                            'parent_company'=>strip_tags($this->request->getVar('parent_company')),
                            'active'=>1
                        ];
                    }else{
                        $ac_data = [
                            'company_name'=>strip_tags($this->request->getVar('cname')),
                            'company_phone'=>strip_tags($this->request->getVar('cnumber')),
                            'email'=>strip_tags($this->request->getVar('cemail')),
                            'country'=>strip_tags($this->request->getVar('country')),
                            'state'=>strip_tags($this->request->getVar('state')),
                            'city'=>strip_tags($this->request->getVar('city')),
                            'postal_code'=>strip_tags($this->request->getVar('postal_code')),
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                            'uid'=>$myid,
                            'parent_company'=>strip_tags($this->request->getVar('parent_company')),
                            'active'=>1
                        ];

                    }
                
               
                 $update_user=$Companies->save($ac_data);
                 $insert_id=$Companies->insertID();



                 ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New branch <b>'.strip_tags($this->request->getVar('cname')).'</b> added.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                $cash_user_data=[
                    'company_id'=>$insert_id,
                    'display_name'=>'Cash Sale',
                    'u_type'=>'customer',
                    'created_at'=>now_time($myid),
                    'serial_no'=>serial_no_customer(company($myid)),
                    'default_user'=>1,
                 ];

                 $UserModel->save($cash_user_data);
                 $cash_insert_id=$UserModel->insertID();
                  



                 $csdata = [
                    'company_id'=>$insert_id,
                    'invoice_prefix'=>'AIT',
                    'sales_prefix'=>'SL',
                    'sales_order_prefix'=>'SO',
                    'sales_quotation_prefix'=>'SQ',
                    'sales_return_prefix'=>'SR',
                    'sales_delivery_prefix'=>'SD',
                    'purchase_order_prefix'=>'PO',
                    'purchase_quotation_prefix'=>'PQ',
                    'purchase_return_prefix'=>'PR',
                    'purchase_delivery_prefix'=>'PD',
                    'purchase_prefix'=>'PC', 
                    'Invoice_color'=>'#faffb8',
                    'invoice_footer'=>'Thank You For Your Business!',  
                    'payment_prefix'=>'PAY', 
                    'payment_color'=>'#ff0080',
                    'payment_footer'=>'Thank You For Your Business!',
                    'discount_per_item'=>'on',
                    'tax_per_item'=>'on',
                    'currency'=>'INR',
                    'timezone'=>'Asia/Kolkata',  
                    'invoice_template'=>'1',
                    'receipt_template'=>'1'
                ];
                $CompanySettings->save($csdata);


                $csdata = [
                    'company_id'=>$insert_id,
                    'invoice_page_size'=>'',
                    'invoice_orientation'=>'',
                    'challan_page_size'=>'a4',
                    'challan_orientation'=>'portrait',
                    'receipt_page_size'=>'a4',
                    'receipt_orientation'=>'portrait',
                    'voucher_page_size'=>'a5',
                    'voucher_orientation'=>'landscape',
                    'footer_title'=>'',
                    'description'=>'',
                    'sign_logo'=>'',
                    'payslip_signature'=>'',
                    'bank'=>'',
                    'upi'=>''
                ];
                $CompanySettings2->save($csdata);

                $brand_name = 'Default'; // Default brand name
                $slug = str_replace(' ', '_', $brand_name);

                $brand_data = [
                    'company_id'=>$insert_id,
                    'brand_name' => $brand_name,
                    'deleted'=>0,
                    'deletable'=>1,
                    'slug'=>$slug
                ];
                $ProductBrand->save($brand_data);

                $cat_name = 'General'; // Default brand name
                $slug = str_replace(' ', '_', $cat_name);

                $cat_data = [
                    'company_id'=>$insert_id,
                    'cat_name' => $cat_name,
                    'deleted'=>0,
                    'deletable'=>1,
                    'cat_department'=>dpt_serial(company($myid)),
                    'slug'=>$slug
                ];
                $ProductCategories->save($cat_data);
                 

                $subjdata = [
                    'company_id'=>$insert_id,
                    'subject_name'=>'Sports',
                    'subject_code'=>'SPRT',
                    'serial_no'=>'1',
                    'datetime'=> now_time($myid),
                    'deleted'=>0,
                    'deletable'=>1,
                    'sub_type'=>'main_sub'
                ];

                $SubjectModel->save($subjdata);
                $subinsid1=$SubjectModel->insertID();

                $comsubdata1=[
                  'sports_id'=>$subinsid1,
                ];

                $Companies->update($insert_id,$comsubdata1);


                $subjdata2 = [
                    'company_id'=>$insert_id,
                    'subject_name'=>'EC/CC',
                    'subject_code'=>'ECCC',
                    'serial_no'=>'2',
                    'datetime'=> now_time($myid),
                    'deleted'=>0,
                    'deletable'=>1,
                    'sub_type'=>'main_sub'
                ];
                
                $SubjectModel->save($subjdata2);
                $subinsid2=$SubjectModel->insertID();

                $comsubdata2=[
                  'eccc_id'=>$subinsid2,
                ];

                $Companies->update($insert_id,$comsubdata2);




                $user_category = [
                    'company_id'=>$insert_id,
                    'category_name'=>'General',
                    'type'=>'main',
                    'default'=>1,

                ];
                
                $StudentcategoryModel->save($user_category);

                
                if ($update_user) {
                	session()->setFlashdata('pu_msg', 'Branch Added successfully!');
                    return redirect()->to(base_url('branch_manager'));
                }else{
                	session()->setFlashdata('pu_er_msg', 'Failed');
                    return redirect()->to(base_url('branch_manager'));
                }

            }

            }
            }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function current_branch(){
    	$session=session(); 
        if($session->has('isLoggedIn')){
        	echo company(session()->get('id'));
        }else{
        	echo 0;
        }
    }


     public function change_branch($branch="",$type="normal")
    {
    	$session=session();

        if($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $ExpensestypeModel=new ExpensestypeModel;
            $AccountCategory=new AccountCategory;
            $ExgroupheadsModel=new ExgroupheadsModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            

            if (check_main_company($myid)==true) {
                if (check_branch_of_main_company($branch)==true) {

                    if (is_school(company($myid))) {

                        $current_academic_year=current_academic_year('id',$branch);
                    }else{
                        $current_academic_year=0;
                    }


                    $com_data=[
                        'company_id'=>$branch,
                        'activated_academic'=>$current_academic_year
                    ];

                    $upc=$UserModel->update($myid,$com_data);

                    $insert_id=$branch;


                     $cusdata=[
                        'company_id'=>main_company_id($myid)
                    ];

                    // $cus=$this->crud->update_data('customers',$cusdata,'id',$myid);
                    if ($upc) {

                        if ($type=='ajax') {
                            echo 1;
                        }else{
                            session()->setFlashdata('sucmsg', 'Branch Changed successfully!');
                            return redirect()->to(base_url('branch_manager')); 
                        }
                    	
                    }else{

                        if ($type=='ajax') {
                            echo 0;
                        }else{
                            session()->setFlashdata('sucmsg', 'Failed');
                            return redirect()->to(base_url('branch_manager'));
                        }

                    	

                    } 
                }else{
                    if ($type=='ajax') {
                            echo 0;
                    }else{

                    return redirect()->to(base_url());
                     }

                }
               
           }else{
                    if ($type=='ajax') {
                        echo 0;
                    }else{
                        return redirect()->to(base_url());
                    }
           }
           
            
        
         
        }else{
            if ($type=='ajax') {
                echo 0;
            }else{
                return redirect()->to(base_url('users/login'));
            }
            
        }
    
    }



}