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
        font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;
    } 
    .company_logo{
      height: 50px;
    } 
    .invoice_font{
      font-size: 16px;
    }
    table{width: 100%;}      
    body{
      background: white;
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
    }
    body::-webkit-scrollbar{
      display: none;
    }
    table,
      td {
        border: solid 1px black;
        text-align: center;
        border-collapse: collapse;
      }

      .bold~tr td {
        border: solid 1px black;
      }

      td {
        padding: 0.2rem;
      }

      [colspan="4"][rowspan="2"] {
        height: 6rem;
      }

  </style>
<div style="padding:0;text-align: right;font-size: 16px;">
Buyer's/Seller's/Transport Copy
</div>




<?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_header'))): ?>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_invoice_header')==1): ?>

    <table class="w-100" style="border-bottom:none">
      <tr>
        <td style="padding:0;border-bottom: none;text-align: center;">
          
            <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_header'); ?>" style="width: 100%;display: block;">
         
        </td>
      </tr>
    </table>
  <?php endif ?>
<?php endif ?>

<table>

  <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?> 
  <tr>
    <td colspan="2" class="invoice_font" style="width:33.333%; border-bottom:none; border-top:none; border-right: none; border-left: none;text-align: left;">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_details')==1): ?>
      <?php if (!empty($cmp['gstin_vat_no'])): ?>
          <?php if (get_company_data($invoice_data['company_id'],'country')=='India'):?>
            <b>GSTIN: <?= $cmp['gstin_vat_no']; ?></b>
          <?php else: ?>
            <b>VAT TIN: <?= $cmp['gstin_vat_no']; ?></b>
          <?php endif ?> 
        
          
        <?php endif ?>
      <?php endif ?>
    </td>

    <td colspan="3" style="width:33.333%; border-bottom:none; border-right: none;  border-top:none;  border-left: none; text-align: center;">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
        
         <?php if (is_medical($invoice_data['company_id'])): ?>
            <?php if ($invoice_data['invoice_type']=='sales'): ?>
              <div style="font-size:26px; color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>!important;"><b>CASH MEMO</b></div>
            <?php else: ?>
              <div style="font-size:26px; color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>!important;"><b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']) ?></b></div>
            <?php endif ?>        
          <?php else: ?>
            <div style="font-size:26px; color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>!important;"><b><?= inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']) ?></b></div>
          <?php endif ?>
      <?php endif ?>
    </td>

    <td colspan="3" style="width:33.333%; border-bottom:none; border-right: none;  border-top:none;  border-left: none; text-align: right;">
      <div style="font-size: 16px;">
        <?php if (!empty($cmp['company_phone'])): ?>
          PHONE: <?= $cmp['company_phone']; ?><br>
        <?php endif ?>
        <?php if (!empty($cmp['company_telephone'])): ?>
          <?= $cmp['company_telephone']; ?>
        <?php endif ?>
      </div>
    </td>


</tr>

  <tr>
    <td colspan="8" style="border:none;">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_name')==1): ?>
       <div style="font-size:2rem; font-weight:bold;"><?= $cmp['company_name']; ?></div>
      <?php endif ?>
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_address')==1): ?>
        <div style="font-size:16px;">
          <?php if (!empty($cmp['city'])): ?>
            <?= $cmp['city']; ?><?php endif ?>, 
            <?php if (!empty($cmp['state'])): ?>
              <?= $cmp['state']; ?>, 
            <?php endif ?>
            <?php if (!empty($cmp['country'])): ?>
              <?= $cmp['country']; ?><br>
            <?php endif ?>
            <?php if (!empty($cmp['postal_code'])): ?>
              <?= $cmp['postal_code']; ?>
            <?php endif ?>
           
        </div>
      <?php endif ?>
    </td>
  </tr>


<?php } ?>
</table>


