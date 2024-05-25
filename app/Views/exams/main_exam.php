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
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Exam</b>
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
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#main_exam_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#addmainexam" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ New exam</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            

             <select class="form-select" name="bookcategory">
                    <option value="" selected>Category</option>
                     <?php foreach (book_category_array(company($user['id'])) as $bk): ?>
                        <option value="<?= $bk['id']; ?>"><?= $bk['category']; ?></option>
                    <?php endforeach ?>
            </select>


              <input type="text" name="serachbook" class="form-control-sm form-control filter-control" placeholder="Search Book Name">
            
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('library-management') ?>?page=1"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>


<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="addmainexam" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addmainexamLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addmainexamLabel">Add exam</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_main_exam_form" action="<?= base_url('exams/add_main_exam'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="exam_name">Exam Name</label>
                        <input type="text" class="form-control" name="exam_name" id="exam_name" >
                    </div>

                     <div class="form-group col-md-6 mb-2 ">
                        <label class="font-weight-semibold" for="category">Select Category</label>
                        <select class="form-select" name="category" id="category">
                            <option value="">Select Category</option>
                            <?php foreach (exam_cate_array(company($user['id'])) as $exc): ?>
                                <option value="<?= $exc['id']; ?>"><?= $exc['exam_category']; ?></option>
                            <?php endforeach ?>

                        </select> 
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label for="date">Start Date</label>
                        <input type="date" class="form-control" name="start_date" placeholder="Start Date">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="date">End Date</label>
                        <input type="date" class="form-control" name="end_date" placeholder="End Date">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="to">Description</label>
                        <textarea class="form-control"  name="description" placeholder="Details"></textarea>
                    </div>
                </div>
            </div>
          <div class="modal-footer text-start py-1">
            <button type="button" class="aitsun-primary-btn" id="add_main_exam">Save</button>
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
                    <th class="sorticon">Exam name</th>
                    <th class="sorticon">Exam category</th>
                    <th class="sorticon">Start date </th> 
                    <th class="sorticon">End date</th> 
                    <th class="sorticon">Details</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($main_exam_data as $mex) { $data_count++; ?>
                  <tr>
                    <td style="width: 90px;"><?= $data_count; ?></td>
                    <td><?= $mex['exam_name']; ?></td>
                    <td><?= exam_cate_name($mex['category']); ?></td>
                    <td><?= get_date_format($mex['start_date'],'d M Y'); ?></td> 
                    <td><?= get_date_format($mex['end_date'],'d M Y'); ?></td> 
                    <td><?= $mex['description']; ?></td> 
                    
                    <td class="text-end" style="width: 270px;" data-tableexport-display="none">
                        <div class="p-1">

                         <a class="btn-pdf me-1 action_btn text-white cursor-pointer downloading_click" href="<?= base_url('exams/pdf_main_exam_time_table'); ?>/<?= $mex['id']; ?>" download><i class="bx bxs-file-pdf mr-1"></i></a>


                         <?php if ($mex['exam_status']=='completed'): ?>
                            <a class="btn-purple me-1 action_btn cursor-pointer" href="<?= base_url('exams/main_exam_time_table'); ?>/<?= $mex['id']; ?>"><i class="anticon anticon-edit mr-1"></i>Valuation</a>

                        <?php else: ?>
                            <a class="btn-purple me-1 action_btn cursor-pointer"  href="<?= base_url('exams/main_exam_time_table'); ?>/<?= $mex['id']; ?>"><i class="bx bxs-show"></i></a>

                            <a class=" btn-edit-dark me-1 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#edit_main_exam<?= $mex['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                            <a class="delete_main_exam btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('exams/delete_main_exam'); ?>/<?= $mex['id']; ?>"><i class="bx bxs-trash"></i></a>
                        <?php endif ?>

                        </div>




                        <!-- ////////////////////////// MODAL EDIT///////////////////////// -->

                        <div class="modal fade" id="edit_main_exam<?= $mex['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="edit_main_exam<?= $mex['id'] ?>Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="edit_main_exam<?= $mex['id'] ?>Label">Edit exam</h5>    
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                               <form id="edit_main_exam_form<?= $mex['id']; ?>" action="<?= base_url('exams/update_main_exam'); ?>/<?= $mex['id']; ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body text-start">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="font-weight-semibold" for="exam_name">Exam Name</label>
                                            <input type="text" class="form-control" name="exam_name" id="exam_name"  value="<?= $mex['exam_name']; ?>">
                                        </div>

                                         <div class="form-group col-md-6 mb-2 ">
                                            <label class="font-weight-semibold" for="category">Select Category</label>
                                            <select class="form-select" name="category" id="category">
                                                <option value="">Select Category</option>
                                                <?php foreach (exam_cate_array(company($user['id'])) as $sub): ?>
                                                    <option value="<?= $sub['id']; ?>" <?php  if ($mex['category']==$sub['id']) {echo 'selected';}?>><?= $sub['exam_category']; ?></option>
                                                <?php endforeach ?>

                                            </select> 
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <label for="date">Start Date</label>
                                            <input type="date" class="form-control" name="start_date" placeholder="Start Date" value="<?= $mex['start_date']; ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="date">End Date</label>
                                            <input type="date" class="form-control" name="end_date" placeholder="End Date" value="<?= $mex['end_date']; ?>">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="to">Description</label>
                                            <textarea class="form-control"  name="description" placeholder="Details"><?= $mex['description']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                              <div class="modal-footer text-start py-1">
                                <button type="button" class="aitsun-primary-btn edit_main_exam" data-id="<?= $mex['id']; ?>">Save</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    <!-- ////////////////////////// MODAL EDIT///////////////////////// -->

                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="7">
                            <span class="text-danger">No exams</span>
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
        <a href="<?= base_url('exams/exam_configuration'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bx-selection ms-2"></i> <span class="my-auto">Exam configuration</span></a>
       
    </div>


    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->