<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
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
    embed {
        overflow: hidden !important;
    }
    table{width: 100%;}      
    body{
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
    }
  </style>
</head>
<body>


<div class="invoice_page">
  <table class="w-100">
    <tr style="color: black;">
      <?php foreach (my_company(company($user['id'])) as $cmp) { ?>
      <td>
        <div style="color:black ; font-weight: bold; font-size: 20px;"><b><?= $cmp['company_name']; ?></b></div>
        <div style="font-size: 14px;">
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
            <?php if (!empty($cmp['company_phone'])): ?>
              Mob: <?= $cmp['company_phone']; ?><br>
            <?php endif ?>
            <?php if (!empty($cmp['company_telephone'])): ?>
              Land: <?= $cmp['company_telephone']; ?><br>
            <?php endif ?>
            
              <?php if (!empty($cmp['gstin_vat_no'])): ?>
                <?php if ($cmp['country']=='India'): ?>
                     <b>GSTIN: <?= $cmp['gstin_vat_no']; ?></b>
                <?php else: ?>
                       <b>VAT IN: <?= $cmp['gstin_vat_no']; ?></b>
                <?php endif ?>
              <?php endif ?>

           
        </div> 
      </td>
      <td style="text-align:right;">
        
        <div> 
          <img src="<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo">
        </div>
        
      </td>
      <?php } ?>
    </tr>

    <tr>
      <td style="text-align:center;" colspan="5">
        <h3 style="color: black;"><b>

          <?php if ($voucher_data['voucher_type']=='expense'): ?> 
              PAYMENT
            <?php else: ?>
              RECEIPT
            <?php endif ?>


        </b></h3>
      </td>
    </tr>

    <tr>
      <td style="text-align:left;">
        <b>No. : </b>#<?= $voucher_data['id']; ?>
      </td>
      <td style="text-align:right;">
        <b>Date :</b> <?= get_date_format($voucher_data['voucher_date'],'d M Y'); ?>
      </td>
      </tr>
    <tr>
      <td colspan="5">
        <table class="w-100" border="1" cellpadding="5" cellspacing="0">
          <tr style="background: black;color: white;">
            <td style="border: 1px solid black;width: 50%;"><b>Particulars</b></td>
            <td style="border: 1px solid black;text-align: center;"><b>Price</b></td>
            <td style="border: 1px solid black;text-align: center;"><b>Quantity</b></td>
            <td style="border: 1px solid black;text-align: right;"><b>Amount</b></td>
          </tr>

          <?php foreach (voucher_items_array($voucher_data['id']) as $vit): ?>
            <tr>
              <td style="border: 1px solid black;">
                <?= get_group_data($vit['account_name'],'group_head') ; ?>
                <?php if (!empty($vit['payment_note'])): ?>
                  <p class="mb-0"><small>(<?= nl2br($vit['payment_note']) ?>)</small></p>
                <?php endif ?> 
            </td>
              <td style="border: 1px solid black;text-align: center;" valign="baseline"><?= aitsun_round($vit['price'],get_setting(company($user['id']),'round_of_value')); ?></td>
              <td style="border: 1px solid black;text-align: center;" valign="baseline"><?= $vit['quantity']; ?></td>
              <td style="border: 1px solid black;text-align: right;" valign="baseline"><?= aitsun_round($vit['amount'],get_setting(company($user['id']),'round_of_value')); ?></td>
            </tr>
          <?php endforeach ?>
          
          <tr> 
          <td style="border: 1px solid black;text-align: right;" colspan="3"><b>Total</b></td>
          <td style="border: 1px solid black;text-align: right;background: black;color: white;"><b><span style="font-family: DejaVu Sans;"><?= currency_symbol(company($user['id'])); ?></span><?= aitsun_round($voucher_data['total'],get_setting(company($user['id']),'round_of_value')); ?></b></td>
        </tr>
        <tr> 
          <td style="text-align: right;border: 1px solid black;" colspan="3"><b>Mode of Payment</b></td>
          <td style="text-align: right;border: 1px solid black;"><b><?= get_group_data($voucher_data['payment_type'],'group_head') ; ?></b></td>
        </tr>
        </table>
      </td>
    </tr>





    <tr>
          <td colspan="2" style="text-align:center;">
            <p class="m-0 text-muted"><?= langg(get_setting(company($user['id']),'language'),'If you have any questions about this, please contact'); ?> <br>
              <?php foreach (my_company(company($user['id'])) as $cmp) { ?>
                <span style="color:black;"><?= $cmp['company_name']; ?></span>, <?= langg(get_setting(company($user['id']),'language'),'phone'); ?>: <span style="color: black;"><?= $cmp['company_phone']; ?></span>, <?= langg(get_setting(company($user['id']),'language'),'email'); ?>: <span style="color: black;"><?= $cmp['email']; ?></span>
              <?php } ?>
            </p> 
          </td>
        </tr>


  </table>
</div>
</body>
</html>