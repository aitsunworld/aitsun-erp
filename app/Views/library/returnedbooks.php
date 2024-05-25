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
                    <b class="page_heading text-dark">Books to be returned</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#returnbooks_table" data-filename="Books to be returned"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#returnbooks_table" data-filename="Books to be returned"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#returnbooks_table" data-filename="Books to be returned"> 
            <span class="my-auto">PDF</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#returnbooks_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">
        
        <div class="aitsun_table w-100 pt-0">
            
            <table id="returnbooks_table" class="erp_table sortable">
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

                <?php foreach ($return_books as $rtn) { $data_count++; ?>
                  <tr>
                    <td><?= $rtn['serial_no'] ?></td>
                    <td><?= user_name($rtn['student_id']) ?> - <?= class_name(current_class_of_student(company($user['id']),$rtn['student_id'])) ?></td>
                    <td><?= book_name($rtn['book_id']) ?></td> 
                    <td><?= get_date_format($rtn['issued_date'],'d M Y') ?></td> 
                    <td><?= get_date_format($rtn['return_date'],'d M y') ?></td> 
                    <td><?= $rtn['status'] ?></td> 
                    
                    <td class="text-end" style="width: 180px;" data-tableexport-display="none">
                        <div class="p-1">
                        <a class="py-1 px-2 btn-success me-2 action_btn cursor-pointer send_returnbook_via_sms" data-uid="<?= $rtn['student_id'] ?>" data-phone="<?= user_phone($rtn['student_id']) ?>" data-bookname="<?= book_name($rtn['book_id']) ?>"><i class="bx bxs-message-dots"></i></a>
                                
                        <a class="receive_book btn-purple action_btn cursor-pointer"  data-deleteurl="<?= base_url('library-management/received-book'); ?>/<?= $rtn['id']; ?>">Received or Not?</a>
                        </div>
                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="7">
                            <span class="text-danger">No return books</span>
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
        <a href="<?= base_url('library-management/issuedbooks'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book-add ms-2"></i> <span class="my-auto">Issued books</span></a>/
        <a href="<?= base_url('library-management/bookcategory'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book-bookmark ms-2"></i> <span class="my-auto">Books category</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total return books : <?= count($return_books); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->