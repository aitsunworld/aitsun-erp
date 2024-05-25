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

                 <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('hr_manage'); ?>">HR Management</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Payroll</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#payroll_table" data-filename="Payroll data <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#payroll_table" data-filename="Payroll data <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#payroll_table" data-filename="Payroll data <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
        
   
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#payroll_table"> 
            <span class="my-auto">Quick search</span>
        </a>

        <a href="<?= base_url('payroll/basic_salary'); ?>" class="text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Basic salary</span>
        </a> 

        <a href="<?= base_url('payroll/settings'); ?>" class="text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Addition / Deduction</span>
        </a> 
    </div>

    <div>
        <a href="<?= base_url('payroll/create_payroll'); ?>" class="text-dark font-size-footer my-auto ms-2 href_loader"> <span class="">+ Create Payroll</span></a>
    </div>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
   
<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="payroll_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Payroll</th>
                    <th class="sorticon">Amount (<?= currency_symbol(company($user['id'])) ?> )</th>
                    <th class="sorticon text-end" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
               <?php foreach ($pay_rolls as $prl): ?>
                <tr>
                    <td>
                        <a href="<?= base_url('payroll/edit') ?>/<?= $prl['id']; ?>" class="aitsun_link href_loader">
                            <?= get_date_format($prl['month'],'Y F') ?>
                        </a>
                    </td>
                    <td><?= $prl['total_salary']; ?></td>
                    <td class="text-end" data-tableexport-display="none">
                         <a class="aitsun_link href_loader" href="<?= base_url('payroll/view_payroll_slip') ?>/<?= $prl['id'] ?>">
                            <i class="bx bx-receipt me-1"></i> Details
                        </a>
                    </td>
                </tr>
               <?php endforeach; ?>
              </tbody>
            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
         
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 