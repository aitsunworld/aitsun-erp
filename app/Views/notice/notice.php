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
                    <b class="page_heading text-dark">Notice</b>
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
<div class="toolbar d-flex justify-content-between">
    <div>
        
    </div>
    <a  class="text-dark font-size-footer my-auto ms-2" data-bs-toggle="modal" data-bs-target="#add_notice"> <span class="">Add Notice</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<!-- Notice Modal -->
<div class="modal fade aistun-modal" id="add_notice"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= langg(get_setting(company($user['id']),'language'),'Add Notices'); ?></h5>
        <button type="button" class="close close_school" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="notice_add_form" enctype="multipart/form-data" action="<?= base_url('notice/send_notice'); ?>/<?= $user['company_id'] ?>">
        <?= csrf_field(); ?>
      <div class="modal-body">
      
        <div>
          
          
          <div class="form-group mb-2">
            <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Enter new Notice'); ?></label>
            <input type="text" name="subject" placeholder="Notice Subject" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <input type="hidden" name="uid" value="<?= $user['id'] ?>">
            <textarea id="summernote" name="notice" class="richtext w-100" required="required"></textarea>
             <label id="final_richcontent-error" class="custom-error text-danger mt-2" for="notice"></label>

          </div>
        </div>
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
        <button type="button" id="send_notice" class="aitsun-primary-btn"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- end Notice Modal -->
<div class="sub_main_page_content h-auto mb-4">

           <?php foreach ($notice_data as $ntc) { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div id="invoice" class="">

                        <div class="modal fade aistun-modal" id="notices_edit<?= $ntc['id'] ?>" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="techerdibt<?= $ntc['id'] ?>">Edit Notice</h5>
                                        <button type="button" class="close close_school" data-bs-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" id="edit_notice_form<?= $ntc['id'] ?>" action="<?= base_url('notice/update_notice') ?>/<?= $ntc['id'] ?>" >
                                        <?= csrf_field(); ?>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                               
                                                <input type="text" name="subject" placeholder="Notice Subject" value="<?= $ntc['subject'] ?>" class="form-control" required>
                                               </div>
                                                <div class="form-group col-md-12">
                                                    
                                                <textarea name="notice" class="richtext form-control mt-3" required="required"><?= $ntc['details'] ?></textarea>

                                               </div>
                                           </div>
                                           
                                            <div class="modal-footer">
                                                <button class="aitsun-primary-btn edit_notice" type="button" data-id="<?= $ntc['id'] ?>">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6>SUBJECT : <?= $ntc['subject'] ?> </h6>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-black-50 mt-2">
                                <?= $ntc['details'] ?>
                              
                            </div>
                            
                        </div>
                        <div class="">
                            <hr>
                            <div class="row m-v-20">
                                <div class="col-sm-6 text-black-50">
                                   <span class="font-sm"><i>Created At: <?= get_date_format($ntc['datetime'],'d M Y') ?> </i></span>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#notices_edit<?= $ntc['id'] ?>"><i class="bx bxs-edit-alt"></i></a>

                                    <a class="btn-delete-red action_btn cursor-pointer deletenote"  data-deleteurl="<?= base_url('notice/deletenotices'); ?>/<?= $ntc['id'] ?>"><i class="bx bxs-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
           </div>
       <?php } ?>         
        
</div>


<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


<script>
    $(document).ready(function() {
        $('.richtext').summernote({
            placeholder: 'Notices',

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