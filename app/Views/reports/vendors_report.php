<!-- ////////////////////////// TOP BAR START ///////////////////////// -->

 <?php

    $report_date=get_date_format(now_time($user['id']),'d M Y');
   if ($_GET) {
        $from=$_GET['from'];
        $dto=$_GET['to'];

        if (!empty($from) && empty($dto)) {
            $report_date=get_date_format($from,'l').' - '.get_date_format($from,'d M Y');
        }
        if (!empty($dto) && empty($from)) {
            $report_date=get_date_format($dto,'l').' - '.get_date_format($dto,'d M Y');
        }
        if (!empty($dto) && !empty($from)) {
            $report_date='From - '.get_date_format($from,'d M Y').'&nbsp; &nbsp; To - '.get_date_format($dto,'d M Y');
        }

     }else{
        $report_date='Today - '.get_date_format(now_time($user['id']),'d M Y');
     }
?>



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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Vendors Report</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#vendors_table" data-filename="Day book <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#vendors_table" data-filename="Day book - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#vendors_table" data-filename="Day book - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#vendors_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// FILTER ///////////////////////// -->
    <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
              
            <form method="get" class="d-flex">
                <?= csrf_field(); ?>
               <input type="date" name="from" class="form-control form-control-sm filter-control" title="From" placeholder="">
                <input type="date" name="to" title="To" class="form-control form-control-sm filter-control" placeholder="">

                <select name="type" class="form-select">
                 <option value="">Select</option>
                     <option value="expense">Expense</option>
                     <option value="purchase">Purchase</option>

                </select>

                <select name="customers" class="form-select">
                 <option value="">Select user</option>
                
<option value="CASH">CASH CUSTOMER</option>
                 <?php foreach (vendors_array(company($user['id'])) as $stf): ?>
                     <option value="<?= $stf['id']; ?>"><?= $stf['display_name']; ?></option>
                 <?php endforeach ?>
                </select>
              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('reports/vendors_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="vendors_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th colspan="8" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr>
                        
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Voucher No'); ?>. </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Customer'); ?>. </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Paid'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Due'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></th>  
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Added By'); ?></th> 
                    </tr>
                 </thead>
                 <tbody>
                <?php  $data_count=0; ?>
                    <?php $debit_sum=0; $credit_sum=0; $total_amount=0; $total_due_amount=0;  foreach ($vendors_data as $vd) { $data_count++; ?>
                        <tr>
                          
                          <td><?= get_date_format($vd['datetime'],'d-m-Y'); ?></td>

                          <td> 


                            <?php if ($vd['invoice_id']>0): ?>
                                
                            
                                    <?php if (invoice_data($vd['invoice_id'],'invoice_type')=='challan'): ?>

                                         <a href="<?php echo base_url('payments/details'); ?>/<?= $vd['id']; ?>" class="aitsun_link mr-2 href_loader">
                                            <?= get_setting(company($user['id']),'payment_prefix'); ?><?= $vd['serial_no']; ?>
                                          </a>
                                          <?php if ($vd['invoice_id']!=0): ?>
                                            <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $vd['invoice_id']; ?>" class="aitsun_link mr-2 href_loader">
                                               (<?= inventory_prefix(company($user['id']),invoice_data($vd['invoice_id'],'invoice_type')) ?><?= invoice_data($vd['invoice_id'],'serial_no') ?>)
                                           </a>
                                        <?php endif ?>


                                    <?php else: ?>

                                        <a href="<?php echo base_url('invoices/details'); ?>/<?= $vd['invoice_id']; ?>" class="aitsun_link mr-2 href_loader">

                                        <?php if ($vd['bill_type']=='sales' || $vd['bill_type']=='purchase' || $vd['bill_type']=='sales_return' || $vd['bill_type']=='purchase_return'): ?>

                                                <?= get_setting($user['company_id'],'invoice_prefix'); ?>

                                                <?php if ($vd['bill_type']=='sales'): ?>
                                                    <?= get_setting($user['company_id'],'sales_prefix'); ?>
                                                  <?php elseif($vd['bill_type']=='purchase'): ?>
                                                    <?= get_setting($user['company_id'],'purchase_prefix'); ?>
                                                    <?php elseif($vd['bill_type']=='sales_return'): ?>
                                                    <?= get_setting($user['company_id'],'sales_return_prefix'); ?>
                                                    <?php elseif($vd['bill_type']=='purchase_return'): ?>
                                                    <?= get_setting($user['company_id'],'purchase_return_prefix'); ?>
                                                  <?php endif ?>


                                                <?= serial(company($user['id']),$vd['invoice_id']); ?>

                                        <?php elseif($vd['bill_type']=='receipt' || $vd['bill_type']=='payment' || $vd['bill_type']=='expense'): ?>
                                        
                                                <?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $vd['id']; ?>
                                        <?php else: ?>
                                                  <?= $vd['id']; ?>
                                        <?php endif ?>
                                        </a>


                                  <?php endif ?>
                            <?php else: ?>
                                <a href="<?php echo base_url('payments/details'); ?>/<?= $vd['id']; ?>" class="aitsun_link mr-2 href_loader">
                                   <?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $vd['serial_no']; ?>
                               </a>
                            <?php endif ?>

                          </td>
                          



                          <td>
                                <?php if ($vd['bill_type']=='sales' || $vd['bill_type']=='purchase_return' || $vd['bill_type']=='purchase' || $vd['bill_type']=='sales_return'): ?>

                                    <?php if ($vd['customer']!='CASH'): ?>
                                    <?=  user_name($vd['customer']); ?>

                                    <?php elseif ($vd['alternate_name']!='CASH CUSTOMER'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $vd['alternate_name']; ?> )

                                    <?php elseif ($vd['alternate_name']=='CASH'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                    <?php else: ?>
                                        <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                    <?php endif ?>
                                  <?php else: ?>
                                  <?= get_group_data($vd['account_name'],'group_head'); ?>
                                  <?php endif ?>
                          </td>


                          <td class="text-right">
                            <?php if ($vd['bill_type']=='expense' || $vd['bill_type']=='purchase' || $vd['bill_type']=='sales_return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($vd['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                               <?php $debit_sum+=$vd['amount']; ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>

                           <td>
                                <?php if ($vd['bill_type']=='sales' || $vd['bill_type']=='sales_return' || $vd['bill_type']=='purchase' || $vd['bill_type']=='purchase_return'): ?> 
                                <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($vd['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                    <?php $total_due_amount+=aitsun_round($vd['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                <?php else: ?>
                                ---
                                <?php endif; ?>
                           </td>

                            <td> 
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($vd['total'],get_setting(company($user['id']),'round_of_value')); ?> <?php $total_amount+=aitsun_round($vd['total'],get_setting(company($user['id']),'round_of_value')); ?>
                           </td>


                           


                          <td style=" font-size: 12px;"><?= nl2br($vd['payment_note']); ?></td>
                           <td style=" font-size: 12px;"><?= user_name($vd['collected_by']); ?></td>
                      </tr>
                  

                    <?php } ?>
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="9">
                                <span class="text-danger">No Data</span>
                            </td>
                        </tr>
                    <?php endif ?>
                    
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th class="text-right">
                          <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($debit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                        <th class="text-right">
                          <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                        <th><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

