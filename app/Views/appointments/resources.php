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
                    <a href="<?= base_url('appointments'); ?>" class="href_loader">Appointments</a>
                </li>

                
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Resources</b>
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
        
        
            <div class="my-auto">
                <form method="get">
                    <?= csrf_field(); ?>
                    <button  class="text-dark btn-top-bar font-size-footer me-2" name="get_excel" > 
                        <span class="my-auto">Excel</span>
                    </button>
                </form>
            </div>

       
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2 my-auto" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2 my-auto" data-table="#resource_edit_table"> 
            <span class="my-auto">Quick search</span>
        </a>

       

    </div>
    <div>
    <a type="button" data-bs-toggle="modal" data-bs-target="#resourcesmodel" class=" font-size-footer ms-2 my-auto btn-back" style="padding: 3px 10px;"> <span class="my-auto">+ New</span></a>
    <button class="aitsun-btn-sm btn-danger my-auto btn-sm d-none rounded-nav" id="deletereallbtn"  >Delete</button> 
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
              <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('appointments/resources'); ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
            
            
          </form>
        <!-- FILTER -->
    </div>  
</div>


<!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="resourcesmodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="resourcesmodelLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="resourcesmodelLabel">Resources</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form  id="add_resources_form" action="<?= base_url('appointments/add_resources'); ?>">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">

                    <div class="form-group col-md-12 mb-2">
                        <label class="font-weight-semibold" for="resource_img">Image</label>
                          <input type="file" accept="image/*" class="form-control" name="resource_img" style="padding: 6px;">
                    </div>

                    <div class="form-group col-md-12 mb-2">
                        <label for="appointment_resource">Appointment Resource  </label>
                        <input type="text" class="form-control" name="appointment_resource" id="appointment_resource" >
                    </div>

                    <div class="form-group col-md-12 mb-2">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" min="1" name="capacity" id="capacity" value="1">
                    </div>
                  

                    <div class="form-group col-md-12">
                        <label for="description">Description </label>
                        <textarea class="form-control" aria-label="description"  id="description" name="description"></textarea>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer text-start py-1">
                <button type="button" class="aitsun-primary-btn" id="add_resources">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->


<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table  table-responsive col-12 w-100 pt-0 pb-5">
            
            <table id="resource_edit_table" class="erp_table sortable">
                 <thead>
                    <tr>
                        <th class="sorticon">Appointment Resource</th>
                        <th class="sorticon">Capacity</th>
                        <th class="sorticon">Description</th>
                        <th class="sorticon text-center" style="width:75px;" data-tableexport-display="none">
                            <i id="deleteresourcesCheckAll" class="select ml-2 bx bx-plus-circle" style="font-size:20px; color: white;">
                        </th>
                    </tr>
                 
                 </thead>
                <tbody>
                    

                    
                    <?php $i=0; foreach ($resource_data as $p_data): $i++; ?>

                    <tr>
                        
                        <td>
                            <p class="d-none"><?= $p_data['appointment_resource']; ?></p>
                            <input type="text" class="resource_update form-control blnk_sp py-1 add_cls-appointment_resource-<?= $p_data['id']; ?>"  name="appointment_resource" data-resource_id="<?= $p_data['id']; ?>" data-r_element="appointment_resource" value="<?= $p_data['appointment_resource']; ?>">
                        </td>
                        <td style="width: 180px;">
                            <p class="d-none"><?= $p_data['capacity']; ?></p>
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="resource_update form-control blnk_sp py-1 add_cls-capacity-<?= $p_data['id']; ?>" data-resource_id="<?= $p_data['id']; ?>" name="capacity" value="<?= $p_data['capacity']; ?>" data-r_element="capacity">
                        </td>

                        <td><p class="d-none"><?= $p_data['description']; ?></p>
                            <input type="text" class="resource_update form-control blnk_sp py-1 add_cls-description-<?= $p_data['id']; ?>" data-resource_id="<?= $p_data['id']; ?>" name="description" value="<?= $p_data['description']; ?>" data-r_element="description">
                        </td>
                        <td class="big_check text-center" data-tableexport-display="none">
                            <div class="form-group mb-0">
                                <input type="checkbox" class="checkbox checkBoxresourcesAll checkingrollbox" name="delete_all_resources[]" value="<?= $p_data['id']; ?>" data-inid="<?= $p_data['id']; ?>" >
                            </div>
                        </td>
                    </tr>

                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="4"><h6 class="p-4 text-center text-danger">No Resources Found... </h6></td>
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
        <?= $pager->links() ?>
    </div>
</div> 