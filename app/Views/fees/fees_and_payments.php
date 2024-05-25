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
                    <b class="page_heading text-dark">Fees management</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#fees_tables" data-filename="Fees master <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#fees_tables" data-filename="Fees master <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#fees_tables" data-filename="Fees master <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#fees_tables"> 
            <span class="my-auto">Quick search</span>
        </a>

        <a href="<?= base_url('fees_and_payments/price_table'); ?>" class=" text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Price table</span>
        </a>

        <a href="<?= base_url('fees_and_payments/price_table_transport'); ?>" class=" text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Transport price table</span>
        </a>

        
        
    </div>

    <a data-bs-toggle="modal" data-bs-target="#addstudentmodel" class="text-dark font-size-footer my-auto ms-2"> <span class="">+ Add Fees</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 <!------------------------------------------------- Add fees modal ------------------------------------------->
 <div class="modal fade" id="addstudentmodel">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addstudentmodelLabel">Add Fees</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
            <form method="post" action="<?= base_url('fees_and_payments/add_fees_type'); ?>">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="font-weight-semibold" for="feesname">Fees Name</label>
                        <input type="text" class="form-control" name="feesname" placeholder="Fees Name" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-semibold" for="fees_type">Fees Type</label>
                        <select class="form-control form-select" name="fees_type" id="fees_type" required>
                            <option value="0">Standard</option>
                            <option value="1">Transport</option>
                            <option value="2">Custom</option>
                        </select>
                    </div>
                   
                    <div class="form-group col-md-6">
                        <label class="font-weight-semibold" for="end_date">Due Date</label>
                        <input type="date" class="form-control" name="due_date" id="end_date" placeholder="Due Date" required>
                    </div>

                    <div class="form-group col-md-4 d-none">
                       <label class="font-weight-semibold" for="classes">Class <small>(Required)</small></label>
                        <select class="form-control" name="classes" >
                            <option value="">Choose Class</option>
                            <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                     <div class="form-group col-md-12 mt-2" id="feeselector">

                        <input type="text" class="form-control mb-0" id="search_addtional_fee" placeholder="Search fee...">


                       <label class="font-weight-semibold" for="classes">Select Items</label>
                       <table id="feetable" class="erp_table">  
                         <?php foreach (products_default_only_fees_array(company($user['id'])) as $itm): ?>
                            <tr>
                                <td>
                                    <div class="form-group col-md-12 mb-0">
                                        <input type="hidden" name="item_id[]" value="<?= $itm['id']; ?>">

                                         <input type="checkbox" id="radio<?= $itm['id']; ?>" class="mt-1 mr-1 checkingrollbox checkBoxmrngAll" >
                                        <input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="itemchecked[]" type="hidden"  value="0">

                                        <label for="radio<?= $itm['id']; ?>"><?= $itm['product_name']; ?></label>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                    </div>
                   
                    <div class="form-group col-md-12">
                        <label class="font-weight-semibold" for="description">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <button class="aitsun-primary-btn mt-3" type="submit" >Add</button>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------- Add fees modal ------------------------------------------->
        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex" action="<?= base_url('fees_and_payments') ?>">
                    <?= csrf_field(); ?>
                    
                      
 
                        <input type="text" name="fee_name" class="form-control form-control-sm filter-control " placeholder="Search fees"> 
                        <select name="class" class="form-control form-control-sm d-none">
                         <option value="">Select Class</option>
                         <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                        <?php endforeach ?>
                        </select>
                      

 
                        <select name="added_by" class="form-control form-control-sm">
                         <option value="">Select user</option>
                         <?php foreach (staffs_array(company($user['id'])) as $stf): ?>
                             <option value="<?= $stf['id']; ?>"><?= user_name($stf['id']); ?></option>
                         <?php endforeach ?>
                        </select>
                       

 
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees_and_payments') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="fees_tables" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Fees</th>
                    <th class="sorticon">Due date</th>
                    <th class="sorticon">Total challans</th> 
                    <th class="sorticon">Details</th> 
                    <th class="sorticon">Paid</th> 
                    <th class="sorticon">Half paid</th> 
                    <th class="sorticon">Pending</th> 
                    <th class="sorticon" data-tableexport-display="none" style="width:170px;">Action</th>  
                </tr>
             
             </thead>
              <tbody>
                <?php $i=0; foreach ($fees_type as $ft): $i++; ?>
                <tr>
                    <td><?= $ft['fees_name']; ?></td>
                    <td><?= get_date_format($ft['due_date'],'d M Y'); ?></td>
                    <td><?= no_of_challans($ft['id'],$user['id']); ?></td> 
                    <td><?= nl2br($ft['description']); ?></td> 
                    <td><?= total_paid_amount_students(company($user['id']),$ft['id']); ?></td> 
                    <td><?= total_half_paid_amount_students(company($user['id']),$ft['id']); ?></td> 
                    <td><?= total_unpaid_amount_students(company($user['id']),$ft['id']); ?></td> 
                    <td data-tableexport-display="none" class="text-end">
                         <a class="btn btn-sm btn-success my-auto fe_manage_bt text-white href_loader ajax_page cursor-pointer" data-position=".main-content" data-active_class="active" href="<?= base_url('fees_and_payments/details') ?>/<?= $ft['id']; ?>">Manage</a>

                         <?php if (no_of_challans($ft['id'],$user['id'])>0): ?> 
                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#feeseditname<?= $ft['id']; ?>"><i class="bx bx-pencil"></i></button>

                            <a class="btn btn-danger btn-sm no_loader cant_delete_fees"><i class="bx bx-trash"></i></a>
                        <?php else: ?>
                             <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#feesedit<?= $ft['id']; ?>"><i class="bx bx-pencil"></i></button>
                             
                            <a class="btn btn-danger btn-sm delete" data-url="<?= base_url('fees_and_payments/delete_fees_type'); ?>/<?= $ft['id']; ?>"><i class="bx bx-trash"></i></a>
                        <?php endif ?> 




                            <?php if (no_of_challans($ft['id'],$user['id'])>0): ?> 


                                <!------------------------------------------------- Edit Modal ------------------------------------------->


                    <div class="modal fade" id="feeseditname<?= $ft['id']; ?>">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addstudentmodelLabel">Edit name</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>

                                <div class="modal-body text-start">
                                <form method="post" action="<?= base_url('fees_and_payments/edit_fees_name'); ?>/<?= $ft['id']; ?>">
                                    <?= csrf_field() ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label class="font-weight-semibold" for="feesname">Fees Name</label>
                                            <input type="text" class="form-control" name="feesname" placeholder="Fees Name" value="<?= $ft['fees_name']; ?>" required>
                                        </div> 

                                        <div class="form-group col-md-12 d-none">
                                            <label class="font-weight-semibold" for="fees_type">Fees Type</label>
                                            <select class="form-control form-select" name="fees_type" required>
                                                <option value="0" <?php if($ft['fees_type']==0){echo 'selected';} ?>>Standard</option>
                                                <option value="1" <?php if($ft['fees_type']==1){echo 'selected';} ?>>Transport</option>
                                                <option value="2" <?php if($ft['fees_type']==2){echo 'selected';} ?>>Custom</option>
                                            </select>
                                        </div>
 
                                    </div>

                                    

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button class="aitsun-primary-btn mt-2" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>     
                                </div>
                            </div>
                        </div>
                    </div>

                            <?php else: ?>



                                <div class="modal fade" id="feesedit<?= $ft['id']; ?>">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addstudentmodelLabel">Edit Fees</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal">
                                         <i class="bx bx-x"></i>
                                    </button>
                                </div>

                                <div class="modal-body text-start">
                                <form method="post" action="<?= base_url('fees_and_payments/edit_fees_type'); ?>/<?= $ft['id']; ?>">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-semibold" for="feesname">Fees Name</label>
                                            <input type="text" class="form-control" name="feesname" placeholder="Fees Name" value="<?= $ft['fees_name']; ?>" required>
                                        </div>

                                        <div class="form-group col-md-12 d-none">
                                            <label class="font-weight-semibold" for="fees_type">Fees Type</label>
                                            <select class="form-control form-select" name="fees_type"required>
                                                <option value="0" <?php if($ft['fees_type']==0){echo 'selected';} ?>>Standard</option>
                                                <option value="1" <?php if($ft['fees_type']==1){echo 'selected';} ?>>Transport</option>
                                                <option value="2" <?php if($ft['fees_type']==2){echo 'selected';} ?>>Custom</option>
                                            </select>
                                        </div>
 
                                        
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-semibold" for="end_date">End Date</label>
                                            <input type="date" class="form-control" name="due_date" value="<?= $ft['due_date']; ?>" id="end_date" placeholder="End Date" required>
                                        </div>
                                       


                                        <div class="form-group col-md-12 mt-2 <?php if ($ft['fees_type']==1 || $ft['fees_type']==2) {echo 'd-none';} ?>">
                                           <label class="font-weight-semibold" for="classes">Select Items</label>
                                             <?php foreach (products_default_only_fees_array(company($user['id'])) as $itm): ?>
                                                <div class="form-group col-md-12 mb-0">
                                                    <input type="hidden" name="item_id[]" value="<?= $itm['id']; ?>"> 

                                                     <input type="checkbox" id="radio<?= $itm['id']; ?>" class="mt-1 mr-1 checkingrollbox checkBoxmrngAll" <?php if (is_have_item($ft['id'],$itm['id'])==1){echo "checked";} ?> >
                                                    <input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="itemchecked[]" type="hidden"  value="<?= is_have_item($ft['id'],$itm['id']) ?>">

                                                    <label for="radio<?= $itm['id']; ?>"><?= $itm['product_name']; ?></label>

                                                </div>
                                            <?php endforeach ?>
                                        </div>



                                      
                                        <div class="form-group col-md-12 mt-2">
                                            <label class="font-weight-semibold" for="description">Description</label>
                                            <textarea class="form-control" name="description"><?= $ft['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button class="aitsun-primary-btn mt-2" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>     
                                </div>
                            </div>
                        </div>
                    </div>



                    <!------------------------------------------------- Edit Modal ------------------------------------------->

                            <?php endif ?> 
                    


                     
                    </td> 
                </tr>
                <?php endforeach ?>
                <?php if ($i==0): ?>

                    <tr>
                        <td colspan="8" class="text-center">
                            <span class="text-danger"> No Fees & Payments</span>
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
        <a href="<?= base_url('fees_and_payments/fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/group_wise_fees_collected'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Group wise fees collected </span></a>/
        <a href="<?= base_url('fees_and_payments/collected_transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport fees collected</span></a>/
        <a href="<?= base_url('fees_and_payments/consession_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Concession report</span></a>/
        <a href="<?= base_url('fees_and_payments/fees_wise_outstanding'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Fees wise outstanding</span></a>/
        <a href="<?= base_url('fees_and_payments/transport_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Transport outstanding</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 