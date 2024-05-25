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
                    <a href="<?= base_url('products'); ?>" class="href_loader">Products</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Add Product</b>
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

<div class="main_page_content">
    <div class="card">
        <div class="card-body p-4">
            <div class="d-md-flex justify-content-between">
                <h5 class="card-title my-auto">Add New Product</h5>

                <?php if (is_aitsun(company($user['id']))): ?>
                <?php if (is_online_shop(company($user['id']))): ?>
                    <div class="d-flex scrap_box">
                        <input type="text" class="form-control modal_inpu me-2" placeholder="Paste product url for scrap" id="scrap_url">
                        <select class="form-select mx-2" id="siteid">
                        <?php foreach (scrap_sites_array(company($user['id'])) as $scr): ?>
                            <option value="<?= $scr['id']; ?>" <?php if($scr['check_default']==1){echo 'selected';} ?>><?= $scr['site_name']; ?></option>
                        <?php endforeach ?>
                        </select>
                        <button class="btn btn-danger btn-group d-flex ml-2 mr-4" id="scrap_product">Scrap</button>
                    </div>
                <?php endif ?>
                <?php endif ?>
            </div>
            <hr/>
            <div id="add_product_form_container">
                
            </div>
        </div>
    </div>
</div>