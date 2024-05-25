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
                    <a class="href_loader" href="<?= base_url('fees_and_payments'); ?>">Fees management</a>
                </li>

                <li class="breadcrumb-item"> 
                    <a href="<?= base_url('fees_and_payments/details'); ?>/<?= $invoice['fees_id']; ?>"><?= get_fees_data(company($user['id']),$invoice['fees_id'],'fees_name') ?></a>  
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Fees details #<?= $invoice['serial_no']; ?>
                        <?php if ($invoice['deleted']==1): ?>  
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


<?php 
    $filename='';
    $filename=inventory_prefix(company($user['id']),$invoice['invoice_type']).$invoice['serial_no'].'-';

    if ($invoice['customer']=='CASH') {
        if ($invoice['alternate_name']=='') {
            $filename.=langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER');
        }else{
            $filename.=$invoice['alternate_name'];
        }
    }else{
        $filename.=user_name($invoice['customer']);
    }
?>


<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div> 

        <a class="text-dark font-size-footer aitsun-print me-2" data-url="<?= base_url('fees_and_payments/get_challan'); ?>/<?= $invoice['id']; ?>/view">
            <i class="bx bx-printer"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Print'); ?></span>
        </a>
        <a class="text-dark font-size-footer me-2 download_complete" href="<?= base_url('fees_and_payments/get_challan'); ?>/<?= $invoice['id']; ?>/download"><i class="bx bx-file-blank"></i>  Download PDF</a>
        
<?php if (get_setting(company($user['id']),'pdf_type')=='dompdf' || get_setting(company($user['id']),'pdf_type')==''): ?>
         <a class="text-dark font-size-footer me-2 pdf_open" data-href="<?= base_url('fees_and_payments/get_challan'); ?>/<?= $invoice['id']; ?>/view">
            <i class="bx bx-file-blank"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'PDF'); ?></span>
        </a>
    <?php endif ?>
        
    </div>

    <?php if ($invoice['deleted']==0): ?> 
    <a data-bs-toggle="dropdown" class="text-dark cursor-pointer font-size-footer my-auto ms-2"> <span class="my-auto">+ Action</span></a>
    <div class="aitsun-dropdown-menu dropdown-menu dropdown-menu-right dropdown-menu-lg-end">  
        
     
        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#concession_modal">
            <i class="bx bx-minus me-1 "></i><span class="">Add & Remove</span> Concession
        </a>
        
        <a href="<?= base_url('fees_and_payments'); ?>/payments/<?= $invoice['id']; ?>" class=" dropdown-item href_loader">
            <i class="bx bx-money me-1"></i><span class="">Receipt/Payment</span>
        </a>
        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#additional_fees">
            <i class="bx bx-plus me-1 "></i>Add/Remove
        </a>

        <?php if ($invoice['is_installment']!=1): ?>
            <?php if ($invoice['due_amount']>0): ?>
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#send_reminder_model">
                        <i class="bx bx-bell me-1 "></i>Send reminder
                </a>
            <?php endif ?>
        <?php endif ?>

    </div>
    <?php endif ?>
</div>
     
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 


<!-- Modal -->
 <div class="aitsun-modal modal fade" id="concession_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addteamLabel">Add concession</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">

                <?php if ($invoice['concession_for']!=''): ?>
                     <table class="table table-sm table-striped table-bordered" style="font-size: 14px;">
                        <tr>
                            <th>Concession For</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php foreach (concession_data($invoice['id']) as $cn): ?>
                            <tr>
                                <td><?= $cn['concession_for']; ?></td>
                                <td class="text-center"><?= currency_symbol($cn['company_id']) ?> <?= $cn['discount']; ?></td>
                                <td class="text-center">
                                    <a class="text-danger delete_concession"  data-deleteurl="<?= base_url(); ?>/fees_and_payments/delete_concession/<?= $cn['id'];?>">
                                    <i class="bx bx-trash"></i>
                                </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                <?php endif ?>

               
                <?php if ($invoice['due_amount']>0): ?>
                <form method="post" action="<?= base_url('fees_and_payments/add_concession_fee'); ?>">
                    <?= csrf_field() ?>
                    <div class="form-group">

                        <input type="hidden" name="invoice_id" value="<?= $invoice['id']; ?>">
                        <input type="hidden" name="student_id" value="<?= $invoice['customer']; ?>">
                        <input type="hidden" name="fees_id" value="<?= $invoice['fees_id']; ?>">
                        <input type="hidden" name="sub_total" value="<?= $invoice['sub_total']; ?>">
                        <input type="hidden" name="total" value="<?= $invoice['total']; ?>">
                        <input type="hidden" name="paid_amount" value="<?= $invoice['paid_amount']; ?>">
                        <input type="hidden" name="main_total" value="<?= $invoice['main_total']; ?>">
                        
                        <label>For why?</label>
                        <select class="form-control" name="concession_for" required>
                            <option value="Regular discount">Regular discount</option>
                            <option value="Sports quota">Sports quota</option>
                            <option value="Handicapped">Handicapped</option>
                            <option value="Right to education(RTE)">Right to education(RTE)</option> 
                        </select> 

                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" step="any" class="form-control" name="discount_amount" min="1" required>
                    </div>

                    <div class="form-group"> 
                           <button class="aitsun-primary-btn mt-2" type="submit">Add concession</button>
              
                    </div>
                </form>
                   <?php endif ?>     
            </div>
        </div>
    </div>
