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
                    <b class="page_heading text-dark">Student Master</b>
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
    <div class="d-flex">
        
        
            <div class="my-auto">
                <form method="get">
                    <?= csrf_field(); ?>
                    <button  class="text-dark btn-top-bar font-size-footer me-2" name="get_excel" > 
                        <span class="my-auto">Excel</span>
                    </button>
                </form>
            </div>

        <a href="<?= base_url('import_and_export') ?>/students" class="aitsun_table_export text-dark font-size-footer me-2 my-auto"> 
            <span class="my-auto">Export/Import</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2 my-auto" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2 my-auto" data-table="#student_table"> 
            <span class="my-auto">Quick search</span>
        </a>

        <a href="<?= base_url('student-master/easy_edit') ?>?page=1" class=" text-dark font-size-footer me-2 my-auto"> 
            <span class="my-auto">Easy Edit</span>
        </a>

    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#studentaddmodal" class="text-dark font-size-footer ms-2 my-auto"> <span class="my-auto">+ New student</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            

             <select class="form-select" name="classes">
                    <option value="" selected>Select class</option> 
                     <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                        <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                    <?php endforeach ?>
            </select>


              <input type="text" name="serachstudent" class="form-control-sm form-control filter-control" placeholder="Search Name">
            
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('student-master') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>


