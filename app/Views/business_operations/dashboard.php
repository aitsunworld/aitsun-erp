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
                <b class="page_heading text-dark">Business Operations</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#parties_table" data-filename="Parties master"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#parties_table" data-filename="Parties master"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#parties_table" data-filename="Parties master"> 
            <span class="my-auto">PDF</span>
        </a>
        <a href="<?= base_url('import_and_export/parties') ?>" class=" text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Export/Import</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#parties_table"> 
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

            <input type="text" name="display_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?>" class="form-control form-control-sm filter-control ">


            <select class="form-control form-control-sm" name="party_type">
              <option value="">Type</option>
              <option value="customer">Customer</option>
              <option value="vendor">Vendor</option>
              <option value="delivery">Delivery</option>
              <option value="seller">Seller</option>
          </select> 

          <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
          <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('customers') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>


      </form>
      <!-- FILTER -->
  </div>  
</div>


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content business_operations_content">

    <div class="fixed_sidebar">
        <div class="m_box">
            <div>
                <ul>
                    <li><i class="bx bx-home my-auto"></i> Home</li>
                    <li><i class="bx bx-task my-auto"></i> My tasks</li>
                    <li><i class="bx bx-envelope my-auto"></i> Inbox</li>
                </ul>
            </div>
            <hr>
            <div class="m_head"><h6 class="my-auto">Projects</h6> <a class="my-auto" href="">+</a></div>
            <div>
                <ul>
                    <li> <span class="my-auto lead_icon bg-white"></span> Lead 1</li>
                    <li> <span class="my-auto lead_icon bg-danger"></span> Project 2</li>
                    <li> <span class="my-auto lead_icon bg-primary"></span> Projects 5</li>
                </ul>
            </div>
            <hr>
            <div class="m_head"><h6 class="my-auto">Teams</h6> <a class="my-auto" href="">+</a></div>
            <div>
                <ul>
                    <li><i class="my-auto bx bx-task"></i> Sales</li>
                    <li><i class="my-auto bx bx-task"></i> Purchase</li>
                    <li><i class="my-auto bx bx-task"></i> Quotation</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="aitsun-row"> 



    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



