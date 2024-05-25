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
                    <b class="page_heading text-dark">
                        Point of Sale
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
        <a href="<?= base_url('pos') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Dashboard</span>
        </a>

        <a href="<?= base_url('pos/orders') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Orders</span>
        </a>

        <a href="<?= base_url('pos') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Sessions</span>
        </a>

        <a href="<?= base_url('pos') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Payments</span>
        </a>

        <a href="<?= base_url('pos') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Preparation Display</span>
        </a>
        

        <a href="<?= base_url('pos') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Products</span>
        </a>

   
       
        
    </div>
 
     <div class="dropdown dropdown-animated ">
            <a class="text-dark cursor-pointer font-size-footer ms-2 my-auto " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                Reports
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('pos/orders') ?>">
                    <span class="ms-3">Orders</span>
                </a>
                <a class="dropdown-item href_loader" href="<?= base_url('pos') ?>">
                    <span class="ms-3">Sales</span>
                </a> 
                <a class="dropdown-item href_loader" href="<?= base_url('pos') ?>">
                    <span class="ms-3">Session report</span>
                </a> 
            </div>
        </div>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row aitsun_pos"> 
  
        <div class="session_box card">
           <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>POS Point</h3>

                    <div class="dropdown dropdown-animated scale-left">
                        <a class="btn btn-outline-dark btn-sm font-size-18" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </a>
                        <div class="dropdown-menu" style="">  
                            <a class="dropdown-item href_loader" href="">
                                <i class="bx bx-plus"></i>
                                <span class="ms-3">Configuration</span>
                            </a> 
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between"> 
                     <?php if (session()->has('pos_session')): ?> 
                        <a href="<?= base_url('pos/create') ?>" class="btn btn-danger rounded-pill my-auto href_loader">Continue Selling</a>
                    <?php else: ?>   
                        <a href="javascript:void(0);" class="btn btn-danger rounded-pill my-auto" data-bs-toggle="modal" data-bs-target="#new_session_modal">Open Register</a>
                    <?php endif ?> 
                    
                    <div class="my-auto">
                        <?php if ($last_session_date!=0): ?>
                            <div>Closing <span class="font-weight-bold"><?= get_date_format($last_session_date,'d M Y') ?></span></div>
                            <div>Balance <span class="text-success font-weight-bold"><?= currency_symbol(company($user['id'])) ?> <?= aitsun_round($last_session_cash,get_setting(company($user['id']),'round_of_value')); ?> </span></div>
                        <?php endif ?> 
                    </div>
                    
                </div>
           </div>
        </div>
        
        <div class="modal fade" id="new_session_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Opening Session Control</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form method="post" id="open_session_form"> 
                            <?= csrf_field() ?>
                            <div class="form-group mb-2">
                                <label>Opening Cash</label>
                                <div class="form-group mb-2">
                                    <input type="number" id="opening_cash" name="opening_cash" step="any" required="" class="form-control me-2" value="0" min="0">
                                </div>
                            </div> 

                            <div class="form-group mb-2">
                                <label>Opening Note</label>
                                <div class="form-group mb-2">
                                    <textarea id="opening_note" name="opening_note"class="form-control me-2" ></textarea>
                                </div>
                            </div> 

                            <div class="d-flex justify-content-between mt-4">   
                                <a class="btn btn-dark btn-sm open_session">Open Session</a>
                            </div>
                        </form>
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
        <a href="<?= base_url('pos/settings')?>" class="text-dark font-size-footer"><i class="bx bx-cog"></i> <span class="my-auto">POS Settings</span></a>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 