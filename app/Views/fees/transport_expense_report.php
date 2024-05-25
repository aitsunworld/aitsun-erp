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
                    <a class="href_loader" href="<?= base_url('fees_and_payments'); ?>">Fees management</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Transport Expense Report</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#group_wise_transport_expense_report" data-filename="Group wise transport expense report <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#group_wise_transport_expense_report" data-filename="Group wise transport expense report <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#group_wise_transport_expense_report" data-filename="Group wise transport expense report <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
     
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#filter"> 
            <span class="my-auto">Filter</span>
        </a>


        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#group_wise_transport_expense_report"> 
            <span class="my-auto">Quick search</span>
        </a>

       
        
    </div>

    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


  <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                        <input type="date" name="from" class="form-control form-control-sm filter-control" title="From" placeholder="">
                        
                        <input type="date" name="to" title="To" class="form-control form-control-sm filter-control" placeholder="">

                        <select name="vehicle" class="form-control form-control-sm asms_select ">
                          <option value=""><?= langg(get_setting(company($user['id']),'language'),'Choose Vehicle'); ?></option>
                              
                            <?php foreach (vehicles_array(company($user['id'])) as $vch): ?>
                                <option value="<?= $vch['id']; ?>"><?= $vch['vehicle_name']; ?></option>
                            <?php endforeach ?>
                        </select>

                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('fees_and_payments/transport_expense_report') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="group_wise_transport_expense_report" class="erp_table sortable">
             <?php 
            $get_from='';
            $get_to=''; 
            

            if ($_GET) {
                if (isset($_GET['from'])) {
                    $get_from=trim($_GET['from']);
                }
                if (isset($_GET['to'])) {
                    $get_to=trim($_GET['to']);
                }

            }
         ?>


       
     <?php $i=0; foreach ($vehicle_data as $vd): $i++; ?>
         <tr>
            <th colspan="5" class="text-center bg-dark text-white">
                <b><?= $vd['vehicle_name'] ?> - <?= $vd['vehicle_number'] ?> </b>
            </th>
        </tr>
       
        

             <tr>
                 <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'Date'); ?></b>
                  </td>
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'No.'); ?></b>
                  </td>
                 
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'Particulars'); ?></b>
                  </td> 
                  <td >
                      <b><?= langg(get_setting(company($user['id']),'language'),'Note'); ?></b>
                  </td> 
                  <td>
                      <b><?= langg(get_setting(company($user['id']),'language'),'Debit'); ?></b>
                  </td> 
                   
            </tr>

             <?php $ic=0; $total_sum=0; $paid_sum=0; $due_sum=0; foreach (get_expense_data(company($user['id']),$vd['id'],$get_from,$get_to) as $db): ?>
         
            <tr>
             <td> 
                <?= get_date_format($db['datetime'],'d-m-Y'); ?>
               
              </td>
              <td>

                <a class="href_loader aitsun_link" href="<?= base_url('payments/details'); ?>/<?= $db['id']; ?>">
                    <?= get_setting(company($user['id']),'payment_prefix'); ?> <?= $db['serial_no']; ?>
                </a>


                 
              </td>
              
              <td>
                    <?= get_account_name($db['account_name'],'group_head') ?>
              </td>
             
              

              <td>
                  <?= $db['payment_note']; ?>
              </td>
              <td class="text-right">
                 
                    <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($db['amount'],get_setting(company($user['id']),'round_of_value')); ?>
                   <?php $total_sum+=aitsun_round($db['amount'],2); ?>
                 
              </td> 
             
          </tr>

           <?php endforeach ?>
        
        <?php if (count(get_expense_data(company($user['id']),$vd['id'],$get_from,$get_to))==0): ?>
       
            <tr>
                <td class="text-center text-danger" colspan="6">No data</td>  
            </tr>
       
       <?php endif ?>
            <tr>
                <td colspan="4" class="text-center"><b>Total</b></td>
                <td class="text-right">
                    <b> <?= currency_symbol(company($user['id'])); ?> <?= aitsun_round($total_sum,get_setting(company($user['id']),'round_of_value')); ?></b>
                </td> 
            </tr>
   

       <?php endforeach ?> 

            </table>
        </div>

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->