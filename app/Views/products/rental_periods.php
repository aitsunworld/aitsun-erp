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
                    <a href="<?= base_url('appointments'); ?>" class="href_loader">Products</a>
                </li>

                
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Rental periods</b>
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
        
   
       
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2 my-auto" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2 my-auto" data-table="#resource_edit_table"> 
            <span class="my-auto">Quick search</span>
        </a>

       

    </div>
    <div> 
    <a type="button" data-bs-toggle="modal" data-bs-target="#rental_period_modal" class=" font-size-footer ms-2 my-auto btn-back" style="padding: 3px 10px;"> <span class="my-auto">+ New</span></a>
     
    <button class="aitsun-btn-sm btn-danger my-auto btn-sm d-none rounded-nav" id="deleteperllbtn"  >Delete</button> 
 
    </div> 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->



<div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
          <form method="get" class="d-flex">
            <?= csrf_field(); ?>
            
              <input type="text" name="serachresource" class="form-control-sm form-control filter-control" placeholder="Search Resources">
            
              <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('product/rental_periods'); ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>


<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="rental_period_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="rental_period_modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rental_period_modalLabel">Rental Period</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form  id="add_rental_period_form" action="<?= base_url('product/save_rental_periods'); ?>">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-md-12 mb-2">
                        <label for="period_name">Period name</label>
                        <input type="text" class="form-control" name="period_name" id="period_name" >
                    </div>

                    <div class="form-group col-md-12 mb-2">
                        <label for="period_duration">Duration</label>
                        <input type="number" class="form-control" min="1" name="period_duration" id="period_duration" value="1">
                    </div>
                  

                    <div class="form-group col-md-12">
                        <label for="unit">Unit</label> 
                        <select class="form-control" name="unit">
                            <option value="hour">Hour</option>
                            <option value="day">Day</option>
                            <option value="week">Week</option>
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_rental_period">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table  table-responsive col-12 w-100 pt-0 mt-4 pb-5">
            
            <table id="resource_edit_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th class="sorticon">Period name</th>
                        <th class="sorticon">Duration</th>
                        <th class="sorticon">Unit</th> 
                        <th class="sorticon text-center" style="width:75px;" data-tableexport-display="none">
                            <i id="deleteperiodsCheckAll" class="select ml-2 bx bx-plus-circle" style="font-size:20px; color: white;">
                        </th> 
                    </tr>
                 
                 </thead>
                <tbody>
                    

                    
                    <?php $i=0; foreach ($rental_hours_data as $rh_data): $i++; ?>

                    <tr>
                   
                        
                        <td>
                            
                            <p class="d-none"><?= $rh_data['period_name']; ?></p>
                            <input type="text" class="periods_update form-control blnk_sp py-1 add_cls-period_name-<?= $rh_data['id']; ?>"  name="period_name" data-period_id="<?= $rh_data['id']; ?>" data-r_element="period_name" value="<?= $rh_data['period_name']; ?>" <?php if (!is_allowed($user['id'], 'edit_resources')): ?>disabled <?php endif; ?>>
                        </td>
                        <td style="width: 180px;">
                            <p class="d-none"><?= $rh_data['period_duration']; ?></p>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="periods_update form-control blnk_sp py-1 add_cls-period_duration-<?= $rh_data['id']; ?>" data-period_id="<?= $rh_data['id']; ?>" name="period_duration" value="<?= $rh_data['period_duration']; ?>" data-r_element="period_duration">
                        </td>

                        <td><p class="d-none"><?= $rh_data['unit']; ?></p>
                             
                             <select class="periods_update form-control blnk_sp py-1 add_cls-unit-<?= $rh_data['id']; ?>" data-period_id="<?= $rh_data['id']; ?>" name="unit" data-r_element="unit">
                                <option value="hour" <?= ($rh_data['unit']=='hour')?'selected':''; ?>>Hour</option>
                                <option value="day" <?= ($rh_data['unit']=='day')?'selected':''; ?>>Day</option>
                                <option value="week" <?= ($rh_data['unit']=='week')?'selected':''; ?>>Week</option>
                                <option value="month" <?= ($rh_data['unit']=='month')?'selected':''; ?>>Month</option>
                                <option value="year" <?= ($rh_data['unit']=='year')?'selected':''; ?>>Year</option>
                            </select>
                        </td>
                        <?php if (is_allowed($user['id'], 'delete_resources')): ?>
                        <td class="big_check text-center" data-tableexport-display="none">
                            <div class="form-group mb-0">
                                <input type="checkbox" class="checkbox checkBoxperiodsAll checkingrollbox" name="delete_all_periods[]" value="<?= $rh_data['id']; ?>" data-inid="<?= $rh_data['id']; ?>" >
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>

                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="4"><h6 class="p-4 text-center text-danger">Periods not Found... </h6></td>
                        </tr>
                    <?php endif ?>
                     
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        
    </div>
</div> 

 