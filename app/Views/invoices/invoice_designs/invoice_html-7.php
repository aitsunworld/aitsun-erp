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
/*     font-size: 13px;*/
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


<?php foreach (my_company($invoice_data['company_id']) as $cmp) { 
    $company_logo=$cmp['company_logo'];
    $company_name=$cmp['company_name'];
    $address=$cmp['address'];
    $city=$cmp['city'];
    $state=$cmp['state'];
    $country=$cmp['country'];
    $postal_code=$cmp['postal_code'];
    $company_phone=$cmp['company_phone'];
    $company_email=$cmp['email'];
    $company_telephone=$cmp['company_telephone'];
    $gstin_vat_no=$cmp['gstin_vat_no']; 
 } ?>




<div class="outer">
  <div class="inner_remaining"> 
  
    <table class="mytab">

      <thead>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_invoice_header')==1): ?>
    <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_invoice_header'))): ?>
    <tr>
      <td colspan="<?= $first_row_fixed ?>" style="padding:0;position: relative;">
        <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_header'))): ?>
          <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_header'); ?>" style="width: 100%;position: absolute;">
        <?php endif ?>
      </td>
    </tr>
    <?php endif ?>
  <?php endif ?> 
          <tr>
          <th colspan="<?= $first_row_fixed ?>" style="border: 0;">
            <div class="text-center p-3" style="margin-top:150px;">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
                <h3 style="margin:0;" class="aitsun-fw-bold">
                  <b><u><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']); ?></u></b>
                </h3>
              <?php endif ?>
            </div>

            <div>
              <h6>Dear Sir,</h6>
              <h6>We would like to submit our invoice for the removal of Sewage from follwing place:</h6>
            </div>
          </th>
        </tr>
      </thead>

    <tbody> 
      
     


  <tr style="border: 1px solid;">
    <td colspan="2">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
        <P class="m-2 mb-0">
          TO: <br>
          <?php if ($invoice_data['customer']!='CASH'): ?>
            <b><?=  user_name($invoice_data['customer']); ?></b>
            <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
              <p  class="m-2 mb-0 mt-0"><b>
                <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
                  <?= nl2br(billing_address_of($invoice_data['customer'])) ?>
                <?php endif ?>
              </p> 
            <?php endif ?> 
           
          <?php elseif ($invoice_data['alternate_name']==''): ?>
            <p class="m-2 mb-0 mt-0">
              <b><?= langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER'); ?></b>
            </p>
          <?php else: ?>
            <p class="m-2 mb-0 mt-0">
              <b><?= $invoice_data['alternate_name']; ?></b>
            </p>
          <?php endif ?>

           <?php if (!empty(gst_no_of($invoice_data['customer']))): ?>
              <p class="m-2 mt-0"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Party VATIN'); ?>: <?= gst_no_of($invoice_data['customer']); ?></b></p>
            <?php endif ?> 
        </P>
      <?php endif ?>
    </td>

    <td style="border-left: 1px solid;" colspan="3" class="m-2">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_num')==1): ?>
        <p class="m-2 mb-0 mt-0">
          <?php if (is_medical($invoice_data['company_id'])): ?>
            <?php if ($invoice_data['invoice_type']=='sales'): ?>
              <b>No:</b>
            <?php else: ?>
              <b>Invoice:</b>
            <?php endif ?>
          <?php else: ?>
            <b>Invoice:</b>
          <?php endif ?>
          <span style="    margin-left: 35px;"><?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?></span>
        </p>
        
        
      <?php endif ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_date')==1): ?>
         <p class="m-2 mb-0 mt-0"><b>Date:</b> <span style="margin-left: 52px;"><?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?></span></p>
      <?php endif ?>
      <p class="m-2 mb-0 mt-0">
        <?php if (!empty($cmp['gstin_vat_no'])): ?>
          <?php if (get_company_data($invoice_data['company_id'],'country')=='India'):?>
            <b>GSTIN: <span style="margin-left: 28px;"><?= $cmp['gstin_vat_no']; ?></span></b>
          <?php else: ?>
            <b>VAT TIN: <span style="margin-left: 28px;"><?= $cmp['gstin_vat_no']; ?></span></b>
          <?php endif ?> 
        <?php endif ?>
      </p>
    </td>
  </tr>


  <tr style="border: 1px solid;">

    <td style="border-right:1px solid black; padding: 3px 0; text-align: center;width: 40px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Sl'); ?></b>
    </td>

    <td style="border-right:1px solid black;padding: 3px 0; text-align: center;width: 50%;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Description'); ?></b>
    </td>
   
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td style="border-right:1px solid black;width: 70px; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Qty'); ?></b>
      </td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'UOM'); ?></b>
      </td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td style="width: 70px;border-right:1px solid black; padding: 3px 0; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Rate'); ?></b>
      </td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
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
    <td style="padding: 3px 0; width: 70px; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Amount'); ?></b>
    </td>
    <?php endif; ?>
  </tr>

  <?php $taxcount=0; $slno=0; $current = 0; $count = count(invoice_items_array($invoice_data['id'])); foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; $current++;?> 
  
    <tr style="border-right: 1px solid;border-left: 1px solid;" class="new_pad" <?php if ($current == $count) {?> height="100%" <?php } ?> >
      <td valign="baseline" style="border-right:1px solid black; text-align: center;"><?= $slno; ?></td>

      <td valign="baseline" style="border-right:1px solid black; font-size: 14px;">
        <b><?= $ii['product'] ; ?></b><br>
        MONTH OF JULY 2024
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
         
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
        <td valign="baseline" style="border-right:1px solid black; text-align: center;"><?= $ii['quantity']; ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
        <td valign="baseline" style="border-right:1px solid black;  text-align: right;"><?= unit_name($ii['in_unit']); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
        <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= aitsun_round($ii['price'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
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
        <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= invoice_percent_of_tax($ii['tax'],$invoice_data['company_id']); ?>%</td>
      <?php endif ?>

      <?php if ($invoice_data['order_type']==''): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
          <td valign="baseline" style="border-right:1px solid black; text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= aitsun_round($ii['discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
        <?php endif ?>
      <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
        <td valign="baseline" style="text-align: right;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= aitsun_round($ii['price']*$ii['quantity'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>

       

      <?php endif; ?>
    </tr>
      <?php endforeach ?>


    <tr style="border-right: 1px solid;border-left: 1px solid;border-top: 1px solid;border-bottom: 0;" >
      <td class="px-2" colspan="4" style="text-align: end;"><b>Total</b></td>
      <td class="px-2"style="border-left: 1px solid;text-align: end;">
            <?= aitsun_round($invoice_data['sub_total']-$invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
      </td>
    </tr>


   

      <?php $ttot=0;foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>
        <?php if (!empty($tds['tax_name'])): ?>
          <tr style="border-right: 1px solid;border-left: 1px solid;border-bottom: 0;">
            <td class="px-2" colspan="4" style="text-align: end;"><?= $tds['tax_name']; ?> :</td>
            <td class="px-2" style="border-left: 1px solid;text-align: end;">
              <?= aitsun_round($tds['tax_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>       
            </td>
          </tr>
        <?php endif ?>  
      <?php endforeach ?> 

      <?php if (get_company_data($invoice_data['company_id'],'country')!='Oman'):?>
        <tr nobr="true">
          <td class="px-2" colspan="4" style="text-align: end;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Taxable Amount'); ?> :</td>
          <td class="px-2" style="border-left: 1px solid;border-right: 1px solid;text-align: end;">
            <?php if ($invoice_data['tax']>0): ?>
              <span style="font-family: DejaVu Sans; ">
              <?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
            <?php else: ?>
              <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?>0</span>
            <?php endif ?>
          </td>
        </tr>
      <?php endif ?>




    <tr style="border-right: 1px solid;border-left: 1px solid;">
      <td class="px-2" colspan="4" style="text-align: end;"><b>Invoice Amount</b></td>
      <td class="px-2" style="border-left: 1px solid;border-top: 1px solid;text-align: end; "> 
                 <?= aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
      </td>
    </tr>


  <tr style="border-top: 1px solid;">
    <th colspan="<?= $first_row_fixed ?>" style="border: 0;">
        <div class="my-auto" style="width:100%">
          <div class="  <?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'display:none;';} ?>">
            <p style="margin: 0px;" class="text-capitalize"> <?= currency_symbol2($invoice_data['company_id']); ?> <?= ucwords(numberTowords(aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')),$invoice_data['company_id'])); ?>.
            </p> 
          </div>
        </div>
    </th>
  </tr>

</tbody>

<tfoot>
  <tr>
    <th colspan="<?= $first_row_fixed ?>" style="border: 0;">   
      <div class=" text-start my-auto fs-6" style="font-size: 16px">

        <div class="">
          <p style="margin-top: 12px;">We Kindly request you to release the above payment as soon as possible.</p>

          <h6 style="font-size:16px; margin-bottom: 0; margin-top: 12px; color:black;"><b>
            Thanking you,</b>
          </h6>

          <h6 style="font-size:16px; margin-bottom: 0; margin-top: 0; color:black;"><b>
            Yours faithfully,</b>
          </h6>

          <h5 style="font-size:16px; margin-bottom: 0; margin-top: 12px; color:black; height: 100px;"><b>For, <?= my_company_name($invoice_data['company_id']); ?></b>
          </h5>
        </div>

      </div>

    </th>
  </tr>


  <tr>
    <td colspan="<?= $first_row_fixed ?>" class="pt-3 pb-10" style="border: 0;">
      <img src="<?= base_url('public'); ?>/images/footer1.png" style="width: 100%;">
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