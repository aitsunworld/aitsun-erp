<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="<?= $css_url ?>">
  <title><?= $title ?></title>
  <style>
    .iparent_new{
      padding: 30px;
    }
    .font_p{
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="iparent iparent_new">
  <div class="invoice_page" style=" color: black;">
      <table class="w-100">
        <tr>
            <td colspan="5" > 
              <table style="width:100%;">
                <tr>
                  <td class="text-center" colspan="5" style="padding-bottom: 20px;">
                    <h3 style="color:black;">
                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
                      <b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']); ?></b>
                    <?php endif ?>
                    </h3>

                    <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?>

                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_name')==1): ?>
                        <h5 style="text-transform: uppercase; margin-bottom:4px;"><?= $cmp['company_name']; ?></h5>
                      <?php endif ?>
                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_address')==1): ?>
                        <p style="text-transform: uppercase; margin-bottom:0px;" class="font_p">
                          <?php if (!empty($cmp['address'])): ?>
                            <?= $cmp['address']; ?>
                            <?php endif ?>
                          <?php if (!empty($cmp['city'])): ?>
                              <?= $cmp['city']; ?>
                            <?php endif ?>
                            <?php if (!empty($cmp['state'])): ?>
                              <?= $cmp['state']; ?>,
                            <?php endif ?>
                            <?php if (!empty($cmp['country'])): ?>
                              <?= $cmp['country']; ?><br>
                            <?php endif ?>
                            <?php if (!empty($cmp['postal_code'])): ?>
                              Pin: <?= $cmp['postal_code']; ?><br>
                            <?php endif ?>
                        </p>

                        <p style="margin-bottom:0px;" class="font_p">
                            <?php if (!empty($cmp['company_phone'])): ?>
                             <?= $cmp['company_phone']; ?>
                            <?php endif ?>
                            <?php if (!empty($cmp['company_telephone'])): ?>
                              /<?= $cmp['company_telephone']; ?><br>
                            <?php endif ?>
                        </p>
                        <p style="margin-bottom:0px;" class="font_p">
                          <?php if (!empty($cmp['email'])): ?>
                             <?= $cmp['email']; ?><br>
                          <?php endif ?>
                        </p>
                    <?php endif ?>
                    <?php if (!empty($cmp['gstin_vat_no'])): ?>
                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_details')==1): ?>
                        <p style="margin-bottom:0px;"> 
                          GSTIN: <?= $cmp['gstin_vat_no']; ?>
                        </p>
                     <?php endif ?>
                    <?php endif ?>
                  <?php } ?>

                 </td>
                </tr>
              </table>



<table class="w-100">
  <tr>              
    <td style="color: black; width: 75%;" >
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
      <h6 >
        <b class="text-decoration-underline"><u>Customers Details:</u></b>
      </h6>
      <?php endif ?> 
      <h6 class="m-0">
        <?php if ($invoice_data['customer']!='CASH'): ?>
          <h6 style="text-transform:uppercase; margin-bottom: 3px;font-weight: 400;">
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
              <?=  user_name($invoice_data['customer']); ?><br>
            <?php endif ?>
          </h6>

          <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
              <h6 style="text-transform:uppercase; margin-bottom: 3px;font-weight: 400;">
                <?= billing_address_of($invoice_data['customer']) ?><br>
              </h6>
            <?php endif ?>
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
            <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
              <h6 style="margin-bottom: 3px;font-weight: 400;">Phone:
                <?= user_phone($invoice_data['customer']) ?><br>
              </h6>
            <?php endif ?>

            <?php if (!empty(gst_no_of($invoice_data['customer']))): ?>
              <h6 style="margin-bottom: 3px;font-weight: 400;">
                <?= langg(get_setting($invoice_data['company_id'],'language'),'GSTN'); ?>: <?= gst_no_of($invoice_data['customer']); ?> <br>
              </h6>
            <?php endif ?> 
          <?php endif ?>

            <?php elseif ($invoice_data['alternate_name']==''): ?>
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
                <h6 style="margin-bottom: 3px;font-weight: 400;">
                  <?= langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER'); ?>
                </h6>
              <?php endif ?>
            <?php else: ?>
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
                <h6 style="margin-bottom: 3px;font-weight: 400;">
                  <?= $invoice_data['alternate_name']; ?>
               </h6>
             <?php endif ?>
            <?php endif ?>

      </h6>
    </td>
             


    <td style="color: black; width: 300px;">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_num')==1): ?>
        <h6 class="mb-1">
          <b>         
            <?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']); ?> #:
            <?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?>  
          </b>
        </h6>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_date')==1): ?>    
      <h6 class="mb-1">
        <b>Date: </b><span><?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?></span>
      </h6>
      <?php endif ?>

      <?php if (!empty(trim($invoice_data['vehicle_number']))): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'vehicle_number')==1): ?>
          <h6 class="mb-1"><b>VEHICLE NO : <?= strtoupper($invoice_data['vehicle_number']); ?></b></h6>
        <?php endif ?>
      <?php endif ?>


      <?php if (trim(mode_of_payment($invoice_data['company_id'],$invoice_data['id']))!=''): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'mode_of_payment')==1): ?>
          <h6 class="mb-1">
            <b>Payment: </b>
            <span>
              <?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_return'): ?>
                <?= mode_of_payment($invoice_data['company_id'],$invoice_data['id']); ?>
              <?php else: ?>
                ---
              <?php endif ?>
            </span>
          </h6>
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


    </td>
  </tr> 
