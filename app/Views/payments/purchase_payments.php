<!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <!-- Page-Title -->
                    <div class="page-title-box">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="page-title mb-1"><?= lang(get_setting(company($user['id']),'language'),'Payments'); ?></h4>
                                 
                                </div>

                                <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                        <div class="dropdown">
                                            <a class="btn btn-danger btn-rounded dropdown-toggle text-white" data-toggle="modal" data-target="#cashentry">
                                                <i class="mdi mdi-plus mr-1"></i> <?= lang(get_setting(company($user['id']),'language'),'Entry'); ?>
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                    </div>
                    <!-- end page title end breadcrumb -->

                    <div class="page-content-wrapper">
                        <div class="container-fluid">
                          
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php if($this->session->flashdata('pu_msg')): ?>
                                              <div class="alert alert-success col-md-12">
                                                   <?= lang(get_setting(company($user['id']),'language'),$this->session->flashdata('pu_msg')); ?>
                                              </div>
                                            <?php endif; ?>
                                            <?php if($this->session->flashdata('pu_er_msg')): ?>
                                              <div class="alert alert-danger col-md-12">
                                                   <?= lang(get_setting(company($user['id']),'language'),$this->session->flashdata('pu_er_msg')); ?>
                                              </div>
                                            <?php endif; ?>

                                            <style type="text/css">
                                                .select2-container--default .select2-selection--single {
                                                    background-color: #fff;
                                                    border: 1px solid #aaa;
                                                    border-radius: 30px;
                                                    height: 30px !important;
                                                }
                                                .select2-container--default .select2-selection--single .select2-selection__rendered {
                                                    color: #000 !important;
                                                    line-height: unset!important;
                                                    padding: 5px 10px;
                                                }
                                                .select2-container--default .select2-selection--single:focus{
                                                    outline: none !important;
                                                }
                                            </style>
            
                                             <!-- FILTER -->
                                            <form method="get" class="row">
                                              <div class="form-group col-md-2  position-relative">
                                                <label>#</label>
                                                <span class="prespan_pay">
                                            <?= get_setting(company($user['id']),'payment_prefix'); ?></span>
                                                <input type="text" name="pay_id" class="form-control filter-control text-ident">
                                              </div>
                                              <div class="form-group col-md-2">
                                                <label><?= lang(get_setting(company($user['id']),'language'),'Vendors'); ?></label>
                                                <select name="customer" class="select2 form-control filter-control">
                                                  <option value=""><?= lang(get_setting(company($user['id']),'language'),'Choose'); ?></option>
                                                    <?php foreach (vendors_array(company($user['id'])) as $cs) { ?>
                                                    <option value="<?= $cs->id; ?>"><?= $cs->display_name; ?>-<?= $cs->phone; ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                              <div class="form-group col-md-2">
                                                <label><?= lang(get_setting(company($user['id']),'language'),'Type'); ?></label>
                                                <select name="type" class="form-control filter-control">
                                                  <option value=""><?= lang(get_setting(company($user['id']),'language'),'Type'); ?></option>
                                                  <option value="cash"><?= lang(get_setting(company($user['id']),'language'),'Cash'); ?></option>
                                                  <option value="cheque"><?= lang(get_setting(company($user['id']),'language'),'Cheque'); ?></option>
                                                  <option value="bank_transfer"><?= lang(get_setting(company($user['id']),'language'),'Bank transfer'); ?></option>
                                                </select>
                                              </div>
                                              <div class="form-group col-md-2">
                                                <label><?= lang(get_setting(company($user['id']),'language'),'From'); ?></label>
                                                <input type="date" name="from" class="form-control filter-control">
                                              </div>
                                              <div class="form-group col-md-2">
                                                <label><?= lang(get_setting(company($user['id']),'language'),'To'); ?></label>
                                                <input type="date" name="to" class="form-control filter-control">
                                              </div>
                                              
                                              <div class="form-group col-md-2 mt-auto">
                                                <button class="btn btn-light btn-filter mt-4 mb-1"><i class="fa fa-filter"></i>&nbsp;<?= lang(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                                              </div>
                                              
                                            </form>
                                            <!-- FILTER -->



                                              <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-justified nav-tabs-custom" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link " href="<?= base_url('payments'); ?>">
                                                         <span class="d-none d-md-inline-block"><?= lang(get_setting(company($user['id']),'language'),'Receipts'); ?></span> 
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="<?= base_url('payments/purchases'); ?>">
                                                         <span class="d-none d-md-inline-block"><?= lang(get_setting(company($user['id']),'language'),'Payments'); ?></span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <a class="btn btn-sm btn-dark mt-2 download_complete" onclick="exporttoexcel('excelthis','payments-<?=  now_time($user['id']); ?>')"><?= lang(get_setting(company($user['id']),'language'),'Excel'); ?></a>
              <!-- Tab panes -->
                                            <div class="tab-content pt-3">
                                                <div class="tab-pane active">
            
                                            <table id="excelthis" class="table table-sm table-responsive-sm table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?= lang(get_setting(company($user['id']),'language'),'Date'); ?></td>
                                                    <td><?= lang(get_setting(company($user['id']),'language'),'Customer/Account'); ?></td>
                                                    <td><?= lang(get_setting(company($user['id']),'language'),'Payment Type'); ?></td>
                                                    <td><?= lang(get_setting(company($user['id']),'language'),'Invoice'); ?></td>
                                                    <td class="text-right"><?= lang(get_setting(company($user['id']),'language'),'Amount'); ?></td>
                                                    <td class="noExl"><?= lang(get_setting(company($user['id']),'language'),'View'); ?></td>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                
                                                 <?php if ($data_count==0): ?>
                                    <tr>
                                      <td colspan="7" class="text-center">
                                        <div class="m-5">
                                          <i class="zmdi font-33 zmdi-receipt d-block"></i>
                                          <h5 ><?= lang(get_setting(company($user['id']),'language'),'No payments'); ?></h5>
                                        </div>
                                      </td>
                                    </tr>
                                  <?php endif ?>

                                  <?php foreach ($allpayments as $pmt): ?>
                                    <tr>
                                      <td>
                                      <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt->id; ?>" class=" mr-2">
                                            <?= get_setting(company($user['id']),'payment_prefix'); ?><?= $pmt->serial_no; ?>
                                          </a>
                                        </td>
                                      <td><?= aitsun_date_month_year($pmt->datetime); ?></td>
                                      <td>
                                        <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt->id; ?>" class=" mr-2">
                                         <?php if ($pmt->bill_type=='purchase' || $pmt->bill_type=='sale return'): ?>
                                            <?php if ($pmt->customer=='CASH'): ?>
                                              CASH CUSTOMER
                                            <?php else: ?>
                                              <?= customer_name($pmt->customer); ?>
                                            <?php endif; ?>
                                          <?php endif; ?>

                                          <?php if ($pmt->bill_type=='payment'): ?>
                                              <?=  account_name($pmt->account_name); ?>
                                          <?php endif; ?>
                                        </a>
                                      </td>
                                      <td><?= $pmt->type; ?></td>
                                      <td>
                                         <?php if ($pmt->bill_type=='purchase' || $pmt->bill_type=='sale return'): ?>
                                          #<?= get_setting(company($user['id']),'invoice_prefix'); ?>
                                          <?php if ($pmt->bill_type=='sale return'): ?>
                                            <?= get_setting(company($user['id']),'sales_return_prefix'); ?>
                                          <?php else: ?>
                                          <?= get_setting(company($user['id']),'purchase_prefix'); ?>
                                          <?php endif ?>
                                          <?= serial(company($user['id']),$pmt->invoice_id); ?>                                          <?php endif ?>
                                          <?php if ($pmt->bill_type=='payment'): ?>
                                            ---
                                          <?php endif ?>
                                      </td>
                                      <td class="text-right">
                                        
                                        <?php if ($pmt->bill_type=='sale'): ?>
                                          <div class="text-success">
                                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt->amount,round_after()); ?> +
                                          </div>
                                        <?php else: ?>
                                            <div class="text-danger">
                                              <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt->amount,round_after()); ?> -
                                            </div>
                                        <?php endif; ?>
                                        
                                          
                                        </td>
                                      <td class="noExl">
                                        <a href="<?php echo base_url('payments/details'); ?>/<?= $pmt->id; ?>" class="text-dark mr-2">
                                          <i class="fa fa-eye"></i>
                                        </a>

                                        <?php if ($pmt->bill_type!='purchase'): ?>

                                          <a class="text-info mr-2" data-toggle="modal" data-target="#ed_rece<?= $pmt->id; ?>">
                                            <i class="fa fa-pencil-alt"></i>
                                          </a>



          <!-- ADD PRODUCT MODAL -->
      <div class="modal  fade" id="ed_rece<?= $pmt->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><?= lang(get_setting(company($user['id']),'language'),'Edit Entry'); ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post">
            <div class="modal-body">
              <div class="row">
             
                <div class="col-md-12" >
                  <div class="w-100 row">


                       <div class="form-group col-md-6">
                        <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Date'); ?></label>
                        <input type="date" name="date" class="form-control modal_inpu" required value="<?= get_date_format($pmt->datetime,'Y-m-d'); ?>">
                       </div>

                       <input type="hidden" name="payid" value="<?= $pmt->id; ?>">

                       <div class="form-group col-md-6">
                        <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Voucher type'); ?></label>
                        <select name="vtype" class="form-control modal_inpu" required>
                          <option value="payment"><?= lang(get_setting(company($user['id']),'language'),'Payment'); ?></option>
                          <option value="receipt"><?= lang(get_setting(company($user['id']),'language'),'Receipt'); ?></option>
                        </select>
                       </div>

                       <div class="form-group col-md-6">
                        <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Account name'); ?></label>
                        <select name="account_name" class="form-control modal_inpu" required>
                          <option value=""><?= lang(get_setting(company($user['id']),'language'),'Choose account name'); ?></option>
                          <?php foreach (account_names_array(company($user['id'])) as $ac) { ?>
                              <option value="<?= $ac->id; ?>" <?php if ($pmt->account_name==$ac->id) { echo 'selected'; } ?>><?= $ac->ex_name; ?></option>
                            <?php } ?>
                        </select>
                       </div>

                       <div class="form-group col-md-6">
                        <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                        <input type="number" name="amount" min="0" class="form-control modal_inpu" required value="<?= aitsun_round($pmt->amount,round_after()); ?>">
                       </div>
                       <div class="form-group col-md-12">
                        <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Note'); ?></label>
                        <textarea name="note" class="form-control modal_inpu"><?= $pmt->payment_note; ?></textarea>
                       </div>
                    
                  </div>
                </div>

              </div>

              <br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang(get_setting(company($user['id']),'language'),'Close'); ?></button>
              <button type="submit" class="btn btn-primary" name="edit_receipt_entry"><?= lang(get_setting(company($user['id']),'language'),'Save'); ?></button>
            </div>
          </form>
          </div>
        </div>
      </div>

                                          <a onclick="return confirm('Are you sure to delete?');" class="text-danger" href="<?= base_url('payments/delete'); ?>/<?= $pmt->id; ?>">
                                            <i class="fa fa-trash"></i>
                                          </a>
                                        <?php endif; ?>
                                      </td>
                                    </tr>
                                  <?php endforeach ?>

                                   <tr>
                                                    <td colspan="4"></td>
                                                    <td class="text-right"><strong><?= lang(get_setting(company($user['id']),'language'),'Total'); ?></strong></td>
                                                    <td class="text-right">
                                                      <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($debit_sum,round_after()); ?></strong>
                                                    </td>
                                                    
                                                    <td></td>
                                                  </tr>

                                       
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div>
                        <!-- end container-fluid -->
                    </div> 
                    <!-- end page-content-wrapper -->
                </div>
                <!-- End Page-content -->

            </div>
            <!-- end main content-->




    <!-- ADD PRODUCT MODAL -->
