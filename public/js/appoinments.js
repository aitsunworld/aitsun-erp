$(document).ready(function() { 

    
    
    $(document).on('click','.save_booking',function(){ 
        var this_btn=$(this);
        var booking_name=$.trim($('#booking_name').val());
        var booking_party=$('#booking_party').val();
        var duration=$('#duration').val();
        var to_date=$('#book_to_date').val();
        var to_time=$('#book_to_time').val();
        var from_date=$('#book_from_date').val();
        var from_time=$('#book_from_time').val();
        var from_datetime=from_date+' '+from_time;
        var to_datetime=to_date+' '+to_time; 

        var is_ready_to_submit=true;

        if (booking_name.length<1) {
            is_ready_to_submit=false;
            show_success_msg('error','Booking name required!');
        }

        if (booking_party<1) {
            is_ready_to_submit=false;
            show_success_msg('error','Select party!');
        }

        var fromDate = new Date(from_datetime);
        var toDate = new Date(to_datetime);

        // Check if fromDate is less than toDate
        if (fromDate < toDate) {
            
        } else if (fromDate > toDate) { 
            is_ready_to_submit=false;
            show_success_msg('error','From date is greater than to date.');
        } else {
            is_ready_to_submit=false;
            show_success_msg('error','From date is equal to to date.');
        }

        if (is_ready_to_submit) {
            // $(this_btn).prop('disabled', true);
            $.ajax({
                type: "POST", 
                url: base_url()+'appointments/save_booking',
                data: $('#booking_form').serialize(),
                beforeSend:function(){  
                  $(this_btn).html('<span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span> Booking...');  
               },
                success:function(response) {
                  show_success_msg('success','Booking completed!');
                  $(this_btn).prop('disabled', false);
                  location.reload();
               },
               error:function(response){
                alert(JSON.stringify(response));
               }
          });
             
        }

    });

    $(document).on('click','.time_box',function(){
        $('#booking_modal').modal('show');

        var app_date=$('#calendar_date_selector').val();
        var appointment_id=$('#appointment_selector').val();
        var booking_from=$(this).data('time');
        
        $.ajax({
            type: 'GET',
            url: base_url()+'appointments/get_booking_form/'+app_date+'/'+booking_from+'/'+appointment_id, 
            beforeSend: function() { 
            },
            success: function(response) {
                $('#booking_form_div').html(response); 
            }
            
        });
    });

    $(document).on('click','.edit_booking',function(){
        $('#booking_modal').modal('show');
 
        var booking_id=$(this).data('booking_id');
        
        $.ajax({
            type: 'GET',
            url: base_url()+'appointments/get_booking_edit_form/'+booking_id, 
            beforeSend: function() { 
            },
            success: function(response) {
                $('#booking_form_div').html(response); 
            }
            
        });
    });

    

    $(document).on('blur','.booking_duration',function(){
        var durat=$(this).val();
        var book_from_time=$('#book_from_time').val();
        var time = book_from_time;
        var duration = durat;
        var timeParts = time.split(':');
        var durationParts = duration.split(':');
        var hours = parseInt(timeParts[0], 10);
        var minutes = parseInt(timeParts[1], 10);
        var durationHours = parseInt(durationParts[0], 10);
        var durationMinutes = parseInt(durationParts[1], 10);
        var totalMinutes = (hours * 60 + minutes) + (durationHours * 60 + durationMinutes);
        var newHours = Math.floor(totalMinutes / 60);
        var newMinutes = totalMinutes % 60;
        var newTime = ('0' + newHours).slice(-2) + ':' + ('0' + newMinutes).slice(-2);
        $('#book_to_time').val(newTime); 
    });


    $(document).on('blur','#book_to_date,#book_to_time,#book_from_date,#book_from_time',function(){
        var to_date=$('#book_to_date').val();
        var to_time=$('#book_to_time').val();

        var from_date=$('#book_from_date').val();
        var from_time=$('#book_from_time').val();
        var from_datetime=from_date+' '+from_time;
        var to_datetime=to_date+' '+to_time;  
 
        var from = new Date(from_datetime.replace(' ', 'T'));
        var to = new Date(to_datetime.replace(' ', 'T'));
 
        // Calculate the difference in milliseconds
        var diff = to - from;

        // Convert the difference to minutes
        var totalMinutes = Math.floor(diff / (1000 * 60));

        // Calculate hours and minutes
        var hours = Math.floor(totalMinutes / 60);
        var minutes = totalMinutes % 60;
        
        if (isNaN(hours) || isNaN(minutes)) {
            hours = 0;
            minutes = 0;
        }
 
        var hoursString = hours.toString().padStart(2, '0');
        var minutesString = minutes.toString().padStart(2, '0');

        $('#duration').val(hoursString + ':' + minutesString);
    });

    $(document).on('change','#appointment_selector',function(){
        var app_id=$(this).val();
        var app_date=$('#calendar_date_selector').val();
        
        if (app_id!='') {
            $.ajax({
                type: 'GET',
                url: base_url()+'appointments/get_timings/'+app_id+'?date='+app_date, 
                beforeSend: function() {
                    $('#timing_box').html('<div class="col-md-12 timing_loader">Checking times...<i class="bx bx-loader bx-spin"></i></div>');
                },
                success: function(response) {
                    $('#timing_box').html(response); 
                }
                
            });
        }else{
            $('#timing_box').html('<div class="col-md-12 text-aitsun-red text-start">Choose appointment for timings</div>');
        }
        
    });

    $(document).on('click', '#add_resources', function() {
        var form_data = new FormData($('#add_resources_form')[0]);

        $("#add_resources_form").validate({
            // Specify validation rules
            rules: {
                appointment_resource: "required",
                capacity: "required",
            },
            // Specify validation error messages
            messages: {
                appointment_resource: "Please enter appointment resource!",
                capacity: "Please enter capacity!",
            }
        });

        var valid = $('#add_resources_form').valid();

        if (valid) {
            $('#add_resources').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: $('#add_resources_form').prop('action'),
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#add_resources').html('Saving...<i class="bx bx-loader bx-spin"></i>');
                },
                success: function(response) {
                    $('#add_resources').html('Save');
                    $('#add_resources_form')[0].reset();
                    show_success_msg('success', 'Added successfully!', 'Saved!');

                    $('#add_resources').prop('disabled', false);
                },
                
                
            });
        }
    });


    $(document).on('blur','.resource_update',function(){
    
        var resource_id=$(this).data('resource_id');
        var r_element_val=$(this).val();
        var r_element=$(this).data('r_element');
        
        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
        var csrfHash = $('#csrf_token').val(); // CSRF hash
       
        
          $.ajax({
              type: 'POST',
              url: base_url()+'appointments/update_resources/'+resource_id,
              data: {

                  r_element_val:r_element_val,
                  r_element:r_element,
                  [csrfName]: csrfHash
              },
              beforeSend: function() {
              },
              success: function(response) {
                  if ($.trim(response)==1) {

                    $('.add_cls-'+r_element+'-'+resource_id).addClass('is-valid'); 
                            setTimeout(function(){
                                $('.add_cls-'+r_element+'-'+resource_id).removeClass('is-valid');
                            },2000)

                      // round_success_noti('Saved');
                  }else{
                     $('.add_cls-'+r_element+'-'+resource_id).addClass('is-invalid'); 
                            setTimeout(function(){
                                $('.add_cls-'+r_element+'-'+resource_id).removeClass('is-invalid');
                            },2000)
                  }
              }
          });
            
    });



    $(document).on('click','#deleteresourcesCheckAll',function () {
        var thisbox=$(this);
        if ($(thisbox).hasClass('select')) {
            $(".checkBoxresourcesAll").prop('checked', true);
            $(thisbox).removeClass('select');
        }else{
            $(".checkBoxresourcesAll").prop('checked', false);
             $(thisbox).addClass('select');
        }

        var checkedNum = $('input[name="delete_all_resources[]"]:checked').length;
        if (checkedNum>=1) {
            $('#deletereallbtn').removeClass('d-none');
        }else{
            $('#deletereallbtn').addClass('d-none');
        }
        
    });



    $(document).on('click','.checkBoxresourcesAll',function(e){ 
        var checkedNum = $('input[name="delete_all_resources[]"]:checked').length;
        if (checkedNum>=1) {
            $('#deletereallbtn').removeClass('d-none');
        }else{
            $('#deletereallbtn').addClass('d-none');
        }
    });

    $(document).on('click','#deletereallbtn',function(){

      
        var val = []; 
        $('input[name="delete_all_resources[]"]:checked').each(function(i){
          val[i] = $(this).val();

        }); 
        
        Swal.fire({
            title: "Are you sure?",
            text: "You cant retrive this after delete",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete!",
            closeOnConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = base_url()+"/appointments/delete_resource/"+val; 
            }
        });
       
       
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

    function base_url(){
        var baseurl=$('#base_url').val();
        return baseurl;
    }
});
