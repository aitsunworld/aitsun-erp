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
                    <b class="page_heading text-dark">Sales Report</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#daybook_table" data-filename="Sales Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#daybook_table" data-filename="Sales Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#daybook_table" data-filename="Sales Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#daybook_table"> 
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
              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('sales_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="daybook_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th colspan="7" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Invoice No'); ?>. </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Customer'); ?> </th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Credit'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></th> 
                 </thead>
                 <tbody>
                    <?php  $data_count=0; ?>
                    <?php foreach ($day_book_data as $db) { $data_count++; ?>
                        <?php if (invoice_data($db['invoice_id'],'invoice_type')=='challan'): ?>
                        <?php else: ?>
                        <tr>
                          <td><?= get_date_format($db['datetime'],'d-m-Y'); ?></td>
                          <td>
                            <a href="<?php echo base_url('payments/details'); ?>/<?= $db['id']; ?>"class="aitsun_link mr-2 href_loader">
                                <?php if ($db['bill_type']=='sales' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return' || $db['bill_type']=='purchase_return'): ?>
                                      <?= inventory_prefix(company($user['id']),invoice_data($db['invoice_id'],'invoice_type')); ?> 
                                      <?= serial(company($user['id']),$db['invoice_id']); ?>
                                    <?php elseif($db['bill_type']=='receipt' || $db['bill_type']=='payment' || $db['bill_type']=='expense'): ?>
                                      <?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $db['id']; ?>
                                    <?php else: ?>
                                      <?= $db['id']; ?>
                                  <?php endif ?>
                            </a>
                          </td>
                          <td>
                            <?php if ($db['bill_type']=='receipt' || $db['bill_type']=='payment'): ?>
                              <?= bill_type_for_daybook(account_name($db['account_name'])); ?>
                            <?php elseif ($db['bill_type']=='sales' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return' || $db['bill_type']=='purchase_return'): ?>

                                <?php if ($db['bill_type']=='sales'): ?>
                                 Sales
                                <?php elseif($db['bill_type']=='purchase'): ?>
                                Purchase
                                <?php elseif($db['bill_type']=='sales_return'): ?>
                                Sales Return
                                <?php elseif($db['bill_type']=='purchase_return'): ?>
                                Purchase Return
                              <?php endif ?>

                             <?php else: ?>
                                 <?= $db['bill_type']; ?>
                            <?php endif ?>
                            
                          </td>
                          <td>
                            <?php if (invoice_data($db['invoice_id'],'customer')=='CASH'): ?>
                                <?php if (!empty(invoice_data($db['invoice_id'],'alternate_name'))): ?>
                                    <?= invoice_data($db['invoice_id'],'alternate_name'); ?>
                                <?php else: ?>
                                    Cash Customer
                                <?php endif ?>
                            <?php else: ?>
                                <?= user_name(invoice_data($db['invoice_id'],'customer')); ?>
                            <?php endif ?>
                            
                          </td>
                          <td class="text-right">
                            <?php if ($db['bill_type']=='expense' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>
                          <td class="text-right">
                            <?php if ($db['bill_type']=='receipt' || $db['bill_type']=='sales' || $db['bill_type']=='purchase_return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php else: ?>
                              ---
                              <?php endif ?>
                          </td>
                          <td style="max-width: 100px; font-size: 12px;"><?= $db['payment_note']; ?></td>
                      </tr>
                      <?php endif ?>
                      

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
                        <th colspan="3"></th>
                        <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th class="text-right">
                          <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($debit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                        <th class="text-right">
                          <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($credit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                        <th></th>
                        
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

