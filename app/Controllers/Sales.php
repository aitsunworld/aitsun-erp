<?php
    namespace App\Controllers;
 
    use App\Models\ProductUnits;
    use App\Models\ProductCategories;
    use App\Models\ProductSubCategories;
    use App\Models\SecondaryCategories;
    use App\Models\ProductBrand;
    use App\Models\ProductsModel;
    use App\Models\ProductsImages;
    use App\Models\ProductratingsModel;
    use App\Models\AdditionalfieldsModel;
    use App\Models\InvoiceModel;
    use App\Models\InvoiceitemsModel;
    use App\Models\StockModel;
    use App\Models\PaymentsModel;
    use App\Models\TaxModel;
    use App\Models\CrmActionInventories;
    use App\Models\LeadModel;
    use App\Models\InvoiceTaxes; 
    use App\Models\Main_item_party_table; 
    use App\Models\AppointmentsBookings;
    use App\Models\PosSessions; 



    class Sales extends BaseController
    {
        public function index()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;
            $InvoiceitemsModel=new InvoiceitemsModel;
            $PaymentsModel=new PaymentsModel;
            $TaxModel=new TaxModel;
            $ProductsModel=new Main_item_party_table;
            $InvoiceTaxes=new InvoiceTaxes;
            $PosSessions = new PosSessions;
            $AppointmentsBookings = new AppointmentsBookings;


            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 


                if ($this->request->getMethod()=='post') {
                    $paid_amount=0;
                       
                    $check_nomber='';
                    $check_date='';
                    $chk_amt=0;

                    $in_type=strip_tags($this->request->getVar('invoice_type'));

                    $view_method=strip_tags($this->request->getVar('view_method'));
                    $convertfrom=strip_tags($this->request->getVar('convertfrom'));

                    $paid_amount=$_POST['cash_amount']; 

                    $grandtotal=strip_tags($this->request->getVar('grand_total'));

                    
                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='sales_return' || $in_type=='purchase' || $in_type=='purchase_return') {
                        if ($paid_amount<aitsun_round($grandtotal,get_setting(company($myid),'round_of_value'))) {
                            $paid_stat='unpaid';
                        }else{
                            $paid_stat='paid';
                        }
                    }else{
                        $paid_stat='unpaid';
                    }

                    $duuuuamt=strip_tags($this->request->getVar('due_amount'));
                    $customer=strip_tags($this->request->getVar('customer'));
                    $bigdiscount=strip_tags($this->request->getVar('discount'));

                    foreach ($_POST["product_name"] as $i => $value ) {
                        if (is_numeric($_POST["p_discount"][$i])) {
                             $bigdiscount+=$_POST["p_discount"][$i];
                        } 
                    }

                    if ($in_type=='sales' || $in_type=='sales_return' || $in_type=='purchase' || $in_type=='purchase_return') {
                        $converttted=1;
                    }else{
                        $converttted=0;
                    }

                    $bill_from=strip_tags($this->request->getVar('invoice_for'));

                    $booking_id=strip_tags($this->request->getVar('booking_id'));
                
                    if ($booking_id>0) {
                        $bill_from='appointment';
                    }

                    $rent_from='';
                    $rent_to='';

                    $rent_from_date=strip_tags($this->request->getVar('rent_from_date'));
                    $rent_from_time=strip_tags($this->request->getVar('rent_from_time'));
                    $rent_to_date=strip_tags($this->request->getVar('rent_to_date'));
                    $rent_to_time=strip_tags($this->request->getVar('rent_to_time'));
                    $rent_from=$rent_from_date.' '.$rent_from_time;
                    $rent_to=$rent_to_date.' '.$rent_to_time;
        
                    
                     

                    $in_data=[
                        'company_id'=>company($myid),
                        'customer'=>strip_tags($this->request->getVar('customer')),
                        'bill_number'=>strip_tags($this->request->getVar('bill_number')),
                        'alternate_name'=>strip_tags($this->request->getVar('alternate_name')),
                        'notes'=>strip_tags($this->request->getVar('notes')),
                        'private_notes'=>strip_tags($this->request->getVar('private_notes')),
                        'transport_charge'=>strip_tags($this->request->getVar('transport_charge')),
                        'total'=>aitsun_round($grandtotal,get_setting(company($myid),'round_of_value')),
                        'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                        'created_at'=>now_time($myid),
                        'billed_by'=>$myid,
                        'sub_total'=>strip_tags($this->request->getVar('sub_total')),
                        'discount'=>aitsun_round($bigdiscount,get_setting(company($myid),'round_of_value')),
                        'tax'=>strip_tags(aitsun_round($this->request->getVar('tax_amount'),get_setting(company($myid),'round_of_value'))),
                        'round_type'=>strip_tags($this->request->getVar('round_type')),
                        'round_off'=>strip_tags(aitsun_round(str_replace('-','',$this->request->getVar('round_off')),get_setting(company($myid),'round_of_value'))),
                        'vehicle_number'=>strip_tags($this->request->getVar('vehicle_number')),
                        'status'=>'sent',
                        'paid_status'=>$paid_stat,
                        'due_amount'=>aitsun_round($duuuuamt,get_setting(company($myid),'round_of_value')),
                        'paid_amount'=>aitsun_round($paid_amount,get_setting(company($myid),'round_of_value')),
                        'invoice_type'=>$in_type,
                        'converted'=>$converttted,
                        'serial_no'=>serial_no(company($myid),$in_type), 
                        'company_state'=>strip_tags($this->request->getVar('company_state')),
                        'state_of_supply'=>strip_tags($this->request->getVar('state_of_supply')),
                        'cash_discount_percent'=>strip_tags(aitsun_round($this->request->getVar('cash_discount_percent'),get_setting(company($myid),'round_of_value'))),
                        'additional_discount_percent'=>strip_tags(aitsun_round($this->request->getVar('additional_discount_percent'),get_setting(company($myid),'round_of_value'))),
                        'additional_discount'=>strip_tags(aitsun_round($this->request->getVar('additional_discount'),get_setting(company($myid),'round_of_value'))),
                        'inv_referal'=>strip_tags($this->request->getVar('inv_referal')), 
                        'mrn_number'=>strip_tags($this->request->getVar('mrn_number')),
                        'doctor_name'=>strip_tags($this->request->getVar('doctor_name')),
                        'validity'=>strip_tags($this->request->getVar('validity')),
                        'session_id'=>strip_tags($this->request->getVar('session_id')),
                        'bill_type'=>strip_tags($this->request->getVar('bill_type')),
                        'booking_id'=>$booking_id,
                        'bill_from'=>$bill_from,
                        'rental_status'=>0,
                        'invoice_address'=>strip_tags($this->request->getVar('invoice_address')),
                        'delivery_address'=>strip_tags($this->request->getVar('delivery_address')),
                        'rent_from'=>$rent_from,
                        'rent_to'=>$rent_to,
                        'rental_duration'=>strip_tags($this->request->getVar('rental_duration'))
                    ];
                     
                    $in_ins=$InvoiceModel->save($in_data);
                    $ins_id=$InvoiceModel->insertID();

                    if ($this->request->getVar('bill_type')=='pos') {
                        $session_pos_id=$PosSessions->where('id',$this->request->getVar('session_id'))->first();

                        $pos_total_amt=$session_pos_id['closing_balance']+$grandtotal;
                        $pos_data=[
                            'closing_balance'=>aitsun_round($pos_total_amt,get_setting(company($myid),'round_of_value'))
                        ];
                        $PosSessions->update($session_pos_id['id'],$pos_data);
                    }

                    if ($booking_id>0) {
                        $AppointmentsBookings->update($booking_id,['billing_status'=>1]);
                    }


                    // ??????????????????????????  customer and cash balance calculation start ????????????
                    // ??????????????????????????  customer and cash balance calculation start ????????????
                    //CUSTOMER
                        $bal_customer=strip_tags($this->request->getVar('customer'));

                        $current_closing_balance=user_data($bal_customer,'closing_balance');
                        $new_closing_balance=$current_closing_balance;

                        if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                            $new_closing_balance=$new_closing_balance+aitsun_round($duuuuamt,get_setting(company($myid),'round_of_value'));
                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                            $new_closing_balance=$new_closing_balance-aitsun_round($duuuuamt,get_setting(company($myid),'round_of_value'));
                        }


                        $bal_customer_data=[ 
                            'closing_balance'=>$new_closing_balance,
                        ];
                        $UserModel->update($bal_customer,$bal_customer_data);
                    // ??????????????????????????  customer and cash balance calculation end ??????????????
                    // ??????????????????????????  customer and cash balance calculation end ??????????????


                    // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                    // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                        $payment_types = $_POST['payment_type'];
                        $payment_values = $_POST['payment_type_value'];
 
                        $combined_array = array_combine($payment_types, $payment_values);

                        foreach ($combined_array as $payment_type => $payment_value) {
                            //PAYMENT
                            $bal_payment=$payment_type; 

                            $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                            $new_closing_pay_balance=$current_pay_closing_balance;

                            if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                                $new_closing_pay_balance=$new_closing_pay_balance+aitsun_round($payment_value,get_setting(company($myid),'round_of_value'));
                            }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                                $new_closing_pay_balance=$new_closing_pay_balance-aitsun_round($payment_value,get_setting(company($myid),'round_of_value'));
                            }

                            $bal_payment_data=[ 
                                'closing_balance'=>$new_closing_pay_balance,
                            ];
                            $UserModel->update($bal_payment,$bal_payment_data); 
                        }
                            
                    // ??????????????????????????  customer and cash balance calculation end ??????????????
                    // ??????????????????????????  customer and cash balance calculation end ??????????????


                    foreach ($_POST["product_name"] as $i => $value ) {

                        $product_name=$_POST["product_name"][$i];
                        if (empty($_POST["quantity"][$i])) {
                                $quantity=1;
                        }else{
                            $quantity=$_POST["quantity"][$i];
                        } 
                         
                        $tax=$_POST["p_tax"][$i];
                        $p_purchase_tax=$_POST["p_purchase_tax"][$i];
                        $p_sale_tax=$_POST["p_sale_tax"][$i];
                        $mrp=$_POST["mrp"][$i];
                        $purchase_margin=$_POST["purchase_margin"][$i];
                        $sale_margin=$_POST["sale_margin"][$i];

                        $p_unit=$_POST["p_unit"][$i];
                        $p_sub_unit=$_POST["subunit"][$i];
                        $p_conversion_unit_rate=1;
                        $in_unit=$_POST["in_unit"][$i];
                        $batch_number=$_POST["batch_number"][$i];

                        if (is_numeric($_POST["p_tax_amount"][$i])) {
                            $p_tax_amount=$_POST["p_tax_amount"][$i];
                        }else{
                            $p_tax_amount=0;
                        }

                        
                        
                        if (is_numeric($_POST["price"][$i])) {
                            if (get_setting(company($myid),'split_tax')==1) {
                                $price=$_POST["price"][$i]-($p_tax_amount/$quantity);
                            }else{
                                $price=$_POST["price"][$i];
                            }
                        }else{
                            $price=0;
                        }

                        
                        if (is_numeric($_POST["amount"][$i])) {
                            if (get_setting(company($myid),'split_tax')==1) {
                                $amount=$_POST["amount"][$i];
                            }else{
                               $amount=$_POST["amount"][$i];
                            } 
                        }else{
                            $amount=0;
                        }

                       
                        if (is_numeric($_POST["p_discount"][$i])) {
                            $p_discount=$_POST["p_discount"][$i];
                        }else{
                            $p_discount=0;
                        }


                        if (is_numeric($_POST["discount_percent"][$i])) {
                             $discount_percent=$_POST["discount_percent"][$i];
                        }else{
                             $discount_percent=0;
                        }


                        
                        $bigdiscount+=$p_discount;
                        // $bigdiscount_percent+=$discount_percent;

                        $product_id=$_POST["product_id"][$i];
                        $product_desc=$_POST["product_desc"][$i];

                        
                        $old_quantity=0;

                        $is_sold_in_primary=true; 

                        if ($p_unit!=$in_unit) {

                            $is_sold_in_primary=false;
                            if ($_POST["conversion_unit"][$i]>0) {
                                $p_conversion_unit_rate=$_POST["conversion_unit"][$i];
                            }
                           
                        }


                        $qqq=$quantity;
                        $old_quantity=$quantity;

                        if (!$is_sold_in_primary) {
                            if ($p_conversion_unit_rate>0) {
                                $old_quantity=1*$quantity/$p_conversion_unit_rate;
                            }else{
                                $old_quantity=$quantity;
                            } 
                        } 



                        $in_item=[
                            'invoice_id'=>$ins_id,
                            'product'=>$product_name,
                            'product_id'=>$product_id,
                            'quantity'=> $quantity,
                            'price'=>aitsun_round($price,get_setting(company($myid),'round_of_value')),
                            'discount'=>aitsun_round($p_discount,get_setting(company($myid),'round_of_value')),
                            'discount_percent'=>aitsun_round($discount_percent,get_setting(company($myid),'round_of_value')),
                            'amount'=>aitsun_round($amount,get_setting(company($myid),'round_of_value')),
                            'desc'=>$product_desc,
                            'type'=>'single',
                            'tax'=>$tax,
                            'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                            'purchase_tax'=>$p_purchase_tax,
                            'sale_tax'=>$p_sale_tax, 
                            'mrp'=>aitsun_round($mrp,get_setting(company($myid),'round_of_value')), 
                            'purchase_margin'=>aitsun_round($purchase_margin,get_setting(company($myid),'round_of_value')), 
                            'sale_margin'=>aitsun_round($sale_margin,get_setting(company($myid),'round_of_value')), 
                            'product_method'=>get_products_data($product_id,'product_method'),
                            'unit'=>$p_unit,
                            'sub_unit'=>$p_sub_unit,
                            'conversion_unit_rate'=>aitsun_round($p_conversion_unit_rate,get_setting(company($myid),'round_of_value')),
                            'in_unit'=>$in_unit,
                            'split_tax'=>get_setting(company($myid),'split_tax'),
                            'old_quantity'=>$old_quantity, 
                            'batch_number'=>$batch_number, 
                            'invoice_type'=>$in_type, 
                            'purchased_price'=>aitsun_round(purchase_price($product_id),get_setting(company($myid),'round_of_value')),
                            'purchased_amount'=>aitsun_round(((purchase_price($product_id))*$quantity),get_setting(company($myid),'round_of_value')),
                        ];

                        $InvoiceitemsModel->save($in_item);






                        //////////////////////////////Stock calculation/////////////////////////
                        ////////////////////////////////////////////////////////////////////////

                         if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                              

                            $old_op_stock=get_products_data($product_id,'opening_balance');
                            $old_at_price=get_products_data($product_id,'at_price');  
                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                            $old_cl_value=get_products_data($product_id,'final_closing_value');  
                            $old_op_value=$old_op_stock*$old_at_price;
                            
                            $is_sold_in_primary=true;

                            if ($p_unit!=$in_unit) {
                                $is_sold_in_primary=false;
                            }


                            if (!$is_sold_in_primary) { 
                                $new_quantity=$quantity/$p_conversion_unit_rate;
                            }else{
                                $new_quantity=$quantity;
                            }

                            $final_cl_balance=$new_quantity;
                            $final_cl_value=$quantity*$price;

                            $stock_data=[
                                'closing_balance'=>$old_cl_stock-$final_cl_balance,
                                'final_closing_value'=>calculate_sale_value_average($product_id),
                                'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                            ];

                            $UserModel->update($product_id,$stock_data);


                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                            $old_op_stock=get_products_data($product_id,'opening_balance');
                            $old_at_price=get_products_data($product_id,'at_price');  
                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                            $old_cl_value=get_products_data($product_id,'final_closing_value');  
                            $old_op_value=$old_op_stock*$old_at_price;
                            
                            $is_sold_in_primary=true;

                            if ($p_unit!=$in_unit) {
                                $is_sold_in_primary=false;
                            }


                            if (!$is_sold_in_primary) { 
                                $new_quantity=$quantity/$p_conversion_unit_rate;
                            }else{
                                $new_quantity=$quantity;
                            }

                            $final_cl_balance=$new_quantity;
                            $final_cl_value=$quantity*$price;

                            $stock_data=[
                                'closing_balance'=>$old_cl_stock+$final_cl_balance,
                                'final_closing_value'=>calculate_sale_value_average($product_id),
                                'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                            ];

                            $UserModel->update($product_id,$stock_data);

                          
                        } 

                        //////////////////////////////Stock calculation/////////////////////////
                        ////////////////////////////////////////////////////////////////////////


                        if ($tax=='None') { 
                        }elseif ($tax=='Exempted') { 
                        }else{
                            insert_invoice_tax($ins_id,$tax,$p_tax_amount,(($price*$quantity)-$p_discount),strip_tags($this->request->getVar('invoice_date')),strip_tags($this->request->getVar('company_state')),strip_tags($this->request->getVar('state_of_supply')));
                        }



                    }

                    if (!empty($_POST["tax_id"])) {
                        foreach ($_POST["tax_id"] as $i => $value ) {
                            if ($_POST["tax_id"][$i]!=0) {
                                $tax=$_POST["tax_id"][$i];
                                $tax_percent=$_POST["tax_percent"][$i];
                                $tax_name=$_POST["tax_name"][$i];
                                $tax_amount=$_POST["taxamount"][$i];
                                $taxess=[
                                    'invoice_id'=>$ins_id,
                                    'tax_id'=>$tax,
                                    'tax_percent'=>$tax_percent,
                                    'tax_name'=>$tax_name,
                                    'tax_amount'=>$tax_amount
                                ];
                                $TaxModel->save($taxess);
                            }
                        }
                    }

                    $payment_id=receipt_no_generate(5);


                    if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='sales_return' || $in_type=='purchase' || $in_type=='purchase_return') {
                         

                            $dis_type='';

                            if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                                $dis_type='discount_allowed';
                            }elseif ($in_type=='sales_return' || $in_type=='purchase') {
                                $dis_type='discount_received';
                            }
                            

                            ///////////// payment_data 
                            $payment_types = $_POST['payment_type'];
                            $payment_values = $_POST['payment_type_value'];
             
                            $combined_array = array_combine($payment_types, $payment_values);

                            foreach ($combined_array as $payment_type => $payment_value) {
                                $ro_amt=$payment_value;

                                if ($ro_amt!=0) {


                                   add_payment($ins_id,$payment_type,$payment_value,'000',$customer,$_POST['alternate_name'],'',strip_tags($this->request->getVar('invoice_date')),$payment_id,company($myid),$in_type,$myid,0); 

                          

                                }

                            }
                            ///////////// payment_data 
                         
                    }


                    if ($in_ins) {
                        $company=company($myid);
                        $userid=$myid;
                        $check_date=$check_date;
                        $paid=aitsun_round($paid_amount,get_setting(company($myid),'round_of_value'));
                        echo $ins_id;


                        ////////////////////////CREATE ACTIVITY LOG//////////////
                        $log_data=[
                            'user_id'=>$myid,
                            'action'=>'New '.full_invoice_type($in_type).' inventory <b>#'.prefixof(company($myid),$ins_id).serial(company($myid),$ins_id).'</b> is added.',
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
            }
           
        }


        public function update_invoice($inid="")
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;
            $InvoiceitemsModel=new InvoiceitemsModel;
            $PaymentsModel=new PaymentsModel;
            $TaxModel=new TaxModel;
            $ProductsModel=new Main_item_party_table;
            $InvoiceTaxes=new InvoiceTaxes;
            $AccountingModel=new Main_item_party_table; 


            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 

                    if ($this->request->getMethod()=='post') {


                        $paid_amount=0;
                        // $payment_type=strip_tags($_POST['payment_type']);
                        $check_nomber='';
                        $check_date='';
                        $chk_amt=0;

                        $paid_amount=$_POST['cash_amount'];

                        $grandtotal=strip_tags($this->request->getVar('grand_total'));

                        $in_type=strip_tags($this->request->getVar('invoice_type'));

                      $customer=strip_tags($this->request->getVar('customer'));
                      $old_customer=invoice_data($inid,'customer');
                      $bigdiscount=strip_tags($this->request->getVar('discount'));
                      $intype=strip_tags($this->request->getVar('invoice_type'));

                        $duee_amt=strip_tags($this->request->getVar('grand_total'))-strip_tags($this->request->getVar('paaid'));
                        if ($duee_amt<=0) {
                            $paid_stat='paid';
                        }else{
                            $paid_stat='unpaid';
                        }

                        $old_customer=strip_tags($this->request->getVar('old_customer'));
                        $old_in_type=strip_tags($this->request->getVar('old_in_type'));
                        $old_due_amount=strip_tags($this->request->getVar('old_due_amount'));
                        $old_paid_amount=strip_tags($this->request->getVar('old_paid_amount'));

                        
                        $rent_from='';
                        $rent_to='';

                        $rent_from_date=strip_tags($this->request->getVar('rent_from_date'));
                        $rent_from_time=strip_tags($this->request->getVar('rent_from_time'));
                        $rent_to_date=strip_tags($this->request->getVar('rent_to_date'));
                        $rent_to_time=strip_tags($this->request->getVar('rent_to_time'));
                        $rent_from=$rent_from_date.' '.$rent_from_time;
                        $rent_to=$rent_to_date.' '.$rent_to_time;

                       
                       $in_data=[
                            'company_id'=>company($myid),
                            'customer'=>strip_tags($this->request->getVar('customer')),
                            'alternate_name'=>strip_tags($this->request->getVar('alternate_name')),
                            'notes'=>strip_tags($this->request->getVar('notes')),
                            'transport_charge'=>strip_tags($this->request->getVar('transport_charge')),
                            'private_notes'=>strip_tags($this->request->getVar('private_notes')),
                            'total'=>aitsun_round($grandtotal,get_setting(company($myid),'round_of_value')),
                            'sub_total'=>strip_tags(aitsun_round($this->request->getVar('sub_total'),get_setting(company($myid),'round_of_value'))),
                            'discount'=>aitsun_round($bigdiscount,get_setting(company($myid),'round_of_value')),
                            'tax'=>strip_tags(aitsun_round($this->request->getVar('tax_amount'),get_setting(company($myid),'round_of_value'))),
                            'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                            'status'=>'sent',
                            'paid_status'=>$paid_stat,
                            'due_amount'=>aitsun_round($duee_amt,get_setting(company($myid),'round_of_value')),
                            'paid_amount'=>strip_tags(aitsun_round($this->request->getVar('paaid'),get_setting(company($myid),'round_of_value'))),
                            'vehicle_number'=>strip_tags($this->request->getVar('vehicle_number')),
                            'round_type'=>strip_tags($this->request->getVar('round_type')),
                             'round_off'=>strip_tags(aitsun_round(str_replace('-','',$this->request->getVar('round_off')),get_setting(company($myid),'round_of_value'))),
                            'invoice_type'=>$in_type,
                            'company_state'=>strip_tags($this->request->getVar('company_state')),
                            'state_of_supply'=>strip_tags($this->request->getVar('state_of_supply')),
                            'edit_effected'=>0,
                            'old_total'=>strip_tags(aitsun_round($this->request->getVar('old_total'),get_setting(company($myid),'round_of_value'))),
                            'cash_discount_percent'=>strip_tags(aitsun_round($this->request->getVar('cash_discount_percent'),get_setting(company($myid),'round_of_value'))),
                            'additional_discount_percent'=>strip_tags(aitsun_round($this->request->getVar('additional_discount_percent'),get_setting(company($myid),'round_of_value'))),
                            'additional_discount'=>strip_tags(aitsun_round($this->request->getVar('additional_discount'),get_setting(company($myid),'round_of_value'))),
                            'inv_referal'=>strip_tags($this->request->getVar('inv_referal')),
                            'mrn_number'=>strip_tags($this->request->getVar('mrn_number')),
                            'doctor_name'=>strip_tags($this->request->getVar('doctor_name')),
                             'bill_number'=>strip_tags($this->request->getVar('bill_number')),
                            'validity'=>strip_tags($this->request->getVar('validity')),
                            'invoice_address'=>strip_tags($this->request->getVar('invoice_address')),
                            'delivery_address'=>strip_tags($this->request->getVar('delivery_address')),
                            'rent_from'=>$rent_from,
                            'rent_to'=>$rent_to,
                            'rental_duration'=>strip_tags($this->request->getVar('rental_duration'))

                        ];
                        

                        $in_ins=$InvoiceModel->update($inid,$in_data);
                        $ins_id=$inid;

                        foreach (get_payments_of_invoice($inid) as $in_pays) {
                            $inpaydata=[
                                'customer'=>strip_tags($this->request->getVar('customer'))
                            ];
                            $PaymentsModel->update($in_pays['id'],$inpaydata);
                        }

                        
            // ??????????????????????????  customer and cash balance calculation start ????????????
            // ??????????????????????????  customer and cash balance calculation start ????????????
                   

                    if ($customer!=$old_customer) {

                         //CUSTOMER
                        $bal_customer=strip_tags($this->request->getVar('customer'));

                        $current_closing_balance=user_data($bal_customer,'closing_balance');
                        $new_closing_balance=$current_closing_balance;

                        if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                            $new_closing_balance=($new_closing_balance)+aitsun_round($duee_amt,get_setting(company($myid),'round_of_value'));
                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                            $new_closing_balance=($new_closing_balance)-aitsun_round($duee_amt,get_setting(company($myid),'round_of_value'));
                        }


                        $bal_customer_data=[ 
                            'closing_balance'=>$new_closing_balance,
                        ];
                        $UserModel->update($bal_customer,$bal_customer_data);



                        //CUSTOMER
                        $old_bal_customer=$old_customer;

                        $old_cus_current_closing_balance=user_data($old_bal_customer,'closing_balance');
                        $old_cusnew_closing_balance=$old_cus_current_closing_balance;

                        if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                            $old_cusnew_closing_balance=($old_cusnew_closing_balance)-aitsun_round($duee_amt,get_setting(company($myid),'round_of_value'));
                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                            $old_cusnew_closing_balance=($old_cusnew_closing_balance)+aitsun_round($duee_amt,get_setting(company($myid),'round_of_value'));
                        }


                        $old_bal_customer_data=[ 
                            'closing_balance'=>$old_cusnew_closing_balance,
                        ];
                        $UserModel->update($old_bal_customer,$old_bal_customer_data);
                    }else{
                         //CUSTOMER
                        $bal_customer=strip_tags($this->request->getVar('customer'));

                        $current_closing_balance=user_data($bal_customer,'closing_balance');
                        $new_closing_balance=$current_closing_balance;

                        if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                            $new_closing_balance=($new_closing_balance-$old_due_amount)+aitsun_round($duee_amt,get_setting(company($myid),'round_of_value'));
                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                            $new_closing_balance=($new_closing_balance+$old_due_amount)-aitsun_round($duee_amt,get_setting(company($myid),'round_of_value'));
                        }


                        $bal_customer_data=[ 
                            'closing_balance'=>$new_closing_balance,
                        ];
                        $UserModel->update($bal_customer,$bal_customer_data);
                    }
                    

            // ??????????????????????????  customer and cash balance calculation end ??????????????
            // ??????????????????????????  customer and cash balance calculation end ??????????????


            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
            // ??????????????????????????  customer and cash balance calculation end ?????????????? 
                    //PAYMENT
                    // $bal_payment=strip_tags($this->request->getVar('payment_type')); 

                    // $current_pay_closing_balance=user_data($bal_payment,'closing_balance');
                    // $new_closing_pay_balance=$current_pay_closing_balance;

                    // if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                    //     $new_closing_pay_balance=($new_closing_pay_balance-$old_paid_amount)+aitsun_round($paid_amount,get_setting(company($myid),'round_of_value'));
                    // }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                    //     $new_closing_pay_balance=($new_closing_pay_balance+$old_paid_amount)-aitsun_round($paid_amount,get_setting(company($myid),'round_of_value'));
                    // }

                    // $bal_payment_data=[ 
                    //     'closing_balance'=>$new_closing_pay_balance,
                    // ];
                    // $UserModel->update($bal_payment,$bal_payment_data); 
            // ??????????????????????????  customer and cash balance calculation end ??????????????
            // ??????????????????????????  customer and cash balance calculation end ??????????????

 

                        ////////////////////////CREATE ACTIVITY LOG//////////////
                        $log_data=[
                            'user_id'=>$myid,
                            'action'=>full_invoice_type($in_type).' inventory <b>#'.prefixof(company($myid),$ins_id).serial(company($myid),$ins_id).'</b> is updated.',
                            'ip'=>get_client_ip(),
                            'mac'=>GetMAC(),
                            'created_at'=>now_time($myid),
                            'updated_at'=>now_time($myid),
                            'company_id'=>company($myid),
                        ];

                        add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////



                        if ($in_ins) {

                            // $deletepros=$InvoiceitemsModel->where('invoice_id',$inid)->delete();
                            $InvoiceTaxes->where('invoice_id',$inid)->delete();



                            $deledata=$InvoiceitemsModel->where('invoice_id',$ins_id)->where('entry_type!=','adjust'); 
                            foreach ($_POST["product_name"] as $ll => $value ) {
                                $i_idd=$_POST["i_id"][$ll];
                                $deledata->where('id!=',$i_idd); 
                            }

                            $deleting_prows=$deledata->where('deleted',0)->findAll();
                            foreach ($deleting_prows as $dp) {
                                $dd=[
                                    'deleted'=>3,
                                ];
                                
                                if ($InvoiceitemsModel->update($dp['id'],$dd)) {
                                    
                                    //////////////////////////////Stock calculation/////////////////////////
                                    ////////////////////////////////////////////////////////////////////////

                                     if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {

                                        $product_id=$dp['product_id'];
                                        $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                                        $current_closing_value=get_products_data($product_id,'final_closing_value');
                                        $final_quantity=$dp['quantity'];

                                        $is_sold_in_primary=true;

                                        if ($dp['unit']!=$dp['in_unit']) {
                                            $is_sold_in_primary=false;
                                        }


                                        if (!$is_sold_in_primary) { 
                                            $final_quantity=$dp['quantity']/$dp['conversion_unit_rate'];
                                        }

                                        $stock_data=[
                                            'closing_balance'=>$old_cl_stock+$final_quantity, 
                                            'final_closing_value'=>calculate_sale_value_average($product_id),
                                            'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                                        ];

                                        $UserModel->update($product_id,$stock_data);
                                          
                                    }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                                        $product_id=$dp['product_id'];
                                        $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                                        $current_closing_value=get_products_data($product_id,'final_closing_value');
                                        $final_quantity=$dp['quantity'];

                                        $is_sold_in_primary=true;

                                        if ($dp['unit']!=$dp['in_unit']) {
                                            $is_sold_in_primary=false;
                                        }


                                        if (!$is_sold_in_primary) { 
                                            $final_quantity=$dp['quantity']/$dp['conversion_unit_rate'];
                                        }

                                        $stock_data=[
                                            'closing_balance'=>$old_cl_stock-$final_quantity,
                                            'final_closing_value'=>calculate_sale_value_average($product_id),
                                            'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                                        ];

                                        $UserModel->update($product_id,$stock_data);

                                      
                                    } 

                                    //////////////////////////////Stock calculation/////////////////////////
                                    ////////////////////////////////////////////////////////////////////////
                                }

                                

                                 

                                 
                            }


                            
                            
                            
                        
                                foreach ($_POST["product_name"] as $i => $value ) {
                                

                                    $product_name=$_POST["product_name"][$i];
                                    $old_quantity=$_POST["old_quantity"][$i];
                                    $old_p_unit=$_POST["old_p_unit"][$i];
                                    $old_in_unit=$_POST["old_in_unit"][$i];
                                    $old_p_conversion_unit_rate=$_POST["old_p_conversion_unit_rate"][$i];

                                     
                                    $old_is_sold_in_primary=true; 

                                    if ($old_p_unit!=$old_in_unit) {
                                        $old_is_sold_in_primary=false;
                                    }
 

                                    if (!$old_is_sold_in_primary) {
                                        if ($old_p_conversion_unit_rate>0) {
                                            $old_quantity=1*$old_quantity/$old_p_conversion_unit_rate;
                                        }
                                    } 


                                    if (empty($_POST["quantity"][$i])) {
                                            $quantity=1;
                                    }else{
                                        $quantity=$_POST["quantity"][$i];
                                    }


                                    if (is_numeric($_POST["p_tax_amount"][$i])) {
                                        $p_tax_amount=$_POST["p_tax_amount"][$i];
                                    }else{
                                        $p_tax_amount=0;
                                    }

                                    
                                    
                                  
                                    if (is_numeric($_POST["price"][$i])) {
                                        if (get_setting(company($myid),'split_tax')==1) {
                                            $price=$_POST["price"][$i]-($p_tax_amount/$quantity);
                                        }else{
                                            $price=$_POST["price"][$i];
                                        }
                                    }else{
                                        $price=0;
                                    }


                                    
                                    $split_tax=get_setting(company($myid),'split_tax');

                                    if (is_numeric($_POST["amount"][$i])) {
                                        if (get_setting(company($myid),'split_tax')==1) {
                                            $amount=$_POST["amount"][$i];
                                        }else{
                                           $amount=$_POST["amount"][$i];
                                        }
                                        
                                    }else{
                                        $amount=0;
                                    }

                                   
                                    if (is_numeric($_POST["p_discount"][$i])) {
                                         $p_discount=$_POST["p_discount"][$i];
                                    }else{
                                         $p_discount=0;
                                    }

                                    if (is_numeric($_POST["discount_percent"][$i])) {
                                         $discount_percent=$_POST["discount_percent"][$i];
                                    }else{
                                         $discount_percent=0;
                                    }
                                     

                                    

                                   $p_unit=$_POST["p_unit"][$i];

                                    $p_sub_unit=$_POST["subunit"][$i];
                                    $p_conversion_rate=1;

                                    $product_id=$_POST["product_id"][$i];
                                    $product_desc=$_POST["product_desc"][$i];

                                     
                                        $tax=$_POST["p_tax"][$i];

                                        $p_purchase_tax=$_POST["p_purchase_tax"][$i];
                                $p_sale_tax=$_POST["p_sale_tax"][$i];

                                $mrp=$_POST["mrp"][$i];
                                $purchase_margin=$_POST["purchase_margin"][$i];
                                $sale_margin=$_POST["sale_margin"][$i];
                                $in_unit=$_POST["in_unit"][$i];
                                $batch_number=$_POST["batch_number"][$i];


                                   

 
                                     $qqq=$quantity;

                                      $is_sold_in_primary=true; 

                            if ($p_unit!=$in_unit) {

                                $is_sold_in_primary=false;
                                if ($_POST["conversion_unit"][$i]>0) {
                                    $p_conversion_rate=$_POST["conversion_unit"][$i];
                                }
                               
                            }



                                    
                                    $i_id=$_POST["i_id"][$i];

                                    $checkexist=$InvoiceitemsModel->where('id',$i_id)->where('deleted',0)->first();
                                    if ($checkexist) {
                                        $in_item=[   
                                            'quantity'=> $quantity,
                                            'price'=>aitsun_round($price,get_setting(company($myid),'round_of_value')),
                                            'discount'=>aitsun_round($p_discount,get_setting(company($myid),'round_of_value')),
                                            'discount_percent'=>aitsun_round($discount_percent,get_setting(company($myid),'round_of_value')),
                                            'amount'=>aitsun_round($amount,get_setting(company($myid),'round_of_value')),
                                            'desc'=>$product_desc, 
                                            'tax'=>$tax,
                                            'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                                            'purchase_tax'=>$p_purchase_tax,
                                            'sale_tax'=>$p_sale_tax, 
                                            'unit'=>$p_unit,
                                            'split_tax'=>$split_tax,
                                            'mrp'=>aitsun_round($mrp,get_setting(company($myid),'round_of_value')), 'product_method'=>get_products_data($product_id,'product_method'),
                                            'purchase_margin'=>aitsun_round($purchase_margin,get_setting(company($myid),'round_of_value')), 
                                            'sale_margin'=>aitsun_round($sale_margin,get_setting(company($myid),'round_of_value')),
                                            'old_quantity'=>$old_quantity,
                                            'sub_unit'=>$p_sub_unit,
                                            'in_unit'=>$in_unit,
                                            'conversion_unit_rate'=>aitsun_round($p_conversion_rate,get_setting(company($myid),'round_of_value')),
                                            'batch_number'=>$batch_number,
                                            'invoice_type'=>$in_type,  
                                            'purchased_price'=>aitsun_round(purchase_price($product_id),get_setting(company($myid),'round_of_value')),
                                            'purchased_amount'=>aitsun_round(((purchase_price($product_id))*$quantity),get_setting(company($myid),'round_of_value')),

                                        ];


                                         //////////////////////////////Stock calculation/////////////////////////
                                        ////////////////////////////////////////////////////////////////////////

                                         if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {

                                             $bef_closing_balance=0;
                                            $bef_final_closing_value=0;       
                                             $bef_p_unit=$checkexist['unit'];
                                            $bef_in_unit=$checkexist['in_unit'];
                                            $bef_quantity=$checkexist['quantity'];
                                            $bef_p_conversion_rate=$checkexist['conversion_unit_rate'];
                                            $bef_price=$checkexist['price'];

                                           

                                            $bef_is_sold_in_primary=true;

                                            if ($bef_p_unit!=$bef_in_unit) {
                                                $bef_is_sold_in_primary=false;
                                            }


                                            if (!$bef_is_sold_in_primary) { 
                                                $bef_new_quantity=$bef_quantity/$bef_p_conversion_rate;
                                            }else{
                                                $bef_new_quantity=$bef_quantity;
                                            }

                                            $bef_closing_balance=$bef_new_quantity;
                                            $bef_final_closing_value=$bef_quantity*$bef_price;





                                            $old_op_stock=get_products_data($product_id,'opening_balance');
                                            $old_at_price=get_products_data($product_id,'at_price');  
                                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                                            $old_cl_value=get_products_data($product_id,'final_closing_value');  
                                            $old_op_value=$old_op_stock*$old_at_price;
                                            
                                            $is_sold_in_primary=true;

                                            if ($p_unit!=$in_unit) {
                                                $is_sold_in_primary=false;
                                            }


                                            if (!$is_sold_in_primary) { 
                                                $new_quantity=$quantity/$p_conversion_rate;
                                            }else{
                                                $new_quantity=$quantity;
                                            }

                                            $final_cl_balance=$new_quantity;
                                            $final_cl_value=$quantity*$price;
             
                                        // $stock_data=[
                                        //     'closing_balance'=>(get_products_data($product_id,'closing_balance')-$bef_closing_balance)+($old_cl_stock+$final_cl_balance),
                                        //     'final_closing_value'=>(get_products_data($product_id,'final_closing_value')-$bef_final_closing_value)+($old_op_value+(($old_cl_value-$old_op_value)+$final_cl_value))
                                        // ];

                                        $stock_data=[
                                            'closing_balance'=>(get_products_data($product_id,'closing_balance')+$bef_closing_balance)-($final_cl_balance), 
                                            'final_closing_value'=>calculate_sale_value_average($product_id),
                                            'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                                        ];


                                            $UserModel->update($product_id,$stock_data);


                                              
                                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){


                                            $bef_closing_balance=0;
                                            $bef_final_closing_value=0;       
                                             $bef_p_unit=$checkexist['unit'];
                                            $bef_in_unit=$checkexist['in_unit'];
                                            $bef_quantity=$checkexist['quantity'];
                                            $bef_p_conversion_rate=$checkexist['conversion_unit_rate'];
                                            $bef_price=$checkexist['price'];

                                           

                                            $bef_is_sold_in_primary=true;

                                            if ($bef_p_unit!=$bef_in_unit) {
                                                $bef_is_sold_in_primary=false;
                                            }


                                            if (!$bef_is_sold_in_primary) { 
                                                $bef_new_quantity=$bef_quantity/$bef_p_conversion_rate;
                                            }else{
                                                $bef_new_quantity=$bef_quantity;
                                            }

                                            $bef_closing_balance=$bef_new_quantity;
                                            $bef_final_closing_value=$bef_quantity*$bef_price;





                                            $old_op_stock=get_products_data($product_id,'opening_balance');
                                            $old_at_price=get_products_data($product_id,'at_price');  
                                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                                            $old_cl_value=get_products_data($product_id,'final_closing_value');  
                                            $old_op_value=$old_op_stock*$old_at_price;
                                            
                                            $is_sold_in_primary=true;

                                            if ($p_unit!=$in_unit) {
                                                $is_sold_in_primary=false;
                                            }


                                            if (!$is_sold_in_primary) { 
                                                $new_quantity=$quantity/$p_conversion_rate;
                                            }else{
                                                $new_quantity=$quantity;
                                            }

                                            $final_cl_balance=$new_quantity;
                                            $final_cl_value=$quantity*$price;
             
                                        // $stock_data=[
                                        //     'closing_balance'=>(get_products_data($product_id,'closing_balance')-$bef_closing_balance)+($old_cl_stock+$final_cl_balance),
                                        //     'final_closing_value'=>(get_products_data($product_id,'final_closing_value')-$bef_final_closing_value)+($old_op_value+(($old_cl_value-$old_op_value)+$final_cl_value))
                                        // ];

                                        $stock_data=[
                                            'closing_balance'=>(get_products_data($product_id,'closing_balance')-$bef_closing_balance)+($final_cl_balance),
                                            'final_closing_value'=>(get_products_data($product_id,'final_closing_value')-$bef_final_closing_value)+(($final_cl_value))
                                        ];


                                            $UserModel->update($product_id,$stock_data);

                                          
                                        } 

                                        //////////////////////////////Stock calculation/////////////////////////
                                        ////////////////////////////////////////////////////////////////////////


                                       
                                        $InvoiceitemsModel->update($i_id,$in_item);


                                       
                                       

                                        if ($tax=='None') { 
                                        }elseif ($tax=='Exempted') { 
                                        }else{
                                            insert_invoice_tax($ins_id,$tax,$p_tax_amount,(($price*$quantity)-$p_discount),strip_tags($this->request->getVar('invoice_date')),strip_tags($this->request->getVar('company_state')),strip_tags($this->request->getVar('state_of_supply')));
                                        }
                                    }else{
                                        $in_item=[
                                            'invoice_id'=>$ins_id,
                                            'product'=>$product_name,
                                            'product_id'=>$product_id,
                                            'quantity'=> $quantity,
                                            'price'=>aitsun_round($price,get_setting(company($myid),'round_of_value')),
                                            'discount'=>aitsun_round($p_discount,get_setting(company($myid),'round_of_value')),
                                            'discount_percent'=>aitsun_round($discount_percent,get_setting(company($myid),'round_of_value')),
                                            'amount'=>aitsun_round($amount,get_setting(company($myid),'round_of_value')),
                                            'desc'=>$product_desc,
                                            'type'=>'single',
                                            'tax'=>$tax,
                                            'invoice_date'=>strip_tags($this->request->getVar('invoice_date')),
                                            'purchase_tax'=>$p_purchase_tax,
                                            'sale_tax'=>$p_sale_tax, 
                                            'unit'=>$p_unit,
                                            'split_tax'=>$split_tax,
                                            'mrp'=>aitsun_round($mrp,get_setting(company($myid),'round_of_value')), 'product_method'=>get_products_data($product_id,'product_method'),
                                            'purchase_margin'=>aitsun_round($purchase_margin,get_setting(company($myid),'round_of_value')), 
                                            'sale_margin'=>aitsun_round($sale_margin,get_setting(company($myid),'round_of_value')),
                                            'old_quantity'=>$old_quantity,
                                            'sub_unit'=>$p_sub_unit,
                                            'in_unit'=>$in_unit,
                                            'conversion_unit_rate'=>aitsun_round($p_conversion_rate,get_setting(company($myid),'round_of_value')), 
                                            'batch_number'=>$batch_number,
                                            'invoice_type'=>$in_type,  
                                            'purchased_price'=>aitsun_round(purchase_price($product_id),get_setting(company($myid),'round_of_value')),
                                            'purchased_amount'=>aitsun_round(((purchase_price($product_id))*$quantity),get_setting(company($myid),'round_of_value')),
                                            
                                        ];

                                        $InvoiceitemsModel->save($in_item);




                                        //////////////////////////////Stock calculation/////////////////////////
                                        ////////////////////////////////////////////////////////////////////////

                                         if ($in_type=='sales' || $in_type=='proforma_invoice' || $in_type=='purchase_return') {
                                            
                                            $old_op_stock=get_products_data($product_id,'opening_balance');
                                            $old_at_price=get_products_data($product_id,'at_price');  
                                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                                            $old_cl_value=get_products_data($product_id,'final_closing_value');  
                                            $old_op_value=$old_op_stock*$old_at_price;
                                            
                                            $is_sold_in_primary=true;

                                            if ($p_unit!=$in_unit) {
                                                $is_sold_in_primary=false;
                                            }


                                            if (!$is_sold_in_primary) { 
                                                $new_quantity=$quantity/$p_conversion_rate;
                                            }else{
                                                $new_quantity=$quantity;
                                            }

                                            $final_cl_balance=$new_quantity;
                                            $final_cl_value=$quantity*$price;
             
                                            $stock_data=[
                                                'closing_balance'=>$old_cl_stock-$final_cl_balance, 
                                                'final_closing_value'=>calculate_sale_value_average($product_id),
                                                'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                                            ];

                                            $UserModel->update($product_id,$stock_data);

                                        }elseif ($in_type=='purchase' || $in_type=='sales_return'){
                                            $old_op_stock=get_products_data($product_id,'opening_balance');
                                            $old_at_price=get_products_data($product_id,'at_price');  
                                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                                            $old_cl_value=get_products_data($product_id,'final_closing_value');  
                                            $old_op_value=$old_op_stock*$old_at_price;
                                            
                                            $is_sold_in_primary=true;

                                            if ($p_unit!=$in_unit) {
                                                $is_sold_in_primary=false;
                                            }


                                            if (!$is_sold_in_primary) { 
                                                $new_quantity=$quantity/$p_conversion_rate;
                                            }else{
                                                $new_quantity=$quantity;
                                            }

                                            $final_cl_balance=$new_quantity;
                                            $final_cl_value=$quantity*$price;
             
                                            $stock_data=[
                                                'closing_balance'=>$old_cl_stock+$final_cl_balance,
                                                'final_closing_value'=>$old_op_value+(($old_cl_value-$old_op_value)+$final_cl_value)
                                            ];

                                            $UserModel->update($product_id,$stock_data);

                                          
                                        } 

                                        //////////////////////////////Stock calculation/////////////////////////
                                        ////////////////////////////////////////////////////////////////////////

                                         


                                        if ($tax=='None') { 
                                        }elseif ($tax=='Exempted') { 
                                        }else{
                                            insert_invoice_tax($ins_id,$tax,$p_tax_amount,(($price*$quantity)-$p_discount),strip_tags($this->request->getVar('invoice_date')),strip_tags($this->request->getVar('company_state')),strip_tags($this->request->getVar('state_of_supply')));
                                        }
                                    }
                                     


           


                                }
                            

                         

                        if (!empty($_POST["tax_id"])) {
                            foreach ($_POST["tax_id"] as $i => $value ) {
                                if ($_POST["tax_id"][$i]!=0) {
                                    $maintax=$_POST["tax_id"][$i];
                                    $tax_percent=$_POST["tax_percent"][$i];
                                    $tax_name=$_POST["tax_name"][$i];
                                    $tax_amount=$_POST["taxamount"][$i];
                                    $taxess=[
                                        'invoice_id'=>$ins_id,
                                        'tax_id'=>$maintax,
                                        'tax_percent'=>$tax_percent,
                                        'tax_name'=>$tax_name,
                                        'tax_amount'=>$tax_amount
                                    ];
                                    $TaxModel->save($taxess);
                                }
                            }
                        }

                        $payment_id=receipt_no_generate(5);

                       

                    

                   
                                $company=company($myid);
                                $userid=$myid;
                                $check_date=$check_date;
                                $paid=aitsun_round($paid_amount,get_setting(company($myid),'round_of_value'));
                                echo $ins_id;
                        }


                    }

                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }
        }

        public function change_rental_status($rental_status='',$inid=0){
            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;
         
            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 

                    
            if ($this->request->getMethod()=='post') {  
                
                $final_rental_status=$rental_status;

                // if ($rental_status==0) {
                //     $final_rental_status=1;
                // }elseif ($rental_status==1) {
                //    $final_rental_status=2;
                // }elseif ($rental_status==2) {
                //    $final_rental_status=3;
                // }

                $in_data=[ 
                    'rental_status'=>$final_rental_status,  
                ]; 

                $in_ins=$InvoiceModel->update($inid,$in_data);
                 

                if ($in_ins) {
                    echo 1;
                } 

            }

                            
            }else{
                echo 0;
            }

        }


        public function display_products(){
            $session=session();
            $UserModel=new Main_item_party_table;
            $ProductsModel=new Main_item_party_table;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();
                $query = $UserModel->where('id',$myid);
 

                    $ProductsModel->orderBy("id", "desc");
                    

                    if (isset($_GET['product_name'])) {

                        if ($_GET['product_type']=='code') {  
                        $_GET['category']='';     
                        } 

                        if ($_GET['product_name'] == '' && $_GET['category']=='' && $_GET['subcategory']=='') {

                            $ProductsModel->where('deleted', 0);
                            $ProductsModel->where('main_type', 'product');
                            $ProductsModel->where('company_id',company($myid));
                            $get_pro = $ProductsModel->where('fav',1);


                            if ($_GET['view_type']=='sales') {
                               $get_pro_data=$get_pro->findAll();
                            }else{
                                $get_pro_data=$get_pro->where('product_method','product')->findAll();
                            }


                            foreach ($get_pro_data as $pro) {
                                ?>
                                    <a class="item_box col-md-3 my-2" href="javascript:void(0);" 
                                    data-productid="<?= $pro['id']; ?>" 
                                    data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>" 
                                    data-batch_number="<?= $pro['batch_no']; ?>" 
                                    data-unit="<?= $pro['unit']; ?>"
                                    <?php if ($_GET['view_type']=='sales'): ?>
                                        data-price="<?= $pro['price']; ?>"
                                    <?php else: ?>
                                        data-price="<?= $pro['purchased_price']; ?>"
                                    <?php endif ?>
                                    
                                    data-tax="<?= $pro['tax']; ?>"
                                    data-tax_name="<?= tax_name($pro['tax']); ?>"
                                    data-barcode="<?= $pro['barcode']; ?>"

                                    data-prounit='<?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

                                    data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

                                    data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

                                    data-protax='<?php foreach (tax_array(company($myid)) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

                                    data-tax_percent="<?= percent_of_tax($pro['tax']); ?>"

                                    data-stock="<?= $pro['closing_balance'] ?>"

                                    data-description="<?= str_replace('"','%22',$pro['description']); ?>"
                                    data-product_type="<?= $pro['product_type']; ?>"
                                     data-purchased_price="<?= $pro['purchased_price']; ?>"
                                     data-selling_price="<?= $pro['price']; ?>"
                                     data-purchase_tax="<?= $pro['purchase_tax']; ?>"
                                     data-sale_tax="<?= $pro['sale_tax']; ?>"
                                     data-mrp="<?= $pro['mrp']; ?>"
                                     data-purchase_margin="<?= $pro['purchase_margin']; ?>"
                                     data-sale_margin="<?= $pro['sale_margin']; ?>"

                                     data-unit_disabled="<?php if (item_has_transaction($pro['id'])): ?>readonly<?php endif ?>"
                                     data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"
                                     

                                     





                                    >

                                    

                                        <div class="product_box <?php if ($pro['product_type']=='item_kit'){ $cst=item_kit_stock($pro['id']);}else{$cst=$pro['closing_balance'];}if ($cst<=0){ echo 'out_of_stock'; } ?>">
                                            <i class="mdi mdi-heart pro_hrt"></i>
                                            <h6 class="text-white textoverflow_x-none"><?= $pro['product_name']; ?></h6>
                                            <span>
                                                <em><?= name_of_brand($pro['brand']); ?></em>

                                                <?php if ($pro['product_method']=='product'): ?>
                                                <small>
                                                <?php if ($pro['product_type']=='item_kit'){ echo item_kit_stock($pro['id']).' item in stock';}else{ if ($pro['closing_balance']<=0 ){  echo '<small class="bg-body p-1 text-danger">Stock ('.$pro['closing_balance'].')</small>';}else{ echo $pro['closing_balance'].' '.name_of_unit(unit_of_product($pro['id'])).' in stock';  }} ?>
                                                </small>
                                                <?php endif ?>

                                            </span >
                                        </div>
                                        
                                    </a>
                                <?php
                            }

                            foreach (product_categories_array(company($myid)) as $pc) {
                                 ?>
                                 <div class="col-md-3 my-2">
                                    <a class="category_box" data-catid="<?= $pc['id']; ?>">
                                        <div class="folder_box d-flex product_box justify-content-between">
                                            <h6 class="text-white textoverflow_x-none my-auto"><?= $pc['cat_name']; ?></h6>
                                            <i class="mdi mdi-folder-outline my-auto"></i>
                                        </div>
                                        
                                    </a>
                                </div>

                                 <?php
                             }


                        }elseif($_GET['product_name']!='' && $_GET['category']=='' && $_GET['subcategory']==''){
                            

                            // if ($_GET['product_type']=='code') {
                            //     $where = '(product_code="'.$_GET['product_name'].'" and company_id = "'.company($myid).'")';
                            // }else{
                            //     $where = '(product_name LIKE "%'.$_GET['product_name'].'%" and company_id = "'.company($myid).'")';
                            // }

                             if ($_GET['product_type']=='code') {
                                $ProductsModel->like('product_code',$_GET['product_name'],'both');
                            }else{ 
                                    $keywords = explode(' ', $_GET['product_name']);
                                     

                                    // Start building the WHERE clause
                                    $whereClause = '';

                                    foreach ($keywords as $keyword) { 
                                        $whereClause .= "(product_name_with_category LIKE '%$keyword%' OR brand_name LIKE '%$keyword%') AND ";
                                    }

                                    // Remove the trailing 'AND'
                                    $whereClause = rtrim($whereClause, ' AND ');

                                    // Perform the search
                                    $ProductsModel->where($whereClause);

                                   
                                

                            }

                            // $ProductsModel->like('product_name',$_GET['product_name']);
                             $get_pro=$ProductsModel->where('company_id', company($myid))->where('deleted', 0);

                            

                            echo '<div class="col-md-3 my-2"><a id="cat_back"><div class="folder_box d-flex product_box justify-content-between"><h6 class="text-white m-auto"><i class="bx-arrow-back bx"></i></h6></div></a></div>';

                            if ($_GET['view_type']=='sales') {
                               $get_pro_data=$get_pro->findAll(8,$_GET['start']);
                            }else{
                                $get_pro_data=$get_pro->where('product_method','product')->findAll(8,$_GET['start']);
                            }

                            $counttt=0;
                            
                            foreach ($get_pro_data as $pro) { 
                              $counttt++;
                                ?>
                                
                                    <a class="item_box col-md-3 my-2" href="javascript:void(0);"
                                    data-productid="<?= $pro['id']; ?>" 
                                    data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>" 
                                    data-batch_number="<?= $pro['batch_no']; ?>" 
                                    data-unit="<?= $pro['unit']; ?>"
                                    <?php if ($_GET['view_type']=='sales'): ?>
                                        data-price="<?= $pro['price']; ?>"
                                    <?php else: ?>
                                        data-price="<?= $pro['purchased_price']; ?>"
                                    <?php endif ?>
                                    data-tax="<?= $pro['tax']; ?>"

                                    data-prounit='<?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'
                                    data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

                                    data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

                                     data-protax='<?php foreach (tax_array(company($myid)) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

                                    data-tax_name="<?= tax_name($pro['tax']); ?>"
                                    data-barcode="<?= $pro['barcode']; ?>"
                                    data-tax_percent="<?= percent_of_tax($pro['tax']); ?>"
                                    data-stock="<?= $pro['closing_balance'] ?>"
                                    data-description="<?= str_replace('"','%22',$pro['description']); ?>"
                                    data-product_type="<?= $pro['product_type']; ?>"
                                    data-purchased_price="<?= $pro['purchased_price']; ?>"
                                     data-selling_price="<?= $pro['price']; ?>"
                                     data-purchase_tax="<?= $pro['purchase_tax']; ?>"
                                     data-sale_tax="<?= $pro['sale_tax']; ?>"
                                     data-mrp="<?= $pro['mrp']; ?>"
                                     data-purchase_margin="<?= $pro['purchase_margin']; ?>"
                                     data-sale_margin="<?= $pro['sale_margin']; ?>"

                                     data-unit_disabled="<?php if (item_has_transaction($pro['id'])): ?>readonly<?php endif ?>"
                                     data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"
                                     
                                    >
                                        <div class="product_box <?php if ($pro['product_type']=='item_kit'){ $cst=item_kit_stock($pro['id']);}else{$cst=$pro['closing_balance'];}if ($cst<=0){ echo 'out_of_stock'; } ?>">
                                            <h6 class="text-white textoverflow_x-none"><?= $pro['product_name']; ?> - <em><?= name_of_category($pro['category']) ?></em></h6>
                                            <span>
                                                <em><?= name_of_brand($pro['brand']); ?></em>

                                                    <?php if ($pro['product_method']=='product'): ?>
                                                
                                                <small>
                                                    <?php if ($pro['product_type']=='item_kit'){ echo item_kit_stock($pro['id']).' item in stock';}else{ if ($pro['closing_balance']<=0 ){  echo '<small class="bg-body p-1 text-danger">Stock ('.$pro['closing_balance'].')</small>';}else{ echo $pro['closing_balance'].' '.name_of_unit(unit_of_product($pro['id'])).' in stock';  }} ?>
                                                </small>
                                                <?php endif ?>
                                            </span >
                                        </div>
                                        
                                    </a>
                                
                                <?php
                            }


                            if ($counttt>0) {
                                ?> 
                                <a class="load_more_box cursor-pointer bg-dark  my-2" data-start="<?= $_GET['start'] ?>" data-search="<?= $_GET['product_name'] ?>" data-view_type="<?= $_GET['view_type'] ?>" data-input="<?= $_GET['product_type'] ?>">
                                    Load more
                                </a> 
                                <?php
                            }else{
                             ?> 
                                <a class="cursor-pointer d-block my-2 text-center text-danger w-100">
                                    No items
                                </a> 
                            <?php
                            }


                        }elseif($_GET['product_name']=='' && $_GET['category']!='' && $_GET['subcategory']==''){
                             

                            
                            // if ($_GET['product_type']=='code') {
                            //     $where = '(product_code="'.$_GET['product_name'].'" and company_id = "'.company($myid).'")';
                            // }else{
                            //     $where = '(product_name LIKE "%'.$_GET['product_name'].'%" and company_id = "'.company($myid).'")';
                            // }

                            if ($_GET['product_type']=='code') {
                                $ProductsModel->like('product_code',$_GET['product_name'],'both');

                            }else{
                                 
                                $ProductsModel->like('category_name',$_GET['category'],'both');  
                                 
                            }

                            // $ProductsModel->like('product_name',$_GET['product_name']);
                             $get_pro=$ProductsModel->where('company_id', company($myid))->where('deleted', 0);

                            

                            echo '<div class="col-md-3 my-2"><a id="cat_back"><div class="folder_box d-flex product_box justify-content-between"><h6 class="text-white m-auto"><i class="bx-arrow-back bx"></i></h6></div></a></div>';

                            if ($_GET['view_type']=='sales') {
                               $get_pro_data=$get_pro->findAll();
                            }else{
                                $get_pro_data=$get_pro->where('product_method','product')->findAll();
                            }

                            
                            foreach ($get_pro_data as $pro) { 
                              
                                ?>
                                
                                    <a class="item_box col-md-3 my-2" href="javascript:void(0);"
                                    data-productid="<?= $pro['id']; ?>" 
                                    data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>" 
                                    data-batch_number="<?= $pro['batch_no']; ?>" 
                                    data-unit="<?= $pro['unit']; ?>"
                                    <?php if ($_GET['view_type']=='sales'): ?>
                                        data-price="<?= $pro['price']; ?>"
                                    <?php else: ?>
                                        data-price="<?= $pro['purchased_price']; ?>"
                                    <?php endif ?>
                                    data-tax="<?= $pro['tax']; ?>"

                                    data-prounit='<?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'
                                    data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

                                    data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

                                     data-protax='<?php foreach (tax_array(company($myid)) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

                                    data-tax_name="<?= tax_name($pro['tax']); ?>"
                                    data-barcode="<?= $pro['barcode']; ?>"
                                    data-tax_percent="<?= percent_of_tax($pro['tax']); ?>"
                                    data-stock="<?= $pro['closing_balance'] ?>"
                                    data-description="<?= str_replace('"','%22',$pro['description']); ?>"
                                    data-product_type="<?= $pro['product_type']; ?>"
                                    data-purchased_price="<?= $pro['purchased_price']; ?>"
                                     data-selling_price="<?= $pro['price']; ?>"
                                     data-purchase_tax="<?= $pro['purchase_tax']; ?>"
                                     data-sale_tax="<?= $pro['sale_tax']; ?>"
                                     data-mrp="<?= $pro['mrp']; ?>"
                                     data-purchase_margin="<?= $pro['purchase_margin']; ?>"
                                     data-sale_margin="<?= $pro['sale_margin']; ?>"

                                     data-unit_disabled="<?php if (item_has_transaction($pro['id'])): ?>readonly<?php endif ?>"
                                     data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"
                                     
                                    >
                                        <div class="product_box <?php if ($pro['product_type']=='item_kit'){ $cst=item_kit_stock($pro['id']);}else{$cst=$pro['closing_balance'];}if ($cst<=0){ echo 'out_of_stock'; } ?>">
                                            <h6 class="text-white textoverflow_x-none"><?= $pro['product_name']; ?> - <em><?= name_of_category($pro['category']) ?></em></h6>
                                            <span>
                                                <em><?= name_of_brand($pro['brand']); ?></em>

                                                    <?php if ($pro['product_method']=='product'): ?>
                                                
                                                <small>
                                                    <?php if ($pro['product_type']=='item_kit'){ echo item_kit_stock($pro['id']).' item in stock';}else{ if ($pro['closing_balance']<=0 ){  echo '<small class="bg-body p-1 text-danger">Stock ('.$pro['closing_balance'].')</small>';}else{ echo $pro['closing_balance'].' '.name_of_unit(unit_of_product($pro['id'])).' in stock';  }} ?>
                                                </small>
                                                <?php endif ?>
                                            </span >
                                        </div>
                                        
                                    </a>
                                
                                <?php
                            }



                        }elseif($_GET['product_name']=='' && $_GET['category']=='' && $_GET['subcategory']!=''){
                            

                           

                            $ProductsModel->where('deleted', 0);
                            $where = '(sub_category = "'.$_GET['subcategory'].'" and company_id = "'.company($myid).'")';

                            $get_pro = $ProductsModel->where('sub_category',$_GET['subcategory'])->where('company_id',company($myid));


                             echo '<div class="col-md-3 my-2"><a id="cat_back"><div class="folder_box d-flex product_box justify-content-between"><h6 class="text-white m-auto"><i class="bx-arrow-back bx"></i></h6></div></a></div>';
                             

                            if ($_GET['view_type']=='sales') {
                               $get_pro_data=$get_pro->findAll();
                            }else{
                                $get_pro_data=$get_pro->where('product_method','product')->findAll();
                            }
                            
                            foreach ($get_pro_data as $pro) {
                                ?>
                                    <a class="item_box col-md-3 my-2 "  href="javascript:void(0);"
                                    data-productid="<?= $pro['id']; ?>" 
                                    data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>"
                                    data-batch_number="<?= $pro['batch_no']; ?>" 
                                    data-unit="<?= $pro['unit']; ?>"
                                    <?php if ($_GET['view_type']=='sales'): ?>
                                        data-price="<?= $pro['price']; ?>"
                                    <?php else: ?>
                                        data-price="<?= $pro['purchased_price']; ?>"
                                    <?php endif ?>
                                    data-tax="<?= $pro['tax']; ?>"
                                    data-tax_name="<?= tax_name($pro['tax']); ?>"
                                    data-barcode="<?= $pro['barcode']; ?>"
                                    data-tax_percent="<?= percent_of_tax($pro['tax']); ?>"
                                    data-stock="<?= $pro['closing_balance'] ?>"

                                    data-prounit='<?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'
                                    data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($myid)) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

                                    data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

                                     data-protax='<?php foreach (tax_array(company($myid)) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

                                    data-description="<?= str_replace('"','%22',$pro['description']); ?>"
                                    data-product_type="<?= $pro['product_type']; ?>"
                                    data-purchased_price="<?= $pro['purchased_price']; ?>"
                                     data-selling_price="<?= $pro['price']; ?>"
                                     data-purchase_tax="<?= $pro['purchase_tax']; ?>"
                                     data-sale_tax="<?= $pro['sale_tax']; ?>"
                                     data-mrp="<?= $pro['mrp']; ?>"
                                     data-purchase_margin="<?= $pro['purchase_margin']; ?>"
                                     data-sale_margin="<?= $pro['sale_margin']; ?>"

                                     data-unit_disabled="<?php if (item_has_transaction($pro['id'])): ?>readonly<?php endif ?>"
                                     data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"

                                    >
                                        <div class="product_box <?php if ($pro['product_type']=='item_kit'){ $cst=item_kit_stock($pro['id']);}else{$cst=$pro['closing_balance'];}if ($cst<=0){ echo 'out_of_stock'; } ?>">
                                            <h6 class="<?php if ($cst<=0){ echo 'text-dark'; }else{ echo 'text-white'; } ?>  textoverflow_x-none"><?= $pro['product_name']; ?></h6>
                                           <span>
                                            <em class="<?php if ($cst<=0){ echo 'text-dark'; }else{ echo 'text-white'; } ?> "><?= name_of_brand($pro['brand']); ?></em>

                                                <?php if ($pro['product_method']=='product'): ?>
                                                <small>
                                                    <?php if ($pro['product_type']=='item_kit'){ echo item_kit_stock($pro['id']).' item in stock';}else{ if ($pro['closing_balance']<=0 ){  echo '<small class="bg-body p-1 text-danger">Stock ('.$pro['closing_balance'].')</small>';}else{ echo $pro['closing_balance'].' '.name_of_unit(unit_of_product($pro['id'])).' in stock';  }} ?>
                                                </small>
                                                <?php endif ?>
                                            </span >
                                        </div>
                                        
                                    </a>
                                <?php
                            }

                            


                        }else{
                            $where = '(product_name LIKE "%'.$_GET['product_name'].'%" and unit LIKE "%'.$_GET['unit'].'%" and company_id = "'.company($myid).'")';

                           $get_pro = $this->db->get_where('main_item_party_table', $where);
                        }
                        
                    }

                }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


        function get_price(){
            $ProductsModel=new Main_item_party_table;
            if ($_GET['prod']=="") {
                echo 0;
            }else{
                
                $price=$ProductsModel->where('id',$_GET['prod']);;
                foreach ($price->findAll() as $ip) {
                    echo $ip['price'];
                }
            }
            
        }


 
        public function get_barcode_product($view_type=""){
            $session=session();
            $UserModel=new Main_item_party_table;
            $ProductsModel=new Main_item_party_table;
            $productbc=null;
            $newarray=array();
            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 
                    if (isset($_GET['barcode'])) {

                        


                        $ProductsModel->orderBy("id", "desc");
                        $row=$_GET['row'];
                        $i_unit=$_GET['i_unit'];
                        $i_subunit=$_GET['i_subunit'];
                        $full_barcode=$_GET['full_barcode'];


                        $taxcount=0; 

                        $cus_pro=$ProductsModel->where('company_id',company($myid))->where('main_type','product')->where('deleted',0)->where('custom_barcode',1)->where('barcode',$full_barcode)->first();

                        if ($cus_pro) {
                            $profetch=$cus_pro;
                        }else{
                            $profetch = $ProductsModel->where('company_id',company($myid))->where('main_type','product')->where('deleted',0)->like('barcode',$_GET['barcode'],'after')->first();
                        }
                        
                        

                        if ($profetch) {
                            $productid=$profetch['id'];
                            $product_name=$profetch['product_name'];
                            $unit=$profetch['unit'];
                            $description=str_replace('"','%22',$profetch['description']);
                            $stock=$profetch['closing_balance'];
                            $product_type=$profetch['product_type'];
                            $selling_price=$profetch['price'];
                            $purchased_price=$profetch['purchased_price'];
                            $tax=$profetch['tax'];
                            $tax_percent=percent_of_tax($profetch['tax']);
                            $tax_name=tax_name($profetch['tax']);
                            $barcode=$profetch['barcode'];

                            //pend
                            $prounit='';
                            foreach (products_units_array(company($myid)) as $pu){
                                $usele='';
                                if ($profetch['unit']==$pu['value']){
                                    $usele='selected';
                                }
                                $prounit.='<option value='.$pu["value"].' '.$usele.'>'.$pu["name"].'</option>';
                            }

                            $prosubunit='';
                            foreach (products_units_array(company($myid)) as $pu){
                                $usubsele='';
                                if ($profetch['sub_unit']==$pu['value']){
                                    $usubsele='selected';
                                }
                                $prosubunit.='<option value="">None</option><option value='.$pu["value"].' '.$usubsele.'>'.$pu["name"].'</option>';
                            }

                            $protax=''; 
                            foreach (tax_array(company($myid)) as $tx){
                                $tax_sele='';
                                if ($profetch['tax']==$tx['name']){
                                    $tax_sele='selected';
                                }
                                $protax.='<option data-perc="'.$tx["percent"].'" data-tname="'.$tx["name"].'" value="'.$tx["name"].'" '.$tax_sele.'>'.$tx["name"].'</option>';
                            }

                            //pend

                            $proconversion_unit_rate=$profetch['conversion_unit_rate'];
                            
                            $purchase_tax=$profetch['purchase_tax'];
                            $mrp=$profetch['mrp']; 
                            $sale_tax=$profetch['sale_tax'];
                            $purchase_margin=$profetch['purchase_margin'];
                            $sale_margin=$profetch['sale_margin'];
                            $custom_barcode=$profetch['custom_barcode'];
                            $unit_disabled='';
                            if (item_has_transaction($profetch['id'])){
                                $unit_disabled='readonly';
                            }
                            $in_unit_options='<option value='.$profetch["unit"].'>'.$profetch["unit"].'</option>';
                            if (!empty($profetch['sub_unit'])){
                                $in_unit_options.='<option value="">None</option><option value='.$profetch["sub_unit"].'>'.$profetch["sub_unit"].'</option>';
                            } 




                            $newarray=[
                                'productid'=>$productid,
                                'product_name'=>$product_name,
                                'unit'=>$unit,
                                'description'=>$description,
                                'mrp'=>$mrp, 
                                'stock'=>$stock,
                                'product_type'=>$product_type,
                                'selling_price'=>$selling_price,
                                'purchased_price'=>$purchased_price,
                                'tax'=>$tax,
                                'tax_percent'=>$tax_percent,
                                'tax_name'=>$tax_name,
                                'barcode'=>$barcode,
                                'prounit'=>$prounit,
                                'prosubunit'=>$prosubunit,
                                'proconversion_unit_rate'=>$proconversion_unit_rate,
                                'protax'=>$protax,
                                'purchase_tax'=>$purchase_tax,
                                'sale_tax'=>$sale_tax,
                                'purchase_margin'=>$purchase_margin,
                                'sale_margin'=>$sale_margin,
                                'unit_disabled'=>$unit_disabled,
                                'in_unit_options'=>$in_unit_options,
                                'i_unit'=>$i_unit,
                                'i_subunit'=>$i_subunit,
                                'custom_barcode'=>$custom_barcode
                            ];
                        }
                        $productbc=$newarray;
                    }

            } 

            echo json_encode($productbc);
        }

        public function get_date_format(){
            $myid=session()->get('id');
            if ($_GET) {
                if (isset($_GET['date'])) {
                    if (!empty($_GET['date'])) {
                        echo get_date_format($_GET['date'],'d M y');
                    }else{
                        echo 0;
                    }
                }else{
                    echo 0;
                }
            }else{
                echo 0;
            }
        }


        
    }
