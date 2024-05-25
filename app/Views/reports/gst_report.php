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
                    <b class="page_heading text-dark">GST Report</b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#gst_table" data-filename="GST Report <?= str_replace(array('From','To','&nbsp;','Today','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','day'), '', $report_date); ?>>"> 
            <span class="my-auto">Excel</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#gst_table"> 
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
                    
                      <input type="date" name="from" placeholder="" class="form-control form-control-sm filter-control ">
                      <input type="date" name="to" placeholder="" class="form-control form-control-sm filter-control ">
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('gst_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     


<div class="sub_main_page_content">
    <div class="aitsun-row "> 
 

        <div class="aitsun_table table-responsive col-12 w-100 pt-0 pb-5">
            
            <table id="gst_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th colspan="9" class="text-start" >
                        
                       <?= $report_date; ?>

                    </th>
                </tr>
                <tr>
                    <th class="sorticon" style="min-width: 100px;">No</th>
                    <th class="sorticon" style="min-width: 130px;">Date</th>
                    <th class="sorticon" style="min-width: 190px;">Party name</th> 
                    <th class="sorticon" style="min-width: 100px;">Address</th>
                    <th class="sorticon" style="min-width: 100px;">GSTIN</th>
                    <?php $ist=0; foreach (all_budpayina_taxes(company($user['id'])) as $hta):  $ist++;?>
                        <?php ${"isav".$ist}=false; if (is_tax_available($hta,$from,$to)):  ${"isav".$ist}=true;?>
                            <th style="min-width: 190px;"><b>Amount <?= $hta ?></b></th>
                            <th style="min-width: 190px;"><b>Value <?= $hta ?></b></th>
                         <?php endif ?>  
                    <?php endforeach ?>
                    <th class="sorticon" style="min-width: 190px;">Subtotal</th>
                    <th class="sorticon" style="min-width: 190px;">Total tax value</th> 
                    <th class="sorticon" style="min-width: 190px;">Total</th> 
                    <th class="sorticon" style="min-width: 190px;">Round off</th> 
                    <th class="sorticon" style="min-width: 190px;">Total</th> 

                </tr>
             
             </thead>
             <?php
                $ti=0;
                foreach (all_budpayina_taxes(company($user['id'])) as $vta){
                    $ti++;
                    ${"taxvar".$ti}=0;
                    ${"taxvalvar".$ti}=0;
                }
            ?> 

            <?php  $data_count=0; ?>
            <?php $grand_sub_total=0;$grand_ta_total=0;$grand_total=0; $grand_round_total=0; $grand_rounded_total=0; foreach ($gst_reports as $db) { $data_count++; ?> 
              <tbody>
                  <tr class="text-center">
                        <td>
                             
                              <?= inventory_prefix(company($user['id']),$db['invoice_type']); ?> 
                              <?= $db['serial_no']; ?>
                          
                              
                      </td>
                        <td><?= get_date_format($db['invoice_date'],'d-m-Y'); ?></td>
                        <td>
                            <?php if ($db['customer']=='CASH'): ?>
                                <?php if (!empty($db['alternate_name'])): ?>
                                    <?= $db['alternate_name']; ?>
                                <?php else: ?>
                                    Cash Customer
                                <?php endif ?>
                            <?php else: ?>
                                <?= user_name($db['customer']); ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if ($db['customer']=='CASH'): ?>
                                <?php if (!empty($db['alternate_name'])): ?>
                                     
                                <?php else: ?>
                                    ----
                                <?php endif ?>
                            <?php else: ?>
                                <?= nl2br(billing_address_of($db['customer'])); ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if ($db['customer']=='CASH'): ?>
                                <?php if (!empty($db['alternate_name'])): ?>
                                     
                                <?php else: ?>
                                    ----
                                <?php endif ?>
                            <?php else: ?>
                                <?= gst_no_of($db['customer']); ?>
                            <?php endif ?>
                        </td>

                        

                        <?php $ai=0; $tai=0; $ttaxx=0; foreach (all_budpayina_taxes(company($user['id'])) as $ta): $ttaxx+=gst_value_of_invoice(company($user['id']),$db['id'],$ta); ?>



                            <?php $ai++; $tai++; ?> 

                            <?php if (${"isav".$ai}): ?> 
                            <td>  
                                    <?= aitsun_round(gst_taxable_value_of_invoice(company($user['id']),$db['id'],$ta),get_setting(company($user['id']),'round_of_value')) ?>
                                    <?php  ${"taxvalvar".$tai}+=gst_taxable_value_of_invoice(company($user['id']),$db['id'],$ta); ?>
                                 
                                 
                            </td>

                            <td>
                                <?= aitsun_round(gst_value_of_invoice(company($user['id']),$db['id'],$ta),get_setting(company($user['id']),'round_of_value')) ?> 
                                <?php  ${"taxvar".$ai}+=gst_value_of_invoice(company($user['id']),$db['id'],$ta); ?>
                            </td>
                            <?php endif ?>
                        <?php endforeach ?> 

                        <td><b><?= aitsun_round($db['sub_total']-$ttaxx,get_setting(company($user['id']),'round_of_value')); ?> <?php $grand_sub_total+=$db['sub_total']-$ttaxx; ?></b></td>
                        <td><b><?= aitsun_round($ttaxx,get_setting(company($user['id']),'round_of_value')); ?> <?php $grand_ta_total+=$ttaxx; ?></b></td>
                        <td><b><?= aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?> <?php $grand_total+=aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?></b></td>

                        <td><b>
                            <?= aitsun_round($db['total']-$db['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            <?php $grand_round_total+=aitsun_round($db['total']-$db['total'],get_setting(company($user['id']),'round_of_value')); ?>
                            </b></td>

                        <td><b><?= aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?> <?php $grand_rounded_total+=aitsun_round($db['total'],get_setting(company($user['id']),'round_of_value')); ?></b></td>
                        
                    </tr>
 
              </tbody>
              <?php } ?> 
              <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="12">
                            <span class="text-danger">No GST Report</span>
                        </td>
                    </tr>
                <?php endif ?> 
                 <tfoot>
                    <tr class="text-center">
                        <td colspan="4"></td>
                        <td ><b>Total</b></td>
                        <?php $ui=0; foreach (all_budpayina_taxes(company($user['id'])) as $ftta): $ui++; ?>  

                            <?php if (${"isav".$ui}): ?> 
                                <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round(${"taxvalvar".$ui},get_setting(company($user['id']),'round_of_value')) ?></b></td>
                                <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round(${"taxvar".$ui},get_setting(company($user['id']),'round_of_value')) ?></b></td>
                            <?php endif ?>
                       
                        <?php endforeach ?> 
                        
                        <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($grand_sub_total,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                        <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($grand_ta_total,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                        <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($grand_total,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                        <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($grand_round_total,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                        <td><b><?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($grand_rounded_total,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                    </tr>
                </tfoot>
              
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->