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
                    <b class="page_heading text-dark">Messaging</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="<?= base_url('messaging/message_history') ?>" class="text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Message History</span>
        </a>
    </div>

    <a data-bs-toggle="collapse"  data-bs-target="#bulk_sms" class="text-dark font-size-footer my-auto ms-2"> <span class="">+ Send SMS</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                    <select class="form-control form-control-sm" id="sel_class" name="sel_class">
                        <option value="" selected>Class</option>
                         <?php foreach (classes_array(company($user['id'])) as $tcr): ?>
                            <option value="<?= $tcr['id']; ?>"><?= $tcr['class']; ?></option>
                        <?php endforeach ?>
                    </select>

                    <select class="form-control form-control-sm " id="sel_gender" name="sele_gender">
                        <option value="" selected>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option>
                        
                    </select>

                     <input type="text" id="searchName" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Search Name'); ?>" class="form-control form-control-sm filter-control" name="searchname">
                     
                      <button type="submit" class=" btn-dark btn-sm "><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('messaging') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div id="bulk_sms" class=" accordion-collapse col-12 border-0 collapse">
        
           <div class="col-md-12">
          
            <form id="bulkform" action="<?= base_url('messaging/send_bulk_sms') ?>" >

            
             <div class="form-row" id="sms_container" style="">
                 <div class="form-group col-md-12 mb-2">
                    <textarea class="form-control" placeholder="Enter Messages" name="smessages" id="message_area"></textarea>
                 </div>
                 <div class="form-group col-md-12 mb-0">
                   <button class="aitsun-primary-btn" type="button" name="send_bulks" id="send_bulk">Send bulk sms</button>
                 </div>
             </div>
             <div id="er_msg" class="mt-3 mb-0"></div>
         </form>
        </div>
    </div>



    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="messaging_table" class="erp_table ">
             <thead>
                <tr class="big_check">
                    <th class="text-center"><input type="checkbox" class="checkbox" id="ckbCheckAll"></th>
                    <th class="text-center">#</th>
                    <th class="text-center">Student Name</th> 
                    <th class="text-center">Class</th> 
                    <th class="text-center">Gender</th> 
                    <th class="text-center">Father Name</th> 
                    <th class="text-center">Mobile Number</th> 
                    <th class="text-center">Attendance</th> 
                    <th class="text-center">Handle</th> 
                </tr>
             
            </thead>
            <tbody>

                <?php  $data_count=0; ?>

                <?php foreach ($students_data as $stc) { $data_count++; ?>

                    <tr>
                <td class="text-center big_check" style="width:100px">
                   
                    <input type="checkbox" name="all_numbers[]" class="bulkselector checkBoxClass checkbox" id="slectst"  value="<?= get_student_data(company($user['id']),$stc['student_id'],'phone'); ?>" data-stuid="<?= $stc['student_id']; ?>">
                </td>
                <td><b><?= school_code(company($user['id'])) ?><?= location_code(company($user['id'])) ?><?= get_student_data(company($user['id']),$stc['student_id'],'serial_no'); ?></b></td>
               
                <td><?= user_name($stc['student_id']) ?></td>
                <td><?= class_name(current_class_of_student(company($user['id']),$stc['student_id'])) ?></td>
                <td><?= $stc['gender']; ?></td> 
                <td><?= get_student_data(company($user['id']),$stc['student_id'],'father_name'); ?></td>
                <td><?= get_student_data(company($user['id']),$stc['student_id'],'phone'); ?></td>
               
                <td><?= total_days_of_attendance(current_class_of_student(company($user['id']),$stc['student_id']),$stc['student_id'],company($user['id'])); ?>
                    /
                    <?= total_days_of_attended(current_class_of_student(company($user['id']),$stc['student_id']),$stc['student_id'],company($user['id'])); ?>
                    (<?= percentage_of_attended(current_class_of_student(company($user['id']),$stc['student_id']),$stc['student_id'],company($user['id'])); ?>%)</td>
                <td class=" text-center" style="width: 150px;">
                    <a class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#send_sms<?= $stc['id'] ?>">
                      <span>Send SMS</span>
                     </a>

                        <div class="modal fade bd-example-modal-sm" id="send_sms<?= $stc['id'] ?>">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title h4">Send SMS</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <i class="anticon anticon-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="<?= base_url('messaging/message') ?>">
                                            <?= csrf_field(); ?>
                                            <div class="form-group text-start">
                                                <label for="to-input">Mobile Number</label>
                                                <input type="number" class="form-control" name="phone" placeholder="Mobile Number" value="<?= get_student_data(company($user['id']),$stc['student_id'],'phone'); ?>" required>
                                                <div class="text-danger mt-2" id="ermsg"></div>
                                            </div>

                                            <div class="form-group text-start">
                                                <label for="message-input">Message</label>
                                                  <textarea class="form-control" name="smsmessage" rows="5" placeholder="Message" required></textarea>
                                            </div>
                                            <div class="btn-toolbar mt-2 form-group mb-0 text-center d-block">
                                                <button type="submit" name="sendsms" class="aitsun-primary-btn waves-effect waves-light">Send</button>
 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </td>
            </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span class="text-danger">No Student Details</span>
                        </td>
                    </tr>
                <?php endif ?> 
 
            </tbody>
            </table>
        </div>

        

    </div>
</div>



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            
<script type="text/javascript">
    $(document).ready(function(){

        $("#ckbCheckAll").click(function () {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });

    });
</script>