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
                    <a href="<?= base_url('user_master'); ?>" class="href_loader">User Master</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Permissions - <?= $staff['display_name']; ?></b>
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
        
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter-book"> 
            <span class="my-auto">Filter</span>
        </a>

        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#staffs_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

<div id="filter-book" class=" accordion-collapse col-12 border-0 collapse">
        <div class="filter_bar">
            <!-- FILTER -->
              <form method="get" class="d-flex">
                <?= csrf_field(); ?>

                <input type="text" name="serachname" class="form-control-sm form-control filter-control" placeholder="Search permission heading">
                
                <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                  <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('permission') ?>/<?= $staff['id'] ?>?page=1"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                
                
              </form>
            <!-- FILTER -->
        </div>  
    </div>




<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">
        <div class="pb-3 d-flex">
            <div class="me-3">
                <img src="<?= base_url(); ?>/public/uploads/users/<?php if($staff['profile_pic'] != ''){echo $staff['profile_pic']; }else{ echo 'avatar-icon.png';} ?>" alt="Admin" class="rounded-circle p-1 bg-dark" width="110" height="110">
            </div>
           <div>
               <h2><?= $staff['display_name']; ?></h2> 
               <h6>Email: <?= $staff['email']; ?></h6> 
               <h6>Phone: <?= $staff['phone']; ?></h6> 
           </div>
        </div>
        <div class="aitsun_table w-100 pt-0">
            
            <table id="staffs_table" class="erp_table no-wrap sortable">
             <thead>
                <tr> 
                    <th class="sorticon" data-tableexport-display="none">Action</th>  
                    <th class="sorticon">Description</th>
                    
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php 
                    $temp_module='';
                    foreach ($permission_lists as $pl) { $data_count++;  ?>
                
                <?php if ($temp_module!=$pl['module']): ?>
                    <tr class="bg-dark">
                        <td colspan="2" class="text-start text-white" style="text-transform: capitalize;">
                            <?= $pl['module']; ?>
                        </td>
                    </tr>
                <?php endif ?> 

                  <tr>
                   <td style="width:100px;">

                         <div class="form-check form-switch text-start p-0" >
                            <input type="checkbox" class="form-check-input is_permission_allowed" data-permi_url="<?= base_url() ?>/is_permission_allowed" data-user_id="<?= $staff['id']; ?>" data-permission_name="<?= $pl['permission_name']; ?>" style="margin-left: 0; float: unset;"  name="is_permission_allowed" value="1" id="perm<?= $pl['id']; ?>" <?= (is_allowed($staff['id'],$pl['permission_name']))?'checked':''; ?>> 

                            <label for="perm<?= $pl['id']; ?>"><?= $pl['permission_heading']; ?></label>
                        </div>



                    </td> 
                    <td><?= $pl['description']; ?></td>
                    
                  </tr>
                <?php $temp_module=$pl['module']; }  ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="9">
                            <span class="text-danger">No staffs</span>
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
    
    <div>
        
    </div>


    <div class="aitsun_pagination ">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->