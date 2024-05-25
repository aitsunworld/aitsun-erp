<!-- ////////////////////////// TOP BAR START ///////////////////////// -->

 <?php
    $from='';
    $dto='';
    $report_date=get_date_format(now_time($user['id']),'d M Y');
   if ($_GET) {
        $from=$_GET['from'];
        $dto=$_GET['to'];

        if (!empty($from) && empty($dto)) {
            $report_date=get_date_format($from,'l').' - '.get_date_format($from,'d M Y');
        }
        if (!empty($dto) && empty($from)) {
            $report_date=get_date_format($dto,'l').' - '.get_date_format($dto,'d M Y');
        }
        if (!empty($dto) && !empty($from)) {
            $report_date='From - '.get_date_format($from,'d M Y').'&nbsp; &nbsp; To - '.get_date_format($dto,'d M Y');
        }

     }else{
        $report_date='Today - '.get_date_format(now_time($user['id']),'d M Y');
     }
?>


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
                    <a href="<?= base_url('reports_selector'); ?>" class="href_loader">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Profit & Loss report</b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#profit_loss_table" data-filename="Profit Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#profit_loss_table" data-filename="Profit Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

   <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    
                    <input type="text" name="product_name" placeholder="Search Product..." class="form-control form-control-sm filter-control ">

                    <input type="date" name="from" placeholder="" class="form-control form-control-sm filter-control ">
                    <input type="date" name="to" placeholder="" class="form-control form-control-sm filter-control ">

                    <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                    <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('profit_and_loss_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="profit_loss_table" class="erp_table sortable no-wrap">

                <div class="text-center">
                    <h6><?= $report_date; ?></h6>
                </div>

                 <thead> 
                    <tr>
                        <th class="sorticon">Product Name</th>
                        <th class="sorticon">Opening Stock</th>
                        <th class="sorticon">Current Stock</th>
                        <th class="sorticon">Stock Value</th>
                        <th class="sorticon">Purchase Qty</th>
                        <th class="sorticon">Purchase Value</th> 
                        <th class="sorticon">Sales Qty</th>
                        <th class="sorticon">Sales Value</th> 
                        <th class="sorticon">Total Dumps</th>
                        <th class="sorticon">Profit/Loss</th> 
                        <th class="sorticon text-end">Profit(%)</th> 
                    </tr> 
                </thead>
                <tbody>

                   
                    <?php  $data_count=0; $total_stock_amount=0; $total_purchase_amt=0; $total_sales_amt=0; $total_dumps=0; $total_profit_loss=0; ?>

                    <?php foreach ($invoice_items_array as $ii): $data_count++;

                        $total_stock_amount+=aitsun_round($ii['final_closing_value'],get_setting(company($user['id']),'round_of_value')); 
                        $total_purchase_amt+=aitsun_round($ii['sum_purchase_amount'],get_setting(company($user['id']),'round_of_value'));
                        $total_sales_amt+=aitsun_round($ii['sum_sales_amount'],get_setting(company($user['id']),'round_of_value'));
                        $total_dumps+=aitsun_round($ii['sum_adjust_amount'],get_setting(company($user['id']),'round_of_value'));
                        
                    ?> 
                   
                    
                    


                    <?php 
                        // Calculate the profit percentage  
                        $costPrice= $ii['purchased_price']; 
                        $sellingPrice=$ii['price']; 
                        $numberOfProductsSold=$ii['sum_sales_quantity'];

                        $total_selling_price=($sellingPrice*$numberOfProductsSold);

                        $profit=($total_selling_price)-($costPrice*$numberOfProductsSold);

                        if (is_numeric($total_selling_price)) {
                            if ($total_selling_price>0) {
                                $profitPercentage = ($profit / $total_selling_price) * 100;
                            }else{
                                $profitPercentage=0;
                            }
                        }

                        $color = ($profit < 0) ? 'red' : 'green';
                        $percent_color = ($profitPercentage < 0) ? 'red' : 'green';

                    ?>

     
                    <tr>
                        <td><?= $ii['product'] ?></td>
                        <td class="text-end"><?= $ii['opening_balance'] ?></td>
                        <td class="text-end"><?= $ii['closing_balance'] ?></td>
                        <td class="text-end"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($ii['final_closing_value'],get_setting(company($user['id']),'round_of_value')) ?></td> 
                        <td class="text-end"><?= aitsun_round($ii['sum_purchase_quantity'],get_setting(company($user['id']),'round_of_value')) ?></td>
                        <td class="text-end"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($ii['sum_purchase_amount'],get_setting(company($user['id']),'round_of_value')) ?></td>
                        <td class="text-end"><?= round($ii['sum_sales_quantity'],3) ?></td>
                        <td class="text-end"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($ii['sum_sales_amount'],get_setting(company($user['id']),'round_of_value')) ?></td> 
                        <td class="text-end"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($ii['sum_adjust_amount'],get_setting(company($user['id']),'round_of_value')) ?> </td>
                        <td class="text-end" style="color: <?php echo $color; ?>" ><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($profit,3)?></td>
                        <td class="text-end" style="color: <?php echo $percent_color; ?>"><?= round($profitPercentage,0) ?><?= "%" ?></td>
                    </tr>

                    <?php endforeach ?>
                        
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="12">
                                <span class="text-danger">No Data Found</span>
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>


                <tfoot>
                    <tr>
                        <th style="border:1px solid #00000012;border-right: 0px;"><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th style="border:1px solid #00000012;border-right: 0px;border-left: 0px;"></th>
                        <th style="border:1px solid #00000012;border-left: 0px;"></th>
                        <th class="text-end" style="border:1px solid #00000012;"><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_stock_amount,get_setting(company($user['id']),'round_of_value')); ?></th>
                        <th class="text-end"></th>
                        
                        <th class="text-end" style="border:1px solid #00000012;"><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_purchase_amt,get_setting(company($user['id']),'round_of_value')); ?></th>
                        <th class="text-end"></th>
                        <th class="text-end" style="border:1px solid #00000012;"><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_sales_amt,get_setting(company($user['id']),'round_of_value')); ?></th>
                        <th class="text-end" style="border:1px solid #00000012;"><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_dumps,get_setting(company($user['id']),'round_of_value')); ?></th>
                        <th class="text-end" style="border:1px solid #00000012;"><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_profit_loss,get_setting(company($user['id']),'round_of_value')); ?></th> 
                    </tr> 
                </tfoot>
              
              
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->


