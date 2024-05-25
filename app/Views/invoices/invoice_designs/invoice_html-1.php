<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
</head>
<body>
 <style type="text/css">
    @page {
            margin: 20px;
        } 
    @font-face {
        /*font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;*/
        font-family: DejaVu Sans;

    } 
    .company_logo{
      height: 50px;
    } 
    .invoice_font{
      font-size: 13px;
    }
    table{width: 100%;}      
    body{
      background: white;
        font-family:  DejaVu Sans,Arial,sans-serif;            
    }
 </style>

 <table class="w-100">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_invoice_header')==1): ?>
        <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_invoice_header'))): ?>

          <tr>
      
           
            <td style="padding:0;">
               <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_header'))): ?>
                <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_header'); ?>" style="width: 100%;">
          <?php endif ?>

            </td>
          </tr>
          <?php endif ?>
          <?php endif ?>

      
    </table>
 <table style="padding-bottom: 14px;" cellspacing="0" cellpadding="0">
  <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?>
  <tr>
    <!-- //company details -->
    <td>
      
     
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_name')==1): ?>
      <div style="font-size:16px; font-weight:bold;"><?= $cmp['company_name']; ?></div>
      <?php endif ?>

      <div style="max-width:75%;font-size: 13px;">

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_address')==1): ?>
        <?php if (!empty($cmp['city'])): ?><?= $cmp['city']; ?><?php endif ?>, <?php if (!empty($cmp['state'])): ?><?= $cmp['state']; ?>, <?php endif ?><?php if (!empty($cmp['country'])): ?><?= $cmp['country']; ?><br><?php endif ?><?php if (!empty($cmp['postal_code'])): ?>Pin: <?= $cmp['postal_code']; ?><br><?php endif ?><?php if (!empty($cmp['company_phone'])): ?>Mob: <?= $cmp['company_phone']; ?><br><?php endif ?><?php if (!empty($cmp['company_telephone'])): ?>Land: <?= $cmp['company_telephone']; ?><br><?php endif ?>
        <?php endif ?>


      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_details')==1): ?>
      <?php if (!empty($cmp['gstin_vat_no'])): ?>

        <?php if (get_company_data($invoice_data['company_id'],'country')=='India'):?>
          <b>GSTIN: <?= $cmp['gstin_vat_no']; ?></b>
        <?php else: ?>
          <b>VAT TIN: <?= $cmp['gstin_vat_no']; ?></b>
        <?php endif ?> 
        <?php endif ?>

        <?php if (get_company_data($invoice_data['company_id'],'country')=='Oman'):?>
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_tin_num')==1): ?>

          <b>
              <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'taxnumber'))): ?>
                <br>
              TAX CARD NO: <?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'taxnumber'); ?> / TIN: <?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'tinnumber'); ?>
              <?php endif ?>
            </b>
          <?php endif ?>

        <?php endif ?>
        <?php endif ?>


    </div> 
    </td>
    <!-- //logo -->
    <td style="text-align:right;">
       <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_logo')==1): ?>
          <div> 
                
                  <img src="<?= base_url('public'); ?>/images/company_docs/<?php if($cmp['company_logo']!= ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo" style="width: auto; height: 60px; ">
          </div>
          <?php endif ?>
    </td>
  </tr>
  <?php } ?>
  
