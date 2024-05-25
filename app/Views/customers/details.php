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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url('customers'); ?>">Parties</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= $cust['display_name']; ?></b>
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
 

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="no_toolbar_sub_main_page_content">
<div class="aitsun-row pb-5">
 
 
    <div class="col-lg-4">
        <div class="card bg-none">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?= base_url(); ?>/public/images/avatars/<?php if($cust['profile_pic'] != ''){echo $cust['profile_pic']; }else{ echo 'avatar-icon.png';} ?>" alt="Admin" class="rounded-circle p-1 bg-dark" width="110" height="110">
                    <div class="mt-3">
                        <h4><?= $cust['display_name']; ?></h4>
                        <?php if ($cust['default_user']!=1): ?>
                             <p class="text-secondary mb-1"><?= $cust['billing_address']; ?></p>
                            <a href="tel:<?= $cust['phone']; ?>" class="btn btn-sm btn-success">Call</a>
                            <a href="mailto:<?= $cust['email']; ?>" class="btn btn-sm btn-outline-primary">Message</a>
                            
                        <?php endif ?>
                    </div>
                </div>
                <hr class="my-4" />
                <ul class="list-group list-group-flush">

                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h5><?= langg(get_setting(company($user['id']),'language'),'Standing'); ?></h5>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><?= langg(get_setting(company($user['id']),'language'),'Due amount'); ?></h6>
                        <span class="text-secondary"><?= currency_symbol($cust['company_id']); ?> <?= aitsun_round(due_amount_of_customer($cust['id'],company($user['id'])),get_setting(company($user['id']),'round_of_value')); ?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><?= langg(get_setting(company($user['id']),'language'),'Op. Balance'); ?></h6>
                        <span class="text-secondary">
                            <?= currency_symbol($cust['company_id']); ?> <?= str_replace('-','', aitsun_round($cust['opening_balance'],get_setting(company($user['id']),'round_of_value'))); ?>

                            
                            <small>
                               <?php if ($cust['opening_balance']>0) {echo '(<span class="text-success">To collect</span>)';}elseif ($cust['opening_balance']<0) {echo '(<span class="text-danger">To Pay</span>)';} ?>
                            </small>
                        </span>
                        
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><?= langg(get_setting(company($user['id']),'language'),'Cls. Balance'); ?></h6>
                        <span class="text-secondary">
                            <?= currency_symbol($cust['company_id']); ?> <?= str_replace('-','',aitsun_round($cust['closing_balance'],get_setting(company($user['id']),'round_of_value'))); ?>
                            
                            
                            <small>
                               <?php if ($cust['closing_balance']>0) {echo '(<span class="text-success">To collect</span>)';}elseif ($cust['closing_balance']<0) {echo '(<span class="text-danger">To Pay</span>)';} ?>
                            </small>
                        </span>
                        
                    </li>
                   
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card bg-none">
            <form method="post" id="edit_cust_form" >
                <?= csrf_field(); ?>
<div class="card-body">
<div>

<div class="col-md-12 row m-0" >

    <input type="hidden" name="old_email" value="<?= $cust['email'] ?>">
    <input type="hidden" name="old_phone" value="<?= $cust['phone'] ?>">
    <input type="hidden" name="current_closing_balance" value="<?= $cust['closing_balance'] ?>">
    <input type="hidden" name="current_opening_balance" value="<?= $cust['opening_balance'] ?>">


     <div class="form-group <?php if ($cust['default_user']!=1): ?> col-md-6 <?php else: ?> col-md-12<?php endif ?>">
      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?></label>
      <input type="text" id ="display_name" class="form-control modal_inpu" name="display_name" value="<?= $cust['display_name']; ?>" required>
     </div>
<?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-6">
      <label for="input-3" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Email/Username'); ?> </label>
      <input type="text" class="form-control modal_inpu" id="email" name="email" value="<?= $cust['email']; ?>">
     </div>
