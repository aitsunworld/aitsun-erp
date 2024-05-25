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

                <?php if ($redi=='party'): ?>
                   <li class="breadcrumb-item active href_loader" aria-current="page">
                        <a href="<?= base_url('customers'); ?>">Parties</a>
                    </li>

                    <li class="breadcrumb-item active href_loader" aria-current="page">
                        <a href="<?= base_url('import_and_export/parties'); ?>">Import & Export</a>
                    </li>
                <?php elseif($redi=='student'): ?>
                     <li class="breadcrumb-item active href_loader" aria-current="page">
                        <a href="<?= base_url('student-master'); ?>?page=1">Student master</a>
                    </li>

                    <li class="breadcrumb-item active href_loader" aria-current="page">
                        <a href="<?= base_url('import_and_export/students'); ?>">Import & Export</a>
                    </li>
                <?php endif ?>
             

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Import Report</b>
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
    <div class="aitsun-row ">
        <div class="col-12">
            <div class="aitsun_table table-responsive  w-100 pt-0">
                <table class="w-100 import_result_table no-wrap">
                    <thead>
                        <tr class="dark_tr">
                            <td></td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Contact</td>
                            <td>Address</td>
                            <td>Type</td>
                            <td>GST/VAT</td>
                            <td>State</td>
                            <td>Op. Balance</td>
                            <td>Op. Type</td>
                             
                            <td class="text-center">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $import_report ?>
                        
                    </tbody>
                </table>

                <div class="text-center">
                    <?php if ($redi=='party'): ?>
                        <?php if ($count<5): ?>
                            <a class="btn btn-sm mt-3 erp_round btn-success w-25 text-center href_loader" href="<?= base_url('import_and_export/parties') ?>">Ok</a>
                        <?php endif ?>
                        
                    <?php elseif($redi=='student'): ?>
                        <a class="btn btn-sm mt-3 erp_round btn-success w-25 text-center href_loader" href="<?= base_url('import_and_export/students') ?>">Ok</a>
                    <?php else: ?>
                        <a class="btn btn-sm mt-3 erp_round btn-success w-25 text-center href_loader" href="<?= base_url('products/import_and_export') ?>">Ok</a>
                    <?php endif ?>
                </div>

            </div>
           
            <div> 
                <span><?= $resubmit_form ?></span>
                <div class="mt-4 mb-4">
                    <!-- Display resubmit form if necessary -->
                    <?php if ($count >= 4): ?>
                        <div class="col-xl-12 col-md-12 text-center d-inline-block">
                            <form action="<?= base_url('import_and_export/import_parties');?>" class="submit_loader w-50 m-auto text-center spsec-validation" id="spsec-validation" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <?= csrf_field(); ?>
                                <div class="form-group position-relative mb-2">
                                    <input type="file" name="fileURL" id="file-url" class="filestyle form-control custom-file-input" data-allowed-file-extensions="[CSV, csv,xlsx,XLSX]" accept=".CSV, .csv, .xlsx" data-buttontext="Choose File" required>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" name="import_csv" id="import_csv" class="btn btn-dark erp_round btn-sm">Resubmit the file</button>
                                </div> 
                            </form>
                        </div> 
                    <?php endif ?>
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
