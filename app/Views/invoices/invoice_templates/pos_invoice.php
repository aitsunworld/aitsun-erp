<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            size: 2.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

 

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center !important;
        }
        .end-align {
            text-align: end !important;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top: 1px dashed black;
            padding-top: 5px;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        /*.price::before {
             content: "\20B9";
            font-family: Arial;
            text-align: right;
        }*/

        .sum-up {
            text-align: right !important;
        }
        .total {
            font-size: 13px;
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .total.text, .total.price {
            text-align: right;
        }
        /*.total.price::before {
            content: "\20B9"; 
        }*/
        .line {
            border-top:1px solid black !important;
        }
        .heading.rate {
            width: 20%;
        }
        .heading.amount {
            width: 25%;
        }
        .heading.qty {
            width: 5%
        }
        p {
            padding: 1px;
            margin: 0;
        }
        section, footer {
            font-size: 12px;
        }
        .w-155{
            width: 155px!important;
        }
        td{
            padding: 1px 5px 1px 5px;
        }
    </style>
</head>
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
<body>
    <header>
        <div id="logo" class="media" style="height:30px;" >
          <img src="<?= base_url('public'); ?>/images/company_docs/<?php if($company_logo!= ''){echo $company_logo; }else{ echo 'company.png';} ?>" class="company_logo" style="width: auto;height: 100%;">
        </div>
       <p style="margin:0;font-size: 13px; padding: 15px 0;   border-bottom: 1px solid black !important">
         <b><?= $company_name; ?></b>  

        
        
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
                  <br> +<?= $company_phone; ?>
              <?php endif ?>
              <?php if (!empty($company_telephone)): ?>
                <br>  <?= $company_telephone; ?>
              <?php endif ?> 
              <?php if (!empty($company_email)): ?>
                <br>  <?= $company_email; ?>
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
          </p>

    </header>
 
    
    <table class="bill-details" border="0">
        <tbody>
            <tr>
                <td style="vertical-align: middle;">
                    <span class="receipt">
                        <b>
                          <?php if (is_medical($invoice_data['company_id'])): ?>
                            <?php if ($invoice_data['invoice_type']=='sales'): ?>
                              CASH MEMO
                            <?php else: ?>
                             <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?>
                            <?php endif ?> 
                          <?php else: ?>
                            <?= ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']))) ?>
                          <?php endif ?>
                        </b>
                  </span>


                    </td>
                 <td class="end-align">
                    Date : <span><b><?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?></b></span><br>
                    <?php if (is_medical($invoice_data['company_id'])): ?>
                        <?php if ($invoice_data['invoice_type']=='sales'): ?>
                            Invoice.
                        <?php else: ?>
                            No.
                        <?php endif ?>
                    <?php else: ?>
                    No.
                    <?php endif ?> # : 
                    <span style="font-weight: bold;">
                        <?= inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?>
                    </span> 
              </td>
            </tr> 
            
        </tbody>
    </table>
    
    <table class="items">
        <thead>
            <tr>
                <th class="heading name center-align" colspan="4">Item</th>
            </tr>
            <tr>
                <th class="name center-align" style="border-bottom: 1px solid black;padding: 0;" colspan="4"></th>
            </tr>
        </thead>
       
        <tbody>

            <?php $taxcount=0; $slno=0; foreach (invoice_items_array($invoice_data['id']) as $ii): $slno++; ?>
            <tr>
                <td colspan="4" style="border-bottom:1px solid black;padding: 2px 5px 1px 5px;" >
                    <p><b><?= $ii['product'] ; ?></b></p>
                    <span><b><?= $ii['quantity']; ?></b> <?= unit_name($ii['in_unit']); ?> x <?= currency_symbol($invoice_data['company_id']); ?> <?= aitsun_round($ii['price'],get_setting($invoice_data['company_id'],'round_of_value')); ?> / <?= unit_name($ii['in_unit']); ?></span><br>
                    <?php if ($ii['discount_percent']!=0): ?>
                        <span>With a <?= $ii['discount_percent']; ?>% discount</span>
                    <?php endif ?>
                    
                    <p class="end-align" style="font-size: 13px;"><b><?= currency_symbol($invoice_data['company_id']); ?> <?= aitsun_round($ii['price']*$ii['quantity'],get_setting($invoice_data['company_id'],'round_of_value')); ?></b></p>
                    
                </td>
            </tr>
            
            <?php endforeach ?>

            


           
            <tr>
                <td colspan="3" class="sum-up line w-155" >Subtotal :</td>
                <td class="line price">
                    <span style="font-family: DejaVu Sans; font-size: 12px;"><?= currency_symbol($invoice_data['company_id']); ?></span>
                    <?= aitsun_round($invoice_data['sub_total']-$invoice_data['tax'],get_setting($invoice_data['company_id'],'round_of_value'),PHP_ROUND_HALF_UP); ?>
                </td>
            </tr>

            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>
         
          <?php

           
          $ttot=0;
           foreach (all_taxes_of_invoice($invoice_data['company_id'],$invoice_data['id']) as $tds): ?>
            <?php if (!empty($tds['tax_name'])): ?>
               <tr>
                  <td colspan="3" class="sum-up w-155" ><?= $tds['tax_name']; ?> :</td>
                  <td class="price">
                    
                       <span style="font-family: DejaVu Sans; "><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($tds['tax_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?> 
                    
                  </td>
                </tr>
            <?php endif ?>
           
          <?php endforeach ?> 
            
            <?php if (get_company_data($invoice_data['company_id'],'country')!='Oman'):?>

           <tr >
            <td colspan="3" class="sum-up w-155" ><?= langg(get_setting($invoice_data['company_id'],'language'),'Taxable Amount'); ?> :</td>
            <td class="price">
              
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


            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'round_off')==1): ?>
            <?php if ($invoice_data['round_off']!=0): ?>
            <tr>
                <td colspan="3" class="sum-up w-155" >Round off :</td>
                <td class="price">
                    
                    <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span>

                  <?php if ($invoice_data['round_off']>0): ?>
                      <?php if ($invoice_data['round_type']=='add'): ?>
                        +<?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php else: ?>
                        -<?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php endif ?>
                  <?php else: ?>
                    <?= aitsun_round($invoice_data['total']-$invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                  <?php endif ?>
                </td>
            </tr>
            <?php endif ?>
            <?php endif ?>
            <tr>
                <th colspan="3" class="total text w-155" style="font-size:15px; padding: 5px;">Total:</th>
                <th class="total price" style="font-size:15px; padding: 5px;"><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice_data['company_id']); ?></span><?= aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?></th>
            </tr>
        </tbody>
    </table>
    <section >
        <p style="padding-top: 5px;padding-left: 5px;">
            Payment Mode : 
            <span>
                <?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_return'): ?>
                  <?= mode_of_payment($invoice_data['company_id'],$invoice_data['id']); ?>
                <?php else: ?>
                  ---
                <?php endif ?>
            </span>
        </p>
       
    </section>
    <?php if (!empty(trim($invoice_data['notes']))): ?>
    <footer style="text-align:center;padding-top: 10px;">
        <p style="text-align:center ;border-top:1px solid black;">
            <?= nl2br($invoice_data['notes']) ?>
        </p>
    </footer>
     <?php endif ?>
</body>
</html>