<table style="border-top:none;" cellspacing="0" cellpadding="0">
  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
  <td style="width:50%;border-top:none;text-align: left;">
    
        <?php if (is_medical($invoice_data['company_id'])): ?>
          <?php if ($invoice_data['invoice_type']=='sales'): ?>
            <div style="font-size:16px; padding: 0px;"><b>Patient Name:</b></div>
          <?php else: ?>
            <b>Bill to:</b>
          <?php endif ?>
        <?php else: ?>
         <div style="font-size:16px; padding: 0px;"><b>To:</b></div>
        <?php endif ?>
        
        <div style="margin-left: 20px;font-size:16px; padding: 0px;">
          <?php if ($invoice_data['customer']!='CASH'): ?>
            <?=  user_name($invoice_data['customer']); ?>

            <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
              <div style="font-size:16px; padding: 0px;">
                <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
                  <?= billing_address_of($invoice_data['customer']) ?>
                <?php endif ?>
              </div> 
            <?php endif ?> 

            <?php if (!empty(gst_no_of($invoice_data['customer']))): ?>
            <div style="font-size:16px;padding: 0px;">
        <?php if (get_company_data($invoice_data['company_id'],'country')=='India'):?>
          <?= langg(get_setting($invoice_data['company_id'],'language'),'GST No'); ?>: 
          <?= gst_no_of($invoice_data['customer']); ?>  
        <?php else: ?>
          <?= langg(get_setting($invoice_data['company_id'],'language'),'VAT TIN'); ?>: 
          <?= gst_no_of($invoice_data['customer']); ?>  


        <?php endif ?>



      


              
              
            </div>
           <?php endif ?> 

         

           


          <?php elseif ($invoice_data['alternate_name']==''): ?>
            <div style="font-size:16px; padding: 0px;">
              <?= langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER'); ?>
            </div>
          <?php else: ?>
            <div style="font-size:16px; padding: 0px;">
              <?= $invoice_data['alternate_name']; ?>
            </div>
          <?php endif ?>
        </div>
      
      
      
      
      
  </td>
  <?php endif ?>
  <td style="width:50%;border-top:none; padding: 0;" valign="baseline"> 
    <table style="line-height:1.5;font-size: 16px; border: none;"  cellspacing="0" cellpadding="0" class="invoice_font" width="100">

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_num')==1): ?>
                <tr nobr="true" >
                  <td style="border-bottom:1px solid #cccccc; padding: 5px 5px;text-align: left;border-right: none;border-left: none; border-top: none; " class="pr-2 dl-none invoice_font">
                   <?php if (is_medical($invoice_data['company_id'])): ?>
                    <?php if ($invoice_data['invoice_type']=='sales'): ?>
                     <?= langg(get_setting($invoice_data['company_id'],'language'),'No'); ?>
                    <?php else: ?>
                     <?= langg(get_setting($invoice_data['company_id'],'language'),'Invoice'); ?>
                    <?php endif ?>
                  <?php else: ?>
                     <?= langg(get_setting($invoice_data['company_id'],'language'),'INVOICE NO'); ?>
                  <?php endif ?>
                   </td>
                  <td style="border:1px solid #cccccc; padding: 0px 5px;text-align: right;border-left: none;border-top: none;border-right: none;">
                     <?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?>
                  </td>
                </tr>
             
            <?php endif ?>

          
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_date')==1): ?>
            <tr nobr="true" style="">
              <td class="invoice_font" style="border:1px solid #cccccc; padding: 5px 5px; font-size:16px;border-right: none;text-align: left;border-top:none;border-left:none;border-bottom: none;"><?= langg(get_setting($invoice_data['company_id'],'language'),'BILL DATE'); ?></td>
              <td style="border:1px solid #cccccc;text-align: right; padding: 0px 5px; font-size:16px;border-top:none;border-bottom: none;border-right: none;border-left: none;"><?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?></td>
            </tr>
            <?php endif ?>

             <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_number')==1): ?>
            <tr nobr="true" style="">
              <td class="invoice_font" style="border:1px solid #cccccc; padding: 5px 5px; font-size:16px;border-right: none;text-align: left;border-top:1px solid #cccccc;border-left:none;border-bottom: none;">
                <?= langg(get_setting($invoice_data['company_id'],'language'),'BILL NO. '); ?>
                  
                </td>
                <td style="border:1px solid #cccccc;text-align: right; padding: 0px 5px; font-size:16px;border-top:1px solid #cccccc;border-bottom: none;border-right: none;border-left: none;"><?php if (!empty($invoice_data['bill_number'])): ?>
                <?= $invoice_data['bill_number']; ?>
                <?php else: ?>
                ---
                <?php endif; ?>
              </td>
            </tr>
            <?php endif ?>
          
            




        </table>
  </td>
