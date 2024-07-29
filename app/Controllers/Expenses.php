<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\AccountCategory;
use App\Models\CustomerBalances;
use App\Models\PaymentsModel;
use App\Models\ExpensestypeModel;
use App\Models\LeadModel;


class Expenses extends BaseController {

     public function index()
        {

            $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;


            if($session->has('isLoggedIn')){

                    $myid=session()->get('id');

                    $con = array( 
                        'id' => session()->get('id') 
                    );

                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   


                    

                    // $this->db->where('bill_type!=','purchase');
                    // $this->db->where('bill_type!=','payment');
                    

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

                        if (isset($_GET['customer'])) {
                            if (!empty($_GET['customer'])) {
                                if ($_GET['customer']=='CASH') {
                                    $PaymentsModel->where('customer',$_GET['customer']);
                                }else{
                                    $PaymentsModel->where('account_name',$_GET['customer']);
                                }
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


                    
                    $allpayments = $PaymentsModel->where('company_id',company($myid))->where('deleted',0)->groupStart()->where('bill_type','expense')->orWhere('bill_type','purchase')->orWhere('bill_type','sales_return')->orWhere('bill_type','discount_allowed')->groupEnd()->orderBy('id','DESC')->findAll();

                   
                    $debit_sum=0;
                    $credit_sum=0;

                    foreach ($allpayments as $sv) {

                        if ($sv['bill_type']=='expense'){
                            $debit_sum+=$sv['amount'];
                        }
                        
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Expenses',
                        'user' => $user,
                        'allpayments' => $allpayments,
                        'debit_sum'=>$debit_sum,
                        'credit_sum'=>$credit_sum,
                    ];



                    if (isset($_POST['get_excel'])) {


                        

                        $fileName = "Payments". ".xls"; 
                         
                        // Column names 
                        $fields = array('PAY NO.', 'DATE', 'PAYMENTS CATEGORY', 'PAYMENT TYPE', '#ID', 'STATUS', 'DEBIT', 'CREDIT'); 

                        
                         
                         // print_r($fields);

                        // Display column names as first row 
                        $excelData = implode("\t", array_values($fields)) . "\n"; 
                         
                        // Fetch records from database 
                        $query = $allpayments; 
                        if(count($query) > 0){ 
                            // Output each row of the data 
                            foreach ($query as $row) {

                                $serial_no = get_setting(company($myid),'payment_prefix').''.$row['serial_no'];

                                $customer=$row['customer'];


                                if ($row['customer']!='CASH'){
                                 
                                  $customer=user_name($row['customer']);
                                  
                                }elseif ($row['alternate_name']==''){
                                  $customer=langg(get_setting(company($myid),'language'),'CASH CUSTOMER');
                                }else{
                                  $customer=langg(get_setting(company($myid),'language'),'CASH CUSTOMER').''.($row['alternate_name']);
                                }

                                if ($row['bill_type']=='expense'){

                                    $customer = expense_type_name($row['account_name']);

                                }

                                $date=get_date_format($row['datetime'],'d M Y');

                                $sp_id= '';

                                 if ($row['bill_type']=='sale' || $row['bill_type']=='purchase return' || $row['bill_type']=='purchase' || $row['bill_type']=='sale return'){

                                      $sp_id = inventory_prefix(company($myid),$row['bill_type']).''.$row['invoice_id'];

                                }

                                $debit= '';

                                if ($row['bill_type']=='expense' || $row['bill_type']=='purchase' || $row['bill_type']=='sale return'){

                                  $debit= $row['amount'];

                                }else{

    
                                }


                                $credit= '';

                               if($row['bill_type']=='receipt' || $row['bill_type']=='sale' || $row['bill_type']=='purchase return'){

                                    $credit= $row['amount'];

                               }else{

                               }


                               $status= '';

                                if ($row['type']=='cheque' || $row['type']=='bank_transfer'){ 

                                if ($row['receive_status']=='1'){

                                    $status= 'Received';
                                }else{ 
                                    $status='Not Received';
                                } 

                                }

                                 
                                $colllumns=array($serial_no,$date,$customer,$row['type'],$sp_id,$status,$debit,$credit);
                                
                                array_walk($colllumns, 'filterData');
                                $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
                            }
                        }else{ 
                            $excelData .= 'No records found...'. "\n"; 
                        } 
                         
                        // // Headers for download 
                        header("Content-Type: application/vnd.ms-excel"); 
                        header("Content-Disposition: attachment; filename=\"$fileName\""); 
                         
                        // Render excel data 
                        echo $excelData; 
                         
                        exit;
                    }

                    echo view('header',$data);
                    echo view('expenses/expenses', $data);
                    echo view('footer');

                  


                    if (isset($_POST['save_expenses_entry'])) {

                        $payment_type=strip_tags($this->request->getVar('payment_type')); 

                        $bank_amt=strip_tags($this->request->getVar('cash_amount'));

                        $receipt_no=receipt_no_generate(5);
                        $customer_data = [
                            'company_id'=>company($myid),
                            'type'=>$payment_type,
                            'amount'=>$bank_amt,
                            'payment_note'=>strip_tags($this->request->getVar('note')),
                            'datetime'=>strip_tags($this->request->getVar('date')),
                            'payment_id'=>$receipt_no,
                            'company_id'=>company($myid),
                            'bill_type'=>'expense',
                            'cheque_no'=>strip_tags($this->request->getVar('cheque_no')),
                            'cheque_date'=>strip_tags($this->request->getVar('cheque_date')),
                            'reference_id'=>strip_tags($this->request->getVar('reference_id')),
                            'receive_status'=>0,
                            'account_name'=>strip_tags($this->request->getVar('account_name')),
                            'serial_no'=>serial_no_cash(company($myid)),
                        ];


                        $add_receipt=$PaymentsModel->save($customer_data);

                        if ($add_receipt) {
                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New expense <b>'.$receipt_no.'</b> added.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////

                            $session->setFlashdata('sucmsg', 'Saved!');
                            return redirect()->to(base_url('expenses'));
                        }else{
                            $session->setFlashdata('failmsg', 'Failed to save!');
                            return redirect()->to(base_url('expenses'));
                        }
                    }



                    if (isset($_POST['edit_expenses_entry'])) {
                        $payment_type=strip_tags($this->request->getVar('payment_type')); 
                        $bank_amt=strip_tags($this->request->getVar('cash_amount'));
                        
                        $pdata=$PaymentsModel->where('id',$_POST['payid'])->first();
                        $old_amount=0;

                        $receipt_no=receipt_no_generate(5);
                        $customer_data = [
                            'bill_type'=>'expense',
                            'cheque_no'=>strip_tags($this->request->getVar('cheque_no')),
                            'cheque_date'=>strip_tags($this->request->getVar('cheque_date')),
                            'reference_id'=>strip_tags($this->request->getVar('reference_id')),
                            'type'=>$payment_type,
                            'amount'=>$bank_amt,
                            'payment_note'=>strip_tags($this->request->getVar('note')),
                            'account_name'=>strip_tags($this->request->getVar('account_name')),
                            'edit_effected'=>0,
                            'old_total'=>$pdata['amount'],
                        ];

                        if ($pdata) {
                            $old_amount=$pdata['amount']; 
                        }
                             


                        // balace data update

                        $up=$PaymentsModel->update($_POST['payid'],$customer_data);

                        if ($up) {
                            $session->setFlashdata('sucmsg', 'Saved!');
                            return redirect()->to(base_url('expenses'));
                        }else{
                            $session->setFlashdata('sucmsg', 'Failed to save!');
                            return redirect()->to(base_url('expenses'));
                        }
                    }

                }else{
                    return redirect()->to(base_url('users/login'));
                }
                
        }


    public function delete_exp($inid){

            $session=session();
            $myid=session()->get('id');
            $UserModel= new Main_item_party_table;
            $PaymentsModel= new PaymentsModel;


            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            
            if($session->has('isLoggedIn')){

                
                $deledata=[
                    'deleted'=>1,
                    'edit_effected'=>0
                ];
                $del=$PaymentsModel->update($inid,$deledata);
                
                if ($del) {


                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Expenses <b>#'.$inid.'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                    $session->setFlashdata('sucmsg', 'Deleted!');
                    return redirect()->to(base_url('expenses'));
                }else{
                    $session->setFlashdata('sucmsg', 'Failed to delete!');
                    return redirect()->to(base_url('expenses'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }


    public function add_ex_cate_ajax_crm($lead_id=""){
        $session=session();
        $myid=session()->get('id');

        $con = array( 
            'id' => session()->get('id') 
        ); 

        $ExpensestypeModel = new ExpensestypeModel;
        $LeadModel= new LeadModel;

        $lead_data=$LeadModel->where('id',$lead_id)->first();

         if (isset($_POST['ex_cate_name'])) {
                $pu_data = [
                    'company_id' => company($myid),
                    'expense_name'=>$this->request->getVar('ex_cate_name')
                ];

                $un=$ExpensestypeModel->save($pu_data);

               

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////

               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'New expense <b>'.$this->request->getVar('ex_cate_name').'</b> is created in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Expenses create',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                
                $uinserid=$ExpensestypeModel->insertID();

                if ($un){
                   echo $uinserid;
                }else{
                    echo 0;
                }
            }
    }


    public function add_ex_cate_ajax(){
        $session=session();
        $myid=session()->get('id');

        $con = array( 
            'id' => session()->get('id') 
        ); 

        $ExpensestypeModel = new ExpensestypeModel;
        $LeadModel= new LeadModel;


         if (isset($_POST['ex_cate_name'])) {
                $pu_data = [
                    'company_id' => company($myid),
                    'expense_name'=>$this->request->getVar('ex_cate_name')
                ];

                $un=$ExpensestypeModel->save($pu_data);
                
                $uinserid=$ExpensestypeModel->insertID();

                if ($un){
                   echo $uinserid;
                }else{
                    echo 0;
                }
            }
    }

    }