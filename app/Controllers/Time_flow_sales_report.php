<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;

class Time_flow_sales_report extends BaseController
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

        


            if (check_permission($myid,'manage_reports')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());} 

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid));

            
                if ($_GET) {
                    if (!empty($_GET['date'])) {
                        $date=get_date_format($_GET['date'],'Y-m-d');

                    }else{
                        $date=get_date_format(now_time($myid),'Y-m-d');
                    }
                    
                }else{
                    $date=get_date_format(now_time($myid),'Y-m-d');
                } 


            
            $data = [
                'title' => 'Aitsun ERP- Time Flow Reports',
                'user'=>$user,
                'global_date'=>$date
            ];

            echo view('header',$data);
            echo view('reports/time_flow_sales_report', $data);
            echo view('footer');
            
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
}