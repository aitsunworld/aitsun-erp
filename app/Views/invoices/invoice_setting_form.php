

            <div class="col-md-12 ms-0 row">
                <div class="col-md-4 p-2 mb-2" style="border: 1px solid #80808061">
                    <h5 class="mt-2"><b>Header Section</b></h5>

                    <div class="form-group col-md-6 mt-3">
                        <div class="form-check form-switch">

                            <input type="checkbox" class="form-check-input"  name="show_business_name" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_business_name') == '1') {echo 'checked';} ?>>

                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Business Name'); ?></label>
                        </div>
                   </div>


                   <div class="form-group col-md-6">
                        <div class="form-check form-switch">

                            <input type="checkbox" class="form-check-input"  name="show_business_address" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_business_address') == '1') {echo 'checked';} ?>>

                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Business Address'); ?></label>
                        </div>
                   </div>


                   <div class="form-group col-md-6">
                        <div class="form-check form-switch">

                            <input type="checkbox" class="form-check-input"  name="show_tax_details" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_tax_details') == '1') {echo 'checked';} ?>>

                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Tax Details'); ?></label>
                        </div>
                   </div>


                    <div class="form-group col-md-6">
                        <div class="form-check form-switch">

                            <input type="checkbox" class="form-check-input"  name="show_header" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_header') == '1') {echo 'checked';} ?>>

                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Heading'); ?></label>
                        </div>
                   </div>

                    <div class="form-group col-md-6 ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_logo" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_logo') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Logo'); ?></label>
                        </div>
                   </div>

                   <div class="form-group col-md-6 ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_invoice_header" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_invoice_header') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Invoice Header'); ?></label>
                        </div>
                   </div>

                   <div class="form-group col-md-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="invoice_num" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_num') == '1') {echo 'checked';} ?>>
                                <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Invoice Number'); ?></label>
                            </div>
                        </div>

                        
                        <div class="form-group col-md-12">
                            <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="show_vehicle_number" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_vehicle_number') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Vehicle Number'); ?></label>
                            </div>
                        </div>
                        

                   

                    <div class="d-flex justify-content-between">
                        <div class="my-auto">   
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Invoice Header'); ?></label>         
                            <input type="file" accept="image/*" class="form-control" name="invoice_header"  style="height: 35px;">
                            <input type="hidden" name="old_invoice_header" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_header') ?>">       
                        </div>
                      

                        <div class="my-auto">
                            <?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_header'))){ ?>
                           <img src="<?= base_url('public/images/company_docs') ?>/<?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_header'))){echo (get_invoicesetting(company($user['id']),$invoice_type,'invoice_header'));}else{} ?>" class="my-auto py-2" style="max-height: 60px;">    
                           <?php } ?>                  
                        </div>
                    </div>
                </div>


                <div class="col-md-3 p-2 mb-2" style="border: 1px solid #80808061">
                    <h5 class="mt-2"><b>Customer Details</b></h5>
                    <div class="form-group mt-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input"  name="show_due_date" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_due_date') == '1') {echo 'checked';} ?>>
                                <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show due date'); ?></label>
                            </div>
                       </div>


                    <div class="form-group ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_date" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_date') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Invoice Date'); ?></label>
                        </div>
                   </div>

                   <div class="form-group ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_bill_to" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_bill_to') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Bill to'); ?></label>
                        </div>
                   </div>

                   <div class="form-group ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_customer_address" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_customer_address') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Customer Billing Address'); ?></label>
                        </div>
                   </div>

                   <div class="form-group ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_customer_shipping_address" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_customer_shipping_address') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Customer Shipping Address'); ?></label>
                        </div>
                   </div>

                   <div class="form-group ">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_bill_number" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_bill_number') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Bill Number'); ?></label>
                        </div>
                   </div>

                </div>

                <div class="col-md-5 mb-2" style="border: 1px solid #80808061">
                    <h5 class="mt-2"><b>Bank Details</b></h5>

                    <div class="d-flex justify-content-between">
                           <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input"  name="show_qr_code" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_qr_code') == '1') {echo 'checked';} ?>>

                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show QR Code'); ?></label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input"  name="show_bank_details" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_bank_details') == '1') {echo 'checked';} ?>>
                                <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Bank Details'); ?></label>
                            </div>
                    </div>


                    <div class="d-flex justify-content-between mt-1">
                        <div class="my-auto">            
                            <label class="form-label mb-0"><?= langg(get_setting(company($user['id']),'language'),'QR Code'); ?></label>
                            <input type="file" accept="image/*" class="form-control" name="invoice_qr_code"  style="height: 35px;">
                        <input type="hidden" name="old_invoice_qr_code" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_qr_code') ?>">         
                        </div>
                      
                        <div class="my-auto">
                            <?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_qr_code'))) { ?>
                           <img src="<?= base_url('public/images/company_docs') ?>/<?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_qr_code'))){echo (get_invoicesetting(company($user['id']),$invoice_type,'invoice_qr_code'));}else{echo 'alt.png';} ?>" class="my-auto py-2" style="max-height: 60px;"> 
                            <?php } ?>             
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-6 my-auto  form-group mt-1">
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Bank Details'); ?></label>
                            <textarea class="form-control" name="bank_details" rows="3"><?= get_invoicesetting(company($user['id']),$invoice_type,'bank_details'); ?></textarea>
                       </div>

                        <div class="my-auto col-md-6 mt-1">
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'UPI'); ?></label>
                            <input type="text" class="form-control" name="upi" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'upi'); ?>">
                       </div>
                    </div>
                    
                </div>

                <div class="col-md-4 p-2" style="border: 1px solid #80808061">
                    <h5 class="mt-2"><b>Footer Section</b></h5>
                    <div class="container px-2">
                      <div class="row mt-2">
                        <div class="form-check form-switch col-md-6">
                            <input type="checkbox" class="form-check-input"  name="show_footer" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_footer') == '1') {echo 'checked';} ?>>

                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Footer'); ?></label>
                        </div>
                        <div class="form-check form-switch col-md-6">
                            <input type="checkbox" class="form-check-input"  name="show_declaration" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_declaration') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Declaration'); ?></label>
                        </div>
                   
                        <div class="form-check form-switch col-md-6">
                            <input type="checkbox" class="form-check-input"  name="show_terms" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_terms') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show T&C'); ?></label>
                        </div>
                      
                        <div class="form-check form-switch col-md-6">
                            <input type="checkbox" class="form-check-input" name="show_signature" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_signature') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Signature'); ?></label>
                        </div>
                   

                        <div class="form-check form-switch col-md-6">
                            <input type="checkbox" class="form-check-input" name="show_seal" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_seal') == '1') {echo 'checked';} ?>>
                            <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Seal'); ?></label>
                        </div>
                        <div class="form-check form-switch col-md-6">
                                <input type="checkbox" class="form-check-input" name="show_reciver_sign" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_reciver_sign') == '1') {echo 'checked';} ?>>
                                <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Receiver Signature'); ?></label>
                        </div>
                        <div class="form-group col-md-6 mt-2 px-1">
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Declaration'); ?></label>
                            <textarea class="form-control" name="invoice_declaration"><?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_declaration');  ?></textarea>
                        </div>
                        <div class="form-group col-md-6 mt-2 px-1">
                                <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Terms & Conditions'); ?></label>
                                <textarea class="form-control" name="invoice_terms"><?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_terms'); ?></textarea>
                        </div>
                    </div>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <div class="my-auto">
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Signature'); ?></label>
                            <input type="file" accept="image/*" class="form-control" name="invoice_signature"  style="height: 35px;">
                            <input type="hidden" name="old_invoice_signature" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_signature') ?>">
                        </div>
                        <div class="my-auto">
                            <?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_signature'))) { ?>
                            <img src="<?= base_url('public/images/company_docs') ?>/<?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_signature'))){echo (get_invoicesetting(company($user['id']),$invoice_type,'invoice_signature'));}else{echo 'alt.png';} ?>" class="my-auto py-2" style="max-height: 60px;">
                            <?php } ?>
                        </div>
                    </div>

                   

                    <div class="d-flex justify-content-between mt-2">
                        <div class="my-auto">
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Seal'); ?></label>
                            <input type="file" accept="image/*" class="form-control" name="invoice_seal"  style="height: 35px;">
                            <input type="hidden" name="old_invoice_seal" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_seal') ?>">
                        </div>
                        <div class="my-auto">
                            <?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_seal'))){ ?>
                                <img src="<?= base_url('public/images/company_docs') ?>/<?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'invoice_seal'))){echo (get_invoicesetting(company($user['id']),$invoice_type,'invoice_seal'));}else{echo 'alt.png';} ?>" class="my-auto py-2" style="max-height: 60px;">
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Footer text'); ?></label>
                        <textarea class="form-control" name="invoice_footer"><?= get_invoicesetting(company($user['id']),$invoice_type,'invoice_footer'); ?></textarea>
                    </div>

                    <div class="form-check form-switch col-md-6 mt-2">
                        <input type="checkbox" class="form-check-input" name="show_footer_image" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_footer_image') == '1') {echo 'checked';} ?>>
                        <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show footer image'); ?></label>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <div class="my-auto">
                            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Footer Image'); ?></label>
                            <input type="file" accept="image/*" class="form-control" name="footer_image"  style="height: 35px;">
                            <input type="hidden" name="old_footer_image" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'footer_image') ?>">
                        </div>
                        <div class="my-auto">
                            <?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'footer_image'))){ ?>
                                <img src="<?= base_url('public/images/company_docs') ?>/<?php if(!empty(get_invoicesetting(company($user['id']),$invoice_type,'footer_image'))){echo (get_invoicesetting(company($user['id']),$invoice_type,'footer_image'));}else{echo 'alt.png';} ?>" class="my-auto py-2" style="max-height: 60px;">
                            <?php } ?>
                        </div>
                    </div>

                </div>

               


                <div class="col-md-8 p-2" style="border: 1px solid #80808061;border-right: none;">
                    <h5 class="mt-2"><b>Product Section</b></h5>

                    <div class="row">
                        
                            <div class="form-group col-md-12">
                                <div class="form-check form-switch">

                                    <input type="checkbox" class="form-check-input"  name="show_pro_desc" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_pro_desc') == '1') {echo 'checked';} ?>>

                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show product description'); ?></label>
                                </div>
                           </div>



                            <div class="form-group col-md-4">
                                <div class="form-check form-switch">

                                    <input type="checkbox" class="form-check-input"  name="show_batch_no" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_batch_no') == '1') {echo 'checked';} ?>>

                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Batch Number'); ?></label>
                                </div>
                           </div>

                            <div class="form-group col-md-4">
                                <div class="form-check form-switch">

                                    <input type="checkbox" class="form-check-input"  name="show_price" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_price') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal" ><?= langg(get_setting(company($user['id']),'language'),'Show Price'); ?></label>
                                </div>
                           </div>

                            <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="show_tax" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_tax') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Tax'); ?></label>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input"  name="show_discount" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_discount') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Discount'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                   <input type="checkbox" class="form-check-input"  name="show_quantity" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_quantity') == '1') {echo 'checked';} ?>>
                                  <label class="form-check-label font-weight-normal" ><?= langg(get_setting(company($user['id']),'language'),'Show Quantity'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="show_expiry_date" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_expiry_date') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show expiry date'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="round_off" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'round_off') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Round off'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="due_amount" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'due_amount') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Due Amount'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                   <input type="checkbox" class="form-check-input"  name="show_uom" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_uom') == '1') {echo 'checked';} ?>>
                                  <label class="form-check-label font-weight-normal" ><?= langg(get_setting(company($user['id']),'language'),'Show UOM'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                   <input type="checkbox" class="form-check-input"  name="show_hsncode_no" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_hsncode_no') == '1') {echo 'checked';} ?>>
                                  <label class="form-check-label font-weight-normal" ><?= langg(get_setting(company($user['id']),'language'),'Show item identity'); ?></label>
                                </div>
                           </div>
                           <div class="form-group col-md-4 d-none">
                                <div class="form-check form-switch">
                                   <input type="checkbox" class="form-check-input" name="billing_style" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'billing_style') == '1') {echo 'checked';} ?>>
                                  <label class="form-check-label font-weight-normal" ><?= langg(get_setting(company($user['id']),'language'),'Disable grid billing'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="show_validity" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_validity') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Validity'); ?></label>
                                </div>
                           </div>
                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input"  name="show_mrn_num" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_mrn_num') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'MRN Number'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input"  name="show_amount" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_amount') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Amount'); ?></label>
                                </div>
                           </div>

                            

                            <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input"  name="mode_of_payment" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'mode_of_payment') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Mode Of payment'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input"  name="show_tax_tin_num" value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'show_tax_tin_num') == '1') {echo 'checked';} ?>>
                                    <label class="form-check-label font-weight-normal"><?= langg(get_setting(company($user['id']),'language'),'Show Tax & Tin Number'); ?></label>
                                </div>
                           </div>

                           <div class="form-group col-md-4  mt-2">
                                <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'TIN Number'); ?></label>
                                <input type="number" class="form-control" name="tinnumber" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'tinnumber') ?>">
                           </div>

                            <div class="form-group col-md-4  mt-2">
                                <label  class="form-label">Search Type</label>
                                <select class="form-select save_side_bar_change" name="cursor_position">
                                  <option value="0" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'cursor_position') == '0') {echo 'selected';} ?>>Search bar</option>
                                  <option value="2" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'cursor_position') == '2') {echo 'selected';} ?>>Barcode</option>
                                  <option value="1" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'cursor_position') == '1') {echo 'selected';} ?>>Product Code</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                    <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Tax Card Number'); ?></label>
                                    <input type="number" class="form-control" name="taxnumber" value="<?= get_invoicesetting(company($user['id']),$invoice_type,'taxnumber') ?>">
                            </div>


                     </div>
                     

                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mt-3">

                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="1"  <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '1') {echo 'checked';} else{
                                    echo 'checked';
                                }  ?>>
                                <img src="<?= base_url('public'); ?>/images/in1.png" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Basic</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mt-3">
                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="2" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '2') {echo 'checked';} ?>>
                                <img src="<?= base_url('public'); ?>/images/in2.jpg" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Standard</p>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-check mt-3">
                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="3" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '3') {echo 'checked';} ?>>
                                <img src="<?= base_url('public'); ?>/images/in3.png" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Hardware</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mt-3">
                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="4" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '4') {echo 'checked';} ?>>
                                <img src="<?= base_url('public'); ?>/images/in4.png" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Wholesale</p>
                            </div>
                        </div>
                        <?php if (company($user['id'])==8): ?> 
                        <div class="col-md-4">
                            <div class="form-check mt-3">
                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="5" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '5') {echo 'checked';} ?>>
                                <img src="<?= base_url('public'); ?>/images/in5.png" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Standard Quotaion</p>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-4">
                            <div class="form-check mt-3">
                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="6" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '6') {echo 'checked';} ?>>
                                <img src="<?= base_url('public'); ?>/images/in4.png" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Rental</p>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-check mt-3">
                                <input class="form-check-input my-5" type="radio" name="invoice_temp" id="invoice_temp" value="7" <?php if (get_invoicesetting(company($user['id']),$invoice_type,'invoice_template') == '7') {echo 'checked';} ?>>
                                <img src="<?= base_url('public'); ?>/images/in4.png" style="width: 100px; box-shadow: 0px 1px 2px 1px #0000002b;">
                                <p class="mb-0">Trsanportation</p>
                            </div>
                        </div>
 
                    </div>
                     

                    
                </div>

            </div>
 