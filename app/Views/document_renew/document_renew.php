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
                    <b class="page_heading text-dark">Document Renew</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#renew_table" data-filename="Document renew"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#renew_table" data-filename="Document renew"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#renew_table" data-filename="Document renew"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#renew_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#add_renew" class="text-dark font-size-footer ms-2 my-auto"> <span class="">+ New Renew</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="aitsun-modal modal fade" id="add_renew" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Renew</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
              <form method="post" enctype="multipart/form-data">
                   <?= csrf_field(); ?>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 row m-0 p-0" >

                                <div class="form-group col-md-12"> 
                                   <label class="form-label">Customer</label>
                                    <select class="form-select" name="cr_customer" required>
                                      <option value="">Choose customer</option>
                                          <?php foreach (crm_customer_array(company($user['id'])) as $crc): ?>
                                              <option value="<?= $crc['id']; ?>"><?= $crc['display_name']; ?></option>
                                          <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6 mt-3">
                
                                   <label class="form-label">Category</label>
                                    <select name="r_category" class="form-control" required="">
                                      <option value="">Select</option>
                                       <?php foreach (document_renew_category_array(company($user['id'])) as $dcat) { ?>
                                          <option value="<?= $dcat['id']; ?>"><?= $dcat['category_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-6 mt-3">
                                    <label class="form-label">Attach File <small>(optional)</small></label>
                                    <input type="file" name="r_file[]" class="form-control" id="r_file" accept="file_extension|image/*" multiple>
                                </div>

                                <div class="form-group col-md-12 mt-3">
                                    <label class="form-label">Title/Description</label>
                                    <textarea class="form-control" name="r_description" required=""></textarea>
                                
                                </div>
                                    
                                <div class="form-group col-md-6 mt-3">
                                    <label class="form-label">Reference No.</label>
                                    <input class="form-control" type="number" name="ref_no" id="ref_no" required="">
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                   <label class="form-label">Renew Period</label>
                                    <select name="renew_period" class="form-control">
                                      <option value="0">Yearly</option>
                                      <option value="1">Monthly</option>
                                    </select>
                                </div>



                                <div class="form-group col-md-6 mt-3">
                                    <label class="form-label">Due On</label>
                                    <input type="date"  name="r_due_on" class="form-control" required="">
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label class="form-label">Phone No. <small>(optional)</small></label>
                                    <input class="form-control" type="number" name="r_phone" id="r_phone">
                                </div>
                               
                                <div class="form-group col-md-12 mt-3">
                                    <label class="form-label">Notes <small>(optional)</small></label>
                                    <textarea class="form-control" name="r_notes"></textarea>
                                
                                </div>
                                        
                                <div class="col-12 mt-4">
                                    <div class="modal-footer text-start py-1">
                                        <button type="submit" class="aitsun-primary-btn" name="addnewrenew">Add Renew</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->

<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->

<div class="sub_main_page_content">
    <div class="row">

        <div class="col-md-2">
            <ul class="si_ul p-0">
                
                <div  id="display_docurenew">
                    
                    <!-- DISPLAY HERE -->
                </div>
                <li><a href="" data-bs-toggle="modal"data-bs-target="#dcate" class="mb-2 btn si_btn w-100" style="text-align:center; border-color: green;">+</a></li>
               
                <li><a class="btn btn-danger button_loader w-100 mt-2" href="<?= base_url('document_renew'); ?>?cancel=cancelled" name="cancelled" type="submit"><span class="text-white">Cancelled</span></a></li>
            </ul>  
        </div>

        <div class="col-md-10">
            <div class="aitsun_table w-100 pt-0">
                <table id="renew_table" class="erp_table sortable">
                     <thead>
                        <tr>
                            <th class="sorticon">Reference</th>
                            <th class="sorticon">Category</th>
                            <th class="sorticon">Description </th> 
                            <th class="sorticon">Due On</th> 
                            <th class="sorticon">Severty</th> 
                            <th class="sorticon">Phone</th> 
                            <th class="sorticon text-end" data-tableexport-display="none">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                            
                            <?php foreach ($document_renew as $dr): ?>
                            <tr>  
                                <td>
                                     <?php if (isset($_GET['cancel'])): ?>
                                        <?= $dr['ref_no']; ?>
                                     <?php else: ?>
                                    <span class="text-dark"><?= $dr['ref_no']; ?></span>
                                    <?php endif ?>
                                    
                                </td>
                                <td><?= doc_cat_name($dr['r_category']); ?></td>

                                <td><?= $dr['r_description']; ?> 
                                    <?php $renew_period=$dr['renew_period']; ?>
                                    <?php if($renew_period==1): ?>
                                        <small style="color:red">(monthly)</small>
                                    <?php endif ?>   
                                </td>
                                <td><?= get_date_format($dr['r_due_on'],'d M Y'); ?></td>
                                <td class="text-center" style="min-width: 115px;">
                                    <?php if ($dr['payment_status']=='received'): ?> 
                                        <a class="cursor-pointer position-relative" data-bs-toggle="modal"  data-bs-target="#edit_renew<?= $dr['id']; ?>">
                                            <span class=" received_blink">Payment received</span>
                                            
                                        </a>
                                    <?php else: ?>
                                        <span class="<?= rn_status_class($dr['r_status']); ?> rn_stat"><?= $dr['r_status']; ?></span>
                                    <?php endif ?>    
                                </td>
                                <td><?= $dr['r_phone']; ?></td>
                                <td class=" ">
                                    <div class="d-flex justify-content-end ">
                                        <?php if ($dr['r_status']=='due' || $dr['r_status']=='critical' ||$dr['r_status']=='over due'): ?>
                                             <a class="" data-bs-toggle="modal"  data-bs-target="#take_action<?= $dr['id']; ?>" ><i class="bx bx-add-to-queue me-2 " style="font-size: 17px;"></i></a>
                                        <?php endif ?>
                                        
                                         <?php if (isset($_GET['cancel'])): ?>
                                             <a class="restore_doc_renew" data-urld="<?= base_url('document_renew/restore_renew'); ?>/<?= $dr['id']; ?>"><i class="bx bx-revision text-facebook me-2" style="font-size: 19px;"></i></a>
                                        <?php else: ?>

                                        <a class="" data-bs-toggle="modal"  data-bs-target="#display_renew<?= $dr['id']; ?>" ><i class="bx bx-show-alt me-2 text-facebook" style="font-size: 17px;"></i></a>

                                        <a data-urlcr="<?= base_url('document_renew/cancel_renew'); ?>/<?= $dr['id']; ?>" class="cancel_renew" title="Cancel"><i class="bx bx-x me-2 text-warning aitsun-fw-bold" style="font-size: 17px;"></i></a>

                                        <a class=" btn-edit-dark me-2 action_btn cursor-pointer me-2 my-auto" data-bs-toggle="modal" data-bs-target="#edit_renew<?= $dr['id']; ?>"><i class="bx bxs-edit-alt"></i></a>

                                         <a class="delete btn-delete-red action_btn cursor-pointer my-auto"  data-url="<?= base_url('document_renew/delete_renew'); ?>/<?= $dr['id']; ?>"><i class="bx bxs-trash"></i></a>
                                        <?php endif ?>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="take_action<?= $dr['id']; ?>"  aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Add inventories</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            <input type="hidden" id="view_type" value="<?= 'sales' ?>">
                                            <input type="hidden" id="is_crm" value="<?= is_crm(company($user['id'])); ?>">
                                            <a class="aitsun-primary-btn me-2 click_inventory_from_renew cursor-pointer" data-from_renew="<?= $dr['id'] ?>" data-from_stage="" data-urlll="<?= base_url('invoices/create_invoice') ?>?from_renew=<?= $dr['id'] ?>">
                                                <i class="bx bx-plus mr-1"></i> Sales
                                            </a>
                                            <a class="aitsun-primary-btn me-2 click_inventory_from_renew cursor-pointer" data-from_renew="<?= $dr['id'] ?>" data-from_stage="" data-urlll="<?= base_url('invoices/create_sales_quotation') ?>?from_renew=<?= $dr['id'] ?>">
                                                <i class="bx bx-plus mr-1"></i> Sales Quotation
                                            </a>
                                            <a class="aitsun-primary-btn me-2 click_inventory_from_renew cursor-pointer" data-from_renew="<?= $dr['id'] ?>" data-from_stage="" data-urlll="<?= base_url('invoices/create_sales_order') ?>?from_renew=<?= $dr['id'] ?>">
                                                <i class="bx bx-plus mr-1"></i> Sales Order
                                            </a>
                                            <a class="aitsun-primary-btn me-2 click_inventory_from_renew cursor-pointer" data-from_renew="<?= $dr['id'] ?>" data-from_stage="" data-urlll="<?= base_url('invoices/create_sales_delivery_note') ?>?from_renew=<?= $dr['id'] ?>">
                                                <i class="bx bx-plus mr-1"></i> Delivery Note
                                            </a>
                                            <a class="aitsun-primary-btn me-2 click_inventory_from_renew cursor-pointer" data-from_renew="<?= $dr['id'] ?>" data-from_stage="" data-urlll="<?= base_url('invoices/sales_return') ?>?from_renew=<?= $dr['id'] ?>">
                                                <i class="bx bx-plus mr-1"></i> Sales Return
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="edit_renew<?= $dr['id']; ?>"  aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Renew</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form method="post" enctype="multipart/form-data">
                                         <?= csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 row m-0 p-0" >
                                                        <div class="form-group col-md-12">
                                                            <label class="form-label">Customer:</label>
                                                            <h6><?= user_name($dr['r_customer']) ?></h6>
                                                        </div>

                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Category</label>

                                                            <input type="hidden" name="rnid" value="<?= $dr['id'];?>">

                                                            <select name="r_category" class="form-control" required="">
                                                                <option value="">Select</option>
                                                                
                                                                <?php foreach (document_renew_category_array(company($user['id'])) as $dcat) { ?>
                                                                  <option value="<?= $dcat['id']; ?>" <?php if ($dcat['id']==$dr['r_category']) { echo 'selected'; } ?>><?= $dcat['category_name']; ?></option>
                                                                <?php } ?>


                                                            </select>
                                                        </div>
                                                    
                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Attach File</label>
                                                            <input type="file" name="r_file[]" class="form-control" accept="file_extension|image/*" multiple>
                                                        </div>
                                                        
                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Reference No.</label>
                                                            <input class="form-control" type="number" name="ref_no" value="<?= $dr['ref_no']; ?>" id="ref_no" required="">
                                                        </div>

                                                        <div class="form-group col-md-6 mt-3">
                                                           <label class="form-label">Renew Period</label>
                                                            <select name="renew_period" class="form-control">
                                                                <option value="0" <?php if ($dr['renew_period']=='0') {echo 'selected';} ?>>Yearly</option>
                                                                <option value="1" <?php if ($dr['renew_period']=='1') {echo 'selected';} ?>>Monthly</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Due On</label>
                                                            <input type="date"  name="r_due_on" class="form-control" value="<?= $dr['r_due_on']; ?>" required="">
                                                        </div>

                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Phone No.</label>
                                                            <input class="form-control" type="number" value="<?= $dr['r_phone'];?>" name="r_phone" id="r_phone" required="">
                                                        </div>

                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Notes</label>
                                                            <textarea class="form-control" name="r_notes" required=""><?= $dr['r_notes']; ?></textarea>
                                                        </div>

                                                        <div class="form-group col-md-6 mt-3">
                                                            <label class="form-label">Description</label>
                                                            <textarea class="form-control" name="r_description" required=""><?= $dr['r_description']; ?></textarea>
                                                        </div>

                                                        <div class="form-group col-md-12 d-none">
                                                            <label class="form-label">Status</label>
                                                            <select name="r_status" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="due" <?php if ($dr['r_status']=='due') {echo 'selected';} ?>>Due</option>
                                                                 <option value="critical" <?php if ($dr['r_status']=='critical') {echo 'selected';} ?>>Critical</option>
                                                                 <option value="over due" <?php if ($dr['r_status']=='over due') {echo 'selected';} ?>>Over Due</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 mt-4">
                                                            <div class="form-group mb-2">
                                                                
                                                                <button type="submit" class="aitsun-primary-btn" id="editrenew" name="editrenew">Update Renew</button>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </form>     
                                    </div>
                                </div>
                            </div>
            <!--  eye    -->      
                            <div class="modal fade" id="display_renew<?= $dr['id']; ?>"  aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title"><?= $dr['ref_no'];?> </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form method="post" action="<?= base_url('document_renew/edit_renew') ?>/<?= $dr['id'];?>" id="documentrenew_form" enctype="multipart/form-data">
                                        <?= csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 row m-0 p-0" >
                                                        
                                                        
                                                        <div class="form-group col-md-12 mb-2">
                                                            <h6>Notes:</h6>
                                                            <p class="text-muted" style="font-size: 14px;"><?= $dr['r_notes']; ?></p>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <h6>Attached Files:</h6>


                                                            <?php if ($dr['r_file']=='') {
                                                                   
                                                              }else{ 
                                                              ?>
                                                            <div style="background: #ebebeb;border-radius: 3px;padding: 6px;" class="mb-2">
                                                              <a target="_blank" class="text-white" href="<?php echo base_url('public/renew_docs'); ?>/<?= $dr['r_file']; ?>">
                                                                  <div class="statement_atta">
                                                                  <?= $dr['r_file']; ?>
                                                                   <!-- Share copy -->
                                                                   </div>

                                                                   <div class="pt-2">
                                                                       <a class=" btn-sm" style="font-size: 14px;" href="<?php echo base_url('public/renew_docs'); ?>/<?php echo $dr['r_file']; ?>" download><i class="lni lni-download text-youtube me-0"></i></a>

                                                                          <a class=" btn-sm" style="font-size: 14px;" href="whatsapp://send?text=<?php echo base_url('assets/renew_docs'); ?>/<?php echo $dr['r_file']; ?>" data-action="share/whatsapp/share"><i class="lni lni-whatsapp text-success me-0"></i></a> 

                                                                          <a class=" btn-sm delete" style="font-size: 14px;" data-url="<?php echo base_url('document_renew/delete_r_file'); ?>/<?php echo $dr['id']; ?>" download><i class="bx bx-trash text-youtube me-0"></i></a>

                                                                    </div>
                                                                </a>
                                                                  <!-- Share copy -->
                                                            </div>
                                                            <?php } ?>


                                                            <?php $filecount=0; foreach (renew_files($dr['id']) as $drr): $filecount++;?>

                                                            <div style="background: #ebebeb;border-radius: 3px;padding: 6px;" class="mb-2">
                                                              <a target="_blank" class=" text-white" href="<?php echo base_url('public/renew_docs'); ?>/<?= $drr['file']; ?>">
                                                                  
                                                                  <div class="statement_atta">
                                                                  <?= $drr['file']; ?>
                                                                   <!-- Share copy -->
                                                                   </div>

                                                                    <div class="pt-2">
                                                                       <a class=" btn-sm" style="font-size: 14px;" href="<?php echo base_url('public/renew_docs'); ?>/<?php echo $drr['file']; ?>" download><i class="lni lni-download text-dark me-0"></i></a>

                                                                          <a class=" btn-sm" style="font-size: 14px;" href="whatsapp://send?text=<?php echo base_url('assets/renew_docs'); ?>/<?php echo $drr['file']; ?>" data-action="share/whatsapp/share"><i class="lni lni-whatsapp text-success me-0"></i></a>

                                                                           <input type="hidden" name="Element To Be Copied" id="copy-ren<?php echo  $drr['id']; ?>" value="<?php echo base_url('assets/renew_docs'); ?>/<?php echo $drr['file']; ?>"/>

                                                                          <a class=" btn-sm copy_me_renew" data-copid="<?php echo  $drr['id']; ?>" style="font-size: 14px;"   style="cursor: pointer;">
                                                                            <span class="copiedsec">
                                                                                <i class="bx bx-copy-alt" id="cpied-copy-ren<?php echo $drr['id']; ?>"></i>
                                                                            </span>
                                                                            
                                                                          </a>

                                                                          <a class=" btn-sm delete" style="font-size: 14px;" data-url="<?php echo base_url('document_renew/delete_file'); ?>/<?php echo $drr['id']; ?>" download><i class="bx bx-trash text-youtube me-0"></i></a>
                                                                    </div>
                                                               </a>
                                                              
                                                                  <!-- Share copy -->
                                                            </div>
                                                                
                                                            <?php endforeach ?>

                                                            <?php if ($filecount<1): ?>
                                                                <?php if ($dr['r_file']==''): ?>
                                                                    <span class="text-danger">No files attached</span>
                                                                <?php endif ?>
                                                                
                                                            <?php endif ?>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-2 mt-3">
                                                            <h6>Inventories:</h6>
                                                            <?php foreach (inventories_of_renew($dr['id']) as $dr_in): ?>
                                                                <div class="bg-light-danger d-flex justify-content-between px-2 py-1 rounded-3">
                                                                    
                                                                    <div class="my-auto">
                                                                        <a href="<?php echo base_url('invoices/details'); ?>/<?= $dr_in['id']; ?>" class="href_loader">
                                                                            #<?= inventory_prefix(company($user['id']),$dr_in['invoice_type']); ?><?= $dr_in['serial_no']; ?>
                                                                        </a>
                                                                        <small>
                                                                            (<?= full_invoice_type($dr_in['invoice_type']); ?>)
                                                                            <?php if ($dr_in['invoice_type']=='sales' || $dr_in['invoice_type']=='sales_return' || $dr_in['invoice_type']=='purchase' || $dr_in['invoice_type']=='purchase_return'): ?>  
                                                                             
                                                                            <?php else: ?> 
                                                                                 <?php if (has_converted($dr_in['id'])): ?>
                                                                                     - <button class="btn btn-muted btn-sm" disabled>
                                                                                        Converted
                                                                                    </button>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>
                                                                        </small>
                                                                    </div>
                                                                    <div class="my-auto">
                                                                        
                                                                        <?php if ($dr_in['invoice_type']=='sales' || $dr_in['invoice_type']=='sales_return' || $dr_in['invoice_type']=='purchase' || $dr_in['invoice_type']=='purchase_return'): ?>  
                                                                            <?= tag_status($dr_in['paid_status']); ?>   
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div>
                                                                        <span class="bg-dark px-2 py-1 rounded-3 text-white mr-2">
                                                                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($dr_in['total']); ?>
                                                                        </span> 
                                                                        <a href="<?= base_url('invoices/edit') ?>/<?= $dr_in['id']; ?>"  class="btn my-auto href_loader btn-outline-primary btn-sm">
                                                                            <i class="bx bx-pencil"></i> 
                                                                        </a>
                                                                    </div> 
                                                                </div>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>     
                                    </div>
                                </div>
                            </div>
                                <?php endforeach ?>
                        </tbody>

                        <!-- new -->

                        <div class="aitsun-modal modal fade" id="dcate"  aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Category</h5>
                                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i></button>
                                    </div>
                                    <form method="post"  action="<?= base_url('document_renew/savecategory') ?>" id="categoryy_form">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="row">
                                              <div class="col-md-12" >
                                                <div class="form-group mb-2">
                                                    <label for="input-2" class="form-label">Category Name</label>
                                                    <input type="text" class="form-control " id="category_name" name="category_name" required>
                                                </div>

                                              </div>
                                            <div id="result"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="aitsun-primary-btn" id="addcategory" name="addcategory">Save Category</button>
                                        </div>                                    
                                    </form> 
                                </div>
                            </div>
                        </div>
                        <!-- end -->  
                </table>
            </div>
        </div>
    </div>
</div>



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('document_renew'); ?>?status=all" class="text-dark font-size-footer me-2  href_loader <?php if(session()->setFlashdata('all-msg')){ echo session()->setFlashdata('all-msg'); } ?>" name="allrn"><i class="bx bxs-file-doc ms-2"></i> <span class="my-auto">All</span></a>/
        <a href="<?= base_url('document_renew'); ?>?status=critical" class="text-dark font-size-footer me-2  href_loader <?php if(session()->setFlashdata('critic-msg')){ echo session()->setFlashdata('critic-msg'); } ?>" name="CriticalRenews"><i class="bx bxs-file-find ms-2"></i> <span class="my-auto">Critical Renews</span></a>/
        <a href="<?= base_url('document_renew'); ?>?status=over due" class="text-dark font-size-footer me-2  href_loader <?php if(session()->setFlashdata('overd-msg')){ echo session()->setFlashdata('overd-msg'); } ?>"><i class="bx bxs-file-export ms-2" name="OverDue"></i> <span class="my-auto">Over Due</span></a>/
        <a href="<?= base_url('document_renew'); ?>?status=due" class="text-dark font-size-footer me-2  href_loader <?php if(session()->setFlashdata('due-msg')){ echo session()->setFlashdata('due-msg'); } ?>" name="Due"><i class="bx bxs-file-blank ms-2"></i> <span class="my-auto">Due</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total books : <?= document_count(company($user['id']),'total'); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->




<div class="modal fade" id="againstmodal"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Against or New?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                                
            <div class="modal-body" id="display_against_crm_data">
                
            </div>
        </div>
    </div>
</div>
