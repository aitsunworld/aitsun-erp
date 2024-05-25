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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Time Flow Report</b>
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
        
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// FILTER ///////////////////////// -->
    <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
              
            <form method="get" class="d-flex">
                <?= csrf_field(); ?>
               <input type="date" name="from" class="form-control form-control-sm filter-control" title="From" placeholder="">
                <input type="date" name="to" title="To" class="form-control form-control-sm filter-control" placeholder="">
              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('day_book') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card radius-10">
                    <div class="card-body">
                     <div class="d-flex align-items-center">
                         <div>
                             <h6 class="mb-0">Overview 

                                <?php if ($global_date==get_date_format(now_time($user['id']),'Y-m-d')): ?>
                                     (<span>Today</span>)
                                <?php elseif ($global_date == date('Y-m-d',strtotime("-1 days")) ):?>
                                    (<span>Yesterday</span>)
                                <?php else: ?>
                                    (<?= get_date_format($global_date,'d F Y') ?>)
                                <?php endif ?>
                                
                            </h6>

                         </div>
                         <div class="dropdown ms-auto">
                             <a class="aitsun_link dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded text-option' style="font-size: 22px;"></i>
                             </a>

                            
                             <ul class="dropdown-menu">


                                 <li><a class="dropdown-item" data-ydate="<?= date('Y-m-d',strtotime("-1 days")) ?>" id="yest_date" name="yesdate">Yesterday</a>
                                 </li>
                                 <li><a class="dropdown-item" data-tdate="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>" id="today_date" name="tdate">Today</a>
                                 </li>
                                 <li>
                                     <hr class="dropdown-divider">
                                 </li>



                                <div class="p-1">
                                    <div class="form-group d-flex justify-content-between">  
                                        <input type="date" id="date_box" class="form-control datepicker-input" name="date" placeholder="Pick a date" value="<?= $global_date ?>"  max="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>">
                                    </div>
                                </div>

                                 <!-- <li><a class="dropdown-item" href="javascript:;">Select date</a>
                                 </li> -->
                             </ul>
                         </div>
                     </div>
                     <div class="chart-container-1 mt-4">
                        <?php 
                            $hours = [
                                '09 am-10 am',
                                '10 am-11 am',
                                '11 am-12 pm',
                                '12 pm-01 pm',
                                '01 pm-02 pm',
                                '02 pm-03 pm',
                                '03 pm-04 pm',
                                '04 pm-05 pm',
                                '05 pm-06 pm',
                                '06 pm-07 pm',
                                '07 pm-08 pm',
                                '08 pm-09 pm',
                                '09 pm-10 pm',
                                '10 pm-11 pm',
                                '11 pm-12 am',
                                '12 am-01 am',
                                '01 am-02 am',
                                '02 am-03 am',
                                '03 am-04 am',
                                '04 am-05 am',
                                '05 am-06 am',
                                '06 am-07 am',
                                '07 am-08 am',
                                '08 am-09 am',    

                            ];

                            $sales = [
                                time_flow_sales_report($global_date.' 09:00',$global_date.' 10:00'),
                                time_flow_sales_report($global_date.' 10:00',$global_date.' 11:00'),
                                time_flow_sales_report($global_date.' 11:00',$global_date.' 12:00'),
                                time_flow_sales_report($global_date.' 12:00',$global_date.' 13:00'),
                                time_flow_sales_report($global_date.' 13:00',$global_date.' 14:00'),
                                time_flow_sales_report($global_date.' 14:00',$global_date.' 15:00'),
                                time_flow_sales_report($global_date.' 15:00',$global_date.' 16:00'),
                                time_flow_sales_report($global_date.' 16:00',$global_date.' 17:00'),
                                time_flow_sales_report($global_date.' 17:00',$global_date.' 18:00'),
                                time_flow_sales_report($global_date.' 18:00',$global_date.' 19:00'),
                                time_flow_sales_report($global_date.' 19:00',$global_date.' 20:00'),
                                time_flow_sales_report($global_date.' 20:00',$global_date.' 21:00'),
                                time_flow_sales_report($global_date.' 21:00',$global_date.' 22:00'),
                                time_flow_sales_report($global_date.' 22:00',$global_date.' 23:00'),
                                time_flow_sales_report($global_date.' 23:00',$global_date.' 00:00'),
                                time_flow_sales_report($global_date.' 00:00',$global_date.' 01:00'),
                                time_flow_sales_report($global_date.' 01:00',$global_date.' 02:00'),
                                time_flow_sales_report($global_date.' 02:00',$global_date.' 03:00'),
                                time_flow_sales_report($global_date.' 03:00',$global_date.' 04:00'),
                                time_flow_sales_report($global_date.' 04:00',$global_date.' 05:00'),
                                time_flow_sales_report($global_date.' 05:00',$global_date.' 06:00'),
                                time_flow_sales_report($global_date.' 06:00',$global_date.' 07:00'),
                                time_flow_sales_report($global_date.' 07:00',$global_date.' 08:00'),
                                time_flow_sales_report($global_date.' 08:00',$global_date.' 09:00'),



                            ];
                            $final_hour=json_encode($hours);
                            $final_sales=json_encode($sales);
                         ?>
                        
                         <canvas id="time_flow_sales" data-hours='<?= $final_hour ?>' data-sales='<?= $final_sales ?>'></canvas>
                       </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->


