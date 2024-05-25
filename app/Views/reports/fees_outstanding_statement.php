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
                    <b class="page_heading text-dark">Fees Outstanding Statements</b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#feesoutstanding_table" data-filename="Fees Outstanding Statement"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#feesoutstanding_table" data-filename="Fees Outstanding Statement"> 
            <span class="my-auto">CSV</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#feesoutstanding_table"> 
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
                     
                        <?php if (is_school(company($user['id']))): ?>
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
                              <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Student'); ?></option>
                                <?php foreach (students_array(company($user['id'])) as $std): ?>
                                    <option value="<?= $std['id']; ?>"><?= user_name($std['id']); ?> - <?= class_name(current_class_of_student(company($user['id']),$std['id'])) ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php endif ?> 
                            
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees-wise-outstanding') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="feesoutstanding_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Invoice No</th>
                    <th class="sorticon">Date</th>           
                    <th class="sorticon">Student</th> 
                    <th>Details</th>
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

                                    <?php if (is_school(company($user['id']))): ?>
                                        -
                                        <?=  class_name(current_class_of_student(company($user['id']),$di['customer'])); ?>
                                    <?php endif ?>
                                      
                                   
                              </a>
                        
                      </td>
                      <?php if (is_school(company($user['id']))): ?>
                      <td>
                        <?= get_fees_data(company($user['id']),$di['fees_id'],'fees_name') ?>
                      </td>
                      <?php endif ?>
                      
                      <td class="text-right"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?></td>
                      <td>
                          <?= dateDifference($di['invoice_date'],now_time($user['id']));?>
                      </td>
                    </tr>
                 <?php }  ?> 
                  
                      

                      <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="6">
                                <span class="text-danger">No Fees Outstanding Statement</span>
                            </td>
                        </tr>
                    <?php endif ?> 
              </tbody>
              <tfoot>
                    <tr>

                        <th colspan="2"></th>
                        <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>

                        <?php if (is_school(company($user['id']))): ?>
                            <th></th>
                            <th class="text-right">
                              <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')); ?></strong>
                            </th>

                        <?php endif ?>
                        
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