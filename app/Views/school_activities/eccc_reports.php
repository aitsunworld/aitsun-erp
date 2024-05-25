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
                    <b class="page_heading text-dark">EC/CC Reports</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#eccc_report" data-filename="Sports Reports"> 
            <span class="my-auto">Excel</span>
        </a>
        
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#eccc_report"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

   
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->





<!-- ////////////////////////// MODAL ///////////////////////// -->


<!-- ////////////////////////// MODAL ///////////////////////// -->




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">

        <div class="aitsun_table w-100 pt-0">
            
            <table id="eccc_report" class="erp_table sortable">
             <thead>
                <tr>
                    
                    <th class="sorticon">Event Name</th>
                    <th class="sorticon">From</th> 
                    <th class="sorticon">To</th> 
                    <th class="sorticon">Place</th> 
                    <th class="sorticon">Related to</th> 
                    <th class="sorticon">Participated</th> 
                    <th class="sorticon">Rewards</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>
                <?php foreach ($eccc_data_events as $ecrv){ $data_count++; ?>
                            <tr>
                               
                                <td>
                                    <?= $ecrv['events_name'] ?>
                                </td>
                                <td><?= get_date_format($ecrv['from'],'d M Y') ?></td>
                                <td><?= get_date_format($ecrv['to'],'d M Y') ?></td>
                                <td><?= $ecrv['place'] ?></td>
                                <td><?= subjects_name($ecrv['related_to']) ?></td>
                                <td><?= total_participant_students(company($user['id']),$ecrv['id'],'eccc'); ?></td>
                                <td> <?php foreach (event_reward_students(company($user['id']),$ecrv['id'],'eccc') as $ers): ?>

                                        <b><?= ucfirst($ers['reward']) ?></b> - 
                                        <?php $std_name=explode(',',user_name($ers['student_id']));
                                        foreach ($std_name as $sn) {
                                            echo $sn.'<br>';
                                        }
                                         ?>

                                <?php endforeach ?> </td>
                            </tr>

                                   


                <?php } ?>
                
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="8">
                            <span class="text-danger">No EC/CC Reports</span>
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
   
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->