</div>
<!-- Modal -->


<!-- Modal -->
 <div class="aitsun-modal modal fade" id="additional_fees" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addteamLabel">Add/Remove Fee</h5>
                <button type="button" class="close close_school" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false;" method="post" action="<?= base_url('fees_and_payments/add_additional_fee'); ?>" id='add_and_remove_fees_form'>
                    <?= csrf_field() ?>
                    <div class="form-row">

                        <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice['id']; ?>">
                        <input type="hidden" name="student_id" value="<?= $invoice['customer']; ?>">
                        <input type="hidden" name="fees_id" value="<?= $invoice['fees_id']; ?>">
                        <input type="hidden" name="sub_total" value="<?= $invoice['sub_total']; ?>">
                        <input type="hidden" id="total" name="total" value="<?= $invoice['total']; ?>">
                        <input type="hidden" id="main_total" name="main_total" value="<?= $invoice['main_total']; ?>">
                        <input type="hidden" name="paid_amount" value="<?= $invoice['paid_amount']; ?>">



                        
                        <input type="text" name="search_car" id="search_fees_data" placeholder="Type 3 charecters and press enter" class="form-control mb-1" data-invoice_id="<?= $invoice['id']; ?>" data-select_url="<?= base_url('fees_and_payments/get_all_fees_list'); ?>" >
                        
                        <div class="search_fee_select">
                           <table id="search_feestable_data" class="w-100"> 

                           </table>
                         </div>

                       
                         

                    </div>
                    
                </form>
                        
            </div>
        </div>
    </div>
</div>
<!-- Modal -->




<!-- Modal -->
 <div class="aitsun-modal modal fade" id="send_reminder_model">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addteamLabel">Send reminder</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="sms_form_my">
                    <?= csrf_field() ?>

                    <div class="form-row">

                        <input type="hidden" name="invoice_id" value="<?= $invoice['id']; ?>">
                        <input type="hidden" name="student_id" value="<?= $invoice['customer']; ?>">
                        <input type="hidden" name="fees_id" value="<?= $invoice['fees_id']; ?>">
                        <input type="hidden" name="sub_total" value="<?= $invoice['sub_total']; ?>">
                        <input type="hidden" name="total" value="<?= $invoice['total']; ?>">
                        <input type="hidden" name="main_total" value="<?= $invoice['main_total']; ?>">
                        <input type="hidden" name="paid_amount" value="<?= $invoice['paid_amount']; ?>">

                        
                            
                        <label>Send Notification</label>
                         

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12 p-0"> 

                           <button class="btn btn-dark" type="button" id="notify_student_fees" data-phone="<?= user_phone($invoice['customer']); ?>" data-action="<?= base_url('notifications/fees_remind') ?>/<?= $invoice['customer']; ?>" data-due_amount="<?= $invoice['due_amount']; ?>" data-invoice_id="<?= $invoice['id']; ?>" data-fees_id="<?= $invoice['fees_id']; ?>">Notify</button>
                        </div>
                    </div>


                    <div class="form-row mt-2">

                        <input type="hidden" id="invoice_id" name="invoice_id" value="<?= $invoice['id']; ?>">
                        <input type="hidden" id="student_id" name="student_id" value="<?= $invoice['customer']; ?>">
                        <input type="hidden" id="fees_id" name="fees_id" value="<?= $invoice['fees_id']; ?>">
                        <input type="hidden" id="sub_total" name="sub_total" value="<?= $invoice['sub_total']; ?>">
                        <input type="hidden" id="total" name="total" value="<?= $invoice['total']; ?>">
                        <input type="hidden" id="main_total" name="main_total" value="<?= $invoice['main_total']; ?>">
                        <input type="hidden" id="paid_amount" name="paid_amount" value="<?= $invoice['paid_amount']; ?>">

                        
                            
                        <div>
                            <label class="d-block mb-1">Write message</label>
                        <small class="mb-1 d-block text-danger">Please dont add any emoji or icons in message</small>
                        </div>

                            <input type="hidden" name="phone" value="<?= user_phone($invoice['customer']); ?>">
