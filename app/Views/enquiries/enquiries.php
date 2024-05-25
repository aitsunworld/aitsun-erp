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
                    <b class="page_heading text-dark">Enquiries</b>
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
<div class="main_page_content">
    <div class=""> 
 
        <div class="row">

                    <?php $i=0; foreach ($user_data as $us): $i++;?>
                    <div class="col-md-6">
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-header p-2">
                                <h6 class="card-title mb-0">
                                    <b><?= $us['name']; ?></b>
                                </h6>
                                <a href="mailto:<?= $us['email']; ?>">
                                <p class="mb-0"><i class="bx bx-envelope-open"></i> : <?= $us['email']; ?></p></a>

                            </div>
                            <div class="card-body p-2">

                                <?php if ($us['subject']!=''): ?>
                                    <p class="mb-0 text-muted" style="font-weight:500;">Subject : <?= $us['subject']; ?></p>
                                <?php endif ?>
                                
                                <?php if ($us['phone']!=''): ?>
                                <a href="tel:<?= $us['phone']; ?>">
                                <p class="mb-2" ><i class="bx bx-phone-outgoing"></i> : <?= $us['phone']; ?></p></a>
                                <?php endif ?>

                                <p class="mb-2" style="font-size:14px!important">
                                    <?= $us['message']; ?>
                                </p>

                                <div class="d-flex justify-content-between">
                                    <small class="my-auto"><i class="bx bx-calendar-alt"></i><?= get_date_format($us['datetime'],'d M Y h:i a'); ?></small>
                                    <a class="text-danger delete_enquiries" data-url="<?= base_url('enquiries/delete_enquiries'); ?>/<?= $us['id']; ?>"><i class="bx bx-trash me-0" style="font-size: 18px;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?> 
                    <?php if ($i==0): ?>
                        <div class="col-md-12">
                                <div class="text-center">
                                    <h4 class="m-5 text-danger">No Enquiries </h4>
                                </div>
                           
                        </div>
                    <?php endif ?>

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


 