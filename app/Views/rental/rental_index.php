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
                    <b class="page_heading text-dark">Rental</b>
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
    <div class="d-flex">
          
        <a href="<?= base_url('rental') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-home"></i> <span class="my-auto">Orders</span></a>

        <a href="<?= base_url('products') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-package"></i> <span class="my-auto">Products</span></a>

        <!-- <a href="<= base_url('rental/periods') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-time"></i> <span class="my-auto">Rental periods</span></a> -->
 
        
        
       <!--  <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-file"></i> Reports
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<= base_url('appointments/reports') ?>">
                    <span>Booking reports</span>
                </a>
              <a class="dropdown-item href_loader" href="#">
                    <span>Person wise</span>
                </a>
                <a class="dropdown-item href_loader" href="#">
                    <span>Resource wise</span>
                </a> 
            </div>
        </div>  -->
 
 

    </div>

    <a href="<?= base_url('invoices/create_sales_quotation') ?>?invoice_for=rental" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New rental</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
  
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">  
        <div class="col-md-2">
            <div class="rental_fiters mt-4">
                <h6><i class="bx bx-refresh"></i> Rental status</h6>
                <ul>
                    <li><a class="href_loader" href="<?= base_url('rental') ?>">All <b>(<?= get_total_rental(company($user['id']),'') ?>)</b></a></li>
                    <li><a class="href_loader" href="<?= base_url('rental') ?>?status=0">Quotation <b>(<?= get_total_rental(company($user['id']),0) ?>)</b></a></li>
                    <li><a class="href_loader" href="<?= base_url('rental') ?>?status=1">Reserved <b>(<?= get_total_rental(company($user['id']),1) ?>)</b></a></li>
                    <li><a class="href_loader" href="<?= base_url('rental') ?>?status=2">Picked Up <b>(<?= get_total_rental(company($user['id']),2) ?>)</b></a></li>
                    <li><a class="href_loader" href="<?= base_url('rental') ?>?status=3">Returned <b>(<?= get_total_rental(company($user['id']),3) ?>)</b></a></li>
                </ul>
                <!-- <h6><i class="bx bx-refresh"></i> Invoice status</h6>
                <ul>
                    <li><a class="href_loader" href="<= base_url('rental') ?>?invoice_status=1">All <b>(<= get_total_rental_invoices(company($user['id']),0) ?>)</b></a></li>
                    <li><a class="href_loader" href="<= base_url('rental') ?>?invoice_status=1">To Invoice <b>(<= get_total_rental_invoices(company($user['id']),0) ?>)</b></a></li>
                </ul> -->
            </div>
        </div>
        <div class="col-md-10">
            
            <div class="mt-4 ms-3 aitsun_table">
                <div class="my-auto">
                    <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#rental_table" data-filename="Rental data - <?= get_date_format(now_time($user['id']),'d M Y') ?>"> 
                        <span class="my-auto">Excel</span>
                    </a>
                    <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#rental_table" data-filename="Rental data - <?= get_date_format(now_time($user['id']),'d M Y') ?>"> 
                        <span class="my-auto">CSV</span>
                    </a>
                    <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#rental_table" data-filename="Rental data - <?= get_date_format(now_time($user['id']),'d M Y') ?>"> 
                        <span class="my-auto">PDF</span>
                    </a>
                   
                    <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#rental_table"> 
                        <span class="my-auto">Quick search</span>
                    </a> 

                </div>
            <table id="rental_table" class=" erp_table sortable">
                <thead>
                    <tr>
                        <th class="sorticon">No.</th>
                        <th class="sorticon">Party</th> 
                        <th class="sorticon">Amount</th> 
                        <th class="sorticon">Paid</th>
                        <th class="sorticon">Due</th>
                        <th class="sorticon text-center">Rental date</th>  
                        <th class="sorticon text-center">Duration</th>  
                        <th class="sorticon text-center">Bill</th>  
                        <th class="sorticon">Status</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $icount=0; $total_amount=0; $total_paid_amount=0; $total_due_amount=0; foreach ($all_rentals as $di): ?> 
                        <tr>
                            <td>
                                <a href="<?php if ($di['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $di['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>" class="aitsun_link <?php if ($di['deleted']==0): ?>href_loader<?php endif ?>" <?php if ($di['deleted']!=0): ?>onclick="popup_message('error','Failed','This is deleted, You cannot open this!');"<?php endif; ?>>
                                    #<?= inventory_prefix(company($user['id']),$di['invoice_type']); ?><?= $di['serial_no']; ?></a>
                                <?php if ($di['deleted']==4): ?>
                                    <small class="text-danger">(Cancelled)</small>
                                <?php endif ?>
                                <?php if ($di['deleted']==1): ?>
                                    <small class="text-danger">(Deleted)</small>
                                <?php endif ?>
                            </td>
                            <td>
                                <a href="<?php if ($di['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $di['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>" class="aitsun_link <?php if ($di['deleted']==0): ?>href_loader<?php endif ?>" <?php if ($di['deleted']!=0): ?>onclick="popup_message('error','Failed','This is deleted, You cannot open this!');"<?php endif; ?>>

                                   <?php if ($di['customer']!='CASH'): ?>
                                    <?=  user_name($di['customer']); ?>
                                      
                                    <?php elseif ($di['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                    <?php elseif ($di['alternate_name']=='CASH CUSTOMER'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> 

                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $di['alternate_name']; ?> )
                                    <?php endif ?>

                                  </a>
                            </td> 
                            <td class="text-end">
                                <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?> 

                            <?php if ($di['deleted']==0): ?>
                                <?php $total_amount+=aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>

                            </td> 
                            <td class="text-right text-success" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>

                                <?php if ($di['converted_id']>0): ?>
                                    <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round(invoice_data($di['converted_id'],'paid_amount'),get_setting(company($user['id']),'round_of_value')); ?> 
                                    <?php if ($di['deleted']==0): ?>
                                        <?php $total_paid_amount+=aitsun_round($di['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                    <?php endif ?>
                                <?php endif ?> 
                                
                                
                            </td>

                            <td class="text-right text-danger" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>

                                 <?php if ($di['converted_id']>0): ?>
                                    <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round(invoice_data($di['converted_id'],'due_amount'),get_setting(company($user['id']),'round_of_value')); ?> 
                                    <?php if ($di['deleted']==0): ?>
                                        <?php $total_due_amount+=aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                    <?php endif ?>
                                <?php endif ?> 

                             
                            </td>
                            <td class="text-center">
                                <?= get_date_format($di['rent_from'],'d M Y h:i A') ?>
                             -
                                <?= get_date_format($di['rent_to'],'d M Y h:i A') ?>
                            </td> 
                            <td class="text-center">
                                <span class="badge bg-dark px-3 py-1" style="font-weight: 400; font-size: 10px;"><?= (!empty($di['rental_duration']))?duration_in_days($di['rental_duration']):''; ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($di['converted_id']>0): ?> 
                                    <a href="<?= base_url('invoices/details') ?>/<?= $di['converted_id'] ?>" class="text-success">View invoice</a>
                                <?php else: ?>
                                    <?php if ($di['invoice_type']=='sales_quotation'): ?>
                                            <a href="<?= base_url('invoices/convert_to_sale'); ?>/<?= $di['id']; ?>" class="aitsun_link href_loader btn-sm">
                                                    Make bill
                                            </a>
                                    <?php endif ?>
                                <?php endif; ?>
                                
                            </td>
                            <td class="">
                                <?php if ($di['rental_status']==0): ?> 
                                    <span class="badge bg-light text-dark">Quotation</span>
                                <?php elseif ($di['rental_status']==1): ?>
                                    <span class="badge bg-primary text-white">Reserved</span>
                                <?php elseif ($di['rental_status']==2): ?>
                                    <span class="badge bg-warning text-dark">Picked Up</span>
                                <?php elseif ($di['rental_status']==3): ?>
                                    <span class="badge bg-success text-white">Returned</span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>  
                            </td> 
                        </tr>
                    <?php endforeach ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-end"><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                        <td class="text-success"><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_paid_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                    <td class="text-danger"><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
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
      <!-- <= $pager->links() ?> -->
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 