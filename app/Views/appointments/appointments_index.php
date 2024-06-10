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
                    <b class="page_heading text-dark">Appointments</b>
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
        
        <a href="<?= base_url('appointments/book_persons/my_appointments') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-user"></i> <span class="my-auto">My Appointments</span></a>

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

        
        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-file"></i> Reports
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/reports') ?>">
                    <span>Booking reports</span>
                </a>
               <!--  <a class="dropdown-item href_loader" href="#">
                    <span>Person wise</span>
                </a>
                <a class="dropdown-item href_loader" href="#">
                    <span>Resource wise</span>
                </a> -->
            </div>
        </div> 



        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-cog"></i> Configuration
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/resources') ?>">
                    <span >Resources</span>
                </a>
                 
            </div>
        </div> 

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2 my-auto" data-bs-toggle="collapse" data-bs-target="#filter-appointment"> 
            <i class="bx bx-filter"></i> <span class="my-auto">Filter</span>
        </a>


    </div>

    <a href="<?= base_url('appointments/create') ?>" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New Appointment</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
        
        <div id="filter-appointment" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="text" name="appointment" placeholder="Search appointment" class="form-control form-control-sm filter-control ">
                    
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('appointments') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 
        <table class="appointments_table">
            <?php $slno=0; foreach ($appointment_data as $aps): $slno++; ?> 
            <tr class="ap_tr" style="background: <?php echo ($slno % 2 == 0) ? "white" : "#ffffff54"; ?>;">
                <td>
                    <h6><?= $aps['title'] ?></h6>
                </td>
                <td>
                    <div class="duration">
                        <div class="time-span"><?= $aps['duration'] ?> minutes</div>
                        <div class="time-head">Duration</div>
                    </div>
                </td>
                <td>
                    <?php if ($aps['availability_on']=='0'): ?>
                        <div class="d-flex">
                            <img src="<?= user_profile_pic($aps['person']); ?>" class="me-2 res_per_img"> 
                            <div class="my-auto"><?= user_name($aps['person']) ?></div>
                        </div>
                    <?php elseif ($aps['availability_on']=='1'): ?>
                         <div class="d-flex">
                            <img src="<?= resource_pic($aps['resource']); ?>" class="me-2 res_per_img"> 
                            <div class="my-auto"><?= resource_data($aps['resource'],'appointment_resource') ?></div>
                        </div>
                    <?php endif ?>
                    
                </td>
                <td>
                    <div class="duration">
                        <div class="time-span"><?= $aps['scheduled_bookings'] ?> <?= (!$aps['availability_on'])?'meetings':'bookings' ?></div>
                        <div class="time-head">Scheduled</div>
                    </div>
                </td>
                <td>
                    <div class="duration">
                        <div class="time-span"><?= $aps['total_scheduled_bookings'] ?> Total <?= (!$aps['availability_on'])?'meetings':'bookings' ?></div>
                        <div class="time-head">(Last 30 days)</div>
                    </div>
                </td>
                <td class="app_padding">
                    <div class="dropdown dropdown-animated ">
                        <a class="text-dark cursor-pointer font-size-footer ms-2 my-auto " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-cog"></i> Action
                        </a>
                        <div class="dropdown-menu" style="">  
                            <a class="dropdown-item href_loader" href="<?= base_url('appointments/create/'.$aps['id']); ?>">
                                <span class="">Edit</span>
                            </a>
                            <a class="dropdown-item delete_appointment" data-deleteurl="<?= base_url('appointments/delete_appointment'); ?>/<?= $aps['id']; ?>">
                                <span>Delete</span>
                            </a> 
                            </a> 
                        </div>
                    </div>
                
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        

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
      <!-- <= $pager->links() ?> -->
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 