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
                    <b class="page_heading text-dark">Fees wise outstanding</b>
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
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

   <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    

                        
                            <select name="fees" class="form-control form-control-sm asms_select ">
                              <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose fees'); ?></option> 
                                <?php foreach (feeses_array(company($user['id'])) as $fee): ?>
                                    <option value="<?= $fee['id']; ?>"><?= $fee['fees_name']; ?></option>
                                <?php endforeach ?>
                            </select>

                            <select name="class" class="form-control form-control-sm asms_select ">
                              <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Class'); ?></option>
                                  
                                <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                    <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                                <?php endforeach ?>
                            </select>

                            <select name="customer1" class="form-select asms_select ">
                                  <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose student'); ?></option>
                                  <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose'); ?></option>
                                    <?php foreach (students_array(company($user['id'])) as $std): ?>
                                        <option value="<?= $std['id']; ?>"><?= user_name($std['id']); ?> - <?= class_name(current_class_of_student(company($user['id']),$std['id'])) ?></option>
                                    <?php endforeach ?>
                                </select>
                            
                                                
                        
       
                    
                     
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees_and_payments/fees_wise_outstanding') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
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
                    <th class="sorticon text-center">Date</th>                
                    <th class="sorticon">Student</th>    
                    <th class="sorticon text-center">Class</th>    
                    <th class="sorticon text-center">Fees</th>  
                    <th class="sorticon text-end">Pending amount</th>
                    <th class="sorticon">Added by</th>
                </tr>
             </thead>
                 
              <tbody>
                <?php  $data_count=0; $feesname=''; $fename=''; ?>
                <?php foreach ($all_invoices as $di){ $data_count++; $tfename=get_fees_data(company($user['id']),$di['fees_id'],'fees_name'); ?>
                    <?php if ($data_count==1){$fename=get_fees_data(company($user['id']),$di['fees_id'],'fees_name');} ?>

                    <?php if ($fename!=$tfename || $data_count==1): $fename=get_fees_data(company($user['id']),$di['fees_id'],'fees_name'); ?>
                         <tr>
                            <td colspan="7" class="bg-grey bg-invoice text-center text-white">
                                <b><?= get_fees_data(company($user['id']),$di['fees_id'],'fees_name') ?></b>
                            </td>
                        </tr>
                    <?php endif ?>
                   

                    <tr>
                    <td>
                        <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>" class="aitsun_link href_loader">
                            #<?= inventory_prefix(company($user['id']),$di['invoice_type']); ?><?= $di['serial_no']; ?>     
                        </a> 
                      </td>
                    <td class="text-center"><?= get_date_format($di['invoice_date'],'d M Y'); ?></td>
                    <td>
                       
                            <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>" class="aitsun_link href_loader">
       
                               <?php if ($di['customer']!='CASH'): ?>
                                    <?=  user_name($di['customer']); ?>
                                      
                                    <?php elseif ($di['alternate_name']==''): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                    <?php else: ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $di['alternate_name']; ?> )
                                    <?php endif ?>  
                                   
                              </a> 
                      </td> 
                      <td class="text-center"><?= class_name($di['class_id']); ?></td>
                      <td class="text-center">
                        <?= get_fees_data(company($user['id']),$di['fees_id'],'fees_name') ?>
                      </td> 
                      
                      <td class="text-end"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?></td>
                      <td><?= user_name($di['billed_by']) ?></td>
                    </tr>
                 <?php }  ?> 
                  
                      

                      <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="7">
                                <span class="text-danger">No Outstanding</span>
                            </td>
                        </tr>
                    <?php endif ?> 
              </tbody>
              <tfoot>
                    <tr>

                        <th colspan="4"></th>
                        <th class="text-center"><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th> 
                     
                        <th class="text-end">
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
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('fees_and_payments'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees management</span></a>/
        <a href="<?= base_url('fees_and_payments/fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/group_wise_fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Group wise fees collected </span></a>/
        <a href="<?= base_url('fees_and_payments/consession_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Concession report</span></a>/
        <a href="<?= base_url('fees_and_payments/transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport outstanding</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->