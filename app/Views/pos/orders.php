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
                    <a href="<?= base_url('pos'); ?>" class="href_loader">Point of Sale</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">
                        Orders
                    </b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#invoice_table" data-filename="Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#invoice_table" data-filename="Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#invoice_table" data-filename="Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
         
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#invoice_table"> 
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

                    <input type="text" name="invoice_no" class="filter-control w-100 text-ident form-control" placeholder="<?= get_setting(company($user['id']),'invoice_prefix'); ?><?= get_setting(company($user['id']),'sales_prefix'); ?>">
 
                    <select name="customer" class="salessel filter-control w-100" style="width:150px;">
                      <?php if ($view_type=='sales'){ ?>
                           <option value="">Customers</option>
                        <?php }else{ ?>
                          <option value="">Vendors</option>
                        <?php } ?>
                      
                        <option value="CASH">CASH CUSTOMER</option>
                        <?php if ($view_type=='sales'){ ?>
                            <?php foreach (customers_array(company($user['id'])) as $cs) { ?>
                                <option value="<?= $cs['id']; ?>"><?= $cs['display_name']; ?>-<?= $cs['phone']; ?></option>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php foreach (vendors_array(company($user['id'])) as $vs) { ?>
                                <option value="<?= $vs['id']; ?>"><?= $vs['display_name']; ?>-<?= $vs['phone']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
 
                    <input type="date" name="from" class="filter-control w-100" placeholder="From">
            
                    <input type="date" name="to" class="filter-control w-100" placeholder="To">
              

               

                   
                    <button class="href_long_loader btn-dark btn-sm">
                        <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
                    </button>
                     

                    <a class=" btn-outline-dark btn btn-sm" href="<?php if ($view_type=='sales'): ?><?= base_url('pos/orders') ?><?php else: ?><?= base_url('purchases/purchases') ?><?php endif ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                  
                  
                </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="invoice_table" class="erp_table sortable">
             <thead>
                <tr> 
                    <th class="sorticon">Session</th>
                    <th class="sorticon">Date</th>
                    <th>Point of sale</th>
                    <th>Receipt No.</th>
                    <th class="sorticon">Customer</th>
                    <th class="sorticon">Staff/Cashier</th>
                    <th class="sorticon">Total</th>
                    <th class="sorticon">Paid</th>
                    <th class="sorticon">Due</th>
                    <th class="sorticon">Status</th> 
                    <th class="text-center" data-tableexport-display="none">Action</th>
                </tr>
             
             </thead>
              <tbody>
              
                   <?php $icount=0; $total_amount=0; $total_paid_amount=0; $total_due_amount=0; foreach ($all_invoices as $di): $icount++; ?>
                    <tr  class="in_pay_tr"> 
                        <td>
                            <a href="javascript:void(0);" class="aitsun_link">
                                POS/<?= $di['session_serial']; ?>
                            </a> 
                            
                        </td>
                        <td><?= get_date_format($di['invoice_date'],'d M Y'); ?></td>
                        <td><?= $di['register_name']; ?></td>
                        <td><?= pos_order_prefix(company($user['id'])) ?><?= $di['pos_receipt_no']; ?></td>
                        <td>
                          <a href="javascript:void(0);" class="aitsun_link" >

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
                      <td>
                          <?= user_name($di['billed_by']) ?>
                      </td>
                        
                        <td class="text-right">
                            
                             
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?> 

                             <?php $total_amount+=aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?>
                          
                            
                            
                        </td>

                         <td class="text-right text-success" >
                            
                             
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?> 

                                <?php $total_paid_amount+=aitsun_round($di['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                           
                          
                            
                            
                        </td>

                        <td class="text-right text-danger" >

                                   
                                <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                    <?php $total_due_amount+=aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                
                        </td>
                       <td>
                        <?php if ($di['paid_status']=='paid'): ?>
                            <span class="badge bg-success">Paid</span>
                        <?php endif ?>
                           <?php if ($di['deleted']==0): ?>
                               
                           <?php elseif ($di['deleted']==1): ?>
                            <span class="badge bg-secondary">Cancelled</span>
                           <?php elseif ($di['deleted']==2): ?>
                            <span class="badge bg-dark">Order preparing</span>
                           <?php elseif ($di['deleted']==3): ?>
                            <span class="badge bg-warning text-dark">On hold</span>
                           <?php else: ?>
                           <?php endif; ?>
                       </td>

                       <td class="text-center">
                           <a href="<?= base_url('pos/edit') ?>/<?= $di['register_id'] ?>/load/<?= $di['id'] ?>" class="btn btn-sm btn-primary rounded-pill">Load</a>
                       </td>
                       
                      </tr>




                            <?php endforeach; ?>
                    <?php if ($icount<1): ?>
                        <tr>
                            <td class="text-center" colspan="9">
                                <span class="text-danger">
                                    No Sales
                                    
                            </span>
                            </td>
                        </tr>
                    <?php endif ?>
                    
                 
                 
              </tbody>

              <tfoot>
                <tr>  
                    <td colspan="3"><b>Total</b></td>
                    <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>

                    <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_paid_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                    <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                    <td class="" data-tableexport-display="none"></td>
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
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 


 

