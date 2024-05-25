<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Articles</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#articles_tb" data-filename="Student Artilces"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#articles_tb" data-filename="Student Artilces"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#articles_tb" data-filename="Student Artilces"> 
            <span class="my-auto">PDF</span>
        </a>
       
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#articles_tb"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
        
         <div class="aitsun_table w-100 pt-0">

            <table class="erp_table sortable" id="articles_tb">
                <thead>
                    <tr>
                        <th class="sorticon">Article Title</th>
                        <th class="sorticon">Posted By</th>
                        <th class="sorticon">Request Teacher</th>
                        <th class="sorticon" data-tableexport-display="none">Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $data_count=0; ?>
                    <?php $i=0; foreach ($articles as $at) { $data_count++; ?>
                    <tr>
                       
                        <td>
                            <?= $at['title'] ?>
                        </td>
                        <td><?= user_name($at['student_id']) ?> - <?= class_name(current_class_of_student(company($user['id']),$at['student_id'])) ?> </td>
                        <td><?= user_name($at['teacher_id']) ?></td>
                        <td>
                            <?php if(trim($at['status'])=='waiting')
                                {
                                    echo '<span class="badge btn-warning my-2" style="border-radius: 50px;">Waiting</span>';
                                }elseif(trim($at['status'])=='accepted'){
                                    echo '<span class="badge btn-success my-2" style="border-radius: 50px;">Accepted</span>';
                                }elseif(trim($at['status'])=='rejected'){
                                    echo '<span class="badge btn-danger my-2" style="border-radius: 50px;">Rejected</span>';
                                } ?>
                        </td>
                        <td>
                            <a href="<?= base_url('magazines/view_article'); ?>/<?= $at['id']; ?>" class="aitsun-datebox"><i class="bx bx-show"></i></a>
                        </td>
                    </tr>

                    <?php } ?>
                    <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="9">
                            <span class="text-danger">No Articles</span>
                        </td>
                    </tr>
                <?php endif ?>
                   
                </tbody>
            </table>

         </div> 
    </div>
</div>


<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    

    <div>
        <span class="m-0 font-size-footer">Total articles : <?= count_articles(company($user['id']),'total'); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
