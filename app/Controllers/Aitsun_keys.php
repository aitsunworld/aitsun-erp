<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ClientpaymentModel;
use App\Models\AlertSessionModel;


class Aitsun_keys extends BaseController
{
    public function index()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           


            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            //$key_user_data=$UserModel->where('company_id',company($myid))->where('author',1)->where('deleted',0)->findAll();
            $user_data=$UserModel->where('author',1)->where('deleted',0)->where('aitsun_user!=',1)->orderBy('id','desc')->where('main_type','user')->findAll();

           
            
            $data=[
                'title'=>'Manage clients',
                'user'=>$user,
                'user_data'=>$user_data
            ];

            echo view('header',$data);
            echo view('aitsun_keys/clients');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
        }

    public function add_clients()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           
            
            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            $data=[
                'title'=>'Add clients',
                'user'=>$user,
            ];

            echo view('header',$data);
            echo view('aitsun_keys/add_clients');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }


    public function save_client(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ClientpaymentModel = new ClientpaymentModel;
        $AlertSessionModel = new AlertSessionModel;

        // $billing_date=get_date_format(now_time($myid),'d M Y');

        if ($this->request->getMethod('post')) { 

            if (isset($_POST['online_shop'])) {
               $online_shop=$_POST['online_shop'];
            }else{
                $online_shop=0;
            }
            if (isset($_POST['crm'])) {
               $crm=$_POST['crm'];
            }else{
                $crm=0;
            }
            if (isset($_POST['restaurent'])) {
               $restaurent=$_POST['restaurent'];
            }else{
                $restaurent=0;
            }
            if (isset($_POST['hr_manage'])) {
               $hr_manage=$_POST['hr_manage'];
            }else{
                $hr_manage=0;
            }
            if (isset($_POST['medical'])) {
               $medical=$_POST['medical'];
            }else{
                $medical=0;
            }
            if (isset($_POST['is_school'])) {
               $is_school=$_POST['is_school'];
            }else{
                $is_school=0;
            }
            if (isset($_POST['is_website'])) {
               $is_website=$_POST['is_website'];
            }else{
                $is_website=0;
            }

            if (isset($_POST['is_appoinments'])) {
               $is_appoinments=$_POST['is_appoinments'];
            }else{
               $is_appoinments=0;
            }

            if (isset($_POST['is_clinic'])) {
               $is_clinic=$_POST['is_clinic'];
            }else{
               $is_clinic=0;
            }
            
            $clientdata=[
                'display_name'=>$this->request->getVar('display_name'),
                'email'=>$this->request->getVar('email'),
                'phone'=>$this->request->getVar('phone'),
                'created_at'=>now_time($myid),
                'password'=>$this->request->getVar('password'),
                'status'=>$this->request->getVar('status'),
                'lc_key'=>$this->request->getVar('lc_key'),
                'validity'=>$this->request->getVar('validity'),
                'packdate'=>$this->request->getVar('pack_date'),
                'packdate'=>$this->request->getVar('pack_date'),
                'aitsun_user'=>0,
                'online_shop'=>$online_shop,
                'price'=>$this->request->getVar('price'),
                'payment_method'=>$this->request->getVar('payment_method'),
                'crm'=>$crm,
                'medical'=>$medical,
                'app_status'=>$this->request->getVar('app_status'),
                'max_branch'=>$this->request->getVar('max_branch'),
                'max_user'=>$this->request->getVar('max_user'),
                'app'=>'pos',
                'year_end'=>$this->request->getVar('year_end'),
                'languages'=>$this->request->getVar('languages'),
                'restaurent'=>$restaurent,
                'hr_manage'=>$hr_manage,
                'monthly_billing_date'=>$this->request->getVar('monthly_billing_date'),
                'pos_payment_type'=>$this->request->getVar('pos_payment_type'),
                'author'=>1,
                'u_type'=>'admin',
                'main_type'=>'user',
                'school'=>$is_school,
                'is_website'=>$is_website,
                'is_appoinments'=>$is_appoinments, 
                'is_clinic'=>$is_clinic, 



            ];

            $checkemail=$UserModel->where('email',strip_tags($this->request->getVar('email')))->first();

        
            if(!$checkemail){
                $save_user=$UserModel->save($clientdata);
                $insert_id=$UserModel->insertID();
               
                if ($save_user) {
                    
                    create_billing($insert_id);

                    $session->setFlashdata('pu_msg','Client saved!');
                    return redirect()->to(base_url('aitsun_keys/add_clients'));
                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('aitsun_keys/add_clients'));
                }
            }else{
                $session->setFlashdata('pu_er_msg','Email already exists!');
                return redirect()->to(base_url('aitsun_keys/add_clients'));
            }
            
        }
    }
 

    public function details($cid=''){
        $session=session();
        $UserModel=new Main_item_party_table;

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();


        $us=$UserModel->where('id',$cid)->first();
        $data=[
            'title'=>'Client Details',
            'us'=>$us,
            'user'=>$user
        ];

        echo view('header',$data);
        echo view('aitsun_keys/details');
        echo view('footer');
        
    }

    public function edit_client($cid=""){
        $session=session();
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $ClientpaymentModel = new ClientpaymentModel;
        $AlertSessionModel = new AlertSessionModel;

        if ($this->request->getMethod('post')) {
            if (isset($_POST['online_shop'])) {
               $online_shop=$_POST['online_shop'];
            }else{
                $online_shop=0;
            }
            if (isset($_POST['crm'])) {
               $crm=$_POST['crm'];
            }else{
                $crm=0;
            }
            if (isset($_POST['restaurent'])) {
               $restaurent=$_POST['restaurent'];
            }else{
                $restaurent=0;
            }
            if (isset($_POST['hr_manage'])) {
               $hr_manage=$_POST['hr_manage'];
            }else{
                $hr_manage=0;
            }
            if (isset($_POST['medical'])) {
               $medical=$_POST['medical'];
            }else{
                $medical=0;
            }
            if (isset($_POST['is_school'])) {
               $is_school=$_POST['is_school'];
            }else{
                $is_school=0;
            }
            if (isset($_POST['is_website'])) {
               $is_website=$_POST['is_website'];
            }else{
                $is_website=0;
            }

            if (isset($_POST['is_appoinments'])) {
               $is_appoinments=$_POST['is_appoinments'];
            }else{
               $is_appoinments=0;
            }

            if (isset($_POST['is_clinic'])) {
               $is_clinic=$_POST['is_clinic'];
            }else{
               $is_clinic=0;
            }


            if(!empty(trim(strip_tags($this->request->getVar('password'))))){          

                $clientdata=[
                    'display_name'=>$this->request->getVar('display_name'),
                    'phone'=>$this->request->getVar('phone'),
                    'email'=>$this->request->getVar('email'),
                    'password'=>$this->request->getVar('password'),
                    'status'=>$this->request->getVar('status'),
                    'lc_key'=>$this->request->getVar('lc_key'),
                    'validity'=>$this->request->getVar('validity'),
                    'packdate'=>$this->request->getVar('pack_date'),
                    'aitsun_user'=>$this->request->getVar('aitsun_user'),
                    'online_shop'=>$this->request->getVar('online_shop'),
                    'price'=>$this->request->getVar('price'),
                    'payment_method'=>$this->request->getVar('payment_method'),
                    'crm'=>$this->request->getVar('crm'),
                    'medical'=>$this->request->getVar('medical'),
                    'app_status'=>$this->request->getVar('app_status'),
                    'max_branch'=>$this->request->getVar('max_branch'),
                    'max_user'=>$this->request->getVar('max_user'),
                    'app'=>'pos',
                    'year_end'=>$this->request->getVar('year_end'),
                    'languages'=>$this->request->getVar('languages'),
                    'restaurent'=>$restaurent,
                    'hr_manage'=>$hr_manage,
                    'monthly_billing_date'=>$this->request->getVar('monthly_billing_date'),
                    'pos_payment_type'=>$this->request->getVar('pos_payment_type'),
                    'u_type'=>'admin',
                    'main_type'=>'user',
                    'school'=>$is_school,
                    'is_website'=>$is_website,
                    'is_appoinments'=>$is_appoinments,
                    'is_clinic'=>$is_clinic,

                ];
            }else{
                $clientdata=[
                    'display_name'=>$this->request->getVar('display_name'),
                    'phone'=>$this->request->getVar('phone'),
                    'email'=>$this->request->getVar('email'),
                    'status'=>$this->request->getVar('status'),
                    'lc_key'=>$this->request->getVar('lc_key'),
                    'validity'=>$this->request->getVar('validity'),
                    'packdate'=>$this->request->getVar('pack_date'),
                    'aitsun_user'=>$this->request->getVar('aitsun_user'),
                    'online_shop'=>$this->request->getVar('online_shop'),
                    'price'=>$this->request->getVar('price'),
                    'payment_method'=>$this->request->getVar('payment_method'),
                    'crm'=>$this->request->getVar('crm'),
                    'medical'=>$this->request->getVar('medical'),
                    'app_status'=>$this->request->getVar('app_status'),
                    'max_branch'=>$this->request->getVar('max_branch'),
                    'max_user'=>$this->request->getVar('max_user'),
                    'app'=>'pos',
                    'year_end'=>$this->request->getVar('year_end'),
                    'languages'=>$this->request->getVar('languages'),
                    'restaurent'=>$restaurent,
                    'hr_manage'=>$hr_manage,
                    'monthly_billing_date'=>$this->request->getVar('monthly_billing_date'),
                    'pos_payment_type'=>$this->request->getVar('pos_payment_type'),
                    'u_type'=>'admin',
                    'main_type'=>'user',
                    'school'=>$is_school,
                    'is_website'=>$is_website,
                    'is_appoinments'=>$is_appoinments,
                    'is_clinic'=>$is_clinic,
                ];
            }


            $checkemail=$UserModel->where('email',strip_tags($this->request->getVar('email')))->first();
        
            if (user_email($cid)==strip_tags(trim($this->request->getVar('email')))) {
                $user_update=$UserModel->update($cid,$clientdata);

                if ($user_update) {

                $clientpay_data=$ClientpaymentModel->where('client_id',$cid)->first();

                if (!empty($clientpay_data['id'])) {
                   $alert_session_data=$AlertSessionModel->where('bill_id',$clientpay_data['id'])->findAll();

                    foreach ($alert_session_data as $alt) {
                        
                        $AlertSessionModel->where('id',$alt['id'])->delete();
                    }
                }

                $ClientpaymentModel->where('client_id',$cid)->delete();

                $check_month_date=$UserModel->where('id',$cid)->first();

                $client_monthly_billing=$check_month_date['monthly_billing_date'];

                $curr_date=get_date_format(now_time($myid),'d');;


                $temp_billing_date=get_date_format(now_time($myid),'Y-m').'-'.$client_monthly_billing;

                $pos_payment_type=$check_month_date['pos_payment_type'];
                    

                    if ($pos_payment_type=='monthly') {
                        if ($curr_date<$client_monthly_billing) {
                            $billing_date = date('Y-m-d', strtotime($temp_billing_date));
                        }else{
                            $billing_date = date('Y-m-d', strtotime('+1 month', strtotime($temp_billing_date)));
                        }
                    }else{
                        if ($curr_date<$client_monthly_billing) {
                            $billing_date = date('Y-m-d', strtotime($temp_billing_date));
                        }else{
                            $billing_date = date('Y-m-d', strtotime('+1 year', strtotime($temp_billing_date)));
                        }
                    }
                    
                    $date1=date('Y-m-d', strtotime('-2 days', strtotime($billing_date)));
                    $date2=date('Y-m-d', strtotime('-1 days', strtotime($billing_date)));
                    $date3=date('Y-m-d', strtotime('0 days', strtotime($billing_date)));
                    $date4=date('Y-m-d', strtotime('+1 days', strtotime($billing_date)));                

                    $csdata = [
                        'client_id'=>$cid,
                        'company_id'=>company($myid),
                        'status'=>'pending',
                        'datetime'=> now_time($myid),
                        'billing_date'=> $billing_date,
                        'date1'=>$date1,
                        'date2'=>$date2,
                        'date3'=>$date3,
                        'date4'=>$date4,
                        'datetime'=>now_time($myid),
                    ];

                    $ClientpaymentModel->save($csdata);
                    $insert_id1=$ClientpaymentModel->insertID();


                    $dates_array=[

                        $date1.' 06:00:00',
                        $date1.' 16:00:00',
                        $date2.' 06:00:00',
                        $date2.' 16:00:00',
                        $date3.' 06:00:00',
                        $date3.' 16:00:00',
                        $date4.' 06:00:00',
                        $date4.' 16:00:00',
                    ];


                    foreach ($dates_array as $fd) {
                        $ntdata = [
                            'bill_id'=>$insert_id1,
                            'status'=>'running',
                            'datetime'=>$fd,
                        ];
                        $AlertSessionModel->save($ntdata);
                    }
                    $session->setFlashdata('pu_msg','Client saved!');
                    return redirect()->to(base_url('aitsun_keys/details').'/'.$cid);
                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('aitsun_keys/details').'/'.$cid);
                }
            }else{

                if(!$checkemail){
                     $user_update=$UserModel->update($cid,$clientdata);
                    if ($user_update) {

                        $session->setFlashdata('pu_msg','Client saved!');
                        return redirect()->to(base_url('aitsun_keys/details').'/'.$cid);
                    }else{
                        $session->setFlashdata('pu_er_msg','Failed to saved!');
                        return redirect()->to(base_url('aitsun_keys/details').'/'.$cid);
                    }
                }else{
                    $session->setFlashdata('pu_er_msg','Email already exists!');
                    return redirect()->to(base_url('aitsun_keys/details').'/'.$cid);
                }
            }
        }
    }


    public function client_status($cid=""){
        $session=session();
        $UserModel=new Main_item_party_table;

        if ($this->request->getMethod('post')) {
        
            $clientdata=[
                
                'app_status'=>$this->request->getVar('client_status'),
               
            ];
      

            if ($UserModel->update($cid,$clientdata)) {
              echo 1;
               
            }else{
               echo 0;
            }
    
        }
    }


    public function payment_status($billid=""){
        $session=session();
        $ClientpaymentModel=new ClientpaymentModel;
        $myid=session()->get('id');
        if ($this->request->getMethod('post')) {
        
            $clientdata=[  
                'status'=>$_POST['statusname'],
            ];

            if ($_POST['statusname']=='paid') {
                $dateq=$ClientpaymentModel->where('deleted',0)->where('id',$billid)->orderBy('id','desc')->first();
           
                if ($dateq) {
                    if ($dateq['status']=='paid') {
                        create_billing($dateq['client_id']);
                    }
                }
                    
            }
            

            if ($ClientpaymentModel->update($billid,$clientdata)) {
                
              echo 1;
               
            }else{
               echo 0;
            }
    
        }
    }

    
    public function delete_users($cid=" "){
        $session=session();
        $usermodel = new Main_item_party_table();
        if ($this->request->getMethod('post')) {   
            $clientdata=[
                'deleted'=>1,
            ];         
            if ($usermodel->update($cid,$clientdata)) {
                echo 1;
            }else{
                echo 0;
                
            }
        }
    }


    public function payment()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $ClientpaymentModel=new ClientpaymentModel;

            $UserModel=new Main_item_party_table;
            $alert_data= new AlertSessionModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            // $AlertSessionModel=$AlertSessionModel->where('id',$myid)->findAll();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           
            
            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

           
