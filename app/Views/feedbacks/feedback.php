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
                    <b class="page_heading text-dark">Feedbacks</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#feedbacks_table" data-filename="Feedbacks"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#feedbacks_table" data-filename="Feedbacks"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#feedbacks_table" data-filename="Feedbacks"> 
            <span class="my-auto">PDF</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#feedbacks_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->






<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="feedbacks_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Student name</th>
                    <th class="sorticon">Class</th>
                    <th class="sorticon">Subject </th> 
                    <th class="sorticon">Message</th> 
                    <th class="sorticon">Date</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($feedbacks as $fb) { $data_count++; ?>
                  <tr>
                    <td><?= user_name($fb['student_id']) ?></td>
                    <td><?= class_name(current_class_of_student(company($user['id']),$fb['student_id'])) ?></td>
                    <td><?= $fb['subject']; ?></td> 
                    <td><?= $fb['review']; ?></td> 
                    <td><?= get_date_format($fb['datetime'],'d M Y'); ?></td> 
                    
                    <td class="text-end" style="width: 170px;" data-tableexport-display="none">
                        <div class="p-1">
                            <a class="delete_feedback btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('feedbacks/delete-feedback'); ?>/<?= $fb['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>
                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span class="text-danger">No feedbacks</span>
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
    
    <div>
        <span class="m-0 font-size-footer">Total books : <?= total_feedback(company($user['id'])); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->