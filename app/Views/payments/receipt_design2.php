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
        table{width: 100%;}      
        body{
            font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
        }
    </style>
</head>
<body>
   <?php  
       $payment_id=$pmt['id'];
       $company=company($user['id']);
       $userid=$user['id'];
       $bill_type=$pmt['bill_type'];
       $customer=$pmt['customer'];
       $alternate_name=$pmt['alternate_name'];
       $type=$pmt['type'];
       $amount=aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value'));
       $payment_note=$pmt['payment_note'];
       $account_name=$pmt['account_name'];
       $datetime=$pmt['datetime'];
   ?>


    <table class="w-100">
        <tr>
            <td class="px-2">
                <?php foreach (my_company($company) as $cmp) { ?>
                <div class="d-flex"> 
                 
                  <div style="margin-bottom:0; font-size: 20px;font-weight: bold;"><?= $cmp['company_name']; ?></div>
                    <div style="max-width: 300px; font-size:14px;">
                    <?php if (!empty($cmp['city'])): ?>
                      <?= $cmp['city']; ?>,
                    <?php endif ?>
                    <?php if (!empty($cmp['state'])): ?>
                      <?= $cmp['state']; ?>,
                    <?php endif ?>
                    <?php if (!empty($cmp['country'])): ?>
                      <?= $cmp['country']; ?>
                    <?php endif ?>
                    <?php if (!empty($cmp['postal_code'])): ?>
                      Pin: <?= $cmp['postal_code']; ?><br>
                    <?php endif ?>
                    <?php if (!empty($cmp['company_phone'])): ?>
                      Mob: <?= $cmp['company_phone']; ?>,
                    <?php endif ?><br>
                    <?php if (!empty($cmp['company_phone'])): ?>
                    GST/VAT: <?= $cmp['gstin_vat_no']; ?>
                    <?php endif ?>
                  </div>
                </div>

                </div>
                    
                <?php } ?>
            </td>
            <td style="text-align: right;">
                 <img src="<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo" style="    height: 60px;">

                

                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='receipt'): ?>
                   <h4 class="text-dark m-0">RECEIPT</h4>
                <?php else: ?>
                    <h4 class="text-dark m-0">PAYMENT</h4>
                <?php endif ?>
            </td>
        </tr>
        <tr><td colspan="2"><div style="border-bottom:1px solid;"></div></td></tr>
        <tr>


            <td class="px-2">
                Particulars :
                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>

                <?php else: ?>
                      <div><?= get_group_data($account_name,'group_head'); ?></div><br>
                <?php endif ?>

                  <b>
                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                    <?php if ($customer!='CASH'): ?>
                      <?=  user_name($customer); ?>
                      <?php if (usertype($customer)=='student'): ?> 
                            -
                          <?= class_name(current_class_of_student(company($user['id']),$customer)); ?>
                      <?php endif ?>
                      
                    <?php elseif($alternate_name!='CASH CUSTOMER'): ?>
                        CASH CUSTOMER ( <?= $alternate_name; ?> )

                    <?php elseif($alternate_name==''): ?>
                        CASH CUSTOMER
                    <?php else: ?>
                        CASH CUSTOMER
                    <?php endif ?>
                <?php else: ?>
                    <?=  user_name($customer); ?> <br>
                <?php endif ?></b>
            </td>
      
            <td style="text-align:right;">
                Date : <?= get_date_format($pmt['datetime'],'d M Y'); ?><br>
                Voucher No : <?= get_setting(company($userid),'payment_prefix'); ?>
                <?= serial_cash(company($userid),$payment_id); ?><br>

                <?php if (invoice_id_of_payment($payment_id) != 0) : ?> 
                    No: <?= inventory_prefix($company,invoice_data(invoice_id_of_payment($payment_id),'invoice_type')); ?><?= invoice_data(invoice_id_of_payment($payment_id),'serial_no');  ?>     <br>    
               <?php endif ?>

               <?php if ($bill_type=='purchase' || $bill_type=='purchase_return'): ?>
                   Bill No: <?= invoice_data(invoice_id_of_payment($payment_id),'bill_number');  ?>
               <?php endif ?>

            </td>
        </tr>

        <tr><td colspan="2"><div style="border-bottom: 1px solid;"></div></td></tr>

        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td class="px-2">Payment: <b><?= get_group_data($type,'group_head'); ?></b></td>
                    </tr>
                    <tr>
                        <td class="px-2">Details:<br>
                            <?= $payment_note; ?>
                        </td>
                        
                    </tr>
                </table>
            </td>
            <td style="width: 50%">
                <table class="w-100">
                    <tr>
                        <td style="text-align:right;" width="60%">Amount : </td>
                        <td style="text-align:right;"><b><span style="font-family: DejaVu Sans;"><?= currency_symbol($company); ?></span> <?=$amount; ?> /-</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        
         <tr>
            <td colspan="2" style="text-align:center;">
                <br>
              <p class="m-0 text-muted">If you have any questions about this invoice, please contact <br>
                <?php foreach (my_company($company) as $cmp) { ?>
                 <span style=""><?= $cmp['company_name']; ?></span>, phone: <span style=""><?= $cmp['company_phone']; ?></span>, email: <span style=""><?= $cmp['email']; ?></span>
                <?php } ?>
              </p><div style="border-bottom: 1px solid;"></div> 
            </td>
          </tr>
    </table>


    
</body>
</html>