// update status

$dateq=$ClientpaymentModel->where('company_id',company($myid))->where('status!=','paid')->where('status!=','under review')->where('deleted',0)->findAll();
    foreach ($dateq as $ri) {
        $pos_payment_type=get_cust_data($ri['client_id'],'pos_payment_type');
        $client_monthly_billing=get_cust_data($ri['client_id'],'monthly_billing_date');

        $temp_billing_date=get_date_format(now_time($myid),'Y-m').'-'.$client_monthly_billing;

        $billing_date = date('Y-m-d', strtotime('+1 month', strtotime($temp_billing_date)));
                    
        $date1=date('Y-m-d', strtotime('-2 days', strtotime($billing_date)));
        $date2=date('Y-m-d', strtotime('-1 days', strtotime($billing_date)));
        $date3=date('Y-m-d', strtotime('0 days', strtotime($billing_date)));
        $date4=date('Y-m-d', strtotime('+1 days', strtotime($billing_date)));


        

        if ($pos_payment_type=='yearly') {
            $three_days_before=$date1;
            $two_days_before=$date2;
            $curr_date=get_date_format(now_time($myid),'Y-m-d');

            if($curr_date>$ri['billing_date']){
                $rddt = array('status' => 'over due');
                $ClientpaymentModel->update($ri['id'],$rddt);   
            }elseif($curr_date==$ri['billing_date']){
                $rddt = array('status' => 'due');
                $ClientpaymentModel->update($ri['id'],$rddt); 
            }else{
                $rddt = array('status' => 'pending');
                $ClientpaymentModel->update($ri['id'],$rddt);               
            }
        }else{
            $three_days_before=$date1;
            $two_days_before=$date2;       
            $curr_date=get_date_format(now_time($myid),'Y-m-d');

            if($curr_date>$ri['billing_date']){
                $rddt = array('status' => 'over due');
                $ClientpaymentModel->update($ri['id'],$rddt);
            }elseif($curr_date==$ri['billing_date']){
                $rddt = array('status' => 'due');
                $ClientpaymentModel->update($ri['id'],$rddt);
            }else{
                $rddt = array('status' => 'pending');
                $ClientpaymentModel->update($ri['id'],$rddt);
            }
        }
       
    }
