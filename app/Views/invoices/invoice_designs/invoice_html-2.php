

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="<?= $css_url ?>">
  <title><?= $title ?></title>
  <style type="text/css">
    html,body {
      height: 100%;
      width: 100%;
      margin: 0; 
      padding: 20px;
    }

    .outer {
      display: flex;
      flex-flow: column;
      height: 100%;
    }

    .inner_remaining { 
      flex-grow: 1;
    }

    .mytab {
      width: 100%;
      height: 100%;
    }

    th {
      border: 1px solid black;
    }

    p{
      font-size: 15px;
      color: black;
      font-weight: 400;
    }
    .new_pad td{
/*      font-size: 13px;*/
      padding: 6px;
    }
    .foot_table td{
      font-weight: 400;

    }
 </style> 
</head>
<body>
<?php
 
$first_row_fixed = 12;

$totalColumnsCount = 12;


if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_batch_no') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--;
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_hsncode_no') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--;
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_expiry_date') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--;  
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_quantity') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--; 
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_uom') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--; 
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_price') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--;
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_tax') != 1) {
    $totalColumnsCount -= 2; // Adjust for two columns related to tax
    $first_row_fixed-=2;
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_discount') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--;   
}
if (get_invoicesetting($invoice_data['company_id'], $invoice_data['invoice_type'], 'show_amount') != 1) {
    $totalColumnsCount--;
    $first_row_fixed--;
}


