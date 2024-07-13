<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <link rel="icon" href="<?= base_url('public'); ?>/images/app_icon.ico" type="image/png" />
  <link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/invoice.css'); ?>?ver=<?= style_version(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/custom.css'); ?>?ver=<?= style_version(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/icons.css'); ?>?ver=<?= style_version(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/sweetalert2.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/lobibox.min.css') ?>">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="<?= base_url('public'); ?>/js/lobibox.min.js"></script>
  <style type="text/css">.bg-no{background: transparent!important;} .bg-no .row{padding: 0!important;}</style>

  <style type="text/css">
    .swal2-container.swal2-center {
        align-items: center;
        z-index: 99999999!important;
    }
    .modal {
      z-index: 1111111!important;
  }

  .spin_me{
    animation: spin_me 1s infinite linear;
  }

  
.lobibox-notify-wrapper{
    z-index: 90000000000!important;
}


@keyframes spin_me {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}

.discount_percent_input{
  max-width: 100px;
    width: 35px;
    text-align: center;
    padding: 0 3px;
}

.discount_input{
   max-width: 100px;
    width: 50px;
    text-align: center;
    padding: 0 3px;
}
.quantity_input{
   max-width: 100px;
    width: 60px;
    text-align: center;
    padding: 0 3px;
}
.discount_percent_input::-webkit-outer-spin-button,
.discount_percent_input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
} 
.discount_percent_input{
  -moz-appearance: textfield;
}

.discount_input::-webkit-outer-spin-button,
.discount_input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
} 
.discount_input{
  -moz-appearance: textfield;
}

.quantity_input::-webkit-outer-spin-button,
.quantity_input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
} 
.quantity_input{
  -moz-appearance: textfield;
}

.scroll_none::-webkit-scrollbar{
  display: none;
}

.qty_plus,.qty_minus{
  background: #5c25cc;
    color: white;
}

.get_weight{
  padding: 0;
}

.get_weight_icon{
  margin-left: 4px;
}
  <?php if (get_setting(company($user['id']),'weighing_mac')!=1) { ?>
    .get_weight{
      display: none;
    }
  <?php } ?>  
  </style>
