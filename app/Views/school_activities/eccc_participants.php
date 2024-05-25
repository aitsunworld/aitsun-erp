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
                    <b class="page_heading text-dark">EC/CC participants</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#eccc_participant_table" data-filename="EC/CC Participants"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#eccc_participant_table" data-filename="EC/CC Participants"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#eccc_participant_table" data-filename="EC/CC Participants"> 
            <span class="my-auto">PDF</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#eccc_participant_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#addparticipantsmodel" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ New participant</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
            <div class="w-50">
             <select class="form-select" name="eccc_category">
                    <option value="" selected>Category</option>
                     <?php foreach (activities_array(company($user['id'])) as $ac): ?>
                        <option value="<?= $ac['id']; ?>"><?= subjects_name($ac['id']); ?></option>
                     <?php endforeach ?>
            </select>
            </div>
            <div class="aitsun_select position-relative w-50">
                                           
                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
         
                    <select class="form-select" name="students">
                        <option value="">Select student</option> 
                       
                    </select>
                    <div class="aitsun_select_suggest">
                    </div>
                </div>
            
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('school_activities/eccc_participants') ?>?page=1"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>



<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="addparticipantsmodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addparticipantsmodelLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addparticipantsmodelLabel">Add Participant</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_activityparticipant_form" action="<?= base_url('school_activities/add_actparticipants'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                     <div class="form-group col-md-12 mb-3">
                        <div class="aitsun_select position-relative ">
                                           
                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                 
                            <select class="form-select" name="student">
                                <option value="">Select student</option> 
                               
                            </select>
                            <div class="aitsun_select_suggest">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <select class="form-control" name="activity">
                            <option value="">Select activities</option>
                           <?php foreach (activities_array(company($user['id'])) as $spt): ?>
                                <option value="<?= $spt['id']; ?>"><?= subjects_name($spt['id']); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_actparticipant">Save</button>
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
            
            <table id="eccc_participant_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Student Name</th>
                    <th class="sorticon">Activities</th> 
                    <th class="sorticon" style="width:180px;">Involvement(%)</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($eccc_participants_data as $ep) { $data_count++; ?>
                  <tr>
                    <td style="width: 80px;"><?= $ep['serial_no'] ?></td>
                    <td><?= user_name($ep['student_id']) ?> - <?= class_name(current_class_of_student(company($user['id']),$ep['student_id'])) ?></td>
                    <td><?= subjects_name($ep['sports_id']) ?></td> 

                    <td><input type="number" min="1" max="100" class="health_box analytics_eccc form-control py-1" data-student_id="<?= $ep['student_id']; ?>" data-activities_id="<?= $ep['sports_id']; ?>" value="<?= get_analytics_subject_data(company($user['id']),$ep['student_id'],$ep['sports_id'],'involve_eccc') ?>"></td>
                    
                    <td class="text-end" style="width: 150px;" data-tableexport-display="none">
                        <div class="p-1">

                        <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#actparticipantedit<?= $ep['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                        <a class="deleteactpartici btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('school_activities/deletesactparticipants'); ?>/<?= $ep['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>


                        <!-- ////////////////////////// MODAL ///////////////////////// -->

                        <div class="modal fade" id="actparticipantedit<?= $ep['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="actparticipantedit<?= $ep['id'] ?>Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="actparticipantedit<?= $ep['id'] ?>Label"><?= user_name($ep['student_id']) ?></h5>    
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_actparticipant_form<?=$ep['id'] ?>" action="<?=base_url('school_activities/update_actparticipants') ?>/<?=$ep['id'] ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 d-none">

                                            <div class="aitsun_select position-relative ">
                                           
                                                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                                                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
                                         
                                                    <select class="form-select" name="student">
                                                        <option value="">Select student</option> 
                                                        <option value="<?=$ep['student_id']; ?>" selected><?= user_name($ep['student_id']); ?> - <?= class_name(current_class_of_student(company($user['id']),$ep['student_id'])) ?></option>
                                                    </select>
                                                    <div class="aitsun_select_suggest">
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="form-group col-md-12">
                                                <select class="form-select" name="activity">
                                                    <option value="">Select activities</option>
                                                    <?php foreach (activities_array(company($user['id'])) as $spt): ?>
                                                    <option value="<?= $spt['id']; ?>" <?php if ($spt['id']==$ep['sports_id']) { echo 'selected'; } ?>><?= subjects_name($spt['id']); ?></option>
                                                    <?php endforeach ?>

                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-start py-1">
                                    <button type="button" class="aitsun-primary-btn edit_actparticipants" data-id="<?= $ep['id'] ?>">Save</button>
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
                            <span class="text-danger">No ec/cc participants</span>
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
        <a href="<?= base_url('school_activities/eccc'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-palette ms-2"></i> <span class="my-auto">EC/CC</span></a>/
        <a href="<?= base_url('school_activities/eccc_events'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-trophy ms-2"></i> <span class="my-auto">Events/Competitions</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total Participants : <?= count($eccc_participants_data); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->