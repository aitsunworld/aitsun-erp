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
                    <b class="page_heading text-dark">Group Head</b>
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
<div class="toolbar d-flex justify-content-end">
    <!-- <a data-bs-toggle="modal" data-bs-target="#gphead" class="text-dark font-size-footer my-auto ms-2"> <span class="">+ Add</span></a> -->
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
        
<div class="sub_main_page_content">
    <div class="settings_sidebar mt-4">
        <div class="">
            <ul>
                <li>
                    <a href="<?= base_url('accounts/ledger-accounts'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx bx-arrow-from-left'></i></div>
                        <div class="icon-title">Ledger Accounts</div>
                    </a>
                </li>
                
                <li>
                    <a href="<?= base_url('accounts/group-head'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx bx-arrow-from-left'></i></div>
                        <div class="icon-title">Group Head</div>
                    </a>
                </li>
    
            </ul>
        </div>
    </div>
    <div class="setting_margin">
        <div class="row">
            <div class="col-12 col-lg-12 col-md-12">
                
                <div class="">
                    <div class="">
                        <ul class="list-group">
                            <?php foreach ($group_head as $gh) { ?>
                            <li class="list-group-item d-flex justify-content-between" style="background: #f0f0f0;">
                                <div class="me-2"><b><?= $gh['group_head']; ?></b> <small>[<?= $gh['nature']; ?>]</small></div>

                                <?php if ($gh['default']!=1): ?>
                                    <div class="d-flex my-auto">
                                    <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#ed_gp_head<?= $gh['id']; ?>">
                                        <i class="bx bx-pencil"></i>
                                    </a>

                                    <a class="text-danger delete_gp_head" data-url="<?= base_url('accounts/delete_gropu_head'); ?>/<?= $gh['id']; ?>">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                                    
                                <?php endif ?>
                                

                                <div class="modal fade" id="ed_gp_head<?= $gh['id']; ?>"  aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Group Head</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form  method="post" action="<?= base_url('accounts/edit_group_head'); ?>/<?= $gh['id']; ?>">
                                                <?= csrf_field(); ?>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12" >
                                                            <div class="form-group">
                                                                <label for="input-2" class="form-label">Group Head Name</label>
                                                                <input type="text" class="form-control modal_inpu" id="input-2" name="grouphead_name" value="<?= $gh['group_head']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-3">
                                                            <div class="form-group">
                                                                <input class="form-check-input primary_check" type="checkbox" id="primary<?= $gh['id']; ?>" data-acid="<?= $gh['id']; ?>" name="primary" value="1" <?php if ($gh['primary']=='1') {echo 'checked';} ?>>
                                                                <label class="form-check-label" for="primary">Primary</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3 <?php if ($gh['primary']==1){echo 'd-block';}else{echo 'd-none';} ?>" id="sel_nature<?= $gh['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="input-2" class="form-label">Select nature</label>
                                                                <select class="form-select" name="nature" required>
                                                                    <option value="liabilties" <?php if ($gh['nature']=='liabilties') {echo 'selected';} ?>>Liabilties</option>
                                                                    <option value="assets" <?php if ($gh['nature']=='assets') {echo 'selected';} ?>>Assets</option>
                                                                    <option value="expenses" <?php if ($gh['nature']=='expenses') {echo 'selected';} ?>>Expenses</option>
                                                                    <option value="income" <?php if ($gh['nature']=='income') {echo 'selected';} ?>>Income</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3 <?php if ($gh['primary']==1){echo 'd-none';}else{echo 'd-block';} ?>" id="sel_group<?= $gh['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="input-2" class="form-label">Select Group Head</label>
                                                                <select class="form-select" name="group_head_pr" required>
                                                                    <?php foreach ($group_head as $ga) { ?>
                                                                        <option value="<?= $ga['id'];?>" <?php if ($gh['parent_id']==$ga['id']) {echo 'selected';} ?>><?= $ga['group_head'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary spinner_btn" name="edit_gp_head">Save </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php foreach (group_head_sub_cat_array($gh['id']) as $ghs) { ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="text-muted" style="margin-left:20px;"><?= $ghs['group_head']; ?> </div>
                                <?php if ($ghs['default']!=1): ?>
                                    <div class="d-flex my-auto">
                                        <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#ed_gp_sub_head<?= $ghs['id']; ?>">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <a class="text-danger delete_gp_head" data-url="<?= base_url('accounts/delete_gropu_head'); ?>/<?= $ghs['id']; ?>">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </div>
                                <?php endif ?>

                                <div class="modal fade" id="ed_gp_sub_head<?= $ghs['id']; ?>"  aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Group Head</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form  method="post" action="<?= base_url('accounts/edit_group_head'); ?>/<?= $ghs['id']; ?>">
                                                <?= csrf_field(); ?>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12" >
                                                            <div class="form-group">
                                                                <label for="input-2" class="form-label">Group Head Name</label>
                                                                <input type="text" class="form-control modal_inpu" id="input-2" name="grouphead_name" value="<?= $ghs['group_head']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-3">
                                                            <div class="form-group">
                                                                <input class="form-check-input primary_check" type="checkbox" id="primary<?= $ghs['id']; ?>" data-acid="<?= $ghs['id']; ?>" name="primary" value="1" <?php if ($ghs['primary']=='1') {echo 'checked';} ?>>
                                                                <label class="form-check-label" for="primary">Primary</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3 <?php if ($ghs['primary']==1){echo 'd-block';}else{echo 'd-none';} ?>" id="sel_nature<?= $ghs['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="input-2" class="form-label">Select nature</label>
                                                                <select class="form-select" name="nature" required>
                                                                    <option value="liabilties" <?php if ($ghs['nature']=='liabilties') {echo 'selected';} ?>>Liabilties</option>
                                                                    <option value="assets" <?php if ($ghs['nature']=='assets') {echo 'selected';} ?>>Assets</option>
                                                                    <option value="expenses" <?php if ($ghs['nature']=='expenses') {echo 'selected';} ?>>Expenses</option>
                                                                    <option value="income" <?php if ($ghs['nature']=='income') {echo 'selected';} ?>>Income</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                 

                                                        <div class="col-md-12 mb-3 <?php if ($ghs['primary']==1){echo 'd-none';}else{echo 'd-block';} ?>" id="sel_group<?= $ghs['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="input-2" class="form-label">Select Group Head</label>
                                                                <select class="form-select" name="group_head_pr" required>
                                                                    <?php foreach ($group_head as $ga) { ?>
                                                                        <option value="<?= $ga['id'];?>" <?php if ($ghs['parent_id']==$ga['id']) {echo 'selected';} ?>><?= $ga['group_head'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary spinner_btn" name="edit_gp_head">Save </button>
                                                </div>
                                            </form>   
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="gphead"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Group Head</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form  method="post" action="<?= base_url('accounts/add_group_head'); ?>">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label for="input-2" class="form-label">Group Head Name</label>
                                        <input type="text" class="form-control modal_inpu" id="input-2" name="grouphead_name" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2 mb-3">
                                    <div class="form-group">
                                        <input class="form-check-input primary_check" type="checkbox" id="primary" data-acid="" name="primary" value="1" checked>
                                        <label class="form-check-label" for="primary">Primary</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" id="sel_nature">
                                    <div class="form-group">
                                        <label for="input-2" class="form-label">Select nature</label>
                                        <select class="form-select" name="nature" required>
                                            <option value="liabilties">Liabilties</option>
                                            <option value="assets">Assets</option>
                                            <option value="expenses">Expenses</option>
                                            <option value="income">Income</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 d-none" id="sel_group">
                                    <div class="form-group">
                                        <label for="input-2" class="form-label">Select Group Head</label>
                                        <select class="form-select" name="group_head_pr">
                                            <?php foreach ($group_head as $ga) { ?>
                                                <option value="<?= $ga['id'];?>"><?= $ga['group_head'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary spinner_btn" name="add_gp_head">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).on('click','.primary_check',function(){

        var acid=$(this).data('acid');

        var checkbox=$(this).prop('checked');
        if (checkbox == true){
            $('#sel_nature'+acid).removeClass('d-none');
            $('#sel_group'+acid).addClass('d-none');

        }else{
            $('#sel_nature'+acid).addClass('d-none');
            $('#sel_group'+acid).removeClass('d-none');
        }
    });
</script>