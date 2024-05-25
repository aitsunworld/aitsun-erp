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
                    <b class="page_heading text-dark">Notifications</b>
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
     <div class="aitsun-row">
        <div class="col-md-12 p-0">
            <?php $i=0; foreach($notifications_data as $nt): $i++; ?>
             
            <div class="card mb-2">
               
                <div class="card-body p-2">
                    
                    <div class="tm_media">
                        <a href="<?= base_url(); ?>/redirect_notify?nurl=<?php echo $nt['url']; ?>&nid=<?php echo $nt['id']; ?>" class="d-block">
                            <div class="tm_avatar avatar-image">
                               <img src="<?= $nt['icon']; ?>" alt=""> 
                            </div>
                        </a>
                        
                        <div class="media-body ms-2 my-auto">
                             
                                <a class="text-dark d-block" style="font-size: 13px;"  href="<?= base_url(); ?>/redirect_notify?nurl=<?php echo $nt['url']; ?>&nid=<?php echo $nt['id']; ?>">
                                <?= strip_tags(str_replace(array('&lt;br&gt;','<br>'),'',$nt['title'])); ?>
                                </a>
                             
                            <span class="font-size-12 text-muted" style="font-size: 11px;"><?= timeAgo($nt['n_datetime'],now_time($user['id'])); ?></span>
                        </div>
                        
                    </div>
                    

                </div>
               
            </div>
            
            <?php endforeach ?>
            <?php if ($i==0): ?>
                <div class="m-b-15 ">
                    <div class="text-center ">
                        <h4 class="m-b-0 text-danger ">0 Notifications </h4>
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
    <div>
       <a href="javascript:void(0);" class="text-dark font-size-footer"><i class="bx bx-calendar"></i> <span class="my-auto"><?= get_date_format(now_time($user['id']),'d M Y') ?></span></a>

        <a href="<?= base_url('settings/preferences'); ?>" class="text-dark href_loader font-size-footer"><i class="bx bx-cog ms-2"></i> <span class="my-auto">App settings</span></a>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
