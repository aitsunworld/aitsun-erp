<?php 
    $at_date=now_time($user['id']);


    if ($_GET) {
        if (!empty($_GET['attend_date'])) {
            $attend_date=get_date_format($_GET['attend_date'],'Y-F');

            $at_date=$attend_date;

        }else{
            $attend_date=get_date_format(now_time($user['id']),'Y - F');
        }
        
    }else{
        $attend_date=get_date_format(now_time($user['id']),'Y - F');
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

                 <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('hr_manage'); ?>">HR Management</a>
                </li>

                 <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('payroll'); ?>">Payroll</a>
                </li>
             
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Basic salary</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#basic_salary_table" data-filename="Parties master"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#basic_salary_table" data-filename="Parties master"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#basic_salary_table" data-filename="Parties master"> 
            <span class="my-auto">PDF</span>
        </a> 
       
    </div>
 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
         
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table table-responsive col-12 w-100 pt-0 pb-5">
             
            <table class="erp_table" id="basic_salary_table">
                <thead>
                    <tr>
                        <th colspan="13" class="text-center">Basic Salary Table (<?= get_date_format($attend_date,'Y'); ?>)</th>
                    </tr>
                    <tr>
                        <th scope="col"> Employee</th>
                          <?php  
                                for ($m=1; $m<=12; $m++) :
                                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                // echo '<li><a class="dropdown-item" href="?month='.$m.'">'.$month.'</a></li>';
                                $dates=get_date_format($attend_date,'Y').'-'.$m.'-01';
                             
                            ?>

                            <th scope="col">  
                                <?= $month; ?>  
                            </th>
                       <?php endfor; ?> 
                        
                    </tr>
                </thead>
                <tbody>

                     <?php $i=0; foreach ($user_data as $it): $i++; ?>
                      <tr>

                        <td style="min-width: 250px;">
                            <b class="text-dark"><?= user_name($it['id']); ?></b>
                           <!--  <a href="<= base_url('payroll/employee_details'); ?>/<= $it['id']; ?>">
                                <b class="text-dark"><?= user_name($it['id']); ?></b>
                                <b class="text-danger"><i class="bx bx-edit"></i></b>
                            </a> -->  
                        </td>


                        <?php  
                                for ($m=1; $m<=12; $m++) :
                                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                // echo '<li><a class="dropdown-item" href="?month='.$m.'">'.$month.'</a></li>';
                                $dates=get_date_format($attend_date,'Y').'-'.$m.'-01';
                             
                            ?>

                        <td>
                            <input type="number" min="1" class="basic_salary_price aitsun-simple-input"  step="any" data-month="<?= get_date_format($dates,'Y') ?>-<?= $m ?>-<?= get_date_format($dates,'d') ?>" data-employee_id="<?= $it['id']; ?>" value="<?= basic_salary_employee($it['id'],$dates,company($user['id'])); ?>" style="max-width: 80px;">
                            
                        </td>

                        <?php endfor; ?>

                    </tr>
                     <?php endforeach ?>
                     <?php if ($i==0): ?>
                         <tr>
                            <td><h6 class="text-danger">No Items</h6></td>
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
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
        
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 