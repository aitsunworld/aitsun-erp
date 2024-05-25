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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">API Details</b>
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



<div class="main_page_content ">
    <?= view('website_management/website_sidebar') ?>
    <div class="row website_margin position-relative p-0">
        <div class="col-lg-12">
            <form method="post" class="on_submit_loader">
            <?= csrf_field(); ?>
              <div class="col-md-12 row m-0" >
                   
                    <div class="form-group col-lg-6 mb-3">
                        <label for="input-5" class="form-label d-block">Website URL</label>
                        <input type="text" name="website_url" class="form-control" value="<?= $conf['website_url']; ?>">
                    </div>
 
                     <div class="form-group col-md-12">
                        <button type="submit" class="aitsun-primary-btn" name="save_sms_email">Save</button>
                     </div>
              </div>
            </form>
        </div>
    </div>
</div>