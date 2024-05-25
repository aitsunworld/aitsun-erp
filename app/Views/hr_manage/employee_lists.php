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
                    <b class="page_heading text-dark">Employee list</b>
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
        <a href="<?= base_url('hr_manage/attendance'); ?>" class="text-dark font-size-footer me-2 href_loader">Attendance</a>    
        <a class="text-dark font-size-footer me-2 href_loader" href="<?= base_url('hr_manage/attendance_settings'); ?>">Settings</a>
        <a class="text-dark font-size-footer me-2 href_loader" href="<?= base_url('hr_manage/employee_categories'); ?>">Employee categories</a>
    </div>

    <?php if (get_setting(company($user['id']),'fp_device')==1): ?>
     <a href="javascript:void(0);" id="upload_to_device" class="text-dark font-size-footer my-auto ms-2"> <span class=""><i class="bx bx-upload"></i> Upload to device</span></a>
    <?php endif ?>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
  
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">

            
            <table id="parties_table" class="erp_table">
             <thead>
                <tr class="big_check">
                    <th class="text-center">
                        <input type="checkbox" class="checkbox" id="check_all_user">
                    </th>
                    <th>Emp. Name</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Emp. Shift</th>
                    <th>Emp. Category</th>
                    <th>Emp. Code</th>
                    <th data-tableexport-display="none">Action</th>
                    <th data-tableexport-display="none">Attendance</th>
                </tr>
             
             </thead>
              <tbody>
                <?php $i=0; foreach ($employee_data as $emp): $i++; ?>
                                    <tr>
                                        <td class="text-center big_check" style="width:100px"> 
                                            <input type="checkbox" name="all_numbers[]" class="bulkselector_user user_check_box checkbox"
                                            data-user_id="<?= $emp['id'];?>"
                                            data-employee_code="<?= $emp['staff_code'];?>"
                                            data-employee_name="<?= $emp['display_name'];?>"
                                            data-user_role="<?= $emp['designation'];?>"
                                            >
                                        </td>
                                        <td><?= $emp['display_name'];?></td>
                                        <td><?= $emp['email'];?></td>
                                        <td><?= $emp['designation'];?></td>
                                        <td><?= work_shift_name($emp['shifts']);?></td>
                                        <td><?= employee_category_data($emp['employee_category'],'category_name');?></td>
                                        <td><?= $emp['staff_code'];?></td>
                                        <td data-tableexport-display="none">
                                            <a class=" me-2" data-bs-toggle="modal" data-bs-target="#ed_empdata<?= $emp['id'];?>">
                                                <i class="bx bx-pencil"></i>
                                            </a>


                                            <div class="aitsun-modal modal fade" id="ed_empdata<?= $emp['id'];?>"  aria-hidden="true" data-bs-backdrop="static">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Employee</h5>
                                                            <button type="button" class="btn-close close_staff_mod" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="edit_staff_form<?= $emp['id'];?>">
                                                            <?= csrf_field(); ?>
                                                              <div class="modal-body">
                                                                <div class="row">
                                                                 
                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Employee name</label>
                                                                         <input type="text" name="staff_name" id="staff_name<?= $emp['id'];?>" placeholder="Employee name" value="<?= $emp['display_name'];?>" class="form-control" required>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Email</label>
                                                                         <input type="email" name="staff_email" id="staff_email<?= $emp['id'];?>" placeholder="Email Address" value="<?= $emp['email'];?>" class="form-control" required>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Phone Number</label>
                                                                         <input type="number" name="phone_number" id="phone_number<?= $emp['id'];?>" placeholder="Phone Number" value="<?= $emp['phone'];?>" class="form-control" required>
                                                                     </div>
                                                                 </div>

                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Designation</label>
                                                                         <input type="text" name="designation" id="designation<?= $emp['id'];?>" placeholder="Designation" value="<?= $emp['designation'];?>" class="form-control" required>
                                                                     </div>
                                                                 </div>

                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Shifts</label>
                                                                         <select class="form-select" name="shifts" id="shifts<?= $emp['id'];?>" >
                                                                            <?php foreach (workshift_array(company($user['id'])) as $ws): ?>
                                                                                <option value="<?= $ws['id']; ?>" <?php if ($emp['shifts']==$ws['id']){echo 'selected';}?>><?= $ws['shift']; ?></option>
                                                                            <?php endforeach ?>
                                                                             
                                                                         </select>
                                                                     </div>
                                                                 </div>

                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Category</label>
                                                                         <select class="form-select" name="employee_category" id="employee_category<?= $emp['id'];?>" required>
                                                                            <?php foreach (employee_categories_array(company($user['id'])) as $ec): ?>
                                                                                <option value="<?= $ec['id']; ?>" <?php if ($emp['employee_category']==$ec['id']){echo 'selected';}?>><?= $ec['category_name']; ?></option>
                                                                            <?php endforeach ?>
                                                                             
                                                                         </select>
                                                                     </div>
                                                                 </div>


                                                                 

                                                                 <div class="col-md-4 mb-2"> 
                                                                     <div class="form-group">
                                                                         <label>Code</label>
                                                                         <input type="text" name="staff_code" id="staff_code<?= $emp['id'];?>" placeholder="Staff code" value="<?= $emp['staff_code'];?>" class="form-control" required>
                                                                     </div>
                                                                 </div>

                                                                 <div class="col-md-4 mb-2 mt-2"> 
                                                                     <div class="form-group">
                                                                         <label class="mb-2">Gender</label><br>
                                                                         <div class="mb-2 ms-3">
                                                                            <input type="radio" name="staff_gender" value="male" class="form-check-input" id="gdrm<?= $emp['id'];?>" <?php if ($emp['gender']=='male'){echo 'checked';}?>>
                                                                            <label for="gdrm<?= $emp['id'];?>">Male</label>
                                                                         </div>
                                                                         <div class="mb-2 ms-3">
                                                                            <input type="radio" name="staff_gender" value="female" class="form-check-input" id="gdrf<?= $emp['id'];?>" <?php if ($emp['gender']=='female'){echo 'checked';}?>>
                                                                            <label for="gdrf<?= $emp['id'];?>">Female</label>
                                                                         </div>
                                                                         <div class="mb-2 ms-3">
                                                                            <input type="radio" name="staff_gender" value="others" class="form-check-input" id="gdro<?= $emp['id'];?>" <?php if ($emp['gender']=='others'){echo 'checked';}?>>
                                                                            <label for="gdro<?= $emp['id'];?>">Others</label>
                                                                         </div>
                                                                     </div>
                                                                 </div>

                                                                 <input type="hidden" name="old_staff_email" value="<?= $emp['email'] ?>">
                                                                 <input type="hidden" name="old_staff_code" value="<?= $emp['staff_code'] ?>">

                                                                 
                                                                  
                                                                </div>
                                                              </div>
                                                              <div class="modal-footer justify-content-between">
                                                                <div id="er_msg<?= $emp['id'];?>"></div>

                                                                <div>
                                                                    <button type="button" class="btn btn-secondary close_staff_mod" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                                                                <button type="button" class="aitsun-primary-btn edit_staff_data" data-emp_id="<?= $emp['id'];?>"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                                                                </div>
                                                                
                                                              </div>
                                                            </form>
                                                                                        
                                                    </div>
                                                </div>
                                            </div>




                                            <a class="delete cursor-pointer" data-url="<?= base_url('hr_manage'); ?>/delete_employee_data/<?= $emp['id'];?>">
                                                <i class="bx bx-trash text-danger"></i>
                                            </a>

                                        </td>

                                        <td data-tableexport-display="none">

                                            <div class="form-check form-switch cursor-pointer ">
                                                <input class="form-check-input add_attend_status" type="checkbox" data-id="<?= $emp['id']; ?>" value="1" <?php if (is_attendance_allowed(company($user['id']),$emp['id'])==1){echo 'checked';}?>>
                                            </div>

                                        </td>
                                       
                                    </tr>

                                    <?php endforeach ?>
                                    <?php if ($i==0): ?>
                                        <tr>
                                            <td colspan="8"><h6 class="p-4 text-center text-danger">You have 0 employees </h6></td>
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
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">   
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report'); ?>">Reports</a>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report/leave_report'); ?>">Leave reports</a>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/leave_management'); ?>">Leave management</a> 
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 <script type="text/javascript">
     $(document).on('click','#upload_to_device',function(){ 
      
      var this_upload_btn=$('#upload_to_device');    
      var this_upload_btn_content=$('#upload_to_device').html();

       
        $(this_upload_btn).html('<i class="bx bx-loader-alt bx-spin me-0"></i> Uploading...');
        $(this_upload_btn).prop('disabled', true);    
      
      var checkedNum = $('.bulkselector_user:checked').length;
      if (checkedNum<1) { 
          show_success_msg('error','Please Select atleast 1 employee!'); 
          $(this_upload_btn).html(this_upload_btn_content);
          $(this_upload_btn).prop('disabled', false);
      }else{
        $(this_upload_btn).html('<i class="bx bx-loader-alt bx-spin me-0"></i> Uploading...');
        $(this_upload_btn).prop('disabled', true); 
        var ccout=0;
        $.each($('.bulkselector_user:checked'), function() {

            ccout++;
         
            
           var user_id=$(this).data("user_id");
           var employee_code=$(this).data("employee_code");
           var employee_name=$(this).data("employee_name");
           var user_role=$(this).data("user_role");


         
        const data_to_push = {
            fp_address: '<?= get_setting(company($user['id']),'fp_address') ?>',                 
            fp_port: '<?= get_setting(company($user['id']),'fp_port') ?>',  
            user_id:user_id,
            employee_code:employee_code,
            employee_name:employee_name,
            user_role:user_role        
        }
 
        window.api.push_user_to_fp_device('toFP', data_to_push); 
        
        if (ccout==checkedNum) {
            
            setInterval(function(){
                $(this_upload_btn).html(this_upload_btn_content);
                $(this_upload_btn).prop('disabled', false);
            },10000);

        }

        });



         

        
      }
    });

    window.api.receive('get-save-user-status', (event,  data) =>{ 
        
      if (data.status==1) {
        show_success_msg('success','<b>'+data.employee_name+'</b> is moved to device.'); 
      }else{
        show_success_msg('error','<b>'+data.employee_name+'</b> is failed to push data, Please check your device configuration!');
      }
    });



    function show_success_msg(type,message,title) {
         Lobibox.notify(type, {
            size: 'mini',
            title: title,
            position: 'top right',
            width: 300,
            icon: 'bx bxs-check-circle',
            sound: false,
            // delay: false,
            delay: 2000,
            delayIndicator: false,
            showClass: 'zoomIn',
            hideClass: 'zoomOut',
            msg: message
        });
    }

    function show_failed_msg(type,message,title) {
        Lobibox.notify(type, {
            size: 'mini',
            title: title,
            position: 'top right',
            width: 300,
            icon: 'bx bxs-x-circle',
            sound: false,
            // delay: false,
            delay: 2000,
            delayIndicator: false,
            showClass: 'zoomIn',
            hideClass: 'zoomOut',
            msg: message
        });
    }
 </script>