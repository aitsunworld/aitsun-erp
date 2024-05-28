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
                    <a href="<?= base_url('appointments'); ?>" class="href_loader">Appointments</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Create appointment</b>
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
          
        <a href="<?= base_url('appointments') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-home"></i> <span class="my-auto">Appointments</span></a>

        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-calendar"></i> Bookings
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/book_resources') ?>">
                    <span class="">Book resources</span>
                </a>
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/book_persons') ?>">
                    <span class="">Book a person</span>
                </a>  
            </div>
        </div> 

        <a href="" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-file"></i> <span class="my-auto">Reports</span></a>

        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer   " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-calendar"></i> Configuration
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/resources') ?>">
                    <span >Resources</span>
                </a>
                 
            </div>
        </div> 

    </div>
 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
  

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
        <form method="post" id="add_appointment_form" action="<?= base_url('appointments/save_appointments'); ?>" class="w-100">
            
            <?= csrf_field(); ?> 

            <?php if (isset($appointment) && $appointment): ?>
                <input type="hidden" name="appointment_id" id="appointment_id" value="<?= $appointment['id']; ?>">
            <?php endif; ?>
            <div class="row">
                
                <div class="col-md-6">
                     <div class="row"> 
                       <div class=" col-md-12 mb-2"> 
                        <label for="input-1" class="modal_lab">Appointment title</label>
                        <input type="text" class="form-control modal_inpu" name="appointment_title" id="appointment_title" value="<?= $appointment['title'] ?? ''; ?>">
                       </div>
                   
                       <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Duration</label>
                        <input type="text" class="form-control modal_inpu duration_input" name="duration" id="duration" value="<?= $appointment['duration'] ?? '01:00'; ?>" >
                       </div>

                        <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Allow cancelling (Until hours before)</label>
                        <input type="text" class="form-control modal_inpu duration_input" name="allow_cancelling_before" id="allow_cancelling_before" value="<?= $appointment['allow_cancelling_before'] ?? '01:00'; ?>">
                       </div>

                       <div class=" col-md-12 mb-2"> 
                            <div class="d-flex">
                                <label for="input-1" class="modal_lab me-3">Availabilty on</label>
                    
                                <div class="form-check me-3">
                                  <input class="form-check-input" type="radio" name="availability_on" id="availability_on1" value="0" <?= ($appointment['availability_on'] ?? '0') == '0' ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="availability_on1">
                                    Users
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="availability_on" id="availability_on2" value="1" <?= ($appointment['availability_on'] ?? '') == '1' ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="availability_on2">
                                    Resources
                                  </label>
                                </div>
                            </div>
                       </div>

                        

                       

                        <div class="form-group col-md-12 mb-2 remove_person <?= ($appointment['availability_on'] ?? '0') == '1' ? 'd-none' : ''; ?>">
                            <label for="person">Person </label>
                            
                            <div class="aitsun_select position-relative">
                                                   
                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/all_staffs'); ?>">
                                <a class="select_close d-none"><i class="bx bx-x"></i></a>
                     
                                <select class="form-select" name="person" id="person">
                                    <option value="">Select Person</option> 
                                    <option value="<?= isset($appointment['person']) ? $appointment['person'] : ''; ?>" <?= isset($appointment['person']) && $appointment['person'] ? 'selected' : ''; ?>><?= isset($appointment['person']) ? user_name($appointment['person']) : ''; ?></option> 
                                    
                                   
                                </select>
                                <div class="aitsun_select_suggest">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-2 remove_resource <?= ($appointment['availability_on'] ?? '0') == '0' ? 'd-none' : ''; ?>">
                            <label for="resource">Resource </label>
                            
                            <div class="aitsun_select position-relative">
                                                   
                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/all_resources'); ?>">
                                <a class="select_close d-none"><i class="bx bx-x"></i></a>
                     
                                <select class="form-select" name="resource" id="resource">
                                    <option value="">Select Resource</option>
                                    <option value="<?= isset($appointment['resource']) ? $appointment['resource'] : ''; ?>" <?= isset($appointment['resource']) && $appointment['resource'] ? 'selected' : ''; ?>><?= isset($appointment['resource']) ? resource_data($appointment['resource'],'appointment_resource') : ''; ?></option>  
                                   
                                </select>
                                <div class="aitsun_select_suggest">
                                </div>
                            </div>
                        </div>


                       <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Scheduling (Min hours before)</label>
                        <input type="text" class="form-control modal_inpu duration_input" name="hours_before" id="hours_before" value="<?= $appointment['hours_before'] ?? '01:00'; ?>">
                       </div>

                       <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Scheduling (Max in days)</label>
                        <input type="number" class="form-control modal_inpu" name="days_before" id="days_before" value="<?= $appointment['days_before'] ?? '15'; ?>">
                       </div>

                       

                      
                       <div class=" col-md-12 mb-2">                  
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="is_image_show" name="is_image_show" <?= isset($appointment['is_image_show']) && $appointment['is_image_show'] ? 'checked' : ''; ?>>
                          <label class="form-check-label" for="is_image_show">Show image</label>
                        </div>
                       </div>

                       <div class=" col-md-6 mb-2"> 
                            <div class="d-block">
                                <label for="input-1" class="modal_lab me-3 mb-2">Assignment method</label>
                    
                                <div class="form-check me-3">
                                  <input class="form-check-input" type="radio" name="assign_method" id="assign_method1" value="0" <?= ($appointment['assign_method'] ?? '0') == '0' ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="assign_method1">
                                    Pick Person/Resource then Time
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="assign_method" id="assign_method2" value="1" <?= ($appointment['assign_method'] ?? '') == '1' ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="assign_method2">
                                    Select Time then Person/Resource
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="assign_method" id="assign_method3" value="2" <?= ($appointment['assign_method'] ?? '') == '2' ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="assign_method3">
                                    Select Time then auto-assign
                                  </label>
                                </div>
                            </div>
                       </div> 
                    </div> 

                    <div class="pt-3">
                        <button type="button" id="save_appointment" class="aitsun-primary-btn w-25">Save</button>
                    </div>
                </div>

            <div class="col-md-6">
                <div class="row"> 
                   <div class=" col-md-12 mb-2"> 
                        <label for="input-1" class="modal_lab">Schedule</label>
 
                        <div class="form-group col-md-12 d-none-on-bill ">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th class="align-content-center">Every</th>
                                <th class="align-content-center" style="width: 135px;">From</th>
                                <th class="align-content-center" style="width: 135px;" colspan="2">To</th>
                              </tr>
                            </thead>
                            <tbody class="after-add-more-schedule">
                                <?php if (isset($appointment) && $appointment): ?>
                                    <?php foreach (appointment_timings_array($appointment['id']) as $schedule): ?>
                                    <tr class="after-add-more-schedule-tr">
                                      <td>
                                        <select name="week[]" class="form-select position-relative" id="week">
                                            <option value="1" <?= $schedule['week'] == 1 ? 'selected' : ''; ?>>Monday</option>
                                            <option value="2" <?= $schedule['week'] == 2 ? 'selected' : ''; ?>>Tuesday</option>
                                            <option value="3" <?= $schedule['week'] == 3 ? 'selected' : ''; ?>>Wednesday</option>
                                            <option value="4" <?= $schedule['week'] == 4 ? 'selected' : ''; ?>>Thursday</option>
                                            <option value="5" <?= $schedule['week'] == 5 ? 'selected' : ''; ?>>Friday</option>
                                            <option value="6" <?= $schedule['week'] == 6 ? 'selected' : ''; ?>>Saturday</option>
                                            <option value="7" <?= $schedule['week'] == 7 ? 'selected' : ''; ?>>Sunday</option>
                                        </select> 
                                      </td>
                                      <td>
                                        <input type="time" name="from[]" class="form-control" id="from" value="<?= $schedule['from']; ?>">
                                      </td>
                                      <td style="width:135px;"><input type="time" name="to[]" class="form-control" id="to" value="<?= $schedule['to']; ?>"></td>
                                      <td class="change text-center" style="width:25px;"><a class="btn btn-danger btn-sm no_load  remove-schedule text-white"><b>-</b></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="after-add-more-schedule-tr">
                                      <td>
                                        <select name="week[]" class="form-select position-relative" id="week">
                                            <option value="1">Monday</option>
                                            <option value="2">Tuesday</option>
                                            <option value="3">Wednesday</option>
                                            <option value="4">Thursday</option>
                                            <option value="5">Friday</option>
                                            <option value="6">Saturday</option>
                                            <option value="7">Sunday</option>
                                        </select> 
                                      </td>
                                      <td>
                                        <input type="time" name="from[]" class="form-control" id="from" value="09:00">
                                      </td>
                                      <td style="width:135px;"><input type="time" name="to[]" class="form-control" id="to" value="15:00"></td>
                                      <td class="change text-center" style="width:25px;"><a class="btn btn-danger btn-sm no_load  remove-schedule text-white"><b>-</b></a></td>
                                    </tr>

                                <?php endif; ?>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="p-0"><button class="no_load btn btn-dark w-100 add-more-schedule  btn-sm" type="button"><b>+</b></button></th>
                                </tr>
                                
                            </tfoot>
                          </table>
                      </div>
             




                   </div>
               </div>
               
            </div>

               

            </div>

        </form>  
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->






 
