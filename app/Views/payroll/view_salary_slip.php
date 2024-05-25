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
             
                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('payroll'); ?>">Payroll</a>
                </li>

                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('payroll/edit'); ?>/<?= $payroll_data['id'] ?>"><?= get_date_format($payroll_data['month'],'F Y') ?></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= user_name($pmt['employee_id']) ?></b>
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

        <a class="text-dark font-size-footer aitsun-print me-2" data-url="<?= base_url('payroll/get_salary_slip'); ?>/<?= $pmt['id']; ?>/view">
            <i class="bx bx-printer"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Print'); ?></span>
        </a>
        <a class="text-dark font-size-footer me-2 download_complete" href="<?= base_url('payroll/get_salary_slip'); ?>/<?= $pmt['id']; ?>/download"><i class="bx bx-file-blank"></i>  Download PDF</a>
        
<?php if (get_setting(company($user['id']),'pdf_type')=='dompdf' || get_setting(company($user['id']),'pdf_type')==''): ?>
         <a class="text-dark font-size-footer me-2 pdf_open" data-href="<?= base_url('payroll/get_salary_slip'); ?>/<?= $pmt['id']; ?>/view">
            <i class="bx bx-file-blank"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'PDF'); ?></span>
        </a>
    <?php endif ?>
        
    </div> 
   
</div>
     
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content overflow-scroll bg-invoice">
    <div class="aitsun-row justify-content-center "> 
        
        <div class="invoice_card paper_shadow" >
            <div class="card-body" >
                <div id="">
                   <div class=" ">
                       
                        <div id="pdfthis" class="pdfthis">

                            <iframe class="aitsun-embed" id="aitsun-embed"
src="<?= base_url('payroll/get_salary_slip'); ?>/<?= $pmt['id']; ?>/view#toolbar=0&navpanes=0&scrollbar=0" width="900" height="600"/></iframe>

                        </div>
                        <div id="pdfthermalthis" class="rounded-3 py-3"></div>
                        <div id="editor"></div>
                   </div>



                   
                </div>
            </div>
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
    
    <div>
       
    </div>

</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

  


<div class="modal  fade" id="pdf_modal"  aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">PDF preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">

        

        <div id="pdf_show">
        </div>

      </div>
    </div>
  </div>
</div>

 