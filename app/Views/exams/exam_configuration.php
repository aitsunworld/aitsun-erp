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
                    <a href="<?= base_url('exams'); ?>" class="href_loader">Exams</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url('exams/main_exam'); ?>" class="href_loader">Exam</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Exam configuration</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#main_exam_table" data-filename="Exams"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#main_exam_table" data-filename="Exams"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#main_exam_table" data-filename="Exams"> 
            <span class="my-auto">PDF</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#main_exam_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#add_exam_category" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ Add exam category</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->





<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="add_exam_category" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_exam_categoryLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="add_exam_categoryLabel">Add exam</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="exams_add_cate_form" action="<?= base_url('exams/add_exam_category'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <label class="font-weight-semibold" for="exam_cate_name">Exam category name</label>
                        <input type="text" class="form-control" name="exam_cate_name" id="exam_cate_name" >
                    </div>
                </div>
            </div>
          <div class="modal-footer text-start py-1">
            <button type="button" class="aitsun-primary-btn" id="add_exam_cate">Save</button>
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
            
            <table id="main_exam_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Sr. No.</th>
                    <th class="sorticon">Exam category</th>
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($exam_cate_data as $exc) { $data_count++; ?>
                  <tr>
                    <td style="width: 100px;"><?= $data_count; ?></td>
                    <td><?= $exc['exam_category']; ?></td>
                    
                    
                    <td class="text-end" style="width: 170px;" data-tableexport-display="none">

                        <div class="p-1">
                            <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#examcateedit<?= $exc['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                            <a class="deleteexamcate btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('exams/deleteexamcate'); ?>/<?= $exc['id']; ?>"><i class="bx bxs-trash"></i></a>
                   

                        </div>


                         <!-- ////////////////////////// MODAL EDIT ///////////////////////// -->

                        <div class="modal fade" id="examcateedit<?= $exc['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="examcateeditLabel" aria-hidden="true" >
                          <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="examcateeditLabel">Edit exam category</h5>
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_exam_cate_form<?=$exc['id'] ?>" action="<?=base_url('exams/update_exam_cate') ?>/<?=$exc['id'] ?>">
                                    <?= csrf_field() ?>
                                  <div class="modal-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-12 mb-2">
                                                <input type="text" class="form-control" name="exam_cate_name" id="exam_cate_name" placeholder="Category Name" value="<?=$exc['exam_category'] ?>">
                                            </div>
                                        </div>
                                  </div>
                              <div class="modal-footer text-start py-1">
                                <button type="button" class="aitsun-primary-btn edit_cate_exam" data-id="<?= $exc['id'] ?>">Save</button>
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
                        <td class="text-center" colspan="7">
                            <span class="text-danger">No exams category </span>
                        </td>
                    </tr>
                <?php endif ?>
                 
              </tbody>
            </table>
        </div>

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



