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
                    <b class="page_heading text-dark">Attendance settings</b>
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

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
  
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content pb-5">
    <div class="aitsun-row pb-5"> 
 
 

            <div class="card w-100 mb-3 d-none">
                <div class="card-header">
                    <h6 class="card-title mb-0">Leave offers</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <?= csrf_field(); ?>  

                        <div class="form-group"> 
                            
                            <div class="d-md-flex justify-content-between">
                                <label class="my-auto pe-3">1. The number of leaves your company offers each month</label>  
                                <input type="number" min="0" max="31" class="form-control" name="leave_for_month" placeholder="" style="max-width: 100px; width: 100px;" value="<?= get_setting(company($user['id']),'leave_for_month') ?>" required>
                            </div>
                        
                            <div class="d-md-flex justify-content-between mt-3">
                                <label class="my-auto pe-3">2. Are you carrying forward leaves to next month?</label>  
                                <select class="form-select" name="carry_forward" style="max-width: 100px; width: 100px;">
                                    <option value="1" <?php if(get_setting(company($user['id']),'carry_forward')==1){echo "selected";} ?>>Yes</option>
                                    <option value="0" <?php if(get_setting(company($user['id']),'carry_forward')==0){echo "selected";} ?>>No</option>
                                </select>
                            </div>


                                
                        </div>
                        
                        <div class="form-group mt-2">
                            <button type="submit" class=" aitsun-primary-btn" name="save_attendance_offers">Save</button>
                        </div>
                               
                     </form>
                    
                </div>
            </div>



            <div class="card w-100 mb-3 d-none">
                <div class="card-header">
                    <h6 class="card-title mb-0">Work Shift</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <?= csrf_field(); ?>
                        <div class="row mb-3"> 
                             <div class="col-md-3 col-sm-12">   
                                <div class="form-group "> 
                                    <input type="text" class="form-control" name="shift" placeholder="Shift Name" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group d-flex">
                                    <label class="my-auto me-2">From</label>
                                    <input type="time" class="form-control" name="from" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group d-flex">
                                    <label class="my-auto me-2">To</label>
                                    <input type="time" class="form-control" name="to" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                           
                                <div class="form-group ">
                                    <button type="submit" class=" aitsun-primary-btn" name="save_work_shift">Add</button>
                                </div>
                            </div>
                         </div>
                     </form>

                        <div class="table-responsive">

                            <table class="erp_table" id="excelthis">

                                <thead>
                                    <tr>
                                        <th>Shift</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($work_shift_data as $ws): ?>
                                        <tr>
                                            <td><?= $ws['shift'];?></td>
                                            <td><?= get_date_format($ws['from'],'h:i A');?></td>
                                            <td><?= get_date_format($ws['to'],'h:i A');?></td>
                                            <td>
                                                
                                                <a class="" data-bs-toggle="modal" data-bs-target="#ed_workshift<?= $ws['id'] ?>">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                                <a class="delete cursor-pointer" data-url="<?= base_url('hr_manage/delete_work_shift'); ?>/<?= $ws['id'] ?>">
                                                    <i class="bx bx-trash text-danger"></i>
                                                </a>



                                                <div class="aitsun-modal modal fade" id="ed_workshift<?= $ws['id'] ?>"  aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Work Shift</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="post">
                                                            <?= csrf_field(); ?>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                        <div class="form-group mb-2">
                                                                            <label>Shift Name</label>
                                                                            <input type="hidden" name="shiftid" value="<?= $ws['id'] ?>">
                                                                            <input type="text" class="form-control" name="shift" placeholder="Shift" value="<?= $ws['shift'] ?>" required>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label>From</label>
                                                                            <input type="time" class="form-control" name="from" required value="<?= $ws['from'] ?>">
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <label>To</label>
                                                                            <input type="time" class="form-control" name="to" required value="<?= $ws['to'] ?>">
                                                                        </div>

                                                                        <div class="form-group mt-3">
                                                                            <button type="submit" class=" aitsun-primary-btn" name="edit_work_shift">Save</button>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                            </td>
                                        </tr>
                                        
                                    <?php endforeach ?>
                                    
                                </tbody>
                            </table>

                           

                        </div>
                    
                </div>
            </div>

  
            <div class="card w-100 mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Events</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <?= csrf_field(); ?> 
                        <div class="row mb-3">  

                            <div class="form-group col-lg-2 col-md-6 col-sm-12"> 
                            <label>Event Date</label>  
                                <input type="date" class="form-control datepicker-input" name="date" placeholder="Pick a date" required>
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                <label>Event Name</label>
                                <input type="text" class="form-control" name="event_name" placeholder="Event" required>
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                <label>Effects</label>
                                <select name="effect_to" class="form-select" required>
                                    <option value="week_off">Week Off</option>
                                    <option value="working_day">Working Day</option>  
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                <label>Font color</label>
                                <input type="color" name="font_color" class="form-control" style="height: 38px;">
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                <label>Background color</label>
                                <input type="color" name="bg_color" class="form-control" style="height: 38px;">
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                <button type="submit" class=" aitsun-primary-btn mt-4" name="save_attendance_event">Add</button>
                            </div>
                              
                            </div> 
                     </form>

                        <div class="table-responsive">

                            

                            <table class="erp_table" id="excelthis">

                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Effect to</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=0; foreach ($event_data as $ed): $i++;?>
                                    <tr>
                                        <td>
                                            <span style="color: <?= $ed['font_color'] ?>; background-color: <?= $ed['bg_color'] ?>;" class="px-2 rounded">
                                                <?= $ed['event_name'] ?>
                                            </span>

                                        </td>
                                        <td><?= get_date_format($ed['event_date'],'d M Y') ?></td>
                                        <td><?= ucwords(str_replace('_', ' ', $ed['effect_to'])) ?></td>
                                        <td>
                                            <a class="" data-bs-toggle="modal" data-bs-target="#ed_event<?= $ed['id'] ?>">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            <a class="delete cursor-pointer" data-url="<?= base_url('hr_manage/delete_event'); ?>/<?= $ed['id'] ?>">
                                                <i class="bx bx-trash text-danger"></i>
                                            </a>

                                            <div class="aitsun-modal modal fade" id="ed_event<?= $ed['id'] ?>"  aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit event</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="post">
                                                            <?= csrf_field(); ?>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12"> 
                                                                        <label>Event Date</label>  
                                                                        <input type="hidden" name="eventid" value="<?= $ed['id'] ?>">
                                                                            <input type="date" class="form-control datepicker-input" name="date" placeholder="Pick a date" value="<?= $ed['event_date'] ?>" required>
                                                                        </div>

                                                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                                            <label>Event Name</label>
                                                                            <input type="text" class="form-control" name="event_name" placeholder="Event" value="<?= $ed['event_name'] ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                                            <label>Effects</label>
                                                                            <select name="effect_to" class="form-select" required> 
                                                                                <option value="week_off" <?php if ($ed['effect_to']=='week_off') { echo "selected"; } ?>>Week Off</option>
                                                                                <option value="working_day" <?php if ($ed['effect_to']=='working_day') { echo "selected"; } ?>>Working Day</option>    
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                                            <label>Font color</label>
                                                                            <input type="color" name="font_color" class="form-control" style="height: 38px;" value="<?= $ed['font_color'] ?>">
                                                                        </div>
                                                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                                            <label>Background color</label>
                                                                            <input type="color" name="bg_color" class="form-control" style="height: 38px;" value="<?= $ed['bg_color'] ?>">
                                                                        </div>
                                                                        <div class="form-group col-lg-12 col-md-6 col-sm-12">
                                                                            <button type="submit" class=" aitsun-primary-btn mt-3" name="edit_save_attendance_event">Save</button>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                           

                        </div>
                    
                </div>
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


 