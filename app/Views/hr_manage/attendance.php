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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Attendance</b>
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
        <a href="<?= base_url('hr_manage/employee_lists'); ?>" class="text-dark font-size-footer me-2 href_loader">Employee List</a>    
        <a class="text-dark font-size-footer me-2 href_loader" href="<?= base_url('hr_manage/attendance_settings'); ?>">Settings</a>
        
        

        <?php if (get_setting(company($user['id']),'fp_device')==1): ?> 
          <a class="text-dark font-size-footer me-2" href="javascript:void(0);" id="download_from_device"><i class="bx bx-download"></i> Download from device</a>
        <?php endif ?>
        
    </div>

    <div><?= day_of_date(get_date_format(now_time($user['id']),'Y-m-d'),$attend_date) ?></div>
    
    <div>
        <label>Filter date:</label>
        <input type="date" id="attend_date_box" class="aitsun-datebox datepicker-input my-auto ms-2" name="date" placeholder="Pick a date" value="<?= $attend_date; ?>" max="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>" required>

        <button class="aitsun-primary-btn-topbar" data-bs-toggle="modal" data-bs-target="#manual_punch_modal"><i class="bx bx-fingerprint"></i> Punch manually</button>
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<div class="aitsun-modal modal fade" id="manual_punch_modal"  aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manual punching</h5>
                <button type="button" class="btn-close close_staff_mod" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="manual_punch_form" action="<?= base_url('hr_manage/manual_push_punch') ?>" method="post">
                <?= csrf_field(); ?>
                  <div class="modal-body">
                    <div class="row">
                     
                     <div class="col-md-12 mb-2"> 

                            <label for="classes">Select Employee </label>
                            
                            <div class="aitsun_select position-relative">
                                                   
                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/employees'); ?>">
                                <a class="select_close d-none"><i class="bx bx-x"></i></a>
                     
                                <select class="form-select" required name="punch_employee">
                                    <option value="">Select Employee</option> 
                                </select>

                                <div class="aitsun_select_suggest">
                                </div>
                            </div>
                            
                     </div>  
  

                     <div class="col-md-6 mb-2"> 
                         <div class="form-group">
                             <label>Date</label>
                             <input type="date" name="punch_date" class="form-control" value="<?= get_date_format(now_time($user['id']),'Y-m-d') ?>" required>
                         </div>
                     </div>

                     <div class="col-md-6 mb-2"> 
                         <div class="form-group">
                             <label>Time</label>
                             <input type="time" name="punch_time" class="form-control" value="<?= get_date_format(now_time($user['id']),'h:i:s') ?>" required>
                         </div>
                     </div>
                     
                      
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between"> 
                    <div>
                        <button type="button" class="btn btn-secondary close_staff_mod" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                        <button type="button" class="aitsun-primary-btn" id="manual_punch"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                    </div> 
                  </div>
                </form>
                                            
        </div>
    </div>
</div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content"> 
    
 
     <?php if ($type=='pushed'): ?>
        <?= view('hr_manage/attendance-pushed') ?>
     <?php else: ?>
        <?= view('hr_manage/attendance-logs') ?>
     <?php endif ?>
     
 
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">

        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/detailed_attendance_report'); ?>">Attendance Reports</a>

        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report'); ?>">Reports</a>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report/leave_report'); ?>">Leave reports</a>
        <?php if (is_aitsun(company($user['id']))): ?>
         <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/leave_management'); ?>">Leave management</a> 
        <?php endif ?>   
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 

 <script type="text/javascript">


     $(document).on('click','#download_from_device',function(){ 


   

      
      var this_upload_btn=$('#download_from_device');    
      var this_upload_btn_content=$('#download_from_device').html();

       
        $(this_upload_btn).html('<i class="bx bx-loader-alt bx-spin me-0"></i> Downloading...');
        $(this_upload_btn).prop('disabled', true); 

        const data_to_push = {
            fp_address: '<?= get_setting(company($user['id']),'fp_address') ?>',                 
            fp_port: '<?= get_setting(company($user['id']),'fp_port') ?>'      
        }
    
        window.api.download_data_fp_device('fromFP', data_to_push);

      
    });

    window.api.receive('get-attendance-data', (event,  data) =>{   
      if (data.status==1) { 

        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
        var csrfHash = $('#csrf_token').val(); // CSRF hash

        $.ajax({
            type: "POST",
            url: '<?= base_url() ?>hr_manage/push_attendance',

            data: {
                'data':JSON.stringify(data.attandance_data),
                [csrfName]: csrfHash
            }, 
            beforeSend: function() {
            },
            success: function(data) {
                console.log(data)
                show_success_msg('success','Data downloaded successfully'); 


              var this_upload_btn=$('#download_from_device');    
              var this_upload_btn_content=$('#download_from_device').html();

                $(this_upload_btn).prop('disabled', false); 
                $(this_upload_btn).html(this_upload_btn_content);
                
                setInterval(function(){
                    location.reload();
                },2000);
            }
        });

        
      }else{
        show_success_msg('error','Failed to download data, Please check your device configuration!');
      }
    });



    function show_success_msg(type,message,title) {
         Lobibox.notify(type, {
            size: 'mini',
            title: title,
            position: 'top right',
            width: 300,
            icon: 'bx bxs-check-circle',
            sound: false,
            // delay: false,
            delay: 2000,
            delayIndicator: false,
            showClass: 'zoomIn',
            hideClass: 'zoomOut',
            msg: message
        });
    }

    function show_failed_msg(type,message,title) {
        Lobibox.notify(type, {
            size: 'mini',
            title: title,
            position: 'top right',
            width: 300,
            icon: 'bx bxs-x-circle',
            sound: false,
            // delay: false,
            delay: 2000,
            delayIndicator: false,
            showClass: 'zoomIn',
            hideClass: 'zoomOut',
            msg: message
        });
    }
 </script>