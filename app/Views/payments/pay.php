<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>" class="href_loader"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>

                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('invoices/details'); ?>/<?= $invoice_data['id'] ?>"><?= inventory_prefix(company($user['id']),$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Receipt or Payment</b>
                </li>
            </ol>
        </nav>

        
     
        <div class="d-flex">
           
            <a class="my-auto ms-2 text-dark cursor-pointer font-size-topbar href_loader" title="Refresh" onclick="location.reload();">    
                <i class="bx bx-refresh"></i>
            </a>
             <a class="my-auto ms-2 text-aitsun-red href_loader cursor-pointer font-size-topbar" href="<?= base_url() ?>" title="Back">
                <i class="bx bxs-category"></i>
            </a>
        </div>

    </div>
</div>
<!-- ////////////////////////// TOP BAR END ///////////////////////// -->

<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#payments_table" data-filename="Invoice receipts"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#payments_table" data-filename="Invoice receipts"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#payments_table" data-filename="Invoice receipts"> 
            <span class="my-auto">PDF</span>
        </a>
      
       
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#payments_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>
 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<?php if (session()->get('pu_msg')): ?>
    <script type="text/javascript">
        popup_message('success','Done',"<?= session()->get('pu_msg'); ?>"); 
    </script>
<?php endif ?>

<?php if (session()->get('pu_er_msg')): ?> 
    <script type="text/javascript">
        popup_message('error','Failed',"<?= session()->get('pu_er_msg'); ?>"); 
    </script>
