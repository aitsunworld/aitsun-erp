<!-- ////////////////////////// TOP BAR START ///////////////////////// -->

 <?php

    $report_date=get_date_format(now_time($user['id']),'d M Y');
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
                    <a href="<?= base_url('appointments'); ?>" class="href_loader">Appointments</a>
                </li>  
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Booking reports</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#daybook_table" data-filename="Appointments bookings - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#daybook_table" data-filename="Appointments bookings - - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#daybook_table" data-filename="Appointments bookings - - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
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
                        <th colspan="9" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Subject'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Starts on'); ?>. </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Ends on'); ?>. </th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Duration'); ?>. </th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Type'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Customer'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Person'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Resource'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Status'); ?></th> 
                 </thead>
                 <tbody>
                    
                    <?php foreach ($all_bookings as $bk): ?>
                        <tr>
                            <td><?= $bk['booking_name'] ?> </td>
                            <td><?= get_date_format($bk['book_from'],'d M Y - H:i A') ?></td>
                            <td><?= get_date_format($bk['book_to'],'d M Y - H:i A') ?></td> 
                            <td><?= $bk['duration'] ?> hrs</td> 
                            <td><?= ($bk['booking_type']=='person')?'<span class="badge bg-primary">Meeting</span>':'<span class="badge bg-secondary">Booking</span>'; ?></td> 
                            <td><?= user_data($bk['customer'],'display_name') ?></td> 
                            <td><?= user_data($bk['person_id'],'display_name') ?></td> 
                            <td><?= resource_data($bk['resource_id'],'appointment_resource') ?></td> 
                            <td>
                                <?= ($bk['status'])?'<span class="badge bg-success">Checked In</span>':'' ?>
                            </td>
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

