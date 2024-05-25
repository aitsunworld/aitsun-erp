$(document).ready(function(){
    

	
	$(document).on('click','.open_session',function(){
		var opening_cash=$('#opening_cash').val();
		if (opening_cash!='' && opening_cash>=0) {
			$.ajax({
	            type: 'POST',
	            url: base_url()+'pos/open_session',
	            data:$('#open_session_form').serialize(),
	            beforeSend: function() {
	            },
	            success: function(ses_response) {
	              if ($.trim(ses_response)==1) {
	              	show_success_msg('success','Starting session...');
	              	setTimeout(function(){
	              		location.href=base_url()+'pos/create';
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