<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add voucher entries</title>
  <link rel="icon" href="<?= base_url('public'); ?>/images/app_icon.ico" type="image/png" />
  <link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/invoice.css'); ?>?ver=<?= style_version(); ?>">
  <link href="<?= base_url('public'); ?>/css/icons.css" rel="stylesheet">
 
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/voucher.css'); ?>?ver=<?= style_version(); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/custom.css'); ?>?ver=<?= style_version(); ?>">
   <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/sweetalert2.min.css') ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style type="text/css">.bg-no{background: transparent!important;} .bg-no .row{padding: 0!important;}</style>
</head>
<body style="overflow: hidden;">
    <div class="invoice_container">

      <form id="invoice_form" method="post" action="<?php if ($view_method=='edit'): ?><?= base_url('voucher_entries/update_voucher'); ?>/<?= $in_data['id']; ?><?php else: ?><?= base_url('voucher_entries/insert_voucher') ?><?php endif ?>">
        <?= csrf_field(); ?>


              <!-- ///////////////////////// SOME INITIALIZATION //////////////////////////////////////// -->
                  <?php if ($view_method=='edit'): ?>
                    <input type="hidden" name="paaid" value="<?= $in_data['total']; ?>">
                  <?php endif ?>

                  <input type="hidden" name="voucher_type" value="<?= $voucher_type; ?>" id="voucher_type">
                  <input type="hidden" name="view_method" value="<?= $view_method; ?>" id="view_method">

                  <?php if ($view_method=='convert'): ?>
                    <input type="hidden" name="convertfrom" value="<?= $in_data['voucher_type']; ?>" id="convertfrom">
                  <?php endif ?>

                  <input type="hidden" id="split_tax" value="<?= get_setting(company($user['id']),'split_tax'); ?>">

                  <input type="hidden" id="focus_element" value="<?= get_setting(company($user['id']),'cursor_position'); ?>">

                  <?php $invoice_type='receipt'; ?>
                   <?php if ($voucher_type=='expense'): ?>
                    <?php $invoice_type='expense'; ?> 
                  <?php endif ?>

                  <input type="hidden" name="invoice_type" id="voucher_voucher_type" value="<?= $voucher_type; ?>">

               <!-- ///////////////////////// SOME INITIALIZATION //////////////////////////////////////// -->

      
      <!-- HEADER SECTION 1 -->
      <div class="d-flex header_section_1 justify-content-between">
         <div class="d-flex">
           <a  class="my-auto go_back_or_close cursor-pointer text-dark btn-new_window">
            <i class="bx bx-arrow-back"></i>
          </a>
          <label class="my-auto d-flex ml-10">
            <div class="mr-2 my-auto">
              <?php if ($view_method=='edit'): ?>
                <?= langg(get_setting(company($user['id']),'language'),'Edit -'); ?> <?= ucfirst($voucher_type); ?> voucher 
              <?php else: ?>
                <?= langg(get_setting(company($user['id']),'language'),'Add -'); ?> 
              <?php endif ?>
            </div>
            
            <?php if ($view_method!='edit'): ?> 
              <?php if ($voucher_type=='expense'): ?> 
                <div class="entry_switcher my-auto">
                  <a href="<?= base_url('voucher_entries/add') ?>" class=""><?= langg(get_setting(company($user['id']),'language'),'Income'); ?></a>
                  <a href="<?= base_url('voucher_entries/add/expense') ?>" class="s_active"><?= langg(get_setting(company($user['id']),'language'),'Expense'); ?></a>
                </div>
              <?php else: ?>
                <div class="entry_switcher">
                  <a href="<?= base_url('voucher_entries/add') ?>" class="s_active"><?= langg(get_setting(company($user['id']),'language'),'Income'); ?></a>
                  <a href="<?= base_url('voucher_entries/add/expense') ?>" class=""><?= langg(get_setting(company($user['id']),'language'),'Expense'); ?></a>
                </div>
              <?php endif ?> 
            <?php endif ?> 

          </label>
         </div>
        <div class="d-flex">

          

          <a data-bs-toggle="modal" data-bs-target="#indate" class="ml-5 cursor-pointer my-auto text-dark <?php if (get_setting(company($user['id']),'allow_receipt_date')==0): echo 'd-none'; endif; ?>" id="invoice_date_label" style="font-size: 12px;">
            <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['voucher_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'d M y'); ?><?php endif ?>
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
      <input type="hidden" name="voucher_type" value="<?php if ($view_method=='convert'): ?><?= $voucher_type; ?><?php else: ?><?= $voucher_type; ?><?php endif ?>">

      <?php 
        if ($voucher_type=='sales'){
          $array_of_customer=customers_array(company($user['id']));
        }else{
          $array_of_customer=vendors_array(company($user['id']));
        }
      ?>

      <?php 
        $from_lead='no_lead';
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
          
        }
      ?>
      <input type="hidden" name="from_lead" value="<?= $from_lead; ?>">
      <input type="hidden" name="stage" value="<?= $from_stage; ?>">
      <!-- ///////////////////////////////////// INITIALIZATION ////////////////////////////////// --> 

      <!-- PRODUCT SELECTION SECTION --> 

      <!-- search product selector -->
      <div class="d-flex header_section_3 position-relative mt-2 justify-content-between d-flex "> 
        <div class="position-relative w-100">
        <input type="text" id="typeandsearch" data-input="name" placeholder="Particulars">
        <div style="position: absolute;right: 14px;top: 6px; color: green;" id="loadbox_name">
          
        </div>
        </div>

        <button type="button" data-bs-toggle="modal" data-bs-target="#add_ledge_form" class="btn btn-sm btn-success ml-5">
          <i class="bx bx-plus"></i>
        </button>
        <div id="tandsproducts"></div>

      </div>
      <!-- PRODUCT SELECTION SECTION -->

      <!-- ledger entry -->
       


        <div class="modal fade" id="add_ledge_form" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add ledger</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <div id="add_ledger_form_container"> 

                </div>

              </div>
            </div>
          </div>
        </div>

          
        <!-- ledger entry -->

      <div class="d-md-flex">
        <!-- PRODUCTS SECTION -->
        <div class="product_section mt-2">
          <ul id="products_table">
            <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>
              <?php foreach ($m_invoices as $m): ?>
                <?php $taxcount=0; foreach (voucher_items_array($m) as $pros): 
                  $product_name=get_group_data($pros['account_name'],'group_head');
                  $product_name.=''.get_group_data($pros['account_name'],'display_name');
                  $productid=$pros['account_name'];
                  $row=$pros['id'];
                  $reference_id=$pros['reference_id'];
                  $description=$pros['payment_note']; 
                  $stock=0;
                  $discoount=0;
                  $discount_percent=0;

                  $quaantity=0;
                  $selling_price=0;
                  $pur_price=0;

                  $sale_tax=0;
                  $purchase_tax=0;


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
 
                  $price=$pros['price']; 
                
                  
                  $amount=$pros['amount'];
                  $pro_unit=0;
                  $pro_tax=0;

                  $tax=0;


                 
                       
                    

                ?>
            <li class="probox mb-2 position-relative productidforcheck<?= $productid; ?> barcode" id="row<?= $row; ?>" data-thisrow="<?= $row; ?>">

                <h6 class="product_name"><?= $product_name; ?></h6>
                
                <input type="hidden" name="p_tax[]" id="pptax<?= $row; ?>" value="<?= $tax; ?>"><input type="hidden" name="product_name[]" value="<?= $product_name; ?>">

                <input type="hidden" name="p_purchase_tax[]" value="0" id="id_purchase_tax_pptax<?= $row; ?>">
                <input type="hidden" name="p_sale_tax[]" value="0" id="id_sale_tax_pptax<?= $row; ?>">
                <input type="hidden" name="old_paid_amount[]" value="<?= $amount; ?>">


                


                <input type="hidden" name="product_id[]" value="<?= $productid; ?>">
                <input type="hidden" name="i_id[]" value="<?= $pros['id']; ?>">

                <div class="d-flex justify-content-between">
                  <div class="my-auto">
                    
                    <input type="hidden" name="split_taxx[]" value="0">
                    Amount:
                    <div class="d-flex"> 
                      <span class="my-auto me-2"><?= currency_symbol($user['company_id']); ?> </span>
                      <input type="number" step="any" class="  price mb-0 form-control form-control-sm"  name="price[]" value="<?= $price; ?>" id="price_bx<?= $row; ?>" data-row="<?= $row; ?>" >
                    </div>
                    <div class="d-none"><span id="tax_hider<?= $row; ?>">Tax: 
                    
                    </span>  <?= currency_symbol($user['company_id']); ?>
                    <input type="hidden" name="p_tax_amount[]" value="0" id="p_tax_box<?= $row; ?>">
                    <span class="tbox" id="taxboxlabel<?= $row; ?>">0</span> <a class="delete_tax text-danger" data-rowid="<?= $row; ?>" data-pricesss="<?= $price; ?>"><i class="bx bxs-x-circle"></i></a>

                    <input type="hidden" step="any" class="numpad control_ro" data-row="<?= $row; ?>" data-product="<?= $productid; ?>" id="taxbox<?= $row; ?>" name="p_tax_percent[]" min="" value="0" readonly></div> 
                  </div> 
                  
                   <div class="d-flex justify-content-between">
                  <div class="my-auto d-flex">
                    <div class="my-auto d-none">
                      
                      <div>
                        <label style="color: #ff1010;">Discount</label>
                        <div class="d-flex">
                          <label style=" margin-top: auto;margin-bottom: auto;margin-right: 5px;margin-left: 5px;">%</label>
                          <input type="number" step="any" class="form-control dis_inp form-control-sm mr-5 numpad discount_percent_input" data-type="percent" data-row="<?= $row; ?>" data-product="<?= $productid; ?>" data-price="<?= $price; ?>" id="discount_percentbox<?= $row; ?>" name="discount_percent[]" placeholder="Discount %" min="0" max="100" value="0">

                          <label style=" margin-top: auto;margin-bottom: auto;margin-right: 5px;margin-left: 5px;"><?= currency_symbol(company($user['id'])) ?></label>
                        <input type="number" step="any" class="form-control dis_inp form-control-sm mr-5 numpad discount_input" data-type="number" data-row="<?= $row; ?>" data-product="<?= $productid; ?>" data-price="<?= $price; ?>" id="discountbox<?= $row; ?>" name="p_discount[]" placeholder="Discount" min="0" value="0">

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

                        <input type="number" class="form-control text-center form-control-sm mb-0 quantity_input numpad"  name="quantity[]" data-row="<?= $row; ?>" data-stock="<?= $stock; ?>" data-price="<?= $price+$discoount; ?>" data-product="<?= $productid; ?>" id="quantity_input<?= $row; ?>"  min="1" value="<?= $pros['quantity'] ?>">

                        <div class="input-group-btn">
                          <button type="button" class="btn border btn-sm qbtn qty_plus" id="qty_plus<?= $row; ?>" data-row="<?= $row; ?>" data-price="<?= $price+$discoount; ?>" data-product="<?= $productid; ?>" data-stock="<?= $stock; ?>">
                            <span class="bx bx-plus"></span>
                          </button>
                        </div>

                      </div>
                    </div> 

                  </div>
                  
                </div>


                

                  <div class="my-auto">
                    <label style="opacity: 0;">Tot</label>
                      <h5 class="m-0 "><span class="text-success"><?= currency_symbol($user['company_id']); ?></span><span id="propricelabel<?= $row; ?>"><?= $amount; ?></span></h5>
                      <input type="hidden" step="any" class="item_total form-control mb-0 control_ro"  name="amount[]" value="<?= $amount; ?>" id="proprice<?= $row; ?>" readonly>
                  </div>


                </div>

                <div class="mt-1">
                  <div class="my-auto">
                    <label style="opacity: 1;">Reference No.</label>
                   
                      <input type="text" step="any" class="w-50 mb-0 form-control form-control-sm"  name="reference_no[]" value="<?= $reference_id; ?>" id="reference_id<?= $row; ?>">
                  </div>
                </div>
               

                <div class="mt-1">
                  <div class="my-auto">
                    <a class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#prodesc<?= $row; ?>">Add Note +</a> 
                  </div>
                    
                    <div id="prodesc<?= $row; ?>" class="collapse">
                      <div class="accordion-body px-0 py-1">
                        <textarea name="product_desc[]" class="keypad textarea_border form-control prodesc" style="border: 1px solid #0000002e;"><?= $description; ?></textarea>

                        <input type="hidden" step="any" name="p_unit[]" id="p_unitbox<?= $row; ?>" value="<?= $pro_unit; ?>">

                      </div>
                    </div>
                  </div>

                  

                <a id="<?= $row; ?>" class="btn text-white pro_btn_remove"><span>+</span></a>

            </li>
                  <?php endforeach ?>                                                       
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

                <div>Sub total: <b>
                    <?= currency_symbol($user['company_id']); ?><span id="subtotal_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']-$taxcount; ?><?php else: ?>0<?php endif; ?></span>

                     <input type="hidden" name="sub_total" id="subtotal" class="form-control text-right control_ro" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php else: ?>0<?php endif; ?>" readonly>
                  </b>
                </div>

                <div class="d-none">
                  <span id="total_taxamt_label_main">0</span>
                </div>

                <div class="d-none">
                  <div class="d-flex justify-content-between w-100"> 
                    <div>

                      <div class="d-flex justify-content-end">

                        <select class="form-select form-select-sm" style="width: 148px;" id="round_type" name="round_type">

                         <option value="add">+ Add </option> 
                          
                        </select>
                        <input type="hidden" step="any" name="round_off" id="round_off" value="0" class="form-control-sm form-control w-25">
                      </div>

                    </div>
                  </div> 
                </div>

              

              </div>
              <div class="my-auto">
                <div class="dl-none">
                  <div>Discount:</div>
                  <div>
                    <b>
                      <input type="text" step="any" class="form-control form-control-sm numpad" name="discount" id="disc_val" min="0" value="0">
                    </b>
                  </div> 
                </div> 
              </div>
            </div>

            <table class="w-100 mt-2">
              <thead>
                  <tr>
                      <td class="bg-success w-50 p-1">
                        <h6><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></h6>
                        <h5 class="mb-0"><?= currency_symbol($user['company_id']); ?><span id="grand_total_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['total'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?></span></h5>
                        <input type="hidden" name="grand_total" id="grand_total" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= aitsun_round($in_data['total'],get_setting(company($user['id']),'round_of_value')); ?><?php else: ?>0<?php endif ?>">
                      </td>
                      <td class="bg-warning w-50 p-1 d-none">
                          <h6><strong><?= langg(get_setting(company($user['id']),'language'),'Due'); ?></strong></h6>
                          <h5 class="mb-0"><?= currency_symbol($user['company_id']); ?><span id="due_amount_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>0<?php else: ?>0<?php endif ?></span></h5>
                          <input type="hidden" name="due_amount" id="due_amount" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>0<?php else: ?>0<?php endif ?>">
                         
                          <input type="hidden" name="old_payment_type" id="old_payment_type" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['payment_type']; ?><?php else: ?>0<?php endif ?>">

                          
                      </td>
                  </tr>
              </thead>
          </table>

           <div class="my-2">
              <label class=""><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
              <select class="form-control payment_select" name="payment_type" id="payment_type" required>
                  <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                      <option value="<?= $ba['id']; ?>"

                        <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>

                          <?php if ($in_data['payment_type']==$ba['id']) {
                            echo "selected";
                          } ?>
                        <?php endif ?>

                        ><?= $ba['group_head']; ?></option>
                  <?php endforeach ?>
              </select>
           </div>

            <div class="d-flex justify-content-between">
              <div class="my-auto">
                <div>Payment: <b id="payment_label">CASH</b></div>
              </div>
              <div class="my-auto">
                <a data-bs-toggle="modal" data-bs-target="#notee" class="cursor-pointer"><i class="bx bx-plus"></i> Add note</a>  
              </div>
            </div>


            <?php 
              if ($view_method=='edit' || $view_method=='copy'){
                $inid=$in_data['id'];
              }elseif ($view_method=='convert') {
                $inid=$inid;
              }elseif ($voucher_type!='sales' && $voucher_type!='sales_return') {
                $inid='';
              }else{
                $inid='';
              }
            ?>
     

          <div id="mess" class=" text-center text-danger w-100"></div>

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
                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['voucher_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'Y-m-d'); ?><?php endif ?>"  >
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
                  <textarea name="notes" class="form-control prodesc mb-2" placeholder="Note"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['notes'] ?><?php endif ?></textarea>
                  <textarea name="private_notes" class="form-control prodesc" placeholder="Private Note"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['private_notes'] ?><?php endif ?></textarea>
                </div>

                <div class="w-100 text-center">
                  <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal" aria-label="Close">OK</button>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="payment"  aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
             
              <div class="modal-body">
                <div class=" px-0 py-1 d-none">
                   <div>
                      <h6 class="mt-4"><?= langg(get_setting(company($user['id']),'language'),'Add taxes'); ?></h6>
                      <div class="taxxess mb-0">
                          <?php foreach (taxarray(company($user['id'])) as $tx_data) { ?>
                          <a class="tax_item col-md-4 text-center"
                           data-taxid="<?= $tx_data['id']; ?>"
                           data-taxname="<?= $tx_data['name']; ?>"
                           data-percent="<?= $tx_data['percent']; ?>"
                          >
                              <?= $tx_data['name']; ?>
                          </a>
                          <?php } ?>

                      </div>
                  </div>

                  <table class="w-100 d-none">
                      <thead>
                          <td><h6><?= langg(get_setting(company($user['id']),'language'),'Discount'); ?></h6></td>
                          <td colspan="2" class="text-right">
                              <h6><?= currency_symbol($user['company_id']); ?><span id="discountval_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>0<?php else: ?>0<?php endif; ?></span></h6>
                              <input type="hidden" name="discount" id="discountval" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>0<?php else: ?>0<?php endif; ?>">
                          </td>
                      </thead>
                  </table>


                  <div class="mb-3">
                      <table class="w-100">
                                      
                        <tbody id="tax_table">


                          <?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>
                            <?php foreach (invoice_taxes_array($inid) as $tx): 
                                $tax_name=$tx['tax_name'];
                                $percent=$tx['tax_percent'];
                                $taxid=$tx['tax_id'];
                                $taxrow=$tx['id'];
                                $tax_amount=$tx['tax_amount'];
                            ?>
                              <tr class="tax_tr" data-taxidentifier="<?= $taxrow; ?>" id="taxrow<?= $taxrow; ?>">
                                <td ><?= $tax_name; ?>(<?= $percent; ?>%)
                                  <input type="hidden" name="tax_id[]" value="<?= $taxid; ?>">
                                  <input type="hidden" name="tax_name[]" value="<?= $tax_name; ?>">
                                  <input type="hidden" name="taxamount[]" id="taxamount<?= $taxrow; ?>" value="<?= $tax_amount; ?>">
                                  <input type="hidden" name="tax_percent[]" id="taxpercent<?= $taxrow; ?>" value="<?= $percent; ?>">
                                </td>
                                <td><span id="taxamountlabel<?= $taxrow; ?>"><?= $tax_amount; ?></span></td>
                                <td> <a id="<?= $taxrow; ?>" class="tax_btn_remove">X</a></td>
                              </tr>
                              <?php endforeach ?>
                          <?php endif ?>



                          <?php foreach (default_taxarray(company($user['id'])) as $tx_data) { ?>
                          <tr class="tax_tr" data-taxidentifier="d<?= $tx_data['id']; ?>" id="taxrowd<?= $tx_data['id']; ?>">
                            <td >
                              <?= $tx_data['name']; ?>
                              <input type="hidden" name="tax_id[]" value="<?= $tx_data['id']; ?>">
                              <input type="hidden" name="tax_name[]" value="<?= $tx_data['name']; ?>">
                              <input type="hidden" name="taxamount[]" id="taxamountd<?= $tx_data['id']; ?>" value="0">
                              <input type="hidden" name="tax_percent[]" id="taxpercentd<?= $tx_data['id']; ?>" value="<?= $tx_data['percent']; ?>">
                            </td>
                            <td><span id="taxamountlabeld<?= $tx_data['id']; ?>">0</span></td>
                            <td> <a id="d<?= $tx_data['id']; ?>" class="tax_btn_remove">X</a></td>
                          </tr>
                          <?php } ?>

                        </tbody>

                    </table>
                    <hr>
                    <table class="w-100">
                        <thead>
                            <td><h6 class="m-0"><?= langg(get_setting(company($user['id']),'language'),'Tax amount'); ?></h6></td>
                            <td colspan="2" class="text-right"><h6 class="m-0"><?= currency_symbol($user['company_id']); ?><span id="total_taxamt_label"><?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>0<?php else: ?>0<?php endif; ?></span></h6>
                                <input type="hidden" name="tax_amount" id="total_taxamt" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?>0<?php else: ?>0<?php endif; ?>">
                            </td>
                        </thead>
                    </table>

                </div>
              </div>



              <?php 
                if ($view_method=='edit'){
                  $classss="d-none";
                }elseif ($view_method=='convert') {
                  $classss="";
                  if ($voucher_type!='sales' &&  $voucher_type!='sales_return' && $voucher_type!='purchase' && $voucher_type!='purchase_return') {
                    $classss="d-none";
                  }
                }elseif ($voucher_type!='sales' &&  $voucher_type!='sales_return' && $voucher_type!='purchase' && $voucher_type!='purchase_return') {
                  $classss="d-none";
                }else{
                  $classss='';
                }
              ?>


             
             <div class="mt-3 <?= $classss; ?>">
                  <div class="form-group mb-3">
                      
                    </div><!-- form-group -->

                    

                    <div id="cash_options" class="">
                        <div class="form-group">
                            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                            <input type="text" min="0" id="cash_input" class="numpad form-control " name="cash_amount" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php endif ?>">
                        </div><!-- form-group -->
                    </div>


                    <div id="cheque_options" class="d-none">
                        <div id="chk_option_container">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. Amt'); ?></label>
                                        <input type="text" min="0" class="numpad form-control " name="cheque_amount[]" id="cheque_input" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php endif ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Chq. No'); ?></label>
                                        <input type="text" class="keypad form-control " name="cheque_no[]">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class=""><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></label>
                                        <input type="date" class="form-control " name="cheque_date[]">
                                    </div>
                                </div>

                            </div>
                        </div>
                       
                    </div>


                    <div id="bank_transfer_options" class="d-none">
                        <label><?= langg(get_setting(company($user['id']),'language'),'Reference Id'); ?></label>
                        <div class="form-group">
                            <input type="text" class="keypad form-control " name="reference_id">
                        </div><!-- form-group -->
                        <label><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                        <div class="form-group">
                            <input type="text" min="0" class="form-control numpad" name="bt_amount" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php endif ?>" id="bt_input">
                        </div><!-- form-group -->
                    </div>
             </div>


             <div class="w-100 text-center">
               <button type="button" class="btn btn-primary mt-3 text-center" data-bs-dismiss="modal" aria-label="Close">OK</button>
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
  <div class="modal-dialog modal-dialog-centered modal-fullscreen" id="remove_style" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Preview'); ?></h5>
        <div>
  



          <!-- <button class="btn-secondary btn-sm thermal_print <php if (print_thermal_show(company($user['id']))){}else{echo 'd-none'; } ?>" data-inv="">
              <span><i class="bx bx-receipt"></i></span>
          </button> -->
          
         

        


           <button type="button" class="btn-sm btn-secondary close_receipt"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        </div>
      </div>

      <div class="modal-body p-0 scroll_none">
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
                  <form method="post" id="add_cust_form" action="<?= base_url('customers'); ?>">
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
                                <input type="text" class="form-control modal_inpu" name="phone" id="phone" required>
                               </div>
                               
                               <div class="form-group col-md-6 mb-3 d-none">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Website'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="website" id="website">
                               </div>

                             

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'GST/VAT No'); ?></label>
                                 
                                 <input type="text" class="form-control modal_inpu" name="gstno" id="gst_input" value="" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$">
                               </div>

                               <div class="form-group col-md-6 mb-3">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'State'); ?></label>
                                 
                                 <div class="position-relative" id="layerer">
                                     
                                      <select class="form-select modal_inpu" name="billing_state" id="state_select_box" required>
                                          <option value="">Choose</option>
                                          <?php foreach (states_array(company($user['id'])) as $st): ?>
                                              <option value="<?= $st ?>" ><?= $st ?></option>
                                          <?php endforeach ?>
                                      </select>
                                  </div>
                               </div>

                               <div class="form-group col-md-8 mb-2">
                                   <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                              
                                  <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="input-5">
                                </div>


                                <div class="form-group col-md-4 ">
                                    <label>Type</label>
                                  <select class="form-control" name="opening_type">
                                      <option value="">To Collect</option>
                                      <option value="-">To Pay</option>
                                  </select>

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
                      <button type="button" class="btn btn-primary" name="add_customer" data-action="<?= base_url('customers'); ?>" id="add_customer_ajax"><?= langg(get_setting(company($user['id']),'language'),'Save Customer'); ?></button>
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

