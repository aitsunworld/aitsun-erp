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
use App\Models\AccountingModel;
use App\Models\AttendanceModel;



class Reports extends BaseController {

        public function index()
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

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));

                 

                    

                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

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
                    echo view('reports/day_book', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }

    public function profit_report()
        {

            $session=session();

            if($session->has('isLoggedIn')){


                    $UserModel=new Main_item_party_table;
                    $InvoiceModel= new InvoiceModel;
                    $InvoiceitemsModel= new InvoiceitemsModel;

                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();

                    $report_f_date=now_time($myid);
                    $report_t_date='';


                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));



                    $invoice_items_array=array();
                     

                    $InvoiceModel->groupStart();
                    $InvoiceModel->where('deleted',0);
                    $InvoiceModel->orWhere('deleted',4);
                    $InvoiceModel->groupEnd();

                    $InvoiceModel->groupStart();
                    $InvoiceModel->where('invoice_type','sales');
                    $InvoiceModel->orWhere('invoice_type','sales_return');
                    $InvoiceModel->orWhere('invoice_type','purchase');
                    $InvoiceModel->orWhere('invoice_type','purchase_return');
                    $InvoiceModel->groupEnd();

                    $InvoiceModel->where('company_id',company($myid));
                    $InvoiceModel->orderBy('id','desc');

                    

                    if ($_GET) {
                        

                        if (isset($_GET['from']) && isset($_GET['to'])) {
                            $from=$_GET['from'];
                            $dto=$_GET['to'];
                            if (!empty($from) && empty($dto)) {
                                $InvoiceModel->where('invoice_date',$from);
                                $report_f_date=$from;
                                 
                            }

                            if (empty($from) && !empty($dto)) {
                                $InvoiceModel->where('invoice_date',$dto);
                                $report_f_date=$dto;
                            }

                            if (empty($dto) && empty($from)) {
                                  $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                            }
                            if (!empty($dto) && !empty($from)) {
                                $InvoiceModel->where("invoice_date BETWEEN '$from' AND '$dto'");
                                $report_f_date=$from;
                                $report_t_date=$dto; 
                            }
                        }else{
                            $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                        }
                        
                        
                    }else{
                        $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                    }

                    $invoices_all=[];
                    $all_invoices=$InvoiceModel->findAll();
                    
                    
                    $invoices_array=[];
                    $total_sum=0;

                   
                    if (count($all_invoices)>0) {
                        $InvoiceitemsModel->select('product_id');
                        $countin=0;
                        foreach ($all_invoices as $ai) {  
                             array_push($invoices_array, $ai['id']); 
                             $countin++;
                            if ($countin>1) {
                                $InvoiceitemsModel->orWhere('invoice_id',$ai['id']); 
                            }else{
                                $InvoiceitemsModel->where('invoice_id',$ai['id']);
                             } 
                        }

                        if ($_GET) {
                            if (isset($_GET['product_name'])) {
                                $InvoiceitemsModel->like('product', $_GET['product_name'], 'both'); 
                            }
                        }
                        $invoices_all=$InvoiceitemsModel->groupBy('product_id')->findAll();

                    }
                    
                   


                    $data = [
                        'title' => 'Aitsun ERP-Profit Reports',
                        'user'=>$user,
                        // 'total_sum'=>$total_sum,
                        'invoice_items'=>$invoice_items_array,
                        'report_f_date'=>$report_f_date,
                        'report_t_date'=>$report_t_date,
                        'invoices_all'=>$invoices_all,
                        'invoices_array'=>$invoices_array

                    ];

                    echo view('header',$data);
                    echo view('reports/profit_report', $data);
                    echo view('footer');
            
            }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


        public function item_wise_sales_report()
        {

            $session=session();

            if($session->has('isLoggedIn')){


                    $UserModel=new Main_item_party_table;
                    $InvoiceModel= new InvoiceModel;
                    $InvoiceitemsModel= new InvoiceitemsModel;

                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();

                    $report_f_date=now_time($myid);
                    $report_t_date='';


                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));



                    $invoice_items_array=array();
                    
                    $InvoiceitemsModel->select('invoice_items.product,invoice_items.invoice_date,sum(invoice_items.quantity) as sum_quantity,sum(invoice_items.amount) as sum_amount, invoices.id');
                    $InvoiceitemsModel->join('invoices', 'invoices.id = invoice_items.invoice_id', 'left');

                    if ($_GET) {

                        if (isset($_GET['product_name'])) {
                            $InvoiceitemsModel->like('invoice_items.product', $_GET['product_name'], 'both'); 
                        }
                        

                        if (isset($_GET['from']) && isset($_GET['to'])) {
                            $from=$_GET['from'];
                            $dto=$_GET['to'];
                            if (!empty($from) && empty($dto)) {
                                $InvoiceitemsModel->where('invoice_items.invoice_date',$from);
                                $report_f_date=$from;
                                 
                            }

                            if (empty($from) && !empty($dto)) {
                                $InvoiceitemsModel->where('invoice_items.invoice_date',$dto);
                                $report_f_date=$dto;
                            }

                            if (empty($dto) && empty($from)) {
                                  $InvoiceitemsModel->where('invoice_items.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                            }
                            if (!empty($dto) && !empty($from)) {
                                $InvoiceitemsModel->where("invoice_items.invoice_date BETWEEN '$from' AND '$dto'");
                                $report_f_date=$from;
                                $report_t_date=$dto; 
                            }
                        }else{
                            $InvoiceitemsModel->where('invoice_items.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                        }
                        
                        
                    }else{
                        $InvoiceitemsModel->where('invoice_items.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                    }


                    $invoice_items_array=$InvoiceitemsModel->where('invoice_items.deleted',0)->where('invoices.company_id',company($myid))->groupBy('invoice_items.product_id')->findAll();


                    $data = [
                        'title' => 'Aitsun ERP-Item wise sales report',
                        'user'=>$user,
                        // 'total_sum'=>$total_sum,
                        'invoice_items_array'=>$invoice_items_array,
                        'report_f_date'=>$report_f_date,
                        'report_t_date'=>$report_t_date, 

                    ];

                    echo view('header',$data);
                    echo view('reports/item_wise_sales_report', $data);
                    echo view('footer');
            
            }else{
                    return redirect()->to(base_url('users/login'));
                }
        }

        
        public function sales_report()
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

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));

                 

                    

                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

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
                    }else{
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }


                    $daybookdata = $PaymentsModel->where('company_id',company($myid))->groupStart()->where('bill_type','sales')->orWhere('bill_type','sales_return')->groupEnd()->where('deleted',0)->findAll();

                    $debit_sum=0;
                    $credit_sum=0;

                    foreach ($daybookdata as $sv) {

                        if ($sv['bill_type']=='expense' || $sv['bill_type']=='purchase' || $sv['bill_type']=='sales_return'){
                            $debit_sum+=$sv['amount'];
                        }elseif ($sv['bill_type']=='receipt' || $sv['bill_type']=='sales' || $sv['bill_type']=='purchase_return'){
                            $credit_sum+=$sv['amount'];
                        }
                        
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Sales report',
                        'user'=>$user,
                        'day_book_data'=>$daybookdata,
                        'debit_sum'=>$debit_sum,
                        'credit_sum'=>$credit_sum,
                    ];

                    echo view('header',$data);
                    echo view('reports/sales_report', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


        public function expense_report()
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

                

                 
                  
                 $acti=activated_year(company($myid));

              
                


                $PaymentsModel->select('payments.*, main_item_party_table.group_head,main_item_party_table.id as aid');
                $PaymentsModel->join('main_item_party_table', 'main_item_party_table.id = payments.account_name', 'left');


                if ($_GET) {
                    if (!isset($_GET['etype'])) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('payments.collected_by',$_GET['collected_user']);
                            }
                        }

                        if (isset($_GET['accounts'])) {
                            if (!empty($_GET['accounts'])) {
                                $PaymentsModel->where('main_item_party_table.id',$_GET['accounts']);
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
                    $PaymentsModel->where('date(payments.datetime)',get_date_format(now_time($myid),'Y-m-d'));
                }


                $PaymentsModel->where('payments.company_id',company($myid));
                $PaymentsModel->where('payments.deleted',0);
                $PaymentsModel->groupStart();
                    $PaymentsModel->where('payments.bill_type','expense');
                    $PaymentsModel->orWhere('payments.bill_type','purchase');
                    $PaymentsModel->orWhere('payments.bill_type','sales_return');
                    $PaymentsModel->orWhere('payments.bill_type','discount_allowed');
                $PaymentsModel->groupEnd();

                $expensedata = $PaymentsModel->findAll();

                

                $data = [
                    'title' => 'Aitsun ERP-Expenses report',
                    'user'=>$user,
                    'day_book_data'=>$expensedata, 
                ];

             
                    echo view('header',$data); 
                    echo view('reports/expenses_report', $data);
                    echo view('footer');
                
        
    }else{
                return redirect()->to(base_url('users/login'));
            }
    }




        public function discount_reports()
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

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));

                 
 ;
                    

                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (!empty($from) && empty($dto)) {
                            $PaymentsModel->where('date(datetime)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $PaymentsModel->where('date(datetime)',$dto);
                        }

                        
                        if (!empty($dto) && !empty($from)) {
                            $PaymentsModel->where("date(datetime) BETWEEN '$from' AND '$dto'");
                        }
 
                    }else{
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }


                    $daybookdata = $PaymentsModel->where('discount>',0)->where('company_id',company($myid))->groupStart()->where('bill_type','sales')->orWhere('bill_type','sales_return')->orWhere('bill_type','purchase')->orWhere('bill_type','purchase_return')->groupEnd()->where('deleted',0)->orderBy('id','DESC')->findAll();

                   

                    $data = [
                        'title' => 'Aitsun ERP-Discount report',
                        'user'=>$user,
                        'day_book_data'=>$daybookdata, 
                    ];

                    echo view('header',$data);
                    echo view('reports/discount_report', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }




      public function vendors_report(){

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

                

                 
                  
                $acti=activated_year(company($myid));

        
            
                $PaymentsModel->select('payments.*, invoices.id,main_item_party_table.id,invoices.due_amount,invoices.total,invoices.customer');
                $PaymentsModel->join('invoices', 'invoices.id = payments.invoice_id', 'left');
                $PaymentsModel->join('main_item_party_table', 'main_item_party_table.id = payments.customer', 'left');



                if ($_GET) {
                    if (!isset($_GET['etype'])) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('payments.collected_by',$_GET['collected_user']);
                            }
                        }

                        if (isset($_GET['type'])) {
                            if (!empty($_GET['type'])) {
                                $PaymentsModel->where('payments.bill_type',$_GET['type']);
                            }
                        } 

                        if (isset($_GET['customers'])) {
                            if (!empty($_GET['customers'])) {
                                $PaymentsModel->where('invoices.customer',$_GET['customers']);
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
                    $PaymentsModel->where('payments.datetime',get_date_format(now_time($myid),'Y-m-d'));
                }


                $PaymentsModel->where('payments.company_id',company($myid));
                $PaymentsModel->where('payments.deleted',0);
                $PaymentsModel->groupStart();
                    $PaymentsModel->where('payments.bill_type','expense');
                    $PaymentsModel->orWhere('payments.bill_type','purchase');
                $PaymentsModel->groupEnd();

                $vendors_data = $PaymentsModel->findAll();

                

                $data = [
                    'title' => 'Aitsun ERP - Vendors report',
                    'user'=>$user,
                    'vendors_data'=>$vendors_data, 
                ];

             
                    echo view('header',$data); 
                    echo view('reports/vendors_report', $data);
                    echo view('footer');
                
        
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function item_reports(){

        $session=session();

        if($session->has('isLoggedIn')){


                $UserModel=new Main_item_party_table;
                $InvoiceitemsModel= new InvoiceitemsModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                 
                  
                $acti=activated_year(company($myid));

        
            
                $InvoiceitemsModel->select('invoice_items.*, products.id,invoices.id,invoices.invoice_date,products.product_name');
                $InvoiceitemsModel->join('products', 'products.id = invoice_items.product_id', 'left');
                $InvoiceitemsModel->join('invoices', 'invoices.id = invoice_items.invoice_id', 'left');




                if ($_GET) {
                    if (!isset($_GET['etype'])) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                   
                        if (!empty($from) && empty($dto)) {
                            $InvoiceitemsModel->where('date(invoices.invoice_date)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $InvoiceitemsModel->where('date(invoices.invoice_date)',$dto);
                        }

                        if (!empty($dto) && !empty($from)) {
                            $InvoiceitemsModel->where("date(invoices.invoice_date) BETWEEN '$from' AND '$dto'");
                        }

                        if (isset($_GET['product'])) {
                            if (!empty($_GET['product'])) {
                                $InvoiceitemsModel->where('products.id',$_GET['product']);
                            }
                        }
                   
                    }
                }else{
                    $InvoiceitemsModel->where('invoices.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                }


                $InvoiceitemsModel->where('invoices.company_id',company($myid));
                $InvoiceitemsModel->where('invoices.deleted',0);
                
                $InvoiceitemsModel->groupStart();
                    $InvoiceitemsModel->where('invoices.invoice_type','sales');
                    $InvoiceitemsModel->orWhere('invoices.invoice_type','sales_return');
                    $InvoiceitemsModel->orWhere('invoices.invoice_type','purchase');
                    $InvoiceitemsModel->orWhere('invoices.invoice_type','purchase_return');
                $InvoiceitemsModel->groupEnd();

                $item_data = $InvoiceitemsModel->findAll();

                

                $data = [
                    'title' => 'Aitsun ERP - Vendors report',
                    'user'=>$user,
                    'item_data'=>$item_data, 
                ];

             
                    echo view('header',$data); 
                    echo view('reports/item_reports', $data);
                    echo view('footer');
                
        
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }



        public function cash_book()
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

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $acti=activated_year(company($myid));
                    $cash_data=[];
                 
                    if (!$_GET) {
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }else {

                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        
                        if (isset($_GET['p_type'])) {
                            if (!empty($_GET['p_type'])) {
                                $PaymentsModel->where('type',$_GET['p_type']);
                            }
                        }

                        if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('collected_by',$_GET['collected_user']);
                            }
                        }

                        if (!empty($_GET['voucher_no'])) {
                             $PaymentsModel->where('serial_no',$_GET['voucher_no']);
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
                    }

                        if (get_setting(company($myid),'hide_deleted')) {
                            $PaymentsModel->where('deleted',0);
                        }

 $bn=0;
                        $totalbc=count(cash_in_bank_array(company($myid)));

                        $PaymentsModel->where('company_id',company($myid));


                        foreach (cash_in_hand_array(company($myid)) as $cb) {
                           
                            $bn++;
                            if ($bn>1) {

                                $PaymentsModel->groupStart();
                            }
                            if ($bn<2) { 
                                $PaymentsModel->where('type',$cb['id']);
                                $cash_data=$PaymentsModel->orderBy('id','DESC')->findAll();
                                 
                            }else{
                                $PaymentsModel->orWhere('type',$cb['id']);

                            }
                            if ($bn>1) {

                                if ($totalbc==($cn-1)) { 
                                    $PaymentsModel->groupEnd();
                                     $cash_data=$PaymentsModel->orderBy('id','DESC')->findAll();
                                }
                                
                            }
                            
                        }

                    $debit_sum=0;
                    $credit_sum=0;

                   

                    $data = [
                        'title' => 'Aitsun ERP - Cash Book',
                        'user'=>$user,
                        'cash_data'=>$cash_data, 
                    ];

                    echo view('header',$data);
                    echo view('reports/cash_book', $data);
                    echo view('footer');
            
            }else{
                    return redirect()->to(base_url('users/login'));
                }
        }

        public function bank_book()
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

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));
                     $bank_data=[];
                 
                    if (!$_GET) {
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }else {

                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        
                        if (isset($_GET['p_type'])) {
                            if (!empty($_GET['p_type'])) {
                                $PaymentsModel->where('type',$_GET['p_type']);
                            }
                        }

                         if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) {
                                $PaymentsModel->where('collected_by',$_GET['collected_user']);
                            }
                        }

                        if (!empty($_GET['voucher_no'])) {
                             $PaymentsModel->where('serial_no',$_GET['voucher_no']);
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
                    }

                        if (get_setting(company($myid),'hide_deleted')) {
                            $PaymentsModel->where('deleted',0);
                        }

                        $bn=0;
                        $totalbc=count(cash_in_bank_array(company($myid)));

                        $PaymentsModel->where('company_id',company($myid));


                        foreach (cash_in_bank_array(company($myid)) as $cb) {
                           
                            $bn++;
                            if ($bn>1) {

                                $PaymentsModel->groupStart();
                            }
                            if ($bn<2) { 
                                $PaymentsModel->where('type',$cb['id']);
                                $bank_data=$PaymentsModel->orderBy('id','DESC')->findAll();
                                 
                            }else{
                                $PaymentsModel->orWhere('type',$cb['id']);

                            }
                            if ($bn>1) {

                                if ($totalbc==($cn-1)) { 
                                    $PaymentsModel->groupEnd();
                                     $bank_data=$PaymentsModel->orderBy('id','DESC')->findAll();
                                }
                                
                            }
                            
                        }

                    // $PaymentsModel->where('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Bank Accounts'));

                   

                    $debit_sum=0;
                    $credit_sum=0;

                   

                    $data = [
                        'title' => 'Aitsun ERP-Bank Book',
                        'user'=>$user,
                        'bank_data'=>$bank_data
                    ];

                    echo view('header',$data);
                    echo view('reports/bank_book', $data);
                    echo view('footer');
            
            }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


    public function credit_statement($account=""){

        $session=session();

            if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $InvoiceModel= new InvoiceModel;
                $pager = \Config\Services::pager();

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
                        $InvoiceModel->where('invoice_type','sales');
                        $InvoiceModel->groupEnd();
                    }else{
                        $InvoiceModel->where('invoice_type','purchase');
                    }

                    $all_invoices=$InvoiceModel->where('company_id',company($myid))->where('paid_status','unpaid')->orderBy('id','DESC')->where('deleted',0)->paginate(25);


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
                        'acccount'=>$account,
                        'pager' =>$InvoiceModel->pager,
                    ];



                    echo view('header',$data);
                    echo view('reports/credit_statement', $data);
                    echo view('footer');
                }else{
                   return redirect()->to(base_url());
                }

                }else{
                   return redirect()->to(base_url('users/login'));
                }
        }




        public function fees_outstanding_statement(){

        $session=session();

            if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $InvoiceModel= new InvoiceModel;

                $pager = \Config\Services::pager();

                
                        
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
                    
                    
                    
                    $InvoiceModel->groupStart();
                    $InvoiceModel->orWhere('invoice_type','challan');
                    $InvoiceModel->groupEnd();
                    

                    $all_invoices=$InvoiceModel->where('company_id',company($myid))->where('paid_status','unpaid')->orderBy('id','DESC')->where('deleted',0)->paginate(25);


                    $amounttt=0;
                    $due_amounttt=0;

                    foreach ($all_invoices as $sv) {
                        $amounttt+=$sv['total'];
                        $due_amounttt+=$sv['due_amount'];
                    }


                    
                    $data = [
                        'title' => 'Aitsun ERP - Fees Outstanding Statement',
                        'user'=>$user,
                        'all_invoices'=>$all_invoices,
                        'total_amount'=>$amounttt,
                        'total_due_amount'=>$due_amounttt,
                        
                        'pager' =>$InvoiceModel->pager,
                    ];


                    echo view('header',$data);
                    echo view('reports/fees_outstanding_statement', $data);
                    echo view('footer');
                

                }else{
                   return redirect()->to(base_url('users/login'));
                }
        }

        public function user_wise_report()
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

                    

                    if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

                     if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                     $acti=activated_year(company($myid));

                 

                    

                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

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
                        if (isset($_GET['collected_user'])) {
                            if (!empty($_GET['collected_user'])) { 
                                $PaymentsModel->where('collected_by',$_GET['collected_user']);
                            }
                        }
                    }else{
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }


                    $daybookdata = $PaymentsModel->where('company_id',company($myid))->groupStart()->where('bill_type','sales')->orWhere('bill_type','sales_return')->groupEnd()->where('deleted',0)->orderBy('collected_by','DESC')->findAll();

                    $debit_sum=0;
                    $credit_sum=0;

                    foreach ($daybookdata as $sv) {

                        if ($sv['bill_type']=='expense' || $sv['bill_type']=='purchase' || $sv['bill_type']=='sales_return'){
                            $debit_sum+=$sv['amount'];
                        }elseif ($sv['bill_type']=='receipt' || $sv['bill_type']=='sales' || $sv['bill_type']=='purchase_return'){
                            $credit_sum+=$sv['amount'];
                        }
                        
                    }

                    $data = [
                        'title' => 'Aitsun ERP-User wise report',
                        'user'=>$user,
                        'day_book_data'=>$daybookdata,
                        'debit_sum'=>$debit_sum,
                        'credit_sum'=>$credit_sum,
                    ];

                    echo view('header',$data);
                    echo view('reports/user_wise_report', $data);
                    echo view('footer');
            
        }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


        public function student_attendance_reports()
        {
            $session=session();
            $user=new Main_item_party_table();
            $AttendanceModel = new AttendanceModel();
            $myid=session()->get('id');
            
            if ($session->has('isLoggedIn')) {
                $usaerdata=$user->where('id', session()->get('id'))->first();
                
                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    $std_attendance_data=$AttendanceModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->findAll();

                    
                    $data=[
                        'title'=>'Student Attendance Reports | Erudite ERP',
                        'user'=>$usaerdata,
                        'std_attendance_data'=>$std_attendance_data,
                        
                    ];
                    
                        echo view('header',$data);
                        echo view('reports/student_attendance_reports');
                        echo view('footer');
                
            }else{
                return redirect()->to(base_url('users'));
            }       
        }



        public function stock_reports(){

                    $session=session();
                if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;

                    $pager = \Config\Services::pager();

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


                    if($_GET){
                        if(isset($_GET['product_name'])){ 

                            if (isset($_GET['product_name'])) {
                                if (!empty($_GET['product_name'])) {
                                    $UserModel->like('product_name', $_GET['product_name'], 'both'); 
                                }
                            }
                     
                        }

                        if (isset($_GET['pro_main_category'])) {
                            if (!empty($_GET['pro_main_category'])) {
                                $UserModel->where('category',$_GET['pro_main_category']);
                            }
                        } 

                        if (isset($_GET['stocks']) && !empty($_GET['stocks'])) {
                            if ($_GET['stocks'] == 'out_of_stock') {
                                $UserModel->where('closing_balance <', 0);
                            } elseif ($_GET['stocks'] == 'in_stock') {
                                $UserModel->where('closing_balance >=', 1);
                            }
                        } 
                    } 

                    $pro_data=$UserModel->where('company_id',company($myid))->where('deleted',0)->where('main_type','product')->where('product_method','product')->orderBy('id','DESC');

                    if (isset($_POST['get_excel'])){
                        $pro_data=$UserModel->findAll();
                    }else{
                        $pro_data=$UserModel->paginate(1000);
                    }
                  


                     $data = [
                        'title' => 'Aitsun ERP - Stock Reports',
                        'user'=>$user,
                        'stock_data'=> $pro_data,
                        'pager'=>$UserModel->pager
                       
                    ];

                   

                    if (isset($_POST['get_excel'])) {
                             $fileName = "Stock reports-".get_date_format(now_time($myid),'d M Y').".xls"; 
                
                                // Column names 
                                    $fields = array('#PRODUCT', 'OPENING STOCK', 'CURRENT STOCK', 'STOCK VALUE'); 

                                    
                                    
                                             // print_r($fields);

                                            // Display column names as first row 
                                    $excelData = implode("\t", array_values($fields)) . "\n"; 
                                    $total_stock_value=0; 
                                            // Fetch records from database 
                                    $query = $pro_data; 
                                    if(count($query) > 0){ 
                                                // Output each row of the data 
                                        $total_stock_value=0;
                                        foreach ($query as $row) {

                                            $ex_opening_stock='';
                                            $ex_current_stock='';
                                            $ex_stock_value='';

                                            $ex_opening_stock.=$row['opening_balance'].$row['unit'];

                                            if (!empty($row['sub_unit'])) {
                                                $ex_opening_stock.='('.$row['opening_balance']*$row['conversion_unit_rate'].' '.$row['sub_unit'].')';
                                            }


                                            $ex_current_stock.=$row['closing_balance'].$row['unit'];

                                            if (!empty($row['sub_unit'])) {
                                                $ex_current_stock.='('.$row['closing_balance']*$row['conversion_unit_rate'].' '.$row['sub_unit'].')';
                                            }


                              

                                            $ex_stock_value=aitsun_round($row['final_closing_value'],get_setting(company($user['id']),'round_of_value'));

                                            $total_stock_value+=aitsun_round($row['final_closing_value'],get_setting(company($user['id']),'round_of_value'));
                      
                                            
                                            $colllumns=array($row['product_name'],$ex_opening_stock,$ex_current_stock,$ex_stock_value);
                                            
                                            

                                            array_walk($colllumns, 'filterData');
                                            $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
                                            
                                        }

                                        $footer_colllumns=array('','','Total',aitsun_round($total_stock_value,get_setting(company($user['id']),'round_of_value')));
                                        array_walk($footer_colllumns, 'filterData');
                                            $excelData .= implode("\t", array_values(str_replace('\n', '', $footer_colllumns))) . "\n";

                                    }else{ 
                                        $excelData .= 'No records found...'. "\n"; 
                                    } 
                                    
                                            // // Headers for download 
                                    header("Content-Type: application/vnd.ms-excel"); 
                                    header("Content-Disposition: attachment; filename=\"$fileName\""); 
                                    
                                            // Render excel data 
                                    echo $excelData; 
                                    
                                    exit;
                    }else{
                        echo view('header',$data);
                        echo view('reports/stock_report', $data);
                        echo view('footer');

                    }
            
        }else{
            return redirect()->to(base_url('users/login'));
        }


    }



     public function profit_and_loss()
        {
             $session=session();
                if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;

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

                 
                    
                    $data = [
                        'title' => 'Aitsun ERP-Profit & Loss A/C',
                        'user'=>$user,
                        
                    ];

                    echo view('header',$data);
                    echo view('reports/profit_and_loss', $data);
                    // echo view('comming_soon', $data);
                    echo view('footer');
            
        }else{
            redirect(base_url('users/login'));
        }
    }

   public function activity_logs()
    {

        $session=session();
        if($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $Logs= new Logs;


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            $results_per_page = 12; 

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

             

            if (usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            if ($_GET) {
                 
           
                if (isset($_GET['logs'])) {
                    if (!empty($_GET['logs'])) {
                        $Logs->like('action',$_GET['logs'],'both');
                    }
                }

                if (isset($_GET['from']) && isset($_GET['to'])) {
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if (!empty($from) && empty($dto)) {
                        $Logs->where('date(created_at)',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $Logs->where('date(created_at)',$dto);
                    }

                    if (!empty($dto) && !empty($from)) {
                        $Logs->where("date(created_at) BETWEEN '$from' AND '$dto'");
                    }

                    // if (empty($dto) && empty($from)) {
                    //     $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                    // }
                } 
                
            }

            $losdata=$Logs->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0)->paginate(50);

            $data = [
                'title' => 'Aitsun ERP- Activity logs',
                'user'=>$user,
                'all_logs'=>$losdata,
                'pager' => $Logs->pager,
            ];
            

            if (check_main_company($myid)==true) {
                if (check_branch_of_main_company(company($myid))==true) {

                    if (usertype($myid)=='admin') {
                        echo view('header',$data);
                        echo view('reports/activity_logs', $data);
                        echo view('footer');
                    }else{
                       return redirect()->to(base_url());
                    }

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


    public function clear_all(){

        $session=session();
        $Logs= new Logs;
        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );


        if (usertype($myid) =='admin') {
            $log_data=$Logs->where('company_id',company($myid))->where('deleted',0)->findAll();

            foreach ($log_data as $du) {
                $Logs->find($du['id']);
                $deledata=[
                    'deleted'=>1
                ];

                $clmsg=$Logs->update($du['id'],$deledata);
            }
            


            if ($clmsg) {
                $session->setFlashdata('pu_msg', 'Activity logs cleared!');
                return redirect()->to(base_url('reports/activity_logs?page=1'));

            }else{
                $session->setFlashdata('pu_er_msg', 'Failed!');
                return redirect()->to(base_url('reports/activity_logs?page=1'));
            }
        }else{return redirect()->to(base_url());}
        

    }


    public function clear_20(){
        
        $session=session();
        $Logs= new Logs;
        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );

        if (usertype($myid) =='admin') {
            $delrow=$Logs->where('company_id',company($myid))->where('deleted',0)->findAll(20);
           
            foreach ($delrow as $dr) {

                $updata=[
                    'deleted'=>1
                ];

                $Logs->update($dr['id'],$updata);
            }
            $session->setFlashdata('pu_msg', 'Activity logs cleared!');
            return redirect()->to(base_url('reports/activity_logs?page=1'));

        }else{return redirect()->to(base_url());}
        

       
    }


    public function crm_reports($lead_id="")
        {
             $session=session();
                if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $TaskreportModel= new TaskreportModel;
                    $LeadModel= new LeadModel;

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

                    if($_GET){
                        if(isset($_GET['from']) && isset($_GET['to'])){
                            $from=$_GET['from'];
                            $to=$_GET['to'];

                            if (isset($_GET['lead_name'])) {
                                if (!empty($_GET['lead_name'])) {
                                    $LeadModel->like('lead_name', $_GET['lead_name'], 'both'); 
                                }
                            }
                    
                            if(!empty($from) && empty($to)){
                                $LeadModel->where('lead_date',$from);
                            }
                            if(!empty($to) && empty($from)){
                                $LeadModel->where('lead_date',$to);
                            }
                            if (!empty($from) && !empty($to)) {
                                $LeadModel->where("lead_date BETWEEN '$from' AND '$to'");
                
                            }
                        }
                        
                        
                    }


                    if (!empty($lead_id)) {
                        $leadthis=$LeadModel->where('id',$lead_id)->first();
                        if ($leadthis) {
                           $crm_report=$TaskreportModel->where('company_id',company($myid))->where('lead_id',$lead_id)->orderBy('id','DESC')->findAll();
                        
                            $data = [
                                'title' => 'Aitsun ERP-CRM Reports',
                                'user'=>$user,
                                'crm_report'=>$crm_report,
                                'ld'=>$leadthis
                                
                            ];

                            if (is_crm(company($myid))) {

                            echo view('header',$data);
                            echo view('reports/crm_reports', $data);
                            echo view('footer');
                            }else{
                                return redirect()->to(base_url());
                            }
                        }else{
                                return redirect()->to(base_url('reports/crm_reports'));
                            }
                        
                    }else{
                        
                        $all_leads=$LeadModel->where('deleted', 0)->where('lead_department!=', 'purchase')->where('company_id',company($myid))->orderBy('id', 'desc')->findAll();

                        $data = [
                            'title' => 'Aitsun ERP-CRM Reports',
                            'user'=>$user,
                            'leads'=>$all_leads
                        ];

                        if (is_crm(company($myid))) {
                            echo view('header',$data);
                            echo view('reports/crm_reports_select_lead', $data);
                            echo view('footer');
                        }else{
                            return redirect()->to(base_url());
                        }
                    }
            
        }else{
            redirect(base_url('users/login'));
        }
    }

    public function crm_purchase_reports($lead_id="")
        {
            $session=session();
                if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $TaskreportModel= new TaskreportModel;
                    $LeadModel= new LeadModel;
                    $FollowersModel= new FollowersModel;

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


                    if ($_GET) {
                        if (isset($_GET['lead_name'])) {
                            if (!empty($_GET['lead_name'])) {
                                    $LeadModel->like('lead_name',trim($_GET['lead_name']),'both');
                            }
                        }
                        if (isset($_GET['lpo'])) {
                            if (!empty($_GET['lpo'])) {
                                    $LeadModel->like('lpo',trim($_GET['lpo']),'both');
                            }
                        }
                        if (isset($_GET['quotation_no'])) {
                            if (!empty($_GET['quotation_no'])) {
                                    $LeadModel->like('quotation_no',trim($_GET['quotation_no']),'both');
                            }
                        }

                         if (isset($_GET['lead_status'])) {
                            if (!empty($_GET['lead_status'])) {
                                    $LeadModel->where('lead_status',trim($_GET['lead_status']));
                            }
                        }

                        

                        if (isset($_GET['from']) && isset($_GET['to'])) {
                            $from=$_GET['from'];
                            $dto=$_GET['to'];

                            if (!empty($from) && empty($dto)) {
                                $LeadModel->where('DATE(lead_date)',$from);
                            }
                            if (!empty($dto) && empty($from)) {
                                $LeadModel->where('DATE(lead_date)',$dto);
                            }

                            if (!empty($dto) && !empty($from)) {
                                $LeadModel->where("DATE(lead_date) BETWEEN '$from' AND '$dto'");
                            }

                        }
                    }


                    $all_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->orderBy('id', 'desc')->findAll();


                    $data = [
                        'title' => 'Aitsun ERP-Purchase Confirmation Reports',
                        'user'=>$user,
                        'leads'=>$all_leads
                    ];

                    if (is_crm(company($myid))) {
                       
                        echo view('header',$data);
                        echo view('reports/crm_purchase_reports', $data);
                        echo view('footer');
                    }else{
                        return redirect()->to(base_url());
                    }       
        }else{
            redirect(base_url('users/login'));
        }
    }


    public function crm_overall_reports($lead_id="")
        {
            $session=session();
                if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $TaskreportModel= new TaskreportModel;
                    $LeadModel= new LeadModel;
                    $FollowersModel= new FollowersModel;

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

                    $all_leads=array();
                        
                    if ($_GET) {

                        if (!empty($this->request->getGet('follower'))) {
                            $flowers=$FollowersModel->where('follower_id',$this->request->getGet('follower'))->findAll();
                           
                            foreach ($flowers as $flr) {
                                $from=$this->request->getGet('from');
                                $dto=$this->request->getGet('to');

                              if (!empty($from) && empty($dto)) {
                                  $LeadModel->where('date(start_date)',$from);
                              }
                              if (!empty($dto) && empty($from)) {
                                  $LeadModel->where('date(start_date)',$dto);
                              }
                          
                              if (!empty($dto) && !empty($from)) {
                                  $LeadModel->where("date(start_date) BETWEEN '$from' AND '$dto'");
                              }
                              if (!empty($this->request->getGet('status'))) {
                                $LeadModel->where('lead_status',$this->request->getGet('status'));
                              }


                              if (!empty($this->request->getGet('followers'))) {
                                $LeadModel->where('followers',$this->request->getGet('followers'));
                              }

                              if (!empty($this->request->getGet('project_type'))) {
                                $LeadModel->where('project_type',$this->request->getGet('project_type'));
                              } 
                              if (!empty($this->request->getGet('lead_by'))) {
                                $LeadModel->where('lead_by',$this->request->getGet('lead_by'));
                              } 


                                $folola=$LeadModel->where('deleted', 0)->where('lead_department!=', 'purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->orderBy('id', 'desc')->findAll();
                                foreach ($folola as $fl) {
                                     array_push($all_leads, $fl);
                                }
                            }
                        }else{
                              $from=$this->request->getGet('from');
                              $dto=$this->request->getGet('to');

                              if (!empty($from) && empty($dto)) {
                                  $LeadModel->where('date(start_date)',$from);
                              }
                              if (!empty($dto) && empty($from)) {
                                  $LeadModel->where('date(start_date)',$dto);
                              }
                          
                              if (!empty($dto) && !empty($from)) {
                                  $LeadModel->where("date(start_date) BETWEEN '$from' AND '$dto'");
                              }
                              if (!empty($this->request->getGet('status'))) {
                                $LeadModel->where('lead_status',$this->request->getGet('status'));
                              }

                              if (!empty($this->request->getGet('followers'))) {
                                $LeadModel->where('followers',$this->request->getGet('followers'));
                              }

                              if (!empty($this->request->getGet('project_type'))) {
                                $LeadModel->where('project_type',$this->request->getGet('project_type'));
                              } 

                              if (!empty($this->request->getGet('lead_by'))) {
                                $LeadModel->where('lead_by',$this->request->getGet('lead_by'));
                              } 
                              

                              if (!empty($this->request->getGet('follower'))) {
                                $LeadModel->where('project_type',$this->request->getGet('project_type'));
                              } 

                            $all_leads=$LeadModel->where('deleted', 0)->where('lead_department!=', 'purchase')->where('company_id',company($myid))->orderBy('id', 'desc')->findAll();
                        }

                    }else{
                        $all_leads=$LeadModel->where('deleted', 0)->where('lead_department!=', 'purchase')->where('company_id',company($myid))->orderBy('id', 'desc')->findAll();
                    }

                    $data = [
                        'title' => 'Aitsun ERP-CRM Reports',
                        'user'=>$user,
                        'leads'=>$all_leads
                    ];

                    if (is_crm(company($myid))) {
                       
                        echo view('header',$data);
                        echo view('reports/crm_overall_reports', $data);
                        echo view('footer');
                    }else{
                        return redirect()->to(base_url());
                    }       
        }else{
            redirect(base_url('users/login'));
        }
    }



    public function referral_reports(){

        $session=session();
        if($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $InvoiceModel= new InvoiceModel;
            $PaymentsModel= new PaymentsModel;

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

             $employee_data=$UserModel->where('main_compani_id',main_company_id($myid))->where('deleted',0)->where('u_type!=','customer')->where('u_type!=','vendor')->where('u_type!=','seller')->where('u_type!=','delivery')->orderBy('display_name','ASC')->findAll();


             if (!$_GET) {
                }else {
                     

                    if (isset($_GET['referral'])) {
                        if (!empty($_GET['referral'])) {
                            $InvoiceModel->where('inv_referal',$_GET['referral']);
                        }
                    }
                 
                }


            $referral_data=$InvoiceModel->where('company_id',company($myid))->where('deleted',0)->where('inv_referal>',0)->orderBy('inv_referal','DESC')->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'))->findAll();
          


             $data = [
                'title' => 'Aitsun ERP - Referral Reports',
                'user'=>$user,
                'employee_data'=>$employee_data,
                'referral_data'=> $referral_data,
               
            ];

            echo view('header',$data);
            echo view('reports/referral_report', $data);
            echo view('footer');
    
        }else{
            return redirect()->to(base_url('users/login'));
        }

    }




public function receipt_payment()
    {

        $session=session();

        if($session->has('isLoggedIn')){


                $UserModel=new Main_item_party_table;
                $PaymentsModel= new PaymentsModel;
                $P_PaymentsModel= new PaymentsModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 

                  
                 $acti=activated_year(company($myid));

             

                

                if ($_GET) {

                            $from=$_GET['from'];
                            $dto=$_GET['to'];

                            if (isset($_GET['collected_user'])) {
                                if (!empty($_GET['collected_user'])) {
                                    $PaymentsModel->where('collected_by',$_GET['collected_user']);
                                    $P_PaymentsModel->where('collected_by',$_GET['collected_user']);
                                }
                            }


                            if (!empty($from) && empty($dto)) {
                                $PaymentsModel->where('date(datetime)',$from);
                                $P_PaymentsModel->where('date(datetime)',$from);
                            }
                            if (!empty($dto) && empty($from)) {
                                $PaymentsModel->where('date(datetime)',$dto);
                                $P_PaymentsModel->where('date(datetime)',$dto);
                            }

                            
                            if (!empty($dto) && !empty($from)) {
                                $PaymentsModel->where("date(datetime) BETWEEN '$from' AND '$dto'");
                                $P_PaymentsModel->where("date(datetime) BETWEEN '$from' AND '$dto'");
                            }

                            if (!empty($_GET['status'])) {
                                 $PaymentsModel->where('lead_status',$_GET('status'));
                                 $P_PaymentsModel->where('lead_status',$_GET('status'));
                            }
                        
                }else{
                    $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    $P_PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                }


                $receipts = $PaymentsModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0)->where('bill_type!=','expense')->where('bill_type!=','sales_return')->where('bill_type!=','purchase')->where('bill_type!=','discount_allowed')->findAll();


                $payments = $P_PaymentsModel->where('company_id',company($myid))->where('deleted',0)->groupStart()->where('bill_type','expense')->orWhere('bill_type','purchase')->orWhere('bill_type','sales_return')->orWhere('bill_type','discount_allowed')->groupEnd()->orderBy('id','DESC')->findAll();

                 
              

                $data = [
                    'title' => 'Erudite ERP-Receipts & Payments',
                    'user'=>$user,
                    'all_receipts'=>$receipts, 
                    'all_payments'=>$payments, 
                ];

                    echo view('header',$data);
                    echo view('reports/receipt_payment');
                    echo view('footer');
               
        
            }else{
                return redirect()->to(base_url('users/login'));
            }
    }


    public function profit_and_loss_report(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel=new Main_item_party_table;

            $InvoiceitemsModel= new InvoiceitemsModel;
            $InvoiceModel= new InvoiceModel;



            $con = array( 
                'id' => session()->get('id') 
            );
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            $report_f_date=now_time($myid);
            $report_t_date='';

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));} 
  
            $acti=activated_year(company($myid));



            $invoice_items_array=array();




