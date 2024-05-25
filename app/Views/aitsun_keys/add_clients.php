<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url('aitsun_keys'); ?>" class="text-dark">Aitsun Keys</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Add Clients</b>
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
<div class="main_page_content" style="margin-bottom: 120px;">
    <div class="row">
        <form method="post" action="<?= base_url('aitsun_keys/save_client') ?>" id="client_form">
            <?= csrf_field(); ?>

            <div class="row">

                <div class="form-group col-md-4">
                    <label class="form-label">Full Name</label>
                    <input class="form-control mb-3" type="text" name="display_name" id="display_name" required >
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Email</label>
                    <input class="form-control mb-3" type="email" name="email" id="email" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Password</label>
                    <input class="form-control mb-3" type="text" name="password" id="password" required >
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Phone</label>
                    <input class="form-control mb-3" type="number" name="phone" id="phone" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Price</label>
                    <input class="form-control mb-3" type="number" name="price" id="price" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="payment_method" class="form-label">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                      <option value="0">Paid</option>
                      <option value="1">Free</option>    
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="status" class="form-label">Choose a status:</label>
                    <select name="status" id="status" class="form-select">
                      <option value="0">0</option>
                      <option value="1">1</option>    
                    </select>
                </div>

                <div class="form-group col-md-4 d-none">
                    <label class="form-label">lc Key</label>
                    <input class="form-control mb-3" type="text" name="lc_key" >
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Validity</label>
                    <input class="form-control mb-3" type="number" name="validity" id="validity" required >
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Pack Date</label>
                    <input class="form-control mb-3" type="date" name="pack_date" id="pack_date" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Monthly Billing Date</label>
                    <!-- <input class="form-control mb-3" type="date" name="monthly_billing_date" id="monthly_billing_date" > -->
                    <select name="monthly_billing_date" id="monthly_billing_date" class="form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>    
                        <option value="5">5</option>
                        <option value="6">6</option>    
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>  
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>  
                        <option value="15">15</option>
                        <option value="16">16</option>  
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>  
                        <option value="25">25</option>
                        <option value="26">26</option>  
                        <option value="27">27</option>
                        <option value="28">28</option>
                                  
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Maximum Branch</label>
                    <input class="form-control mb-3" type="number" name="max_branch" required>
                </div>


                <div class="form-group col-md-4">
                    <label for="app_status" class="form-label"> app status</label>
                    <select name="app_status" id="app_status" class="form-select" >
                    <option value="0">0</option>
                    <option value="1">1</option>      
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Max User</label>
                    <input class="form-control mb-3" type="number" name="max_user" required>
                </div>

                <div class="form-group col-md-4 d-none">
                    <label for="app" class="form-label">Choose a app:</label>
                    <select name="app" id="app" class="form-select" >
                    <option value="pos">POS</option>
                    <option value="asms">ASMS</option>    
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="pos_payment_type" class="form-label">Choose Payment Period</label>
                    <select name="pos_payment_type" id="pos_payment_type" class="form-select">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>    
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="year_end" class="form-label">Choose Year End:</label>
                    <select name="year_end" id="year_end" class="form-select">
                    <option value="mar">March</option>
                    <option value="dec">December</option>     
                    </select>
                </div>

                <div class="form-group col-md-4 mb-3">
                    <label class="form-label">Languages</label>
                    <input class="form-control " type="text" name="languages" required>                                 
                </div>

                <div class="form-group col-md-12 mb-3">
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" value="1" name="aitsun_user" id="aitsun_user">
                        <label class="form-check-label" for="aitsun_user">Aitsun User</label>
                    </div>
                    <label class="form-check-label mb-2" for="aitsun_user">Features</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" id="online_shop" name="online_shop">
                        <label class="form-check-label" for="on_sp">Online Shop</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="crm" id="crm">
                        <label class="form-check-label" for="crm">CRM</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="restaurent" id="restaurent">
                        <label class="form-check-label" for="restaurent">Restaurant</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="hr_manage" id="hr_manage">
                        <label class="form-check-label" for="hr_manage">HR Manage</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="medical" id="medical">
                        <label class="form-check-label" for="medical">Medical</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="is_school" id="is_school">
                        <label class="form-check-label" for="is_school">School</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="is_website" id="is_website">
                        <label class="form-check-label" for="is_website">Website</label>
                    </div>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" name="is_appoinments" id="is_appoinments">
                        <label class="form-check-label" for="is_appoinments">Appoinments</label>
                    </div>

                </div>

                <div id="error_mes" class="mb-2 text-danger"></div>

            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="submit" id="save_client" class="aitsun-primary-btn">Add Clients</button>         
                </div>
            </div>
        </form> 
    </div>
</div>