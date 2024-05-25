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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Student Attendance Report</b>
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


<!-- ////////////////////////// FILTER ///////////////////////// -->
    <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->

               <form method="get" class="d-flex">
                <?= csrf_field(); ?>

                

                <select name="referral" class="form-control">
                     <option value="">Select user</option>
                     <?php foreach (users_array(company($user['id'])) as $stf): ?>
                         <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                     <?php endforeach ?>
                </select>
              

              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('reports/referral_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              </form>

            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<div class="sub_main_page_content">
    <div class="">

        <?php foreach (classes_array(company($user['id'])) as $cls): ?>
        <div class="d-flex justify-content-between ">
            <div class="my-auto">
                 <h6 class="aitsun-fw-bold">Monthly Attendance (<?= $attend_date; ?>)- <?= $cls['class']; ?></h6>
            </div>
            <div class="my-auto">

                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#std_attend_report_table<?= $cls['id']; ?>" data-filename="<?= $cls['class']; ?> Students Attendance-<?=  now_time($user['id']); ?>"> 
                    <span class="my-auto">Excel</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#std_attend_report_table<?= $cls['id']; ?>" data-filename="<?= $cls['class']; ?> Students Attendance-<?=  now_time($user['id']); ?>"> 
                    <span class="my-auto">CSV</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#std_attend_report_table<?= $cls['id']; ?>" data-filename="<?= $cls['class']; ?> Students Attendance-<?=  now_time($user['id']); ?>"> 
                    <span class="my-auto">PDF</span>
                </a>
            </div>
        </div>


        <div class="aitsun_table w-100 pt-0 mb-4">

            <table class="erp_table sortable" id="std_attend_report_table<?= $cls['id']; ?>">
                <thead>
                    
                    <tr> 

                        <th>
                            <b>Name/Dates</b>
                        </th>

                        <?php foreach (get_dates_of_month_array( $at_date,'day_number' ) as $dt): ?>
                            <th> <?= $dt; ?> </th>
                            <?php if (get_date_format(timetest($at_date),'d')==$dt):
                                break;
                            endif ?>
                        <?php endforeach ?>

                    </tr> 
                </thead>
                <tbody>

                    <?php foreach (students_array_of_class(company($user['id']),$cls['id']) as $std): ?>
                    <tr>
                        <td>
                            <b><?= user_name($std['student_id']); ?></b> 
                        </td>


                         <?php 
                                
                            foreach (get_dates_of_month_array($at_date,'day_number') as $dt): 

                            $dates=get_date_format($at_date,'Y').'-'.get_date_format($at_date,'m').'-'.$dt;
                             
                        ?>


                        
                            <?php if (get_student_attendance_data_by_date($std['student_id'],$dates,'attendance')==1 && get_student_attendance_data_by_date($std['student_id'],$dates,'attendance2')==1): ?>
                                
                                <td class="text-white bg-success"><b>P</b></td>

                            <?php elseif (get_student_attendance_data_by_date($std['student_id'],$dates,'attendance')==1 && get_student_attendance_data_by_date($std['student_id'],$dates,'attendance2')==0): ?>

                                <td class="text-black bg-warning"><b>H</b></td>

                            <?php elseif (get_student_attendance_data_by_date($std['student_id'],$dates,'attendance')==0 && get_student_attendance_data_by_date($std['student_id'],$dates,'attendance2')==1): ?>

                                <td class="text-black bg-warning"><b>H</b></td>

                            <?php elseif (get_student_attendance_data_by_date($std['student_id'],$dates,'attendance')==0 && get_student_attendance_data_by_date($std['student_id'],$dates,'attendance2')==0): ?>

                                <td class="text-white bg-danger"><b>A</b></td>

                            <?php else: ?>

                                <td><b> &#8722;</b></td>

                            <?php endif ?>
                        



                        <?php if (get_date_format(timetest($at_date),'d')==$dt):
                            break;
                        endif ?>

                        <?php endforeach ?>

                       
                    </tr>
                    <?php endforeach ?>
                    

                </tbody>                   
            </table>


        </div>

        <?php endforeach ?>
    </div>
</div>
