<?php 
    $at_date=now_time($user['id']);


    if ($_GET) {
        if (!empty($_GET['attend_date'])) {
            $attend_date=get_date_format($_GET['attend_date'],'Y-F');

            $at_date=$attend_date;

        }else{
            $attend_date=get_date_format(now_time($user['id']),'Y - F');
        }
        
    }else{
        $attend_date=get_date_format(now_time($user['id']),'Y - F');
    }   
?> 
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
                    <a class="href_loader" href="<?= base_url('hr_manage'); ?>">HR Management</a>
                </li>
                
                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('hr_manage/attendance'); ?>">Attendance</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Leave management</b>
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

        <a onclick="exporttoexcel('attend_report_table','<?= get_company_data(company($user['id']),'company_name') ?> - Leave management (<?= get_date_format($attend_date,'Y'); ?>')" class="text-dark font-size-footer me-2"> Excel</a>

       
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#attend_report_table" data-filename="Leave management (<?= get_date_format($attend_date,'Y'); ?>')"> 
            <span class="my-auto">CSV</span>
        </a>
      
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>

        
    </div>

    <a data-bs-toggle="modal" data-bs-target="#add_parties" class="text-dark font-size-footer ms-2 my-auto">+ List</a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
              

                <input type="month" id="attend_month_box" class="form-control form-control-sm" name="date" value="<?= get_date_format($at_date,'Y-m'); ?>" max="<?= get_date_format(now_time($user['id']),'Y-m'); ?>">

                <button type="button" class="btn-dark btn-sm" id="monthapply">Apply</button>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>



<div class="aitsun-modal modal fade" id="add_parties"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Staffs list</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <?= csrf_field(); ?>
                  <div class="modal-body">
                    <div class="row">
                     
                      <div class="col-md-12 row m-0 p-0" >
                            <ul class="list-unstyled">

                                <?php foreach (all_users_array(main_company_id($user['id'])) as $sa): ?>
                                    <li>
                                       <div class="">
                                           
                                           <div class=" d-flex justify-content-between p-0 form-check form-switch cursor-pointer ">
                                            <input type="hidden" name="staffid[]" value="<?= $sa['id']; ?>">

                                             <label class="cursor-pointer form-check-label" for="settings-check<?= $sa['id']; ?>"><h6><?= $sa['display_name']; ?></h6></label>

                                              <input class="form-check-input checkingrollbox" type="checkbox" id="settings-check<?= $sa['id']; ?>" value="1" <?php if ($sa['is_concept_user']==1){echo 'checked';}?>>


                                             <input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="is_concept_user[]" type="hidden"  value="<?= $sa['is_concept_user']; ?>">

                                             
                                            </div>
                                       </div> 
                                    </li>
                                <?php endforeach ?>
                            </ul>
                      </div>
                    </div>
                  
                
                      
                    
                  </div>


                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= langg(get_setting(company($user['id']),'language'),'Close'); ?></button>
                    <button type="submit" class="aitsun-primary-btn" name="save_attendance_list"><?= langg(get_setting(company($user['id']),'language'),'Save List'); ?></button>
                  </div>
                </form>
                                            
        </div>
    </div>
