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
                    <b class="page_heading text-dark">Group wise fees collected</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#group_wise_fees_collected_table" data-filename="Group wise fees collected <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#group_wise_fees_collected_table" data-filename="Group wise fees collected <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#group_wise_fees_collected_table" data-filename="Group wise fees collected <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#group_wise_fees_collected_table"> 
            <span class="my-auto">Quick search</span>
        </a>

       
        
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 

        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->

                    <form method="get" class="d-flex" action="<?= base_url('fees_and_payments/group_wise_fees_collected') ?>">
                        <?= csrf_field(); ?>
                       
                      
                        
                            <select name="fees" class="form-select">
                             <option value="">Select Group</option>
                             <?php foreach (feeses_array(company($user['id'])) as $stf): ?>
                                 <option value="<?= $stf['id']; ?>"><?= $stf['fees_name']; ?></option>
                             <?php endforeach ?>
                            </select>


                            <select name="class" class="form-control form-control-sm asms_select ">
                              <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Class'); ?></option>
                                  
                                <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                    <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                                <?php endforeach ?>
                            </select>
                        
                         

                           <input type="date" name="from" class="form-control">
                          

                            <input type="date" name="to" class="form-control">
                          
                      
                     
                        <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                        <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees_and_payments/group_wise_fees_collected') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                      
                    </form>
                  
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="group_wise_fees_collected_table" class="erp_table sortable">
             <?php 
            $get_from='';
            $get_to=''; 
            $get_collected='';
            $get_class='';

            if ($_GET) {
                if (isset($_GET['from'])) {
                    $get_from=trim($_GET['from']);
                }
                if (isset($_GET['to'])) {
                    $get_to=trim($_GET['to']);
                }

                if (isset($_GET['collected_user'])) {
                    $get_collected=trim($_GET['collected_user']);
                }
                if (isset($_GET['class'])) {
                    $get_class=trim($_GET['class']);
                }
            }
         ?>


        <?php $i=0; foreach ($all_fees_groups as $ft): $i++; ?>
    
         <tr>
            <th colspan="5" class="text-center bg-dark text-white">
                <b><?= $ft['fees_name']; ?></b>
            </th>
        </tr>
       

             <tr>
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'No.'); ?></b>
                  </td>
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></b>
                  </td>
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'Student name'); ?></b>
                  </td> 
                  <td >
                      <b>Coll. By</b>
                  </td> 
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'Paid'); ?></b>
                  </td> 
                   
            </tr>
          <?php $ic=0; $total_sum=0; $paid_sum=0; $due_sum=0; foreach (get_paid_challans(company($user['id']),$ft['id'],$get_collected,$get_from,$get_to,$get_class) as $db): ?>
            <tr>
             <td> 
                <?= inventory_prefix(company($user['id']),invoice_data($db['invoice_id'],'invoice_type')); ?><?= invoice_data($db['invoice_id'],'serial_no') ?>
              </td>
              <td><?= get_date_format($db['datetime'],'d-m-Y'); ?></td>
              
              <td>
                 <?= user_name($db['customer']); ?>-<?= class_name(current_class_of_student(company($user['id']),$db['customer'])) ?>
              </td>
             
              

              <td><?= user_name($db['collected_by']); ?></td>
              <td class="text-right">
                 
                    <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                   <?php $total_sum+=aitsun_round($db['amount'],2); ?>
                 
              </td> 
             
          </tr>
        <?php endforeach ?>

        <?php if (count(get_paid_challans(company($user['id']),$ft['id'],$get_collected,$get_from,$get_to,$get_class))==0): ?>
            <tr>
                <td class="text-center text-danger" colspan="6">No data</td>  
            </tr>
        <?php endif ?>
       
            <tr>
                <td colspan="4" class="text-center"><b>Total</b></td>
                <td class="text-right">
                    <b> <?= aitsun_round($total_sum,get_setting(company($user['id']),'round_of_value')); ?></b>
                </td> 
            </tr>
   

        <?php endforeach ?> 

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
        <a href="<?= base_url('fees_and_payments/collected_transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/consession_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Concession report</span></a>/
        <a href="<?= base_url('fees_and_payments/fees_wise_outstanding'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees wise outstanding</span></a>/
        <a href="<?= base_url('fees_and_payments/transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport outstanding</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 