</table>



<table style="width: 100%; margin-top: 10px; border:1px solid black;">

  <tr style="border-bottom:1px solid black; background-color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>; color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>!important;">
              
    <td style="border-right:1px solid black;text-align: center;width: 200px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Item Name'); ?></b></td>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_pro_desc')==1): ?>
      <td style="border-right:1px solid black;  text-align: center;width: 200px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Description'); ?>. </b></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
      <td style="border-right:1px solid black; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Batch No'); ?>. </b>
      </td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td style="border-right:1px solid black;  text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'HSN'); ?>. </b></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Exp'); ?>. </b>
      </td>
    <?php endif ?>
    
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td style="border-right:1px solid black;  text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Qty'); ?>. </b></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
      <td style="border-right:1px solid black; padding: 3px 0; text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'UOM'); ?></b>
      </td>
    <?php endif ?>
    
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td style="border-right:1px solid black;  text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Item Rate'); ?></b></td>
    <?php endif ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>        
        <td style="border-right:1px solid black;  text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?></b></td>
      <?php endif ?>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td style="border-right:1px solid black;  text-align: center;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Unit Rate'); ?></b></td>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
      <td style="text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Amount'); ?></b></td>
    <?php endif; ?>  
  </tr> 

          
  <?php $taxcount=0; $slno=0; foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; ?>

    <tr style="border-bottom:1px solid black; ">

      <td style="border-right:1px solid black;border-top: 1px solid black;  text-align: center;width: 200px;">
        <?= $ii['product'] ; ?>
        <?php if (has_show_item($invoice_data['company_id'])): ?>
          <?php foreach (item_kits_array_for_show($ii['product_id'],$invoice_data['id']) as $iti): ?>
            <small class="d-block"><?= $iti['product']; ?> <?= $iti['quantity']; ?> <?= unit_name(unit_of_product($iti['product_id'])); ?> </small>
          <?php endforeach ?>
        <?php endif; ?>
      </td>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_pro_desc')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black;  text-align: center;width: 200px;">
          <?= nl2br($ii['desc']) ?>
        </td>
      <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
        <td style="border-top: 1px solid black;border-right:1px solid black; padding: 10px;"><?= batch_no($ii['product_id']); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black;  text-align: center;"><?= pro_identy($ii['product_id']); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black; padding: 10px;"><?= expiry_date($ii['product_id']); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black;  text-align: center;"><?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black; padding: 10px; text-align: right;"><?= unit_name($ii['in_unit']); ?></td>
      <?php endif ?>
                
     
            
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black;  text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= $ii['mrp']; ?></td>
      <?php endif ?>

      <?php if ($invoice_data['order_type']==''): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
          <td style="border-top: 1px solid black; border-right:1px solid black;  text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>">
            <?php if ($invoice_data['invoice_type']=='sales'): ?>
              <?= $ii['sale_margin']; ?>%
            <?php elseif($invoice_data['invoice_type']=='purchase'): ?>
              <?= $ii['purchase_margin']; ?>%
            <?php endif ?>
          </td>
        <?php endif ?>
      <?php endif; ?>

      <?php 
        $unit_rate=0;
        $margin=$ii['sale_margin'];
        $withorwithout=$ii['sale_tax'];
        if($invoice_data['invoice_type']=='purchase'){
          $margin=$ii['purchase_margin'];
          if ($ii['purchase_tax']==1) {
            $withorwithout=1;
          }else{
            $withorwithout=0;
          }
        }

        $shortax='1.0';
        if ($withorwithout==1) {
          $shortax='1.'.invoice_percent_of_tax($ii['tax'],$invoice_data['company_id']);
        }

        $unit_rate=($ii['mrp']-($ii['mrp']*$margin/100))/$shortax;
      ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
        <td style="border-top: 1px solid black; border-right:1px solid black;  text-align: center;"><?= round($unit_rate,2); ?></td>
      <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
        <td style=" border-top: 1px solid black; text-align: center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= $ii['price']*$ii['quantity']; ?></td>
      <?php endif ?>
    </tr>
  <?php endforeach ?> 
           
