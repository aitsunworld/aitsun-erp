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
                    <b class="page_heading text-dark">Rich Edit</b>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= reduce_chars($pro['product_name'],27); ?>...</b>
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
<div class="toolbar d-flex justify-content-end">

    <div class="d-flex">
        
        <div class="my-auto">         

            <div class=" my-auto">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <?php if (next_product($pro['id'],'prev',company($user['id']))!='no product'): ?>
                        <a href="<?= base_url('products/long_edit') ?>/<?= next_product($pro['id'],'prev',company($user['id'])); ?>" class="aitsun-primary-btn-topbar  font-size-footer font-size href_loader me-1">
                            <i class="bx bx-left-arrow"></i> Prev
                        </a>
                    <?php endif ?>
                    <?php if (next_product($pro['id'],'next',company($user['id']))!='no product'): ?>
                        <a href="<?= base_url('products/long_edit') ?>/<?= next_product($pro['id'],'next',company($user['id'])); ?>" class="aitsun-primary-btn-topbar  font-size-footer font-size href_loader ">
                        Next
                        <i class="bx bx-right-arrow"></i> 
                    </a>
                    <?php endif ?>
                
                </div>
            </div>
            
        </div>
        
    </div>



</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->





<div class="sub_main_page_content">
    <div class="card">
        <div class="card-body p-4">
            <form method="post" action="<?= base_url('products/rich_update_product') ?>/<?= $pro['id']; ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="rounded">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="mb-3 <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
                                            <label for="inputProductDescription" class="form-label">Long Description</label>
                                            <textarea  class="form-control long_description" id="summernote" name="long_description" rows="3"><?= $pro['rich_description']; ?></textarea>
                                        </div>   
                                        <div class="col-12">
                                            <div id="error_display" class="mb-2 text-danger"></div>
                                            <div class="d-grid">
                                                <button type="button" class="href_long_loader_filter aitsun-primary-btn">Save</button>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
                        
            </form>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('.long_description').summernote({

            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['fontname', ['fontname']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture']],
              ['view', ['fullscreen', 'help']],

            ]
            });


    });
  </script>