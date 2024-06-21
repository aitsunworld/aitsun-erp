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
        <?php 
            $email_data=aitsun_share_data('email','invoice_share');
            $subject=$email_data['subject'];
           
            $replacing_data = [
                '[customer-name]' => user_name($invoice_data['customer']), 
                '[currency-icon]' => currency_symbol(company($user['id'])),
                '[total-amount]' => aitsun_round($invoice_data['total'],get_setting(company($user['id']),'round_of_value')),
                '[due-amount]' => aitsun_round($invoice_data['due_amount'],get_setting(company($user['id']),'round_of_value')),
                '[company-name]' => get_company_data(company($user['id']),'company_name'),
                '[company-contact]' => get_company_data(company($user['id']),'email'),
                '[invoice-number]' => inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'],
                '[invoice-link]' => base_url('invoices/download').'/'.$invoice_data['id'],
                '[invoice-type]' => ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type'])))
            ];
            $message=str_replace(array_keys($replacing_data), array_values($replacing_data), $email_data['message']);
            $subject=str_replace(array_keys($replacing_data), array_values($replacing_data), $email_data['subject']);
         ?>
      <a class="text-dark font-size-footer ms-2 aitsun-share" data-type="email" data-name="<?= user_name($invoice_data['customer']) ?>" data-to="<?= user_email($invoice_data['customer']) ?>" data-template="invoice_share" data-subject="<?= $subject ?>" data-message="<?= $message ?>"><i class="bx bx-envelope"></i> Email</a>

      <?php 
            $whatsapp_data=aitsun_share_data('whatsapp','invoice_share');
            $whatsapp_subject=$whatsapp_data['subject'];
           
            $wa_replacing_data = [
                '[customer-name]' => user_name($invoice_data['customer']), 
                '[currency-icon]' => currency_symbol(company($user['id'])),
                '[total-amount]' => aitsun_round($invoice_data['total'],get_setting(company($user['id']),'round_of_value')),
                '[due-amount]' => aitsun_round($invoice_data['due_amount'],get_setting(company($user['id']),'round_of_value')),
                '[company-name]' => get_company_data(company($user['id']),'company_name'),
                '[company-contact]' => get_company_data(company($user['id']),'email'),
                '[invoice-number]' => inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'],
                '[invoice-link]' => base_url('invoices/download').'/'.$invoice_data['id'],
                '[invoice-type]' => ucwords(strtolower(inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type'])))
            ];
            $whatsapp_message=str_replace(array_keys($wa_replacing_data), array_values($wa_replacing_data), $whatsapp_data['message']);
            $whatsapp_subject=str_replace(array_keys($wa_replacing_data), array_values($wa_replacing_data), $whatsapp_data['subject']);
         ?>

      <a class="text-dark font-size-footer ms-2 aitsun-share" data-type="whatsapp" data-name="<?= user_name($invoice_data['customer']) ?>" data-to="<?= country_code($invoice_data['customer']) ?><?= user_phone($invoice_data['customer']) ?>" data-template="invoice_share" data-subject="<?= $whatsapp_subject ?>" data-message="<?= $whatsapp_message ?>"><i class="lni lni-whatsapp"></i> WhatsApp</a>
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
                    <div class="d-flex mb-2 justify-content-between">
                        <h6 class="my-auto text-aitsun-red">Items</h6> 
                        <div class="d-flex my-auto">
                            <span class="my-auto me-2">Rental status:</span>
                            <?php if ($invoice_data['rental_status']==0): ?> 
                                <span class="my-auto badge bg-light text-dark">Quotation</span>
                            <?php elseif ($invoice_data['rental_status']==1): ?>
                                <span class="my-auto badge bg-primary text-white">Reserved</span>
                            <?php elseif ($invoice_data['rental_status']==2): ?>
                                <span class="my-auto badge bg-warning text-dark">Picked Up</span>
                            <?php elseif ($invoice_data['rental_status']==3): ?>
                                <span class="my-auto badge bg-success text-white">Returned</span>
                            <?php else: ?>
                                -
                            <?php endif; ?> 
                        </div>
                    </div>
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

 




