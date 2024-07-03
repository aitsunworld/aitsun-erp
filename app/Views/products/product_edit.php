<script type="text/javascript">
    $(document).ready(function(){
        $('#long_description').summernote({
          tabsize: 2,
          height: 100
        });
    })
</script>

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
                    <b class="page_heading text-dark">Edit Product</b>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= reduce_chars($pro['product_name'],27); ?>...</b>
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
<div class="toolbar d-flex justify-content-end">

    <div class="d-flex">
        
        <div class="my-auto">         

            <div class="my-auto">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <?php if (next_product($pro['id'],'prev',company($user['id']))!='no product'): ?>
                        <a href="<?= base_url('products/edit') ?>/<?= next_product($pro['id'],'prev',company($user['id'])); ?>" class=" aitsun-primary-btn-topbar  font-size font-size-footer href_loader me-1">
                            <i class="bx bx-left-arrow"></i> Prev
                        </a>
                    <?php endif ?>
                    <?php if (next_product($pro['id'],'next',company($user['id']))!='no product'): ?>
                        <a href="<?= base_url('products/edit') ?>/<?= next_product($pro['id'],'next',company($user['id'])); ?>" class=" aitsun-primary-btn-topbar  font-size-footer font-size href_loader">
                        Next
                        <i class="bx bx-right-arrow"></i> 
                    </a>
                    <?php endif ?>
                
                </div>
            </div>
            
        </div>
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<div class="sub_main_page_content">

    <div class="card">
      <div class="card-body ">
          
           <form method="post" id="edit_product_form" action="<?= base_url('products/update_product') ?>/<?= $pro['id']; ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-body ">
                <div class="row">
                   <div class="col-lg-8">
                   <div class="rounded">
                      <div class="mb-3">
                        <label for="inputProductTitle" class="form-label">Product Title <small class="font-weight-bold text-danger">*</small></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter product title" value="<?= $pro['product_name']; ?>">
                      </div>
                      <div class="mb-3">
                        <label for="inputProductTitle" class="form-label">Slug <small class="font-weight-bold text-danger">*</small></label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="<?= $pro['slug']; ?>">
                      </div>

                      <div class="mb-3">
                                     
                    <span class="my-auto">Type: <small class="font-weight-bold text-danger">*</small></span>
                    <div class="d-flex mt-2">
                      
                    
                      <div class="d-flex my-auto me-4">
                        <input type="radio" name="product_method" class="form-check-input" value="product"  <?php if ($pro['product_method']=='product') {echo 'checked';} ?> id="product_method_product">
                        <label class="my-auto ms-2">Product</label>
                      </div>

                      <div class="d-flex my-auto ">
                        <input type="radio" name="product_method" class="form-check-input" value="service" <?php if ($pro['product_method']=='service') {echo 'checked';} ?> id="product_method_service">
                        <label class="my-auto ms-2">Service</label>
                      </div>
                    </div>
                  </div>

                  
                    
                  
                     <div class="remove_service <?php if ($pro['product_method']=='service') {echo 'd-none';} ?>">


                        <?php  if (check_permission($user['id'],'stock_management')==true || $user['u_type']=='admin'): ?>
                      <div class="mb-3">


                            <div class="d-flex w-100">
                                <div class="my-auto w-100">
                                    <label for="input-2" class="form-label">Opening Stock</label>
                                    <input type="number" name="stock" min="0" class="form-control" id="pstock" value="<?= $pro['opening_balance']; ?>" required>

                                    <input type="hidden" name="current_opening_balance" min="0" class="form-control" id="pstock" value="<?= $pro['opening_balance']; ?>" >
                                    <input type="hidden" name="current_closing_balance" min="0" class="form-control" id="pstock" value="<?= $pro['closing_balance']; ?>" >

                                </div>
                                <div class="my-auto " style="max-width:200px;">
                                    <label for="input-2" class="form-label">At price</label>
                                    <input type="number" name="at_price" min="0" class="form-control" id="at_price" value="<?= aitsun_round($pro['at_price'],get_setting(company($user['id']),'round_of_value')); ?>" required >
                                </div>
                            </div>

                      </div>
                    <?php endif; ?>


                    </div>

         <div class="mb-3 d-none-on-bill">
            <div class="form-check form-switch " > 
            <label for="is_rental"><input type="checkbox" class="form-check-input is_rental" id="is_rental" name="is_rental" value="1" <?= ($pro['is_rental'])?'checked':''; ?> > Is rental product</label>
        </div>


        <div id="pricelist_block" class="<?= ($pro['is_rental'])?'':'d-none'; ?> ">
            <div class="aitsun_table">
                    <table class="erp_table aitsun_table table-bordered">
                  <thead>
                    <tr>
                      <th>Period</th> 
                      <th>Price</th>
                      <th><button class="no_load btn btn-outline-light rental_price_add-more  btn-sm" type="button"><b>+</b></button></th>
                    </tr>
                  </thead>
                  <tbody class="after-rental_price_add-more">
                    <input type="hidden" name="i_id[]">
                    <input type="hidden" name="period_id[]">
                    <input type="hidden" name="rental_price[]">



                    <?php $pl_no=0; foreach (price_list_of_product($pro['id']) as $pl): $pl_no++; ?> 
                        <input type="hidden" name="i_id[]" value="<?= $pl['id'] ?>">
                          <tr class="after-rental_price_add-more-tr"> 
                            <td class="w-100">
                                <div class="d-flex w-100">
                                    <div class="position-relative fsc field_select_container w-100">
                                        <select name="period_id[]" class="form-select position-relative w-100" data-blockid="" > 
                                            <?php foreach (rental_periods_array(company($user['id'])) as $rp): ?>
                                                <option value="<?= $rp['id'] ?>" <?= ($pl['period_id']==$rp['id'])?'selected':'' ?>><?= $rp['period_name'] ?></option> 
                                            <?php endforeach ?>
                                    </select>  
                                    </div> 
                                </div>
                            </td>
                            <td><input type="number" step="any" name="rental_price[]" class="form-control " style="width: 200px;" value="<?= aitsun_round($pl['price'],get_setting(company($user['id']),'round_of_value')) ?>"></td>
                            <td class="change"> 
                                <a class="btn btn-danger btn-sm no_load rental_remove text-white"><b>-</b></a> 
                            </td>
                          </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
            </div> 
        </div>
          </div>
                                  
                                  
                  <div class="mb-3 ">
                    <label for="inputProductDescription" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3"><?= $pro['description']; ?></textarea>
                  </div>
                  

                  <div class="mb-3">
                    
                    <label for="inputProductDescription" class="form-label">Featured Image (320 X 320)</label>
                    <br>
                    

                    <div class="row web_pageeefro " id="featured_upload_form">
                      <input type="file" accept="image/*" id="featured_image" name="featured_image">
                      <p id="p_text">
                          
                          <img class="fe_img" src="<?= base_url(); ?>/public/images/products/<?php if( $pro['pro_img'] !=''){echo $pro['pro_img']; }else{echo 'prod.png';} ?>">

                      </p>
                    </div>

                    <input type="hidden" name="old_featured_image" value="<?= $pro['pro_img']; ?>">
                    <br>
                    <label for="inputProductDescription " class="form-label <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">Thumbnail Images (320 X 320)</label>
                    <br>

                    <div class="row web_pageeefro <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>" id="thumb_upload_form">
                      <input type="file" id="thumbnail_images" name="thumbnail_images[]" accept="image/*" multiple>
                      <p id="p_text">Thumbnail Image</p>
                    </div>

                  </div>

  <div class="mb-3 d-md-flex <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">

    <?php foreach (product_thumbnails_array($pro['id']) as $pro_image): ?>  

      <div class="protumb_cont mr-2 position-relative <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
        <img src="<?= base_url(); ?>/public/images/products/<?= $pro_image['image'] ?>" style=" width: auto; border-radius: 3px; height: 55px;">
        <a class="thumbdel" data-url="<?= base_url('products/delete_thumb'); ?>/<?= $pro_image['id'] ?>/<?= $pro['id'] ?>"><i class="bx bx-trash-alt"></i></a>
      </div>
      <?php endforeach ?>

      <div class="protumb_cont mr-2 position-relative d-flex">
        <a href="<?= base_url('products/edit'); ?>/<?= $pro['id']; ?>" class="my-auto <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">Refresh</a>
      </div>
  </div>

        <div class="remove_service <?php if ($pro['product_method']=='service') {echo 'd-none';} ?>">
                  


                  <div class="mb-3 <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
                    <label for="inputProductDescription" class="form-label">Keywords (word1,word2,...n)</label>
                    <textarea class="form-control" name="keywords" id="keywords" rows="3"><?= $pro['keywords']; ?></textarea>
                  </div>



                        <div class="col-md-12 mb-3" style=" background: #dadbdd; border-radius: 10px;">
                <div class="row p-2">

                    <div class="form-group col-md-12 mb-3">
                      <label for="input-4" class="">Product Code</label>
                      <input name="product_code" type="text" class="form-control" value="<?= $pro['product_code']; ?>">
                      <input name="product_color" type="hidden" class="form-control" value="<?= $pro['product_color']; ?>">
                  </div>

                  <div class="d-none">
                        <select class="d-none" id="add_field_items">
                        <?php foreach (fields_name_array(company($user['id'])) as $fn): ?>
                            <option value="<?= $fn['fields_name'] ?>" data-fid="<?= $fn['id'] ?>"><?= $fn['fields_name'] ?></option>
                        <?php endforeach ?> 
                    </select>
                    </div>

                  <div class="form-group col-md-12 <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
                      <label for="input-4" class="">Additional fields</label>
                      <table class="table table-light table-bordered">
                        <thead>
                          <th>Switch</th>
                            <th>
                                <div class="d-flex justify-content-between">
                                    <div class="my-auto">Field <small>(Ex: RAM)</small></div>
                                    
                                </div>
                            </th>
                            <th>Value <small>(Ex: 2GB)</small></th>
                            <th><button class="no_load btn btn-outline-dark add-more  btn-sm" type="button"><b>+</b></button></th>
                        </thead>
                        <tbody class="after-add-more">
                          <?php foreach (additional_fields_array($pro['id']) as $pd): ?> 
                            <tr class="after-add-more-tr">
                                <td>
                                    <div class="form-check form-switch">
                                                    <input class="form-check-input checkingrollbox" type="checkbox" id="switchableid<?= $pd['id']; ?>" <?php if ($pd['switchable']==1) {echo 'checked';} ?>>
                                                    <input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="switchable[]" type="hidden" value="<?= $pd['switchable']; ?>">
                                                    <label class="form-check-label" for="switchableid<?= $pd['id']; ?>"></label>
                                                </div>
                                </td>

                              <td>
                                <div class="d-flex">
                                    <div class="position-relative fsc field_select_container<?= $pd['id'] ?>">
                                        <select name="field_name[]" class="form-select select2 field_select" data-blockid="<?= $pd['id'] ?>" id="field_select<?= $pd['id'] ?>" style="width: 200px;">
                                            <option value="" data-fid="">Search</option>
                                            <?php foreach (fields_name_array(company($user['id'])) as $fn): ?>
                                                <option value="<?= $fn['fields_name'] ?>" data-fid="<?= $fn['id'] ?>" <?php if($pd['field_name']==$fn['fields_name']){echo 'selected';} ?>><?= $fn['fields_name'] ?></option>
                                            <?php endforeach ?> 
                                        </select>
                                         
                                    </div>
                                <a class="ml-2 my-auto btn btn-sm btn-info add_fields_input" id="add_fields_input<?= $pd['id'] ?>" data-blockid="<?= $pd['id'] ?>">+</a>
                                <a class="ml-2 d-none my-auto btn btn-sm btn-facebook save_fields_input" id="save_add_field<?= $pd['id'] ?>" data-blockid="<?= $pd['id'] ?>"><i class="bx bx-x"></i></a>
                                </div>

                              </td>

                              <td><input type="text" name="field_value[]" class="form-control" value="<?= get_value_of_field($pd['field_name'],$pro['id']); ?>"></td>

                              <td class="change"><a class="btn btn-danger btn-sm no_load  remove text-white"><b>-</b></a></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                  </div>

                 

                  
                </div>
               </div> 


               


                                    </div>

                                </div>
                               </div>
                               <div class="col-lg-4">
                                <div class="rounded">
                                  <div class="row g-3">
                                    <div class="col-md-12">

                                        <div class="remove_service <?php if ($pro['product_method']=='service') {echo 'd-none';} ?>">

                                            <div class="col-md-12 mb-3">
                        
                                                    <label for="inputProductTitle" class="form-label">MRP <small class="font-weight-bold text-danger">*</small></label>
                                                    <div class="">
                                                        <input type="number" min="0" step="any" class="form-control" id="pmrp" name="mrp" placeholder="Max Retail Price" value="<?= $pro['mrp'] ?>">
                                                        <div class="d-flex mt-2 w-100">
                                                             <div class="w-100">
                                                                <label>Pur. margin (%)</label>
                                                                <input type="number" min="0" step="any" class="form-control me-1" id="p_margin" name="purchase_margin" value="<?= $pro['purchase_margin'] ?>" placeholder="Pur. Disc %">
                                                             </div>
                                                             <div class="w-100">
                                                                <label>Sale margin (%)</label>
                                                                <input type="number" min="0" step="any" class="form-control ms-1" id="s_margin" name="sale_margin" value="<?= $pro['sale_margin'] ?>" placeholder="Sale. Disc %">
                                                             </div>
                                                        </div>
                                                    </div>
                                                    
                                            </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="inputProductTitle" class="form-label">Purchase Price <small class="font-weight-bold text-danger">*</small></label>
                                            
                                            <div class="d-flex">
                                                    <input type="number" min="0" step="any" class="form-control" id="pprice" name="purchased_price" placeholder="Price" value="<?= aitsun_round($pro['purchased_price'],get_setting(company($user['id']),'round_of_value')); ?>">

                                                    <div style="width: 134px;">
                                                        <select class="form-control" name="purchase_tax">
                                                            <option value="1"  <?php if ($pro['purchase_tax']=='1') {echo 'selected';} ?>>With Tax</option>
                                                            <option value="0"  <?php if ($pro['purchase_tax']=='0') {echo 'selected';} ?>>Without Tax</option>
                                                        </select>
                                                    </div>
                                            </div>

                                        </div>

                                    </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <label for="inputProductTitle" class="form-label">Selling Price <small class="font-weight-bold text-danger">*</small></label>
                                                <div>
                                                    <a class="btn btn-sm-primary p-0" id="add_pro_diss" style="font-size: 14px;">
                                Discounted price 
                              </a>
                              <span id="showprice"><input type="checkbox" id="checkbooox" class="checkbooox" data-proid="" <?php if ($pro['discounted_price']!=0) {echo 'checked';} ?> ><span id="showspan" class="ps-1"><?= $pro['discounted_price']; ?></span></span>
                              </div>
                                            </div>

                         <div  class="d-flex">
                      <div id="discout_container_product" class=" mb-2 " style="display: none;">
                        <input type="number" name="discounted_price" id="discounted" class="ad_u" value="<?= $pro['discounted_price']; ?>">
                        <button class="mr-2 adddd_discountbtn_btn adddd_unit_btn  save_dis" id="save_dis" data-proid="" type="button">Ok</button>
                      </div>
                    </div>

                    <div class="d-flex">
                                            <input type="number" min="0" value="<?= aitsun_round($pro['price'],get_setting(company($user['id']),'round_of_value')); ?>" step="any" class="form-control" id="psellprice" name="price" placeholder="Selling Price">

                                                <div style="width: 134px;">
                                                    <select class="form-control" name="sale_tax">
                                                        <option value="1" <?php if ($pro['sale_tax']=='1') {echo 'selected';} ?>>With Tax</option>
                                                        <option value="0" <?php if ($pro['sale_tax']=='0') {echo 'selected';} ?>>Without Tax</option>
                                                    </select>
                                                </div>
                                                </div>
                                        </div>


                                     
                                      <div class="col-12 mb-2">
                                        
                                            <label for="inputProductType" class="form-label my-auto">Unit <small class="font-weight-bold text-danger">*</small></label>
                                            <?php if (item_has_transaction($pro['id'])): ?>
                                                <span style="display: block; color:red; font-size: 11px;">You are unable to alter the primary unit because this item has transactions.</span> 
                                            <?php endif ?> 
                                        <select class="form-select <?php if (item_has_transaction($pro['id'])): ?>readonly_select<?php endif ?>" title="" data-proid="" name="unit" id="unit" >
                                            <option value="">Choose</option>
                                            <?php foreach (products_units_array(company($user['id'])) as $pu): ?>
                                            <option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>>
                                                <?= $pu['name']; ?>
                                            </option>
                                            <?php endforeach ?>
                                          </select>
                                      </div>


                                      

                                      <div class="col-12 mb-2">
                                        
                                            <label for="inputCollection" class="form-label my-auto">Sub Unit <small class=" text-danger" id="subuer">*</small></label>
                                            
                                            <select class="form-select subu"  name="sub_unit" id="sub_unit">
                                            <option value="">None</option>
                                            <?php foreach (products_units_array(company($user['id'])) as $pu): ?>
                                            <option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>>
                                                <?= $pu['name']; ?>
                                            </option>
                                            <?php endforeach ?> 
                                          </select>
                                      </div>


                                      <div class="col-12 mb-2 add_conversion <?php if ($pro['sub_unit']=='') {echo 'd-none';} ?>">
                                            <label for="inputCollection" class="form-label my-auto">Conversion Rate</label>

                                            <input type="number" min="0" step="any" class="form-control" id="conversion_unit_rate" name="conversion_unit_rate" placeholder="Conversion Rate" value="<?= $pro['conversion_unit_rate']?>">
                                      </div>


                                      <div class="remove_service <?php if ($pro['product_method']=='service') {echo 'd-none';} ?>">
                                      <div class="col-12 mb-2">

                                        <div class="d-flex justify-content-between">
                                                <label for="inputVendor" class="form-label my-auto">Brand <small class="font-weight-bold text-danger">*</small></label>
                                                 <a class="p-0 add_pro_brand" id="add_pro_brand" data-proid=""><i class="bx bxs-plus-square " style="font-size: 25px;"></i></a>
                                            </div>

                                            <div  class="d-flex">
                        <div id="brand_container_product" class=" mb-2 " style="display: none;">
                          <input type="text" name="brand_name" id="brand_name" class="ad_u">
                          <button class="mr-2 adddd_unit_btn addd_brand" id="addd_brand" data-proid="" type="button">Add</button>
                        </div>
                        
                     </div>
 
                                        <select class="form-select" name="brand" id="brand">
                                            <option value="">Choose</option>
                                            <?php foreach (products_brands_array(company($user['id'])) as $pb): ?>
                                            <option value="<?= $pb['id']; ?>" <?php if ($pro['brand']==$pb['id']) {echo 'selected';} ?>>
                                                <?= $pb['brand_name']; ?>
                                            </option>
                                            <?php endforeach ?>
                                          </select>
                                      </div>
                                    </div>


                                    
                                      <div class="col-12 mb-2">

                                        <div class="d-flex justify-content-between">
                                            <label for="inputCollection" class="form-label my-auto">Category <small class="font-weight-bold text-danger">*</small></label>
                                            <a class=" p-0 add_pro_cat" id="add_pro_cat" data-proid=""><i class="bx bxs-plus-square" style="font-size: 25px;"></i></a>
                                        </div>
                                        
                                        <div  class="d-flex">
                      <div id="cat_container_product" class=" mb-2 " style="display: none;">
                        <input type="text" name="cat_name" id="cat_name" class="ad_u">
                        <button class="mr-2 adddd_unit_btn addd_cate" id="addd_cate" data-proid="" type="button">Add</button>
                      </div>
                     </div>

                                        <select class="form-select parc" data-proid="" name="category" id="category">
                                            <option value="">Select category</option>
                                            <?php foreach (product_categories_array(company($user['id'])) as $pc): ?>
                                                <option value="<?= $pc['id']; ?>" <?php if ($pro['category']==$pc['id']) {echo 'selected';} ?>>
                                                    <?= $pc['cat_name']; ?>
                                                </option>
                                            <?php endforeach ?>
                                          </select>
                                      </div>


                                      <div class="col-12 mb-2">

                                        <div class="d-flex justify-content-between">
                                            <label for="inputCollection" class="form-label my-auto">Sub Category</label>
                                            <a class="p-0 add_pro_subcat" id="add_pro_subcat" data-proid=""><i class="bx bxs-plus-square " style="font-size: 25px;"></i></a>
                                            </div>

                                            <div  class="d-flex">
                        <div id="subcat_container_product" class=" mb-2 " style="display: none;">
                          <input type="text" name="subcat_name" id="subcat_name" class="ad_u">
                          <button class="mr-2 adddd_unit_btn addd_subcate" id="addd_subcate" data-proid="" type="button">Add</button>
                        </div>
                        
                     </div>

                                        <select class="form-select subc" data-proid="" name="sub_category" id="sub_category">
                                            <option value="<?= $pro['sub_category']; ?>"><?= name_of_sub_category($pro['sub_category']); ?></option>
                                          </select>
                                      </div>
                                      <div class="col-12 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <label for="inputCollection" class="form-label my-auto">Secondary Category</label>
                                                 <a class=" p-0 add_pro_seccat" id="add_pro_seccat" data-proid=""><i class="bx bxs-plus-square " style="font-size: 25px;"></i></a>
                      </div>
                        <div  class="d-flex">
                        <div id="seccat_container_product" class=" mb-2" style="display: none;">
                          <input type="text" name="subcat_name" id="seccat_name" class="ad_u">
                          <button class="mr-2 adddd_unit_btn addd_seccate" id="addd_seccate" data-proid="" type="button">Add</button>
                        </div>
                     </div>

                                        <select class="form-select" name="secondary_category" id="secondary_category">
                                            <option value="<?= $pro['sec_category']; ?>"><?= name_of_sec_category($pro['sec_category']); ?></option>
                                          </select>
                                      </div>

                                      <div class="remove_service <?php if ($pro['product_method']=='service') {echo 'd-none';} ?>">

                           
                            <div class="col-12 mb-2">
                          <label for="input-4" class="form-label">Expiry date</label>
                          <input type="date" name="ex_date" class="form-control modal_inpu" value="<?= $pro['expiry_date']; ?>">
                         </div>

                         <div class="col-12 mb-2">
                          <label for="input-4" class="form-label">Batch No</label>
                          <input type="text" name="batch_no" class="form-control modal_inpu" value="<?= $pro['batch_no']; ?>">
                         </div>

                          <div class="col-12 mb-2 <?php if(!is_medical(company($user['id']))){echo "d-none";} ?> ">
                          <label for="input-4" class="form-label">Bin Location</label>
                          <input type="text" name="bin_location" class="form-control modal_inpu" value="<?= $pro['bin_location']; ?>">
                         </div>

                         <div class="col-12 mb-2">
                          <label for="input-4" class="form-label">Product identifiers (GTIN, UPC, EAN, JAN or ISBN)</label>
                          <input name="pro_in" type="text" class="form-control" value="<?= $pro['pro_in']; ?>">
                      </div>
                    </div>

                  <div class="col-12 mb-2">
                    <label for="input-4" class="form-label">Tax</label>
                    <select class="form-select" name="tax" id="tax" > 
                       <?php foreach (tax_array(company($user['id'])) as $tx): ?>
                         <option value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?> ><?= $tx['name']; ?></option>
                       <?php endforeach ?>
                    </select>
                  </div>

                  <div class="remove_service <?php if ($pro['product_method']=='service') {echo 'd-none';} ?>">
                                      <div class="col-12 mb-3 <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
                                            <label for="inputProductTitle" class="form-label">Delivery Days</label>
                                            <input type="number" min="1" class="form-control" id="delivery_days" name="delivery_days" placeholder="Delivery Days" value="<?= $pro['delivery_days']; ?>">
                                        </div>
                                    </div>
                                      
                                      <div class="col-12">
                                        <div id="error_display" class="mb-2 text-danger"></div>
                                          <div class="d-grid ">
                                            <button type="button" id="edit_save_product" class="aitsun-primary-btn ">Save Product</button>
                                          </div>
                                      </div>
                                  </div> 
                              </div>
                              </div>
                           </div><!--end row-->
                        </div>
                      </div>
                        
                       </form>
              </div>


            </div>