</div>

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 
        <div class="aitsun-table table-responsive col-12 w-100 pt-0 pb-5">
            <table class="erp_table" id="attend_report_table">
                <thead>
                    <tr>
                        <th class="text-center" colspan="<?= count(get_dates_of_month_array( $at_date,'day_number' ))+1; ?>">
                            <?= get_company_data(company($user['id']),'company_name') ?> - Leave management (<?= get_date_format($attend_date,'Y'); ?>)
                        </th>
                    </tr>
                    <tr style="background-color:#d4d4e0;">  
                        <th class=""><b>Employees Name</b></th> 
                        <th class="text-center"><b>Visited to India</b></th>
                        <th class="text-center"><b>Returned to Muscat</b></th>
                        <th class="text-center"><b>Joined Work</b></th>
                        <th class="text-center"><b>Camed India</b></th> 
                        <th class="text-center"><b>Returned to Dubai</b></th> 
                        <th class="text-center"><b>Joined Work(Dubai)</b></th> 
                    </tr> 
                    <?php 
                        $status_array=[
                            'Visited_to_India'=>'Visited to India',
                            'Returned to Muscat'=>'Returned to Muscat',
                            'Joined Work'=>'Joined Work',
                            'Camed India'=>'Camed India',
                            'Returned to Dubai'=>'Returned to Dubai',
                            'Joined Work(Dubai)'=>'Joined Work(Dubai)',
                        ];
                     ?>
                </thead>
                <tbody>
                    <?php $spyrow=0; $i=0; foreach ($user_data as $atn): $i++; ?>


                        <tr>
                            <td class="text-center" style="background-color:#d4d4e0;">

                                <div class="d-flex">
                                    <a class="d-flex cursor-pointer btn-plus aitsun_link" data-bs-toggle="modal" data-bs-target="#dateaddadd<?= $atn['id'] ?>">
                                        <span class="m-auto"><i class="bx bx-plus "></i></span>
                                    </a>
                                    <a class="cursor-pointer text-dark" data-bs-toggle="modal" data-bs-target="#dateaddadd<?= $atn['id'] ?>">
                                        <b class="ms-1"><?= $atn['display_name']; ?></b>
                                    </a>
                                </div> 

                            </td>


                             

                            <?php foreach ($status_array as $std): ?>
                                <td class="text-center  <?php if ($std=='Visited to India' || $std=='Returned to Muscat'){echo 'text-danger'; }else{echo 'text-dark';}?>"> 
                                    <?php foreach (get_leave_manage_date($atn['id'],$attend_date,$std) as $lmd): ?> 
                                        <a class="cursor-pointer <?php if ($std=='Visited to India' || $std=='Returned to Muscat'){echo 'text-danger'; }else{echo 'text-dark';}?>" data-bs-toggle="modal" data-bs-target="#lmd<?= $lmd['id'] ?>">
                                            <b class="d-block"><?= get_date_format($lmd['date'],'d M Y') ?></b>
                                        </a> 

                                    <?php endforeach ?> 
                                </td>

                            <?php endforeach ?> 

                        </tr>
                    <?php endforeach ?>
                </tbody>                   
            </table>
        </div>
         

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
 

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report'); ?>">Reports</a>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/attendance_report/leave_report'); ?>">Leave reports</a>
      
         <?php if (is_aitsun(company($user['id']))): ?>
        <a class="text-dark font-size-footer ms-2 href_loader" href="<?= base_url('hr_manage/leave_management'); ?>">Leave management</a>   
        <?php endif ?> 
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->






<?php foreach ($user_data as $atn): ?>
    <div class="aitsun-modal modal fade" id="dateaddadd<?= $atn['id'] ?>"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="staff_id" value="<?= $atn['id'] ?>"> 
                        <div class="form-group">
                            <select name="leave_status" class="form-select" required>
                                <option value="">Choose</option>
                                <?php foreach ($status_array as $sa): ?>
                                    <option value="<?= $sa; ?>"><?= $sa; ?></option>
                                <?php endforeach ?> 
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" name="save_leave_dates" class="aitsun-primary-btn">Save</button> 
                        </div>

                    </div> 
                </form> 
            </div>
        </div>
    </div>
    <?php foreach ($status_array as $std): ?>
        <?php foreach (get_leave_manage_date($atn['id'],$attend_date,$std) as $lmd): ?>  
            <div class="aitsun-modal modal fade" id="lmd<?= $lmd['id'] ?>"  aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header"> 
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" class="text-start">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <input type="hidden" name="lmd_id" value="<?= $lmd['id'] ?>"> 
                              
                                <div class="form-group mt-2">
                                    <input type="date" name="date" class="form-control" value="<?= $lmd['date'] ?>" required>
                                </div>

                                <div class="form-group mt-2">
                                    <a class="btn btn-sm btn-danger delete" data-url="<?= base_url('hr_manage/delete_leave_date') ?>/<?= $lmd['id'] ?>"><i class="bx bx-trash"></i></a>
                                    <button type="submit" name="edit_leave_dates" class="aitsun-primary-btn">Save</button> 
                                </div>

                            </div> 
                        </form> 
                    </div>
                </div>
            </div>
        <?php endforeach ?> 
    <?php endforeach ?> 
<?php endforeach ?> 

<script src="<?= base_url('public/js/tableexport.js'); ?>"></script>  

<script type="text/javascript">
  function exporttoexcel(tableid,filename) {

        var table = $("#"+tableid);

        $(table).table2excel({

            // exclude CSS class

            exclude: ".noExl",

            name: filename,

            filename: filename + $.now(),//do not include extension

            fileext: ".xls", // file extension

            preserveColors: true,

            sheetName: filename

        });
      }
</script>