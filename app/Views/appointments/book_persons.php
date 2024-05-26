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

            <div class="timings pb-5">

                <div class="row">
                    <?php 
                        $start_time = new DateTime('09:00');
                        $end_time = new DateTime('18:00'); 
                        $interval = new DateInterval('PT30M'); 
                        $timings = new DatePeriod($start_time, $interval, $end_time->add($interval));
                    ?>
                    <div class="col-md-12">
                        <select class="appointment_selector">
                            <option>Select an appointment</option>
                            <option>Eye test</option>
                            <option>Dental checkup</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <h6>Timings:</h6>
                    </div>
                    <?php foreach ($timings as $time): ?>
                        <div class="col-md-3">
                            <div class="time_box">
                                <?= $time->format('H:i') ?>
                            </div>
                        </div>
                    <?php endforeach ?> 
                </div>
            </div>
        </div>

        <div class="booking_details col-md-6">
            <h5>Today's Booking</h5>
            <div class="w-100">
                <table class="erp_table booking_table">
                    <thead>
                        <tr>
                            <th>Appointment title</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Team selection meeting</td>
                            <td>9:00AM to 11:00AM</td>
                        </tr>
                        <tr>
                            <td>Team selection meeting</td>
                            <td>9:00AM to 11:00AM</td>
                        </tr>
                    </tbody> 
                </table>
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
 