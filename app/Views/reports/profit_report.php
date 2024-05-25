<!-- ////////////////////////// TOP BAR START ///////////////////////// -->


 <?php

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
                    <b class="page_heading text-dark">Items Report</b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#profit_table" data-filename="Profit Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#profit_table" data-filename="Profit Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#profit_table"> 
            <span class="my-auto">Quick search</span>
        </a>
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

   <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="text" name="product_name" placeholder="Search Product..." class="form-control form-control-sm filter-control ">

                      <input type="date" name="from" placeholder="" class="form-control form-control-sm filter-control ">
                      <input type="date" name="to" placeholder="" class="form-control form-control-sm filter-control ">

                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('profit_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="profit_table" class="erp_table sortable">
             <thead>
                <tr>
                    <td colspan="5" class="text-center " >
                        
                       <?= $report_date; ?>

                    </td>
                </tr>
                <tr>
                    <th class="sorticon">Date</th>
                    <th class="sorticon">Products</th>
                    <th class="sorticon">Qty</th> 
                    <th class="sorticon">Amount</th>
                    <th class="sorticon">Profit</th> 

                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>
                    <?php $total_amount=0; $total_profit=0; foreach ($invoices_all as $itm) { $data_count++; 
                        $sum_of_quantity=sum_of_quantity($itm['product_id']);
                        $get_cost_of_product=get_cost_of_product($itm['product_id']);
                        $get_profit_of_product=get_profit_of_product($itm['product_id']);
                    ?>
                                    
                    <tr>
                       <td>
                        <?= get_date_format($report_f_date,'d-m-Y') ?> 
                        <?php if (!empty($report_t_date)): ?>
                             - 
                            <?= get_date_format($report_t_date,'d-m-Y') ?>
                        <?php endif ?>
                       
                       </td>
                       <td>
                          <?= product_name($itm['product_id']) ?>
                       </td>
                       

                       <td class="text-right"><?= $sum_of_quantity ?></td>
                       <td class="text-right"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($get_cost_of_product,get_setting(company($user['id']),'round_of_value')) ?></td>

                       <td class="text-right"><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($get_profit_of_product,get_setting(company($user['id']),'round_of_value')) ?></td>
                       
                   </tr>

                    <?php 
                        $total_amount+=$get_cost_of_product;
                        $total_profit+=$get_profit_of_product;
                    ?>
                   <?php } ?> 
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="5">
                                <span class="text-danger">No Profit Report</span>
                            </td>
                        </tr>
                    <?php endif ?>
                 
              </tbody>

              <tfoot>
                    <tr>
                        <th style="border:1px solid #00000012;border-right: 0px;"><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th style="border:1px solid #00000012;border-right: 0px;border-left: 0px;"></th>
                        <th style="border:1px solid #00000012;border-left: 0px;"></th>
                        <th class="text-right" style="border:1px solid #00000012;"><?= currency_symbol(company($user['id'])); ?><?= aitsun_round($total_amount,get_setting(company($user['id']),'round_of_value')); ?></th>
                        
                        <th class="text-right" style="border:1px solid #00000012;"> 
                          <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_profit,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>

                    </tr>
                    
                </tfoot>
              
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->