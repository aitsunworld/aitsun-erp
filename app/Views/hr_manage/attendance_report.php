<?php 
    $at_date=now_time($user['id']);
    if ($_GET) {
        if (!empty($_GET['attend_date'])) {
            $attend_date=get_date_format($_GET['attend_date'],'Y-F');
            $at_date=$attend_date;

        }else{
            $attend_date=get_date_format(now_time($user['id']),'Y - F');
        }
        
    }else{
        $attend_date=get_date_format(now_time($user['id']),'Y - F');
    }   
?>
     

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
                    <a class="href_loader" href="<?= base_url('hr_manage'); ?>">HR Management</a>
                </li>
                
                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('hr_manage/attendance'); ?>">Attendance</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Monthly Attendance (<?= $attend_date; ?>)</b>
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

        <a onclick="exporttoexcel('attend_report_table','<?= get_company_data(company($user['id']),'company_name') ?> - Monthly Attendance (<?= $attend_date; ?>')" class="text-dark font-size-footer me-2"> Excel</a>

       
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#attend_report_table" data-filename="Monthly Attendance (<?= $attend_date; ?>)"> 
            <span class="my-auto">CSV</span>
        </a>
      
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
              

                <input type="month" id="attend_month_box" class="form-control form-control-sm" name="date" value="<?= get_date_format($at_date,'Y-m'); ?>" max="<?= get_date_format(now_time($user['id']),'Y-m'); ?>">

                <button type="button" class="btn-dark btn-sm" id="monthapply">Apply</button>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 
        <div class=" table-responsive col-12 w-100 pt-0 pb-5">
            <table class="w-100 table-bordered" id="attend_report_table">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="<?= count(get_dates_of_month_array( $at_date,'day_number' ))+2; ?>">
                                        <?= get_company_data(company($user['id']),'company_name') ?> - Monthly Attendance (<?= $attend_date; ?>)
                                    </th>
                                </tr>
                                <tr style="background-color:#d4d4e0;"> 

                                    <th>
                                        <b>Name/Dates</b>
                                    </th>

                                    <?php foreach (get_dates_of_month_array( $at_date,'day_number' ) as $dt): ?>
                                        <th class="text-center"> <?= $dt; ?> </th>
                                        <?php if (get_date_format(timetest($at_date),'d')==$dt):
                                            break;
                                        endif ?>
                                    <?php endforeach ?>

                                    <th>Note</th>

                                </tr> 
                            </thead>
                            <tbody>
                                <?php $spyrow=0; $i=0; foreach ($user_data as $atn): $i++; ?>


                                    <tr>
                                        <td style="background-color:#d4d4e0;">
                                            <b><?= user_name($atn['user_id']); ?></b> 
                                        </td>

                                 
                                        <?php 
                                            
                                            foreach (get_dates_of_month_array($at_date,'day_number') as $dt): 
                                            $dates=get_date_format($at_date,'Y').'-'.get_date_format($at_date,'m').'-'.$dt;
                                            
                                            if (check_attendance_event(company($user['id']),$dates)){
                                                $spyrow++;
                                            }

                                            $event_name=get_attendance_event(company($user['id']),$dates,'event_name');

                                            $event_bg=get_attendance_event(company($user['id']),$dates,'bg_color');
                                            $event_color=get_attendance_event(company($user['id']),$dates,'font_color');

                                            $event_style='style="background:'.$event_bg.';color:'.$event_color.';"';

                                            $column_name=''; 

                                            $dayattend=get_user_attendance_data_by_date($atn['user_id'],$dates,'day_status');

                                            $td_class=''; 

                                            $month_and_year=get_date_format($dates,'Y-m');
                                            $current_month_and_year=get_date_format(now_time_of_company(company($user['id'])),'Y-m');
                                            $is_current_month=false;
                                            if ($month_and_year==$current_month_and_year) {
                                                $is_current_month=true;
                                            }
                                            if (empty($event_name)) {
                                               if ($dayattend==2) {
                                                   $column_name='<i class="bx bx-check"></i>';
                                                   $td_class=' text-success'; 
                                               }elseif ($dayattend==1) {
                                                   $column_name='HD';
                                                   $td_class='text-warning'; 
                                               }else{
                                                if ($is_current_month) {
                                                    $today_date=get_date_format(now_time_of_company(company($user['id'])),'d');
                                                    if ($dt<$today_date) {
                                                        $column_name='<i class="bx bx-x"></i>';
                                                        $td_class='text-danger';
                                                    }
                                                }else{
                                                    $column_name='<i class="bx bx-x"></i>';
                                                    $td_class='text-danger';
                                                }
                                                    
                                               }
                                            }else{ 
                                                $column_name='<small>'.$event_name.'</small>'; 
                                            }

                                            
                                            

                                        ?>

                                       
                                            <td class="p-1 text-center" <?= $event_style ?>>
                                                <span class="border-white <?= $td_class ?>"><?= $column_name ?></span> 
                                            </td> 

                                        <?php endforeach ?>

                                        <td>
                                            <small><?= get_user_attendance_note_by_month($atn['user_id'],$dates) ?></small>
                                        </td>

                                    </tr>
                                <?php endforeach ?>
                            </tbody>                   
                        </table>
        </div>
         

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
 

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report'); ?>">Reports</a>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report/leave_report'); ?>">Leave reports</a>
      
         <?php if (is_aitsun(company($user['id']))): ?>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/leave_management'); ?>">Leave management</a>   
        <?php endif ?> 
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

 