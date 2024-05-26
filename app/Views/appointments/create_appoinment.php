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
            <a class="text-dark cursor-pointer font-size-footer   " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
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

        <a href="<?= base_url('parties_category') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-file"></i> <span class="my-auto">Reports</span></a>

        <a href="<?= base_url('parties_category') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-cog"></i> <span class="my-auto">Configuration</span></a>
    </div>
 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
  

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
        <form method="post" id="add_cust_form" action="<?= base_url('appointments/save_appointments'); ?>" class="w-100">
            
            <?= csrf_field(); ?> 
            <div class="row">
                
                <div class="col-md-6">
                     <div class="row"> 
                       <div class=" col-md-12 mb-2"> 
                        <label for="input-1" class="modal_lab">Appointment title</label>
                        <input type="text" class="form-control modal_inpu" name="title" id="title">
                       </div>
                   
                       <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Duration</label>
                        <input type="time" class="form-control modal_inpu" name="duration" id="duration">
                       </div>

                        <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Allow cancelling (Until hours before)</label>
                        <input type="time" class="form-control modal_inpu" name="allow_cancelling_before" id="allow_cancelling_before">
                       </div>

                       <div class=" col-md-12 mb-2"> 
                            <div class="d-flex">
                                <label for="input-1" class="modal_lab me-3">Availabilty on</label>
                    
                                <div class="form-check me-3">
                                  <input class="form-check-input" type="radio" name="availability_on" id="availability_on1" value="0" checked>
                                  <label class="form-check-label" for="availability_on1">
                                    Users
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="availability_on" id="availability_on2" value="1">
                                  <label class="form-check-label" for="availability_on2">
                                    Resources
                                  </label>
                                </div>
                            </div>
                       </div>
                        <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Person</label>
                        <input type="text" class="form-control modal_inpu" name="person" id="person">
                       </div>

                       <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Resource</label>
                        <input type="text" class="form-control modal_inpu" name="resource" id="resource">
                       </div>


                       <div class=" col-md-6 mb-2"> 
                        <label for="input-1" class="modal_lab">Scheduling (Min hours before)</label>
                        <input type="time" class="form-control modal_inpu" name="hours_before" id="hours_before">
                       </div>

                       

                      
                       <div class=" col-md-12 mb-2">                  
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="is_image_show" name="is_image_show">
                          <label class="form-check-label" for="is_image_show">Show image</label>
                        </div>
                       </div>

                       <div class=" col-md-6 mb-2"> 
                            <div class="d-block">
                                <label for="input-1" class="modal_lab me-3">Assignment method</label>
                    
                                <div class="form-check me-3">
                                  <input class="form-check-input" type="radio" name="assign_method" id="assign_method1" value="0" checked>
                                  <label class="form-check-label" for="assign_method1">
                                    Pick Person/Resource then Time
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="assign_method" id="assign_method2" value="1">
                                  <label class="form-check-label" for="assign_method2">
                                    Select Time then Person/Resource
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="assign_method" id="assign_method3" value="2">
                                  <label class="form-check-label" for="assign_method3">
                                    Select Time then auto-assign
                                  </label>
                                </div>
                            </div>
                       </div> 
                    </div> 
                </div>

            <div class="col-md-6">
                
            </div>
               

            </div>
   


        </form>  
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
      
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
 