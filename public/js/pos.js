var categoryBox = document.getElementById("categoryBox");
var isMouseDown = false;
var startX;
var startScrollLeft;

 var input_value = '';
    var click_by=0;

$(document).on('keypress','#product_search_input,#product_code,#searchCustomerInput,.methods_pay_input',function(e){
    if (e.keyCode == 13) {
        event.preventDefault();
    }
});



categoryBox.addEventListener("mousedown", function (e) {
    isMouseDown = true;
    startX = e.pageX;
    startScrollLeft = categoryBox.scrollLeft;
});

document.addEventListener("mouseup", function () {
    isMouseDown = false;
});

document.addEventListener("mousemove", function (e) {
    if (!isMouseDown) return;
    e.preventDefault();
    var dx = e.pageX - startX;
    categoryBox.scrollLeft = startScrollLeft - dx;
});

// Show all items initially
$('.item_container').show();


// var display_value = ''; 
    var new_click=false;
    $(document).on('click','.orderline',function(){
        $('.orderline').removeClass('active');
        $(this).addClass('active'); 
        input_value=''; 
    });

    $(document).on('click','.target_input',function(){
        $('.target_input').removeClass('active');
        $(this).addClass('active');
        new_click=true;
    });
    
   
    
    $(document).on('click','.scan_bar', function(){
        $('.scan_bar').addClass('scan_listen');
         $('#productbarcodesearch').focus();
    });

    $(document).on('click','.pos_key', function(){
        var key = $(this).html();
        // alert(input_value)
        $('.scan_bar').removeClass('scan_listen');

        if (new_click==true) {
            display_value = '';
            input_value = ''; 
        }

        if (key === 'Clear') {
            input_value='';
            display_value=input_value;
        } else if (key === '<i class="bx bx-tag"></i>') {
            if (input_value=='') {
                display_value=''
            }else{
                if (input_value.length>1) {
                    display_value=input_value.slice(0, -1);
                }else{
                    display_value='';
                    input_value='';
                }
            }
            
        } else { 
            display_value=input_value + key;
        }

    
        display(display_value);
        // if(button_value === '<i class="bx bx-tag"></i>'){
            
        //  if (new_value.length == 1) {
        //      new_value = 0;
        //  }else{
        //      new_value = new_value.substring(0, new_value.length-1);
        //  }

        //  display(new_value);

        // } else if(button_value === 'Clear'){
        //  new_value = 0;
        //  display_value = 0;
        //  display(new_value);
        // } else if(button_value === '.'){
        //  new_value += '.';
        // } else if(isNumber(button_value)){
             
        //   if (new_value == 0) new_value = button_value;
        //   else new_value = new_value + button_value; 
        //   display(new_value);
        // }

        
    });

    function isNumber(value){
        return !isNaN(value);
    }


    function display(display_value){
      
        new_click=false;
        var target_input_id = $('.target_input.active').data('target');
        if ($('.target_input.active').length) {
            var target_row_id = $('.orderline.active').data('thisrow');
        
            if (target_input_id=='quantity_input' || target_input_id=='discount_percentbox' || target_input_id=='price_bx') {
                if (display_value<1 || display_value=='') {
                    $('#'+target_input_id+target_row_id).val(0).click(); 
                    $('#'+target_input_id+'_label'+target_row_id).html(0);
                }else{
                    $('#'+target_input_id+target_row_id).val(display_value).click(); 
                    $('#'+target_input_id+'_label'+target_row_id).html(display_value); 
                }
            }else{
                $('#'+target_input_id+target_row_id).val(display_value).click(); 
                $('#'+target_input_id+'_label'+target_row_id).html(display_value);  
            }
            
            input_value=display_value;
            if (target_input_id=='discount_percentbox') {
                if (display_value>0) {
                    $('#'+target_input_id+'_li'+target_row_id).removeClass('d-none');
                }else{
                    $('#'+target_input_id+'_li'+target_row_id).addClass('d-none');
                }
            }
        }else{
            $('#product_code').val(display_value).click();
            input_value=display_value;
        }
            
        

    }


    var pay_display_value = ''; 
    var pay_new_value = 0;
    var pay_new_click=false;
    var pay_click_by=0;

    $(document).on('click','.pay_box',function(){
        $('.pay_box').removeClass('active');
        $(this).addClass('active');
        pay_new_click=true; 
    });
    
    

    $(document).on('click','.pos_pay_key_plus', function(){
        var plus_button_value = $(this).html();
        plus_button_value = plus_button_value.replace('+','');


        var pay_target_input_id = $('.pay_box.active').data('target');  
        var current_val=$('#'+pay_target_input_id).val();

        pay_plus_value = parseFloat(current_val)+parseFloat(plus_button_value);

        $('#'+pay_target_input_id).val(pay_plus_value); 
        pay_new_value=pay_plus_value;

        var total_paid=0;
        $('.pay_box').each(function() {
            // Find the methods_pay_input within the current pay_box
            var inputValue = parseFloat($(this).find('.methods_pay_input').val());
            // alert(inputValue)
            total_paid+=parseFloat(inputValue.toFixed(round_of_value()));
        });

        $('#cash_input').val(total_paid).click();

    });

    $(document).on('click','.pos_pay_key', function(){
        var pay_button_value = $(this).html();

        if (pay_new_click==true) {
            pay_display_value = 0;
            pay_new_value = 0;
            pay_display(pay_new_value);
        }

        if(pay_button_value === '<i class="bx bx-tag"></i>'){
            
            if (pay_new_value.length == 1) {
                pay_new_value = 0;
            }else{
                pay_new_value = pay_new_value.substring(0, pay_new_value.length-1);
            }

            pay_display(pay_new_value);

        } else if(pay_button_value === 'Clear'){
            pay_new_value = 0;
            pay_display_value = 0;
            pay_display(pay_new_value);
        }else if(pay_button_value === '.'){
            pay_new_value += '.';
        } else if(isNumber(pay_button_value)){
             
             if (pay_new_value == 0) pay_new_value = pay_button_value;
             else pay_new_value = pay_new_value + pay_button_value;
             pay_display(pay_new_value); 
        }

        
    });

     

    function pay_display(pay_display_value){
        pay_new_click=false;
        var pay_target_input_id = $('.pay_box.active').data('target'); 
        // alert('#'+target_input_id+target_row_id)
        var pay_display_value = pay_display_value.toString();
        // alert(display_value)
        $('#'+pay_target_input_id).val(pay_display_value.substring(0,10)); 

        var total_paid=0;
        $('.pay_box').each(function() {
            // Find the methods_pay_input within the current pay_box
            var inputValue = parseFloat($(this).find('.methods_pay_input').val());
            // alert(inputValue)
            total_paid+=parseFloat(inputValue.toFixed(round_of_value()));
        });

        $('#cash_input').val(total_paid).click();
    }


