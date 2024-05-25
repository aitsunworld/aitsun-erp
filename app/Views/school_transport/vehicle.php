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
                    <b class="page_heading text-dark">School Transport</b>
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
       <!--  <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#vehicle_table" data-filename="School Vehicles"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#vehicle_table" data-filename="School Vehicles"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#vehicle_table" data-filename="School Vehicles"> 
            <span class="my-auto">PDF</span>
        </a> -->
       

        <!-- <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#vehicle_table"> 
            <span class="my-auto">Quick search</span>
        </a> -->

        <a type="button" data-bs-toggle="modal" data-bs-target="#vehicleaddmodal" class="text-dark font-size-footer me-2"> <span class="my-auto">+ New vehicle</span></a>
    </div>

    

    
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
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('school_transport') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>

<!-- ////////////////////////// ADD STD LOCATION MODAL ///////////////////////// -->

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
<!-- ////////////////////////// ADD STD LOCATION MODAL ///////////////////////// -->





<!-- ////////////////////////// ADD STD VEHICLE MODAL  ///////////////////////// -->

<div class="modal fade" id="vehicleaddmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="vehicleaddmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleaddmodalLabel">Add vehicle</h5>    
                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_vehicle_form" action="<?= base_url('school_transport/add_vehicle'); ?>">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="font-weight-semibold" for="vehiclename">Vehicle Name</label>
                            <input type="text" class="form-control" name="vehiclename" id="vehiclename" placeholder="Vehicle Name">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label class="font-weight-semibold" for="vehiclenumber">Vehicle Number</label>
                            <input type="text" class="form-control" name="vehiclenumber" id="vehiclenumber" placeholder="Vehicle Number">
                        </div>


                        <div class="remove_service">
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="inputVendor" class="form-label my-auto">Driver <small class="font-weight-bold text-danger">*</small></label>
                                    <a class="p-0 add_driver mb-2" id="add_driver" data-proid="">+ driver</a>
                                </div>

                                <div id="brand_container_product" class="mb-2 text-end" style="display: none;">
                                    <div  class="d-flex justify-content-between">
                                         <input type="text" name="display_name" id="display_name" class="ad_u form-control" placeholder="Driver Name">
                                        <input type="text" name="contact_number" id="contact_number" class="ad_u form-control ms-4"  placeholder="Phone">
                                    </div>
                                    <button class="mr-2 adddd_unit_btn addd_driver mb-2 mt-2 " id="addd_driver" data-proid="" type="button" >Add</button>
                                </div>

                                
                                <select class="form-select single-select" name="driver" id="driver">
                                    <option value="">Select Driver</option>
                                    <?php foreach (drivers_array(company($user['id'])) as $dr): ?>
                                        <option value="<?= $dr['id']; ?>"><?= user_name($dr['id']); ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-start py-1">
                    <button type="button" class="aitsun-primary-btn" id="add_vehicle">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ////////////////////////// ADD STD VEHICLE MODAL ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="col-md-4 ">
            <?php  $data_count=0; ?>
            <?php foreach ($vehicle_data as $vh) { $data_count++; ?>
                <div class="card mb-3 card-trans me-3 bg-0">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between aitsun_table_vehicle_search">
                            <div style="min-width: 88px;">
                                <img src="<?= base_url('public')?>/images/bus.webp">
                            </div>                             
                            <div class="font-14 my-auto trans-width">
                                <span><b><?= $vh['vehicle_name'] ?> - <?= $vh['vehicle_number'] ?></b><br></span>
                                <span><?= user_name($vh['driver']) ?></span> - <span class="text-danger"><?= user_phone($vh['driver']) ?><br></span>
                            </div>

                            <div class="text-end my-auto " >
                                <a class="cursor-pointer badge bg-light text-success exp-btn mb-2" data-bs-toggle="modal" data-bs-target="#expenseaddmodal<?= $vh['id']; ?>">+ Expense</a><br>

                                <a class="me-2 cursor-pointer" data-bs-toggle="modal" data-bs-target="#editvehicle<?= $vh['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                        
                                <a class="deletevehicle text-danger cursor-pointer"  data-deleteurl="<?= base_url('school_transport/deletevehicle'); ?>/<?= $vh['id']; ?>"><i class="bx bxs-trash"></i></a>
                            </div>
                        </div>

<!-- //////////////////////////EXPENSE MODAL ///////////////////////// -->
<div class="modal fade" id="expenseaddmodal<?= $vh['id']; ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="expenseaddmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="expenseaddmodalLabel">Add Expenses</h5>    
                <button type="button" class="btn-close close_school href_loader" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="expense_invoice_form<?= $vh['id'] ?>" method="post" action="<?= base_url('voucher_entries/insert_voucher') ?>">
            <?= csrf_field() ?>

            <input type="hidden" name="vehicleid" value="<?= $vh['id'] ?>">

                <?php if ($view_method=='edit'): ?>
                    <input type="hidden" name="paaid" value="<?= $in_data['total']; ?>">
                <?php endif ?>

                <input type="hidden" name="entry_type" value="<?= $entry_type; ?>" id="entry_type<?= $vh['id'] ?>">
                <input type="hidden" name="view_method" value="<?= $view_method; ?>" id="view_method<?= $vh['id'] ?>">

                <input type="hidden" id="split_tax<?= $vh['id'] ?>" value="<?= get_setting(company($user['id']),'split_tax'); ?>">

                <input type="hidden" id="focus_element<?= $vh['id'] ?>" value="<?= get_setting(company($user['id']),'cursor_position'); ?>">

                <?php $invoice_type='receipt'; ?>
                <?php if ($entry_type=='expense'): ?>
                    <?php $invoice_type='expense'; ?> 
                <?php endif ?>

                <input type="hidden" name="invoice_type" value="<?= $invoice_type; ?>">

                <input type="hidden" name="invoice_date" id="invoice_date" class="form-control" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['voucher_date']; ?><?php else: ?><?= get_date_format(now_time($user['id']),'Y-m-d'); ?><?php endif ?>"  >

                <?php $invoice_type='receipt'; ?>
                    <?php if ($entry_type=='expense'): ?>
                    <?php $invoice_type='expense'; ?> 
                <?php endif ?>

                <input type="hidden" name="invoice_type" value="<?= $invoice_type; ?>">

                <?php 
                    $from_lead='no_lead';
                    $from_stage='no_stage';
                    if ($_GET) {
                      if (isset($_GET['from_lead'])) {
                        if (!empty($_GET['from_lead'])) {
                          $from_lead=$_GET['from_lead'];
                        }
                      }

                      if (isset($_GET['from_stage'])) {
                        if (!empty($_GET['from_stage'])) {
                          $from_stage=$_GET['from_stage'];
                        }
                      }
                      
                    }
                ?>
                    
                <input type="hidden" name="from_lead" value="<?= $from_lead; ?>">
                <input type="hidden" name="stage" value="<?= $from_stage; ?>">


                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4 mb-2">
                            <label>Select Expenses </label>
                            <select class="form-select" name="product_id[]" id="exp<?= $vh['id'] ?>">
                                <option value="">Select Expense</option>
                                <?php foreach (get_transport_data(company($user['id'])) as $ba): ?>
                                    <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                                <?php endforeach ?>
                               
                            </select>
                        </div>


                        <input type="hidden" name="product_name[]" value="">

                        <div class="form-group col-md-4 mb-2">
                            <label>Amount: </label>
                            <div class="d-flex"> 
                                <span class="my-auto me-2"><?= currency_symbol($user['company_id']); ?> </span>
                                <input type="number" step="any" class="price mb-0 form-control form-control-sm input1"  name="price[]" id="price<?= $vh['id'] ?>" data-row="" oninput="updateAmount(<?= $vh['id'] ?>)">
                            </div>
                        </div>


                        <input type="hidden" step="any" class="item_total form-control mb-0 control_ro input2" id="amount<?= $vh['id'] ?>"  name="amount[]" value=""> 

                        <input type="hidden" step="any" class="item_total form-control mb-0 control_ro input3" id="grand_total<?= $vh['id'] ?>" name="grand_total" value=""> 




                        <input type="hidden" name="sub_total" id="subtotal<?= $vh['id'] ?>" class="form-control text-right control_ro" value="<?php if ($view_method=='edit' || $view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php else: ?>0<?php endif; ?>" readonly>



                        


                        <input type="hidden" min="0" id="cash_input<?= $vh['id'] ?>" class="numpad form-control " name="cash_amount" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php endif ?>">

                        <input type="hidden" min="0" class="numpad form-control " name="cheque_amount[]" id="cheque_input<?= $vh['id'] ?>" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php endif ?>">

                        <input type="hidden" min="0" class="form-control numpad" name="bt_amount" value="<?php if ($view_method=='convert' || $view_method=='copy'): ?><?= $in_data['total']; ?><?php endif ?>" id="bt_input<?= $vh['id'] ?>">


                        <input type="hidden" class="form-control text-center form-control-sm mb-0 quantity_input numpad"  name="quantity[]" min="1" value="1">

                        


                        <div class="form-group col-md-4 mb-2">
                            <label><?= langg(get_setting(company($user['id']),'language'),'Payment Type'); ?></label>
                            <select class="form-control payment_select" name="payment_type" id="payment_type<?= $vh['id'] ?>" required>
                                    <option value="">Select Payment Type</option>
                                    <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                        <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>

                                    <?php endforeach ?>
                            </select>
                        </div>



                        <div class="mt-1">
                            <div class="my-auto">
                                <a class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#prodesc">Add Note +</a> 
                            </div>
                
                            <div id="prodesc" class="collapse">
                                <div class="accordion-body px-0 py-1">
                                    <textarea name="product_desc[]" class="keypad textarea_border form-control prodesc" style="border: 1px solid #0000002e;"></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

                <div id="mess<?= $vh['id'] ?>" class=" text-center text-danger w-100"></div>
                <div class="modal-footer text-start py-1">
                    <button type="button" class="aitsun-primary-btn submit_invoice_form" data-id="<?= $vh['id'] ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   
<!-- ////////////////////////// EXPENSE MODAL ///////////////////////// -->

<!-- ////////////////////////// EDIT VEHICLE MODEL ///////////////////////// -->

<div class="modal fade" id="editvehicle<?= $vh['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editvehicleLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h5 class="modal-title" id="editvehicleLabel">Edit Vehicle</h5>
                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="edit_vehicle_form<?= $vh['id'] ?>" action="<?= base_url('school_transport/update_vehicle') ?>/<?=$vh['id'] ?>">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label class="font-weight-semibold" for="vehiclename">Vehicle Name</label>
                            <input type="text" class="form-control" name="vehiclename" id="vehiclename" placeholder="Vehicle Name" value="<?= $vh['vehicle_name'] ?>">
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label class="font-weight-semibold" for="vehiclenumber">Vehicle Number</label>
                            <input type="text" class="form-control" name="vehiclenumber" id="vehiclenumber" placeholder="Vehicle Number" value="<?= $vh['vehicle_number'] ?>">
                        </div>


                        <div class="form-group col-md-6 mb-2">
                            <select class="form-select single-select" name="driver" id="driver">
                                <option value="">Select Driver</option>
                                <?php foreach (drivers_array(company($user['id'])) as $dr): ?>
                                    <option value="<?= $dr['id']; ?>" <?php if ($vh['driver']==$dr['id']) {echo 'selected';} ?>><?= user_name($dr['id']); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    
                    </div>
                </div>
                <div class="modal-footer text-start py-1">
                    <button type="button" class="aitsun-primary-btn edit_vechicle" data-id="<?= $vh['id'] ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ////////////////////////// EDIT VEHICLE MODEL ///////////////////////// -->
                                   
                    </div>
                </div>
            
            <?php } ?>
                    
     
            <?php if ($data_count<1): ?>
               <div class="text-center">
                    <div class="card mb-3 card-trans ms-2">
                        <div class="card-body">
                            <span class="text-danger">No Data</span>
                        </div>
                    </div>
               </div>
            <?php endif ?>
                
        </div>

           
        <div class="col-md-8">
            <div class="row">
                 <div class="aitsun_table w-100 pt-0">

                    <div class="d-flex justify-content-between">
                        <div class="px-2">
                            <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#stdlocation_table" data-filename="Student loactions"> 
                                <span class="my-auto">Excel</span>
                            </a>
                            <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#stdlocation_table" data-filename="Student loactions"> 
                                <span class="my-auto">CSV</span>
                            </a>
                            <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf"  data-table="#stdlocation_table" data-filename="Student loactions">
                                <span class="my-auto">PDF</span>
                            </a>
                             <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
                                <span class="my-auto">Filter</span>
                            </a>

                          
                            <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#stdlocation_table"> 
                                <span class="my-auto">Quick search</span>
                            </a>
                        </div>

                        <div>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#addstdlocationmodal" class="text-dark text-end font-size-footer me-2"> <span class="my-auto">+ Add</span></a>
                        </div>
                    </div>



                        
                
                    <table id="stdlocation_table" class="erp_table sortable">
                     <thead>
                        <tr>
                            <th class="sorticon">S. No</th>
                            <th class="sorticon">Student</th>
                            <th class="sorticon">Location</th> 
                            <th class="sorticon">Vehicle</th> 
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
                            <td><?= get_vehicle_data(get_products_data($stl['item_id'],'vehicle'),'vehicle_name') ?></td> 
                            
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


    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->





<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('fees_and_payments/price_table_transport'); ?>" class="text-dark font-size-footer me-2"><i class="bx bx-money ms-2"></i> <span class="my-auto">Transport price table</span></a>
    </div>


    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>


</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


    <script>
        function updateAmount(id) {
            var priceInput = document.getElementById("price" + id);
            var amountInput = document.getElementById("amount" + id);
            var totalInput = document.getElementById("grand_total" + id);

            amountInput.value = priceInput.value;
            totalInput.value = priceInput.value;

        }
        
    </script>


