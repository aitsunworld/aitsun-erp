<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url('time_table') ?>?page=1"><b class="page_heading text-dark">School Calendar</b></a>
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

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#time_table"> 
            <span class="my-auto"></span>
        </a>
    </div>
    <div>
        
        <a type="button" data-bs-toggle="modal" data-bs-target="#addcalenderevent" class="text-dark font-size-footer ms-2 my-auto"> <span class="">+ Event</span></a>
    </div>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MODAL ///////////////////////// -->

<div class="modal fade" id="addcalenderevent" tabindex="-1" data-bs-backdrop="static" aria-labelledby="EventModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add event</h5>    
                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form method="post" action="<?= base_url('calendar/add_cal_event');?>" id="add_cal_event_form">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div id="er_mes"></div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="form-label">Event name</label>
                            <input type="text" name="title" id="title" class="form-control" required="">
                        </div>
                        <div class="form-group col-md-12 mb-3 date_hide_class">
                            <label class="form-label">Start date</label>
                            <input type="date" name="start" id="start" class="form-control d-block" required>
                        </div>
                        <div class="form-group col-md-12 mb-3 date_hide_class">
                            <label class="form-label">End date</label>
                            <input type="date" name="end" id="end" class="form-control d-block" required>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer text-start py-1">
                    <button type="button" class="aitsun-primary-btn add_cal_event" data-tid="">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- ////////////////////////// MAIN PAGE ///////////////////////// -->

 <div class="sub_main_page_content">
 
            <div class="row">
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body p-2">
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


                            <div class="calendar_container pt-2">
                                <input type="date" name="" class="d-none" value="<?= $active_date; ?>" id="calendar_date_selector">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="card" style=" box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);">
                        <div class="card-body p-3">

                            <?php if (get_date_format(now_time($user['id']),'Y-m-d')==$active_date): ?>
                            <h5 class="text-center">Today</h5>
                            <?php else: ?>
                            <h5 class="text-center">On <?= get_date_format($active_date,'d M Y') ?></h5>
                            <?php endif ?>

                            <?php $i=0; foreach ($today_event_data as $event): $i++; ?>  
                            <div class="cal_event_div py-1 px-2 mb-2">
                                <div class="d-flex justify-content-between">
                                <h6 class="my-auto aitsun_link"><?= $event['title']; ?></h6>
                                <div class="my-auto">
                                    <?php if ($event['deletable']=='1'): ?>
                                    <a class="btn-edit-dark me-2 action_btn cursor-pointer" style="font-size: 11px !important;" data-bs-toggle="modal" data-bs-target="#editcalenderevent<?= $event['id']; ?>"><i class="bx bxs-edit-alt"></i></a>
                                     <?php endif ?>
                                    <a class="delete_cal_event btn-delete-red action_btn cursor-pointer" style="font-size: 11px !important;" data-url="<?= base_url('calendar/delete_event'); ?>/<?= $event['id']; ?>" data-deletableev="<?= $event['deletable']; ?>"><i class="bx bxs-trash"></i>
                                    </a>
                                </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                            <?php if ($i==0): ?>
                                <div class="cal_event_div py-1 px-2 mb-2">
                                    <h6 class="m-b-0 text-danger text-center">No events</h6>
                                </div>
                            <?php endif ?>
                            
                            <hr class="mb-3">
                            

                            <?php if (get_date_format(now_time($user['id']),'Y-m')==get_date_format($active_date,'Y-m')): ?>
                               <h5 class="text-center">This Month</h5>
                            <?php else: ?>
                                <h5 class="text-center">In the month of <?= get_date_format($active_date,'M Y') ?></h5> 
                            <?php endif ?>

                             <?php $i=0; foreach ($this_month_event_data as $event): $i++; ?> 
                                <div class="cal_event_div py-1 px-2 mb-2">
                                    <div class="text-center pb-1 mb-2 border-bottom">
                                        <?php if ($event['start_event']==$event['end_event']): ?>
                                            <small class="text-dark font-size-12 font-weight-semibold">On <?= get_date_format($event['start_event'],'d M Y l'); ?></small>
                                        <?php else: ?>
                                            <small class="text-dark font-size-12 font-weight-semibold">On <?= get_date_format($event['start_event'],'d M Y D'); ?> to <?= get_date_format($event['end_event'],'d M Y D'); ?></small>
                                        <?php endif ?>

                                    </div>
                                    <div class="d-flex justify-content-between ">
                                    <h6 class="my-auto aitsun_link "><?= $event['title']; ?></h6>
                                    <div class="my-auto">
                                        <?php if ($event['deletable']=='1'): ?>
                                            
                                            <a class="btn-edit-dark me-2 action_btn cursor-pointer" style="font-size: 11px !important;" data-bs-toggle="modal" data-bs-target="#editcalenderevent<?= $event['id']; ?>"><i class="bx bxs-edit-alt"></i></a>

                                        <?php endif ?>
                                        

                                         <a class="delete_cal_event btn-delete-red action_btn cursor-pointer" style="font-size: 11px !important;" data-url="<?= base_url('calendar/delete_event'); ?>/<?= $event['id']; ?>" data-deletableev="<?= $event['deletable']; ?>"><i class="bx bxs-trash"></i>
                                        </a>
                                    </div>
                                    </div>

                                    <!-- /////////////////////////EVENT EDIT MODAL////////////////////// -->


                                    <div class="modal fade" id="editcalenderevent<?= $event['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit event</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <i class="anticon anticon-close"></i>
                                                    </button>
                                                </div>
                                                <form method="post" action="<?= base_url('calendar/edit_cal_event');?>/<?= $event['id']; ?>" id="add_cal_event_form<?= $event['id']; ?>">
                                                    <?= csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div id="er_mes<?= $event['id'] ?>"></div>
                                                            
                                                            <div class="form-group col-md-12 mb-3">
                                                                <label class="form-label">Event name</label>
                                                                <input type="text" name="title" id="title<?= $event['id'] ?>" class="form-control" value="<?= $event['title']; ?>" required>
                                                            </div>
                                                            <div class="form-group col-md-12 mb-3 date_hide_class">
                                                                <label class="form-label">Start date</label>
                                                                <input type="date" name="start" id="start<?= $event['id'] ?>" class="form-control d-block" value="<?= get_date_format($event['start_event'],'Y-m-d'); ?>" required>
                                                            </div>
                                                            <div class="form-group col-md-12 mb-3 date_hide_class">
                                                                <label class="form-label">End date</label>
                                                                <input type="date" name="end" class="form-control d-block" value="<?= get_date_format($event['end_event'],'Y-m-d'); ?>" required>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                       
                                                        <button type="button" class="aitsun-primary-btn add_cal_event" data-tid="<?= $event['id']; ?>">Save</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>



                                    <!-- /////////////////////////EVENT EDIT MODAL////////////////////// -->


                                </div>
                            <?php endforeach ?>
                            <?php if ($i==0): ?>
                                <div class="cal_event_div py-1 px-2 mb-2">
                                    <h6 class="m-b-0 text-danger text-center">No events</h6>
                                </div>
                            <?php endif ?>

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->

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

  
</script> 

<script type="text/javascript">
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



     $(document).on('click','.delete_cal_event',function(event){
      var deleteurl=$(this).data('url');

      var deletableev=$(this).data('deletableev');

       if (deletableev==0) {
        Swal.fire({
              title: "You cant delete this",
              text: "If you want to delete this event, please go to EC/CC or Sports event page",
            
            });

       }else{

        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }).then((result) => {
            if (result.isConfirmed) {

       $.ajax({
            type: 'GET',
            url: deleteurl,
             beforeSend: function() {
                
                // setting a timeout
                // $(techerbt).html('Saving  <i class="anticon anticon-loading d-inline-block"></i> ');
                
            },
            success: function() {
              
                Swal.fire("Deleted!", "Your imaginary file has been deleted.", "success");

                location.reload();

         
             
            }
             });
        }
        });
    }
});
</script>