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
                 <li class="breadcrumb-item active href_loader" aria-current="page">
                    <a href="<?= base_url('work_updates'); ?>">Work Updates</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Work Updates Settings</b>
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
       
    </div>
    <div>
        <a type="button" data-bs-toggle="modal" data-bs-target="#work_dept_model" class="text-dark font-size-footer ms-2 my-auto"> <span class="">Work Department</span></a>
        <a type="button" data-bs-toggle="modal" data-bs-target="#work_cat_model" class="text-dark font-size-footer ms-2 my-auto"> <span class="">Work Category</span></a>
        
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<div class="modal fade" id="work_dept_model" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Work Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form method="post" action="<?= base_url('work_updates/save_department') ?>">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group mb-2">
                                    <label for="input-2" class="form-label">Department Name</label>
                                    <input type="text" class="form-control modal_inpu"  name="department_name" required>
                                </div>
        

                                <div class="form-group">
                                    <select name="staffid" class="form-select mb-3">
                                        <option value="">Choose staff</option>
                                        <?php foreach (admin_array(company($user['id'])) as $flr): ?>
                                          <option value="<?= $flr['id']; ?>"><?= $flr['display_name']; ?></option>
                                        <?php endforeach ?>
                                        <?php foreach (staffs_array(company($user['id'])) as $flr): ?>
                                          <option value="<?= $flr['id']; ?>"><?= $flr['display_name']; ?></option>
                                        <?php endforeach ?>
                                        
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="aitsun-primary-btn spinner_btn" >Save Department</button>
                    </div>
                </form>
                
        </div>
    </div>
</div>   


<div class="modal fade" id="work_cat_model"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Work Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?= base_url('work_updates/save_work_category') ?>">
                <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="row">
                 
                  <div class="col-md-12" >
                    <div class="form-group">
                        <label for="input-2" class="form-label">Select Department Name</label>
                        <select name="parent_id" class="form-select mb-3" required>
                            <option value="">Choose Department</option>
                            <?php foreach (work_department_array(company($user['id'])) as $flr): ?>
                              <option value="<?= $flr['id']; ?>"><?= $flr['department_name']; ?></option>
                            <?php endforeach ?>
                            
                        </select>

                    </div>
                    <div class="form-group mt-2">
                        <label for="input-2" class="form-label">Category Name</label>
                        <input type="text" class="form-control modal_inpu"  name="category_name" required>
                    </div>
                  </div>


                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="aitsun-primary-btn spinner_btn" >Save Category</button>
              </div>
            </form>
            
        </div>
    </div>
</div> 

<div class="sub_main_page_content">

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($work_department as $wp) { ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="me-2"><?= $wp['department_name'];?> 
                                    <small>(<?= user_name($wp['department_head']); ?>)</small> 

                                </div>
                                <div class="d-flex my-auto">
                                    <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#edit_work_department<?= $wp['id']; ?>">
                                      <i class="bx bx-pencil"></i>
                                    </a>

                                    <a class="text-danger delete" data-url="<?= base_url('settings/delete_work_department'); ?>/<?= $wp['id']; ?>">
                                      <i class="bx bx-trash"></i>
                                    </a>
                                </div>

                                <div class="modal fade aitposmodal" id="edit_work_department<?= $wp['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Work Department</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                          
                                            <form method="post" action="<?= base_url('work_updates/edit_work_department');?>/<?= $wp['id']; ?>">
                                                <?= csrf_field(); ?>
                                                <div class="modal-body">
                                                    <div class="row">
                                             
                                                        <div class="col-md-12" >
                                                            <div class="form-group mb-2">
                                                                <label for="input-2" class="modal_lab">Department Name</label>
                                                                <input type="hidden" name="wpid" value="<?= $wp['id']; ?>">
                                                                <input type="text" class="form-control modal_inpu" id="input-2" name="department_name" value="<?= $wp['department_name']; ?>" required>
                                                            </div>


                                                            <div class="form-group">
                                                                
                                                                    <select name="staffid" class="form-select mb-3" id="staffid" >
                                                                        <option value="">Choose staff</option>
                                                                        <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                                                                          <option value="<?= $flr['id']; ?>" <?php if($wp['department_head']==$flr['id']) {echo 'selected';} ?>><?= $flr['display_name']; ?>
                                                                              
                                                                          </option>
                                                                        <?php endforeach ?>
                                                                        
                                                                    </select>                          
                                                               
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="aitsun-primary-btn spinner_btn" name="">Save Department</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>



                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($work_category_data as $wc) { ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <div class="me-2"><?= $wc['category_name']; ?><small> (<?= user_rg($wc['parent_id']); ?>)</small></div>
                            <div class="d-flex my-auto">
                                <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#ed_work_cate<?= $wc['id']; ?>">
                                  <i class="bx bx-pencil"></i>
                                </a>

                                <a class="text-danger delete_work_category" data-url="<?= base_url('settings/delete_work_category'); ?>/<?= $wc['id']; ?>">
                                  <i class="bx bx-trash"></i>
                                </a>
                            </div>

                            <div class="modal fade aitposmodal" id="ed_work_cate<?= $wc['id']; ?>"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Edit Work Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          
                                        </button>
                                      </div>
                                      <form method="post" action="<?= base_url('work_updates/edit_work_category');?>/<?= $wc['id']; ?>">
                                        <?= csrf_field(); ?>
                                      <div class="modal-body">
                                        <div class="row">
                                         
                                          <div class="col-md-12" >
                                            <div class="form-group">
                                                <label for="input-2" class="form-label">Select Department Name</label>
                                                <select name="parent_id" class="form-select mb-3" required>
                                                    <option value="">Choose Department</option>
                                                    <?php foreach (work_department_array(company($user['id'])) as $flr): ?>
                                                      <option value="<?= $flr['id']; ?>"  <?php if($wc['parent_id']==$flr['id']){echo 'selected';} ?>> <?=$flr['department_name']; ?>   
                                                      </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
            

                                            <div class="form-group mb-2">
                                                <label for="input-2" class="modal_lab">Category Name</label>
                                                <input type="hidden" name="wcid" value="<?= $wc['id']; ?>">
                                                <input type="text" class="form-control modal_inpu" id="input-2" name="category_name" value="<?= $wc['category_name']; ?>" required>
                                            </div>

                                            
                                          </div>


                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="aitsun-primary-btn spinner_btn">Save category</button>
                                      </div>
                                    </form>
                                    </div>

                                  </div>
                                </div>

                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>