</table>


    <table cellspacing="0" cellpadding="0" width="100">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
     
        <tr>
            <td style="text-align:center; padding-bottom: 8px;" colspan="2">

              <?php if (is_medical($invoice_data['company_id'])): ?>
                    <?php if ($invoice_data['invoice_type']=='sales'): ?>
                      <div style="font-size:16px; color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>!important;"><b>CASH MEMO</b></div>
                    <?php else: ?>
                     <div style="font-size:16px; color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>!important;"><b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']) ?></b></div>
                    <?php endif ?>
                     

                  <?php else: ?>
                    <div style="font-size:16px; color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>!important;"><b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']) ?></b></div>
                  <?php endif ?>

                  


            </td>
        </tr>
        <?php endif ?>




         
        <tr>
          <td style="vertical-align:baseline;width:65%;">

            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_num')==1): ?>

                <div style="font-size: 14px;">

                   <?php if (is_medical($invoice_data['company_id'])): ?>
                    <?php if ($invoice_data['invoice_type']=='sales'): ?>
                      <b>No:</b>
                    <?php else: ?>
                      <b>Invoice:</b>
                    <?php endif ?>
                     

                  <?php else: ?>
                    <b>Invoice:</b>
                  <?php endif ?>

                  

                   <?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?></div>
              <?php endif ?>


            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_mrn_num')==1): ?>
            <div style="font-size:14px;">
                <b>MRN No : </b> <?= $invoice_data['mrn_number']; ?> 
            </div>
            <?php endif ?>
            <div style="font-size:14px;">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_date')==1): ?>
              <b>Date:</b> <?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?>
               <?php endif ?>
            </div>
            <div style="font-size:14px;">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_due_date')==1): ?><b>Payment Due:</b> <?php $Date = $invoice_data['invoice_date']; ?><?= date('d M Y',strtotime($Date. ' + 7 days')); ?><?php endif ?>
            </div>
            <div style="font-size:14px;">
               <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_number')==1): ?>
            <b>Bill no:</b>  <?php if (!empty($invoice_data['bill_number'])): ?>
              <?= $invoice_data['bill_number']; ?>
              <?php else: ?>
              ---
              <?php endif; ?>
            <?php endif ?>
            </div>

            <div style="font-size:14px;">
               <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_vehicle_number')==1): ?>

                <?php if (!empty(trim($invoice_data['vehicle_number']))): ?><b>Vehicle No:</b> <?= strtoupper($invoice_data['vehicle_number']); ?><?php endif ?>
              <?php endif ?>
            </div>




          </td> 

          <td style="vertical-align:baseline;">
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>

      <?php if (is_medical($invoice_data['company_id'])): ?>
        <?php if ($invoice_data['invoice_type']=='sales'): ?>
          <div style="font-size:14px; padding: 0px;"><b>Patient Name:</b></div>
        <?php else: ?>
          <b>Bill to:</b>
        <?php endif ?>

         

      <?php else: ?>
         <div style="font-size:14px; padding: 0px;"><b>Bill to:</b></div>
      <?php endif ?>


                <div style="font-size:13px; padding: 0px;">
                <?php if ($invoice_data['customer']!='CASH'): ?>
                  <?=  user_name($invoice_data['customer']); ?>

                  <?php if (!empty(gst_no_of($invoice_data['customer']))): ?>
                   <div style="font-size:13px; padding: 0px;"><?= langg(get_setting($invoice_data['company_id'],'language'),'GST No'); ?>: <?= gst_no_of($invoice_data['customer']); ?>  </div>
                  <?php endif ?> 

                  <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
                    <div style="font-size:13px; padding: 0px;">
                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
                      <?= billing_address_of($invoice_data['customer']) ?>
                      <?php endif ?>
                    </div> 

                  <?php endif ?> 

                  <?php elseif ($invoice_data['alternate_name']==''): ?>
                  <div style="font-size:13px; padding: 0px;">
                    <?= langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER'); ?>
                  </div>
                  <?php else: ?>
                  <div style="font-size:13px; padding: 0px;">
                    <?= $invoice_data['alternate_name']; ?>
                  </div>
                <?php endif ?>
                </div>

                <?php endif ?>


          </td>
          
        </tr>


         
    </table>

<table style="padding-top: 10px; width: 100%; font-size: 13px;" cellpadding="5" cellspacing="0" class="invoice_font mt-4">
  <tr  style="border:1px solid #cccccc; background: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>; color:<?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>;">

   
<td style="border:1px solid #cccccc;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Particulars'); ?></b></td>

<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
<td style=" text-align:center;border:1px solid #cccccc;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Batch No'); ?>. </b></td>
<?php endif ?>

<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
<td style=" text-align:center;border:1px solid #cccccc;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'HSN Code'); ?>. </b></td>
<?php endif ?>

<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
<td style=" text-align:center;border:1px solid #cccccc;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Exp'); ?>. </b></td>
<?php endif ?>

