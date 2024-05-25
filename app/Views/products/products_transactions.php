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
                <a href="<?= base_url('products'); ?>" class="href_loader">Products</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                <a href="<?= base_url('products/edit'); ?>/<?= $product_id ?>" class="href_loader"><?= get_products_data($product_id,'product_name') ?></a>
            </li>


            <li class="breadcrumb-item active" aria-current="page">
                <b class="page_heading text-dark">Transactions</b>
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

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#product_transaction_table" data-filename="<?= get_products_data($product_id,'product_name') ?> - All Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#product_transaction_table" data-filename="<?= get_products_data($product_id,'product_name') ?> - All Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#product_transaction_table" data-filename="<?= get_products_data($product_id,'product_name') ?> - All Transactions-<?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#product_transaction_table"> 
            <span class="my-auto">Quick search</span>
        </a>
        

    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">



        <div class="aitsun_secondary_tabs">
            <div class="d-flex ">
                <div class="tab active" onclick="switchTab(1)">Inventories</div>
                <div class="tab" onclick="switchTab(2)">Stock Adjustments</div>
                <div class="tab" onclick="showBothaitsun_secondary_tabs()">Show Both</div>
            </div>
        </div>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .aitsun_secondary_tabs {
              display: block; 
              margin-bottom: 10px;
              width: 100%;
          }

       .aitsun_secondary_tabs .tab {
    width: 100%;
    cursor: pointer;
    padding: 2px 10px;
    border: 1px solid #ccc;
    border-radius: 5px 5px 0 0;
    background-color: #f1f1f1;
    user-select: none;
    text-align: center;
}

        .aitsun_secondary_tabs .tab.active {
            background-color: #ce2057;
    color: white;
        }

        .tab-content {
            display: none; 
            border-radius: 0 0 5px 5px;
        }

        .tab-content.active {
            display: block;
            width: 100%;
        }

        .both_class {
            width: 50%!important;  
        }

         

        .both_class .scrolltable{ 
            overflow-x: scroll;
            background: white;
        }

        .tab_heading{
            display: none;
            color: white;
        }

        .both_class .tab_heading {
            display: block;
            background: #ce2057;
            margin: 0;
            padding: 5px 0;
        }

        .both_class table{
            white-space: nowrap;
        }

        .both_class .aitsun_table{
            border-right: 2px solid #cc2056;
            padding-bottom: 0!important;
        }
    </style>
    <div id="tab1" class="tab-content active">
        
            <div class="aitsun_table col-12 w-100 pt-0 pb-5">
                    <h6 class="text-center tab_heading">Inventories</h6>
                    <div class="scrolltable">
                    <table id="product_transaction_table" class="erp_table sortable">
                       <thead>
                        <tr>
                            <th class="sorticon" style="width:200px;">Transaction ID</th>
                            <th class="sorticon" style="width:130px;">Date</th>
                            <th class="sorticon" style="width:130px;">Type</th>
                            <th class="sorticon">Product Name</th>
                            <th class="sorticon" style="width:150px;">Quantity</th>
                            <th class="sorticon" style="width:200px;">Debit</th>
                            <th class="sorticon" style="width:200px;">Credit</th>

                        </tr>

                    </thead>
                    <tbody>
                        <?php $icount=0; $total_qty=0; $total_debit=0; $total_credit=0; foreach ($transactions as $trns): $icount++; ?>
                        <tr>
                            <td><a href="<?php echo base_url('invoices/details'); ?>/<?= $trns['invoice_id']; ?>">#<?= inventory_prefix(company($user['id']),$trns['invoice_type']); ?><?= invoice_data($trns['invoice_id'],'serial_no'); ?></a></td> 
                            <td><?= get_date_format($trns['invoice_date'],'d M Y'); ?></td>
                            <td><span class="text-capitalize"><?= $trns['invoice_type']; ?></span></td>
                            <td><?= $trns['product']; ?></td>
                            <td><?= $trns['quantity']; ?> <?= unit_name($trns['in_unit']); ?>
                                <?php $total_qty+=$trns['quantity']; ?>
                            </td>
                            <td>
                                <?php if ($trns['invoice_type']=='purchase' || $trns['invoice_type']=='sales_return'): ?>
                                    <span class="text-danger aitsun-fw-bold"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($trns['price']*$trns['quantity'],get_setting(company($user['id']),'round_of_value')); ?></span>
                                    <?php $total_debit+=aitsun_round($trns['price']*$trns['quantity'],get_setting(company($user['id']),'round_of_value')); ?>

                                <?php else: ?>
                                    ---
                                <?php endif ?>


                            </td>
                            <td>
                                <?php if ($trns['invoice_type']=='sales' || $trns['invoice_type']=='purchase_return' || $trns['invoice_type']=='proforma_invoice'): ?>
                                    <span class="text-success aitsun-fw-bold"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($trns['price']*$trns['quantity'],get_setting(company($user['id']),'round_of_value')); ?></span>

                                    <?php $total_credit+=aitsun_round($trns['price']*$trns['quantity'],get_setting(company($user['id']),'round_of_value'));; ?>
                                <?php else: ?>
                                    ---
                                <?php endif ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                    <?php if ($icount<1): ?>
                        <tr>
                            <td class="text-center" colspan="6">
                                <span class="text-danger">No Transactions </span>
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>

                <tfoot>
                    <tr>  
                        <td colspan="4"><b>Total</b></td>
                        <td><b><?= aitsun_round($total_qty,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                        <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_debit,get_setting(company($user['id']),'round_of_value')) ?></b></td>

                        <td class=""><b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_credit,get_setting(company($user['id']),'round_of_value')) ?></b></td>
                    </tr>

                </tfoot>
            </table>
        </div>
        </div>
        
