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
                    <a class="href_loader" href="<?= base_url('fees_and_payments'); ?>">Fees management</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Transport Fees</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#fees_collected_table" data-filename="Fees collected <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#fees_collected_table" data-filename="Fees collected <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#fees_collected_table" data-filename="Fees collected <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#fees_collected_table"> 
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
                    

                        
                           
                        <select name="class" class="form-control form-control-sm asms_select ">
                          <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Class'); ?></option>
                              
                            <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                            <?php endforeach ?>
                        </select>

                         <select name="driver" class="form-control form-control-sm asms_select ">
                          <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Driver'); ?></option>
                              
                            <?php foreach (drivers_array(company($user['id'])) as $dr): ?>
                                <option value="<?= $dr['id']; ?>"><?= $dr['display_name']; ?></option>
                            <?php endforeach ?>
                        </select>

                        <select name="vehicle" class="form-control form-control-sm asms_select ">
                          <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Vehicle'); ?></option>
                              
                            <?php foreach (vehicles_array(company($user['id'])) as $vch): ?>
                                <option value="<?= $vch['id']; ?>"><?= $vch['vehicle_name']; ?></option>
                            <?php endforeach ?>
                        </select>



                           
                                                
                        
       
                    
                     
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('credit_statement/sales') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="fees_collected_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Invoice No</th>
                    <th class="sorticon">Date</th>
                    <th class="sorticon">Driver</th>
                    <th class="sorticon">Vehicle</th>
                    <th class="sorticon">Customer</th> 
                    <th class="sorticon">Class</th>
                    <th>Details</th>
                    <th class="sorticon">Pending amount</th>
                    <th class="sorticon">Added By</th>

                </tr>
             </thead>
                 
              <tbody>
                <?php  $data_count=0; $feesname=''; $fename=''; ?>
                <?php foreach ($all_invoices as $di){ $data_count++; $tfename=get_vehicle_data($di['vehicle_id'],'vehicle_name'); ?>

                      <?php if ($data_count==1){$fename=get_vehicle_data($di['vehicle_id'],'vehicle_name');} ?>


                     <?php if ($fename!=$tfename || $data_count==1): $fename=get_vehicle_data($di['vehicle_id'],'vehicle_name'); ?>
                         <tr>
                            <td colspan="9" class="bg-grey bg-invoice text-center text-white">
                                <b>
                                    <?= get_vehicle_data($di['vehicle_id'],'vehicle_name') ?></b> - <b><?= get_vehicle_data($di['vehicle_id'],'vehicle_number')?></b>
                            </td>
                        </tr>
                    <?php endif ?>

                  
                  <tr>
                     
                    <td>
                        <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>">#<?= get_setting(company($user['id']),'invoice_prefix'); ?><?= get_setting(company($user['id']),'sales_prefix'); ?><?= $di['serial_no']; ?></a>
                      </td>
                  
                      <td><?= get_date_format($di['invoice_date'],'d M Y'); ?></td>
                      <td><?= user_name($di['driver_id'])?></td>
                      <td><?= get_vehicle_data($di['vehicle_id'],'vehicle_name')?></td>
                      <td>
                       
                            <a class="aitsun_link" href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>">
                                <?=  user_name($di['customer']); ?>      
                            </a>
                        
                      </td>
                      <td><?= class_name($di['class_id'])?></td>
                      <td>
                        <?= get_fees_data(company($user['id']),$di['fees_id'],'fees_name') ?>
                      </td>


                      
                      
                      <td class="text-right"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?></td>
                      <td style=" font-size: 12px;"><?= user_name(get_fees_data(company($user['id']),$di['fees_id'],'added_by')); ?></td>
                  </tr>
                      <?php } ?>
                
                <?php if ($data_count<1): ?>
                <tr>
                    <td class="text-center" colspan="12">
                        <span class="text-danger">No Transport Report</span>
                    </td>
                </tr>
                <?php endif ?> 
              </tbody>
              <tfoot>
                    <tr>


                        
                    </tr>
                </tfoot>
          </table>
        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->


<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('fees_and_payments/fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees collected</span></a>/

        

        <a href="<?= base_url('fees_and_payments/group_wise_fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Group wise fees collected </span></a>/
         <a href="<?= base_url('fees_and_payments/collected_transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/consession_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Concession report</span></a>/
        <a href="<?= base_url('fees_and_payments/fees_wise_outstanding'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees wise outstanding</span></a>/
        <a href="<?= base_url('fees_and_payments/transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport outstanding</span></a>
    </div>
    <div class="aitsun_pagination">  
        
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
