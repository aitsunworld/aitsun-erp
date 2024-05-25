<?php
namespace App\Controllers; 
use App\Models\Companies;
use App\Models\MainCompanies;
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\NotificationsettingModel;
use App\Models\EmailtemplateModel;
use App\Models\ConfigurationModel;  
use App\Models\StudentcategoryModel;
use App\Models\SubjectModel;
use App\Models\Main_item_party_table;
use App\Models\ProductBrand;
use App\Models\ProductCategories;




class Company extends BaseController
{
     public function index()
    {
        $session=session();

        if($session->has('isLoggedIn')){

            $MainCompanies= new MainCompanies; 
            $Companies= new Companies;  
            $CompanySettings= new CompanySettings;
            $NotificationsettingModel= new NotificationsettingModel;
            $EmailtemplateModel= new EmailtemplateModel;
            $ConfigurationModel= new ConfigurationModel;
            $CompanySettings2= new CompanySettings2;

            $ProductBrand= new ProductBrand();
            $ProductCategories= new ProductCategories();

            $SubjectModel = new SubjectModel();
            $StudentcategoryModel= new StudentcategoryModel();
            $Main_item_party_table= new Main_item_party_table();





            $myid=session()->get('id');
            $con = array( 
               'id' => session()->get('id') 
            );

            $user=$Main_item_party_table->where('main_type','user')->where('id',$myid)->first();

            
           
            $get_main_company=$MainCompanies->where('uid',$myid)->first();

            $data = [
                'title' => 'Aitsun ERP-Company',
                'user'=>$user,
                'main_company'=>$get_main_company,
                
            ];
           
           if (check_main_company($myid)==true) {
                if (check_branch_of_main_company(company($myid))==true) {
                    return redirect()->to(base_url());
                }else{
                    echo view('company/addbranch', $data);
                }
               
           }else{
            if ($user['author']!=1) {
              echo view('company/no_companies', $data);
            }else{
              echo view('company/addcompany', $data);
            }
                
           }



            
           
            if (isset($_POST['save_companies'])) {

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
                        'created_at'=>now_time($myid),
                        'updated_at'=>now_time($myid),
                        'uid'=>$myid
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
                        'created_at'=>now_time($myid),
                        'updated_at'=>now_time($myid),
                        'uid'=>$myid
                    ];

                }

               
                 $update_user=$MainCompanies->save($ac_data);
                 $insert_id=$MainCompanies->insertID();
                 $mainid=$insert_id;

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
                            'created_at'=>now_time($myid),
                            'updated_at'=>now_time($myid),
                            'uid'=>$myid,
                            'parent_company'=>$insert_id,
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
                            'created_at'=>now_time($myid),
                            'updated_at'=>now_time($myid),
                            'uid'=>$myid,
                            'parent_company'=>$insert_id,
                            'active'=>1
                        ];

                }

                 $update_user=$Companies->save($ac_data);
                 $insert_id=$Companies->insertID();

                 $com_data=[
                    'company_id'=>$insert_id,
                    'main_compani_id'=>$mainid, 
                 ];

                 $Main_item_party_table->update($myid,$com_data);


                 $cash_user_data=[
                    'company_id'=>$insert_id,
                    'display_name'=>'Cash Sale',
                    'u_type'=>'customer',
                    'main_type'=>'user',
                    'created_at'=>now_time($myid),
                    'serial_no'=>serial_no_customer(company($myid)),
                    'default_user'=>1,
                 ];

                 $Main_item_party_table->save($cash_user_data);
                 $cash_insert_id=$Main_item_party_table->insertID();




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
                    'invoice_declaration'=>'We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.',
                    'invoice_terms'=>'1. Customer will be billed after indicating acceptance of this quot
                                      2. Payment cash on delivery.
                                      3. Please fax or mail the signed price quote to the address above
                                      4. Delivery 2-7 days after confirmation
                                      5. Warranty 1 Year',
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

                add_base_accounting_heads(company($myid),activated_year(company($myid)));


                if ($update_user) {
                    session()->setFlashdata('sucmsg', 'Company Added successfully!');
                    return redirect()->to(base_url());
                }else{
                    session()->setFlashdata('failmsg', 'Failed!');
                    return redirect()->to(base_url());
                }
            }


            
         
        }else{
            redirect(base_url('users/login'));
        }
    
    }
}
