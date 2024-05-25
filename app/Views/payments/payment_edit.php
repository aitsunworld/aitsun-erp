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
                                    <h4 class="page-title mb-1"><?= lang(get_setting(company($user['id']),'language'),'Edit Payment'); ?></h4>
                                 
                                </div>
                                <div class="col-md-4">
                                    <div class="float-right d-none d-md-block">
                                        <!-- <div class="dropdown">
                                            
                                         <a href="#" class="btn btn-outline-danger">
                                          <i class="fa fa-trash"></i></a>

                                        </div> -->
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
                                                 
                                                  <div class="col-md-12 row" >
                                                       
                                                        <div class="form-group col-md-4">
                                                          <label for="input-5" class=""><?= lang(get_setting(company($user['id']),'language'),'Select Customer'); ?></label>
                                                          <select class="form-control" id="input-5">
                                                            <option><?= lang(get_setting(company($user['id']),'language'),'Select'); ?></option>
                                                            <option><?= lang(get_setting(company($user['id']),'language'),'Bharathraj'); ?></option>
                                                            <option><?= lang(get_setting(company($user['id']),'language'),'Rajesh'); ?></option>
                                                          </select>
                                                         </div>

                                                         <div class="form-group col-md-4">
                                                          <label for="input-1" class=""><?= lang(get_setting(company($user['id']),'language'),'Payment Date'); ?></label>
                                                          <input type="date" class="form-control" id="input-1">
                                                         </div>

                                                          

                                                         <div class="form-group col-md-4">
                                                          <label for="input-3" class=""><?= lang(get_setting(company($user['id']),'language'),'Payment No'); ?></label>
                                                          <input type="text" step="any" class="form-control" id="input-3">
                                                         </div>

                                                         <div class="form-group col-md-4">
                                                          <label for="input-5" class=""><?= lang(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                                                          <select class="form-control" id="input-5">
                                                            <option><?= lang(get_setting(company($user['id']),'language'),'Select'); ?></option>
                                                            <option><?= lang(get_setting(company($user['id']),'language'),'Card'); ?></option>
                                                            <option><?= lang(get_setting(company($user['id']),'language'),'Paypal'); ?></option>
                                                          </select>
                                                         </div>

                                                         <div class="form-group col-md-4">
                                                          <label for="input-2" class=""><?= lang(get_setting(company($user['id']),'language'),'Invoice'); ?></label>
                                                          <input type="text" class="form-control" id="input-2">
                                                         </div>

                                                         <div class="form-group col-md-4">
                                                          <label for="input-2" class=""><?= lang(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                                          <input type="number" step="any" class="form-control" id="input-2">
                                                         </div>

                                                  </div>




                                                  <div class="col-md-12 p-4 row">
                                                      <div class="col-md-12 p-0">
                                                         <div class="form-group ">
                                                            <label class=""><?= lang(get_setting(company($user['id']),'language'),'Notes'); ?></label>
                                                            <textarea class="form-control" id="input-2"></textarea>
                                                          </div>
                                                           <div class="form-group ">
                                                              <label class=""><?= lang(get_setting(company($user['id']),'language'),'Private Notes'); ?></label>
                                                            <textarea class="form-control" id="input-2"></textarea>
                                                          </div>
                                                          <div class="form-group ">
                                                              <button type="button" class="btn btn-light"><?= lang(get_setting(company($user['id']),'language'),'Save Payment'); ?></button>
                                                          </div>
                                                          
                                                      </div>
                                                 
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






<!-- /////////////////////////////Scripts /////////////////////////////// -->

              <?php for ($i=1; $i < 15; $i++) { ?>

                <input type="hidden" class="tax_prc" id="tax_prc<?= $i; ?>" value="0">

                <script type="text/javascript">
   $(document).ready(function(){
    calc_total_amount();
    var id_post=<?php echo $i; ?>;
     $(document).on('click change input', '#selcus'+id_post, function(){  
           var pid=this.value;
            calc_total_amount();
           $('#sele_val'+id_post).val(pid);
          
           $.ajax({
              url:"<?= base_url('invoices/get_price?prod='); ?>"+pid,
              type:"POST",
              
              success:function(response) {

                if ($.trim(response)!='') {
                  var qy=$('#qty'+id_post).val();
                  var replace_amt=$.trim(response)*qy;
                  $('#price'+id_post).val($.trim(response));
                  $('#amount'+id_post).val(replace_amt.toFixed(2));

                  get_stock(id_post,pid);
                   
                  calc_total_amount();

                }else{
                  $('#price'+id_post).val('0.00');
                  $('#amount'+id_post).val('0.00');
                }
               
             },
             error:function(){
              alert("error");
             }

            });
      });

     function get_stock(id_post,pid){
       $.ajax({
          url:"<?= base_url('invoices/get_stock?prod='); ?>"+pid,
          success:function(response) {

              $('#qty'+id_post).attr({
                 "max" : $.trim(response)
              });

            }
        });
     }


       $(document).on('click change input', '#qty'+id_post, function(){
        var pid=$('#sele_val'+id_post).val();

           $.ajax({
              url:"<?= base_url('invoices/get_price?prod='); ?>"+pid,
              type:"POST",
              success:function(response) {
                if ($.trim(response)!='') {
                  var qy=$('#qty'+id_post).val();
                  var replace_amt=$.trim(response)*qy;
                  $('#amount'+id_post).val(replace_amt.toFixed(2));
                    calc_total_amount();
                }
             },
             error:function(){
              alert("error");
             }
            });
      });

        $(document).on('click change input', '#tax_val'+id_post, function(){
        var taxid=$('#tax_val'+id_post).val();
              $.ajax({
                  url:"<?= base_url('invoices/tax_val?tax='); ?>"+taxid,
                  type:"POST",
                  success:function(response) {

                    $('#tax_prc'+id_post).val($.trim(response));
                    calc_total_amount();
                    
                 },
                 error:function(){
                  alert("error");
                 }
              });
        
      });




   });
</script>
              <?php } ?>


<script type="text/javascript">

  // $(document).on('click change input', '#tax_val', function(){
  //   var taxid=$('#tax_val').val();
  //         $.ajax({
  //             url:""+taxid,
  //             type:"POST",
  //             success:function(response) {
  //               $('#tax_prc').val($.trim(response));
  //               calc_total_amount();
                
  //            },
  //            error:function(){
  //             alert("error");
  //            }
  //         });
    
  // });


  $(document).on('click change input', '#disc_val', function(){
         calc_total_amount();
       });
  function calc_total_amount(){

        var sum = 0;        
        $(".total").each(function() {          
          if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
          }    
        });

        $("#subtotal").val(sum.toFixed(2));

      var pos_sub_total=parseFloat($('#subtotal').val());

      var sumtax = 0;        
        $(".tax_prc").each(function() {          
          if (!isNaN(this.value) && this.value.length != 0) {
            sumtax += parseFloat(this.value);
          }    
        });

      var txv=sumtax;


      var tv=parseFloat(txv);
      var pos_tax=pos_sub_total/100*tv;
      var sss= pos_sub_total + pos_tax;

      if ($('#disc_val').val()=='') {
        var pos_discount=0;
      }else{
        var pos_discount=parseFloat($('#disc_val').val());
      }
      var gtotal= sss - pos_discount;
      $('#grand_total').val(gtotal.toFixed(2));
  }   
</script>

<script type="text/javascript">
  $(document).ready(function(){ 

      var i=1;  

      $('#add').click(function(){  
           i++;  
           var appe='<tr id="row'+i+'"><td width="50%"><div class="form-group"><select class="form-control " id="selcus'+i+'" name="product_name[]" required> <option value="">Select</option><?php foreach (products_array(company($user['id'])) as $proaraay) { ?><option value="<?= $proaraay->id; ?>" <?php if (stock($proaraay->id)==0){echo 'disabled';} ?>><?= $proaraay->product_name; ?><?php if (stock($proaraay->id)==0){echo '-No stock';}else{ echo ' In stock-'.stock($proaraay->id); } ?></option><?php } ?></select><input type="hidden" id="sele_val'+i+'"></div></td><td width=""><div class="form-group"><input type="number" class="form-control  qty"  name="quantity[]" id="qty'+i+'" min="1" value="1"></div></td><td width=""><input type="number" step="any" class="mb-3 price readonly_form_control"  name="price[]" value="0.00" id="price'+i+'" readonly></td><td width=""><input type="text" name="amount[]" value="0.00" id="amount'+i+'" class="mb-3 total readonly_form_control" readonly></td><td><div class="form-group"><a id="'+i+'" class=" btn_remove">X</a></div></td></tr>';

           $('#dynamic_field').append(appe);});

      
      $('#add_tax').click(function(){  
           i++;  
           var appe_tax='<div class="mt-2 d-flex" id="taxselect'+i+'"><select class="form-control " id="tax_val'+i+'" name="tax[]"><option value="0">No tax</option><?php foreach (taxarray(company($user['id'])) as $tx_data) { ?><option value="<?= $tx_data->id; ?>"><?= $tx_data->name; ?></option><?php } ?></select><a id="'+i+'" class="my-auto pl-2 tax_btn_remove">X</a></div>';

           $('#tax_cont').append(appe_tax);
         });

         $(document).on('click', '.tax_btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#taxselect'+button_id+'').remove(); 
           calc_total_amount(); 
          });


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           calc_total_amount(); 
      });
    });
</script>








