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
                    <b class="page_heading text-dark">Employee categories</b>
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
        <a class="text-dark font-size-footer me-2 href_loader" href="<?= base_url('hr_manage/employee_lists'); ?>">Employee list</a>
    </div>

    <a data-bs-toggle="modal" data-bs-target="#employee_categories_modal" class="text-dark font-size-footer my-auto ms-2"> <span class=""><i class="bx bx-plus"></i> New category</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 

<div class="modal fade " id="employee_categories_modal" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" class="on_submit_loader">
                <?= csrf_field(); ?>
                  <div class="modal-body">
                    <div class="">
                     
                        <div class="d-flex"> 
                            <div class="w-50">
                                <label class="my-auto pe-3">Category name</label>  
                                <input type="text" class="form-control" name="category_name" required>
                            </div>
                         
                            <div class="form-group ms-2 w-25">
                                <label class="my-auto me-2">Work start</label>
                                <input type="time" class="w-100 form-control" name="from" required>
                            </div>
                        
                            <div class="ms-2 form-group w-25">
                                <label class="my-auto me-2">Work end</label>
                                <input type="time" class="w-100 form-control" name="to" required>
                            </div>
                        </div>

                        <div class=""> 
                            <div class="d-md-flex justify-content-between mt-3">
                                <label class="my-auto pe-3">The number of leaves your company offers each month</label>  
                                <input type="number" min="0" max="31" class="form-control" name="leave_for_month" placeholder="" style="max-width: 100px; width: 100px;" value="1" required>
                            </div>
                        </div>

                        <div class=""> 
                            <div class="d-md-flex justify-content-between mt-3">
                                <label class="my-auto pe-3">Are you carrying forward leaves to next month?</label>  
                                <select class="form-select" name="carry_forward" style="max-width: 100px; width: 100px;">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class=""> 
                            <div class="d-md-flex justify-content-between mt-3">
                                <label class="my-auto pe-3">Total working hours</label>  
                                <input class="form-control" type="number" name="total_working_hour" min="1" max="24" style="max-width: 100px; width: 100px;" value="8">
                            </div>
                        </div>

                        <div class=""> 
                            <div class="d-md-flex justify-content-between mt-3">
                                <label class="my-auto pe-3">Hours for full day</label>  
                                <input class="form-control" type="number" name="full_day_hour" min="1" max="24" style="max-width: 100px; width: 100px;" value="6">
                            </div>
                        </div>

                        <div class=""> 
                            <div class="d-md-flex justify-content-between mt-3">
                                <label class="my-auto pe-3">Hours for half day</label>  
                                <input class="form-control" type="number" name="half_day_hour" min="1" max="24" style="max-width: 100px; width: 100px;" value="3">
                            </div>
                        </div>

                        <div class="mt-3">
                            <table class="w-100 aitsun_table" border="" cellspacing="0" cellpadding="2"> 
                                <tr>
                                    <td colspan="2" class="text-center">
                                        Week off's
                                    </td>
                                </tr> 
                                <?php foreach (weeks_array() as $wk): ?>
                                    <tr class="week_parent">
                                        <td class="w-50">
                                            <input type="hidden" name="<?= $wk['week'] ?>">
                                            <?= $wk['week_name'] ?>
                                        </td>
                                        <td>
                                            <select class="form-select week_selector" name="<?= $wk['post_name'] ?>">
                                                <option value="">No week off</option>
                                                <option value="all">All <?= $wk['week_name'] ?></option> 
                                                <?php foreach (custom_weeks() as $key => $value): ?>
                                                    <option value="<?= $key ?>"><?= $value ?> <?= $wk['week_name'] ?></option>
                                                <?php endforeach ?> 
                                            </select>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach ?>  
                            </table>
                        </div>
                        
                       
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <div id="er_msg"></div>

                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                        <button type="submit" class="aitsun-primary-btn" name="add_employees_category"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                    </div>
                    
                  </div>
                </form>
                                            
        </div>
    </div>
