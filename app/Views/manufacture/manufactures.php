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
                    <b class="page_heading text-dark">Manufacture</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#product_edit_table" data-filename="Manufacture masters <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#product_edit_table" data-filename="Manufacture masters <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#product_edit_table" data-filename="Manufacture masters <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
     
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#products_edit_fliter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#product_edit_table"> 
            <span class="my-auto">Quick search</span>
        </a>

    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 

        
<div id="products_edit_fliter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>

            <input type="text" name="product_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Product Name'); ?>" class=" filter-control form-control  w-100">

            <button class="href_long_loader btn-dark btn-sm">
                <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
            </button>
            
            <a class="btn btn-outline-dark my-auto" href="<?= base_url('/products/manufacture') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
          
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
                        <th class="sorticon ">Products Name</th>
                        <th class="sorticon text-center">Status</th>
                        <th class="sorticon text-center">Date</th> 
                        <th class="sorticon text-center">Quantity</th> 
                        <th class="sorticon text-end">Cost</th> 
                        <th class="sorticon text-end">Additional cost</th>
                        <th class="sorticon text-end">Total cost</th> 
                        <th class="sorticon text-end" data-tableexport-display="none">Action</th>  
                    </tr>
                 
                 </thead>
                <tbody>
                    

                    
                    <?php $i=0; foreach ($product_data as $p_data): $i++; ?> 
                    <tr> 
                        <td>
                            <a class="aitsun_link mt-1 d-block font-size-footer" href="<?= base_url('products/manufacture/edit_manufacture') ?>/<?= $p_data['id'] ?>">
                                <?= $p_data['product_name']; ?> 
                            </a>
                        </td>

                        <td class="text-center">
                            <span class="text-success d-flex">
                                <i class="my-auto bx bx-badge-check"></i>
                                <span class="my-auto ms-1 text-capitalize"> <?= $p_data['type']; ?></span>
                            </span>
                        </td>

                        <td class="text-center"><?= $p_data['manufactured_date']; ?></td> 
                        <td class="text-center"><?= $p_data['manufactured_quantity']; ?></td> 
                        <td class="text-end"><?= $p_data['total_cost']; ?></td> 
                        <td class="text-end"><?= $p_data['total_additional_cost']; ?></td> 
                        <td class="text-end"><?= $p_data['total_manufactured_cost']; ?></td> 


                        <td class="text-end" data-tableexport-display="none" style="white-space: nowrap;">
                            <a class=" btn-edit-dark me-2 action_btn cursor-pointer" href="<?= base_url('products/manufacture/edit_manufacture') ?>/<?= $p_data['id'] ?>"><i class="bx bxs-edit-alt"></i></a>

                            <a class="delete btn-delete-red action_btn cursor-pointer" data-url="<?= base_url('manufacture/delete'); ?>/<?= $p_data['id'] ?>"><i class="bx bxs-trash"></i></a>
                        </td>
                    </tr>

                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="8"><h6 class="p-4 text-center text-danger">No data found... </h6></td>
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