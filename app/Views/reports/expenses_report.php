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

                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Expense Report</b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#expense_report_table" data-filename="Expense Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#expense_report_table" data-filename="Expense Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#expense_report_table"> 
            <span class="my-auto">Quick search</span>
        </a>
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

   <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="date" name="from" placeholder="" class="form-control form-control-sm filter-control ">
                      <input type="date" name="to" placeholder="" class="form-control form-control-sm filter-control ">

                        <select name="collected_user" class="form-control form-control-sm filter-contro">
                         <option value="">Select user</option>
                         <?php foreach (staffs_array(company($user['id'])) as $stf): ?>
                             <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                         <?php endforeach ?>
                        </select> 
                       

                        <div class="aitsun_select position-relative" style="min-width:250px;">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/accounts'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" name="accounts">
                                <option value="">Search account</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('expense_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="expense_report_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th colspan="7" class="text-center" >
                        
                       <?= $report_date; ?>

                    </th>
                </tr>
                <tr> 
                  <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                  <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Voucher No'); ?>.</th>
                  <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></th>
                  <th class="text-right sorticon"><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></th>
                  <th class="text-right sorticon"><?= langg(get_setting(company($user['id']),'language'),'Credit'); ?></th>
                  <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></th>
                  <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Added by'); ?></th>

                </tr>
             
             </thead>
              <tbody>

                <?php  $data_count=0; ?>
                    <?php $debit_sum=0; $credit_sum=0; foreach ($day_book_data as $db) { $data_count++; ?>
                        <tr> 
                          <td><?= get_date_format($db['datetime'],'d-m-Y'); ?></td>
                          <td>

                            <a href="<?= base_url('payments/details'); ?>/<?= $db['id']; ?>" class=" mr-2">
                                <?= get_setting(company($user['id']),'payment_prefix'); ?><?= $db['serial_no']; ?>
                              </a>

                            <?php if (invoice_data($db['invoice_id'],'invoice_type')=='challan'): ?>
                              <?php if ($db['invoice_id']!=0): ?>
                                <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $db['invoice_id']; ?>" class=" mr-2">
                                   (<?= inventory_prefix(company($user['id']),invoice_data($db['invoice_id'],'invoice_type')) ?><?= invoice_data($db['invoice_id'],'serial_no') ?>)
                               </a>
                              <?php endif ?>
                            <?php else: ?> 

                                <?php if ($db['invoice_id']!=0): ?>
                                <a href="<?php echo base_url('invoices/details'); ?>/<?= $db['invoice_id']; ?>" class=" mr-2">
                                   (<?= inventory_prefix(company($user['id']),invoice_data($db['invoice_id'],'invoice_type')) ?><?= invoice_data($db['invoice_id'],'serial_no') ?>)
                               </a>

                               <?php endif ?>
                            <?php endif ?>

                            
                          </td>
                          <td>
                            <?= $db['group_head']; ?> 
                          </td>
                          <td class="text-right">
                            <?php if ($db['bill_type']=='expense' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return'): ?>
                                <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                <?php $credit_sum+=$db['amount']; ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>
                          <td class="text-right">
                            <?php if ($db['bill_type']=='receipt' || $db['bill_type']=='sales' || $db['bill_type']=='purchase_return'): ?>
                                <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                 <?php $debit_sum+=$db['amount']; ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>
                          <td style="max-width: 100px; font-size: 12px;"><?= $db['payment_note']; ?></td>
                          <td><?= user_name($db['collected_by']); ?></td>
                      </tr>
                  <?php }  ?> 
                  
                      

                      <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="7">
                                <span class="text-danger">No Reports</span>
                            </td>
                        </tr>
                    <?php endif ?> 
 
              </tbody>
              <tfoot>
                <tr>
                    <th colspan="2"></th>
                    <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                    
                    <th class="text-right">
                      <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($credit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                    </th> 
                    <th class="text-right">
                      <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($debit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                    </th>
                    
                </tr>
            </tfoot>
              
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->