<div class="modal-header">
    <h5 class="modal-title mt-0" id="mySmallModalLabel"><?= ($action=='pickup')?'Pickup':'Return' ?> items</h5>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    
    <form action="<?= base_url('rental/save_rental_items') ?>/<?= $action ?>" id="validate_rental_items_form" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="status" value="<?= $status ?>">
        <input type="hidden" name="invoice_id" value="<?= $invoice_id ?>">
        <input type="hidden" id="action" value="<?= $action ?>">
      

        <table class="aitsun_table erp_table">
            <thead>
                <tr>
                    <td>Item</td>
                    <td class="text-end">Reserved Qty</td>
                    <td class="text-end"><?= ($action=='pickup')?'Picked':'Returned' ?> Qty</td>
                    <td class="text-end">Unit</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach (invoice_items_array($invoice_id) as $ii): 
                    $productid=$ii['product_id'];
                    $product_name=get_products_data($ii['product_id'],'product_name');
                    $in_unit=$ii['in_unit']; 
                    $pro_unit=$ii['unit'];
                    $pro_subunit=$ii['sub_unit'];
                    $in_quantity=$ii['quantity'];

                    $total_quantity=total_picked_quantity($invoice_id,$ii['product_id'],$action);
                    $total_picked_quantity=total_picked_quantity($invoice_id,$ii['product_id'],'pickup');
                    $total_returned_quantity=total_picked_quantity($invoice_id,$ii['product_id'],'return');

                ?> 
                    <tr>
                        <td>
                            <?= $ii['product'] ; ?>
                            <input type="hidden" name="id[]" value="<?= $ii['id'] ; ?>">
                            <input type="hidden" name="product_id[]" value="<?= $ii['product_id'] ; ?>">

                            <input type="hidden" name="total_picked_quantity[]" id="total_picked_quantity<?= $ii['id'] ; ?>" value="<?= $total_picked_quantity ?>">
                            <input type="hidden" name="total_returned_quantity[]" id="total_returned_quantity<?= $ii['id'] ; ?>" value="<?= $total_returned_quantity ?>"> 
                            <input type="hidden" name="in_quantity[]" id="in_quantity<?= $ii['id'] ; ?>" value="<?= $in_quantity ?>">
                            <input type="hidden" name="product_name[]" id="product_name<?= $ii['id'] ; ?>" value="<?= $product_name ?>">
                        </td>
                        <td class="text-end">
                            <?= $ii['quantity']; ?> <?= unit_name($ii['in_unit']); ?> 
                            (<?= $total_quantity ?> <?= unit_name($ii['in_unit']); ?> <?= ($action=='pickup')?'picked':'retuned' ?> )
                        </td>
                        <td class="text-end"><input type="number" class="form-control text-end picked_qty" data-row_id="<?= $ii['id'] ; ?>"  step="any" name="quantity[]" value="<?= ($action=='pickup')?$ii['picked_qty']:$ii['returned_qty'] ?>"></td>
                        <td>
                            <select class="in_unit form-control p-0 text-center form-control-sm mb-0" style="min-width: 60px;" data-proconversion_unit_rate="<?= conversion_unit_of_product($productid); ?>" name="in_unit[]"> 
                          <option value="<?= $pro_unit; ?>" <?php if($pro_unit==$in_unit){echo "selected";} ?>><?= $pro_unit; ?></option>
                          <?php if (!empty($pro_subunit)): ?>
                            <option value="<?= $pro_subunit ?>" <?php if($pro_subunit==$in_unit){echo "selected";} ?>><?= $pro_subunit ?></option>
                          <?php endif ?> 
                        </select>
                        </td>
                    </tr>
                <?php endforeach ?> 
            </tbody>
        </table>
        <div class="mt-2 text-center">
            <button class="btn btn-erp-medium btn-sm rounded-pill validate_rental_items" data-row_id="<?= $ii['id'] ; ?>" type="button">Validate</button>
        </div>
    </form>

</div>