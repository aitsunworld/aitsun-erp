<!-- ////////////////////////// TOP BAR START ///////////////////////// -->

 <?php
    $report_date=get_date_format(now_time($user['id']),'d M Y');
    $customer_name='';
    $from='';
    $to='';

   if ($_GET) { 

        if (isset($_GET['accounts'])) {
            if (!empty($_GET['accounts'])) {
                $customer_name=user_name($_GET['accounts']).' -';
            } 
        }

        if (isset($_GET['from'])) {
            $from=$_GET['from'];
        }

        if (isset($_GET['to'])) {
            $to=$_GET['to'];
        }

        if (!empty($from) && empty($to)) {
            $report_date=get_date_format($from,'l').' - '.get_date_format($from,'d M Y');
        }
        if (!empty($to) && empty($from)) {
            $report_date=get_date_format($to,'l').' - '.get_date_format($to,'d M Y');
        }
        if (!empty($to) && !empty($from)) {
            $report_date=''.get_date_format($from,'d M Y').' to '.get_date_format($to,'d M Y');
        }

     }else{
        $report_date='Today - '.get_date_format(now_time($user['id']),'d M Y');
     }
?>



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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Day End Summary</b>
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
<div class="toolbar d-flex justify-content-between filter_load">
    <div>
        <?= $customer_name ?> <?= $report_date; ?>
    </div>
    <form>
        
        <label>Party</label>
        <div class="aitsun_select position-relative d-inline-flex" style="height: 24px; min-width:250px; margin: auto;">                            
            <input type="text" class="aitsun-datebox d-none " style="min-width:250px;" data-select_url="<?= base_url('selectors/all_parties'); ?>">
            <a class="select_close d-none" style="top:-5px; color: black;"><i class="bx bx-x"></i></a>
            <select class="form-select" name="accounts" style="margin: auto; min-width:250px; height: 24px; padding: 0;">
                <option value="">Search party</option> 
               
            </select>
            <div class="aitsun_select_suggest">
            </div>
        </div> 

        <label>From</label> 
        <input type="date" class="aitsun-datebox datepicker-input my-auto ms-2" name="from" placeholder="Pick a date">

        <label>To</label>
        <input type="date" class="aitsun-datebox datepicker-input my-auto ms-2" name="to" placeholder="Pick a date">

        <button class="aitsun-primary-btn-topbar" type="submit"><i class="bx bx-check"></i> Apply</button>
    </form>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

 

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content " id="day_end_summary_page">
    <div class="aitsun-row pb-5">

        <div class="col-md-6">
            <div class="row ">
                <div class="col-md-6 ">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content sales_bg">
                            <div class="mb-4 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= round(get_inventories_summary($user['id'],'sales','quantity','',$from,$to,$customer_name)); ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> N/A </span> 
                                    <p class="text-white">Total Sales</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="mx-3">
                            <div class="card mb-0 border p-3 mini-stats-desc">
                                <div class="d-flex">
                                    <h6 class="my-auto">Sales Value</h6>
                                    <h5 class="mb-0 ms-auto mt-0"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales','value','total',$from,$to,$customer_name); ?></h5>
                                </div> 
                                <div class="d-flex mt-2">
                                    <h6 class="my-auto">Outstanding</h6>
                                    <h5 class="mb-0 ms-auto mt-0 text-danger"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales','value','due_amount',$from,$to,$customer_name); ?></h5>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 ">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content purchase_bg">
                            <div class="mb-4 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= round(get_inventories_summary($user['id'],'purchase','quantity','',$from,$to,$customer_name)); ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> N/A </span> 
                                    <p class="text-white">Total Purchases</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="mx-3">
                            <div class="card mb-0 border p-3 mini-stats-desc">
                                <div class="d-flex">
                                    <h6 class="my-auto">Purchase Value</h6>
                                    <h5 class="mb-0 ms-auto mt-0"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'purchase','value','total',$from,$to,$customer_name); ?></h5>
                                </div> 
                                <div class="d-flex mt-2">
                                    <h6 class="my-auto">Outstanding</h6>
                                    <h5 class="mb-0 ms-auto mt-0 text-danger"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'purchase','value','due_amount',$from,$to,$customer_name); ?></h5>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 ">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content income_bg">
                            <div class="mb-4 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= round(get_payments_summary($user['id'],'receipt','quantity','',$from,$to,$customer_name)); ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> N/A </span> 
                                    <p class="text-white">Other Incomes</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="mx-3">
                            <div class="card mb-0 border p-3 mini-stats-desc">
                                <div class="d-flex">
                                    <h6 class="my-auto">Income Value</h6>
                                    <h5 class="mb-0 ms-auto mt-0"><?= currency_symbol(company($user['id'])) ?> <?= round(get_payments_summary($user['id'],'receipt','value','amount',$from,$to,$customer_name)); ?></h5>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 ">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content expense_bg">
                            <div class="mb-4 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= round(get_payments_summary($user['id'],'expense','quantity','',$from,$to,$customer_name)); ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> N/A </span> 
                                    <p class="text-white">Total Expenses</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="mx-3">
                            <div class="card mb-0 border p-3 mini-stats-desc">
                                <div class="d-flex">
                                    <h6 class="my-auto">Expense Value</h6>
                                    <h5 class="mb-0 ms-auto mt-0"><?= currency_symbol(company($user['id'])) ?> <?= round(get_payments_summary($user['id'],'expense','value','amount',$from,$to,$customer_name)); ?></h5>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 ">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content customer_bg">
                            <div class="mb-0 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= round(get_total_parties_data($user['id'],'customer','quantity')); ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> N/A </span> 
                                    <p class="text-white">Total Customers</p>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>



                <div class="col-md-6 ">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content customer_bg">
                            <div class="mb-0 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= round(get_total_parties_data($user['id'],'vendor','quantity')); ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> N/A </span> 
                                    <p class="text-white">Total Vendors</p>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>

                 
            </div>
        </div>

        <div class="col-md-6 px-3">
            <div class="row">
                <div class="col-md-12 pe-0">
                    <div class="card mb-3">
                        <div 
                            id="chart7"
                            data-datetimes="'<?= get_chart_data($user['id'],'datetimes',$from,$to,$customer_name) ?>'"
                            data-sales_incomes="<?= get_chart_data($user['id'],'sales_incomes',$from,$to,$customer_name) ?>"
                            data-purchase_expenses="<?= get_chart_data($user['id'],'purchase_expenses',$from,$to,$customer_name) ?>" 
                        ></div>
 

                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark" style="font-weight:400;">Cash in Hand</div>
                      <b class="text-dark" style="font-weight: bold;"><?= currency_symbol(company($user['id'])) ?> <?= cash_in_hand(company($user['id'])) ?></b>
                    </div>
                </div>

                <div class="col-md-6 pe-0">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark" style="font-weight:400;">Cash in Bank</div>
                      <b class="text-dark" style="font-weight: bold;"><?= currency_symbol(company($user['id'])) ?> <?= cash_in_bank(company($user['id'])) ?></b>
                    </div>
                </div>

                <?php 
                    $to_receive=company_balance($user['id'],'receive');
                    $to_pay=company_balance($user['id'],'pay');
                    
                     
                 ?>

                <div class="col-md-6">
                    <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-success">⇩ To Collect</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= str_replace('','', $to_receive); ?></b>
                    </div>
                </div>

                <div class="col-md-6 pe-0">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-danger">⇧ To Pay</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= str_replace('','', $to_pay); ?></b>
                    </div>
                </div>

                <div class="col-md-12 pe-0">
                   <div class="mb-3 card mini-stats ">
                        <div class="p-3 mini-stats-content products_bg">
                            <div class="mb-0 d-flex justify-content-between"> 
                                <div class=" number_box my-auto d-flex">
                                    <span class="m-auto"><?= total_products_of_company(company($user['id'])) ?></span>
                                </div> 

                                <div class=" text-end">
                                    <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> Stock value <?= currency_symbol(company($user['id'])) ?> <?= company_stock_value($user['id'],'average'); ?></span> 
                                    <p class="text-white">Total Products/Services</p>
                                </div>
                                
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 px-0">
            <div class="row">

                <div class="col-md-4">
                    <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Proforma Invoice </div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'proforma_invoice','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Sales returns</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales_return','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Sales quotations</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales_quotation','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Sales orders</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales_order','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>

                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Sales delivery notes</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales_delivery_note','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>

                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Performa invoices</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'performa_invoice','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>



                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Purchase returns</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'purchase_return','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>



                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Purchase orders</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'purchase_order','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>



                <div class="col-md-4">
                     <div class="alert alert-light d-flex justify-content-between" role="alert">
                      <div class="text-dark">Purchase delivery notes</div>
                      <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'purchase_delivery_note','value','total',$from,$to,$customer_name); ?></b>
                    </div>
                </div>

            </div>
        </div>
        

        <!-- // Inventories -->

        <div class="aitsun_table card w-100 pt-0">
            <div class="px-2 py-1">
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#inventories_table" data-filename="Inventories - <?= $customer_name ?> <?= $report_date; ?>"> 
                    <span class="my-auto">Excel</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#inventories_table" data-filename="Inventories - <?= $customer_name ?> <?= $report_date; ?>"> 
                    <span class="my-auto">CSV</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#inventories_table" data-filename="Inventories - <?= $customer_name ?> <?= $report_date; ?>"> 
                    <span class="my-auto">PDF</span>
                </a>
                 
              
                <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#inventories_table"> 
                    <span class="my-auto">Quick search</span>
                </a>
            </div>
            <table id="inventories_table" class="erp_table">
                 <thead> 
                    <tr>
                        <td colspan="7" class="text-center" >
                            
                           <b>Inventories</b> - <?= $customer_name ?> <?= $report_date; ?>

                        </td>
                    </tr>
                    <tr>
                        <th class="sorticon">Inv. no.</th>
                        <th class="sorticon">Date</th>
                        <th class="sorticon">Customer/Vendor</th>
                        <th class="sorticon">Type</th>
                        <th class="sorticon">Status</th>
                        <th class="sorticon">Amount</th>
                        <th class="sorticon">Balance</th> 
                 </thead>
                 <tbody>
                    <?php $icount=0; $total_amount=0; $total_due_amount=0;  foreach (get_inventories_summary($user['id'],'','','',$from,$to,$customer_name) as $di): $icount++; ?>
                      
                    <tr <?php if ($di['deleted']!=0): ?>style="background: #ff000040;" data-tableexport-display="none" <?php endif ?>> 
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
                      
                        <td class="noExl">
                            <?php if ($di['deleted']==0): ?>
                            <?php if ($di['invoice_type']=='sales' || $di['invoice_type']=='proforma_invoice' || $di['invoice_type']=='sales_return' || $di['invoice_type']=='purchase' || $di['invoice_type']=='purchase_return'): ?>
                                <?= tag_status($di['paid_status']); ?>
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
                        <td class="text-right text-success" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            
                             
                            <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?> 

                            <?php if ($di['deleted']==0): ?>
                                <?php $total_amount+=aitsun_round($di['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php endif ?>
                            
                            
                        </td>
                        <td class="text-right text-danger" <?php if ($di['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            <?php if ($di['invoice_type']=='sales' || $di['invoice_type']=='proforma_invoice' || $di['invoice_type']=='sales_return' || $di['invoice_type']=='purchase' || $di['invoice_type']=='purchase_return'): ?> 
                                <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                <?php if ($di['deleted']==0): ?>
                                    <?php $total_due_amount+=aitsun_round($di['due_amount'],get_setting(company($user['id']),'round_of_value')); ?>
                                <?php endif ?>
                            <?php else: ?>
                                 
                            <?php endif; ?>
                        </td>
                        
                      </tr>
                    <?php endforeach ?> 
                 </tbody> 
            </table>  
        </div>


        <!-- // other Income & Expenses -->

        <div class="aitsun_table card w-100 pt-0 mt-3">
            <div class="px-2 py-1">
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#income_expense_table" data-filename="Other Income & Expenses - <?= $customer_name ?> <?= $report_date; ?>"> 
                    <span class="my-auto">Excel</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#income_expense_table" data-filename="Other Income & Expenses - <?= $customer_name ?> <?= $report_date; ?>"> 
                    <span class="my-auto">CSV</span>
                </a>
                <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#income_expense_table" data-filename="Other Income & Expenses - <?= $customer_name ?> <?= $report_date; ?>"> 
                    <span class="my-auto">PDF</span>
                </a>
                 
              
                <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#income_expense_table"> 
                    <span class="my-auto">Quick search</span>
                </a>
            </div>
            <table id="income_expense_table" class="erp_table">
                 <thead> 
                    <tr>
                        <td colspan="8" class="text-center" >
                            
                           <b>Other income & Expenses</b> - <?= $customer_name ?> <?= $report_date; ?>

                        </td>
                    </tr>
                    <tr>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'No'); ?>. </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Customer'); ?>. </th>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Credit'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Added By'); ?></th> 
                 </thead>
                 <tbody>
                   <?php $debit_sum=0; $credit_sum=0;  foreach (other_income_expenses($user['id'],$from,$to,$customer_name) as $db):  ?> 
                    <tr>
                        <tr <?php if ($db['deleted']!=0): ?>style="background: #ff000040; opacity: 0.7;" data-tableexport-display="none" <?php endif ?>>
                          
                          <td> <?= get_date_format($db['datetime'],'d-m-Y'); ?></td>

                          <td> 
                            
                            <a href="<?php echo base_url('payments/details'); ?>/<?= $db['id']; ?>" class="aitsun_link mr-2 href_loader">
                                <?= get_setting($user['company_id'],'payment_prefix'); ?> <?= $db['serial_no']; ?>
                            </a>

                            <?php if ($db['invoice_id']>0): ?>
                                
                                (
                                    <?php if (invoice_data($db['invoice_id'],'invoice_type')=='challan'): ?>

                                         
                                          <?php if ($db['invoice_id']!=0): ?>
                                            <a href="<?php echo base_url('fees_and_payments/view_challan'); ?>/<?= $db['invoice_id']; ?>" class="aitsun_link mr-2 href_loader">
                                               <?= inventory_prefix(company($user['id']),invoice_data($db['invoice_id'],'invoice_type')) ?><?= invoice_data($db['invoice_id'],'serial_no') ?>
                                           </a>
                                        <?php endif ?>


                                    <?php else: ?>

                                        <a href="<?php echo base_url('invoices/details'); ?>/<?= $db['invoice_id']; ?>" class="aitsun_link mr-2 href_loader">

                                        <?php if ($db['bill_type']=='sales' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return' || $db['bill_type']=='purchase_return'): ?>

                                                <?= get_setting($user['company_id'],'invoice_prefix'); ?>

                                                <?php if ($db['bill_type']=='sales'): ?>
                                                    <?= get_setting($user['company_id'],'sales_prefix'); ?>
                                                  <?php elseif($db['bill_type']=='purchase'): ?>
                                                    <?= get_setting($user['company_id'],'purchase_prefix'); ?>
                                                    <?php elseif($db['bill_type']=='sales_return'): ?>
                                                    <?= get_setting($user['company_id'],'sales_return_prefix'); ?>
                                                    <?php elseif($db['bill_type']=='purchase_return'): ?>
                                                    <?= get_setting($user['company_id'],'purchase_return_prefix'); ?>
                                                  <?php endif ?>


                                                <?= serial(company($user['id']),$db['invoice_id']); ?>

                                        <?php elseif($db['bill_type']=='receipt' || $db['bill_type']=='payment' || $db['bill_type']=='expense'): ?>
                                        
                                                 
                                        <?php else: ?>
                                                   
                                        <?php endif ?>

                                   
                                        </a>


                                  <?php endif ?>
                                  )
                            <?php else: ?>
                                
                            <?php endif ?>


                            <?php if ($db['deleted']==1): ?>
                                <small class="text-danger">(Deleted)</small>
                                 <?php if (!empty($db['delete_reason'])): ?><br><?php endif ?> <span style="font-size: 12px;color: red;">Reason-<?= $db['delete_reason'] ?></span>
                            <?php endif ?>


                          </td>
                          <td>
                                <?php if ($db['bill_type']=='sales' || $db['bill_type']=='purchase_return' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return'): ?>

                                    <?php if ($db['customer']!='CASH'): ?>
                                    <?=  user_name($db['customer']); ?>

                                    <?php elseif ($db['alternate_name']!='CASH CUSTOMER'): ?>
                                    <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?> ( <?= $db['alternate_name']; ?> )

                                    <?php elseif ($db['alternate_name']=='CASH'): ?>
                                      <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>

                                    <?php else: ?>
                                        <?= langg(get_setting(company($user['id']),'language'),'CASH CUSTOMER'); ?>
                                    <?php endif ?>
                                  <?php else: ?>
                                  <?= get_group_data($db['account_name'],'group_head'); ?>
                                  <?php endif ?>



                          </td>



                          <td>
                            <?php if ($db['invoice_id']>0): ?>
                            <?php if (invoice_data($db['invoice_id'],'invoice_type')=='challan'): ?>
                                <?php if ($db['bill_type']=='receipt' || $db['bill_type']=='payment'): ?>
                                  <?= bill_type_for_daybook(get_group_data($db['account_name'],'group_head')); ?>
                                <?php elseif ($db['bill_type']=='sales' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return' || $db['bill_type']=='purchase_return'): ?>

                                    <?php if ($db['bill_type']=='sales'): ?>
                                     Paid <?= get_fees_data(company($user['id']),invoice_data($db['invoice_id'],'fees_id'),'fees_name'); ?>
                                     <?php if (!empty($db['alternate_name'])): ?>
                                         (<?= $db['alternate_name'] ?>)
                                     <?php endif ?>
                                    <?php elseif($db['bill_type']=='purchase'): ?>
                                    Purchase
                                    <?php elseif($db['bill_type']=='sales_return'): ?>
                                    Sales Return
                                    <?php elseif($db['bill_type']=='purchase_return'): ?>
                                    Purchase Return
                                  <?php endif ?>

                                 <?php else: ?>
                                     <?= get_group_data($db['account_name'],'group_head'); ?>
                                <?php endif ?>

                            <?php else: ?>
                                <?php if ($db['bill_type']=='receipt' || $db['bill_type']=='payment'): ?>
                                  <?= bill_type_for_daybook(get_group_data($db['account_name'],'group_head')); ?>
                                <?php elseif ($db['bill_type']=='sales' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return' || $db['bill_type']=='purchase_return'): ?>

                                    <?php if ($db['bill_type']=='sales'): ?>
                                     Sales
                                    <?php elseif($db['bill_type']=='purchase'): ?>
                                    Purchase
                                    <?php elseif($db['bill_type']=='sales_return'): ?>
                                    Sales Return
                                    <?php elseif($db['bill_type']=='purchase_return'): ?>
                                    Purchase Return
                                  <?php endif ?>

                                 <?php else: ?>
                                     <?= get_group_data($db['account_name'],'group_head'); ?>
                                <?php endif ?>
                            <?php endif ?>
                            <?php else: ?>
                                     <?= get_group_data($db['account_name'],'group_head'); ?>
                            <?php endif ?>
                        </td>



                          <td class="text-right text-success" <?php if ($db['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            <?php if ($db['bill_type']=='expense' || $db['bill_type']=='purchase' || $db['bill_type']=='sales_return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                               <?php if ($db['deleted']==0): ?>
                                <?php $debit_sum+=$db['amount']; ?>
                               <?php endif ?>
                            <?php else: ?>
                              
                              <?php endif ?>
                          </td>
                          <td class="text-right text-danger" <?php if ($db['deleted']!=0): ?>style="text-decoration: line-through;"<?php endif ?>>
                            <?php if ($db['bill_type']=='receipt' || $db['bill_type']=='sales' || $db['bill_type']=='purchase_return'): ?>
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                               <?php if ($db['deleted']==0): ?>
                               <?php $credit_sum+=$db['amount']; ?>
                               <?php endif ?>
                            <?php else: ?>
                              
                              <?php endif ?>
                          </td>
                          <td style=" font-size: 12px;"><?= nl2br($db['payment_note']); ?></td>
                           <td style=" font-size: 12px;"><?= user_name($db['collected_by']); ?></td>
                    </tr>
                    <?php endforeach ?>
                 </tbody> 
            </table>

 

        </div>
    </div>
</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->




<script src="<?= base_url('public') ?>/js/chartjs/apexcharts.min.js"></script>
<script src="<?= base_url('public') ?>/js/chartjs/apex-custom.js"></script>
    
          