<?php endif ?>
  

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
  
     <div class="col-md-4">
        <div class="card radius-10 bg-primary bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white"><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></p>
                        <h4 class="my-1 text-white"><?= currency_symbol(company($user['id'])) ?><?= aitsun_round($invoice_data['total']); ?></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-money"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 ps-3 pe-3">
        <div class="card radius-10 bg-success bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white"><?= langg(get_setting(company($user['id']),'language'),'Paid'); ?></p>
                        <h4 class="my-1 text-white"><?= currency_symbol(company($user['id'])) ?><span id="paidcalc"><?= aitsun_round($invoice_data['paid_amount'],round_after()); ?></span></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-money"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card radius-10 bg-danger bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white"><?= langg(get_setting(company($user['id']),'language'),'Due'); ?></p>
                        <h4 class="my-1 text-white"><?= currency_symbol(company($user['id'])) ?><span id="duecalc"><?= aitsun_round($invoice_data['due_amount'],round_after()); ?></span></h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-money"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>




      <div class="col-md-12 pt-2">

        <?php if ($invoice_data['paid_status']=='unpaid'): ?>
          


       
          
          <form id="policy_form">
            <?= csrf_field(); ?>
              <div class="">

                 
                  <div class=" row" >
                         <input type="hidden" name="customer" value="<?= $invoice_data['customer']; ?>">
                         <input type="hidden" name="alternate_name" value="<?= $invoice_data['alternate_name']; ?>">
                         <input type="hidden" name="invoice" value="<?= $invoice_id; ?>">
                         <input type="hidden" name="total" value="<?= aitsun_round($invoice_data['total']); ?>">
                         <input type="hidden" name="biltype" value="<?= $invoice_data['invoice_type']; ?>">


                         

                          <div class="form-group col-md-12">
                            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                              <select class="form-select" name="payment_type" id="payment_type" required>
                                  <option value=""><?= langg(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>
                                 <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                    <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                                <?php endforeach ?>
                                  <!-- <option value="credit">Credit</option> -->
                              </select>
                          </div><!-- form-group -->



                          <div id="cash_options" class=" col-md-12">
                              <div class="form-group">
                                  <label class=""><?= langg(get_setting(company($user['id']),'language'),'Cash Amount'); ?></label>
                                  <input type="number" min="0" class="form-control cash_amount" name="cash_amount" value="<?= aitsun_round($invoice_data['due_amount'],round_after()); ?>" id="cash_amount">
                              </div><!-- form-group -->
                          </div>


                          <div id="cheque_options" class="d-none col-md-12">
                              <div id="chk_option_container">
                                  <div class="row">
                                      <div class="col-md-3">
                                          <div class="form-group my-1 mt-1">
                                              <input type="number" min="0" class="form-control cheque_amount" name="cheque_amount[]" value="<?= aitsun_round($invoice_data['total']-$invoice_data['paid_amount'],round_after()); ?>" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?>">
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
                                      <input type="number" min="0" class="form-control bt_amount" name="bt_amount" value="<?= aitsun_round($invoice_data['total']-$invoice_data['paid_amount'],round_after()); ?>">
                                  </div><!-- form-group -->
                              </div>
                          </div>
             

 
                      <div class="col-md-12 ">
                         <div class="form-group ">
                            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Notes'); ?></label>
                            <textarea class="form-control" name="payment_note" id="input-2"></textarea>
                          </div>
                      </div>

                      <div class="col-md-12 pt-2">
                         <div class="form-group ">
                            <button type="button" id="save_payment" class="aitsun-primary-btn no_loader"><?= langg(get_setting(company($user['id']),'language'),'Save Payment'); ?></button>
                          </div>

                          <div id="res" class="mt-3">
                          </div>
                          
                          <a onclick="createPDF('pdfthis','<?= user_name($invoice_data['customer']); ?><?= $invoice_id ?>-invoice')"  class="btn btn-dark btn-sm printbtn d-none mb-3" >
                              <i class="bx bx-printer"></i> 
                              <span><?= langg(get_setting(company($user['id']),'language'),'Print Receipt'); ?></span>
                          </a>
                      </div>
                       

                  

                </div> 
              </div>
            </form>
          <?php endif ?>
      </div>

        <div class="col-md-12">
          <div id="pdfthis" class="bg-white mb-3">

           </div>
        </div>


        <div class="col-md-12 aitsun_table w-100 pt-0 pb-5">
             <table id="payments_table" class="erp_table sortable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Vouch. No'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Customer/Account'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></th>
                        <th class="sorticon">#</th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Status'); ?></th>
                        <th class="sorticon text-right"><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></th>
                        <th class="sorticon text-right"><?= langg(get_setting(company($user['id']),'language'),'Credit'); ?></th>
                        <th class="sorticon" data-tableexport-display="none"><?= langg(get_setting(company($user['id']),'language'),'Action'); ?></th>
                    </tr>
                </thead>


                    <tbody>
                    
                     <?php if ($data_count==0): ?>
        <tr>
          <td colspan="9" class="text-center noExl">
            <div class="m-5">
              <i class="zmdi font-33 zmdi-receipt d-block"></i>
              <h5 ><?= langg(get_setting(company($user['id']),'language'),'No payments'); ?></h5>
            </div>
          </td>
        </tr>
      <?php endif ?>

      <?php foreach ($allpayments as $pmt): ?>
        <tr>
          
          <td>
              <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt['id']; ?>" class=" mr-2">
                <?= get_setting(company($user['id']),'payment_prefix'); ?><?= $pmt['serial_no']; ?>
              </a>
          </td>
          <td><?= get_date_format($pmt['datetime'],'d M Y'); ?></td>
          <td>
            <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt['id']; ?>" class=" mr-2">
              
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
              <a href="<?= base_url('invoices/details'); ?>/<?= $pmt['invoice_id']; ?>">
            <?= get_setting(company($user['id']),'invoice_prefix'); ?>
            <?php if ($pmt['bill_type']=='purchase return'): ?>
              <?= get_setting(company($user['id']),'purchase_return_prefix'); ?>
            <?php elseif($pmt['bill_type']=='purchase'): ?>
              <?= get_setting(company($user['id']),'purchase_prefix'); ?>
              <?php elseif($pmt['bill_type']=='sale return'): ?>
              <?= get_setting(company($user['id']),'sales_return_prefix'); ?>
            <?php else: ?>
            <?= get_setting(company($user['id']),'sales_prefix'); ?>
            <?php endif ?>
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
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],round_after()); ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>
                          <td class="text-right">
                            <?php if ($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales' || $pmt['bill_type']=='purchase return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],round_after()); ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>
          <td class="noExl"  data-tableexport-display="none">
            <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt['id']; ?>" class="text-dark mr-2">
              <i class="bx bx-show"></i>
            </a>

            <?php if ($pmt['bill_type']!='sale' && $pmt['bill_type']!='sale return' && $pmt['bill_type']!='purchase return' && $pmt['bill_type']!='purchase'): ?>
             <a class="text-info mr-2" data-toggle="modal" data-target="#ed_rece<?= $pmt['id']; ?>">
                <i class="fa fa-pencil-alt"></i>
              </a>



<!-- ADD PRODUCT MODAL -->
<div class="modal  fade" id="ed_rece<?= $pmt['id']; ?>"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Edit Entry'); ?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<form method="post">
<?= csrf_field(); ?>
<div class="modal-body">
<div class="row">

<div class="col-md-12" >
<div class="w-100 row">


