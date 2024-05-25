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
                 <li class="breadcrumb-item">
                    <a href="<?= base_url('exams/main_exam'); ?>" class="href_loader">Exams</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark"><?= $main_exam_id['exam_name']; ?></b>
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
        <!-- <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#main_exam_time_table" data-filename="Exams"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#main_exam_time_table" data-filename="Exams"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#main_exam_time_table" data-filename="Exams"> 
            <span class="my-auto">PDF</span>
        </a> -->
        
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#add_main_exam_subjectmodal" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ Add subject</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->




<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="add_main_exam_subjectmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="add_main_exam_subjectLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="add_main_exam_subjectLabel">Add exam subject</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_main_exam_subject_form" action="<?= base_url('exams/add_main_exam_subject'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="main_exam_id" id="main_exam_id" value="<?= $main_exam_id['id']; ?>">
                    
                    <div class="form-group col-md-6 mb-2">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" min="<?= $main_exam_id['start_date']; ?>" max="<?= $main_exam_id['end_date']; ?>" name="date" placeholder="Exam Date">
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="exam_for_subject">Exam for Subject:</label>
                        <select class="form-select" name="exam_for_subject" id="exam_for_subject">
                            <option value="">Select Subject</option>
                            <?php foreach (subject_array(company($user['id'])) as $sub): ?>
                                <option value="<?= $sub['id']; ?>"><?= $sub['subject_name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        
                    </div>

                
                    <div class="form-group col-md-6 mb-2">
                        <label for="from">Start Time</label>
                        <div class="bootstrap-timepicker">
                               <div class="form-group">
                         
                                        <div class="input-group input-group">
                                        <input id="start_time" name="from" type="text" class="form-control timepicker rounded-3">
                         
                                        <div class="input-group-addon">
                                               <span class="fa fa-timer"></span>
                                        </div>
                                        </div>
                                </div>
                        </div>

                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="to">End Time</label>
                        <div class="bootstrap-timepicker">
                           <div class="form-group">
                 
                                <div class="input-group input-group">
                                <input id="end_time" name="to" type="text" class="form-control timepicker rounded-3" >
                 
                                <div class="input-group-addon">
                                       <span class="fa fa-timer"></span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="exam_for_class">Exam for Class</label>
                        <select class="form-select" name="exam_for_class" id="exam_for_class">
                            <option value="">Select Class</option>
                            <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                            <?php endforeach ?>
                        </select>
                        
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label for="max_marks">Maximum Marks</label>
                        <input type="number" class="form-control" value="100" name="max_marks"  placeholder="Maximum Marks">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="min_marks">Minimum Marks</label>
                        <input type="number" class="form-control"  value="35" name="min_marks" placeholder="Minimum Marks">
                    </div>
                    </div>
            </div>
              <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_main_exam_subject">Save</button>
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

            <table id="main_exam_time_table" class="erp_table">
              <tbody>
                <?php  $data_count=0; ?>
                <?php foreach (classes_array(company($user['id'])) as $cls){ $data_count++; ?>

                    <div id="errorbox<?= $cls['id'] ?>"></div>

                    <tr>
                        <td colspan="2" style="border-right: 1px solid #f1f1f1!important;"><strong><?=$cls['class']; ?></strong></td>
                        <td colspan="2" class="text-end" style="border-left: 1px solid #f1f1f1!important;">

                        
                            
                             
                             <?php if (get_exam_time_table_array(company($user['id']),$cls['id'],$main_exam_id['id'])): ?> 
                             <a class="btn btn-sm btn-secondary downloading_click py-0" href="<?= base_url('exams/pdf_main_exam_subject'); ?>/<?= $cls['id'] ?>?main=<?= $main_exam_id['id']; ?>" download ><i class="anticon anticon-file-pdf"></i><i class="bx bxs-file-pdf" style="font-size:19px;"></i></a>

                            <?php endif ?>

                             <?php if (is_all_subject_valuated(company($user['id']),$main_exam_id['id'],$cls['id'])): ?>
                                <a class="btn btn-primary no_loader btn-sm text-white notify_exam_result" data-boxid="<?= $cls['id'] ?>" data-exid="<?= $main_exam_id['id']; ?>"><i class="fa fa-bell"></i> <span class="d_text_none">Notify student</span></a>

                                <a class="btn btn-sm btn-success no_loader publish_exam_result_via_sms text-white" data-boxid="<?= $cls['id'] ?>" data-exid="<?= $main_exam_id['id']; ?>" id="btttnn<?= $cls['id'] ?>"><i class="fa fa-paper-plane"></i> <span class="d_text_none">Publish result via SMS</span></a>


                             <?php else: ?>
                                <a class="btn btn-sm btn-success no_loader publish_exam_via_sms text-white" data-boxid="<?= $cls['id'] ?>" data-exid="<?= $main_exam_id['id']; ?>" id="btttn<?= $cls['id'] ?>"><i class="fa fa-paper-plane"></i> <span class="d_text_none">Publish via SMS</span></a>
                             <?php endif ?>
                     
                        </td>
                    </tr>



                    <tr>
                        <td><strong>Date</strong></td>
                        <td><strong>Time</strong></td>
                        <td><strong>Subject</strong></td>
                        <td data-tableexport-display="none"><strong>Handle</strong></td>
                    </tr>

                    <?php $count=0; foreach (get_exam_time_table_array(company($user['id']),$cls['id'],$main_exam_id['id']) as $mextb) { $count++; ?>
                    <tr>
                        <td><?= get_date_format($mextb['date'],'d M Y'); ?></td>
                        <td><?= get_date_format($mextb['from'],'h:i A'); ?> - <?= get_date_format($mextb['to'],'h:i A'); ?></td>
                        <td>
                            <div class="d-flex justify-content-between">
                            <?= subjects_name($mextb['exam_for_subject']); ?>

                            <?php if ($mextb['marksvaluate']=='1'): ?>
                            <span class="badge bg-success py-1 rounded-pill" style="font-size: 12px;"><i class="bx bxs-check-circle"></i> VALUATED</span>
                            <?php else: ?>

                            <?php endif ?>
                        </div>
                        </td>

                        <td data-tableexport-display="none">
                            <div class="p-1">
                            <?php if ($main_exam_id['exam_status']=='completed'): ?>
                                <a class="btn btn-dark btn-sm py-0 text-white" href="<?= base_url('exams/main_exam_marks'); ?>/<?= $mextb['id']; ?>">
                            <i class="bx bx-highlight"></i> 
                            Valuate</a>
                                                        
                            <?php else: ?>
                            <a class="btn-edit-dark me-2 action_btn cursor-pointer " data-bs-toggle="modal" data-bs-target="#exxlsedit<?= $mextb['id'] ?>">
                            <i class="bx bx-edit"></i></a>

                            <a class="btn-delete-red action_btn cursor-pointer delete_main_exam_subject" data-main_ex_id="<?= $main_exam_id['id'] ?>"  data-deleteurl="<?= base_url('exams/delete_main_exam_subject'); ?>/<?= $mextb['id']; ?>">
                                <i class="bx bxs-trash"></i> 
                                
                            </a>
                        <?php endif ?>
                        </div>


                        <div class="modal fade" id="exxlsedit<?= $mextb['id'] ?>">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exxlsedit<?= $mextb['id'] ?>">Edit exam subject</h5>
                                        <button type="button" class="close close_school" data-bs-dismiss="modal">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </div>

                                    <form method="post" id="edit_main_exam_subject_form<?=$mextb['id'] ?>" action="<?=base_url('exams/edit_main_exam_subject') ?>/<?=$mextb['id'] ?>" >
                                        <?= csrf_field(); ?> 
                                        <div class="modal-body">
                                            
                                            <div class="row">
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="date">Date</label>
                                                <input type="date" class="form-control" name="date"  value="<?= $mextb['date']; ?>" placeholder="Exam Date">
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label class="font-weight-semibold" for="main_subject">Exam for Subject:</label>
                                                <select class="form-select" name="exam_for_subject" id="exam_for_subject">
                                                    <?php foreach (subject_array(company($user['id'])) as $sub): ?>
                                                        <option value="<?= $sub['id']; ?>" <?php  if ($mextb['exam_for_subject']==$sub['id']) {echo 'selected';}?>><?= $sub['subject_name']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                    
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="from">Start Time</label>
                                                <div class="bootstrap-timepicker">
                                                    <div class="form-group">
                                                    <div class="input-group input-group">
                                                        <input id="start_time" name="from" type="text" class="form-control timepicker rounded-3" value="<?= get_date_format($mextb['from'],'h:i a'); ?>">
                                     
                                                        <div class="input-group-addon">
                                                               <span class="fa fa-timer"></span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="to">End Time</label>
                                                <div class="bootstrap-timepicker">
                                                    <div class="form-group">
                                                        <div class="input-group input-group">
                                                            <input id="end_time" name="to" type="text" class="form-control timepicker rounded-3" value="<?= get_date_format($mextb['to'],'h:i a'); ?>">
                                             
                                                            <div class="input-group-addon">
                                                                   <span class="fa fa-timer"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group col-md-6 mb-2">
                                                <label class="font-weight-semibold" for="teacher">Exam for Class</label>
                                                <select class="form-select" name="exam_for_class"   id="exam_for_class">
                                                    <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                                                        <option value="<?= $tcr['id']; ?>" <?php  if ($mextb['exam_for_class']==$tcr['id']) {echo 'selected';}?>><?= $tcr['class']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="max_marks">Maximum Marks</label>
                                                <input type="number" class="form-control" value="<?= $mextb['max_marks']; ?>" name="max_marks"  placeholder="Maximum Marks">
                                            </div>
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="min_marks">Minimum Marks</label>
                                                <input type="number" class="form-control"  value="<?= $mextb['min_marks']; ?>" name="min_marks" placeholder="Minimum Marks">
                                            </div> 
                                            

                                        </div>

                                        </div>

                                        <div class="modal-footer text-start py-1">
                                            <button type="button" class="aitsun-primary-btn edit_main_exam_form"  data-id="<?=$mextb['id'] ?>">Save</button>
                                        </div>
                                    
                                    </form>
                                </div>
                                   

                            </div>
                        </div>

                        </td>
                    </tr>

                    <?php
                    
                    } 
                    if ($count==0) {
                                echo ' 
                            
                                <tr> 

                                    <td colspan="4" class="text-danger text-center">No Exams</td>
                                </tr>';
                        }
                        ?>

                    <tr>
                        <td colspan="4" class="p-3" style="border-left: 1px solid #f1f1f1!important;border-right: 1px solid #f1f1f1!important;"></td>
                    </tr>




                <?php } ?>

                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" >
                            <span class="text-danger">No class</span>
                        </td>
                    </tr>
                <?php endif ?>
                
              </tbody>
            </table>

        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->