<textarea class="form-control mb-3" name="fees_message" rows="5" placeholder="" id="fees_message">Dear Mr/Ms <?= get_student_data(company($user['id']),$invoice['customer'],'father_name'); ?>,
This is to inform you that the school fee of <?= user_name($invoice['customer']) ?> will due on this month. You are requested to pay the fees as soon as possible to avoid additional late fees.

The total due amount is <?= currency_symbol_for_sms(company($user['id'])) ?> <?= $invoice['due_amount']; ?>.

Regards,
<?= organisation_name($user['company_id']); ?></textarea>  


                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12 p-0"> 
                           <button class="aitsun-primary-btn mt-2" type="button" id="sms_notify_student_fees" data-phone="" data-action="<?= base_url('messaging/fees_remind') ?>/<?= $invoice['customer']; ?>" data-due_amount="<?= $invoice['due_amount']; ?>" data-invoice_id="<?= $invoice['id']; ?>" data-fees_id="<?= $invoice['fees_id']; ?>">Send SMS</button>
                        </div>
                    </div>
                </form>
                        
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content overflow-scroll bg-invoice">
    <div class="aitsun-row justify-content-center "> 
        
        <div class="invoice_card paper_shadow" >
            <div class="card-body" >
                <div id="">
                   <div class=" ">
                       
                        <div id="pdfthis" class="pdfthis">

                            <iframe class="aitsun-embed" id="aitsun-embed"
src="<?= base_url('fees_and_payments/get_challan'); ?>/<?= $invoice['id']; ?>/view#toolbar=0&navpanes=0&scrollbar=0" width="900" height="600"/></iframe>

                        </div>
                        <div id="pdfthermalthis" class="rounded-3 py-3"></div>
                        <div id="editor"></div>
                   </div>



                   
                </div>
            </div>
        </div>


    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
    <div>
        <a href="" data-bs-toggle="modal" data-bs-target="#add_settings" class="text-dark font-size-footer"><i class="bx bx-plus"></i> <span class="my-auto">Challan Settings</span></a>
    </div>

</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

 

