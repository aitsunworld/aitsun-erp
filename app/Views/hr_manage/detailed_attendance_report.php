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
                    <b class="page_heading text-dark">Detailed attendance report (<?= get_date_format($attend_date,'Y'); ?>)</b>
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

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#attend_report_table" data-filename="<?= get_company_data(company($user['id']),'company_name') ?> - attendance report (<?= get_date_format($attend_date,'F Y'); ?>)"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#attend_report_table" data-filename="<?= get_company_data(company($user['id']),'company_name') ?> - attendance report (<?= get_date_format($attend_date,'F Y'); ?>)"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#attend_report_table" data-filename="<?= get_company_data(company($user['id']),'company_name') ?> - attendance report (<?= get_date_format($attend_date,'F Y'); ?>)"> 
            <span class="my-auto">PDF</span>
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
        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="attend_report_table" class="erp_table ">
                <thead>
                    <tr>
                        <td class="text-center" colspan="10">
                            <?= get_company_data(company($user['id']),'company_name') ?> - Detailed attendance report (<?= get_date_format($attend_date,'F Y'); ?>)
                        </td>
                    </tr>

                    <tr style="background-color: #8e0934c7;color: white;vertical-align: middle;">  
                        <td>Employee name</td>
                        <td>Category</td>   
                        <td class="text-center">Total Wrk.Days</td>  
                        <td class="text-center">Present</td>   
                        <td class="text-center">Half-day</td> 
                        <td class="text-center">Absent</td>
                        <td class="text-center">On-time</td> 
                        <td class="text-center">Late</td> 
                        <td class="text-center">Over-time(hrs)</td>  
                    </tr>  
                </thead>
                <tbody>
                    <?php 
                        $spyrow=0; $i=0; 
                        foreach ($user_data as $atn): $i++;
                        $get_total_days_of_month=get_total_days_of_month(company($user['id']),$attend_date,$atn['id'],$atn['employee_category']);
                        $get_full_present_of_employee=get_full_present_of_employee($attend_date,$atn['id']);
                        $get_half_present_of_employee=get_half_present_of_employee($attend_date,$atn['id']);
                        $get_on_time_of_employee=get_on_time_of_employee($attend_date,$atn['id']);
                        $get_late_of_employee=get_late_of_employee($attend_date,$atn['id']);
                        $get_overtime_of_employee =get_overtime_of_employee($attend_date,$atn['id']);

                        $total_leaves=$get_total_days_of_month-($get_full_present_of_employee+($get_half_present_of_employee/2));
                    ?>
                    <tr>
                        <td><?= $atn['display_name']; ?> </td>
                        <td><?= $atn['category_name'] ?></td> 
                        <td class="text-center"><?= $get_total_days_of_month ?></td> 
                        <td class="text-center"><?= $get_full_present_of_employee ?></td>  
                        <td class="text-center"><?= $get_half_present_of_employee ?></td>  
                        <td class="text-center"><?= $total_leaves ?></td> 
                        <td class="text-center"><?= $get_on_time_of_employee ?></td> 
                        <td class="text-center"><?= $get_late_of_employee ?></td> 
                        <td class="text-center"><?= $get_overtime_of_employee ?></td> 
                       
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
      
        <!--  <php if (is_aitsun(company($user['id']))): ?>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<= base_url('hr_manage/leave_management'); ?>">Leave management</a>   
        <php endif ?>  -->
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