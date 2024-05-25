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
            <form method="post" action="<?= base_url('settings/side_bar_setting'); ?>" id="side_bar_form">
                <?= csrf_field(); ?>
                <a class="text-dark font-size-footer my-auto ms-2" data-bs-toggle="modal" data-bs-target="#add_settings"> <span class="">Settings</span></a>
            </form>
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
        
        <div class="">
            <div class="form-group mb-2">
            <label  class="form-label">Barcode Settings</label>
                <select class="form-select save_side_bar_change" name="barcode_settings">
                   
                    <option value="0" <?php if (get_setting(company($user['id']),'barcode_settings') == '0') {echo 'selected';} ?>>Normal Barcode</option>
                    <option value="1" <?php if (get_setting(company($user['id']),'barcode_settings') == '1') {echo 'selected';} ?>>Quantity Barcode</option>
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



<div class="sub_main_page_content">

    <div id="synmes" class="mb-2">

    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid" style="">



            <?php $pi=0; foreach ($product_data as $pro): $pi++; ?>
            <div class="col mb-3">

                <?php $current_stock=balance(company($user['id']),ledger_id_of_product(company($user['id']),$pro['id']),'closing_balance','stock'); ?>
                <div class="card " style="
                <?php 
                    if ($current_stock<0){
                        echo "border: 2px solid red;border-radius: 7px;";
                    }elseif($current_stock<=5){
                        echo "border: 2px solid #ffaa2b;border-radius: 7px;";
                    } 
                ?>">

 
                <div class="d-flex text-center 
                    <?php if(get_date_format(now_time($user['id']),'Y-m-d')<=$pro['expiry_date']){echo "d-none";} ?>
                    <?php if($pro['expiry_date']=='0000-00-00'){echo "d-none";} ?>">        
                    <span style="background: #ff0000c7;border-bottom-right-radius: 10px;width: 30%; color: white; position: absolute;
                    top: 0;" >Expired</span>
                </div>

                    <?php if(is_online_shop(company($user['id']))): ?>
                        <div class="position-relative">
                        <img onclick="location.href='<?= base_url('products/edit'); ?>/<?= $pro['id']; ?>';" src="<?= base_url(); ?>/public/images/products/<?php if( $pro['pro_img'] !=''){echo $pro['pro_img']; }else{echo 'prod.png';} ?>" class="href_loader card-img-top product_image_show " draggable="false" style="-moz-user-select: none;" ondragstart="return false;">
                    
                        <small class="p_uploader">(By: <?= user_name($pro['added_by']); ?>)</small>

                        <?php if ($pro['product_type']=='item_kit'): ?>
                            <small class="p_kit">iKit</small>
                        <?php endif ?>

                        <?php if ($pro['product_method']=='service'): ?>
                            <small class="pro_ser_tag">Service</small>
                        <?php endif ?>
                        </div>

                        <?php if ($pro['product_method']=='product'): ?>
                        <div class="">
                            <div class="position-absolute top-0 end-0 m-4 product-discount"><span class=""><?= name_of_brand($pro['brand']); ?></span></div>
                        </div>
                        <?php endif ?>

                    <?php else :?>
                    <div class="position-relative mb-3">
                     

                        <?php if ($pro['product_type']=='item_kit'): ?>
                            <small class="p_kit">iKit</small>
                        <?php endif ?>

                        <?php if ($pro['product_method']=='service'): ?>
                            <small class="pro_ser_tag">Service</small>
                        <?php endif ?>



                    </div>

                        
                    
                    <?php endif ?>


                    <div class="card-body pt-0">




                        <?php if(is_online_shop(company($user['id']))): ?> 

                            <div class="text-end">

                                <a class="font-20 text-muted cursor-pointer" data-bs-toggle="modal" data-bs-target="#barcodemodal<?= $pro['id']; ?>"><i class="bx bx-barcode-reader"></i></a>
                            </div>

                        <?php endif ?>

                        <!-- Barcode Modal -->
                        
                        <div class="modal fade" id="barcodemodal<?= $pro['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Barcode</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group mb-2">
                                            <input type="text" name="barcode" value="<?= $pro['barcode']; ?>" data-product_id="<?= $pro['id']; ?>" class="form-control me-2 add_barcode" pattern="^[a-zA-Z0-9 ]+$" id="bar_inp<?= $pro['id']; ?>" placeholder="Scan / Type & enter">
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <button class="btn btn-danger btn-sm w-100 me-2 remove_barcode" data-product_id="<?= $pro['id']; ?>">Remove </button>
                                            <button class="btn btn-primary btn-sm w-100 generate_barcode" data-product_id="<?= $pro['id']; ?>">Generate </button>
                                        </div>

                                        <div class="mb-2 <?php if (empty(trim($pro['barcode']))): ?>d-none<?php endif ?>" id="bar_box<?= $pro['id']; ?>">
                                            <img src="<?= base_url('generate_barcode') ?>?text=<?= $pro['barcode']; ?>&size=80&SizeFactor=4&print=true" id="bar_img<?= $pro['id']; ?>" class="w-100">
                                        </div>

                                        <div class="d-flex justify-content-between"> 
                                            <div class="my-auto">
                                                <input type="number" id="barcode_qty<?= $pro['id']; ?>" class="form-control text-center form-control-sm mb-0" data-product_name="<?= $pro['product_name']; ?>"  name="quantity" min="1" value="1" style="width: 75px;">
                                            </div> 

                                            <button class="btn btn-outline-dark btn-sm w-100" onclick="BarcodePrint('bar_inp<?= $pro['id']; ?>','barcode_qty<?= $pro['id']; ?>')">Print</button>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- Barcode Modal -->





                        



                        <div class="d-flex justify-content-between mt-2 ">
                            <h6 class="card-title prohead cursor-pointer">
                                <a class="text-dark href_loader" href="<?= base_url('products/edit'); ?>/<?= $pro['id']; ?>">
                                    <?= $pro['product_name']; ?>
                                </a>
                            </h6>
                            <div class="clearfix <?php if(!is_medical(company($user['id']))){echo "d-none";} ?> ">
                                <span><b><?= $pro['bin_location']; ?></b></span>
                            </div>
                        </div>
                            
                            
                        
                        

                        <?php if(!is_online_shop(company($user['id']))): ?> 
                            <div class="">

                                <a class=" text-muted cursor-pointer" data-bs-toggle="modal" data-bs-target="#barcodemodal<?= $pro['id']; ?>"><i class="bx bx-barcode-reader"></i> Barcode</a>
                            </div>
                        <?php endif ?>

                        <?php if ($pro['product_method']=='product'): ?>
                        <div class="clearfix">
                            <p class="mb-0 float-start">
                                <small>
                                    <?php if (!empty($pro['category'])): ?>
                                        <?= name_of_category($pro['category']); ?>
                                    <?php endif ?>
                                    <?php if (!empty($pro['sub_category'])): ?>
                                        /<?= name_of_sub_category($pro['sub_category']); ?>
                                    <?php endif ?>
                                    <?php if (!empty($pro['sec_category'])): ?>
                                        /<?= name_of_sec_category($pro['sec_category']); ?>
                                    <?php endif ?>
                                </small>
                            </p>
                            
                        </div>
                        <?php endif ?>


                        

                        <?php if ($pro['product_method']=='product'): ?>
                        <div class="clearfix mt-2">
                            <small class="mb-0 float-start aitsun-fw-bold"><span class="me-2 text-decoration-line-through text-secondary text-danger"><?= currency_symbolfor_sms($pro['company_id']); ?><?= $pro['discounted_price']; ?></span></small>
                            
                            <small class="mb-0 float-end aitsun-fw-bold">
                                <span class="text-success">
                                    <?= currency_symbolfor_sms($pro['company_id']); ?>
                                    <?php if (get_setting(company($user['id']),'display_price')=='mrp'): ?>
                                        <?= $pro['mrp']; ?>

                                    <?php elseif(get_setting(company($user['id']),'display_price')=='sales_price'): ?>
                                         <?= $pro['price']; ?>
                                    <?php elseif(get_setting(company($user['id']),'display_price')=='purchased_price'): ?>
                                        <?= $pro['purchased_price']; ?>
                                    <?php else: ?>
                                        <?= $pro['price']; ?>   
                                    <?php endif ?>  
                                </span>
                            </small>
                            

                        </div>
                        <?php endif ?>  


                        <?php if ($pro['product_method']=='product'): ?>
                        <div class="row mt-2 border-top border-bottom pb-2 pt-2">
                            <div class="col-md-6 col-6">

                                <p class="mb-0">
                                    <span>Stock : <strong class="text-facebook"><?= number_format(balance(company($user['id']),ledger_id_of_product(company($user['id']),$pro['id']),'closing_balance','stock'),2,'.',''); ?></strong></span>
                                </p>
                                    
                            </div>
                            <div class="col-md-6 col-6 text-end">
                                <p class=" mb-0">
                                    <span>Unit : <strong class="text-facebook"><?= name_of_unit($pro['unit']); ?><?= name_of_unit($pro['sub_unit']); ?></strong></span>
                                </p>
                            </div>
                        </div>

                    <?php else : ?>

                        <div class="row mt-2 border-top  pb-2 pt-2">
                            <div class="col-md-6 col-6">

                                <small class="mb-0 aitsun-fw-bold"><span class="text-success"><?= currency_symbolfor_sms($pro['company_id']); ?><?= $pro['price']; ?></span></small>
                                    
                            </div>
                            <div class="col-md-6 col-6 text-end">
                                <p class=" mb-0">
                                    <span>Unit : <strong class="text-facebook"><?= name_of_unit($pro['unit']); ?></strong></span>
                                </p>
                            </div>
                        </div>



                    <?php endif ?>  


                        <?php if (is_online_shop(company($user['id']))): ?>

                        <?php if ($pro['product_method']=='product'): ?>

                        <div class="row px-2 pb-1 pt-1">

                            <div class="col-md-6 col-6 my-auto">
                                
                            <a data-url="<?php echo base_url('google_services/sync_product_to_google'); ?>/<?= $pro['id']; ?>" class="btn-dark btn-sm sync_to_google_shop" title="Google Shopping" 
                                data-idd="<?= $pro['id']; ?>"
                                data-unit="<?= name_of_unit($pro['unit']); ?>"
                                data-brand="<?= name_of_brand($pro['brand']); ?>"
                                data-category="<?= name_of_category($pro['category']); ?>"
                                data-sub_category="<?= name_of_sub_category($pro['sub_category']); ?>"
                                data-sec_category="<?= name_of_sec_category($pro['sec_category']); ?>"
                            >
                              <i class="lni lni-google text-google"></i>
                            </a>
                            </div>

                            <div class="col-md-6 col-6 text-end">

                                <a class="href_loader" href="<?= base_url('products/product_rating'); ?>/<?= $pro['id']; ?>"><i class="bx bxs-star text-warning font-22"></i></a>
                                    
                            </div>
                            
                        </div>

                        <div class="row text-center px-4 pt-1  border-top">
                          
                            <div class="col-md-3 col-3">
                                <label for="id-of-top<?= $pro['id']; ?>" class="custom-checkbox" title="Top product">
                                    <input type="checkbox" id="id-of-top<?= $pro['id']; ?>"
                                    <?php if ($pro['top']==1) { echo 'checked';} ?> />
                                        <i class="bx bx-heart"></i>
                                        <i class="bx bxs-heart <?php if ($pro['top']==1) { echo 'removetop';}else{echo 'addtop';} ?>" data-pid="<?= $pro['id']; ?>"></i>
                                </label>
                            </div>
                            
                            <div class="col-md-3 col-3">
                    <label for="id-of-deals<?= $pro['id']; ?>" class="custom-checkbox" title="Deals of day">
                      <input type="checkbox" id="id-of-deals<?= $pro['id']; ?>"
                      <?php if ($pro['deals_of_day']==1) { echo 'checked';} ?>/>
                      <i class="bx bx-toggle-right"></i>
                      <i class="bx bxs-toggle-left <?php if ($pro['deals_of_day']==1) { echo 'removedeals';}else{echo 'adddeals';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                    </label>
                </div>

                <div class="col-md-3 col-3">
                    <label for="id-of-top_seller<?= $pro['id']; ?>" class="custom-checkbox" title="Top seller">
                      <input type="checkbox" id="id-of-top_seller<?= $pro['id']; ?>"
                      <?php if ($pro['top_seller']==1) { echo 'checked';} ?>/>
                      <i class="bx bx-check-circle"></i>
                      <i class="bx bxs-check-circle <?php if ($pro['top_seller']==1) { echo 'removetop_seller';}else{echo 'addtop_seller';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                    </label>
                </div>

                <div class="col-md-3 col-3">
                    <label for="id-of-online<?= $pro['id']; ?>" class="custom-checkbox" title="Online">
                    <input type="checkbox" id="id-of-online<?= $pro['id']; ?>"
                    <?php if ($pro['online']==1) { echo 'checked';} ?>/>
                    <i class="bx bx-hide"></i>
                    <i class="bx bxs-show <?php if ($pro['online']==1) { echo 'removeonline';}else{echo 'addonline';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                  </label>
                </div>

                        </div>

                        <div class="row text-center px-4 pt-1 mt-2 ">

                            <div class="col-md-3 col-3">
                                <label for="id-of-latest_product<?= $pro['id']; ?>" class="custom-checkbox" title="latest product">
                                  <input type="checkbox" id="id-of-latest_product<?= $pro['id']; ?>"
                                  <?php if ($pro['latest_product']==1) { echo 'checked';} ?>/>
                                  <i class="bx bx-checkbox"></i>
                                  <i class="bx bx-checkbox-square <?php if ($pro['latest_product']==1) { echo 'removelatestproduct';}else{echo 'addlatestproduct';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                </label>
                            </div>

                            <div class="col-md-3 col-3">
                                <label for="id-of-flash_seller<?= $pro['id']; ?>" class="custom-checkbox" title="Flash Seller">
                                  <input type="checkbox" id="id-of-flash_seller<?= $pro['id']; ?>"
                                  <?php if ($pro['flash_seller']==1) { echo 'checked';} ?>/>
                                  <i class="bx bx-purchase-tag-alt"></i>
                                  <i class="bx bxs-purchase-tag-alt <?php if ($pro['flash_seller']==1) { echo 'removeflashseller';}else{echo 'addflashseller';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                </label>
                            </div>

                            <div class="col-md-3 col-3">
                                <label for="id-of-upsell_product<?= $pro['id']; ?>" class="custom-checkbox" title="Upsell Product">
                                  <input type="checkbox" id="id-of-upsell_product<?= $pro['id']; ?>"
                                  <?php if ($pro['upsell_product']==1) { echo 'checked';} ?>/>
                                  <i class="bx bx-store-alt"></i>
                                  <i class="bx bxs-store-alt <?php if ($pro['upsell_product']==1) { echo 'removeupsellproduct';}else{echo 'addupsellproduct';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                </label>
                            </div>

                         
                            <div class="col-md-3 col-3">
                                <label for="id-of-product_group1<?= $pro['id']; ?>" class="custom-checkbox" title="Home products">
                                  <input type="checkbox" id="id-of-product_group1<?= $pro['id']; ?>"
                                  <?php if ($pro['product_group1']==1) { echo 'checked';} ?>/>
                                  <i class="bx bx-grid-vertical"></i>
                                  <i class="bx bx-grid-horizontal <?php if ($pro['product_group1']==1) { echo 'removeproductgroup1';}else{echo 'addproductgroup1';} ?> " data-pid="<?= $pro['id']; ?>"></i>
                                </label>
                            </div>



                            
                        </div>
                        <div class=" row border-top mt-2"></div>
                        <?php endif ?>

                        <?php endif ?>
                        


                        <div class="mt-2 d-flex justify-content-between">
                                
                            <a href="<?php echo base_url('products/edit'); ?>/<?= $pro['id']; ?>" class="btn btn-primary btn-sm w-100 me-1 href_loader" title="Edit" ><i class="bx bx-pencil me-0" style="font-size:17px;"></i></a>
                        
                            <?php if(is_online_shop(company($user['id']))): ?>
                                
                                <?php if ($pro['product_method']=='product'): ?>
                                <a href="<?php echo base_url('products/long_edit/'); ?>/<?= $pro['id']; ?>" class="btn btn-dark btn-sm w-100 "  title="Rich edit"><i class="bx bx-edit me-0" style="font-size:17px;"></i></a>
                                <?php endif ?>
                            <?php endif ?>

                            <a data-url="<?php echo base_url('products/delete'); ?>/<?= $pro['id']; ?>" class="btn btn-danger btn-sm w-100 ms-1 product_delete" title="delete"><i class="bx bx-trash me-0" style="font-size:17px;"></i></a>
                                        
                        </div>


                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if ($pi<1): ?>
                <div class="col-12 text-center mb-3"> 
                    <div class="card ">
                        <h6 class="text-danger mb-0 py-5">No items</h6>
                    </div>
                </div>
            <?php endif ?>

        </div><!--end row-->





      
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('products/requests'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bx-question-mark ms-2"></i> <span class="my-auto">Requests</span></a>/
        <a href="<?= base_url('products/easy_edit'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-edit-alt ms-2"></i> <span class="my-auto">Easy Edit</span></a>/
        <a data-bs-toggle="modal" data-bs-target="#sync_select" class="text-dark font-size-footer me-2"><i class="bx bxs-book-bookmark ms-2"></i> <span class="my-auto">Sync to branch</span></a>/
        <a data-url="<?php echo base_url('google_services/sync_product_to_google/'); ?>"id="sync_all_to_google_shop" title="Google Shopping" class="text-dark font-size-footer me-2"><i class="lni lni-google text-google ms-2"></i> <span class="my-auto">Sync all</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 





</div>





    <script type="text/javascript">
        function BarcodePrint(input_box,qty_box) {

        
        var barcode_val=document.getElementById(input_box).value;
        var product_name=document.getElementById(input_box).getAttribute('data-product_name');

        if (document.getElementById(qty_box).value<=0) {
            var barcode_qty=1;
        }else{
            var barcode_qty=document.getElementById(qty_box).value;
        }
        
        // alert(barcode_qty)
        


        const data = [
            {
                type: 'text',                       // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: product_name,
                style: { textAlign: "center", color: "black", marginTop: "0px", marginBottom:"0px"}
            },
        ];


        for (let i = 0; i < barcode_qty; i++) {
            data.push({
                  type: 'barCode',
                  value: barcode_val,
                  height: 70,                     // height of barcode, applicable only to bar and QR codes
                  width: 2,                       // width of barcode, applicable only to bar and QR codes
                  displayValue: true,             // Display value below barcode
                  fontsize: 18,
            });

            
        }

        

        const options = {
            preview: <?= get_setting(company($user['id']),'bar_preview') ?>,
             width:'<?= get_setting(company($user['id']),'bar_body_width') ?>px',
            margin: '<?= get_setting(company($user['id']),'bar_margin1') ?>px <?= get_setting(company($user['id']),'bar_margin2') ?>px <?= get_setting(company($user['id']),'bar_margin3') ?>px <?= get_setting(company($user['id']),'bar_margin4') ?>px',            // margin of content body
            copies: <?= get_setting(company($user['id']),'bar_copies') ?>,                    // Number of copies to print
            printerName: '<?= get_setting(company($user['id']),'bar_printer1') ?>',        // printerName: string, check with webContent.getPrinters()
            timeOutPerLine: 400,
            pageSize: { height: <?php echo (get_setting(company($user['id']),'bar_height')>0) ? get_setting(company($user['id']),'bar_height') : '301000'; ?> , width: <?php echo (get_setting(company($user['id']),'bar_width')>0) ? get_setting(company($user['id']),'bar_width') : '71000'; ?> },
            silent:<?= get_setting(company($user['id']),'bar_silent') ?>,
            dpi: <?= get_setting(company($user['id']),'bar_dpi') ?>,
            header: '<?= get_setting(company($user['id']),'bar_header') ?>',
            footer: '<?= get_setting(company($user['id']),'bar_footer') ?>',
        }
         var print_data=JSON.stringify(data);
         var printer_data=options;

         var full_arr = [];
         full_arr.push(print_data, printer_data);
         window.api.main_print('toMain', full_arr);
        }
    </script>