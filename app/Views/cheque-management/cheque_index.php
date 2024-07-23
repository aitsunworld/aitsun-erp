<?php 
 
    $report_date=get_date_format(now_time($user['id']),'d M Y');
    if ($_GET) {
        $from='';
        $dto='';
        if (isset($_GET['from'])) {
            $from=$_GET['from'];
        }

        if (isset($_GET['to'])) {
            $dto=$_GET['to'];
        }

        if (!empty($from) && empty($dto)) {
            $report_date=get_date_format($from,'l').' - '.get_date_format($from,'d M Y');
        }
        if (!empty($dto) && empty($from)) {
            $report_date=get_date_format($dto,'l').' - '.get_date_format($dto,'d M Y');
        }
        if (!empty($dto) && !empty($from)) {
            $report_date='<span class="text-dark">from </span>'.get_date_format($from,'d M Y').'&nbsp; &nbsp; <span class="text-dark">to</span> '.get_date_format($dto,'d M Y');
        }

    }else{
        $report_date='Today - '.get_date_format(now_time($user['id']),'d M Y');
    }

    
    $search_status=0;
    $search_department=0;
    $search_cheque_category='';


    if (isset($_GET)) {
        if (isset($_GET['department'])) {
            if ($_GET['department']!='') {
                $search_department=$_GET['department'];
            }
        }
        if (isset($_GET['status'])) {
            if ($_GET['status']!='') {
                $search_status=$_GET['status'];
            }
        }
        if (isset($_GET['cheque_category'])) {
            if ($_GET['cheque_category']!='') {
                $search_cheque_category=$_GET['cheque_category'];
            }
        }
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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Cheques</b>
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
    <div class="d-flex">
           
        <a href="<?= base_url('cheque-management') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-home"></i> <span class="my-auto">Dashboard</span></a>
        <a href="<?= base_url('cheque-management/department') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-receipt"></i> <span class="my-auto">Cheque Departments</span></a>

    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#chequemodel" class=" btn-back font-size-footer my-auto ms-2 "> <span class="">+ New Cheque</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="chequemodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="chequemodelLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="chequemodelLabel">Add Cheque</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form  id="add_cheque_cheque_form" action="<?= base_url('cheque-management/add_cheque'); ?>">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-md-4 mb-2">
                        <label for="department_name">Cheque No.</label>
                        <input type="text" class="form-control" name="cheque_no" id="cheque_no" >
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label for="cheque_date">Date</label>
                        <input type="date" class="form-control" name="cheque_date" id="cheque_date" >
                    </div>
                    
                    <div class="form-group col-md-4 mb-2">
                        <label for="cheque_category">Cheque category</label>
                        <select class="form-select" id="cheque_category" name="cheque_category">
                            <option value="0">Issued cheque</option> 
                            <option value="1">Received cheque</option>  
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label for="cheque_department">Cheque Department</label>
                        <select class="form-select" id="cheque_department" name="cheque_department">
                            <option value="">Select Department</option> 
                            <?php foreach (cheque_department() as $chd): ?>
                            <option value="<?= $chd['id'] ?>"><?= $chd['department_name']; ?></option> 
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <label for="cheque_title">Cheque title</label>
                        <input type="text" class="form-control" name="cheque_title" id="cheque_title" >
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" name="amount" id="amount" >
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="remarks">Remarks</label>
                        <select class="form-select" id="remarks" name="remarks">
                            <option value="pending">Pending</option> 
                            <option value="cleared">Cleared</option> 
                            <option value="bounced">Bounced</option> 
                            <option value="cancelled">Cancelled</option>    
                        </select>
                    </div>

                    <div class="form-group col-md-12 mb-2">
                        <label for="cheque_note">Notes</label>
                        <textarea class="form-control" id="cheque_note" name="cheque_note"></textarea>
                    </div> 
                    

                </div>
            </div>
            
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_cheque">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->

 
  
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">  
        <div class="col-md-2">
            <div class="rental_fiters mt-4">
                <h6><i class="bx bx-refresh"></i> Cheque category</h6>
                <ul>
                    <li><a class="href_loader <?= (''==$search_cheque_category)?'active':'' ?>" href="<?= base_url('cheque-management') ?>">All <b>(<?= get_total_cheque_of_category(company($user['id']), '') ?>)</b></a></li>
                    <li>
                        <a class="href_loader <?= (0==$search_cheque_category)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= $search_department ?>&status=<?= $search_status ?>&cheque_category=0">Issued cheque<b>(<?= get_total_cheque_of_category(company($user['id']), 0) ?>)</b></a>
                    </li>
                    <li>
                        <a class="href_loader <?= (1==$search_cheque_category)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= $search_department ?>&status=<?= $search_status ?>&cheque_category=1">Received cheque<b>(<?= get_total_cheque_of_category(company($user['id']), 1) ?>)</b></a>
                    </li>
                </ul>

                <h6><i class="bx bx-refresh"></i> Cheque Department</h6>
                <ul>
                    <li><a class="href_loader <?= (0==$search_department)?'active':'' ?>" href="<?= base_url('cheque-management') ?>">All Departments <b>(<?= get_total_cheque_of_department(company($user['id']), 0) ?>)</b></a></li>
                    <?php foreach (cheque_department() as $cqd): ?>
                        <li>
                            <a class="href_loader <?= ($cqd['id']==$search_department)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= urlencode($cqd['id']) ?>&status=<?= $search_status ?>&cheque_category=<?= $search_cheque_category ?>"><?= $cqd['department_name'] ?> <b>(<?= get_total_cheque_of_department(company($user['id']), $cqd['id']) ?>)</b></a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <h6><i class="bx bx-refresh"></i> Remarks</h6>
                <ul>
                    <li><a class="href_loader <?= (0==$search_status)?'active':'' ?>" href="<?= base_url('cheque-management') ?>">All Remarks <b>(<?= get_total_cheque_of_status(company($user['id']), '') ?>)</b></a></li>
                    <li><a class="href_loader <?= ('pending'==$search_status)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= $search_department ?>&status=pending&cheque_category=<?= $search_cheque_category ?>">Pending <b>(<?= get_total_cheque_of_status(company($user['id']), 'pending') ?>)</b></a></li>
                    <li><a class="href_loader <?= ('cleared'==$search_status)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= $search_department ?>&status=cleared&cheque_category=<?= $search_cheque_category ?>">Cleared <b>(<?= get_total_cheque_of_status(company($user['id']), 'cleared') ?>)</b></a></li>
                    <li><a class="href_loader <?= ('bounced'==$search_status)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= $search_department ?>&status=bounced&cheque_category=<?= $search_cheque_category ?>">Bounced <b>(<?= get_total_cheque_of_status(company($user['id']), 'bounced') ?>)</b></a></li>
                    <li><a class="href_loader <?= ('cancelled'==$search_status)?'active':'' ?>" href="<?= base_url('cheque-management') ?>?department=<?= $search_department ?>&status=cancelled&cheque_category=<?= $search_cheque_category ?>">Cancelled <b>(<?= get_total_cheque_of_status(company($user['id']), 'cancelled') ?>)</b></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-10">
             <b class="result_bar"><?= (!empty(trim($report_date)))?'<span class="text-dark">Showing result </span>'.$report_date:''; ?></b>
            <div class="mt-2 ms-3 aitsun_table">
                <div class="my-auto d-flex justify-content-between pb-2">
                    <div>
                        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#cheque_table" data-filename="Cheques data - <?= strip_tags($report_date) ?>"> 
                            <span class="my-auto">Excel</span>
                        </a>
                        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#cheque_table" data-filename="Cheques data - <?= strip_tags($report_date) ?>"> 
                            <span class="my-auto">CSV</span>
                        </a>
                        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#cheque_table" data-filename="Cheques data - <?= strip_tags($report_date) ?>"> 
                            <span class="my-auto">PDF</span>
                        </a>
                       
                        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#cheque_table"> 
                            <span class="my-auto">Quick search</span>
                        </a> 

                        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
                            <span class="my-auto">Filter</span>
                        </a>
                    </div> 

                    <div>

                        





                        <a class="btn-dark href_loader rounded-pill btn-sm my-auto ms-2" style="height:max-content;" href="<?= base_url('cheque-management') ?>?from=<?= get_date_format(now_time($user['id']),'Y-m-d') ?>&to=<?= get_date_format(now_time($user['id']),'Y-m-t') ?>&department=<?= $search_department ?>&status=<?= $search_status ?>&cheque_category=<?= $search_cheque_category ?>">Up coming</a>

                        <a class="btn-dark href_loader rounded-pill btn-sm my-auto ms-2" style="height:max-content;" href="<?= base_url('cheque-management') ?>?from=<?= get_date_format(now_time($user['id']),'Y-m-01') ?>&to=<?= get_date_format(now_time($user['id']),'Y-m-t') ?>&department=<?= $search_department ?>&status=<?= $search_status ?>&cheque_category=<?= $search_cheque_category ?>">This month</a>

                        <a class="btn-dark href_loader rounded-pill btn-sm my-auto ms-2" style="height:max-content;" href="<?= base_url('cheque-management') ?>?from=<?= date('Y-m-d', strtotime('-7 days', strtotime(get_date_format(now_time($user['id']),'Y-m-d')))) ?>&to=<?= get_date_format(now_time($user['id']),'Y-m-d') ?>&department=<?= $search_department ?>&status=<?= $search_status ?>&cheque_category=<?= $search_cheque_category ?>">Last 7 days</a>

                        <a class="btn-dark href_loader rounded-pill btn-sm my-auto ms-2" style="height:max-content;" href="<?= base_url('cheque-management') ?>?from=<?= get_date_format(now_time($user['id']),'Y-m-d') ?>&to=&department=<?= $search_department ?>&status=<?= $search_status ?>&cheque_category=<?= $search_cheque_category ?>">Today</a>
                    </div>

                </div>

                <div>

                    <div id="filter" class=" accordion-collapse  border-0 collapse">
                    <div class="filter_bar_bottom">
                        <!-- FILTER -->
                        <form method="get" class="d-flex"> 

                            <input type="text" name="cheque_no" class="filter-control w-100 form-control" placeholder="Cheque No.">
                            <input type="text" name="cheque_title" class="filter-control w-100 form-control" placeholder="Title">
         
                     
         
                            <input type="date" name="from" class="filter-control w-100" placeholder="From">
                    
                            <input type="date" name="to" class="filter-control w-100" placeholder="To">
                      
 

                           
                            <button class="href_long_loader btn-dark btn-sm">
                                <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
                            </button>
                             

                            <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('cheque-management') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                          
                          
                        </form>
                        <!-- FILTER -->
                    </div>  
                </div>
                </div>


                

                <div class="table-responsive"> 
            <table id="cheque_table" class=" erp_table sortable no-wrap">
                <thead>
                    <tr>
                        <th class="sorticon">Cheque No.</th>
                        <th class="sorticon">Date</th>   
                        <th class="sorticon">Title</th>
                        <th class="sorticon">Expires in</th> 
                        <th class="sorticon">Category</th> 
                        <th class="sorticon">Remarks</th> 
                        <th class="sorticon">Amount</th> 
                        <th class="sorticon">Department</th>   
                        <th class="sorticon">Action</th> 
                    </tr>
                </thead>
                <tbody>
                <?php $i=0; $total_=0; foreach ($cheque_data as $chq): $i++; $total_+=$chq['amount'];?>
                 <tr>
                     <td><?= $chq['cheque_no']; ?></td>
                     <td><?= get_date_format($chq['cheque_date'],'d M Y'); ?></td>

                     <td>
                        <?= $chq['cheque_title']; ?>
                        <?php if (!empty($chq['cheque_note'])): ?>
                            <small class="d-block">(<?= $chq['cheque_note'] ?>)</small>
                        <?php endif ?>
                    </td>
                      <td style=""><?= (!empty(timeToExpire(now_time($user['id']),$chq['cheque_date'])))?timeToExpire(now_time($user['id']),$chq['cheque_date']):'-'; ?></td>
                      <td class="text-center">
                        <?php if ($chq['cheque_category']==1): ?> 
                            <span class="">Issued</span>
                        <?php else: ?>
                            <span class="">Received</span>
                        <?php endif ?>
                      </td>
                        <td class="text-center"> 
                        <div class="dropdown">
                            <a class="text-dark cursor-pointer font-size-footer" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if ($chq['status']=='cancelled'): ?> 
                                    <span class="badge bg-danger text-white">Cancelled</span> 
                                <?php elseif ($chq['status']=='cleared'): ?>
                                    <span class="badge bg-success text-white">Cleared</span>  
                                <?php elseif ($chq['status']=='bounced'): ?>
                                    <span class="badge bg-primary text-white">Bounced</span> 
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif ?>
                            </a>
                            <div class="dropdown-menu" style=""> 
                                <a class="dropdown-item confirm_cheque" data-id="<?= $chq['id'] ?>" data-value="pending">
                                    <span class="">Pending</span>
                                </a>   
                                <a class="dropdown-item confirm_cheque" data-id="<?= $chq['id'] ?>" data-value="cleared">
                                    <span class="">Cleared</span>
                                </a>  
                                <a class="dropdown-item confirm_cheque" data-id="<?= $chq['id'] ?>" data-value="bounced">
                                    <span class="">Bounced</span>
                                </a>  
                                <a class="dropdown-item confirm_cheque" data-id="<?= $chq['id'] ?>" data-value="cancelled">
                                    <span class="">Cancelled</span>
                                </a>  
                            </div>
                        </div>
                    </td>
                     <td class="text-end"><?= aitsun_round($chq['amount'],get_setting(company($user['id']),'round_of_value')); ?></td>
                     <td><?= get_cheque_department($chq['cheque_department'],'department_name'); ?></td>
                     
                  
                     <td class="text-center" data-tableexport-display="none">
                        <a data-bs-toggle="modal" data-bs-target="#cheque_edit<?= $chq['id'] ?>"  class="px-2">
                            <i class="bx bx-pencil"></i> 
                        </a>

                        <a data-deleteurl="<?= base_url('cheque-management/delete_cheque'); ?>/<?= $chq['id']; ?>" class="delete_cheque text-danger px-2">
                            <i class="bx bxs-trash-alt"></i> 
                        </a>

                        <!-- ////////////////////////// STAFF EDIT MODAL ///////////////////////// -->

                        <div class="modal fade" id="cheque_edit<?= $chq['id'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="cheque_editLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content text-start">
                              <div class="modal-header">
                                <h5 class="modal-title" id="cheque_editLabel"><?= $chq['cheque_title'] ?></h5>    
                                <button type="button" class="btn-close close_school href_loader" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="cheque_edit_form<?= $chq['id'] ?>" action="<?=  base_url('cheque-management/update_cheque') ?>/<?= $chq['id'] ?>">
                                    <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="department_name">Cheque No.</label>
                                            <input type="text" class="form-control" name="cheque_no" id="cheque_no" value="<?= $chq['cheque_no'] ?>">
                                        </div>
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="cheque_date">Date</label>
                                            <input type="date" class="form-control" name="cheque_date" id="cheque_date" value="<?= get_date_format($chq['cheque_date'],'Y-m-d') ?>">
                                        </div>
                                        
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="cheque_category">Cheque category</label>
                                            <select class="form-select" id="cheque_category" name="cheque_category">
                                                <option value="0" <?php if ($chq['cheque_category']==0) {echo 'selected';} ?>>Issued cheque</option> 
                                                <option value="1" <?php if ($chq['cheque_category']==1) {echo 'selected';} ?>>Received cheque</option>  
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="cheque_department">Cheque Department</label>
                                            <select class="form-select" id="cheque_department" name="cheque_department">
                                                <option value="">Select Department</option> 
                                                <?php foreach (cheque_department() as $chd): ?>
                                                <option value="<?= $chd['id'] ?>"  <?php if ($chq['cheque_department']==$chd['id']) {echo 'selected';} ?>><?= $chd['department_name']; ?></option> 
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            <label for="cheque_title">Cheque title</label>
                                            <input type="text" class="form-control" name="cheque_title" id="cheque_title" value="<?= $chq['cheque_title'] ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="amount">Amount</label>
                                            <input type="number" class="form-control" name="amount" id="amount" value="<?= aitsun_round($chq['amount'],get_setting(company($user['id']),'round_of_value')) ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label for="remarks">Remarks</label>
                                            <select class="form-select" id="remarks" name="remarks">
                                                <option value="pending" <?php if ($chq['status']=='pending') {echo 'selected';} ?>>Pending</option> 
                                                <option value="cleared" <?php if ($chq['status']=='cleared') {echo 'selected';} ?>>Cleared</option>  
                                                <option value="bounced" <?php if ($chq['status']=='bounced') {echo 'selected';} ?>>Bounced</option> 
                                                <option value="cancelled" <?php if ($chq['status']=='cancelled') {echo 'selected';} ?>>Cancelled</option>   
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12 mb-2">
                                            <label for="cheque_note">Notes</label>
                                            <textarea class="form-control" id="cheque_note" name="cheque_note"><?= $chq['cheque_note'] ?></textarea>
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="modal-footer text-start py-1">
                                    <button type="button" class="aitsun-primary-btn update_cheque" data-id="<?= $chq['id'] ?>">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    <!-- ////////////////////////// STAFF EDIT MODAL ///////////////////////// -->
                     </td>
                </tr>
                <?php endforeach ?>

                <?php if ($i==0): ?>
                    <tr>
                        <td colspan="9"><h6 class="p-4 text-center text-danger">No Cheques Found... </h6></td>
                    </tr>
                <?php endif ?>
                <tr>
                    <td colspan="6" class="text-end">Total</td>
                    <td class="text-end"><b><?= aitsun_round($total_,get_setting(company($user['id']),'round_of_value')); ?></b></td>
                </tr>
             </tbody>
                
               
            </table>
            </div>
        </div>
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
      <!-- <= $pager->links() ?> -->
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 