<div class="form-group col-md-6">
<label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
<input type="date" name="date" class="form-control modal_inpu" required value="<?= get_date_format($pmt['datetime'],'Y-m-d'); ?>">
</div>

<input type="hidden" name="payid" value="<?= $pmt['id']; ?>">

<div class="form-group col-md-6">
<label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Voucher type'); ?></label>
<select name="vtype" class="form-control modal_inpu" required>
<option value="receipt"<?php if ($pmt['bill_type']=='receipt'){echo 'selected'; }?>><?= langg(get_setting(company($user['id']),'language'),'Receipt'); ?></option>
<option value="payment"<?php if ($pmt['bill_type']=='payment'){echo 'selected'; }?>><?= langg(get_setting(company($user['id']),'language'),'Payment'); ?></option>
</select>
</div>

<div class="form-group col-md-6">
<label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Account name'); ?></label>

<select name="account_name" class="form-control modal_inpu" required>
<option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose account name'); ?></option>
<?php foreach (account_names_array(company($user['id'])) as $ac) { ?>
  <option value="<?= $ac['id']; ?>" <?php if ($pmt['account_name']==$ac['id']) { echo 'selected'; } ?>><?= $ac['category_name']; ?></option>
<?php } ?>
</select>
</div>

<div class="form-group col-md-6">
<label class=""><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
<select class="form-control payment_type" name="payment_type" data-id="<?= $pmt['id']; ?>" required>
<option value=""><?= langg(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>
<option value="cheque" <?php if ($pmt['type']=='cheque'){echo 'selected'; }?>><?= langg(get_setting(company($user['id']),'language'),'Cheque'); ?></option>
<option value="bank_transfer" <?php if ($pmt['type']=='bank_transfer'){echo 'selected'; }?>><?= langg(get_setting(company($user['id']),'language'),'Bank Transfer'); ?></option>
</select>
</div><!-- form-group -->


<div id="cheque_options<?= $pmt['id']; ?>" class="<?php if ($pmt['type']!='cheque'){echo 'd-none'; }?> col-md-12">
<div id="chk_option_container">
<div class="row">
<div class="col">
    <div class="form-group">
        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?></label>
        <input type="number" min="0" class="form-control " name="cheque_amount" value="<?= aitsun_round($pmt['amount'],round_after()); ?>" required>
    </div>
</div>
<div class="col">
    <div class="form-group">
        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?></label>
        <input type="text" class="form-control" name="cheque_no" value="<?= $pmt['cheque_no']; ?>">
    </div>
</div>
<div class="col">
    <div class="form-group">
        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
        <input type="date" class="form-control" name="cheque_date" value="<?= $pmt['cheque_date']; ?>">
    </div>

</div>

</div>
</div>

</div>

<div id="bank_transfer_options<?= $pmt['id']; ?>" class="<?php if ($pmt['type']!='bank_transfer'){echo 'd-none'; }?> col-md-12">
<div class="row">
<div class="col-md-6">
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

<br>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
<button type="submit" class="btn btn-primary no_loader" name="edit_receipt_entry"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
</div>
</form>
</div>
</div>
</div>

              <a class="text-danger  delete" data-url="<?= base_url('payments/delete'); ?>/<?= $pmt['id']; ?>">
                <i class="fa fa-trash"></i>
              </a>
              <?php endif ?>

              <a class="text-danger  delete" data-url="<?= base_url('payments/delete_from_invoice'); ?>/<?= $pmt['id']; ?>/<?= $invoice_id; ?>">
                <i class="bx bx-trash"></i>
              </a>

          </td>
        </tr>
      <?php endforeach ?>

      

           
                    </tbody>
                </table>
        </div>

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 


<script type="text/javascript">
  $(document).ready(function(){  
      $(document).on('click','#save_payment',function(){ 

                  var payment_type =$('#payment_type').val(); 
                  var cash_amount =$('#cash_amount').val(); 

                  if (payment_type=='') {
              
                      popup_message('error','Failed!','Please select payment type');

                      $('#save_payment').html('Save');
                      setTimeout(function(){  
                         // $('#res').fadeOut("slow");  
                    }, 5000); 
                  }else if(cash_amount<1){

                      popup_message('error','Failed!','Amount must be greater than 0');

                      $('#save_payment').html('Save');
                      setTimeout(function(){  
                         // $('#res').fadeOut("slow");  
                    }, 5000); 
                  }else{
                      $.ajax({  
                           url:"<?= base_url('invoices/update_pay'); ?>",  
                           method:"POST",  
                           data:$('#policy_form').serialize(),  
                           beforeSend:function(){  
                                $('#save_payment').html('<i class="bx bx-loader-alt bx-spin"></i> Saving..');  
                           },  
                           success:function(data){
                            $('#save_payment').html('Save Payment');
                           if ($.trim(data)=='morethandue') {
                            
                            popup_message('error','Failed!','Enter amount less than or equal to due amount');
                           }else{
                              $('#pdfthis').fadeIn().html(data);
                               

                            popup_message('success','Done!','Payment saved');

                              $('.printbtn').removeClass('d-none');

                              var paidaaa=$('#paidcalc').html();
                              var dueaaa=$('#duecalc').html();

                              if (payment_type=='cash') {
                                $('#paidcalc').html(parseFloat($('.cash_amount').val())+parseFloat(paidaaa));
                                $('#duecalc').html(parseFloat(dueaaa)-parseFloat($('.cash_amount').val()));
                              }else if(payment_type=='bank_transfer'){
                                 $('#paidcalc').html(parseFloat($('.bt_amount').val())+parseFloat(paidaaa));
                                 $('#duecalc').html(parseFloat(dueaaa)-parseFloat($('.bt_amount').val()));
                              }else if (payment_type=='cheque') {
                               
                                location.reload();

                              }else{

                              }
                              $('#policy_form')[0].reset();
                           }   
                                
                           }  
                      }); 
                  }
                        
            });

          $(document).on('click', '#add', function(){  
           i++;  
           var appe='<div class="col-md-3"><div class="form-group my-1 mt-1"><input type="number" min="0" class="form-control cheque_amount" name="cheque_amount[]" value="0.000" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?>"></div></div><div class="col-md-3"><div class="form-group my-1"><input type="text" class="form-control " name="cheque_no[]" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?>"></div></div><div class="col-md-3"><div class="form-group my-1"><input type="date" class="form-control " name="cheque_date[]" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Date'); ?>"></div></div><div class="col-md-3"><a name="remove" id="'+i+'" class="my-1 d-block btn btn-danger btn_remove dynamic_field_containerclose">-</a></div>';
           $('#chk_option_container').append('<div id="row'+i+'" class="row">'+appe+'</div>');});

            $(document).on('click', '.btn_remove', function(){  
                 var button_id = $(this).attr("id");   
                 $('#row'+button_id+'').remove();  
            });  



      $("#payment_type").change(function(){
        var catname = $(this).val(); 
        if (catname=='cash') {
          d_n_all_form();
          $('#cash_options').removeClass("d-none");
        } 
        if (catname=='cheque') {
          d_n_all_form();
          $('#cheque_options').removeClass("d-none");
        } 
        if (catname=='bank_transfer') {
          d_n_all_form();
          $('#bank_transfer_options').removeClass("d-none");
        } 
        if (catname=='credit') {
          d_n_all_form();
        }   
      });   
      function d_n_all_form(){
        $('#cash_options').addClass("d-none");
        $('#cheque_options').addClass("d-none");
        $('#bank_transfer_options').addClass("d-none");
      }

      var i=1;  

      $('#add').click(function(){  
           i++;  
           var appe='<tr id="row'+i+'"><td><div class="form-group"><select class="form-control " id="input-2"><option>Bharath</option><option>Rajesh</option></select></div></td><td><div class="form-group"><input type="number" class="form-control " id="input-2"></div></td><td><div class="form-group "><input type="text" class="form-control " id="input-2"></div></td><td><div class="form-group "><input type="number" class="form-control " id="input-2"></div></td><td>0,00</td><td><a id="'+i+'" class="text-dark btn_remove">X</a></td></tr>';

           $('#dynamic_field').append(appe);});

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


       $(document).on('change', '.select_c_status', function(){
       var statusname = $(this).val();                  
       var getid = $(this).attr("data-id");    

        $.ajax({
            type:'POST',
            url:'<?php echo base_url('payments/update_status'); ?>',
            data:{statusname:statusname,getid
            :getid},
            success:function(result){
                if (statusname=='1') {
                    $('#'+getid+'rec_status').html('<span class="border px-1 rounded cursor-pointer rec_status"><i class="bx bxs-circle me-1 text-success"></i><?= langg(get_setting(company($user['id']),'language'),'Received'); ?></span>');
                }else{
                    $('#'+getid+'rec_status').html('<span class="border px-1 rounded cursor-pointer rec_status"><i class="bx bxs-circle me-1 text-danger"></i><?= langg(get_setting(company($user['id']),'language'),'Not Received'); ?></span>');
                }
                
            }
        });
    });

    });
</script>

