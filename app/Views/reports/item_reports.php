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


<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#items_table" data-filename="Items Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#items_table" data-filename="Items Report - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#items_table" data-filename="Items Report - <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#items_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<!-- ////////////////////////// FILTER ///////////////////////// -->
    <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
            <form method="get" class="d-flex">
                <?= csrf_field(); ?>
               <input type="date" name="from" class="form-control form-control-sm filter-control" title="From" placeholder="">
                <input type="date" name="to" title="To" class="form-control form-control-sm filter-control" placeholder="">


                    <select class="form-control form-control-sm filter-control" name="product">
                          <option value="0" selected>Products</option>
                          <?php foreach (products_array(company($user['id'])) as $itmss): ?>
                              <option value="<?= $itmss['id']; ?>"><?= $itmss['product_name']; ?></option>
                          <?php endforeach ?>
                    </select>
                
              
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('item_reports') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
              
            </form>
            <!-- FILTER -->
        </div>  
    </div>
<!-- ////////////////////////// FILTER END ///////////////////////// -->





<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content ">
    <div class="aitsun-row pb-5">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="items_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th colspan="8" class="text-center" >
                            
                           <?= $report_date; ?>

                        </th>
                    </tr>
                    <tr>
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></th>
                        <!-- <th class="sorticon"><= langg(get_setting(company($user['id']),'language'),'Voucher No'); ?>. </th> -->
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Products'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Qty'); ?></th> 
                        <th class="sorticon"><?= langg(get_setting(company($user['id']),'language'),'Amount'); ?></th> 

                 </thead>
                 <tbody>
                <?php  $data_count=0; ?>
                    <?php $debit_sum=0; $credit_sum=0; $total_qty=0; foreach ($item_data as $id) { $data_count++; ?>
                        <tr>
                          
                          <td><?= get_date_format($id['invoice_date'],'d-m-Y'); ?></td>

                          <td><?= $id['product_name'];  ?></td>

                            <td>
                                <?= $id['quantity']; ?>
                            </td>
                        </td>



                          <td class="text-right">
                           
                               <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($id['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                               <?php $debit_sum+=$id['amount']; ?>
                           
                          </td>
                          

                           


                          
                           
                      </tr>
                  
                    <?php 
                        
                        $total_qty+=$id['quantity'];
                    ?>

                    <?php } ?>
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="8">
                                <span class="text-danger">No Data</span>
                            </td>
                        </tr>
                    <?php endif ?>
                    
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="1"></th>
                        <th><strong><?= langg(get_setting(company($user['id']),'language'),'Total'); ?></strong></th>
                        <th class="text-right">
                          <strong><?= $total_qty ?></strong>
                        </th>
                        <th class="text-right">
                          <strong><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($debit_sum,get_setting(company($user['id']),'round_of_value')); ?></strong>
                        </th>
                       
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->