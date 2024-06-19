<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>" class="href_loader"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>

                <li class="breadcrumb-item">
                    <?php if (inventory_type($invoice_data['invoice_type'])=='sales'): ?>
                        <a href="<?= base_url('invoices/sales'); ?>" class="href_loader">Invoices</a>
                    <?php else: ?>
                        <a href="<?= base_url('purchases/purchases'); ?>" class="href_loader">Invoices</a>
                    <?php endif ?> 
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= inventory_prefix(company($user['id']),$invoice_data['invoice_type']); ?><?= $invoice_data['serial_no']; ?>
                        <?php if ($invoice_data['deleted']==4): ?>
                            <small class="text-danger">(Cancelled)</small>
                        <?php endif ?>
                        <?php if ($invoice_data['deleted']==1): ?>
                            <small class="text-danger">(Deleted)</small>
                        <?php endif ?>
                    </b>
                </li>
                
            </ol>
        </nav>

        
     
        <div class="d-flex">
           
            <a class="my-auto ms-2 text-dark cursor-pointer font-size-topbar href_loader" title="Refresh" onclick="location.reload();">    
                <i class="bx bx-refresh"></i>
            </a>
             <a class="my-auto ms-2 text-aitsun-red href_loader cursor-pointer font-size-topbar" href="<?= base_url() ?>" title="Back">
                <i class="bx bxs-category"></i>
            </a>
        </div>

    </div>
</div>
<!-- ////////////////////////// TOP BAR END ///////////////////////// -->