</div>


<script type="text/javascript">
            
            $(document).ready(function(){


    $(document).on('click','.is_rental',function(){
        if ($(this).is(':checked')) {
        $('#pricelist_block').removeClass('d-none');
    } else {
        $('#pricelist_block').addClass('d-none');
    }  
    });


    var rental_no=0;


    $(document).on("click",".rental_price_add-more",function(){  

            var options_fields=$('#add_field_items').html();

            rental_no++;


      var html = `<tr class="after-rental_price_add-more-tr">
        <td class="w-100">
            <div class="d-flex w-100">
            <input type="hidden" name="i_id[]" value="">
                <div class="position-relative fsc field_select_container w-100">
                    <select name="period_id[]" class="form-select position-relative w-100" data-blockid="" > 
                        <?php foreach (rental_periods_array(company($user['id'])) as $rp): ?>
                            <option value="<?= $rp['id'] ?>"><?= $rp['period_name'] ?></option> 
                        <?php endforeach ?>
                </select>  
                </div> 
            </div>
        </td>
        <td><input type="number" step="any" name="rental_price[]" class="form-control " style="width: 200px;"></td>
        <td class="change"><a class="btn btn-danger btn-sm no_load rental_remove text-white"><b>-</b></a></td>
      </tr>`; 
      
      $(".after-rental_price_add-more").append(html);

      $('.newsele').select2();

    });

    $(document).on("click",".rental_remove",function(){ 
      $(this).parents(".after-rental_price_add-more-tr").remove();
    });



















                var no=0;
            $(document).on("click",".add-more",function(){ 
          var options_fields=$('#add_field_items').html();

                no++;


          var html = '<tr class="after-add-more-tr"><td><div class="form-check form-switch"><input class="form-check-input checkingrollbox" type="checkbox" id="switchableided'+no+'"><input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="switchable[]" type="hidden" value="0"><label class="form-check-label" for="switchableided'+no+'"></label></div></td><td><div class="d-flex"><div class="position-relative fsc field_select_containered'+no+'"><select name="field_name[]" class="form-select select2 field_select newsele" id="field_selected'+no+'" style="width: 200px;"><option value="">Search</option>'+options_fields+'</select></div><a class="ml-2 my-auto btn btn-sm btn-info add_fields_input" id="add_fields_inputed'+no+'" data-blockid="ed'+no+'">+</a><a class="ml-2 d-none my-auto btn btn-sm btn-facebook save_fields_input" id="save_add_fielded'+no+'" data-blockid="ed'+no+'"><i class="bx bx-x"></i></a></div></td><td><input type="text" name="field_value[]" class="form-control" ></td><td class="change"><a class="btn btn-danger btn-sm no_load  remove text-white"><b>-</b></a></td></tr>'; 

          $(".after-add-more").append(html);
          $('.newsele').select2();
        });

        $(document).on("click",".remove",function(){ 
          $(this).parents(".after-add-more-tr").remove();
        });

        $(document).on("click",".removeitemkit",function(){ 
          $(this).parents(".itemparent").remove(); 
          var no_of_pros=$(".itemparent").length;
    
            if (no_of_pros!=0) {
                $('#product_container').html('<h6 class="text-center mt-2" style="color: #0fae2f;">'+no_of_pros+' items added!</h6>');
            }else{
                $('#product_container').html('');
            }
        });

    });

        $(document).on('change','.checkingrollbox',function(){
        if($(this).prop('checked')){
            $(this).siblings(".rollcheckinput").val(1);
        }else{
            $(this).siblings(".rollcheckinput").val(0);
        }
    });
 
        $(function() {
        $('#product_method_service').click(function() {
            $('.remove_service').addClass('d-none');
        });           
        $('#product_method_product').click(function() {
            $('.remove_service').removeClass('d-none');
        });
    });

        </script>