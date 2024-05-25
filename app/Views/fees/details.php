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
                    <a class="href_loader" href="<?= base_url('fees_and_payments'); ?>">Fees management</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= $ft['fees_name']; ?></b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#fees_tables" data-filename="<?= $ft['fees_name']; ?> <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#fees_tables" data-filename="<?= $ft['fees_name']; ?> <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#fees_tables" data-filename="<?= $ft['fees_name']; ?> <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#fees_tables"> 
            <span class="my-auto">Quick search</span>
        </a>

        <a href="<?= base_url('fees_and_payments/price_table'); ?>" class=" text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Price table</span>
        </a>

        <a class=" text-dark font-size-footer me-2 feespay_all href_loader" href="<?= base_url('fees_and_payments/details') ?>/<?= $ft['id'] ?>">All</a>
        <a class=" text-dark font-size-footer me-2 feespay href_loader" href="<?= base_url('fees_and_payments/details'); ?>/<?= $ft['id'] ?>?status=paid">Paid (<?= total_paid_amount_students(company($user['id']),$ft['id']); ?>)</a>
        <a class=" text-dark font-size-footer me-2 feeshalf href_loader" href="<?= base_url('fees_and_payments/details'); ?>/<?= $ft['id'] ?>?status=half_paid href_loader">Half-Paid (<?= total_half_paid_amount_students(company($user['id']),$ft['id']); ?>)</a>
        <a class=" text-dark font-size-footer me-2 feespending href_loader" href="<?= base_url('fees_and_payments/details'); ?>/<?= $ft['id'] ?>?status=unpaid">Pending (<?= total_unpaid_amount_students(company($user['id']),$ft['id']); ?>)</a>

        
        
    </div>
    <div>
    <?php if ($ft['fees_type']==0): ?>

             <button class="aitsun-btn-sm btn-success my-auto  btn-sm generate_challan_for_all" data-fees_id="<?= $ft['id']; ?>">Generate Challan for all</button>

              <button class="aitsun-btn-sm btn-dark my-auto btn-sm" data-bs-toggle="modal" data-bs-target="#manual_class_challan" >Generate challan for class</button>

            <button class="aitsun-btn-sm btn-info my-auto btn-sm" data-bs-toggle="modal" data-bs-target="#manual_challan" >Generate manually</button>
        
    <?php elseif($ft['fees_type']==2): ?>
        

        

            <button class="aitsun-btn-sm btn-info my-auto btn-sm" data-bs-toggle="modal" data-bs-target="#manual_challan_custom" >Generate Custom Challan</button>

        <?php else: ?>

        <button class="aitsun-btn-sm btn-dark my-auto  btn-sm generate_for_all_transport" data-fees_id="<?= $ft['id']; ?>">Generate for all</button>

        <button class="aitsun-btn-sm btn-info my-auto btn-sm" data-bs-toggle="modal" data-bs-target="#manual_challan_for_vehicle" >Generate transport charge</button>
      
    <?php endif ?>

        <button class="aitsun-btn-sm btn-danger my-auto btn-sm d-none" id="deleteallbtn" data-feeid="<?= $ft['id']; ?>" >Delete All</button>   
    </div>

   
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="fees_tables" class="erp_table sortable">
             <thead>
                <tr>  
                    <th class="sorticon">S.No</th>
                    <th class="sorticon">Ch. no.</th>
                    <th class="sorticon">Date</th>
                    <th class="sorticon">Student</th>
                    <th class="sorticon">Paid Status</th>
                    <th class="sorticon">Amount</th>
                    <th class="sorticon">Due</th>     
                    <th class="sorticon" data-tableexport-display="none">Action </th>
                    <th class="sorticon" data-tableexport-display="none">
                        <i id="deleteinvoiceCheckAll" class="select ml-2 bx bx-plus-circle" style="font-size:20px; color: #0075ff;">
                    </th> 
                </tr> 
             </thead>
              <tbody> 
                <?php 
                    $total=0;
                    $due_amount=0;
                 ?>
                <?php $i=0; foreach ($invoices as $di): $i++; ?>
                    <tr class="pay_tr">
                        <td><?= $i; ?></td>
                        <td>
                            <a class="aitsun_link href_loader" href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>">
                                <?= inventory_prefix(company($user['id']),$di['invoice_type']); ?><?= $di['serial_no']; ?>
                            </a>
                        </td>
                        <td><?= get_date_format($di['invoice_date'],'d M Y'); ?></td>
                        <td>
                            <?php if ($di['customer']!='CASH'): ?>
                                <?=  user_name($di['customer']); ?> - <?=  class_name(current_class_of_student(company($user['id']),$di['customer'])); ?>
                            <?php elseif ($di['alternate_name']==''): ?>
                                CASH CUSTOMER
                            <?php else: ?>
                                CASH CUSTOMER
                            <?php endif ?>
                        </td>
                        <td>
                           <?php if ($di['paid_status']=='paid'): ?>
                                <span class="badge badge-pill bg-success">Paid</span>
                            <?php endif ?>

                            <?php if ($di['paid_status']=='unpaid'): ?>
                                <?php if ($di['due_amount']>0 && $di['due_amount']<$di['total']): ?>
                                    <div class="position-relative">
                                        <span class="badge badge-pill bg-warning pay_hide">Half paid</span>
                                        <a data-position=".main-content" data-active_class="active" href="<?php echo base_url('fees_and_payments/payments'); ?>/<?= $di['id']; ?>" class="btn btn-sm btn-success pay_instant py-1 no_loader ajax_page cursor-pointer text-white href_loader">Pay</a>
                                    </div>
                                <?php else: ?>
                                     <div class="position-relative">
                                        <span class="badge badge-pill bg-danger pay_hide">Unpaid</span>
                                        <a href="<?php echo base_url('fees_and_payments/payments'); ?>/<?= $di['id']; ?>" class="btn btn-sm btn-success pay_instant py-1 no_loader ajax_page cursor-pointer text-white href_loader">Pay</a>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                            
                        </td>
                        <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?></td>
                        <td><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?></td>
                         
                        <td data-tableexport-display="none">
                             <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark btn-sm href_loader"><i class="bx bx-show"></i></a>
                            <a class="btn btn-outline-danger btn-sm delete_challan_link my-auto" data-url="<?= base_url() ?>/fees_and_payments/delete_invoice/<?= $ft['id']; ?>/<?= $di['id']; ?>" data-challan_id="<?= $di['id']; ?>">
                                <i class="bx bx-trash text-danger"></i> 
                            </a>
                        </td> 
                        <td class="big_check" data-tableexport-display="none">
                            <div class="form-group mb-0">
                                <input type="checkbox" class=" checkbox checkBoxinvoiceAll checkingrollbox" name="delete_all_invoice[]" value="<?= $di['id']; ?>" data-inid="<?= $di['id']; ?>" >
                            </div>
                        </td>
                    </tr>

                    <?php 
                        $total+=$di['total'];
                        $due_amount+=$di['due_amount'];
                     ?>
                <?php endforeach ?> 

                <?php if ($i<1): ?>
                  <tr>
                    <td colspan="10" class="text-center noExl"> 
                        <span class="text-danger">No Challans</span> 
                    </td>
                  </tr>
                <?php endif ?>
              </tbody>

              <tfoot> 
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>
                         <?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total,get_setting(company($user['id']),'round_of_value')); ?>
                    </td>
                    <td>
                        <?= currency_symbol(company($user['id'])); ?><?= aitsun_round($due_amount,get_setting(company($user['id']),'round_of_value')); ?>
                    </td>    
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<div class="aitsun-modal modal fade" id="manual_class_challan">
    <div class="modal-dialog modal-dialog-scrollable modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatemodelLabel">Select class</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
            <form method="post" id="_form">
                <?= csrf_field(); ?>
                <div class=" w-100">

                    <div class="form-group">

                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required id="class_id_select">
                                <option value="">Select Class</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>


                        



                    </div>
                    
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 mb-0">
                        <button class="aitsun-primary-btn mt-3 generate_invoices" data-fees_id="<?= $ft['id']; ?>" type="button">Generate</button>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
