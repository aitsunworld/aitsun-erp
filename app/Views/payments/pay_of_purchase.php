 <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <!-- Page-Title -->
                    <div class="page-title-box">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="page-title mb-1"><?= lang(get_setting(company($user['id']),'language'),'Add payment'); ?> - <?= prefixof(company($user['id']),$invoice_id).serial(company($user['id']),$invoice_id); ?></h4>
                                 
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                       <a class="btn btn-secondary my-auto btn-rounded" href="javascript:history.back()"><?= lang(get_setting(company($user['id']),'language'),'BACK'); ?></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end page title end breadcrumb -->

                    <div class="page-content-wrapper">
                        <div class="container-fluid">
                          
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                     
                                     <div class="card-body">
                                            <div class="row">
                                             
                                            <div class="col-md-12 d-flex justify-content-between px-4">
                                              <div class="bg-body p-2 border_5">
                                                <h6 class="text-info m-0"><?= lang(get_setting(company($user['id']),'language'),'Tot. amt'); ?>: <?= aitsun_round($invoice_data->total,round_after()); ?></h6>
                                              </div>
                                              <div class="bg-body p-2 border_5">
                                                <h6 class="text-success m-0"><?= lang(get_setting(company($user['id']),'language'),'Paid amt'); ?>: <?= aitsun_round($invoice_data->paid_amount,round_after()); ?></h6>
                                              </div>
                                              <div class="bg-body p-2 border_5">
                                                <h6 class="text-danger m-0"><?= lang(get_setting(company($user['id']),'language'),'Due amt'); ?>: <?= aitsun_round($invoice_data->total-$invoice_data->paid_amount,round_after()); ?></h6>
                                              </div>
                                            </div>

                                              <div class="col-md-12">
                                                  
                                                  <form id="policy_form">
                                                      <div class="modal-body">

                                                         
                                                          <div class=" row" >
                                                                 <input type="hidden" name="customer" value="<?= $invoice_data->customer; ?>">
                                                                 <input type="hidden" name="invoice" value="<?= $invoice_id; ?>">
                                                                 <input type="hidden" name="total" value="<?= $invoice_data->total; ?>">


                                                                 

                                                                  <div class="form-group col-md-12">
                                                                    <label class=""><?= lang(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                                                                      <select class="form-control " name="payment_type" id="payment_type" required>
                                                                          <option value=""><?= lang(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>
                                                                          <option value="cash"><?= lang(get_setting(company($user['id']),'language'),'Cash'); ?></option>
                                                                          <option value="cheque"><?= lang(get_setting(company($user['id']),'language'),'Cheque'); ?></option>
                                                                          <option value="bank_transfer"><?= lang(get_setting(company($user['id']),'language'),'Bank Transfer'); ?></option>
                                                                          <option value="credit"><?= lang(get_setting(company($user['id']),'language'),'Credit'); ?></option>
                                                                      </select>
                                                                  </div><!-- form-group -->



                                                                  <div id="cash_options" class="d-none col-md-6">
                                                                      <div class="form-group">
                                                                          <label class=""><?= lang(get_setting(company($user['id']),'language'),'Cash Amount'); ?></label>
                                                                          <input type="number" min="0" class="form-control " name="cash_amount" value="0.000">
                                                                      </div><!-- form-group -->
                                                                  </div>


                                                                  <div id="cheque_options" class="d-none col-md-12">
                                                                      <div id="chk_option_container">
                                                                          <div class="row">
                                                                              <div class="col">
                                                                                  <div class="form-group">
                                                                                      <label class=""><?= lang(get_setting(company($user['id']),'language'),'Chq. Amt'); ?></label>
                                                                                      <input type="number" min="0" class="form-control " name="cheque_amount[]" value="0.000">
                                                                                  </div>
                                                                              </div>
                                                                              <div class="col">
                                                                                  <div class="form-group">
                                                                                      <label class=""><?= lang(get_setting(company($user['id']),'language'),'Chq. No'); ?></label>
                                                                                      <input type="text" class="form-control " name="cheque_no[]">
                                                                                  </div>
                                                                              </div>
                                                                              <div class="col">
                                                                                  <div class="form-group">
                                                                                      <label class=""><?= lang(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                                                                      <input type="date" class="form-control " name="cheque_date[]">
                                                                                  </div>

                                                                              </div>

                                                                              <a name="remove" id="add" class="btn btn-success btn_add dynamic_field_containerclose">+</a>

                                                                          </div>
                                                                      </div>
                                                                     
                                                                  </div>


                                                                  <div id="bank_transfer_options" class="d-none col-md-6">
                                                                      <label><?= lang(get_setting(company($user['id']),'language'),'Reference Id'); ?></label>
                                                                      <div class="form-group">
                                                                          <input type="text" class="form-control " name="reference_id">
                                                                      </div><!-- form-group -->
                                                                      <label><?= lang(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                                                      <div class="form-group">
                                                                          <input type="number" min="0" class="form-control " name="bt_amount" value="0.000">
                                                                      </div><!-- form-group -->
                                                                  </div>
                                                     


                                                          <div class="col-md-12">
                                                              <div class="col-md-12 p-0">
                                                                 <div class="form-group ">
                                                                    <label class=""><?= lang(get_setting(company($user['id']),'language'),'Notes'); ?></label>
                                                                    <textarea class="form-control" name="payment_note" id="input-2"></textarea>
                                                                  </div>
                                                              </div>

                                                              <div class="col-md-12 p-0">
                                                                 <div class="form-group ">
                                                                    <button type="button" id="save_payment" class="btn btn-primary"><?= lang(get_setting(company($user['id']),'language'),'Save Payment'); ?></button>
                                                                  </div>

                                                                  <div id="res"></div>
                                                                  
                                                                  <a onclick="createPDF('pdfthis','<?= vendor_name($invoice_data->customer); ?><?= $invoice_id ?>-invoice')"  class="btn btn-light text-white printbtn d-none" >
                                                                      <i class="fa fa-print"></i> 
                                                                      <span><?= lang(get_setting(company($user['id']),'language'),'Print Receipt'); ?></span>
                                                                  </a>
                                                              </div>
                                                              
                                                          </div>

                                                          

                                                        </div>
                                                        <br>
                                                      </div>
                                                    </form>

                                              </div>

                                                <div class="col-md-12">

                                                  <div id="pdfthis">
               
                                                   </div>
                                                  


                                                </div>

                                              
                                            </div>
                                        </div>
                                  
                                        

                                    </div>
                                  </div><!-- end col -->

                            </div><!-- end row --> 
                        </div><!-- end container-fluid --> 

                    </div><!-- end page-content-wrapper -->
                         
                    
                </div>
                <!-- End Page-content -->

                
              
            </div>
            <!-- end main content-->





<script src="<?= base_url('public'); ?>/js/cjs/jquery.min.js"></script>



<script type="text/javascript">
  $(document).ready(function(){  
      $('#save_payment').click(function(){ 

                  var payment_type =$('#payment_type').val(); 

                  if (payment_type=='') {
                      $('#res').fadeIn().html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;<?= lang(get_setting(company($user['id']),'language'),'Please select payment type'); ?></div>');
                      $('#save_payment').html('Save');
                      setTimeout(function(){  
                         // $('#res').fadeOut("slow");  
                    }, 5000); 
                  }else{
                      $.ajax({  
                           url:"<?= base_url('purchases/update_pay'); ?>",  
                           method:"POST",  
                           data:$('#policy_form').serialize(),  
                           beforeSend:function(){  
                                $('#save_payment').html('<i class="fa fa-spinner"></i> <?= lang(get_setting(company($user['id']),'language'),'Saving'); ?>..');  
                           },  
                           success:function(data){   
                                $('#pdfthis').fadeIn().html(data);
                                $('#policy_form')[0].reset();
                                $('#save_payment').html('Save');
                                $('#res').fadeIn().html('<div class="alert alert-success"><i class="fa fa-check"></i>&nbsp;<?= lang(get_setting(company($user['id']),'language'),'Payment saved'); ?></div>');
                                $('.printbtn').removeClass('d-none');
                           }  
                      }); 
                  }
                        
            });

          $(document).on('click', '#add', function(){  
           i++;  
           var appe='<div class="col"><div class="form-group"><input type="number" min="0" class="form-control " name="cheque_amount[]" value="0.000"></div></div><div class="col"><div class="form-group"><input type="text" class="form-control " name="cheque_no[]"></div></div><div class="col"><div class="form-group"><input type="date" class="form-control " name="cheque_date[]"></div></div><a name="remove" id="'+i+'" class="btn btn-danger btn_remove dynamic_field_containerclose">-</a></div></div></div>';
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

    });
</script>