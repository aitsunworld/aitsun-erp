<!-- start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Employee Details</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>" class="href_loader"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('payroll/basic_salary'); ?>" class="href_loader">Salary table</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $cust['display_name']; ?></li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
               
            </div>
        </div>
        <!--end breadcrumb-->

         <?php if (session()->get('pu_msg')): ?>
            <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success">Success</h6>
                        <div><?= session()->get('pu_msg'); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>

        <?php if (session()->get('pu_er_msg')): ?>
            <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-danger"><i class="bx bxs-error"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-danger">Failed</h6>
                        <div><?= session()->get('pu_er_msg'); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>


        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="<?= base_url(); ?>/public/images/avatars/<?php if($user['profile_pic'] != ''){echo $user['profile_pic']; }else{ echo 'avatar-icon.png';} ?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                    <div class="mt-3">
                                        <h4><?= $cust['display_name']; ?></h4>
                                        <p class="text-secondary mb-1"><?= $cust['billing_address']; ?></p>
                                        <a href="tel:<?= $cust['phone']; ?>" class="btn btn-sm btn-success">Call</a>
                                        <a href="mailto:<?= $cust['email']; ?>" class="btn btn-sm btn-outline-primary">Message</a>
                                    </div>
                                </div> 
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <form method="post" id="edit_cust_form" >
                                <?= csrf_field(); ?>
      <div class="card-body">
        <div>
         
              <div class="col-md-12 row m-0" >

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'PAN No.'); ?></label>
                      <input type="text" id="pan" class="form-control modal_inpu" name="pan" value="<?= $cust['pan']; ?>">
                     </div>

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Adhar No.'); ?></label>
                      <input type="text" id="adhar" class="form-control modal_inpu" name="adhar" value="<?= $cust['adhar']; ?>">
                     </div>

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Bank name'); ?></label>
                      <input type="text" id="bank_name" class="form-control modal_inpu" name="bank_name" value="<?= $cust['bank_name']; ?>">
                     </div>

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'IFSC'); ?></label>
                      <input type="text" id="ifsc" class="form-control modal_inpu" name="ifsc" value="<?= $cust['ifsc']; ?>">
                     </div>

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Account No.'); ?></label>
                      <input type="text" id="account_number" class="form-control modal_inpu" name="account_number" value="<?= $cust['account_number']; ?>">
                     </div> 

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'PF No.'); ?></label>
                      <input type="text" id="pf_no" class="form-control modal_inpu" name="pf_no" value="<?= $cust['pf_no']; ?>">
                     </div> 

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'ESI No.'); ?></label>
                      <input type="text" id="esi_no" class="form-control modal_inpu" name="esi_no" value="<?= $cust['esi_no']; ?>">
                     </div> 

                     <div class="form-group col-md-6">
                      <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Designation.'); ?></label>
                      <input type="text" id="designation" class="form-control modal_inpu" name="designation" value="<?= $cust['designation']; ?>">
                     </div> 
 

                    <div class="col-md-12 form-group pt-3 text-right">  
                        <button type="submit" class="btn btn-sm btn-primary" name="edit_customer"><?= langg(get_setting(company($user['id']),'language'),'Save details'); ?></button>
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
                      <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'State'); ?></label>
                      <input type="text" class="form-control modal_inpu" name="billing_state" id="input-2">
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
                
     

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper 