
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

            <?php if (get_setting(company($user['id']),'show_logo')==1): ?>
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
                style: { textAlign: 'center', fontSize: "18px", fontWeight: "600", marginBottom:'5px'}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (!empty($cmp['city'])): ?>
                <?= $cmp['city']; ?>,<?php endif ?><?php if (!empty($cmp['state'])): ?><?= $cmp['state']; ?>,<?php endif ?><?php if (!empty($cmp['country'])): ?><?= $cmp['country']; ?><?php endif ?><?php if (!empty($cmp['postal_code'])): ?>, Pin - <?= $cmp['postal_code']; ?><?php endif ?>',
                style: {textDecoration: "none", fontSize: "14px", textAlign: "center", color: "black"}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (!empty($cmp['email'])): ?>E-mail: <?= $cmp['email']; ?><?php endif ?><?php if (!empty($cmp['company_phone'])): ?>, Mob: <?= $cmp['company_phone']; ?><?php endif ?>',
                style: {textDecoration: "none", fontSize: "14px", textAlign: "center", color: "black"}
            },

            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if (!empty($cmp['company_phone'])): ?>
                                    GST/VAT: <?= $cmp['gstin_vat_no']; ?>
                                    <?php endif ?>',
                style: {textDecoration: "none", fontSize: "14px", textAlign: "center", color: "black"}
            },

            <?php } ?>




            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<hr>',
                style: { textAlign: "center", color: "black", marginTop: "0px", marginBottom:"0px"}
            },
 
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?php if ($voucher_data['voucher_type']=='expense'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'PAYMENT'); ?>
                          <?php else: ?>
                             <?= langg(get_setting(company($user['id']),'language'),'RECEIPT'); ?>
                          <?php endif; ?> ',
                style: {textDecoration: "none", fontSize: "17px", textAlign: "center", color: "black", textTransform: "uppercase", fontWeight: "600", marginBottom:'0px', marginTop: '0px'}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<hr>',
                style: { textAlign: "center", color: "black", marginTop: "0px", marginBottom:"0px"}
            },
 

            
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?= langg(get_setting(company($user['id']),'language'),'Date'); ?>: <?= get_date_format($voucher_data['voucher_date'],'d M Y'); ?>',
                style: {textDecoration: "none", fontSize: "13px", textAlign: "left", color: "black"}
            },



            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: 'No.: <?= $voucher_data['id']; ?>',
                style: {textDecoration: "none", fontSize: "13px", textAlign: "left", color: "black"}
            },

      

            <?php if ($voucher_data['voucher_type']=='purchase' || $voucher_data['voucher_type']=='purchase_order' || $voucher_data['voucher_type']=='purchase_quotation' || $voucher_data['voucher_type']=='purchase_return' || $voucher_data['voucher_type']=='purchase_delivery_note'): ?>
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?= langg(get_setting(company($user['id']),'language'),'Bill No'); ?>: <?php if (!empty($voucher_data['bill_number'])): ?>
                                    <?= $voucher_data['bill_number']; ?>
                                  <?php else: ?>---<?php endif; ?>',
                style: {textDecoration: "none", fontSize: "13px", textAlign: "left", color: "black"}
            },
            <?php endif ?>

            {
                type: 'table',
                // style the table
                style: {border: '1px solid', marginTop:'10px', fontWeight:'900'},
                // list of the columns to be rendered in the table header
                tableHeader: [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?>', style:{ textAlign: "left" }}, 
                    '<?= langg(get_setting(company($user['id']),'language'),'Amt.'); ?>',  
                ],
                    

                // multi dimensional array depicting the rows and columns of the table body
                tableBody: [

                     <?php  $slno=0;  foreach (voucher_items_array($voucher_data['id']) as $ii): ?>  

                     [
                        {
                            type: 'text', 
                            value: '<?= get_group_data($ii['account_name'],'group_head') ; ?>', 
                            style:{ textAlign: "left" }
                        }, 
                        {
                            type: 'text', 
                            value: '<?= $ii['amount']; ?>', 
                            style:{ textAlign: "right" }
                        }, 
                                        
                    ],
                                        



                     <?php endforeach ?>
                     
                ],
                // list of columns to be rendered in the table footer
                // custom style for the table header
                tableHeaderStyle: { backgroundColor: 'white', color: 'black', borderBottom:'1px solid', fontSize:'15px'},
                // custom style for the table body
                tableBodyStyle: {'border': '0.5px solid #ddd'},
                // custom style for the table footer
                tableFooterStyle: {backgroundColor: '#000', color: 'white'},
            },

            {
                type: 'table',
                // style the table
                style: {border: '1px solid #ddd', fontWeight:'900'},
                // list of the columns to be rendered in the table header
                
                // multi dimensional array depicting the rows and columns of the table body
                tableBody: [
 

             


 
                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Total'); ?>', style:{textAlign: "left", fontWeight: "600", fontSize:'16px',width:'35px'}}, {type: 'text', value: '<?= currency_symbol(company($user['id'])); ?><?= aitsun_round($voucher_data['total']); ?>', style:{textAlign: "right", fontWeight: "600", fontSize:'16px'}}], 

                    [{type: 'text', value: '<?= langg(get_setting(company($user['id']),'language'),'Mode of Payment'); ?>:', style:{textAlign: "left"}}, {type: 'text', value: '<?= get_group_data($voucher_data['payment_type'],'group_head'); ?>', style:{textAlign: "right"}}],
                    
                    
                ],
                // list of columns to be rendered in the table footer
                // custom style for the table header
                tableHeaderStyle: { backgroundColor: '#000', color: 'white'},
                // custom style for the table body
                tableBodyStyle: {'border': '0.5px solid #ddd'},
                tableTdStyle: {'border': '0.5px solid #ddd'},
                // custom style for the table footer
                tableFooterStyle: {backgroundColor: '#000', color: 'white'},
            },


            
            {
                type: 'table',
                // style the table
                style: {border: '1px solid #ddd', fontWeight:'900'},
                // list of the columns to be rendered in the table header
                
                // multi dimensional array depicting the rows and columns of the table body
                tableBody: [
                    ['<b><?= langg(get_setting(company($user['id']),'language'),'Note'); ?> :</b> <?php if (!empty($voucher_data['notes'])){ ?>
                                        <?= $voucher_data['notes']; ?>
                                      <?php }else{echo "";} ?><br><?= langg(get_setting(company($user['id']),'language'),'Thank You For Your Business'); ?>'],
                ],
                // list of columns to be rendered in the table footer
                // custom style for the table header
                tableHeaderStyle: { backgroundColor: '#000', color: 'white'},
                // custom style for the table body
                tableBodyStyle: {'border': '0.5px solid #ddd'},
                // custom style for the table footer
                tableFooterStyle: {backgroundColor: '#000', color: 'white'},
            },
             
        ]

    










    const options = {
        preview: <?= get_setting(company($user['id']),'preview') ?>,
        margin: '<?= get_setting(company($user['id']),'margin1') ?>px <?= get_setting(company($user['id']),'margin2') ?>px <?= get_setting(company($user['id']),'margin3') ?>px <?= get_setting(company($user['id']),'margin4') ?>px',            // margin of content body
        copies: <?= get_setting(company($user['id']),'copies') ?>,                    // Number of copies to print
        printerName: '<?= get_setting(company($user['id']),'printer1') ?>',        // printerName: string, check with webContent.getPrinters()
        timeOutPerLine: 400,
        pageSize: { height: 301000, width: 71000 },
        silent:<?= get_setting(company($user['id']),'silent') ?>,
        dpi: <?= get_setting(company($user['id']),'dpi') ?>,
        header: '<?= get_setting(company($user['id']),'header') ?>',
        footer: '<?= get_setting(company($user['id']),'footer') ?>',
    }
     var print_data=JSON.stringify(data);
     var printer_data=options;

     var full_arr = [];
     full_arr.push(print_data, printer_data);
     window.api.send('toMain', full_arr);
    }


</script>