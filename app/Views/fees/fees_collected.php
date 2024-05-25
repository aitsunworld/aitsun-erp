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
                    <b class="page_heading text-dark">Fees collected</b>
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

                    <form method="get" class="d-flex" action="<?= base_url('fees_and_payments/fees_collected') ?>">
                        <?= csrf_field(); ?>
                       
                      
                        <input type="date" name="from" class="filter-control form-control" placeholder="">
                      

                        <input type="date" name="to" class="filter-control form-control" placeholder="">
                     


                        <select name="collected_user" class="form-select">
                         <option value="">Select user</option>
                         <?php foreach (staffs_array(company($user['id'])) as $stf): ?>
                             <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                         <?php endforeach ?>
                        </select>
                      
                     
                        <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                        <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees_and_payments/fees_collected') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                      
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
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Date</th>
                    <th class="sorticon">No</th> 
                    <th class="sorticon">Student name</th> 
                    <th class="sorticon">Amount</th> 
                    <th class="sorticon">Collected by</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php $i=0; foreach ($fees_collected_data as $fc): $i++; ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= get_date_format($fc['datetime'],'d-m-Y'); ?></td>
                    <td> 
                     <?= inventory_prefix(company($user['id']),invoice_data($fc['invoice_id'],'invoice_type')); ?><?= invoice_data($fc['invoice_id'],'serial_no') ?>
                    </td>
                    <td>
                     <?= user_name($fc['customer']); ?>-<?= class_name(current_class_of_student(company($user['id']),$fc['customer'])) ?>
                    </td>
                 
                    <td class="text-right">
                        <?php if ($fc['bill_type']=='receipt' || $fc['bill_type']=='sales' || $fc['bill_type']=='purchase_return'): ?>
                            <?= aitsun_round($fc['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                        <?php else: ?>
                          ---
                          <?php endif ?>
                    </td>

                    <td><?= user_name($fc['collected_by']); ?></td>
                    
                </tr>
                <?php endforeach ?>
                <?php if ($i==0): ?>

                    <tr>
                        <td colspan="8" class="text-center">
                            <span class="text-danger"> No data</span>
                        </td>
                    </tr>


                <?php endif ?>
                 
              </tbody>

              <tfoot>
                <tr>
                    
                    <th colspan="4" class="text-center"><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                   
                    <th class="text-right">
                      <strong> <?= aitsun_round($credit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                    </th>
                    <th></th>
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
        <a href="<?= base_url('fees_and_payments/group_wise_fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Group wise fees collected </span></a>/
        <a href="<?= base_url('fees_and_payments/collected_transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/consession_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Concession report</span></a>/
        <a href="<?= base_url('fees_and_payments/fees_wise_outstanding'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees wise outstanding</span></a>/
        <a href="<?= base_url('fees_and_payments/transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport outstanding</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 