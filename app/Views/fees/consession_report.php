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
                    <b class="page_heading text-dark">Concession report</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#concession_table" data-filename="Concession report <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#concession_table" data-filename="Concession report <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#concession_table" data-filename="Concession report <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#concession_table"> 
            <span class="my-auto">Quick search</span>
        </a>

       
        
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 

        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->

                    <form method="get" class="d-flex" action="<?= base_url('fees_and_payments/consession_report') ?>">
                        <?= csrf_field(); ?>
                       
                        <input type="date" name="from" class="filter-control form-control" placeholder="">
                     

                        <input type="date" name="to" class="filter-control form-control" placeholder="">
                      
                     
                        <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                        <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees_and_payments/consession_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                      
                    </form>
                  
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="concession_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Date</th>
                    <th class="sorticon">No</th> 
                    <th class="sorticon">Student name</th> 
                    <th class="sorticon">Consession for</th> 
                    <th class="sorticon">Total</th> 
                    <th class="sorticon">Consession</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php $main_total=0; $conse_total=0; $i=0; foreach ($consession_data as $db): $i++; ?>
                <tr>
                      <td><?= $i; ?></td>
                      <td><?= get_date_format($db['invoice_date'],'d-m-Y'); ?></td>
                      <td>
                        <a href="<?= base_url('fees_and_payments/view_challan') ?>/<?= $db['id'] ?>">
                            <?= inventory_prefix(company($user['id']),$db['invoice_type']); ?><?= $db['serial_no'] ?>
                        </a>
                        
                      </td>
                      <td>
                         <?= user_name($db['customer']); ?>-<?= class_name(current_class_of_student(company($user['id']),$db['customer'])) ?>
                      </td>
                      <td>
                          <?= $db['concession_for'] ?>
                      </td>
                     
                      <td class="text-right">
                          <?= aitsun_round($db['main_total'],get_setting(company($user['id']),'round_of_value')); ?>
                         <?php $main_total+=$db['main_total']; ?>
                      </td> 
                      <td class="text-right">
                          <?= aitsun_round($db['discount'],get_setting(company($user['id']),'round_of_value')); ?>
                         <?php $conse_total+=$db['discount']; ?>
                      </td> 
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
                    
                    <th colspan="5" class="text-center"><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                    
                    <th class="text-right">
                      <strong> <?= aitsun_round($main_total,get_setting(company($user['id']),'round_of_value')); ?></strong>
                    </th>
                    <th class="text-right">
                      <strong> <?= aitsun_round($conse_total,get_setting(company($user['id']),'round_of_value')); ?></strong>
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
        <a href="<?= base_url('fees_and_payments/collected_transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/fees_wise_outstanding'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees wise outstanding</span></a>/
        <a href="<?= base_url('fees_and_payments/transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport outstanding</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 