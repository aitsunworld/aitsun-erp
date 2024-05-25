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
             
                <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url('student-master') ?>?page=1" class="href_loader">Student Master</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Students Reports</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#student_report" data-filename="Student Report"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#student_report"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
    
<div id="filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>

                <select class="form-control form-control-sm"name="stdyear">
                    <option value="" selected>Academic Year</option>
                     <?php foreach (academic_year_array(company($user['id'])) as $acy): ?>
                        <option value="<?= $acy['id']; ?>"><?= $acy['year']; ?></option>
                    <?php endforeach ?>
                </select>
                <select class="form-control form-control-sm" name="stdcls">
                    <option value="" selected>Class</option>
                     <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                        <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                    <?php endforeach ?>
                </select>

                <input type="text" name="stdname" class="form-control form-control-sm filter-control " placeholder="Search Name">
            
             
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('student-reports') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>


 <div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table table_responsive col-12 w-100 pt-0 pb-5">
            
            <table id="student_report" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Academic Year</th>
                    <th class="sorticon">Reg.No</th>
                    <th class="sorticon">Admission.No</th> 
                    <th class="sorticon">Student Name</th> 
                    <th class="sorticon">Class</th> 
                    <th class="sorticon" >Roll No</th>
                    <th class="sorticon" >DOB</th>
                    <th class="sorticon">Age</th>
                    <th class="sorticon">Gender</th>
                    <th class="sorticon">Father Name</th>
                    <th class="sorticon">Mother Name</th>
                    <th class="sorticon">Contact</th>
                    <th class="sorticon">Address</th>
                    <th class="sorticon">Aadhar.No</th>
                    <th class="sorticon">Blood Group</th>
                    <th class="sorticon">DOJ</th>
                </tr>
             
             </thead>
              <tbody>
                <?php $i=0; foreach ($students_data as $sta): $i++; ?>
                    <tr>
                        <th><?= year_of_academic_year($sta['academic_year']) ?></th>
                        <td scope="row"><b><?= school_code(company($user['id'])) ?><?= location_code(company($user['id'])) ?><?= get_student_data(company($user['id']),$sta['student_id'],'serial_no'); ?></b></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'admission_no'); ?></td>
                        <td><?= $sta['first_name']; ?></td>
                        
                        <td><?= class_name(current_class_of_student_by_year(company($user['id']),$sta['student_id'],$sta['academic_year'])) ?></td>
                        <td><?= $sta['roll_no']; ?></td>
                        <td><?= get_date_format(get_student_data(company($user['id']),$sta['student_id'],'date_of_birth'),'d M Y'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'stdage'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'gender'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'father_name'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'mother_name'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'phone'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'billing_address'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'adhar'); ?></td>
                        <td><?= get_student_data(company($user['id']),$sta['student_id'],'blood_group'); ?></td>
                        <td><?= get_date_format(get_student_data(company($user['id']),$sta['student_id'],'date_of_join'),'d M Y') ?></td>
                        
                    </tr>
                <?php endforeach ?>
                <?php if ($i==0): ?>
                    <tr>
                        <td colspan="14" class="text-center p-3 text-danger">No Students</td>
                    </tr>
                <?php endif ?>
                 
              </tbody>
            </table>
        </div>

        

    </div>
 </div>


 <!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info');?>" class="text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon');?>" class="text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->