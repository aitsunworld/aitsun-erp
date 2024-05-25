<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Health</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#health_table" data-filename="Aitsun Keys"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#health_table" data-filename="Aitsun Keys"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#health_table" data-filename="Aitsun Keys"> 
            <span class="my-auto">PDF</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
       
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#health_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

      
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    
                    
                      <select id="classselect" class="form-control">
                            <option value="">Select Class</option>
                            <?php foreach (classes_array(company($user['id'])) as $ac): ?>
                                <option value="<?= $ac['id']; ?>" <?php if ($_GET) { if (isset($_GET['class'])) {if ($_GET['class']==$ac['id']) { echo 'selected'; }}} ?>><?= $ac['class'] ?></option>
                            <?php endforeach ?>
                        </select>
                     

                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('health') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
        <div class="aitsun_table table-responsive col-12 w-100 pt-0 pb-5">
            
            <table id="health_table" class="erp_table no-wrap">
                 <thead>
                    <tr>
                        <th class="">Reg. No</th>
                        <th class="">Name</th>
                        <th class="">Gender</th>
                        <th class="">Class</th>
                        <th class="">Age</th>
                        <th class="">Weight(kg)</th>
                        <th class="">Height(cm)</th>
                        <th class="text-center ">Status</th>
                    </tr>
                 </thead>
                  <tbody>
                    <?php 
                        if ($_GET) {
                            if (isset($_GET['class'])) {
                        ?>
                            <?php if (count($students)==0): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-danger">No data found</td>
                                </tr>
                            <?php endif ?>
                            <?php foreach ($students as $st): ?>
                             <tr>
                                <td><?= school_code(company($user['id']))?><?= location_code(company($user['id']))?><?= get_student_data(company($user['id']),$st['student_id'],'serial_no') ?></td>
                                <td><?= get_student_data(company($user['id']),$st['student_id'],'first_name') ?></td>
                                <td><?= get_student_data(company($user['id']),$st['student_id'],'gender') ?></td>
                                <td><?= class_name(current_class_of_student(company($user['id']),$st['student_id'])) ?></td>
                                
                                <td><?= age_of_student(get_student_data(company($user['id']),$st['student_id'],'date_of_birth'),get_date_format(now_time($user['id']),'d-m-Y')); ?></td>
                                <td><input type="number" min="1" class="health_box health_weight form-control" data-student_id="<?= $st['student_id']; ?>"  value="<?= get_health_data(company($user['id']),$st['student_id'],'weight') ?>"></td>
                                
                                <td><input type="number" min="1" class="health_box health_height form-control" data-student_id="<?= $st['student_id']; ?>"  value="<?= get_health_data(company($user['id']),$st['student_id'],'height') ?>"></td>
                                <td><?= calculate_BMI(get_health_data(company($user['id']),$st['student_id'],'weight'),get_health_data(company($user['id']),$st['student_id'],'height'),age_of_student(get_student_data(company($user['id']),$st['student_id'],'date_of_birth'),get_date_format(now_time($user['id']),'d-m-Y')),get_student_data(company($user['id']),$st['student_id'],'gender'),'badge') ?></td>
                                
                             </tr>
                             <?php endforeach ?>
                         <?php }else{
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center text-danger p-20"><b>Please select class</b></td>
                                </tr>
                            <?php
                         }}else{
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center text-danger p-20"><b>Please select class</b></td>
                                </tr>
                            <?php
                        } ?>
                    
                  </tbody>
            </table>
        </div>        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
