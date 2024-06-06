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
                    <b class="page_heading text-dark">Rental</b>
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
    <div class="d-flex">
          
        <a href="<?= base_url('rental') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-home"></i> <span class="my-auto">Orders</span></a>

        <a href="<?= base_url('products') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-package"></i> <span class="my-auto">Products</span></a>

        <a href="<?= base_url('rental/periods') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-time"></i> <span class="my-auto">Rental periods</span></a>
 
        
        
        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-file"></i> Reports
            </a>
            <div class="dropdown-menu" style="">  
              <!--   <a class="dropdown-item href_loader" href="<= base_url('appointments/reports') ?>">
                    <span>Booking reports</span>
                </a>
              <a class="dropdown-item href_loader" href="#">
                    <span>Person wise</span>
                </a>
                <a class="dropdown-item href_loader" href="#">
                    <span>Resource wise</span>
                </a> --> 
            </div>
        </div> 
 
 

    </div>

    <a href="<?= base_url('invoices/create_sales_quotation') ?>" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New rental</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
        
        <div id="filter-appointment" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="text" name="appointment" placeholder="Search appointment" class="form-control form-control-sm filter-control ">
                    
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('appointments') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 
        
        

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
      <!-- <= $pager->links() ?> -->
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 