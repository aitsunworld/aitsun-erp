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
use App\Models\ProductrequestsModel;
use App\Models\HidedTaxes;

class Gst_report extends BaseController {

        public function index()
        {

            $session=session();

            if($session->has('isLoggedIn')){


                    $UserModel=new Main_item_party_table;
                    $InvoiceModel= new InvoiceModel;
                    $HidedTaxes= new HidedTaxes;

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

                    $from='';
                    $dto='';

                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (!empty($from) && empty($dto)) {
                            $InvoiceModel->where('date(invoice_date)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $InvoiceModel->where('date(invoice_date)',$dto);
                        }

                        if (empty($dto) && empty($from)) {
                             $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
                        }
                        if (!empty($dto) && !empty($from)) {
                            $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                        }

                         
                    }else{
                        $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
                    }


                    $gst_reports = $InvoiceModel->where('company_id',company($myid))->where('invoice_type','sales')->where('deleted',0)->orderBy('id','DESC')->findAll();
                     // $gst_reports = [];
                     

                    $data = [
                        'title' => 'GST Report',
                        'user'=>$user, 
                        'gst_reports'=>$gst_reports,
                        'from'=>$from,
                        'to'=>$dto
                    ];

                    echo view('header',$data);
                    echo view('reports/gst_report', $data);
                    echo view('footer');


                    

            
        }else{
            return redirect()->to(base_url('users/login'));
        }
        }

        public function save_gst_columns(){

            $session=session();

            if($session->has('isLoggedIn')){


                    $UserModel=new Main_item_party_table;
                    $PaymentsModel= new PaymentsModel;
                    $HidedTaxes= new HidedTaxes;

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

                     if ($this->request->getMethod() == 'post') {

 

                        $HidedTaxes->where('company_id',company($myid))->delete();
                        
                        if (isset($_POST['tax_check'])) {
                            foreach ($_POST['tax_check'] as $i => $value) {
                                $tax_col_data = [
                                    'company_id'=>company($myid), 
                                    'tax_name'=>$_POST['tax_check'][$i], 
                                ]; 

                                $hidetax=$HidedTaxes->save($tax_col_data);
                            }

                            if ($hidetax) {
                                ////////////////////////CREATE ACTIVITY LOG//////////////
                                $log_data=[
                                    'user_id'=>$myid,
                                    'action'=>'GST report columns are updated',
                                    'ip'=>get_client_ip(),
                                    'mac'=>GetMAC(),
                                    'created_at'=>now_time($myid),
                                    'updated_at'=>now_time($myid),
                                    'company_id'=>company($myid),
                                ];

                                add_log($log_data);
                                ////////////////////////END ACTIVITY LOG/////////////////

                                $session->setFlashdata('sucmsg', 'Saved!');
                                return redirect()->to(base_url('gst_report'));
                            }else{
                                $session->setFlashdata('failmsg', 'Failed to save!');
                                return redirect()->to(base_url('gst_report'));
                            }
                        }else{
                            $session->setFlashdata('failmsg', 'Failed to save!');
                            return redirect()->to(base_url('gst_report'));
                        }
                        
                       

                        
                    }

            }else{
                return redirect()->to(base_url('users/login'));
            }
        }




        public function vat_report()
        {

            $session=session();

            if($session->has('isLoggedIn')){


                    $UserModel=new Main_item_party_table;
                    $InvoiceModel= new InvoiceModel;
                    $HidedTaxes= new HidedTaxes;

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

                    $from='';
                    $dto='';

                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (!empty($from) && empty($dto)) {
                            $InvoiceModel->where('date(invoice_date)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $InvoiceModel->where('date(invoice_date)',$dto);
                        }

                        if (empty($dto) && empty($from)) {
                             $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
                        }
                        if (!empty($dto) && !empty($from)) {
                            $InvoiceModel->where("date(invoice_date) BETWEEN '$from' AND '$dto'");
                        }

                         
                    }else{
                        $InvoiceModel->where('date(invoice_date)',get_date_format(now_time($myid),'Y-m-d'));
                    }


                    $vat_reports = $InvoiceModel->where('company_id',company($myid))->where('invoice_type','sales')->where('deleted',0)->orderBy('id','DESC')->findAll();
                     // $vat_reports = [];
                     

                    $data = [
                        'title' => 'VAT Report',
                        'user'=>$user, 
                        'vat_reports'=>$vat_reports,
                        'from'=>$from,
                        'to'=>$dto
                    ];

                    echo view('header',$data);
                    echo view('reports/vat_report', $data);
                    echo view('footer');


                    

            
        }else{
            return redirect()->to(base_url('users/login'));
        }
        }
    }