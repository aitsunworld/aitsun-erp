<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\FinancialYears;
use App\Models\PaymentsModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceitemsModel;
use App\Models\Logs;
use App\Models\LeadModel;
use App\Models\TaskreportModel;
use App\Models\FollowersModel;
use App\Models\AccountCategory;
use App\Models\CustomerBalances;
use App\Models\ProductrequestsModel; 
use App\Models\AttendanceModel;

class Aitsun_special_reports extends BaseController {
    public function index()
    {

        $session=session();

        if($session->has('isLoggedIn')){

        
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function day_end_summary(){
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

            

            $data = [
                'title' => 'Day End Summary',
                'user'=>$user,  
            ];

            echo view('header',$data);
            echo view('aitsun_special_reports/day_end_summary', $data);
            echo view('footer');
        
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function sale()
    {
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
            
             
            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid));     

            if ($_GET) {
                if (isset($_GET['from'])) {
                     $from=$_GET['from'];
                }

                if (isset($_GET['to'])) {
                     $dto=$_GET['to'];
                }
                
                if (isset($_GET['type'])) {
                    if (!empty($_GET['type'])) {
                        $InvoiceModel->where('invoice_type',$_GET['type']);
                    }
                } 

                if (!empty($from) && empty($dto)) {
                    $InvoiceModel->where('date(invoice_date)',$from);
                }
                if (!empty($dto) && empty($from)) {
                    $InvoiceModel->where('date(invoice_date)',$dto);
                }

                
                if (!empty($dto) && !empty($from)) {
                    $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                }

                if (!empty($_GET['status'])) {
                     $InvoiceModel->where('lead_status',$_GET('status'));
                }
            }else{
                $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
            }


            $daybookdata = $InvoiceModel->where('company_id',company($myid))->groupStart()->where('invoice_type','sales')->orWhere('invoice_type','sales_return')->groupEnd()->where('deleted',0)->findAll();

         
         

            $data = [
                'title' => 'Aitsun ERP-Sales report',
                'user'=>$user,
                'day_book_data'=>$daybookdata, 
            ];

            echo view('header',$data);
            echo view('aitsun_special_reports/sale', $data);
            echo view('footer');
            
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function purchase()
    {
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
            
             
            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid));     

            if ($_GET) {
                if (isset($_GET['from'])) {
                     $from=$_GET['from'];
                }

                if (isset($_GET['to'])) {
                     $dto=$_GET['to'];
                }
                
                if (isset($_GET['type'])) {
                    if (!empty($_GET['type'])) {
                        $InvoiceModel->where('invoice_type',$_GET['type']);
                    }
                } 

                if (!empty($from) && empty($dto)) {
                    $InvoiceModel->where('date(invoice_date)',$from);
                }
                if (!empty($dto) && empty($from)) {
                    $InvoiceModel->where('date(invoice_date)',$dto);
                }

                
                if (!empty($dto) && !empty($from)) {
                    $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                }

                if (!empty($_GET['status'])) {
                     $InvoiceModel->where('lead_status',$_GET('status'));
                }
            }else{
                $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
            }


            $daybookdata = $InvoiceModel->where('company_id',company($myid))->groupStart()->where('invoice_type','purchase')->orWhere('invoice_type','purchase_return')->groupEnd()->where('deleted',0)->findAll();

         
         

            $data = [
                'title' => 'Aitsun ERP - Purchase Report',
                'user'=>$user,
                'day_book_data'=>$daybookdata, 
            ];

            echo view('header',$data);
            echo view('aitsun_special_reports/purchase', $data);
            echo view('footer');
            
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function day_book()
        {

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

                   

                     

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));

                 

                    

                    if ($_GET) {

                        if (isset($_GET['from'])) {
                             $from=$_GET['from'];
                        }

                        if (isset($_GET['to'])) {
                             $dto=$_GET['to'];
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

                        if (!empty($_GET['voucher_no'])) {
                             $PaymentsModel->where('serial_no',$_GET['voucher_no']);
                        }

                        

                         if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('collected_by',$_GET['collected_user']);
                            }
                        }
                        
                    }else{
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }

                    if (get_setting(company($myid),'hide_deleted')) {
                        $PaymentsModel->where('deleted',0);
                    }

                    $daybookdata = $PaymentsModel->where('company_id',company($myid))->orderBy('id','DESC')->findAll();

                   
                    

                    $data = [
                        'title' => 'Aitsun ERP-Day book',
                        'user'=>$user,
                        'day_book_data'=>$daybookdata, 
                    ];

                    echo view('header',$data);
                    echo view('aitsun_special_reports/daybook', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


    public function all_transactions()
        {

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

                  
                     

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));

                 

                    

                    if ($_GET) {

                        if (isset($_GET['from'])) {
                             $from=$_GET['from'];
                        }

                        if (isset($_GET['to'])) {
                             $dto=$_GET['to'];
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

                        if (!empty($_GET['voucher_no'])) {
                             $PaymentsModel->where('serial_no',$_GET['voucher_no']);
                        }

                        

                         if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('collected_by',$_GET['collected_user']);
                            }
                        }
                        
                    }else{
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }

                    if (get_setting(company($myid),'hide_deleted')) {
                        $PaymentsModel->where('deleted',0);
                    }

                    $daybookdata = $PaymentsModel->where('company_id',company($myid))->orderBy('id','DESC')->findAll();

                   
                    

                    $data = [
                        'title' => 'Aitsun ERP- All Transactions',
                        'user'=>$user,
                        'day_book_data'=>$daybookdata, 
                    ];

                    echo view('header',$data);
                    echo view('aitsun_special_reports/all_transactions', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }



        public function bill_wise_profit()
        {

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
          
             
            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid));     

            if ($_GET) {
                if (isset($_GET['from'])) {
                     $from=$_GET['from'];
                }

                if (isset($_GET['to'])) {
                     $dto=$_GET['to'];
                }
                
                if (isset($_GET['customer'])) {
                    if (!empty($_GET['customer'])) {
                        $InvoiceModel->where('customer',$_GET['customer']);
                    }
                }

                if (!empty($from) && empty($dto)) {
                    $InvoiceModel->where('date(invoice_date)',$from);
                }
                if (!empty($dto) && empty($from)) {
                    $InvoiceModel->where('date(invoice_date)',$dto);
                }

                
                if (!empty($dto) && !empty($from)) {
                    $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                }

                if (!empty($_GET['status'])) {
                     $InvoiceModel->where('lead_status',$_GET('status'));
                }
            }else{
                $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
            }


            $daybookdata = $InvoiceModel->where('company_id',company($myid))->where('invoice_type','sales')->where('deleted',0)->findAll();

                   
                    

                    $data = [
                        'title' => 'Aitsun ERP- Profit on sale invoices',
                        'user'=>$user,
                        'day_book_data'=>$daybookdata, 
                    ];

                    echo view('header',$data);
                    echo view('aitsun_special_reports/bill-wise-profit', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }

}