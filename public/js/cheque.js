$(document).ready(function() { 

    $(document).on('click','.confirm_cheque',function(){ 
        var this_btn=$(this);
        var this_btn_html=$(this).html();
        var cheque_id=$(this).data('id');
        var cheque_value=$(this).data('value');
        $(this_btn).prop('disabled', true);
        $.ajax({
            type: 'GET',
            url: base_url()+'cheque-management/confirm_cheque/'+cheque_id+'/'+cheque_value,
            success: function(del_res) {  
              if (del_res==1) { 
                    show_success_msg('success','Updated!'); 
                  
                  setTimeout(function(){
                    location.reload();
                  },500);
              }else{
                  show_failed_msg('error','Failed!, Try again'); 
              } 
            }
        });
    });

	$(document).on('click', '#add_cheque_department', function() {
        var form_data = new FormData($('#add_cheque_department_form')[0]);

        var valid = true;
        var department_name=$.trim($('#department_name').val());
        var bank=$.trim($('#bank').val());
        var responsible_person=$.trim($('#responsible_person').val());

        if (department_name=='') {
            valid = false;
            show_failed_msg('error', '', 'Please enter department name!');
        }else if(bank=='' || bank==''){
            valid = false;
            show_failed_msg('error', '', 'Please select bank!');
        }else if(responsible_person=='' || responsible_person==0){
            valid = false;
            show_failed_msg('error', '', 'Please select responsible person!');
        }  

     

        

        if (valid) {
            $('#add_cheque_department').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: $('#add_cheque_department_form').prop('action'),
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#add_cheque_department').html('Saving...<i class="bx bx-loader bx-spin"></i>');
                },
                success: function(result) {
                    if ($.trim(result)=='1') {
                        $('#add_cheque_department').html('Save');
                        $('#add_cheque_department_form')[0].reset();
                        show_success_msg('success', 'Added successfully!', 'Saved!');
                        $('#add_cheque_department').prop('disabled', false);
                    }else{
                        $('#add_cheque_department').prop('disabled', false);
                        $('#add_cheque_department').html('Save');
                        show_failed_msg('error', '', 'Failed!');
                    }
                    
                },
                
                
            });
        }
    });


    $(document).on('click','.delete_department',function(){
		var urll=$(this).data('deleteurl');
		var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
    	var csrfHash = $('#csrf_token').val(); // CSRF hash
		
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		  	$.ajax({
				type: 'POST', 
				url:urll,
                data: {
                    [csrfName]: csrfHash 
                },
				success:function(result){
				Swal.fire(
			      'Deleted!',
			      '',
			      'success'
			    ).then(() => {
                        location.reload(); // Reload the page
                    });
										
				}
			});
		  }
		})		
	});


	$(document).on('click','.edit_department',function(){
            
            var chqid=$(this).data('id');
            var techerbt=$(this);
            var form_data = new FormData($('#edit_department_form'+chqid)[0]);
           
            var valid = true;
            var department_name=$.trim($('#department_name'+chqid).val());
            var bank=$.trim($('#bank'+chqid).val());
            var responsible_person=$.trim($('#responsible_person'+chqid).val());
          
            if (department_name=='') {
                valid = false;
                show_failed_msg('error', '', 'Please enter department name!');
            }else if(bank=='' || bank==''){
                valid = false;
                show_failed_msg('error', '', 'Please select bank!');
            }else if(responsible_person=='' || responsible_person==0){
                valid = false;
                show_failed_msg('error', '', 'Please select responsible person!');
            }  

           if (valid == true) {
               $.ajax({
                    type: 'POST',
                    url: $('#edit_department_form'+chqid).prop('action'),
                    data: form_data,
                    processData: false,
                    contentType: false,
                     beforeSend: function() {
                        // setting a timeout
                        $(techerbt).html('Saving...<i class="bx bx-loader bx-spin"></i>');
                        
                    },
                    success: function(result) {
                        if ($.trim(result)==1) {
                           $(techerbt).html('Save');
                            show_success_msg('success','','Saved!');
                          
                        }else{
                            $(techerbt).html('Save');
                            show_failed_msg('error','','Failed!');
                        }
                          

                        
                     
                    }
                });
           }
           
            
        });


    $(document).on('click', '#add_cheque', function() {
        var form_data = new FormData($('#add_cheque_cheque_form')[0]);

        $("#add_cheque_cheque_form").validate({
            // Specify validation rules
            rules: {
                cheque_no: "required",
                cheque_date: "required",
                cheque_department: "required",
                cheque_title: "required",
                amount: "required",
                remarks: "required",
            },
            // Specify validation error messages
            messages: {
                cheque_no: "Please enter cheque number!",
                cheque_date: "Please select cheque date!",
                cheque_department: "Please select cheque department!",
                cheque_title: "Please enter cheque title!",
                amount: "Please enter cheque amount!",
                remarks: "Please select remark",
            }
        });

        var valid = $('#add_cheque_cheque_form').valid();

        if (valid) {
            $('#add_cheque').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: $('#add_cheque_cheque_form').prop('action'),
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#add_cheque').html('Saving...<i class="bx bx-loader bx-spin"></i>');
                },
                success: function(result) {
                    if ($.trim(result)=='1') {
                        $('#add_cheque').html('Save');
                        $('#add_cheque_cheque_form')[0].reset();
                        show_success_msg('success', 'Added successfully!', 'Saved!');
                        $('#add_cheque').prop('disabled', false);
                    }else{
                        $('#add_cheque').prop('disabled', false);
                        $('#add_cheque').html('Save');
                        show_failed_msg('error', '', 'Failed!');
                    }
                    
                },
                
                
            });
        }
    });

    $(document).on('click','.update_cheque',function(){
            
        var cqid=$(this).data('id');
        var techerbt=$(this);
        var form_data = new FormData($('#cheque_edit_form'+cqid)[0]);
        $("#cheque_edit_form"+cqid).validate({
        // Specify validation rules
        rules: {
            cheque_no: "required",
            cheque_date: "required",
            cheque_department: "required",
            cheque_title: "required",
            amount: "required",
            remarks: "required",
        },
        // Specify validation error messages
        messages: {
            cheque_no: "Please enter cheque number!",
            cheque_date: "Please select cheque date!",
            cheque_department: "Please select cheque department!",
            cheque_title: "Please enter cheque title!",
            amount: "Please enter cheque amount!",
            remarks: "Please select remark",
        }
      });  
       var valid = $('#cheque_edit_form'+cqid).valid();  

       if (valid == true) {
           $.ajax({
                type: 'POST',
                url: $('#cheque_edit_form'+cqid).prop('action'),
                data: form_data,
                processData: false,
                contentType: false,
                 beforeSend: function() {
                    // setting a timeout
                    $(techerbt).html('Saving...<i class="bx bx-loader bx-spin"></i>');
                    
                },
                success: function(result) {
                    if ($.trim(result)==1) {
                       $(techerbt).html('Save');
                        show_success_msg('success','','Saved!');
                      
                    }else{
                        $(techerbt).html('Save');
                        show_failed_msg('error','','Failed!');
                    }
                      
                }
            });
       }
    });

    $(document).on('click','.delete_cheque',function(){
        var urll=$(this).data('deleteurl');
        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
        var csrfHash = $('#csrf_token').val(); // CSRF hash
        
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type: 'POST', 
                url:urll,
                data: {
                    [csrfName]: csrfHash 
                },
                success:function(result){
                Swal.fire(
                  'Deleted!',
                  '',
                  'success'
                ).then(() => {
                        location.reload(); // Reload the page
                    });
                                        
                }
            });
          }
        })      
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

