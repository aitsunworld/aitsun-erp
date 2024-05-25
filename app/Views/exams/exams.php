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
                    <b class="page_heading text-dark">Exams</b>
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
<div class="main_page_content d-flex">
    <div class="menu_box">
        
         <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('exams/main_exam'); ?>">
            <img src="<?= base_url('public/images/menu_icons/main_exam.webp') ?>" class="menu_img">
            <h6 class="mt-1">Exam</h6>
        </a> 
        
        <a class="menu_icon text-dark cursor-pointer" href="javascript:void(0);">
            <img src="<?= base_url('public/images/menu_icons/online_exam.webp') ?>" class="menu_img">
            <h6 class="mt-1">Online exam</h6>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('exams/exam_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/exam_reports.webp') ?>" class="menu_img">
            <h6 class="mt-1">Reports</h6>
        </a>

         
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
         
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 