?>


  <div class="outer">
    <div class="inner_remaining">
      <table class="mytab">
        <thead>
          <tr>
            <th colspan="<?= $first_row_fixed ?>" style="border: 0;">
              
              <div class="d-flex ">
                <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?> 
                <div>
                  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_name')==1): ?>
                  <h5 class="aitsun-fw-bold"><?= my_company_name($invoice_data['company_id']); ?></h5>
                  <?php endif ?>
                  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_address')==1): ?>
                  <p style="margin:0;" class="fw-normal">
                    <?php if (!empty($cmp['city'])): ?>
                      <?= $cmp['city']; ?>,
                    <?php endif ?>
                    <?php if (!empty($cmp['state'])): ?>
                      <?= $cmp['state']; ?>, 
                    <?php endif ?>
                    <?php if (!empty($cmp['country'])): ?>
                      <?= $cmp['country']; ?><br>
                    <?php endif ?>
                    <?php if (!empty($cmp['postal_code'])): ?>
                      Pin: <?= $cmp['postal_code']; ?>,<br>
                    <?php endif ?>
                    <?php if (!empty($cmp['company_phone'])): ?>
                      Mob: <?= $cmp['company_phone']; ?>,<br>
                    <?php endif ?>
                    <?php if (!empty($cmp['company_telephone'])): ?>
                      Land: <?= $cmp['company_telephone']; ?><br>
                    <?php endif ?>
                  </p>
                  <?php endif ?>
                  <?php if (!empty($cmp['gstin_vat_no'])): ?>
                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_details')==1): ?>
                      <p style="margin:0;" class="fw-normal">
                        <b>GSTIN: 
                          <?= $cmp['gstin_vat_no']; ?>
                        </b>
                      </p>
                   <?php endif ?>

                  <?php endif ?>
                </div>
                <?php } ?>
                <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_logo')==1): ?>
                <div class="ms-auto">
                  <img src="<?= base_url(); ?>/public/images/company_docs/<?php if(my_company_logo($invoice_data['company_id']) != ''){echo my_company_logo($invoice_data['company_id']); }else{ echo 'company.png';} ?>" style="height: 127px;">
                </div>
                <?php endif ?>
              </div>

              <div class="text-center p-3">
                <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
                  <h3 style="margin:0;" class="aitsun-fw-bold">
                    <b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']); ?></b>
                  </h3>
                  <!-- product <= $i ?> -->
                <?php endif ?>
              </div>

              <div class="d-flex justify-content-between mb-2">
                <div class="">
                 <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
                  <div>
                    <h5 class="aitsun-fw-bold mb-2" style="margin:0; font-size: 16px;">
                      <?= langg(get_setting($invoice_data['company_id'],'language'),'Party Name:'); ?></h5>
                  </div>
                   <?php endif ?> 

                  <p style="margin:0;" class="fw-normal"> 
                    
                    <?php if ($invoice_data['customer']!='CASH'): ?>
                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
                        <?=  user_name($invoice_data['customer']); ?> 

                      <?php if (!empty(gst_no_of($invoice_data['customer']))): ?><br>
                        <?= langg(get_setting($invoice_data['company_id'],'language'),'GST No'); ?>: <?= gst_no_of($invoice_data['customer']); ?> <br>
                      <?php endif ?>  
                      <?php endif ?> 
                    
                      <?php elseif ($invoice_data['alternate_name']==''): ?>
                        <?= langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER'); ?>
                      <?php else: ?>
                        <?= $invoice_data['alternate_name']; ?>
                      <?php endif ?>
                    

                    <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
                      <?= billing_address_of($invoice_data['customer']) ?>
                      <?php endif ?>
                    <?php endif ?>
                  </p> 

                </div>

                <div class=" text-end fs-6" style="font-size: 16px">
                  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_num')==1): ?>
                  <p class="mb-0"><b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']); ?> #:
                  <?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?></b></p>
                   <?php endif ?> 
                   
                   <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_date')==1): ?>
                  <p class="mb-0 fw-normal"><?= langg(get_setting($invoice_data['company_id'],'language'),'Date'); ?>:
                  <?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?></p>
                  
                  <p class="mb-0 fw-normal"><?= langg(get_setting($invoice_data['company_id'],'language'),'Time'); ?>:
                  <?= get_date_format($invoice_data['created_at'],'H:i:s'); ?></p>
                  <?php endif ?> 
                  
                  <?php if (!empty(trim($invoice_data['vehicle_number']))): ?>
                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_vehicle_number')==1): ?>
                    <b>VEHICLE NO :</b>
                    <?= strtoupper($invoice_data['vehicle_number']); ?>
                  <?php endif ?>
                  <?php endif ?> 

                  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_due_date')==1): ?>
                  <p class="fw-normal"><?= langg(get_setting($invoice_data['company_id'],'language'),'Due Date'); ?>:
                    <span class="fw-normal" style="background-color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>; color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>!important;">
                      <?php
                      $Date = $invoice_data['invoice_date'];
                      ?>
                       <?= date('d M Y',strtotime($Date. ' + 7 days')); ?>
                    </span>
                  </p>
                  <?php endif ?>


                  <?php if ($invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_order' || $invoice_data['invoice_type']=='purchase_quotation' || $invoice_data['invoice_type']=='purchase_return' || $invoice_data['invoice_type']=='purchase_delivery_note'): ?>
                    <?= langg(get_setting($invoice_data['company_id'],'language'),'BILL NO'); ?>
                    <?php if (!empty($invoice_data['bill_number'])): ?>
                      <?= $invoice_data['bill_number']; ?>
                    <?php else: ?>
                      ---
                    <?php endif; ?>
                  <?php endif; ?>         
                </div>
              </div>
            </th>
          </tr>
        </thead>

<tbody>
  <tr style="border: 1px solid;">
    <td style="border-right:1px solid black; padding: 3px 0; text-align: center;width: 60px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'S.No'); ?></b>
    </td>
    <td style="border-right:1px solid black;padding: 3px 0; text-align: center;width: 30%;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Particulars'); ?></b>
    </td>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Batch No'); ?>. </b>
      </td>
    <?php endif ?>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;min-width: 80px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'HSN Code'); ?>. </b>
      </td>
    <?php endif ?>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Exp'); ?>. </b>
      </td>
    <?php endif ?>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Qty'); ?></b>
      </td>
    <?php endif ?>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'UOM'); ?></b>
      </td>
    <?php endif ?>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Rate'); ?></b>
      </td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
      <!-- <td style="border-right:1px solid black; padding: 3px 0; text-align: center; min-width: 100px;" class="<php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><= langg(get_setting($invoice_data['company_id'],'language'),'Rate <br>(Incl. of Tax)'); ?></b>
      </td> -->
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'GST'); ?>.(%)</b>
      </td>
    <?php endif ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td style="border-right:1px solid black; padding: 3px 0; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?></b>
        </td>
      <?php endif ?>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
    <td style="padding: 3px 0; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Amount'); ?></b>
    </td>
    <?php endif; ?>
  </tr>

  <?php $taxcount=0; $slno=0; $current = 0; $count = count(invoice_items_array($invoice_data['id'])); foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; $current++;?> 
  <tr style="border-right: 1px solid;border-left: 1px solid;" class="new_pad" <?php if ($current == $count) {?> height="100%" <?php } ?> >
    <td valign="baseline" style="border-right:1px solid black; text-align: center;"><?= $slno; ?></td>
    <td valign="baseline" style="border-right:1px solid black; font-size: 14px;">
      <?= $ii['product'] ; ?><br>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_pro_desc')==1): ?>
      <small><?= nl2br($ii['desc']) ?></small>   
      <?php endif; ?>
      <?php if (has_show_item($invoice_data['company_id'])): ?>
        <?php foreach (item_kits_array_for_show($ii['product_id'],$invoice_data['id']) as $iti): ?>
          <small class="d-block">
            <?= $iti['product']; ?> <?= $iti['quantity']; ?> <?= unit_name(unit_of_product($iti['product_id'])); ?> 
          </small>
        <?php endforeach ?>
      <?php endif; ?>
    </td>
         
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
      <td valign="baseline" style="border-right:1px solid black; "><?= batch_no($ii['product_id']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td valign="baseline" style="border-right:1px solid black;  text-align: right;"><?= pro_identy($ii['product_id']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
      <td valign="baseline" style="border-right:1px solid black; "><?= expiry_date($ii['product_id']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td valign="baseline" style="border-right:1px solid black; text-align: right;"><?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
      <td valign="baseline" style="border-right:1px solid black;  text-align: right;"><?= unit_name($ii['in_unit']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= $ii['price']; ?></td>
    <?php endif ?>

    <?php 
      if ($ii['split_tax']==1) {
        $inc_taxxxx=($ii['amount'])*invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])/100; 
        $inc_taxxxx=($inc_taxxxx/$ii['quantity'])+$ii['price'];
      }else{
        $inc_taxxxx=($ii['price'])*invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])/100; 
        $inc_taxxxx=$inc_taxxxx+$ii['price'];
      } 
    ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
      <!-- <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><= $inc_taxxxx; ?></td> -->
      <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= invoice_percent_of_tax($ii['tax'],$invoice_data['company_id']); ?>%</td>
    <?php endif ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= $ii['discount']; ?></td>
      <?php endif ?>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
    <td valign="baseline" style="text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= $ii['price']*$ii['quantity']; ?></td>
    <?php endif; ?>
  </tr>
  <?php endforeach ?>


  <tr style="border-top: 1px solid;">
    <th colspan="<?= $first_row_fixed ?>" style="border: 0;">
      
      <div class="d-flex ">
        
        <div class="my-auto" style="width:50%">
          <div class="  <?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'display:none;';} ?>">
            <h6 style="font-size: 16px;margin-bottom: 0.5rem!important; margin: 0; color: black;"><b>Amt In Words : </b></h6>
            <p style="margin: 0px;" class="text-capitalize">
              <?= currency_symbol2($invoice_data['company_id']); ?> <?= amount_in_words(round($invoice_data['total'])); ?>
            </p> 
          </div>
          <div class="">
            <?php if (!empty($invoice_data['notes'])){ ?>
              <h6 class="p-0" style="color: black;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Note'); ?> :</b></h6>
              <p class="m-0" style="width: 100%; max-width: 330px;">
                <?= $invoice_data['notes']; ?>  
              </p>
            <?php }else{echo "";} ?>
          </div> 
        </div>
    
        
        <div style="width:50%">
        <table class="w-100 foot_table mt-4 <?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>" style="color: black;">
        <tr class="text-right" style="border: 1px solid;">
          <td class="" style="border-right: 0;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Subtotal'); ?> :</td>

          <td class="px-2" style="border-left: 0;"> <span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
        
            <?= round($invoice_data['sub_total']-$invoice_data['tax'],2,PHP_ROUND_HALF_UP); ?>
          </td>
        </tr>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
        <!-- <tr class="text-right" style="border: 1px solid;">
          <td class="" style="border-right: 0;"><= langg(get_setting($invoice_data['company_id'],'language'),'Subtotal with Tax'); ?> :</td>
          <td class="px-2" style="border-left: 0;"> <span style="font-family: DejaVu Sans; font-size: 14px;"><= currency_symbol($invoice_data['company_id']); ?></span>?= $invoice_data['sub_total']; ?></td>
        </tr> -->

        
          <tr class="text-right" style="border:1px solid black;">
            <td class="" style="border-right: 0;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Taxable Amount'); ?> :</td>
            <td  class="px-2" style="border-left: 0;">
              <ul class="tax_list mb-0">
                <?php if ($invoice_data['tax']>0): ?>
                  <li style="list-style: none;"><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= round($invoice_data['tax'],2,PHP_ROUND_HALF_UP); ?></li>
                <?php else: ?>
                  <li style="list-style: none;"><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>0</li>
                <?php endif ?>
              </ul>
            </td>
          </tr>
          <?php $ttot=0; foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>
            <?php if (!empty($tds['tax_name'])): ?>
              <tr class="text-right" style="border:1px solid black;">
                <td class="" style="border-right: 0;"><?= $tds['tax_name']; ?> :</td>
                <td class="px-2" style="border-left: 0;">
                  <ul class="tax_list mb-0" > 
                      <li style="list-style: none;"> <span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= $tds['tax_amount']; ?> </li>
                  </ul>
                </td>
              </tr>
            <?php endif ?>
          <?php endforeach ?>
        <?php endif ?>

        <?php if ($invoice_data['order_type']==''): ?>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
            <tr class="text-right" style="border:1px solid black;">
              <td class="pr-2 dl-none " style="border-right: 0;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?> :</td>
              <td class="text-right px-2 dl-none" style="border-left: 0;"><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= $invoice_data['discount']; ?></td>
            </tr>
          <?php endif ?>
        <?php endif ?>

        <?php if ($invoice_data['transport_charge']>0): ?>
          <tr style="text-align:right; border:1px solid black;">
            <td><?= langg(get_setting($invoice_data['company_id'],'language'),'Transport Charge'); ?> :</td>
            <td><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
              <?= round($invoice_data['transport_charge'],2); ?> 
            </td>
          </tr>
          <?php endif ?>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>
        <tr class="text-right" style=" border:1px solid black; ">
          <td style="border-right: 0;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Round off'); ?> :</td>
          <td class="px-2" style="border-left: 0;"><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>

              <?php if ($invoice_data['round_off']>0): ?>
                  <?php if ($invoice_data['round_type']=='add'): ?>
                    + <?= number_format(round($invoice_data['total'])-$invoice_data['total'],2)+$invoice_data['round_off']; ?>
                  <?php else: ?>
                    - <?= number_format(round($invoice_data['total'])-$invoice_data['total'],2)+$invoice_data['round_off']; ?>
                  <?php endif ?>
              <?php else: ?>
                <?= number_format(round($invoice_data['total'])-$invoice_data['total'],2); ?>
              <?php endif ?>
            
          </td>
        </tr>
        <?php endif ?>

        <tr class="text-right" style=" border:1px solid black; background-color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>; color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>!important;">
          <td style="border-right: 0;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Total'); ?> :</b></td>
          <td class="px-2" style="border-left: 0;"><b><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= round($invoice_data['total']); ?></b></td>
        </tr>

        <?php if ($invoice_data['paid_status']=='unpaid'): ?>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'due_amount')==1): ?>
        <tr class="text-right" style="border:1px solid black;">
          <td style="border-right: 0;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Due Amount'); ?> :</td>
          <td class="px-2" style="border-left: 0;">
            <span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= number_format($invoice_data['due_amount'],2); ?>
          </td>
        </tr>
         <?php endif ?>
        <?php endif ?>

        <?php if (trim(mode_of_payment($invoice_data['company_id'],$invoice_data['id']))!=''): ?>
        <tr class="text-right" style="border:1px solid black;">
          
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'mode_of_payment')==1): ?>
          <td style="border-right: 0;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Mode of Payment'); ?> :</td>
          <td class="px-2" style="border-left: 0;">
            <?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_return'): ?>
              <?= mode_of_payment($invoice_data['company_id'],$invoice_data['id']); ?>
            <?php else: ?>
              ---
            <?php endif ?>
          </td>
          <?php endif ?>
        </tr>
        <?php endif ?>
      </table>
    </div>
      </div>
    </th>
  </tr>

