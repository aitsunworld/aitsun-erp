<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $title ?></title>
<?php
// Original color
  $baseColor = get_setting($invoice_data['company_id'],'Invoice_color');



 // Function to adjust opacity of the color
function adjustOpacity($color, $opacity) {
    $color = str_replace('#', '', $color);
    $r = hexdec(substr($color, 0, 2));
    $g = hexdec(substr($color, 2, 2));
    $b = hexdec(substr($color, 4, 2));

    return "rgba($r, $g, $b, $opacity)";
}

// Adjust opacity to 50%
$lighterColor = adjustOpacity($baseColor, 0.07);
$darklight = adjustOpacity($baseColor, 0.03);
  ?>
   <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  
    :root {
      --bg-color: <?= $baseColor ?>;
      --bg-light-color: <?= $lighterColor ?>;
      --bg-darklight-color: <?= $darklight ?>;
      --font-color: <?= get_setting($invoice_data['company_id'],'invoice_font_color'); ?>;
    }
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
       font-family: 'Poppins'!important;            
    }

    .address_box{
      background: var(--bg-light-color);
      padding: 15px 20px;
      border-radius: 10px;
      width: 100%; 
    }
    .company_details ul{
      list-style: none;
    }
    .company_details ul a{
      text-decoration: none;
      color: black;
      font-size: 14px;
    }
    .table_head td{
       padding:5px 10px;
    }
 </style>
