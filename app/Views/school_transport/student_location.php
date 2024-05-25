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
                    <a class="href_loader" href="<?= base_url('school_transport'); ?>">School Transport</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Student Locations</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#stdlocation_table" data-filename="Student loactions"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#stdlocation_table" data-filename="Student loactions"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#stdlocation_table" data-filename="Student loactions"> 
            <span class="my-auto">PDF</span>
        </a>

       <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#stdlocation_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#addstdlocationmodal" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ Add</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
            <div class="w-50">
                <div class="aitsun_select position-relative">
                                               
                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
         
                    <select class="form-select" name="student">
                        <option value="">Select student</option> 
                       
                    </select>
                    <div class="aitsun_select_suggest">
                    </div>
                </div>
            </div>
            <div class="w-50">
                
                <div class="aitsun_select position-relative">
                                               
                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/locations'); ?>">
                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
         
                    <select class="form-select" name="location">
                        <option value="">Select location</option> 
                       
                    </select>
                    <div class="aitsun_select_suggest">
                    </div>
                </div>
            </div>

            
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('school_transport/student_location') ?>?page=1"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>





<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="addstdlocationmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addstdlocationmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addstdlocationmodalLabel">Add student location</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_stdlocation_form" action="<?= base_url('school_transport/add_std_location'); ?>">
                <?= csrf_field() ?>
              <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 mb-3">
                            <div class="aitsun_select position-relative">
                                                   
                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                                <a class="select_close d-none"><i class="bx bx-x"></i></a>
                     
                                <select class="form-select" required name="students">
                                    <option value="">Select student</option> 
                                   
                                </select>
                                <div class="aitsun_select_suggest">
                                </div>
                            </div>
                    </div>
                    
                    <div class="form-group col-md-12 mb-2">
                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/locations'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required name="location">
                                <option value="">Select location</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <div class="modal-footer text-start py-1">
            <button type="button" class="aitsun-primary-btn" id="add_std_location">Save</button>
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
            
            <table id="stdlocation_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Student</th>
                    <th class="sorticon">Location</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($std_location_data as $stl) { $data_count++; ?>
                  <tr>
                    <td><?= $data_count; ?></td>
                    <td><?= user_name($stl['student_id']) ?> - <?= class_name(current_class_of_student(company($user['id']),$stl['student_id'])) ?></td>
                    <td><?= get_products_data($stl['item_id'],'product_name') ?></td> 
                    
                    
                    <td class="text-end" style="width: 120px;" data-tableexport-display="none">
                        <div class="p-1">

                        
                                
                        <a class="deletestdlocation btn-delete-red action_btn cursor-pointer" data-deleteurl="<?= base_url('school_transport/deletestdlocation'); ?>/<?= $stl['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>




                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span class="text-danger">No students</span>
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
        <a href="<?= base_url('school_transport'); ?>" class="text-dark font-size-footer me-2"><i class="bx bxs-bus-school ms-2"></i> <span class="my-auto">Vehicle</span></a>/

        <a href="<?= base_url('fees_and_payments/price_table_transport'); ?>" class="text-dark font-size-footer me-2"><i class="bx bx-money ms-2"></i> <span class="my-auto">Transport price table</span></a>
        
    </div>

    <div>
        <span class="m-0 font-size-footer">Total students : <?= count($std_location_data); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->