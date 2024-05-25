<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\FinancialYears;
use App\Models\PaymentsModel;
use App\Models\ProductrequestsModel;
use App\Models\LeadModel;
use App\Models\ActivitiesNotes;
use App\Models\DocumentRenewModel;
use App\Models\AccountCategory;
use App\Models\ClientpaymentModel;
use App\Models\AlertSessionModel;



class App_error extends BaseController
{
     public function index()
    {

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
       
            $UserModel=new Main_item_party_table;
             
            
            $user=$UserModel->where('id',$myid)->first();

 
 
 

            if (check_main_company($myid)==true) {
                if (check_branch_of_main_company(company($myid))==true) {
                     if (app_status(company($myid))==0) {
                        echo view('errors/html/app_error');
                    } else{
                        return redirect()->to(base_url());
                    }
                }else{
                     return redirect()->to(base_url('company'));
                }
                
            }else{
                return redirect()->to(base_url('company'));
            }
             
         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }

    public function company_not_cofigured()
    {

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
       
            $UserModel=new Main_item_party_table;
             
            
            $user=$UserModel->where('id',$myid)->first();

            echo view('errors/html/company_not_cofigured');
         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }

    public function tutorial_coming_soon()
    {

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
       
            $UserModel=new Main_item_party_table;
             
            
            $user=$UserModel->where('id',$myid)->first();

            echo view('errors/html/coming_soon');
         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }

    public function permission_denied()
    {

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
       
            $UserModel=new Main_item_party_table;
             
            
            $user=$UserModel->where('id',$myid)->first();

            echo view('errors/html/permission_denied');
         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }

    
    
}