</head>
<body>

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

  <!-- Header -->
  <table>
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
  <!-- Header -->

  <!-- Heading -->
 <table>
   <tr>
     <?php $center_style=''; if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_logo')==1): $center_style='text-align:center;';?>
        
          <td> 
                
                  <img src="<?= base_url('public'); ?>/images/company_docs/<?php if($company_logo!= ''){echo $company_logo; }else{ echo 'company.png';} ?>" class="company_logo" style="width: auto; height: 60px; ">
          </td>
      <?php endif ?>
     <td style="<?= $center_style; ?>">
       <h1 style="color: var(--bg-color); text-transform: capitalize;">
         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
          <?php if (is_medical($invoice_data['company_id'])): ?>
            <?php if ($invoice_data['invoice_type']=='sales'): ?>
              CASH MEMO
            <?php else: ?>
             <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?>
            <?php endif ?> 
          <?php else: ?>
            <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?>
          <?php endif ?>
         <?php endif ?>
       </h1>
     </td>
     <td>
      <div style="display: flex; justify-content: end; line-height: 2;">
        <div>
          
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_num')==1): ?>
            <p style="margin:0;line-height: 1.6;">
              <?php if (is_medical($invoice_data['company_id'])): ?>
                <?php if ($invoice_data['invoice_type']=='sales'): ?>
                  Invoice.
                <?php else: ?>
                  No.
                <?php endif ?>
              <?php else: ?>
                No.
              <?php endif ?> 

              <span style="font-weight: bold;">
                <?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?>
              </span> 
            </p> 
          <?php endif ?>
          
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_mrn_num')==1): ?>
              <p style="margin:0;line-height: 1.6;">
               MRN No :  <span style="font-weight: bold;"><?= $invoice_data['mrn_number']; ?> </span> 
              </p>
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_date')==1): ?>
              <p style="margin:0;line-height: 1.6;">
              Date:  <span style="font-weight: bold;"><?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?></span>
              </p>
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_due_date')==1): ?>

             <p style="margin:0;line-height: 1.6;">
              <?php if ($invoice_data['invoice_type']=='sales'): ?>
               Due Date: 
              <?php else: ?>
               Validity:
              <?php endif ?>
               <span style="font-weight: bold;"><?php $Date = $invoice_data['invoice_date']; ?><?= date('d M Y',strtotime($Date. ' + 7 days')); ?></span>
              
              </p> 
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_number')==1): ?>
             <p style="margin:0;line-height: 1.6;">
               Bill no:  
              <?php if (!empty($invoice_data['bill_number'])): ?>
              <span style="font-weight: bold;"><?= $invoice_data['bill_number']; ?></span>
              <?php else: ?>
              ---
              <?php endif; ?>
              </p> 
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_vehicle_number')==1): ?>
            <?php if (!empty(trim($invoice_data['vehicle_number']))): ?>
              Vehicle No: <span style="font-weight: bold;"><?= strtoupper($invoice_data['vehicle_number']); ?></span>
            <?php endif ?>
          <?php endif ?>
        
        </div>
      </div>
     </td>
   </tr>
 </table>
  <!-- Heading -->


  <!-- Customer details --> 
  <div style="display:flex; width: 100%; gap: 20px;">
    <div class="address_box">
       <h4 style="font-weight:400; margin:0;color: var(--bg-color);">
         <?php if (is_medical($invoice_data['company_id'])): ?>
            <?php if ($invoice_data['invoice_type']=='sales'): ?>
              Hospital/Clinic Details 
            <?php else: ?>
              <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?> By
            <?php endif ?> 

          <?php else: ?>
             <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?> By
          <?php endif ?>
        </h4>
      <p style="margin:0;font-size: 14px; padding-top: 5px;">
         <b><?= $company_name; ?></b> 
         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_business_address')==1): ?>

        
        
        <?php if (!empty($address)): ?>
          <br> <?= nl2br($address); ?>
         <?php endif ?> 
         <!-- <php if (!empty($city)): ?>
          <br> <= $city; ?>,
         <php endif ?> 
         <php if (!empty($state)): ?>
          <= $state; ?>, 
          <php endif ?>
          <php if (!empty($country)): ?>
            <= $country; ?>
          <php endif ?>
          <php if (!empty($postal_code)): ?>
            <br> Pin: <= $postal_code; ?>
          <php endif ?> -->
          
          <?php if (!empty($company_phone)): ?>
              <?php 
              if (substr($company_phone, 0, 3) === '968') {
                  $company_phone = substr_replace($company_phone, ' ', 3, 0);
              }
              ?>
              <br>  Mob: +<?= $company_phone; ?>
          <?php endif ?>
          <?php if (!empty($company_telephone)): ?>
            <br> Land: <?= $company_telephone; ?>
          <?php endif ?> 
          <?php if (!empty($company_email)): ?>
            <br> Email: <?= $company_email; ?>
          <?php endif ?> 

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_details')==1): ?>
            <?php if (!empty($cmp['gstin_vat_no'])): ?>

              <?php if (get_company_data($invoice_data['company_id'],'country')=='India'):?>
                <br><b>GSTIN: <?= $cmp['gstin_vat_no']; ?></b>
              <?php else: ?>
                <br><b>VATIN: <?= $cmp['gstin_vat_no']; ?></b>
              <?php endif ?> 
              <?php endif ?>

              <?php if (get_company_data($invoice_data['company_id'],'country')=='Oman'):?>
                  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax_tin_num')==1): ?>
                    <br>
                    <b>
                    <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'taxnumber'))): ?>
                      
                    TAX CARD NO: <?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'taxnumber'); ?> / TIN: <?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'tinnumber'); ?>
                    <?php endif ?>
                  </b>
                <?php endif ?>

            <?php endif ?>
          <?php endif ?> 
        <?php endif ?>
      </p>
      </div>
    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bill_to')==1): ?>
      <div class="address_box"> 

       <h4 style="font-weight:400; margin:0;color: var(--bg-color);">
           <?php if (is_medical($invoice_data['company_id'])): ?>
            <?php if ($invoice_data['invoice_type']=='sales'): ?>
              Patient Details 
            <?php else: ?>
              <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?> To
            <?php endif ?> 

          <?php else: ?>
             <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?> To
          <?php endif ?>
        </h4>

       <p style="margin:0;font-size: 14px; padding-top: 5px;">
                <?php if ($invoice_data['customer']!='CASH'): ?>
                  <b><?=  user_name($invoice_data['customer']); ?></b>

                  

                  <?php if (!empty(billing_address_of($invoice_data['customer']))): ?>
                      
                      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
                        <br><?= nl2br(billing_address_of($invoice_data['customer'])) ?>
                      <?php endif ?>
                

                  <?php endif ?> 

                  <?php if (!empty(gst_no_of($invoice_data['customer']))): ?>
                   <br><b><?= langg(get_setting($invoice_data['company_id'],'language'),'GST No'); ?>: <?= gst_no_of($invoice_data['customer']); ?></b>
                  <?php endif ?> 

                  <?php elseif ($invoice_data['alternate_name']==''): ?> 
                    <b><?= langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER'); ?></b> 
                  <?php else: ?> 
                    <b><?= $invoice_data['alternate_name']; ?></b> 
                <?php endif ?>
       </p>
      </div>
    <?php endif; ?>
  </div>


  <div style="display:flex; width: 100%; gap: 20px; font-size: 14px;">
    <?php if (!empty($state)): ?>
           <div style="width:100%; padding-left: 20px;margin-top: 5px;">Place of Supply <b><?= $state; ?></b></div>
    <?php endif ?>
   
    <div style="width:100%; padding-left: 20px;margin-top: 5px;">Country of Supply <b><?= $country; ?></b></div>
  </div>
  <!-- Customer details -->










