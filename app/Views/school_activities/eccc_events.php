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
                    <b class="page_heading text-dark">EC/CC events</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#eccc_event_table" data-filename="EC/CC Events"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#eccc_event_table" data-filename="EC/CC Events"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#eccc_event_table" data-filename="EC/CC Events"> 
            <span class="my-auto">PDF</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#eccc_event_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#addsportseventsmodel" class="text-dark font-size-footer ms-2"> <span class="my-auto">+ New event</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->





<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="addsportseventsmodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addsportseventsmodelLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addsportseventsmodelLabel">Add Event</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add_ecccsevent_form" action="<?= base_url('school_activities/add_ecevents'); ?>/<?= $user['company_id'] ?>">
                <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 mb-2">
                        <input type="hidden" name="subject_id" value="<?= eccc_name(company($user['id'])) ?>">
                        <label class="font-weight-semibold" for="events_name">Event Name</label>
                        <input type="text" class="form-control" name="events_name" id="events_name" placeholder="Event Name">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="from">From</label>
                        <input type="date" class="form-control" name="from" id="from" placeholder="From Date">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="to">To</label>
                        <input type="date" class="form-control" name="to" id="to" placeholder="To Date">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="place">Place</label>
                        <input type="text" class="form-control" name="place" id="place" placeholder="Place">
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="sports">Related to</label>
                        <select class="form-select" name="related_to" id="related_to">
                            <option value="">Select Activity</option>
                            <?php foreach (activities_array(company($user['id'])) as $spt): ?>
                                <option value="<?= $spt['id']; ?>"><?= subjects_name($spt['id']); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label class="font-weight-semibold" for="sports">Event Type</label>
                        <select class="form-select" name="c_type" id="c_type">
                            <option value="">Select Event Type</option>
                            <option value="Competition">Competition</option>
                            <option value="Camp">Camp</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_ecccevent">Save</button>
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
            
            <table id="eccc_event_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">S. No</th>
                    <th class="sorticon">Event Name</th>
                    <th class="sorticon">From</th> 
                    <th class="sorticon">To</th> 
                    <th class="sorticon">Place</th> 
                    <th class="sorticon">Related to</th> 
                    <th class="sorticon">Event Type</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($ecccevents_data as $ecv) { $data_count++; ?>
                  <tr>
                    <td style="width: 80px;"><?= $ecv['serial_no'] ?></td>
                    <td><?= $ecv['events_name'] ?></td>
                    <td><?= get_date_format($ecv['from'],'d M Y') ?></td> 
                    <td><?= get_date_format($ecv['to'],'d M Y') ?></td>
                    <td><?= $ecv['place'] ?></td>
                    <td><?= subjects_name($ecv['related_to']) ?></td>
                    <td><?= $ecv['c_type'] ?></td>
                    
                    <td class="text-end" style="width: 150px;" data-tableexport-display="none">
                        <div class="p-1">
                        <?php if ($ecv['status']=='completed'): ?>
                            <a href="<?= base_url('school_activities/reward') ?>/<?= $ecv['id']; ?>" class="btn-purple action_btn cursor-pointer href_loader">Rewarding</a>
                        <?php else: ?>

                        <a class=" btn-edit-dark me-2 action_btn cursor-pointer" data-bs-toggle="modal" data-bs-target="#eccceventedit<?= $ecv['id'] ?>"><i class="bx bxs-edit-alt"></i></a>
                                
                        <a class="deleteecccevent btn-delete-red action_btn cursor-pointer"  data-deleteurl="<?= base_url('school_activities/deleteecccevent'); ?>/<?= $ecv['id']; ?>"><i class="bx bxs-trash"></i></a>
                        <?php endif; ?>

                        </div>


                        <!-- ////////////////////////// MODAL ///////////////////////// -->

                        <div class="modal fade" id="eccceventedit<?= $ecv['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="eccceventedit<?= $ecv['id'] ?>Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="eccceventedit<?= $ecv['id'] ?>Label">Edit Event</h5>    
                                <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="edit_ecccevent_form<?=$ecv['id'] ?>" action="<?=base_url('school_activities/update_ecccevents') ?>/<?=$ecv['id'] ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2">
                                                  
                                            <label class="font-weight-semibold" for="events_name">Sports Name</label>
                                            <input type="text" class="form-control" name="events_name" id="events_name" placeholder="Event Name" value="<?=$ecv['events_name'] ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="font-weight-semibold" for="from">From</label>
                                            <input type="date" class="form-control" name="from" id="from" placeholder="From Date" value="<?= get_date_format($ecv['from'],'Y-m-d') ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="font-weight-semibold" for="to">To</label>
                                            <input type="date" class="form-control" name="to" id="to" placeholder="To Date" value="<?= get_date_format($ecv['to'],'Y-m-d') ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="font-weight-semibold" for="place">Place</label>
                                            <input type="text" class="form-control" name="place" id="place" placeholder="Place" value="<?=$ecv['place'] ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="font-weight-semibold" for="sports">Related To</label>
                                            <select class="form-control" name="related_to" >
                                              <?php foreach (activities_array(company($user['id'])) as $spt): ?>
                                                   <option value="<?= $spt['id']; ?>" <?php if ($spt['id']==$ecv['related_to']) { echo 'selected'; } ?>><?= subjects_name($spt['id']); ?></option>
                                              <?php endforeach ?>

                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <label class="font-weight-semibold" for="sports">Event Type</label>
                                            <select class="form-control" name="c_type" >
                                                <option value="Competition" <?php if ($ecv['c_type']=='Competition'){echo "selected";} ?>>Competition</option>
                                                <option value="Camp" <?php if ($ecv['c_type']=='Camp'){echo "selected";} ?>>Camp</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer text-start py-1">
                                    <button type="button" class="aitsun-primary-btn edit_ecccevent" data-id="<?= $ecv['id'] ?>">Save</button>
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
                        <td class="text-center" colspan="8">
                            <span class="text-danger">No ec/cc events</span>
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
        <a href="<?= base_url('school_activities/eccc_participants'); ?>?page=1" class="text-dark font-size-footer me-2 href_loader"><i class="bx bxs-user ms-2"></i> <span class="my-auto">Participants</span></a>
    </div>

    <div>
        <span class="m-0 font-size-footer">Total events : <?= count($ecccevents_data); ?></span>
    </div>

    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->