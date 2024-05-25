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
                    <b class="page_heading text-dark">Ledger Accounts</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
    </div>
    <a data-bs-toggle="modal" data-bs-target="#add_ledger" class="text-dark font-size-footer my-auto ms-2"> <span class="">+ Add</span></a>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<div id="filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
              <input type="text" name="account_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Name'); ?>" class="form-control form-control-sm filter-control ">
            
             
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('accounts/ledger-accounts?page=1') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
    </div>
 
<div class="sub_main_page_content">
    <div class="settings_sidebar mt-4">
        <div class="">
            <ul>
                <li>
                    <a href="<?= base_url('accounts/ledger-accounts'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-arrow-from-left'></i></div>
                        <div class="icon-title">Ledger Accounts</div>
                    </a>
                </li>
                
                <li>
                    <a href="<?= base_url('accounts/group-head'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-arrow-from-left'></i></div>
                        <div class="icon-title">Group Head</div>
                    </a>
                </li>
    
            </ul>
        </div>
    </div>
    <div class="setting_margin">
        <div class="col-12 col-lg-12 col-md-12">
                    <ul class="list-group pb-5">
                        <?php foreach ($ledger_data as $led) { ?>
                        <li class="list-group-item d-flex justify-content-between" style="background: #f0f0f0;">
                            <div class="me-2"><b><?= $led['group_head']; ?></b> 
                                <?php if (!empty(get_group_data($led['parent_id'],'group_head'))): ?>
                                    <small>[<?= get_group_data($led['parent_id'],'group_head'); ?>]</small>
                                <?php endif ?> 
                               <?php if (get_group_data($led['parent_id'],'group_head')=='Bank Accounts' || get_group_data($led['parent_id'],'group_head')=='Cash-in-Hand'): ?>
                                <small class="d-block">
                                   
                                    Current Balance <?= number_format(balance(company($user['id']),$led['id'],'closing_balance'),2,'.',''); ?>
                                </small>
                                 <?php endif ?>
                            </div>

                            <div class="d-flex my-auto">
                         
                                 <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#ed_ledger<?= $led['id']; ?>">
                                        <i class="bx bx-pencil"></i>
                                    </a> 
                        

                                <?php if ($led['default']!=1): ?>
                                   
                                    <a class="text-danger delete" data-url="<?= base_url('accounts/delete_ledger'); ?>/<?= $led['id']; ?>">
                                        <i class="bx bx-trash"></i>
                                    </a> 
                                <?php endif; ?>
                            </div>

                            <div class="modal fade" id="ed_ledger<?= $led['id']; ?>"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit ledger account</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form  method="post" action="<?= base_url('accounts/edit_ledger'); ?>/<?= $led['id']; ?>">
                                            <?= csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <label for="input-2" class="form-label">Ledger Name</label>
                                                            <input type="text" class="form-control modal_inpu" id="input-2" name="ledger_name" value="<?= $led['group_head']; ?>" required>
                                                        </div>
                                                    </div>
 
                                                    <?php if (get_group_data($led['parent_id'],'group_head')=='Bank Accounts' || get_group_data($led['parent_id'],'group_head')=='Cash-in-Hand'): ?>

                                                    <div class="form-group col-md-12 mb-1 mt-3">
                                                        <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Current Balance'); ?></label>
                                                        <input type="number" min="0" step="any" value="<?= $led['closing_balance']; ?>" class="form-control modal_inpu" name="opening_balance" id="input-5">
                                                    </div> 
                                                    <?php endif ?>   
                                                 
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary spinner_btn" name="edit_ledger">Save</button>
                                            </div>
                                        </form> 
                                    </div>
                                </div>
                            </div>
                        </li>      
                        <?php } ?>
                    </ul>
        </div>


        <!-- ledger model -->

        <div class="modal fade" id="add_ledger"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add ledger account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form  method="post" action="<?= base_url('accounts/add_ledger'); ?>">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label for="input-2" class="form-label">Ledger Name</label>
                                        <input type="text" class="form-control modal_inpu" id="input-2" name="ledger_name" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 mb-3">
                                    <div class="form-group">
                                        <label for="input-2" class="form-label">Select group head</label>
                                        <select class="form-select" name="group_head" required>
                                            <?php foreach (group_head_income_expense_array(company($user['id'])) as $gm): ?>
                                                    <option value="<?= $gm['id']; ?>"><?= $gm['group_head']; ?></option>

                                                    
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-8 mb-2">
                                    <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                                    <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="input-5">
                                </div>
                                <div class="form-group col-md-4 ">
                                    <label>Type</label>
                                    <select class="form-control" name="opening_type">
                                        <option value="">To Collect</option>
                                        <option value="-">To Pay</option>
                                    </select>
                                </div>           
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary spinner_btn" name="add_ledger">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- ledger model -->

       
    </div>
</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


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