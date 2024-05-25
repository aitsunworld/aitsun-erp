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

                <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url('reports_selector'); ?>">Reports</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Activity Logs</b>
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
<div class="toolbar d-flex justify-content-end">
    <a href="javascript:void(0);" class="aitsun_table_export my-auto text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
        <span class="my-auto">Filter</span>
    </a>
    <div class="ms-auto"> 
        <a class="text-dark font-size-footer dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">Action<span class="visually-hidden"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">    
            <a class="dropdown-item clear_20_logs font-size-footer" data-url="<?= base_url('reports/clear_20') ?>">
                <i class="bx bx-trash-alt mr-1"></i>  <?= langg(get_setting(company($user['id']),'language'),'Clear 20 logs'); ?>
            </a>
            <a class="dropdown-item clear_all_logs font-size-footer" data-url="<?= base_url('reports/clear_all') ?>">
                <i class="bx bx-trash-alt mr-1"></i> <?= langg(get_setting(company($user['id']),'language'),'Clear all logs'); ?>
            </a>
            
        </div>
        
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                <form method="get" class="d-flex">
                    <?= csrf_field(); ?>

                    <input type="text" name="logs" class="filter-control w-100 form-control" placeholder="Search actions">
 
                    <input type="date" name="from" class="filter-control w-100" placeholder="From">
            
                    <input type="date" name="to" class="filter-control w-100" placeholder="To">
 
                    <button class="href_long_loader btn-dark btn-sm">
                        <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
                    </button>
                     

                    <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('reports/activity_logs') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                  
                  
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
                    <th class="sorticon">User</th>
                    <th class="sorticon">Action</th>
                    <th class="sorticon">Date</th> 
                    <th class="sorticon">IP</th> 
                    <th class="sorticon">MAC</th> 
                </tr>
             
             </thead>
              <tbody>
                <?php foreach ($all_logs as $alg ): ?>
                    <tr>
                        <td><?= user_name($alg['user_id']); ?></td>
                        <td><?= $alg['action']; ?></td>
                        <td><?= get_date_format($alg['created_at'],'d M Y h:i A'); ?></td>
                        <td><?= $alg['ip']; ?></td>
                        <td><?= $alg['mac']; ?></td>
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
        <a href="<?= base_url('app_info') ?>" class="text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 