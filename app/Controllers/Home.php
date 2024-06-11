<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\AppointmentsBookings;
use App\Models\PaymentsModel;
use App\Models\ProductrequestsModel;
use App\Models\LeadModel;
use App\Models\ActivitiesNotes;
use App\Models\DocumentRenewModel;
use App\Models\AccountCategory;
use App\Models\ClientpaymentModel;
use App\Models\AlertSessionModel;
use App\Models\Companies; 



class Home extends BaseController
{
     public function index()
    {

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
            $ntt=now_time($myid);

            $Main_item_party_table=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;
            $ProductsModel=new Main_item_party_table;
            $AppointmentsBookings=new AppointmentsBookings;
            $ProductrequestsModel=new ProductrequestsModel;
            $LeadModel=new LeadModel;
            $ActivitiesNotes=new ActivitiesNotes;
            $AccountCategory=new AccountCategory;
            $ClientpaymentModel= new ClientpaymentModel;
            $AlertSessionModel = new AlertSessionModel;
            $Companies = new Companies;
              

            if ($_GET) {
                if (!empty($_GET['year'])) {
                   $year_data=trim($_GET['year']);
                }else{
                    $year_data=now_year($myid);
                }
            }else{
                $year_data=now_year($myid);
            }
            
            $user=$Main_item_party_table->where('id',$myid)->first();



            // array push of alert session
            $payment_alert = array();

            // $billing_payment=$ClientpaymentModel->where('deleted',0)->where('client_id',app_super_user(company($myid)))->where('status!=','paid')->findAll();


            // foreach ($billing_payment as $bp) {
               
            //     $alert_session=$AlertSessionModel->where('bill_id',$bp['id'])->where('status!=','done')->findAll();
            //      // echo $bp['id'];
            //     foreach ($alert_session as $als) {
            //         if ($als['status']=='activated') {
            //             array_push($payment_alert, $als);
            //         }else{
            //             $curr_date=now_time($myid);
            //             if ($curr_date>=$als['datetime']) {
            //                 $alss = array('status' => 'activated');
            //                 $AlertSessionModel->update($als['id'],$alss);   
            //             }
            //         }
                   
            //     }
            // } 
            // array push of alert session

            $get_branches=$Companies->where('parent_company', main_company_id($myid));

            $my_appointments=$AppointmentsBookings->where('company_id',company($myid))->where('person_id',$myid)->where('date(book_from)',get_date_format(now_time($myid),'Y-m-d'))->where('deleted',0)->orderBy('book_from','ASC')->findAll();
            $data = [
                'title' => 'Aitsun ERP-Dashboard',
                'user'=>$user,
                'now_year'=>$year_data, 
                'payment_alert'=>$payment_alert,
                'branches'=>$get_branches->findAll(),
                'my_appointments'=>$my_appointments
            ];
           

            if (check_main_company($myid)==true) {
                if (check_branch_of_main_company(company($myid))==true) {
                    if (usertype($myid)=='customer') {
                        redirect(base_url('customer_dashboard'));
                    }else{

                        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                      

                        // if (user_data(session()->get('id'),'activated_financial_year')<1) {
                        //     return redirect()->to(base_url('settings/financial_years'));
                        // }


                        if (is_school(company($myid))) {
                            if (current_academic_year('year',company($myid))=='no_academic_years') {
                                return redirect()->to(base_url('settings/academic_year'));
                            }
                        }

                        // if (current_financial_year('financial_to',company($myid))!='no_financial_years') {
                        //     $financialY=get_date_format(current_financial_year('financial_to',company($myid)),'Y-m-d');
                        //     $currentY=get_date_format(now_time($myid),'Y-m-d');

                        //     if ($currentY>$financialY) {
                        //         $fdata=['status'=>1];
                        //         $audit=$FinancialYears->update(financial_year(company($myid)),$fdata);
                        //     }


                        // }else{
                        //      return redirect()->to(base_url('settings/financial_years'));
                        // }

                        echo view('header',$data);
                        echo view('main_menu');
                        echo view('dashboard');
                        echo view('main_footer');
                        echo view('footer');

               
                        
                        
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

    public function search($searched_text=""){
        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
            $ntt=now_time($myid);

            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;
            $ProductsModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;
            $LeadModel=new LeadModel;
            $DocumentRenewModel=new DocumentRenewModel;

            $acti=activated_year(company($myid));

            $product_result=$ProductsModel->where('deleted',0)->where('company_id',company($myid))->like('product_name',$searched_text,'both')->findAll(4);

            $user_result=$UserModel->where('deleted',0)->where('u_type!=','staff')->where('u_type!=','admin')->where('company_id',company($myid))->like('display_name',$searched_text,'both')->findAll(4);

            $invoice_result=$InvoiceModel->where('deleted',0)->where('company_id',company($myid))->groupStart()->like('serial_no',$searched_text)->orLike('alternate_name',$searched_text,'both')->groupEnd()->findAll(4);

            $payments_result=$PaymentsModel->where('deleted',0)->where('company_id',company($myid))->like('serial_no',$searched_text)->findAll(4);

            $lead_result=$LeadModel->where('deleted',0)->where('company_id',company($myid))->like('lead_name',$searched_text,'both')->findAll(4);

            $renew_result=$DocumentRenewModel->where('deleted',0)->where('company_id',company($myid))->like('r_description',$searched_text,'both')->findAll(4);


            foreach ($lead_result as $pr) { ?>
                <li class="search_bg_lead">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('crm/details'); ?>/<?= $pr['id']; ?>">
                        <span class="sertag">Lead</span> <?= $pr['lead_name']; ?> <small>(<?= $pr['lead_status']; ?>)</small>
                    </a>
                </li>                
            <?php }

            foreach ($user_result as $cr) { 
                $lead_of_party=$LeadModel->where('deleted',0)->where('cr_customer',$cr['id'])->findAll(4);
                foreach ($lead_of_party as $pr) {
                ?>
                <li class="search_bg_lead">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('crm/details'); ?>/<?= $pr['id']; ?>">
                        <span class="sertag">Lead</span> <?= $pr['lead_name']; ?> <small>(<?= $pr['lead_status']; ?>)</small> 
                        <small><em>- <?= user_name($pr['cr_customer']); ?></em></small>
                    </a>
                </li>  

            <?php }}

            foreach ($user_result as $cr) { 
                $invoice_result=$InvoiceModel->where('deleted',0)->where('customer',$cr['id'])->findAll(4);
                foreach ($invoice_result as $pr) { 
                    if ($pr['fees_id']>0) {
                        $rurl=base_url('fees_and_payments/view_challan').'/' .$pr['id'];
                    }else{
                        $rurl=base_url('invoices/details').'/' .$pr['id'];
                    }
                ?>
                <li class="search_bg_invoice">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= $rurl ?>">

                        <span class="sertag">Inventory</span> #<?= inventory_prefix(company($myid),$pr['invoice_type']); ?> <?= $pr['serial_no']; ?> 
                        <small><em>- <?= user_name($pr['customer']); ?></em></small>     
                    </a>
                </li>  
            <?php }}

            foreach ($product_result as $pr) { ?>
                <li class="search_bg_product">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('products/edit'); ?>/<?= $pr['id']; ?>">
                        <span class="sertag">Product</span> <?= $pr['product_name']; ?>
                    </a>
                </li>                
            <?php }

            foreach ($user_result as $pr) { ?>
                <li class="search_bg_user">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('customers/details'); ?>/<?= $pr['id']; ?>">
                        <span class="sertag">Parties</span> <?= $pr['display_name']; ?>
                    </a>
                </li>                
            <?php }

            foreach ($invoice_result as $pr) { ?>
                <li class="search_bg_invoice">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('invoices/details'); ?>/<?= $pr['id']; ?>">
                        <span class="sertag">Inventory</span> #<?= inventory_prefix(company($myid),$pr['invoice_type']); ?><?= $pr['serial_no']; ?> <?= $pr['alternate_name']; ?>

                    </a>
                </li>                
            <?php }

            foreach ($payments_result as $pr) { ?>
                <li class="search_bg_payments">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('payments/details'); ?>/<?= $pr['id']; ?>">
                        <span class="sertag">Payment</span> <?= get_setting(company($myid),'payment_prefix'); ?> <?= $pr['serial_no']; ?>
                    </a>
                </li>                
            <?php }

            foreach ($renew_result as $pr) { ?>
                <li class="search_bg_renews">
                    <a class="py-2 my-1 pr-2 cursor-pointer d-block" href="<?= base_url('document_renew'); ?>?doc=<?= $pr['id']; ?>">
                        <span class="sertag">Renews</span> <?= $pr['r_description']; ?>
                    </a>
                </li>                
            <?php }

        }
    }




    public function session_status($cid=""){
        $session=session();
        $AlertSessionModel=new AlertSessionModel;

        if ($this->request->getMethod('post')) {
        
            $clientdata=[
                
                'status'=>'done',
               
            ];
      

            if ($AlertSessionModel->update($cid,$clientdata)) {
              echo 1;
               
            }else{
               echo 0;
            }
    
        }
    }



    public function  get_states($country="india"){
            echo '<option value="">Choose</option>';
            foreach (states_array_for_select($country) as $st) {
                echo '<option value="'.$st.'">'.$st.'</option>';
            }
    }

    public function get_adjust_payment($groupHeadId){
        $session = session();
        $myid = session()->get('id');

        $UserModel = new Main_item_party_table;

        $ps_data = [
            'closing_balance' => $this->request->getPost('inputValue'),
            'opening_balance' => $this->request->getPost('inputValue'),

        ];

        $sc = $UserModel->update($groupHeadId, $ps_data); 

        if ($sc) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function permission_denied($permission_name=''){
        $session=session();

        if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
                
                $Main_item_party_table=new Main_item_party_table;
                $user=$Main_item_party_table->where('id',$myid)->first();

                $data = [
                    'title' => 'Aitsun ERP-Dashboard',
                    'user'=>$user,
                    'permission_name'=>$permission_name 
                ];
               
            echo view('errors/html/permission_denied',$data);

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    
}