<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
<td style=" text-align:center;border:1px solid #cccccc;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Qty'); ?></b></td>
<?php endif ?>

<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
<td style=" text-align:center;border:1px solid #cccccc;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'UOM'); ?></b></td>
<?php endif ?>

<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
<td style=" text-align:center;border:1px solid #cccccc;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Rate'); ?></b></td>
 <?php endif ?>

 <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>

<!-- <td style=" text-align:center;border:1px solid #cccccc;" style="border-right:1px solid black; padding: 0px 5px; text-align: center;" class="<php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><b><= langg(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'language'),'Rate <br>(Incl. of Tax)'); ?></b></td> -->

  <td style=" text-align:center;border:1px solid #cccccc;" style=" padding: 0px 5px; text-align: center;" class="">
    <?php if (get_company_data($invoice_data['company_id'],'country')=='Oman'):?>
      <b><?= langg(get_setting($invoice_data['company_id'],'language'),'VAT'); ?>.(%)</b>
    <?php else: ?>
      <b><?= langg(get_setting($invoice_data['company_id'],'language'),'GST'); ?>.(%)</b>

    <?php endif ?>

  </td>


 
  <?php endif ?>


 <?php if ($invoice_data['order_type']==''): ?>
  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
  <td style=" text-align:center;border:1px solid #cccccc;" class=""><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?></b></td>
  <?php endif ?>
<?php endif; ?>

 <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>