<input type="hidden" id="round_off_value" value="<?= get_setting(company($user['id']),'round_of_value'); ?>">

<input type="hidden" id="currency_symbol" value="<?= currency_symbol($user['company_id']); ?>">

<input type="hidden" id="loc" value="<?= get_setting(company($user['id']),'loc'); ?>"><input type="hidden" id="base_url" value="<?= base_url(); ?>/">
<input type="hidden" id="loc" value="<?= get_setting(company($user['id']),'loc'); ?>"><input type="hidden" id="base_url" value="<?= base_url(); ?>/">
<input type="hidden" id="thermalcheck" value="<?= get_setting(company($user['id']),'print_thermal'); ?>">

<input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>

 
<script src="<?= base_url('public'); ?>/js/bootstrap.min.js"></script>
<script src="<?= base_url('public'); ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('public'); ?>/js/sweetalert2.min.js"></script>

<?php if (has_sticky(company($user['id']))): ?> 
<?php else: ?> 
<?php endif; ?>
 
  <script type="text/javascript" src="<?= base_url('public'); ?>/js/printThis.js?v=<?= script_version(); ?>"></script> 
<input type="hidden" value="<?= get_setting(company($user['id']),'printer1'); ?>" id="installedPrinterName">
 
  <script src="<?= base_url('public'); ?>/js/pos_print.js?v=<?= script_version(); ?>"></script>

<script src="<?= base_url('public/js/voucher.js'); ?>?v=<?= script_version(); ?>"></script>
</html>