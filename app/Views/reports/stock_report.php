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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Stock Report</b>
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
        <!-- <a href="javascript:void(0);" class="big_data_export text-dark font-size-footer me-2" data-type="excel" data-table="#stock_table" data-filename="Stock Report"> 
            <span class="my-auto">Excel</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#stock_table" data-filename="Stock Report"> 
            <span class="my-auto">CSV</span>
        </a>
         <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#stock_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>
    <div>
        <form method="post">
            <?= csrf_field(); ?>
            <button href="javascript:void(0);" class="text-dark btn-top-bar font-size-footer me-2" name="get_excel"> 
                <span class="my-auto">Export to Excel</span>
            </button>
        </form>
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<div id="filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>

            <input type="text" name="product_name" class="filter-control w-100 text-ident form-control" placeholder="Product name">

            <select name="stocks" class="form-select">
                <option value="">All</option>
                <option value="out_of_stock">Out of stock</option>
                <option value="in_stock">In stock</option>
            </select>

            <div class="w-100" role="group">
                <select class="form-control " name="pro_main_category" id="input-5">
                    <option value="">Select Category</option>
                    <?php foreach (product_categories_array(company($user['id'])) as $ct) { ?>
                    <option value="<?= $ct['id']; ?>"><?= $ct['cat_name']; ?></option>
                    <?php } ?>
                </select>
            </div> 
 
           
            <button class="href_long_loader btn-dark btn-sm">
                <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
            </button>
              
            <a class="btn-outline-dark btn btn-sm" href="<?= base_url('stock_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
           
        </form>
        <!-- FILTER -->
    </div>  
</div>


<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="stock_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Product</th>
                    <th class="sorticon">Opening Stock</th>
                    <th class="sorticon">Current Stock</th> 
                    <th class="sorticon">Stock value(Avg.)</th> 
                    <!-- <th class="sorticon">Stock value(FIFO)</th>  -->
                </tr>
             
             </thead>
              <tbody>
                <?php $total_stock_value_fifo=0; $total_stock_value=0; foreach ($stock_data as $pro): ?>
                  <tr  <?php if ($pro['closing_balance']<=0){ ?> style="background: #f53737; color:white!important;" <?php } ?> >
                      <td style="max-width:420px;">
                          <a class="<?php if ($pro['closing_balance']<1){ ?>text-white<?php } ?> href_loader text_over_flow_1" href="<?= base_url('products/edit'); ?>/<?= $pro['id']; ?>"><?= $pro['product_name']; ?></a>
                      </td>
                     <td>
                         <?= $pro['opening_balance']; ?> <?= $pro['unit']; ?> 
                         <?php if (!empty($pro['sub_unit'])): ?>

                             (<?= $pro['opening_balance']*$pro['conversion_unit_rate']; ?> <?= $pro['sub_unit']; ?>)

                         <?php endif ?>
                     </td>
                     <td>
                         <?= $pro['closing_balance']; ?> <?= $pro['unit']; ?> 
                         <?php if (!empty($pro['sub_unit'])): ?>

                             (<?= $pro['closing_balance']*$pro['conversion_unit_rate']; ?> <?= $pro['sub_unit']; ?>)

                         <?php endif ?>
                     </td>
                     <td class="text-right">

                        <?= currency_symbol(company($user['id'])); ?><?= aitsun_round($pro['final_closing_value'],get_setting(company($user['id']),'round_of_value')); ?>
                        <?php $total_stock_value+=aitsun_round($pro['final_closing_value'],get_setting(company($user['id']),'round_of_value')); ?>
                    </td>
                    <!-- <td class="text-right">

                        <= currency_symbol(company($user['id'])); ?><= aitsun_round($pro['final_closing_value_fifo'],get_setting(company($user['id']),'round_of_value')); ?>
                        <php $total_stock_value_fifo+=aitsun_round($pro['final_closing_value_fifo'],get_setting(company($user['id']),'round_of_value')); ?>
                    </td> -->
                  </tr>
              <?php endforeach ?>
                 
              </tbody>
              <tfoot>
                    <td colspan="2"></td>
                    <td><b>Total stock value</b></td>
                    <td class="text-right"><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_stock_value,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                    <!-- <td class="text-right"><b><= currency_symbol(company($user['id'])); ?> <= aitsun_round($total_stock_value_fifo,get_setting(company($user['id']),'round_of_value')); ?></b></td> -->
                </tfoot>
            </table>
        </div>

        

    </div>
</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->