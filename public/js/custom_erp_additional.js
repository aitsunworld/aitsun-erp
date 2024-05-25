$(document).ready(function(){
    $(document).on('click','.branch_click_quick_change',function(){
        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
        var csrfHash = $('#csrf_token').val(); // CSRF hash

        $.ajax({
            type: "POST", 
            url: $(this).data('href'), 
            data:{
                [csrfName]: csrfHash
            },
            beforeSend:function(){  
                // $('#expense_invoice_form'+vehicleid).html('<span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span> Loading...');  
            },
            success:function(response) {   
                href_loader();              
                location.reload();
            },
            error:function(response){
                show_success_msg('error','Failed!, Try again.');
                // alert(JSON.stringify(response));
            }
        });

    });

    function href_loader(){
        $('body').append('<div id="print_loader" class="d-flex"><div class="print_box m-auto d-flex justify-content-center"><div class="d-flex my-auto"><div class="spin_me sec_spin"><span class="loader-4"> </span></div></div></div> </div>');
    }

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
});