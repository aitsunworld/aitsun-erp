<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel; 
use App\Models\PaymentsModel;
use App\Models\AccountingModel;
use App\Models\PartiesCategories; 


class Customers extends BaseController
{
    public function index()
    {
        $session=session();  

        $Main_item_party_table=new Main_item_party_table; 

        $pager = \Config\Services::pager();


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$Main_item_party_table->where('id',$myid)->first();


            $results_per_page = 12; 


            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            // if (user_data(session()->get('id'),'activated_financial_year')<1) {
            //     return redirect()->to(base_url('settings/financial_years'));
            // }



            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

 

            $Main_item_party_table->where('deleted',0);
            $Main_item_party_table->where('u_type!=','admin');
            $Main_item_party_table->where('u_type!=','superuser');
            $Main_item_party_table->where('main_type','user');


            if ($_GET) {
                if (isset($_GET['display_name'])) {
                    if (!empty($_GET['display_name'])) {
                        $Main_item_party_table->like('display_name', $_GET['display_name'], 'both'); 
                    }
                }
                if (isset($_GET['phone'])) {
                    if (!empty($_GET['phone'])) {
                        $Main_item_party_table->like('phone', $_GET['phone'], 'both'); 
                    }
                }
                if (isset($_GET['party_type'])) {
                    if (!empty($_GET['party_type'])) {
                        $Main_item_party_table->where('u_type', $_GET['party_type']); 
                    }
                } 

            }  


            $get_cust = $Main_item_party_table->where('u_type!=','staff')->where('u_type!=','driver')->where('u_type!=','teacher')->where('u_type!=','delivery')->where('u_type!=','seller')->where('u_type!=','admin')->where('u_type!=','student')->where('company_id',company($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(22);
    // PRODUCTS FETCHING AND PAGINATION END




            $data = [
                'title' => 'Aitsun ERP-Parties',
                'user'=>$user, 
                'customer_data'=> $get_cust, 
                'pager' => $Main_item_party_table->pager,
            ]; 

            echo view('header',$data);
            echo view('customers/customers'); 
            echo view('footer');

            

        }else{
            return redirect()->to(base_url('users/login'));
        }

    }


    public function add(){
        $session=session();
        $UserModel=new Main_item_party_table;   

        $pager = \Config\Services::pager();


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();



            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            // if (user_data(session()->get('id'),'activated_financial_year')<1) {
            //     return redirect()->to(base_url('settings/financial_years'));
            // }



            $data = [
                'title' => 'Aitsun ERP-Parties',
                'user'=>$user,  
            ]; 

            echo view('header',$data);
            echo view('customers/add_customer'); 
            echo view('footer');


        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function add_customer_form(){
        $session=session();
        $UserModel=new Main_item_party_table;  



        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            $data = [
                'title' => 'Aitsun ERP-Parties',
                'user'=>$user,  
            ]; 
            echo view('customers/add_customer_form',$data);  


        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
    public function save_customer()
    {
        $session=session();
        $UserModel=new Main_item_party_table;   


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (isset($_POST['display_name'])) {

               




                    $email=strip_tags($this->request->getVar('email'));
                    $phone=strip_tags($this->request->getVar('phone'));


                    if (strip_tags(trim($this->request->getVar('contact_name')))=='') {
                        $contactname=$this->request->getVar('display_name');
                    }else{
                        $contactname=$this->request->getVar('contact_name');
                    }


                    $customer_data = [
                        'company_id'=>company($myid),
                        'display_name'=>strip_tags($this->request->getVar('display_name')),
                        
                        'email'=>$email,
                        'contact_name'=>$contactname,
                        'main_type'=>'user',
                        'phone'=>$phone, 
                        'gst_no'=>strip_tags($this->request->getVar('gstno')),
                        'u_type'=>strip_tags($this->request->getVar('party_type')),
                        'created_at'=>now_time($myid),
                        'serial_no'=>serial_no_customer(company($myid)),  
                        'opening_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
                        'closing_balance'=>strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value')),
                        'credit_limit'=>aitsun_round(strip_tags($this->request->getVar('credit_limit')),get_setting(company($myid),'round_of_value')), 
                        'website'=>strip_tags($this->request->getVar('website')),
                        'billing_address'=>strip_tags($this->request->getVar('billing_address')),
                        'billing_state'=>strip_tags($this->request->getVar('billing_state')),
                        'area'=>strip_tags($this->request->getVar('area')),
                        'landline'=>strip_tags($this->request->getVar('landline')),
                        'company'=>strip_tags($this->request->getVar('company')),
                        'location'=>strip_tags($this->request->getVar('location')),
                        'phone_2'=>strip_tags($this->request->getVar('phone_2')),
                        'designation'=>strip_tags($this->request->getVar('designation')),
                        'contact_type'=>strip_tags($this->request->getVar('contact_type')),
                        'saved_as'=>strip_tags($this->request->getVar('savedas')),
                        'country_code'=>strip_tags(trim($this->request->getVar('country_code'))),
                        'part_category'=>strip_tags(trim($this->request->getVar('part_category'))),
                    ];

  
                    $parties_result_status=1;
                    $echo_result=0;



                    if ($parties_result_status==1) {
                        $insert_user=$UserModel->save($customer_data);
                        $insidd=$UserModel->insertID();

                      


                        if (strip_tags($this->request->getVar('party_type'))!='vendor') {
                            $group_head_name='Sundry Debtors';
                        }else{
                            $group_head_name='Sundry Creditors';
                        }





                        if ($insert_user) {

                        ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New '.strip_tags($this->request->getVar('party_type')).' <b>'.strip_tags($this->request->getVar('display_name')).'</b> added.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////


                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='New '.strip_tags($this->request->getVar('party_type')).' <b>'.strip_tags($this->request->getVar('display_name')).'</b> added.';
                            $message='';
                            $url=base_url().'/customers'; 
                            $icon=notification_icons('user');
                            $userid='all';
                            $nread=0;
                            $for_who='admin';
                            $notid='user';
                            // notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='New '.strip_tags($this->request->getVar('party_type')).' <b>'.strip_tags($this->request->getVar('display_name')).'</b> added.';
                            $message='';
                            $url=base_url().'/customers'; 
                            $icon=notification_icons('user');
                            $userid='all';
                            $nread=0;
                            $for_who='staff';
                            $notid='user';
                            // notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]


                            if ($this->request->getVar('withajax')==1) {
                                echo $insidd;
                            }else{
                                echo 1;
                            }

                        }else{
                            if ($this->request->getVar('withajax')==1) {
                                echo 0;
                            }else{
                                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                                return redirect()->to(current_url());
                            }
                            
                        }


                    }else{
                        $echo_result=$session->setFlashdata('pu_msg', 'Saved');;
                        return redirect()->to(current_url());
                    }


                }

           

        }
    }

    
    public function add_party_from_selector()
    {
        $session=session();
        $UserModel=new Main_item_party_table;   


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (isset($_POST['cus_name'])) {

           
  
                    $customer_data = [
                        'company_id'=>company($myid),
                        'display_name'=>strip_tags($this->request->getVar('cus_name')),
                        'phone'=>strip_tags($this->request->getVar('pop_phone')),
                        'email'=>strip_tags($this->request->getVar('pop_email')), 
                        'u_type'=>'customer',
                        'created_at'=>now_time($myid),
                        'serial_no'=>serial_no_customer(company($myid)), 
                        'main_type'=>'user' 
                       
                    ];

   


                    if ($UserModel->save($customer_data)) { 
                        $insidd=$UserModel->insertID();

                        
 

                        ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New '.strip_tags('customer').' <b>'.strip_tags($this->request->getVar('cus_name')).'</b> added(from selector).',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////


                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='New '.strip_tags('customer').' <b>'.strip_tags($this->request->getVar('cus_name')).'</b> added(from selector).';
                            $message='';
                            $url=base_url().'/customers'; 
                            $icon=notification_icons('user');
                            $userid='all';
                            $nread=0;
                            $for_who='admin';
                            $notid='user';
                            // notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='New '.strip_tags('customer').' <b>'.strip_tags($this->request->getVar('cus_name')).'</b> added(from selector).';
                            $message='';
                            $url=base_url().'/customers'; 
                            $icon=notification_icons('user');
                            $userid='all';
                            $nread=0;
                            $for_who='staff';
                            $notid='user';
                            // notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]


                            echo $insidd;

                      

                    }else{
                         echo 0;
                    }

 
 
        }
    }
}

    public function details($cusval=""){
        $session=session();
        $Main_item_party_table=new Main_item_party_table;   
        $PaymentsModel=new PaymentsModel;
        $InvoiceModel=new InvoiceModel;



        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            if (app_status(company($myid))==0) {redirect(base_url('app_error'));}

            // if (current_financial_year('financial_from',company($myid))=='no_financial_years') {redirect(base_url('settings/financial_years'));}

            



            $query=$Main_item_party_table->where('id',$myid)->first();

            $acti=activated_year(company($myid)); 
 
            $get_cust = $Main_item_party_table->where('id',$cusval)->first();


            $InvoiceModel->where('company_id',company($myid));
            $InvoiceModel->where('deleted',0)->orderBy('id','desc');



            $data = [
                'title' => 'Aitsun ERP-Customers',
                'user'=>$query,
                'cust'=> $get_cust,
                'all_invoices'=>$InvoiceModel->where('customer',$cusval)->findAll(), 
                'data_count'=>$InvoiceModel->countAllResults()
            ];

            if (isset($_POST['edit_customer'])) {

                $old_email=strip_tags($this->request->getVar('old_email'));
                $old_phone=strip_tags($this->request->getVar('old_phone'));


                $email=strip_tags($this->request->getVar('email'));
                $phone=strip_tags($this->request->getVar('phone'));


                if (user_email($cusval)==strip_tags(trim($this->request->getVar('email')))) {


                 if (strip_tags(trim($this->request->getVar('contact_name')))=='') {
                   $contactname=strip_tags($this->request->getVar('display_name'));
               }else{
                $contactname=strip_tags($this->request->getVar('contact_name'));
            }



            if (strip_tags(trim($this->request->getVar('location')))=='') {
               $looc=strip_tags($this->request->getVar('oldlocation'));
           }else{
            $looc=strip_tags($this->request->getVar('location'));
        }

        $op_balance=strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value'));

        $current_closing_balance=floatval(strip_tags($this->request->getVar('current_closing_balance')));
        $current_opening_balance=floatval(strip_tags($this->request->getVar('current_opening_balance')));


        $closing_balance=($current_closing_balance-$current_opening_balance) + floatval($op_balance);
        

        $customer_data = [
            'company_id'=>company($myid),
            'display_name'=>strip_tags($this->request->getVar('display_name')),
            'email'=>strip_tags(trim($this->request->getVar('email'))),
            'contact_name'=>$contactname, 
            'phone'=>strip_tags($this->request->getVar('phone')), 

            'credit_limit'=>aitsun_round(strip_tags($this->request->getVar('credit_limit')),get_setting(company($myid),'round_of_value')),
            'billing_name'=>strip_tags($this->request->getVar('billing_name')),
            'billing_mail'=>strip_tags($this->request->getVar('billing_mail')),
            'billing_country'=>strip_tags($this->request->getVar('billing_country')),
            'billing_city'=>strip_tags($this->request->getVar('billing_city')),
            'billing_postalcode'=>strip_tags($this->request->getVar('billing_postalcode')),
            'shipping_name'=>strip_tags($this->request->getVar('shipping_name')),
            'shipping_mail'=>strip_tags($this->request->getVar('shipping_mail')),
            'shipping_country'=>strip_tags($this->request->getVar('shipping_country')),
            'shipping_state'=>strip_tags($this->request->getVar('shipping_state')),
            'shipping_city'=>strip_tags($this->request->getVar('shipping_city')),
            'shipping_postatlcode'=>strip_tags($this->request->getVar('shipping_postatlcode')),
            'shipping_address'=>strip_tags($this->request->getVar('shipping_address')),
            'gst_no'=>strip_tags($this->request->getVar('gstno')),
            'u_type'=>strip_tags($this->request->getVar('party_type')),
            'opening_balance'=>$op_balance,
            'closing_balance'=>$closing_balance,
            'edit_effected'=>0,
            'website'=>strip_tags($this->request->getVar('website')),
            'billing_address'=>strip_tags($this->request->getVar('billing_address')),
            'billing_state'=>strip_tags($this->request->getVar('billing_state')),
            'area'=>strip_tags($this->request->getVar('area')),
            'landline'=>strip_tags($this->request->getVar('landline')),
            'company'=>strip_tags($this->request->getVar('company')),
            'location'=>$looc,
            'phone_2'=>strip_tags($this->request->getVar('phone_2')),
            'designation'=>strip_tags($this->request->getVar('designation')),
            'contact_type'=>strip_tags($this->request->getVar('contact_type')),
            'saved_as'=>strip_tags($this->request->getVar('savedas')),

            'country_code'=>strip_tags(trim($this->request->getVar('country_code'))),
            'part_category'=>strip_tags(trim($this->request->getVar('part_category'))),
        ];

// 
        $parties_result_status=1;
        $echo_result=0;
        if ($email!='') {
            if ($old_email!=$email) {
                $checkemail=$Main_item_party_table->where('company_id',company($myid))->where('email',strip_tags($this->request->getVar('email')))->where('deleted',0)->first();
                if (!$checkemail) {
                    $parties_result_status=1;
                }else{
                    $parties_result_status=0;
                    $echo_result=$session->setFlashdata('pu_er_msg', 'Email already exist!');;
                    return redirect()->to(current_url());
                }
            }
        }
        
        if ($phone!='') {
            if ($old_phone!=$phone) {
                $checkcode=$Main_item_party_table->where('company_id',company($myid))->where('phone',strip_tags($this->request->getVar('phone')))->where('deleted',0)->first();

                if (!$checkcode) {
                    $parties_result_status=1;
                }else{
                    $parties_result_status=0;
                    $echo_result=$session->setFlashdata('pu_er_msg', 'Phone already exit!');;
                    return redirect()->to(current_url());

                }
            }
        }


        if ($parties_result_status==1) {
            $insert_user=$Main_item_party_table->update($cusval,$customer_data);

            
 

            if ($insert_user) {


        ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>strip_tags($this->request->getVar('party_type')).'(#'.$cusval.')  <b>'.strip_tags($this->request->getVar('display_name')).'</b> details updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
    ////////////////////////END ACTIVITY LOG/////////////////
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(current_url());
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(current_url());
            }


        }else{
            $echo_result=$session->setFlashdata('pu_msg', 'Saved');;
            return redirect()->to(current_url());
        }
 // 



    }else{

        $old_email=strip_tags($this->request->getVar('old_email'));
        $old_phone=strip_tags($this->request->getVar('old_phone'));


        $email=strip_tags($this->request->getVar('email'));
        $phone=strip_tags($this->request->getVar('phone'));


        if (strip_tags(trim($this->request->getVar('contact_name')))=='') {
           $contactname=$this->request->getVar('display_name');
       }else{
        $contactname=$this->request->getVar('contact_name');
    }

    $op_balance=strip_tags($this->request->getVar('opening_type')).aitsun_round(strip_tags($this->request->getVar('opening_balance')),get_setting(company($myid),'round_of_value'));

        $current_closing_balance=floatval(strip_tags($this->request->getVar('current_closing_balance')));
        $current_opening_balance=floatval(strip_tags($this->request->getVar('current_opening_balance')));


        $closing_balance=($current_closing_balance-$current_opening_balance) + floatval($op_balance);
    
    $customer_data = [
        'company_id'=>company($myid),
        'display_name'=>strip_tags($this->request->getVar('display_name')),
        'email'=>strip_tags(trim($this->request->getVar('email'))),
        'contact_name'=>$contactname, 
        'phone'=>strip_tags($this->request->getVar('phone')), 

        'credit_limit'=>aitsun_round(strip_tags($this->request->getVar('credit_limit')),get_setting(company($myid),'round_of_value')),
        'billing_name'=>strip_tags($this->request->getVar('billing_name')),
        'billing_mail'=>strip_tags($this->request->getVar('billing_mail')),
        'billing_country'=>strip_tags($this->request->getVar('billing_country')),
        'billing_city'=>strip_tags($this->request->getVar('billing_city')),
        'billing_postalcode'=>strip_tags($this->request->getVar('billing_postalcode')),
        'shipping_name'=>strip_tags($this->request->getVar('shipping_name')),
        'shipping_mail'=>strip_tags($this->request->getVar('shipping_mail')),
        'shipping_country'=>strip_tags($this->request->getVar('shipping_country')),
        'shipping_state'=>strip_tags($this->request->getVar('shipping_state')),
        'shipping_city'=>strip_tags($this->request->getVar('shipping_city')),
        'shipping_postatlcode'=>strip_tags($this->request->getVar('shipping_postatlcode')),
        'shipping_address'=>strip_tags($this->request->getVar('shipping_address')),
        'gst_no'=>strip_tags($this->request->getVar('gstno')),
        'u_type'=>strip_tags($this->request->getVar('party_type')),
        'opening_balance'=>$op_balance,
        'closing_balance'=>$closing_balance,
        'edit_effected'=>0,
        'website'=>strip_tags($this->request->getVar('website')),
        'billing_address'=>strip_tags($this->request->getVar('billing_address')),
        'billing_state'=>strip_tags($this->request->getVar('billing_state')),
        'area'=>strip_tags($this->request->getVar('area')),
        'landline'=>strip_tags($this->request->getVar('landline')),
        'company'=>strip_tags($this->request->getVar('company')),
        'location'=>strip_tags($this->request->getVar('location')),
        'phone_2'=>strip_tags($this->request->getVar('phone_2')),
        'designation'=>strip_tags($this->request->getVar('designation')),
        'contact_type'=>strip_tags($this->request->getVar('contact_type')),
        'saved_as'=>strip_tags($this->request->getVar('savedas')), 
        'country_code'=>strip_tags(trim($this->request->getVar('country_code'))),
        'part_category'=>strip_tags(trim($this->request->getVar('part_category'))),
    ];
// start

    $parties_result_status=1;
    $echo_result=0;
      if ($email!='') {
            if ($old_email!=$email) {
                $checkemail=$Main_item_party_table->where('company_id',company($myid))->where('email',strip_tags($this->request->getVar('email')))->where('deleted',0)->first();
                if (!$checkemail) {
                    $parties_result_status=1;
                }else{
                    $parties_result_status=0;
                    $echo_result=$session->setFlashdata('pu_er_msg', 'Email already exit!');;
                    return redirect()->to(current_url());
                }
            }
        }
    if ($phone!='') {
       if ($old_phone!=$phone) {
        $checkcode=$Main_item_party_table->where('company_id',company($myid))->where('phone',strip_tags($this->request->getVar('phone')))->where('deleted',0)->first();

        if (!$checkcode) {
            $parties_result_status=1;
        }else{
            $parties_result_status=0;
            $echo_result=$session->setFlashdata('pu_er_msg', 'Phone already exit!');;
            return redirect()->to(current_url());

        }
    }
    }
    


    if ($parties_result_status==1) {

        $insert_user=$Main_item_party_table->update($cusval, $customer_data);

    

        if ($insert_user) {
        ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>strip_tags($this->request->getVar('party_type')).'(#'.$cusval.')  <b>'.strip_tags($this->request->getVar('display_name')).'</b> details updated.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];

            add_log($log_data);
    ////////////////////////END ACTIVITY LOG/////////////////
            $session->setFlashdata('pu_msg', 'Saved!');
            return redirect()->to(current_url());
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed to save!');
            return redirect()->to(current_url());
        }


    }else{
        $echo_result=$session->setFlashdata('pu_msg', 'Saved');;
        return redirect()->to(current_url());
    }


// end

}



}

echo view('header',$data);
echo view('customers/details', $data);
echo view('footer');

}else{
    return redirect()->to(base_url('users/login'));
}


}


public function delete($userid=""){           
    $session=session();
    $UserModel=new Main_item_party_table;
    $AccountingModel=new AccountingModel;
    $myid=session()->get('id');



    if (no_bills_of_user($userid,company($myid))>=1 || no_entries_of_user($userid,company($myid))>=1) {
        $session->setFlashdata('pu_er_msg', 'Failed to delete, delete all transactions before delete this party');
        return redirect()->to(base_url('customers/details/'.$userid));
    }else{


        $deledata=[
            'deleted'=>1,
            'edit_effected'=>0
        ];

        $del=$UserModel->update($userid,$deledata);



        if ($del) {
                        ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>get_cust_data($userid,'u_type').' (#'.$userid.')  <b>'.user_name($userid).'</b> is deleted.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];
            add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('customers'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed to delete!');
            return redirect()->to(base_url('customers'));
        }
    }


}




public function add_part_cate_from_ajax(){
    $session=session();
    $myid=session()->get('id');

    $con = array( 
        'id' => session()->get('id') 
    );

    $PartiesCategories = new PartiesCategories;

    if (isset($_POST['parties_cat_name'])) {

        $pc_data = [
            'company_id' => company($myid),
            'parties_cat_name'=>$this->request->getVar('parties_cat_name'),
        ];

        $ct=$PartiesCategories->save($pc_data);
        $cinserid=$PartiesCategories->insertID();

        if ($ct) {


           echo $cinserid;
       }else{

        echo 0;
    }
}
}





        // category //
public function parties_category()
{
    $session=session();
    $UserModel=new Main_item_party_table;
    $PartiesCategories=new PartiesCategories;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        // if (user_data(session()->get('id'),'activated_financial_year')<1) {
        //     return redirect()->to(base_url('settings/financial_years'));
        // }

        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }
        
        $UserModel->where('deleted',0);
        $UserModel->where('u_type!=','admin');
        $UserModel->where('u_type!=','superuser');
        
        $productategory = $PartiesCategories->where('company_id', company($myid))->where('deleted',0)->findAll();

        $data = [
            'title' => 'Aitsun ERP-Parties',
            'user'=>$user, 
            'p_category' => $productategory
        ]; 

        echo view('header',$data);
        echo view('customers/parties_category'); 
        echo view('footer');

    }else{
        return redirect()->to(base_url('users/login'));
    }

}

