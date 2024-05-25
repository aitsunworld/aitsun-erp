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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url('student-master'); ?>" class="href_loader">Student Master</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Students Edit</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#student_edit_fliter"> 
            <span class="my-auto">Filter</span>
        </a>
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
<?php if (session()->get('pu_msg')): ?>
    <script type="text/javascript">
        popup_message('success','Done',"<?= session()->get('pu_msg'); ?>"); 
    </script>
<?php endif ?>

<?php if (session()->get('pu_er_msg')): ?> 
    <script type="text/javascript">
        popup_message('error','Failed',"<?= session()->get('pu_er_msg'); ?>"); 
    </script>
<?php endif ?>

        
<div id="student_edit_fliter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>

            <input type="text" name="student_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Student Name'); ?>" class=" filter-control form-control  w-100">

             <select class="form-select" name="classes">
                    <option value="" selected>Select class</option> 
                     <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                        <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                    <?php endforeach ?>
            </select>

            <button class="href_long_loader btn-dark btn-sm">
                <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
            </button>
            
            <a class="btn btn-outline-dark my-auto" href="<?= base_url('/student-master/easy_edit') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
          
        </form>
        <!-- FILTER -->
    </div>  
</div>



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="student_edit_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th class="">Admission Number</th>
                        <th class="">Student Name</th>
                        <th class="">Mother Name</th> 
                        <th class="">Father Name</th> 
                        <th class="">Gender</th> 
                        <th class="">Class</th> 
                        <th class="">Contact No</th> 
                        <th class="">Joined on</th> 
                    </tr>
                 
                 </thead>
                <tbody>

                   <?php $i=0; foreach ($student_data as $s_data): $i++; ?>
                    <tr>
                        <td>
                            <input type="text" class="easy_stu_update aitsun-simple-input py-1 add_cls-admission_no-<?= $s_data['student_id']; ?>"  name="admission_no" data-student_id="<?= $s_data['student_id']; ?>" data-classtableid="<?= $s_data['id']; ?>" data-table='user' data-p_element="admission_no" value="<?= get_student_data(company($user['id']),$s_data['student_id'],'admission_no') ?>">
                        </td>
                        <td>

                            <input type="text" class="easy_stu_update aitsun-simple-input add_cls-student_name-<?= $s_data['student_id']; ?>"  name="student_name" data-student_id="<?= $s_data['student_id']; ?>" data-classtableid="<?= $s_data['id']; ?>" data-table='both' data-p_element="student_name" value="<?= user_name($s_data['student_id']) ?>">
                        </td>
                        <td>
                             <input type="text" class="easy_stu_update aitsun-simple-input add_cls-mother_name-<?= $s_data['student_id']; ?>"  name="mother_name" data-student_id="<?= $s_data['student_id']; ?>" data-p_element="mother_name" data-classtableid="<?= $s_data['id']; ?>" data-table='user' value="<?=  get_student_data(company($user['id']),$s_data['student_id'],'mother_name') ?>">
                        </td>
                        <td>
                             <input type="text" class="easy_stu_update aitsun-simple-input add_cls-father_name-<?= $s_data['student_id']; ?>"  name="father_name" data-student_id="<?= $s_data['student_id']; ?>" data-p_element="father_name" data-classtableid="<?= $s_data['id']; ?>" data-table='user' value="<?=  get_student_data(company($user['id']),$s_data['student_id'],'father_name')  ?>">
                        </td>
                        <td>

                            <div class="">
                                <div class="form-group mb-2">
                                   <select class="aitsun-simple-input easy_edit_student add_cls-gender-<?= $s_data['student_id']; ?>" name="gender" data-student_id="<?= $s_data['student_id']; ?>" data-p_element="gender" data-classtableid="<?= $s_data['id']; ?>" data-table='both'>
                                        <option value="male" <?php if (get_student_data(company($user['id']),$s_data['student_id'],'gender') == 'male') {echo 'selected';} ?>>Male</option>
                                        <option value="female" <?php if (get_student_data(company($user['id']),$s_data['student_id'],'gender') == 'female') {echo 'selected';} ?>>Female</option>
                                        <option value="other" <?php if (get_student_data(company($user['id']),$s_data['student_id'],'gender') == 'other') {echo 'selected';} ?>>Other</option>
                                    </select>
                              </div>
                            </div>


                        </td>
                        <td>

                                                    
                            <select class="aitsun-simple-input easy_edit_student add_cls-class-<?= $s_data['student_id']; ?>" name="class" data-student_id="<?= $s_data['student_id']; ?>" data-p_element="class" data-classtableid="<?= $s_data['id']; ?>" data-table='both'>
                                     <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                        <option value="<?= $tcr['id']; ?>" <?php if ($tcr['id']==current_class_of_student(company($user['id']),$s_data['student_id'])) {echo 'selected';} ?>><?= $tcr['class']; ?></option>
                                    <?php endforeach ?>
                            </select>          

                           
                            
                        </td>
                        <td>
                           <input type="text" class="easy_stu_update aitsun-simple-input add_cls-phone-<?= $s_data['student_id']; ?>"  name="phone" data-student_id="<?= $s_data['student_id']; ?>" data-p_element="phone" data-classtableid="<?= $s_data['id']; ?>" data-table='user' value="<?= get_student_data(company($user['id']),$s_data['student_id'],'phone'); ?>">
                        </td>
                        <td>
                             <input type="date" class="easy_stu_update aitsun-simple-input add_cls-date_of_join-<?= $s_data['student_id']; ?>"  name="date_of_join" data-student_id="<?= $s_data['student_id']; ?>" data-p_element="date_of_join" data-classtableid="<?= $s_data['id']; ?>" data-table='user' value="<?= get_date_format(get_student_data(company($user['id']),$s_data['student_id'],'date_of_join'),'Y-m-d') ?>">
                        </td>
                        
                    </tr>

                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="8"><h6 class="p-4 text-center text-danger">No Students Records... </h6></td>
                        </tr>
                    <?php endif ?>

                    
                     
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 