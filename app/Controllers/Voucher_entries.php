<?php

namespace App\Controllers; 
use App\Models\Main_item_party_table;  
use App\Models\PaymentsModel;
use App\Models\VoucherListModel;
use App\Models\CompanySettings2;



class Voucher_entries extends BaseController
{
    public function index(){
         $session=session();

                if ($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $PaymentsModel=new PaymentsModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();
                $user_data=$UserModel->where('company_id',company($myid))->where('deleted',0)->findAll();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                


                

                    // $this->db->where('bill_type!=','purchase');
                    // $this->db->where('bill_type!=','payment');
                    // $this->db->where('bill_type!=','sale return');
                   


                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $acti=activated_year(company($myid));

                    if (!$_GET) {
                        $PaymentsModel->where('date(datetime)',get_date_format(now_time($myid),'Y-m-d'));
                    }else {
                        
                        $from=$_GET['from'];
                        $to=$_GET['to'];


                        if (isset($_GET['pay_id'])) {
                            if (!empty($_GET['pay_id'])) {
                                $PaymentsModel->where('serial_no',$_GET['pay_id']);
                            }
                        }

                        if (isset($_GET['p_type'])) {
                            if (!empty($_GET['p_type'])) {
                                $PaymentsModel->where('type',$_GET['p_type']);
                            }
                        }

                        if (!empty($from) && empty($to)) {
                            $PaymentsModel->where('date(datetime)',$from);
                        }
                        if (!empty($to) && empty($from)) {
                            $PaymentsModel->where('date(datetime)',$to);
                        }

                        if (!empty($to) && !empty($from)) {
                            $PaymentsModel->where("date(datetime) BETWEEN '$from' AND '$to'");
                        }

                    }

                    


                    // $allpayments=$PaymentsModel->where('company_id',company($myid))->where('financial_year',$acti)->orderBy('id','DESC')->where('deleted',0)->where('bill_type!=','expense')->where('bill_type!=','sales_return')->where('bill_type!=','purchase')->where('bill_type!=','discount_allowed')->findAll();

                    $allpayments=$PaymentsModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0)->paginate(50);

                 

                    $data = [
                        'title' => 'Aitsun ERP - All entries',
                        'user' => $user,
                        'user_data' => $user_data,
                        'allpayments' => $allpayments,
                        'pager' => $PaymentsModel->pager,
                    ];


                    echo view('header',$data);
                    echo view('voucher_entries/all_entries', $data);
                    echo view('footer');
 
                    

                }else{
                    return redirect()->to(base_url('users/login'));
                }
    }


    public function all_entries()
        {

            $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;
            $VoucherListModel= new VoucherListModel;

                if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    
                    
                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }
                        
                    $title='Income entry';
                    $entry_type='';

                    if ($entry_type=='expense') {
                        $title='Expense entry';
                    }
                    


                    if (!$_GET) {
                        $VoucherListModel->where('voucher_date',get_date_format(now_time($myid),'Y-m-d'));
                    }else {
                     
                        

                        if (isset($_GET['voucher_no'])) {
                            if (!empty($_GET['voucher_no'])) {
                                $VoucherListModel->where('id',$_GET['voucher_no']);
                            }
                        }

                        if (isset($_GET['payment'])) {
                            if (!empty($_GET['payment'])) {
                                $VoucherListModel->where('payment_type',$_GET['payment']);
                            }
                        }

                        if (isset($_GET['voucher_type'])) {
                            if (!empty($_GET['voucher_type'])) {
                                $VoucherListModel->where('voucher_type',$_GET['voucher_type']);
                            }
                        }



                        if (isset($_GET['from']) && isset($_GET['to'])) {
                            $from=$_GET['from'];
                            $dto=$_GET['to'];

                            if (!empty($from) && empty($dto)) {
                                $VoucherListModel->where('datetime',$from);
                            }
                            if (!empty($dto) && empty($from)) {
                                $VoucherListModel->where('datetime',$dto);
                            }

                            if (!empty($dto) && !empty($from)) {
                                $VoucherListModel->where("datetime BETWEEN '$from' AND '$dto'");
                            }

                            // if (empty($dto) && empty($from)) {
                            //     $VoucherListModel->where('datetime',get_date_format(now_time($myid),'Y-m-d'));
                            // }
                        }


                        
                        
                    }

                    $VoucherListModel->where('company_id',company($myid));
                    $VoucherListModel->orderBy('id','DESC');
                    $VoucherListModel->where('deleted',0);

                    $voucher_data=$VoucherListModel->findAll();





                    $data = [
                        'title' => 'Aitsun ERP - '.$title,
                        'entry_type'=>$entry_type, 
                        'user'=>$user,
                        'view_method'=>'',
                        'voucher_type'=>'',
                        'voucher_data'=>$voucher_data
                    ];
                    
                    echo view('header',$data);
                     echo view('voucher_entries/all_entries', $data);
                    echo view('footer');  
                  
                    

            }else{
                return redirect()->to(base_url('users/login'));
            }



        }

    public function select(){
 

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
            $ntt=now_time($myid);

            $UserModel=new Main_item_party_table; 
       
            
            $user=$UserModel->where('id',$myid)->first();


 


            $data = [
                'title' => 'Aitsun ERP-Vouchers',
                'user'=>$user, 
            ];
           

            if (check_main_company($myid)==true) {
                if (check_branch_of_main_company(company($myid))==true) {
                    if (usertype($myid)=='customer') {
                        redirect(base_url('customer_dashboard'));
                    }else{

                        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                       

                        // if (current_financial_year('financial_to',company($myid))!='no_financial_years') {
                        //     $financialY=get_date_format(current_financial_year('financial_to',company($myid)),'Y-m-d');
                        //     $currentY=get_date_format(now_time($myid),'Y-m-d');

                        //     if ($currentY>$financialY) {
                        //         $fdata=['status'=>1];
                        //         $audit=$FinancialYears->update(financial_year(company($myid)),$fdata);
                        //     }


                        // }

                        echo view('header',$data); 
                        echo view('voucher_entries/select'); 
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


    public function add($entry_type="",$vc_type='receipt'){
            
            $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;

                if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   
                    
                    
                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }
                        
                    $title='Income entry';

                    if ($entry_type=='expense') {
                        $title='Expense entry';
                    }
                        
                    $data = [
                        'title' => 'Aitsun ERP - '.$title,
                        'entry_type'=>$entry_type, 
                        'user'=>$user,
                        'view_method'=>'add',
                        'voucher_type'=>$vc_type
                    ];
 
                    echo view('voucher_entries/add', $data);
                    

            }else{
                return redirect()->to(base_url('users/login'));
            }
    
    }



    public function edit($inv_id=''){

        $session=session();
        $UserModel=new Main_item_party_table;
        $VoucherListModel=new VoucherListModel;

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           
 

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            } 


            $inquery=$VoucherListModel->where('id',$inv_id)->first();
            
            $multyiple = explode(',', $inv_id);
            $data = [
                'title' => 'Aitsun ERP-Edit Voucher',
                'user'=>$user,
                'in_data'=>$inquery,
                'inid'=>$inv_id,
                'entry_type'=>'edit', 
                'voucher_type'=>$inquery['voucher_type'],
                'view_method'=>'edit',
                'view_type'=>'sales', 
                'm_invoices'=>$multyiple
            ];

            echo view('voucher_entries/add', $data);

              
                    
        }else{
            return redirect()->to(base_url('users/login'));
        }
        
    }




    public function delete($vid=""){

            $session=session();
            $UserModel=new Main_item_party_table;
            $VoucherListModel=new VoucherListModel;
            $PaymentsModel=new PaymentsModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if ($session->has('isLoggedIn')){



                $deledata=[
                    'deleted'=>1
                ];
                $del=$VoucherListModel->update($vid,$deledata);
                
                if ($del) {


                foreach (voucher_items_array($vid) as $vit) {

                   $deledata_itm=[
                        'deleted'=>1,
                        'edit_effected'=>0
                    ];
                    $PaymentsModel->update($vit['id'],$deledata);

                }



                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=> 'Voucher(#'.$vid.') entry is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                        $session->setFlashdata('pu_msg', 'Voucher entry deleted');
                        return redirect()->to(base_url('voucher_entries'));

                                      

                }else{

                    $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                    return redirect()->to(base_url('voucher_entries'));
                    
                }

            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



        public function details($vid){


             $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;
            $VoucherListModel= new VoucherListModel;
            $CompanySettings2= new CompanySettings2;
            

                if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   

                    
                    
                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }
                        
                    $title='Income entry';
                    $entry_type='';

                    if ($entry_type=='expense') {
                        $title='Expense entry';
                    }
                    
                    $ind=$VoucherListModel->where('id',$vid);

                    $inrow=$ind->first();

                    if ($inrow['deleted']==1) {
                        return redirect()->to(base_url('voucher_entries'));
                    }
                    

                    $data = [
                        'title' => 'Aitsun ERP - '.$title,
                        'entry_type'=>$entry_type, 
                        'user'=>$user,
                        'view_method'=>'',
                        'voucher_type'=>'',
                        'voucher_data'=>$inrow
                    ];
                    
                    echo view('header',$data);
                     echo view('voucher_entries/voucher_details', $data);
                    echo view('footer');  
                  
                    

            }else{
                return redirect()->to(base_url('users/login'));
            }



    }


    
    public function display_particulars(){
            $session=session();
            $UserModel=new Main_item_party_table;
            $AccountingModel=new Main_item_party_table;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                $acti=activated_year(company($myid));

                    $AccountingModel->orderBy("id", "desc");
                    $query = $UserModel->where('id',$myid);

                    if (isset($_GET['product_name'])) {
                        if($_GET['product_name']!='' && $_GET['category']=='' && $_GET['subcategory']==''){ 
                             
                            
                            $AccountingModel->groupStart();
                            $AccountingModel->like('group_head',$_GET['product_name'],'both');  
                            $AccountingModel->orLike('display_name',$_GET['product_name'],'both');  
                            $AccountingModel->groupEnd();
                            $AccountingModel->where('parent_id!=',id_of_group_head(company($myid),activated_year(company($myid)),'Bank Accounts'));
                            $AccountingModel->where('parent_id!=',id_of_group_head(company($myid),activated_year(company($myid)),'Cash-in-Hand'));
                            // $AccountingModel->where('group_head',id_of_group_head(company($myid),activated_year(company($myid)),'Purchase Accounts'));

                     

                            if ($_GET['view_type']=='receipt') { 
                                $AccountingModel->where('parent_id!=',id_of_group_head(company($myid),activated_year(company($myid)),'Direct Expenses'));
                                $AccountingModel->where('parent_id!=',id_of_group_head(company($myid),activated_year(company($myid)),'Indirect Expenses'));
                            }else{
                                $AccountingModel->where('parent_id!=',id_of_group_head(company($myid),activated_year(company($myid)),'Direct Incomes'));
                                $AccountingModel->where('parent_id!=',id_of_group_head(company($myid),activated_year(company($myid)),'Indirect Incomes'));
                            } 
                    
                            

                            $get_pro=$AccountingModel->where('main_type!=', 'product')->where('company_id', company($myid))->where('deleted', 0)->where('is_static_journal!=', 1);
                            

                            echo '<div class="col-md-3 my-2"><a id="cat_back"><div class="folder_box d-flex product_box justify-content-between"><h6 class="text-white m-auto"><i class="bx-arrow-back bx"></i></h6></div></a></div>';

                            $get_pro_data=$get_pro->findAll(10);

                            
                            foreach ($get_pro_data as $pro) { 
                              
                                ?>
                                
                                    <a class="item_box col-md-3 my-2" href="javascript:void(0);"
                                    data-productid="<?= $pro['id']; ?>" 
                                    data-product_name="<?= $pro['display_name']; ?><?= $pro['group_head']; ?>" 
                                    data-unit="0"
                                    data-price="0" 
                                    data-old_paid_amount="0" 
                                    data-tax="0" 
                                    data-prounit='0' 
                                    data-protax='0' 
                                    data-tax_name=""
                                    data-barcode=""
                                    data-tax_percent="0"
                                    data-stock="0"
                                    data-description=""
                                    data-product_type=""
                                    data-purchased_price="0"
                                     data-selling_price="0"
                                     data-purchase_tax="0"
                                     data-sale_tax="0"
                                     data-mrp="0"
                                     data-purchase_margin="0"
                                     data-sale_margin="0"
                                    >
                                        <div class="product_box">
                                            <h6 class="text-white textoverflow_x-none">
                                                
                                                <?= $pro['display_name']; ?>
                                                <?= $pro['group_head']; ?>
                                                <?php if (!empty(class_name(current_class_of_student(company($myid),$pro['customer_id'])))): ?>
                                                    - <?= class_name(current_class_of_student(company($myid),$pro['customer_id'])) ?>
                                                <?php endif ?> 
                                            </h6>
                                        </div>
                                        
                                    </a>
                                
                                <?php
                            }


                        }   
                        
                    }

                }else{
                    return redirect()->to(base_url('users/login'));
                }
        }



        public function insert_voucher()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $VoucherListModel=new VoucherListModel;  
            $PaymentsModel=new PaymentsModel;   

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 


                   if ($this->request->getMethod()=='post') {

                        $paid_amount=0;
                        $payment_type=strip_tags($_POST['payment_type']);
                        $check_nomber='';
                        $check_date='';
                        $chk_amt=0;

                        $in_type=strip_tags($this->request->getVar('invoice_type'));
                        $view_method=strip_tags($this->request->getVar('view_method'));
                        $convertfrom=strip_tags($this->request->getVar('convertfrom'));
                        

                        $paid_amount=$_POST['cash_amount'];


                        $grandtotal=strip_tags($this->request->getVar('grand_total'));

                        if ($in_type=='sales' || $in_type=='sales_return' || $in_type=='purchase' || $in_type=='purchase_return') {
                            if ($paid_amount<aitsun_round($grandtotal,get_setting(company($myid),'round_of_value'))) {
                                $paid_stat='unpaid';
                            }else{
                                $paid_stat='paid';
                            }
                        }else{
                            $paid_stat='unpaid';
                        }


                        if ($payment_type!='credit') {
                            $duuuuamt=strip_tags($this->request->getVar('due_amount'));
                        }else{
                            $duuuuamt=aitsun_round($grandtotal,get_setting(company($myid),'round_of_value'));
                        }



                      $customer=strip_tags($this->request->getVar('customer'));
                      $bigdiscount=strip_tags($this->request->getVar('discount'));


                      

                       $in_data=[
                            'company_id'=>company($myid),  
                            'notes'=>strip_tags($this->request->getVar('notes')),
                            'private_notes'=>strip_tags($this->request->getVar('private_notes')),
                            'total'=>$grandtotal,
                            'voucher_date'=>strip_tags($this->request->getVar('invoice_date')),
                            'datetime'=>now_time($myid),   
                            'voucher_type'=>$in_type,
                            'vehicle_id'=>strip_tags($this->request->getVar('vehicleid')),
                            'payment_type'=> $payment_type   
                        ];

 
                        
                        

                        $in_ins=$VoucherListModel->save($in_data);
                        $ins_id=$VoucherListModel->insertID();

                        

                        foreach ($_POST["product_name"] as $i => $value ) {
                             
 
                            
                            if (is_numeric($_POST["amount"][$i])) {
                               $amount=$_POST["amount"][$i]; 
                            }else{
                                $amount=0;
                            } 
                            
                            if (is_numeric($_POST["quantity"][$i])) {
                               $quantity=$_POST["quantity"][$i]; 
                            }else{
                                $quantity=0;
                            }

                            if (is_numeric($_POST["price"][$i])) {
                               $price=$_POST["price"][$i]; 
                            }else{
                                $price=0;
                            }  
 

                            $product_id=$_POST["product_id"][$i];
                            $product_desc=$_POST["product_desc"][$i];
                            $reference_id=$_POST["reference_no"][$i];

                            

 
                          

                            $customer_data = [
                                'company_id'=>company($myid),
                                'voucher_id'=>$ins_id,
                                'type'=>$payment_type,
                                'amount'=>$amount,
                                'payment_note'=>$product_desc,
                                'reference_id'=>$reference_id,
                                'datetime'=>strip_tags($this->request->getVar('invoice_date')),
                                'payment_id'=> $receipt_no=receipt_no_generate(5),
                                'company_id'=>company($myid),
                                'bill_type'=>$in_type, 
                                'receive_status'=>1,
                                'account_name'=>$product_id,
                                'serial_no'=>serial_no_cash(company($myid)),
                                'customer'=>strip_tags($this->request->getVar('customer')),
                                'quantity'=>$quantity,
                                'price'=>$price,
                                'collected_by'=>$myid,
                                'vehicle_id'=>strip_tags($this->request->getVar('vehicleid')),

                            ]; 
                            $add_receipt=$PaymentsModel->save($customer_data);


                             // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                    //PAYMENT
                                    $cus_bal_payment=$product_id; 

                                    $cus_current_pay_closing_balance=user_data($cus_bal_payment,'closing_balance');
                                    $cus_new_closing_pay_balance=$cus_current_pay_closing_balance;

                                    if ($in_type=='receipt') {
                                        $cus_new_closing_pay_balance=$cus_new_closing_pay_balance-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $cus_new_closing_pay_balance=$cus_new_closing_pay_balance+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }

                                    $cus_bal_payment_data=[ 
                                        'closing_balance'=>$cus_new_closing_pay_balance,
                                    ];
                                    $UserModel->update($cus_bal_payment,$cus_bal_payment_data); 
                            // ??????????????????????????  customer and cash balance calculation end ??????????????
                            // ??????????????????????????  customer and cash balance calculation end ??????????????

 
                            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                    //PAYMENT
                                    $bal_payment=strip_tags($this->request->getVar('payment_type')); 

                                    $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                                    $new_closing_pay_balance=$current_pay_closing_balance;

                                    if ($in_type=='receipt') {
                                        $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }

                                    $bal_payment_data=[ 
                                        'closing_balance'=>$new_closing_pay_balance,
                                    ];
                                    $UserModel->update($bal_payment,$bal_payment_data); 
                            // ??????????????????????????  customer and cash balance calculation end ??????????????
                            // ??????????????????????????  customer and cash balance calculation end ??????????????

                        }

                         
                        if ($in_ins) {
                            $company=company($myid);
                            $userid=$myid;
                            $check_date=$check_date;
                            $paid=$paid_amount;
                            echo $ins_id;


                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New voucher <b>#'.$ins_id.'</b> is created.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////
                        
                        }else{
                            echo "failed";
                        }

                    }

                            
                }else{
                    echo 'failed';
                }
        }



        public function update_voucher($voucher_id="")
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $VoucherListModel=new VoucherListModel;  
            $PaymentsModel=new PaymentsModel;   

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 


                   if ($this->request->getMethod()=='post') {

                        $paid_amount=0;
                        $payment_type=strip_tags($_POST['payment_type']);
                        $check_nomber='';
                        $check_date='';
                        $chk_amt=0;

                        $in_type=strip_tags($this->request->getVar('invoice_type'));
                        $view_method=strip_tags($this->request->getVar('view_method'));
                        $convertfrom=strip_tags($this->request->getVar('convertfrom'));
                        

                        $paid_amount=$_POST['cash_amount'];


                        $grandtotal=strip_tags($this->request->getVar('grand_total'));

                        if ($in_type=='sales' || $in_type=='sales_return' || $in_type=='purchase' || $in_type=='purchase_return') {
                            if ($paid_amount<aitsun_round($grandtotal,get_setting(company($myid),'round_of_value'))) {
                                $paid_stat='unpaid';
                            }else{
                                $paid_stat='paid';
                            }
                        }else{
                            $paid_stat='unpaid';
                        }


                        if ($payment_type!='credit') {
                            $duuuuamt=strip_tags($this->request->getVar('due_amount'));
                        }else{
                            $duuuuamt=aitsun_round($grandtotal,get_setting(company($myid),'round_of_value'));
                        }



                      $customer=strip_tags($this->request->getVar('customer'));
                      $old_payment_type=strip_tags($this->request->getVar('old_payment_type'));
                      $bigdiscount=strip_tags($this->request->getVar('discount'));


                      

                       $in_data=[     
                            'notes'=>strip_tags($this->request->getVar('notes')),
                            'private_notes'=>strip_tags($this->request->getVar('private_notes')),
                            'total'=>$grandtotal,
                            'voucher_date'=>strip_tags($this->request->getVar('invoice_date')), 
                            'payment_type'=> $payment_type   
                        ];

 
                        
                        

                        $in_ins=$VoucherListModel->update($voucher_id,$in_data);
                        $ins_id=$voucher_id;

                        $deledata=$PaymentsModel->where('voucher_id',$ins_id)->where('deleted',0); 
                        foreach ($_POST["product_name"] as $i => $value ) {
                            $i_idd=$_POST["i_id"][$i];
                            $deledata->where('id!=',$i_idd);
                        }

                        $deleting_prows=$deledata->findAll();
                        foreach ($deleting_prows as $dp) {
                            $dd=[
                                'deleted'=>1,
                                'edit_effected'=>0
                            ];
                            $PaymentsModel->update($dp['id'],$dd);

                            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                            // ??????????????????????????  customer and cash balance calculation end ?????????????? 


                                     //PAYMENT
                                    $cus_bal_payment=get_payment_data($dp['id'],'account_name'); 

                                    $cus_current_pay_closing_balance=user_data($cus_bal_payment,'closing_balance');
                                    $cus_new_closing_pay_balance=$cus_current_pay_closing_balance;

                                    if ($dp['bill_type']=='receipt') {
                                        $cus_new_closing_pay_balance=$cus_new_closing_pay_balance+aitsun_round(get_payment_data($dp['id'],'amount'),get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $cus_new_closing_pay_balance=$cus_new_closing_pay_balance-aitsun_round(get_payment_data($dp['id'],'amount'),get_setting(company($myid),'round_of_value'));
                                    }

                                    $cus_bal_payment_data=[ 
                                        'closing_balance'=>$cus_new_closing_pay_balance,
                                    ];
                                    $UserModel->update($cus_bal_payment,$cus_bal_payment_data); 


                                    //PAYMENT
                                    $bal_payment=get_payment_data($dp['id'],'type'); 

                                    $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                                    $new_closing_pay_balance=$current_pay_closing_balance;

                                    if ($dp['bill_type']=='receipt') {
                                        $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round(get_payment_data($dp['id'],'amount'),get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round(get_payment_data($dp['id'],'amount'),get_setting(company($myid),'round_of_value'));
                                    }

                                    $bal_payment_data=[ 
                                        'closing_balance'=>$new_closing_pay_balance,
                                    ];
                                    $UserModel->update($bal_payment,$bal_payment_data); 
                            // ??????????????????????????  customer and cash balance calculation end ??????????????
                            // ??????????????????????????  customer and cash balance calculation end ??????????????
                        }


                        foreach ($_POST["product_name"] as $i => $value ) {
                             
 
                            
                            if (is_numeric($_POST["amount"][$i])) {
                               $amount=$_POST["amount"][$i]; 
                            }else{
                                $amount=0;
                            } 

                            if (is_numeric($_POST["price"][$i])) {
                               $price=$_POST["price"][$i]; 
                            }else{
                                $price=0;
                            } 
                            


                            if (is_numeric($_POST["quantity"][$i])) {
                               $quantity=$_POST["quantity"][$i]; 
                            }else{
                                $quantity=0;
                            } 

                            if (is_numeric($_POST["old_paid_amount"][$i])) {
                               $old_paid_amount=$_POST["old_paid_amount"][$i]; 
                            }else{
                                $old_paid_amount=0;
                            }

                            
                            $reference_id=$_POST["reference_no"][$i];

 

                            $product_id=$_POST["product_id"][$i];
                            $product_desc=$_POST["product_desc"][$i];
                            $i_id=$_POST["i_id"][$i];

                            $checkexist=$PaymentsModel->where('id',$i_id)->where('deleted',0)->first();
                            if ($checkexist) {

                                $pdata=$PaymentsModel->where('id',$i_id)->first();
                                $old_amount=0;

                                $customer_data = [  
                                    'amount'=>$amount,
                                    'payment_note'=>$product_desc,
                                    'reference_id'=>$reference_id,
                                    'type'=>$payment_type,
                                    'quantity'=>$quantity,
                                    'datetime'=>strip_tags($this->request->getVar('invoice_date')),
                                    'price'=>$price,
                                    'edit_effected'=>0,
                                    'old_total'=>$pdata['amount'],
                                ]; 

                                if ($pdata) {
                                    $old_amount=$pdata['amount']; 
                                }
                                     


                                // balace data update 
                                $update_receipt=$PaymentsModel->update($i_id,$customer_data); 


                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                    //PAYMENT
                                    $cus_bal_payment=$product_id; 

                                    $cus_current_pay_closing_balance=user_data($cus_bal_payment,'closing_balance');
                                    $cus_new_closing_pay_balance=$cus_current_pay_closing_balance;

                                    if ($in_type=='receipt') {
                                        $cus_new_closing_pay_balance=($cus_new_closing_pay_balance+$pdata['amount'])-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $cus_new_closing_pay_balance=($cus_new_closing_pay_balance-$pdata['amount'])+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }

                                    $cus_bal_payment_data=[ 
                                        'closing_balance'=>$cus_new_closing_pay_balance,
                                    ];
                                    $UserModel->update($cus_bal_payment,$cus_bal_payment_data); 
                                // ??????????????????????????  customer and cash balance calculation end ??????????????
                                // ??????????????????????????  customer and cash balance calculation end ??????????????


                                if ($payment_type!=$old_payment_type) {
                                    $new_bal_payment=$payment_type; 

                                    $new_current_pay_closing_balance=user_data($new_bal_payment,'closing_balance');
                                    $new_new_closing_pay_balance=$new_current_pay_closing_balance;

                                    if ($in_type=='receipt') {
                                        $new_new_closing_pay_balance=$new_new_closing_pay_balance+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $new_new_closing_pay_balance=$new_new_closing_pay_balance-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                    }

                                    $new_bal_payment_data=[ 
                                        'closing_balance'=>$new_new_closing_pay_balance,
                                    ];
                                    $UserModel->update($new_bal_payment,$new_bal_payment_data);

                                    // --------------------

                                    $old_bal_payment=$old_payment_type;

                                    $old_current_pay_closing_balance=user_data($old_bal_payment,'closing_balance');
                                    $old_new_closing_pay_balance=$old_current_pay_closing_balance;

                                    if ($in_type=='receipt') {
                                        $old_new_closing_pay_balance=$old_new_closing_pay_balance-aitsun_round($old_amount,get_setting(company($myid),'round_of_value'));
                                    }else{
                                        $old_new_closing_pay_balance=$old_new_closing_pay_balance+aitsun_round($old_amount,get_setting(company($myid),'round_of_value'));
                                    }

                                    $old_bal_payment_data=[ 
                                        'closing_balance'=>$old_new_closing_pay_balance,
                                    ];
                                    $UserModel->update($old_bal_payment,$old_bal_payment_data); 
                                }else{
                                    // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                    // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                            //PAYMENT
                                            $bal_payment=$payment_type; 

                                            $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                                            $new_closing_pay_balance=$current_pay_closing_balance;

                                            if ($in_type=='receipt') {
                                                $new_closing_pay_balance=($new_closing_pay_balance-$old_paid_amount)+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                            }else{
                                                $new_closing_pay_balance=($new_closing_pay_balance+$old_paid_amount)-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                            }

                                            $bal_payment_data=[ 
                                                'closing_balance'=>$new_closing_pay_balance,
                                            ];
                                            $UserModel->update($bal_payment,$bal_payment_data); 
                                    // ??????????????????????????  customer and cash balance calculation end ??????????????
                                    // ??????????????????????????  customer and cash balance calculation end ??????????????
                                }
                            }else{
                               $customer_dataa = [
                                    'company_id'=>company($myid),
                                    'voucher_id'=>$ins_id,
                                    'type'=>$payment_type,
                                    'amount'=>$amount,
                                    'payment_note'=>$product_desc,
                                    'reference_id'=>$reference_id,
                                    'datetime'=>strip_tags($this->request->getVar('invoice_date')),
                                    'payment_id'=> $receipt_no=receipt_no_generate(5),
                                    'company_id'=>company($myid),
                                    'bill_type'=>$in_type, 
                                    'receive_status'=>1,
                                    'account_name'=>$product_id,
                                    'serial_no'=>serial_no_cash(company($myid)),
                                    'customer'=>strip_tags($this->request->getVar('customer')),
                                    'quantity'=>$quantity,
                                    'price'=>$price,

                                ]; 
                                $update_receipt=$PaymentsModel->save($customer_dataa);


                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                        //PAYMENT
                                        $cus_bal_payment=$product_id; 

                                        $cus_current_pay_closing_balance=user_data($cus_bal_payment,'closing_balance');
                                        $cus_new_closing_pay_balance=$cus_current_pay_closing_balance;

                                        if ($in_type=='receipt') {
                                            $cus_new_closing_pay_balance=$cus_new_closing_pay_balance-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                        }else{
                                            $cus_new_closing_pay_balance=$cus_new_closing_pay_balance+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                        }

                                        $cus_bal_payment_data=[ 
                                            'closing_balance'=>$cus_new_closing_pay_balance,
                                        ];
                                        $UserModel->update($cus_bal_payment,$cus_bal_payment_data); 
                                // ??????????????????????????  customer and cash balance calculation end ??????????????
                                // ??????????????????????????  customer and cash balance calculation end ??????????????   

                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                                        //PAYMENT
                                        $bal_payment=$payment_type; 

                                        $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                                        $new_closing_pay_balance=$current_pay_closing_balance;

                                        if ($in_type=='receipt') {
                                            $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                        }else{
                                            $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round($amount,get_setting(company($myid),'round_of_value'));
                                        }

                                        $bal_payment_data=[ 
                                            'closing_balance'=>$new_closing_pay_balance,
                                        ];
                                        $UserModel->update($bal_payment,$bal_payment_data); 
                                // ??????????????????????????  customer and cash balance calculation end ??????????????
                                // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                            } 

                            

                        }

                         
                        if ($in_ins) {
                            $company=company($myid);
                            $userid=$myid;
                            $check_date=$check_date;
                            $paid=$paid_amount;
                            echo $ins_id;


                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'Voucher <b>#'.$ins_id.'</b> is updated.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////
                        
                        }else{
                            echo "failed";
                        }

                    }

                            
                }else{
                    echo 'failed';
                }
        }

        
        public function get_voucher($cusval="",$type="view"){
               $session=session();
                $UserModel=new Main_item_party_table;
                $VoucherListModel=new VoucherListModel;

              

                        $myid=session()->get('id');
                        $user=$UserModel->where('id',$myid)->first();

                    if ($cusval) {
                         
                        $vdata=$VoucherListModel->where('id',$cusval)->first();
                        $filename='Voucher - '.$vdata['id'];
                        $data = [
                            'title' => $filename,
                            'voucher_id'=>$cusval,
                            'user'=>$user,
                            'voucher_data'=>$vdata
                        ];
                        
                         
                        
                        $dompdf = new \Dompdf\Dompdf();
                        $dompdf->set_option('isJavascriptEnabled', TRUE);
                        $dompdf->set_option('isRemoteEnabled', TRUE); 

                        $dompdf->loadHtml(view('voucher_entries/voucher_show', $data));
                        $dompdf->setPaper('A4', 'portrait');
                        $dompdf->render();

                        if ($type=='download') {
                          $dompdf->stream($filename, array("Attachment" => true));
                        }else{
                          $dompdf->stream($filename, array("Attachment" => false));
                        }  

                        exit();
                    }else{
                        // return redirect()->to(base_url('invoices'));
                    }

              

                
        }

        public function get_thermal_script($cusval=""){
            $session=session();
            $UserModel=new Main_item_party_table;
            $VoucherListModel=new VoucherListModel;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                if ($cusval) {
                     
                    
                    
                    $data = [
                        'title' => 'Aitsun ERP-Vucher Details',
                        'voucher_id'=>$cusval,
                        'user'=>$user,
                        'voucher_data'=>$VoucherListModel->where('id',$cusval)->first()
                    ];

                    echo view('voucher_entries/voucher_thermal_script', $data);
                }else{
                    return redirect()->to(base_url('voucher_entries'));
                }

            }else{
                return redirect()->to(base_url('users/login'));
            }
        }




        public function add_voucher_settings($id=''){

        $session=session();

        if($session->has('isLoggedIn')){

                $myid=session()->get('id');
          $CompanySettings2= new CompanySettings2;

          $UserModel = new Main_item_party_table;

            if (isset($_POST['add_voucher_settings'])) {
                $ac_data = [
                'voucher_page_size'=>strip_tags($this->request->getVar('voucher_page_size')),
                'voucher_orientation'=>strip_tags($this->request->getVar('voucher_orientation')),           
                
            ];

            $update_user=$CompanySettings2->update(get_setting2(company($myid),'id'),$ac_data);
                if ($update_user){
                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> Voucher settings updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                     session()->setFlashdata('pu_msg', 'Saved!');
                     return redirect()->to(base_url('voucher_entries/details/'.$id));
                }else{
                    session()->setFlashdata('pu_er_msg', 'Failed to save!');
                   return redirect()->to(base_url('voucher_entries/details/'.$id));
                }
            }

      
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }



}