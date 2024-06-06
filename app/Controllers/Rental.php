<?php
namespace App\Controllers;  
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\Main_item_party_table;

use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

class Rental extends BaseController
{  
    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table; 
            $myid=session()->get('id');
            $pager = \Config\Services::pager();
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
               
                
            
                $data = [
                    'title' => 'Aitsun ERP- Rental',
                    'user' => $user, 
                ];
               
                echo view('header',$data);
                echo view('rental/rental_index', $data);
                echo view('footer'); 

           
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
}