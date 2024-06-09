<?php
namespace App\Controllers;  
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;

use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

class Rental extends BaseController
{  
    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $InvoiceModel= new InvoiceModel;

            $myid=session()->get('id');
            $pager = \Config\Services::pager();
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}

            if ($_GET) {
                if (isset($_GET['status'])) {
                    if ($_GET['status']!='') {
                        $InvoiceModel->where('rental_status',$_GET['status']);
                    }
                }

                if (isset($_GET['invoice_status'])) {
                    if ($_GET['invoice_status']!='') {
                        $InvoiceModel->where('invoice_type','sales');
                    }else{ 
                        $InvoiceModel->where('invoice_type!=','sales'); 
                    }
                }else{ 
                    $InvoiceModel->where('invoice_type!=','sales'); 
                }
            }else{
                $InvoiceModel->where('invoice_type!=','sales');
            }
               
                $all_rentals=$InvoiceModel->where('company_id',company($myid))->where('deleted',0)->where('bill_from','rental')->orderBy('id','desc')->findAll();
            
                $data = [
                    'title' => 'Aitsun ERP- Rental',
                    'user' => $user, 
                    'all_rentals'=>$all_rentals
                ];
               
                echo view('header',$data);
                echo view('rental/rental_index', $data);
                echo view('footer'); 

           
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
}