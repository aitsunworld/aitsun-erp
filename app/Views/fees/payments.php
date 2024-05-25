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

                 
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= langg(get_setting(company($user['id']),'language'),'Add payment'); ?> - <?= inventory_prefix(company($user['id']),$invoice_id['invoice_type']); ?><?= $invoice_id['serial_no']; ?></b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#payments_table" data-filename="Invoice receipts"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#payments_table" data-filename="Invoice receipts"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#payments_table" data-filename="Invoice receipts"> 
            <span class="my-auto">PDF</span>
        </a>
        
    </div>
 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
  

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row pb-5"> 
    
        <div id="form_of_pay" class="w-100">
            
        </div> 

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 



<script type="text/javascript">
  $(document).ready(function(){  
        

        $.ajax({
            type: 'GET',
            url: "<?= base_url('fees_and_payments/get_payment_form'); ?>/<?= $invoice_id['id']; ?>",
            success: function(feeform) { 
                $('#form_of_pay').html(feeform);
            }

        });

          $(document).on('click', '#add', function(){  
           i++;  
           var appe='<div class="col-md-3"><div class="form-group my-1 mt-1"><input type="number" min="0" class="form-control cheque_amount" name="cheque_amount[]" value="0.000" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?>"></div></div><div class="col-md-3"><div class="form-group my-1"><input type="text" class="form-control " name="cheque_no[]" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?>"></div></div><div class="col-md-3"><div class="form-group my-1"><input type="date" class="form-control " name="cheque_date[]" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Date'); ?>"></div></div><div class="col-md-3"><a name="remove" id="'+i+'" class="my-1 d-block btn btn-danger btn_remove dynamic_field_containerclose">-</a></div>';
           $('#chk_option_container').append('<div id="row'+i+'" class="row">'+appe+'</div>');});

            $(document).on('click', '.btn_remove', function(){  
                 var button_id = $(this).attr("id");   
                 $('#row'+button_id+'').remove();  
            });  



      $("#payment_type").change(function(){
        var catname = $(this).val(); 
        if (catname=='cash') {
          d_n_all_form();
          $('#cash_options').removeClass("d-none");
        } 
        if (catname=='cheque') {
          d_n_all_form();
          $('#cheque_options').removeClass("d-none");
        } 
        if (catname=='bank_transfer') {
          d_n_all_form();
          $('#bank_transfer_options').removeClass("d-none");
        } 
        if (catname=='credit') {
          d_n_all_form();
        }   
      });   
      function d_n_all_form(){
        $('#cash_options').addClass("d-none");
        $('#cheque_options').addClass("d-none");
        $('#bank_transfer_options').addClass("d-none");
      }

      var i=1;  

      $('#add').click(function(){  
           i++;  
           var appe='<tr id="row'+i+'"><td><div class="form-group"><select class="form-control " id="input-2"><option>Bharath</option><option>Rajesh</option></select></div></td><td><div class="form-group"><input type="number" class="form-control " id="input-2"></div></td><td><div class="form-group "><input type="text" class="form-control " id="input-2"></div></td><td><div class="form-group "><input type="number" class="form-control " id="input-2"></div></td><td>0,00</td><td><a id="'+i+'" class="text-dark btn_remove">X</a></td></tr>';

           $('#dynamic_field').append(appe);});

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


       $(document).on('change', '.select_c_status', function(){
       var statusname = $(this).val();                  
       var getid = $(this).attr("data-id");    
       var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
       var csrfHash = $('#csrf_token').val(); // CSRF hash
        $.ajax({
            type:'POST',
            url:'<?php echo base_url('payments/update_status'); ?>',
            data:{statusname:statusname,getid
            :getid, [csrfName]: csrfHash},
            success:function(result){
                if (statusname=='1') {
                    $('#'+getid+'rec_status').html('<span class="border px-1 rounded cursor-pointer rec_status"><i class="bx bxs-circle me-1 text-success"></i><?= langg(get_setting(company($user['id']),'language'),'Received'); ?></span>');
                }else{
                    $('#'+getid+'rec_status').html('<span class="border px-1 rounded cursor-pointer rec_status"><i class="bx bxs-circle me-1 text-danger"></i><?= langg(get_setting(company($user['id']),'language'),'Not Received'); ?></span>');
                }
                
            }
        });
    });

    });
</script>