<?php endif ?>

     <div class="form-group col-md-6 d-none">
      <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact Name'); ?></label>
      <input type="text" class="form-control modal_inpu" name="contact_name" value="<?= $cust['display_name']; ?>" id="input-2">
     </div>

    <?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-6">
      <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Party Type'); ?></label>
      <select class="form-control" name="party_type">
          <option value="customer" <?php if ($cust['u_type']=='customer') {echo 'selected';} ?>>Customer</option>
          <option value="vendor" <?php if ($cust['u_type']=='vendor') {echo 'selected';} ?>>Vendor</option>
          <!-- <option value="delivery" <php if ($cust['u_type']=='delivery') {echo 'selected';} ?>>Delivery</option>
          <option value="seller" <php if ($cust['u_type']=='seller') {echo 'selected';} ?>>Seller</option> -->
      </select>
     </div>
    <?php endif ?>
    <?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-6">
      <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact'); ?></label>

      <div class="d-flex">
          <select class="form-select w-25" name="country_code">
            <?php foreach (countries_array(company($user['id'])) as $ct): ?>
                <option value="<?= $ct['country_code'] ?>" <?php if ($cust['country_code']==$ct['country_code']){ echo "selected";} else if(get_company_data($user['company_id'],'country')==$ct['country_name']){ echo "selected"; } ?>><?= $ct['country_code'] ?> - <?= $ct['country_name'] ?> </option>
            <?php endforeach ?>
          </select>
          <input type="text" id="phone" class="form-control modal_inpu" name="phone" value="<?= $cust['phone']; ?>">
        </div>

      

     </div>
    <?php endif ?>
     <!-- categry -->
        <?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-12 mb-2">

        <div class="d-flex justify-content-between">
            <label for="inputCollection" class="form-label my-auto">Category</label>
            <a class="p-0 add_parties_cat text-dark" id="add_parties_cat"><i class="bx bxs-plus-square" style="font-size: 25px;"></i></a>
        </div>
                        
        <div  class="d-flex">
            <div id="cat_container_parties" class=" mb-2" style="display: none;">
                <input type="text" name="parties_cat_name" id="parties_cat_name" class="ad_u">
                <button class="mr-2 adddd_unit_btn addd_parti_cate" id="addd_parti_cate"type="button">Add</button>
            </div>
        </div>

        <select class="form-select "  name="part_category" id="part_category">
            <option value="0">Select category</option>
            <?php foreach (parties_categories_array(company($user['id'])) as $pc): ?>
                <option value="<?= $pc['id']; ?>" <?php if ($cust['part_category']==$pc['id']) {echo 'selected';} ?>>
                    <?= $pc['parties_cat_name']; ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
        <?php endif ?>
     <!-- category -->
     
     <div class="form-group col-md-6 d-none">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Website'); ?></label>
      <input type="text" class="form-control modal_inpu" name="website" id="input-5">
     </div>
