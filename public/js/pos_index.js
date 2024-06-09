$(document).ready(function(){
    

	  var no=1;
    $(document).on("click",".add-more-table",function(){  

     no++;

      var html = `<tr class="after-add-more-table-tr">
          <td>
            <input type="text" name="table_name[]" value="Table ${no}" class="form-control position-relative" id="table_name"> 
          </td>
          <td>
            <input type="number" name="seats[]" min="1" value="4" class="form-control" id="seats">
          </td>
          <td style="width:135px;">
                 <select name="shape[]" class="form-select position-relative" id="shape">
                    <option value="0">Square</option>
                    <option value="1">Circle</option> 
                </select> 
          </td>
          <td class="change text-center" style="width:25px;"><a class="btn btn-danger btn-sm no_load  remove-table text-white"><b>-</b></a></td>
        </tr>`; 
      
      $(".after-add-more-table").append(html);

    });

    $(document).on("click",".remove-table",function(){ 
      $(this).parents(".after-add-more-table-tr").remove();
    });


$(document).on('click','#save_floor',function(){
        var form_data = new FormData($('#add_floor_form')[0]);

        var floor_name=$.trim($('#floor_name').val());
        var register_id=$.trim($('#register_id').val());
  
        var approve=true; 

        if (floor_name=='') {
            show_failed_msg('error','','Floor name is required!');
            approve=false;

        }else if (register_id=='') {
            show_failed_msg('error','','Please select register!')
            approve=false;
        } 

         $('.after-add-more-table-tr').each(function () {
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
                  url: $('#add_floor_form').prop('action'),
                  data: form_data,
                  processData: false,
                  contentType: false,
                  beforeSend: function() {
                      $('#save_floor').html('<div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span></div>');
                  },
                  success: function(result) {
                    $('#save_floor').html('Save');
                    if ($.trim(result)==1) {
                        $('#add_floor_form')[0].reset();
                        show_success_msg('success', 'Added successfully!', 'Saved!');
                        if ($('#floor_id').length === 0) { 
                            $("#register_id").val('').trigger('change');
                        }
                        
                    }

                  }
              });
            }
           

    });

    var current_url=location.href;
    
    $(document).on('click','.delete_appointment',function(){
      var deleteurl=$(this).data('deleteurl');
      var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
      var csrfHash = $('#csrf_token').val(); // CSRF hash
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          allowOutsideClick: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {

       $.ajax({
            type: 'POST',
            url: deleteurl,
            data:{
                [csrfName]: csrfHash
            },
             beforeSend: function() {
                // setting a timeout
                // $(techerbt).html('Saving  <i class="anticon anticon-loading d-inline-block"></i> ');
                
            },
            success: function() {
                
                Swal.fire(
                          'Deleted!',
                          'Appointment has been deleted!',
                          'success'
                        ).then(function() {
                            window.location.href = current_url;
                        });


                
               
             
                }
            });
        }
        });

    });


	$(document).on('click','.open_session',function(){
        var reg_id=$(this).data('reg_id');
		var opening_cash=$('#opening_cash'+reg_id).val();
		if (opening_cash!='' || opening_cash>=0) {
			$.ajax({
	            type: 'POST',
	            url: base_url()+'pos/open_session',
	            data:$('#open_session_form'+reg_id).serialize(),
	            beforeSend: function() {
	            },
	            success: function(ses_response) {
	              if ($.trim(ses_response)==1) {
	              	show_success_msg('success','Starting session...');
	              	setTimeout(function(){
	              		location.href=base_url()+'pos/create/'+reg_id;
	              	},3000);
	              } 
	            }
	        });
		}else{
			show_failed_msg('error','Opening cash must not be less than 0')
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

    function round_of_value(){
        var round_of_value=$('#round_of_value').val();
        return round_of_value;
    }
});