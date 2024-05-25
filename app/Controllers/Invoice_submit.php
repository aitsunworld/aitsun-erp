<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceSubmitModel; 

class Invoice_submit extends BaseController
{
    public function index()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $InvoiceSubmitModel=new InvoiceSubmitModel;

            $pager = \Config\Services::pager();

            $results_per_page = 12;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           


            if (check_permission($myid,'manage_invoice_submit')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if ($_GET) {
                if (isset($_GET['invoice_number'])) {
                    if (!empty($_GET['invoice_number'])) {
                        $InvoiceSubmitModel->where('invoice_number',$_GET['invoice_number']);
                    }
                }

                if (isset($_GET['customer'])) {
                    if (!empty($_GET['customer'])) {
                        $InvoiceSubmitModel->where('customer_id',$_GET['customer']);
                    }
                }

                if (isset($_GET['responsible_person'])) {
                    if (!empty($_GET['responsible_person'])) {
                        $InvoiceSubmitModel->where('responsible_person',$_GET['responsible_person']);
                    }
                }

                if (isset($_GET['status'])) {
                    if (!empty($_GET['status'])) {
                        $InvoiceSubmitModel->where('status',$_GET['status']);
                    }
                }

                if (isset($_GET['received'])) {
                    if ($_GET['received']==0 || $_GET['received']==1) {
                        $InvoiceSubmitModel->where('received',$_GET['received']);
                    }
                }
            }


            $submitted_invoices=$InvoiceSubmitModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->paginate(25);
           

 
            $data=[
                'title'=>'Invoice submit - Aitsun ERP',
                'user'=>$user,
                'submitted_invoices'=>$submitted_invoices,
                'pager' => $InvoiceSubmitModel->pager
                
            ];

            echo view('header',$data);
            echo view('invoice_submit/invoice_submit');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }

    public function reports()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $InvoiceSubmitModel=new InvoiceSubmitModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_invoice_submit')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            if ($_GET) {
                if (isset($_GET['invoice_number'])) {
                    if (!empty($_GET['invoice_number'])) {
                        $InvoiceSubmitModel->where('invoice_number',$_GET['invoice_number']);
                    }
                }

                if (isset($_GET['customer'])) {
                    if (!empty($_GET['customer'])) {
                        $InvoiceSubmitModel->where('customer_id',$_GET['customer']);
                    }
                }

                if (isset($_GET['responsible_person'])) {
                    if (!empty($_GET['responsible_person'])) {
                        $InvoiceSubmitModel->where('responsible_person',$_GET['responsible_person']);
                    }
                }

                if (isset($_GET['status'])) {
                    if (!empty($_GET['status'])) {
                        $InvoiceSubmitModel->where('status',$_GET['status']);
                    }
                }

                if (isset($_GET['received'])) {
                    if ($_GET['received']==0 || $_GET['received']==1) {
                        $InvoiceSubmitModel->where('received',$_GET['received']);
                    }
                }
            }

 
           
            $submitted_invoices=$InvoiceSubmitModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();

            $data=[
                'title'=>'Invoice submit reports - Aitsun ERP',
                'user'=>$user,
                'submitted_invoices'=>$submitted_invoices
            ];

            echo view('header',$data);
            echo view('invoice_submit/invoice_submit_report');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }

    public function add_invoice(){

        if ($this->request->getMethod()=='post') {

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            
            $InvoiceSubmitModel=new InvoiceSubmitModel();

            $invoice_data = [
                'company_id'=>company($myid),
                'customer_id'=>strip_tags($this->request->getVar('customer')),
                'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                'invoice_number'=>strip_tags($this->request->getVar('invoice_number')),
                'amount'=>strip_tags(aitsun_round($this->request->getVar('amount'),get_setting(company($myid),'round_of_value'))),
                'responsible_person'=>strip_tags($this->request->getVar('responsible_person')),
                'status'=>strip_tags($this->request->getVar('status')),
                'created_at'=>now_time($myid),
                'received'=>0, 
            ];


            $add_invoice=$InvoiceSubmitModel->save($invoice_data);

            if ($add_invoice) {
                
                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New invoice submitted <b>No.'.strip_tags($this->request->getVar('invoice_number')).'</b>.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                session()->setFlashdata('pu_msg', 'Saved');
                return redirect()->to(base_url('invoice_submit'));
                
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('invoice_submit'));
            }
        }else{
            return redirect()->to(base_url());
        }
    }



    public function edit_invoice($inid=''){

        if ($this->request->getMethod()=='post') {

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            
            $InvoiceSubmitModel=new InvoiceSubmitModel();

            $invoice_data = [
                'company_id'=>company($myid),
                'customer_id'=>strip_tags($this->request->getVar('customer')),
                'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                'invoice_number'=>strip_tags($this->request->getVar('invoice_number')),
                'amount'=>strip_tags(aitsun_round($this->request->getVar('amount'),get_setting(company($myid),'round_of_value'))),
                'responsible_person'=>strip_tags($this->request->getVar('responsible_person')),
                'status'=>strip_tags($this->request->getVar('status'))
            ];


            $add_invoice=$InvoiceSubmitModel->update($inid,$invoice_data);

            if ($add_invoice) {
                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Submitted invoice updated <b>No.'.strip_tags($this->request->getVar('invoice_number')).'</b>.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                session()->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('invoice_submit?page=1'));

            }else{

                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('invoice_submit?page=1'));
            }
        }else{
            return redirect()->to(base_url());
        }
    }


    public function update_status(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $InvoiceSubmitModel=new InvoiceSubmitModel;
        $myid=session()->get('id');

        if (isset($_POST['statusname'],$_POST['getid'])) {
            $cdad=[
                'received'=>$_POST['statusname']
            ];

            $InvoiceSubmitModel->update($_POST['getid'],$cdad);

            if ($_POST['statusname']==1) {
                $stat='received';
            }else{
                $stat='not received';
            }

            ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>'Invoice submission <b>(#'.$_POST['getid'].')</b> receive status changed to '.$stat,
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];

            add_log($log_data);
            ////////////////////////END ACTIVITY LOG/////////////////
        }
    }


    public function delete_invoice($inid){

            $session=session();
            $myid=session()->get('id');
            $UserModel= new Main_item_party_table;
            $InvoiceSubmitModel= new InvoiceSubmitModel;


            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            
            if($session->has('isLoggedIn')){

                
                $deledata=[
                    'deleted'=>1
                ];
                $del=$InvoiceSubmitModel->update($inid,$deledata);
                
                if ($del) {


                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Invoice submission <b>#'.$inid.'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                    $session->setFlashdata('pu_msg', 'Deleted!');
                    return redirect()->to(base_url('invoice_submit'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                    return redirect()->to(base_url('invoice_submit'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



 }