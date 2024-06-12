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
                    <?php if ($book_type=='person'): ?>
                        <?php if ($my_appointments=='my_appointments'): ?>
                            <b class="page_heading text-dark">My appointments</b>
                        <?php else: ?>
                            <b class="page_heading text-dark">Book persons</b>
                        <?php endif ?> 
                    <?php else: ?> 
                        <b class="page_heading text-dark">Book Resources</b>
                    <?php endif ?> 
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
        
        <?php if (is_allowed($user['id'], 'read_booked_resources') || is_allowed($user['id'], 'read_booked_person')): ?>
        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer   " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-calendar"></i> Bookings
            </a>
            <div class="dropdown-menu" style="">  
               <?php if (is_allowed($user['id'], 'read_booked_resources')): ?>
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/book_resources') ?>">
                    <span class="">Book resources</span>
                </a>
                <?php endif; ?>
                <?php if (is_allowed($user['id'], 'read_booked_person')): ?>
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/book_persons') ?>">
                    <span class="">Book a person</span>
                </a> 
                <?php endif; ?>   
            </div>
        </div> 
        <?php endif; ?>
        <?php if (is_allowed($user['id'], 'read_appointments_reports')): ?>
        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-file"></i> Reports
            </a>
            <div class="dropdown-menu" style="">  
                <?php if (is_allowed($user['id'], 'read_appointments_reports')): ?> 
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/reports') ?>">
                    <span>Booking reports</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?> 
        <?php if (is_allowed($user['id'], 'read_resources')): ?>
        <div class="dropdown  my-auto me-2">
            
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-cog"></i> Configuration
            </a>
            <div class="dropdown-menu" style=""> 
                <?php if (is_allowed($user['id'], 'read_resources')): ?> 
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/resources') ?>">
                    <span >Resources</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?> 
    </div>

    <?php if (is_allowed($user['id'], 'add_appointments')): ?>
    <a href="<?= base_url('appointments/create') ?>" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New Appointment</span></a>
    <?php endif; ?>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="text" name="display_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?>" class="form-control form-control-sm filter-control ">
                    
     
                      <select class="form-control form-control-sm" name="party_type">
                          <option value="">Type</option>
                          <option value="customer">Customer</option>
                          <option value="vendor">Vendor</option>
                          <option value="delivery">Delivery</option>
                          <option value="seller">Seller</option>
                      </select> 
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('customers') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

    <?php 
        $active_date=get_date_format(now_time($user['id']),'Y-m-d'); 
        if ($_GET) {
            if (isset($_GET['date'])) {
                if (!empty($_GET['date'])) {
                    if (strtotime($_GET['date'])) {
                        $active_date=$_GET['date'];
                    } 
                }
            }
        }
    ?>  
    <?php if ($my_appointments==''): ?>  
        
        <div class="col-md-4">
            <div class="booking_calendar ">
                <input type="date" name="" class="d-none" value="<?= $active_date; ?>" id="calendar_date_selector">
            </div>

         
        </div>
        <div class="col-md-8">
               <form class="timings pb-5" id="booking_form">
                <?= csrf_field() ?>
                <div class="row">
                   
                    <div class="col-md-12" style="padding-right: 30px;">
                        <select class="appointment_selector" id="appointment_selector" >
                            <option value="">Select an appointment</option>
                            <?php foreach ($appointments_array as $apn): ?>
                                <option value="<?= $apn['id'] ?>"><?= $apn['title'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <h6>Timings:</h6>
                        <div class="row" id="timing_box">
                             <div class="col-md-12 text-aitsun-red text-start">Choose appointment for timings</div>
                        </div>  
                    </div>

                </div>

                    <?php if ($book_type=='person'): ?>
                        <?php if (is_allowed($user['id'], 'add_booked_person')): ?>
                            <div class="modal customer_modal fade" id="booking_modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <div class="d-flex">
                                        <h5 class="modal-title">Book a person</h5>
                                      </div>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start" id="booking_form_div">
                                      

                                    </div> 
                                  </div>
                                </div>
                            </div>
                        <?php endif ?> 
                    <?php else: ?> 
                        <?php if (is_allowed($user['id'], 'add_booked_resources')): ?>
                            <div class="modal customer_modal fade" id="booking_modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <div class="d-flex">
                                        <h5 class="modal-title">Book a person</h5>
                                      </div>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start" id="booking_form_div">
                                      

                                    </div> 
                                  </div>
                                </div>
                            </div>
                        <?php endif ?> 
                    <?php endif ?> 

            </form>
        </div>
        <?php endif ?> 

        <div class="booking_details col-md-12">
            <div class="d-flex mt-3 justify-content-between">
                <h5 class=" my-auto"><?= ($active_date==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today\'s':''; ?> Booking - <?= get_date_format($active_date,'d M Y, l') ?></h5>
              <div class="my-auto">
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#bookings_table" data-filename="Bookings- <?= ($active_date==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today\'s':''; ?> Booking - <?= get_date_format($active_date,'d M Y, l') ?>"> 
                    <span class="my-auto">Excel</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#bookings_table" data-filename="Bookings- <?= ($active_date==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today\'s':''; ?> Booking - <?= get_date_format($active_date,'d M Y, l') ?>"> 
                    <span class="my-auto">CSV</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#bookings_table" data-filename="Bookings- <?= ($active_date==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today\'s':''; ?> Booking - <?= get_date_format($active_date,'d M Y, l') ?>"> 
                    <span class="my-auto">PDF</span>
                </a>
               
                <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#bookings_table"> 
                    <span class="my-auto">Quick search</span>
                </a> 

            </div>
            </div>
            <div class="w-100 book_list position-relative">
                <div class="aitsun_table ">
                    <table id="bookings_table" class="mt-1 erp_table sortable no-wrap">
                        <thead>
                            <tr> 
                                <th class="sorticon">No.</th>
                                <th class="sorticon">Title</th>
                                <th class="sorticon">Meeting/Booking</th> 
                                <th class="sorticon">Contact</th>   
                                <th class="sorticon">Duration</th> 
                                <th class="sorticon">Appointment</th> 
                                <th class="sorticon text-center">Starts on</th>  
                                <th class="sorticon text-center">Ends on</th>  
                                <th class="sorticon">Status <small>(Click to change)</small></th> 
                                <th class="sorticon">Billing</th> 
                                <th class="sorticon noExl">Action</th> 
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach ($todays_booking as $bk): ?> 
                                <tr> 
                                    <td><?= $bk['booking_no'] ?></td>
                                    <td>
                                        <?php 
                                            $profile_image='default.webp';
                                            if ($bk['booking_type']=='person') {
                                                if (!empty(trim(user_data($bk['person_id'],'profile_pic')))) {
                                                    $profile_image=user_data($bk['person_id'],'profile_pic');
                                                }
                                            }else{
                                                if (!empty(trim(resource_data($bk['resource_id'],'image')))) {
                                                    $profile_image=resource_data($bk['resource_id'],'image');
                                                }
                                            }
                                        ?>
                                     
                                        <img src="<?= base_url('public/uploads/users') ?>/<?= $profile_image ?>" style="width: 20px;">
                                        <?= $bk['booking_name'] ?> 

                                    </td>
                                    <td> 
                                       <div class="d-flex">
                                            <b><?= user_data($bk['customer'],'display_name') ?></b> 
                                           <i class="bx bx-arrow-back d-block mx-2" style="transform: rotate(180deg);"></i> 
                                           <b class="text-success">
                                            <?php if ($bk['booking_type']=='person'): ?>
                                                <?= user_data($bk['person_id'],'display_name') ?>
                                            <?php else: ?>
                                                <?= resource_data($bk['resource_id'],'appointment_resource') ?>
                                            <?php endif ?> 
                                            </b>  
                                       </div>
                                    </td> 
                                    <td>
                                        <?= user_data($bk['customer'],'phone') ?>
                                        <?= (!empty(user_data($bk['customer'],'email')))?'<br>'.user_data($bk['customer'],'email'):'' ?>
                                    </td>  
                                   
                                    <td><?= $bk['duration'] ?> hrs</td> 
                                    <td><?= appointments_data(strip_tags($bk['appointment_id']),'title') ?></td> 
                                    <td>
                                         <?= (get_date_format($bk['book_from'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_from'],'d M'); ?> - <?= get_date_format($bk['book_from'],'h:i A') ?>
                                    </td>  
                                    <td>
                                        <?= (get_date_format($bk['book_to'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_to'],'d M'); ?> - <?= get_date_format($bk['book_to'],'h:i A') ?>
                                    </td>  
                                    <td class="text-center"> 
                                        <div class="dropdown">
                                            <a class="text-dark cursor-pointer font-size-footer   " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?php if ($bk['status']==0): ?>
                                                    <span class="badge bg-warning text-dark">Scheduled</span>
                                                <?php elseif ($bk['status']==1): ?>
                                                    <span class="badge bg-primary text-white">Visited</span>
                                                <?php elseif ($bk['status']==2): ?>
                                                    <span class="badge bg-success text-white">Completed</span> 
                                                <?php elseif ($bk['status']==3): ?>
                                                    <span class="badge bg-danger text-white">Pending</span> 
                                                <?php endif ?>
                                            </a>
                                            <?php if ($bk['booking_type']=='person'): ?>
                                                <?php if (is_allowed($user['id'], 'person_booking_status')): ?>
                                                <div class="dropdown-menu" style=""> 
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="0">
                                                        <span class="">Scheduled</span>
                                                    </a>   
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="1">
                                                        <span class="">Visited</span>
                                                    </a> 
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="3">
                                                        <span class="">Pending</span>
                                                    </a>  
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="2">
                                                        <span class="">Completed</span>
                                                    </a> 
                                                </div>
                                                <?php endif ?>
                                            
                                            <?php else: ?>  
                                                <?php if (is_allowed($user['id'], 'resource_booking_status')): ?>
                                                <div class="dropdown-menu" style=""> 
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="0">
                                                        <span class="">Scheduled</span>
                                                    </a>   
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="1">
                                                        <span class="">Visited</span>
                                                    </a> 
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="3">
                                                        <span class="">Pending</span>
                                                    </a>  
                                                    <a class="dropdown-item confirm_checkin" data-id="<?= $bk['id'] ?>" data-value="2">
                                                        <span class="">Completed</span>
                                                    </a> 
                                                </div>
                                                <?php endif ?>
                                            <?php endif ?>



                                        </div>  
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($bk['booking_type']=='person'): ?>
                                            <?php if (is_allowed($user['id'], 'person_billing')): ?>
                                                <?php if ($bk['billing_status']==0): ?>
                                                     <a href="<?= base_url('invoices/create_invoice') ?>?customer=<?= $bk['customer'] ?>&booking=<?= $bk['id'] ?>" class=" aitsun-link mt-2 rounded-pill">Make bill</a>
                                                <?php else: ?>
                                                    <span class="badge bg-success text-white">Billed</span>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php else: ?>
                                            <?php if (is_allowed($user['id'], 'resource_billing')): ?>
                                                <?php if ($bk['billing_status']==0): ?>
                                                     <a href="<?= base_url('invoices/create_invoice') ?>?customer=<?= $bk['customer'] ?>&booking=<?= $bk['id'] ?>" class=" aitsun-link mt-2 rounded-pill">Make bill</a>
                                                <?php else: ?>
                                                    <span class="badge bg-success text-white">Billed</span>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endif ?>


                                    </td> 
                                    
                                   
                                    <td class="noExl">

                                        <?php if ($bk['booking_type']=='person'): ?>
                                            <?php if (is_allowed($user['id'], 'edit_booked_person')): ?>
                                                 <?php if ($bk['status']!=2): ?>
                                                     <a class="edit_booking" data-booking_id="<?= $bk['id'] ?>"><i class="bx bx-pencil text text-decoration-underline"></i> Edit</a>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php else: ?>
                                            <?php if (is_allowed($user['id'], 'edit_booked_resources')): ?>
                                                <?php if ($bk['status']!=2): ?>
                                                     <a class="edit_booking" data-booking_id="<?= $bk['id'] ?>"><i class="bx bx-pencil text text-decoration-underline"></i> Edit</a>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endif ?>

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
      
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/webshim/1.16.0/minified/polyfiller.js"></script>

<script type="text/javascript">
  
    webshim.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'date',
        date: {
            startView: 2,
            inlinePicker: true,
            classes: 'hide-inputbtns'
        }
    });
    webshim.setOptions('forms', {
        lazyCustomMessages: true
    });
    //start polyfilling
    webshim.polyfill('forms forms-ext');

    //only last example using format display
    $(function () {

        $('.format-date').each(function () {

            var $display = $('.date-display', this);
            $(this).on('change', function (e) {
                //webshim.format will automatically format date to according to webshim.activeLang or the browsers locale
                var localizedDate = webshim.format.date($.prop(e.target, 'value'));
                $display.html(localizedDate);
            });
        });
    });

    function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        }
 $(document).on('change','#calendar_date_selector',function(){
        var loc = location.href;
        var sortval = $('#calendar_date_selector').val();
          
        var key='date';

         
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = loc.indexOf('?') !== -1 ? "&" : "?";
        if (loc.match(re)) {
          location.href=loc.replace(re, '$1' + key + "=" + sortval + '$2');
        }
        else {
          location.href=loc + separator + key + "=" + sortval;
        }
    });
      
    </script> 




 
 <!-- <div class="bg-white booking_item position-relative p-1 mb-2">

    <php if ($bk['status']==2): ?>
        <div class="billed_tag">
            <span>Billed</span>
        </div>
    <php endif ?> 
    <div class="d-flex justify-content-between <= ($bk['status']==2)?'opacity_60':''; ?>"> 
        <div class="d-flex">
            <div class="me-2">
                <php 
                    $profile_image='default.webp';
                    if ($bk['booking_type']=='person') {
                        if (!empty(trim(user_data($bk['person_id'],'profile_pic')))) {
                            $profile_image=user_data($bk['person_id'],'profile_pic');
                        }
                    }else{
                        if (!empty(trim(resource_data($bk['resource_id'],'image')))) {
                            $profile_image=resource_data($bk['resource_id'],'image');
                        }
                    }
                ?>
             
                <img src="<= base_url('public/uploads/users') ?>/<= $profile_image ?>">
              
            </div>
            <div>
                <h6 class="mb-1">
                    <= $bk['booking_name'] ?> 
                    <php if ($bk['status']!=2): ?>
                         <a class="edit_booking" data-booking_id="<= $bk['id'] ?>"><i class="bx bx-pencil text text-decoration-underline"></i></a>
                    <php endif ?> 
                   

                </h6>
                <div class="d-flex">
                   <b><= user_data($bk['customer'],'display_name') ?></b> 
                   <i class="bx bx-arrow-back d-block mx-2" style="transform: rotate(180deg);"></i> 
                   <b class="text-success">
                    <php if ($bk['booking_type']=='person'): ?>
                        <= user_data($bk['person_id'],'display_name') ?>
                    <php else: ?>
                        <= resource_data($bk['resource_id'],'appointment_resource') ?>
                    <php endif ?> 
                    </b>
                </div>
                <div class="d-flex">
                    <div class="book_type my-auto me-2">
                        <php if ($bk['booking_type']=='person'): ?>
                            <i class="bx bx-time"></i> Scheduled 
                        <php else: ?>
                            <i class="bx bx-check-square"></i> Booked 
                        <php endif ?>
                        > <= $bk['duration'] ?> hrs
                    </div>
                    <span class="my-auto" style="font-size: 10px;">> <= appointments_data(strip_tags($bk['appointment_id']),'title') ?></span>
                </div>
              
                <div>
                    <div>
                        <small class="me-3">Booked on: <= get_date_format($bk['datetime'],'d M Y h:i A') ?></small>  
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="schedule_box">
            <div class="timeto <= ($bk['status'])?'bg-success':'bg-danger'; ?>"> 
                <div>
                    <= (get_date_format($bk['book_from'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_from'],'d M'); ?> - <= get_date_format($bk['book_from'],'h:i A') ?>
                </div>
                <div><i class="bx bx-down-arrow"></i></div>
                <div>
                    <= (get_date_format($bk['book_to'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_to'],'d M'); ?> - <= get_date_format($bk['book_to'],'h:i A') ?>
                </div> 

                <php if ($bk['status']!=2): ?> 
                <div class="timeto_label">
                    <div>
                        <h6 class="mb-1">Contact Information</h6>

                         <b>Name:</b> <br> <= user_data($bk['customer'],'display_name') ?>
                            <php if (!empty(user_data($bk['customer'],'email'))): ?>
                                <br> <b>Email:</b> <br> <= user_data($bk['customer'],'email') ?>
                            <php endif ?> 
                         
                        
                        <php if ($bk['booking_type']=='resource'): ?>
                         <br><b>Resource:</b> <br><= resource_data($bk['resource_id'],'appointment_resource') ?>
                        <php endif ?>  

                        <h6 class="mb-1 mt-2">Booking Details</h6>
                        <b>Type:</b> <br><= appointments_data(strip_tags($bk['appointment_id']),'title') ?>
                        <br> <b>Start Date:</b> <br><= (get_date_format($bk['book_from'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_from'],'d M Y'); ?> - <= get_date_format($bk['book_from'],'h:i A') ?>
                        <br> <b>Stop Date:</b> <br><= (get_date_format($bk['book_to'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_to'],'d M Y'); ?> - <= get_date_format($bk['book_to'],'h:i A') ?>
                        <php if ($bk['status']!=2): ?>
                            <div class="d-flex justify-content-center mt-2">
                                <div class="text-center">
                                    <button class="btn btn-edit-dark rounded-pill confirm_checkin" data-id="<= $bk['id'] ?>" data-value="<= ($bk['status'])?'0':'1'; ?>"><= ($bk['status'])?'Unconfirm':'Confirm'; ?> Check-In</button>
                                <php if ($bk['status']==1): ?>
                                    <a href="<= base_url('invoices/create_invoice') ?>?customer=<= $bk['customer'] ?>&booking=<= $bk['id'] ?>" class="btn btn-sm btn-success mt-2 rounded-pill">Make bill</a>
                                <php endif ?>
                                </div>
                            </div>
                        <php endif ?> 
                    </div> 
                </div>
                <php endif ?> 
            </div>
        </div>
    </div>
</div> -->