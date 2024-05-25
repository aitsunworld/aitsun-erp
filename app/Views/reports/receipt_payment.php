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
                    <b class="page_heading text-dark">Receipt and Payment</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#receipt_payment_table" data-filename="Receipts and Payments <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#receipt_payment_table" data-filename="Receipts and Payments <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#receipt_payment_table" data-filename="Receipts and Payments <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// FILTER ///////////////////////// -->
    <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
              
            <form method="get" class="d-flex" action="<?= base_url('reports/receipt_payment') ?>">
                <?= csrf_field(); ?>
               
                    <input type="date" name="from" class="filter-control form-control" placeholder="">
                  

                  
                    <input type="date" name="to" class="filter-control form-control" placeholder="">
                  

                  
                    <select name="collected_user" class="form-control">
                     <option value="">Select user</option>
                     <?php foreach (staffs_array(company($user['id'])) as $stf): ?>
                         <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                     <?php endforeach ?>
                    </select>
              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('reports/receipt_payment') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="receipt_payment_table" class="erp_table" >
                <thead>
                    <tr>
                        <th colspan="2" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr>
                        <td align="center"><b>Receipts</b></td>
                        <td align="center"><b>Payments</b></td>
                    </tr>
                </thead>

                <?php 
                    $total_receipt=0;
                    $total_payment=0;
                ?>

                <tbody>
                    <tr>
                        <td> 
                            <ul style="width: 100%; margin: 0; padding:0;">
                                <?php foreach (bank_accounts_of_account(company($user['id'])) as $bd): ?>
                                <li class="span_tr">
                                    <span>By Opening <?= $bd['group_head'] ?></span>
                                    <span align="right"><?= number_format(balance(company($user['id']),$bd['id'],'opening_balance'),get_setting(company($user['id']),'round_of_value')) ?></span>
                                </li>
                                <?php $total_receipt+=balance(company($user['id']),$bd['id'],'opening_balance'); ?>  
                                 <?php endforeach ?>


                                <?php foreach ($all_receipts as $ar): ?> 
                                    <li class="span_tr">
                                        <span>
                                            By
                                            <?php if ($ar['bill_type']=='receipt' || $ar['bill_type']=='payment'): ?>
                                              <?= bill_type_for_daybook(get_group_data($ar['account_name'],'group_head')); ?>
                                            <?php elseif ($ar['bill_type']=='sales' || $ar['bill_type']=='proforma_invoice' || $ar['bill_type']=='purchase' || $ar['bill_type']=='sales_return' || $ar['bill_type']=='purchase_return'): ?>

                                                <?php if ($ar['bill_type']=='sales'): ?>
                                                  <?= user_name(invoice_data($ar['invoice_id'],'customer')); ?> 

                                                 <?php if (!empty($ar['alternate_name'])): ?>
                                                     <!-- (<= $ar['alternate_name'] ?>) -->
                                                 <?php endif ?>
                                             <?php elseif($ar['bill_type']=='proforma_invoice'): ?>
                                                Proforma Invoice
                                                <?php elseif($ar['bill_type']=='purchase'): ?>
                                                Purchase
                                                <?php elseif($ar['bill_type']=='sales_return'): ?>
                                                Sales Return
                                                <?php elseif($ar['bill_type']=='purchase_return'): ?>
                                                Purchase Return
                                              <?php endif ?>

                                             <?php else: ?>
                                                 <?= get_group_data($ar['account_name'],'group_head'); ?>
                                            <?php endif ?>
                                        </span>
                                        <span align="right"><?= number_format($ar['amount'],get_setting(company($user['id']),'round_of_value')) ?></span>
                                    </li> 
                                    <?php $total_receipt+=$ar['amount']; ?>                                  
                                <?php endforeach ?>
                            </ul>  
                           
                        </td>

                        <td valign="baseline">


                            <ul style="width: 100%; padding: 0;">
                                <?php foreach ($all_payments as $ap): ?>
                                <li class="span_tr">
                                    <span>
                                        To
                                        <?php if ($ap['bill_type']=='receipt' || $ap['bill_type']=='payment'): ?>
                                          <?= bill_type_for_daybook(get_group_data($ap['account_name'],'group_head')); ?>
                                        <?php elseif ($ap['bill_type']=='sales' || $ap['bill_type']=='purchase' || $ap['bill_type']=='sales_return' || $ap['bill_type']=='purchase_return'): ?>

                                            <?php if ($ap['bill_type']=='sales'): ?>
                                             <?= user_name(invoice_data($ap['invoice_id'],'customer')); ?>
                                             <?php if (!empty($ap['alternate_name'])): ?>
                                                 <!-- (<= $ap['alternate_name'] ?>) -->
                                             <?php endif ?>
                                            <?php elseif($ar['bill_type']=='proforma_invoice'): ?>
                                                Proforma Invoice
                                            <?php elseif($ap['bill_type']=='purchase'): ?>
                                            Purchase
                                            <?php elseif($ap['bill_type']=='sales_return'): ?>
                                            Sales Return
                                            <?php elseif($ap['bill_type']=='purchase_return'): ?>
                                            Purchase Return
                                          <?php endif ?>

                                         <?php else: ?>
                                             <?= get_group_data($ap['account_name'],'group_head'); ?>
                                        <?php endif ?>
                                    </span>
                                    <span align="right">
                                        <?= number_format($ap['amount'],get_setting(company($user['id']),'round_of_value')) ?>
                                    </span>
                                </li>
                                <?php $total_payment+=$ap['amount']; ?>
                                <?php endforeach ?>
                            </ul> 


                        </td>

                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                    
                        <td class="footth" align="right" colspan="" width="100">
                            <b><?= currency_symbol(company($user['id'])) ?> <?= number_format($total_receipt,get_setting(company($user['id']),'round_of_value')); ?></b>
                        </td>
                        
                        <td class="footth" align="right" colspan="" width="100">
                            <b><?= currency_symbol(company($user['id'])) ?> <?= number_format($total_payment,get_setting(company($user['id']),'round_of_value')); ?></b>
                        </td>
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

