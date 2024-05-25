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
                    <b class="page_heading text-dark">Products</b>
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

    <div class="d-flex">

        <div class="my-auto">
            <form method="post">
                <?= csrf_field(); ?>
                <button href="javascript:void(0);" class="text-dark btn-top-bar font-size-footer me-2" name="get_excel"> 
                    <span class="my-auto">Excel</span>
                </button>
            </form>
        </div>

        <div class="my-auto">          
            <a href="<?= base_url('products/import_and_export') ?>" class=" href_loader text-dark font-size-footer me-2"> 
                <span class="my-auto">Export/Import</span>
            </a>
            <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#pro_filter"> 
                <span class="my-auto">Filter</span>
            </a>
        </div>

        <div class="my-auto">
            
                <a class="text-dark font-size-footer my-auto ms-2" data-bs-toggle="modal" data-bs-target="#add_settings"> <span class="">Settings</span></a>

                 <a class="text-dark font-size-footer my-auto ms-2" href="<?= base_url('products/manufacture') ?>"> <span class="">Manufactures</span></a>

                 <a class="text-dark font-size-footer my-auto ms-2 download_complete" href="<?= base_url('products/download_plu') ?>"> <span class="">Download PLU</span></a>


                 <a class="text-dark font-size-footer my-auto ms-2" href="<?= base_url('easy_edit/barcode_customization') ?>"> <span class="">Barcode generator</span></a>
              
             
        </div>

       
    </div>

    <div class="d-flex">
        <a href="<?= base_url('products/add_new'); ?>" class="text-dark font-size-footer href_loader ms-2 my-auto"> <span class="my-auto">+ New product</span></a>
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<!-- Modal -->
<div class="modal fade aistun-modal" id="add_settings"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Results per page'); ?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="<?= base_url('products/add_results_page') ?>">
        <?= csrf_field(); ?>
      <div class="modal-body">
      
        <div>
          <div class="form-group mb-2">
            <label  class="form-label">Results per page</label>
                <select class="form-select save_side_bar_change" name="results_per_page">
                  <option value="5" <?php if (get_setting(company($user['id']),'results_per_page') == '5') {echo 'selected';} ?>>5</option>
                  <option value="10" <?php if (get_setting(company($user['id']),'results_per_page') == '10') {echo 'selected';} ?>>10</option>
                  <option value="20" <?php if (get_setting(company($user['id']),'results_per_page') == '20') {echo 'selected';} ?>>20</option>
                  <option value="30" <?php if (get_setting(company($user['id']),'results_per_page') == '30') {echo 'selected';} ?>>30</option>
                  <option value="50" <?php if (get_setting(company($user['id']),'results_per_page') == '50') {echo 'selected';} ?>>50</option>
                  <option value="75" <?php if (get_setting(company($user['id']),'results_per_page') == '75') {echo 'selected';} ?>>75</option>
                  <option value="100" <?php if (get_setting(company($user['id']),'results_per_page') == '100') {echo 'selected';} ?>>100</option>
                </select>
          </div>
        </div>
        
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        <button type="submit" class="aitsun-primary-btn" name="add_results_per_page"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- end Modal -->




   
<div id="pro_filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
            <div class="position-relative w-100"> 
                <input type="text" class="form-control ps-5" placeholder="Search Product..." name="product_name"> <span class="position-absolute top-50 product-show_search translate-middle-y"><i class="bx bx-search"></i></span>
            </div>
            <div class="position-relative w-100">
                <input type="text" class="form-control ps-5" placeholder="Search Bin Location..." name="bin_location"> <span class="position-absolute top-50 product-show_search translate-middle-y"><i class="bx bx-search"></i></span>
            </div>
            <div class="w-100" role="group">
                <select class="form-control modal_inpu" name="parent_category" id="input-5">
                    <option value="">Select Category</option>
                    <?php foreach (product_categories_array(company($user['id'])) as $ct) { ?>
                    <option value="<?= $ct['id']; ?>"><?= $ct['cat_name']; ?></option>
                    <?php } ?>
                </select>
            </div> 
            <?php if (is_online_shop(company($user['id']))): ?>
            <div class="w-100" role="group">
                <select class="form-control modal_inpu" name="product_item" id="input-6">
                    <option value="">Select Item</option>
                    <option value="top">Top</option>
                    <option value="deals_of_day">Deals of the day</option>
                    <option value="top_seller">Top Sellers</option> 
                    <option value="offline">Offline</option>
                    <option value="latest_product">Latest</option>
                    <option value="flash_seller">Flash</option>
                    <option value="upsell_product">Upsell</option>
                    <option value="product_group1">Group 1</option>
                </select>
            </div>
            <?php endif ?>
                 
            <button type="submit" class="btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
            <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('products') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
        </form>
        <!-- FILTER -->
    </div>  
