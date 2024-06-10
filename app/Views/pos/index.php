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
    <div class="my-auto">
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
        

        <a href="<?= base_url('products') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Products</span>
        </a>

        <a href="<?= base_url('pos/floors') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">Floors & Tables</span>
        </a>

   
       
        
    </div>
 
    <a class="btn btn-back btn-sm" data-bs-toggle="modal" data-bs-target="#new_register_modal">New register</a>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="container-fluid">
    <div class="row aitsun_pos mt-4"> 
        
        <?php foreach ($all_registers as $reg): ?>
        <div class="col-md-6">
            <div class="session_box mb-4 card">
               <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3><?= $reg['register_name'] ?></h3>

                        <div class="dropdown dropdown-animated scale-left">
                            <a class="btn btn-outline-dark btn-sm font-size-18" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </a>
                            <div class="dropdown-menu" style="">  
                                <a class="dropdown-item "  data-bs-toggle="modal" data-bs-target="#new_register_modal<?= $reg['id'] ?>">
                                    <i class="bx bx-pencil"></i>
                                    <span class="ms-3">Edit</span>
                                </a>
                                <a class="dropdown-item delete" data-url="<?= base_url('pos/delete_register') ?>/<?= $reg['id'] ?>">
                                    <i class="bx bx-trash"></i>
                                    <span class="ms-3">Delete</span>
                                </a> 
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between"> 
                        <?php 
                        $register_id='';
                        if (session()->has('pos_session'.$reg['id'])) {
                            $session_data=session()->get('pos_session'.$reg['id']);
                            $register_id=$session_data['register_id']; 
                        }
                         ?> 
                         <?php if ($register_id==$reg['id']): ?> 
                            <a href="<?= base_url('pos/create') ?>/<?= $reg['id'] ?>" class="btn btn-danger rounded-pill my-auto href_loader">Continue Selling</a>
                        <?php else: ?>   
                            <a href="javascript:void(0);" class="btn btn-danger rounded-pill my-auto" data-bs-toggle="modal" data-bs-target="#new_session_modal<?= $reg['id'] ?>">Open Register</a>
                        <?php endif ?> 
                        
                        <div class="my-auto">
                            <?php if (last_session_data($reg['id'],'date')!=''): ?>
                                <div>Closing <span class="font-weight-bold"><?= get_date_format(last_session_data($reg['id'],'date'),'d M Y') ?></span></div>
                                <div>Balance <span class="text-success font-weight-bold"><?= currency_symbol(company($user['id'])) ?> <?= aitsun_round(last_session_data($reg['id'],'closing_balance'),get_setting(company($user['id']),'round_of_value')); ?> </span></div>
                            <?php endif ?> 
                        </div>
                        
                    </div>
               </div>
            </div>
        </div> 

          <div class="modal fade" id="new_register_modal<?= $reg['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit register</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form method="post" action="<?= base_url('pos') ?>"> 
                            <?= csrf_field() ?>
                            <input type="hidden" name="register_id" value="<?= $reg['id'] ?>"  class="form-control me-2">
                            <div class="form-group mb-2">
                                <label>Resgister name</label>
                                <div class="form-group mb-2">
                                    <input type="text" name="register_name" value="<?= $reg['register_name'] ?>" class="form-control me-2" required>
                                </div>
                            </div> 

                            <div class="form-group mb-2">
                                <label>Type</label>
                                <div class="form-group mb-2">
                                    <select class="form-select" name="register_type">
                                        <option value="0" <?= ($reg['register_type']==0)?'selected':''; ?>>Shop</option>
                                        <option value="1" <?= ($reg['register_type']==1)?'selected':''; ?>>Restaurent</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="d-flex justify-content-between mt-4">   
                                <button type="submit" class="btn btn-dark btn-sm">Save register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="new_session_modal<?= $reg['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Opening Session Control</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form method="post" id="open_session_form<?= $reg['id'] ?>"> 
                            <?= csrf_field() ?>
                            <input type="hidden" name="register_id" value="<?= $reg['id'] ?>">
                            <div class="form-group mb-2">
                                <label>Opening Cash</label>
                                <div class="form-group mb-2">
                                    <input type="number" id="opening_cash<?= $reg['id'] ?>" name="opening_cash" step="any" required="" class="form-control me-2" value="0" min="0">
                                </div>
                            </div> 

                            <div class="form-group mb-2">
                                <label>Opening Note</label>
                                <div class="form-group mb-2">
                                    <textarea id="opening_note<?= $reg['id'] ?>" name="opening_note"class="form-control me-2" ></textarea>
                                </div>
                            </div> 

                            <div class="d-flex justify-content-between mt-4">   
                                <a class="btn btn-dark btn-sm open_session" data-reg_id="<?= $reg['id'] ?>">Open Session</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>

        <div class="modal fade" id="new_register_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New register</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form method="post" action="<?= base_url('pos') ?>"> 
                            <?= csrf_field() ?>
                            <input type="hidden" name="register_id"  class="form-control me-2">
                            <div class="form-group mb-2">
                                <label>Resgister name</label>
                                <div class="form-group mb-2">
                                    <input type="text" name="register_name"  class="form-control me-2" required>
                                </div>
                            </div> 

                            <div class="form-group mb-2">
                                <label>Type</label>
                                <div class="form-group mb-2">
                                    <select class="form-select" name="register_type">
                                        <option value="0">Shop</option>
                                        <option value="1">Restaurent</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="d-flex justify-content-between mt-4">   
                                <button type="submit" class="btn btn-dark btn-sm">Save register</button>
                            </div>
                        </form>
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
     <div>
        <a href="<?= base_url('pos/settings')?>" class="text-dark font-size-footer"><i class="bx bx-cog"></i> <span class="my-auto">POS Settings</span></a>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 