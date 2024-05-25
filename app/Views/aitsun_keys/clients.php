<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Aitsun Keys</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#Aitsun_keys_table" data-filename="Aitsun Keys"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#Aitsun_keys_table" data-filename="Aitsun Keys"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#Aitsun_keys_table" data-filename="Aitsun Keys"> 
            <span class="my-auto">PDF</span>
        </a>
       
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#Aitsun_keys_table"> 
            <span class="my-auto">Quick search</span>
        </a>
    </div>

    <a type="button" href= <?= base_url('aitsun_keys/add_clients')?> class="text-dark font-size-footer ms-2"> <span class="my-auto">+ Add Clients</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
        <div class="aitsun_table table-responsive col-12 w-100 pt-0 pb-5">
            
            <table id="Aitsun_keys_table" class="erp_table no-wrap">
                 <thead>
                    <tr>
                        <th class="">Action</th>
                        <th class="">Status</th>
                        <th class="">Name</th>
                        <th class="">Email</th>
                        <th class="">Pack Date</th>
                        <th class="">Billing Date</th>
                        <th class="">Payment Method</th>
                        <th class="">Type</th>
                        <th class="text-center ">Restaurent</th>
                        <th class="text-center ">Online shop</th>
                        <th class="text-center ">Hr Manage</th>
                        <th class="text-center ">Crm</th>
                        <th class="text-center ">Medical</th>
                        <th class="text-center ">School</th>
                    </tr>
                 </thead>
                  <tbody>
                    
                    <?php $i=0; foreach ($user_data as $us): $i++; ?>
                    <tr>
                        <td>
                            <a href="<?= base_url('aitsun_keys/details'); ?>/<?= $us['id']; ?>" class=" href_loader text-primary"> 
                                <span class="bx bx-edit"></span>
                            </a>

                            <a class=" text-danger delete_user" data-deleteurl="<?= base_url('aitsun_keys/delete_users'); ?>/<?= $us['id']; ?>">
                                <span class="bx bx-trash"></span>
                            </a> 
                        </td>
                        <td> 
                            <div class="form-group col-md-12 mb-2 px-3 ">
                                <div class="form-check form-switch">
                                    <input class="form-check-input save_status_click" type="checkbox" id="settings-check3" data-action="<?= base_url('aitsun_keys/client_status') ?>/<?= $us['id']; ?>" name="app_status" value="1" <?php if ($us['app_status'] == '1') {echo 'checked';} ?>>
                                </div>
                            </div> 
                        </td>
                        <td><?= $us['display_name']; ?></td>
                        <td><?= $us['email']; ?></td>
                       
                        <td><?= $us['packdate']; ?></td>
                        <td><?= $us['monthly_billing_date']; ?></td>
                        <td>
                            <?php if ($us['payment_method']==0): ?>
                                <span style="color:green;">Paid</span>
                            <?php else: ?>
                                <span style="color:red;">Free</span>
                            <?php endif ?>
                        </td>
                        <td><?= $us['pos_payment_type']; ?></td>
                        <?php if ($us['restaurent']==1): ?>
                            <td class="text-center"><i class="bx bx-check" style="color:green;"></i></td>
                        <?php else: ?>
                            <td class="text-center"><i class="bx bx-x" style="color:red"></i></td>
                        <?php endif ?>
                        <?php if ($us['online_shop']==1): ?>
                            <td class="text-center"><i class="bx bx-check" style="color:green"></i></td>
                        <?php else: ?>
                            <td class="text-center"><i class="bx bx-x" style="color:red"></i></td>
                        <?php endif ?>
                        <?php if ($us['hr_manage']==1): ?>
                            <td class="text-center"><i class="bx bx-check" style="color:green"></i></td>
                        <?php else: ?>
                            <td class="text-center"><i class="bx bx-x" style="color:red"></i></td>
                        <?php endif ?>
                        <?php if ($us['crm']==1): ?>
                            <td class="text-center"><i class="bx bx-check" style="color:green"></i></td>
                        <?php else: ?>
                            <td class="text-center"><i class="bx bx-x" style="color:red"></i></td>
                        <?php endif ?>
                        <?php if ($us['medical']==1): ?>
                            <td class="text-center"><i class="bx bx-check" style="color:green"></i></td>
                        <?php else: ?>
                            <td class="text-center"><i class="bx bx-x" style="color:red"></i></td>
                        <?php endif ?>
                        <?php if ($us['school']==1): ?>
                            <td class="text-center"><i class="bx bx-check" style="color:green"></i></td>
                        <?php else: ?>
                            <td class="text-center"><i class="bx bx-x" style="color:red"></i></td>
                        <?php endif ?>
                        
                    </tr>

                    <?php endforeach ?>
                    
                    <?php if ($i<1): ?>
                        <tr>
                            <td class="text-center" colspan="13">
                                <span class="text-danger">No Clients</span>
                            </td>
                        </tr>
                    <?php endif ?>
                     
                  </tbody>
            </table>
        </div>        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
