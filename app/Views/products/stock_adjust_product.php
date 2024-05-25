
<table class="table table-bordered table-sm">
    <thead class="text-center">
        <tr style="border-bottom: 1px solid #dee2e6;">
            <th class="aitsun-fw-bold">Date</th>
            <th class="aitsun-fw-bold">In Unit</th>
            <th class="aitsun-fw-bold">Qty</th>
            <th class="aitsun-fw-bold">Type</th>
            <th class="aitsun-fw-bold">Action</th>
        </tr>
    </thead>
    <tbody class="text-center">
        
        <?php  $data_count=0; ?>
        <?php foreach ($stock_array as $ads): $data_count++; ?>
             <tr style="border-bottom: 1px solid #dee2e6;">
                <td><?= get_date_format($ads['invoice_date'],'d-M-Y'); ?></td>
                <td><?= $ads['in_unit']; ?></td>
                <td><?= $ads['quantity']; ?></td>
                <td>
                    <?php if ($ads['invoice_type']=='purchase'): ?>
                         <span class="text-success text-capitalize">Add</span>
                    <?php elseif($ads['invoice_type']=='sales'): ?>
                         <span class="text-danger text-capitalize">Reduce</span>
                    <?php endif ?>
                </td>
                <td>
                    <a data-url="<?php echo base_url('products/delete_adjust_stock'); ?>/<?= $ads['id']; ?>" class="delete_adjust_stock text-danger" title="delete" data-product_id="<?= $proid; ?>">
                        <i class="bx bx-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>

        <?php if ($data_count<1): ?>
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td class="text-center" colspan="5">
                    <span class="text-danger">No stock details</span>
                </td>
            </tr>
        <?php endif ?>
       

    </tbody>
</table>