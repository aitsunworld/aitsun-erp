<!-- ////////////////////////// TOP BAR START ///////////////////////// -->

 <?php

    $report_date=get_date_format(now_time($user['id']),'d M Y');
    $from=get_date_format(now_time($user['id']),'d M Y');
    $dto=get_date_format(now_time($user['id']),'d M Y');

   if ($_GET) {
        $from=$_GET['from'];
        $dto=$_GET['to'];

        if (!empty($from) && empty($dto)) {
            $report_date=get_date_format($from,'l').' - '.get_date_format($from,'d M Y');
        }
        if (!empty($dto) && empty($from)) {
            $report_date=get_date_format($dto,'l').' - '.get_date_format($dto,'d M Y');
        }
        if (!empty($dto) && !empty($from)) {
            $report_date='From - '.get_date_format($from,'d M Y').'&nbsp; &nbsp; To - '.get_date_format($dto,'d M Y');
        }

     }else{
        $report_date='Today - '.get_date_format(now_time($user['id']),'d M Y');
     }

   

    $startDate = $from;
    $endDate = $dto;

    $dateArray = array();

    $currentDate = strtotime($startDate);
    $endDateTimestamp = strtotime($endDate);

    while ($currentDate <= $endDateTimestamp) {
        $dateArray[] = date('Y-m-d', $currentDate);
        $currentDate = strtotime('+1 day', $currentDate);
    }

    
?>



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
                    <b class="page_heading text-dark">Day Book</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#daybook_table" data-filename="Day book <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#daybook_table" data-filename="Day book - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#daybook_table" data-filename="Day book - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#daybook_table"> 
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
               <input type="number" min="1" name="voucher_no" class="form-control form-control-sm filter-control" placeholder="<?= get_setting($user['company_id'],'payment_prefix'); ?>">
               <input type="date" name="from" class="form-control form-control-sm filter-control" title="From" placeholder="">
                <input type="date" name="to" title="To" class="form-control form-control-sm filter-control" placeholder="">

                <select name="collected_user" class="form-select">
                 <option value="">Select user</option>
                 <?php foreach (staffs_array(company($user['id'])) as $stf): ?>
                     <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                 <?php endforeach ?>
                </select>
              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('day_book') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">

        <div class="aitsun_table w-100 pt-0">

            
               
       
            <table id="daybook_table" class="erp_table sortable no-wrap">
                 <thead>
                    <tr>
                        <th colspan="8" class="text-center"> 
                           <?= $report_date; ?> 
                        </th>
                    </tr>
                    <tr> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Vhr. No.'); ?>. </th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Credit'); ?></th>  
                    </tr>
                 </thead>
                 <tbody>
                    

                    <?php  foreach ($dateArray as $dt):  ?> 
                    <?php 
                        $lap=0;
                        $dr_sum=0; $cr_sum=0;  
                        $data_count=0; 
                        $trows=count(date_wise_day_book($dt));
                        foreach (date_wise_day_book($dt) as $db): $data_count++; $lap++;  
                  
                    ?>  
 
                    <?php if ($lap==1): ?>
                        <tr>
                            <td colspan="4"> 
                                <?= get_date_format($db['datetime'],'d M Y'); ?>
                            </td> 
                        </tr> 
                        <tr>
                            <td> 
                                Opening Balance
                            </td> 
                            <td></td>
                            <td><?= get_day_balance($dt,'opening_balance') ?></td>
                            <td></td>
                        </tr> 
                    <?php endif ?> 

                        <tr>
                            <td><?= get_group_data($db['account_name'],'group_head'); ?></td>
                            <td>
                                <a href="<?php echo base_url('payments/details'); ?>/<?= $db['id']; ?>" class="aitsun_link mr-2 href_loader">
                                    <?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $db['serial_no']; ?>
                                </a>
                            </td> 
                            <td class="text-right" <?php if ($db['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                                <?php if ($db['pay_amount_type']=='dr'): ?>
                                    <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                   <?php if ($db['deleted']==0): ?>
                                    <?php $dr_sum+=$db['amount']; ?>
                                   <?php endif ?>
                                <?php else: ?>
                                  
                                  <?php endif ?>
                              </td>
                              <td class="text-right" <?php if ($db['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                                <?php if ($db['pay_amount_type']=='cr'): ?>
                                    <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                   <?php if ($db['deleted']==0): ?>
                                   <?php $cr_sum+=$db['amount']; ?>
                                   <?php endif ?>
                                <?php else: ?>
                                  
                                  <?php endif ?>
                              </td>
                        </tr>
                        

                        <?php if ($lap==$trows): ?>
                        <tr>
                            <td> 
                                Closing Balance
                            </td> 
                            <td></td>
                            <td></td>
                            <td><?= get_day_balance($dt,'closing_balance') ?></td>
                        </tr> 
                        <tr>
                            <td colspan="1"></td>
                            <td><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></td>
                            <td class="text-right">
                              <strong> <?= aitsun_round($dr_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                            </td>
                            <td class="text-right">
                              <strong> <?= aitsun_round($cr_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                            </td> 
                        </tr>  
                        <?php endif ?> 

                    <?php endforeach ?>
                  
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