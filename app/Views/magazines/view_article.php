<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>
             
                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('magazine_request'); ?>?page=1">Articles</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= reduce_chars($magzine['title'],27); ?>...</b>
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
<div class="sub_main_page_content mt-5 mb-5">
    <div class="aitsun-row"> 
        <div class="aitsun_table w-100 pt-0">


        <div class="d-flex justify-content-between">
            <div class="media align-items-center">
                <div class="">
                    <h4 class="m-b-0"><?= $view_article['title'] ?></h4>
                    <small><i><i class="bx bx-user mr-1"></i>Posted By : <b><?= user_name($view_article['student_id']) ?></b></i></small>&nbsp;&nbsp; <small><i><i class="bx bx-analyse mr-1"></i>Request For : <b><?= user_name($view_article['teacher_id']) ?></b></i></small>
                </div>
            </div>
            <div>
                <?php if(trim($view_article['status'])=='waiting')
                {
                    echo '<span class="badge bg-body rounded-pill text-warning">Waiting</span>';
                }elseif(trim($view_article['status'])=='accepted'){
                    echo '<span class="badge bg-body rounded-pill text-success">Accepted</span>';
                }elseif(trim($view_article['status'])=='rejected'){
                    echo '<span class="badge bg-body rounded-pill text-aitsun-red">Rejected</span>';
                } ?>
            </div>
        </div>
        <div class="text-center mt-3">
            <img style="width: auto;height: 300px;" src="<?= base_url('public'); ?>/uploads/articles/<?php if($view_article['magazine_img'] != ''){echo $view_article['magazine_img']; }else{ echo 'img-8.jpg';} ?>" >
        </div>
        <div class="w-100">
            <h6 class="aitsun-fw-bold">Description:</h6>
            <div><?= nl2br($view_article['description'] )?></div>
        </div>
        <div class="mt-3 text-end">
        
                <span class="font-sm">Post Date : <?= get_date_format($view_article['datetime'],'d M Y') ?></span>
           
        </div>
       </div>
                
    </div>
</div>