// Filter items based on category on click
$('.category_box .cat_selector').click(function(e){ 
    $('.category_box a').removeClass('active');
    $(this).addClass('active');

    e.preventDefault();
    var category = $(this).data('category');
    $('.item_container').hide();
    if(category === 'all') {
        $('.item_container').show();
    } else {
        $('.item_container[data-category="' + category + '"]').show();
    }
    $('#product_search_input').val('');
});

// Reset filter
$('#resetFilter').click(function(){
    $('#product_search_input').val('');
    $('.category_box a').removeClass('active');
    $(this).addClass('active');
    $('.category_box .cat_selector').removeClass('active');
    $('.item_container').show();
});

$('#product_search_input').on('input', function(e){
    
    $('.category_box a').removeClass('active');
    $('.category_box a:first-child').addClass('active');
    var searchText = $(this).val().toLowerCase();
    $('.product_name').each(function(){
        var productName = $(this).text().toLowerCase();
        if(productName.includes(searchText)){
            $(this).closest('.item_container').show();
        } else {
            $(this).closest('.item_container').hide();
        }
    }); 
    
});

$(document).on('input click','#product_code', function(){ 
    var searchValue = $(this).val().trim(); 
    if (searchValue === '') { 
        $('.item_container').show();
    } else { 
        $('.item_container').hide(); 
        $('.product_code_item_' + searchValue).show();
    } 
    $('.target_input').removeClass('active'); 
});

 $('#searchCustomerInput').on('input', function(){ 
    var searchText = $(this).val().toLowerCase();
    $('#cus_table tbody tr').each(function(){
        var rowText = $(this).text().toLowerCase();
        if(rowText.includes(searchText)){
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

 $(document).on('click','.internal_note_tag',function(){
    var this_val=$(this).html();
    $(this).prop('disabled',true);
    var order=$(this).data('order');
    var text_area_val=$.trim($('#internal_note').val());

    if (order==1 && text_area_val=='') {
        text_area_val+=this_val;
    }else{
        if (text_area_val!='') {
            text_area_val+='\n';
        } 
        text_area_val+=this_val;
    }
 
    $('#internal_note').val(text_area_val);

 });



$(document).on('click','.hold',function(){


      var st=$('#subtotal').val();
    var grand_total=$('#grand_total').val();
    var view_method=$('#view_method').val();

   

    if (view_method=='create') {
      var total_cash=$('#cash_input').val();
    }else{
      var total_cash=$('#paid_amt').val();
    }

         

    var party_box=$('#customer').val();
        var due_amount=$('#due_amount').val();



        var credit_limit=$('#party_box').data('credit_limit');
        var closing_balance=$('#party_box').data('closing_balance');



        var inid=$(this).data('inid');
        if ($.trim(party_box)!='' && $.trim(party_box)!=0) {
        if (st!=0) {

    

 
                var status = navigator.onLine;
                if (status) {

                  var allow_submit=true;
                  var due_close=parseFloat(closing_balance)+parseFloat(due_amount);
                  

                  if (credit_limit>0) {
                    if (due_amount>0) {
                      if (credit_limit<due_close) {
                         show_failed_msg('error','Credit limit '+credit_limit+' of this party has been exceeded.'); 
                        
                      }else{
                       sinv(inid);
                      }
                    }else{
                     sinv(inid);
                    }
                  }else{
                   sinv(inid);
                  }
                  
                  
      


                    } else { 
                     show_failed_msg('error','No internet');  
                }
              
            }else{
                show_failed_msg('error','Item is empty!');   
            }
        }else{
            show_failed_msg('error','Please select party!');   
        }

});

$(document).on('click','.payment',function(){


      var st=$('#subtotal').val();
    var grand_total=$('#grand_total').val();
    var view_method=$('#view_method').val();

   

    if (view_method=='create') {
      var total_cash=$('#cash_input').val();
    }else{
      var total_cash=$('#paid_amt').val();
    }

         

    var party_box=$('#customer').val();
        var due_amount=$('#due_amount').val();



        var credit_limit=$('#party_box').data('credit_limit');
        var closing_balance=$('#party_box').data('closing_balance');



        var inid=$(this).data('inid');
        if ($.trim(party_box)!='' && $.trim(party_box)!=0) {
        if (st!=0) {

    

 
                var status = navigator.onLine;
                if (status) {

                  var allow_submit=true;
                  var due_close=parseFloat(closing_balance)+parseFloat(due_amount);
                  

                  if (credit_limit>0) {
                    if (due_amount>0) {
                      if (credit_limit<due_close) {
                         show_failed_msg('error','Credit limit '+credit_limit+' of this party has been exceeded.'); 
                        
                      }else{
                        toggle_pay_box();
                      }
                    }else{
                      toggle_pay_box();
                    }
                  }else{
                    toggle_pay_box();
                  }
                  
                  
      


                    } else { 
                     show_failed_msg('error','No internet');  
                }
              
            }else{
                show_failed_msg('error','Item is empty!');   
            }
        }else{
            show_failed_msg('error','Please select party!');   
        }

});

 function toggle_pay_box(){
    $('#payment_modal').modal('show');
 }





 $(document).on('click','#submit_invoice',function(e){


    var st=$('#subtotal').val();
    var grand_total=$('#grand_total').val();
    var view_method=$('#view_method').val();
    var invoice_type=$('#invoice_type').val();
   

   

    if (view_method=='create') {
      var total_cash=$('#cash_input').val();
    }else{
      var total_cash=$('#paid_amt').val();
    }

     

    var party_box=$('#customer').val();
    var due_amount=$('#due_amount').val();



    var credit_limit=$('#party_box').data('credit_limit');
    var closing_balance=$('#party_box').data('closing_balance');



    var inid=$(this).data('inid');
    if ($.trim(party_box)!='' && $.trim(party_box)!=0) {
    if (st!=0) {


    var is_readyto_submit=true;
    
    if (invoice_type=='sales_quotation') {
      is_readyto_submit= true;
    }else{

        if (parseFloat(total_cash)>parseFloat(grand_total)) {
          if (view_method=='create') { 
              show_failed_msg('error','Please enter an amount less than or equal to the total amount!');
              is_readyto_submit= false;
            }else{
              show_failed_msg('error','Cannot updated the invoice with lower amount than current payment made.<br> <a href="'+base_url()+'fees_and_payments/payments/'+inid+'">Delete vouchers</a>'); 
              is_readyto_submit= false;
            }
        }

    }
      if (!is_readyto_submit) {
        
        
      }else{


      // $('#submit_invoice').prop('disabled', true);
      var status = navigator.onLine;
            if (status) {

              var allow_submit=true;
              var due_close=parseFloat(closing_balance)+parseFloat(due_amount);
              

              if (credit_limit>0) {
                if (due_amount>0) {
                  if (credit_limit<due_close) { 
                      show_failed_msg('error','Credit limit '+credit_limit+' of this party has been exceeded.');
                  }else{
                    sinv(inid);
                  }
                }else{
                  sinv(inid);
                }
              }else{
                sinv(inid);
              }
              
              
  


          } else {
                $('#submit_invoice').prop('disabled', false); 
                show_failed_msg('error','No internet');
            }
          }




            }else{ 
              show_failed_msg('error','Item is empty!');
            }
      }else{
        show_failed_msg('error','Please select party!');
      }
    
  });



  function sinv(inid){
  $.ajax({
      type: "POST", 
            url: $('#invoice_form').attr('action'),
            data: $('#invoice_form').serialize(),
            beforeSend:function(){  
              $('#submit_invoice').html('<span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span> Loading...');  
           },
            success:function(response) {
            // alert(response);
              $('#submit_invoice').prop('disabled', false);
        $('#submit_invoice').html('<i class="mdi mdi-plus mr-1"></i> Complete');
        $('#mess').html('');
        $('#receiptmodal').modal('show');
        display_invoice($.trim(response));
        $('#invoice_form')[0].reset();
        reset_invoice(); 
        
        if ($('#view_method').val()=='convert') {
          try {
              var valNew=inid.split(',');

              for(var i=0;i<valNew.length;i++){
                  convert_invoice(valNew[i]);
              }
          } catch {
               convert_invoice(inid);
          }
        }
        

           },
           error:function(response){
            alert(JSON.stringify(response));
           }
      });
}

function convert_invoice(invoice){
        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
    var csrfHash = $('#csrf_token').val(); // CSRF hash
        $.ajax({
      url: base_url()+"invoices/convert_invoice/"+invoice,
      data:{
                [csrfName]: csrfHash
            },
      success:function(response) {
        
     },
     error:function(){
      alert("error");
     }
    });
    }

    function reset_invoice(){
        $('#products_table').html('');
        $('#tax_table').html('');
        calculate_invoice(); 
        calculate_due_amount();  
        calculate_due_amount(); 
        calculate_tax_amount(); 
        if (focus_element==1) {
            $('#product_code').focus();
        }else{
            
            $('#productbarcodesearch').focus();
        }
    }


    function display_invoice(invoice){
        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
        var csrfHash = $('#csrf_token').val(); // CSRF hash

        var buttons='';

        buttons+='<a class="text-white btn btn-sm btn-success font-size-footer aitsun-print cursor-pointer me-3" data-url="'+base_url()+'invoices/get_invoice_pdf/'+invoice+'/view#toolbar=0&navpanes=0&scrollbar=0"><i class="bx bx-printer"></i> <span class="hidden-xs">Print</span></a>';
        buttons+='<a class="text-white btn btn-sm btn-success font-size-footer aitsun-print cursor-pointer me-3" data-url="'+base_url()+'invoices/view_pdf/'+invoice+'?method=view"><i class="bx bx-printer"></i><span class="hidden-xs">PDF Print</span></a>';

        $('#print_buttoons').html(buttons); 
        var receipt_url=base_url()+"invoices/get_pos_invoice/"+invoice;
        $('#payment_modal').modal('hide');
        $('#receipt_dialog').removeClass('d-none');
        $('#pos_iframe').attr('src',receipt_url);
        $('#print_pos_btn').data('url',receipt_url); 
    }

$(document).on('click','#set_new_order',function(){
    $('#receipt_dialog').addClass('d-none');
    $('#pos_iframe').attr('src','');
    $('#print_pos_btn').data('url','');

    input_value=0;
    // reset_htmls
    $('#bill_item_box').html('<li class="text-center" id="no_items">No items</li>');
    // $('#grand_total_label2').html('0');
    // $('#due_amount_label2').html('0');
    // $('#total_taxamt_label_main').html('0');
    // $('#total_taxamt_label_main').html('grand_total_label');


 var x = 0;
    var intervalID = setInterval(function () {
       calculate_invoice();
       calculate_tax_amount();
       calculate_due_amount();
        
    if (++x === 5) {
           window.clearInterval(intervalID);
       }
    }, 100);


    //reset vals
    // $('.methods_pay_input').val(0);
    // $('#cash_input').val(0);

});

 $(document).on('input','#internal_note',function(){
    var this_val=$.trim($(this).val());
    if (this_val=='') {
        $('.internal_note_tag').prop('disabled',false);
    } 
 });

 $(document).on('click','.customer_row',function(){
    var this_element=$(this);
    var cus_id=$.trim($(this).data('cus_id'));
    var cus_name=$.trim($(this).data('cus_name'));
    var credit_limit=$.trim($(this).data('credit_limit'));
    var closing_balance=$.trim($(this).data('closing_balance'));


    $('.customer_row').removeClass('selected');
    $(this_element).addClass('selected');
    $('#customer').val(cus_id);
    $('#customer').data('credit_limit',credit_limit);
    $('#customer').data('closing_balance',closing_balance);



    $('#customer_btn').html(cus_name);
    $('#customer_modal').modal('hide');
 });

$(document).on('click','.item_container',function(){
    var this_element=$(this);
    input_value='';
    var productid=$(this).data('productid');
    var product_name=$(this).data('product_name');
    product_name=product_name.replace('"','&#x22;')
    var unit=$(this).data('unit');
    
    var description=$(this).data('description');
    var stock=$(this).data('stock');
    var product_type=$(this).data('product_type');
    var selling_price=$(this).data('selling_price');
    var purchaseprice=$(this).data('purchased_price');
    var tax=$(this).data('tax');
    var tax_percent=$(this).data('tax_percent');
    var tax_name=$(this).data('tax_name');
    var barcode=$(this).data('barcode');
    var prounit=$(this).data('prounit');
    var prosubunit=$(this).data('prosubunit');
    var proconversion_unit_rate=$(this).data('proconversion_unit_rate');
    var protax=$(this).data('protax');
    var purchase_tax=$(this).data('purchase_tax');
    var sale_tax=$(this).data('sale_tax');
    var mrp=$(this).data('mrp');
    var purchase_margin=$(this).data('purchase_margin');
    var sale_margin=$(this).data('sale_margin');
    var unit_disabled=$(this).data('unit_disabled');
    var in_unit_options=$(this).data('in_unit_options');
    var batch_number=$(this).data('batch_number');

    $('#no_items').remove();
    var item_data="";

    add_bill_item(
        productid,
        product_name,
        unit,
        description,
        stock,
        product_type,
        selling_price,
        purchaseprice,
        tax,
        tax_percent,
        tax_name,
        barcode,
        prounit,
        prosubunit,
        proconversion_unit_rate,
        protax,
        purchase_tax,
        sale_tax,
        mrp,
        purchase_margin,
        sale_margin,
        unit_disabled,
        in_unit_options,
        batch_number
    );
    
});
  
var row=0;
var taxrow=0;
var product_js_id=0;
var last_inserted_row=0;
var proqty=2;
var last_bar_code=0;
var foucc=0;
var is_split=false;
var focus_element=0;


if ($('#focus_element').val()==1) {
    focus_element=1;
}

if ($('#focus_element').val()==2) {
    focus_element=2;
}


if (focus_element==1) {
     $('#productbarcodesearch').focus(); 

}else if (focus_element==2) {
    $('#product_code').focus();

}

   
function split_from(value, index)
{
 return value.substring(0, index) + "," + value.substring(index);
}


$(document).on("keypress", "#productbarcodesearch", function(e) {
        if (e.keyCode == 13) {

            event.preventDefault();

            var barcode=$.trim($('#productbarcodesearch').val());
            var view_type=$('#view_type').val();
        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
      var csrfHash = $('#csrf_token').val();

      var barcode_type=$('#barcode_type').val(); 
      var final_barcode=barcode;
      var unit='';
      var sub_unit='';
      if (barcode!='') {

        // if (barcode_type==1) {
            final_barcode=barcode.substring(0, 6);;
            var get_from_last=barcode.substr(barcode.length - 6);
            var after_split=split_from(get_from_last,3);
            var p_b_data = after_split.split(",");
            var unit=p_b_data[0];
            var sub_unit=p_b_data[1];

        // }


       if (final_barcode.length>0) {
            var this_element=$('.barcode_item_'+barcode); 
            if (this_element.length) {
                var productid=$(this_element).data('productid');
                var product_name=$(this_element).data('product_name');
                product_name=product_name.replace('"','&#x22;')
                var unit=$(this_element).data('unit');
                
                var description=$(this_element).data('description');
                var stock=$(this_element).data('stock');
                var product_type=$(this_element).data('product_type');
                var selling_price=$(this_element).data('selling_price');
                var purchaseprice=$(this_element).data('purchased_price');
                var tax=$(this_element).data('tax');
                var tax_percent=$(this_element).data('tax_percent');
                var tax_name=$(this_element).data('tax_name');
                var barcode=$(this_element).data('barcode');
                var prounit=$(this_element).data('prounit');
                var prosubunit=$(this_element).data('prosubunit');
                var proconversion_unit_rate=$(this_element).data('proconversion_unit_rate');
                var protax=$(this_element).data('protax');
                var purchase_tax=$(this_element).data('purchase_tax');
                var sale_tax=$(this_element).data('sale_tax');
                var mrp=$(this_element).data('mrp');
                var purchase_margin=$(this_element).data('purchase_margin');
                var sale_margin=$(this_element).data('sale_margin');
                var unit_disabled=$(this_element).data('unit_disabled');
                var in_unit_options=$(this_element).data('in_unit_options');
                var batch_number=$(this_element).data('batch_number');
                
                $('#no_items').remove();
                var item_data="";

                    add_bill_item(
                        productid,
                        product_name,
                        unit,
                        description,
                        stock,
                        product_type,
                        selling_price,
                        purchaseprice,
                        tax,
                        tax_percent,
                        tax_name,
                        barcode,
                        prounit,
                        prosubunit,
                        proconversion_unit_rate,
                        protax,
                        purchase_tax,
                        sale_tax,
                        mrp,
                        purchase_margin,
                        sale_margin,
                        unit_disabled,
                        in_unit_options,
                        batch_number
                    );
            } else {
                show_failed_msg('error','No item available!')
            }
            

       }

        
      }

      $('#productbarcodesearch').val(''); 

       
    } 
    });


function add_bill_item(productid,
        product_name,
        unit,
        description,
        stock,
        product_type,
        selling_price,
        purchaseprice,
        tax,
        tax_percent,
        tax_name,
        barcode,
        prounit,
        prosubunit,
        proconversion_unit_rate,
        protax,
        purchase_tax,
        sale_tax,
        mrp,
        purchase_margin,
        sale_margin,
        unit_disabled,
        in_unit_options,
        batch_number,
        fi_unit,
        fi_subunit){

        var show_inputs='do_not_show_inputs';

        row++;
        
        selling_price=parseFloat(selling_price);
        purchaseprice=parseFloat(purchaseprice);

   

        var unit_disabled_message="";
        if (unit_disabled=='readonly') {
            unit_disabled_message='<span style="display: block; color:red; font-size: 11px;">You are unable to alter the primary unit because this item has transactions.</span> <div class="form-control bg-light-transparent">'+unit+'</div>';
        } 
        


        var box_class='d-none';
        if (prounit!='' && prosubunit!='' && prounit!=prosubunit) {
            box_class='';
        }  
    
        var sale_withtax_selected='';
        var sale_withouttax_selected='';
        var purchase_withtax_selected='';
        var purchase_withouttax_selected='';

        var view_type=$('#view_type').val();
        if (view_type=='sales') {
            
            if (sale_tax==1) {
                var tz=(parseFloat(tax_percent)+100)/100;
                var price=(selling_price/tz).toFixed(round_of_value());
            }else{
                var price=selling_price.toFixed(round_of_value());
            }
        }else{
            
            if (purchase_tax==1) {
                var pz=(parseFloat(tax_percent)+100)/100;
                var price=(purchaseprice/pz).toFixed(round_of_value()); 
            }else{
                var price=purchaseprice.toFixed(round_of_value());
            }
        }


        

        if (sale_tax==1) {
            sale_withtax_selected='selected';
        }else{
            sale_withouttax_selected='selected';
        }

        if (purchase_tax==1) {
            purchase_withtax_selected='selected';
        }else{
            purchase_withouttax_selected='selected';
        }

        var isplit_tax=0;

        if (is_split) {
            isplit_tax=1;
        }

        var input_quatity=1;

        if (typeof fi_unit!='undefined') {
            fi_unit=fi_unit;
        }else{
            fi_unit=0;
        }
        
        if (typeof fi_subunit!='undefined') {
            fi_subunit=fi_subunit;
        }else{
            fi_subunit=0;
        }
        
        if (fi_unit>0 || fi_subunit>0) {
            input_quatity=fi_unit+'.'+fi_subunit;
        }else{
            input_quatity=1;
        }
        


    
        if ($(".productidforcheck"+productid).length) {
            $('.orderline').removeClass('active');
            $(".productidforcheck"+productid).addClass('active');
            last_inserted_row=$(".productidforcheck"+productid).data('thisrow')

            proqty++;

            var get_qty_value=$('#row'+last_inserted_row+' .quantity_input').val();
            var rep_quantity=parseFloat(get_qty_value)+1;
            $('#row'+last_inserted_row+' .quantity_input').val(rep_quantity);
            $('#quantity_input_label'+last_inserted_row).html(rep_quantity);


            
        }else{
            proqty=2;
            $('.orderline').removeClass('active');
            $('#products_table').removeClass('tb');
            
var append_data='<li class="orderline '+show_inputs+' active probox mb-2 position-relative productidforcheck'+productid+' barcode'+barcode+'" id="row'+row+'" data-thisrow="'+row+'">'+

    '<div class="d-flex justify-content-between">'+
        '<div class="product-name d-inline-block flex-grow-1 fw-bolder pe-1 text-truncate">'+
            '<span class="text-wrap">'+product_name+'</span>'+

            '<input type="hidden" name="p_tax[]" id="pptax'+row+'" value="'+tax+'"><input type="hidden" name="product_name[]" value="'+product_name+'"><input type="hidden" name="product_id[]" value="'+productid+'">'+
            '<input type="hidden" name="batch_number[]" value="'+batch_number+'">'+
            '<input type="hidden" name="p_purchase_tax[]" value="'+sale_tax+'" id="id_purchase_tax_pptax'+row+'">'+
            '<input type="hidden" name="p_sale_tax[]" value="'+purchase_tax+'" id="id_sale_tax_pptax'+row+'">'+

            '<input type="hidden" name="i_id[]" value="0">'+
            '<input type="hidden" name="old_quantity[]" value="0">'+
            '<input type="hidden" class="form-control text-center form-control-sm mb-0 quantity_input numpad"  name="quantity[]" data-row="'+row+'" data-stock="'+stock+'" data-price="'+price+'" data-product="'+productid+'" id="quantity_input'+row+'"  min="1" value="'+input_quatity+'">'+
            '<input type="hidden" name="old_p_unit[]" value="">'+
            '<input type="hidden" name="old_in_unit[]" value="">'+
            '<input type="hidden" name="old_p_conversion_unit_rate[]" value="0">'+
            '<input type="hidden" name="split_taxx[]" value="'+isplit_tax+'">'+
            '<input type="hidden" step="any" class=" price mb-0 control_ro"  name="price[]" value="'+price+'" data-row="'+row+'" id="price_bx'+row+'" readonly >'+
            '<input type="hidden" step="any" class="item_total form-control mb-0 control_ro"  name="amount[]" value="'+price+'" id="proprice'+row+'" readonly>'+
        
            '<div class="d-none"><span id="tax_hider'+row+'">Tax: '+tax_name+' ('+tax_percent+'%)</span> '+currency_symbol()+'<input type="hidden" name="p_tax_amount[]" value="'+(price*tax_percent/100).toFixed(round_of_value())+'" id="p_tax_box'+row+'"><span class="tbox" id="taxboxlabel'+row+'">'+(price*tax_percent/100).toFixed(round_of_value())+'</span> <a class="delete_tax text-danger" data-rowid="'+row+'" data-pricesss="'+price+'"><i class="bx bxs-x-circle"></i></a>'+
            '<input type="hidden" step="any" class="numpad control_ro" data-row="'+row+'" data-product="'+productid+'" id="taxbox'+row+'" name="p_tax_percent[]" min="" value="'+tax_percent+'" readonly></div> '+
            '<textarea name="product_desc[]" class="d-none keypad textarea_border form-control prodesc" style="border: 1px solid #0000002e;">'+description+'</textarea>'+
            '<select class="in_unit form-control p-0 text-center d-none form-control-sm mb-0" name="in_unit[]" data-row="'+row+'" data-proconversion_unit_rate="'+proconversion_unit_rate+'"  id="in_unit'+row+'">'+in_unit_options+'</select>'+
       
            '<input type="hidden" step="any" class="form-control dis_inp form-control-sm mr-5 numpad discount_percent_input" data-type="percent" data-row="'+row+'" data-product="'+productid+'" data-price="'+price+'" id="discount_percentbox'+row+'" name="discount_percent[]" placeholder="Discount %" min="0" max="100" value="">'+

            '<input type="hidden" step="any" class="form-control dis_inp form-control-sm mr-5 numpad discount_input" data-row="'+row+'" data-product="'+productid+'" data-price="'+price+'" id="discountbox'+row+'" name="p_discount[]" placeholder="Discount" min="0" value="">'+

        '</div>'+

        '<div class="product-price text-end price fw-bolder">'+
          currency_symbol()+'&nbsp;<span data-row="'+row+'" id="propricelabel'+row+'">'+price+'</span>'+
        '</div>'+
    '</div>'+

    '<ul class="info-list">'+
      '<li class="price-per-unit">'+
        '<em class="qty fst-normal fw-bolder me-1" data-row="'+row+'" id="quantity_input_label'+row+'">'+input_quatity+'</em> <span class="text-muted"> Units x $&nbsp;<span data-row="'+row+'" id="price_bx_label'+row+'">'+price+'</span><span> / Units</span></span>'+
      '</li>'+
      '<li id="discount_percentbox_li'+row+'" class="d-none"><span class="text-muted"> With a</span> <em><span id="discount_percentbox_label'+row+'">0</span>% </em> <span class="text-muted">discount</span> </li>'+
    '</ul>'+

    '<div class="it_close pro_btn_remove" id="'+row+'">'+
        '<i class="bx bx-x"></i>'+
    '</div>'+


     '<div class="modal fade" id="price_edit_popup'+row+'"  tabindex="-1" aria-hidden="true">'+
                        '<div class="modal-dialog modal-sm modal-dialog-centered">'+
                          '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<h5 class="modal-title">Edit item</h5>'+
                                '<button type="button" class="btn-close close_popup" data-proid="'+row+'" data-bs-dismiss="modal" aria-label="Close"></button>'+
                            '</div>'+
                            '<div class="modal-body">'+


                            '<div class="form-group">'+
                
                                '<label for="inputProductTitle" class="form-label">MRP <small class="font-weight-bold text-danger">*</small></label>'+
                                '<div class="">'+
                                  '<input type="number" min="0" step="any" class="form-control pmrp" data-rowin="'+row+'" id="pmrp'+row+'" name="mrp[]" placeholder="Max Retail Price" value="'+mrp+'">'+
                                  '<div class="d-flex mt-2 w-100">'+
                                     '<div class="w-100">'+
                                      '<label>Pur. margin (%)</label>'+
                                      '<input type="number" min="0" step="any" class="form-control me-1 p_margin" data-rowin="'+row+'" id="p_margin'+row+'" name="purchase_margin[]" value="'+purchase_margin+'" placeholder="Pur. Disc %">'+
                                     '</div>'+
                                     '<div class="w-100">'+
                                      '<label>Sale margin (%)</label>'+
                                      '<input type="number" min="0" step="any" class="form-control ms-1 s_margin" data-rowin="'+row+'" id="s_margin'+row+'" name="sale_margin[]" value="'+sale_margin+'" placeholder="Sale. Disc %">'+
                                     '</div>'+
                                  '</div>'+
                                '</div>'+
                                
                            '</div>'+



                              '<div class="form-group">'+
                                '<label class="text-dark">Purchase price</label>'+
                                '<div class="d-flex">'+
                                '<input type="number" id="purchase_price_text'+row+'" value="'+purchaseprice.toFixed(round_of_value())+'" class="form-control">'+
                                '<div style="width: 134px;">'+
                                '<select class="form-control" id="purchase_tax_text'+row+'" name="purchase_tax">'+
                                  '<option value="1" '+purchase_withtax_selected+'>With Tax</option>'+
                                  '<option value="0" '+purchase_withouttax_selected+'>Without Tax</option>'+
                                '</select>'+
                              '</div>'+
                                '</div>'+

                              '</div>'+
                              '<div class="form-group mt-2">'+
                                '<label class="text-dark">Selling price</label>'+
                                  '<div class="d-flex">'+
                                '<input type="number" id="selling_price_text'+row+'" value="'+selling_price.toFixed(round_of_value())+'" class="form-control">'+
                                '<div style="width: 134px;">'+
                                '<select class="form-control" id="sale_tax_text'+row+'" name="sale_tax">'+
                                  
                                  '<option value="1" '+sale_withtax_selected+'>With Tax</option>'+
                                  '<option value="0" '+sale_withouttax_selected+'>Without Tax</option>'+
                                '</select>'+
                              '</div>'+
                              '</div>'+
                              '</div>'+
                              '<div class="form-group mt-2">'+
                                '<label class="text-dark">Unit</label>'+unit_disabled_message+

                                '<select id="unit_text'+row+'" class="form-control box_unit_input '+unit_disabled+'_select box_unit'+row+'" name="p_unit[]" data-rowid="'+row+'" '+unit_disabled+'>'+prounit+'</select>'+
                              '</div>'+
                              '<div class="form-group mt-2">'+
                                '<label class="text-dark">Sub Unit <small class=" text-danger box_subuer'+row+'"></small></label>'+
                                '<select id="subunit_text'+row+'" class="form-control box_subu box_sub_unit'+row+'" name="subunit[]" data-rowid="'+row+'">'+prosubunit+'</select>'+
                              '</div>'+

                              '<div class="form-group mt-2 '+box_class+' box_add_conversion'+row+'" id="box_add_conversion'+row+'">'+
                                '<label class="text-dark">Conversion unit rate</label>'+
                                '<input type="number" min="0" step="any" class="form-control"  id="conversion_unit_text'+row+'" name="conversion_unit[]" placeholder="Conversion unit rate" value="'+proconversion_unit_rate+'">'+
                                
                              '</div>'+
                              
                              '<div class="form-group mt-2">'+
                                '<label class="text-dark">Tax</label>'+
                                '<select id="tax_text'+row+'" class="form-control">'+protax+'</select>'+
                              '</div>'+
                              '<div class="form-group">'+
                                '<button type="button" class="btn btn-primary btn-sm mt-2 edit_purchase_price" id="edit_purchase_price'+row+'" data-proid="'+productid+'" data-rowid="'+row+'">Save</button>'+
                              '</div>'+

                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div>'+

'</li>';
            $('#bill_item_box').append(append_data);
             
                    product_js_id=productid;
                    last_inserted_row=row;

        }
        

        
        var x = 0;
        var intervalID = setInterval(function () {

            calculate_item_table(last_inserted_row,price);
            
            calculate_tax_amount();
            calculate_due_amount();
            calculate_invoice();
            $('#typeandsearch').val('');
            $('#tandsproducts').html('');
            // if (focus_element==1) {
            //     $('#productbarcodesearch').focus();
                
            // }else if (focus_element==2) {
            //     $('#product_code').focus();
            //     $('#product_code').val('');
            // }else{ 
            // }
            foucc=0;

           if (++x === 5) {
               window.clearInterval(intervalID);
           }
        }, 100);


} 


$(document).on('click', '.pro_btn_remove', function(){  
   var button_id = $(this).attr("id");   
   $('#row'+button_id+'').remove(); 
   product_js_id=0;
   var x = 0;
    var intervalID = setInterval(function () {
       calculate_invoice();
       calculate_tax_amount();
       calculate_due_amount();
        
    if (++x === 5) {
           window.clearInterval(intervalID);
       }
    }, 100);
});


$(document).on('click change input','#cash_input,#cheque_input,#bt_input', function(){
    var grand_total_amount=$('#grand_total_label').html();
    var payment_type = $('#payment_type').val();
    var pay_amount=0;
    
    pay_amount=$('#cash_input').val();

    if (pay_amount=='') {
        var pay_amount=0;
    }

    var due_amount = parseFloat(grand_total_amount)-parseFloat(pay_amount);

    $("#due_amount").val(due_amount.toFixed(round_of_value()));
    $("#due_amount_label").html(due_amount.toFixed(round_of_value()));
    $("#due_amount_label2").html(due_amount.toFixed(round_of_value()));
});

$(document).on('click','.change_pos_mode', function(){ 
    var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
    var csrfHash = $('#csrf_token').val();

    $('#product_search_input').removeClass('d-none');
    $('#product_code').addClass('d-none');

    var pos_mode=0;
    if (focus_element==0) {
        pos_mode=1;
        focus_element=1;
    }else if (focus_element==1) {
        pos_mode=2;
        focus_element=2;
    }else{
        pos_mode=0;
        focus_element=0;
    }

    $.ajax({
        url: base_url()+"pos/change_pos_mode/"+pos_mode,
        type:'POST',
        data:{
            [csrfName]: csrfHash
        },
        success:function(response) {
 
        if ($.trim(response)==1) {
            if (pos_mode==1) {
                $('.mode_span').html('Barcode');
                $('#focus_element').val(1);
                $('#productbarcodesearch').focus();
                show_success_msg('success','Scan barcode to add item')
            }else if (pos_mode==2) {
                $('#product_search_input').addClass('d-none');
                $('#product_code').removeClass('d-none');
                $('.target_input').removeClass('active');

                $('.mode_span').html('Product code'); 
                $('#focus_element').val(2);
                $('#product_code').focus();
                $('#product_code').val(''); 
            }else{ 
                $('.mode_span').html('Basic'); 
                $('#focus_element').val(0); 
            }
            location.reload();
        } 
        },
        error:function(){
          alert("error");
        }
    });
});


//////////////////////////// CALCULATIONS //////////////////////////////////
    function calculate_item_table(this_row,product_price){
        // var product_price=0;
        // $.ajax({
  //           url: base_url()+"sales/get_price?prod="+this_product,
  //           success:function(response) {
  //            product_price=$.trim(response);

                
                

  //           },
     //         error:function(){
     //          alert("error");
     //         }
     //    });

        // $('#price_bx'+this_row).val(response);

      var qty = $('#quantity_input'+this_row).val();

      var discount = $('#discountbox'+this_row).val();
      var discount_percentbox = $('#discount_percentbox'+this_row).val();
      if (isNaN(discount)) {
        discount=0;
      }
      $('#discount_percentbox'+this_row).val((discount/(product_price*qty)*100).toFixed(round_of_value()));

            if (qty=='') {
                qty=1;
            }
            if (discount=='') {
                discount=0;
            }

            
                            
        var calc_amt=(parseFloat(product_price)*parseFloat(qty))-parseFloat(discount);
        var tax = $('#taxbox'+this_row).val();
            if (tax!='') {
        var taxamt=calc_amt*tax/100;

        if (1) {

        }else{
            calc_amt+=parseFloat(taxamt);
        }
        
      }

        $('#proprice'+this_row).val(calc_amt+taxamt);

        $('#propricelabel'+this_row).html((calc_amt+taxamt).toFixed(round_of_value()));

        $('#taxboxlabel'+this_row).html(taxamt.toFixed(round_of_value()));
        $('#p_tax_box'+this_row).val(taxamt);

                
                

                // alert(this_row+this_product);

                
        
        
    }

    function calculate_due_amount(){
        var grand_total_amount=$('#grand_total_label').html();
        var payment_type = $('#payment_type').val();
        var pay_amount=0;
        
            pay_amount=$('#cash_input').val();

        var due_amount = parseFloat(grand_total_amount)-parseFloat(pay_amount);

          $("#due_amount").val(due_amount.toFixed(round_of_value()));
          $("#due_amount_label").html(due_amount.toFixed(round_of_value()));
          $("#due_amount_label2").html(due_amount.toFixed(round_of_value()));
        }

    function calculate_tax_amount(){
        var taxsum = 0;
        var sub_total=0;
        $(".item_total").each(function() {          
          if (!isNaN(this.value) && this.value.length != 0) {
            sub_total += parseFloat(this.value);
          }    
        });
        var disc= $("#discountval").val();
        var sub_total = parseFloat(sub_total)-parseFloat(disc);

            $(".tax_tr").each(function() {          
          var ti=$(this).data('taxidentifier'); 
          var tax_percent=$('#taxpercent'+ti).val();
          var taxamount = parseFloat(sub_total)*parseFloat(tax_percent)/100;
          $("#taxamount"+ti).val(taxamount);
          $("#taxamountlabel"+ti).html(taxamount);
          taxsum += parseFloat(taxamount);
        });



        

        var total_taxamt_label_main=0;
        $(".tbox").each(function() {          
          var taxmt=$(this).html(); 
           total_taxamt_label_main+= parseFloat(taxmt)
        });

        
        $("#total_taxamt_label_main").html(total_taxamt_label_main.toFixed(round_of_value()));
        $("#total_taxamt").val(total_taxamt_label_main);
        $("#total_taxamt_label").html(total_taxamt_label_main);

    }

     
    function calculate_invoice(){


         




        var sum = 0;        
        $(".item_total").each(function() {          
          if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
          }    
        });
        
        if ($('#disc_val').val()=='' ) {
            entire_discount = 0;
        }else{
            var entire_discount = parseFloat($('#disc_val').val());
        }
        var taxamount = $("#total_taxamt").val();
        var round_type = $("#round_type").val();
        var round_off = $.trim($("#round_off").val());
    var transport_charge = $.trim($("#transport_charge").val());

        var additional_discount = $.trim($("#additional_discount").val()); 



        var sub_total = parseFloat(sum);

        var grand_total =parseFloat(sum);

        if (additional_discount!='') {

             grand_total=grand_total-parseFloat(additional_discount);
        }
        
                var fin_grand_total=0;

        if (round_off!='') {

            if (round_type=='add') {
                fin_grand_total=parseFloat(grand_total)+parseFloat(round_off);
            }else{

                fin_grand_total=parseFloat(grand_total)-parseFloat(round_off);
            }

        }else{
            round_off=0;
            fin_grand_total=grand_total;
        }

        if (transport_charge!='') {

           fin_grand_total=fin_grand_total+parseFloat(transport_charge);
        }

        var txxmt=$("#total_taxamt_label_main").html();

        
        //displayinmg value
        $("#discountval").val(entire_discount.toFixed(round_of_value()));
        $("#discountval_label").html(entire_discount.toFixed(round_of_value()));
        $("#subtotal").val(sub_total.toFixed(round_of_value()));
        $("#subtotal_label").html((sub_total-parseFloat(txxmt)).toFixed(round_of_value()));

        $("#grand_total").val(fin_grand_total.toFixed(round_of_value()));
        $("#grand_total_label").html(fin_grand_total.toFixed(round_of_value()));
        $("#grand_total_label2").html(fin_grand_total.toFixed(round_of_value()));


        $("#cash_input").val(fin_grand_total.toFixed(round_of_value())); 
        $('.pay_box').first().find('.methods_pay_input').val(fin_grand_total.toFixed(round_of_value()));
        $("#cheque_input").val(fin_grand_total);
        $("#bt_input").val(fin_grand_total);




    }



    $(document).on('click','.qty_minus', function(){
        var this_row=$(this).data('row');
        var this_product=$(this).data('product');
        var price=$(this).data('price');

        var qnumber4=$('#quantity_input'+this_row).val();
        if (qnumber4 != 0) {
            var upval=parseFloat(qnumber4)-1;
            $('#quantity_input'+this_row).val(upval);

            var this_val=$('#discount_percentbox'+this_row).val(); 
            $('#discountbox'+this_row).val(((price*upval)*this_val/100).toFixed(round_of_value()));

            var x = 0;
            var intervalID = setInterval(function () {

                calculate_item_table(this_row,price);
                calculate_invoice(); 
                calculate_due_amount();  
                calculate_due_amount(); 
                calculate_tax_amount();

            if (++x === 5) {
                   window.clearInterval(intervalID);
               }
            }, 100);
         

        }
    });

    $(document).on('click','.qty_plus', function(){
        var this_row=$(this).data('row');
        var this_product=$(this).data('product');
        var qnumber4=$('#quantity_input'+this_row).val();
        var price=$(this).data('price');
            var upval=parseFloat(qnumber4)+1;
            $('#quantity_input'+this_row).val(upval);

            var this_val=$('#discount_percentbox'+this_row).val(); 
            $('#discountbox'+this_row).val(((price*upval)*this_val/100).toFixed(round_of_value()));

            var x = 0;
            var intervalID = setInterval(function () {

                calculate_item_table(this_row,price);
                calculate_invoice(); 
                calculate_due_amount();  
                calculate_due_amount(); 
                calculate_tax_amount();

            if (++x === 5) {
                   window.clearInterval(intervalID);
               }
            }, 100);
    });

    $(document).on('click change input','.quantity_input', function(){
        var this_row=$(this).data('row');
        var this_product=$(this).data('product');
        var stock=$(this).data('stock');
        var price=$(this).data('price');
        var qnumber4=$(this).val();
        var x = 0;

        var this_val=$('#discount_percentbox'+this_row).val(); 
            $('#discountbox'+this_row).val(((price*qnumber4)*this_val/100).toFixed(round_of_value()));

        var intervalID = setInterval(function () {

            calculate_item_table(this_row,price);
            calculate_invoice(); 
            calculate_due_amount();  
            calculate_due_amount(); 
            calculate_tax_amount();

        if (++x === 5) {
               window.clearInterval(intervalID);
           }
        }, 100);

    });

     
    $(document).on('click change input','.price', function(){
        var this_row=$(this).data('row'); 
        var price=$(this).val(); 


        $('#quantity_input'+this_row).data('price',price);
        $('#discountbox'+this_row).data('price',price);
        $('#discount_percentbox'+this_row).data('price',price);
        $('#qty_plus'+this_row).data('price',price);
        $('#qty_minus'+this_row).data('price',price);


        
        $(this).siblings('.qty_plus').data('price',price);

        
        var x = 0; 
        var intervalID = setInterval(function () {

            calculate_item_table(this_row,price);
            calculate_invoice(); 
            calculate_due_amount();  
            calculate_due_amount(); 
            calculate_tax_amount();

        if (++x === 5) {
               window.clearInterval(intervalID);
           }
        }, 100);

    });

    $(document).on('click input','.discount_input,.discount_percent_input', function(){
        var this_row=$(this).data('row');
        var this_val=$(this).val();
        var type=$(this).data('type');
        var this_product=$(this).data('product');
        var price=$(this).data('price');
        var p_price=$('#price_bx'+this_row).val(); 
        var p_qty=$('#quantity_input'+this_row).val(); 

        

        if (type=='percent') {
            $('#discountbox'+this_row).val(((p_price*p_qty)*this_val/100).toFixed(round_of_value()));
        }else{
            $('#discount_percentbox'+this_row).val((this_val/(p_price*p_qty)*100).toFixed(round_of_value()));
        }



            var qty = $('#quantity_input'+this_row).val();
      var discount = $('#discountbox'+this_row).val(); 
 

            if (qty=='') {
                qty=1;
            }
            if (discount=='') {
                discount=0;
            }

            
                            
        var calc_amt=(parseFloat(price)*parseFloat(qty))-parseFloat(discount);
        var tax = $('#taxbox'+this_row).val();
            if (tax!='') {
        var taxamt=calc_amt*tax/100;

        if (1) {

        }else{
            calc_amt+=parseFloat(taxamt);
        }
        
      }
        $('#proprice'+this_row).val(calc_amt+taxamt);

        $('#propricelabel'+this_row).html((calc_amt+taxamt).toFixed(round_of_value()));

        $('#taxboxlabel'+this_row).html(taxamt.toFixed(round_of_value()));
        $('#p_tax_box'+this_row).val(taxamt);


        
        var x = 0;
        var intervalID = setInterval(function () {

            // calculate_item_table(this_row,price);
            calculate_invoice(); 
            calculate_due_amount();  
            calculate_due_amount(); 
            calculate_tax_amount();

        if (++x === 5) {
               window.clearInterval(intervalID);
           }
        }, 100);


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


function round_of_value(){
    var round_of_value=$('#round_of_value').val();
    return round_of_value;
}

function currency_symbol(){
    var crsy=$('#currency_symbol').val();
    return crsy;
}

function base_url(){
    var baseurl=$('#base_url').val();
    return baseurl;
}