<td style=" text-align:center;border:1px solid #cccccc;" class=""><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Amount'); ?></b></td>
<?php endif; ?>



  </tr>


  
   <?php $taxcount=0; $slno=0; foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; ?>
  <tr style="color: black;font-size: 13px;" id="thisheight"> 
    <td style=" border:1px solid #cccccc;" valign="baseline">
      <div ><?= $ii['product'] ; ?></div>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_pro_desc')==1): ?>
      <small style="display: block; max-width:300px; color: #212529d4; font-size: 10px;">
        <?= nl2br($ii['desc']) ?>   
      </small>   
      <?php endif ?>
       
    </td>
     <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
     <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline"><?= batch_no($ii['product_id']); ?></td>
     <?php endif ?>

     <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
     <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" ><?= pro_identy($ii['product_id']); ?></td>
     <?php endif ?>

     
     <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
      <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline"><?= expiry_date($ii['product_id']); ?></td>
      <?php endif ?>


    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
    <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline"><?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
        <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" ><?= unit_name($ii['in_unit']); ?></td>
    <?php endif ?>

    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
    <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" class=""><?= aitsun_round($ii['price'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
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

    <!-- <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" class="<php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><= $inc_taxxxx; ?></td> -->


   <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= invoice_percent_of_tax($ii['tax'],$invoice_data['company_id']); ?>%</td>

     


   <td style=" text-align:right; border:1px solid #cccccc; display: none;" valign="baseline" class="d-none <?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>">
    <?php if (invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])!=''): ?>
       <?= ($ii['price']*$ii['quantity'])*invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])/100; ?> 

      

    <?php endif ?>
    </td>


    <?php endif ?>

    <?php if ($invoice_data['order_type']==''): ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
    <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" class=""><?= aitsun_round($ii['discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
    <?php endif ?>
    <?php endif; ?>

  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
    <td style=" text-align:right; border:1px solid #cccccc;" valign="baseline" class="">
      
         <?= aitsun_round($ii['price']*$ii['quantity'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
      </td>
      <?php endif ?>
  </tr>
  <?php endforeach ?>

 

</table>
<br>

<table cellspacing="0" cellpadding="0" width="100" style="margin-bottom:8px;">

  <tr>
    <td style="width:55%;">
      <table width="100" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2">
            <div style="font-size:14px; margin-bottom: 10px;">
                <b>Amt in Words:</b><br> <?= currency_symbol2($invoice_data['company_id']); ?> <?= numberTowords(aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')),$invoice_data['company_id']); ?>
              </div>
          </td>
        </tr>
        <tr>
          <td valign="baseline">
             <div style="color: black; font-size: 12px;">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bank_details')==1): ?>

                     <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details'))){ ?>
                        <div style="font-size:14px;"><b>Company Details :</b></div>      
                            <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details')); ?>
                       

                        <?php }else{echo "";} ?>

              <?php endif ?>
            </div>
            
          </td>
          <td valign="middle">
               <div style="">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_qr_code')==1): ?>
              <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'))): ?>
              <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'); ?>"  style="width: 80px; object-fit: contain;">
              <?php endif ?> 
              <?php endif ?> 
              </div>
          </td>
        </tr>

      </table>
      
    </td>
    <td valign="baseline"> 

        <table style="line-height:1.5;font-size: 13px;" cellspacing="0" cellpadding="1" class="invoice_font" width="100">


          <tr style="color: black;"> 
            <td style=" border:1px solid #cccccc;padding: 0px 5px; width: 52%;" valign="baseline" >Sub Total:</td>

                
           <td style="border:1px solid #cccccc;  text-align: right;"> <span style="font-family: DejaVu Sans; font-size: 12px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
            <?= aitsun_round($invoice_data['sub_total']-$invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
            </td>
           
          </tr>
          
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
         
          <?php

           
          $ttot=0;
           foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>
            <?php if (!empty($tds['tax_name'])): ?>
               <tr nobr="true">
                  <td style="border:1px solid #cccccc; padding: 0px 5px;" ><?= $tds['tax_name']; ?> :</td>
                  <td style="border:1px solid #cccccc; font-size: 13px; padding: 0px 5px; text-align: right;">
                    
                       <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($tds['tax_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?> 
                    
                  </td>
                </tr>
            <?php endif ?>
           
          <?php endforeach ?> 

            <?php if (get_company_data($invoice_data['company_id'],'country')!='Oman'):?>

           <tr nobr="true">
            <td style="border:1px solid #cccccc; padding: 0px 5px; "><?= langg(get_setting($invoice_data['company_id'],'language'),'Taxable Amount'); ?> :</td>
            <td style="border:1px solid #cccccc; padding: 0px 5px; text-align: right;">
              
                <?php if ($invoice_data['tax']>0): ?>
                  <span style="font-family: DejaVu Sans; ">
                  <?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
                <?php else: ?>
                  <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?>0</span>
                <?php endif ?>
            
            </td>
          </tr>
          <?php endif ?>

          
          <?php endif ?>





          <?php if ($invoice_data['order_type']==''): ?>
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
                <tr nobr="true" >
                  <td style="border:1px solid #cccccc; padding: 0px 5px; " class="pr-2 dl-none"><?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?> :</td>
                  <td style="border:1px solid #cccccc; padding: 0px 5px;text-align: right;"><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['discount']+$invoice_data['additional_discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
                </tr>
              <?php endif ?>
            <?php endif ?>

            <tr nobr="true">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>

              <td style="border:1px solid #cccccc; padding: 0px 5px; "><?= langg(get_setting($invoice_data['company_id'],'language'),'Round off'); ?> :</td>
              

              <td style="border:1px solid #cccccc; padding: 0px 5px; text-align: right;"><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span>

                  <?php if ($invoice_data['round_off']>0): ?>
                      <?php if ($invoice_data['round_type']=='add'): ?>
                        + <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php else: ?>
                        - <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php endif ?>
                  <?php else: ?>
                    <?= aitsun_round($invoice_data['total']-$invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                  <?php endif ?>
                
              </td>
              <?php endif ?>
            </tr>

            <tr nobr="true" style="background-color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>; color:<?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>;">
              <td style="border:1px solid #cccccc; padding: 0px 5px; font-size:14px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Total'); ?> :</b></td>
              <td style="border:1px solid #cccccc;text-align: right; padding: 0px 5px; font-size:14px;"><b><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?></b></td>
            </tr>
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'due_amount')==1): ?>

            <?php if ($invoice_data['paid_status']=='unpaid'): ?>
            <tr nobr="true">
              <td style="border:1px solid #cccccc; padding: 0px 5px;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Due Amount'); ?> :</td>
              <td style="border:1px solid #cccccc;text-align: right; padding: 0px 5px;">
                <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['due_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
              </td>
            </tr>
            <?php endif ?>
            <?php endif ?>
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'mode_of_payment')==1): ?>
            <?php if (trim(mode_of_payment($invoice_data['company_id'],$invoice_data['id']))!=''): ?>
            <tr nobr="true">
              <td style="border:1px solid #cccccc; padding: 0px 5px;" class="pr-2"><?= langg(get_setting($invoice_data['company_id'],'language'),'Mode of Payment'); ?> :</td>
              <td style="border:1px solid #cccccc;text-align: right; padding: 0px 5px;">
                <?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_return'): ?>
                  <?= mode_of_payment($invoice_data['company_id'],$invoice_data['id']); ?>
                <?php else: ?>
                  ---
                <?php endif ?>
              </td>
            </tr>
           <?php endif ?>
           <?php endif ?>




        </table>


      
    </td>
  </tr>
  
</table>








<!-- ////////////////////////// -->

<table style="font-size: 12px; margin-bottom: 10px;"  cellspacing="0" cellpadding="2">     
  
  <tr>
    <td style="width:52%;">
        <div style="margin-bottom: 10px; color: black; font-size: 12px;">
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_terms')==1): ?>
        <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms'))){ ?>

         <div style="font-size:14px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Terms & Conditions'); ?> :</b></div>
                               
                <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms')); ?>
           
            <?php }else{echo "";} ?>
        <?php endif ?>
      </div> 


      <div style="margin-bottom: 10px; color: black; font-size: 12px;">
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_declaration')==1): ?>

           <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration'))){ ?>
           <div style="font-size:14px;"><b><?= langg(get_setting($invoice_data['company_id'],'language'),'Declaration'); ?> :</b></div>
            <?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration'); ?>
            <?php } ?>
          <?php endif ?> 
      </div>

    </td>


    <td valign="bottom" > 
        <div style="color:black; text-align:right; font-size:13px;"><b>For, <?= my_company_name($invoice_data['company_id']); ?></b>
        </div>
        <br>
        <br>

         <table style="text-align:right;"> 
          <tr style="text-align:right;">
            <td style="text-align:right;">
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_seal')==1): ?>
                <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'))): ?>
                    <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'); ?>"  style="width: 100px; object-fit: contain;">
                <?php endif ?> 
              <?php endif ?> 

            
            
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')==1): ?>

               <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'))): ?>
                <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'); ?>" style="width:100px; height: auto; object-fit: contain;">
              <?php endif ?> 

            <?php endif ?> 
            </td>
          </tr>
        </table>

      
    </td>
  </tr>


  <tr>

    <td  style="font-size:12px;">
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_reciver_sign')==1): ?>
              <br>
             <div style="text-align:left;">--------------------------</div>
              <div style="text-align:left;">Receiver Signature</div>
          

        <?php endif ?> 

    </td>
    
    <td style="font-size:12px;">
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')==1): ?>
      
            <div style="text-align:right;">--------------------------------</div>
            <div style="text-align:right;">Authorised Signatory</div></div>
        <?php endif ?> 
      
    </td>

  </tr>



</table>

  <table style="font-size: 12px; margin-bottom: 0px; border-bottom: 0.5px solid #C4C4C4;"  cellspacing="0" cellpadding="5" >
    <tr>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_footer')==1): ?>

        <td colspan="2" style="text-align: center;">
          <div style="margin:0;">
            <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?>
              <?= nl2br(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_footer')); ?>
            <?php } ?>
          </div>
        </td>
          <?php endif ?> 

      </tr>
      <tr>
       
      <?php if (is_payment_method($invoice_data['company_id'])): ?>
        <td colspan="2" style="text-align: center;">
          <div style="margin:0;">
            <h4 class="mb-4" style="color:#00000073; font-size: 12px;">
              <b>This Document is Generated by <a style="color:#e54a4a;" href="https://www.aitsun.com/">Aitsun ERP</a>.</b>
            </h4> 
          </div>
        </td>
      <?php endif ?> 

      </tr>

  </table>

</body>
</html>