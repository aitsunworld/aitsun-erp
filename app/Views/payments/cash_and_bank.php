<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content pay_res">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-sm-flex d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Receipts</div>
            <div class="ps-3 d-sm-flex d-none">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a class="href_loader" href="<?= base_url(); ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="d-flex">
                    <form method="post">
                        <?= csrf_field(); ?>
                            <button type="submit" name="get_excel" class="btn btn-success me-1 download_complete"><i class="bx bxs-file-export me-0"></i></button>
                    </form>

                    <div>
                    <button type="button" class="btn btn-dark collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo"><i class="bx bx-filter me-0"></i></button>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_pay">+ Entry</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add_pay"  aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Entry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" >
                            <?= csrf_field(); ?>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" >
                                <div class=" row">

                                    <?php 
                                        $from_lead='no_lead';
                                        $from_stage='no_stage';
                                        if ($_GET) {
                                          if (isset($_GET['from_lead'])) {
                                            if (!empty($_GET['from_lead'])) {
                                              $from_lead=$_GET['from_lead'];
                                            }
                                          }

                                          if (isset($_GET['from_stage'])) {
                                            if (!empty($_GET['from_stage'])) {
                                              $from_stage=$_GET['from_stage'];
                                            }
                                          }
                                          
                                        }
                                      ?>


                                     <div class="form-group col-md-6 mb-3">
                                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                      <input type="date" name="date" class="form-control modal_inpu" required value="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>">
                                     </div>

                                     <div class="form-group col-md-6 mb-3 d-none">
                                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Voucher type'); ?></label>
                                      <select name="vtype" class="form-control modal_inpu" required>
                                        
                                        <option value="receipt"><?= langg(get_setting(company($user['id']),'language'),'Receipt'); ?></option>
                                        <option value="payment"><?= langg(get_setting(company($user['id']),'language'),'Payment'); ?></option>
                                      </select>
                                     </div>


                                    

                                     <div class="form-group col-md-6 ">
                                      
                                      <div class="d-flex justify-content-between">
                                        <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></label>
                                        <!-- <span class="btn btn-primary text-white btn-sm" id="add_ac_name">+ <= langg(get_setting(company($user['id']),'language'),'Add'); ?></span> -->
                                      </div>


                                      <select name="account_name" id="acc_sele" class="form-control modal_inpu">
                                        <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose particulars'); ?></option>
                                        <?php foreach (ledgers_array(company($user['id'])) as $ac) { ?>
                                            <option value="<?= $ac['id']; ?>"><?= $ac['group_head']; ?></option>
                                          <?php } ?>
                                      </select>
                                     </div>




                                    <div class="form-group col-md-12 mb-3 d-none" >
                                        <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Party Name'); ?></label>
                                         <select class="form-control select2 customer_select" name="customer" id="cusselct">
                                                <option value="CASH"><?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                                </option>
                                                <?php foreach (users_array(company($user['id'])) as $cs) { ?>
                                                    <option value="<?= $cs['id']; ?>"><?= $cs['display_name']; ?></option>
                                                <?php } ?>
                                         </select> 
                                    </div>


                                     <div class="form-group col-md-12 mb-3">
                                      <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                                        <select class="form-control payment_type" name="payment_type" data-id="addd" required>
                                            <option value=""><?= langg(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>
 
                                            <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                                <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                                            <?php endforeach ?>
                                           

                                        </select>
                                    </div><!-- form-group -->

                                    <div id="cash_optionsaddd" class=" col-md-12 mb-3">
                                        <div class="form-group">
                                            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                            <input type="text" min="0" id="cash_input" class="numpad form-control " name="cash_amount" value="0.000">
                                        </div><!-- form-group -->
                                    </div>

                                    <div id="cheque_optionsaddd" class="d-none col-md-12 mb-3">
                                        <div id="chk_option_container">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?></label>
                                                        <input type="number" min="0" class="form-control " name="cheque_amount" value="0.000" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?></label>
                                                        <input type="text" class="form-control " name="cheque_no">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                                        <input type="date" class="form-control " name="cheque_date">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                       
                                    </div>

                                    <div id="bank_transfer_optionsaddd" class="d-none col-md-12 mb-3">
                                      <div class="row">
                                        <div class="col-md-6 mb-3">
                                        <label><?= langg(get_setting(company($user['id']),'language'),'Reference Id'); ?></label>

                                      <div class="form-group">
                                          <input type="text" class="form-control " name="reference_id">
                                      </div><!-- form-group -->
                                      </div>
                                      <div class="col-md-6">
                                      <label><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                      <div class="form-group">
                                          <input type="number" min="0" class="form-control " name="bt_amount" value="0.000" required>
                                      </div><!-- form-group -->
                                      </div>
                                      </div>
                                    </div>

                                     <div class="form-group col-md-12">
                                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></label>
                                      <textarea name="note" class="form-control modal_inpu"></textarea>
                                     </div>
                                  
                                </div>
                              </div>


                             
                              
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                            <button type="submit" class="btn btn-primary" name="save_receipt_entry"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                          </div>
                        </form>
                                
                            </div>
                        </div>
                    </div>


        </div>
        <!--end breadcrumb-->

        <div id="collapseTwo" class="accordion-collapse border-0 collapse">
            <div class="card-body p-0">  
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <div class="row align-items-center">
                                    
                                    <div class="col-lg-9 col-xl-10">
                                         <!-- FILTER -->
                                            <form method="get" class="row">
                                                <?= csrf_field(); ?>
                                              <div class="form-group my-2 col-md-3 position-relative">
                                                
                                                <span class="prespan">
                                                    <span><?= get_setting(company($user['id']),'payment_prefix'); ?></span>
                                                </span>
                                                <input type="text" name="pay_id" class="filter-control text-ident form-control" placeholder="No.">
                                              </div>
                                               
                                              <div class="form-group my-2 col-md-3 ">
                                                <input type="date" name="from" class="filter-control form-control" title="From" placeholder="">
                                              </div><div class="form-group my-2 col-md-3 ">
                                                <input type="date" name="to" title="To" class="filter-control form-control" placeholder="">
                                              </div>
                                              

                                              <div class="form-group my-2 col-md-3 ">
                                                <Select name="p_type" class="filter-control form-control">
                                                  <option value="">Payment Type</option>
                                                    <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                                        <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                                                    <?php endforeach ?>

                                                </Select>
                                              </div>

                                              
                                              <div class="form-group my-2 col-md-3  my-auto">
                                                <button class="btn btn-facebook btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                                              </div>
                                              
                                            </form>
                                            <!-- FILTER -->
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>


        <div class="container px-0">

        <?php if (session()->get('sucmsg')): ?>
            <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success">Success</h6>
                        <div><?= session()->get('sucmsg'); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <?php if (session()->get('failmsg')): ?>
        <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger">Failed!</h6>
                    <div><?= session()->get('failmsg'); ?></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif ?>
        <?php if (session()->get('wrngmsg')): ?>
        <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-danger">Failed!</h6>
                    <div><?= session()->get('wrngmsg'); ?></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif ?>

        <div class="main-body">
            <div class="row">

            <?php $i=0; foreach ($allpayments as $pmt ): $i++; ?>

                <div class="col-md-4 col-12">
                    <div class="card radius-10">
                        <a class="href_loader" href="<?= base_url('payments/details'); ?>/<?= $pmt['id']; ?>">
                        <div class="card-header">
                            <div class="d-flex justify-content-between ">
                                <h6 class="card-title text-facebook mb-0"> <?= get_setting(company($user['id']),'payment_prefix'); ?> <?= $pmt['serial_no']; ?></h6>

                                <span class=" px-2 rounded " style="font-size: 12px;border: 1px solid; color: #0a8a97;">💷<?= get_group_data($pmt['type'],'group_head'); ?></span>
                                


                            </div>
                        </div>
                        </a>

                        <div class="card-body pb-2 pt-0">
                            

                            <div class="d-flex justify-content-between mt-2">
                                <div>
                                    <p class="card-text mb-0 text-muted" style="font-size:11px;">

                                        <?php if ($pmt['bill_type']=='sales' || $pmt['bill_type']=='purchase_return' || $pmt['bill_type']=='purchase' || $pmt['bill_type']=='sales_return' || $pmt['bill_type']=='discount_received'): ?>

                                            <?php if ($pmt['customer']!='CASH'): ?>
                                            <?=  user_name($pmt['customer']); ?>

                                            <?php elseif ($pmt['alternate_name']!='CASH CUSTOMER'): ?>
                                            <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $pmt['alternate_name']; ?> )

                                            <?php elseif ($pmt['alternate_name']=='CASH'): ?>
                                              <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                            <?php else: ?>
                                                <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                            <?php endif ?>
                                          <?php else: ?>
                                          <?= get_group_data($pmt['account_name'],'group_head'); ?>
                                          <?php endif ?>

                                          <?php if ($pmt['bill_type']=='discount_received'): ?>
                                              (discount received)
                                          <?php endif ?>

                                    </p>
                                    <small class="card-text text-muted" style="font-size:11px;">
                                        <?php if ($pmt['bill_type']=='sales' || $pmt['bill_type']=='purchase_return' || $pmt['bill_type']=='discount_received'): ?>
                                          <a class="href_loader" href="<?= base_url('invoices/details'); ?>/<?= $pmt['invoice_id']; ?>">
                                        <?= get_setting(company($user['id']),'invoice_prefix'); ?>
                                        <?php if ($pmt['bill_type']=='purchase_return'): ?>
                                          <?= get_setting(company($user['id']),'purchase_return_prefix'); ?>
                                        <?php elseif($pmt['bill_type']=='purchase'): ?>
                                          <?= get_setting(company($user['id']),'purchase_prefix'); ?>
                                          <?php elseif($pmt['bill_type']=='sales_return'): ?>
                                          <?= get_setting(company($user['id']),'sales_return_prefix'); ?>
                                        <?php else: ?>
                                        <?= get_setting(company($user['id']),'sales_prefix'); ?>
                                        <?php endif ?>
                                        <?= serial(company($user['id']),$pmt['invoice_id']); ?>
                                          </a>
                                        <?php endif ?>
                                    </small>
                                </div>
                                 <?php if ($pmt['bill_type']=='expense' || $pmt['bill_type']=='purchase'|| $pmt['bill_type']=='discount_allowed' || $pmt['bill_type']=='sales_return'): ?>
                                   <h6 class="my-auto text-danger">-<?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],round_after()); ?></h6>
                                <?php elseif($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales' || $pmt['bill_type']=='purchase_return' || $pmt['bill_type']=='discount_received'): ?>
                                  <h6 class="my-auto text-success">+<?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],round_after()); ?></h6>
                                  <?php endif ?>

                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted my-auto" style="font-size: 10px;"><?= get_date_format($pmt['datetime'],'d M Y'); ?></small>

                                <div class="my-auto">
                                    <div class="d-flex">
                                        <div id="<?= $pmt['id']; ?>rec_status">
                                            <?php if ($pmt['type']=='cheque' || $pmt['type']=='bank_transfer'){ ?>
                                            <?php if ($pmt['receive_status']=='1'){ ?>
                                                <span class="px-2 py-1 rec_status text-capitalize rounded" style="font-size:12px;color: green;">
                                                <?= langg(get_setting(company($user['id']),'language'),'Received'); ?>
                                            </span>
                                            <?php }else{ ?>
                                                <span class="px-2 py-1 rec_status text-capitalize rounded" style="font-size:12px;color: red;">
                                                <?= langg(get_setting(company($user['id']),'language'),'Not Received'); ?>
                                            </span>
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                        

                                        <?php if ($pmt['type']=='cheque' || $pmt['type']=='bank_transfer'){ ?>
                                            <?php if ($pmt['receive_status']!='1'): ?>
                                              <div class="text-end">

                                                <div class=" form-switch">
                                                    <input class="form-check-input select_c_status" type="checkbox"  data-id="<?= $pmt['id']; ?>" value="1" <?php if ($pmt['receive_status']== '1') {echo 'checked';} ?> style="width: 36px;height: 18px;">
                                                    
                                                </div>
                                                
                                                
                                                </div>

                                            <?php endif ?>
                                        <?php } ?>

                                    </div>
                                    
                                </div>


                            </div>


                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <?php if ($pmt['bill_type']!='sales' && $pmt['bill_type']!='sales_return' && $pmt['bill_type']!='purchase_return' && $pmt['bill_type']!='purchase'): ?>
 
                                    <a class="text-primary" data-bs-toggle="modal" data-bs-target="#edit_pay<?= $pmt['id']; ?>" ><i class="bx bxs-pencil"></i></a>
                                    <a data-url="<?= base_url('payments/delete'); ?>/<?= $pmt['id']; ?>" class="ms-2 text-danger delete_payment"><i class="bx bxs-trash"></i></a>

                                    <?php endif ?>
                                    
                                </div>
                                <a href="#" class="text-success d-none"><i class="lni lni-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="edit_pay<?= $pmt['id']; ?>"  aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Entry</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post">
                                    <?= csrf_field(); ?>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" >
                                <div class=" row">


                                     <div class="form-group col-md-6 mb-3">
                                        <input type="hidden" name="payid" value="<?= $pmt['id']; ?>">
                                        
                                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                      <input type="date" name="date" class="form-control " required value="<?= get_date_format($pmt['datetime'],'Y-m-d'); ?>">
                                     </div>

                                     <div class="form-group col-md-6 mb-3 d-none">
                                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Voucher type'); ?></label>
                                      <select name="vtype" class="form-control modal_inpu" required>
                                        
                                        <option value="receipt" <?php if ($pmt['bill_type']=='receipt'){echo 'selected'; }?>><?= langg(get_setting(company($user['id']),'language'),'Receipt'); ?></option>
                                        <option value="expense" <?php if ($pmt['bill_type']=='expense'){echo 'selected'; }?>><?= langg(get_setting(company($user['id']),'language'),'Payment'); ?></option>
                                      </select>
                                     </div>

                                     <div class="form-group col-md-6 ">
                                      
                                      <div class="d-flex justify-content-between">
                                        <label for="input-1" class="modal_lab my-auto"><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></label>
                                
                                      </div>

                                      <select name="account_name" id="acc_sele" class="form-control modal_inpu">
                                        <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose particulars'); ?></option>
                                        <?php foreach (ledgers_array(company($user['id'])) as $ac) { ?>
                                            <option value="<?= $ac['id']; ?>" <?php if ($pmt['account_name']==$ac['id']){echo 'selected'; }?>><?= $ac['group_head']; ?></option>
                                          <?php } ?>
                                      </select>
                                     </div>


                                     <div class="form-group col-md-12 mb-3 d-none">
                                        <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Party Name'); ?></label>
                                         <select class="form-control select2 customer_select" name="customer">
                                                <option value="CASH"><?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                                </option>
                                                
                                                <?php foreach (users_array(company($user['id'])) as $cs) { ?>
                                                    <option value="<?= $cs['id']; ?>" <?php if ($pmt['customer']==$cs['id']){echo 'selected'; } ?>> <?= $cs['display_name']; ?></option>
                                                <?php } ?>
                                         </select>
                                         
                                    </div>

                                     <div class="form-group col-md-12 mb-3">
                                      <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                                        <select class="form-control payment_type" name="payment_type" data-id="<?= $pmt['id']; ?>" required>
                                            <option value=""><?= langg(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>
 

                                            <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                                <option value="<?= $ba['id']; ?>" <?php if ($pmt['type']==$ba['id']){echo 'selected'; }?>><?= $ba['group_head']; ?></option>
                                            <?php endforeach ?>

                                             
                                        </select>
                                    </div><!-- form-group -->

                                    <div id="cash_options<?= $pmt['id']; ?>" class="<?php if ($pmt['type']!='cash'){}?> col-md-12 mb-3">
                                        <div class="form-group">
                                            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                            <input type="text" min="0" id="cash_input" class="numpad form-control " name="cash_amount" value="<?= aitsun_round($pmt['amount'],round_after()); ?>">
                                        </div><!-- form-group -->
                                    </div>

                                    <div id="cheque_options<?= $pmt['id']; ?>" class="<?php if ($pmt['type']!='cheque'){echo 'd-none'; }?> col-md-12 mb-3">
                                        <div id="chk_option_container">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?></label>
                                                        <input type="number" min="0" class="form-control " name="cheque_amount" value="<?= aitsun_round($pmt['amount'],round_after()); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?></label>
                                                        <input type="text" class="form-control " name="cheque_no" value="<?= $pmt['cheque_no']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                                        <input type="date" class="form-control " name="cheque_date" value="<?= $pmt['cheque_date']; ?>">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                       
                                    </div>

                                    <div id="bank_transfer_options<?= $pmt['id']; ?>" class="<?php if ($pmt['type']!='bank_transfer'){echo 'd-none'; }?> col-md-12 mb-3">
                                      <div class="row">
                                        <div class="col-md-6 mb-3">
                                        <label><?= langg(get_setting(company($user['id']),'language'),'Reference Id'); ?></label>

                                      <div class="form-group">
                                          <input type="text" class="form-control " name="reference_id" value="<?= $pmt['reference_id']; ?>">
                                      </div><!-- form-group -->
                                      </div>
                                      <div class="col-md-6">
                                      <label><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                      <div class="form-group">
                                          <input type="number" min="0" class="form-control " name="bt_amount" value="<?= aitsun_round($pmt['amount'],round_after()); ?>" required>
                                      </div><!-- form-group -->
                                      </div>
                                      </div>
                                    </div>

                                     <div class="form-group col-md-12">
                                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></label>
                                      <textarea name="note" class="form-control modal_inpu"><?= $pmt['payment_note']; ?></textarea>
                                     </div>
                                  
                                </div>
                              </div>


                             
                              
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                            <button type="submit" class="btn btn-primary" name="edit_receipt_entry"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                          </div>
                        </form>
                                
                            </div>
                        </div>
                    </div>
    
            <?php endforeach ?>
            <?php if ($i==0): ?>
                <div class="col-md-12">
                        <div class="text-center">
                            <h4 class="m-5 text-danger">No Receipts </h4>
                        </div>
                   
                </div>
            <?php endif ?>
                

            </div>
        </div>
    </div>
</div>
</div>
        <!--end page wrapper -->



        <script type="text/javascript">
  $(document).ready(function(){  
      $(".payment_type").change(function(){
        var opt_id=$(this).data('id');
        var catname = $(this).val();
        if (catname=='cash') {
          d_n_all_form(opt_id);
          $('#cash_options'+opt_id).removeClass("d-none");
        }   
        if (catname=='cheque') {
          d_n_all_form(opt_id);
          $('#cheque_options'+opt_id).removeClass("d-none");
        } 
        if (catname=='bank_transfer') {
          d_n_all_form(opt_id);
          $('#bank_transfer_options'+opt_id).removeClass("d-none");
        }   
      });   
      function d_n_all_form(opt_id){
        $('#cheque_options'+opt_id).addClass("d-none");
        $('#bank_transfer_options'+opt_id).addClass("d-none");
        $('#cash_options'+opt_id).addClass("d-none");
      }
 
    });



</script>