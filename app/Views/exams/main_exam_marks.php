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
                    <a href="<?= base_url('exams/main_exam'); ?>" class="href_loader">Exams</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url('exams/main_exam_time_table'); ?>/<?= $exam_class_sub['main_exam_id']; ?>" class="href_loader"><?= get_main_exam_data($exam_class_sub['main_exam_id'],'exam_name'); ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= subjects_name($exam_class_sub['exam_for_subject']); ?></b>
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


 <form action="<?= base_url('exams/add_main_exam_mark'); ?>" method="post">
                        <?= csrf_field() ?>
<input type="hidden" name="exam_id" value=" <?= $exam_class_sub['id']; ?>">
<input type="hidden" name="exam_mark_type" value="">


<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div>
        

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#main_exam_marks_table"> 
            <span class="my-auto">Quick search</span>
        </a>
        
    </div>


    <div class="d-flex">
         <div class="d-flex me-2">          
            <input type="checkbox" value="1" name="markvaluate" <?php if (isavaluated(company($user['id']),$exam_class_sub['id'])==1) {echo 'checked';} ?> id="mark_as_value">
            <label for="mark_as_value" class="aitsun-fw-bold ms-1 my-auto">Mark as valuated</label>
        </div>
        <button class="aitsun-primary-btn py-0 mrk_bt"  type="submit" name="submit">Submit</button>
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">

            <table id="main_exam_marks_table" class="erp_table sortable">

                <thead>
                    <tr>
                        <th class="sorticon" style="width:150px;">S.No.</th>
                        <th class="sorticon" style="width:150px;">Registration no.</th>
                        <th class="sorticon">Student name</th>
                        <th class="sorticon" style="width:150px;">Marks </th> 
                        <th class="sorticon" data-tableexport-display="none">Leave</th> 
                    </tr>
                 </thead>

                 <tbody>  
                     <?php  $data_count=0; ?> 
                    <?php foreach (students_array_of_class(company($user['id']),$exam_class_sub['exam_for_class']) as $std){ $data_count++; ?>   

                    <tr>
                        <td><?= $data_count; ?></td>
                        <td><?= school_code(company($user['id']))?><?= location_code(company($user['id']))?><?= get_student_data(company($user['id']),$std['student_id'],'serial_no'); ?></td>

                        <td><?= get_student_data(company($user['id']),$std['student_id'],'first_name'); ?>
                            <input type="hidden" name="student_id[]" value="<?= get_student_data(company($user['id']),$std['student_id'],'id'); ?>">
                            <input type="hidden" name="subject_id" value="<?= $exam_class_sub['exam_for_subject']; ?>">
                        </td>

                        <td>
                            <input type="number" class="" name="marks[]" min="0" step="0.01" placeholder="Marks" value="<?= get_marks_valuation_array(company($user['id']),$exam_class_sub['id'],get_student_data(company($user['id']),$std['student_id'],'id'),$exam_class_sub['exam_for_subject']); ?>" >


                        </td>

                        <td data-tableexport-display="none">
                            <div class="ml-3 mt-2">
                                <input type="checkbox" class="mt-1 mr-1 checkingabsentbox" <?php if (sub_exam_absent(company($user['id']),$exam_class_sub['id'],get_student_data(company($user['id']),$std['student_id'],'id'),$exam_class_sub['exam_for_subject'])) { echo 'checked';} ?>>

                                    <input class="mt-1 mr-1 absentcheckinput" name="absent[]" type="hidden"  value="<?php if (sub_exam_absent(company($user['id']),$exam_class_sub['id'],get_student_data(company($user['id']),$std['student_id'],'id'),$exam_class_sub['exam_for_subject'])) { echo '1';}else{echo '0';} ?>">
                                   
                                <label for="checkbox1">Absent</label>
                            </div>
                        </td>
                    </tr>
                     <?php } ?>
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="5">
                                <span class="text-danger">No students</span>
                            </td>
                        </tr>
                    <?php endif ?>
                    
                </tbody>

            </table>
        </div>
    </div>
</div>
</form>