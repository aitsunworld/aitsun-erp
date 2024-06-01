<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <link rel="icon" href="<?= base_url('public'); ?>/images/app_icon.ico" type="image/png" />
  <link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/pos.css'); ?>?ver=<?= style_version(); ?>"> 
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/icons.css'); ?>?ver=<?= style_version(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/sweetalert2.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/lobibox.min.css') ?>">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<?php 
$products_array=[];
if (session()->has('pos_session')) {
  $session_data=session()->get('pos_session');
  $products_array=$session_data['products'];
  $customers=$session_data['customers']; 
  $session_id=$session_data['session_id']; 
}


?>
<body class="pos_body"> 

 
<form class="pos_main d-flex" id="invoice_form" method="post" action="<?php if ($view_method=='edit'): ?><?= base_url('sales/update_invoice'); ?>/<?= $in_data['id']; ?><?php elseif($view_method=='convert' || $view_method=='copy'): ?><?= base_url('sales'); ?><?php else: ?><?= base_url('sales') ?><?php endif ?>">
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
               <input type="hidden" id="invoice_type" name="invoice_type" value="<?php if ($view_method=='convert'): ?><?= $convert_to; ?><?php else: ?><?= $invoice_type; ?><?php endif ?>">

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



                  <input type="hidden" id="focus_element" value="<?= get_setting(company($user['id']),'pos_focus_element'); ?>">
                  <input type="hidden" id="barcode_type" value="<?= get_setting(company($user['id']),'barcode_settings'); ?>">

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

                  <input type="hidden" name="alternate_name" placeholder="Party name" id="alternate_name" value="<?= $cus_value; ?>" <?= $disable_value; ?>>

                  <input type="hidden" name="bill_number" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Bill No'); ?>." value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['bill_number']; ?><?php else: ?><?php endif; ?>">

                  <input type="hidden" name="inv_referal" value="0">

                  <input type="hidden" name="mrn_number" class="" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['mrn_number']; ?><?php else: ?> <?php endif; ?>">

                  <input type="hidden" name="validity" value="3">

                  <input type="hidden" name="company_state" value="">
                  <input type="hidden" name="state_of_supply" value="">
                  <input type="hidden" name="additional_discount_percent" value="0">
                  <input type="hidden" name="additional_discount" value="0">
                  <input type="hidden" name="cash_discount_percent" value="0"> 
                  <input type="hidden" name="round_off" value="0"> 
                  <input type="hidden" name="vehicle_number" value=""> 
                  <input type="hidden" name="transport_charge" value="0"> 
                  <input type="hidden" name="discount" value="0">  
                  <input type="hidden" name="round_type" value="add">

                  <input type="hidden" name="session_id" value="<?= $session_id; ?>">
                  <input type="hidden" name="bill_type" value="pos">

                  <input type="date" name="invoice_date" id="invoice_date" class="d-none" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['invoice_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'Y-m-d'); ?><?php endif ?>"  >


               <!-- ///////////////////////// SOME INITIALIZATION //////////////////////////////////////// -->


    <div class="item_selector">
       

       <input type="text" id="productbarcodesearch" placeholder="Scan Barcode" class="barcode_inbox form-control form-control-sm  my-auto">

      <header class="justify-content-between">

        <div class="logo top_buttons">
           <a class="sm_button my-auto me-2" title="Back" href="<?= base_url('invoices/sales') ?>"><i class="bx bx-arrow-back text-dark"></i></a>
          <img src="<?= base_url('public/images/logo-icon.png') ?>">
          <h5>Aitsun POS</h5>

          <div class="ms-3 position-relative search_box">
            <?php 
              $pro_box_class='';
              $co_box_class='d-none';
             
              if (get_setting(company($user['id']),'pos_focus_element')==1){
                $pro_box_class='';
                $co_box_class='d-none';
              }elseif (get_setting(company($user['id']),'pos_focus_element')==2){
                $pro_box_class='d-none';
                $co_box_class='';
              } else{
                $pro_box_class='';
                $co_box_class='d-none';
              }
            ?>
            <input type="text" placeholder="Search item..." class="search_input <?= $pro_box_class ?>" id="product_search_input">
            <input type="number" id="product_code" data-input="code" placeholder="Type Product Code" class=" search_input <?= $co_box_class ?>">
            <i class="bx bx-search"></i>
          </div>
        </div>

        <div class="top_buttons d-flex">

          <div class="my-auto me-2" style="font-size: 14px;">
            <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['invoice_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'D, d M Y'); ?><?php endif ?>
          </div>

         
          <button class="sm_button my-auto me-2" onclick="location.reload();"><i class="bx bx-refresh"></i></button>
          <button class="sm_button my-auto me-2"><i class="text-aitsun bx bx-wifi"></i></button> 

          <button class="big_btn btn btn-dark d-none btn-sm me-2"><i class="bx bx-table"></i> Select table</button>

          <div class="dropdown dropdown-animated my-auto">
            <button class="sm_button " data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>  
            <div class="dropdown-menu" style="">  
             <!--  <a class="dropdown-item href_loader" href="<?= base_url('pos/orders') ?>">  
                <span class="ms-3">Orders</span>
              </a>  --> 
             <!--  <a class="dropdown-item href_loader" href="">
                <span class="ms-3">Cash In/Out</span> 
              </a>   -->
              <a class="dropdown-item href_loader" href="<?= base_url('pos/close_register') ?>">
                <span class="ms-0">Close register</span> 
              </a> 
            </div>
          </div>
        </div>
      </header>

      <div>
        <div class="category_box" id="categoryBox">
          <a class="active" id="resetFilter">All</a> 
          <?php foreach (product_categories_array(company($user['id'])) as $cat): ?> 
            <a class="cat_selector" data-category="<?= $cat['id'] ?>"><?= $cat['cat_name'] ?></a>
          <?php endforeach ?> 
        </div>
      </div>


      <div class="item_box row"> 
        <?php foreach ($products_array as $pro): ?> 
          <div class="col-md-3 item_container barcode_item_<?= $pro['barcode']; ?> product_code_item_<?= $pro['product_code']; ?> " 
          data-category="<?= $pro['category'] ?>"
          data-productid="<?= $pro['id']; ?>" 
          data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>" 
          data-batch_number="<?= $pro['batch_no']; ?>" 
          data-unit="<?= $pro['unit']; ?>" 
          data-price="<?= $pro['price']; ?>"


          data-tax="<?= $pro['tax']; ?>"
          data-tax_name="<?= tax_name($pro['tax']); ?>"
          data-barcode="<?= $pro['barcode']; ?>"

          data-prounit='<?php foreach (products_units_array(company($user['id'])) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

          data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($user['id'])) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

          data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

          data-protax='<?php foreach (tax_array(company($user['id'])) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

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

          data-unit_disabled="readonly"
          data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"
          >
          <div class="item_card">
            <img src="<?php if( $pro['pro_img'] !=''){echo base_url('/public/images/products/').$pro['pro_img']; }else{echo 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaUlEQVR4nO2WOwqAMBAF51wSe4P3v4DrPVYsot3aZFXIG3hlMvDyBTEaK7AD3jkG1EhsCdKWLRJ7cv4nHhP/qmaXmLuFKWiqZFZdgnGz1hjt6gd0jl1XJkmPhL397WnUzvJTulyzi2E4AOgSq5aJBOkvAAAAAElFTkSuQmCC';} ?>">
            <h6 class="product_name text_over_flow_2"><?= $pro['product_name'] ?></h6>
            <div class="price"><?= currency_symbol(company($user['id'])) ?> <?= $pro['price'] ?></div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>

  <input type="hidden" id="customer" name="customer" value="<?= cash_customer_of_company(company($user['id'])) ?>" data-credit_limit="<?= user_data(cash_customer_of_company(company($user['id'])),'credit_limit') ?>" data-closing_balance="<?= user_data(cash_customer_of_company(company($user['id'])),'closing_balance') ?>">

  <div class="biller_container">
    <div class="biller_header">

      <div class="cupad-10">
        <div class="biller_head aitsun-row">
         <div class="col-4 p-1 ps-0 pt-0">
          <a class="bill_button " data-bs-toggle="modal" data-bs-target="#customer_modal" ><span class="d-flex justify-content-center"><i class="bx bx-user me-1 my-auto"></i> <span id="customer_btn" class="text_over_flow_1 my-auto">Customer</span></span></a>
        </div>
        <div class="col-4 p-1 pt-0">
          <a class="bill_button" data-bs-toggle="modal" data-bs-target="#internal_note_modal"><i class="bx bx-notepad"></i> Internal Note</a>
        </div>
        <div class="col-4 p-1 pe-0 d-none pt-0">
          <a class="bill_button"><i class="bx bx-link"></i> Quote/Order</a>
        </div>
        <div class="col-4 p-1  pb-0 pt-0">
          <a class="bill_button" data-bs-toggle="modal" data-bs-target="#customer_note_modal"><i class="bx bx-text"></i> Customer Note</a>
        </div>
        <div class="col-4 p-1 d-none pb-0">
          <a class="bill_button"><i class="bx bx-wifi"></i> Pricelist</a>
        </div>
        <div class="col-4 p-1 d-none pe-0 pb-0">
          <a class="bill_button"><i class="bx bx-shuffle"></i> Refund</a>
        </div>

      </div>
    </div> 
  </div>


  <div class="modal customer_modal fade" id="customer_note_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex">
            <h5 class="modal-title">Customer Note</h5>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">

          <textarea class="form-control" id="customer_note" name="notes" rows="5" placeholder="Start to write..."></textarea>
          <div class="text-center mt-3">
            <button type="button" class="btn btn-primary rounded-pill text-center" data-bs-dismiss="modal" aria-label="Close">Add note</button>
          </div> 
        </div> 
      </div>
    </div>
  </div>


  <div class="modal customer_modal fade" id="internal_note_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex">
            <h5 class="modal-title">Internal Note</h5>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <div class="d-flex justify-content-center">
            <button type="button" class="btn mb-2 mx-1 btn-secondary internal_note_tag" data-order="1">Wait</button>
            <button type="button" class="btn mb-2 mx-1 btn-secondary internal_note_tag" data-order="2">To Serve</button>
            <button type="button" class="btn mb-2 mx-1 btn-secondary internal_note_tag" data-order="3">Emergency</button>
            <button type="button" class="btn mb-2 mx-1 btn-secondary internal_note_tag" data-order="4">No Dressing</button>
          </div>
          <textarea class="form-control" id="internal_note" name="private_notes" rows="5" placeholder="Write/Select tag"></textarea>
          <div class="text-center mt-3">
            <button type="button" class="btn btn-primary rounded-pill text-center" data-bs-dismiss="modal" aria-label="Close">Add note</button>
          </div> 
        </div> 
      </div>
    </div>
  </div>

  <div class="modal customer_modal fade" id="customer_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex">
            <a class="btn btn-danger btn-sm me-2">+ New</a>
            <input type="search" placeholder="Search..." id="searchCustomerInput">
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-start">
          <table class="w-100" id="cus_table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
              <?php $slno=1; foreach ($customers as $cus): $slno++; ?> 
              <tr style="background:<?php echo ($slno % 2 == 0) ? "#f3ecec" : "white"; ?>;" class="customer_row" data-cus_id="<?= $cus['id'] ?>" data-cus_name="<?= $cus['display_name'] ?>" data-credit_limit="<?= $cus['credit_limit'] ?>" data-closing_balance="<?= $cus['closing_balance'] ?>">
                <td><?= $cus['display_name'] ?></td>
                <td>
                  <div><?= $cus['email'] ?></div> 
                  <div><?= $cus['phone'] ?></div> 
                </td>
                <td><?= currency_symbol(company($user['id'])) ?> <?= $cus['closing_balance'] ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="biller_body">
  <div class="bill_panel">
    <ul class="position-relative" id="bill_item_box">

     

      <li class="text-center" id="no_items">No items</li>

    </ul>  
  </div>
</div>


<!-- //////////////////////////hiddenables//////////////////////// --> 
<div class="d-none">Sub total: <b>
  <?= currency_symbol($user['company_id']); ?><span id="subtotal_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_subtotal-$taxcount,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif; ?></span>

  <input type="hidden" name="sub_total" id="subtotal" class="form-control text-right control_ro" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_subtotal,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif; ?>" readonly>
</b>

<h6 class="m-0"><?= currency_symbol($user['company_id']); ?><span id="total_taxamt_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['tax']; ?><?php else: ?>0<?php endif; ?></span></h6>
<input type="hidden" name="tax_amount" id="total_taxamt" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['tax']; ?><?php else: ?>0<?php endif; ?>">

<h5 class="mb-0"><?= currency_symbol($user['company_id']); ?><span id="due_amount_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['due_amount'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></h5>
<input type="hidden" name="due_amount" id="due_amount" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['due_amount'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>">
</div>
<!-- //////////////////////////hiddenables//////////////////////// -->


<div class="biller_footer"> 
  <div class="total_box d-flex justify-content-between">


    <div class="text-muted">Taxes:  
      <?= currency_symbol($user['company_id']); ?><span id="total_taxamt_label_main"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($taxcount,get_setting(company($user['id']),'round_of_value'),PHP_ROUND_HALF_UP); ?><?php else: ?>0<?php endif; ?></span>
    </div>  
    <div>
      <b class="text-success">Total: <?= currency_symbol($user['company_id']); ?><span id="grand_total_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></b>

      <input type="hidden" name="grand_total" id="grand_total" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>">
    </div>


  </div>


  <div class="d-flex">
    <div class="w-100">
      <table class="cal_buttons_table" data-target="pos_items_page">
        <tr>
          <td class="ps-0">
            <div class="pos_key">1</div>
          </td>
          <td>
            <div class="pos_key">2</div>
          </td>
          <td>
            <div class="pos_key">3</div>
          </td>
          <td>

            <div class="target_input <?php if (get_setting(company($user['id']),'pos_focus_element')!=2): ?>active<?php endif ?>" data-target="quantity_input">Qty</div>
          </td> 
          <td>
           <div class="d-flex">
              <?php if (get_setting(company($user['id']),'pos_focus_element')==1): ?> 
                <a class="scan_bar scan_listen" >Scan</a> 
              <?php endif ?>
              <a class="sp_btns mode w-100 change_pos_mode">
                <div class="m-auto ">
                  <div id="mode_btn" class=" my-auto">
                   <span class="">
                      <span class="d-block head_span">
                        <span>Mode</span>
                      </span>
                      <hr class="my-0">
                      <span class="d-block mode_span">
                        <?php if (get_setting(company($user['id']),'pos_focus_element')==1): ?> 
                          Barcode
                        <?php elseif (get_setting(company($user['id']),'pos_focus_element')==2): ?>
                          Product code
                        <?php else: ?>
                          Basic
                        <?php endif ?>
                      </span>
                   </span>
                  </div>
                </div>
              </a>
           </div>
          </td>
        </tr>
        <tr>
          <td class="ps-0">
            <div class="pos_key">4</div>
          </td>
          <td>
            <div class="pos_key">5</div>
          </td>
          <td>
            <div class="pos_key">6</div>
          </td>
          <td>
            <div class="target_input" data-target="discount_percentbox">% Disc</div>
          </td>
          <td>
              <a class="sp_btns hold">
                <div class="m-auto ">
                  <div class="d-flex"><i class="me-1 bx bx-chevron-right-circle"></i>  <span>Hold</span></div>
                </div>
              </a>
          </td>
        </tr>
        <tr>
          <td class="ps-0">
            <div class="pos_key">7</div>
          </td>
          <td>
            <div class="pos_key">8</div>
          </td>
          <td>
            <div class="pos_key">9</div>
          </td>
          <td>
            <div class="target_input" data-target="price_bx">Price</div>
          </td>
          <td rowspan="2">
            <a class="sp_btns payment">
              <div class="m-auto rot">
                <div class="d-flex"><i class="me-1 bx bx-chevron-right-circle"></i>  <span>Payment</span></div>
              </div>
            </a>
          </td>
        </tr>
        <tr>
          <td class="ps-0">
            <div class="pos_key">Clear</div>
          </td>
          <td>
            <div class="pos_key">0</div>
          </td>
          <td>
            <div class="pos_key">.</div>
          </td>
          <td>
            <div class="pos_key"><i class="bx bx-tag"></i></div>
          </td>
        </tr>
      </table>
    </div>

 
  </div>
</div>
</div>







<div class="modal  fade" id="payment_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">

      <div class="payment_dialog">
        <div class="d-flex justify-content-between  py-2" style="background:#f9f5f5; padding-right: 10px; padding-left: 10px;">

          <h4 class="my-auto">Payment</h4>
          <a class="btn btn-secondary btn-sm my-auto d-flex" data-bs-dismiss="modal" aria-label="Close"><i class="bx bx-arrow-back my-auto"></i> <span class="my-auto ms-1">Back</span></a>
        </div>
        <div class="d-flex">
          <div class="payment_method w-50">
           <div class="payment_types">
            <label class="pb-3">Select payment method</label>
            <?php $bcout=0; foreach (bank_accounts_of_account(company($user['id'])) as $ba): $bcout++; ?>
              <div class="pay_box d-flex justify-content-between <?= $bcout==1 ? 'active' :''; ?>" data-pay_id="<?= $ba['id']; ?>" data-target="pay_type_value<?= $ba['id'] ?>">
                <div>
                  <div><?= $ba['group_head']; ?></div>
                  <div class="d-flex">
                    <span class="methods_pay_cur me-1"><?= currency_symbol($user['company_id']); ?></span> 
                    <input type="number" id="pay_type_value<?= $ba['id'] ?>" class="methods_pay_input" name="payment_type_value[]" value="0">
                    <input type="hidden" name="payment_type[]" value="<?= $ba['id']; ?>">
                  </div>
                </div> 
                <a class="my-auto clear_cash"><i class="bx bx-check-circle"></i></a>
              </div> 
            <?php endforeach ?>
          </div>
        </div>
        <div class="w-50">
          <div class="w-100 polebutton_box">
            <div class="pol_display">
              <div class="d-flex justify-content-between mb-4 pol_block">
                <div >
                  <h6>Total:</h6>
                  <div class="due_label text-primary"><?= currency_symbol($user['company_id']); ?><span id="grand_total_label2"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total,get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></div>
                </div>
                <div >
                  <h6>Due amount:</h6>
                  <div class="due_label text-danger"><?= currency_symbol($user['company_id']); ?><span id="due_amount_label2"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['due_amount'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></div>
                </div>
              </div>

              <input type="hidden" name="due_amount" id="due_amount" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['due_amount'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>">

              <div>
                <label>Total paid:</label>
                <div class="d-flex">
                  <div class="disable_layer"></div>
                  <div class="cur_sym pe-3"><?= currency_symbol(company($user['id'])) ?></div>
                  <input type="number" min="0" id="cash_input" class="cash_amount numpad form-control " name="cash_amount" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($indata_total-$indata_due_amount,get_setting(company($user['id']),'round_of_value')); ?><?php endif ?>" placeholder="0">
                </div>
              </div>
            </div>

            <div class="button_table_box">
              <table class="cal_buttons_table">
                <tr>
                  <td class="ps-0">
                    <div class="pos_pay_key">1</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">2</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">3</div>
                  </td>
                  <td>
                    <div class="pos_pay_key_plus">+10</div>
                  </td>
                </tr>
                <tr>
                  <td class="ps-0">
                    <div class="pos_pay_key">4</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">5</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">6</div>
                  </td>
                  <td>
                    <div class="pos_pay_key_plus">+20</div>
                  </td>
                </tr>
                <tr>
                  <td class="ps-0">
                    <div class="pos_pay_key">7</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">8</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">9</div>
                  </td>
                  <td>
                    <div class="pos_pay_key_plus">+50</div>
                  </td>
                </tr>
                <tr>
                  <td class="ps-0">
                    <div class="pos_pay_key">Clear</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">0</div>
                  </td>
                  <td>
                    <div class="pos_pay_key">.</div>
                  </td>
                  <td>
                    <div class="pos_pay_key"><i class="bx bx-tag"></i></div>
                  </td>
                </tr>
              </table>

              <?php 
              $invoice_type ='sales';
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

              <div class="btn-complete-block">
                <button type="button" class="btn w-100 btn-sm btn-complete" data-inid="<?= $inid; ?>" id="submit_invoice" name="save_invoice">Complete</button> 
              </div>

            </div>
          </div>
        </div>
      </div>
    </div> 
  </div>
</div>
</div>


<div class="receipt_dialog d-none" id="receipt_dialog">
  <div class="d-flex">
    <div class="payment_method w-50">
     <div class="payment_types">
      <iframe id="pos_iframe" src=""></iframe>
    </div>
  </div>
    <div class="w-75">
      <div class="w-100 polebutton_box">
        
        <div class="button_table_box"> 

          <div class="btn-complete-block">
            <h4 class="mb-4 text-center">Payment Successful!</h4>

            <button type="button" class="btn w-100 btn-sm btn-pos-print aitsun-electron-print" id="print_pos_btn" 
            data-url="dsfdfds" 
            data-silent="<?= printer_data($user['id'],'silent') ?>"
            data-devicename="<?= printer_data($user['id'],'printer_name') ?>"
            data-top="<?= printer_data($user['id'],'top') ?>"
            data-right="<?= printer_data($user['id'],'right') ?>"
            data-bottom="<?= printer_data($user['id'],'bottom') ?>"
            data-left="<?= printer_data($user['id'],'left') ?>"
            data-scalefactor="<?= printer_data($user['id'],'scale') ?>"

            ><i class="bx bx-printer"></i> Print</button> 

            
            <button type="button" class="btn w-100 btn-sm mt-3 btn-pos-neworder" id="set_new_order"><i class="bx bx-chevron-right-circle"></i> New order</button> 
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>






<!-- /////////////////////////////////////// -->
</form>

<input type="hidden" id="currency_symbol" value="<?= currency_symbol($user['company_id']); ?>">

<input type="hidden" id="loc" value="<?= get_setting(company($user['id']),'loc'); ?>">
<input type="hidden" id="base_url" value="<?= base_url(); ?>/"> 
<input type="hidden" id="round_of_value" value="<?= get_setting(company($user['id']),'round_of_value'); ?>">
<input type="hidden" id="thermalcheck" value="<?= get_setting(company($user['id']),'print_thermal'); ?>">

<input type="hidden" id="view_type" value="sales">
<script src="<?= base_url('public/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('public'); ?>/js/pos.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/keypad.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/pos_print.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/lobibox.min.js"></script>
<script type="text/javascript">
  document.addEventListener('keydown', function(event) {
    if (event.keyCode === 9) { // Tab key code is 9
        event.preventDefault(); // Prevent the default tab action
    }
});

</script>
</body>
</html>