<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div>
        
       
        <a class="text-dark font-size-footer aitsun-print me-2" data-url="<?= base_url('invoices/get_invoice_pdf/'.$invoice_data['id'].'/view#toolbar=0&navpanes=0&scrollbar=0')?>">
            <i class="bx bx-printer"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Print'); ?></span>
        </a>


        <a class="text-dark font-size-footer aitsun-print me-2" data-url="<?= base_url('invoices/view_pdf/'.$invoice_data['id'].'?method=view'); ?>">
            <i class="bx bx-printer"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'PDF Print'); ?></span>
        </a>
 
    <a  class="text-dark font-size-footer me-2 aitsun-electron-print" 
            data-url="<?= base_url('invoices/get_pos_invoice/'.$invoice_data['id'])?>" 
            data-silent="<?= printer_data($user['id'],'silent') ?>"
            data-devicename="<?= printer_data($user['id'],'printer_name') ?>"
            data-top="<?= printer_data($user['id'],'top') ?>"
            data-right="<?= printer_data($user['id'],'right') ?>"
            data-bottom="<?= printer_data($user['id'],'bottom') ?>"
            data-left="<?= printer_data($user['id'],'left') ?>"
            data-scalefactor="<?= printer_data($user['id'],'scale') ?>"
    >
        <i class="bx bx-printer"></i> 
        <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Print Thermal'); ?></span>
    </a>

 

     
    <a href="<?= base_url('invoices/view_pdf/'.$invoice_data['id'].'?method=download'); ?>" class="text-dark font-size-footer me-2 download_complete">
        <i class="bx bx-download"></i>
        <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Download PDF'); ?></span>
    </a>

    
 


    <?php 
        $filename='';
        $filename=inventory_prefix(company($user['id']),$invoice_data['invoice_type']).$invoice_data['serial_no'].'-';

        if ($invoice_data['customer']=='CASH') {
            if ($invoice_data['alternate_name']=='') {
                $filename.=langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER');
            }else{
                $filename.=$invoice_data['alternate_name'];
            }
        }else{
            $filename.=user_name($invoice_data['customer']);
        }
    ?>
   
 

    <?php if (get_setting(company($user['id']),'pdf_type')=='dompdf' || get_setting(company($user['id']),'pdf_type')==''): ?>
         <a class="text-dark font-size-footer me-2 pdf_open_new" data-href="<?= base_url('invoices/view_pdf/'.$invoice_data['id'].'') ?>">
            <i class="bx bx-file-blank"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'PDF'); ?></span>
        </a>
    <?php endif ?>
    <script>
        
    $(document).on('click','.pdf_open_new',function(){
        var href= $(this).data('href');
        var last_height=$('#last_height').val();
        $('#pdf_modal').modal('show');
        $('#pdf_show').html('Loading'); 
        
        $('#pdf_show').html('<iframe src="'+href+'?method=view" class="erp_iframe" id="erp_iframe"></iframe>');

        const iframe = document.getElementById('erp_iframe');
          iframe.srcdoc = '<!DOCTYPE html><div style="color: green; width: 100%;height: 90vh;display: flex;"><div style="margin:auto; font-family: system-ui;">Rendering PDF...</div></div>';
           iframe.addEventListener('load', () => setTimeout(function(){iframe.removeAttribute('srcdoc')}, 2500));
         

    });
    </script>



    <!-- export pdf-->
 


    <?php if ($invoice_data['deleted']==0): ?>
      <a class="text-dark font-size-footer ms-2 aitsun-share" data-type="email" data-to="<?= user_email($invoice_data['customer']) ?>" data-template="invoice_share"><i class="bx bx-envelope"></i> Email</a>
    <?php endif ?>

    </div>


    <div>

    <?php if ($invoice_data['bill_from']=='rental' &&  $invoice_data['invoice_type']!='sales'): ?>
        <?php if ($invoice_data['rental_status']==0): ?>
            <a class=" font-size-footer me-2  rental_status tob_bar_status_btn" style="background: purple;color: white;" data-status="1" data-invoice_id="<?= $invoice_id ?>">
                <i class="bx bx-check-circle"></i> 
                <span class="hidden-xs">Confirm</span>
            </a>
        <?php endif ?>
       
        <?php if ($invoice_data['rental_status']!=0): ?>
            <a class=" font-size-footer me-2  pickup_status bg-warning text-dark tob_bar_status_btn" data-status="2" data-action="pickup" data-invoice_id="<?= $invoice_id ?>">
                <i class="bx bx-bus"></i> 
                <span class="hidden-xs">Pick Up</span>
            </a>
        
            <a class=" font-size-footer me-2  pickup_status bg-success text-white tob_bar_status_btn" data-status="3" data-action="return" data-invoice_id="<?= $invoice_id ?>">
                <i class="bx bx-reply"></i> 
                <span class="hidden-xs">Return</span>
            </a>
        <?php endif ?>
        
    <?php endif ?>

        <?php if ($invoice_data['deleted']==0): ?>
    <!-- payment-->
    <?php if ($invoice_data['invoice_type']=='sales' || $invoice_data['invoice_type']=='proforma_invoice' || $invoice_data['invoice_type']=='purchase' || $invoice_data['invoice_type']=='sales_return' || $invoice_data['invoice_type']=='purchase_return'): ?>
            <?php if ($invoice_data['deleted']!=4): ?>
              <a href="<?php echo base_url('fees_and_payments/payments') ?>/<?= $invoice_id ?>" class="btn-sm btn-back font-size-footer me-2 href_loader ">
                  <i class="bx bx-money"></i> 
                  <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Receipt / Payment'); ?></span>
              </a>
            <?php endif ?>
    <?php endif ?>
    <!-- payment-->


    <!-- edit invoice -->
    <?php if ($invoice_data['order_status']!='cancelled'): ?>
    <?php if ($invoice_data['invoice_type']=='sales'): ?>
       <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='purchase'): ?>
       <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='sales_order'): ?>
       <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='sales_quotation'): ?>
       <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='sales_return'): ?>
       <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='sales_delivery_note'): ?>
      <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='purchase_order'): ?>
      <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='purchase_quotation'): ?>
       <?php $editex='invoices'; ?>
    <?php elseif ($invoice_data['invoice_type']=='purchase_return'): ?>
       <?php $editex='invoices'; ?>
       <?php elseif ($invoice_data['invoice_type']=='purchase_delivery_note'): ?>
       <?php $editex='invoices'; ?>
    <?php else: ?>
        <?php $editex='invoices'; ?>
    <?php endif; ?> 

        <?php if ($invoice_data['deleted']!=4): ?>
             <a href="<?php echo base_url($editex.'/edit/') ?>/<?= $invoice_id ?>" class="text-primary font-size-footer me-2 href_loader">
                <i class="bx bx-pencil"></i> 
                <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Edit'); ?></span>
            </a>
            <a href="<?php echo base_url($editex.'/copy/') ?>/<?= $invoice_id ?>" class="text-info font-size-footer me-2 href_loader">
                <i class="bx bx-copy"></i> 
                <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Copy'); ?></span>
            </a>
        <?php endif ?>    
    <!-- edit invoice -->                        
                                                

  
           
        <a data-url="<?php echo base_url() ?>/invoices/delete/<?= $invoice_id ?>" class="delete text-danger font-size-footer me-2">
            <i class="bx bx-trash-alt"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Delete'); ?></span>
        </a> 
        

    <?php endif ?>
    <?php endif ?>
    </div>
    
     
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal aitsun-modal fade" id='email<?= $invoice_data['id']; ?>'  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
                <div class="form-group">
                    <label for="to-input">To</label>
                    <input type="email" class="form-control" id="emailto<?= $invoice_data['id']; ?>"  placeholder="To" value="<?= user_email($invoice_data['customer']); ?>" required>
                    <div class="text-danger mt-2" id="ermsg"></div>
                </div>

                <div class="form-group">
                    <label for="subject-input">Subject</label>
                    <input type="text" class="form-control" id="subject<?= $invoice_data['id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
                </div>
                <div class="form-group ">
                    <label for="message-input">Message</label>
                      <textarea style="white-space: pre-wrap;" class="form-control" value="" id='message<?= $invoice_data['id']; ?>' rows="10">