<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="studentaddmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="studentaddmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="studentaddmodalLabel">Add student</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form  id="add_student_form" action="<?= base_url('student-master/add_student'); ?>/<?= $user['company_id'] ?>">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-md-3 mb-2">
                        <label for="profile">Student Profile(Below 500kb)</label>
                        <input type="file" accept="image/*" class="form-control" id="select_student_img" name="student_img" style="padding: 6px;">
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="stdname">Student Full Name  </label>
                        <input type="text" class="form-control" name="stdname" id="stdname" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="date_of_birth">Date of Birth </label>
                        <input type="date" class="form-control date_of_birth" data-bxid="" name="date_of_birth" id="date_of_birth" >
                    </div>
                  

                    <div class="form-group col-md-3 mb-2">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" name="age" id="age"  readonly>
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="fathername">Father Name </label>
                        <input type="text" class="form-control" name="fathername" id="fathername" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="mothername">Mother Name </label>
                        <input type="text" class="form-control" name="mothername" id="mothername" >
                    </div>

                    <fieldset class="form-group col-md-3 mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Gender </label>
                        </div>
                        <div class="col-sm-12 d-flex mt-2 ml-3">
                            <div class="me-2">
                                <input type="radio" name="gender" id="gender" value="male" checked>
                                <label for="gender">
                                   Male
                                </label>
                            </div>
                            <div class="me-2">
                                <input type="radio" name="gender" id="gender" value="female">
                                <label for="gender">
                                   Female
                                </label>
                            </div>
                            <div class="me-2">
                                <input type="radio" name="gender" id="gender" value="others">
                                <label for="gender">
                                   Others
                                </label>
                            </div>
                            
                        </div>
                    </div>
                    </fieldset>

                    <div class="form-group col-md-3 mb-2">
                        <label for="mobileno">Contact </label>
                        <input type="number" class="form-control" name="mobileno" id="mobileno" >
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="mobileno">Additional Contact </label>
                        <input type="number" class="form-control" name="phone2" >
                    </div>
                   <!--  <div class="form-group col-md-3 mb-2">
                        <label for="email">Email/Username</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                    </div> -->

                    <!-- <div class="form-group col-md-3 mb-2">
                        <label for="password">Password </label>
                        <input type="text" class="form-control" name="password" id="" placeholder="password ">
                    </div> -->


                    <div class="form-group col-md-3 mb-2">
                        <label for="classes">Select Class </label>
                        
                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required name="classes">
                                <option value="">Select Class</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>
                        
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="admission_no">Admission Number</label>
                        <input type="text" class="form-control" name="admission_no" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="date_of_join">Joined on: </label>
                        <input type="date" class="form-control" name="date_of_join" id="date_of_join" value="<?= get_date_format(now_time($user['id']),'Y-m-d') ?>">
                    </div>


                    <div class="form-group col-md-3 mb-2">
                        <label for="category">Select Category </label>
                        <select class="form-select stdcat" name="category" data-stid="" id="category" required>
                            <option value="">Choose Category</option>
                            <?php foreach (student_category_array(company($user['id'])) as $stc): ?>
                                <option value="<?= $stc['id']; ?>"><?= $stc['category_name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        
                        
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="subcategory">Select Sub Category</label>
                        <select class="form-select" name="subcategory" data-stid="" id="subcategory" >
                            <option value="">Choose sub category</option>
                            
                        </select>
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="religion">Religion</label>
                        <input type="text" class="form-control" name="religion" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="aadhar_no">Aadhar Number</label>
                        <input type="text" class="form-control" name="aadhar_no">
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="ration_card_no">Ration Card Number</label>
                        <input type="text" class="form-control" name="ration_card_no">
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="account_number">Bank Account Number</label>
                        <input type="text" class="form-control" name="account_number" >
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="ifsc">Bank IFSC Code</label>
                        <input type="text" class="form-control" name="ifsc" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="blood_gp">Blood Group</label>
                        <input type="text" class="form-control" name="blood_gp" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                       <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                  
                      <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="input-5">
                    </div>


                    <div class="form-group col-md-3 mb-2">
                        <label>Type</label>
                      <select class="form-select" name="opening_type">
                          <option value="">To Collect</option>
                          <option value="-">To Pay</option>
                      </select>

                    </div>

                    <div class="form-group col-md-12">
                            <label for="address">Address </label>
                            <textarea class="form-control" aria-label="address" required="required" id="address" name="address"></textarea>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" data-from="organisation" id="add_student_new">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row ">

        <div class="aitsun_table table-responsive w-100 pt-0">
            
            <table id="student_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon" style="width:55px;">#</th>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Adm. No.</th>
                    <th class="sorticon">Student Name</th> 
                    <th class="sorticon">Class</th> 
                    <th class="sorticon">Contact No</th> 
                    <th class="sorticon">Op. balance</th>
                    <th class="sorticon">Cl. balance</th>
                    <th class="sorticon no_print" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>

             <tbody>
                <?php  $data_count=0; ?>

                <?php  foreach ($student_data as $st) { $data_count++; $join_date=get_student_data(company($user['id']),$st['student_id'],'date_of_join'); ?>
                <tr >
                    <td><?= $data_count; ?></td>
                    <td><?= school_code(company($user['id']))?><?= location_code(company($user['id']))?><?= get_student_data(company($user['id']),$st['student_id'],'serial_no'); ?></td>
                    <td><?= get_student_data(company($user['id']),$st['student_id'],'admission_no') ?></td>
                    <td><a href="<?= base_url('student-master/student_details') ?>/<?= $st['student_id']; ?>" class="aitsun_link">
                            <?= user_name($st['student_id']) ?>
                        </a></td>
                    <td><?= class_name(current_class_of_student(company($user['id']),$st['student_id'])) ?></td>
                    <td><?= get_student_data(company($user['id']),$st['student_id'],'phone'); ?></td>
                    <td>
                        <?php 
                            $opcl_class='text-success';
                            if (aitsun_round(get_student_data(company($user['id']),$st['student_id'],'opening_balance'),get_setting(company($user['id']),'round_of_value'))<0){
                                $opcl_class='text-danger';
                            }
                        ?>
                        <span class="<?= $opcl_class ?>"><?= str_replace('-', '', aitsun_round(get_student_data(company($user['id']),$st['student_id'],'opening_balance'),get_setting(company($user['id']),'round_of_value'))); ?></span>
                    </td>
                    <td>
                        <?php 
                            $opcl_class='text-success';
                            if (aitsun_round(get_student_data(company($user['id']),$st['student_id'],'closing_balance'),get_setting(company($user['id']),'round_of_value'))<0){
                                $opcl_class='text-danger';
                            }
                        ?>
                        <span class="<?= $opcl_class ?>"><?= str_replace('-', '', aitsun_round(get_student_data(company($user['id']),$st['student_id'],'closing_balance'),get_setting(company($user['id']),'round_of_value'))); ?></span>
                    </td>
                    <td>

                        <div class="p-1 text-center">
                            <a class=" btn-edit-dark me-1 action_btn cursor-pointer student_fee_data" data-href="<?= base_url('student-master/student_fees_details') ?>/<?= $st['student_id']; ?>/view" data-download_href="<?= base_url('student-master/student_fees_details') ?>/<?= $st['student_id']; ?>/download">Fees detail</a>

                            <a data-bs-toggle="collapse" data-bs-target="#student_details<?= $st['id'] ?>" class="accordion-toggle btn-show  me-1 py-1 px-2 rounded cursor-pointer student_other_data" data-student_id="<?= $st['student_id'] ?>"><i class="bx bx-show-alt"></i></a>

                            <a class="btn-purple me-1 action_btn cursor-pointer promote_stu_data" data-bs-toggle="modal" data-bs-target="#promote<?= $st['id'] ?>" data-student_id="<?= $st['student_id'] ?>">Promote</a>

                            

                            <a class=" btn-edit-dark me-1 action_btn cursor-pointer edit_stu_data" data-bs-toggle="modal" data-bs-target="#studentedit<?= $st['id'] ?>" data-student_id="<?= $st['student_id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                    
                            <a class="deletestudent btn-delete-red action_btn cursor-pointer" data-student_id="<?= $st['student_id']; ?>"  data-deleteurl="<?= base_url('student-master/deletestudent'); ?>/<?= $st['student_id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>


                        <!-- ////////////////////////// STUDENT PROMOTE MODAL ///////////////////////// -->
                        <div class="modal fade" id="promote<?=  $st['id'] ?>">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="promote<?=  $st['id'] ?>"><?= get_student_data(company($user['id']),$st['student_id'],'first_name') ?></h5>

                                        <button type="button" class="close" data-bs-dismiss="modal">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </div>


                                    <form id="promote_form<?= $st['id'] ?>" action="<?= base_url('student-master/promote'); ?>/<?= get_student_data(company($user['id']),$st['student_id'],'id') ?>">
                                            <?= csrf_field(); ?>
                                        <div class="modal-body text-start">

                                            <div id="promote_student_data<?= $st['student_id'] ?>">
                            
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer text-start py-1">
                                            <button type="button" class="aitsun-primary-btn promote_student" data-id="<?=  $st['id'] ?>">Promote</button>
                                        </div>



                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- ////////////////////////// STUDENT PROMOTE MODAL ///////////////////////// -->


                         <!-- ////////////////////////// STUDENT EDIT MODAL ///////////////////////// -->

                            <div class="modal fade" id="studentedit<?= $st['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="studenteditLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content text-start">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="studenteditLabel"><?= get_student_data(company($user['id']),$st['student_id'],'first_name') ?></h5>    
                                    <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form id="edit_student_form<?= $st['id'] ?>" action="<?=  base_url('student-master/update_student') ?>/<?= $st['student_id'] ?>">
                                        <?= csrf_field() ?>
                                    <div class="modal-body">

                                         <div id="edit_student_data<?= $st['student_id'] ?>">
                            
                                        </div>


                                    </div>
                                    <div class="modal-footer text-start py-1">
                                        <button type="button" class="aitsun-primary-btn edit_student" data-id="<?=  $st['id'] ?>">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        <!-- ////////////////////////// STUDENT EDIT MODAL ///////////////////////// -->

                        

                        
                    </td>
                </tr>
                    
                <tr>
                    <td colspan="12" class="hiddenRow">
                        <div class="accordian-body collapse" id="student_details<?= $st['id'] ?>">
                            <div class="bg-white" id="hide_student_data<?= $st['student_id'] ?>">
                            
                            </div>
                        </div> 
                    </td>
                </tr>

                <?php } ?>

                

                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="9">
                            <span class="text-danger">No students</span>
                        </td>
                    </tr>
                <?php endif ?>
       
            </tbody>
             
            </table>
        </div>

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('student-reports'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-user ms-2"></i> <span class="my-auto">Students Reports</span></a>/
        <a href="<?= base_url('category-report'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book ms-2"></i> <span class="my-auto">Category Wise Report</span></a>
    </div>
    
    <div>
        <span class="m-0 font-size-footer">Total students : <?= total_students(company($user['id'])); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->



<div class="modal fade" id="fees_selection_modal">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addsubjectmodelLabel">Select fees</h5>
                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row" id="fees_box">
                    
                </div>
                
            </div>
        </div>
    </div>
</div>


<div class="modal  fade" id="pdf_modal"  aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title w-100"><div class="d-flex justify-content-between"><div>Fees details</div> <div id="do_btn"></div></div></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">

        

        <div id="pdf_show">
        </div>

      </div>
    </div>
  </div>
</div>