</tbody>

<tfoot>
  <tr>
    <th colspan="<?= $first_row_fixed ?>" style="border: 0;">

      <div class="d-flex justify-content-between mb-2">
        <div class="">
         
          <div class="" ><?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_declaration')==1): ?>

            <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration'))){ ?>
              <div class="mt-5 ">
                 <h5 style="margin-bottom: 0.5rem;color: black;; margin-top: 5px; font-size: 16px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Invoice Declaration'); ?> :</b></h5>
                  <p style="margin:0;font-size: 14px;">                     
                      <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration')); ?>
                  </p>
              </div>
            <?php }else{echo "";} ?>
             <?php endif ?> 

             <div class="d-flex justify-content-between">
               <div>
                 <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details'))){ ?>
                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bank_details')==1): ?>
                  <div class="mt-4">
                    
                    <h6 style="margin-bottom: 0.5rem;color: black; margin-top: 5px; font-size: 16px;"><b>Company Details :</b></h6>
                    <p style="margin:0;">         
                        <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details')); ?>
                    </p>
                    
                  </div>
                  <?php endif ?> 
                  <?php }else{echo "";} ?>
               </div>
               <div class="text-end my-auto">
                 <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'))){ ?>
                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_qr_code')==1): ?>
                  
                    
                   <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'); ?>"  style="width: 120px; object-fit: contain;">
                    
                  
                  <?php endif ?> 
                  <?php }else{echo "";} ?>
               </div>
             </div>
             

            <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms'))){ ?>
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_terms')==1): ?>
              <div class="mt-4 ">
                <h5 style="margin-bottom: 0.5rem;color: black; margin-top: 5px; font-size: 16px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Terms & Conditions'); ?> :</b></h5>
                <p style="margin:0;font-size: 14px;">                     
                    <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms')); ?>
                </p>  
              </div>
            <?php endif ?> 
            <?php }else{echo "";} ?>
            </div>
            

        </div>

        <div class=" text-end my-auto fs-6" style="font-size: 16px">
         
            <div class="">
              <h5 style="font-size:16px; margin-bottom: 0; margin-top: 12px; color:black;"><b>For, <?= my_company_name($invoice_data['company_id']); ?></b>
              </h5>
              <br>



              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_seal')==1): ?>
                <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'))): ?>
                  <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'); ?>"  style="width: 90px; object-fit: contain;">
                <?php endif ?>
                <?php endif ?>
               <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')==1): ?>
                <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'))): ?>
                  <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'); ?>" style="width:90px; height: auto; object-fit: contain;">
                <?php endif ?>  
                
                <?php endif ?> 
                <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_seal')!=1): ?>
                  <p style="height:100px"></p>
                <?php elseif (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')!=1): ?>
                  <p style="height:100px"></p>
                <?php else: ?>
                  <?php endif ?>
                <p style="margin-bottom: 0; margin-top: 0;">--------------------------------</p>
                <h5 style="margin: 0; font-size:16px;"><b>Authorised Signatory</b></h5>
              
             </div>

       
        </div>
      </div>
    </th>
  </tr>







        <tr>
          <td colspan="<?= $first_row_fixed ?>" class="pt-3 pb-10 text-center" style="border: 0;">
            <p class="mb-4 text-muted"><?= langg(get_setting($invoice_data['company_id'],'language'),'If you have any questions about this, please contact'); ?><br>
              <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?>
                <span style="color:black;"><?= $cmp['company_name']; ?></span>, <?= langg(get_setting($invoice_data['company_id'],'language'),'phone'); ?>: <span style="color: black;"><?= $cmp['company_phone']; ?></span>, <?= langg(get_setting($invoice_data['company_id'],'language'),'email'); ?>: <span style="color: black;"><?= $cmp['email']; ?></span>
              <?php } ?>
            </p> 
          </td>
        </tr>

<?php if (is_payment_method($invoice_data['company_id'])): ?>
  <tr>
    <td colspan="<?= $first_row_fixed ?>" class="pb-10 text-center" style="border: 0;">
      <h4 class="mb-4" style="color:#00000073; font-size: 12px;">
              <b>This Document is Generated by <a style="color:#e54a4a;" href="https://www.aitsun.com/">Aitsun ERP</a>.</b>
            </h4> 
    </td>
  </tr>
<?php endif ?> 

      </tfoot>
      
    </table>
  </div>

</div>

</body>
</html>