<div class="modal  fade" id="cashentry" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= lang(get_setting(company($user['id']),'language'),'Add Entry'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
      <div class="modal-body">
        <div class="row">
       
          <div class="col-md-12" >
            <div class="w-100 row">


                 <div class="form-group col-md-6">
                  <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Date'); ?></label>
                  <input type="date" name="date" class="form-control modal_inpu" required value="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>">
                 </div>

                 <div class="form-group col-md-6">
                  <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Voucher type'); ?></label>
                  <select name="vtype" class="form-control modal_inpu" required>
                    <option value="payment"><?= lang(get_setting(company($user['id']),'language'),'Payment'); ?></option>
                    <option value="receipt"><?= lang(get_setting(company($user['id']),'language'),'Receipt'); ?></option>
                  </select>
                 </div>

                 <div class="form-group col-md-6">
                  <div class="d-flex justify-content-between mb-2">
                    <label for="input-1" class="modal_lab my-auto"><?= lang(get_setting(company($user['id']),'language'),'Account name'); ?></label>
                    <span class="btn btn-primary text-white btn-sm" id="add_ac_name">+ <?= lang(get_setting(company($user['id']),'language'),'Add'); ?></span>
                  </div>
                  <select name="account_name" id="acc_sele" class="form-control modal_inpu" required>
                    <option value=""><?= lang(get_setting(company($user['id']),'language'),'Choose account name'); ?></option>
                    <?php foreach (account_names_array(company($user['id'])) as $ac) { ?>
                        <option value="<?= $ac->id; ?>"><?= $ac->ex_name; ?></option>
                      <?php } ?>
                  </select>
                 </div>

                 <div class="form-group col-md-6">
                  <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                  <input type="number" name="amount" min="0" class="form-control modal_inpu" required>
                 </div>
                 <div class="form-group col-md-12">
                  <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Note'); ?></label>
                  <textarea name="note" class="form-control modal_inpu"></textarea>
                 </div>
              
            </div>
          </div>

        </div>

        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang(get_setting(company($user['id']),'language'),'Close'); ?></button>
        <button type="submit" class="btn btn-primary" name="save_receipt_entry"><?= lang(get_setting(company($user['id']),'language'),'Save'); ?></button>
      </div>
    </form>


    <div id="short_ac_add">
      <div class="form-group">
        <label for="input-1" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Expense Name'); ?></label>
        <input type="text" name="exname" class="form-control modal_inpu" id="exname" required>
      </div>

      <div class="form-group">
        <label for="input-5" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Account Category'); ?></label>
        <select class="form-control modal_inpu accountcat" data-ide="" name="accountcat" id="accountcat" required>
          <option value=""><?= lang(get_setting(company($user['id']),'language'),'Select Account Category'); ?></option>
          <?php foreach (exaccount_categories_array(company($user['id'])) as $ac) { ?>
              <option value="<?= $ac->slug; ?>"><?= $ac->category_name; ?></option>
            <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <label for="input-5" class="modal_lab"><?= lang(get_setting(company($user['id']),'language'),'Group Heads'); ?></label>
         <select class="form-control modal_inpu accountcat" data-ide="" name="exgrp" id="exgrp" required>
          <option value=""><?= lang(get_setting(company($user['id']),'language'),'Select Group'); ?></option>
          <?php foreach (exgroup_heads_array(company($user['id'])) as $ac) { ?>
              <option value="<?= $ac->slug; ?>"><?= $ac->grouphead_name; ?></option>
            <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <span type="button" class="btn btn-secondary" id="close_short_ac_add"><?= lang(get_setting(company($user['id']),'language'),'Close'); ?></span>
        <button type="button" class="btn btn-primary" id="add_ac"><?= lang(get_setting(company($user['id']),'language'),'Save Expenses'); ?></button>
      </div>

</div>
    </div>
  </div>
</div>





<script type="text/javascript">


    $(document).on('click','#add_ac_name',function(){
      $('#short_ac_add').addClass('d-block');
    });
    $(document).on('click','#close_short_ac_add',function(){
      $('#short_ac_add').removeClass('d-block');
    });

    $(document).on('click','#add_ac',function(){
      var exname=$.trim($('#exname').val());
      var accountcat=$.trim($('#accountcat').val());
      var exgrp=$.trim($('#exgrp').val());
      if (exname=='' || accountcat=='' || exgrp =='') {

      }else{
        $.ajax({
            type:'POST',
            url:'<?php echo base_url('expenses/add_expense_ajax'); ?>',
            data:{exname:exname,accountcat:accountcat,exgrp:exgrp},
            success:function(result){
              if ($.trim(result)!=0) {
                $('#short_ac_add').removeClass('d-block');
                $('#acc_sele').append('<option value="'+result+'" selected>'+exname+'</option>');
                $('#exname').val('');
                $('#accountcat').val('');
                $('#exgrp').val('');
              }
            }
        });
      }
      
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
                    $('#'+getid+'rec_status').html(' <span class="bg-success rec_status" ><span class="m-auto">Received</span></span>');
                }else{
                    $('#'+getid+'rec_status').html(' <span class="bg-danger rec_status" ><span class="m-auto">Not Received</span></span>');
                }
                
            }
        });
    });
 </script>