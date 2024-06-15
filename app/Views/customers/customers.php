 
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
                    <b class="page_heading text-dark">Parties</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#parties_table" data-filename="Parties master"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#parties_table" data-filename="Parties master"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#parties_table" data-filename="Parties master"> 
            <span class="my-auto">PDF</span>
        </a>
        <a href="<?= base_url('import_and_export/parties') ?>" class=" text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Export/Import</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#parties_table"> 
            <span class="my-auto">Quick search</span>
        </a>


    
        <a href="<?= base_url('parties_category') ?>" class="href_loader text-dark font-size-footer me-"><i class="bx bx-cog"></i> <span class="my-auto">Parties Category</span></a>
     

    </div>

    <a href="<?= base_url('customers/add') ?>" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New party</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="text" name="display_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?>" class="form-control form-control-sm filter-control ">
                    
     
                      <select class="form-control form-control-sm" name="party_type">
                          <option value="">Type</option>
                          <option value="customer">Customer</option>
                          <option value="vendor">Vendor</option>
                          <option value="delivery">Delivery</option>
                          <option value="seller">Seller</option>
                      </select> 
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('customers') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="parties_table" class="erp_table sortable">
             <thead>
                <tr>
                    <th class="sorticon">Party name</th>
                    <th class="sorticon">Contact</th>
                    <th class="sorticon">Email</th> 
                    <th class="sorticon">
                        <?= get_company_data($user['company_id'],'country') ?>
                        <?php if (get_company_data($user['company_id'],'country')=='India'):?>
                            <?= langg(get_setting(company($user['id']),'language'),'GSTIN'); ?>
                          <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                          <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'VATIN'); ?>
                          <?php endif; ?>
                    </th> 
                    <th class="sorticon">
                        <?php if (get_company_data($user['company_id'],'country')=='India'):?>
                            <?= langg(get_setting(company($user['id']),'language'),'State'); ?>
                          <?php elseif(get_company_data($user['company_id'],'country')=='Oman'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'Governorate'); ?>
                          <?php elseif(get_company_data($user['company_id'],'country')=='United Arab Emirates'): ?>
                            <?= langg(get_setting(company($user['id']),'language'),'Emirates'); ?>
                          <?php endif; ?>
                    </th> 
                    <th class="sorticon">Type</th> 
                    <th class="sorticon">Op. Balance</th> 
                    <th class="sorticon">Cl. Balance</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php  $data_count=0; ?>

                <?php foreach ($customer_data as $cust) { $data_count++; ?>
                  <tr>
                    <td>
                        <?php  if (check_permission($user['id'],'manage_parties')==true || $user['u_type']=='admin'): ?>
                        <a class="href_loader aitsun_link" href="<?php echo base_url('customers/details'); ?>/<?= $cust['id']; ?>">
                            <?= $cust['display_name']; ?>
                        </a>
                        <?php else: ?>
                            <a><?= $cust['display_name']; ?></a>
                        <?php endif; ?>
                    </td>
                    <td><?= $cust['phone'] ?></td>
                    <td><?= $cust['email'] ?></td> 
                    <td><?= $cust['gst_no'] ?></td> 
                    <td><?= $cust['billing_state'] ?></td> 
                    <td><?= $cust['u_type'] ?></td> 
                    <td>
                        <?php 
                            $opcl_class='text-success';
                            if (aitsun_round($cust['opening_balance'],get_setting(company($user['id']),'round_of_value'))<0){
                                $opcl_class='text-danger';
                            }
                        ?>
                        <span class="<?= $opcl_class ?>"><?= str_replace('-', '', aitsun_round($cust['opening_balance'],get_setting(company($user['id']),'round_of_value'))); ?></span>
                    </td> 
                    <td>
                        <?php 
                            $cl_class='text-success';
                            if (aitsun_round($cust['closing_balance'],get_setting(company($user['id']),'round_of_value'))<0){
                                $cl_class='text-danger';
                            }
                        ?>
                        <span class="<?= $cl_class ?>"><?= str_replace('-', '', aitsun_round($cust['closing_balance'],get_setting(company($user['id']),'round_of_value'))); ?></span>
                    </td> 
                  </tr>
                <?php } ?>
                <?php if ($data_count<1): ?>
                    <tr>
                        <td class="text-center" colspan="8">
                            <span class="text-danger">No parties</span>
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
        <a onclick="toggleSidebar()">Main Menus</a>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
</div>
 