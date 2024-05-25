<?php

namespace App\Controllers; 
use App\Models\InvoiceModel;
use App\Models\Main_item_party_table;
use App\Models\AccountCategory;
use App\Models\CustomerBalances;
use App\Models\PaymentsModel;
use App\Models\CompanySettings2;
use App\Models\FeesModel;


class Payments extends BaseController
{
    public function index()
    {
        return redirect()->to(base_url());
    }

    public function details($cusval=""){
            
            $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;
            $CompanySettings2=new CompanySettings2;
            

                if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    if (check_permission($myid,'manage_cash_ex')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
                    
                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $erqry = $PaymentsModel->where('id',$cusval)->first(); 
                        
                    $data = [
                        'title' => 'Aitsun ERP-Payments Receipt',
                        'user'=>$user,
                        'pmt' => $erqry  
                    ];

                    echo view('header',$data);
                    echo view('payments/payment_details', $data);
                    echo view('footer');

            }else{
                return redirect()->to(base_url('users/login'));
            }
    
    }

    public function get_receipt($pid='',$type='view'){
         $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;
            $InvoiceModel=new InvoiceModel;
            $FeesModel=new FeesModel;
             $myid=session()->get('id');
            $page_size='A5';
                $orientation='portrait';

                if (!empty($page_size)) {
                    $page_size=strtoupper(get_setting2(company($myid),'receipt_page_size')); 
                }

                if (!empty($page_size)) {
                    $orientation=get_setting2(company($myid),'receipt_orientation'); 
                }


                $last_height=0;

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                if ($pid) {
                     
                    $erqry = $PaymentsModel->where('id',$pid)->first(); 
                     
                    $filename=get_setting(company($myid),'payment_prefix').serial_cash(company($myid),$pid);

                    $invoice_data=$InvoiceModel->where('id',$erqry['invoice_id'])->first();
                    $ft=$FeesModel->where('id',$erqry['fees_id'])->first();

                    
                    $data = [
                        'title' => $filename,
                        'payment_id'=>$pid,
                        'user'=>$user, 
                        'pmt' => $erqry,
                        'page_type'=>'pdf',  
                        'invoice'=>$invoice_data,
                        'ft'=>$ft,
                    ];
                    
                   
                    $dompdf = new \Dompdf\Dompdf();
                    $dompdf->set_option('isJavascriptEnabled', TRUE);
                    $dompdf->set_option('isRemoteEnabled', TRUE); 
                    if ($erqry['fees_id']>0) {
                        
                        $dompdf->loadHtml(view('payments/receipt_design_for_school', $data));
                    }else{
                       $dompdf->loadHtml(view('payments/receipt_design2', $data));
                    }
                    
                    $dompdf->setPaper($page_size, $orientation);
                    $dompdf->render();

                    if ($type=='download') {
                      $dompdf->stream($filename, array("Attachment" => true));
                    }else{
                      $dompdf->stream($filename, array("Attachment" => false));
                    }  

                    exit();

  
                }
            
    }




    public function update_status(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $PaymentsModel=new PaymentsModel;
        $myid=session()->get('id');

        if (isset($_POST['statusname'],$_POST['getid'])) {
            $cdad=[
                'receive_status'=>$_POST['statusname']
            ];

            $PaymentsModel->update($_POST['getid'],$cdad);

            if ($_POST['statusname']==1) {
                $stat='received';
            }else{
                $stat='not received';
            }

            ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>'Payment(#'.$_POST['getid'].') is '.$stat.'',
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



    public function pdf($cusval=""){
            $session=session();
            $UserModel=new Main_item_party_table;
            $PaymentsModel=new PaymentsModel;

         if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
        

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

    
        if (check_permission($myid,'manage_cash_ex')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
        
        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }
        $pmt = $PaymentsModel->where('id',$cusval)->first(); 

        $data = [
            'title' => 'Aitsun ERP-Payments Receipt',
            'user'=>$user,
            'pmt' => $pmt
        ];



        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
        ]);

        $pdfname='';

        if ($pmt['customer']=='CASH'):
            $pdfname.='CASH CUSTOMER';
        else:
            $pdfname.=user_name($pmt['customer']);
        endif;


        $html = view('payments/payment_pdf',$data);
        $mpdf->WriteHTML($html);
        $mpdf->Output('RECEIPT-'.$pdfname.get_setting(company($myid),'payment_prefix').serial_cash(company($myid),$pmt['id']).'.pdf','I');

    }else{
        return redirect()->to(base_url('users/login'));
    }

    
}