public function delete_product_cate($proval=""){
    $PartiesCategories = new PartiesCategories();
    $session=session();

    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );

    $parties_cat=$PartiesCategories->where('id',$proval)->first();

    $deledata=[
        'deleted'=>1
    ];


    if ($PartiesCategories->update($proval,$deledata)) {
            ////////////////////////CREATE ACTIVITY LOG//////////////
        $log_data=[
            'user_id'=>$myid,
            'action'=>'Product Category (#'.$proval.') <b>'.$parties_cat['parties_cat_name'].'</b> is deleted.',
            'ip'=>get_client_ip(),
            'mac'=>GetMAC(),
            'created_at'=>now_time($myid),
            'updated_at'=>now_time($myid),
            'company_id'=>company($myid),
        ];

        add_log($log_data);
            ////////////////////////END ACTIVITY LOG/////////////////

        $session->setFlashdata('pu_msg', 'Deleted!');
        return redirect()->to(base_url('parties_category'));
    }else{
        $session->setFlashdata('pu_er_msg', 'Failed to delete!');
        return redirect()->to(base_url('parties_category'));
    }
}

public function edit_category($cid=""){
    $session=session();
    $myid=session()->get('id');
    $UserModel=new Main_item_party_table;
    $PartiesCategories = new PartiesCategories;
    
    if ($this->request->getMethod('post')) {
        $clientdata=[
            'parties_cat_name'=>$this->request->getVar('parties_cat_name'),
        ];
        
    }     
    $user_update=$PartiesCategories->update($cid,$clientdata);
    if ($user_update) {

        $session->setFlashdata('pu_msg','Parties Saved!');
        return redirect()->to(base_url('parties_category'));
    }else{
        $session->setFlashdata('pu_er_msg','Failed to saved!');
        return redirect()->to(base_url('parties_category'));
    }
}


public function add_category(){
    $session=session();
    $myid=session()->get('id');
    $UserModel=new Main_item_party_table;
    $PartiesCategories = new PartiesCategories;
    
    if ($this->request->getMethod('post')) {
        $clientdata=[
            'company_id' => company($myid),
            'parties_cat_name'=>$this->request->getVar('parties_cat_name'),
        ];
        
    }     
    $user_update=$PartiesCategories->save($clientdata);
    if ($user_update) {

        $session->setFlashdata('pu_msg','Parties Saved!');
        return redirect()->to(base_url('parties_category'));
    }else{
        $session->setFlashdata('pu_er_msg','Failed to saved!');
        return redirect()->to(base_url('parties_category'));
    }
}

}
