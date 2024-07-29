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

class Tally extends BaseController {

    public function index()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $AccountCategory=new AccountCategory;
        $CustomerBalances=new CustomerBalances;
        $AccountingModel=new AccountingModel;


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }
            
            $UserModel->where('deleted',0);
            $UserModel->where('u_type!=','admin');
            $UserModel->where('u_type!=','superuser');
            

           if ($_GET) {
                if (isset($_GET['display_name'])) {
                    if (!empty($_GET['display_name'])) {
                        $UserModel->like('display_name', $_GET['display_name'], 'both'); 
                    }
                }
                if (isset($_GET['phone'])) {
                    if (!empty($_GET['phone'])) {
                        $UserModel->like('phone', $_GET['phone'], 'both'); 
                    }
                }
                if (isset($_GET['party_type'])) {
                    if (!empty($_GET['party_type'])) {
                        $UserModel->where('u_type', $_GET['party_type']); 
                    }
                }
            }
           
            $get_cust = $UserModel->where('u_type!=','staff')->where('u_type!=','admin')->where('company_id',company($myid))->orderBy('id','desc')->findAll();

                $data = [
                    'title' => 'Aitsun ERP-Parties',
                    'user'=>$user,
                    'customer_data'=> $get_cust,
                ];

 


             
                echo view('header',$data);
                echo view('tally/master_export');
                echo view('footer');
         

                

            }else{
                return redirect()->to(base_url('users/login'));
            }
        
    }


    public function voucher_export(){
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
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if (!empty($from) && empty($dto)) {
                        $PaymentsModel->where('date(datetime)',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $PaymentsModel->where('date(datetime)',$dto);
                    }

                    if (empty($dto) && empty($from)) {
                         $PaymentsModel->where("date(datetime) BETWEEN '$from' AND '$dto'");
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


                $daybookdata = $PaymentsModel->where('company_id',company($myid))->where('deleted',0)->findAll();

                $debit_sum=0;
                $credit_sum=0;

              

                $data = [
                    'title' => 'Tally import - Aitsun ERP',
                    'user'=>$user,
                    'day_book_data'=>$daybookdata, 
                ];

                echo view('header',$data);
                echo view('tally/voucher_export', $data);
                echo view('footer');
            
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

}