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
                    <b class="page_heading text-dark">Create</b>
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


  <?php 
        if ($_GET) {
            if (!empty($_GET['attend_date'])) {
                $attend_date=get_date_format($_GET['attend_date'],'Y-m-d');

            }else{
                $attend_date=get_date_format(now_time($user['id']),'Y-m-d');
            }
            
        }else{
            $attend_date=get_date_format(now_time($user['id']),'Y-m-d');
        }   
    ?>

<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->

<form method="post" action="<?= base_url('payroll/add_payroll'); ?>">
                            <?= csrf_field(); ?>
                            
                <input type="hidden" class="form-control" name="month" id="month_details" value="<?= $attend_date; ?>">

<div class="toolbar d-flex justify-content-between">
    <div>
        <input type="date" id="attend_date_box" class="aitsun-datebox datepicker-input my-auto me-2" name="date" placeholder="Pick a date" value="<?= $attend_date; ?>" max="<?= get_date_format(now_time($user['id']),'Y-m-d'); ?>" required>

        
 
       
    </div>
    
     <div> 
        <?php if ($monthly_salary_count>0): ?> 
            <select class="aitsun-datebox" name="type" required>
                <option value=""><?= langg(get_setting(company($user['id']),'language'),'Select payment type'); ?></option>

                <?php foreach (bank_accounts_of_account(company($user['id'])) as $ba): ?>
                    <option value="<?= $ba['id']; ?>"><?= $ba['group_head']; ?></option>
                <?php endforeach ?>  
            </select>

            <button type="submit" class="aitsun-primary-btn-topbar" name="add_payroll">Create & Save</button>
        <?php endif ?>
    </div>

