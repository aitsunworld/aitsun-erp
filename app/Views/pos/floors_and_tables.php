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
                    <a href="<?= base_url('pos'); ?>" class="href_loader">Point of sale</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">
                        Floor management
                    </b>
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
    <div class="my-auto">
        <a href="<?= base_url('pos') ?>" class=" text-dark font-size-footer me-2" > 
            <span class="my-auto">POS Dashboard</span>
        </a> 
    </div>
    <a class="btn btn-sm btn-back" href="<?= base_url('pos/floors/new_floor') ?>">Add floors/Tables</a>
  
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-3 pb-5">
            
            <table id="invoice_table" class="erp_table sortable">
             <thead>
                <tr> 
                    <th class="sorticon">Floor name</th>
                    <th class="sorticon">Register</th> 
                    <th class="sorticon" data-tableexport-display="none">Action</th>
                </tr> 
             </thead>
              <tbody>
                    <?php foreach ($all_floors as $floor): ?>
                    <tr>
                        <td><?= $floor['floor_name'] ?></td>
                        <td><?= $floor['register_name'] ?></td> 
                        <td data-tableexport-display="none">
                            <a class="btn btn-sm btn-primary rounded-pill href_loader" href="<?= base_url('pos/floors/new_floor/'.$floor['id']); ?>">
                                <i class="bx bx-pencil"></i> <span class="">Edit</span>
                            </a>
                            <a class="btn btn-sm btn-danger rounded-pill ajax_delete" data-url="<?= base_url('pos/floors/delete_floor'); ?>/<?= $floor['id']; ?>">
                                <i class="bx bx-trash"></i> <span>Delete</span>
                            </a>  
                        </td>
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
     <div>
        <a href="<?= base_url('pos/settings')?>" class="text-dark font-size-footer"><i class="bx bx-cog"></i> <span class="my-auto">POS Settings</span></a>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 