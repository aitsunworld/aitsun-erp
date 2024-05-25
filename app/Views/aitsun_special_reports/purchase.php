<!-- ////////////////////////// TOP BAR START ///////////////////////// -->

<?php

    $report_date=get_date_format(now_time($user['id']),'d M Y');
    if ($_GET) {
         if (isset($_GET['from'])) {
             $from=$_GET['from'];
        }

        if (isset($_GET['to'])) {
             $dto=$_GET['to'];
        }

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
                    <b class="page_heading text-dark">Purchase Report</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#purchase_table" data-filename="Purchase Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#purchase_table" data-filename="Purchase Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#purchase_table" data-filename="Purchase Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#purchase_table"> 
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
                     <option value="purchase">Purchase</option>
                     <option value="purchase_return">Purchase Return</option>

                </select>

              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('special_reports/purchase') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">
        <div class="aitsun_table w-100 pt-0">

            <table id="purchase_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th colspan="7" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Invoice No'); ?> </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Party Name'); ?> </th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Transaction Type'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Balance Due'); ?></th> 
                    </tr>
                 </thead>
                 <tbody>
                    <?php  $data_count=0; $total_amount=0; $total_due_amount=0; ?>
                    <?php foreach ($day_book_data as $db) { $data_count++; ?>
                        <?php if ($db['invoice_type']=='challan'): ?>
                        <?php else: ?>
                        <tr>
                          <td><?= get_date_format($db['invoice_date'],'d-m-Y'); ?></td>
                          <td> 
                            <a href="<?php if ($db['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $db['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>">
                            <?php if ($db['invoice_type']=='sales' || $db['invoice_type']=='purchase' || $db['invoice_type']=='sales_return' || $db['invoice_type']=='purchase_return'): ?>
                                  <?= inventory_prefix(company($user['id']),$db['invoice_type']); ?> 
                                  <?= serial(company($user['id']),$db['id']); ?>
                                <?php elseif($db['invoice_type']=='receipt' || $db['invoice_type']=='payment' || $db['invoice_type']=='expense'): ?>
                                  <?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $db['id']; ?>
                                <?php else: ?>
                                  <?= $db['id']; ?>
                              <?php endif ?>
                              </a>
                             
                          </td>
                          <td>
                            <?php if ($db['customer']=='CASH'): ?>
                                <?php if (!empty($db['alternate_name'])): ?>
                                    <?= $db['alternate_name']; ?>
                                <?php else: ?>
                                    Cash Customer
                                <?php endif ?>
                            <?php else: ?>
                                <?= user_name($db['customer']); ?>
                            <?php endif ?>
                            
                          </td>
                          <td>
                            <?php if ($db['invoice_type']=='receipt' || $db['invoice_type']=='payment'): ?>
                              <?= invoice_type_for_daybook(account_name($db['account_name'])); ?>
                            <?php elseif ($db['invoice_type']=='sales' || $db['invoice_type']=='purchase' || $db['invoice_type']=='sales_return' || $db['invoice_type']=='purchase_return'): ?>

                                <?php if ($db['invoice_type']=='sales'): ?>
                                 Sales
                                <?php elseif($db['invoice_type']=='purchase'): ?>
                                Purchase
                                <?php elseif($db['invoice_type']=='sales_return'): ?>
                                Sales Return
                                <?php elseif($db['invoice_type']=='purchase_return'): ?>
                                Purchase Return
                              <?php endif ?>

                             <?php else: ?>
                                 <?= $db['invoice_type']; ?>
                            <?php endif ?>
                            
                          </td>

                          <td> 
                             <?= mode_of_payment($db['company_id'],$db['id']) ?> 
                          </td>
                          
                          <td class="text-end">
                             
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?> 

                            <?php if ($db['deleted']==0): ?>
                                <?php $total_amount+=aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                            
                          </td>
                          <td class="text-end">


                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php if ($db['deleted']==0): ?>
                                <?php $total_due_amount+=aitsun_round($db['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                          </td>
                          
                      </tr>
                      <?php endif ?>
                      

                      <?php } ?>
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="7">
                                <span class="text-danger">No Data</span>
                            </td>
                        </tr>
                    <?php endif ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4"></th>
                        <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th class="text-end">
                          <strong> <?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')) ?></strong>
                        </th>
                        <th class="text-end">
                          <strong><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')) ?></b></strong>
                        </th>
                        
                        
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

