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
             
                <li class="breadcrumb-item " aria-current="page">
                    <a href="<?= base_url('time_table') ?>?page=1" class="href_loader">Time Table</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url('time_table/tab_time_table') ?>?page=1"><b class="page_heading text-dark">View Time Table</b></a>
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

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#exceltimetable"> 
            <span class="my-auto"></span>
        </a>
    </div>

    <button class="aitsun-primary-btn aitsun-btn-sm my-auto notify_time_table my-auto text-white" id="notify_time_table">Notify students</button>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="main_page_content">
    <div class="aitsun-row"> 
        
       <?php foreach (classes_array(company($user['id'])) as $cls): ?>
     
        <div class="col-md-12 mt-5 pb-5 class_box">
            <div class="d-flex justify-content-between">
                <div class="my-auto">
                     <h6 class="aitsun-fw-bold">Class: <?= $cls['class']; ?></h6>
                </div>
                <div class="my-auto">

                    <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#exceltimetable<?= $cls['id']; ?>" data-filename="<?= $cls['class']; ?> Time Table-<?=  now_time($user['id']); ?>"> 
                        <span class="my-auto">Excel</span>
                    </a>
                    <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#exceltimetable<?= $cls['id']; ?>" data-filename="<?= $cls['class']; ?> Time Table-<?=  now_time($user['id']); ?>"> 
                        <span class="my-auto">CSV</span>
                    </a>
                    <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#exceltimetable<?= $cls['id']; ?>" data-filename="<?= $cls['class']; ?> Time Table-<?=  now_time($user['id']); ?>"> 
                        <span class="my-auto">PDF</span>
                    </a>
                </div>
            </div>

            <div class="aitsun_table table-responsive">
                 <table class="erp_table sortable" id="exceltimetable<?= $cls['id']; ?>">
                    <tbody>
                        <tr>
                            <td><b>Monday</b></td>
                            <?php foreach (get_time_table_array(company($user['id']),$cls['id'],1,$user['id']) as $tcr): ?>
                            <td>
                                <?php if(trim($tcr['subject'])=='f')
                                {
                                    echo 'Free Hour';
                                }elseif(trim($tcr['subject'])=='l'){
                                    echo 'Launch Time';
                                }else{
                                    echo ''.subjects_name($tcr['subject']).'';
                                } ?>
                                <br>
                                <small style="font-size: 10px;"><b>(<?= get_date_format($tcr['start_time'],'h:i'); ?> - <?= get_date_format($tcr['end_time'],'h:i'); ?>)</b></small>
                            </td>
                            
                            <?php endforeach ?>

                        </tr>

                        <tr>
                            <td><b>Tuesday</b></td>
                            <?php foreach (get_time_table_array(company($user['id']),$cls['id'],2,$user['id']) as $tcr): ?>                     
                       
                            <td>
                                <?php if(trim($tcr['subject'])=='f')
                                {
                                    echo 'Free Hour';
                                }elseif(trim($tcr['subject'])=='l'){
                                    echo 'Launch Time';
                                }else{
                                    echo ''.subjects_name($tcr['subject']).'';
                                } ?>
                                <br>
                                <small style="font-size: 10px;"><b>(<?= get_date_format($tcr['start_time'],'h:i'); ?> - <?= get_date_format($tcr['end_time'],'h:i'); ?>)</b></small>
                            </td>
                            <?php endforeach ?>
                            
                        </tr>

                        <tr>
                            <td><b>Wednessday</b></td>
                            <?php foreach (get_time_table_array(company($user['id']),$cls['id'],3,$user['id']) as $tcr): ?>                     
                       
                            <td>
                                <?php if(trim($tcr['subject'])=='f')
                                {
                                    echo 'Free Hour';
                                }elseif(trim($tcr['subject'])=='l'){
                                    echo 'Launch Time';
                                }else{
                                    echo ''.subjects_name($tcr['subject']).'';
                                } ?>
                                <br>
                                <small style="font-size: 10px;"><b>(<?= get_date_format($tcr['start_time'],'h:i'); ?> - <?= get_date_format($tcr['end_time'],'h:i'); ?>)</b></small>
                            </td>
                            <?php endforeach ?>
                            
                        </tr>
                         <tr>
                            <td><b>Thursday</b></td>
                            <?php foreach (get_time_table_array(company($user['id']),$cls['id'],4,$user['id']) as $tcr): ?>                     
                       
                            <td>
                                <?php if(trim($tcr['subject'])=='f')
                                {
                                    echo 'Free Hour';
                                }elseif(trim($tcr['subject'])=='l'){
                                    echo 'Launch Time';
                                }else{
                                    echo ''.subjects_name($tcr['subject']).'';
                                } ?>
                                <br>
                                <small style="font-size: 10px;"><b>(<?= get_date_format($tcr['start_time'],'h:i'); ?> - <?= get_date_format($tcr['end_time'],'h:i'); ?>)</b></small>
                            </td>
                            <?php endforeach ?>
                            
                        </tr>
                         <tr>
                            <td><b>Friday</b></td>
                            <?php foreach (get_time_table_array(company($user['id']),$cls['id'],5,$user['id']) as $tcr): ?>                     
                       
                            <td>
                                <?php if(trim($tcr['subject'])=='f')
                                {
                                    echo 'Free Hour';
                                }elseif(trim($tcr['subject'])=='l'){
                                    echo 'Launch Time';
                                }else{
                                    echo ''.subjects_name($tcr['subject']).'';
                                } ?>
                                <br>
                                <small style="font-size: 10px;"><b>(<?= get_date_format($tcr['start_time'],'h:i'); ?> - <?= get_date_format($tcr['end_time'],'h:i'); ?>)</b></small>
                            </td>
                            <?php endforeach ?>
                            
                        </tr>
                         <tr>
                            <td><b>Saturday</b></td>
                            <?php foreach (get_time_table_array(company($user['id']),$cls['id'],6,$user['id']) as $tcr): ?>                     
                       
                            <td>
                                <?php if(trim($tcr['subject'])=='f')
                                {
                                    echo 'Free Hour';
                                }elseif(trim($tcr['subject'])=='l'){
                                    echo 'Launch Time';
                                }else{
                                    echo ''.subjects_name($tcr['subject']).'';
                                } ?>
                                <br>
                                <small style="font-size: 10px;"><b>(<?= get_date_format($tcr['start_time'],'h:i'); ?> - <?= get_date_format($tcr['end_time'],'h:i'); ?>)</b></small>
                            </td>
                            <?php endforeach ?>
                            
                        </tr>
                    </tbody>
                </table> 
            </div>

            <?php endforeach ?>
        </div>
    </div>