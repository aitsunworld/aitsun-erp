<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\PaymentsNoteModel;
use App\Models\CrmActions;



class Payments_followup extends BaseController
{
    public function index(){   

        $session=session(); 
        if ($session->has('isLoggedIn')){
       
            $UserModel = new Main_item_party_table();
            $InvoiceModel = new InvoiceModel();


            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

                $all_invoices=$InvoiceModel->select('customer')->where('due_amount>',0)->where('invoice_type','sales')->where('company_id',company($myid))->where('deleted',0)->groupBy('customer')->findAll();  
           
                if ($user['u_type']=='superuser') {
                    $data=[
                        'title'=> 'Aitsun ERP-CRM | Payments Follow Up',
                        'user'=> $user,
                        'all_invoices'=>$all_invoices,
                       
                        
                    ];
                }else{
                    $data=[
                        'title'=> 'Aitsun ERP-CRM | Payments Follow Up',
                        'user'=> $user,
                        'all_invoices'=>$all_invoices,
                        
                        
                    ];
                }

                echo view('header',$data); 
                echo view('payments_followup/payments_follow_up');
                echo view('footer');

            }else{
                return redirect()->to(base_url());
            }

        }else{
            return redirect()->to(base_url('users'));
        }  
    }



    public function create_invoicenotes(){
        $session=session();
        $myid=session()->get('id');

        $con = array( 
            'id' => session()->get('id') 
        ); 

        $CrmActions = new CrmActions;


         if (isset($_POST['text_note'])) { 

                $action_data = [
                    'company_id'=>company($myid),
                    'lead_id'=>strip_tags(trim($this->request->getVar('lead_id'))),
                    'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                    'added_by'=>$myid,
                    'report'=>strip_tags(trim($this->request->getVar('text_note'))),
                    'created_at'=>now_time($myid),
                ];
                $saveaction=$CrmActions->save($action_data);

                if ($saveaction){
                   echo 1;
                }else{
                    echo 0;
                }
            }
    } 

}


