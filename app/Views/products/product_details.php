<div>
    <div class="text-center pt-3">        
        <h6 class="mb-1 text-center"><b>Profit : ---- </b> <?= get_date_format(now_time($user['id']),'d M Y'); ?> </h6>
    </div>


    <div class="prod-shadow p-3 ps-4 pe-4">
        <h6 class="mb-1 text-aitsun-red"><b>Price Details: </b></h6>
        <div class="d-flex justify-content-between">
            <div>
                <small >Purchase price :</small> 
                <span class="text-danger"><?= currency_symbolfor_sms($stock['company_id']); ?> <?= aitsun_round($stock['purchased_price'],get_setting(company($user['id']),'round_of_value')); ?></span>
            </div>
            <div>
                <small>Sales price :</small> 
                <span class="text-success"><b><?= currency_symbolfor_sms($stock['company_id']); ?> <?= aitsun_round($stock['price'],get_setting(company($user['id']),'round_of_value')); ?></b></span>
            </div>
            <div style="color: #a78181;">
                <small >MRP :</small> 
                <span><?= currency_symbolfor_sms($stock['company_id']); ?> <?= aitsun_round($stock['mrp'],get_setting(company($user['id']),'round_of_value')); ?></span>
            </div>
        </div>

    </div>

    <hr class="mt-0 mb-0">

    <div class="prod-shadow p-3  ps-4 pe-4">
        <h6 class="mb-1 text-aitsun-red"><b>Stock Details:</b></h6>
        <div class="d-flex justify-content-between">
            <div>
                <small>Opeining stock :</small> 
                <span class="text-success"><?= $stock['opening_balance'] ?></span>  
                <small style="color: #776466!important;">(at price : <?= currency_symbolfor_sms($stock['company_id']); ?> <?= aitsun_round($stock['at_price'],get_setting(company($user['id']),'round_of_value')); ?>)</small>
            </div>
            
            <div>
                <small>Current stock :</small> <span class="text-success"><?= $stock['closing_balance'] ?></span>
            </div>
        </div>
        <h6 class="mt-2 text-end">Total Stock Value : <b class="text-success"><?= $stock['final_closing_value']; ?></b></h6>
    </div>

    <hr class="mt-0 mb-0">

    <div class="prod-shadow p-3  ps-4 pe-4">
        <h6 class="mb-2 text-aitsun-red"><b>Total Adjust Stock Details</b></h6>
        <table class="table table-bordered table-sm mb-0 table-striped">
            <thead class="text-center">
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <th class="aitsun-fw-bold">Type</th>
                    <th class="aitsun-fw-bold">In Unit</th>
                    <th class="aitsun-fw-bold">Qty</th>
                    
                </tr>
            </thead>
            <tbody class="text-center">
                <?php  $data_count=0; ?>
                <?php foreach ($stock_array as $ads): $data_count++; ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td> 
                            <?php if ($ads['invoice_type']=='purchase'): ?>
                                <span class="text-success text-capitalize">Add</span>
                            <?php elseif($ads['invoice_type']=='sales'): ?>
                                <span class="text-danger text-capitalize">Reduce</span>
                            <?php endif ?>
                        </td>
                        <td><?= $ads['in_unit']; ?></td>
                        <td><?= $ads['quantity']; ?></td>
                    </tr>
                 <?php endforeach ?>
                 <?php if ($data_count<1): ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td class="text-center" colspan="3">
                            <span class="text-danger">No stock details</span>
                        </td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

