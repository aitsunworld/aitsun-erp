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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Outstanding Statements</b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#outstanding_table" data-filename="Outstanding Statement"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#outstanding_table" data-filename="Outstanding Statement"> 
            <span class="my-auto">CSV</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#outstanding_table"> 
            <span class="my-auto">Quick search</span>
        </a>
        
    </div>
    <div>
        <a class="text-dark font-size-footer my-auto ms-2 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">Statement<span class="visually-hidden"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">    
            <a class="dropdown-item href_loader" href="<?= base_url('credit_statement/sales') ?>">
                <i class="bx bx-arrow-to-right mr-1"></i>  <?= langg(get_setting(company($user['id']),'language'),'Accounts Receivable'); ?>
            </a>
            <a class="dropdown-item href_loader" href="<?= base_url('credit_statement/purchase') ?>">
                <i class="bx bx-arrow-to-right mr-1"></i> <?= langg(get_setting(company($user['id']),'language'),'Accounts Payable'); ?>
            </a>
        </div>
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

   <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    <?php if ($acccount=='sales'): ?>     

                       
                        <select name="customer" class="form-control form-control-sm">
                          <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Customer'); ?></option>
                          <option value="CASH"><?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?></option>
                            <?php foreach (customers_array(company($user['id'])) as $cs) { ?>
                            <option value="<?= $cs['id']; ?>"><?= $cs['display_name']; ?>-<?= $cs['phone']; ?></option>
                          <?php } ?>
                        </select>
                          
                       <?php else: ?>                          
                        <select name="customer" class="form-control form-control-sm">
                          <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Vendor'); ?></option>
                            <?php foreach (vendors_array(company($user['id'])) as $cs) { ?>
                            <option value="<?= $cs['id']; ?>"><?= $cs['display_name']; ?>-<?= $cs['phone']; ?></option>
                          <?php } ?>
                        </select>
                         
                    <?php endif ?>
                    
                     
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('credit_statement/sales') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="outstanding_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Invoice No</th>
                    <th class="sorticon">Date</th>
                    <?php if ($acccount=='sales'): ?>                 
                    <th class="sorticon">Customer</th> 
                    <?php else: ?>
                    <th class="sorticon">Vendors</th>
                    <?php endif ?>
                    <th class="sorticon">Pending amount</th>
                    <th class="sorticon">Due Date</th>

                </tr>
             </thead>
                 
              <tbody>
                <?php  $data_count=0; ?>
                <?php foreach ($all_invoices as $di){ $data_count++; ?>
                    <?php if ($di['fees_id']>0){ $reurl=base_url('fees_and_payments/view_challan').'/'.$di['id']; }else{$reurl=base_url('invoices/details').'/'.$di['id'];} ?>
                    
                    <tr>
                    <td>
                        <a class="aitsun_link href_loader" href="<?= $reurl; ?>">
                            #<?= inventory_prefix(company($user['id']),$di['invoice_type']); ?><?= $di['serial_no']; ?>
                        </a> 
                      </td>
                    <td><?= get_date_format($di['invoice_date'],'d M Y'); ?></td>
                    <td>
                        
                            <a href="<?= $reurl; ?>" class="aitsun_link href_loader">
       
                               <?php if ($di['customer']!='CASH'): ?>
                                    <?=  user_name($di['customer']); ?>
                                      
                                    <?php elseif ($di['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $di['alternate_name']; ?> )
                                    <?php endif ?>

                                   
                                      
                                   
                              </a>
                       
                        
                      </td>
                     
                      
                      <td class="text-right"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?></td>

                      <td>
                          <?= dateDifference($di['invoice_date'],now_time($user['id']));?>
                      </td>
                    </tr>
                 <?php }  ?> 
                  
                      

                      <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="6">
                                <span class="text-danger">No Outstanding Statement</span>
                            </td>
                        </tr>
                    <?php endif ?> 
              </tbody>
              <tfoot>
                    <tr>

                        <th colspan="2"></th>
                        <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>

                        
                            <th class="text-right">
                              <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')); ?></strong>
                            </th>
                      
                        
                    
                    </tr>
                </tfoot>
          </table>
      </div>
  </div>
</div>

<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->


 <!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->