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
                    <b class="page_heading text-dark">Leave report (<?= get_date_format($attend_date,'Y'); ?>)</b>
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

        <a onclick="exporttoexcel('attend_report_table','<?= get_company_data(company($user['id']),'company_name') ?> - leave report (<?= get_date_format($attend_date,'Y'); ?>')" class="text-dark font-size-footer me-2"> Excel</a>

       
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#attend_report_table" data-filename="Leave report (<?= $attend_date; ?>)"> 
            <span class="my-auto">CSV</span>
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
 
        <div class="aitsun-table table-responsive col-12 w-100 pt-0 pb-5">
            <table class="w-100 table-bordered" id="attend_report_table">
                <thead>
                    <tr>
                        <th class="text-center" colspan="<?= count(get_dates_of_month_array( $at_date,'day_number' ))+1; ?>">
                            <?= get_company_data(company($user['id']),'company_name') ?> - Leave report (<?= get_date_format($attend_date,'Y'); ?>)
                        </th>
                    </tr>
                    <tr style="background-color:#d4d4e0;"> 

                        <th class="px-2">
                            <b>Employee name</b>
                        </th>

                        <th class="px-2">
                            <b>Month</b>
                        </th>

                        <th class="text-center px-2">
                            <b>Leaves</b>
                        </th>

                        <th class="px-2 text-center">Note</th>

                    </tr> 
                </thead>
                <tbody>
                    <?php $spyrow=0; $i=0; foreach ($user_data as $atn): $i++; ?>

                        <?php  
                            for ($m=1; $m<=12; $m++) :
                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                            // echo '<li><a class="dropdown-item" href="?month='.$m.'">'.$month.'</a></li>';
                            $dates=get_date_format($attend_date,'Y').'-'.$m.'-01';
                            $t_leaves=get_user_leave_by_month_status(company($user['id']),$atn['user_id'],$dates,$atn['employee_category']);
                        ?>

                            <tr>
                                <?php if ($m==1): ?>
                                    <td rowspan="12" class="row_devider px-2" style="background-color:#d4d4e0;vertical-align: middle;text-align: center;">
                                        <b><?= user_name($atn['user_id']); ?></b>

                                        <?php if (get_user_leave_by_year(company($user['id']),$atn['user_id'],$dates,$atn['employee_category'])>0): ?>

                                            <?php if (get_setting(company($user['id']),'carry_forward')==1): ?>
                                                <small class="d-block"><b class="text-danger"><?= get_user_leave_by_year(company($user['id']),$atn['user_id'],$dates,$atn['employee_category']); ?></b> leaves out of <b class="text-success"><?= (get_setting(company($user['id']),'leave_for_month')*12)+carry_forwarded_leave($atn['user_id'],$dates); ?></b></small>
                                                
                                                <?php if (carry_forwarded_leave($atn['user_id'],$dates)>0): ?>
                                                    <small><?= carry_forwarded_leave($atn['user_id'],$dates) ?> from last year</small>
                                                <?php endif ?>
                                                
                                            <?php else: ?>
                                                <small class="d-block"><b class="text-danger"><?= get_user_leave_by_year(company($user['id']),$atn['user_id'],$dates,$atn['employee_category']); ?></b>
                                                    <?php if (get_user_leave_by_year(company($user['id']),$atn['user_id'],$dates,$atn['employee_category'])>1): ?>
                                                        leaves
                                                    <?php else: ?>
                                                        leave
                                                    <?php endif ?>
                                                </small>
                                            <?php endif ?>
                                            
                                        <?php endif ?>

                                        
                                         
                                    </td>
                                <?php endif ?>

                                
                                <td class="px-2 <?php if ($m==12) {  echo 'row_devider'; } ?> month_color_<?= $m; ?>">
                                    <?= $month; ?>
                                </td> 

                                <td class="text-center <?php if ($m==12) {  echo 'row_devider'; } ?>"> 
                                    <?php if ($t_leaves!='up_month'): ?>
                                        <span class="text-danger">
                                            <?= $t_leaves ?>
                                        </span>
                                    <?php else: ?>  
                                        N/A
                                    <?php endif ?>  
                                </td> 

                                <td class="text-center <?php if ($m==12) {  echo 'row_devider'; } ?>">
                                    <small><?= get_user_attendance_note_by_month($atn['user_id'],$dates) ?></small>
                                </td> 
                            </tr>
                        
                        <?php endfor; ?> 
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


<script src="<?= base_url('public/js/tableexport.js'); ?>"></script>  

<script type="text/javascript">
  function exporttoexcel(tableid,filename) {

        var table = $("#"+tableid);

        $(table).table2excel({

            // exclude CSS class

            exclude: ".noExl",

            name: filename,

            filename: filename + $.now(),//do not include extension

            fileext: ".xls", // file extension

            preserveColors: true,

            sheetName: filename

        });
      }
</script>