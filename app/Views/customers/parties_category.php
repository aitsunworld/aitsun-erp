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
                    <a href="<?= base_url('customers'); ?>">Parties</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Parties Categoy</b>
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
 <div class="toolbar d-flex justify-content-end">
    <a data-bs-toggle="modal" data-bs-target="#pcateg" class="text-dark font-size-footer my-auto ms-2"> <span class="">Add Category</span></a>
</div>

<div class="modal fade aitposmodal" id="pcateg"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form  method="post" action="<?= base_url('customers/add_category') ?>">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label for="input-2" class="form-label">Product Category Name</label>
                                <input type="text" class="form-control modal_inpu " id="input-2" name="parties_cat_name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="aitsun-primary-btn spinner_btn">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="sub_main_page_content">
    <div>
        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    <?php $pcount=0; foreach ($p_category as $pb) { $pcount++;?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div class="me-2"><?= $pb['parties_cat_name']; ?> </div>
                        <div class="d-flex my-auto">
                            <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#ed_pcat<?= $pb['id']; ?>">
                              <i class="bx bx-pencil"></i>
                            </a>

                            <a class="text-danger delete_product_cat" data-url="<?= base_url('customers/delete_product_cate'); ?>/<?= $pb['id']; ?>">
                              <i class="bx bx-trash"></i>
                            </a>
                        </div>

                        <div class="modal fade aitposmodal" id="ed_pcat<?= $pb['id']; ?>"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Product Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form  method="post" action="<?= base_url('customers/edit_cat') ?>/<?= $pb['id']; ?>">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12" >
                                                    <div class="form-group">
                                                        <label for="input-2" class="modal_lab">Product Category</label>
                                                        <input type="hidden" name="pr" value="<?= $pb['id']; ?>">
                                                        <input type="text" class="form-control modal_inpu" id="input-2" name="parties_cat_name" value="<?= $pb['parties_cat_name']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="aitsun-primary-btn">Update Category</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>

                    <?php if ($pcount<1): ?>
                        <li class="list-group-item d-flex justify-content-center text-center">
                            <div class="text-danger">No data</div>  
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
 </div>