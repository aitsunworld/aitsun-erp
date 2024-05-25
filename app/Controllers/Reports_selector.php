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

class Reports_selector extends BaseController {

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
                $acti=activated_year(company($myid));

                $data = [
                    'title' => 'Aitsun ERP-Reports',
                    'user'=>$user,
                ];
                echo view('header',$data);
                echo view('reports/reports_selector', $data);
                echo view('footer');
        
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function new()
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
            $acti=activated_year(company($myid));
            $data = [
                'title' => 'Aitsun ERP-Reports',
                'user'=>$user,
            ];

            echo view('header',$data);
            echo view('aitsun_special_reports/reports_selector', $data);
            echo view('footer');  
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

     
        
}