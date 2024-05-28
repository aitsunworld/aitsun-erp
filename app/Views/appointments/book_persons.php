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
                    <b class="page_heading text-dark">Book persons</b>
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

    <a href="<?= base_url('appointments/create') ?>" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New Appointment</span></a>
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
        <div class="col-md-6">
            <div class="booking_calendar ">
                <input type="date" name="" class="d-none" value="<?= $active_date; ?>" id="calendar_date_selector">
            </div>

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

            </form>
        </div>

        <div class="booking_details col-md-6">
            <h5><?= ($active_date==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today\'s':''; ?> Booking - <?= get_date_format($active_date,'d M Y, l') ?></h5>
            <div class="w-100 book_list">
                <?php foreach ($todays_booking as $bk): ?> 
                   
                    <div class="bg-white booking_item p-1 mb-2">
                        <div class="d-flex justify-content-between"> 
                            <div class="d-flex">
                                <div class="me-2">
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
                                 
                                    <img src="<?= base_url('public/uploads/users') ?>/<?= $profile_image ?>">
                                  
                                </div>
                                <div>
                                    <h6 class="mb-1">
                                        <?= $bk['booking_name'] ?> 
                                        <a class="edit_booking" data-booking_id="<?= $bk['id'] ?>"><i class="bx bx-pencil text text-decoration-underline"></i></a>
                                    </h6>
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
                                    <div class="d-flex">
                                        <div class="book_type my-auto me-2">
                                            <?php if ($bk['booking_type']=='person'): ?>
                                                <i class="bx bx-time"></i> Scheduled 
                                            <?php else: ?>
                                                <i class="bx bx-check-square"></i> Booked 
                                            <?php endif ?>
                                            > <?= $bk['duration'] ?> hrs
                                        </div>
                                        <span class="my-auto" style="font-size: 10px;">> <?= appointments_data(strip_tags($bk['appointment_id']),'title') ?></span>
                                    </div>
                                  
                                    <div>
                                        <div>
                                            <small class="me-3">Booked on: <?= get_date_format($bk['datetime'],'d M Y h:i A') ?></small>  
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="schedule_box">
                                <div class="timeto"> 
                                    <div>
                                        <?= (get_date_format($bk['book_from'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_from'],'d M'); ?> - <?= get_date_format($bk['book_from'],'h:i A') ?>
                                    </div>
                                    <div><i class="bx bx-down-arrow"></i></div>
                                    <div>
                                        <?= (get_date_format($bk['book_to'],'Y-m-d')==get_date_format(now_time($user['id']),'Y-m-d'))? 'Today':get_date_format($bk['book_to'],'d M'); ?> - <?= get_date_format($bk['book_to'],'h:i A') ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
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
 