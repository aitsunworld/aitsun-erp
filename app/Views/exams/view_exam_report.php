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
                    <a href="<?= base_url('exams'); ?>" class="href_loader">Exams</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="<?= base_url('exams/exam_report'); ?>" class="href_loader">Report</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= class_name($class_id) ?></b>
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


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="main_page_content">
    <div class="aitsun-row">
        <div class="col-md-12">
             <h5 class="text-center mb-3">Exams mark list of <?= class_name($class_id) ?> (<?= year_of_academic_year(academic_year($user['id'])) ?>)</h5>
        </div>



        <?php foreach ($all_exams_of_class as $me): ?> 
         <div class="card col-md-12 mb-3">
            <div class="card-body p-2">

                <div style="position: absolute;top: 15px;right: 8px;">
                     <a href="javascript:void(0);" class="aitsun_table_export text-white p-1 rounded font-size-footer btn-success me-2" data-type="excel" data-table="#excelexamtimetable" data-filename="Exams mark list of <?= class_name($class_id) ?>-<?= $me['exam_name'] ?> (<?= year_of_academic_year(academic_year($user['id'])) ?>)"> 
                        <span class="my-auto">Excel</span>
                    </a>

                </div> 

                    <div class="aitsun_table table-responsive">
                        <table class="erp_table sortable" id="excelexamtimetable">
                           <tbody> 
                                <tr>
                                    <td scope="col" style="border-right: 1px solid #ffffff!important;"><h5><?= $me['exam_name'] ?></h5></td>   
                                    
                                </tr>
                                <tr>
                                    <td scope="col"><b>Student</b></td> 
                                    <?php foreach (exams_of_main_exam(company($user['id']),$me['id'],$class_id) as $sb): ?>
                                        <td scope="col"><?= subjects_name($sb['exam_for_subject']) ?></td> 
                                    <?php endforeach ?>
                                    
                                </tr>
                            
                                <?php foreach (students_array_of_class(company($user['id']),$class_id) as $st): ?> 
                                <tr>  
                                    <td><?= user_name($st['student_id']) ?></td> 
                                    <?php foreach (exams_of_main_exam(company($user['id']),$me['id'],$class_id) as $sb): ?>
                                        <td>
                                            <span class="
                                            <?php if($sb['exammarks']=='grade'): ?>
                                                <?php if (value_of_grade(aggregate_marks(company($user['id']),$st['student_id'],$sb['id'],$sb['exam_for_subject']),company($user['id']))>=value_of_grade($sb['min_grade'],company($user['id']))){echo "text-success"; }else{ echo "text-danger";} ?>"> 
                                            <?php else: ?>
                                            <?php if (aggregate_marks(company($user['id']),$st['student_id'],$sb['id'],$sb['exam_for_subject'])>=$sb['min_marks']){echo "text-success"; }else{ echo "text-danger";} ?>">
                                            <?php endif ?>
                                                <?= aggregate_marks(company($user['id']),$st['student_id'],$sb['id'],$sb['exam_for_subject']) ?> 
                                            </span>
                       
                                        </td> 
                                    <?php endforeach ?>
                                </tr> 
                                <?php endforeach ?>                                                  
                            </tbody>
                       </table>
                   </div>
            </div>
        </div>
        <?php endforeach ?>

        
        

    </div>
</div>