</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
         
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">  

        <div class="aitsun_table table-responsive col-12 w-100 pt-0 pb-5">
            
            <table class="erp_table no-wrap" id="basic_salary_table">
                <thead>
                     <tr> 
                        <th colspan="<?= count(payroll_fields_array(company($user['id'])))+7; ?>" class="text-center">Salary Table (<?= get_date_format($attend_date,'F Y'); ?> )</th>
                    </tr>
                     <tr>
                        <th scope="col">Employee</th>
                        <th scope="col">Basic Salary</th>
                        <th scope="col">Extra Leave</th>
                        
                        <?php foreach (payroll_fields_array(company($user['id'])) as $pfa): ?>

                             <?php 
                                ////Defining variables
                                $var_name=str_replace(' ', '_', $pfa['field_name']);
                                ${'total_'.$var_name} = 0;
                             ?>

                            <th scope="col">
                                <div class="d-flex justify-content-between">
                                    <div><?= $pfa['field_name']; ?></div>
                                    <?php if ($pfa['formula']==''): ?>
                                        <small class="my-auto">
                                            <a class="set_value" data-boxid="<?= $pfa['id']; ?>">+ Set value</a>
                                        </small>
                                    <?php endif ?>
                                </div> 
                            </th>

                        <?php endforeach ?>
                      
                        
                    </tr> 
                </thead>
                <tbody> 

                <?php $grand_total=0; $total_salary=0; $total_basic_salary=0; foreach ($monthly_salary as $msl): 
                   
                ?>

                     <?php foreach (payroll_fields_array(company($user['id'])) as $pfa): ?>

                            <?php 
                                ////Defining variables
                                $var_name=str_replace(' ', '_', $pfa['field_name']);
                                ${$var_name} = 0;
                             ?>

                          

                        <?php endforeach ?>

                    <?php   
                        $dates=get_date_format($attend_date,'Y').'-'.$msl['month'].'-01';

                        $total_salary=0;
                        $gross_salary=0;
                        $esic_amount=0;
                        $pf_amount=0;
                        $net_salary=0;
                        $basic_salary=0;
                       
                        // get_user_leave_by_year(company($user['id']),$atn['user_id'],$dates,$atn['employee_category'])

                        if (get_user_leave_by_year(company($user['id']),$msl['employee_id'],$dates,get_cust_data($msl['employee_id'],'employee_category'))>(get_setting(company($user['id']),'leave_for_month')*12)+carry_forwarded_leave($msl['employee_id'],$dates)) {

                             $leave_amount=one_day_salary_of_employee($user['id'],$msl['basic_salary'],$msl['month'])*get_total_leaves_of_employee(company($user['id']),$attend_date,$msl['employee_id']);



                        }else{
                            $leave_amount=0;
                        }

                        $basic_salary+=$msl['basic_salary']-$leave_amount;  

                        $Basic=$msl['basic_salary']-$leave_amount;

                        $total_basic_salary+=$Basic;

                       
                    ?>

                    <tr>
                        <td><?= user_name($msl['employee_id']); ?>
                            <input type="hidden" class="aitsun-simple-input-disabled read_box" name="employee_id[]" value="<?= $msl['employee_id']; ?>" readonly>
                            <?php  $in_the_month=get_date_format(now_time($user['id']),'Y-m-d'); ?>
                            <input type="hidden" class="aitsun-simple-input-disabled read_box" name="nod[]" value="<?= completed_days($msl['employee_id'],$in_the_month); ?>" readonly>
                            <input type="hidden" class="aitsun-simple-input-disabled read_box" name="present_days[]" value="<?= present_days($msl['employee_id'],$in_the_month); ?>" readonly>
                        </td>

                       

                        <td><input type="number" min="0" class="aitsun-simple-input-disabled read_box basic_sal_box" name="basic_salary[]" data-salary_id="<?= $msl['id'] ?>" id="basic_salary<?= $msl['id'] ?>" step="any"  value="<?= $msl['basic_salary']; ?>" readonly></td>


                        <td> 
                            <input type="number" min="0" class="aitsun-simple-input-disabled read_box extra_leave_box" data-salary_id="<?= $msl['id'] ?>" id="extra_leave<?= $msl['id'] ?>" name="extra_leave[]"  step="any"  value="<?= $leave_amount; ?>" readonly> 
                        </td>
                        


                        

                        <?php foreach (payroll_fields_array(company($user['id'])) as $pfa): ?>
                            <td>  
                                <?php  
                                    $dvar_name=str_replace(' ', '_', $pfa['formula']);

                                    $modifiedString = preg_replace("/\b(?![^a-zA-Z]+$)([a-zA-Z]+)/", "$$1", $dvar_name);
 
                                    

                                    $var_name=str_replace(' ', '_', $pfa['field_name']);
                                    ${$var_name}+=eval("return $modifiedString;");

                                    if ($pfa['formula']==''){ 
                                        ${$var_name}=get_manual_field_data($attend_date,$msl['employee_id'],$pfa['id'],'manual_value');
                                    }

                                    ${'total_'.$var_name} += ${$var_name};

                                    if ($var_name=='Gross_salary') {
                                        $gross_salary+=${$var_name};
                                    }


                                    if ($var_name=='Net_salary') {
                                        $net_salary+=${$var_name};
                                    }
                                     

                                 ?>
                               <!-- <= $pfa['formula'] ?> -->


                               <!-- //////input/////// -->

                            <?php 
                                $aitsun_simple_input_disabled='aitsun-simple-input-disabled';
                                $readonly='readonly';
                                $manual_box='manual_box'.$pfa['id']; 
                                if ($pfa['formula']==''){
                                    $aitsun_simple_input_disabled='aitsun-simple-input';
                                    $readonly=''; 
                                }

                                
                            ?>

                            <input type="number" min="0" class="<?= $manual_box ?>  aitsun-simple-input-disabled add_box add_element<?= $msl['id'] ?>" 

                                data-calculation="<?= $pfa['amount_type'] ?>" 
                                data-amount_type="<?= $pfa['amount_type'] ?>" 
                                data-percentage="<?= $pfa['percentage'] ?>" 
                                data-salary_id="<?= $msl['id'] ?>" 
                                data-field_id="<?= $pfa['id'] ?>"
                                data-employee_id="<?= $msl['employee_id'] ?>" 
                                id="add_box<?= $msl['id'] ?>" 

                                name="<?= $msl['employee_id'] ?>salary_item_amount[]" 
                                step="any"  
                                value="<?= ${$var_name} ?>"
                                data-formula="<?= $pfa['formula'] ?>" readonly>

                            <input type="hidden" name="<?= $msl['employee_id'] ?>salary_item_id[]" value="<?= $pfa['id'] ?>">
                            <input type="hidden" name="<?= $msl['employee_id'] ?>salary_item_calculation[]" value="<?= $pfa['amount_type'] ?>">
                            <input type="hidden" name="<?= $msl['employee_id'] ?>salary_item_percentage[]" value="<?= $pfa['percentage'] ?>"> 
                            <input type="hidden" name="<?= $msl['employee_id'] ?>salary_item_amount_type[]" value="<?= $pfa['amount_type'] ?>"> 

                            <input type="hidden" min="0" class="read_box gross_sal_box" data-salary_id="<?= $msl['id'] ?>" id="gross_sal<?= $msl['id'] ?>" name="gross_salary[]"  step="any" style="max-width: 80px;" value="<?= $gross_salary; ?>" readonly> 
                            <input type="hidden" min="0" class="read_box net_sal_box" data-salary_id="<?= $msl['id'] ?>" id="net_salary<?= $msl['id'] ?>" name="net_salary[]"  step="any" style="max-width: 80px;" value="<?= $net_salary ?>" readonly>

                            <input type="hidden" min="0" class="read_box " data-salary_id="<?= $msl['id'] ?>" id="formula<?= $msl['id'] ?>" name="formula[]"  step="any" style="max-width: 80px;" value="<?= $pfa['formula'] ?>" readonly>

                            <input type="hidden" name="<?= $msl['employee_id'] ?>formula[]" value="<?= $pfa['formula'] ?>"> 
                            <input type="hidden" name="<?= $msl['employee_id'] ?>field_name[]" value="<?= $pfa['field_name'] ?>"> 

                            

                               <!-- //////input/////// -->
                        </td>

                        <?php endforeach ?>

 
                      
                    </tr>
                    
                <?php endforeach ?>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <b>Total</b>
                        </th>

                        <th>
                            <b><?= $total_basic_salary ?></b>
                        </th>

                        <th>
                            <b></b>
                        </th>
                        <?php foreach (payroll_fields_array(company($user['id'])) as $pfa): 
                            $svar_name=str_replace(' ', '_', $pfa['field_name']);
                            if ($svar_name=='Net_salary') {
                                $grand_total+=${'total_'.$svar_name};
                            } 
                            
                        ?>

                           

                            <th scope="col"><?= ${'total_'.$svar_name}; ?></th>

                        <?php endforeach ?>
                        
                    </tr>
                </tfoot>
            </table>  

        </div>

        <!-- ////////////  additional inputs ////////////// -->
        <input type="hidden" min="0" class="aitsun-simple-input-disabled read_box" id="total_salary" name="total_salary"  step="any" value="<?= $grand_total; ?>" readonly>

        

    </div>
</div>
</form>
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


 