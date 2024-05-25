<div class="card bg-none border-0 first_card" >
            <div class="card-body p-0" >
               <div class="row">
                                     

                <div class="col-md-4">
                    <div class="card border-radius-10 bg-primary">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-0 text-white"><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></p>
                                    <h3 class="my-1 text-white"><?= currency_symbol(company($user['id'])) ?><?= aitsun_round($invoice_id['total'],get_setting(company($user['id']),'round_of_value')); ?></h3>
                                </div>
                                <div class="text-white my-auto font-size-35"><i class="fa fa-money-bill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-radius-10 bg-success">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-0 text-white"><?= langg(get_setting(company($user['id']),'language'),'Paid'); ?></p>
                                    <h3 class="my-1 text-white"><?= currency_symbol(company($user['id'])) ?><span id="paidcalc"><?= aitsun_round($invoice_id['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?></span></h3>
                                </div>
                                <div class="text-white my-auto font-size-35"><i class="fa fa-money-bill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-radius-10 bg-danger">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-0 text-white"><?= langg(get_setting(company($user['id']),'language'),'Due'); ?></p>
                                    <h3 class="my-1 text-white"><?= currency_symbol(company($user['id'])) ?><span id="duecalc"><?= aitsun_round($invoice_id['total']-$invoice_id['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?></span></h3>
                                </div>
                                <div class="text-white my-auto font-size-35"><i class="fa fa-money-bill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="d-flex justify-content-end mb-2 mt-3">
                        <?php if ($invoice_id['paid_status']!='paid' && $invoice_id['total']>0): ?>
                            <?php if ($invoice_id['is_installment']!=1): ?>
                                <a class="btn btn-dark btn-sm text-white" data-bs-toggle="modal" data-bs-target="#split_installment_modal"><span>Create installment</span></a>
                            <?php endif ?> 
                        <?php endif ?>



                        <!-- Modal -->
                             <div class="aitsun-modal modal fade" id="split_installment_modal">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addteamLabel">Installment</h5>
                                            <button type="button" class="close" id="closeeee" data-bs-dismiss="modal">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form method="post" action="<?= base_url('fees_and_payments/add_installments'); ?>" id="create_installment_form">
                                                <?= csrf_field() ?>

                                                <h6>Payable amount: <span class="text-success"><?= currency_symbol(company($user['id'])) ?> <?= aitsun_round($invoice_id['due_amount'],get_setting(company($user['id']),'round_of_value')); ?></span></h6>

                                                <div class="form-group">
                                                    <input type="hidden" name="invoice_id" id="inidddd" value="<?= $invoice_id['id']; ?>">
                                                    <input type="hidden" id="due_amount" name="due_amount" value="<?= aitsun_round($invoice_id['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>">
                                                    <input type="hidden" id="cursymb" value="<?= currency_symbol(company($user['id'])) ?>">
                                                    
                                                    <label>No. of installments</label>
                                                    <select class="form-control" name="no_of_installments" id="no_of_installments" required>
                                                        <option value="">Choose</option> 
                                                        <option value="2">2 installments</option> 
                                                        <option value="3">3 installments</option> 
                                                        <option value="4">4 installments</option> 
                                                        <option value="6">6 installments</option> 
                                                        <option value="10">10 installments</option>
                                                        <option value="12">12 installments</option> 
                                                    </select> 

                                                    <div id="errrr"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Day for payment</label> 
                                                    <select class="form-control" name="day_for_payment" id="day_for_payment" required>
                                                        <option value="1">1st</option>  
                                                        <option value="2">2nd</option>  
                                                        <option value="3">3rd</option>  
                                                        <option value="4">4th</option> 
                                                        <option value="5">5th</option> 
                                                        <option value="6">6th</option> 
                                                        <option value="7">7th</option> 
                                                        <option value="8">8th</option> 
                                                        <option value="9">9th</option> 
                                                        <option value="10">10th</option> 
                                                        <option value="11">11th</option> 
                                                        <option value="12">12th</option> 
                                                        <option value="13">13th</option> 
                                                        <option value="14">14th</option> 
                                                        <option value="15">15th</option> 
                                                        <option value="16">16th</option> 
                                                        <option value="17">17th</option> 
                                                        <option value="18">18th</option> 
                                                        <option value="19">19th</option> 
                                                        <option value="20">20th</option> 
                                                        <option value="21">21th</option> 
                                                        <option value="22">22th</option> 
                                                        <option value="23">23rd</option> 
                                                        <option value="24">24th</option> 
                                                        <option value="25">25th</option> 
                                                        <option value="26">26th</option> 
                                                        <option value="27">27th</option> 
                                                        <option value="28">28th</option>  
                                                    </select>  
                                                </div>

                                                <div class="form-group">
                                                    <label>EMI Calculator</label>
                                                    <table id="emi_calcultor" class="w-100 table table-sm">
                                                        
                                                    </table>
                                                </div>

                                                <div class="form-group"> 
                                                    <button class="aitsun-primary-btn" type="button" id="create_installment">Save</button>
                                                </div> 
                                            </form>
                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                    </div>

                  <div class="col-md-12">

                     <form id="policy_form" action="<?= base_url('fees_and_payments/update_pay'); ?>" method="post">
                        <?= csrf_field(); ?>
                         <input type="hidden" name="installment_id[]">

                    <?php if ($invoice_id['is_installment']==1): ?>
                       <div class="alert alert-warning"> 
                           <div class="d-flex justify-content-between">
                            <h5>This have <?= count(installments_array($invoice_id['id'])) ?> installments option</h5>
                            <a data-url="<?= base_url('fees_and_payments/delete_all_installments') ?>/<?= $invoice_id['id'] ?>" class="text-danger delete_installments cursor-pointer no_loader" data-inid="<?= $invoice_id['id'] ?>">Delete All</a>
                        </div>

                            <table class="w-100 table table-sm">
                            <tr>
                                <th>Select</th>
                                <th>#</th>
                                <th>-</th>
                                <th>Amount</th>
                                <th>Due on</th>
                                <th class="text-right">Payment</th> 
                            </tr>

                            <?php $i=0; foreach (installments_array($invoice_id['id']) as $ai): $i++; ?>
                                <tr>
                                    <td style="width: 20px;">

                                        <?php 
                                            $isid=0;
                                            foreach (get_next_unpaid_installment_data($invoice_id['id'],1) as $pi){
                                                $isid=$pi['id'];
                                            }
                                        ?>

                                        <input type="checkbox" name="installment_id[]" class="incheck <?php if ($ai['paid_status']=='paid' || $isid==$ai['id']) {}else{echo 'incheckcount';}?> " data-pstat="<?php if ($ai['paid_status']=='paid' || $isid==$ai['id']){echo 'disable';} ?>" <?php if ($ai['paid_status']=='paid' || $isid==$ai['id']){echo 'checked';} ?> value="<?= $ai['id'] ?>" data-amt="<?= aitsun_round($ai['amount'],get_setting(company($user['id']),'round_of_value')) ?>">
                                    </td>
                                    <td>Installment <?= $ai['installment_name'] ?></td>
                                    <td>-</td>
                                    <td><?= currency_symbol(company($user['id'])) ?> <?= aitsun_round($ai['amount'],get_setting(company($user['id']),'round_of_value')) ?></td>
                                    <td><?= get_date_format($ai['date'],'d M Y') ?></td>
                                    <td class="text-right">
                                        <?php if ($ai['paid_status']=='paid'): ?>
                                            <span class="badge badge-pill bg-success">Paid</span>
                                        <?php endif ?>

                                        <?php if ($ai['paid_status']=='unpaid'): ?>
                                            <span class="badge badge-pill bg-danger">Unpaid</span>
                                        <?php endif ?>
                                    </td>
                                  
                                </tr>
                            <?php endforeach ?>
                        </table>

                       </div>
               
                    <?php endif ?>

                    <?php if ($invoice_id['paid_status']=='unpaid'): ?>
                      


                   
                      
                     
                          <div class="">

                             
                              <div class=" row" >
                                     <input type="hidden" name="customer" value="<?= $invoice_id['customer']; ?>">
                                     <input type="hidden" name="alternate_name" value="<?= $invoice_id['alternate_name']; ?>">
                                     <input type="hidden" name="invoice" value="<?= $invoice_id['id']; ?>">
                                     <input type="hidden" name="total" value="<?= aitsun_round($invoice_id['total'],get_setting(company($user['id']),'round_of_value')); ?>">
                                     <input type="hidden" name="biltype" value="<?= $invoice_id['invoice_type']; ?>">


                                     

                                     <div class="form-group col-md-12 <?php if (get_setting(company($user['id']),'allow_receipt_date')==0): echo 'd-none'; endif; ?>">
                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                        <input type="date" class="form-control cash_date" name="cash_date" id="payment_date" value="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>" >                                      </div><!-- form-group -->

                                      <div class="form-group col-md-12">
                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                                          <select class="form-control" name="payment_type" id="payment_type" required>
                                              <option value=""><?= langg(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>
                                             <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                                <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                                            <?php endforeach ?>
                                              <!-- <option value="credit">Credit</option> -->
                                          </select>
                                      </div><!-- form-group -->



                                      <div id="cash_options" class=" col-md-12">
                                          <div class="form-group">
                                              <label class="">
                                                <?php 
                                                    $payableamt=aitsun_round($invoice_id['total']-$invoice_id['paid_amount'],get_setting(company($user['id']),'round_of_value')); 
                                                    $read_only='';
                                                ?>
                                                <?= langg(get_setting(company($user['id']),'language'),'Amount'); ?>
                                                <?php if (count(get_next_unpaid_installment_data($invoice_id['id'],1))>0): ?>
                                                    (Pay installment 
                                                        <?php foreach (get_next_unpaid_installment_data($invoice_id['id'],1) as $pi): ?>
                                                        <?php 
                                                            $payableamt=aitsun_round($pi['amount'],get_setting(company($user['id']),'round_of_value'));
                                                            $read_only='readonly';
                                                        ?>
                                                           <?= $pi['installment_name'] ?>
                                                           <!-- <input type="hidden" name="installment_id" value="<= $pi['id'] ?>"> -->
                                                        <?php endforeach ?>
                                                    ) 
                                                <?php endif ?>
                                                 
                                              </label>

                                              <input type="hidden" min="0" class="form-control" id="temp_amount" value="<?= $payableamt; ?>" <?= $read_only; ?>>

                                              <input type="number" min="0" class="form-control cash_amount" name="cash_amount" id="payment_amount" value="<?= $payableamt; ?>" <?= $read_only; ?>>
                                          </div><!-- form-group -->
                                      </div>


                                      <div id="cheque_options" class="d-none col-md-12">
                                          <div id="chk_option_container">
                                              <div class="row">
                                                  <div class="col-md-3">
                                                      <div class="form-group my-1 mt-1">
                                                          <input type="number" min="0" class="form-control cheque_amount" name="cheque_amount[]" value="<?= aitsun_round($invoice_id['total']-$invoice_id['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?>" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?>">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <div class="form-group my-1">
                                                          <input type="text" class="form-control " name="cheque_no[]" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?>">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <div class="form-group my-1">
                                                          <input type="date" class="form-control " name="cheque_date[]" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Date'); ?>">
                                                      </div>

                                                  </div>

                                                  <div class="col-md-3">
                                                    <a name="remove" id="add" class="my-1 d-block btn btn-success btn_add dynamic_field_containerclose">+</a>
                                                  </div>

                                              </div>





                                          </div>
                                         
                                      </div>


                                      <div id="bank_transfer_options" class="d-none col-md-12 row">
                                          <div class="col-md-6">
                                              <label><?= langg(get_setting(company($user['id']),'language'),'Reference Id'); ?></label>
                                              <div class="form-group">
                                                  <input type="text" class="form-control " name="reference_id">
                                              </div><!-- form-group -->
                                          </div>
                                          <div class="col-md-6">
                                              <label><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                              <div class="form-group">
                                                  <input type="number" min="0" class="form-control bt_amount" name="bt_amount" value="<?= aitsun_round($invoice_id['total']-$invoice_id['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?>">
                                              </div><!-- form-group -->
                                          </div>
                                      </div>
                         


                                <div class="col-md-12">
                                     <div class="form-group ">
                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Notes'); ?></label>
                                        <textarea class="form-control" name="payment_note" id="input-2"></textarea>
                                      </div>
                                  </div>

                                  <div class="col-md-12 pt-2">
                                     <div class="form-group ">
                                        <button type="button" id="save_payment" data-url="<?= base_url('fees_and_payments/get_challan'); ?>/<?= $invoice_id['id']; ?>" data-inserturl="<?= base_url('fees_and_payments/update_pay'); ?>" class="aitsun-primary-btn"><?= langg(get_setting(company($user['id']),'language'),'Save Payment'); ?></button>
                                      </div>

                                      <div id="res" class="mt-3">

                                      </div>
                                      
                                      
                                  </div>
                                  
                              </div>

                              

                            </div>
                     
                        </form>
                      <?php endif ?>
                  </div>

                  
                </div>
            </div>
        </div>
     


        <div class="card" >
            <div class="card-body table-responsive aitsun_table" >
               <table id="payments_table" class="erp_table fee_pay_tb" style="border-collapse: collapse; border-spacing: 0; ;">
                    <thead>
                    <tr>
                        <td><?= langg(get_setting(company($user['id']),'language'),'Vouch. No'); ?></td>
                        <td><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></td>
                        <td><?= langg(get_setting(company($user['id']),'language'),'Customer/Account'); ?></td>
                        <td><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></td>
                        <td>#</td>
                        <td><?= langg(get_setting(company($user['id']),'language'),'Status'); ?></td>
                        <td class="text-right"><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></td>
                        <td class="text-right"><?= langg(get_setting(company($user['id']),'language'),'Credit'); ?></td>
                        <td class="noExl"><?= langg(get_setting(company($user['id']),'language'),'Action'); ?></td>
                    </tr>
                    </thead>


                    <tbody>
                                    
                                     <?php if ($data_count==0): ?>
                        <tr>
                          <td colspan="9" class="text-center bg-white noExl">
                            <div class="m-5">
                              <i class="zmdi font-33 zmdi-receipt d-block"></i>
                              <h5 class="text-danger"><?= langg(get_setting(company($user['id']),'language'),'No payments'); ?></h5>
                            </div>
                          </td>
                        </tr>
                      <?php endif ?>

                      <?php foreach ($allpayments as $pmt): ?>
                        <tr>
                          
                          <td>
                              <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt['id']; ?>" class="aitsun_link mr-2">
                                <?= get_setting(company($user['id']),'payment_prefix'); ?><?= $pmt['serial_no']; ?>
                              </a>
                          </td>
                          <td><?= get_date_format($pmt['datetime'],'d M Y'); ?></td>
                          <td>
                            <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt['id']; ?>" class="aitsun_link mr-2">
                              
                                <?php if ($pmt['customer']!='CASH'): ?>
                                    <?=  user_name($pmt['customer']); ?>
                                      
                                    <?php elseif ($pmt['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $pmt['alternate_name']; ?> )
                                    <?php endif ?>
                              

                              <?php if ($pmt['bill_type']=='receipt' || $pmt['bill_type']=='payment'): ?>
                                  <?=  account_name($pmt['account_name']); ?>
                              <?php endif; ?>
                            </a>

                          </td>
                          <td><?= get_group_data($pmt['type'],'group_head'); ?></td>
                          <td>

                             <?php if ($pmt['bill_type']=='sale' || $pmt['bill_type']=='purchase return' || $pmt['bill_type']=='purchase' || $pmt['bill_type']=='sale return'): ?>

                                <?php if ($pmt['fees_id']>0): ?>
                                     <a href="<?= base_url('fees_and_payments/view_challan'); ?>/<?= $pmt['invoice_id']; ?>">
                                <?php else: ?>  
                                    <a href="<?= base_url('invoices/details'); ?>/<?= $pmt['invoice_id']; ?>">
                                <?php endif ?>  
                                <?= inventory_prefix($pmt['company_id'],invoice_data($pmt['invoice_id'],'invoice_type')) ?>
                                <?= serial(company($user['id']),$pmt['invoice_id']); ?>
                              </a>
                            <?php endif ?>


                            <?php if ($pmt['bill_type']=='receipt'): ?>
                              ---
                            <?php endif ?>
                          </td>
                          <td>
                            

                            <div id="<?= $pmt['id']; ?>rec_status">
                                <?php if ($pmt['type']=='cheque' || $pmt['type']=='bank_transfer'){ ?>
                                    <?php if ($pmt['receive_status']=='1'){ ?>
                                        <span class="border px-1 rounded cursor-pointer rec_status">
                                            <i class="bx bxs-circle me-1 text-success"></i>
                                            <?= langg(get_setting(company($user['id']),'language'),'Received'); ?>
                                        </span>
                                    <?php }else{ ?>
                                        <span class="border px-1 rounded cursor-pointer rec_status">
                                            <i class="bx bxs-circle me-1 text-danger"></i>
                                            <?= langg(get_setting(company($user['id']),'language'),'Not Received'); ?>
                                        </span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            

                            <?php if ($pmt['type']=='cheque' || $pmt['type']=='bank_transfer'){ ?>
                                <?php if ($pmt['receive_status']!='1'): ?>
                                  <div class="text-left">
                                    <select class="select_c_status" data-id="<?= $pmt['id']; ?>">
                                        <option value="0"><?= langg(get_setting(company($user['id']),'language'),'Not received'); ?></option>
                                        <option value="1"><?= langg(get_setting(company($user['id']),'language'),'Received'); ?></option>
                                    </select>
                                    </div>
                                <?php endif ?>
                            <?php } ?>




                          </td>
                          
                          <td class="text-right">
                            <?php if ($pmt['bill_type']=='payment' || $pmt['bill_type']=='purchase' || $pmt['bill_type']=='sale return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>

                          <td class="text-right">
                            <?php if ($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales' || $pmt['bill_type']=='purchase return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>

                          <td class="noExl">
                            <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt['id']; ?>" class="text-dark mr-2">
                              <i class="bx bx-show"></i>
                            </a>

                            <?php  if (check_permission($user['id'],'delete_receipts_and_payments')==true || $user['u_type']=='admin'): ?>
                                <a class="text-danger delete_rec" data-nid="<?= $pmt['id']; ?>" data-url="<?= base_url('fees_and_payments/delete'); ?>/<?= $pmt['id']; ?>/<?= $invoice_id['id'];?>">
                                    <i class="bx bx-trash"></i>
                                </a>
                            <?php endif ?>

                          </td>
                        </tr>
                      <?php endforeach ?>

                      

           
                    </tbody>
                </table>
            </div>
        </div>




        <div class="aitsun-modal modal fade asms_modal " id="receipt_show_modal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header " style="background: #000000;border-top-left-radius:0;border-bottom:none;border-top-right-radius: 0;">


                <h5 class="modal-title text-white" id="addstudentmodelLabel">Receipt/payment</h5>
  

                <button type="button" class="close text-white location_reload" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body bg-invoice p-0 overflow-scroll-none">
                <div id="pdfthis" class="full_iframe"></div>      
            </div>

             
        </div>
    </div>
</div>
