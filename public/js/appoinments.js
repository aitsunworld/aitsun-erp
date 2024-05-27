$(document).ready(function() { 

    $(document).on('click','.time_box',function(){
        $('#booking_modal').modal('show');
        $.ajax({
            type: 'GET',
            url: base_url()+'appointments/get_booking_form', 
            beforeSend: function() { 
            },
            success: function(response) {
                $('#booking_form').html(response); 
            }
            
        });
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


    var no=0;
    $(document).on("click",".add-more-schedule",function(){  

     no++;

      var html = `<tr class="after-add-more-schedule-tr"><td>
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
                    <input type="time" name="from[]" class="form-control" id="from" value="08:00">
                  </td>
                  <td><input type="time" name="to[]" class="form-control" id="to" value="13:00"></td>
                  <td class="change text-center"><a class="btn btn-danger btn-sm no_load  remove-schedule text-white"><b>-</b></a></td>
                </tr>`; 
      
      $(".after-add-more-schedule").append(html);

    });

    $(document).on("click",".remove-schedule",function(){ 
      $(this).parents(".after-add-more-schedule-tr").remove();
    });


     $(function() {
        $('#availability_on1').click(function() {
            $('.remove_resource').addClass('d-none');
            $('.remove_person').removeClass('d-none');
            $("#resource").val('').trigger('change');
            
           
        });           
        $('#availability_on2').click(function() {
            $('.remove_person').addClass('d-none');
            $('.remove_resource').removeClass('d-none');
            $("#person").val('').trigger('change');
            
        });
    });


     $(document).on('click','#save_appointment',function(){
        var form_data = new FormData($('#add_appointment_form')[0]);

        

        var appointment_title=$.trim($('#appointment_title').val());
        var duration=$.trim($('#duration').val());
        var allow_cancelling_before=$.trim($('#allow_cancelling_before').val());
        var person=$.trim($('#person').val());
        var resource=$.trim($('#resource').val());
        var hours_before=$.trim($('#hours_before').val());
        var days_before=$.trim($('#days_before').val());


        var availability_method='users';

        var approve=true;
 
        if ($("#availability_on2").prop("checked")) {

                availability_method='resources';
        }

        if (availability_method=='users') {

            if (appointment_title=='') {
                show_failed_msg('error','','Appointment title is required!');
                approve=false;

            }else if (duration=='') {
                show_failed_msg('error','','Duration is required!');
                approve=false;
            }else if (allow_cancelling_before=='') {
                show_failed_msg('error','','Allow cancelling is required!')
                approve=false;
            }
            else if (person=='') {
                show_failed_msg('error','','Person is required!')
                approve=false;
            }
            else if (days_before=='') {
                show_failed_msg('error','','Scheduling days is required!')
                approve=false;
            }

            

        }else{

            if (appointment_title=='') {
                show_failed_msg('error','','Appointment title is required!');
                approve=false;

            }else if (duration=='') {
                show_failed_msg('error','','Duration is required!');
                approve=false;
            }else if (allow_cancelling_before=='') {
                show_failed_msg('error','','Allow cancelling is required!')
                approve=false;
            }
            else if (resource=='') {
                show_failed_msg('error','','Resource is required!')
                approve=false;
            }
            else if (days_before=='') {
                show_failed_msg('error','','Scheduling days is required!')
                approve=false;
            }

            
        }


         $('.after-add-more-schedule-tr').each(function () {
            var fromTime = $(this).find('input[name="from[]"]').val();
            var toTime = $(this).find('input[name="to[]"]').val();
            
            // Convert time strings to date objects
            var fromDateTime = new Date('1970-01-01T' + fromTime + ':00Z');
            var toDateTime = new Date('1970-01-01T' + toTime + ':00Z');

            // Calculate the difference in hours
            var timeDifference = (toDateTime - fromDateTime) / (1000 * 60 * 60);

            if (timeDifference < 1) {
                show_failed_msg('error', '', '"To" time must be at least 1 hour greater than the "From" time!');
                approve = false;
                return false; // Exit the loop
            }
        });

 
            if (approve==true) {
                var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
                var csrfHash = $('#csrf_token').val(); // CSRF hash

                $.ajax({
              type: 'POST',
              url: $('#add_appointment_form').prop('action'),
              data: form_data,
              processData: false,
              contentType: false,
              beforeSend: function() {
                  $('#save_appointment').html('<div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span></div>');
              },
              success: function(result) {
                $('#save_appointment').html('Save');
                if ($.trim(result)==1) {
                    $('#add_appointment_form')[0].reset();
                    show_success_msg('success', 'Added successfully!', 'Saved!');
                    $("#resource").val('').trigger('change');
                    $("#person").val('').trigger('change');
                    
                }

              }
          });
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

    function base_url(){
        var baseurl=$('#base_url').val();
        return baseurl;
    }
});
