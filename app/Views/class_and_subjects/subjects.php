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
                    <b class="page_heading text-dark">Subjects</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#subjects_table" data-filename="Subjects"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#subjects_table" data-filename="Subjects"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#subjects_table" data-filename="Subjects"> 
            <span class="my-auto">PDF</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#subjects_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>
<a type="button" data-bs-toggle="modal" data-bs-target="#subjectaddmodal" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ New subject</span></a>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="subjectaddmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="subjectaddmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="subjectaddmodalLabel">Add subject</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_subject_form" action="<?= base_url('class-and-subjects/add-subject'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <label>Subject Name:</label>
                        <input type="text" class="form-control" name="subname">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Subject Code</label>
                        <input type="text" class="form-control" name="subcode">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_subjects">Save</button>
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
            
            <table id="subjects_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon" style="width:50px;">#</th>
                    <th class="sorticon">Subject</th>
                    <th class="sorticon">Code</th>
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($sub_data as $sb) { $data_count++; ?>
                  <tr>
                    <td><?= $sb['serial_no'] ?></td>
                    <td><?= $sb['subject_name'] ?></td>
                    <td><?= $sb['subject_code'] ?></td> 
                    
                    <td class="text-end" style="width: 110px;" data-tableexport-display="none">


                        <?php if ($sb['deletable']!=1): ?>

                        <div class="p-1">
                            
                             <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#subjectedit<?= $sb['id'] ?>"><i class="bx bxs-edit-alt"></i></a>

                            <a class="deletesubject btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('class-and-subjects/deletesubject'); ?>/<?= $sb['id']; ?>"><i class="bx bxs-trash"></i></a>
                            
                        </div>
                        
                        <?php endif ?>


                        <!-- ////////////////////////// SUBJECT EDIT MODAL ///////////////////////// -->

                            <div class="modal fade" id="subjectedit<?= $sb['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="subjectaddmodalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-start">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="subjectaddmodalLabel">Edit subject</h5>    
                                    <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form id="edit_subject_form<?= $sb['id'] ?>" action="<?= base_url('class-and-subjects/update-subject') ?>/<?= $sb['id'] ?>">
                                        <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-2">
                                                <label>Subject Name:</label>
                                                <input type="text" class="form-control" name="subname" value="<?= $sb['subject_name'] ?>">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Subject Code</label>
                                                <input type="text" class="form-control" name="subcode" value="<?= $sb['subject_code'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-start py-1">
                                        <button type="button" class="aitsun-primary-btn edit_subjects" data-id="<?= $sb['id'] ?>">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        <!-- ////////////////////////// SUBJECT EDIT MODAL ///////////////////////// -->

                        
                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span class="text-danger">No subjects</span>
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
        <a href="<?= base_url('class-and-subjects'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-layout ms-2"></i> <span class="my-auto">Classes</span></a>
    </div>
    <div>
        <span class="m-0 font-size-footer">Total subjects : <?= count($sub_data);?></span>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->