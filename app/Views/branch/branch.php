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
                    <b class="page_heading text-dark">Branch Manager</b>
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
        <h6 class="my-auto"><b>Total <?= total_branch($user['id']) ?>/<?= branch_limit(company($user['id'])) ?> branches</b></h6>
    </div>
    
    <?php if ($user['author']==1): ?>
        <a class="text-dark font-size-footer my-auto ms-2" id="new_branch" data-bs-toggle="modal" data-bs-target="#add_branch"> <span class="">+ Add Branch</span></a>
    <?php endif ?> 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- branch Modal -->
<div class="modal fade aistun-modal" id="add_branch"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Add New Branch'); ?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" action="<?= base_url('branch_manager/add_new_branch') ?>">
        <?= csrf_field(); ?>
      <div class="modal-body">
      
        <div class="row">
          
          <input type="hidden" name="parent_company" value="<?= $main_company['id']; ?>">
          <div class="form-group mb-2 col-md-6">
            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Branch Logo'); ?></label>
            <input class="form-control" type="file" accept="image/*" name="company_logo">
          </div>

          <div class="form-group mb-2 col-md-6">
            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Branch name'); ?></label>
            <input type="text" class="form-control not-dark" name="cname" placeholder="" required>
          </div>

          <div class="col-md-4 mb-2">
            <label for="inputLastName" class=""><?= langg(get_setting(company($user['id']),'language'),'Company Email'); ?></label>
            <input type="email" class="form-control" name="cemail" required> 
        </div>

          <div class="form-group col-md-4">
            <label class=""><?= langg(get_setting(company($user['id']),'language'),'Branch Contact'); ?></label>
            <input type="number" class="form-control not-dark" name="cnumber" placeholder="" required="">
          </div>

          <div class="col-md-4 mb-2">
            <label>Country</label> 
            <select class="form-select" name="country" id="country_select" required> 
                <?php foreach (countries_array(company($user['id'])) as $ct): ?>
                   <option value="<?= $ct['country_name'] ?>"><?= $ct['country_name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

         <div class="col-md-4 mb-2">
            <label>State/Governorate/Emirates</label> 
            <div class="position-relative" id="layerer">
                
                <select class="form-select" name="state" id="state_select_box" required>
                    <option value="">Choose</option>
                    <?php foreach (states_array(company($user['id'])) as $st): ?>
                        <option value="<?= $st ?>"><?= $st ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <label>City</label>
            <input type="text" class="form-control" name="city"  required>
        </div>

        

        <div class="col-md-4 mb-2">
            <label>Postal Code</label>
            <input type="number" class="form-control" name="postal_code" required>
        </div>
        </div>
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        <button type="submit" class="aitsun-primary-btn" name="add_new_branch"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- end Branch Modal -->
<div class="sub_main_page_content">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="">

                    

                    <span><?= langg(get_setting(company($user['id']),'language'),'Click to change branch'); ?></span>

                      <div class="row mt-2">
                        <?php foreach ($branches as $br): ?>

                          <?php if (is_allowed_branch($br['id'],$user['allowed_branches'])==true || $user['author']==1 || $user['u_type']=='admin'): ?>
                              
                          
                          <div class="col-md-3 mb-3">

                            <?php if (company($user['id'])==$br['id']): ?>

                            <a href="javascript:void(0);" class="branch_active_box">
                                <div class="d-flex justify-content-between">
                                    <div class="my-auto">
                                        <h6 class="mb-0 text-white"><?= $br['company_name']; ?></h6>
                                    </div>
                                    <div class="font-24 text-white my-auto"><i class="bx bxs-check-circle"></i>
                                    </div>
                                </div>
                            </a>
                            <?php else: ?>

                                <a data-url="<?= base_url('branch_manager/change_branch'); ?>/<?= $br['id']; ?>" class="branch_box branch_click">
                                <div class="d-flex justify-content-between">
                                    <div class="my-auto">
                                        <h6 class="mb-0 text-white"><?= $br['company_name']; ?></h6>
                                    </div>
                                    <div class="font-24 my-auto active_ic"><i class="bx bxs-check-circle "></i>
                                    </div>
                                </div>
                                </a>
                          <?php endif; ?>
                            

                          </div>
                          <?php endif ?>

                        <?php endforeach ?>
                      </div>
                    


                </div>
            </div>
            

        </div>
    </div>
</div>