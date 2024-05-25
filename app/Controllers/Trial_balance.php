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

class Trial_balance extends BaseController {

        public function index()
        {

            $session=session();

            if($session->has('isLoggedIn')){


                    $UserModel=new Main_item_party_table;
                    $PaymentsModel= new PaymentsModel;
                    $AccountingModel= new AccountingModel;
                    

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

                    $group_head=$AccountingModel->where('company_id',company($myid))->where('primary',1)->where('type','group_head')->where('deleted',0)->findAll();

                  

                    $data = [
                        'title' => 'Aitsun ERP - Trial balance',
                        'user'=>$user,
                        'group_head'=>$group_head,
                    ];

                    echo view('header',$data);
                    echo view('reports/trial_balance', $data);
                    echo view('footer');
            
            }else{
                    return redirect()->to(base_url('users/login'));
                }
        }
}