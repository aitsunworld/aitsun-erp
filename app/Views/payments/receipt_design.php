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
       $amount=aitsun_round($pmt['amount'],round_after());
       $payment_note=$pmt['payment_note'];
       $account_name=$pmt['account_name'];
       $datetime=$pmt['datetime'];
   ?>


    <table class="w-100">
        <tbody>
            <tr>
            <td>
            <?php foreach (my_company($company) as $cmp) { ?>
            <div class="d-flex">
              <img src="<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo" style="    height: 60px;">
                <div class="my-auto ml-2 ">
                  <div style="margin-bottom:0; font-size: 20px;font-weight: bold;"><?= $cmp['company_name']; ?></div>
                    <div style="max-width: 300px;">
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
                <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                    <h4 class="text-dark m-0">RECEIPT</h4>
                <?php else: ?>
                    <h4 class="text-dark m-0">PAYMENT</h4>
                <?php endif ?>
                
                Date : <?= get_date_format($pmt['datetime'],'d M  Y'); ?><br>
                Voucher No : <?= get_setting(company($userid),'payment_prefix'); ?>
                <?= serial_cash(company($userid),$payment_id); ?>   
                   
                <?php if (invoice_id_of_payment($payment_id) != 0) : ?> 
                    Invoice No: <?= inventory_prefix($company,invoice_data(invoice_id_of_payment($payment_id),'invoice_type')); ?><?= invoice_data(invoice_id_of_payment($payment_id),'serial_no');  ?>         
               <?php endif ?>

             </td>
          </tr>


          <tr>
            <td colspan="2" class="pt-2">
            <table border="1" border="1" cellspacing="0" cellpadding="5">
           
            <tbody>
          
              <tr >
               <td class="py-2 px-2" style="width: 50%;">
                 <span>

                    <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>

                    <?php else: ?>
                        <?= get_group_data($account_name,'group_head'); ?><br>
                    <?php endif ?>


                    Party Name:   <b>
                    <?php if ($bill_type=='sales' || $bill_type=='purchase_return' || $bill_type=='purchase' || $bill_type=='sales_return'): ?>
                        <?php if ($customer!='CASH'): ?>
                            <?=  user_name($customer); ?>
                        <?php elseif($alternate_name!='CASH CUSTOMER'): ?>
                            CASH CUSTOMER ( <?= $alternate_name; ?> )
                        <?php elseif($alternate_name==''): ?>
                            CASH CUSTOMER
                        <?php else: ?>
                            CASH CUSTOMER
                        <?php endif ?>
                    <?php else: ?>
                        <?=  user_name($customer); ?> <br>
                        
                    <?php endif ?>  
                 </b></span><br>
                 <span>Payment: <b><?= get_group_data($type,'group_head'); ?>
                     
                 </b></span>
               </td>

               <td class="py-2 px-2 border-all">
                  <table border="0" cellspacing="0"> 
                    <tr> 
                      <td>
                        Details:
                        <p><?= $payment_note; ?></p>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </td>
             </tr>
                


             <tr>
              <td colspan="2">
                <div class="amt_ro mt-3">
                <b><span style="font-family: DejaVu Sans;"><?= currency_symbol($company); ?></span> <?= $amount; ?> /-</b>
              </div>
              </td>
            </tr>



            <tr>
              <td colspan="2" style="text-align: center;">
                <p style="margin-bottom: 0;">If you have any questions about this invoice, please contact <br>
                <?php foreach (my_company($company) as $cmp) { ?>
                  <span><?= $cmp['company_name']; ?></span>, phone: <span ><?= $cmp['company_phone']; ?></span>, email: <span ><?= $cmp['email']; ?></span>
                <?php } ?>
              </p>  
              </td>
            </tr>

        </tbody>
    </table>


    
</body>
</html>