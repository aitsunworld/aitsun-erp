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
                    <a class="href_loader" href="<?= base_url('voucher_entries'); ?>" class="href_loader"><?= langg(get_setting(company($user['id']),'language'),'Voucher entries'); ?></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= langg(get_setting(company($user['id']),'language'),'Details'); ?></b>
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
      
        <a class="text-dark font-size-footer aitsun-print me-2" data-url="<?= base_url('voucher_entries/get_voucher'); ?>/<?= $voucher_data['id'] ?>/view/view">
            <i class="bx bx-printer"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Print'); ?></span>
        </a>
        <a class="text-dark font-size-footer me-2 download_complete" href="<?= base_url('voucher_entries/get_voucher'); ?>/<?= $voucher_data['id'] ?>/download"><i class="bx bx-file-blank"></i>  Download PDF</a>
        
<?php if (get_setting(company($user['id']),'pdf_type')=='dompdf' || get_setting(company($user['id']),'pdf_type')==''): ?>
         <a class="text-dark font-size-footer me-2 pdf_open" data-href="<?= base_url('voucher_entries/get_voucher'); ?>/<?= $voucher_data['id'] ?>/view">
            <i class="bx bx-file-blank"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'PDF'); ?></span>
        </a>
    <?php endif ?>





        <?php if ($voucher_data['deleted']!=4): ?>
             <a href="<?php echo base_url('voucher_entries/edit') ?>/<?= $voucher_data['id']; ?>" class="text-dark font-size-footer me-2 href_loader">
                <i class="bx bx-pencil"></i> 
                <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Edit'); ?></span>
            </a>
            <?php endif ?>
          
        <a data-url="<?php echo base_url() ?>/voucher_entries/delete/<?= $voucher_data['id']; ?>" class="delete text-dark font-size-footer me-2">
            <i class="bx bx-trash-alt"></i> 
            <span class="hidden-xs"><?= langg(get_setting(company($user['id']),'language'),'Delete'); ?></span>
        </a>
    </div>

      
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

 
  

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content overflow-scroll-none bg-invoice">
    <div class="aitsun-row justify-content-center"> 
        <div class="invoice_card paper_shadow" >
            <div class="card-body" >
                <div id="pdfthis" class="">
                    <iframe class="aitsun-embed" id="aitsun-embed"
src="<?= base_url('voucher_entries/get_voucher'); ?>/<?= $voucher_data['id'] ?>/view#toolbar=0&navpanes=0&scrollbar=0" width="900" height="600"/></iframe>
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
        <a href="" data-bs-toggle="modal" data-bs-target="#add_settings" class="text-dark font-size-footer"><i class="bx bx-plus"></i> <span class="my-auto">Voucher Settings</span></a>
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

 

 <!--  Modal -->
<div class="modal fade aistun-modal" id="add_settings"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Add Voucher Settings'); ?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data" action="<?= base_url('add_voucher_settings'); ?>/<?= $voucher_data['id']; ?>">
        <?= csrf_field(); ?>
      <div class="modal-body">
      
        <div>
          <div class="form-group mb-2">
            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Select Page Size'); ?></label>
            <select class="form-control form-control-sm"name="voucher_page_size">
                <option value="" selected>select page size</option>
                <option value="a4" <?php if (get_setting2(company($user['id']),'voucher_page_size') == 'a4') {echo 'selected';} ?>>A4</option>
                <option value="a5" <?php if (get_setting2(company($user['id']),'voucher_page_size') == 'a5') {echo 'selected';} ?>>A5</option>
                <option value="a3" <?php if (get_setting2(company($user['id']),'voucher_page_size') == 'a3') {echo 'selected';} ?>>A3</option>
            </select>
        
          </div>

          <div class="form-group mb-2">
            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Select Orientation'); ?></label>
                <select class="form-control form-control-sm"name="voucher_orientation">
                    <option value="" selected>select orientation</option>
                    <option value="landscape" <?php if (get_setting2(company($user['id']),'voucher_orientation') == 'landscape') {echo 'selected';} ?> >Landscape</option>
                    <option value="portrait" <?php if (get_setting2(company($user['id']),'voucher_orientation') == 'portrait') {echo 'selected';} ?>>Portrait</option>
                </select>
          </div>


          
        </div>
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        <button type="submit" class="aitsun-primary-btn" name="add_voucher_settings"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- end  Modal -->