<!-- ////////////////////////////////////////PRODUCTS//////////////////////////////
////////////////////////////////////////PRODUCTS//////////////////////////////
////////////////////////////////////////PRODUCTS//////////////////////////////
////////////////////////////////////////PRODUCTS////////////////////////////// -->
<br>
  <!-- Item Table -->
  <table style="" cellpadding="10" cellspacing="0">
    <tr style="background: var(--bg-color);color:var(--font-color);" class="table_head"> 
      <td style=""><?= langg(get_setting($invoice_data['company_id'],'language'),'Product / Service details'); ?></td>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
      <td style=" text-align:center;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Batch No'); ?>.</td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
      <td style=" text-align:center;"><?= langg(get_setting($invoice_data['company_id'],'language'),'HSN Code'); ?>.</td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
      <td style=" text-align:center;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Exp'); ?>. </td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
      <td style=" text-align:center;"><?= langg(get_setting($invoice_data['company_id'],'language'),'Qty'); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
      <td style=" text-align:center;"><?= langg(get_setting($invoice_data['company_id'],'language'),'UOM'); ?></td>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
      <td style=" text-align:center;" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= langg(get_setting($invoice_data['company_id'],'language'),'Rate'); ?></td>
       <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?> 
        <td  style=" padding: 0px 5px; text-align: center; width: 115px;" class="">
          <?php if (get_company_data($invoice_data['company_id'],'country')=='Oman'):?>
            <?= langg(get_setting($invoice_data['company_id'],'language'),'VAT'); ?>.(%)
          <?php else: ?>
            <?= langg(get_setting($invoice_data['company_id'],'language'),'GST'); ?>.(%)
          <?php endif ?> 
        </td>  
        <?php endif ?>


       <?php if ($invoice_data['order_type']==''): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td style=" text-align:center;" class=""><?= langg(get_setting($invoice_data['company_id'],'language'),'Discount'); ?></td>
        <?php endif ?>
      <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
        <td style=" text-align:end;" class=""><?= langg(get_setting($invoice_data['company_id'],'language'),'Amount'); ?></td>
      <?php endif; ?>
    </tr>

     <?php $taxcount=0; $slno=0; foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; ?>
      <tr style=" background:<?php echo ($slno % 2 == 0) ? "var(--bg-light-color)" : "var(--bg-darklight-color)"; ?>;" id="thisheight"> 
        <td style="border-bottom: 1px solid #b7b7b7;" valign="baseline">
          <b style="color:var(--bg-color);"><?= $slno ?>. <?= $ii['product'] ; ?></b> <br>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_pro_desc')==1): ?>
          
          <p style="margin:0; padding-left: 30px; font-size: 14px;">
             <?= nl2br($ii['desc']) ?>
          </p>
          <?php endif ?>
           
        </td>
         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_batch_no')==1): ?>
         <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline"><?= batch_no($ii['product_id']); ?></td>
         <?php endif ?>

         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_hsncode_no')==1): ?>
         <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline" ><?= pro_identy($ii['product_id']); ?></td>
         <?php endif ?>

         
         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_expiry_date')==1): ?>
          <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline"><?= expiry_date($ii['product_id']); ?></td>
          <?php endif ?>


        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?>
        <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline"><?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?></td>
        <?php endif ?>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_uom')==1): ?>
            <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline" ><?= unit_name($ii['in_unit']); ?></td>
        <?php endif ?>

        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?>
        <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline" class=""><?= aitsun_round($ii['price'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
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

        <!-- <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline" class="<php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><= $inc_taxxxx; ?></td> -->


       <td style="border-bottom: 1px solid #b7b7b7; text-align:center; " valign="baseline" class="<?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>"><?= invoice_percent_of_tax($ii['tax'],$invoice_data['company_id']); ?>%</td>

         


       <td style="border-bottom: 1px solid #b7b7b7; text-align:right;  display: none;" valign="baseline" class="d-none <?php if ($invoice_data['invoice_type']=='sales_delivery_note'){echo 'dl-none';} ?>">
        <?php if (invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])!=''): ?>
           <?= ($ii['price']*$ii['quantity'])*invoice_percent_of_tax($ii['tax'],$invoice_data['company_id'])/100; ?> 

          

        <?php endif ?>
        </td>


        <?php endif ?>

        <?php if ($invoice_data['order_type']==''): ?>
          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>
        <td style="border-bottom: 1px solid #b7b7b7; text-align:right; " valign="baseline" class=""><?= aitsun_round($ii['discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?></td>
        <?php endif ?>
        <?php endif; ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_amount')==1): ?>
        <td style="border-bottom: 1px solid #b7b7b7; text-align:right; width: 130px;" valign="baseline" class="">
          
             <?= aitsun_round($ii['price']*$ii['quantity'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
          </td>
          <?php endif ?>
      </tr>
      <?php endforeach ?>

  </table>
  <!-- Item Table -->
  <!-- ////////////////////////////////////////PRODUCTS//////////////////////////////
////////////////////////////////////////PRODUCTS//////////////////////////////
////////////////////////////////////////PRODUCTS//////////////////////////////
////////////////////////////////////////PRODUCTS////////////////////////////// -->












  <br>
  <div style="display:flex;">
    <div style="width:100%; padding-right:50px;"> 
       <p style="font-size: 13px;">For any enquiries, email us on <b><?= $company_email ?></b> or <br>call us on <b>+<?= $company_phone ?></b></p>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_bank_details')==1): ?>
          <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details'))){ ?>
            <h4 style="color:var(--bg-color);margin-bottom: 5px;">Bank details</h4>
            <p style="margin-top: 5px; font-size:13px;">  
              <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'bank_details')); ?>
            </p>
          <?php } ?>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_qr_code')==1): ?>
        <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'))): ?>
        <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_qr_code'); ?>"  style="width: 150px; object-fit: contain;">
        <?php endif ?> 
      <?php endif ?> 
    </div>
    <div style="width:60%;">
      <!-- subtotal  -->
      <div style="display:flex; justify-content:space-between;">
        <div><span style="font-weight: 500;">Sub total</span></div>
        <div>
          <span style="font-weight: 500;">
            <span ><?= currency_symbol($invoice_data['company_id']); ?></span>
            <?= aitsun_round($invoice_data['sub_total']-$invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
          </span>
        </div>
      </div>

      <?php if ($invoice_data['order_type']==''): ?>
        <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?> 
          <div style="display:flex; justify-content:space-between;">
            <div><span style="font-weight: 500; color:#049b04;">Discount</span></div>
            <div>
              <span style="font-weight: 500; color:#049b04;">
                  <?= currency_symbol($invoice_data['company_id']); ?>
                  <?= aitsun_round($invoice_data['discount']+$invoice_data['additional_discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
              </span>
            </div>
          </div>
        <?php endif ?>
      <?php endif ?>


      
      

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
         
          <?php 
          $ttot=0;
           foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>
            <?php if (!empty($tds['tax_name'])): ?>
               
               <div style="display:flex; justify-content:space-between;">
                  <div><span style="font-weight: 500;"><?= $tds['tax_name']; ?></span></div>
                  <div>
                    <span style="font-weight: 500;">
                      <?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($tds['tax_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?> 
                    </span>
                  </div>
                </div>

            <?php endif ?>
           
          <?php endforeach ?> 

            <?php if (get_company_data($invoice_data['company_id'],'country')!='Oman'):?>
                <div style="display:flex; justify-content:space-between;">
                  <div><span style="font-weight: 500;">Tax amount</span></div>
                  <div>
                    <span style="font-weight: 500;">
                      <?php if ($invoice_data['tax']>0): ?>
                        <?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
                      <?php else: ?>
                        <?= currency_symbol($invoice_data['company_id']); ?>0
                      <?php endif ?>
                    </span>
                  </div>
                </div>

              <?php endif ?>

          
          <?php endif ?>

          <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>
              <div style="display:flex; justify-content:space-between;">
                  <div><span style="font-weight: 500;">Round off</span></div>
                  <div>
                    <span style="font-weight: 500;">
                      <?= currency_symbol($invoice_data['company_id']); ?>

                  <?php if ($invoice_data['round_off']>0): ?>
                      <?php if ($invoice_data['round_type']=='add'): ?>
                        + <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php else: ?>
                        - <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php endif ?>
                  <?php else: ?>
                    <?= aitsun_round($invoice_data['total']-$invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                  <?php endif ?>
                    </span>
                  </div>
                </div>
          
              <?php endif ?>

      <hr>
      <div style="display:flex; justify-content:space-between;">
        <div  style="margin:auto 0;"><span style="font-weight:bold;">Total</span></div>
        <div><span style="font-weight: 800;
    font-size: 24px; color:#049b04;"><?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?></span></div>
      </div>

      <div style="">
        <div  style="margin:auto 0; font-size: 12px;color: #919191;"><span>Total (in words)</span></div>
        <div><span style="font-size:13px;"><?= currency_symbol2($invoice_data['company_id']); ?> <?= ucwords(numberTowords(aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')),$invoice_data['company_id'])); ?></span></div>
      </div>
       <hr>


      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'due_amount')==1): ?>

        <?php if ($invoice_data['paid_status']=='unpaid'): ?>
          <div style="display:flex; justify-content:space-between;">
            <div><span style="font-weight: 500;">Due amount</span></div>
            <div>
              <span style="font-weight: 500;">
                <?= currency_symbol($invoice_data['company_id']); ?><?= aitsun_round($invoice_data['due_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
              </span>
            </div>
          </div>
         
        <?php endif ?>
      <?php endif ?>

      <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'mode_of_payment')==1): ?>
        <?php if (trim(mode_of_payment($invoice_data['company_id'],$invoice_data['id']))!=''): ?>
          <div style="display:flex; justify-content:space-between;">
            <div><span style="font-weight: 500;">Mode of payment</span></div>
            <div>
              <span style="font-weight: 500;">
                <?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_return'): ?>
                  <?= mode_of_payment($invoice_data['company_id'],$invoice_data['id']); ?>
                <?php else: ?>
                  ---
                <?php endif ?>
              </span>
            </div>
          </div> 
       <?php endif ?>
       <?php endif ?>

      <div style=" margin-top: 30px;">
              
                
            
 
              <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_signature')==1): ?>

                <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'))): ?>
                  <div style="text-align:center; ">
                     <div>
                       <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_seal')==1): ?>
                      <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'))): ?>
                          <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_seal'); ?>"  style="width: 100px; object-fit: contain;">
                      <?php endif ?> 
                    <?php endif ?>
                    
                    <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_signature'); ?>" style="width:100px; height: auto; object-fit: contain;">
                     </div>
     
        
                    <div style="text-align:right; width: 100%; text-align:center; border-top: 1px dashed;"></div>
                    <div style="text-align:right; width: 100%; text-align:center;">Authorized Signature</div>
                  </div>
                <?php endif ?>

                 <div style="text-align:left;">
                   <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_declaration')==1): ?>
                    <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration'))){ ?>
                      <h4 style="color:var(--bg-color);margin-bottom: 5px;">Declaration</h4>
                      <p style="margin-top: 0px; font-size:13px; margin-bottom: 15px;">  
                        <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_declaration')); ?>
                      </p>
                    <?php } ?>
                <?php endif ?>
                </div>

              <?php endif ?> 
              </div>
      </div>

    </div>

    
  </div>

  <?php if (!empty(trim($invoice_data['notes']))): ?>
    <div>
      <h4 style="color:var(--bg-color);margin-bottom: 5px;">Additional Notes</h4>
      <p style="margin-top: 5px; font-size:13px;"><?= nl2br($invoice_data['notes']) ?></p>
    </div>
  <?php endif ?>

 
   
   <div style="">
      <h4 style="color:var(--bg-color);margin-bottom: 5px;margin-top: 0;">Terms & Conditions</h4>
      <p style="margin-top: 5px; font-size:13px;line-height: 1.7;">
         <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_terms')==1): ?>
          <?php if (!empty(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms'))){ ?>
           <?=nl2br( get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_terms')); ?>        
            <?php }else{echo "";} ?>
          <?php endif ?>
      </p>  
    </div>


<hr style="margin-top: 40px;">
    <div class="company_details" style="text-align: center;margin-top: 30px;">
      <h2 style="color:var(--bg-color);">Give yourself the best chance of Success</h2>
      <div style="display:flex; width:100%;">
        <div>
          <img style="width:100%;" src="https://www.csloman.com/public/images/main_slide1.webp">
        </div>
        <div>
          <img style="width:100%;" src="https://www.csloman.com/public/images/main_slide2.webp">
        </div>
        <div>
          <img style="width:100%;" src="https://www.csloman.com/public/images/main_slide3.webp">
        </div>
      </div>
      
      

      <p style="font-size:14px;">We are Concept Solutions LLC, a reputed IT company based in Oman, with a view of spreading world wide.
      We are specialised in the field of Web design and development, Mobile application development, Domain registration, Web hosting, E-mail support, Graphic designing and Digital marketing, POS Software and Business software tool development.</p>

      <h2 style="color:var(--bg-color);">Know About Our Work</h2>
      <table class="">
        <tr>
          <td style="width:50%;" valign="baseline">
              <div style="text-align:left;">
                  <a href="https://www.csloman.com/website-design" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">Web Development</h3></a>
                  <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                      <li><a href="https://www.csloman.com/e-commerce-website">> Ecommerce Website</a></li>
                      <li><a href="https://www.csloman.com/catalogue-website">> Catalogue Website</a></li>
                      <li><a href="https://www.csloman.com/portal-website">> Portal Website</a></li>
                      <li><a href="https://www.csloman.com/wordpress-website">> Wordpress Website</a></li>
                      <li><a href="https://www.csloman.com/static-website">> Static Website</a></li>
                      <li><a href="https://www.csloman.com/dynamic-website">> Dynamic Website</a></li>
                      <li><a href="https://www.csloman.com/blog-website">> Blog / News Website</a></li>
                      <li><a href="https://www.csloman.com/customized-web-application">> Customized Web Application</a></li>
                  </ul>
              </div>
          </td>
          <td style="width:50%;" valign="baseline">
            <div style="text-align:left;">
                <a href="https://www.csloman.com/software-development" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">Software Development</h3></a>

                <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                    <li><a href="https://www.csloman.com/erp-solutions"> > ERP Software</a></li>
                    <li><a href="https://www.csloman.com/pos-point-of-sale"> > Point of Sale (POS)</a></li>
                    <li><a href="https://www.csloman.com/crm-software"> > CRM Software</a></li>
                    <li><a href="https://www.csloman.com/school-management-system"> > School Software</a></li>
                    <li><a href="https://www.csloman.com/inventory-management-software"> > Billing Software</a></li>
                    <li><a href="https://www.csloman.com/cloud-computing"> > Cloud Computing &amp; Cloud based data storage</a></li>
                    <li><a href="https://www.csloman.com/customized-software"> > Customized Software</a></li>
                </ul>
            </div>

          </td>
        </tr>

        <tr>
          <td style="width:50%;" valign="baseline">
            
              <div style="text-align:left;">
                  <a href="https://www.csloman.com/graphic-design" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">Branding & Identity</h3></a>

                  <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                      <li><a href="https://www.csloman.com/logo-design">> Logo Designing</a></li>
                      <li><a href="https://www.csloman.com/brochure-design-and-flyer-design">> Brochure & Flyer Designing</a></li>
                      <li><a href="https://www.csloman.com/business-card-design">> Business / Visiting Cards</a></li>
                      <li><a href="https://www.csloman.com/social-media-poster-design">> Social Media Posters</a></li>
                      <li><a href="https://www.csloman.com/advertising-and-motion-graphics">> Advertising & Motion Graphics</a></li>
                  </ul>
              </div>
          </td>
          <td style="width:50%;" valign="baseline">
            <div style="text-align:left;">
              <a href="https://www.csloman.com/mobile-application-development" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">Mobile App Development</h3></a>

              <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                  <li><a href="https://www.csloman.com/android-app-development">> Android App</a></li>
                  <li><a href="https://www.csloman.com/ios-app-development">> iOS App</a></li>
                  <li><a href="https://www.csloman.com/native-apps">> Native App</a></li>
              </ul> 
   
            </div>

          </td>
        </tr>
        <tr>
           <td style="width:50%;" valign="baseline">
            <div style="text-align:left;">
           
              
              <a href="https://www.csloman.com/digital-marketing" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">Digital Marketing</h3></a>

              <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                  <li><a href="https://www.csloman.com/search-engine-optimization">> Search Engine Optimization (SEO)</a></li>
                  <li><a href="https://www.csloman.com/social-media-marketing">> Social Media Marketing (SMM)</a></li>
                  <li><a href="https://www.csloman.com/email-and-sms-marketing">> Email & SMS Marketing</a></li>
                  <li><a href="https://www.csloman.com/google-ads-marketing">> Google Ads Marketing</a></li>
              </ul> 

            </div>

          </td>

           <td style="width:50%;" valign="baseline">
            
            <div style="text-align:left;">
                <a href="https://www.csloman.com/erp-system" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">Business Tools/ERP</h3></a>

                <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                    <li><a href="https://www.csloman.com/pos-point-of-sale">> POS Billing</a></li>
                    <li><a href="https://www.csloman.com/human-resource-management">> HR Management & Payroll</a></li>
                    <li><a href="https://www.csloman.com/transport-management-system">> Transport Management</a></li>
                </ul>
            </div>


          </td>

        </tr>


        <tr>
           <td style="width:50%;" valign="baseline">
             

            <div style="text-align:left;">
                <a href="https://www.csloman.com/it-products-and-it-services" style="text-decoration: none;color:var(--bg-color);"><h3 style="margin:0;">IT Products</h3></a>

                <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                    <li><a href="https://www.csloman.com/it-products-and-it-services">> Laptops, Towers PC's & Accessories</a></li>
                    <li><a href="https://www.csloman.com/it-products-and-it-services">> Printers, Scanners & Accessories</a></li>
                    <li><a href="https://www.csloman.com/it-products-and-it-services">> POS Machines & Thermal Printers</a></li>
                    <li><a href="https://www.csloman.com/it-products-and-it-services">> Barcode Printers & Scanners</a></li>
                    <li><a href="https://www.csloman.com/it-products-and-it-services">> Weighing Machines</a></li>
                </ul>
            </div>


          </td>

           <td style="width:50%;" valign="baseline">
            
          

            <div  style="text-align:left;">
              <a href="https://www.csloman.com/link-shortener-and-qr-code-generator" style="text-decoration: none;color:var(--bg-color);"><h3  style="margin:0;">ShortLinkHub</h3></a>

              <ul style="list-style: none; margin-top: 5px; padding-left: 0;">
                  <li><a href="https://www.csloman.com/link-shortener-and-qr-code-generator">> Link Shortner</a></li>
                  <li><a href="https://www.csloman.com/link-shortener-and-qr-code-generator">> QR Code Generator</a></li>
              </ul>
          </div>



          </td>

        </tr>
      </table>

      <div>
        <p style="text-align:left;">
          Please respond to or approve the above proposal as soon as possible. <br> Hopefully we will be
able to build a long-term mutually beneficial relationship. <br><br>
Regards, <br>
<span style="color:var(--bg-color);">Concept Solutions LLC</span> 
        </p>
      </div>


  <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_footer')==1): ?>
    <div style="margin:0;">
      <?php foreach (my_company($invoice_data['company_id']) as $cmp) { ?>
        <?= nl2br(get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'invoice_footer')); ?>
      <?php } ?>
    </div>
  <?php endif ?> 

 
   
    
  <?php if (is_payment_method($invoice_data['company_id'])): ?>
    <div style="margin:0;">
      <h4 class="mb-4" style="color:#00000073; font-size: 12px;">
        <b>This document is generated by <a style="color:#e54a4a; text-decoration:none;" href="https://www.aitsun.com/">Aitsun ERP</a>.</b>
      </h4> 
    </div> 
  <?php endif ?> 
 


    </div>

</body>
</html>