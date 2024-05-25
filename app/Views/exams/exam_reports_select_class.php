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

                <li class="breadcrumb-item">
                    <a href="<?= base_url('exams'); ?>" class="href_loader">Exams</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Report</b>
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
        <div class="col-md-12">
             <h5 class="text-center mb-3">Exam reports - Choose class</h5>
        </div>
       

            <?php $i=0; foreach ($my_classes as $mc): $i++; ?>
            
                <div class="col-md-4 mb-3 px-2">
                    <div class="bg-dark px-3 py-1 rounded-3 text-center">
                        <a href="<?= base_url('exams/view_exam_report'); ?>/<?= $mc['class_id'] ?>" class="long_loader">
                            <h4 class="mb-0 text-white"><?= class_name($mc['class_id']); ?></h4>
                        </a>
                    </div>
                </div>


            <?php endforeach ?>
            
            <?php if ($i==0): ?>
                <div class="col-md-12 text-center">
                    <h4 class="m-b-0 text-danger">You have no classes </h4>
                </div>
            <?php endif ?>
        

    </div>
</div>