</table>



<table style="width:100%;border: 1px solid;margin-top: 10px;">

  <tr style="border-bottom:1px solid black; ">

    <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>
      <td style="padding: 5px;" colspan="2"><h6 class="p-2" style="font-weight:400">  </h6></td>
    <?php else: ?>
      <td style="padding: 5px; " colspan="2"><h6 class="mb-0" style="font-weight:400">Bill Amount: <?= currency_symbol2($invoice_data['company_id']); ?> <?= amount_in_words(round($invoice_data['total'])); ?></h6></td>
    <?php endif; ?>
              
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td style="" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td style=""></td>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td style="" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
    <?php endif; ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td style="" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
      <?php endif ?>
    <?php endif; ?>
       
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
      <td style="border-left:1px solid black; width:150px;  text-align: right; padding-top: 0;padding-bottom: 0;"><h6 class="mb-0">Taxable Amt :</h6></td>
      <td style="border-left:1px solid black; width:150px;  text-align: right; padding-top: 0;padding-bottom: 0;"><b class="mb-0">
        <span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
        <?= round($invoice_data['sub_total']-$invoice_data['tax'],2,PHP_ROUND_HALF_UP); ?></b>
      </td>
    <?php endif ?>
  </tr>

  <?php if ($invoice_data['additional_discount']>0): ?>        
    <tr style="border-bottom:1px solid black; ">
      <td  colspan="2"></td>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
        <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
      <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
        <td ></td>
      <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
        <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
      <?php endif; ?>

      <?php if ($invoice_data['order_type']==''): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
          <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
        <?php endif ?>
      <?php endif; ?>
   
      <td style="text-align: right; padding-top: 0;padding-bottom: 0; border-left:1px solid black;"><h6 class="mb-0">Cash Discount (-)<?= round($invoice_data['additional_discount_percent'],2); ?>%</h6></td>

      <td style="border-left:1px solid black; text-align: right;padding-top: 0;padding-bottom: 0;"><b class="mb-0">
        <span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
        <?= round($invoice_data['additional_discount'],2); ?></b>
      </td>
    </tr>
  <?php endif ?>

  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
    <?php
    $ttot=0;
    foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>

      <?php if (!empty($tds['tax_name'])): ?>
        <tr style="border-bottom:1px solid black; ">
          <td colspan="2"></td>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
            <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
          <?php endif; ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
            <td ></td>
          <?php endif; ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
            <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
          <?php endif; ?>

          <?php if ($invoice_data['order_type']==''): ?>
             <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
              <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
            <?php endif ?>
          <?php endif; ?>

          <td style="border-top:1px solid; text-align: right;padding-top: 0;padding-bottom: 0; border-left:1px solid black;"><h6 class="mb-0"><?= $tds['tax_name']; ?> : </h6></td>

          <td style="border-top:1px solid; border-left:1px solid black;text-align: right;padding-top: 0;padding-bottom: 0;"><b class="mb-0">
            <span style="font-family: DejaVu Sans!important; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
            <?= $tds['tax_amount']; ?></b>
          </td>
        </tr>
      <?php endif ?>         
    <?php endforeach ?>
  <?php endif ?>



  <tr style="border-bottom:1px solid black; ">
    <td colspan="2"></td>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td ></td>
    <?php endif; ?>
       
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
    <?php endif; ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
      <?php endif ?>
    <?php endif; ?>
 
  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>
    <td style="text-align: right;border-top: 1px solid; padding-top: 0;padding-bottom: 0; border-left:1px solid black;"><h6 class="mb-0">Round Off :</h6></td>
              
    <td style="border-top: 1px solid; border-left:1px solid black; text-align: right; padding-top: 0;padding-bottom: 0;">
      <b class="mb-0"><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span>

        <?php if ($invoice_data['round_off']>0): ?>
          <?php if ($invoice_data['round_type']=='add'): ?>
            + <?= number_format(round($invoice_data['total'])-$invoice_data['total'],2)+$invoice_data['round_off']; ?>
          <?php else: ?>
            - <?= number_format(round($invoice_data['total'])-$invoice_data['total'],2)+$invoice_data['round_off']; ?>
          <?php endif ?>
        <?php else: ?>
          <?= number_format(round($invoice_data['total'])-$invoice_data['total'],2); ?>
        <?php endif ?>
      </b>
    </td>
  <?php endif; ?>
  </tr>


  <tr style="border-bottom:1px solid black;">
    <td colspan="2"></td>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
    <?php endif; ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td ></td>
    <?php endif; ?>
    
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
    <?php endif; ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"></td>
      <?php endif ?>
    <?php endif; ?>

    <td style="border-top: 1px solid; text-align: right; padding-top: 0;padding-bottom: 0; border-left:1px solid black;"><h6 class="mb-0">Bill Total :</h6></td>

    <td style="border-top: 1px solid; border-left:1px solid black;text-align: right; padding-top: 0;padding-bottom: 0;"><b class="mb-0"><span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= round($invoice_data['total']); ?></b>
    </td>
  </tr>
