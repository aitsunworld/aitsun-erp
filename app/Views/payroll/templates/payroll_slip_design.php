<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?></title>
	<style type="text/css">
    @page {
            margin: 20px;
        } 
    @font-face {
        font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;

    } 
    .company_logo{
      height: 50px;
    } 
    table{width: 100%;}      
    body{
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            
    }
 </style>
</head>
<body>

	<table cellspacing="0" cellpadding="5" style="width:100%;">
		<?php foreach (my_company(company($user['id'])) as $cmp) { ?> 
		<tr>
			<td>
				<img src="<?= base_url(); ?>/public/images/company_docs/<?php if($cmp['company_logo'] != ''){echo $cmp['company_logo']; }else{ echo 'company.png';} ?>" class="company_logo_small company_logo">
			</td>
			<td style="text-align:right;">
				<p class="px-2 mt-1 mb-1">
		        <?php if (!empty($cmp['city'])): ?>
			          <?= $cmp['city']; ?><br>
			        <?php endif ?>
			        <?php if (!empty($cmp['state'])): ?>
			          <?= $cmp['state']; ?>,
			        <?php endif ?>
			        <?php if (!empty($cmp['country'])): ?>
			          <?= $cmp['country']; ?><br>
			        <?php endif ?>
			        <?php if (!empty($cmp['postal_code'])): ?>
			          Pin: <?= $cmp['postal_code']; ?><br>
			        <?php endif ?>
			        <?php if (!empty($cmp['company_phone'])): ?>
			          Mob: <?= $cmp['company_phone']; ?>
			        <?php endif ?><br>
			         <?php if (!empty($cmp['company_phone'])): ?>
			            
			        <?php endif ?>    
			      </p>
			</td>
		</tr>
		<?php } ?>
	</table>
 

 


	<div style="text-align: center;"> 
	     <div style="font-size: 24px;color: #666;">Payroll</div>
	     <span class="fw-normal">Payment roll for the month of <?= get_date_format($payroll_data['month'],'F Y') ?></span>
	</div>
	<br>

	<table class="w-100">
	   <tr>
	       <td>
	            <span class="">Date</span> <span class="ms-3 aitsun-fw-bolder"><?= get_date_format($payroll_data['month'],'d M Y') ?></span> 
	        </td> 
	       <td style="text-align:right;"> 
	         <span class="">Mode of Pay</span> <span class="ms-3 aitsun-fw-bolder"><?= get_group_data($payroll_data['payment_type'],'group_head'); ?></span>  
	       </td>
	   </tr>
	</table>

	<br>
	<?php   $attend_date=$payroll_data['month'] ?>


	<table style=" width: 100%;" cellpadding="5" cellspacing="0" border="1">
	    <thead>
	        <tr> 
	            <th colspan="<?= count(salary_items_array_by_payrollid($payroll_data['id'],company($user['id'])))+3; ?>" style="border:1px solid #cccccc; text-align: center;">Payroll items</th>
	        </tr>
	        <tr style="font-weight: line-height: 2; bold;border:1px solid #cccccc;background-color:#f2f2f2;">
	            <th style="border:1px solid #cccccc;text-align: left;">Employee</th>
	            <th style="border:1px solid #cccccc;text-align: center;">Basic</th>
	            <th style="border:1px solid #cccccc;text-align: center;">Leave</th>
	            
	            <?php foreach (salary_items_array_by_payrollid($payroll_data['id'],company($user['id'])) as $pfa): ?>

	            	<?php 

	            		$var_name=str_replace(' ', '_', $pfa['field_name']);
                        ${'total_'.$var_name} = 0;
	            	 ?>

	                <th style="border:1px solid #cccccc;"><?= get_payroll_field_data($pfa['payroll_field_id'],"field_name"); ?></th>

	            <?php endforeach ?>
	            
	        </tr>
	    </thead>
	    <tbody> 
	        
	        <?php 

	            $total_basic=0;
	                $total_leave_amount=0;
	                $total_gross_salary=0;
	                $total_pf_amount=0;
	                $total_esic_amount=0;

	            $array_total=array(); $grand_total=0; $total_salary=0; foreach ($payroll_items as $msl): 
	           
	        ?>

	            <?php   
	                $dates=get_date_format($attend_date,'Y').'-'.$payroll_data['month'].'-01';

	                $total_salary=0;
	                $gross_salary=0;
	                $esic_amount=0;
	                $pf_amount=0;
	                $net_salary=0;
	                $leave_amount=0;

	                
	               

	               $leave_amount=$msl['extra_leave'];

	                $total_salary+=$msl['basic_salary']-$leave_amount; 

	                $gross_salary=$total_salary;

	                foreach (salary_items_array_by_payrollid_with_employee_id($payroll_data['id'],$msl['employee_id'],company($user['id'])) as $pfa){
	                   
	                    ${"total_" . $pfa['id']}=0;
	                }
	                $gross_salary=$gross_salary;  
	                $grand_total=$payroll_data['total_salary'];


	                  
	             
	            ?>

	            <tr>
	                <td style="border:1px solid #cccccc; text-align: left;"><?= user_name($msl['employee_id']); ?></td>

	                <td style="border:1px solid #cccccc;text-align: center;">
	                    <?= $msl['basic_salary']; ?> 
	                    <?php $total_basic+=$msl['basic_salary']; ?>
	                </td> 
	                <td style="border:1px solid #cccccc;text-align: center;">
	                    <?= $leave_amount; ?>
	                    <?php $total_leave_amount+=$leave_amount; ?>
	                </td> 

	                <?php  foreach (salary_items_array_by_payrollid_with_employee_id($payroll_data['id'],$msl['employee_id'],company($user['id'])) as $pfa): ?>
	                    <!-- //////////amount calculation//////////// -->
	                    <?php 
 
	                        $var_name=str_replace(' ', '_', $pfa['field_name']);
	                        ${'total_'.$var_name} += $pfa['total_amount'];
	                         
	                    ?>
	                    <!-- //////////amount calculation//////////// -->

	                     <td style="border:1px solid #cccccc;text-align: center;"><?= $pfa['total_amount']; ?></td>

	                <?php endforeach ?> 
	                
	                
	            </tr>
	            
	        <?php endforeach ?>
	        <tfoot>
	            <tr style="font-weight: line-height: 2; bold;border:1px solid #cccccc;background-color:#f2f2f2;">
	                <th style="border:1px solid #cccccc;text-align: left;">Total</th> 
	                <td style="border:1px solid #cccccc;text-align: center;"><?= $total_basic; ?></td> 
	                <td style="border:1px solid #cccccc;text-align: center;"><?= $total_leave_amount; ?></td>
					
					<?php foreach (salary_items_array_by_payrollid($payroll_data['id'],company($user['id'])) as $pfa): 

						$svar_name=str_replace(' ', '_', $pfa['field_name']);
					?> 
	                    <td style="border:1px solid #cccccc;text-align: center;"><?= ${'total_'.$svar_name}; ?></td>
	                <?php endforeach; ?> 
	                
	               
	            </tr>

	            <tr>
	            	<td style="border:1px solid #cccccc;" colspan="<?= count(salary_items_array_by_payrollid($payroll_data['id'],company($user['id'])))+3; ?>">
	            		<div class="d-flex flex-column"> <span><?= currency_symbol2($payroll_data['company_id']); ?></span> <span><?= ucwords(amount_in_words(aitsun_round($grand_total))) ?></span> </div>
	            	</td>
	            </tr>
	            
	        </tfoot>

	        
	    </tbody>
	</table>
 
	<div style="margin-top:10px;">
	        <div style="text-align:right;"> 
	            <div class="aitsun-fw-bolder">For <?php foreach (my_company(company($user['id'])) as $cmp) { ?><?= $cmp['company_name']; ?><?php } ?></div> 
	            <?php if (!empty(get_setting(company($user['id']),'payslip_signature'))): ?>
	                <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_setting(company($user['id']),'payslip_signature'); ?>" style="width: 160px; height: 100px;  object-fit: contain;" class="mt-2">
	            <?php endif ?>
	            <div class="mt-2">Authorised Signatory</div> 
	        </div>
	    </div>
</body>
</html>