<!--  Modal -->
<div class="modal fade aistun-modal" id="add_settings"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Add Challan Settings'); ?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" action="<?= base_url('add_challan_settings'); ?>/<?= $invoice['id']; ?>">
        <?= csrf_field(); ?>
      <div class="modal-body">
      
        <div class="row">
            <div class="col-md-6">
            <div class="form-group mb-2 ">
                <label class="font-weight-semibold" for="footer_title">Footer Title:</label>
                <div class="input-affix d-block">
                    <input type="text" class="form-control" id="footer_title" name="footer_title" placeholder="Footer Title" autocomplete="off" value="<?= get_organisation_settings2(company($user['id']),'footer_title'); ?>">
                </div>
            </div>

            <div class="form-group mb-2 ">
                <label class="font-weight-semibold">Description:</label>
                <div class="input-affix d-block">
                    <textarea class="form-control pl-3" id="description" name="description" placeholder="Description" rows="5"><?= get_organisation_settings2(company($user['id']),'description'); ?></textarea>
                </div>
            </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between mb-3">
                    <div class="form-group my-auto w-100 ">
                        <label class="font-weight-semibold">Signature:</label>
                        <div class="input-affix d-block position-relative">
                            <input type="file" class="p-1 form-control" id="sign_logo" accept="image/*" name="sign_logo" placeholder="Logo">
                            
                            <input type="hidden" class="form-control" id="old_sign" value="<?= get_organisation_settings2(company($user['id']),'sign_logo'); ?>" name="old_sign">

                             <?php if (get_organisation_settings2(company($user['id']),'sign_logo')!= ''): ?>
                            <a data-url="<?= base_url('fees_and_payments/remove_signature'); ?>/<?= get_organisation_settings2(company($user['id']),'id'); ?>/<?= $invoice['id']; ?>" class="delete no_loader" style="position: absolute;width: 150px;right: 0; height: 29px;display: flex;justify-content: center;align-items: center;top: 0; ">
                        <div class="delete_sign_bg">Remove</div>
                        </a>
                        <?php endif ?>


                        </div>
                    </div>
                    <div class="my-auto position-relative">
                        <img src="<?= base_url('public/uploads/signature'); ?>/<?php if(get_organisation_settings2(company($user['id']),'sign_logo') != ''){echo get_organisation_settings2(company($user['id']),'sign_logo'); }else{ echo 'thumb-3.jpg';} ?>" style="width: 31px;position: absolute;left: -35px;top: -4px;height: 31px;object-fit: contain;">
                    </div>
                </div>

            
                <div class="d-flex justify-content-between mb-3">
                    
                
                <div class="form-group my-auto w-100 ">
                    <label class="font-weight-semibold">Payslip Signature:</label>
                    <div class="input-affix d-block position-relative">
                        <input type="file" class="p-1 form-control" id="payslip_signature" accept="image/*" name="payslip_signature" placeholder="Logo">
                        
                        <input type="hidden" class="form-control" id="old_sign" value="<?= get_organisation_settings2(company($user['id']),'payslip_signature'); ?>" name="old_payslip_signature">
                           <?php if (get_organisation_settings2(company($user['id']),'payslip_signature')!= ''): ?>
                    <a data-url="<?= base_url('fees_and_payments/remove_pay_slip_signature'); ?>/<?= get_organisation_settings2(company($user['id']),'id'); ?>/<?= $invoice['id']; ?>" class="delete no_loader" style="position: absolute;width: 150px;right: 0; height: 29px;display: flex;justify-content: center;align-items: center;top: 0; ">
                    <div class="delete_sign_bg">Remove</div>
                    </a>
                    <?php endif ?>
                    </div>
                </div>

                <div class="my-auto position-relative">
                    <img src="<?= base_url('public/uploads/signature'); ?>/<?php if(get_organisation_settings2(company($user['id']),'payslip_signature') != ''){echo get_organisation_settings2(company($user['id']),'payslip_signature'); }else{ echo 'thumb-3.jpg';} ?>" style="width: 31px;position: absolute;left: -35px;top: -4px;height: 31px;object-fit: contain;">
                 
                    

                </div>
                </div>

                 <div class="d-flex justify-content-between">
                    <div class="form-group my-auto w-100 ">
                        <label class="font-weight-semibold">Payment QR code:</label>
                        <div class="input-affix d-block position-relative">
                            <input type="hidden" class="form-control" id="upi" name="upi" placeholder="example@okhdfcbank" value="<?= get_organisation_settings2(company($user['id']),'upi'); ?>">
                            <input type="file" class="form-control p-1" id="qr_code" accept="image/*" name="qr_code" placeholder="QR Code">

                             <?php if (get_organisation_settings2(company($user['id']),'upi')!= ''): ?>
                            <a data-url="<?= base_url('fees_and_payments/remove_qr_code'); ?>/<?= get_organisation_settings2(company($user['id']),'id'); ?>/<?= $invoice['id']; ?>" class="delete no_loader" style="position: absolute;width: 150px;right: 0; height: 29px;display: flex;justify-content: center;align-items: center;top: 0; ">
                        <div class="delete_sign_bg">Remove</div>
                        </a>
                        <?php endif ?>

                        </div>
                    </div>
                    <div class="my-auto position-relative">
                        <img src="<?= base_url('public/uploads/signature'); ?>/<?php if(get_organisation_settings2(company($user['id']),'upi') != ''){echo get_organisation_settings2(company($user['id']),'upi'); }else{ echo 'thumb-3.jpg';} ?>" style="width: 31px;position: absolute;left: -35px;top: -4px;height: 31px;object-fit: contain;">
                       
                    </div>
                </div>

            </div>



            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="font-weight-semibold" for="bank">Bank details:</label>
                    <div class="input-affix d-block position-relative">
                        <textarea type="text" class="form-control" id="bank" name="bank" placeholder="Bank Name" autocomplete="off" rows="5"><?= get_organisation_settings2(company($user['id']),'bank'); ?></textarea>
                    </div>
                </div>
            </div>

     
        

          <div class="col-md-6">
              <div class="form-group mb-2">
                <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Select Page Size'); ?></label>
                <select class="form-control form-control-sm"name="challan_page_size">
                    <option value="" selected>select page size</option>
                    <option value="a4" <?php if (get_setting2(company($user['id']),'challan_page_size') == 'a4') {echo 'selected';} ?>>A4</option>
                    <option value="a5" <?php if (get_setting2(company($user['id']),'challan_page_size') == 'a5') {echo 'selected';} ?>>A5</option>
                    <option value="a3" <?php if (get_setting2(company($user['id']),'challan_page_size') == 'a3') {echo 'selected';} ?>>A3</option>
                </select>
            
              </div>

              <div class="form-group mb-2">
                <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Select Orientation'); ?></label>
                    <select class="form-control form-control-sm"name="challan_orientation">
                        <option value="" selected>select orientation</option>
                        <option value="landscape" <?php if (get_setting2(company($user['id']),'challan_orientation') == 'landscape') {echo 'selected';} ?> >Landscape</option>
                        <option value="portrait" <?php if (get_setting2(company($user['id']),'challan_orientation') == 'portrait') {echo 'selected';} ?>>Portrait</option>
                    </select>
              </div>
          </div>


          
        </div>
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        <button type="submit" class="aitsun-primary-btn" name="add_challan_settings"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- end Modal -->



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

 