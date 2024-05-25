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
                    <a class="href_loader" href="<?= base_url('library-management'); ?>?page=1">Library books</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Issued books</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#issuebooks_table" data-filename="Issued books"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#issuebooks_table" data-filename="Issued books"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#issuebooks_table" data-filename="Issued books"> 
            <span class="my-auto">PDF</span>
        </a>
        
        
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#issuebooks_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="issuebooks_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">#</th>
                    <th class="sorticon">Student name</th>
                    <th class="sorticon">Book Name </th> 
                    <th class="sorticon">Issued date</th> 
                    <th class="sorticon">Return date</th> 
                    <th class="sorticon">Status</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($issue_book_data as $isb) { $data_count++; ?>
                  <tr>
                    <td><?= $isb['serial_no'] ?></td>
                    <td><?= user_name($isb['student_id']) ?> - <?= class_name(current_class_of_student(company($user['id']),$isb['student_id'])) ?></td>
                    <td><?= book_name($isb['book_id']) ?></td> 
                    <td><?= get_date_format($isb['issued_date'],'d M Y') ?></td> 
                    <td><?= get_date_format($isb['return_date'],'d M y') ?></td> 
                    <td><?= $isb['status'] ?></td> 
                    
                    <td class="text-end" style="width: 130px;" data-tableexport-display="none">
                        <div class="p-1">
                        <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#issued_book_edit<?= $isb['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                        <a class="deleteissuebk btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('library-management/delete-issue-book'); ?>/<?= $isb['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>


                        <!-- ////////////////////////// MODAL EDIT ///////////////////////// -->

                        <div class="modal fade" id="issued_book_edit<?= $isb['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="book_cate_editLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="book_cate_editLabel">Edit issued book</h5>
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_issue_book_form<?= $isb['id'] ?>" action="<?= base_url('library-management/update-issue-books') ?>/<?= $isb['id'] ?>">
                                    <?= csrf_field() ?>
                                  <div class="modal-body">
                                        <div class="form-group col-md-12 mb-2">
                                            <label for="student">Select Student</label>
                                            

                                            <div class="aitsun_select position-relative ">

                                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                                                <a class="select_close d-none"><i class="bx bx-x"></i></a>

                                     
                                                <select class="form-select" name="student">
                                                    <option value="">Select student</option> 
                                                    <option value="<?= $isb['student_id'];?>" selected><?= user_name($isb['student_id']); ?> - <?= class_name(current_class_of_student(company($user['id']),$isb['student_id'])) ?></option> 
                                                </select>

                                                <div class="aitsun_select_suggest">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-2">
                                            <label for="student">Select book</label>
                                            <div class="aitsun_select position-relative ">

                                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/library_books'); ?>">
                                                <a class="select_close d-none"><i class="bx bx-x"></i></a>

                                     
                                                <select class="form-select" name="book">
                                                    <option value="<?= $isb['book_id'];?>" selected><?= book_name($isb['book_id']); ?></option> 
                                                </select>

                                                <div class="aitsun_select_suggest">
                                                </div>
                                            </div>

                                            
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="return_date">Return Date</label>
                                            <input type="date" class="form-control" name="return_date" id="return_date" value="<?= $isb['return_date'] ?>" placeholder="Return Date">
                                        </div>
                                  </div>
                              <div class="modal-footer text-start py-1">
                                <button type="button" class="aitsun-primary-btn edit_issue_book" data-id="<?= $isb['id'] ?>">Save</button>
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
                            <span class="text-danger">No issued books</span>
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
        <a href="<?= base_url('library-management'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book ms-2"></i> <span class="my-auto">Library books</span></a>/
        <a href="<?= base_url('library-management/returnedbooks'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book-reader ms-2"></i> <span class="my-auto">Books to be returned</span></a>/
        <a href="<?= base_url('library-management/bookcategory'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book-bookmark ms-2"></i> <span class="my-auto">Books category</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total issued books : <?= count($issuedbooks); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->