</div>




<!-- Synch to Branch -->
<div class="row align-items-center">
    <div class="col-lg-12 col-xl-12 d-flex justify-content-between">

        <div class="modal fade aitsun-modal" id="sync_select"  aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <?php $ib=1; foreach ($branches as $br): $ib++; ?>
                                <?php if (company($user['id'])!=$br['id']): ?>
                                    <button class="sync_all_to_branch btn btn-success mt-2" type="button" data-branchid="<?= $br['id'] ?>">
                                        <?= $br['company_name'] ?>
                                    </button>
                                <?php endif ?>
                            <?php endforeach ?>
                            <?php if ($ib==2): ?>
                                <div class="text-center">
                                    <div class=" m-b-15">
                                        <div class="m-l-15">
                                            <h4 class="m-b-0 text-danger">No branches</h4>
                                        </div>
                                    </div>
                                    
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Synch to Branch -->



<div class="sub_main_page_content pb-5">

    <div id="synmes" class="mb-2">

    </div>

    <div class="row  product-grid pb-3" style="">
        <div class="table_box pb-5">
            <table id="product_list_table" class="w-100">
                <thead>
                    <tr>
                        <th class="text-center">+</th>
                        <th class="text-center" style="max-width: 600px; width:600px;">Product/Service</th>
                        <th class="text-center">POS</th>
                        <th class="text-center"><i class="bx bx-dots-horizontal"></i></th> 
                        <th class="text-center">Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $pi=0; foreach ($product_data as $pro): $pi++; ?>
                    <tr> 
                        <td class="text-center"> 
                            <a class="font-20 text-muted cursor-pointer" data-bs-toggle="modal" data-bs-target="#barcodemodal<?= $pro['id']; ?>"><i class="bx bx-barcode-reader"></i></a>

                            <!-- Barcode Modal -->
                        
                        <div class="modal fade" id="barcodemodal<?= $pro['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Barcode</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="<?php if (get_setting(company($user['id']),'barcode_settings') == '1' || get_setting(company($user['id']),'barcode_settings') == '0') {?>d-none<?php } ?>">
                                            <div class="form-group mb-2">
                                                <input type="text" name="barcode" value="<?= $pro['barcode']; ?>" data-product_id="<?= $pro['id']; ?>" class="form-control me-2 add_barcode" pattern="^[a-zA-Z0-9 ]+$" id="bar_inp<?= $pro['id']; ?>" placeholder="Scan / Type & enter" data-product_name="<?= $pro['product_name']; ?>">
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <button class="btn btn-danger btn-sm w-100 me-2 remove_barcode" data-product_id="<?= $pro['id']; ?>">Remove </button>
                                                <button class="btn btn-primary btn-sm w-100 generate_barcode" data-product_id="<?= $pro['id']; ?>">Generate </button>
                                            </div>
                                        </div>
                                        

                                        <div class="mb-2 <?php if (empty(trim($pro['barcode']))): ?>d-none<?php endif ?>" id="bar_box<?= $pro['id']; ?>">

                                            <img src="<?= base_url('generate_barcode') ?>?text=<?= $pro['barcode']; ?>&size=80&SizeFactor=4&print=true" id="bar_img<?= $pro['id']; ?>" class="w-100">

                                        </div>

                                        <div class="d-flex justify-content-between"> 
                                            <div class="my-auto d-none">
                                                <input type="number" id="barcode_qty<?= $pro['id']; ?>" class="form-control text-center form-control-sm mb-0"   name="quantity" min="1" value="1" style="width: 75px;">
                                            </div> 

                                            <!-- <button class="btn btn-outline-dark btn-sm w-100" onclick="BarcodePrint('bar_inp<= $pro['id']; ?>','barcode_qty<= $pro['id']; ?>','bar_img<?= $pro['id']; ?>')">Print</button> -->
 

                                            <button class="btn btn-outline-dark btn-sm w-100 print_barcode" 
                                                data-bar_inp="bar_inp<?= $pro['id']; ?>"
                                                data-barcode_qty="barcode_qty<?= $pro['id']; ?>"
                                                data-bar_img="bar_img<?= $pro['id']; ?>"
                                                data-thisid="<?= $pro['id']; ?>"
                                                data-product_name="<?= $pro['product_name']; ?>"

                                                data-margins="<?= get_setting(company($user['id']),'bar_margin1') ?>px <?= get_setting(company($user['id']),'bar_margin2') ?>px <?= get_setting(company($user['id']),'bar_margin3') ?>px <?= get_setting(company($user['id']),'bar_margin4') ?>px"
                                                data-width="<?= get_setting(company($user['id']),'bar_body_width') ?>px"
                                                data-height="<?= get_setting(company($user['id']),'barcode_height') ?>px"

                                            >Print</button>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- Barcode Modal -->
                        </td>
                        <td>
                            <div class="d-flex py-1">
                                <?php if ($pro['pro_img'] !=''): ?>
                                     <img onclick="location.href='<?= base_url('products/edit'); ?>/<?= $pro['id']; ?>';" src="<?= base_url(); ?>/public/images/products/<?php if( $pro['pro_img'] !=''){echo $pro['pro_img']; }else{echo 'prod.png';} ?>" class="href_loader card-img-top me-2 pro_featured " draggable="false" style="-moz-user-select: none; background-repeat: no-repeat, repeat;
                                        background-image: url('<?= base_url(); ?>/public/images/products/<?php if( $pro['pro_img'] !=''){echo $pro['pro_img']; }else{echo 'prod.png';} ?>'), url('');
                                        background-blend-mode: lighten;" ondragstart="return false;">
                                <?php else: ?>
                                    <div class="image_box d-flex me-2">
                                        <i class="bx bx-plus-circle m-auto"></i>
                                    </div>
                                <?php endif ?>
                               


                                <div class="my-auto w-100 pro_box">
                                    <a class="pro_data" data-bs-toggle="modal" data-bs-target="#customModal<?= $pro['id'] ?>" data-product_id="<?= $pro['id']; ?>">
                                        <h6 class="text_over_flow_2 text-dark">
                                            <?= $pro['product_name'] ?>
                                        </h6>
                                    </a>

