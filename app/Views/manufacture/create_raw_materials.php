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
             
                <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url('products'); ?>" class="href_loader">Products</a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url('products/manufacture'); ?>" class="href_loader">Manufacture</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Add raw materials</b>
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
<div class="toolbar d-flex justify-content-center">
    <div class="text_over_flow_1">
       <?= $pro['product_name'] ?>
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <!-- //////////////////////////////////////ITEM KIT SELECTOR/////////////////////////////// -->
            <div class="mb-3 d-none-on-bill" style=" background: #dadbdd; border-radius: 10px;">
                 <input type="text" class="d-block form-control product_selector_search w-100" placeholder="Search & add items...">
            </div> 

             <div id="show_pro" class="mb-3"></div>
     
            
            
            <form method="post" action="<?= base_url('manufacture/save_raw_material') ?>" id="raw_material_form">
                <?= csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?= $pro['id'] ?>">

                <div class="raw_material_box p-4 mb-3">
                    <span class="rm_box_head">Raw materials</span>
                    <div id="product_list" class="m-auto w-100 text-center">  

                        <?php $rcount=0; foreach (raw_materials_array($pro['id']) as $iite): $rcount++; 
                            $pro_unit=$iite['unit'];
                            $in_unit=$iite['in_unit'];
                            $pro_subunit=$iite['sub_unit']; 
                            $pro_conversion_unit_rate=$iite['conversion_unit_rate']; 

                        ?>
                        <li class="list-group-item mb-2 d-flex justify-content-between align-items-center cursor-pointer itemparent" id="proo<?= $iite['item_id'] ?>">
                            <input type="text" name="item_product_name[]" class="form-empty bg-0" value="<?= $iite['product'] ?>" style="margin-right: 15px;" readonly>

                            <input type="number" name="item_quantity[]" id="qtyite<?= $iite['item_id'] ?>" data-proid="<?= $iite['item_id'] ?>" data-price="<?= $iite['price'] ?>" class="form-light aitsun-simple-input itemkit_qty_input" value="<?= $iite['quantity'] ?>" step="any" data-row="<?= $iite['item_id'] ?>" data-proconversion_unit_rate="<?= $pro_conversion_unit_rate ?>" style="margin-right: 15px; width:100px;">

                            <select class="in_unit_material form-light aitsun-simple-input" name="in_unit[]" data-row="<?= $iite['item_id'] ?>" data-proconversion_unit_rate="<?= $pro_conversion_unit_rate ?>" id="in_unit<?= $iite['item_id'] ?>" style="margin-right: 15px;"> 
                              <option value="<?= $pro_unit; ?>" <?php if($pro_unit==$in_unit){echo "selected";} ?>><?= $pro_unit; ?></option>
                              <?php if (!empty($pro_subunit) && $pro_subunit!='None'): ?>
                                <option value="<?= $pro_subunit ?>" <?php if($pro_subunit==$in_unit){echo "selected";} ?>><?= $pro_subunit ?></option>
                              <?php endif ?> 
                            </select>


                            <input type="text" name="item_amount[]" class="form-light aitsun-simple-input totalamot no-btn" style="margin-right: 15px; width:150px;" value="<?= $iite['amount'] ?>" id="amtite<?= $iite['item_id'] ?>" readonly>



                            <input type="hidden" name="conversion_unit_rate[]" value="<?= $iite['conversion_unit_rate'] ?>">
                            <input type="hidden" name="unit[]" value="<?= $iite['unit'] ?>">
                            <input type="hidden" name="sub_unit[]" value="<?= $iite['sub_unit'] ?>">
                            <input type="hidden" name="item_product_id[]" value="<?= $iite['item_id'] ?>">
                            <input type="hidden" name="item_price[]" value="<?= $iite['price'] ?>">
                            <input type="hidden" name="purchased_price[]"  value="<?= $iite['price'] ?>">
                            <input type="hidden" name="item_selling_price[]"  value="<?= $iite['price'] ?>">
                            <input type="hidden" name="item_product_desc[]"  value="<?= $iite['desc'] ?>">
                            <input type="hidden" name="item_tax[]"  value="<?= $iite['tax'] ?>">
                            <input type="hidden" name="main_price[]" id="main_price<?= $iite['item_id'] ?>" value="<?= purchase_price($iite['item_id']) ?>"> 
                            <button type="button" class="btn-dark btn btn-sm removeitemkit rounded-pill">
                                <span class="rotate-45 d-block">+</span>
                            </button>
                        </li>
                      <?php endforeach ?>


                        <span class="m-auto" id="plus_icon" style="font-size: 30px; color: #d2235a63;"><?php if ($rcount<1){echo '+';} ?></span>
                 
                      


                    </div> 
                </div>

                  
     
                <div>
                    <button id="saveitems" type="button" class="aitsun-primary-btn">
                        Save materials
                    </button>

                    <a class="aitsun-secondary-btn" href="<?= base_url('products/manufacture/create_manufacture') ?>/<?= $pro['id'] ?>">+ Manufacture</a>
                </div> 

            </form>

           
            <!-- //////////////////////////////////////ITEM KIT SELECTOR/////////////////////////////// -->

        </div>
         
    </div> 
</div> 
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->


<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        
    </div>
</div> 