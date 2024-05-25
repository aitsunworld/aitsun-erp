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

                <?php if ($event_data['type']=='sports'): ?>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('school_activities/sports_events'); ?>?page=1" class="href_loader">Sports events</a>
                    </li>

                <?php else: ?>

                    <li class="breadcrumb-item">
                        <a href="<?= base_url('school_activities/eccc_events'); ?>?page=1" class="href_loader">EC/CC events</a>
                    </li>

                <?php endif ?>
                
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Reward</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#event_reward_table" data-filename="Events Reward"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#event_reward_table" data-filename="Events Reward"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#event_reward_table" data-filename="Events Reward"> 
            <span class="my-auto">PDF</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#event_reward_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <span class="my-auto font-size-footer aitsun-fw-bold text-aitsun-red"><?= $event_data['events_name']; ?></span>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->





<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="event_reward_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Name</th>
                    <th class="sorticon">Class</th> 
                    <th class="sorticon">Mark</th> 
                    <th class="sorticon">Reward</th> 
                    <th class="sorticon" data-tableexport-display="none">Change Reward</th>
                    <th class="sorticon" data-tableexport-display="none">Send SMS</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($participants_data as $pd) { $data_count++; ?>
                  <tr>
                    <td style="width: 80px;"><?= $data_count; ?></td>
                    <td><?= user_name($pd['student_id']) ?></td>
                    <td><?= class_name(current_class_of_student(company($user['id']),$pd['student_id'])) ?></td> 
                    <td>
                        <?php if ($event_data['type']=='sports'): ?>
                        
                            <input type="number" min="1" max="100" class="health_box_mark mr-2 event_mark form-control py-1" data-student_id="<?= $pd['student_id']; ?>" data-event_id="<?= $event_data['id']; ?>"  value="<?= get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'mark','sports') ?>">

                        <?php elseif($event_data['type']=='eccc'): ?>
                            <input type="number" min="1" max="100" class="health_box_mark mr-2 event_mark form-control py-1" data-student_id="<?= $pd['student_id']; ?>" data-event_id="<?= $event_data['id']; ?>"  value="<?= get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'mark','eccc') ?>">
                            

                        <?php endif ?>
                         
                    </td>
                    <td class="text-capitalize">
                        <?php if ($event_data['type']=='sports'): ?>
                            <p id="rw_status<?= $pd['student_id']; ?>" class="m-0"><?= get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','sports') ?></p>
                        <?php elseif($event_data['type']=='eccc'): ?>
                            <p id="rw_status<?= $pd['student_id']; ?>" class="m-0"><?= get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','eccc') ?></p>

                        <?php endif ?>
                        

                    </td>
                    
                    <td data-tableexport-display="none">

                        <?php if ($event_data['type']=='sports'): ?>

                            <select class="health_box_Select event_reward_select w-100 form-select py-1 " id="rw_val<?= $pd['student_id']; ?>" data-student_id="<?= $pd['student_id']; ?>" data-event_id="<?= $event_data['id']; ?>">
<option value="">Select reward</option>
<option value="not participated" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','sports')=='not participated') { echo 'selected'; } ?>>Not participated</option>
<option value="first" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','sports')=='first') { echo 'selected'; } ?>>First</option>
<option value="second" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','sports')=='second') { echo 'selected'; } ?>>Second</option>
<option value="third" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','sports')=='third') { echo 'selected'; } ?>>Third</option>
<option value="participated" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','sports')=='participated') { echo 'selected'; } ?>>Participated</option>
                                           </select>

                        <?php elseif($event_data['type']=='eccc'): ?>


                            <select class="health_box_Select event_reward_select w-100 form-select py-1 " id="rw_val<?= $pd['student_id']; ?>" data-student_id="<?= $pd['student_id']; ?>" data-event_id="<?= $event_data['id']; ?>">
<option value="">Select reward</option>
<option value="not participated" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','eccc')=='not participated') { echo 'selected'; } ?>>Not participated</option>
<option value="first" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','eccc')=='first') { echo 'selected'; } ?>>First</option>
<option value="second" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','eccc')=='second') { echo 'selected'; } ?>>Second</option>
<option value="third" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','eccc')=='third') { echo 'selected'; } ?>>Third</option>
<option value="participated" <?php if (get_reward_data(company($user['id']),$pd['student_id'],$event_data['id'],'reward','eccc')=='participated') { echo 'selected'; } ?>>Participated</option>
                                           </select>


                        <?php endif ?>
                        


                    </td>
                    
                    <td class="text-end" style="width: 150px;" data-tableexport-display="none">
                        <div class="p-1">

                        <a class="py-1 px-2 btn-success me-2 action_btn cursor-pointer send_reward_via_sms" data-uid="<?= $pd['student_id'] ?>" data-phone="<?= user_phone($pd['student_id']) ?>" data-event="<?= $event_data['events_name'] ?>"> Notify via SMS</a>

                        </div>


                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span class="text-danger">No rewards</span>
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
    <?php if ($event_data['type']=='sports'): ?>

        <div class="b_ft_bn">
            <a href="<?= base_url('school_activities/sports'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bx-football ms-2"></i> <span class="my-auto">Sports</span></a>/
            <a href="<?= base_url('school_activities/sports_participants'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-user ms-2"></i> <span class="my-auto">Participants</span></a>/

            <a href="<?= base_url('school_activities/sports_events'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-trophy ms-2"></i> <span class="my-auto">Events/Competitions</span></a>
        </div>

    <?php else: ?>

        <div class="b_ft_bn">
            <a href="<?= base_url('school_activities/eccc'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-palette ms-2"></i> <span class="my-auto">EC/CC</span></a>/
            <a href="<?= base_url('school_activities/eccc_participants'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-user ms-2"></i> <span class="my-auto">Participants</span></a>/

            <a href="<?= base_url('school_activities/eccc_events'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-trophy ms-2"></i> <span class="my-auto">Events/Competitions</span></a>
        </div>


    <?php endif ?>
    
    <div>
        <span class="m-0 font-size-footer">Total <?= subjects_name($event_data['related_to']) ?> Students : <?= count($participants_data); ?></span>
    </div>

    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->