public function cash_and_bank()
        {
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

               


                if (check_permission($myid,'manage_cash_ex')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

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

                   
                    $debit_sum=0;
                    $credit_sum=0;


                    $allpayments=$PaymentsModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0)->where('bill_type!=','expense')->where('bill_type!=','sales_return')->where('bill_type!=','purchase')->where('bill_type!=','discount_allowed')->findAll();

                    foreach ($allpayments as $sv) {

                        if ($sv['bill_type']=='payment' || $sv['bill_type']=='purchase' || $sv['bill_type']=='sale return'){
                            $debit_sum+=$sv['amount'];
                        }elseif ($sv['bill_type']=='receipt' || $sv['bill_type']=='sale' || $sv['bill_type']=='purchase return'){
                            $credit_sum+=$sv['amount'];
                        }
                        
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Cash and Bank',
                        'user' => $user,
                        'user_data' => $user_data,
                        'allpayments' => $allpayments,
                        'debit_sum'=>$debit_sum,
                        'credit_sum'=>$credit_sum,
                    ];


                    if (isset($_POST['get_excel'])) {


                        

                        $fileName = "PAYMENTS". ".xls"; 
                         
                        // Column names 
                        $fields = array('PAY NO.', 'DATE', 'CUSTOMER', 'PAYMENT TYPE', '#ID', 'STATUS', 'DEBIT', 'CREDIT'); 

                        
                         
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

                                $date=get_date_format($row['datetime'],'d M Y');

                                $sp_id= '';

                                 if ($row['bill_type']=='sales' || $row['bill_type']=='purchase_return' || $row['bill_type']=='purchase' || $row['bill_type']=='sales_return'){

                                      $sp_id = inventory_prefix(company($myid),$row['bill_type']).''.$row['invoice_id'];

                                }

                                $debit= '';

                                if ($row['bill_type']=='expense' || $row['bill_type']=='purchase' || $row['bill_type']=='sales_return'){

                                  $debit= $row['amount'];

                                }else{

    
                                }


                                $credit= '';

                               if($row['bill_type']=='receipt' || $row['bill_type']=='sales' || $row['bill_type']=='purchase_return'){

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
                    echo view('payments/cash_and_bank', $data);
                    echo view('footer');




                    if (isset($_POST['save_receipt_entry'])) {

                        $payment_type=strip_tags($this->request->getVar('payment_type')); 
                        $p_amt=strip_tags($this->request->getVar('cash_amount'));

                        $receipt_no=receipt_no_generate(5);
                        $customer_data = [
                            'company_id'=>company($myid),
                            'type'=>$payment_type,
                            'amount'=>$p_amt,
                            'payment_note'=>strip_tags($this->request->getVar('note')),
                            'datetime'=>strip_tags($this->request->getVar('date')),
                            'payment_id'=>$receipt_no,
                            'company_id'=>company($myid),
                            'bill_type'=>strip_tags($this->request->getVar('vtype')),
                            'cheque_no'=>strip_tags($this->request->getVar('cheque_no')),
                            'cheque_date'=>strip_tags($this->request->getVar('cheque_date')),
                            'reference_id'=>strip_tags($this->request->getVar('reference_id')),
                            'receive_status'=>0,
                            'account_name'=>strip_tags($this->request->getVar('account_name')),
                            'serial_no'=>serial_no_cash(company($myid)),
                            'customer'=>strip_tags($this->request->getVar('customer')),

                        ];


                        $add_receipt=$PaymentsModel->save($customer_data);

                        if ($add_receipt) {
                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New receipt <b>'.$receipt_no.'</b> added.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////

                            $session->setFlashdata('pu_msg', 'Saved!');
                            return redirect()->to(base_url('payments/cash_and_bank'));
                        }else{
                            $session->setFlashdata('pu_er_msg', 'Failed to save!');
                            return redirect()->to(base_url('payments/cash_and_bank'));
                        }
                    }



                    if (isset($_POST['edit_receipt_entry'])) {
                        $payment_type=strip_tags($this->request->getVar('payment_type')); 

                        $p_amt=strip_tags($this->request->getVar('cash_amount'));

                        $pdata=$PaymentsModel->where('id',$_POST['payid'])->first();
                        $old_amount=0;

                        $receipt_no=receipt_no_generate(5);
                        $customer_data = [
                            'type'=>$payment_type,
                            'amount'=>$p_amt,
                            'payment_note'=>strip_tags($this->request->getVar('note')),
                            'datetime'=>strip_tags($this->request->getVar('date')),
                            'bill_type'=>strip_tags($this->request->getVar('vtype')),
                            'account_name'=>strip_tags($this->request->getVar('account_name')),
                            'customer'=>strip_tags($this->request->getVar('customer')),
                            'cheque_no'=>strip_tags($this->request->getVar('cheque_no')),
                            'cheque_date'=>strip_tags($this->request->getVar('cheque_date')),
                            'reference_id'=>strip_tags($this->request->getVar('reference_id')),
                            'edit_effected'=>0,
                            'old_total'=>$pdata['amount'],
                        ];

                        if ($pdata) {
                            $old_amount=$pdata['amount']; 
                        }
                             


                        // balace data update

                        $up=$PaymentsModel->update($_POST['payid'],$customer_data);
                        
                        

                        if ($up) {
                            $session->setFlashdata('pu_msg', 'Saved!');
                            return redirect()->to(base_url('payments/cash_and_bank'));
                        }else{
                            $session->setFlashdata('pu_er_msg', 'Failed to save!');
                            return redirect()->to(base_url('payments/cash_and_bank'));
                        }
                    }

                }else{
                    return redirect()->to(base_url('users/login'));
                }
                
        }



    public function delete($inid){

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

                    // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                    // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                            //PAYMENT
                            $cus_bal_payment=get_payment_data($inid,'account_name'); 

                            $cus_current_pay_closing_balance=user_data($cus_bal_payment,'closing_balance');
                            $cus_new_closing_pay_balance=$cus_current_pay_closing_balance;

                            if (get_payment_data($inid,'bill_type')=='receipt') {
                                $cus_new_closing_pay_balance=$cus_new_closing_pay_balance+aitsun_round(get_payment_data($inid,'amount'),get_setting(company($myid),'round_of_value'));
                            }else{
                                $cus_new_closing_pay_balance=$cus_new_closing_pay_balance-aitsun_round(get_payment_data($inid,'amount'),get_setting(company($myid),'round_of_value'));
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
                            $bal_payment=get_payment_data($inid,'type'); 

                            $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                            $new_closing_pay_balance=$current_pay_closing_balance;

                            if (get_payment_data($inid,'bill_type')=='receipt') {
                                $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round(get_payment_data($inid,'amount'),get_setting(company($myid),'round_of_value'));
                            }else{
                                $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round(get_payment_data($inid,'amount'),get_setting(company($myid),'round_of_value'));
                            }

                            $bal_payment_data=[ 
                                'closing_balance'=>$new_closing_pay_balance,
                            ];
                            $UserModel->update($bal_payment,$bal_payment_data); 
                    // ??????????????????????????  customer and cash balance calculation end ??????????????
                    // ??????????????????????????  customer and cash balance calculation end ??????????????


                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Payment <b>#'.$inid.'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                    $session->setFlashdata('pu_msg', 'Deleted!');
                    return redirect()->to(base_url('voucher_entries'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                    return redirect()->to(base_url('voucher_entries'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



        public function delete_from_invoice($inid='',$invoice_id=''){

            $session=session();
            $myid=session()->get('id');
            $UserModel= new Main_item_party_table;
            $PaymentsModel= new PaymentsModel;
            $InvoiceModel= new InvoiceModel;  



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
                    $rec_amt=get_payment_data($inid,'amount');
                    $old_paid_amount=invoice_data($invoice_id,'paid_amount');
                    $old_due_amount=invoice_data($invoice_id,'due_amount');

                    $paid_amount=$old_paid_amount-$rec_amt;
                    $due_amount=$old_due_amount+$rec_amt;
                    /////////////// RESET INVOICE DATA/////////////////////
                    $resindata=[
                        'paid_amount'=>$paid_amount,
                        'due_amount'=>$due_amount,
                        'paid_status'=>'unpaid',
                    ];
                    $InvoiceModel->update($invoice_id,$resindata);
                    /////////////// RESET INVOICE DATA/////////////////////




 

                    
                    

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Payment <b>#'.$inid.'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                    $session->setFlashdata('pu_msg', 'Deleted!');
                    return redirect()->to(base_url('invoices/pay/'.$invoice_id));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                    return redirect()->to(base_url('invoices/pay/'.$invoice_id));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }


        public function add_receipt_settings($id=''){

        $session=session();

        if($session->has('isLoggedIn')){

                $myid=session()->get('id');
          $CompanySettings2= new CompanySettings2;

          $UserModel = new Main_item_party_table;

            if (isset($_POST['add_receipt_settings'])) {
                $ac_data = [
                'receipt_page_size'=>strip_tags($this->request->getVar('receipt_page_size')),
                'receipt_orientation'=>strip_tags($this->request->getVar('receipt_orientation')),           
                
            ];

            $update_user=$CompanySettings2->update(get_setting2(company($myid),'id'),$ac_data);
                if ($update_user){
                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> receipt settings updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                     session()->setFlashdata('pu_msg', 'Saved!');
                     return redirect()->to(base_url('payments/details/'.$id));
                }else{
                    session()->setFlashdata('pu_er_msg', 'Failed to save!');
                   return redirect()->to(base_url('receipt_entries/details/'.$id));
                }
            }

      
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
}