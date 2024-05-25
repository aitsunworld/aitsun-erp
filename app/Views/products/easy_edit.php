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
                    <b class="page_heading text-dark">Products Edit</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#products_edit_fliter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a class="text-dark font-size-footer my-auto ms-2 download_complete" href="<?= base_url('products/download_plu') ?>"> <span class="">Download PLU</span></a>

    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
<?php if (session()->get('pu_msg')): ?>
    <script type="text/javascript">
        popup_message('success','Done',"<?= session()->get('pu_msg'); ?>"); 
    </script>
<?php endif ?>

<?php if (session()->get('pu_er_msg')): ?> 
    <script type="text/javascript">
        popup_message('error','Failed',"<?= session()->get('pu_er_msg'); ?>"); 
    </script>
<?php endif ?>

        
<div id="products_edit_fliter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>

            <input type="text" name="product_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Product Name'); ?>" class=" filter-control form-control  w-100">

            <button class="href_long_loader btn-dark btn-sm">
                <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
            </button>
            
            <a class="btn btn-outline-dark my-auto" href="<?= base_url('/products/easy_edit') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
          
        </form>
        <!-- FILTER -->
    </div>  
</div>



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="product_edit_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th class="">Products Name</th>
                        <th class="">Purchase Price</th>
                        <th class="">Taxable</th>
                        <th class="">Selling Price</th>
                        <th class="">Taxable</th> 
                        <?php  if (check_permission($user['id'],'stock_management')==true || $user['u_type']=='admin'): ?>
                        <th class="">Opening Stock</th> 
                        <th class="">Op. at price</th> 
                        <?php endif; ?>
                        <th class="">Code</th> 
                        <?php if (is_medical(company($user['id']))):?>
                            <th class="">Batch No</th> 
                            <th class="">Bin Location</th> 
                        <?php endif ?>
                        <th class="">Product identifiers</th> 
                    </tr>
                 
                 </thead>
                <tbody>
                    

                    
                    <?php $i=0; foreach ($product_data as $p_data): $i++; ?>

                    <tr>
                        
                        <td>
                            <input type="text" class="easy_pro_update form-control py-1 add_cls-product_name-<?= $p_data['id']; ?>"  name="pro_name" data-product_id="<?= $p_data['id']; ?>" data-p_element="product_name" value="<?= $p_data['product_name']; ?>">
                        </td>
                        <td>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="easy_pro_update form-control py-1 add_cls-purchased_price-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="purchased_price" value="<?= aitsun_round($p_data['purchased_price'],get_setting(company($user['id']),'round_of_value')); ?>" data-p_element="purchased_price">
                        </td>

                        <td>
                            <select class="form-control easy_pro_update py-1 add_cls-purchase_tax-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="purchase_tax" data-p_element="purchase_tax">
                                <option value="1"  <?php if ($p_data['purchase_tax']=='1') {echo 'selected';} ?>>With Tax</option>
                                <option value="0"  <?php if ($p_data['purchase_tax']=='0') {echo 'selected';} ?>>Without Tax</option>
                            </select>
                        </td>

                        <td>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="easy_pro_update form-control py-1 add_cls-price-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="sales_price" value="<?= aitsun_round($p_data['price'],get_setting(company($user['id']),'round_of_value')); ?>" data-p_element="price">
                        </td>

                        <td>
                            <select class="form-control easy_pro_update py-1 add_cls-sale_tax-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="sale_tax" data-p_element="sale_tax">
                                <option value="1"  <?php if ($p_data['sale_tax']=='1') {echo 'selected';} ?>>With Tax</option>
                                <option value="0"  <?php if ($p_data['sale_tax']=='0') {echo 'selected';} ?>>Without Tax</option>
                            </select>
                        </td>

                        <?php  if (check_permission($user['id'],'stock_management')==true || $user['u_type']=='admin'): ?>
                        <td>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="easy_pro_update form-control py-1 add_cls-opening_balance-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="opening_balance" value="<?= $p_data['opening_balance']; ?>" data-p_element="opening_balance">
                        </td>
                        
                        <td>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="easy_pro_update form-control py-1 add_cls-at_price-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="at_price" value="<?= $p_data['at_price']; ?>" data-p_element="at_price">
                        </td>
                        <?php endif; ?>

                        <td>
                            <input type="text" class="easy_pro_update form-control py-1 add_cls-product_code-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="product_code" value="<?= $p_data['product_code']; ?>" data-p_element="product_code">
                        </td>

                        <?php if (is_medical(company($user['id']))):?>
                        <td>
                            <input type="text" class="easy_pro_update form-control py-1 add_cls-batch_no-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="pro_batch_no" value="<?= $p_data['batch_no']; ?>" data-p_element="batch_no">
                        </td>
                        <td>
                            <input type="text" class="easy_pro_update form-control py-1 add_cls-bin_location-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="pro_bin_location" value="<?= $p_data['bin_location']; ?>" data-p_element="bin_location">
                        </td>
                        <?php endif ?>
                        <td>
                            <input type="text" class="easy_pro_update form-control py-1 add_cls-pro_in-<?= $p_data['id']; ?>" data-product_id="<?= $p_data['id']; ?>" name="pro_in" value="<?= $p_data['pro_in']; ?>" data-p_element="pro_in">
                        </td>
                    </tr>

                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="9"><h6 class="p-4 text-center text-danger">No Products Found... </h6></td>
                        </tr>
                    <?php endif ?>
                     
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 