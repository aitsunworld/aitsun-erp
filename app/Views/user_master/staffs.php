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
                    <b class="page_heading text-dark">User Master</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#staffs_table" data-filename="Staffs"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#staffs_table" data-filename="Staffs"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#staffs_table" data-filename="Staffs"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#staffs_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#bookaddmodal" class="text-dark font-size-footer ms-2 my-auto"> <span class="my-auto">+ New staff</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


    <div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
              <form method="get" class="d-flex">
                <?= csrf_field(); ?>
                
                 <select class="form-select" name="usertype">
                        <option value="" selected>User type</option>
                        <option value="">Select user type</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff/Normal user</option> 
                </select>


                <input type="text" name="serachname" class="form-control-sm form-control filter-control" placeholder="Search Name">
                
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                  <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('user_master') ?>?page=1"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                
                
              </form>
            <!-- FILTER -->
        </div>  
    </div>




<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="bookaddmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="bookaddmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bookaddmodalLabel">Add staff</h5>    
            <button type="button" class="btn-close close_school href_loader" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_staff_form" action="<?= base_url('user_master/add_staff'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
              <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-4 mb-2">
                        <label class="font-weight-semibold" for="profile">Profile</label>
                          <input type="file" accept="image/*" class="form-control" name="user_img" style="padding: 6px;">
                    </div> 

                    <div class="form-group col-md-4 mb-2">
                        <label class="font-weight-semibold" for="name">Name</label>
                        <input type="text" class="form-control" name="staff_name" >
                    </div>

                    <div class="form-group col-md-4 mb-2">
                        <label class="font-weight-semibold" for="email_phone">Email</label>
                        <input type="email" class="form-control" name="staff_email" >
                    </div>
                     <div class="form-group col-md-4 mb-2">
                        <label class="font-weight-semibold" for="password">Password</label>
                        <input type="text" class="form-control" name="password" >
                    </div>

                    

                    <div class="form-group col-md-4 mb-2">
                        <label class="font-weight-semibold" for="date_of_join">Joined on:</label>
                        <input type="date" class="form-control" name="date_of_join">
                    </div>
                     

                    <fieldset class="form-group col-md-4 mb-2">
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
                        <label class="font-weight-semibold" for="contact number">Phone number</label>
                        <input type="text" class="form-control" name="contact_number">
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label>User type</label>
                        <select class="form-select" name="u_type">
                            <option value="">Select user type</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff/Normal user</option> 
                        </select>
                    </div>


                    


                    <div class="form-group col-md-3 mb-2">
                       <label><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                        <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="input-5">
                    </div>


                    <div class="form-group col-md-3 mb-2">
                        <label>Type</label>
                        <select class="form-select" name="opening_type">
                          <option value="">To Collect</option>
                          <option value="-">To Pay</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <label class="font-weight-semibold" for="address">Address:</label>
                        <textarea class="form-control" name="address" placeholder="Address"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                       
                        <div class="d-flex ">
                             <p>Additional fields</p>
                            <div class="form-check form-switch cursor-pointer ms-4">
                                <input type="checkbox" class="form-check-input staff_additional" data-stfid="" name="staff_additional" value="1">
                            </div>
                            
                        </div>
                    </div>

                    <div class="d-none row" id="staff_additional_details">

                    <?php if (is_school(company($user['id']))): ?>
                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="main_subject">Main subject</label>

                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/subjects'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required name="main_subject">
                                <option value="">Select Subject</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>

                    </div>
                    <?php endif ?>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="phone2">Additional contact:</label>
                        <input type="text" class="form-control" name="phone2" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="date_of_birth">Date of Birth </label>
                        <input type="date" class="form-control date_of_birth" data-bxid="tc" name="date_of_birth" id="date_of_birthtc" >
                    </div>
                  

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="age">Age</label>
                        <input type="number" class="form-control" name="age" id="agetc" readonly>
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="category">Select Category </label>
                        <select class="form-select stdcat" name="category" data-stid="tc" id="category">
                            <option value="">Choose Category</option>
                            <?php foreach (student_category_array(company($user['id'])) as $stc): ?>
                                <option value="<?= $stc['id']; ?>"><?= $stc['category_name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        
                        
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="subcategory">Select Sub Category</label>
                        <select class="form-control" name="subcategory" data-stid="" id="subcategorytc" >
                            <option value="">Choose sub category</option>
                            
                        </select>
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="religion">Religion</label>
                        <input type="text" class="form-control" name="religion"  >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="designation">Designation</label>
                        <input type="text" class="form-control" name="designation" >
                    </div>

                    <?php if (is_school(company($user['id']))): ?>
                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="nature_of_appointment">Nature of appointment</label>
                        <input type="text" class="form-control" name="nature_of_appointment" >
                    </div>
                    <?php endif ?>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="qualification">Qualification</label>
                        <input type="text" class="form-control" name="qualification" >
                    </div>



                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="aadhar_no">Aadhar Number</label>
                        <input type="text" class="form-control" name="aadhar_no" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="account_number">Bank Account Number</label>
                        <input type="text" class="form-control" name="account_number" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="ifsc">Bank IFSC Code</label>
                        <input type="text" class="form-control" name="ifsc" >
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label class="font-weight-semibold" for="blood_gp">Blood Group</label>
                        <input type="text" class="form-control" name="blood_gp" >
                    </div>

                    </div>



                </div>
            </div>
          <div class="modal-footer text-start py-1">
            <button type="button" class="aitsun-primary-btn" id="add_staff">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="staffs_table" class="erp_table no-wrap sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Name</th>
                    <th class="sorticon">Email</th>
                    <th class="sorticon">Phone Number </th> 
                    <th class="sorticon">Designation</th> 
                    <th class="sorticon">Date of join</th> 
                    <th class="sorticon">User type</th> 
                    <th class="sorticon">Op. Bal</th> 
                    <th class="sorticon">Cl. Bal</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($company_members_array as $cmpuser) { $data_count++; ?>
                  <tr>
                    <td><?= $data_count; ?> </td>
                    <td><?= $cmpuser['display_name']; ?></td>
                    <td><?= $cmpuser['email']; ?></td>
                    <td><?= $cmpuser['phone']; ?></td>
                    <td><?= $cmpuser['designation']; ?></td>
                    <td><?= get_date_format($cmpuser['date_of_join'],'d M Y') ?></td>
                    <td class="text-capitalize"><?= $cmpuser['u_type']; ?></td>
                    <td> <?= currency_symbol(company($user['id'])); ?> <?= str_replace('-','',aitsun_round($cmpuser['opening_balance'],get_setting(company($user['id']),'round_of_value'))); ?>
                        
                         <small>
                               <?php if ($cmpuser['opening_balance']>0) {echo '(<span class="text-success">To collect</span>)';}elseif ($cmpuser['opening_balance']<0) {echo '(<span class="text-danger">To Pay</span>)';} ?>
                            </small>
                    </td>
                    <td>
                         <?= currency_symbol(company($user['id'])); ?> <?= str_replace('-','',aitsun_round($cmpuser['closing_balance'],get_setting(company($user['id']),'round_of_value'))); ?>
                            
                            
                            <small>
                               <?php if ($cmpuser['closing_balance']>0) {echo '(<span class="text-success">To collect</span>)';}elseif ($cmpuser['closing_balance']<0) {echo '(<span class="text-danger">To Pay</span>)';} ?>
                            </small>
                    </td>
                    <td class="text-end" style="width: 250px;" data-tableexport-display="none">
                        <div class="p-1">

                            <?php if (is_school(company($user['id']))): ?>
                            <a class="btn-success me-2 action_btn cursor-pointer send_pass_via_sms" data-uid="<?= $cmpuser['id'] ?>" data-phone="<?= $cmpuser['phone'] ?>">Credentials</a>
                            <?php endif ?>






                            <?php if ($cmpuser['id'] == $user['id']): ?>
                                <span class="badge bg-success rounded-pill " style="border-radius: 50px;"> <i class="bi bi-person-fill mr-1"></i> Me</span>
                                <?php endif ?>

                                <?php if ($user['u_type'] == 'admin'): ?>
                                  <?php if ($cmpuser['id'] != $user['id']): ?>
                                    <?php if (usertype($cmpuser['id']) != 'admin'): ?>

                                        <a title="Permission" class=" btn-info me-2 action_btn cursor-pointer href_loader" href="<?= base_url('permission'); ?>/<?= $cmpuser['id'] ?>">Permission</a>


                                <a title="Branch permission" class="btn-purple me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#branchpermission<?= $cmpuser['id'] ?>"><i class="bx bx-building-house"></i></a>

                            <a title="Permission" class=" btn-info me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#user_permission<?= $cmpuser['id'] ?>"><i class="bx bxs-key"></i></a>

                            <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#staff_edit<?= $cmpuser['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                    
                            <a class="delete_staff btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('user_master/delete_staff'); ?>/<?= $cmpuser['id']; ?>"><i class="bx bxs-trash"></i></a>




                                <?php endif ?>

                                <?php if ($user['author'] == 1): ?>

                                <?php if (usertype($cmpuser['id']) == 'admin'): ?>

                                   <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#staff_edit<?= $cmpuser['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                    
                            <a class="delete_staff btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('user_master/delete_staff'); ?>/<?= $cmpuser['id']; ?>"><i class="bx bxs-trash"></i></a>

                                <?php endif ?>

                                <?php endif ?>



                                
                              <?php endif ?>
                            <?php endif ?>








                            
                        </div>



                        <!-- ////////////////////////// STAFF EDIT MODAL ///////////////////////// -->

                            <div class="modal fade" id="staff_edit<?= $cmpuser['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staff_editLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content text-start">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staff_editLabel"><?= $cmpuser['display_name'] ?></h5>    
                                    <button type="button" class="btn-close close_school href_loader" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form id="edit_staff_form<?= $cmpuser['id'] ?>" action="<?=  base_url('user_master/update_staff') ?>/<?= $cmpuser['id'] ?>">
                                        <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <div class="row">

                                            <input type="hidden" name="current_closing_balance" value="<?= $cmpuser['closing_balance'] ?>">
                                            <input type="hidden" name="current_opening_balance" value="<?= $cmpuser['opening_balance'] ?>">

                                            <div class="form-group col-md-4 mb-2">
                                                <label class="font-weight-semibold" for="profile">Profile</label>
                                                <input type="hidden" name="old_profile_pic" value="<?=  $cmpuser['profile_pic'] ?>">
                                                  <input type="file" accept="image/*" class="form-control" name="user_img" style="padding: 6px;">
                                            </div> 

                                            <div class="form-group col-md-4 mb-2">
                                                <label class="font-weight-semibold" for="name">Name</label>
                                                <input type="text" class="form-control" name="staff_name" value="<?=  $cmpuser['display_name'] ?>">
                                            </div>

                                            <div class="form-group col-md-4 mb-2">
                                                <label class="font-weight-semibold" for="email_phone">Email</label>
                                                <input type="email" class="form-control" name="staff_email" value="<?=  $cmpuser['email'] ?>">
                                            </div>
                                             <div class="form-group col-md-4 mb-2">
                                                <label class="font-weight-semibold" for="password">Password</label>
                                                <input type="text" class="form-control" name="password"  value="">
                                            </div>

                                            

                                            <div class="form-group col-md-4 mb-2">
                                                <label class="font-weight-semibold" for="date_of_join">Joined on:</label>
                                                <input type="date" class="form-control" name="date_of_join" value="<?= get_date_format($cmpuser['date_of_join'],'Y-m-d') ?>">
                                            </div>
                                             

                                            <fieldset class="form-group col-md-4 mb-2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Gender </label>
                                                </div>
                                                <div class="col-sm-12 d-flex mt-2 ml-3">
                                                    <div class="me-2">
                                                        <input type="radio" name="gender" id="gender" value="male" <?php if($cmpuser['gender']=="male"){ echo "checked";}?>>
                                                        <label for="gender">
                                                           Male
                                                        </label>
                                                    </div>
                                                    <div class="me-2">
                                                        <input type="radio" name="gender" id="gender" value="female" <?php if($cmpuser['gender']=="female"){ echo "checked";}?>>
                                                        <label for="gender">
                                                           Female
                                                        </label>
                                                    </div>
                                                    <div class="me-2">
                                                        <input type="radio" name="gender" id="gender" value="others" <?php if($cmpuser['gender']=="others"){ echo "checked";}?>>
                                                        <label for="gender">
                                                           Others
                                                        </label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            </fieldset>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="contact number">Phone number</label>
                                                <input type="text" class="form-control" name="contact_number" value="<?= $cmpuser['phone'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label>User type</label>
                                                <select class="form-select" name="u_type">
                                                    <option value="">Select user type</option>
                                                    <option value="admin" <?php if ($cmpuser['u_type']=='admin'){echo 'selected'; }?>>Admin</option>
                                                    <option value="staff" <?php if ($cmpuser['u_type']=='staff'){echo 'selected'; }?>>Staff/Normal user</option> 
                                                </select>
                                            </div>


                                            


                                            <div class="form-group col-md-3 mb-2">
                                               <label><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                                                <input type="number" min="0" step="any" value="<?= str_replace('-','',aitsun_round($cmpuser['opening_balance'],get_setting(company($user['id']),'round_of_value'))); ?>" class="form-control " name="opening_balance" id="input-5">

                                                <input type="hidden" name="current_balance" value="<?= str_replace('-','',aitsun_round($cmpuser['opening_balance'],get_setting(company($user['id']),'round_of_value'))); ?>">
                                            </div>


                                            <div class="form-group col-md-3 mb-2">
                                                <label>Type</label>
                                                <select class="form-select" name="opening_type">

                                                  <option value="" <?php if ($cmpuser['opening_balance']>=0) {echo 'selected';} ?>>To Collect</option>

                                                  <option value="-" <?php if ($cmpuser['opening_balance']<0) {echo 'selected';} ?>>To Pay</option>

                                                </select>
                                            </div>

                                            <div class="form-group col-md-12 mb-3">
                                                <label class="font-weight-semibold" for="address">Address:</label>
                                                <textarea class="form-control" name="address" placeholder="Address"><?= $cmpuser['billing_address'] ?></textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                               
                                                <div class="d-flex ">
                                                     <p>Additional fields</p>
                                                    <div class="form-check form-switch cursor-pointer ms-4">
                                                        <input type="checkbox" class="form-check-input staff_additional" data-stfid="<?= $cmpuser['id'] ?>" name="staff_additional" value="1" <?php if ($cmpuser['saved_as']==1) { echo 'checked'; } ?>>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="<?php if ($cmpuser['saved_as']!=1) { echo 'd-none'; } ?> row" id="staff_additional_details<?= $cmpuser['id'] ?>">

                                            <?php if (is_school(company($user['id']))): ?>
                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="main_subject">Main subject</label>
                                                

                                                <div class="aitsun_select position-relative">
                                                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/subjects'); ?>">
                                                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
                                         
                                                    <select class="form-select" required name="main_subject">
                                                        <option value="">Select Subject</option> 
                                                        <option value="<?= $cmpuser['main_subject']; ?>" selected><?= subjects_name($cmpuser['main_subject']); ?></option>
                                                    </select>
                                                    <div class="aitsun_select_suggest">
                                                    </div>
                                                </div>


                                            </div>
                                            <?php endif ?>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="phone2">Additional contact:</label>
                                                <input type="text" class="form-control" name="phone2" value="<?= $cmpuser['phone_2'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="date_of_birth">Date of Birth </label>
                                                <input type="date" class="form-control date_of_birth" data-bxid="tc<?= $cmpuser['id'] ?>" name="date_of_birth" id="date_of_birthtc<?= $cmpuser['id'] ?>"  value="<?= $cmpuser['date_of_birth']; ?>" >
                                            </div>
                                          

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="age">Age</label>
                                                <input type="number" class="form-control" name="age<?= $cmpuser['id'] ?>" id="agetc<?= $cmpuser['id'] ?>" readonly value="<?= $cmpuser['stdage'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="category">Select Category </label>
                                                <select class="form-select stdcat" name="category" data-stid="tc<?= $cmpuser['id'] ?>" id="category">
                                                    <option value="">Choose Category</option>
                                                    <?php foreach (student_category_array(company($user['id'])) as $stc): ?>
                                                        <option value="<?= $stc['id']; ?>" <?php if ($cmpuser['category']==$stc['id']) {echo 'selected';} ?>><?= $stc['category_name']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                
                                                
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="subcategory">Select Sub Category</label>
                                                <select class="form-control" name="subcategory" data-stid="" id="subcategorytc<?= $cmpuser['id'] ?>" >
                                                    
                                                    <option value="<?= $cmpuser['subcategory']; ?>"><?= student_category_name($cmpuser['subcategory']) ?></option>
                                                    
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="religion">Religion</label>
                                                <input type="text" class="form-control" name="religion"   value="<?= $cmpuser['religion'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="designation">Designation</label>
                                                <input type="text" class="form-control" name="designation" value="<?= $cmpuser['designation'] ?>">
                                            </div>

                                            <?php if (is_school(company($user['id']))): ?>
                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="nature_of_appointment">Nature of appointment</label>
                                                <input type="text" class="form-control" name="nature_of_appointment" value="<?= $cmpuser['nature_of_appointment'] ?>">
                                            </div>
                                            <?php endif ?>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="qualification">Qualification</label>
                                                <input type="text" class="form-control" name="qualification" value="<?= $cmpuser['qualification'] ?>">
                                            </div>



                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="aadhar_no">Aadhar Number</label>
                                                <input type="text" class="form-control" name="aadhar_no" value="<?= $cmpuser['adhar'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="bank_name">Bank Name</label>
                                                <input type="text" class="form-control" name="bank_name" value="<?= $cmpuser['bank_name'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="account_number">Bank Account Number</label>
                                                <input type="text" class="form-control" name="account_number" value="<?= $cmpuser['account_number'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="ifsc">Bank IFSC Code</label>
                                                <input type="text" class="form-control" name="ifsc" value="<?= $cmpuser['ifsc'] ?>">
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <label class="font-weight-semibold" for="blood_gp">Blood Group</label>
                                                <input type="text" class="form-control" name="blood_gp" value="<?= $cmpuser['blood_group'] ?>">
                                            </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer text-start py-1">
                                        <button type="button" class="aitsun-primary-btn edit_staff" data-id="<?=  $cmpuser['id'] ?>">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        <!-- ////////////////////////// STAFF EDIT MODAL ///////////////////////// -->



                         <!-- ////////////////////////// STAFF BRANCH PERMISSION MODAL ///////////////////////// -->

                            <div class="modal fade" id="branchpermission<?= $cmpuser['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staff_editLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-start">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staff_editLabel">Branch permission</h5>    
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form method="post" action="<?= base_url('user_master/save_branch_permission'); ?>/<?= $cmpuser['id']; ?>">
                                        <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <?php foreach ($branches as $br): ?>

                                                    <div class="form-group mb-3 d-flex form-check form-switch">
                                                      <input type="checkbox" name="allowed_branches[]" value="<?= $br['id'] ?>"  <?php if(is_allowed_branch($br['id'],$cmpuser['allowed_branches'])==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_branch_id<?= $br['id'] ?>">
                                                      <label class="mb-0 form-check-label" for="manage_branch_id<?= $br['id'] ?>" style="font-size: 15px;font-weight: 500;"><?= $br['company_name']; ?></label>

                                                    </div>
                                                    
                                                <?php endforeach ?>
                                                

                                            </div>

                                         </div>
                                    </div>
                                    <div class="modal-footer text-start py-1">
                                        <button type="submit" class="aitsun-primary-btn">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        <!-- ////////////////////////// STAFF BRANCH PERMISSION MODAL ///////////////////////// -->



                        <!-- ////////////////////////// STAFF MENU PERMISSION MODAL ///////////////////////// -->

                            <div class="modal fade" id="user_permission<?= $cmpuser['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staff_editLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content text-start">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="staff_editLabel">Permission - <?= $cmpuser['display_name'] ?></h5>    
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form  action="<?= base_url('user_master/user_permission') ?>/<?= $cmpuser['id'] ?>" method="post">
                                        <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <div class="row px-3">

                                         
                                                
                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_parties" value="1" <?php if(check_permission( $cmpuser['id'],'manage_parties')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_parties_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_parties_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Parties</label>

                                                </div>
                            
                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_sales" value="1" <?php if(check_permission( $cmpuser['id'],'manage_sales')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_sale_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_sale_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Sales</label>

                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_sales_quotation" value="1" <?php if(check_permission( $cmpuser['id'],'manage_sales_quotation')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_sale_quotation_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_sale_quotation_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Sales Quotation</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_sales_order" value="1" <?php if(check_permission( $cmpuser['id'],'manage_sales_order')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_sale_order_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_sale_order_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Sales Order</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_sales_return" value="1" <?php if(check_permission( $cmpuser['id'],'manage_sales_return')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_sale_return_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_sale_return_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Sales Return</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_sales_delivery_note" value="1" <?php if(check_permission( $cmpuser['id'],'manage_sales_delivery_note')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_manage_salesdelivery_note_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_manage_salesdelivery_note_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Sales Delivery Note</label>
                                                </div>


                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_purc" value="1" <?php if(check_permission( $cmpuser['id'],'manage_purchase')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_purchase_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_purchase_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Purchases</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_purchase_order" value="1" <?php if(check_permission( $cmpuser['id'],'manage_purchase_order')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_purchase_order_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_purchase_order_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Purchases Order</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_purchase_return" value="1" <?php if(check_permission( $cmpuser['id'],'manage_purchase_return')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_purchase_return_id">
                                                  <label class="mb-0 form-check-label" for="manage_purchase_return_id" style="font-size: 15px;font-weight: 500;">Manage Purchases Return</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none form-check form-switch">
                                                  <input type="checkbox" name="manage_purchase_delivery_note" value="1" <?php if(check_permission( $cmpuser['id'],'manage_purchase_delivery_note')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_purchase_delivery_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_purchase_delivery_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Purchases Delivery Note</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_cash_ex" value="1" <?php if(check_permission( $cmpuser['id'],'manage_cash_ex')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_payments_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_payments_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Vouchers</label>
                                                </div>


                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_pro_ser" value="1" <?php if(check_permission( $cmpuser['id'],'manage_pro_ser')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_product_ser_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_product_ser_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Products</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_orders" value="1" <?php if(check_permission( $cmpuser['id'],'manage_orders')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_orders_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_orders_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Product Orders</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_product_requestes" value="1" <?php if(check_permission( $cmpuser['id'],'manage_product_requestes')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_product_requestes_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_product_requestes_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Product Requests</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_work_updates" value="1" <?php if(check_permission( $cmpuser['id'],'manage_work_updates')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_work_updates_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_work_updates_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Work Updates</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_invoice_submit" value="1" <?php if(check_permission( $cmpuser['id'],'manage_invoice_submit')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_invoice_submit_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_invoice_submit_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Invoice Submit</label>
                                                </div>


                                                
                            
                                                

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_crm" value="1" <?php if(check_permission( $cmpuser['id'],'manage_crm')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_crm_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_crm_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage CRM</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_appearance" value="1" <?php if(check_permission( $cmpuser['id'],'manage_appearance')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_appearance_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_appearance_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Appearance</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_settings" value="1" <?php if(check_permission( $cmpuser['id'],'manage_settings')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_settings_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_settings_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Settings</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_reports" value="1" <?php if(check_permission( $cmpuser['id'],'manage_reports')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_reports_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_reports_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Reports</label>

                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex d-none">
                                                  <input type="checkbox" name="manage_trash" value="1" <?php if(check_permission( $cmpuser['id'],'manage_trash')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_trash_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_trash_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Trash</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_aitsun_keys" value="1" <?php if(check_permission( $cmpuser['id'],'manage_aitsun_keys')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_aitsun_keys_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_aitsun_keys_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Aitsun Keys</label>
                                                </div>


                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_enquires" value="1" <?php if(check_permission( $cmpuser['id'],'manage_enquires')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_enquires_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_enquires_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Enquires</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_document_renew" value="1" <?php if(check_permission( $cmpuser['id'],'manage_document_renew')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_document_renew_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_document_renew_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage Document Renew</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-check form-switch">
                                                  <input type="checkbox" name="manage_hr" value="1" <?php if(check_permission( $cmpuser['id'],'manage_hr')==true){echo 'checked';} ?> class="my-auto me-2 form-check-input" id="manage_hr_id<?= $cmpuser['id'] ?>">
                                                  <label class="mb-0 form-check-label" for="manage_hr_id<?= $cmpuser['id'] ?>" style="font-size: 15px;font-weight: 500;">Manage HR</label>
                                                </div>


                                                <!-- <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_financial_year" value="1" <php if(check_permission($cmpuser['id'],'manage_financial_year')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_financial_year<= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_financial_year<= $cmpuser['id'] ?>">Manage Financial Year </label>
                                                </div> -->
                                                

                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_sms_config" value="1" <?php if(check_permission($cmpuser['id'],'manage_sms_config')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_sms_config<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_sms_config<?= $cmpuser['id'] ?>">Manage SMS Configurations</label>
                                                </div>


                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_account_setting" value="1" <?php if(check_permission($cmpuser['id'],'manage_account_setting')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_account_setting<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_account_setting<?= $cmpuser['id'] ?>">Manage Organisation Settings</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="stock_management" value="1" <?php if(check_permission($cmpuser['id'],'stock_management')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="stock_management<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="stock_management<?= $cmpuser['id'] ?>">Stock Management</label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="delete_receipts_and_payments" value="1" <?php if(check_permission($cmpuser['id'],'delete_receipts_and_payments')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="delete_receipts_and_payments<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="delete_receipts_and_payments<?= $cmpuser['id'] ?>">Delete Receipt/Payments</label>
                                                </div>
                                                

                                                 <?php if (is_school(company($user['id']))): ?>

                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    <input type="checkbox" name="manage_library" value="1" <?php if(check_permission($cmpuser['id'],'manage_library')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_library<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_library<?= $cmpuser['id'] ?>">Manage library </label>
                                                </div>
                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    <input type="checkbox" name="manage_sports" value="1" <?php if(check_permission($cmpuser['id'],'manage_sports')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_sports<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_sports<?= $cmpuser['id'] ?>">Manage Sports </label>
                                                </div>
                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_eccc" value="1" <?php if(check_permission($cmpuser['id'],'manage_eccc')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_eccc<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_eccc<?= $cmpuser['id'] ?>">Manage EC/CC </label>
                                                </div>
                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_messaging" value="1" <?php if(check_permission($cmpuser['id'],'manage_messaging')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_messaging<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_messaging<?= $cmpuser['id'] ?>">Manage Messaging </label>
                                                </div>
                                                
                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_timetable" value="1" <?php if(check_permission($cmpuser['id'],'manage_timetable')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_timetable<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_timetable<?= $cmpuser['id'] ?>">Manage Timetable Builder </label>
                                                </div>
                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_notices" value="1" <?php if(check_permission($cmpuser['id'],'manage_notices')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_notices<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_notices<?= $cmpuser['id'] ?>">Manage Notices </label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_health" value="1" <?php if(check_permission($cmpuser['id'],'manage_health')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_health<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_health<?= $cmpuser['id'] ?>">Manage Health </label>
                                                </div>

                                                
                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_fees" value="1" <?php if(check_permission($cmpuser['id'],'manage_fees')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_fees<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_fees<?= $cmpuser['id'] ?>">Manage Fees & Payments </label>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 d-flex form-switch">
                                                    
                                                    <input type="checkbox" name="manage_academic_year" value="1" <?php if(check_permission($cmpuser['id'],'manage_academic_year')==true){echo 'checked';} ?> class="my-auto form-check-input me-2" id="manage_academic_year<?= $cmpuser['id'] ?>">
                                                    <label class="my-auto ml-2 font-weight-semibold text-dark" for="manage_academic_year<?= $cmpuser['id'] ?>">Manage Academic Year </label>
                                                </div>



                                                <?php endif ?>
                                                



                                        </div>
                                    </div>
                                    <div class="modal-footer text-start py-1">
                                        <button type="submit" class="aitsun-primary-btn">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        <!-- ////////////////////////// STAFF MENU PERMISSION MODAL ///////////////////////// -->


                    </td>
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="9">
                            <span class="text-danger">No staffs</span>
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
    

    <div>
        <span class="m-0 font-size-footer">Total staffs : <?= count($company_members_array); ?></span>
    </div>


    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->