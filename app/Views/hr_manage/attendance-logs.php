<div class="aitsun_tabs">
        <ul class="nav nav-tabs nav-pills with-arrow lined flex-column flex-sm-row text-center" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link " href="<?= base_url('hr_manage/attendance') ?>">Attendance status</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?= base_url('hr_manage/attendance/logs') ?>">Punch logs</a>
          </li> 
        </ul>
 

        <div class="tab-content" id="myTabContent">
               
          <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <div class="aitsun-row mt-3">
                  <div class="aitsun_table col-12 w-100 pt-0 pb-5"> 
            
                    <table id="parties_table" class="erp_table">
                     <thead>
                        <tr>
                            <th>Employee Name</th> 
                            <th>Employee code</th>
                            <th>Punched time</th> 
                            <th class="text-center">In/Out</th>
                            <th>Type</th> 
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                     
                     </thead>
                      <tbody>
                        
                         <?php $i=0; foreach ($attendance_data as $atn): $i++; ?>
                            <tr>
                                <td>
                                    <?= user_name($atn['employee_id']); ?>
                                    <input type="hidden" name="empid[]" value="<?= $atn['employee_id']; ?>">
                                </td>
                                
                                <td>
                                    
                                   <?= $atn['employee_code']; ?>

                                </td>
         

                                <td>
                                    <?= get_date_format($atn['punched_time'],'d M Y h:i A'); ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($atn['inout_status']=='in'): ?>
                                       <span class="badge bg-dark" style="min-width: 48px;"><i class="bx bx-walk"></i> <?= strtoupper($atn['inout_status']) ?></span>
                                    <?php else: ?>
                                       <span class="badge bg-danger"><i class="bx bx-walk" style="transform:scale(-1,1.0);"></i> <?= strtoupper($atn['inout_status']) ?></span>
                                    <?php endif ?>
                                    
                                </td>
                                <td>
                                    <?= ($atn['state']==1)?'<span class="badge bg-danger">Device</span>':'<span class="badge bg-invoice">Manual</span>'; ?>
                                </td> 
                              

                                <td>
                                    <input type="text" name="at_note[]" class="aitsun-simple-input punch_note" data-id="<?= $atn['id'] ?>" data-save_url="<?= base_url('hr_manage/update_note') ?>/<?= $atn['id'] ?>" value="<?= $atn['note']; ?>">
                                </td>

                                <td>
                                    <!-- <a class="btn-edit-dark me-1 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#punchedit<= $atn['id'] ?>"><i class="bx bxs-edit-alt"></i></a> -->



        <div class="aitsun-modal modal fade" id="punchedit<?= $atn['id'] ?>"  aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Manual punching</h5>
                        <button type="button" class="btn-close close_staff_mod" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit_punch_btn_form<?= $atn['id'] ?>" action="<?= base_url('hr_manage/edit_punch') ?>/<?= $atn['id'] ?>" method="post">
                        <?= csrf_field(); ?>
                          <div class="modal-body">
                            <div class="row">
                              

                             <div class="col-md-6 mb-2"> 
                                 <div class="form-group">
                                     <label>Date</label>
                                     <input type="date" name="punch_date" class="form-control" value="<?= get_date_format($atn['punched_time'],'Y-m-d') ?>" required>
                                 </div>
                             </div>

                             <div class="col-md-6 mb-2"> 
                                 <div class="form-group">
                                     <label>Time</label>
                                     <input type="time" name="punch_time" class="form-control" value="<?= get_date_format($atn['punched_time'],'h:i:s') ?>" required>
                                 </div>
                             </div>
                             
                              
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between"> 
                            <div>
                                <button type="button" class="btn btn-secondary close_staff_mod" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                                <button type="button" class="aitsun-primary-btn edit_punch_btn" data-id="<?= $atn['id'] ?>"><?= langg(get_setting(company($user['id']),'language'),'Save'); ?></button>
                            </div> 
                          </div>
                        </form>
                                                    
                </div>
            </div>
        </div>
             
                                        
                                    <a class="delete btn-delete-red action_btn cursor-pointer" data-url="<?= base_url('hr_manage/delete_punch'); ?>/<?= $atn['id']; ?>"><i class="bx bxs-trash"></i></a>
                                </td>

                                    
                            </tr>

                            <?php endforeach ?>
                                <?php if ($i==0): ?>
                                    <tr>
                                        <td colspan="7">
                                            <h6 class="mt-2 text-center text-danger">No data fetched</h6>
                                        </td>
                                    </tr>
                                <?php endif ?>

                      </tbody>
                    </table>

                </div>
            </div>


          </div> 
        </div>
    </div>