</head>
<body style="overflow: hidden;">
    
    <div class="invoice_container">

        <?php 
          $invoice_for='';
          if ($_GET) {
            if (isset($_GET['invoice_for'])) {
              if (!empty($_GET['invoice_for'])) {
                $invoice_for=$_GET['invoice_for'];
              }
            }

            if (isset($_GET['booking'])) {
              if (!empty($_GET['booking'])) {
                if ($_GET['booking']>0) {
                  $invoice_for='appointment';
                } 
              }
            }
          }

          if ($view_method=='convert' || $view_method=='edit') {
            $invoice_for=$in_data['bill_from'];
          }
         ?>

      <form id="invoice_form" method="post" action="<?php if ($view_method=='edit'): ?><?= base_url('sales/update_invoice'); ?>/<?= $in_data['id']; ?><?php elseif($view_method=='convert' || $view_method=='copy'): ?><?= base_url('sales'); ?><?php else: ?><?= base_url('sales') ?><?php endif ?>">
        <?= csrf_field(); ?>


            <?php 
                if ($view_method=='convert' || $view_method=='copy' || $view_method=='edit') {
                    $indata_subtotal=$in_data['sub_total'];
                    $indata_total=$in_data['total'];
                    $indata_discount=$in_data['discount'];
                    $indata_additional_discount=$in_data['additional_discount'];
                    $indata_cash_discount_percent=$in_data['cash_discount_percent']; 

                    $indata_round_type=$in_data['round_type'];  
                    $indata_round_off=$in_data['round_off']; 




                    if (count($m_invoices)>0) {
                      $indata_subtotal=0;
                      $indata_total=0;
                      $indata_discount=0;
                      $indata_additional_discount=0;
                      $indata_cash_discount_percent=0;
                      $indata_round_type='add';
                      $indata_round_off=0;
                      $indata_due_amount=0;


                      foreach ($m_invoices as $cm) {
                        if (!empty(trim($cm))){
                          $indata_subtotal+=invoice_data($cm,'sub_total');
                          $indata_total+=invoice_data($cm,'total');
                          $indata_discount+=invoice_data($cm,'discount');
                          $indata_due_amount+=invoice_data($cm,'due_amount');
                          $indata_additional_discount+=invoice_data($cm,'additional_discount'); 
                         
                        

                          if (invoice_data($cm,'round_type')=='add') {
                            $indata_round_off=invoice_data($cm,'round_off');
                             $indata_round_type=invoice_data($cm,'round_type');  
                          }else{
                            $indata_round_off=invoice_data($cm,'round_off');
                             $indata_round_type=invoice_data($cm,'round_type');  
                          }
                          
                          
                        } 
                      }
                      if ($indata_total<1) {
                        $indata_cash_discount_percent=$indata_additional_discount/1*100;
                      }else{
                        $indata_cash_discount_percent=$indata_additional_discount/$indata_total*100;
                      }
                      

                    }
                }
             ?>

              <!-- ///////////////////////// SOME INITIALIZATION //////////////////////////////////////// -->
                <?php if ($view_method=='edit'): ?>
                    <input type="hidden" name="paaid" id="paid_amt" value="<?= aitsun_round($in_data['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?>">
                    <input type="hidden" name="old_total" value="<?= aitsun_round($indata_total,get_setting(company($user['id']),'round_of_value')); ?>">
                  <?php endif ?>

                  <input type="hidden" name="view_type" value="<?= $view_type; ?>" id="view_type">
                  <input type="hidden" name="view_method" value="<?= $view_method; ?>" id="view_method">

                  <?php if ($view_method=='convert'): ?>
                    <input type="hidden" name="convertfrom" value="<?= $in_data['invoice_type']; ?>" id="convertfrom">
                  <?php endif ?>

                  <input type="hidden" id="split_tax" value="<?= get_setting(company($user['id']),'split_tax'); ?>">
                  <input type="hidden" id="is_subunit_divide" value="1">



                  <input type="hidden" id="focus_element" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'cursor_position'); ?>">
                  <input type="hidden" id="barcode_type" value="<?= get_setting(company($user['id']),'barcode_settings'); ?>">
                  <input type="hidden" id="invoice_for" name="invoice_for" value="<?= $invoice_for; ?>">

               <!-- ///////////////////////// SOME INITIALIZATION //////////////////////////////////////// -->

      
      <!-- HEADER SECTION 1 -->
      <div class="d-flex header_section_1 justify-content-between">
         <div class="d-flex">
           <a  class="my-auto go_back_or_close cursor-pointer text-dark btn-new_window">
            <i class="bx bx-arrow-back"></i>
          </a>
          <label class="my-auto ml-10">
              <?= langg(get_setting(company($user['id']),'language'),full_invoice_type($invoice_type)); ?>

              <?php if ($invoice_for=='rental'): ?>
                - Rental
              <?php endif ?>

              <?php if ($view_method=='convert'): ?>
                <?= langg(get_setting(company($user['id']),'language'),'- Convert'); ?>
              <?php elseif ($view_method=='edit'): ?>
                <?= langg(get_setting(company($user['id']),'language'),'- Edit'); ?>


              <?php elseif ($view_method=='copy'): ?>
                <?= langg(get_setting(company($user['id']),'language'),'- Copy'); ?>
              <?php endif ?>  
          </label>
         </div>
        <div class="d-flex">

          

          <a data-bs-toggle="modal" data-bs-target="#indate" class="ml-5 cursor-pointer my-auto text-dark <?php if (get_setting(company($user['id']),'allow_receipt_date')==0): echo 'd-none'; endif; ?>" id="invoice_date_label" style="font-size: 12px;">
            <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['invoice_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'d M y'); ?><?php endif ?>
          </a>
          <a onclick="window.location.href=window.location.href" class="ml-5 my-auto text-dark">
            <i class="bx bx-refresh"></i>
          </a>
          <!-- <a id="fullscreen" class="ml-5 my-auto text-dark">
            <i class="bx bx-fullscreen"></i>
          </a> -->
          <a id="open_calculator" class="ml-5 my-auto text-dark">
            <i class="bx bx-calculator"></i>
          </a>
          <a id="new_window" class="ml-5 text-dark btn-new_window">
            <i class="bx bx-windows"></i>
          </a>
         
        </div>
      </div>
      <!-- HEADER SECTION 1 -->

      <!-- ///////////////////////////////////// INITIALIZATION ////////////////////////////////// -->
      <input type="hidden" id="invoice_type" name="invoice_type" value="<?php if ($view_method=='convert'): ?><?= $convert_to; ?><?php else: ?><?= $invoice_type; ?><?php endif ?>">

      <?php 
        if ($view_type=='sales'){
          $array_of_customer=customers_array(company($user['id']));
        }else{
          $array_of_customer=vendors_array(company($user['id']));
        }
      ?>

      <?php 
        $from_lead='no_lead';
        $from_renew='no_renew';

        if ($view_method=='convert') {
          $from_renew=$in_data['renew_id'];
        }
         


        $from_stage='no_stage';

        if ($_GET) {
          if (isset($_GET['from_lead'])) {
            if (!empty($_GET['from_lead'])) {
              $from_lead=$_GET['from_lead'];
            }
          }

          if (isset($_GET['from_stage'])) {
            if (!empty($_GET['from_stage'])) {
              $from_stage=$_GET['from_stage'];
            }
          }

          if (isset($_GET['from_renew'])) {
            if (!empty($_GET['from_renew'])) {
              $from_renew=$_GET['from_renew'];
            }
          }
          
        }
      ?>


      <input type="hidden" name="from_lead" value="<?= $from_lead; ?>">
      <input type="hidden" name="stage" value="<?= $from_stage; ?>">
      <input type="hidden" name="from_renew" value="<?= $from_renew; ?>">

      <!-- ///////////////////////////////////// INITIALIZATION ////////////////////////////////// -->


      <div class="d-md-flex">
        <!-- HEADER SECTION 2 -->
        <div class="d-flex header_section_2 mt-2 justify-content-between">

         

          <?php 
            $cus_value="CASH CUSTOMER";
            $old_customer="CASH CUSTOMER";
            $old_in_type="";
            $old_due_amount=0;
            $old_paid_amount=0;

            $disable_value="";
              if ($from_lead!='no_lead') { 
                $cus_value=user_name(get_lead_data($from_lead,'cr_customer')); 
                $disable_value="readonly";
              }
          ?> 
          <?php 
              if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy') {
                if ($in_data['customer']!='CASH') {
                  $cus_value=user_name($in_data['customer']); 
                  $disable_value="readonly"; 
                  $old_customer=$in_data['customer'];
                  $old_in_type=$in_data['invoice_type'];
                  $old_due_amount=$in_data['due_amount'];
                  $old_paid_amount=$in_data['paid_amount'];
                }
              } 
          ?>

          <input type="hidden" name="old_customer" value="<?= $old_customer ?>">
          <input type="hidden" name="old_in_type" value="<?= $old_in_type ?>">
          <input type="hidden" name="old_due_amount" value="<?= $old_due_amount ?>">
          <input type="hidden" name="old_paid_amount" value="<?= $old_paid_amount ?>">

          <?php $booking_id=0; if ($_GET): ?>
            <?php if (isset($_GET['booking'])): ?>
              <?php if (!empty($_GET['booking'])): ?>
                <?php $booking_id=$_GET['booking']; ?> 
              <?php endif ?>
            <?php endif ?>
          <?php endif ?>

          <input type="hidden" name="booking_id" value="<?= $booking_id ?>">


          <input type="hidden" name="alternate_name" class="form-control form-control-sm mr-5" placeholder="Party name" id="alternate_name" value="<?= $cus_value; ?>" <?= $disable_value; ?>>

          <div class="aitsun_select position-relative d-inline-flex w-100">                            
            <input type="text" class="aitsun-datebox d-none " style="text-indent: 10px; " data-select_url="<?= base_url('selectors/all_parties_for_create_invoice/'.$view_type); ?>">
            <a class="select_close d-none" style=""><i class="bx bx-x"></i></a>
            <select class="form-control form-control-sm mr-5 w-100" name="customer" id="party_box" style="margin: auto; text-indent: 10px;  padding: 0;">

                <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy') { ?>
                  <option value="<?= $in_data['customer'] ?>"><?= user_name($in_data['customer']) ?></option> 
                <?php }else{ ?>
                  <?php if ($view_type=='sales'): ?>
                    <?php if ($_GET): ?>
                      <?php if (isset($_GET['customer'])): ?>
                        <?php if (!empty($_GET['customer'])): ?>
                          <option value="<?= $_GET['customer'] ?>"><?= user_name($_GET['customer']) ?></option> 
                        <?php endif ?>
                      <?php endif ?>
                    <?php endif ?>
                    <option value="<?= cash_customer_of_company(company($user['id'])) ?>"><?= user_name(cash_customer_of_company(company($user['id']))) ?></option> 
                  <?php else: ?>
                    <option value="">Search party</option> 
                  <?php endif ?>
                  
                <?php } ?>
                
               
            </select>
            <div class="aitsun_select_suggest">
            </div>
        </div> 

          
        </div>
        <!-- HEADER SECTION 2 -->

        <div class="d-flex w-apanel">

            
         

          <!-- SCAN BARCODE SECTION -->
          <div class="position-relative mt-2 mbl_res_search w-100">
            <i class="bx bx-barcode-reader scan_position"></i>
            <input type="text" id="productbarcodesearch" placeholder="Scan Barcode" class="form-control form-control-sm  my-auto">
          </div>
          <!-- SCAN BARCODE SECTION -->
          <div class="gap <?php  if ($view_type=='sales'){echo "d-none";} ?>"></div>
          <!-- BILL NUMBER -->
          <div class="form-group mt-2 w-100 <?php  if ($view_type=='sales'){echo "d-none";} ?>">
              <input type="text" name="bill_number" class="form-control form-control-sm" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Bill No'); ?>." value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['bill_number']; ?><?php else: ?><?php endif; ?>">
          </div>
          <!-- BILL NUMBER -->
        </div>

      </div>




 

    <!-- search product selector -->
      <div class="d-flex header_section_3 position-relative mt-2 justify-content-between d-flex>">
        <div class="position-relative">
        <input type="number" id="product_code" data-input="code" placeholder="Type Product Code" class="mr-5 product_code_search po">
        <div style="position: absolute;right: 14px;top: 6px; color: green;" id="loadbox_code">
          
        </div>
        </div>

        <div class="position-relative w-100 d-flex">
        <input type="text" class="mr-5" id="typeandsearch" data-input="name" placeholder="Type item name & Press enter">
        <input type="text" id="typeandsearch_category" data-input="name" class="d-none" placeholder="Search by category">
        <div style="position: absolute;right: 14px;top: 6px; color: green;" id="loadbox_name">
          
        </div>
        </div>

        <button type="button" id="addnewproductbutton" class="btn btn-sm btn-success ml-5">
          <i class="bx bx-plus"></i>
        </button>
        <div id="tandsproducts" class="d-none">
          <?php 
            foreach (products_array(company($user['id'])) as $pro): 
              $price_list=price_list_of_product($pro['id']);
              $price_list=json_encode($price_list);
          ?>
            <a class="item_box col-md-3 my-2 procode_<?= $pro['product_code']; ?> barcode_item_<?= substr($pro['barcode'], 0, 6); ?> custom_barcode_item_<?= $pro['barcode']; ?>" href="javascript:void(0);"
              data-productid="<?= $pro['id']; ?>" 
              data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>" 
              data-batch_number="<?= $pro['batch_no']; ?>" 
              data-unit="<?= $pro['unit']; ?>"
              <?php if ($view_type=='sales'): ?>
                  data-price="<?= $pro['price']; ?>"
              <?php else: ?>
                  data-price="<?= $pro['purchased_price']; ?>"
              <?php endif ?>
              data-price_list='<?= $price_list ?>' 
              data-tax="<?= $pro['tax']; ?>"

              data-prounit='<?php foreach (products_units_array(company($user['id'])) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'
              data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($user['id'])) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

              data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

               data-protax='<?php foreach (tax_array(company($user['id'])) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

              data-tax_name="<?= tax_name($pro['tax']); ?>"
              data-barcode="<?= $pro['barcode']; ?>"
              data-tax_percent="<?= percent_of_tax($pro['tax']); ?>"
              data-stock="<?= $pro['closing_balance'] ?>"
              data-description="<?= str_replace('"','%22',$pro['description']); ?>"
              data-product_type="<?= $pro['product_type']; ?>"
              data-purchased_price="<?= $pro['purchased_price']; ?>"
              data-selling_price="<?= $pro['price']; ?>"
              data-purchase_tax="<?= $pro['purchase_tax']; ?>"
              data-sale_tax="<?= $pro['sale_tax']; ?>"
              data-mrp="<?= $pro['mrp']; ?>"
              data-purchase_margin="<?= $pro['purchase_margin']; ?>"
              data-sale_margin="<?= $pro['sale_margin']; ?>"
              data-custom_barcode="<?= $pro['custom_barcode']; ?>"


               data-unit_disabled="<?php if (item_has_transaction($pro['id'])): ?>readonly<?php endif ?>"
               data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"
               
              >
                  <div class="product_box <?php if ($pro['product_type']=='item_kit'){ $cst=item_kit_stock($pro['id']);}else{$cst=$pro['closing_balance'];}if ($cst<=0){ echo 'out_of_stock'; } ?>">
                      <h6 class="text-white textoverflow_x-none"><?= $pro['product_name']; ?> - <em><?= name_of_category($pro['category']) ?></em></h6>
                      <span>
                          <em><?= name_of_brand($pro['brand']); ?></em>

                              <?php if ($pro['product_method']=='product'): ?>
                          
                          <small>
                              <?php if ($pro['product_type']=='item_kit'){ echo item_kit_stock($pro['id']).' item in stock';}else{ if ($pro['closing_balance']<=0 ){  echo '<small class="bg-body p-1 text-danger">Stock ('.$pro['closing_balance'].')</small>';}else{ echo $pro['closing_balance'].' '.name_of_unit(unit_of_product($pro['id'])).' in stock';  }} ?>
                          </small>
                          <?php endif ?>
                      </span >
                  </div>
                  
              </a>
          <?php endforeach ?>
        </div>

      </div>
      <!-- PRODUCT SELECTION SECTION -->

      <div class="d-md-flex">
        <!-- PRODUCTS SECTION -->
        <div class="product_section mt-2">
          <ul id="products_table">
            <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>



              <?php $taxcount=0; foreach ($m_invoices as $m): ?>
                <?php if (!empty(trim($m))): ?> 

                <?php  foreach (invoice_items_array($m) as $pros): 
                  $product_name=$pros['product'];
                  $productid=$pros['product_id'];
                  $row=$pros['id'];
                  $description=$pros['desc'];
                  $stock=stock_of_product($pros['product_id']);
                  $discoount=$pros['discount'];
                  $discount_percent=$pros['discount_percent'];

                  
                  
 

                  $quaantity=$pros['quantity'];
                  $selling_price=selling_price($pros['product_id']);
                  $pur_price=purchase_price($pros['product_id']);

                  $sale_tax=$pros['sale_tax'];
                  $purchase_tax=$pros['purchase_tax'];
                  $in_unit=$pros['in_unit']; 


                  $sale_withtax_selected='';
                  $sale_withouttax_selected='';
                  $purchase_withtax_selected='';
                  $purchase_withouttax_selected='';

                  if ($sale_tax==1) {
                    $sale_withtax_selected='selected';
                  }else{
                    $sale_withouttax_selected='selected';
                  }

                  if ($purchase_tax==1) {
                    $purchase_withtax_selected='selected';
                  }else{
                    $purchase_withouttax_selected='selected';
                  }
 
                  $price=($pros['price']-$discoount);
                
                  
                  $amount=$pros['amount'];
                  $pro_unit=$pros['unit'];
                  $pro_subunit=$pros['sub_unit'];
                  $pro_conversion_unit_rate=$pros['conversion_unit_rate'];

                  $old_purchase_price=$pros['old_purchase_price'];
                  $old_purchase_amount=$pros['old_purchase_amount'];

                  $box_class='d-none';

                  if ($pro_unit!='' && $pro_subunit!='' && $pro_unit!=$pro_subunit) {
                      $box_class='';
                    } 

                  $pro_tax=$pros['tax'];

                  $tax=$pros['tax'];


                 
                      
                         $taxxxx=(($pros['price']*$pros['quantity'])-$pros['discount'])*percent_of_tax($pros['tax'])/100; 
                     

                      

                      $taxcount+=$taxxxx; 
                    
                      

                ?>
            <li class="probox mb-2 position-relative productidforcheck<?= $productid; ?> barcode<?= get_barcode($productid); ?>" id="row<?= $row; ?>" data-thisrow="<?= $row; ?>">

                <h6 class="product_name"><?= $product_name; ?></h6>
                
                <input type="hidden" name="p_tax[]" id="pptax<?= $row; ?>" value="<?= $tax; ?>"><input type="hidden" name="product_name[]" value="<?= $product_name; ?>">


                <input type="hidden" name="batch_number[]" value="<?= $pros['batch_number']; ?>">


                <input type="hidden" name="p_purchase_tax[]" value="<?= $pros['purchase_tax'] ?>" id="id_purchase_tax_pptax<?= $row; ?>">
                <input type="hidden" name="p_sale_tax[]" value="<?= $pros['sale_tax'] ?>" id="id_sale_tax_pptax<?= $row; ?>">
                


                <input type="hidden" name="product_id[]" value="<?= $productid; ?>">
                <input type="hidden" name="i_id[]" value="<?= $row; ?>">

                <div class="d-flex justify-content-between">
                  <div class="my-auto">
                    
                    <input type="hidden" name="split_taxx[]" value="<?= $pros['split_tax'] ?>">

                    <div class="d-flex cursor-pointer"> 
                      <a data-proid="<?= $row; ?>" class="open_popup"><i class="bx bx-pencil"></i></a> 
                      Price: <?= currency_symbol($user['company_id']); ?><input type="number" step="any" class=" price price_box mb-0 control_ro"  name="price[]" value="<?= aitsun_round($price+$discoount,get_setting(company($user['id']),'round_of_value')); ?>" id="price_bx<?= $row; ?>" readonly >

                      <div class="my-auto">/</div>

                      <select class="form-control pricelist_select" id="pricelist_select<?= $row; ?>" data-row_id="<?= $row; ?>" name="rental_price_type[]">
                        <option value="0" data-rental_price="<?= aitsun_round($price+$discoount,get_setting(company($user['id']),'round_of_value')); ?>" >Default</option>
                        <?php foreach (price_list_of_product($productid) as $obj): ?>
                          <option value="<?= $obj['id'] ?>" data-rental_price="<?= $obj['price'] ?>" data-period_duration="<?= $obj['period_duration'] ?>" data-unit="<?= $obj['unit'] ?>" <?= ($obj['id']==$pros['rental_price_type'])?'selected':''; ?>><?= $obj['period_name'] ?></option>
                        <?php endforeach ?> 
                      </select>

                    </div>
                    <div><span id="tax_hider<?= $row; ?>">Tax: 
                      <?php if ($tax>0): ?>
                        <?= tax_name($tax); ?>(<?= percent_of_tax($tax); ?>%)
                      <?php else: ?>
                        None
                      <?php endif ?>
                    </span>  <?= currency_symbol($user['company_id']); ?>
                    <input type="hidden" name="p_tax_amount[]" value="<?= aitsun_round(($pros['price']*$pros['quantity'])*percent_of_tax($tax)/100,get_setting(company($user['id']),'round_of_value')); ?>" id="p_tax_box<?= $row; ?>">

                    <span class="tbox" id="taxboxlabel<?= $row; ?>"><?= aitsun_round((($pros['price']*$pros['quantity'])-$pros['discount'])*percent_of_tax($tax)/100,get_setting(company($user['id']),'round_of_value')); ?></span> <a class="delete_tax text-danger" data-rowid="<?= $row; ?>" data-pricesss="<?= $price; ?>"><i class="bx bxs-x-circle"></i></a>

                    <input type="hidden" step="any" class="numpad control_ro" data-row="<?= $row; ?>" data-product="<?= $productid; ?>" id="taxbox<?= $row; ?>" name="p_tax_percent[]" min="" value="<?= percent_of_tax($tax); ?>" readonly></div> 
                  </div>

                  <div class="modal fade" id="price_edit_popup<?= $row; ?>"   aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit price</h5>
                            <button type="button" class="btn-close close_popup" data-proid="<?= $row; ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                          <div class="form-group">
            
                            <label for="inputProductTitle" class="form-label">MRP <small class="font-weight-bold text-danger">*</small></label>
                            <div class="">
                              <input type="number" min="0" step="any" class="form-control pmrp" data-rowin="<?= $row; ?>" id="pmrp<?= $row; ?>" name="mrp[]" placeholder="Max Retail Price" value="<?= aitsun_round($pros['mrp'],get_setting(company($user['id']),'round_of_value')) ?>">
                              <div class="d-flex mt-2 w-100">
                                 <div class="w-100">
                                  <label>Pur. margin (%)</label>
                                  <input type="number" min="0" step="any" class="form-control me-1 p_margin" data-rowin="<?= $row; ?>" id="p_margin<?= $row; ?>" name="purchase_margin[]" value="<?= aitsun_round($pros['purchase_margin'],get_setting(company($user['id']),'round_of_value')) ?>" placeholder="Pur. Disc %">
                                 </div>
                                 <div class="w-100">
                                  <label>Sale margin (%)</label>
                                  <input type="number" min="0" step="any" class="form-control ms-1 s_margin" data-rowin="<?= $row; ?>" id="s_margin<?= $row; ?>" name="sale_margin[]" value="<?= aitsun_round($pros['sale_margin'],get_setting(company($user['id']),'round_of_value')) ?>" placeholder="Sale. Disc %">
                                 </div>
                              </div>
                            </div>
                            
                        </div>

                          <div class="form-group mt-2">
                            <label class="text-dark"><?= langg(get_setting(company($user['id']),'language'),'Purchase price'); ?></label>
                            <div class="d-flex">
                            <input type="number" id="purchase_price_text<?= $row; ?>" value="<?= aitsun_round($pur_price,get_setting(company($user['id']),'round_of_value')); ?>" class="form-control">

                            <div style="width: 134px;">
                            <select class="form-control" name="purchase_tax" id="purchase_tax_text<?= $row ?>">
                              <option value="1" <?= $purchase_withtax_selected; ?>>With Tax</option>
                              <option value="0" <?= $purchase_withouttax_selected; ?>>Without Tax</option>
                            </select>
                          </div>
                          </div>

                          </div>
                          <div class="form-group mt-2">
                            <label class="text-dark"><?= langg(get_setting(company($user['id']),'language'),'Selling price'); ?></label>
                            <div class="d-flex">
                            <input type="number" id="selling_price_text<?= $row; ?>" value="<?= aitsun_round($selling_price,get_setting(company($user['id']),'round_of_value')); ?>" class="form-control">

                            <div style="width: 134px;">
                              <select class="form-control" name="sale_tax" id="sale_tax_text<?= $row ?>">
                                <option value="1" <?= $sale_withtax_selected; ?>>With Tax</option>
                                <option value="0" <?= $sale_withouttax_selected; ?>>Without Tax</option>
                              </select>
                            </div>
                            </div>
                          </div>




                          <div class="form-group mt-2">
                            <label class="text-dark">Unit</label> 
 
                              <?php if (item_has_transaction($pros['product_id'])): ?>
                                <span style="display: block; color:red; font-size: 11px;">You are unable to alter the primary unit because this item has transactions.</span>
                                <div class="form-control bg-light-transparent"><?= $pro_unit ?></div>
                              <?php endif ?> 

                            <select id="unit_text<?= $row; ?>" name="p_unit[]" class="form-control box_unit_input <?php if (item_has_transaction($pros['product_id'])): ?>readonly_select<?php endif ?> box_unit<?= $row; ?>" data-rowid="<?= $row; ?>">
                              <?php foreach (products_units_array(company($user['id'])) as $pu): ?>
                                <option value="<?= $pu['value']; ?>" <?php if ($pro_unit==$pu['value']) {echo 'selected';} ?>>
                                  <?= $pu['name']; ?>
                                </option>
                              <?php endforeach ?>
                            </select>
                          </div>
                          <div class="form-group mt-2">
                            <label class="text-dark">Sub Unit <small class=" text-danger box_subuer<?= $row; ?>"></small></label>
                            <select id="subunit_text<?= $row; ?>" name="subunit[]" class="form-control box_subu box_sub_unit<?= $row; ?>" data-rowid="<?= $row; ?>">
                              <option value="">None</option>
                              <?php foreach (products_units_array(company($user['id'])) as $pu): ?>
                              <option value="<?= $pu['value']; ?>" <?php if ($pro_subunit==$pu['value']) {echo 'selected';} ?>>
                                <?= $pu['name']; ?>
                              </option>
                            <?php endforeach ?>
                            </select>
                          </div>

                          <div class="form-group mt-2 <?php if ($pro_unit!='' && $pro_subunit!='' && $pro_unit!=$pro_subunit) {  echo ''; }else{ echo 'd-none'; } ?> box_add_conversion<?= $row; ?>" id="box_add_conversion<?= $row; ?>">
                            <label class="text-dark">Conversion unit rate</label>
                            <input type="number" min="0" step="any" class="form-control"  id="conversion_unit_text<?= $row; ?>" name="conversion_unit[]" placeholder="Conversion unit rate" value="<?= aitsun_round(conversion_unit_of_product($productid),get_setting(company($user['id']),'round_of_value')); ?>">
                            
                          </div>
  

                          <div class="form-group mt-2">
                            <label class="text-dark">Tax</label>
                            <select id="tax_text<?= $row; ?>" class="form-control">
 

                              <?php foreach (tax_array(company($user['id'])) as $txxx): ?>
                                <option data-perc="<?= $txxx['percent']; ?>" data-tname="<?= $txxx['name']; ?>" value="<?= $txxx['name']; ?>" <?php if ($pro_tax==$txxx['name']) {echo 'selected';} ?>>
                                  <?= $txxx['name']; ?>
                                </option>
                              <?php endforeach ?>
                            </select>
                          </div>

                          


                          <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm mt-2
                             edit_purchase_price" id="edit_purchase_price<?= $row; ?>" data-proid="<?= $productid; ?>" data-rowid="<?= $row; ?>"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  

                  <div class="my-auto">
                    <a class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#prodesc<?= $row; ?>">More</a> 

                  </div>
                </div>

                <div id="prodesc<?= $row; ?>" class="collapse">
                  <div class="accordion-body px-0 py-1">
                    <textarea name="product_desc[]" class="keypad textarea_border form-control prodesc" style="border: 1px solid #0000002e;"><?= $description; ?></textarea>

                    <input type="hidden" step="any" name="" id="p_unitbox<?= $row; ?>" value="<?= $pro_unit; ?>">

                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <div class="my-auto d-flex">
                    <div class="my-auto">
                      
                      <div>
                        <label style="color: #ff1010;">Discount</label>
                        <div class="d-flex">
                          <label style=" margin-top: auto;margin-bottom: auto;margin-right: 5px;margin-left: 5px;">%</label>
                          <input type="number" step="any" class="form-control dis_inp form-control-sm mr-5 numpad discount_percent_input" data-type="percent" data-row="<?= $row; ?>" data-product="<?= $productid; ?>" data-price="<?= $price+$discoount; ?>" id="discount_percentbox<?= $row; ?>" name="discount_percent[]" placeholder="Discount %" min="0" max="100" value="<?= aitsun_round($discount_percent,get_setting(company($user['id']),'round_of_value')); ?>">

                          <label style=" margin-top: auto;margin-bottom: auto;margin-right: 5px;margin-left: 5px;"><?= currency_symbol(company($user['id'])) ?></label>
                        <input type="number" step="any" class="form-control dis_inp form-control-sm mr-5 numpad discount_input" data-type="number" data-row="<?= $row; ?>" data-product="<?= $productid; ?>" data-price="<?= $price+$discoount; ?>" id="discountbox<?= $row; ?>" name="p_discount[]" placeholder="Discount" min="0" value="<?= aitsun_round($discoount,get_setting(company($user['id']),'round_of_value')); ?>">

                        </div>
                      </div>
                    </div>

                    <div class="my-auto">
                      <label style="color: #257e00;">Quantity</label>
                      <div class="d-flex" style="min-width: 145px;">

                        <div class="input-group-btn">
                          <button type="button" class="btn border btn-sm qbtn qty_minus" id="qty_minus<?= $row; ?>" data-row="<?= $row; ?>" data-price="<?= $price+$discoount; ?>" data-product="<?= $productid; ?>"> 
                            <span class="bx bx-minus"></span>
                          </button>
                        </div>

                        <input type="number" class="form-control text-center form-control-sm mb-0 quantity_input numpad"  name="quantity[]" data-row="<?= $row; ?>" data-stock="<?= $stock; ?>" data-price="<?= $price+$discoount; ?>" data-product="<?= $productid; ?>" id="quantity_input<?= $row; ?>"  min="1" value="<?= $quaantity; ?>">

                        

                        <select class="in_unit form-control p-0 text-center form-control-sm mb-0" data-proconversion_unit_rate="<?= conversion_unit_of_product($productid); ?>" name="in_unit[]" data-row="<?= $row; ?>" id="in_unit<?= $row; ?>"> 
                          <option value="<?= $pro_unit; ?>" <?php if($pro_unit==$in_unit){echo "selected";} ?>><?= $pro_unit; ?></option>
                          <?php if (!empty($pro_subunit)): ?>
                            <option value="<?= $pro_subunit ?>" <?php if($pro_subunit==$in_unit){echo "selected";} ?>><?= $pro_subunit ?></option>
                          <?php endif ?> 
                        </select>

                        <input type="hidden" name="old_quantity[]" value="<?= $quaantity; ?>">
                        <input type="hidden" name="old_p_unit[]" value="<?= $pro_unit; ?>">
                        <input type="hidden" name="old_in_unit[]" value="<?= $in_unit; ?>">
                        <input type="hidden" name="old_p_conversion_unit_rate[]" value="<?= $pro_conversion_unit_rate; ?>">
                        <input type="hidden" name="old_purchase_price[]" value="<?= $old_purchase_price; ?>">
                        <input type="hidden" name="old_purchase_amount[]" value="<?= $old_purchase_amount; ?>">
                        



                        <div class="input-group-btn">
                          <button type="button" class="btn border btn-sm qbtn qty_plus" id="qty_plus<?= $row; ?>" data-row="<?= $row; ?>" data-price="<?= $price+$discoount; ?>" data-product="<?= $productid; ?>" data-stock="<?= $stock; ?>">
                            <span class="bx bx-plus"></span>
                          </button>
                        </div>

                        <button class="btn btn-sm border get_weight"  type="button" data-inpid="quantity_input<?= $row; ?>">
                          <i class="bx bx-sync get_weight_icon" title="Get quantity from machine" id="gtbt_quantity_input<?= $row; ?>"></i>
                        </button>

                      </div>
                    </div> 

                  </div>
                  <div class="my-auto">
                    <label style="opacity: 0;">Tot</label>
                      <h5 class="m-0 "><span class="text-success"><?= currency_symbol($user['company_id']); ?></span><span id="propricelabel<?= $row; ?>"><?= aitsun_round($amount,get_setting(company($user['id']),'round_of_value')); ?></span></h5>
                      <input type="hidden" step="any" class="item_total form-control mb-0 control_ro"  name="amount[]" value="<?= aitsun_round($amount,get_setting(company($user['id']),'round_of_value')); ?>" id="proprice<?= $row; ?>" readonly>
                  </div>
                </div>

                <a id="<?= $row; ?>" class="btn text-white pro_btn_remove"><span>+</span></a>

            </li>
                  <?php endforeach ?>    
            <?php endif ?>                                                     
              <?php endforeach ?>  
            <?php endif ?>  

          </ul>
        </div>
        <!-- PRODUCTS SECTION -->


        <!-- PRODUCTS SECTION -->
        <div class="fixed_footer">
          <div class="footer_section mt-2">
            <div class="d-flex justify-content-between">
              <div class="my-auto my-auto w-100">

                <div class="">
                <div class="d-flex justify-content-between mt-1 w-100 mb-2">
                  <div class="my-auto" style="width: 170px;">Referral: </div>
                  <div>
                    <div class="d-flex justify-content-end">
                      <select class="form-select form-select-sm" style="width: max-content;" name="inv_referal"> 
                        <option value="">Choose</option>
                        <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?> 
                            <?php foreach (all_branches($user['id']) as $alb): ?>
                              <?php foreach (admin_array($alb['id']) as $ads): ?>
                                  <option value="<?= $ads['id']; ?>" <?php if($in_data['inv_referal']==$ads['id']){echo "selected";} ?>><?= $ads['display_name']; ?></option>
                              <?php endforeach ?>
                            <?php endforeach ?>

                            <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                                <option value="<?= $flr['id']; ?>" <?php if($in_data['inv_referal']==$flr['id']){echo "selected";} ?>><?= $flr['display_name']; ?></option>
                            <?php endforeach ?>
                          <?php else: ?>
                              <?php foreach (all_branches($user['id']) as $alb): ?>
                                <?php foreach (admin_array($alb['id']) as $ads): ?>
                                    <option value="<?= $ads['id']; ?>"><?= $ads['display_name']; ?></option>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                                <option value="<?= $flr['id']; ?>"><?= $flr['display_name']; ?></option>
                            <?php endforeach ?>
                          <?php endif; ?> 
                        
                            
                      </select>
                      
                    
                    </div>

                  </div>
                </div> 
              </div>


              <?php if (is_medical(company($user['id']))):?>
              
                <div class="d-flex justify-content-between mb-1">
                  <div class="my-auto">Doctor Name:</div>
                  <div>
                  <input type="text" name="doctor_name" class="form-control form-control-sm " value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['doctor_name']; ?><?php else: ?> <?php endif; ?>">
                  </div>
                </div>
              
              <?php endif ?>
              

                <div class="<?php if (get_setting($user['company_id'],'show_mrn_number')!=1): ?>d-none<?php endif ?>">
                
                    <div class="d-flex justify-content-between">
                      <div class="my-auto">MRN Number:</div>
                      <div>
                      <input type="text" name="mrn_number" class="form-control form-control-sm " value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['mrn_number']; ?><?php else: ?> <?php endif; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="<?php if (get_setting($user['company_id'],'show_validity')!=1): ?>d-none<?php endif ?>">
                    <div class="d-flex justify-content-between mt-1">
                      <div class="my-auto">Validity:</div>
                      <div>
                    <select class="form-select form-select-sm" name="validity" style="width: 148px;">
                        

                         <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?> 
                            <option value="3" <?php if ($in_data['validity']=='3') {echo 'selected';} ?>>3 Days</option>
                            <option value="5" <?php if ($in_data['validity']=='5') {echo 'selected';} ?>>5 Days</option>
                            <option value="10" <?php if ($in_data['validity']=='10') {echo 'selected';} ?>>10 Days</option>
                            <option value="15" <?php if ($in_data['validity']=='15') {echo 'selected';} ?>>15 Days</option>
                            <option value="30" <?php if ($in_data['validity']=='30') {echo 'selected';} ?>>30 Days</option>
                            <option value="60" <?php if ($in_data['validity']=='60') {echo 'selected';} ?>>60 Days</option>
                            <option value="90" <?php if ($in_data['validity']=='90') {echo 'selected';} ?>>90 Days</option>
                          <?php else: ?>
                            <option value="3">3 Days</option>
                            <option value="5">5 Days</option>
                            <option value="10">10 Days</option>
                            <option value="15">15 Days</option>
                            <option value="30">30 Days</option>
                            <option value="60">60 Days</option>
                            <option value="90">90 Days</option>
                          <?php endif; ?> 


                      </select>
                      </div>
                    </div>
                  </div>



                <?php if (get_company_data($user['company_id'],'country')!='Oman'):?>
                  
                
                <div class="d-flex justify-content-between mt-1">
                  <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): $instate=$in_data['state_of_supply']; ?>
                    <input type="hidden" name="company_state" value="<?= $in_data['company_state'] ?>">
                  <?php else: $instate=''; ?>
                    <input type="hidden" name="company_state" value="<?= get_company_data(company($user['id']),'state') ?>">
                  <?php endif; ?>
                  
                  <div class="my-auto">State of supply:</div>
                  <div>
                  <select class="form-select form-select-sm" name="state_of_supply" style="width: 148px;"> 
                    <option value="">Choose</option>
                      <?php foreach (states_array(company($user['id'])) as $st): ?>
                          <option value="<?= $st ?>" <?php if($st==$instate){echo 'selected';} ?>><?= $st ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
                </div>
                <?php endif ?>


                <div class="d-flex justify-content-between">
                    <div>Sub total: <b>
                      <?= currency_symbol($user['company_id']); ?><span id="subtotal_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_subtotal-$taxcount,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif; ?></span>

                       <input type="hidden" name="sub_total" id="subtotal" class="form-control text-right control_ro" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_subtotal,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif; ?>" readonly>
                    </b>
                  </div>


                  

                  <div class="mt-1">Tax: <b><?= currency_symbol($user['company_id']); ?><span id="total_taxamt_label_main"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($taxcount,get_setting(company($user['id']),'round_of_value'),PHP_ROUND_HALF_UP); ?><?php else: ?>0<?php endif; ?></span></b></div>
                </div>


                <div>
                  <div class="d-flex justify-content-between w-100">
                    <div class="my-auto" style="width: 170px;">Additional discount: </div>
                    <div>

                      <div class="d-flex justify-content-end"> 
                       
                        <label class="my-auto me-1 ">%</label>
                        <input type="number" step="any" name="additional_discount_percent" id="additional_discount_percent" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['additional_discount_percent'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>" class="form-control-sm form-control w-25">

                        <input type="number" step="any" name="additional_discount" id="additional_discount" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_additional_discount,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>" class="form-control-sm form-control w-50">
                      </div>

                    </div>
                  </div> 
                </div>


                <div >
                  <div class="d-flex justify-content-between mt-1 w-100">
                    <div class="my-auto" style="width: 170px;">Round off: </div>
                    <div>

                      <div class="d-flex justify-content-end">
                      
                        <select class="form-select form-select-sm " style="width: 100px;" id="round_type" name="round_type"> 
                          <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?> 
                            <option value="add" <?php if ($indata_round_type=='add') {echo 'selected';} ?>>+ Add </option>
                            <option value="sub" <?php if ($indata_round_type=='sub') {echo 'selected';} ?>>- Reduce</option>
                          <?php else: ?>
                            <option value="add">+ Add </option>
                            <option value="sub">- Reduce</option>
                          <?php endif; ?> 
                        </select>
                        <label class="my-auto me-1  d-none">%</label>
                        <input type="number" step="any" name="cash_discount_percent" id="cash_discount_percent" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_cash_discount_percent,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>" class="form-control-sm form-control w-25 d-none">

                        <input type="number" step="any" name="round_off" id="round_off" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_round_off,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>" class="form-control-sm form-control w-50">
                      </div>

                    </div>
                  </div> 
                </div>

               <div class="d-flex justify-content-between">
                  <div class="d-flex justify-content-between mt-1">
                    <div class="my-auto me-1">Vehicle Number:</div>
                    <div>
                    <input type="text" name="vehicle_number" class="form-control form-control-sm " value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['vehicle_number']; ?><?php else: ?> <?php endif; ?>">
                    </div>
                  </div>

                  <div class="d-flex justify-content-between mt-1">
                    <div class="my-auto me-1">Transport Charges:</div>
                    <div>
                    <input type="number" step="any" name="transport_charge" id="transport_charge" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['transport_charge']; ?><?php else: ?> <?php endif; ?>" class="form-control-sm form-control">
                    </div>
                  </div>
               </div>
 

                <!-- //////////////////////// rental details //////////////////////////// -->
                <?php  
                  if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'){
                    $from_date=get_date_format($in_data['rent_from'],'Y-m-d');
                    $from_time=get_date_format($in_data['rent_from'],'H:i');
                    $to_date=get_date_format($in_data['rent_to'],'Y-m-d');
                    $time=get_date_format($in_data['rent_to'],'h:i');
                 
                    $duration=$in_data['rental_duration']; 
                  
                    $newTime = get_date_format($in_data['rent_to'],'H:i');
                  }else{
                    $from_date=get_date_format(now_time($user['id']),'Y-m-d');
                    $from_time=get_date_format(now_time($user['id']),'H:i');
                    $to_date=get_date_format(now_time($user['id']),'Y-m-d');
                    $time=get_date_format(now_time($user['id']),'h:i');
                    $booking_id='';
                    $timeObject = DateTime::createFromFormat('H:i', $time);
                    $duration='01:00'; 
                 
 
                    $from_time = get_date_format(now_time($user['id']),'H:i');

                     
                    list($hours, $minutes) = sscanf($duration, "%d.%d");

                    // Convert from_time to minutes
                    list($from_hours, $from_minutes) = explode(':', $from_time);
                    $total_from_minutes = $from_hours * 60 + $from_minutes;

                    // Add duration in minutes
                    $total_duration_minutes = $hours * 60 + $minutes;
                    $total_minutes = $total_from_minutes + $total_duration_minutes;

                    // Calculate new time
                    $new_hours = floor($total_minutes / 60);
                    $new_minutes = $total_minutes % 60;

                    // Format new time
                    $newTime = sprintf('%02d:%02d', $new_hours, $new_minutes);
 
                  } 
                ?>
                <?php if ($invoice_for=='rental'): ?>
                <div class="rental_details mt-2">
                  <h6>Rental details</h6>
                  <div class="d-flex">
                    <div class="w-100">
                      <label>Invoice address</label>
                      <textarea class="form-control" name="invoice_address" placeholder=""><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['invoice_address']; ?><?php else: ?> <?php endif; ?></textarea>
                    </div>
                    <div class="w-100">
                      <label>Delivery address</label>
                      <textarea class="form-control" name="delivery_address" placeholder=""><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['delivery_address']; ?><?php else: ?> <?php endif; ?></textarea>
                    </div>
                  </div>

                  <div class="mt-2">
                    <b>Rental period</b>
                    <div class="d-lex">
                      <div class="w-100">
                        <label>From</label>
                        <div class="d-flex">
                          <input type="date" class="form-control modal_inpu" name="rent_from_date" id="rent_from_date" value="<?= $from_date ?>">
                          <input type="time" class="form-control modal_inpu" name="rent_from_time" id="rent_from_time" value="<?= $from_time ?>">
                        </div>
                      </div>
                      <div class="w-100">
                        <label>To</label>
                        <div class="d-flex">
                          <input type="date" class="form-control modal_inpu" name="rent_to_date" id="rent_to_date" value="<?= $to_date ?>">
                        
                          <input type="time" class="form-control modal_inpu" name="rent_to_time" id="rent_to_time" value="<?= $newTime ?>">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div>
                    <label for="input-1" class="modal_lab">Duration</label>
                    <div class="d-flex">
                      <input type="text" class="form-control modal_inpu d-none  w-50 rental_duration" name="rental_duration" id="rental_duration" value="<?= $duration ?>" readonly>
                      <b class="my-auto " id="rental_duration_label" ><?= duration_to_rental_days($duration) ?></b>
                    </div>
                  </div>
                </div>
                <?php endif ?>
              <!-- //////////////////////// rental details //////////////////////////// -->

              </div>
              <div class="my-auto">
                <div class="dl-none">
                  <div>Discount:</div>
                  <div>
                    <b>
                      <input type="text" step="any" class="form-control form-control-sm numpad" name="discount" id="disc_val" min="0" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $indata_discount; ?><?php else: ?>0<?php endif; ?>">
                    </b>
                  </div> 
                </div> 
              </div>


             


            </div>

            <table class="w-100 mt-2">
              <thead>
                  <tr>
                      <td class="bg-success w-50 p-1">
                        <h6><strong class="text-white"><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></h6>
                        <h5 class="mb-0 text-white"><?= currency_symbol($user['company_id']); ?><span id="grand_total_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></h5>
                        <input type="hidden" name="grand_total" id="grand_total" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>">
                      </td>
                      <td class="bg-warning w-50 p-1 <?php if ($view_method=='edit' || ($view_method=='convert' && $in_data['invoice_type']!='proforma_invoice') || $view_method=='copy'){echo 'd-none';} ?>">
                          <h6><strong><?= langg(get_setting(company($user['id']),'language'),'Due'); ?></strong></h6>
                          <h5 class="mb-0"><?= currency_symbol($user['company_id']); ?><span id="due_amount_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['due_amount'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></h5>
                          <input type="hidden" name="due_amount" id="due_amount" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['due_amount'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>">
                      </td>
                  </tr>
              </thead>
          </table>

           <?php 
              if ($view_method=='edit'){
                $classss="d-none";
              }elseif ($view_method=='convert') {
                $classss="";
                if ($view_type!='sales' &&  $view_type!='sales_return' && $view_type!='purchase' && $view_type!='purchase_return') {
                  $classss="d-none";
                }
              }elseif ($invoice_type!='sales' && $invoice_type!='proforma_invoice' &&  $invoice_type!='sales_return' && $invoice_type!='purchase' && $invoice_type!='purchase_return') {
                $classss="d-none";
              }else{
                $classss='';
              }
            ?>

          <div class="d-flex justify-content-between">
            <div class="my-auto">
              <div class="<?= $classss ?>">Received amount:</div>
            </div>
            <div class="my-auto">
              <a data-bs-toggle="modal" data-bs-target="#notee" class="cursor-pointer"><i class="bx bx-plus"></i> Add note</a>  
            </div>
          </div>


            <!-- ///////////////////////////PAYMENT/////////////////////////////// -->
            
            <table class="w-100 d-none">
              <thead>
                  <td><h6 class="m-0"><?= langg(get_setting(company($user['id']),'language'),'Tax amount'); ?></h6></td>
                  <td colspan="2" class="text-right"><h6 class="m-0"><?= currency_symbol($user['company_id']); ?><span id="total_taxamt_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['tax']; ?><?php else: ?>0<?php endif; ?></span></h6>
                      <input type="hidden" name="tax_amount" id="total_taxamt" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['tax']; ?><?php else: ?>0<?php endif; ?>">
                  </td>
              </thead>
            </table>

           
             
             <div class="d-flex w-100 <?= $classss; ?>">
                <div class="form-group mb-3 w-25"> 
                    <select class="form-control payment_select" name="payment_type[]" id="payment_type" required>
                        <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                            <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div><!-- form-group -->

                

                <div id="cash_options" class="w-75">
                    <div class="form-group"> 
                        <input type="text" min="0" id="cash_input" class="numpad form-control " name="cash_amount" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total-$indata_due_amount,get_setting(company($user['id']),'round_of_value')); ?><?php endif ?>" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Amount'); ?>">

                        <input type="hidden" min="0" id="payment_type_value" class="numpad form-control " name="payment_type_value[]" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total-$indata_due_amount,get_setting(company($user['id']),'round_of_value')); ?><?php endif ?>" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Amount'); ?>">

                    </div><!-- form-group -->
                </div>   
             </div>

      <!-- ///////////////////////////PAYMENT/////////////////////////////// -->


            <?php 
              if ($view_method=='edit' || $view_method=='copy'){
                $inid=$in_data['id'];
              }elseif ($view_method=='convert') {
                $inid=$inid;
              }elseif ($invoice_type!='sales' && $invoice_type!='proforma_invoice' && $invoice_type!='sales_return') {
                $inid='';
              }else{
                $inid='';
              }
            ?>
     

          <div id="mess" class=" text-center text-danger w-100 mb-2"></div>

            <div class="d-flex justify-content-between"> 
              <div class="w-100">
                <button type="button" class="btn w-100 btn-sm btn-complete" data-inid="<?= $inid; ?>" id="submit_invoice" name="save_invoice">Complete</button> 
              </div>
            </div>

            

          </div>
        </div>
        <!-- PRODUCTS SECTION -->
      </div>

      <!-- /////////////////////////////// MODALS ///////////////////////////////////////////// -->
      <div class="modal fade" id="indate"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            
            <div class="modal-body">
              <div class="px-0 py-1 d-flex">
                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['invoice_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'Y-m-d'); ?><?php endif ?>"  >
                <button type="button" class="btn btn-primary ms-2" data-bs-dismiss="modal" aria-label="Close">OK</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      


      <div class="modal fade" id="notee"  aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
               
              <div class="modal-body">
                <div class=" px-0 py-1">
                  <textarea name="notes" class="form-control prodesc mb-2" placeholder="Note"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['notes']; ?><?php endif ?></textarea>
                  <textarea name="private_notes" class="form-control prodesc" placeholder="Private Note"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['private_notes']; ?><?php endif ?></textarea>
                </div>

                <div class="w-100 text-center">
                  <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal" aria-label="Close">OK</button>
                </div>

              </div>
            </div>
          </div>
        </div>
 
        <div class="modal fade" id="pro_selector"  aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                  <input type="text" id="productsearch" placeholder="Search Item" data-input="name" class="form-control ml-2 keypad my-auto">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                
                <div class="d-flex">
                  <div class="row col-md-11"  id="products"></div>

                  <div class="d-flex w-100 my-2">
                    <div class="m-auto">
                      <div id="up_pro" class="d-block">
                        <i class="bx bx-arrow-to-top scrollbt c-pointer"></i>
                      </div>
                      <div id="down_pro" class="d-block">
                        <i class="bx bx-arrow-to-bottom scrollbt c-pointer"></i>
                      </div>
                    </div>
                  </div>
                </div>
             
              </div>
            </div>
          </div>
        </div>
      <!-- /////////////////////////////// MODALS ///////////////////////////////////////////// -->


   

</form>


    <!-- ///////////////////////////////   FORM  EXLUDED MODALS //////////////////////////////// -->

    <div class="modal aitposmodal fade" id="receiptmodal" data-bs-keyboard="false" data-bs-backdrop="static"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="remove_style" role="document" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'INVOICE'); ?></h5>
        <div class="ms-3" id="print_buttoons">

        </div>
      </div>
        <div>   
           <button type="button" class="btn-sm btn-secondary close_receipt"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        </div>
      </div>

      <div class="modal-body p-0 scroll_none">
        <div id="pdf_show_div"></div>
        <div id="receipt_show">
            
        </div>
        <div id="pdfthermalthis" class="p-0 m-0 w-100">


          
        </div>
      </div> 
    </div>
  </div>