<div class="modal fade prod_modal" id="customModal<?= $pro['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <div class="modal-header pt-0 pb-0">
                <h5 class="modal-title ps-2" id="exampleModalLabel"><?= $pro['product_name'] ?></h5>
                <span class="my-auto cursor-pointer " data-bs-dismiss="modal" style="transform: rotate(45deg); font-size: 25px;">+</span>
            </div>
            
            <div class="modal-body p-0">
                <div id="show_product_details<?= $pro['id']; ?>">
                    
                </div>
              
            </div>
        </div>
    </div>
</div>






                                    <p class="category_text d-flex justify-content-between mt-1">
                                        
                                       <span>
                                            <?php if ($pro['product_method']=='product'): ?> 
                                                <span class="pro_brand">[<?= name_of_brand($pro['brand']); ?>]</span>
                                            <?php endif ?>

                                           <?php if (!empty($pro['category'])): ?>
                                                <?= name_of_category($pro['category']); ?>
                                            <?php endif ?>
                                            <?php if (!empty($pro['sub_category'])): ?>
                                                > </i><?= name_of_sub_category($pro['sub_category']); ?>
                                            <?php endif ?>
                                            <?php if (!empty($pro['sec_category'])): ?>
                                                > </i><?= name_of_sec_category($pro['sec_category']); ?>
                                            <?php endif ?>
                                       </span>

                                        <?php if ($pro['is_manufactured']==1): ?>
                                            <small class="p_kit">Manufactured</small>
                                        <?php endif ?>
                                    </p>

                                    <?php if (is_online_shop(company($user['id']))): ?>

                                        <?php if ($pro['product_method']=='product'): ?>
                                            <div>
                                                <div class="custom-row pb-1 text-center border-top">
                                                    <div class="col">
                                                         <a data-url="<?php echo base_url('google_services/sync_product_to_google'); ?>/<?= $pro['id']; ?>" class=" sync_to_google_shop" title="Google Shopping" 
                                                            data-idd="<?= $pro['id']; ?>"
                                                            data-unit="<?= name_of_unit($pro['unit']); ?>"
                                                            data-brand="<?= name_of_brand($pro['brand']); ?>"
                                                            data-category="<?= name_of_category($pro['category']); ?>"
                                                            data-sub_category="<?= name_of_sub_category($pro['sub_category']); ?>"
                                                            data-sec_category="<?= name_of_sec_category($pro['sec_category']); ?>"
                                                        >
                                                          <i class="lni lni-google text-google" style="margin-top: 6px;"></i>
                                                        </a> 
                                                    </div>
                                                    <div class="col"> 
                                                        <a class="href_loader" href="<?= base_url('products/product_rating'); ?>/<?= $pro['id']; ?>"><i class="bx bxs-star text-warning font-22" style="margin-top: 2px;"></i></a>
                                                    </div>
                                                    <div class="col">
                                                        <label for="id-of-top<?= $pro['id']; ?>" class="custom-checkbox" title="Top product">
                                                            <input type="checkbox" id="id-of-top<?= $pro['id']; ?>"
                                                            <?php if ($pro['top']==1) { echo 'checked';} ?> />
                                                                <i class="bx bx-heart"></i>
                                                                <i class="bx bxs-heart <?php if ($pro['top']==1) { echo 'removetop';}else{echo 'addtop';} ?>" data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="col">
                                                        <label for="id-of-deals<?= $pro['id']; ?>" class="custom-checkbox" title="Deals of day">
                                                          <input type="checkbox" id="id-of-deals<?= $pro['id']; ?>"
                                                          <?php if ($pro['deals_of_day']==1) { echo 'checked';} ?>/>
                                                          <i class="bx bx-toggle-right"></i>
                                                          <i class="bx bxs-toggle-left <?php if ($pro['deals_of_day']==1) { echo 'removedeals';}else{echo 'adddeals';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>

                                                    <div class="col">
                                                        <label for="id-of-top_seller<?= $pro['id']; ?>" class="custom-checkbox" title="Top seller">
                                                          <input type="checkbox" id="id-of-top_seller<?= $pro['id']; ?>"
                                                          <?php if ($pro['top_seller']==1) { echo 'checked';} ?>/>
                                                          <i class="bx bx-check-circle"></i>
                                                          <i class="bx bxs-check-circle <?php if ($pro['top_seller']==1) { echo 'removetop_seller';}else{echo 'addtop_seller';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>

                                                    <div class="col">
                                                        <label for="id-of-online<?= $pro['id']; ?>" class="custom-checkbox" title="Online">
                                                        <input type="checkbox" id="id-of-online<?= $pro['id']; ?>"
                                                        <?php if ($pro['online']==1) { echo 'checked';} ?>/>
                                                        <i class="bx bx-hide"></i>
                                                        <i class="bx bxs-show <?php if ($pro['online']==1) { echo 'removeonline';}else{echo 'addonline';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                      </label>
                                                    </div>

                                                    <div class="col">
                                                        <label for="id-of-latest_product<?= $pro['id']; ?>" class="custom-checkbox" title="latest product">
                                                          <input type="checkbox" id="id-of-latest_product<?= $pro['id']; ?>"
                                                          <?php if ($pro['latest_product']==1) { echo 'checked';} ?>/>
                                                          <i class="bx bx-checkbox"></i>
                                                          <i class="bx bx-checkbox-square <?php if ($pro['latest_product']==1) { echo 'removelatestproduct';}else{echo 'addlatestproduct';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>

                                                    <div class="col">
                                                        <label for="id-of-flash_seller<?= $pro['id']; ?>" class="custom-checkbox" title="Flash Seller">
                                                          <input type="checkbox" id="id-of-flash_seller<?= $pro['id']; ?>"
                                                          <?php if ($pro['flash_seller']==1) { echo 'checked';} ?>/>
                                                          <i class="bx bx-purchase-tag-alt"></i>
                                                          <i class="bx bxs-purchase-tag-alt <?php if ($pro['flash_seller']==1) { echo 'removeflashseller';}else{echo 'addflashseller';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>

                                                    <div class="col">
                                                        <label for="id-of-upsell_product<?= $pro['id']; ?>" class="custom-checkbox" title="Upsell Product">
                                                          <input type="checkbox" id="id-of-upsell_product<?= $pro['id']; ?>"
                                                          <?php if ($pro['upsell_product']==1) { echo 'checked';} ?>/>
                                                          <i class="bx bx-store-alt"></i>
                                                          <i class="bx bxs-store-alt <?php if ($pro['upsell_product']==1) { echo 'removeupsellproduct';}else{echo 'addupsellproduct';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>

                                                 
                                                    <div class="col">
                                                        <label for="id-of-product_group1<?= $pro['id']; ?>" class="custom-checkbox" title="Home products">
                                                          <input type="checkbox" id="id-of-product_group1<?= $pro['id']; ?>"
                                                          <?php if ($pro['product_group1']==1) { echo 'checked';} ?>/>
                                                          <i class="bx bx-grid-vertical"></i>
                                                          <i class="bx bx-grid-horizontal <?php if ($pro['product_group1']==1) { echo 'removeproductgroup1';}else{echo 'addproductgroup1';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                                        </label>
                                                    </div>
     
                                                </div>
                                            </div>
                                        <?php endif ?>

                                    <?php endif ?>

                                </div> 
                            </div>

                            
                        </td>

                        <td class="text-center">
                             
                             <div class="form-check form-switch text-center p-0" >
                                <input type="checkbox" class="form-check-input is_pos" data-p_url="<?=  base_url() ?>/is_pos/<?= $pro['id']; ?>" style="margin-left: 0; float: unset;"  name="is_pos" value="1" <?php if ($pro['is_pos'] == '1') {echo 'checked';} ?>> 
                            </div>
                        </td>

                        <td class="text-center"> 
                            <a class="pro_stock_data" data-bs-toggle="modal" data-bs-target="#adjust_stock_modal<?= $pro['id']; ?>" data-product_id="<?= $pro['id']; ?>">
                                    

                            <div class="pro_box_details">
                            <div>  
                                <?php if ($pro['product_method']=='service'): ?>
                                    <small class="pro_ser_tag-service"><b>Service</b></small>
                                <?php else: ?>
                                    <small class="pro_ser_tag-product"><b>Product</b></small>
                                <?php endif ?>
                            </div>

                            <?php if ($pro['product_method']=='product'): ?>
                             <?php $stockkk=$pro['closing_balance']; ?>
                                <span class="price_label mt-1">In Stock</span>
                                <small class="<?php if ($stockkk<0): ?>text-danger<?php elseif($stockkk>0): ?>text-success<?php endif ?>">
                                    <?= number_format($stockkk,1,'.',''); ?>
                                    <?= $pro['unit']; ?> 
                                     <?php if (!empty($pro['sub_unit'])): ?> 
                                         (<?= $stockkk*$pro['conversion_unit_rate']; ?> <?= $pro['sub_unit']; ?>) 
                                     <?php endif ?>
                                 </small>
                            <?php endif ?>
                            </div>
                            </a>


                            <?php  if (check_permission($user['id'],'stock_management')==true || $user['u_type']=='admin'): ?>
                            <div class="modal fade" id="adjust_stock_modal<?= $pro['id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Adjust stock details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div id="show_adjust_stock<?= $pro['id']; ?>">
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                        </td>
                       
                        <td class="text-center">
                            <div class="pro_box_details">
                            <div class="d-flex justify-content-center">
                                <?php if ($pro['product_method']=='product'): ?>
                                 <div class="text-center pe-2 border-line-right">
                                    <span class="price_label">Purchase price</span>
                                    <span class="price text-danger"><?= currency_symbolfor_sms($pro['company_id']); ?> <?= aitsun_round($pro['purchased_price'],get_setting(company($user['id']),'round_of_value')); ?>/<?= $pro['unit']; ?></span>
                                 </div>
                                <?php endif ?>

                                <div class="text-center px-2">
                                    <span class="price_label">Sale price</span>
                                    <span class="price text-success"><b><?= currency_symbolfor_sms($pro['company_id']); ?> <?= aitsun_round($pro['price'],get_setting(company($user['id']),'round_of_value')); ?>/<?= $pro['unit']; ?></b></span>
                                </div>
                            

                                <?php if ($pro['product_method']=='product'): ?>
                                    <?php if ($pro['mrp']>0): ?> 
                                      <div class="text-center ps-2 border-line-left">
                                          <span class="price_label">MRP</span>
                                          <span class="price text-success"><?= currency_symbolfor_sms($pro['company_id']); ?> <?= aitsun_round($pro['mrp'],get_setting(company($user['id']),'round_of_value')); ?>/<?= $pro['unit']; ?></span>
                                      </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                        </div>
                        </td>
                        
                        <td class="text-center">
                            <div class="dropdown dropdown-animated scale-left">
                                <a class="btn btn-outline-dark btn-sm font-size-18" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-horizontal"></i>
                                </a>
                                <div class="dropdown-menu"> 

                                    <?php if ($pro['product_method']!='service'): ?>
                                     <a class="dropdown-item href_loader" href="<?= base_url('products/manufacture/create_raw_materials') ?>/<?= $pro['id'] ?>">
                                        <i class="bx bx-plus"></i>
                                        <span class="ms-3">Manufacture</span>
                                    </a>
                                    <?php endif ?>
                                    
                                    <?php  if (check_permission($user['id'],'stock_management')==true || $user['u_type']=='admin'): ?>
                                    <a class="dropdown-item" title="Adjust Stock" data-bs-toggle="modal" data-bs-target="#adjust_stock<?= $pro['id']; ?>">
                                        <i class="bx bx-stats"></i>
                                        <span class="ms-3">Adjust stock</span>
                                    </a>
                                    <?php endif; ?>

                                    <a href="<?php echo base_url('products/edit'); ?>/<?= $pro['id']; ?>" class="dropdown-item href_loader" title="Edit" >
                                        <i class="bx bx-pencil"></i>
                                        <span class="ms-3">Edit</span>
                                    </a>

                                    <a href="<?php echo base_url('products/products_transactions'); ?>/<?= $pro['id']; ?>" class="dropdown-item href_loader">
                                        <i class="bx bx-transfer"></i>
                                        <span class="ms-3">Transactions</span>
                                    </a>
                        
                                    <?php if(is_online_shop(company($user['id']))): ?> 
                                        <?php if ($pro['product_method']=='product'): ?>
                                        <a href="<?php echo base_url('products/long_edit/'); ?>/<?= $pro['id']; ?>" class="dropdown-item href_loader"  title="Rich edit">
                                            <i class="bx bx-edit"></i>
                                            <span class="ms-3">Rich edit</span>
                                        </a>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <a data-url="<?php echo base_url('products/delete'); ?>/<?= $pro['id']; ?>" class="dropdown-item product_delete text-danger-dropdown-link" title="delete">
                                        <i class="bx bx-trash"></i>
                                        <span class="ms-3">Delete</span>
                                    </a>

                                </div>
                            </div>

                            <div class="modal fade" id="adjust_stock<?= $pro['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Adjust stock</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <form method="post" action="<?= base_url('products') ?>/add_adjust_stck/<?= $pro['id']; ?>">
                                            <?= csrf_field(); ?>
                                        
                                        <div class="form-group mb-2">
                                            <label>Add or Reduce stock</label>
                                             <div class="mb-3"> 
                                                
                                                <div class="d-flex mt-2">
                                                   
                                                  <div class="d-flex justify-content-center my-auto me-4">
                                                    <input type="radio" name="adjust_type" class="form-check-input my-auto" value="purchase"  checked id="add_label">
                                                    <label class="my-auto ms-2 my-auto" for="add_label">Add</label>
                                                  </div>

                                                  <div class="d-flex my-auto ">
                                                    <input type="radio" name="adjust_type" class="form-check-input my-auto" value="sales" id="reduce_label">
                                                    <label class="my-auto ms-2 my-auto" for="reduce_label">Reduce</label>
                                                  </div>
                                                </div>
                                                  </div>

                                        </div> 
                                        <div class="d-flex">
                                            
                                         <div class="form-group mb-2">
                                            <label>Adjust stock</label>
                                            <div class="form-group mb-2">
                                                <input type="number" name="adjust_stock_qty" required class="form-control me-2" value="0" min="1">
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <input type="hidden" name="unit" value="<?= $pro['unit']; ?>">
                                            <input type="hidden" name="sub_unit" value="<?= $pro['sub_unit']; ?>">
                                            <input type="hidden" name="conversion_unit_rate" value="<?= $pro['conversion_unit_rate']; ?>">

                                            <label  class="form-label my-auto">In Unit</label>
                                            <select class="bg-dark form-control text-white" style="min-width: max-content;max-width: 100px;" name="in_unit" required>
                                                <option value="<?= $pro['unit']; ?>"><?= $pro['unit']; ?></option>
                                              <?php if (!empty($pro['sub_unit'])): ?>
                                                <option value="<?= $pro['sub_unit'] ?>"><?= $pro['sub_unit'] ?></option>
                                              <?php endif ?> 
                                             </select>
                                      </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label>At price (per <?= $pro['unit']; ?>)</label>
                                            <div class="form-group mb-2">
                                                <input type="number" name="at_price" step="any" required class="form-control me-2" value="<?= $pro['purchased_price']; ?>" min="0">
                                            </div>
                                        </div>

                                        


                                     

                                        <div class="d-flex justify-content-between mt-4">   
                                            <button type="submit" class="btn btn-outline-dark btn-sm w-100 ">Adjust</button>
                                        </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> 
    </div><!--end row-->

 

      
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('products/requests'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bx-question-mark ms-2"></i> <span class="my-auto">Requests</span></a>/
        <a href="<?= base_url('products/easy_edit'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-edit-alt ms-2"></i> <span class="my-auto">Easy Edit</span></a>/
        <a data-bs-toggle="modal" data-bs-target="#sync_select" class="text-dark font-size-footer me-2"><i class="bx bxs-book-bookmark ms-2"></i> <span class="my-auto">Sync to branch</span></a>/
        <a data-url="<?php echo base_url('google_services/sync_product_to_google/'); ?>"id="sync_all_to_google_shop" title="Google Shopping" class="text-dark font-size-footer me-2"><i class="lni lni-google text-google ms-2"></i> <span class="my-auto">Sync all</span></a>/
        <a href="<?= base_url('settings/product'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bx-cog ms-2"></i> <span class="my-auto">Product Category & Brand</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 





</div>





<script type="text/javascript">
    function BarcodePrint(input_box,qty_box,barcode_src) { 
        var barcode_val=document.getElementById(input_box).value;
        var barcode_src=document.getElementById(barcode_src).src;
        var product_name=document.getElementById(input_box).getAttribute('data-product_name');
 
        if (document.getElementById(qty_box).value<=0) {
            var barcode_qty=1;
        }else{
            var barcode_qty=document.getElementById(qty_box).value;
        } 

        const data = [
           
        ]; 

        for (let i = 0; i < barcode_qty; i++) {
            data.push({
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: product_name,
                style: { textAlign: 'center', fontSize: "15px",fontFamily:'monospace,cursive', fontWeight: "600"}
            },
            
            {
                type: 'barCode',
                value: barcode_val,
                height: <?= get_setting(company($user['id']),'barcode_height') ?>,                     // height of barcode, applicable only to bar and QR codes
                width: '<?= get_setting(company($user['id']),'barcode_width') ?>px',                       // width of barcode, applicable only to bar and QR codes
                displayValue: true,             // Display value below barcode
                fontsize: <?= get_setting(company($user['id']),'barcode_fontsize') ?>, 
            },
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: '<br>',
                style: { textAlign: 'center', fontFamily:'monospace,cursive' ,marginBottom:'<?= get_setting(company($user['id']),'barcode_marginbottom') ?>'}
            });  
        }

        const options = {
            preview: <?= get_setting(company($user['id']),'bar_preview') ?>, 
            margin: '<?= get_setting(company($user['id']),'bar_margin1') ?>px <?= get_setting(company($user['id']),'bar_margin2') ?>px <?= get_setting(company($user['id']),'bar_margin3') ?>px <?= get_setting(company($user['id']),'bar_margin4') ?>px',            // margin of content body
            copies: <?= get_setting(company($user['id']),'bar_copies') ?>,                    // Number of copies to print
            printerName: '<?= get_setting(company($user['id']),'bar_printer1') ?>',        // printerName: string, check with webContent.getPrinters()
            timeOutPerLine: 400,
            width: '<?= get_setting(company($user['id']),'bar_body_width') ?>',
            pageSize: '<?= get_setting(company($user['id']),'bar_width') ?>',
            silent:<?= get_setting(company($user['id']),'bar_silent') ?>,
            dpi: <?= get_setting(company($user['id']),'bar_dpi') ?>, 


        }

        var print_data=JSON.stringify(data);
        var printer_data=options;

        var full_arr = [];
        full_arr.push(print_data, printer_data);
        window.api.bar_print('toBar', full_arr);
    }
</script>