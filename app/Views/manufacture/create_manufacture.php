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
                    <b class="page_heading text-dark"><?php if ($view_type=='edit'): ?>Edit<?php else: ?>Create<?php endif ?> manufacture</b>
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
            
          

             <div id="show_pro" class="mb-3"></div>
     
            
            
            <form method="post" action="<?php if ($view_type=='edit'): ?><?= base_url('manufacture/update_manufacture') ?>/<?= $man_data['id'] ?><?php else: ?><?= base_url('manufacture/save_manufacture') ?><?php endif ?>" id="manufacture_form">
                <?= csrf_field(); ?>
                
                <?php 
                    if ($view_type=='edit'){
                        $m_conversion_unit_rate=$man_data['manufactured_unit_rate'];
                        $m_unit=$man_data['manufactured_unit'];
                        $m_sub_unit=$man_data['manufactured_sub_unit'];  
                        $m_in_unit=$man_data['manufactured_in_unit'];
                        $old_manufactured_quantity=$man_data['manufactured_quantity'];
                    }else{
                        $m_conversion_unit_rate=$pro['conversion_unit_rate'];
                        $m_unit=$pro['unit'];
                        $m_sub_unit=$pro['sub_unit'];
                        $m_in_unit=$pro['unit'];
                        $old_manufactured_quantity=0;
                    } 
                ?>

                <input type="hidden" name="product_id" value="<?= $pro['id'] ?>">  
                <input type="hidden" name="manufactured_unit_rate" value="<?= $pro['conversion_unit_rate']; ?>"> 
                <input type="hidden" name="old_manufactured_unit_rate_for_main_pro" value="<?= $pro['conversion_unit_rate']; ?>"> 
                <input type="hidden" name="manufactured_unit" id="manufactured_unit" value="<?= $m_unit; ?>"> 
                <input type="hidden" name="manufactured_sub_unit" value="<?= $m_sub_unit; ?>">
                <input type="hidden" name="old_manufactured_quantity" value="<?= $old_manufactured_quantity; ?>">



                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="form-group w-100">
                            <label>Quantity</label>
                            <input type="number" class="d-block form-control" placeholder="Quantity" value="<?php if ($view_type=='edit'): ?><?= $man_data['manufactured_quantity'] ?><?php else: ?>1<?php endif ?>" name="manufactured_quantity" data-conversion_unit_rate="<?= $m_conversion_unit_rate ?>" id="man_quantity_input">
                        </div>

                        <div class="form-group" style="min-width:200px;">
                            <label>Unit</label>
                            <select class="d-block form-control" placeholder="Unit" name="manufactured_in_unit" id="man_unit_input" data-conversion_unit_rate="<?php if ($view_type=='edit'): ?><?= $man_data['base_unit_rate'] ?><?php else: ?><?= $pro['conversion_unit_rate'] ?><?php endif ?>"> 
                                <option value="<?= $m_unit ?>"><?= $m_unit ?></option>
                                <?php if (!empty($m_sub_unit) && $m_sub_unit!='None'): ?>
                                    <option value="<?= $m_sub_unit ?>" <?php if($m_sub_unit==$m_in_unit){echo "selected";} ?>><?= $m_sub_unit ?></option>
                                <?php endif ?> 

                                
                            </select>
                        </div>

                    </div> 

                    <?php if ($view_type=='edit'): ?>
                        <input type="hidden" name="old_total_cost"  value="<?= $man_data['total_cost'] ?>">
                        <input type="hidden" name="old_manufactured_unit"  value="<?= $man_data['manufactured_unit'] ?>">
                        <input type="hidden" name="old_manufactured_in_unit"  value="<?= $man_data['manufactured_in_unit'] ?>">
                        <input type="hidden" name="old_manufactured_unit_rate_for_main_pro"  value="<?= $man_data['base_unit_rate'] ?>">
                        <input type="hidden" name="old_manufactured_unit_rate"  value="<?= $man_data['base_unit_rate'] ?>">



                        <input type="hidden" name="old_total_additional_cost"  value="<?= $man_data['total_additional_cost'] ?>">
                        <input type="hidden" name="old_total_manufactured_cost"  value="<?= $man_data['total_manufactured_cost'] ?>"> 
                    <?php endif ?>
                        

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <?php 
                                if ($view_type=='edit'){
                                   $man_date=$man_data['manufactured_date'];
                                }else{
                                   $man_date=now_time($user['id']);
                                }
                            ?>

                            <input type="date" class="d-block form-control" name="manufactured_date" value="<?= get_date_format($man_date,'Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                         <table class="aitsun_table mt-3">
                            <thead>
                                <tr>
                                    <th>Raw material</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Purchase price/Unit</th>
                                    <th class="text-end">Estimated cost</th>
                                </tr>
                            </thead>
                            <tbody>




                                <?php $rcount=0; $total_manufacture_cost=0; $total_additional_cost=0; $total_cost=0; 

                                if ($view_type=='edit'){
                                   $raw_materials_array=manufactured_items_array($man_data['id']);
                                }else{
                                   $raw_materials_array=raw_materials_array($pro['id']);
                                }

                                foreach ($raw_materials_array as $iite): 

                                    $rcount++; 

                                    if ($view_type=='edit'){
                                        $pro_unit=$iite['unit'];
                                        $in_unit=$iite['in_unit'];
                                        $pro_subunit=$iite['sub_unit']; 
                                        $pro_conversion_unit_rate=$iite['conversion_unit_rate'];  
                                        $item_id=$iite['product_id'];
                                        $item_quantity=$iite['quantity'];
                                        $item_old_quantity=$iite['quantity'];
                                        $old_quantity=$iite['old_quantity'];

                                        $base_quantity=$iite['base_quantity']; 

                                        $item_price=$iite['price']; 
                                        $item_desc=$iite['desc'];  
                                        $item_amount=$iite['amount']; 
                                    }else{
                                        $pro_unit=$iite['unit'];
                                        $in_unit=$iite['in_unit'];
                                        $pro_subunit=$iite['sub_unit']; 
                                        $pro_conversion_unit_rate=$iite['conversion_unit_rate'];  
                                        $item_id=$iite['item_id'];
                                        $item_quantity=$iite['quantity'];
                                        $base_quantity=$iite['quantity']; 
                                        $item_price=$iite['price']; 
                                        $item_desc=$iite['desc'];  
                                        $item_amount=$iite['amount'];   
                                        $item_old_quantity=0;
                                        $old_quantity=0;

                                    }
                                    


                                ?>
                                <input type="hidden" name="conversion_unit_rate[]" id="conversion_unit_rate<?= $item_id ?>" value="<?= $iite['conversion_unit_rate'] ?>">
                                <input type="hidden" name="unit[]" id="unit<?= $item_id ?>" value="<?= $pro_unit ?>">
                                <input type="hidden" name="sub_unit[]" id="sub_unit<?= $item_id ?>" value="<?= $pro_subunit ?>">
                                <input type="hidden" name="base_qty[]" id="base_qty<?= $item_id ?>" value="<?= $base_quantity ?>">
 

                                <input type="hidden" name="item_product_id[]" value="<?= $item_id ?>"> 
                                <input type="hidden" name="purchased_price[]"  value="<?= $item_price ?>">
                                <input type="hidden" name="item_selling_price[]"  value="<?= $item_price ?>">
                                <input type="hidden" name="item_product_desc[]"  value="<?= $item_desc ?>">
                                <input type="hidden" name="conversion_unit_rate[]"  value="<?= $pro_conversion_unit_rate ?>">
                                
                                <input type="hidden" name="item_tax[]"  value="">
                                <?php if ($view_type=='edit'): ?>
                                    <input type="hidden" name="i_id[]"  value="<?= $iite['id'] ?>">
                                    <input type="hidden" name="old_quantity[]"  value="<?= $old_quantity ?>">
                                    <input type="hidden" name="old_amount[]"  value="<?= $item_amount ?>"> 
                                    <input type="hidden" name="old_item_quantity[]"  value="<?= $item_old_quantity ?>"> 
                                    <input type="hidden" name="old_in_unit[]"  value="<?= $in_unit ?>"> 
                                    <input type="hidden" name="old_unit[]"  value="<?= $pro_unit ?>"> 


                                    <input type="hidden" name="old_conversion_unit_rate[]"  value="<?= $pro_conversion_unit_rate ?>"> 


                                <?php endif ?>
                                <input type="hidden" name="main_price[]" id="main_price<?= $item_id ?>" value="<?= purchase_price($iite['item_id']) ?>"> 



                                



                            
                              
                                <tr class="raw_items" data-row="<?= $item_id ?>">
                                    <td> 
                                        <input type="text" name="item_product_name[]" class="form-empty bg-0" value="<?= $iite['product'] ?>" style="margin-right: 15px;" readonly>
                                    </td>
                                    <td class="text-center"> 
                                        <input type="number" name="item_quantity[]" id="qtyite<?= $item_id ?>" data-proid="<?= $item_id ?>" data-price="<?= $item_price ?>" data-row="<?= $item_id ?>" class="form-light no-btn aitsun-simple-input text-center itemkit_qty_input w-100" data-still_qty="<?= $item_quantity ?>" value="<?= $item_quantity ?>" step="any" style="margin-right: 15px; width:100px;" data-proconversion_unit_rate="<?= $pro_conversion_unit_rate ?>"  readonly>
                                    </td>
                                    <td class="text-center readonly_td">
                                        <select class="in_unit_material form-light aitsun-simple-input no-btn" name="in_unit[]" data-row="<?= $item_id ?>" data-proconversion_unit_rate="<?= $pro_conversion_unit_rate ?>" id="in_unit<?= $item_id ?>" style="margin-right: 15px;" readonly> 
                                          <option value="<?= $pro_unit; ?>" <?php if($pro_unit==$in_unit){echo "selected";} ?>><?= $pro_unit; ?></option>
                                          <?php if (!empty($pro_subunit) && $pro_subunit!='None'): ?>
                                            <option value="<?= $pro_subunit ?>" <?php if($pro_subunit==$in_unit){echo "selected";} ?>><?= $pro_subunit ?></option>
                                          <?php endif ?> 
                                        </select>
                                    </td>
                                    <td class="text-center">
                                         <input type="number" name="item_price[]" id="priceite<?= $item_id ?>" data-proid="<?= $item_id ?>" data-price="<?= $item_price ?>" class="form-light no-btn aitsun-simple-input text-center w-100" value="<?= $item_price ?>" step="any" style="margin-right: 15px; width:100px;" readonly>
                                    </td>
                                    <td class="text-end">
                                        <input type="text" name="item_amount[]" class="text-end form-light aitsun-simple-input totalamot no-btn" style=" width:150px;" value="<?= $item_amount ?>" id="amtite<?= $item_id ?>" readonly>
                                        <?php $total_cost+=$item_amount; $total_manufacture_cost+=$item_amount; ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>



 
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class=""> 
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div><b>Total cost</b></div> 

                                        <?php 
                                            if ($view_type=='edit'){
                                               $total_cost=$man_data['total_cost'];
                                            }else{
                                               $total_cost=$total_cost;
                                            }
                                        ?>

                                        <div>
                                            <b><?= currency_symbol(company($user['id'])) ?><span id="total_cost_text"><?= $total_cost; ?></span></b>
                                            <input type="hidden" name="total_cost" id="total_cost" class="no-btn text-end man_cost_input" style="text-indent: 0;padding: 0;" value="<?= $total_cost; ?>">
                                        </div> 
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr class="mt-4">

                    <div class="col-md-12 pb-3" style="background:#d1d1d1; border-radius: 5px;">
                        <table class="mt-3">
                            <tr>
                                <th colspan="3" class="text-center">Additional charges</th>
                            </tr> 
                            <tr>
                                <th class="w-25">Charges</th>
                                <th class="w-75">Details</th>
                                <th class="text-end" style="width:300px;min-width:300px;">Estimated cost</th>
                                <th><button class="no_load btn btn-outline-dark add-more  btn-sm" type="button"><b>+</b></button></th>
                            </tr>
                            <tbody class="after-add-more">
                                <?php $ccount=0; if ($view_type=='edit'): ?>
                                    <?php foreach (additional_costs_array($man_data['id']) as $m_cost): $ccount++; ?>

                                        
                                        <?php if ($view_type=='edit'){
                                            $co_i_id=$m_cost['id'];
                                            $old_additional_cost=$m_cost['cost'];
                                        } ?>
                                        <input type="hidden" name="co_i_id[]" value="<?= $co_i_id ?>">
                                        <input type="hidden" name="old_additional_cost[]"  value="<?= $old_additional_cost ?>">
                                        
                                        <tr class="after-add-more-tr">
                                            <td class="w-25">
                                                <select name="additional_charges[]" class="aitsun-simple-input">
                                                    <option value="Labour cost" <?php if($m_cost['charges']=='Labour cost') echo 'selected'; ?>>Labour cost</option>
                                                    <option value="Electricity cost" <?php if($m_cost['charges']=='Electricity cost') echo 'selected'; ?>>Electricity cost</option>
                                                    <option value="Packaging charge" <?php if($m_cost['charges']=='Packaging charge') echo 'selected'; ?>>Packaging charge</option>
                                                    <option value="Logistic cost" <?php if($m_cost['charges']=='Logistic cost') echo 'selected'; ?>>Logistic cost</option>
                                                    <option value="Other charges" <?php if($m_cost['charges']=='Other charges') echo 'selected'; ?>>Other charges</option>
                                                </select>
                                            </td>
                                            <td class="w-75">
                                                <input type="text" name="additional_details[]" class="aitsun-simple-input" value="<?= $m_cost['details'] ?>">
                                            </td>
                                                <td>
                                                    <input type="number" name="additional_cost[]" style="width: 300px;" class="aitsun-simple-input cost_input text-end" value="<?= $m_cost['cost'] ?>">
                                                </td>
                                                <td class="change">
                                                    <a class=" no_load btn btn-danger btn-sm remove text-white"><b>-</b></a>
                                                </td>
                                            </tr>
                                    <?php endforeach ?>
                                <?php else: ?><?php endif ?>
                            </tbody>

                            <tr id="payment_mode_tr" class="<?php if ($ccount<1) {echo 'd-none'; } ?>">
                                <td></td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end">
                                        <div class="my-auto me-2">Payment:</div>
                                        <select class="my-auto aitsun-simple-input payment_select" style="border: 1px solid #c9c9c9; width: 300px;" name="payment_type" id="payment_type" required>
                                            <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                                                <option value="<?= $ba['id']; ?>" <?php if ($view_type=='edit'){ if($man_data['additional_cost_payment_type']==$ba['id']) echo 'selected'; } ?>><?= $ba['group_head']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div> 
                                </td>
                                <td class="text-end">
                                    <?php 
                                        if ($view_type=='edit'){
                                           $total_additional_cost=$man_data['total_additional_cost'];
                                        }else{
                                           $total_additional_cost=$total_additional_cost;
                                        }
                                    ?>
                                   <b><?= currency_symbol(company($user['id'])) ?><span id="total_additional_cost_text"><?= $total_additional_cost; ?></span></b>
                                    <input type="hidden" name="total_additioanl_cost" id="total_additional_cost" class="man_cost_input no-btn text-end" style="text-indent: 0;padding: 0;" value="<?= $total_additional_cost; ?>">   
                                </td>
                                <td></td>
                            </tr>
                            
                        </table>
                    </div>


                     <div class="col-md-12">
                        <table class="mt-3"> 
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div>Total estimated cost (Raw material + Additional Cost)</div> 

                                        <?php 
                                            if ($view_type=='edit'){
                                               $total_manufacture_cost=$man_data['total_manufactured_cost'];
                                            }else{
                                               $total_manufacture_cost=$total_manufacture_cost;
                                            }
                                        ?>

                                        <div>
                                            <b><?= currency_symbol(company($user['id'])) ?><span id="total_manufacture_cost_text"><?= $total_manufacture_cost; ?></span></b>
                                            <input type="hidden" name="total_manufacture_cost" id="total_manufacture_cost" class="no-btn text-end " style="text-indent: 0;padding: 0;" value="<?= $total_manufacture_cost; ?>">
                                        </div> 
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                  

                    <div class="col-md-12">
                        <button id="manufacture_this" type="button" class="aitsun-primary-btn mt-3">
                            Manufacture
                        </button>
                    </div> 
                </div>  

                
            </form>

            

        </div>
         
    </div> 
</div> 
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->


<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        
    </div>
</div> 


