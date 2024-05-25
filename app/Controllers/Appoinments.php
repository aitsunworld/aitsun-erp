<?php
namespace App\Controllers; 
use App\Models\EnquiriesModel;
use App\Models\SocialMediaModel;
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\PostsModel;
use App\Models\PostThumbnail;
use App\Models\PostCategoryModel;
use App\Models\ReviewsModel;
use App\Models\ClientsModel;
use App\Models\Main_item_party_table;

class Appoinments extends BaseController
{  
    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appoinments(company($user['id']))==1) {
            
                $etqry = $CompanySettings2->where('company_id',company($myid))->first();
                $data = [
                    'title' => 'Aitsun ERP- Appoinments',
                    'user' => $user, 
                ];
               
                echo view('header',$data);
                echo view('appointments/appointments_index', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function create(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appoinments(company($user['id']))==1) {
            
                $etqry = $CompanySettings2->where('company_id',company($myid))->first();
                $data = [
                    'title' => 'Aitsun ERP- create Appoinments',
                    'user' => $user, 
                ];
               
                echo view('header',$data);
                echo view('appointments/create_appoinment', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
    
}