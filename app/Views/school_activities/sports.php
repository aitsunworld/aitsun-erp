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
                    <a class="href_loader" href="<?= base_url('school_activities'); ?>">Activities</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Sports</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#sports_table" data-filename="Sports"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#sports_table" data-filename="Sports"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#sports_table" data-filename="Sports"> 
            <span class="my-auto">PDF</span>
        </a>
        

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#sports_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#addsportsmodal" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ New sports</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->






<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="addsportsmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addsportsmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addsportsmodalLabel">Add Sports</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_sports_form" action="<?= base_url('school_activities/add_sports'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <input type="hidden" name="sports_id" value="<?= sports_name(company($user['id'])) ?>">
                        <label class="font-weight-semibold" for="sportsname">Sports Name</label>
                        <input type="text" class="form-control" name="sportsname"  >
                    </div>
                    <div class="form-group col-md-12">
                        <label class="font-weight-semibold" for="sportscode">Sports Code</label>
                        <input type="text" class="form-control" name="sportscode"  >
                    </div>
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_sports">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="sports_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Sports Name</th>
                    <th class="sorticon">Sports Code</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($sports_data as $sp) { $data_count++; ?>
                  <tr>
                    <td style="width: 80px;"><?= $sp['serial_no'] ?></td>
                    <td><?= $sp['subject_name'] ?></td>
                    <td><?= $sp['subject_code'] ?></td> 
                    
                    <td class="text-end" style="width: 150px;" data-tableexport-display="none">
                        <div class="p-1">

                        <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#sports_edit<?= $sp['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                        <a class="deletesports btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('school_activities/deletesports'); ?>/<?= $sp['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>


                        <!-- ////////////////////////// MODAL ///////////////////////// -->

                        <div class="modal fade" id="sports_edit<?= $sp['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="sports_edit<?= $sp['id'] ?>Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="sports_edit<?= $sp['id'] ?>Label">Add Sports</h5>    
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_sports_form<?=$sp['id'] ?>" action="<?=base_url('school_activities/update_sports') ?>/<?=$sp['id'] ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                            <input type="hidden" name="sports_id" value="<?= sports_name(company($user['id'])) ?>">
                                            <label class="font-weight-semibold" for="sportsname">Sports Name</label>
                                            <input type="text" class="form-control" name="sportsname" value="<?=$sp['subject_name'] ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="font-weight-semibold" for="sportscode">Sports Code</label>
                                            <input type="text" class="form-control" name="sportscode" value="<?=$sp['subject_code'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-start py-1">
                                    <button type="button" class="aitsun-primary-btn edit_sports" data-id="<?= $sp['id'] ?>">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    <!-- ////////////////////////// MODAL ///////////////////////// -->







                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span class="text-danger">No sports</span>
                        </td>
                    </tr>
                <?php endif ?>
                 
              </tbody>
            </table>
        </div>

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('school_activities/sports_participants'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-user ms-2"></i> <span class="my-auto">Participants</span></a>/
        <a href="<?= base_url('school_activities/sports_events'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-trophy ms-2"></i> <span class="my-auto">Events/Competitions</span></a>/
        <a href="<?= base_url('sports_report'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-report ms-2"></i> <span class="my-auto">Sports Reports</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total sports : <?= count($sports_data); ?></span>
    </div>

    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->