<?php
namespace App\Controllers;  
use App\Models\Main_item_party_table; 
use App\Models\PosSessions; 
use App\Models\CompanySettings; 
use App\Models\InvoiceModel; 
 
 

class Pos extends BaseController
{
 
     public function index()
     {
        $session=session();
        $UserModel=new Main_item_party_table; 
        $PosSessions=new PosSessions; 


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid));

            $last_session_cash=0;
            $last_session_date=0;
            
            $lssdata=$PosSessions->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->first();
            if ($lssdata) {
                $last_session_cash=$lssdata['closing_balance'];
                $last_session_date=$lssdata['date'];
            }


            $data = [
                'title' => 'POS - Aitsun ERP',
                'user'=>$user,   
                'last_session_cash'=>$last_session_cash,   
                'last_session_date'=>$last_session_date,   
            ];

            echo view('header',$data);
            echo view('pos/index', $data);
            echo view('footer');     
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function create(){
        $session=session();
        $UserModel=new Main_item_party_table; 
        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid));


     


            $data = [
                'title' => 'POS - Aitsun ERP',
                'user'=>$user,  
                'view_method'=>'create',
                'view_type'=>'sales',
                'invoice_type'=>'sales',
                

            ];
 
            echo view('pos/create', $data);    
            
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    
    public function open_session(){

        $session=session();
        $UserModel=new Main_item_party_table; 
        $ProductsModel = new Main_item_party_table();
        $PosSessions = new PosSessions();


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 

            if ($this->request->getMethod()=='post') {
                $sesdata=[ 
                    'date'=>now_time($myid),
                    'closing_balance'=>aitsun_round(strip_tags(htmlentities(trim($this->request->getVar('opening_cash')))),get_setting(company($myid),'round_of_value')),
                    'Note'=>strip_tags(htmlentities(trim($this->request->getVar('opening_note')))),
                    'company_id'=>company($myid),
                    'deleted'=>0,
                    'user_id'=>$myid
                ];


                if ($PosSessions->save($sesdata)) { 

                    $insert_id=$PosSessions->insertID();

                    $ProductsModel = new Main_item_party_table(); 
                    $acti=activated_year($sesdata['company_id']);
                    $ProductsModel->where('is_pos',1);
                    $get_pro = $ProductsModel->where('company_id',company($sesdata['user_id']))->orderBy("id", "desc")->where('deleted',0)->where('financial_year',$acti)->where('main_type','product')->findAll(); 

                    $get_cust = $UserModel->where('u_type!=','staff')->where('u_type!=','driver')->where('u_type!=','teacher')->where('u_type!=','delivery')->where('u_type!=','seller')->where('u_type!=','admin')->where('u_type!=','student')->where('company_id',company($myid))->where('deleted',0)->where('main_type','user')->orderBy('id','DESC')->findAll();

                    
                    $set_data=[ 
                        'date'=>now_time($myid),
                        'closing_balance'=>aitsun_round(strip_tags(htmlentities(trim($this->request->getVar('opening_cash')))),get_setting(company($myid),'round_of_value')),
                        'Note'=>strip_tags(htmlentities(trim($this->request->getVar('opening_note')))),
                        'company_id'=>company($myid),
                        'deleted'=>0,
                        'user_id'=>$myid,
                        'products'=>$get_pro,
                        'customers'=>$get_cust,
                        'session_id'=>$insert_id,
                    ];

                    if ($this->setPosSession($set_data)) {
                        echo 1;
                    }else{
                        echo 0;
                    }  
                }else{
                    echo 0;
                }
            }else{
                echo 0;
            }
            
        }else{
            echo 0;
        }

    }

    public function close_register(){
        if (session()->has('pos_session')) { 
            session()->remove('pos_session');
            return redirect()->to(base_url('pos'));
        }else{
            return redirect()->to(base_url('pos'));
        }
    }

    private function setPosSession($sesdata){ 
        $posdata = $sesdata; 
        session()->set('pos_session',$posdata);
        return true;
    } 

    public function change_pos_mode($mode=0){
        $session=session();
        if($session->has('isLoggedIn')){
            $CompanySettings= new CompanySettings;
            $myid=session()->get('id');
            $etqry = $CompanySettings->where('company_id',company($myid))->first();

            $clientdata=[ 
                'pos_focus_element'=>$mode
            ];

            if ($CompanySettings->update(get_setting(company($myid),'id'),$clientdata)) {
                echo 1;
            }else{
                echo 0;
            }       
        }else{
            echo 0;
        } 
    }


    public function orders()
     {
        $session=session();
        $UserModel=new Main_item_party_table; 
        $PosSessions=new PosSessions; 
        $InvoiceModel=new InvoiceModel; 


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            if (!$_GET) {
            $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
            }else {



                if (isset($_GET['invoice_no'])) {
                    if (!empty($_GET['invoice_no'])) {
                        $InvoiceModel->where('serial_no',$_GET['invoice_no']);
                    }
                }

               



                if (isset($_GET['customer'])) {
                    if (!empty($_GET['customer'])) {
                        $InvoiceModel->where('customer',$_GET['customer']);
                    }
                }
                if (isset($_GET['cust_name'])) {
                    if (!empty($_GET['cust_name'])) {
                        $InvoiceModel->like('alternate_name',$_GET['cust_name']);
                    }
                }

                if (isset($_GET['from']) && isset($_GET['to'])) {
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if (!empty($from) && empty($dto)) {
                        $InvoiceModel->where('invoice_date',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $InvoiceModel->where('invoice_date',$dto);
                    }

                    if (!empty($dto) && !empty($from)) {
                        $InvoiceModel->where("invoice_date BETWEEN '$from' AND '$dto'");
                    }

                                // if (empty($dto) && empty($from)) {
                                //     $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                                // }
                }




            }


          
            $InvoiceModel->where('invoice_type','sales');
            $InvoiceModel->where('bill_type','pos');
            $InvoiceModel->where('deleted',4);

            $InvoiceModel->where('company_id',company($myid));
            
            $InvoiceModel->orderBy('id','desc');

                        // $InvoiceModel->where('financial_year',$acti);

            $all_invoices=$InvoiceModel->findAll();


            $data = [
                'title' => 'POS - Orders',
                'user'=>$user,
                'all_invoices'=>$all_invoices, 
            'view_type'=>'sales'      
            ];

            echo view('header',$data);
            echo view('pos/orders', $data);
            echo view('footer');     
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


}
