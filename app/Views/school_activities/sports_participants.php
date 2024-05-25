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
                    <b class="page_heading text-dark">Sports participants</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#sports_participant_table" data-filename="Sports Participants"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#sports_participant_table" data-filename="Sports Participants"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#sports_participant_table" data-filename="Sports Participants"> 
            <span class="my-auto">PDF</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#sports_participant_table"> 
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
             <select class="form-select " name="sports_category" >
                    <option value="" selected>Category</option>
                     <?php foreach (sports_array(company($user['id'])) as $spt): ?>
                        <option value="<?= $spt['id']; ?>"><?= subjects_name($spt['id']); ?></option>
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
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('school_activities/sports_participants') ?>?page=1"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
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
          <form id="add_participant_form" action="<?= base_url('school_activities/add_sports_participants'); ?>/<?= $user['company_id'] ?>">
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
                        <select class="form-control" name="sports">
                            <option value="">Select Sports</option>
                            <?php foreach (sports_array(company($user['id'])) as $spt): ?>
                                <option value="<?= $spt['id']; ?>"><?= subjects_name($spt['id']); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_participant">Save</button>
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
            
            <table id="sports_participant_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Student Name</th>
                    <th class="sorticon">Sports</th> 
                    <th class="sorticon" style="width:180px;">Involvement(%)</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($sports_participants_data as $ps) { $data_count++; ?>
                  <tr>
                    <td style="width: 80px;"><?= $ps['serial_no'] ?></td>
                    <td><?= user_name($ps['student_id']) ?> - <?= class_name(current_class_of_student(company($user['id']),$ps['student_id'])) ?></td>
                    <td><?= subjects_name($ps['sports_id']) ?></td> 

                    <td><input type="number" min="1" max="100" class="health_box analytics_sports form-control py-1" data-student_id="<?= $ps['student_id']; ?>" data-sports_id="<?= $ps['sports_id']; ?>" value="<?= get_analytics_subject_data(company($user['id']),$ps['student_id'],$ps['sports_id'],'involve_sports') ?>"></td>
                    
                    <td class="text-end" style="width: 150px;" data-tableexport-display="none">
                        <div class="p-1">

                        <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#sports_participantedit<?= $ps['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                        <a class="deletesportspartici btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('school_activities/delete_sports_participants'); ?>/<?= $ps['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>


                        <!-- ////////////////////////// MODAL ///////////////////////// -->

                        <div class="modal fade" id="sports_participantedit<?= $ps['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="sports_participantedit<?= $ps['id'] ?>Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="sports_participantedit<?= $ps['id'] ?>Label"><?= user_name($ps['student_id']) ?></h5>    
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_participant_form<?=$ps['id'] ?>" action="<?=base_url('school_activities/update_sports_participants') ?>/<?=$ps['id'] ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 d-none">
                                                

                                                <div class="aitsun_select position-relative ">
                                           
                                                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/students'); ?>">
                                                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
                                         
                                                    <select class="form-select" name="student">
                                                        <option value="">Select student</option> 
                                                        <option value="<?=$ps['student_id']; ?>" selected><?= user_name($ps['student_id']); ?> - <?= class_name(current_class_of_student(company($user['id']),$ps['student_id'])) ?></option>
                                                    </select>
                                                    <div class="aitsun_select_suggest">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <select class="form-select" name="sports">
                                                    <option value="">Select Sports</option>
                                                    <?php foreach (sports_array(company($user['id'])) as $spt): ?>
                                                        <option value="<?= $spt['id']; ?>" <?php if ($spt['id']==$ps['sports_id']) { echo 'selected'; } ?>><?= subjects_name($spt['id']); ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-start py-1">
                                    <button type="button" class="aitsun-primary-btn edit_participants" data-id="<?= $ps['id'] ?>">Save</button>
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
                            <span class="text-danger">No sports participants</span>
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
        <a href="<?= base_url('school_activities/sports'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bx-football ms-2"></i> <span class="my-auto">Sports</span></a>/
        <a href="<?= base_url('school_activities/sports_events'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-trophy ms-2"></i> <span class="my-auto">Events/Competitions</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total Participants : <?= count($sports_participants_data); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->