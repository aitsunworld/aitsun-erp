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
                    <b class="page_heading text-dark">Classes</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#class_table" data-filename="Classes"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#class_table" data-filename="Classes"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#class_table" data-filename="Classes"> 
            <span class="my-auto">PDF</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#class_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>
<a type="button" data-bs-toggle="modal" data-bs-target="#classaddmodal" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ New class</span></a>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="classaddmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="classaddmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="classaddmodalLabel">Add class</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_class_form" action="<?= base_url('class-and-subjects/add-class'); ?>/<?= $user['id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 mb-2">
                        <label>Class</label>
                        <input type="text" class="form-control" name="class">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label>Strength</label>
                        <input type="number" min="0" class="form-control" name="strength">
                    </div>

                    <div class="col-6 mb-2">
                        <div class="d-flex justify-content-between">
                            <label for="inputVendor" class="form-label my-auto">Responsible Teacher</label>
                            <a class="p-0 add_teacher" id="add_teacher" style="font-size: 13px!important;">+ Teacher</a>
                        </div>

                        <div id="teacher_container" class="mb-2 text-end" style="display: none;">
                            <div  class="d-flex justify-content-between">
                                 <input type="text" name="display_name" id="display_name" class="ad_u form-control" placeholder="Teacher Name">
                                <input type="text" name="contact_number" id="contact_number" class="ad_u form-control ms-4"  placeholder="Phone">
                            </div>
                            <button class="mr-2 addd_teacher mb-2 mt-2 adddd_unit_btn" id="addd_teacher"  type="button" >Add</button>
                        </div>

                        
                        <select class="form-select single-select" name="teacher" id="teacher">
        
                            <option value="">Choose teacher</option>
                            <?php foreach (teachers_array($user['company_id']) as $tcr): ?>
                                <option value="<?= $tcr['id']; ?>"><?= user_name($tcr['id']); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label>Rewarding</label>
                        <input type="text" class="form-control" name="rewarding">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_class">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="class_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">#</th>
                    <th class="sorticon">Class</th>
                    <th class="sorticon">Resp. teacher </th> 
                    <th class="sorticon" style="width:150px;">Leader 1</th> 
                    <th class="sorticon" style="width:150px;">Leader 2</th> 
                    <th class="sorticon">Boys</th> 
                    <th class="sorticon">Girls</th> 
                    <th class="sorticon">Others</th> 
                    <th class="sorticon">Total students</th> 
                    <th class="sorticon">Rewarding</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($class_data as $cls) { $data_count++; ?>
                  <tr>
                    <td><?= $cls['serial_no'] ?></td>
                    <td><?= $cls['class'] ?></td>
                    <td><?= user_name(get_teacher_of_class(company($user['id']),$cls['id'])) ?></td> 
                    <td><?= user_name($cls['leader1']) ?></td> 
                    <td><?= user_name($cls['leader2']) ?></td> 
                    <td><?= total_class_students(company($user['id']),$cls['id'],'male'); ?></td>
                    <td><?= total_class_students(company($user['id']),$cls['id'],'female'); ?></td> 
                    <td><?= total_class_students(company($user['id']),$cls['id'],'others'); ?></td> 
                    <td><?= total_class_students(company($user['id']),$cls['id'],'all'); ?></td> 
                    <td><?= $cls['rewarding'] ?></td> 
                    
                    <td class="text-end" style="width: 170px;" data-tableexport-display="none">
                        <div class="p-1">
                             <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#class_edit<?= $cls['id'] ?>"><i class="bx bxs-edit-alt"></i></a>

                            <a class="deleteclass btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('class-and-subjects/deleteclasses'); ?>/<?= $cls['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>


                        <!-- ////////////////////////// MODAL EDIT ///////////////////////// -->

                        <div class="modal fade" id="class_edit<?= $cls['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="class_editLabel" aria-hidden="true" >
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="class_editLabel">Edit class</h5>
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_class_form<?= $cls['id'] ?>" action="<?= base_url('class-and-subjects/update-class') ?>/<?= $cls['id'] ?>">
                                    <?= csrf_field() ?>
                                  <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="font-weight-semibold" for="class">Class</label>
                                                <input type="text" class="form-control" name="class" placeholder="Class Name" value="<?= $cls['class'] ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="font-weight-semibold" for="strength">Strength</label>
                                                <input type="number" min="0" class="form-control" name="strength" placeholder="Strength" value="<?= $cls['strength'] ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="font-weight-semibold" for="teacher">Responsible Teacher</label>
                                                <select class="form-select" name="teacher">
                                                    <option value="">Choose teacher</option>
                                                    <?php foreach (superusers_array($user['company_id']) as $spu): ?>
                                                        <option value="<?= $spu['id']; ?>" <?php if ($spu['id']==get_teacher_of_class(company($user['id']),$cls['id'])) { echo 'selected'; } ?>><?= user_name($spu['id']); ?></option>
                                                    <?php endforeach ?>
                                                    
                                                    <?php foreach (teachers_array($user['company_id']) as $tcr): ?>
                                                        <option value="<?= $tcr['id']; ?>" <?php if ($tcr['id']==get_teacher_of_class(company($user['id']),$cls['id'])) { echo 'selected'; } ?>><?= user_name($tcr['id']); ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="font-weight-semibold" for="rewarding">Rewarding</label>
                                                <input type="text" class="form-control" name="rewarding" placeholder="Rewarding" value="<?= $cls['rewarding'] ?>">
                                            </div>
                                        </div>
                                  </div>
                              <div class="modal-footer text-start py-1">
                                <button type="button" class="aitsun-primary-btn edit_class" data-id="<?= $cls['id'] ?>">Save</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- ////////////////////////// MODAL EDIT ///////////////////////// -->




                        
                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="11">
                            <span class="text-danger">No classes</span>
                        </td>
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
     <div class="b_ft_bn">
        <a href="<?= base_url('class-and-subjects/subjects'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-collection ms-2"></i> <span class="my-auto">Subjects</span></a>
    </div>
    <div>
        <span class="m-0 font-size-footer">Total classes : <?= count($class_data);?></span>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->