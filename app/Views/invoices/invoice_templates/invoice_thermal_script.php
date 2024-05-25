
<div class="text-center p-2">
        
<a class="btn btn-primary w-50" onclick="ThermalPrint()">
        <i class="bx bx-printer"></i> 
        <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Print'); ?></span>
    </a>

</div>



<script>
    // const { ipcRenderer } = require('electron');

    function ThermalPrint() {

         const data = [


            
            <?php foreach (my_company(company($user['id'])) as $cmp) { ?>

            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_logo')==1): ?>
            {
                type: 'image',
                url: '<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>',     // file path
                position: 'center',                                  // position of image: 'left' | 'center' | 'right'
                width: '160px',                                           // width of image in px; default: auto
                height: '60px',                                          // width of image in px; default: 50 or '50px'
            },

             <?php endif ?>
            {
                type: 'text',                                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
                value: '<?= $cmp['company_name']; ?>',
                style: { textAlign: 'center', fontSize: "16px", fontWeight: "400", marginBottom:'3px', fontFamily:'arial'}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (!empty($cmp['city'])): ?>
                <?= $cmp['city']; ?>,<?php endif ?><?php if (!empty($cmp['state'])): ?><?= $cmp['state']; ?>,<?php endif ?><?php if (!empty($cmp['country'])): ?><?= $cmp['country']; ?><?php endif ?><?php if (!empty($cmp['postal_code'])): ?>, Pin:<?= $cmp['postal_code']; ?><?php endif ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "center", color: "black", fontFamily:"poppins", fontWeight: "400"}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (!empty($cmp['email'])): ?><?= $cmp['email']; ?><?php endif ?><?php if (!empty($cmp['company_phone'])): ?><br><?= $cmp['company_phone']; ?><?php endif ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "center", color: "black", fontFamily:"poppins", fontWeight: "400"}
            },

            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (!empty($cmp['gstin_vat_no'])): ?>
                                    GST/VAT: <?= $cmp['gstin_vat_no']; ?>
                                    <?php endif ?>',
                style: {textDecoration: "none", fontSize: "13px", textAlign: "center", color: "black", fontFamily:"poppins",fontWeight: "400"}
            },

            <?php } ?>




            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<hr>',
                style: { textAlign: "center", color: "black", marginTop: "0px", marginBottom:"0px"}
            },

            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if ($invoice_data['invoice_type']=='sales'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'INVOICE'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='purchase'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'PURCHASE'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='sales_order'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'SALES ORDER'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='sales_quotation'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'SALES QUOTATION'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='sales_return'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'SALES RETURN'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='sales_delivery_note'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'SALES DELIVERY NOTE'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='purchase_order'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'PURCHASE ORDER'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='purchase_quotation'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'PURCHASE QUOTATION'); ?>
                                    <?php elseif ($invoice_data['invoice_type']=='purchase_return'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'PURCHASE RETURN'); ?> 
                                    <?php elseif ($invoice_data['invoice_type']=='purchase_delivery_note'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'PURCHASE DELIVERY NOTE'); ?>
                                    <?php else: ?>
                                    <?php endif; ?>',
                style: {textDecoration: "none", fontSize: "16px", textAlign: "center", color: "black", textTransform: "uppercase", fontWeight: "400", marginBottom:'0px', marginTop: '0px'}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<hr>',
                style: { textAlign: "center", color: "black", marginTop: "0px", marginBottom:"0px"}
            },

            <?php endif ?>

            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: "<?php if ($invoice_data['customer']!='CASH'): ?><?=  user_name($invoice_data['customer']); ?><?php if (!empty(gst_no_of($invoice_data['customer']))): ?><br><?= langg(get_setting(company($user['id']),'language'),'GST No'); ?>: <?= gst_no_of($invoice_data['customer']); ?><?php endif ?>
                <?php if (!empty(user_phone($invoice_data['customer']))): ?><br><?= langg(get_setting(company($user['id']),'language'),'Mob'); ?>: <?= user_phone($invoice_data['customer']); ?><?php endif ?>
                <?php if (!empty(billing_address_of($invoice_data['customer']))): ?><br><?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_customer_address')==1): ?>
                      <?= billing_address_of($invoice_data['customer']) ?>
                      <?php endif ?><?php endif ?><br><?php elseif ($invoice_data['alternate_name']==''): ?><?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?><?php else: ?><?= $invoice_data['alternate_name']; ?><?php endif ?>",
                style: {textDecoration: "none", fontSize: "12px", textAlign: "left", color: "black", fontWeight: "400", fontFamily:"poppins"}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?= langg(get_setting(company($user['id']),'language'),'Date'); ?>: <?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "right", color: "black", fontFamily:"poppins", fontWeight: "400", marginBottom:"6px"}
            },



            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_header')==1): ?>
                              <?php if ($invoice_data['invoice_type']=='sales'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'INVOICE'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'PURCHASE'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_order'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'SALES ORDER'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_quotation'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'SALES QUOTATION'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_return'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'SALES RETURN'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_delivery_note'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'SALES DELIVERY NOTE'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_order'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'PURCHASE ORDER'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_quotation'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'PURCHASE QUOTATION'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_return'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'PURCHASE RETURN'); ?> 
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_delivery_note'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'PURCHASE DELIVERY NOTE'); ?>
                                  <?php else: ?>
                                  <?php endif; ?>
                                <?php else: ?>
                                  <?= langg(get_setting(company($user['id']),'language'),'No'); ?>
                                  <?php endif ?>
                                   #: <?= get_setting(company($user['id']),'invoice_prefix'); ?>
                                  <?php if ($invoice_data['invoice_type']=='sales'): ?>
                                     <?= get_setting(company($user['id']),'sales_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase'): ?>
                                     <?= get_setting(company($user['id']),'purchase_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_order'): ?>
                                     <?= get_setting(company($user['id']),'sales_order_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_quotation'): ?>
                                     <?= get_setting(company($user['id']),'sales_quotation_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_return'): ?>
                                     <?= get_setting(company($user['id']),'sales_return_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='sales_delivery_note'): ?>
                                     <?= get_setting(company($user['id']),'sales_delivery_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_order'): ?>
                                    <?= get_setting(company($user['id']),'purchase_order_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_quotation'): ?>
                                     <?= get_setting(company($user['id']),'purchase_quotation_prefix'); ?>
                                  <?php elseif ($invoice_data['invoice_type']=='purchase_return'): ?>
                                     <?= get_setting(company($user['id']),'purchase_return_prefix'); ?>
                                     <?php elseif ($invoice_data['invoice_type']=='purchase_delivery_note'): ?>
                                     <?= get_setting(company($user['id']),'purchase_delivery_prefix'); ?>
                                  <?php else: ?>
                                  <?php endif; ?><?= $invoice_data['serial_no']; ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "right", color: "black", fontFamily:"poppins", fontWeight: "400"}
            },

            <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_due_date')==1): ?>
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?= langg(get_setting(company($user['id']),'language'),'Due'); ?>: <?php
                              $Date = $invoice_data['invoice_date'];
                              ?>
                               <?= date('d M Y',strtotime($Date. ' + 7 days')); ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "right", color: "black", fontFamily:"poppins", fontWeight: "400"}
            },
            <?php endif ?>


            <?php if ($invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_order' || $invoice_data['invoice_type']=='purchase_quotation' || $invoice_data['invoice_type']=='purchase_return' || $invoice_data['invoice_type']=='purchase_delivery_note'): ?>
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?= langg(get_setting(company($user['id']),'language'),'Bill No'); ?>: <?php if (!empty($invoice_data['bill_number'])): ?>
                                    <?= $invoice_data['bill_number']; ?>
                                  <?php else: ?>---<?php endif; ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "right", color: "black", fontFamily:"poppins", fontWeight: "400"}
            },
            <?php endif ?>

            {
                type: 'table',
                // style the table
                style: {border: '1px solid', marginTop:'10px', fontWeight:'300'},
                // list of the columns to be rendered in the table header
                tableHeader: [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Item details'); ?>', style:{ textAlign: "left", fontSize: "12px",fontFamily:"poppins", padding:"3px 2px",fontWeight:'300' }},


                    <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>

                    <?php else: ?> 
                    {type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Amt'); ?>', style:{textAlign: "right", fontSize: "12px",fontFamily:"poppins", padding:"3px 2px", fontWeight:'300'}}],
                    <?php endif ?>

                // multi dimensional array depicting the rows and columns of the table body
                tableBody: [

                     <?php $slno=0;  foreach (invoice_items_array($invoice_data['id']) as $ii): ?>




                   <?php 
                      if ($ii['split_tax']==1) {
                          $inc_taxxxx=($ii['amount'])*percent_of_tax($ii['tax'])/100; 
                           $inc_taxxxx=($inc_taxxxx/$ii['quantity'])+$ii['price'];
                      }else{
                         $inc_taxxxx=($ii['price'])*percent_of_tax($ii['tax'])/100; 
                          $inc_taxxxx=$inc_taxxxx+$ii['price'];
                      } 

                      
 
                     
                   ?>



                     [{type: 'text', value: '<?= thermal_text($ii['product']) ; ?><br> <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_quantity')==1): ?> <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?><?php else: ?><?= $ii['quantity']; ?> <?= unit_name($ii['unit']); ?><?php endif ?> <?php endif ?>X<?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_price')==1): ?><?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?><?php else: ?> <?= $ii['price']; ?><?php endif ?> <?php endif ?>', 


                                        style:{ textAlign: "left",fontFamily:"poppins", padding:"3px 2px" }}, 


                                        <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>

                                        <?php else: ?> 
                                        {type: 'text', value: '<?= $ii['price']*$ii['quantity']; ?>', style:{textAlign: "right", padding:"3px 2px"}}],
                                        <?php endif ?> 



                     <?php endforeach ?>
                     
                ],
                // list of columns to be rendered in the table footer
                // custom style for the table header
                tableHeaderStyle: { backgroundColor: 'white', color: 'black', borderBottom:'1px solid', fontSize:'12px'},
                // custom style for the table body
                tableBodyStyle: {'border': '0.5px solid #ddd'},
                // custom style for the table footer
                tableFooterStyle: {backgroundColor: '#000', color: 'white'},
            },

            {
                type: 'table',
                // style the table
                style: {border: '1px solid #ddd', marginTop:'5px', fontFamily:"poppins", fontWeight:'300'},
                // list of the columns to be rendered in the table header
                
                // multi dimensional array depicting the rows and columns of the table body
                tableBody: [

                    <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>

                    <?php else: ?>

                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Subtotal'); ?> :', style:{ textAlign: "left", padding:"3px 2px", fontWeight: "400"}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?><?= aitsun_round($invoice_data['sub_total']-$invoice_data['tax'],2,PHP_ROUND_HALF_UP); ?>', style:{textAlign: "right", padding:"3px 2px",fontFamily:"poppins",fontWeight: "400"}}],

                    <?php endif ?>

                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_tax')==1): ?>

                        <?php if (get_company_data($invoice_data['company_id'],'country')!='Oman'):?>

                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Taxable'); ?> :', style:{textAlign: "left",fontFamily:"poppins", padding:"3px 2px"}}, {type: 'text', value: '<?php if ($invoice_data['tax']>0): ?>
                                      <?= currency_symbol(company($user['id'])); ?><?= aitsun_round($invoice_data['tax'],2,PHP_ROUND_HALF_UP); ?><?php else: ?><?= currency_symbol(company($user['id'])); ?><?= 0; ?><?php endif ?>
                                   <?php if (count(taxes_of_invoice($invoice_data['id']))==0): ?><?php endif ?><?php foreach (taxes_of_invoice($invoice_data['id']) as $tx): ?><?= tax_name($tx['tax_id']); ?><?= currency_symbol(company($user['id'])); ?><?php $tax_amt=$invoice_data['sub_total']/100*percent_of_tax($tx['tax_id']);
                                        echo aitsun_round($tax_amt,2,PHP_ROUND_HALF_UP); ?><?php endforeach ?>', style:{textAlign: "right", padding:"3px 2px"}}],

                    <?php endif ?>
                     <?php endif ?>

                    <?php
  
                      $ttot=0;
                       foreach (all_taxes_of_invoice(company($user['id']),$invoice_data['id']) as $tds): ?>
                        <?php if (!empty($tds['tax_name'])): ?>


                    [{type: 'text', value: '<?= $tds['tax_name']; ?>  :', style:{textAlign: "left", padding:"3px 2px"}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?><?= $tds['tax_amount']; ?>  <?php  $ttot+=$tds['tax_amount']; ?>', style:{textAlign: "right",fontFamily:"poppins", padding:"3px 2px"}}],

                        <?php endif ?>
                    <?php endforeach ?>


                    <?php if (get_invoicesetting($invoice_data['company_id'],$invoice_data['invoice_type'],'show_discount')==1): ?>

                    <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>

                    <?php else: ?> 

                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Discount'); ?> :', style:{textAlign: "left", padding:"3px 2px"}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?><?= aitsun_round($invoice_data['discount']+$invoice_data['additional_discount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>', style:{textAlign: "right",fontFamily:"poppins", padding:"3px 2px"}}],

                    <?php endif ?>
                    <?php endif ?>


                    
                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Round off'); ?> :', style:{textAlign: "left",fontFamily:"poppins", padding:"3px 2px"}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?> <?php if ($invoice_data['round_off']>0): ?>
                      <?php if ($invoice_data['round_type']=='add'): ?>
                        + <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php else: ?>
                        - <?= aitsun_round($invoice_data['total']-$invoice_data['total']+$invoice_data['round_off'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                      <?php endif ?>
                  <?php else: ?>
                    <?= aitsun_round($invoice_data['total']-$invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?>
                  <?php endif ?>', style:{textAlign: "right",fontFamily:"poppins", padding:"3px 2px"}}],



                    <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>

                    <?php else: ?> 
                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Total'); ?>', style:{textAlign: "left", fontWeight: "400",fontFamily:"poppins", fontSize:'15px',padding:"3px 2px"}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?><?= aitsun_round($invoice_data['total'],get_setting($invoice_data['company_id'],'round_of_value')); ?>', style:{textAlign: "right", fontWeight: "400", fontSize:'15px', fontFamily:"poppins",padding:"3px 2px"}}],
                <?php endif ?>


                    <?php if ($invoice_data['paid_status']=='unpaid'): ?>
                    <?php if ($invoice_data['invoice_type']=='sales_delivery_note'): ?>

                    <?php else: ?> 

                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Due Amount'); ?> :', style:{textAlign: "left",fontFamily:"poppins", padding:"3px 2px"}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?><?= aitsun_round($invoice_data['due_amount'],get_setting($invoice_data['company_id'],'round_of_value')); ?>', style:{textAlign: "right",fontFamily:"poppins", padding:"3px 2px"}}],

                    <?php endif ?>
                    <?php endif ?>

                    <?php if (trim(mode_of_payment(company($user['id']),$invoice_data['id']))!=''): ?>

                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Mode of Payment'); ?>:', style:{textAlign: "left", fontFamily:"poppins", padding:"3px 2px"}}, {type: 'text', value: '<?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='purchase_return'): ?>
                      <?= mode_of_payment(company($user['id']),$invoice_data['id']); ?>
                    <?php else: ?>---<?php endif ?>', style:{textAlign: "right", fontFamily:"poppins", padding:"3px 2px"}}],
                    <?php endif ?>
                    
                ],
                // list of columns to be rendered in the table footer
                // custom style for the table header
                tableHeaderStyle: { backgroundColor: '#000', color: 'white',fontFamily:"poppins"},
                // custom style for the table body
                tableBodyStyle: {'border': '0.5px solid #ddd',fontFamily:"poppins"},
                tableTdStyle: {'border': '0.5px solid #ddd',fontFamily:"poppins"},
                // custom style for the table footer
                tableFooterStyle: {backgroundColor: '#000', color: 'white',fontFamily:"poppins"},
            },


            
            {
                type: 'table',
                // style the table
                style: {border: '1px solid #ddd', fontWeight:'300',fontFamily:"poppins"},
                // list of the columns to be rendered in the table header
                
                // multi dimensional array depicting the rows and columns of the table body
                tableBody: [

                    [{type: 'text', value: '<b><?= langg(get_setting(company($user['id']),'language'),'Note'); ?> :</b> <?php if (!empty($invoice_data['notes'])){ ?> <?= $invoice_data['notes']; ?> <?php }else{echo "";} ?><br><?= langg(get_setting(company($user['id']),'language'),'Thank You For Your Business'); ?>', style:{textAlign: "center", padding:"3px 2px",fontFamily:"poppins"}}],


                    
                ],
                // list of columns to be rendered in the table footer
                // custom style for the table header
                tableHeaderStyle: { backgroundColor: '#000', color: 'white',fontFamily:"poppins"},
                // custom style for the table body
                tableBodyStyle: {'border': '0.5px solid #ddd',fontFamily:"poppins"},
                // custom style for the table footer
                tableFooterStyle: {backgroundColor: '#000', color: 'white',fontFamily:"poppins"},
            },
             
        ]







    const options = {
         preview: <?= get_setting(company($user['id']),'preview') ?>,
        width: '<?= get_setting(company($user['id']),'body_width') ?>px',
        margin: '<?= get_setting(company($user['id']),'margin1') ?>px <?= get_setting(company($user['id']),'margin2') ?>px <?= get_setting(company($user['id']),'margin3') ?>px <?= get_setting(company($user['id']),'margin4') ?>px',            // margin of content body
        copies: <?= get_setting(company($user['id']),'copies') ?>,                    // Number of copies to print
        printerName: '<?= get_setting(company($user['id']),'printer1') ?>',        // printerName: string, check with webContent.getPrinters()
        timeOutPerLine: <?= get_setting(company($user['id']),'time_out_per_line') ?>,
        pageSize: { height: 301000, width: 71000 },
        silent:<?= get_setting(company($user['id']),'silent') ?>,
        dpi: <?= get_setting(company($user['id']),'dpi') ?>,
    }
     var print_data=JSON.stringify(data);
     var printer_data=options;

     var full_arr = [];
     full_arr.push(print_data, printer_data);
     window.api.main_print('toMain', full_arr);
    }


</script>