</div>


  
     



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">   
        <div class="aitsun_table col-12 w-100 pt-0 pb-5"> 
            <table id="product_edit_table" class="erp_table">
                 <thead>
                    <tr>
                        <th class="">Category</th> 
                        <th class="text-center">Leave in a month</th>
                        <th class="text-center">Carry forward</th>
                        <th class="text-center">Total Hrs</th>
                        <th class="text-center">Full day Hrs</th>
                        <th class="text-center">Half day Hrs</th>
                        <th class="text-end" data-tableexport-display="none">Action</th>  
                    </tr>
                 
                 </thead>
                <tbody>
                    

                    
                    <?php $i=0; foreach ($employee_categories as $ec): $i++; ?> 
                    <tr> 
                        <td><?= $ec['category_name'] ?></td>
                        <td class="text-center"><?= $ec['leave_for_month'] ?></td>
                        <td class="text-center"><?= ($ec['carry_forward']==1)?'Yes':'No' ?></td>
                        <td class="text-center"><?= $ec['total_working_hour'] ?> hrs</td>
                        <td class="text-center"><?= $ec['full_day_hour'] ?> hrs</td>
                        <td class="text-center"><?= $ec['half_day_hour'] ?> hrs</td>
                        <td class="text-end" data-tableexport-display="none" style="white-space: nowrap;">

                            <a data-bs-toggle="modal" data-bs-target="#edit_employee_categories_modal<?= $ec['id'] ?>" class="cursor-pointer me-2" href="<?= $ec['id'] ?>"><i class="bx bx-pencil"></i></a>


    <div class="modal fade text-start" id="edit_employee_categories_modal<?= $ec['id'] ?>" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" class="on_submit_loader">
                        <?= csrf_field(); ?>
                          <div class="modal-body">
                            <div class="">
                                
                                <input type="hidden" name="ecid" value="<?= $ec['id'] ?>"> 

                                <div class="d-flex"> 
                                    <div class="w-50">
                                        <label class="my-auto pe-3">Category name</label>  
                                        <input type="text" class="form-control" name="category_name" value="<?= $ec['category_name'] ?>" required>
                                    </div>
                                 
                                    <div class="form-group ms-2 w-25">
                                        <label class="my-auto me-2">Work start</label>
                                        <input type="time" class="w-100 form-control" name="from" value="<?= $ec['from'] ?>" required>
                                    </div>
                                
                                    <div class="ms-2 form-group w-25">
                                        <label class="my-auto me-2">Work end</label>
                                        <input type="time" class="w-100 form-control" name="to" value="<?= $ec['to'] ?>" required>
                                    </div>
                                </div>

                                <div class=""> 
                                    <div class="d-md-flex justify-content-between mt-3">
                                        <label class="my-auto pe-3">The number of leaves your company offers each month</label>  
                                        <input type="number" min="0" max="31" class="form-control" name="leave_for_month" placeholder="" style="max-width: 100px; width: 100px;" value="<?= $ec['leave_for_month'] ?>" required>
                                    </div>
                                </div>

                                <div class=""> 
                                    <div class="d-md-flex justify-content-between mt-3">
                                        <label class="my-auto pe-3">Are you carrying forward leaves to next month?</label>  
                                        <select class="form-select" name="carry_forward" style="max-width: 100px; width: 100px;">
                                            <option value="1" <?= ($ec['carry_forward']==1)?'selected':'' ?>>Yes</option>
                                            <option value="0" <?= ($ec['carry_forward']==0)?'selected':'' ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class=""> 
                                    <div class="d-md-flex justify-content-between mt-3">
                                        <label class="my-auto pe-3">Total working hours</label>  
                                        <input class="form-control" type="number" name="total_working_hour" min="1" max="24" style="max-width: 100px; width: 100px;" value="<?= $ec['total_working_hour'] ?>">
                                    </div>
                                </div>

                                <div class=""> 
                                    <div class="d-md-flex justify-content-between mt-3">
                                        <label class="my-auto pe-3">Hours for full day</label>  
                                        <input class="form-control" type="number" name="full_day_hour" min="1" max="24" style="max-width: 100px; width: 100px;" value="<?= $ec['full_day_hour'] ?>">
                                    </div>
                                </div>

                                <div class=""> 
                                    <div class="d-md-flex justify-content-between mt-3">
                                        <label class="my-auto pe-3">Hours for half day</label>  
                                        <input class="form-control" type="number" name="half_day_hour" min="1" max="24" style="max-width: 100px; width: 100px;" value="<?= $ec['half_day_hour'] ?>">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <table class="w-100 aitsun_table" border="" cellspacing="0" cellpadding="2"> 
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                Week off's
                                            </td>
                                        </tr> 
                                        <?php foreach (weeks_array() as $wk): ?>
                                            <tr class="week_parent">
                                                <td class="w-50">
                                                    <input type="hidden" name="<?= $wk['week'] ?>">
                                                    <?= $wk['week_name'] ?>
                                                </td>
                                                <td>
                                                    <select class="form-select week_selector" name="<?= $wk['post_name'] ?>">
                                                        <option value="" <?= ($ec[$wk['post_name']]=='')?'selected':'' ?>>No week off</option>
                                                        <option value="all" <?= ($ec[$wk['post_name']]=='all')?'selected':'' ?>>All <?= $wk['week_name'] ?></option>
                                                        <?php foreach (custom_weeks() as $key => $value): ?>
                                                            <option value="<?= $key ?>" <?= ($ec[$wk['post_name']]==$key)?'selected':'' ?>><?= $value ?> <?= $wk['week_name'] ?></option>
                                                        <?php endforeach ?> 
                                                    </select>
                                                </td>
                                                
                                            </tr>
                                        <?php endforeach ?>  
                                    </table>
                                </div>
                                
                               
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <div id="er_msg"></div>

                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                                <button type="submit" class="aitsun-primary-btn" name="edit_employees_category"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                            </div>
                            
                          </div>
                        </form>
                                                    
                </div>
            </div>
        </div>

                            <a class="delete text-danger cursor-pointer" data-url="<?= base_url('hr_manage/delete_employee_category'); ?>/<?= $ec['id'] ?>"><i class="bx bx-trash text-danger"></i></a>
                        </td>
                    </tr>
                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="8"><h6 class="p-4 text-center text-danger">No data found... </h6></td>
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


 