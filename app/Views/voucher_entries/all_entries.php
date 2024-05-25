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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Vouchers</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#vouchers_table" data-filename="Vouchers - <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#vouchers_table" data-filename="Vouchers - <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#vouchers_table" data-filename="Vouchers - <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#vouchers_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a href="<?= base_url('voucher_entries/add') ?>" class="text-dark font-size-footer my-auto ms-2 href_loader"> <span class="my-auto">+ Add Entries</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

  
        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?> 

                        <input type="text" name="pay_id" class="form-control form-control-sm filter-control" placeholder="No.">
                        <input type="date" name="from" class="form-control form-control-sm filter-control" title="From" placeholder="">
                        <input type="date" name="to" title="To" class="form-control form-control-sm filter-control" placeholder="">
                        
                        <Select name="p_type" class="form-control form-control-sm">
                          <option value="">Payment Type</option>
                            <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                            <?php endforeach ?> 
                        </Select>

                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('voucher_entries') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="vouchers_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">No.</th>
                    <th class="sorticon">Account</th>
                    <th class="sorticon">Ref.</th>
                    <th class="sorticon">Payment</th> 
                    <th class="sorticon">Date</th> 
                    <th class="sorticon">Full voucher</th> 
                    <th class="sorticon">Inventory #</th> 
                    <th class="sorticon text-end">Debit <small>(<?= currency_symbol(company($user['id'])); ?>)</small></th> 
                    <th class="sorticon text-end">Credit <small>(<?= currency_symbol(company($user['id'])); ?>)</small></th> 
                    <th class="sorticon">Note</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php 
                    $data_count=0; $total_debit=0; $total_credit=0; foreach ($allpayments as $pmt ): $data_count++; ?>
                    <tr>
                        <td>
                            <a class="href_loader aitsun_link" href="<?= base_url('payments/details'); ?>/<?= $pmt['id']; ?>">
                                <?= get_setting(company($user['id']),'payment_prefix'); ?> <?= $pmt['serial_no']; ?>
                            </a>
                        </td>
                        <td>
                             <?php if ($pmt['bill_type']=='sales' || $pmt['bill_type']=='proforma_invoice' || $pmt['bill_type']=='purchase_return' || $pmt['bill_type']=='purchase' || $pmt['bill_type']=='sales_return' || $pmt['bill_type']=='discount_received'): ?>

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
                              <?= get_group_data($pmt['account_name'],'display_name'); ?>
                              <?php endif ?>

                              <?php if ($pmt['bill_type']=='discount_received'): ?>
                                  (discount received)
                              <?php endif ?>

                               
                        </td>
                        <td><?= $pmt['reference_id']; ?></td>
                        <td><?= get_group_data($pmt['type'],'group_head'); ?></td> 
                         
                        <td><?= get_date_format($pmt['datetime'],'d M Y'); ?></td> 
                        <td>
                            <?php if ($pmt['voucher_id']>0): ?>
                                <a class="href_loader aitsun_link" href="<?php echo base_url('voucher_entries/details') ?>/<?= $pmt['voucher_id']; ?>">
                                    View full
                                </a>
                            <?php endif ?> 
                        </td>
                        <td>
                            <?php if ($pmt['bill_type']=='sales' || $pmt['bill_type']=='proforma_invoice' || $pmt['bill_type']=='purchase' || $pmt['bill_type']=='purchase_return' || $pmt['bill_type']=='sales_return' || $pmt['bill_type']=='discount_received' || $pmt['bill_type']=='discount_allowed'): ?> 

                                    <?php if ($pmt['fees_id']>0): ?>
                                        <a href="<?= base_url('fees_and_payments/view_challan'); ?>/<?= $pmt['invoice_id']; ?>">
                                    <?php else: ?>  
                                        <a href="<?= base_url('invoices/details'); ?>/<?= $pmt['invoice_id']; ?>">
                                    <?php endif ?>  
                                          <?= inventory_prefix(company($user['id']),$pmt['bill_type']); ?><?= serial(company($user['id']),$pmt['invoice_id']); ?>                                  
                                        </a>
                                    <?php endif ?>
                        </td>
                        <td class="text-end">
                            <?php if ($pmt['bill_type']=='expense' || $pmt['bill_type']=='purchase'|| $pmt['bill_type']=='discount_allowed' || $pmt['bill_type']=='sales_return'): ?>
                               <span class="my-auto text-danger"><?= aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?></span>
                               <?php $total_debit+=aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?> 
                        </td> 
                        <td class="text-end">
                            <?php if($pmt['bill_type']=='receipt' || $pmt['bill_type']=='sales' || $pmt['bill_type']=='proforma_invoice' || $pmt['bill_type']=='purchase_return' || $pmt['bill_type']=='discount_received'): ?>
                              <span class="my-auto text-success"><?= aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?></span>
                              <?php $total_credit+=aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                        </td> 
                        <td><?= $pmt['payment_note'] ?></td> 
                        <td data-tableexport-display="none">
                            <?php if ($pmt['bill_type']!='sales' && $pmt['bill_type']!='sales_return' && $pmt['bill_type']!='purchase_return' && $pmt['bill_type']!='purchase'): ?>
                                            
 
                                    <a class="text-primary" href="<?php echo base_url('voucher_entries/edit') ?>/<?= $pmt['voucher_id']; ?>">
                                        <i class="bx bxs-pencil"></i>
                                    </a>

                                    <a data-url="<?= base_url('payments/delete'); ?>/<?= $pmt['id']; ?>" class="ms-2 text-danger delete_payment"><i class="bx bxs-trash"></i></a>

                            <?php endif ?>
                        </td> 
                    </tr>
                <?php endforeach ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="10">
                            <span class="text-danger">No entries</span>
                        </td>
                    </tr>
                <?php endif ?> 
              </tbody>
              <tfoot>
                <tr>
                    <td colspan="7"><b>Total</b></td>
                    <td class="text-end"><b><?= aitsun_round($total_debit,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                    <td class="text-end"><b><?= aitsun_round($total_credit,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                    <td colspan="2"></td>
                </tr>
              </tfoot>
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
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 