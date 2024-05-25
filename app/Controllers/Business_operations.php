<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\AccountCategory;
use App\Models\CustomerBalances;
use App\Models\PaymentsModel;
use App\Models\LeadModel;
use App\Models\FollowersModel;
use App\Models\ActivitiesNotes; 
use App\Models\TasksModel;
use App\Models\TaskDateModel;
use App\Models\MessageFileModel;
use App\Models\ProductrequestsModel;
use App\Models\Companies;



class Business_operations extends BaseController
{
    public function index()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $AccountCategory=new AccountCategory;
            $CustomerBalances=new CustomerBalances;
            $ProductrequestsModel=new ProductrequestsModel;
            $LeadModel = new LeadModel();
            $FollowersModel= new FollowersModel;


            if ($session->has('isLoggedIn')){
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();

                if (is_crm(company($myid))) {

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                  

                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    if (check_permission($myid,'manage_crm')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                     

                    $data=[
                        'title'=> 'Aitsun ERP-Business operations',
                        'user'=> $user, 
                    ];

                    
 
                    echo view('header',$data);
                    echo view('business_operations/dashboard', $data);
                    echo view('footer');
                }else{
                    return redirect()->to(base_url());
                }

            }else{
                return redirect()->to(base_url('users/login'));
            }               
    }
}