</table>


<table style="width:100%; margin-top:10px;">
  <tr>

    <td  style="padding: 10px;border-left:1px solid black;border-bottom:1px solid black; width:70%; border-top: 1px solid;">
      <div class="d-flex justify-content-between">
        <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details'))){ ?>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bank_details')==1): ?>
            <div style="margin-top: 10px;" class="my-auto">
              <h6 style="margin-bottom:0px; font-weight: 400;">
                <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details')); ?>
              </h6> 
            </div>
          <?php endif ?> 
        <?php }else{echo "";} ?>
      
       <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'))){ ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_qr_code')==1): ?>
          <div class="text-center" style="width:max-content; margin-top: 10px;">
            <div>Scan to pay</div>
            <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'); ?>"  style="width:130px; height: auto; object-fit: contain;">
          </div>
        <?php endif ?>
      <?php }else{echo "";} ?>
    </div>

      
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_declaration')==1): ?>
      <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration'))){ ?>
        <div class="mt-2">
          <h5 style="margin-bottom: 0.5rem;color: black;; margin-top: 5px; font-size: 16px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Invoice Declaration'); ?> :</b></h5>
          <p style="margin:0;font-size: 14px;">                     
            <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration')); ?>
          </p>
        </div>
      <?php }else{echo "";} ?>
    <?php endif ?> 

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
          
    </td>

    <td style="border-left:1px solid black;border-bottom:1px solid black; border-top: 1px solid; border-right:1px solid black;text-align: center;">
      <p class="mb-5 mt-2">For, <?= my_company_name($invoice_data['company_id']); ?> </p>

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

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_seal')==1): ?>
        <p class="mb-2" style="margin-top:2rem!important;">Authorised Signatory</p>
      <?php elseif (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')==1): ?>
        <p class="mb-2" style="margin-top:2rem!important;">Authorised Signatory</p>
      <?php else :?>
        <p class=" mb-2" style="margin-top:10rem!important;">Authorised Signatory</p>
      <?php endif ?>
      

    </td>

  </tr>
</table>
  
<?php if (is_payment_method($invoice_data['company_id'])): ?>
  <tfoot style="font-size: 12px; margin-bottom: 0px; border-bottom: 0.5px solid #C4C4C4;"  cellspacing="0" cellpadding="5" >
    <tr>
      <td colspan="2" style="text-align: center;">
        <div>
          <h4 class="mb-4 mt-4" style="color:#00000073; font-size: 12px;">
              <b>This Document is Generated by <a style="color:#e54a4a;" href="https://www.aitsun.com/">Aitsun ERP</a>.</b>
            </h4> 
        </div>
      </td>
    </tr>
  </tfoot>
<?php endif ?> 

            </td>
      </table>
    </div>
  </div>




</body>
</html>