</div>

<script src="<?= base_url('public')?>/js/chartjs/chart.min.js"></script>
<script src="<?= base_url('public')?>/js/chartjs/chart.extension.js"></script>
<script src="<?= base_url('public')?>/js/chartjs/jquery.sparkline.min.js"></script>

    
<script type="text/javascript">

    $(function() {
    "use strict";
      // chart 6
    var ctx = document.getElementById("time_flow_sales").getContext('2d');
   
     var data_hours=$('#time_flow_sales').data('hours');
     var data_sales=$('#time_flow_sales').data('sales');


      var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke4.addColorStop(0, ' #7f00ff');
      gradientStroke4.addColorStop(0.5, '#e100ff');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data_hours,
          datasets: [{
            label: 'Sales',
            data: data_sales,
            borderColor: gradientStroke4,
            backgroundColor: gradientStroke4,
            hoverBackgroundColor: gradientStroke4,
            pointRadius: 0,
            fill: false,
            borderWidth: 1
          }]
        },
        options:{
      maintainAspectRatio: false,
          legend: {
              position: 'bottom',
              display: true,
              labels: {
                boxWidth:12
              }
            },
            tooltips: {
              displayColors:false,
            },  
          scales: {
              xAxes: [{
                barPercentage: .5
              }]
             }
        }
      });
  });

    $(document).on('change','#date_box',function(){
       
    var loc = location.href;
    var sortval = $('#date_box').val();
      
    var key='date';

    $('.page-content').html('<div class="apanel_loader"><div class="timeline-wrapper"><div class="timeline-item"><div class="d-flex justify-content-between"><div class="animated-background title_mask"></div><div class="d-flex"><div class="animated-background button_mask1"></div><div class="animated-background button_mask2"></div></div></div><div class="row mt-3"><div class="col-md-4 mb-3"><div class="d-flex rounded-5"><div class="my-auto w-50"><div class="animated-background proload mr-2"></div></div><div class="my-auto w-50"><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div></div></div></div><div class="col-md-4 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-4 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-12 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-12 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-6 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-6 mb-3"><div class="animated-background rounded-5"></div></div></div></div></div></div>');
    

    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = loc.indexOf('?') !== -1 ? "&" : "?";
        if (loc.match(re)) {
          location.href=loc.replace(re, '$1' + key + "=" + sortval + '$2');
        }
        else {
          location.href=loc + separator + key + "=" + sortval;
        }
    });

    $(document).on('click','#today_date',function(){
       
    var loc = location.href;
    var sortval = $('#today_date').data('tdate');
      
    var key='date';

    $('.page-content').html('<div class="apanel_loader"><div class="timeline-wrapper"><div class="timeline-item"><div class="d-flex justify-content-between"><div class="animated-background title_mask"></div><div class="d-flex"><div class="animated-background button_mask1"></div><div class="animated-background button_mask2"></div></div></div><div class="row mt-3"><div class="col-md-4 mb-3"><div class="d-flex rounded-5"><div class="my-auto w-50"><div class="animated-background proload mr-2"></div></div><div class="my-auto w-50"><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div></div></div></div><div class="col-md-4 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-4 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-12 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-12 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-6 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-6 mb-3"><div class="animated-background rounded-5"></div></div></div></div></div></div>');
    

    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = loc.indexOf('?') !== -1 ? "&" : "?";
        if (loc.match(re)) {
          location.href=loc.replace(re, '$1' + key + "=" + sortval + '$2');
        }
        else {
          location.href=loc + separator + key + "=" + sortval;
        }
    });

    $(document).on('click','#yest_date',function(){
       
    var loc = location.href;
    var sortval = $('#yest_date').data('ydate');
      
    var key='date';

    $('.page-content').html('<div class="apanel_loader"><div class="timeline-wrapper"><div class="timeline-item"><div class="d-flex justify-content-between"><div class="animated-background title_mask"></div><div class="d-flex"><div class="animated-background button_mask1"></div><div class="animated-background button_mask2"></div></div></div><div class="row mt-3"><div class="col-md-4 mb-3"><div class="d-flex rounded-5"><div class="my-auto w-50"><div class="animated-background proload mr-2"></div></div><div class="my-auto w-50"><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div><div class="animated-background protext"></div></div></div></div><div class="col-md-4 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-4 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-12 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-12 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-6 mb-3"><div class="animated-background rounded-5"></div></div><div class="col-md-6 mb-3"><div class="animated-background rounded-5"></div></div></div></div></div></div>');
    

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