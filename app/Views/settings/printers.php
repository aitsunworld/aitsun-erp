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
                    <b class="page_heading text-dark">Printers</b>
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
    <?= view('settings/settings_sidebar') ?>

    <div class="row setting_margin">
        <div class="col-lg-12">
 
                <?= csrf_field(); ?>

                    <div class="col-md-12 " > 
                        <div class="d-flex justify-content-between">
                            <h5 class=" my-auto ">Printers</h5> 
                            <a data-bs-toggle="modal" class="d-block my-auto btn btn-back btn-sm" data-bs-target="#add_printer">Add printer</a>
                        </div>
                    </div> 

                    <?php foreach ($all_printers as $printer): ?>
                    <div class="col-md-12 "> 
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="d-flex  justify-content-between">
                                    <h5 class=" my-auto ">
                                        <?php if ($printer['default']): ?>
                                            <i class="bx bx-check-circle text-success"></i>
                                        <?php endif ?>
                                        <?= $printer['printer_name'] ?>
                                    </h5> 
                                    <div class="d-flex">
                                        <?php if (!$printer['default']): ?>
                                            <a  class="d-block me-2 my-auto btn btn-back-success btn-sm" href="<?= base_url('settings/set_default_printer') ?>/<?= $printer['id'] ?>">
                                                <i class="bx bx-check-circle"></i> Set as default
                                            </a>
                                        <?php endif ?>
                                        <a  class="d-block me-2 my-auto btn btn-back btn-sm delete" data-url="<?= base_url('settings/delete_printer') ?>/<?= $printer['id'] ?>">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                        <a data-bs-toggle="modal" class="d-block my-auto btn btn-back-dark btn-sm" data-bs-target="#edit_printer<?= $printer['id'] ?>">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="modal  fade" id="edit_printer<?= $printer['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <div class="d-flex">
                                <h5 class="modal-title">Edit <?= $printer['printer_name'] ?></h5>
                              </div>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">

                                <form method="post" action="<?= base_url('settings/printers') ?>/<?= $printer['id'] ?>">
                                    <?= csrf_field(0) ?>
                                    <div class="form-group">
                                        <label>Printer share name</label>
                                        <input type="text" class="form-control" name="printer_name" value="<?= $printer['printer_name'] ?>" required>
                                    </div>

                                    <div class="form-group mt-2">
                                         <div class="form-check form-switch">
                                            <label class="form-check-label" for="silent">Silent
                                                <span class="span_font"> <?= langg(get_setting(company($user['id']),'language'),'(When this is enable, it will automatically print without preview)'); ?></span>
                                            </label>
                                            <input class="form-check-input" value="1" <?php if($printer['silent']==1){echo 'checked';} ?> type="checkbox" name="silent" id="silent">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label>Margins</label>
                                        <div class="d-flex">
                                            <div class="">
                                                <label class="my-auto me-2">Top</label>
                                                <input type="number" min="0" value="<?= $printer['top'] ?>" class="my-auto form-control" name="top" required>
                                            </div>
                                            <div class="">
                                                <label class="my-auto me-2">Right</label>
                                                <input type="number" min="0" value="<?= $printer['right'] ?>" class="my-auto form-control" name="right" required>
                                            </div>
                                            <div class="">
                                                <label class="my-auto me-2">Bottom</label>
                                                <input type="number" min="0" value="<?= $printer['bottom'] ?>" class="my-auto form-control" name="bottom" required>
                                            </div>
                                            <div class="">
                                                <label class="my-auto me-2">Left</label>
                                                <input type="number" min="0" value="<?= $printer['left'] ?>" class="my-auto form-control" name="left" required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group mt-2">
                                        <label>Scale</label>
                                        <input type="number" value="<?= $printer['scale'] ?>" class="form-control" name="scale" min="10" max="200" required>
                                    </div>

                                    
                                    
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary rounded-pill text-center">Save printer</button>
                                    </div> 
                                </form>
                              
                            </div> 
                          </div>
                        </div>
                      </div>
                    <?php endforeach ?>



                      <div class="modal  fade" id="add_printer" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <div class="d-flex">
                                <h5 class="modal-title">Printer</h5>
                              </div>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">

                                <form method="post" action="<?= base_url('settings/printers') ?>">
                                    <?= csrf_field(0) ?>
                                    <div class="form-group">
                                        <label>Printer share name</label>
                                        <input type="text" class="form-control" name="printer_name" required>
                                    </div>

                                    <div class="form-group mt-2">
                                         <div class="form-check form-switch">
                                            <label class="form-check-label" for="silent">Silent
                                                <span class="span_font"> <?= langg(get_setting(company($user['id']),'language'),'(When this is enable, it will automatically print without preview)'); ?></span>
                                            </label>
                                            <input class="form-check-input" value="1" type="checkbox" name="silent" id="silent">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label>Margins</label>
                                        <div class="d-flex">
                                            <div class="">
                                                <label class="my-auto me-2">Top</label>
                                                <input type="number" min="0" value="10" class="my-auto form-control" name="top" required>
                                            </div>
                                            <div class="">
                                                <label class="my-auto me-2">Right</label>
                                                <input type="number" min="0" value="10" class="my-auto form-control" name="right" required>
                                            </div>
                                            <div class="">
                                                <label class="my-auto me-2">Bottom</label>
                                                <input type="number" min="0" value="10" class="my-auto form-control" name="bottom" required>
                                            </div>
                                            <div class="">
                                                <label class="my-auto me-2">Left</label>
                                                <input type="number" min="0" value="10" class="my-auto form-control" name="left" required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group mt-2">
                                        <label>Scale</label>
                                        <input type="number" value="100" class="form-control" name="scale" min="10" max="200" required>
                                    </div>

                                      <div class="form-group mt-2 d-none">
                                         <div class="form-check form-switch">
                                            <label class="form-check-label" for="default">Default printer</label>
                                            <input class="form-check-input" value="1" checked type="checkbox" name="default" id="default">
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary rounded-pill text-center">Add printer</button>
                                    </div> 
                                </form>
                              
                            </div> 
                          </div>
                        </div>
                      </div>
        </div>
    </div>
</div>