$InvoiceitemsModel->select('invoice_items.product, main_item_party_table.opening_balance, invoice_items.invoice_date, main_item_party_table.closing_balance, main_item_party_table.final_closing_value,invoice_items.purchased_price,invoice_items.price,
    SUM(CASE WHEN invoice_items.invoice_type = "purchase" THEN invoice_items.quantity END) as sum_purchase_quantity,
    SUM(CASE WHEN invoice_items.invoice_type = "sales" THEN invoice_items.quantity END) as sum_sales_quantity,
    SUM(CASE WHEN invoice_items.invoice_type = "purchase" THEN invoice_items.amount END) as sum_purchase_amount,
    SUM(CASE WHEN invoice_items.invoice_type = "sales" THEN invoice_items.amount END) as sum_sales_amount,
    SUM(CASE WHEN invoice_items.invoice_type = "sales" AND invoice_items.entry_type = "adjust" THEN invoice_items.amount ELSE 0 END) as sum_adjust_amount,
    SUM(CASE WHEN invoice_items.invoice_type = "purchase" AND invoice_items.entry_type = "adjust" THEN invoice_items.amount ELSE 0 END) as sum_purc_adjust_amount,');
    


    
$InvoiceitemsModel->join('main_item_party_table', 'main_item_party_table.id = invoice_items.product_id', 'left');
    // ->where('main_item_party_table.type', 'stock')
   


if ($_GET) {

     if (isset($_GET['product_name'])) {
        $InvoiceitemsModel->like('invoice_items.product', $_GET['product_name'], 'both'); 
    }

    if (isset($_GET['from']) && isset($_GET['to'])) {
        $from=$_GET['from'];
        $dto=$_GET['to'];
        if (!empty($from) && empty($dto)) {
            $InvoiceitemsModel->where('invoice_items.invoice_date',$from);
            $report_f_date=$from;
        }

        if (empty($from) && !empty($dto)) {
            $InvoiceitemsModel->where('invoice_items.invoice_date',$dto);
            $report_f_date=$dto;
        }

        if (empty($dto) && empty($from)) {
              $InvoiceitemsModel->where('invoice_items.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
        }
        if (!empty($dto) && !empty($from)) {
            $InvoiceitemsModel->where("invoice_items.invoice_date BETWEEN '$from' AND '$dto'");
            $report_f_date=$from;
            $report_t_date=$dto; 
        }
    }else{
        $InvoiceitemsModel->where('invoice_items.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
    } 
}else{
    $InvoiceitemsModel->where('invoice_items.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
}         


$invoice_items_array = $InvoiceitemsModel->where('invoice_items.deleted', 0)
    ->groupBy('invoice_items.product_id')
    ->findAll();


    

            $data = [
                'title' => 'Aitsun ERP - Profit & Loss Report',
                'user'=>$user,
                'invoice_items_array'=>$invoice_items_array,
                'report_f_date'=>$report_f_date,
                'report_t_date'=>$report_t_date, 
            ];

            echo view('header',$data);
            echo view('reports/profit_and_loss_report');
            echo view('footer');
    
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
   
}