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
             
                <li class="breadcrumb-item active href_loader" aria-current="page">
                    <a href="<?= base_url('products?page=1'); ?>">Products</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Import & Export</b>
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
 

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="no_toolbar_sub_main_page_content">
    <div class="aitsun-row">

        <div class="col-xl-6 col-md-6">
             
            <div class="card">
                <div class="card-body">
                    <div class="ie_box d-flex">
                        <div class="m-auto ">
                          <a class=" btn btn-dark btn-sm download_complete" href="<?= base_url('import_and_export/export'); ?>">
                            Export Products
                          </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            
            <div class="card">
                <div class="card-body">
                    <div class="ie_box d-flex">
                            <form action="<?= base_url('import_and_export/save');?>" class="submit_loader m-auto text-center spsec-validation" id="spsec-validation" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <?= csrf_field(); ?>
                          
                                  <div class="form-group position-relative mb-2">
                                     <input type="file" name="fileURL" id="file-url" class="filestyle form-control custom-file-input" data-allowed-file-extensions="[CSV, csv,xlsx,XLSX]" accept=".CSV, .csv, .xlsx" data-buttontext="Choose File" required>
                                  </div>
                              
                                  <div class="form-group">
                                      <button type="submit" name="import_csv" id="import_csv" class="btn btn-dark btn-sm">Import Products</button>
                                  </div> 
                           </form>
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
     
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->

 