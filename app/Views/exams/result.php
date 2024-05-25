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

                <li class="breadcrumb-item href_loader" aria-current="page">
                    <a href="<?= base_url('student-master'); ?>">Student Master</a>
                </li>

                <li class="breadcrumb-item href_loader" aria-current="page">
                    <a href="<?= base_url('student-master/student_details') ?>/<?= $student_data['id']; ?>"><?= $student_data['first_name']; ?></a>

                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Exam Result</b>
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
 

        <div class=" col-12 w-100 pt-0 pb-5">
        	  <iframe src="<?= base_url(); ?>/exams/progress_card/<?= $main_exam_data['id']; ?>/<?= $student_data['id']; ?>/<?= company($user['id']); ?>/student" class="w-100"  style="height:90vh;"></iframe>

        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->

        