</div>


<div class="aitsun-modal modal fade" id="manual_challan">
    <div class="modal-dialog modal-dialog-scrollable modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatemodelLabel">Select student</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
            <form method="post" id="_form">
                <?= csrf_field(); ?>
                <div class=" w-100">

                    <div class="form-group">


                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required id="student_id_select">
                                <option value="">Select student</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>


                    </div>
                    
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 mb-0">
                        <button class="aitsun-primary-btn mt-3 generate_invoice_for_student" data-fees_id="<?= $ft['id']; ?>" type="button">Generate</button>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
</div>



<div class="aitsun-modal modal fade" id="manual_challan_for_vehicle">
    <div class="modal-dialog modal-dialog-scrollable modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatemodelLabel">Select student & Location</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
            <form method="post" id="_form">
                <?= csrf_field(); ?>
                <div class="row">

                    <div class="form-group mb-3 col-md-12">

                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required id="t_student_id_select">
                                <option value="">Select student</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>

                        
                    </div>

                    <div class="form-group mb-3 col-md-12">

                        <div class="aitsun_select position-relative">
                                               
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/locations'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" required id="t_location_id_select">
                                <option value="">Select location</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>

                    </div>
                    
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 mb-0">
                        <button class="aitsun-primary-btn mt-3 generate_transport_invoice_for_student" data-fees_id="<?= $ft['id']; ?>" type="button">Generate</button>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
