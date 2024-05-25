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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Referral Report</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#referral_report_table" data-filename="Referral report"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#referral_report_table" data-filename="Referral report"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#referral_report_table" data-filename="Referral report"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#referral_report_table"> 
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

                

                <select name="referral" class="form-control">
                     <option value="">Select user</option>
                     <?php foreach (users_array(company($user['id'])) as $stf): ?>
                         <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                     <?php endforeach ?>
                </select>
              

              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('reports/referral_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              </form>

            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">

        <div class="aitsun_table w-100 pt-0">
            
            <table class="erp_table sortable" id="referral_report_table">
                <thead>
                    <tr>
                      <th><b><?= langg(get_setting(company($user['id']),'language'),'Inv. no.'); ?></b></th>
                      <th><b><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></b></th>
                      <th><b><?= langg(get_setting(company($user['id']),'language'),'Customer/Vendor'); ?></b></th>
                      <th><b><?= langg(get_setting(company($user['id']),'language'),'Type'); ?></b></th>
                      <th><b><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></b></th>
                      
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        $total_amount=0; 
                        $old_ref=0; 
                        $st_start=0; 
                        foreach ($referral_data as $rfl): 

                            $st_start=$rfl['inv_referal'];

                    ?>

                       <?php if ($old_ref!=$rfl['inv_referal']): ?>
                           <tr>
                                <td colspan="5"class="bg-grey bg-invoice text-center text-white" >
                                    <b><?= user_name($rfl['inv_referal']); ?></b>
                                    
                                    
                                </td>
                            </tr>
                       <?php endif ?>
                         <?php $old_ref=$rfl['inv_referal'];  ?>
                    


                        <tr>
                            <td>
                              <a href="<?php echo base_url('invoices/details'); ?>/<?= $rfl['id']; ?>" class="href_loader aitsun_link">#<?= inventory_prefix(company($user['id']),$rfl['invoice_type']); ?><?= $rfl['serial_no']; ?></a>
                              </td>
                              <td><?= get_date_format($rfl['invoice_date'],'d M Y'); ?></td>
                              <td>
                                  <a href="<?php echo base_url('invoices/details'); ?>/<?= $rfl['id']; ?>" class="href_loader aitsun_link">

                                   <?php if ($rfl['customer']!='CASH'): ?>
                                    <?=  user_name($rfl['customer']); ?>
                                      
                                    <?php elseif ($rfl['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                    <?php elseif ($rfl['alternate_name']=='CASH CUSTOMER'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> 

                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $rfl['alternate_name']; ?> )
                                    <?php endif ?>

                                  </a>
                              </td>
                              <td><?= full_invoice_type($rfl['invoice_type']); ?></td>
                              <td><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($rfl['total'],get_setting(company($user['id']),'round_of_value')); ?> <?php $total_amount+=aitsun_round($rfl['total'],get_setting(company($user['id']),'round_of_value')); ?></td>
                            </tr>
                        
                    <?php endforeach ?>
                   
                </tbody>

                
                
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

