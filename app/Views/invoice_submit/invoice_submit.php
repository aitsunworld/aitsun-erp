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
                    <b class="page_heading text-dark">Invoice Submit</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#invoice_submit" data-filename="Invoice Submit"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#invoice_submit" data-filename="Invoice Submit"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#invoice_submit" data-filename="Invoice Submit"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#invoice_submit"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#submit_invoice_modal" class="text-dark font-size-footer ms-2 my-auto"> <span class="">+ Submit Invoice</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

 

    <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
              <form method="get" class="d-flex">
                <?= csrf_field(); ?>

                  <input type="text" name="display_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?>" class="form-control filter-control ">
                
 
                  <select class="form-control" name="party_type">
                      <option value="">Type</option>
                      <option value="customer">Customer</option>
                      <option value="vendor">Vendor</option>
                      <option value="delivery">Delivery</option>
                      <option value="seller">Seller</option>
                  </select> 


                     <select class="form-control" name="responsible_person">
                          <option value="" selected>Choose</option>
                          <?php foreach (all_branches($user['id']) as $alb): ?>
                              <?php foreach (admin_array($alb['id']) as $ads): ?>
                                  <option value="<?= $ads['id']; ?>"><?= $ads['display_name']; ?></option>
                              <?php endforeach ?>
                          <?php endforeach ?>
                          <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                              <option value="<?= $flr['id']; ?>"><?= $flr['display_name']; ?></option>
                          <?php endforeach ?>
                    </select>

                    <select class="form-control" name="status">
                        <option value="">Status</option>
                        <option value="pending">Pending</option>
                        <option value="submited to customer">Submited to customer</option>
                        <option value="received from customer">Received from customer</option>
                        <option value="scanned">Scanned</option>
                        <option value="cancelled">Cancelled</option> 
                    </select>

                    <Select name="received" class="form-control">
                      <option value="">Scan status</option>
                      <option value="1">Received</option>
                      <option value="0">Not received</option>
                    </Select>
                 
                 
                  <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                  <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('invoice_submit') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                
                
              </form>
            <!-- FILTER -->
        </div>  
    </div>


    <!-- add submit invoice form -->

