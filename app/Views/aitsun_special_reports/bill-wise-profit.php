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
                    <b class="page_heading text-dark">Profit on sale invoices</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#bill_wise_profit_table" data-filename="Profit on sale invoices Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#bill_wise_profit_table" data-filename="Profit on sale invoices Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#bill_wise_profit_table" data-filename="Profit on sale invoices Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#bill_wise_profit_table"> 
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
                <select name="customer" class=" filter-control w-100" style="width:150px;">
                    <option value="">Search party</option> 
                    <?php foreach (crm_customer_array(company($user['id'])) as $cr): ?>
                         <option value="<?= $cr['id'] ?>"><?= user_name($cr['id']) ?></option>
                    <?php endforeach ?>
                   
                    </select>

              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('special_reports/bill-wise-profit') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">
        <div class="aitsun_table w-100 pt-0">

            <table id="bill_wise_profit_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th colspan="7" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Invoice No'); ?> </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Party Name'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Total Sale Amount'); ?> </th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Profit (+)/Loss(-)'); ?> </th> 
                        <th class="sorticon" data-tableexport-display="none"><?= langg(get_setting(company($user['id']),'language'),'Details'); ?></th> 
                    </tr>
                 </thead>

                   <tbody>
                <?php  $data_count=0; ?>
                    <?php $debit_sum=0; $totalpl=0; $total_amount=0; foreach ($day_book_data as $db) { $data_count++; ?>
                        <tr <?php if ($db['deleted']!=0): ?>style="background: #ff000040; opacity: 0.7;" data-tableexport-display="none" <?php endif ?>>
                          
                          <td> <?= get_date_format($db['invoice_date'],'d M Y'); ?></td>

                          <td> 
                            
                            <a href="<?php if ($db['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $db['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>" class="aitsun_link <?php if ($db['deleted']==0): ?>href_loader<?php endif ?>" <?php if ($db['deleted']!=0): ?>onclick="popup_message('error','Failed','This is deleted, You cannot open this!');"<?php endif; ?>>
                                #<?= inventory_prefix(company($user['id']),$db['invoice_type']); ?><?= $db['serial_no']; ?></a>
                            <?php if ($db['deleted']==4): ?>
                                <small class="text-danger">(Cancelled)</small>
                            <?php endif ?>
                            <?php if ($db['deleted']==1): ?>
                                <small class="text-danger">(Deleted)</small>
                            <?php endif ?>


                          </td>
                          <td>
                                <a href="<?php if ($db['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $db['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>" class="aitsun_link <?php if ($db['deleted']==0): ?>href_loader<?php endif ?>" <?php if ($db['deleted']!=0): ?>onclick="popup_message('error','Failed','This is deleted, You cannot open this!');"<?php endif; ?>>

                                   <?php if ($db['customer']!='CASH'): ?>
                                    <?=  user_name($db['customer']); ?>
                                      
                                    <?php elseif ($db['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                    <?php elseif ($db['alternate_name']=='CASH CUSTOMER'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> 

                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $db['alternate_name']; ?> )
                                    <?php endif ?>

                                  </a>


                          </td>
                          <td class="text-right" <?php if ($db['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            
                             
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?> 

                            <?php if ($db['deleted']==0): ?>
                                <?php $total_amount+=aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                            
                            
                        </td>
                          <td>

                            <?php 
                                $totalProfitOrLoss = 0; 

                                foreach (invoice_items_array($db['id']) as $init): 
                                    $salePrice = $init['price'];
                                    $purchasePrice = $init['purchased_price'];

                                    $profitOrLoss = $salePrice - $purchasePrice;
                                    $totalProfitOrLoss += $profitOrLoss;
                                endforeach;

                                if ($totalProfitOrLoss > 0) {
                                    $colorClass = 'text-success'; 
                                } elseif ($totalProfitOrLoss < 0) {
                                    $colorClass = 'text-danger';
                                } else {
                                    $colorClass = ''; 
                                }

                                if ($totalProfitOrLoss < 0) {
                                    echo "<p class='$colorClass mb-0'>- " . currency_symbol(company($user['id'])) . aitsun_round(abs($totalProfitOrLoss),get_setting(company($user['id']),'round_of_value')) . "</p>";
                                } else {
                                    echo "<p class='$colorClass mb-0'>" . currency_symbol(company($user['id'])) . aitsun_round($totalProfitOrLoss,get_setting(company($user['id']),'round_of_value')) . "</p>";
                                }
                                $totalpl+= $totalProfitOrLoss
                                ?>
                          </td>

 



                          <td data-tableexport-display="none" <?php if ($db['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                           <a data-bs-toggle="modal" data-bs-target="#detail_view<?= $db['id'] ?>"><i class="bx bxs-show" style="font-size: 16px;color: mediumblue;"></i></a>

                           <div class="modal fade" id="detail_view<?= $db['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staff_editLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staff_editLabel">Invoice #<?= inventory_prefix(company($user['id']),$db['invoice_type']); ?><?= $db['serial_no']; ?> - 

                                    <?php if ($db['customer']!='CASH'): ?>
                                    <?=  user_name($db['customer']); ?>
                                      
                                    <?php elseif ($db['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                    <?php elseif ($db['alternate_name']=='CASH CUSTOMER'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> 

                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $db['alternate_name']; ?> )
                                    <?php endif ?>
                                        
                                    </h5>    
                                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div>
                                        <h6 style="font-size:14px;">Cost Calculation</h6>
                                        <div class="pb-3">
                                            <table>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Purchase Price</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                                <?php $total_sub_item_cost=0; foreach (invoice_items_array($db['id']) as $intp): ?>
                                                    <tr>
                                                        <td style="width:140px;"><?= $intp['product']; ?></td>
                                                        <td><?= $intp['quantity']; ?></td>
                                                        <td><?= currency_symbol(company($user['id'])); ?> <?= $intp['purchased_price']; ?></td>
                                                        <td><?= currency_symbol(company($user['id'])); ?> <?= $intp['purchased_price']; ?>
                                                            <?php $total_sub_item_cost+=aitsun_round($intp['purchased_price'],get_setting(company($user['id']),'round_of_value')); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                                
                                            </table>
                                        </div>
                                    </div>
                                   <div class="d-flex justify-content-between">
                                       <p class="mb-1">Sale Amount</p>
                                       <p class="mb-1"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?> </p>
                                   </div>
                                   <div class="d-flex justify-content-between">
                                       <p class="mb-1">Total Cost</p>
                                       <p class="mb-1"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_sub_item_cost,get_setting(company($user['id']),'round_of_value')); ?></p>
                                   </div>
                                   <div class="d-flex justify-content-between">
                                       <p class="mb-1">Tax Payable</p>
                                       <p class="mb-1"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['tax'],get_setting(company($user['id']),'round_of_value')); ?></p>
                                   </div>
                                   <div class="d-flex justify-content-between border-top pt-1 border-bottom mb-2">
                                       <p class="mb-1">Profit (Sale Amount - Total Cost - Tax Payable)</p>
                                       
                                         <?php  if ($totalProfitOrLoss < 0) {
                                            echo "<p class='$colorClass mb-1'>- " . currency_symbol(company($user['id'])) . aitsun_round(abs($totalProfitOrLoss),get_setting(company($user['id']),'round_of_value')) . "</p>";
                                        } else {
                                            echo "<p class='$colorClass mb-1'>" . currency_symbol(company($user['id'])) . aitsun_round($totalProfitOrLoss,get_setting(company($user['id']),'round_of_value')) . "</p>";
                                        } ?>
                                      
                                   </div>
                                   <div class="d-flex justify-content-between">
                                       <p class="mb-1">Profit (Excluding Additional Charges)</p>
                                       <?php  if ($totalProfitOrLoss < 0) {
                                            echo "<p class='$colorClass mb-1'>- " . currency_symbol(company($user['id'])) . aitsun_round(abs($totalProfitOrLoss),get_setting(company($user['id']),'round_of_value')) . "</p>";
                                        } else {
                                            echo "<p class='$colorClass mb-1'>" . currency_symbol(company($user['id'])) . aitsun_round($totalProfitOrLoss,get_setting(company($user['id']),'round_of_value')) . "</p>";
                                        } ?>
                                   </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                          </td>

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
                        <th colspan="3"><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th class="text-right">
                            <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                        <th class="text-right">
                            <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($totalpl,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                        <th class="text-right">
                          
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