<?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-6">
      <label for="input-5" class="modal_lab"><?php if (get_company_data($user['company_id'],'country')=='India'):?>
                                    <?= langg(get_setting(company($user['id']),'language'),'GSTIN'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                                  <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                                  <?php endif; ?></label>
      <input type="text" class="form-control modal_inpu" name="gstno" value="<?= $cust['gst_no']; ?>" id="input-5">
     </div>
<?php endif ?>
<?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-6">
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
              <?php if ($cust['gst_no']>1): ?>
            <div class="disable_layer"></div> 
        <?php endif ?> 
                <select class="form-select modal_inpu" name="billing_state" id="state_select_box">
                    <option value="">Choose</option>
                    <?php foreach (states_array(company($user['id'])) as $st): ?>
                        <option value="<?= $st ?>" <?php if ($cust['billing_state']==$st) {echo "selected";} ?>><?= $st ?></option>
                    <?php endforeach ?>
                </select>
            </div>
         </div>

         <?php endif ?>

     <div class="form-group col-md-4 mb-2">
       <label for="input-5" class="modal_lab">Opening Balance</label>
  
      <input type="number" min="0" step="any" value="<?= str_replace('-','',aitsun_round($cust['opening_balance'],get_setting(company($user['id']),'round_of_value'))); ?>" class="form-control " name="opening_balance" id="input-5">

      <input type="hidden" name="current_balance" value="<?= aitsun_round($cust['opening_balance'],get_setting(company($user['id']),'round_of_value')); ?>">
    </div>


    <div class="form-group col-md-4 ">
        <label>Type</label>
          <select class="form-control" name="opening_type">

              <option value="" <?php if ($cust['opening_balance']>=0) {echo 'selected';} ?>>To Collect</option>
              <option value="-" <?php if ($cust['opening_balance']<0) {echo 'selected';} ?>>To Pay</option>


          </select>
    </div>

    <div class="form-group col-md-4 mb-2">
       <label for="input-5" class="modal_lab">Credit limit</label> 
      <input type="number" min="0" step="any" value="<?= aitsun_round($cust['credit_limit'],get_setting(company($user['id']),'round_of_value')) ?>" class="form-control " name="credit_limit" id="input-5">

      
    </div>

<?php if ($cust['default_user']!=1): ?>
     <div class="form-group col-md-12">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address'); ?></label>
      <textarea class="form-control modal_inpu" name="billing_address" id="input-5" cols="5"><?= $cust['billing_address']; ?></textarea>
     </div>
<?php endif ?>
     <!-- //new -->
    <div class="form-group col-md-12 mt-2 d-none"> 
        <input type="checkbox" id="savedas" name="savedas" value="contact" <?php if ($cust['saved_as']=='contact') { echo 'checked'; } ?>>
        <label for="savedas"> Save as contact</label>                   
    </div>


    <div class="col-md-12 <?php if ($cust['saved_as']!='contact') { echo 'd-none'; } ?>" id="customer_contact_details">
        <div class="row">
            <div class="form-group col-md-6 mt-2">
                <label class="input-5">phone 2 (Optional)</label>
                <input class="form-control" type= "number" value ="<?= $cust['phone_2'] ?>" name="phone_2" >
            </div>

             <div class="form-group col-md-6 mt-2">
                <label for="input-5">Landline (Optional)</label>
                <input class="form-control" type="number" value = "<?= $cust['landline'] ?>"  name="landline" id="landline">
            </div>

            <div class="form-group col-md-6 mt-2">
                <label for="input-5">Area</label>
                <input class="form-control" type="text" value = "<?= $cust['area'] ?>"  name="area" id="area">
            </div>

            <div class="form-group col-md-6 mt-2">
                <label for="input-5">Company</label>
                <input class="form-control" type="text" value = "<?= $cust['company'] ?>"  name="company" id="company">
            </div>


            <div class="form-group col-md-6 mt-2">
                <select name="contact_type" class="form-select" id="contacttype">
                <option value="">Contact type</option>

                <?php foreach (contact_typearray(company($user['id'])) as $ct): ?>
                    <option value="<?= $ct['id']; ?>" <?php if ($cust['contact_type']==$ct['id']) {echo 'selected';} ?>><?= $ct['contact_type'];?> </option>
                <?php endforeach ?>
                    
                </select>
            </div>

            <div class="form-group col-md-6 mt-2"> 
                <select name="designation" class="form-select" id="designation">
                <option value="">Designation</option>
                <?php foreach (designationarray(company($user['id'])) as $cc): ?>
                    <option value="<?= $cc['id']; ?>" <?php if ($cust['designation']==$cc['id']) {echo 'selected';} ?>><?= $cc['designation']; ?></option>
                <?php endforeach ?>

                </select>
            </div>

            <div class="form-group mt-2">
                <label>Location (Required)</label>
                <input type="hidden" name="location" id="cmy_location" class="form-control" required="">
                <input type="hidden" name="oldlocation" value="<?= $cust['location']; ?>">
                <button class="btn btn-success m-0 w-100" style="background-color:black;" id="find_btn" type="button">
                <i class="fa fa-map-marker"></i> Use current location</button>
            </div>
        </div>
    </div>

    <div id="error_mes">
          </div>


    <div class="col-md-12 form-group pt-3 text-right">
    <?php if ($cust['default_user']!=1): ?>
        <a data-url="<?php echo base_url('customers/delete'); ?>/<?= $cust['id']; ?>" class="py-2 aitsun-danger-btn delete"><span class="bx bx-trash"></span></a>

    <?php endif ?>
        <button type="submit" id ="edit_customer" class="aitsun-primary-btn w-25" name="edit_customer"><?= langg(get_setting(company($user['id']),'language'),'Save Customer'); ?></button>
    </div>
    
</div>
</div>

<div class="row d-none">
<div class="col-md-12">
<h5 class="text-dark"><?= langg(get_setting(company($user['id']),'language'),'Billing Address'); ?></h5>
<p><?= langg(get_setting(company($user['id']),'language'),"Customer's Billing Address"); ?></p>

</div>
<div class="col-md-12 row" >

     <div class="form-group col-md-6">
      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address Name'); ?></label>
      <input type="text" class="form-control modal_inpu" name="billing_name" id="input-1">
     </div>

     <div class="form-group col-md-6">
      <label for="input-3" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address email'); ?></label>
      <input type="email" class="form-control modal_inpu" name="billing_mail" id="input-3">
     </div>

      <div class="form-group col-md-6">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Country'); ?></label>
      <input type="text" class="form-control modal_inpu" name="billing_country" id="input-1">
     </div>

     
     <div class="form-group col-md-6">
      <label for="input-4" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'City'); ?></label>
      <input type="text" class="form-control modal_inpu" name="billing_city" id="input-4">
     </div>
     
     <div class="form-group col-md-6">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Postal code'); ?></label>
      <input type="text" class="form-control modal_inpu" name="billing_postalcode" id="input-5">
     </div>
     
    
