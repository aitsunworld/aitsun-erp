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
                    <b class="page_heading text-dark">Work Updates</b>
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

        <form method="post" class="">
            <?= csrf_field(); ?>
            <button type="submit" name="get_excel" class="text-dark font-size-footer me-2 no-btn download_complete"><span class="my-auto">Excel</span></button>
            
        </form>
        
         <a href="javascript:void(0);" class="aitsun_table_export my-auto text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <!-- <a href="<= base_url('import_and_export/parties') ?>" class="aitsun_table_export text-dark font-size-footer me-2"> 
            <span class="my-auto">Export/Import</span>
        </a> -->

        <a href="javascript:void(0);" class="aitsun_table_quick_search my-auto text-dark font-size-footer me-2" data-table="#renew_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" data-bs-toggle="modal" data-bs-target="#add_renew" class="text-dark font-size-footer ms-2 my-auto"> <span class="">+ Updates</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<div id="filter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
              <input type="date" name="from" class="form-control form-control-sm filter-control ">
              <input type="date" name="to" class="form-control form-control-sm filter-control ">

            
              <?php if (check_permission($user['id'],'manage_work_updates')==true || usertype($user['id'])=='admin'): ?> 
              <select name="staffid" class="form-control form-control-sm">
                    <option value="">Choose staff</option>
                    <?php foreach (all_branches($user['id']) as $alb): ?>
                                  <?php foreach (admin_array($alb['id']) as $ads): ?>
                                      <option value="<?= $ads['id']; ?>"><?= $ads['display_name']; ?></option>
                                  <?php endforeach ?>
                              <?php endforeach ?>
                    <?php foreach (followers_array(company($user['id'])) as $flr): ?>
                      <option value="<?= $flr['id']; ?>"><?= $flr['display_name']; ?></option>
                    <?php endforeach ?>
                    
                </select>
                 <?php endif ?>
             
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('customers') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
          </form>
        
    </div>
</div>

<!-- ////////////////////////// MODAL ///////////////////////// -->

<div class="aitsun-modal modal fade" id="add_renew" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Work Updates</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <form method="post" action="<?= base_url('work_updates/save_workupdate') ?>" id="workupdate_form">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 row m-0 p-0" >
                        <div class="form-group col-md-6 mb-2">
        
                            <label class="user">Select a Department :</label>
                            <select name="department_name" id="dept" class="form-select mb-3 department_category" data-dptid="" required>
                                <option value="">Select </option>
                                 <?php foreach (work_department_array(company($user['id'])) as $wd): ?>
                                    <option value="<?= $wd['id']; ?>"><?= $wd['department_name']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-2">
        
                            <label class="user">Select a Category :</label>
                            <select name="category" id="user" class="form-select mb-3" data-dptid="" required>
                                <option value="">Select Work Category</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-2">
                            <label for="entry" class="col-sm-12 control-label">Date </label>
                            <input type="date"  name="date" class="form-control form-type mb-3" required="" value="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>">
                        </div>

                        <div class="form-group col-md-12 mb-2">
                            <label class="additional_message_label">Description</label>
                            <textarea class="form-control" name="description" style="height: 100px;" placeholder="Description"  required=""></textarea>
                        
                        </div>

                        <div class="form-group">
                            <div class="modal-footer">
                                <button type="submit" id="success-top-center" class="aitsun-primary-btn">Save</button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>
<div class="sub_main_page_content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body p-2">
                    <?php $i=0; foreach ($work_update as $us): $i++; ?>

                        <div class="col-md-12 p-2 border mb-3" style="box-shadow: 0px 4px 5px 0px #9c27b01a;">
                            <div class="border-bottom">
                                <div class="d-flex justify-content-between">
                                    <div>
                                    <p class="mb-0" style="font-weight: 500;"><?= user_name($us['user_id']); ?></p> 
                                    <small class="text-muted"><i class="bx bx-calendar"><?= get_date_format($us['date'],'d M Y'); ?></i> | <?= work_category_name($us['category']); ?></small>
                                    </div>
                                    <a class="text-danger mr-1 my-auto" data-bs-toggle="modal" data-dptid="" data-bs-target="#workmodel<?= $us['id']; ?>" ><i class="bx bx-pencil" style="font-size: 18px;"></i></a> 
                                </div>
                                
                            </div>
                                <p class="mt-2 mb-1" ><?= nl2br($us['description']); ?></p>
                        </div>

                        
                            

                        <div class="modal fade" data-dptid="" id="workmodel<?= $us['id']; ?>"  aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title"><?= user_name($us['user_id']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                     <form method="post" action="<?= base_url('work_updates/edit_workupdate') ?>/<?= $us['id']; ?>">
                                        <?= csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="row">

                                                    <div class="form-group col-md-6">
                                
                                                        <label for="input-2" class="modal_lab">Select Department :</label>
                                                        <select name="department_name" data-dptid="<?= $us['id']; ?>" class="form-select mb-3 department_category" required>
                                                            <option value="0">Select </option>
                                                             <?php foreach (work_department_array(company($user['id'])) as $wd): ?>
                                                                <option value="<?= $wd['id']; ?>" <?php if($us['department']==$wd['id']){echo "selected";} ?>><?= $wd['department_name']; ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="input-2" class="modal_lab">Category</label>
                                                        <select name="category" data-dptid="" id="user<?= $us['id']; ?>" class="form-select mb-3" required>            
                                                            <option value="<?= $us['category']; ?>"><?= name_of_work_category($us['category']); ?></option>
                                                        </select>
                                                    </div>

                                                     <div class="form-group col-md-6 mb-3">
                                                        <label for="input-2">Date</label>
                                                        <input type="date" class="form-control modal_inpu" name="date" value="<?= $us['date']; ?>">
                                                    </div>

                                                    <div class="form-group col-md-12 ">
                                                        <label for="input-2">Description</label>

                                                        <textarea name="description" class="form-control" style="height: 100px;"><?= $us['description']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                           
                                                <a data-url="<?= base_url('work_updates/delete_workupdate'); ?>/<?= $us['id']; ?>" class="btn delete btn-danger">Delete</a>

                                                <button type="submit" class="btn btn-primary">Save </button>

                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>

                    
                    <?php endforeach ?> 
                    <?php if ($i==0): ?>
                        <div class="col-md-12">
                            <div class="text-center">
                                <h4 class="m-5 text-danger">No Work Updates </h4>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div class="b_ft_bn">
        <a href="<?= base_url('work_updates/work_updates_settings'); ?>" class="text-dark font-size-footer me-2 href_loader"><span class="my-auto">Work update Category</span></a>

    </div>
    
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