</div>




 <!------------------------------------------------- Modal ------------------------------------------->

 <div class="aitsun-modal modal fade" id="generatemodel">
    <div class="modal-dialog modal-dialog-scrollable modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatemodelLabel">Select Items</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
            <form method="post" id="generate_form" action="<?= base_url('fees_and_payments/generate_invoices'); ?>/<?= $ft['id']; ?>">
                <?= csrf_field(); ?>
                <div class="form-row">

                    <?php foreach (products_default_array(company($user['id'])) as $itm): ?>
                    <div class="form-group col-md-12">
                        <input type="hidden" name="item_id[]" value="<?= $itm['id']; ?>">
                        <input type="hidden" name="product_name[]" value="<?= $itm['product_name']; ?>">
                        <input type="hidden" name="product_desc[]" value="<?= $itm['description']; ?>">
                        



                         <input type="checkbox" id="radio<?= $itm['id']; ?>" class="mt-1 mr-1 checkingrollbox checkBoxmrngAll" >

            <input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="itemchecked[]" type="hidden"  value="0">

            <label for="radio<?= $itm['id']; ?>"><?= $itm['product_name']; ?></label>


                    </div>
                    <?php endforeach ?>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 mb-0">
                        <button class="aitsun-primary-btn mt-3 " id="generate_invoices" type="button">Save</button>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
</div>





 


<div class="aitsun-modal modal fade" id="manual_challan_custom">
    <div class="modal-dialog modal-dialog-scrollable modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatemodelLabel">Create challan</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
            <form method="post" id="_form_custom">
                <?= csrf_field(); ?>
                <div class=" w-100">

                    <div class="form-group">

                        <div class="d-flex">
                            <label for="for_all" class="checkbox_div me-1">
                                <span >For all</span>
                                <input type="radio" id="for_all" name="challan_for" value="for_all" class="challan_for" checked>
                            </label>
                            <label for="for_student" class="checkbox_div">
                                <span >For student</span>
                                <input type="radio" id="for_student" name="challan_for" value="for_student" class="challan_for">
                            </label>
                            
                            <label for="for_class" class="checkbox_div ms-1">
                                <span >For class</span>
                                <input type="radio" id="for_class" name="challan_for" value="for_class" class="challan_for">
                            </label> 
                        </div>

                        
                        <div class="custom_article">
                            
                            <article></article>

                            <article class="mt-3">
                                <div class="aitsun_select position-relative">
                                                       
                                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
                         
                                    <select class="form-select" name="cus_student" required id="student_id_select_custom">
                                        <option value="">Select student</option> 
                                       
                                    </select>
                                    <div class="aitsun_select_suggest">
                                    </div>
                                </div>
                              </article>

                              <article class="mt-3">
                                
                                    <div class="aitsun_select position-relative">
                                                           
                                        <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
                                        <a class="select_close d-none"><i class="bx bx-x"></i></a>
                             
                                        <select class="form-select" name="cus_class" required id="class_id_select_custom">
                                            <option value="">Select Class</option> 
                                           
                                        </select>
                                        <div class="aitsun_select_suggest">
                                        </div>
                                    </div>
                              </article>

                             
                        </div>

                        

                        <div>
                           <table class="mt-3 table table-light table-bordered">
                                <thead>
                                  <tr> 
                                    <th>Fees name</th>
                                    <th class="text-end">Amount</th>
                                    <th><button class="no_load btn btn-outline-dark add-more-custom  btn-sm" type="button"><b>+</b></button></th>
                                  </tr>
                                </thead>
                                <tbody class="after-add-more-custom">
                                    <tr class="after-add-more-custom-tr"> 
                                      <td>
                                        <input type="text" name="custom_fees_name[]" class="form-control custom_fees_name">
                                      </td>
                                      <td><input type="number" name="custom_fees_amount[]" class="text-end form-control custom_fees_amount"></td>
                                      <td class="change"><a class="btn btn-danger btn-sm no_load  remove-custom text-white"><b>-</b></a></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end"><input type="number" name="custom_total" id="custom_total" class="readonly_input text-end" value="0" readonly></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                              </table>
                        </div>

                    </div>
                    
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 mb-0">
                        <button class="aitsun-primary-btn mt-3 generate_invoice_for_student_custom" data-fees_id="<?= $ft['id']; ?>" type="button">Generate</button>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
</div>



<!------------------------------------------------- Modal ------------------------------------------->


<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">   
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 