</div>

<div id="tab2" class="tab-content">
    <div class="aitsun_table col-12 w-100 pt-0 pb-5">
        <h6 class="text-center tab_heading">Stock Adjustments</h6>
        <div class="scrolltable">
            <table class="erp_table sortable">
                <thead class="">
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <th class="aitsun-fw-bold">Date</th> 
                        <th class="aitsun-fw-bold">Type</th>
                        <th class="aitsun-fw-bold">Qty</th>
                        <th class="aitsun-fw-bold">At price</th>
                        <th class="aitsun-fw-bold">Amount</th> 
                        <th class="aitsun-fw-bold">Action</th>
                    </tr>
                </thead>
                <tbody class="">

                    <?php  $data_count=0; ?>
                    <?php $totaladj_val=0; foreach ($stock_array as $ads): $data_count++; ?>
                       <tr style="border-bottom: 1px solid #dee2e6;">
                        <td><?= get_date_format($ads['invoice_date'],'d-M-Y'); ?></td> 
                        <td>
                            <?php if ($ads['invoice_type']=='purchase'): ?>
                               <span class="text-success text-capitalize">Add</span>
                           <?php elseif($ads['invoice_type']=='sales'): ?>
                               <span class="text-danger text-capitalize">Reduce</span>
                           <?php endif ?>
                       </td>
                        <td><?= $ads['quantity']; ?> <?= $ads['in_unit']; ?></td>
                        <td><?= currency_symbol(company($user['id'])); ?>
                            <?= aitsun_round($ads['price'],get_setting(company($user['id']),'round_of_value')); ?>
                        </td>
                        <td>
                            <?php if ($ads['invoice_type']=='purchase'): ?>
                               <span class="text-success text-capitalize">
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($ads['price']*$ads['quantity'],get_setting(company($user['id']),'round_of_value')); ?>
                                   
                               </span>
                           <?php elseif($ads['invoice_type']=='sales'): ?>
                               <span class="text-danger text-capitalize">
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($ads['price']*$ads['quantity'],get_setting(company($user['id']),'round_of_value')); ?>
                                   
                               </span>
                           <?php endif ?>
                           <?php $totaladj_val+=aitsun_round($ads['price']*$ads['quantity'],get_setting(company($user['id']),'round_of_value'));  ?>
                            
                        </td>
                        
                       <td>
                        <a data-url="<?php echo base_url('products/delete_adjust_stock'); ?>/<?= $ads['id']; ?>" class="delete_adjust_stock text-danger" title="delete" data-product_id="<?= $product_id; ?>">
                            <i class="bx bx-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>

            <?php if ($data_count<1): ?>
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td class="text-center" colspan="5">
                        <span class="text-danger">No stock details</span>
                    </td>
                </tr>
            <?php endif ?>

            <tr>
                <td colspan="4"></td>
                <td>
                    <b><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($totaladj_val,get_setting(company($user['id']),'round_of_value')); ?></b>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
</div>
</div>

<script>
    function switchTab(tabIndex) {
        document.querySelectorAll('.tab').forEach(function (tab, index) {
            tab.classList.toggle('active', index + 1 === tabIndex);
        });

        document.querySelectorAll('.tab-content').forEach(function (content, index) {
            content.classList.toggle('active', index + 1 === tabIndex);
        });
        
        document.querySelectorAll('.tab-content').forEach(function (content) { 
            content.classList.remove('both_class');
        });

      
    }

    function showBothaitsun_secondary_tabs() {
        document.querySelectorAll('.tab-content').forEach(function (content) {
            content.classList.add('active');
            content.classList.add('both_class');
        });

        document.querySelectorAll('.tab').forEach(function (tab) {
            tab.classList.remove('active');
            tab.classList.remove('both_class');
        });
    }
</script>


</div>
</div>