Dear <?php if($invoice_data['customer'] == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name($invoice_data['customer']);}  ?>,

<?php foreach (my_company(company($user['id'])) as $cmp) { ?>
    <?= $cmp['company_name']; ?> <?php } ?>truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($user['id'])); ?> <?= $invoice_data['total']; ?> 
Due Amount: <?= currency_symbol(company($user['id'])); ?> <?= $invoice_data['due_amount']; ?>



   
Thanks and Regards,  
<?php foreach (my_company(company($user['id'])) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>

                      </textarea>
                </div>

                

                <div class="btn-toolbar form-group mt-2">
                        <button class="aitsun-primary-btn inventory_email" data-id="<?= $invoice_data['id']; ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
                </div>

          
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->


    <input type="hidden" id="thermalcheckvalue" value="<?= get_setting(company($user['id']),'print_thermal'); ?>">


<div class="modal  fade" id="pdf_modal"  aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">PDF preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">

        

        <div id="pdf_show">
        </div>

      </div>
    </div>
  </div>
</div>

 

  
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="d-flex">
    <div class="sub_main_page_content overflow-scroll bg-invoice"> 
        
            <div class="aitsun-row w-100 justify-content-center ">
                <div class="invoice_card paper_shadow" >
                    <div class="card-body" >
                        <div id="">
                           <div class=" ">  
                                <div id="pdfthis" class="pdfthis"> 
                                   <iframe class="aitsun-embed" id="aitsun-embed" src="<?= base_url('invoices/get_invoice_pdf'); ?>/<?= $invoice_id ?>/view#toolbar=0&navpanes=0&scrollbar=0" width="900" height="600"></iframe>
                          
                                </div>
                                <div id="pdfthermalthis" class="rounded-3 py-3"></div>
                                <div id="editor"></div>
                           </div>



                            <?php if (!empty($invoice_data['private_notes'])): ?>
                              <div class="card">
                                  <div class="card-body">
                                    <h6><?= langg(get_setting(company($user['id']),'language'),'Private Note'); ?></h6>
                                      <p><?= $invoice_data['private_notes']; ?></p>
                                  </div>
                              </div>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>
 
</div>

<?php if ($invoice_data['bill_from']=='rental'): ?>
            <div class="rental_logs">

                <div>
                    <h6 class="mb-1 text-aitsun-red">Items</h6>
                     <?php 
                     $isl=0;
                        foreach (invoice_items_array($invoice_data['id']) as $ii): 
                        $isl++;
                        $productid=$ii['product_id']; 
                        $in_unit=$ii['in_unit'];  
                        $in_quantity=$ii['quantity'];
     
                        $total_picked_quantity=total_picked_quantity($invoice_id,$ii['product_id'],'pickup');
                        $total_returned_quantity=total_picked_quantity($invoice_id,$ii['product_id'],'return');

                ?> 
                    <div class="rent_item_card">
                        <div><b style="font-weight: 700;"><?= $isl ?>. <?= $ii['product'] ; ?></b></div>
                        <div>Total: <b style="font-weight: 700;" class="text-dark"><?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?></b></div>
                        <div>Picked: <b style="font-weight: 700;" class="text-warning"><?= $total_picked_quantity ?> <?= unit_name($ii['in_unit']); ?></b></div>
                        <div>Returned: <b style="font-weight: 700;" class="text-success"><?= $total_returned_quantity ?> <?= unit_name($ii['in_unit']); ?></b></div> 
 
                    </div>
                    
                <?php endforeach ?> 
                </div>
                <hr>
                <h6 class="mt-2 text-aitsun-red">Rental activities</h6>
                <ul>
                    <?php foreach (all_rental_logs($invoice_data['id']) as $ld): ?>  
                    <li class="mb-1 d-flex">
                        <div class="my-auto me-2">
                            <i style="font-size: 26px;" class="bx bx-<?= ($ld['log_type']=='pickup')?'bus text-warning':'reply text-success'; ?>"></i>
                        </div> 
                        <div>
                            <small class="log_date">
                                <?= get_date_format($ld['datetime'],'d M Y h:i A'); ?> - <?=  user_name($ld['user_id']); ?>
                            </small>
                            <p class="mb-1">
                               <b><?= $ld['quantity'] ?> <?= unit_name($ld['in_unit']) ?></b> <?= get_products_data($ld['item_id'],'product_name') ?> is <?= ($ld['log_type']=='pickup')?'picked up.':'returned.'; ?>
                            </p>
                        </div>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endif ?>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->

</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>

    <div>
        <a href="<?= base_url('invoice_settings/sales')?>" class="text-dark font-size-footer"><i class="bx bx-cog"></i> <span class="my-auto">Invoice Settings</span></a>
    </div>
   
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 










<script type="text/javascript">
    
    $(document).ready(function(){

        $(document).on('click','#sendmail',function(){
            var to=$('#emailto').val();
            var subject=$('#subject').val();
            var message=$('#message').val();
          
            var link = "https://mail.google.com/mail/?view=cm&fs=1&to="+to+"&su="+subject+"&body="+message;
            var a = document.createElement('a');
            a.target="_blank";
            a.href=link;

            if (to!='') {
                if ( validateEmail(to)) {
                    a.click();
                }else{
                    $('#ermsg').html('<?= langg(get_setting(company($user['id']),'language'),'Invalid email'); ?>');                  
                }
               
            }else{
               $('#ermsg').html('<?= langg(get_setting(company($user['id']),'language'),'Please write email address'); ?>');
            }

            
        });

        function validateEmail($email) {
          var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
          return emailReg.test( $email );
        }

    });

</script>


<script type="text/javascript">
  $(document).ready(function(){
    var thermalcheckvalue=$('#thermalcheckvalue').val();

   
        // $.ajax({
        //       url: "<?= base_url('invoices/get_thermal_invoice'); ?>/<?= $invoice_id ?>",
        //       success:function(response) {
        //         $('#pdfthermalthis').html(response);
        //      },
        //      error:function(){
        //       alert("error");
        //      }
        //     });

   


        // $.ajax({
        //   url: "<?= base_url('invoices/get_invoice'); ?>/<?= $invoice_id ?>",
        //   success:function(response) {
        //     $('#pdfthis').html(response);
        //  },
        //  error:function(){
        //   alert("error");
        //  }
        // });


    

  });
</script>


<script type="text/javascript">
    
    function Popup(data) {
      var mywindow = window.open('', 'new div', 'height=400,width=600');
      mywindow.document.write('<html><head><title></title>');
      mywindow.document.write('<link rel="stylesheet" href="css/midday_receipt.css" type="text/css" />');
      mywindow.document.write('</head><body >');
      mywindow.document.write(data);
      mywindow.document.write('</body></html>');
      mywindow.document.close();
      mywindow.focus();
      setTimeout(function(){mywindow.print();},1000);
      mywindow.close();

      return true;
}
</script>

<?php if (print_thermal_show(company($user['id']))): ?>
    



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
                style: {textDecoration: "none", fontSize: "12px", textAlign: "left", color: "black", fontWeight: "400", fontFamily:"poppins", marginBottom:"6px"}
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<?= langg(get_setting(company($user['id']),'language'),'Date'); ?>: <?= get_date_format($invoice_data['invoice_date'],'d M Y'); ?>',
                style: {textDecoration: "none", fontSize: "12px", textAlign: "right", color: "black", fontFamily:"poppins", fontWeight: "400"}
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

<?php endif ?>
 
<div data-filename="text.png"></div>




