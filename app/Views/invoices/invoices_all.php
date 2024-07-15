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
                    <b class="page_heading text-dark">
                        <?php if ($view_type=='sales'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'Sales'); ?>
                        <?php else: ?>
                            <?= langg(get_setting(company($user['id']),'language'),'Purchases'); ?>
                        <?php endif ?>
                    </b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#invoice_table" data-filename="Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#invoice_table" data-filename="Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#invoice_table" data-filename="Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
         
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#invoice_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a data-bs-toggle="dropdown" class="text-dark cursor-pointer font-size-footer ms-2 my-auto new-btn"> <span>+ New</span></a>
    <div class="aitsun-dropdown-menu dropdown-menu dropdown-menu-right dropdown-menu-lg-end">  
        <input type="hidden" id="view_type" value="<?= $view_type ?>">
        <input type="hidden" id="is_crm" value="<?= is_crm(company($user['id'])); ?>">
        <?php if ($view_type=='sales'): ?>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('invoices/create_invoice') ?>">
                <i class="bx bx-plus mr-1"></i> Sales
            </a>

             <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('invoices/create_proforma_invoice') ?>">
                <i class="bx bx-plus mr-1"></i> Proforma Invoice
            </a>

            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('invoices/create_sales_quotation') ?>">
                <i class="bx bx-plus mr-1"></i> Sales Quotation
            </a>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('invoices/create_sales_order') ?>">
                <i class="bx bx-plus mr-1"></i> Sales Order
            </a>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('invoices/create_sales_delivery_note') ?>">
                <i class="bx bx-plus mr-1"></i> Delivery Note
            </a>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('invoices/sales_return') ?>">
                <i class="bx bx-plus mr-1"></i> Sales Return
            </a>
        <?php else: ?>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('purchases/create_purchase') ?>">
                <i class="bx bx-plus mr-1"></i> Purchase
            </a>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('purchases/create_purchase_order') ?>">
                <i class="bx bx-plus mr-1"></i> Purchase Order
            </a>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('purchases/create_purchase_delivery_note') ?>">
                <i class="bx bx-plus mr-1"></i> Delivery Note
            </a>
            <a class="dropdown-item click_inventory cursor-pointer" data-from_stage="" data-urlll="<?= base_url('purchases/purchase_return') ?>">
                <i class="bx bx-plus mr-1"></i> Purchase Return
            </a>
        <?php endif ?>

    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

 
        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                <form method="get" class="d-flex">
                    <?= csrf_field(); ?>

                    <input type="text" name="invoice_no" class="filter-control w-100 text-ident form-control" placeholder="<?= get_setting(company($user['id']),'invoice_prefix'); ?><?= get_setting(company($user['id']),'sales_prefix'); ?>">
 
                    <select name="customer" class="salessel filter-control w-100" style="width:150px;">
                      <?php if ($view_type=='sales'){ ?>
                           <option value="">Customers</option>
                        <?php }else{ ?>
                          <option value="">Vendors</option>
                        <?php } ?>
                      
                        <option value="CASH">CASH CUSTOMER</option>
                        <?php if ($view_type=='sales'){ ?>
                            <?php foreach (customers_array(company($user['id'])) as $cs) { ?>
                                <option value="<?= $cs['id']; ?>"><?= $cs['display_name']; ?>-<?= $cs['phone']; ?></option>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php foreach (vendors_array(company($user['id'])) as $vs) { ?>
                                <option value="<?= $vs['id']; ?>"><?= $vs['display_name']; ?>-<?= $vs['phone']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
 
                    <input type="date" name="from" class="filter-control w-100" placeholder="From">
            
                    <input type="date" name="to" class="filter-control w-100" placeholder="To">
              

               
                    <Select name="payment" class="filter-control w-100">
                      <option value="">Payment</option>
                      <option value="paid">Paid</option>
                      <option value="unpaid">Unpaid</option>
                    </Select>
                

                
                    <Select name="type" class="filter-control w-100">
                      <option value="">Type</option>
                      <?php if ($view_type=='sales'): ?>
                          <option value="sales">Sales</option>
                          <option value="proforma_invoice">Proforma Invoice</option>
                          <option value="sales_quotation">Sales Quotaion</option>
                          <option value="sales_order">Sales Order</option>
                          <option value="sales_delivery_note">Delivery Note</option>
                          <option value="sales_return">Sales Return</option>
                      <?php else: ?>
                          <option value="purchase">Purchase</option>
                          <option value="purchase_order">Purchase Order</option>
                          <option value="purchase_delivery_note">Delivery Note</option>
                          <option value="purchase_return">Purchase Return</option>
                      <?php endif ?>
                    </Select>
         

                   
                    <button class="href_long_loader btn-dark btn-sm">
                        <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
                    </button>
                     

                    <a class=" btn-outline-dark btn btn-sm" href="<?php if ($view_type=='sales'): ?><?= base_url('invoices/sales') ?><?php else: ?><?= base_url('purchases/purchases') ?><?php endif ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                  
                  
                </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="invoice_table" class="erp_table sortable">
             <thead>
                <tr> 
                    <th class="sorticon">Inv. no.</th>
                    <th class="sorticon">Date</th>
                    <th class="sorticon">Customer/Vendor</th>
                    <th class="sorticon">Type</th>
                    <th class="sorticon">Status</th>
                    <th class="sorticon">Amount</th>
                    <th class="sorticon">Paid</th>
                    <th class="sorticon">Due</th>
                    <th class="sorticon">From</th>
                    <th class="sorticon" data-tableexport-display="none">Action</th>
                </tr>
             
             </thead>
              <tbody>
              
                   <?php $icount=0; $total_amount=0; $total_paid_amount=0; $total_due_amount=0; foreach ($all_invoices as $di): $icount++; ?>
                    <tr <?php if ($di['deleted']!=0): ?>style="background: #ff000040;" data-tableexport-display="none" <?php endif ?> class="in_pay_tr"> 
                        <td>
                            <a href="<?php if ($di['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $di['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>" class="aitsun_link <?php if ($di['deleted']==0): ?>href_loader<?php endif ?>" <?php if ($di['deleted']!=0): ?>onclick="popup_message('error','Failed','This is deleted, You cannot open this!');"<?php endif; ?>>
                                #<?= inventory_prefix(company($user['id']),$di['invoice_type']); ?><?= $di['serial_no']; ?></a>
                            <?php if ($di['deleted']==4): ?>
                                <small class="text-danger">(Cancelled)</small>
                            <?php endif ?>
                            <?php if ($di['deleted']==1): ?>
                                <small class="text-danger">(Deleted)</small>
                            <?php endif ?>
                            
                        </td>
                        <td><?= get_date_format($di['invoice_date'],'d M Y'); ?></td>
                        <td>
                          <a href="<?php if ($di['deleted']==0): ?><?php echo base_url('invoices/details'); ?>/<?= $di['id']; ?><?php else: ?>javascript:void(0);<?php endif ?>" class="aitsun_link <?php if ($di['deleted']==0): ?>href_loader<?php endif ?>" <?php if ($di['deleted']!=0): ?>onclick="popup_message('error','Failed','This is deleted, You cannot open this!');"<?php endif; ?>>

                           <?php if ($di['customer']!='CASH'): ?>
                            <?=  user_name($di['customer']); ?>
                              
                            <?php elseif ($di['alternate_name']==''): ?>
                              <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                            <?php elseif ($di['alternate_name']=='CASH CUSTOMER'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> 

                            <?php else: ?>
                            <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $di['alternate_name']; ?> )
                            <?php endif ?>

                          </a>
                      </td>
                      <td>
                        <span class="text-capitalize"><?= full_invoice_type($di['invoice_type']); ?></span>
                        <?php if ($di['deleted']==0): ?>
                        <?php if ($di['invoice_type']=='sales_quotation'): ?>
                            <?php if (!has_converted($di['id'])): ?>
                                <input type="checkbox" class="checkBoxClass_sq" name="pol_is_sq[]" value="<?= $di['id']; ?>" >
                            <?php endif ?>
                        <?php endif ?>

                        <?php if ($di['invoice_type']=='sales_order' || $di['invoice_type']=='purchase_order'): ?>
                            <?php if (!has_converted($di['id'])): ?>
                                <input type="checkbox" class="checkBoxClass_so" name="pol_is_so[]" value="<?= $di['id']; ?>" >
                            <?php endif ?>
                        <?php endif ?>
                        

                        <?php if ($di['invoice_type']=='sales_delivery_note' || $di['invoice_type']=='purchase_delivery_note'): ?>
                            <?php if (!has_converted($di['id'])): ?>
                                <input type="checkbox" class="checkBoxClass_sdn" name="pol_is_sdn[]" value="<?= $di['id']; ?>" >
                            <?php endif ?>
                        <?php endif ?>  

                        <?php if (is_crm(company($user['id']))): ?>
                            
                            <?php if (lead_of_invoice($di['id'])!='no_leads'): ?>
                                <a href="<?= base_url('crm/details'); ?>/<?= lead_of_invoice($di['id']); ?>" class="d-block text-black-50">
                                    Agnst: lead #<?= lead_of_invoice($di['id']); ?>
                                </a>
                            <?php endif ?>
                            
                        <?php endif ?>
                        <?php endif ?>

                      </td>
                      
                        <td class="noExl text-center">
                            <?php if ($di['deleted']==0): ?>
                            <?php if ($di['invoice_type']=='sales' || $di['invoice_type']=='sales_return' || $di['invoice_type']=='purchase' || $di['invoice_type']=='purchase_return'): ?>


                                <?php if ($di['paid_status']=='paid'): ?>
                                    <a href="<?php echo base_url('fees_and_payments/payments'); ?>/<?= $di['id']; ?>">
                                    <div class="badge rounded-pill text-success bg-light-success text-uppercase"><i class="bx bxs-circle me-1"></i>Paid</div>
                                    </a>
                                <?php endif ?>

                                <?php if ($di['paid_status']=='unpaid'): ?>

                                    <div class="position-relative">
                                        <div class="badge rounded-pill text-danger bg-light-danger text-uppercase in_pay_hide"><i class="bx bxs-circle me-1"></i>Unpaid</div>
                                        <a href="<?php echo base_url('fees_and_payments/payments'); ?>/<?= $di['id']; ?>" class="btn btn-sm btn-success in_pay_instant py-1 no_loader ajax_page cursor-pointer text-white href_loader px-3">Pay</a>
                                    </div>
                                <?php endif ?>

                                



                            <?php else: ?>
                                <?php if (has_converted($di['id'])): ?>
                                    <button class="btn btn-muted btn-sm" disabled>
                                        Converted
                                    </button>
                                <?php else: ?>


                                    <?php if ($di['invoice_type']=='sales_delivery_note'): ?>
                                    <a href="<?= base_url('invoices/convert_to_sale'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">
                                            To Sale
                                    </a>
                                    <?php elseif ($di['invoice_type']=='sales_order'): ?>
                                    <a href="<?= base_url('invoices/convert_to_sale_delivery_note'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">To Sales delivery note
                                    </a>
                                    <?php elseif ($di['invoice_type']=='sales_quotation'): ?>
                                        <a href="<?= base_url('invoices/convert_to_sale'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">
                                                To Sale
                                        </a>
                                    <a href="<?= base_url('invoices/convert_to_sale_order'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">
                                       To Sales Order  
                                    </a>
                                    <?php elseif ($di['invoice_type']=='proforma_invoice'): ?>
                                        <a href="<?= base_url('invoices/convert_to_sale'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">
                                                To Sale
                                        </a>
                                    <?php elseif ($di['invoice_type']=='purchase_order'): ?>
                                    <a href="<?= base_url('purchases/convert_to_purchase_delivery_note'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">
                                       To Purchase Delivery Note  
                                    </a>
                                    <?php elseif ($di['invoice_type']=='purchase_delivery_note'): ?>
                                    <a href="<?= base_url('purchases/convert_to_purchase'); ?>/<?= $di['id']; ?>" class="btn btn-outline-dark href_loader btn-sm">To Purchase
                                    </a>
                                    <?php endif ?>



                                <?php endif; ?>
                            <?php endif; ?>
                            <?php endif ?>

                            
                        </td>
                        <td class="text-right" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            
                             
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?> 

                            <?php if ($di['deleted']==0): ?>
                                <?php $total_amount+=aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                            
                            
                        </td>

                         <td class="text-right text-success" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            
                            <?php if (!has_converted($di['id']) || $di['invoice_type']!='proforma_invoice'): ?>
                             <?php if ($di['invoice_type']=='sales' || $di['invoice_type']=='proforma_invoice' || $di['invoice_type']=='sales_return' || $di['invoice_type']=='purchase' || $di['invoice_type']=='purchase_return'): ?> 
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?> 

                            <?php if ($di['deleted']==0): ?>
                                <?php $total_paid_amount+=aitsun_round($di['paid_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                            <?php endif ?>
                            <?php endif; ?>
                            
                            
                        </td>

                        <td class="text-right text-danger" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>

                            <?php if (!has_converted($di['id']) || $di['invoice_type']!='proforma_invoice'): ?>
                                   
                            <?php if ($di['invoice_type']=='sales' || $di['invoice_type']=='proforma_invoice' || $di['invoice_type']=='sales_return' || $di['invoice_type']=='purchase' || $di['invoice_type']=='purchase_return'): ?> 
                                <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                <?php if ($di['deleted']==0): ?>
                                    <?php $total_due_amount+=aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                <?php endif ?>
                            <?php else: ?>
                                 
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= $di['bill_from'] ?>
                        </td>
                       
                        <td class="position-relative noExl" data-tableexport-display="none">

                            <?php if ($di['deleted']==0): ?>
                            
                           
                            <?php if($di['customer'] != 'CASH'){ ?>
                           
                             
                                <button type="button" class="btn  btn-sm " data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-share-alt"></i></button>

                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li>
                                        <a class="mr-4 dropdown-item" data-bs-toggle="modal" data-bs-target="#email<?= $di['id']; ?>" href="#">
                                            <i class="bx bx-mail-send"></i>
                                            Email
                                        </a>
                                    </li>
                                    <li>
                                        <a class="ml-4 dropdown-item whatsapp_share" data-invoice_id="<?= $di['id'];?>" aria-label="Chat on WhatsApp" target="_blank"><i class="lni lni-whatsapp" ></i> WhatsApp</a>
                                    </li>
                                </ul>
                                <?php } ?>

                                <!-- Small modal -->

<!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal fade" id='email<?= $di['id']; ?>'  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
                <label for="to-input">To</label>
                <input type="email" class="form-control" id="emailto<?= $di['id']; ?>"  placeholder="To" value="<?= user_email($di['customer']); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group">
                <label for="subject-input">Subject</label>
                <input type="text" class="form-control" id="subject<?= $di['id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
            </div>
            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" value="" id='message<?= $di['id']; ?>' rows="10">
Dear <?php if($di['customer'] == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name($di['customer']);}  ?>,

<?php foreach (my_company(company($user['id'])) as $cmp) { ?>
    <?= $cmp['company_name']; ?> <?php } ?>truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['total']); ?> 
Due Amount: <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount']); ?>




Thanks and Regards
<?php foreach (my_company(company($user['id'])) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>

                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mt-2">
                    <button class="btn btn-primary waves-effect waves-light inventory_email" data-id="<?= $di['id']; ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
            </div>

      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->



<!-- /////////////////////////////////////////SMS//////////////////////////////////////////////////////// -->

<div class="modal fade" id='sms<?= $di['id']; ?>'  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send SMS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form method="post" action="<?= base_url('invoices/message') ?>">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="to-input">Mobile Number</label>
                <input type="number" class="form-control" name="phone" placeholder="Mobile Number" value="<?= user_phone($di['customer']); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" name="smsmessage" rows="5">
Dear <?php if($di['customer'] == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name($di['customer']);}  ?>,

We at <?php foreach (my_company(company($user['id'])) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?> truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbolfor_sms(company($user['id'])); ?> <?= $di['total']; ?> 
Due Amount: <?= currency_symbolfor_sms(company($user['id'])); ?> <?= $di['due_amount']; ?>


Thanks & Regards
<?php foreach (my_company(company($user['id'])) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>


                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mb-0 text-center d-block">
                <button type="submit" name="sendsms" class="btn btn-primary waves-effect waves-light">Send</button>

                   
            </div>
</form>
      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////END SMS//////////////////////////////////////////////////////// -->

   

<a href="<?php echo base_url('invoices/edit') ?>/<?= $di['id']; ?>"  class="href_loader px-2">
                                <i class="bx bx-pencil"></i> 
                            </a>

 
           
        <a data-url="<?php echo base_url() ?>/invoices/delete/<?= $di['id']; ?>" class="delete text-danger px-2">
            <i class="bx bxs-trash-alt"></i> 
        </a>


                          <?php endif ?>  
                        </td>
                      </tr>




                            <?php endforeach; ?>
                    <?php if ($icount<1): ?>
                        <tr>
                            <td class="text-center" colspan="9">
                                <span class="text-danger">
                                    No 
                                    <?php if ($view_type=='sales'): ?>
                                        <?= langg(get_setting(company($user['id']),'language'),'Sales'); ?>
                                    <?php else: ?>
                                        <?= langg(get_setting(company($user['id']),'language'),'Purchases'); ?>
                                    <?php endif ?> 
                            </span>
                            </td>
                        </tr>
                    <?php endif ?>
                    
                 
                 
              </tbody>

              <tfoot>
                <tr>  
                    <td colspan="5"><b>Total</b></td>
                    <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>

                    <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_paid_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                    <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_due_amount,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                    <td class="" data-tableexport-display="none"></td>
                </tr>
             
             </tfoot>
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
     <div>
        <a href="<?= base_url('invoice_settings/sales')?>" class="text-dark font-size-footer"><i class="bx bx-cog"></i> <span class="my-auto">Invoice Settings</span></a>
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
                                
            <div class="modal-body">  
                <div class="position-relative search-bar-box w-100 mb-3">
                    <input type="text" class="form-control search-control" name="product_name" placeholder="Type to search..." autocomplete="off" id="agaist_search">
                    <span class="position-absolute top-50 search-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                <div id="display_against_crm_data">
                    
                </div>
                
            </div>

        </div>
    </div>
</div>
