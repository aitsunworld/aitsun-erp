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
                    <b class="page_heading text-dark">Time Table</b>
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

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#time_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>
    <div>
        <button class="aitsun-primary-btn aitsun-btn-sm my-auto notify_time_table my-auto text-white" id="notify_time_table">Notify students</button>
        <a type="button" data-bs-toggle="modal" data-bs-target="#time_table_modal" class="text-dark font-size-footer ms-2 my-auto"> <span class="">+ Time Table</span></a>
    </div>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MODAL ///////////////////////// -->

<div class="modal fade" id="time_table_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="bookaddmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add time table</h5>    
                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
               
                 <form id="add_time_table_form" action="<?= base_url('time_table/add_time_table'); ?>/<?= $user['company_id'] ?>">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                        <div class="row">
                            
                            <div class="form-group col-md-6 mb-2">
                                <label class="font-weight-semibold" for="week">Select Week</label>
                                <select class="form-control" name="week" id="week">
                                    <option value="">Choose Week</option>
                                    <option value="0">Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Firday</option>
                                    <option value="6">Saturday</option>
                                    
                                </select>
                                
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label class="font-weight-semibold" for="classes">Select Class</label>

                                <div class="aitsun_select position-relative">
                                    <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
                                    <a class="select_close d-none"><i class="bx bx-x"></i></a>
                         
                                    <select class="form-select" required name="classes">
                                        <option value="">Select Class</option> 
                                       
                                    </select>
                                    <div class="aitsun_select_suggest">
                                    </div>
                                </div>

                                
                                
                            </div>
                            
                            <div class="form-group col-md-12 mb-2">
                                <label class="font-weight-semibold" for="subject">Select Subject</label>
                                <select class="form-control" name="subject" id="subject">
                                    <option value="">Choose Subject</option>
                                    <option value="f">Free Hour</option>
                                    <option value="l">Launch Time</option>

                                    <?php foreach (subject_array(company($user['id'])) as $sub): ?>
                                        <option value="<?= $sub['id']; ?>"><?= $sub['subject_name']; ?></option>
                                    <?php endforeach ?>
                                </select>
                                
                            </div>
                            
                            
                            <div class="form-group col-md-6 mb-2">
                                <label class="form-contro" for="start_time">Start Time</label>
                                
                                <div class="bootstrap-timepicker">
                                       <div class="form-group">
                                 
                                                <div class="input-group input-group">
                                                <input id="start_time" name="start_time" type="text" class="form-control timepicker">
                                 
                                                <div class="input-group-addon">
                                                       <span class="fa fa-timer"></span>
                                                </div>
                                                </div>
                                        </div>
                                </div>

                            </div>
                            <div class="form-group col-md-6 mb-2 ">
                                <label class="form-contro" for="end_time">End Time</label>
                                <div class="bootstrap-timepicker">
                                       <div class="form-group">
                                 
                                                <div class="input-group input-group">
                                                <input id="end_time" name="end_time" type="text" class="form-control timepicker">
                                 
                                                <div class="input-group-addon">
                                                       <span class="fa fa-timer"></span>
                                                </div>
                                                </div>
                                        </div>
                                </div>
                            </div>

                        </div>

                    </div>
                        <div class="modal-footer text-start py-1">
                            <button type="button" class="aitsun-primary-btn" id="add_time_table">Save</button>
                        </div>
                </form>
               

        </div>
    </div>
