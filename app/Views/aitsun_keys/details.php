<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
        
     <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
        <i class="bx bx-arrow-back"></i>       </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                   <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
               </li>

               <li class="breadcrumb-item" aria-current="page">
                <a href="<?= base_url('aitsun_keys'); ?>" class="text-dark">Aitsun Keys</a>
            </li>
            
            <li class="breadcrumb-item active" aria-current="page">
                <b class="page_heading text-dark">Edit Clients</b>
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
<div class="main_page_content">
    <div class="row">
        <form method="post" id="add_cust_form" action="<?= base_url('aitsun_keys/edit_client') ?>/<?= $us['id']; ?>">
            <?= csrf_field(); ?>
            
            <div>
                <div class="col-md-12 row m-0">
                    <div class="form-group col-md-4">
                        <label for="input-1" class="modal_lab form-label">Display Name</label>
                        <input type="text" class="form-control modal_inpu mb-3" name="display_name" value="<?= $us['display_name']; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="input-1" class="modal_lab">Phone</label>
                        <input type="text" class="form-control modal_inpu mb-3" name="phone" value="<?= $us['phone']; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="input-3" class="modal_lab">Email </label>
                        <input type="text" class="form-control modal_inpu mb-3" name="email" value="<?= $us['email']; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="input-3" class="modal_lab">Password </label>
                        <input type="text" class="form-control modal_inpu mb-3" name="password">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="input-2" class="modal_lab">Status</label>
                        <select class="form-control mb-3" name="status">
                            <option value="0" <?php if ($us['status']==0){echo "selected";} ?>>0</option>
                            <option value="1" <?php if ($us['status']==1){echo "selected";} ?>>1</option>
                        </select>
                    </div>

                        <!-- <div class="form-group col-md-4">
                            <label for="input-2" class="modal_lab">Lc Key</label>
                            <input type="text" class="form-control modal_inpu" name="lc_key" value="<= $us['lc_key']; ?>">
                            </div> -->

                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">Price</label>
                                <input type="number" class="form-control modal_inpu mb-3" name="price" value="<?= $us['price']; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab ">Payment Method</label>
                                <select class="form-control mb-3" name="payment_method">
                                    <option value="0" <?php if ($us['payment_method']==0){echo "selected";} ?>>Paid</option>
                                    <option value="1" <?php if ($us['payment_method']==1){echo "selected";} ?>>Free</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">Validity</label>
                                <input type="text" class="form-control modal_inpu mb-3" name="validity" value="<?= $us['validity']; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">Pack Date</label>
                                <input type="date" class="form-control modal_inpu mb-3" name="pack_date" value="<?= $us['packdate']; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">Monthly Billing Date</label>
                                <select name="monthly_billing_date" id="monthly_billing_date" class="form-select">

                                    <option value="1" <?php if ($us['monthly_billing_date']==1){echo "selected";} ?>>1</option>
                                    <option value="2"<?php if ($us['monthly_billing_date']==2){echo "selected";} ?>>2</option>
                                    <option value="3"<?php if ($us['monthly_billing_date']==3){echo "selected";} ?>>3</option>
                                    <option value="4"<?php if ($us['monthly_billing_date']==4){echo "selected";} ?>>4</option>    
                                    <option value="5"<?php if ($us['monthly_billing_date']==5){echo "selected";} ?>>5</option>
                                    <option value="6"<?php if ($us['monthly_billing_date']==6){echo "selected";} ?>>6</option>    
                                    <option value="7"<?php if ($us['monthly_billing_date']==7){echo "selected";} ?>>7</option>
                                    <option value="8"<?php if ($us['monthly_billing_date']==8){echo "selected";} ?>>8</option>
                                    <option value="9"<?php if ($us['monthly_billing_date']==9){echo "selected";} ?>>9</option>
                                    <option value="10"<?php if ($us['monthly_billing_date']==10){echo "selected";} ?>>10</option>  
                                    <option value="11"<?php if ($us['monthly_billing_date']==11){echo "selected";} ?>>11</option>
                                    <option value="12"<?php if ($us['monthly_billing_date']==12){echo "selected";} ?>>12</option>
                                    <option value="13"<?php if ($us['monthly_billing_date']==13){echo "selected";} ?>>13</option>
                                    <option value="14"<?php if ($us['monthly_billing_date']==14){echo "selected";} ?>>14</option>  
                                    <option value="15"<?php if ($us['monthly_billing_date']==15){echo "selected";} ?>>15</option>
                                    <option value="16"<?php if ($us['monthly_billing_date']==16){echo "selected";} ?>>16</option>  
                                    <option value="17"<?php if ($us['monthly_billing_date']==17){echo "selected";} ?>>17</option>
                                    <option value="18"<?php if ($us['monthly_billing_date']==18){echo "selected";} ?>>18</option>
                                    <option value="19"<?php if ($us['monthly_billing_date']==19){echo "selected";} ?>>19</option>
                                    <option value="20"<?php if ($us['monthly_billing_date']==20){echo "selected";} ?>>20</option>
                                    <option value="21"<?php if ($us['monthly_billing_date']==21){echo "selected";} ?>>21</option>
                                    <option value="22"<?php if ($us['monthly_billing_date']==22){echo "selected";} ?>>22</option>
                                    <option value="23"<?php if ($us['monthly_billing_date']==23){echo "selected";} ?>>23</option>
                                    <option value="24"<?php if ($us['monthly_billing_date']==24){echo "selected";} ?>>24</option>  
                                    <option value="25"<?php if ($us['monthly_billing_date']==25){echo "selected";} ?>>25</option>
                                    <option value="26"<?php if ($us['monthly_billing_date']==26){echo "selected";} ?>>26</option>  
                                    <option value="27"<?php if ($us['monthly_billing_date']==27){echo "selected";} ?>>27</option>
                                    <option value="28"<?php if ($us['monthly_billing_date']==28){echo "selected";} ?>>28</option>

                                </select>
                            </div>


                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">Max Branch</label>
                                <input type="text" class="form-control modal_inpu mb-3" name="max_branch" value="<?= $us['max_branch']; ?>">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab ">App Status</label>
                                <select class="form-control mb-3" name="app_status">
                                    <option value="0" <?php if ($us['app_status']==0){echo "selected";} ?>>0</option>
                                    <option value="1" <?php if ($us['app_status']==1){echo "selected";} ?>>1</option>
                                </select>
                            </div>

                          
                            <div class="form-group col-md-4 d-none">
                                <label for="input-2" class="modal_lab">App</label>
                                <select class="form-control mb-3" name="pos">
                                    <option value="pos" <?php if ($us['app']=='pos'){echo "selected";} ?>>POS</option>
                                    <option value="asms" <?php if ($us['app']=='asms'){echo "selected";} ?>>ASMS</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">Choose Payment Type</label>
                                <select class="form-control mb-3" name="pos_payment_type">
                                    <option value="monthly" <?php if ($us['pos_payment_type']=='monthly'){echo "selected";} ?>>Monthly</option>
                                    <option value="yearly" <?php if ($us['pos_payment_type']=='yearly'){echo "selected";} ?>>Yearly</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="input-2" class="modal_lab">Year End</label>
                                <select class="form-control mb-3" name="year_end">
                                    <option value="mar" <?php if ($us['year_end']=='mar'){echo "selected";} ?>>March</option>
                                    <option value="dec" <?php if ($us['year_end']=='dec'){echo "selected";} ?>>December</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="input-2" class="modal_lab">LANGUAGE</label>
                                <input type="text" class="form-control mb-3 modal_inpu" name="languages" value="<?= $us['languages']; ?>">
                            </div>


                            <div class="form-group col-md-12 mb-3">
                                <div class="form-group mb-2 mt-2 d-none">
                                    <input class="form-check-input" type="checkbox" id="aitsun_user" name="aitsun_user" value="1" <?php if ($us['aitsun_user']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="aitsun_user"> aitsun user</label>
                                </div>

                                <label class="form-check-label mb-2" for="aitsun_user">Features</label>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="online_shop" name="online_shop" value="1" <?php if ($us['online_shop']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="online_shop"> online shop</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="crm" name="crm" value="1" <?php if ($us['crm']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="crm"> crm</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="restaurent" name="restaurent" value="1" <?php if ($us['restaurent']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="restaurent"> Restaurent</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="hr_manage" name="hr_manage" value="1" <?php if ($us['hr_manage']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="hr_manage"> Hr Manage</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="medical" name="medical" value="1" <?php if ($us['medical']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="medical"> Medical</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="is_school" name="is_school" value="1" <?php if ($us['school']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="is_school">School</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" id="is_website" name="is_website" value="1" <?php if ($us['is_website']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="is_website">Website</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_appoinments" id="is_appoinments" <?php if ($us['is_appoinments']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="is_appoinments">Appoinments</label>
                                </div>

                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_clinic" id="is_clinic" <?php if ($us['is_clinic']==1){echo "checked";} ?>>
                                    <label class="form-check-label" for="is_clinic">Clinic</label>
                                </div>

                                

                            </div>

                            <div class="col-md-12 form-group pt-3 text-right">

                                <button type="submit" class="aitsun-primary-btn" data-bs-toggle="modal" data-bs-target="#editclients<?= $us['id']; ?>">Save Details</button>

                            </div>                   
                        </div>
                    </div>                                   
                    
                </form>

            </div>
        </div>