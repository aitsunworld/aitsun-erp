 
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
                <li class="breadcrumb-item">
                    <a href="<?= base_url('cheque-management'); ?>" class="href_loader">Cheque Management</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Cheque Department</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#cheque_department_table" data-filename="Cheque Department"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#cheque_department_table"> 
            <span class="my-auto">Quick search</span>
        </a>


    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#departmentmodel" class="btn-back font-size-footer my-auto ms-2"> <span class="my-auto">+ New</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
        

<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="departmentmodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="departmentmodelLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="departmentmodelLabel">Cheque Department</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form  id="add_cheque_department_form" action="<?= base_url('cheque-management/add_cheque_department'); ?>">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-md-12 mb-2">
                        <label for="department_name">Department Name</label>
                        <input type="text" class="form-control" name="department_name" id="department_name" >
                    </div>

                    <div class="form-group col-md-12 mb-2">
                        <label for="bank">Bank</label>
                            <select class="form-select" required id="bank" name="bank">
                                <option value="">Select Bank</option> 
                                <?php foreach (only_bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                <option value="<?= $ba['id'] ?>"><?= $ba['group_head']; ?></option> 
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-12 mb-2">
                        <label for="capacity">Responsible Person</label>
                        <div class="aitsun_select position-relative">
                                                   
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/all_staffs'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                            <select class="form-select" required id="responsible_person" name="responsible_person">
                                <option value="">Select Person</option> 
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>
                    </div>
                  
                </div>
            
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_cheque_department">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="cheque_department_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Department Name</th>
                    <th class="sorticon" style="width:400px;">Bank</th>
                    <th class="sorticon" style="width:400px;">Responsible person</th> 
                    <th class="sorticon text-center" style="width: 150px;" data-tableexport-display="none">Action</th> 
                </tr>
             </thead>
             <tbody>
                <?php  $data_count=0; ?>
                <?php  foreach ($cheque_department as $ch){ $data_count++; ?>
                 <tr>
                     <th><?= $ch['department_name']; ?></th>
                     <th><?= get_group_data($ch['bank_id'],'group_head'); ?></th>
                     <th><?= user_name($ch['responsible_person']); ?></th>
                     <th class="text-center" data-tableexport-display="none">
                        <a data-bs-toggle="modal" data-bs-target="#department_edit<?= $ch['id'] ?>"  class="px-2">
                            <i class="bx bx-pencil"></i> 
                        </a>

                        <a data-deleteurl="<?= base_url('cheque-management/delete_department'); ?>/<?= $ch['id']; ?>" class="delete_department text-danger px-2">
                            <i class="bx bxs-trash-alt"></i> 
                        </a>

                        <!-- ////////////////////////// STAFF EDIT MODAL ///////////////////////// -->

                        <div class="modal fade" id="department_edit<?= $ch['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="department_editLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="department_editLabel"><?= $ch['department_name'] ?></h5>    
                                <button type="button" class="btn-close close_school href_loader" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_department_form<?= $ch['id'] ?>" action="<?=  base_url('cheque-management/update_department') ?>/<?= $ch['id'] ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                            <label for="department_name">Department Name</label>
                                            <input type="text" class="form-control" name="department_name" id="department_name<?= $ch['id'] ?>" value="<?= $ch['department_name'] ?>">
                                        </div>

                                        <div class="form-group col-md-12 mb-2">
                                            <label for="bank">Bank</label>
                                                <select class="form-select" required id="bank<?= $ch['id'] ?>" name="bank">
                                                    <?php foreach (only_bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                                    <option value="<?= $ba['id'] ?>"  <?php if ($ch['bank_id']==$ba['id']) {echo 'selected';} ?>><?= $ba['group_head']; ?></option> 
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-2">
                                            <label for="capacity">Responsible Person</label>
                                            <div class="aitsun_select position-relative">
                                                                       
                                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/all_staffs'); ?>">
                                                <a class="select_close d-none"><i class="bx bx-x"></i></a>
                                                <select class="form-select" required id="responsible_person<?= $ch['id'] ?>" name="responsible_person">
                                                    <option value="">Select Person</option> 
                                                    <option value="<?= $ch['responsible_person'] ?>" selected><?= user_name($ch['responsible_person']); ?></option> 
                                                </select>
                                                <div class="aitsun_select_suggest">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                
                                <div class="modal-footer text-start py-1">
                                    <button type="button" class="aitsun-primary-btn edit_department" data-id="<?= $ch['id'] ?>">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    <!-- ////////////////////////// STAFF EDIT MODAL ///////////////////////// -->
                     </th>
                </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td colspan="4"><h6 class="p-4 text-center text-danger">No Cheque Department Found... </h6></td>
                    </tr>
                <?php endif ?>
             </tbody>
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a onclick="toggleSidebar()">Main Menus</a>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
</div>
 