</div>

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="time_table" class="erp_table sortable">
                 <thead>
                    <tr> 
                        <th scope="sorticon">#</th>
                        <th scope="sorticon">Week</th>
                        <th scope="sorticon">Subject</th>
                        <th scope="sorticon">Class</th>
                        <th scope="sorticon">Start Time</th>
                        <th scope="sorticon">End Time</th>
                        <th scope="sorticon" data-tableexport-display="none">Handle</th>
                    </tr>
                 
                 </thead>
                 <tbody>
                    <?php  $data_count=0; ?>

                    <?php foreach ($timetable_data as $tm) { $data_count++; ?>
                        <tr>
                            <th><?= $data_count ?></th>
                            <td><?= priority_word($tm['week']) ?></td>
                            <td>
                                <?php if(trim($tm['subject'])=='f')
                                    {
                                        echo 'Free Hour';
                                    }elseif(trim($tm['subject'])=='l'){
                                        echo 'luch time';
                                    }else{
                                        echo ''.subjects_name($tm['subject']).'';
                                    } ?>
                            </td>

                            <td><?= class_name($tm['class_id']) ?></td>
                            <td><?= get_date_format($tm['start_time'],'h:i: A') ?></td>
                            <td><?= get_date_format($tm['end_time'],'h:i: A') ?></td>
                            <td>
                                

                            <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#time_table_edit<?= $tm['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                            
                            <a class="delete_ex_payment btn-delete-red action_btn cursor-pointer"  data-url="<?= base_url('time_table/deletetime_table'); ?>/<?= $tm['id']; ?>"><i class="bx bxs-trash"></i>
                            </a>
                                    

                                <div class="modal fade" id="time_table_edit<?= $tm['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" >
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content text-start">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= priority_word($tm['week']) ?></h5>
                                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                                                
                                            </div>
                                        <form id="edit_time_table_form<?= $tm['id'] ?>" action="<?=  base_url('time_table/update_time_table') ?>/<?=  $tm['id'] ?>">
                                            <div class="modal-body">
                                                        <?= csrf_field(); ?>
                                                <div class="row">
                                                    
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label class="font-weight-semibold" for="week">Select Week</label>
                                                        <select class="form-control" name="week" id="week">

                                                           <option value="" >Select Week</option>
                                                            <option value="0" <?php if ($tm['week']=='0'){echo "selected";} ?>>Sunday</option>
                                                            <option value="1" <?php if ($tm['week']=='1'){echo "selected";} ?>>Monday</option>
                                                            <option value="2" <?php if ($tm['week']=='2'){echo "selected";} ?>>Tuesday</option>
                                                            <option value="3" <?php if ($tm['week']=='3'){echo "selected";} ?>>Wednesday</option>
                                                            <option value="4" <?php if ($tm['week']=='4'){echo "selected";} ?>>Thursday</option>
                                                            <option value="5" <?php if ($tm['week']=='5'){echo "selected";} ?>>Firday</option>
                                                            <option value="6" <?php if ($tm['week']=='6'){echo "selected";} ?>>Saturday</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label class="font-weight-semibold" for="classes">Select Class</label>

                                                        <div class="aitsun_select position-relative">
                                               
                                                            <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/classes'); ?>">
                                                            <a class="select_close d-none"><i class="bx bx-x"></i></a>
                                                 
                                                        <select class="form-select" required name="classes">
                                                            <option value="">Select Class</option>  
                                                            <option value="<?= $tm['class_id']; ?>" selected><?= class_name($tm['class_id']); ?></option>
                                                        </select>

                                                        <div class="aitsun_select_suggest">
                                                            
                                                        </div>
                                                    </div>


                                                        
                                                    </div>
                                                    
                                                    <div class="form-group col-md-12 mb-2">
                                                        <label class="font-weight-semibold" for="subject">Select Subject</label>
                                                        <select class="form-control" name="subject" id="subject">
                                                            
                                                            <option value="f" <?php if ($tm['subject']=='f'){echo "selected";} ?>>Free Hour</option>
                                                            <option value="l" <?php if ($tm['subject']=='l'){echo "selected";} ?>>Launch Time</option>

                                                            <?php foreach (subject_array(company($user['id'])) as $sub): ?>
                                                                <option value="<?= $sub['id']; ?>" <?php if ($sub['id']==$tm['subject']) { echo 'selected'; } ?>><?= $sub['subject_name']; ?></option>
                                                            <?php endforeach ?>

                                                        </select>
                                                    </div>
                                                  
                                                    
                                                    <div class="form-group col-md-6 mb-0">
                                                        <label class="font-weight-semibold" for="start_time">Start Time</label>
                                                        <div class="bootstrap-timepicker">
                                                           <div class="form-group">
                                                     
                                                                    <div class="input-group input-group">
                                                                    <input id="start_time" name="start_time" type="text" class="form-control timepicker" value="<?= get_date_format($tm['start_time'],'h:i a'); ?>">
                                                     
                                                                    <div class="input-group-addon">
                                                                           <span class="fa fa-timer"></span>
                                                                    </div>
                                                                    </div>
                                                            </div>
                                                    </div>

                                                    </div>
                                                    <div class="form-group col-md-6 mb-0">
                                                        <label class="font-weight-semibold" for="end_time">End Time</label>
                                                        <div class="bootstrap-timepicker">
                                                               <div class="form-group">
                                                         
                                                                        <div class="input-group input-group">
                                                                        <input id="end_time" name="end_time" type="text" class="form-control timepicker" value="<?= get_date_format($tm['end_time'],'h:i a'); ?>">
                                                         
                                                                        <div class="input-group-addon">
                                                                               <span class="fa fa-timer"></span>
                                                                        </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                    </div>

                                                </div>
                                          
                                            </div>
                                                <div class="modal-footer text-start py-1">
                                                    <button type="button" class="aitsun-primary-btn edit_time_table" data-id="<?= $tm['id'] ?>" >Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>             
                        </tr>

                    <?php } ?>
                    <?php if ($data_count<1): ?>
                        <tr>
                            <td class="text-center" colspan="7">
                                <span class="text-danger">No time table</span>
                            </td>
                        </tr>
                    <?php endif ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>


<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('time_table/tab_time_table'); ?>" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-book-add ms-2"></i> <span class="my-auto">View Time Table</span></a> 
    </div>
    
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