<div class="aitsun-modal modal fade aitsun-model" id="submit_invoice_modal"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>       
                <div class="modal-body">
                    <div class="row"> 
                        <div class="col-md-12" >
                            <div class="row"> 
                                <div class="form-group col-md-12 mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label for="cr_customer" class="my-auto font-weight-semibold">Customers</label>
                                        <a class="btn btn-sm btn-secondary collapsed" style="padding:0 10px;" data-bs-toggle="collapse" data-bs-target="#collapseTwo" id="coll_cus_form" aria-expanded="false" aria-controls="collapseTwo">+</a>
                                    </div>

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item border-0">
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body px-0 py-1">
                                        <!-- //////////////+ CUSTOMER FORMMMMM/////////////////// -->
                                                    <form method="post" id="add_cust_form" action="<?= base_url('customers/save_customer'); ?>">
                                                        <?= csrf_field(); ?>
                                                
                                                          <div class="row">

                                                              
                                                           
                                                            <div class="col-md-12 row m-0 p-0" >
                                                                  <input type="hidden" name="withajax" id="withajax" value="0">
                                                                   <div class=" col-md-6 mb-2">

                                                                    <label for="input-1" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?></label>
                                                                    <input type="text" class="form-control modal_inpu" name="display_name" id="display_name">
                                                                   </div>

                                                                   <div class=" col-md-6 mb-2">
                                                                    <label for="input-3" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Email/Username'); ?> </label>
                                                                    <input type="text" class="form-control modal_inpu" name="email" id="email">
                                                                   </div>

                                                                   <div class=" col-md-6 mb-2 d-none">
                                                                    <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact Name'); ?></label>
                                                                    <input type="text" class="form-control modal_inpu" name="contact_name" id="contact_name">
                                                                   </div>

                                                                   <div class=" col-md-6 mb-2">
                                                                    <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Party Type'); ?></label>
                                                                    <select class="form-control" name="party_type" id="party_type">
                                                                        <option value="customer">Customer</option>
                                                                        <option value="vendor">Vendor</option>
                                                                    </select>
                                                                   </div>

                                                                   <div class=" col-md-6 mb-2">
                                                                    <label for="input-2" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Contact'); ?></label>
                                                                    <input type="text" class="form-control modal_inpu" name="phone" id="phone">
                                                                   </div>
                                                                   
                                                                   <div class=" col-md-6 mb-2 d-none">
                                                                    <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Website'); ?></label>
                                                                    <input type="text" class="form-control modal_inpu" name="website" id="website">
                                                                   </div>

                                                                 

                                                                   <div class=" col-md-6 mb-2">
                                                                    <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'GST/VAT No'); ?></label>
                                                                     
                                                                     <input type="text" class="form-control modal_inpu" name="gstno" id="gst_input" value="" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$">
                                                                   </div>

                                                                   <div class=" col-md-6 mb-2">
                                                                    <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'State'); ?></label>
                                                                     
                                                                     <div class="position-relative" id="layerer">
                                                                         
                                                                          <select class="form-select modal_inpu" name="billing_state" id="state_select_box">
                                                                              <option value="">Choose</option>
                                                                              <?php foreach (states_array(company($user['id'])) as $st): ?>
                                                                                  <option value="<?= $st ?>" ><?= $st ?></option>
                                                                              <?php endforeach ?>
                                                                          </select>
                                                                      </div>
                                                                   </div>

                                                                   <div class=" col-md-8 mb-2">
                                                                       <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Opening Balance'); ?></label>
                                                                  
                                                                      <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="opening_balance">
                                                                    </div>


                                                                    <div class=" col-md-4  mb-2">
                                                                        <label>Type</label>
                                                                      <select class="form-control" name="opening_type" id="opening_type">
                                                                          <option value="">To Collect</option>
                                                                          <option value="-">To Pay</option>
                                                                      </select>

                                                                    </div>

                                                                   <div class=" col-md-12  mb-3">
                                                                    <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Address'); ?></label>
                                                                    <textarea class="form-control modal_inpu" name="billing_address" id="billing_address" cols="5"></textarea>
                                                                   </div>

                                                                   <div id="errrr" class=" col-md-12 text-danger"></div>

                                                                   <div class=" modal-footer">
                                                                    <button type="button" class="aitsun-primary-btn" name="add_customer" data-action="<?= base_url('customers'); ?>" id="add_customer_ajax"><?= langg(get_setting(company($user['id']),'language'),'Save Customer'); ?></button>
                                                                   </div>
                                                                      
                                                            </div>
                                                          </div>
                                                     
                                                      </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                    <!-- //////////////submit invoice FORMMMMM/////////////////// -->

                                    <form method="post" action="<?= base_url('invoice_submit/add_invoice') ?>">
                                        <?= csrf_field(); ?>

                                        <div class="row">
                                            <div class="form-group col-md-12 mb-2">
                                                <select class="form-select form-control" name="customer" id="cr_customer_select" required>
                                                  <option value="">Choose customer</option>
                                                  <?php foreach (crm_customer_array(company($user['id'])) as $crc): ?>
                                                  <option value="<?= $crc['id']; ?>"><?= $crc['display_name']; ?></option>
                                                  <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="input-1" class="font-weight-semibold"><?= langg(get_setting(company($user['id']),'language'),'Invoice date'); ?></label>
                                                <input type="date" name="invoice_date" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="input-1" class="font-weight-semibold"><?= langg(get_setting(company($user['id']),'language'),'Invoice No.'); ?></label>
                                                <input type="text" name="invoice_number" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="input-1" class="font-weight-semibold"><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                                <input type="number" step="any" name="amount" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="input-1" class="font-weight-semibold"><?= langg(get_setting(company($user['id']),'language'),'Responsible person'); ?></label>
                                                <select class="form-control form-select " name="responsible_person" required>
                                                      <option value="" selected>Choose</option>
                                                      <?php foreach (all_branches($user['id']) as $alb): ?>
                                                          <?php foreach (admin_array($alb['id']) as $ads): ?>
                                                              <option value="<?= $ads['id']; ?>"><?= $ads['display_name']; ?></option>
                                                          <?php endforeach ?>
                                                      <?php endforeach ?>
                                                      <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                                                          <option value="<?= $flr['id']; ?>"><?= $flr['display_name']; ?></option>
                                                      <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="input-1" class="font-weight-semibold"><?= langg(get_setting(company($user['id']),'language'),'Status'); ?></label>
                                                <select class="form-control form-select" name="status" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="submited to customer">Submited to customer</option>
                                                    <option value="received from customer">Received from customer</option>
                                                    <option value="scanned">Scanned</option>
                                                    <option value="cancelled">Cancelled</option> 
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12 mb-2">
                                                <button type="submit" class=" aitsun-primary-btn">Save</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="invoice_submit" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Customer</th>
                    <th class="sorticon">Resp person</th>
                    <th class="sorticon">Invoice date </th> 
                    <th class="sorticon">Invoice no</th> 
                    <th class="sorticon">Amount</th> 
                    <th class="sorticon">Status</th> 
                    <th class="sorticon">Recieve Status</th> 
                    <th class="sorticon" data-tableexport-display="none">Recieved</th>
                    <th class="sorticon" data-tableexport-display="none">Action</th> 

                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($submitted_invoices as $pmt) { $data_count++; ?>
                  <tr>
                    <td><?= user_name($pmt['customer_id']) ?></td>
                    <td><?= user_name($pmt['responsible_person']) ?></td>
                    <td><?= get_date_format($pmt['invoice_date'],'d M Y'); ?></td> 
                    <td><?= $pmt['invoice_number']; ?></td> 
                    <td><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($pmt['amount'],get_setting(company($user['id']),'round_of_value')); ?></td> 
                    
                    <td>
                        <?php  
                            if ($pmt['status']=='submited to customer'){
                                $bg_class='bg-info';
                            }elseif($pmt['status']=='received from customer'){
                                $bg_class='bg-secondary';
                            }elseif($pmt['status']=='scanned'){
                                $bg_class='bg-success';
                            }elseif($pmt['status']=='cancelled'){
                                $bg_class='bg-danger';
                            }else{
                                $bg_class='bg-warning';
                            }
                        ?>
                        <span class=" px-2 rounded badge <?= $bg_class; ?>" >
                            <?= ucfirst($pmt['status']) ?>
                        </span> 
                    </td> 
                    <td>
                        <?php if ($pmt['received']==1): ?>
                            Received
                        <?php else: ?>
                            Not Received
                        <?php endif ?>
                    </td>
                    <td class="text-center" data-tableexport-display="none">
                        <?php  if (check_permission($user['id'],'manage_invoice_submit')==true || $user['u_type']=='admin'): ?>
                            <?php if ($pmt['received']!='1'): ?>     

                                <div class="form-switch">
                                    <input class="form-check-input me-3 select_submit_status" type="checkbox"  data-id="<?= $pmt['id']; ?>" value="1" <?php if ($pmt['received']=='1') {echo 'checked';} ?> style="width: 36px;height: 18px;"> 
                               </div>
                            <?php endif ?>

                        <?php endif ?>

                        <td class="text-center">
                            <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#edit_submit<?= $pmt['id']; ?>"><i class="bx bxs-edit-alt"></i></a>
                            
                            <a class="delete_ex_payment btn-delete-red action_btn cursor-pointer"  data-url="<?= base_url('invoice_submit/delete_invoice'); ?>/<?= $pmt['id']; ?>"><i class="bx bxs-trash"></i>
                            </a>
                        </td>


                <!-- /////////////////////////EDIT MODAL //////////////////////////////-->
                                        <div class="modal fade" id="edit_submit<?= $pmt['id']; ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="book_editLabel" aria-hidden="true" >
                                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content text-start">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="book_editLabel">Edit book</h5>
                                                    <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <form action="<?= base_url('invoice_submit/edit_invoice') ?>/<?= $pmt['id']; ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="row"> 

                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="input-1" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Customer'); ?></label>
                                                                <select class="form-select" name="customer" required>
                                                                  <option value="">Choose customer</option>
                                                                  <?php foreach (crm_customer_array(company($user['id'])) as $crc): ?>
                                                                      <option value="<?= $crc['id']; ?>" <?php if($pmt['customer_id']==$crc['id']){echo 'selected';} ?>><?= $crc['display_name']; ?></option>
                                                                  <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="input-1" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Invoice date'); ?></label>
                                                                <input type="date" name="invoice_date" class="form-control" value="<?= $pmt['invoice_date']; ?>" required>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="input-1" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Invoice No.'); ?></label>
                                                                <input type="text" name="invoice_number" class="form-control" value="<?= $pmt['invoice_number']; ?>" required>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="input-1" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></label>
                                                                <input type="number" step="any" name="amount" class="form-control" value="<?= $pmt['amount']; ?>" required>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="input-1" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Responsible person'); ?></label>
                                                                <select class="form-select" name="responsible_person" required>
                                                                      <option value="" selected>Choose</option>
                                                                      <?php foreach (all_branches($user['id']) as $alb): ?>
                                                                          <?php foreach (admin_array($alb['id']) as $ads): ?>
                                                                              <option value="<?= $ads['id']; ?>" <?php if($pmt['responsible_person']==$ads['id']){echo 'selected';} ?>><?= $ads['display_name']; ?></option>
                                                                          <?php endforeach ?>
                                                                      <?php endforeach ?>
                                                                      <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                                                                          <option value="<?= $flr['id']; ?>" <?php if($pmt['responsible_person']==$flr['id']){echo 'selected';} ?>><?= $flr['display_name']; ?></option>
                                                                      <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="input-1" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Status'); ?></label>
                                                                <select class="form-select" name="status" required>
                                                                <option value="pending" <?php if($pmt['status']=='pending'){echo 'selected';} ?>>Pending</option>
                                                                <option value="submited to customer" <?php if($pmt['status']=='submited to customer'){echo 'selected';} ?>>Submited to customer</option>
                                                                <option value="received from customer" <?php if($pmt['status']=='received from customer'){echo 'selected';} ?>>Received from customer</option>
                                                                <option value="scanned" <?php if($pmt['status']=='scanned'){echo 'selected';} ?>>Scanned</option>
                                                                <option value="cancelled" <?php if($pmt['status']=='cancelled'){echo 'selected';} ?>>Cancelled</option> 
                                                                </select>
                                                            </div>
                                                        </div>
                                                      <div class="text-start py-1">
                                                        <button type="submit" class="aitsun-primary-btn">Save</button>
                                                      </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>

                                    <!-- /////////////////////////EDIT MODAL END//////////////////////////////-->

                                    </div>
                                
                    </td>
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="9">
                            <span class="text-danger">No Data</span>
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
        <span class="m-0 font-size-footer">Total invoices : <?= count_submit(company($user['id']),'total'); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->