</div>

<script type="text/javascript">
  function print_invoice(){
        var contents = $("#receipt_show").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>DIV Contents</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        frameDoc.document.write('<link href="'+base_url()+'/public/css/invoice_bootstrap.min.css" rel="stylesheet" type="text/css" />');
        frameDoc.document.write('<link href="'+base_url()+'/public/css/custom.css" rel="stylesheet" type="text/css" />');
        frameDoc.document.write('<link href="'+base_url()+'/public/css/invoice_design.css" rel="stylesheet" type="text/css" />');
        frameDoc.document.write('<link href="'+base_url()+'/public/css/after_print.css" rel="stylesheet" type="text/css" />');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    }
</script>

    <div class="modal fade" id="addcus"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class=" px-0 py-1">
                <!-- //////////////FORMMMMM/////////////////// -->
                  <form method="post" id="add_cust_form" action="<?= base_url('customers/save_customer'); ?>">
                    <?= csrf_field(); ?>
                    <div class="">
                      <div class="row">

                          
                       
                        <div class="col-md-12 row m-0 p-0" >
                              <input type="hidden" name="withajax" id="withajax" value="1">
                               <div class="form-group col-md-6 mb-3">

                                <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="display_name" id="display_name" required>
                               </div>

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-3" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Email/Username'); ?> </label>
                                <input type="text" class="form-control modal_inpu" name="email" id="email">
                               </div>

                               <div class="form-group col-md-6 mb-3 d-none">
                                <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact Name'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="contact_name" id="contact_name">
                               </div>

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Party Type'); ?></label>
                                <select class="form-control" name="party_type" id="party_type">
                                    <option value="customer">Customer</option>
                                    <option value="vendor">Vendor</option>
                                </select>
                               </div>

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact'); ?></label>
                                <div class="d-flex">
                                  <select class="form-select" name="country_code" id="country_code" style="width:35%;">
                                    <?php foreach (countries_array(company($user['id'])) as $ct): ?>
                                        <option value="<?= $ct['country_code'] ?>" <?php if (get_company_data($user['company_id'],'country')==$ct['country_name']){ echo "selected";} ?>><?= $ct['country_code'] ?> - <?= $ct['country_name'] ?></option>
                                    <?php endforeach ?>
                                  </select>
                                  <input type="text" class="form-control modal_inpu" name="phone" id="phone" required>
                                </div>
                               </div>
                               
                               <div class="form-group col-md-6 mb-3 d-none">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Website'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="website" id="website">
                               </div>

                             

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-5" class="modal_lab">
                                  <?php if (get_company_data($user['company_id'],'country')=='India'):?>
                                    <?= langg(get_setting(company($user['id']),'language'),'GSTIN'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                                  <?php endif; ?>
                                </label>
                                 
                                 <input type="text" class="form-control modal_inpu" name="gstno" id="gst_input" value="" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$">
                               </div>

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-5" class="modal_lab">
                                  <?php if (get_company_data($user['company_id'],'country')=='India'):?>
                                    <?= langg(get_setting(company($user['id']),'language'),'State'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'Governorate'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'Emirates'); ?>
                                  <?php endif; ?>
                                </label>
                                 
                                 <div class="position-relative" id="layerer">
                                     
                                      <select class="form-select modal_inpu" name="billing_state" id="state_select_box" required>
                                          <option value="">Choose</option>
                                          <?php foreach (states_array(company($user['id'])) as $st): ?>
                                              <option value="<?= $st ?>" ><?= $st ?></option>
                                          <?php endforeach ?>
                                      </select>
                                  </div>
                               </div>

                               <div class="form-group col-md-4 mb-2">
                                   <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                              
                                  <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="opening_balance">
                                </div>


                                <div class="form-group col-md-4 ">
                                    <label>Type</label>
                                  <select class="form-control" name="opening_type" id="opening_type">
                                      <option value="">To Collect</option>
                                      <option value="-">To Pay</option>
                                  </select>

                                </div>

                                <div class="col-md-4">
                                   <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Credit limit'); ?></label>
                              
                                  <input type="number" min="0" step="any" value="0" class="form-control " name="credit_limit" id="credit_limit">
                                </div>

                               <div class="form-group col-md-12">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address'); ?></label>
                                <textarea class="form-control modal_inpu" name="billing_address" id="billing_address" cols="5"></textarea>
                               </div>

                               <div id="errrr" class="form-group col-md-12 text-danger"></div>


                              
                        </div>
                      </div>
                    
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                      <button type="button" class="btn btn-primary" name="add_customer" data-action="<?= base_url('customers/save_customer'); ?>" id="add_customer_ajax"><?= langg(get_setting(company($user['id']),'language'),'Save Customer'); ?></button>
                    </div>
                  </form>
                  <!-- //////////////FORMMMMM/////////////////// -->
              </div>
            </div>
          </div>
        </div>
      </div>




      <div class="modal fade" id="addnewproduct"  aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">New item</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <div id="add_product_form_container_createinvoice"></div>

              </div>
            </div>
          </div>
        </div>
    <!-- ///////////////////////////////   FORM  EXLUDED MODALS //////////////////////////////// -->
</body>

<input type="hidden" id="currency_symbol" value="<?= currency_symbol($user['company_id']); ?>">

<input type="hidden" id="loc" value="<?= get_setting(company($user['id']),'loc'); ?>">
<input type="hidden" id="base_url" value="<?= base_url(); ?>/"> 
 <input type="hidden" id="round_of_value" value="<?= get_setting(company($user['id']),'round_of_value'); ?>">
<input type="hidden" id="thermalcheck" value="<?= get_setting(company($user['id']),'print_thermal'); ?>">

<input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
  
<input type="hidden" id="silent" value="<?= printer_data($user['id'],'silent') ?>">
<input type="hidden" id="printer_name" value="<?= printer_data($user['id'],'printer_name') ?>">
<input type="hidden" id="top" value="<?= printer_data($user['id'],'top') ?>">
<input type="hidden" id="right" value="<?= printer_data($user['id'],'right') ?>">
<input type="hidden" id="bottom" value="<?= printer_data($user['id'],'bottom') ?>">
<input type="hidden" id="left" value="<?= printer_data($user['id'],'left') ?>">
<input type="hidden" id="scale" value="<?= printer_data($user['id'],'scale') ?>">

<script src="<?= base_url('public'); ?>/js/sweetalert2.min.js"></script>
    

<?php if (has_sticky(company($user['id']))): ?> 
<?php else: ?> 
<?php endif; ?>
<?php 
    $uri = new \CodeIgniter\HTTP\URI(str_replace('/index.php','',current_url()));
 ?>

    
<div id="sidebar">  
  <div class="list"> 
       
        <?php 
            foreach (menus_array($user['id'],$user['u_type']) as $side_item) {
                if (!isset($side_item['condition']) || $side_item['condition']) {
        ?>
            <div class="item" onclick="location.href='<?= $side_item["url"] ?>'">
                <img src="<?= $side_item['icon'] ?>" class=" my-auto me-2">
                <?= $side_item['title'] ?>
            </div> 
        <?php
                }
            } 
        ?> 
  </div>  
  <?php if ($uri->getTotalSegments()>=sn2()): ?>
      <div class="main_menu_toggler" onclick="toggleSidebar()">
          Main Menu 
      </div>
  <?php endif ?>
         
 
</div>  
    
 <script type="text/javascript">
    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle('active');
    }

    function updateWidth(input) {
      // Reset the width to auto to recalculate the content-based width
      input.style.width = 'auto';
      // Then set the width to the scrollWidth (actual width of the content)
      input.style.width = input.scrollWidth + 'px';
    }

</script>   
        
<input type="hidden" value="<?= get_setting(company($user['id']),'printer1'); ?>" id="installedPrinterName">
   <script src="<?= base_url('public/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('public'); ?>/js/pos_print.js?v=<?= script_version(); ?>"></script>

<script src="<?= base_url('public/js/invoice.js'); ?>?v=<?= script_version(); ?>"></script>
<?php if (SLEEP_MODE==true): ?>
 <script type="text/javascript">
    setInterval(function(){
                location.href="<?= base_url('sleep_mode') ?>?red=<?= str_replace('/index.php', '', 'users/logout') ?>"
            },1800000)
 </script>
 <?php endif ?>