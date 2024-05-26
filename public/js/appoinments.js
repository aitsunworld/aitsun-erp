$(document).ready(function() {

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
