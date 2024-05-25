<div class="aitsun_tabs">
        <ul class="nav nav-tabs nav-pills with-arrow lined flex-column flex-sm-row text-center" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?= base_url('hr_manage/attendance') ?>">Attendance status</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?= base_url('hr_manage/attendance/logs') ?>">Punch logs</a>
          </li> 
        </ul>
 

        <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                 <div class="aitsun-row mt-3">
                      <div class="aitsun_table col-12 w-100 pt-0 pb-5"> 
                
                        <table id="parties_table" class="erp_table">
                         <thead>
                            <tr>
                                <th>Employee Name</th> 
                                <th class="text-center">Attendance</th>
                                <th class="text-center">Total worked hours</th> 
                                <th class="text-center">Overtime</th>  
                                <th class="text-end">Entry</th> 
                            </tr>
                         
                         </thead>
                          <tbody>
                            <?php $i=0; foreach ($attendance_data as $at_data): $i++; ?>
                                <tr>
                                    <td><?= $at_data['display_name'] ?></td>
                                    <td class="text-center"><?= ($at_data['day_status']==2)?"Full day":(($at_data['day_status']==1)?"Half day":"N/A"); ?></td>
                                    <td class="text-center"><?= ($at_data['worked_hours']!=0)?decimal_to_time($at_data['worked_hours']):"-"; ?></td>
                                    <td class="text-center"><?= ($at_data['overtime_hours']!=0)?decimal_to_time($at_data['overtime_hours']):"-"; ?></td> 
                                    <td class="text-end"> 
                                        <?php if ($at_data['late_come']<=0): ?>
                                            <span class="text-success">On-time <small>(<?= decimal_to_time(str_replace('-', '', $at_data['late_come'])) ?>)</small></span>
                                        <?php else: ?>
                                            <span class="text-danger">Late <small>(<?= decimal_to_time(str_replace('-', '', $at_data['late_come'])) ?>)</small></span>
                                        <?php endif ?> 
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            <?php if ($i==0): ?>
                                <tr>
                                    <td colspan="5">
                                        <h6 class="mt-2 text-center text-danger">No data</h6>
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