</div>
</div>

<div class="row d-none">
<div class="col-md-4">
<h5 class="text-dark"><?= langg(get_setting(company($user['id']),'language'),'Shipping Address'); ?></h5>
<p><?= langg(get_setting(company($user['id']),'language'),"Customer's Shipping Address"); ?></p>

</div>
<div class="col-md-8 row" >

     <div class="form-group col-md-6">
      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address Name'); ?></label>
      <input type="text" class="form-control modal_inpu" name="shipping_name" id="input-1">
     </div>

     <div class="form-group col-md-6">
      <label for="input-3" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address email'); ?></label>
      <input type="email" class="form-control modal_inpu" name="shipping_mail" id="input-3">
     </div>

     <div class="form-group col-md-6">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Country'); ?></label>
      <input type="text" class="form-control modal_inpu" name="shipping_country" id="input-1">
     </div>

     <div class="form-group col-md-6">
      <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'State'); ?></label>
      <input type="text" class="form-control modal_inpu" name="shipping_state" id="input-2">
     </div>
     
     <div class="form-group col-md-6">
      <label for="input-4" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'City'); ?></label>
      <input type="text" class="form-control modal_inpu" name="shipping_city" id="input-4">
     </div>
     
     <div class="form-group col-md-6">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Postal code'); ?></label>
      <input type="text" class="form-control modal_inpu" name="shipping_postatlcode" id="input-5">
     </div>
     <div class="form-group col-md-12">
      <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address'); ?></label>
      <textarea class="form-control modal_inpu" id="input-5" name="shipping_address" cols="5"></textarea>
     </div>
    
</div>

</div>
</div>

</form>
</div>

<div class="row">
<div class="col-sm-12">
    <div class="card bg-none">
       
        <div class="card-body">
            <h5 class="d-flex align-items-center mb-3">Inventories</h5>
            <div class="col-md-12">
                <?php foreach ($all_invoices as $di): ?>
                    <div class="card radius-10">
                        <div class="card-body">
                         
                            <div class="d-md-flex justify-content-between">
                                <div class="align-items-center">

                                    <p class="mb-2"><a href="<?php echo base_url('invoices/details'); ?>/<?= $di['id']; ?>" class="href_loader">#<?= inventory_prefix(company($user['id']),$di['invoice_type']); ?><?= $di['serial_no']; ?></a></p>

                                    <p class="mb-2 font-15 text-dark"> <?= get_date_format($di['invoice_date'],'d M Y'); ?></p>

                                </div>

                                <div class="align-items-center">

                                    <p class="mb-2 font-15 text-dark"><?= currency_symbol(company($user['id'])); ?> <?= $di['total']; ?></p>

                                    <p class="mb-2 font-15 text-success"><?= currency_symbol(company($user['id'])); ?> <?= $di['paid_amount']; ?></p>

                                    <p class="font-15 text-danger"><?= currency_symbol(company($user['id'])); ?> <?= $di['due_amount']; ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?> 
            </div>
        </div>
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

   
     
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

 