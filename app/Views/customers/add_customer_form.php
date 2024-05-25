<!-- //////////////FORMMMMM/////////////////// -->
                  <form method="post" id="add_cust_form" action="<?= base_url('customers/save_customer'); ?>">
                    <?= csrf_field(); ?>
            
                      <div class="row">

                          
                       
                        <div class="col-md-12 row m-0 p-0" >
                              <input type="hidden" name="withajax" id="withajax" value="0">
                               <div class=" col-md-6 mb-2">

                                <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="display_name" id="display_name">
                               </div>

                               <div class=" col-md-6 mb-2">
                                <label for="input-3" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Email'); ?> </label>
                                <input type="text" class="form-control modal_inpu" name="email" id="email">
                               </div>

                               <div class=" col-md-6 mb-2 d-none">
                                <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact Name'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="contact_name" id="contact_name">
                               </div>

                               <div class=" col-md-6 mb-2">
                                <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Party Type'); ?></label>
                                <select class="form-select" name="party_type" id="party_type">
                                    <option value="customer">Customer</option>
                                    <option value="vendor">Vendor</option>
                                </select>
                               </div>

                               <div class=" col-md-6 mb-2">
                                <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact'); ?></label>
                                <div class="d-flex">
                                  <select class="form-select w-25" name="country_code">
                                    <?php foreach (countries_array(company($user['id'])) as $ct): ?>
                                        <option value="<?= $ct['country_code'] ?>" <?php if (get_company_data($user['company_id'],'country')==$ct['country_name']){ echo "selected";} ?>><?= $ct['country_code'] ?> - <?= $ct['country_name'] ?></option>
                                    <?php endforeach ?>
                                  </select>
                                  <input type="text" class="form-control modal_inpu" name="phone" id="phone">
                                </div>
                                
                               </div>
                               
                               <div class=" col-md-6 mb-2 d-none">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Website'); ?></label>
                                <input type="text" class="form-control modal_inpu" name="website" id="website">
                               </div>

                             

                               <div class=" col-md-6 mb-2">
                                <label for="input-5" class="modal_lab">
                                  <?php if (get_company_data($user['company_id'],'country')=='India'):?>
                                    <?= langg(get_setting(company($user['id']),'language'),'GSTIN'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                                  <?php endif; ?>
                                  </label>
                                 
                                 <input type="text" class="form-control modal_inpu" name="gstno" id="gst_input" value="" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$">
                               </div>

                               <div class=" col-md-6 mb-2">
                                <label for="input-5" class="modal_lab">
                                  <?php if (get_company_data($user['company_id'],'country')=='India'):?>
                                    <?= langg(get_setting(company($user['id']),'language'),'State'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'Governorate'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'Emirates'); ?>
                                  <?php endif; ?>
                                </label>
                                 
                                 <div class="position-relative" id="layerer">
                                     
                                      <select class="form-select modal_inpu" name="billing_state" id="state_select_box">
                                          <option value="">Choose</option>
                                          <?php foreach (states_array(company($user['id'])) as $st): ?>
                                              <option value="<?= $st ?>" ><?= $st ?></option>
                                          <?php endforeach ?>
                                      </select>
                                  </div>
                               </div>

                               <div class=" col-md-4 mb-2">
                                   <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                              
                                  <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="opening_balance">
                                </div>


                                <div class=" col-md-4  mb-2">
                                    <label>Type</label>
                                  <select class="form-select" name="opening_type" id="opening_type">
                                      <option value="">To Collect</option>
                                      <option value="-">To Pay</option>
                                  </select>

                                </div>

                                
                                <div class=" col-md-4 mb-2">
                                   <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Credit limit'); ?></label>
                              
                                  <input type="number" min="0" step="any" value="0" class="form-control " name="credit_limit" id="credit_limit">
                                </div>

                               <div class=" col-md-12  mb-3">
                                <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address'); ?></label>
                                <textarea class="form-control modal_inpu" name="billing_address" id="billing_address" cols="5"></textarea>
                               </div>

                               <div id="errrr" class=" col-md-12 text-danger"></div>

                               <div class=" col-md-12">
                                <button type="button" class="aitsun-primary-btn w-25" name="add_customer" data-action="<?= base_url('customers'); ?>" id="add_customer_ajax"><?= langg(get_setting(company($user['id']),'language'),'Save Customer'); ?></button>

                               </div>
                               

                              
                        </div>
                      </div>
                    
                      
                 
                  </form>
                  <!-- //////////////FORMMMMM/////////////////// -->