// update status

        $bill_data=$ClientpaymentModel->where('deleted',0)->orderBy('id','desc')->findAll();

            $data=[
                'title'=>'Clients Payment',
                'user'=>$user,
                'bill_data'=>$bill_data, 
            ];

            echo view('header',$data);
            echo view('aitsun_keys/client_payment');
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function payment_dashboard()
    {

          $session=session();

          if ($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $ClientpaymentModel=new ClientpaymentModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

               

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

// update status

    $dateq=$ClientpaymentModel->where('deleted',0)->where('status!=','paid')->where('status!=','under review')->where('client_id',app_super_user(company($myid)))->orderBy('id','desc')->findAll();
        foreach ($dateq as $ri) {
            $pos_payment_type=get_cust_data($ri['client_id'],'pos_payment_type');
            $client_monthly_billing=get_cust_data($ri['client_id'],'monthly_billing_date');

            $temp_billing_date=get_date_format(now_time($myid),'Y-m').'-'.$client_monthly_billing;

            $billing_date = date('Y-m-d', strtotime('+1 month', strtotime($temp_billing_date)));
            
            $date1=date('Y-m-d', strtotime('-2 days', strtotime($billing_date)));
            $date2=date('Y-m-d', strtotime('-1 days', strtotime($billing_date)));
            $date3=date('Y-m-d', strtotime('0 days', strtotime($billing_date)));
            $date4=date('Y-m-d', strtotime('+1 days', strtotime($billing_date)));

            if ($pos_payment_type=='yearly') {
                $three_days_before=$date1;
                $two_days_before=$date2;
                $curr_date=get_date_format(now_time($myid),'Y-m-d');

                if($curr_date>$ri['billing_date']){
                    $rddt = array('status' => 'over due');
                    $ClientpaymentModel->update($ri['id'],$rddt);
                }elseif($curr_date==$ri['billing_date']){
                    $rddt = array('status' => 'due');
                    $ClientpaymentModel->update($ri['id'],$rddt); 
                }else{
                    $rddt = array('status' => 'pending');
                    $ClientpaymentModel->update($ri['id'],$rddt); 
                }

            }else{
                $three_days_before=$date1;
                $two_days_before=$date2;
                $curr_date=get_date_format(now_time($myid),'Y-m-d');
                if($curr_date>$ri['billing_date']){
                    $rddt = array('status' => 'over due');
                    $ClientpaymentModel->update($ri['id'],$rddt);
                }elseif($curr_date==$ri['billing_date']){
                    $rddt = array('status' => 'due');
                    $ClientpaymentModel->update($ri['id'],$rddt);
                }else{
                    $rddt = array('status' => 'pending');
                    $ClientpaymentModel->update($ri['id'],$rddt);
                }
            }
        }

               
        $client_data=$ClientpaymentModel->where('deleted',0)->where('client_id',$myid)->orderBy('id','desc')->findAll();

         $data = [
             'title' => 'Aitsun ERP-Settings',
             'user'=>$user,
             'client_data'=>$client_data,

         ];

            echo view('header',$data);
            echo view('aitsun_keys/payment_dashboard', $data);
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }

    }

    public function delete_client_payment($cid=""){
        $session=session();
        $ClientpaymentModel = new ClientpaymentModel();
        if ($this->request->getMethod('post')) {            
            if ($ClientpaymentModel->delete($cid)) {
                echo 1;
            }else{
                echo 0;
                
            }
        }
    }


    

    
}
        

    
                    
                  
                
