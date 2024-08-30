 <?php 
    $products_array=[]; 
    $products_array=products_array(company($user['id'])); 
    $is_sales_session=true;
      foreach ($products_array as $pro): 
        $price_list=price_list_of_product($pro['id']);
        $price_list=json_encode($price_list);
    ?>
      <a class="item_box col-md-3 my-2 procode_<?= $pro['product_code']; ?> barcode_item_<?= substr($pro['barcode'], 0, 6); ?> custom_barcode_item_<?= $pro['barcode']; ?>" href="javascript:void(0);"
        data-productid="<?= $pro['id']; ?>" 
        data-product_name="<?= str_replace('"', '&#34;', $pro['product_name']); ?>" 
        data-batch_number="<?= $pro['batch_no']; ?>" 
        data-unit="<?= $pro['unit']; ?>"
        <?php if ($view_type=='sales'): ?>
          data-price="<?= $pro['price']; ?>"
        <?php else: ?>
          data-price="<?= $pro['purchased_price']; ?>"
        <?php endif ?>
        data-price_list='<?= $price_list ?>' 
        data-tax="<?= $pro['tax']; ?>"

        data-prounit='<?php foreach (products_units_array(company($user['id'])) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'
        data-prosubunit='<option value="">None</option><?php foreach (products_units_array(company($user['id'])) as $pu): ?><option value="<?= $pu['value']; ?>" <?php if ($pro['sub_unit']==$pu['value']) {echo 'selected';} ?>><?= $pu['name']; ?></option><?php endforeach ?>'

        data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"

         data-protax='<?php foreach (tax_array(company($user['id'])) as $tx): ?><option data-perc="<?= $tx['percent']; ?>" data-tname="<?= $tx['name']; ?>" value="<?= $tx['name']; ?>" <?php if ($pro['tax']==$tx['name']) {echo 'selected';} ?>><?= $tx['name']; ?></option><?php endforeach ?>'

        data-tax_name="<?= $pro['tax']; ?>"
        data-barcode="<?= $pro['barcode']; ?>"
        data-tax_percent="<?= percent_of_tax($pro['tax']); ?>"
        data-stock="<?= $pro['closing_balance'] ?>"
        data-description="<?= str_replace('"','%22',$pro['description']); ?>"
        data-product_type="<?= $pro['product_type']; ?>"
        data-purchased_price="<?= $pro['purchased_price']; ?>"
        data-selling_price="<?= $pro['price']; ?>"
        data-purchase_tax="<?= $pro['purchase_tax']; ?>"
        data-sale_tax="<?= $pro['sale_tax']; ?>"
        data-mrp="<?= $pro['mrp']; ?>"
        data-purchase_margin="<?= $pro['purchase_margin']; ?>"
        data-sale_margin="<?= $pro['sale_margin']; ?>"
        data-custom_barcode="<?= $pro['custom_barcode']; ?>"


         data-unit_disabled='readonly'
         data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit'])): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"
         
        >
            <div class="product_box <?php if ($pro['product_type']=='item_kit'){ $cst=item_kit_stock($pro['id']);}else{$cst=$pro['closing_balance'];}if ($cst<=0){ echo 'out_of_stock'; } ?>">
                <h6 class="text-white textoverflow_x-none d-flex w-100 justify-content-between"><div><?= $pro['product_name']; ?> - <em><?= $pro['cat_name'] ?></em></div>

                  <span>
                     <em>-<?= $pro['brand_name']; ?></em>
                    <?php if ($pro['product_method']=='product'): ?>
                    <small>
                        <?php if ($pro['product_type']=='item_kit'){ echo item_kit_stock($pro['id']).' item in stock';}else{ if ($pro['closing_balance']<=0 ){  echo '<small class="bg-body p-1 text-danger">Stock ('.$pro['closing_balance'].')</small>';}else{ echo $pro['closing_balance'].' '.name_of_unit($pro['unit']).' in stock';  }} ?>
                    </small>
                    <?php endif ?>
                </span >
                 </h6>


                
            </div>
            
        </a>
    <?php endforeach ?>