</table>


  <table style="border-collapse: collapse; width: 100%; font-size: 16px; border-bottom: none; border-top: none; " border="1" class="invoice_font">
    <tbody>
      <tr style="border:1px solid #cccccc; background-color: <?= get_setting($invoice_data['company_id'],'Invoice_color'); ?>; color:<?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>;">
        <td style="border-top: none; ">&nbsp;
          <?= langg(get_setting($invoice_data['company_id'],'language'),'SL'); ?>
        </td>
        <td style="border-top: none; ">&nbsp;
          <?= langg(get_setting($invoice_data['company_id'],'language'),'Description'); ?>
        </td>


        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
          <td style=" border-top: none; ">&nbsp;<?= langg(get_setting($invoice_data['company_id'],'language'),'Batch No'); ?></td>
        <?php endif ?>
        
         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
          <td style=" border-top: none; ">&nbsp;<?= langg(get_setting($invoice_data['company_id'],'language'),'HSN'); ?></td>
        <?php endif ?>

       

       

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
          <td style="border-top: none; ">&nbsp;
            <?= langg(get_setting($invoice_data['company_id'],'language'),'Basic Rate'); ?>
          </td>
        <?php endif ?>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
          <td style="border-top: none;  ">&nbsp;
            <?php if (get_company_data($invoice_data['company_id'],'country')!='India'):?>
              <?= langg(get_setting($invoice_data['company_id'],'language'),'VAT'); ?>(%)
            <?php else: ?>
              <?= langg(get_setting($invoice_data['company_id'],'language'),'GST'); ?>(%)
            <?php endif ?>
          </td>
        <?php endif ?>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
          <td style="border-top: none;  ">&nbsp;
            <?php if (get_company_data($invoice_data['company_id'],'country')!='India'):?>
              <?= langg(get_setting($invoice_data['company_id'],'language'),'VAT Amt'); ?>
            <?php else: ?>
              <?= langg(get_setting($invoice_data['company_id'],'language'),'GST Amt'); ?>
            <?php endif ?>
          </td>
        <?php endif ?>

          <td style="border-top: none; ">&nbsp;
            <?= langg(get_setting($invoice_data['company_id'],'language'),'NET Rate'); ?>
          </td>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
          <td style="border-top: none; " >&nbsp;
            <?= langg(get_setting($invoice_data['company_id'],'language'),'Qty'); ?>
          </td>
        <?php endif ?>

        <?php if ($invoice_data['order_type']==''): ?>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
          <td style=" border-top: none; " class=""><?= langg(get_setting($invoice_data['company_id'],'language'),'Disc'); ?></td>
          <?php endif ?>
        <?php endif; ?>

        <td style="border-top: none; ">&nbsp;
          <?= langg(get_setting($invoice_data['company_id'],'language'),'Amount'); ?>
        </td>
      </tr>

       <?php $taxcount=0; $slno=0; foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; ?>
      <tr>
        <td style="border-bottom: none;border-top: none;">&nbsp;<?= $slno; ?></td>

        <td style="border-bottom: none;border-top: none; text-align: left;">&nbsp;<?= $ii['product'] ; ?><br>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_pro_desc')==1): ?>
            <small style="display: block; max-width:300px; color: #212529d4; font-size: 10px;"><?= nl2br($ii['desc']) ?></small>   
          <?php endif ?>
        </td>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
          <td style="border-bottom: none; border-top: none;" valign="baseline"><?= batch_no($ii['product_id']); ?></td>
        <?php endif ?>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
          <td style="border-bottom: none; border-top: none;" valign="baseline"><?= pro_identy($ii['product_id']); ?></td>
        <?php endif ?>
         

           <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
        <td valign="baseline" style="border-bottom: none;border-top: none;text-align: right; ">&nbsp;
          <?= aitsun_round($ii['price'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
        </td>
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
        <td class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>" valign="baseline" style="border-bottom: none;border-top: none; ">&nbsp;
          <?= invoice_percent_of_tax($ii['tax'],$invoice_data['company_id']); ?>%
        </td>
        <?php endif ?>

           <?php  $tax_amt=aitsun_round($ii['price']-$ii['discount'],get_setting($invoice_data['company_id'],'round_of_value'))*(invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])/100); ?>
        <?php  

        $before_net=$ii['price']*(invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])/100);
        $net_rate=$before_net+$ii['price']; 
        // $net_rate=$net_rate+aitsun_round($ii['discount'],get_setting($invoice_data['company_id'],'round_of_value'));
        ?>
        <?php  $total_amt=aitsun_round($net_rate,get_setting($invoice_data['company_id'],'round_of_value'))*aitsun_round($ii['quantity'],get_setting($invoice_data['company_id'],'round_of_value')); ?>

         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>

        <td valign="baseline" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>" style="border-bottom: none;border-top: none; ">
          
          <?= aitsun_round($tax_amt,get_setting($invoice_data['company_id'],'round_of_value')); ?>
        </td>
        <?php endif ?>

        <td valign="baseline" style="border-bottom: none; border-top: none;text-align: right;">
           <?=  aitsun_round($net_rate,get_setting($invoice_data['company_id'],'round_of_value')); ?>
        </td>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
        <td valign="baseline" style="border-bottom: none; border-top: none;width: 50px">&nbsp;
          <?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?>
        </td>
        <?php endif ?>

        <?php if ($invoice_data['order_type']==''): ?>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
            <td valign="baseline" style="border-bottom: none; border-top: none;text-align:right;" valign="baseline" class=""><?= aitsun_round($ii['discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
          <?php endif ?>
        <?php endif; ?>

        <td valign="baseline" style="border-bottom: none;border-top: none; text-align:right; ">
          <?= aitsun_round($total_amt,get_setting($invoice_data['company_id'],'round_of_value')); ?>
        </td>

        

        <!-- <td>&nbsp;</td> -->

   
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>


  <table style="border-bottom:none">
    <tr>
      <td style="width:70%; border-top: none;">
        <table style="border:none;border-top: none;">
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
            <?php $ttot=0;
              foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>
                <?php if (!empty($tds['tax_name'])): ?>
                  <tr>
                    <td style="border:none; padding: 0px 5px;font-size: 16px;" ><?= $tds['tax_name']; ?> </td>
                    <td style="border:none; font-size: 16px; padding: 0px 5px; text-align: right;">
                    
                       <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($tds['tax_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?> 
                    
                  </td>
                  </tr>
                <?php endif ?>
              <?php endforeach ?> 
              
           <?php endif ?>
        </table>
      </td>

      <td style="width:30%;border: none;" valign="baseline">

        <table style="line-height:1.5;font-size: 16px;border-bottom: none;border-top: none;border-left: none;border-right: none;" cellspacing="0" cellpadding="1" class="invoice_font" width="100">



          <tr>
            <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
              <?= langg(get_setting($invoice_data['company_id'],'language'),'Sub Total'); ?>
            </td>

            <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
             <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['sub_total']-$invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?></span>
            </td>
          </tr>

          
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
          
          <tr>
            <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
                <?= langg(get_setting($invoice_data['company_id'],'language'),'Total GST'); ?>
            </td>

            <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
              <?php if ($invoice_data['tax']>0): ?>
                  <span style="font-family: DejaVu Sans; ">
                  <?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
                <?php else: ?>
                  <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?>0</span>
                <?php endif ?>
            </td>
          </tr>
          <?php endif ?>


           <tr>
            <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
              <?= langg(get_setting($invoice_data['company_id'],'language'),'Incl. Tax'); ?>
            </td>

            <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
             <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['sub_total'],get_setting($invoice_data['company_id'],'round_of_value')); ?></span>
            </td>
          </tr>

           <?php if ($invoice_data['transport_charge']>0): ?>  
           <tr>
            <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
              <?= langg(get_setting($invoice_data['company_id'],'language'),'Transport Charge'); ?>
            </td>

            <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
             <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['transport_charge'],get_setting($invoice_data['company_id'],'round_of_value')); ?></span>
            </td>
          </tr>

          <?php endif ?>
        

          <tr>
            <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>
                <?= langg(get_setting($invoice_data['company_id'],'language'),'Round up'); ?>
              <?php endif ?>
            </td>

            <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>

              <?php if ($invoice_data['round_off']>0): ?>
                <?php if ($invoice_data['round_type']=='add'): ?>
                  <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?>+ <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?></span>
                <?php else: ?>
                 <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?> - <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?></span>
                <?php endif ?>
              <?php else: ?>
                <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?> <?= aitsun_round($invoice_data['total']-$invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?></span>
              <?php endif ?>
              <?php endif ?>

            </td>
          </tr>

          <?php if ($invoice_data['order_type']==''): ?>
            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
              <tr>
                <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
                    <?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?>
                </td>

                <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
                  <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['discount']+$invoice_data['additional_discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                </td>
              </tr>
            <?php endif ?>
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'due_amount')==1): ?>
            <?php if ($invoice_data['paid_status']=='unpaid'): ?>
            <tr>
              <td style="text-align: left;border-right: none;border-top: none;border-bottom: none;border-left: none;" class="invoice_font" colspan="2" >
                  <?= langg(get_setting($invoice_data['company_id'],'language'),'Due Amount'); ?>
              </td>

              <td class="invoice_font"  style="text-align: right;border-top: none;border-bottom: none; border-left: none;border-right: none;">
                <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['due_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
              </td>
            </tr>
            <?php endif ?>
          <?php endif ?>


        </table>
      </td>
    </tr>
    <tr>
      <td style="width:70%;text-align:left; border-bottom: none;" class="invoice_font" >
        <b><?= langg(get_setting($invoice_data['company_id'],'language'),' Amt in Words:'); ?></b>
        <span style="text-transform:capitalize"><?= numberTowords(aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')),$invoice_data['company_id']); ?></span>
      </td>
       <td style="text-align:right;width:30%; border-bottom: none;" class="invoice_font">
        <span style="font-family: DejaVu Sans;"><b><?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?></b></span>
      </td>
    </tr>

  </table>


<table>
  <tr>
    <td colspan="4" style="border-right: none;text-align:left;border-top: none;">
      <div style="color: black; font-size: 16px;">
      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bank_details')==1): ?>
        <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details'))){ ?>
          <div style="font-size:16px;margin-bottom: 10px;"><b><u>Bank Details :</u></b></div>
          <div style="font-size:16px;"></div>      
              <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details')); ?>
        <?php }else{echo "";} ?>
      <?php endif ?>
      </div>
    </td>
    <td colspan="4" style="border-left: none;text-align:right;">
      <div style="color:black; text-align:right; font-size:16px;">
        <h4 style="text-align:right;">For, <?= my_company_name($invoice_data['company_id']); ?></h4>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_seal')==1): ?>
            <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'))): ?>
                <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'); ?>"  style="width: 100px; object-fit: contain;">
            <?php endif ?> 
          <?php endif ?> 
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')==1): ?>
          <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'))): ?>
            <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'); ?>" style="width:100px; height: auto; object-fit: contain;">
          <?php endif ?> 
          <br>
          
          <div style="text-align:right;">--------------------------------------</div>
          AUTHORISED SIGNATORY
        <?php endif ?> 
        </div>
    </td>
   
  </tr>
  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_terms')==1): ?>
  <tr>
    <td colspan="8" style="text-align:left;font-size: 14px;border-bottom: 0;">
    <p>
      <b><?= langg(get_setting($invoice_data['company_id'],'language'),'Note:'); ?></b><br>
      <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms'))){ ?>
      <span>
        <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms')); ?>
      </span>
      <?php }else{echo "";} ?>
    </p>
    </td>
  </tr>
  <?php endif ?>

<?php if (is_payment_method($invoice_data['company_id'])): ?>
  <tfoot style="margin-bottom: 0px; border-bottom: 0.5px solid #C4C4C4;"  cellspacing="0" cellpadding="5" >
    <tr>
      <td colspan="8" style="text-align: center;border-top: 0;">
        <div>
          <h4 class="mb-4" style="color:#00000073; font-size: 12px;">
              <b>This Document is Generated by <a style="color:#e54a4a;" href="https://www.aitsun.com/">Aitsun ERP</a>.</b>
            </h4> 
        </div>
      </td>
    </tr>
  </tfoot>
<?php endif ?> 

</table>


      


       
</body>

</html>