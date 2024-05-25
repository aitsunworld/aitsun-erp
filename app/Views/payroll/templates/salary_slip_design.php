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
    .aitsun-fw-bolder,.aitsun-fw-bold{
    	font-weight: bold;
    }
 </style>
</head>
<body>

	<table cellspacing="0" cellpadding="5" style="width:100%;">
		<?php foreach (my_company($payroll_data['company_id']) as $cmp) { ?> 
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
     <div style="font-size: 24px;color: #666;">Payslip</div>
     <span class="fw-normal">Payment slip for the month of <?= get_date_format($payroll_data['month'],'F Y') ?></span>
</div>
<br>


<table style="width:100%;">
   <tr>
       <td>
       	 <span class="">EMP Name</span> <span class="ms-3 aitsun-fw-bolder"><?= user_name($pmt['employee_id']) ?></span>
        <br>
            <span class="">EMP ID</span> <span class="ms-3 aitsun-fw-bolder"><?= $pmt['employee_id'] ?></span>
            <br>
            
             <span class="">Designation</span> <span class="ms-3 aitsun-fw-bolder"><?= get_cust_data($pmt['employee_id'],'designation') ?></span>
             <br>
             <span class="">NOD</span> 
        <span class="ms-3 aitsun-fw-bolder">
            <?= $pmt['nod'] ?>
            <?php if ($pmt['nod']>1): ?>
                Days
            <?php else: ?> 
                Day
            <?php endif ?> 
        </span>  
        </td> 
       <td style="text-align:right;">
       
        
         <span class="">Mode of Pay</span> <span class="ms-3 aitsun-fw-bolder"><?= get_group_data($pmt['type'],'group_head'); ?></span> 
         <br> 
         <span class="">Bank name</span> <span class="ms-3 aitsun-fw-bolder"><?= get_cust_data($pmt['employee_id'],'bank_name') ?></span>
		 <br>	
         <span class="">Acc No.</span> <span class="ms-3 aitsun-fw-bolder"><?= get_cust_data($pmt['employee_id'],'account_number') ?></span>
		 <br>
         <span class="">IFSC</span> <span class="ms-3 aitsun-fw-bolder"><?= get_cust_data($pmt['employee_id'],'ifsc') ?></span>
       </td>
   </tr>
</table>
<table class=""> 

	<?php 
		$notal_gross=0;
		$notal_net=0;
	 ?>
    
    <tr class="d-flex w-100">
        <td valign="baseline">
        	<table style=" width: 100%; height: max-content;" cellpadding="5" cellspacing="0" border="1">
		        <thead class="">
		            <tr>
		                <th style="border:1px solid #cccccc;text-align: left;">Earnings</th>
		                <th style="border:1px solid #cccccc;text-align: right;">Amount</th> 
		            </tr>
		        </thead>
		        <tbody>
		            <tr>
		                <td style="border:1px solid #cccccc;text-align: left;">Basic</td>
		                <td style="border:1px solid #cccccc;text-align: right;"><?= $pmt['basic_salary'] ?></td> 
		            </tr>

		            <?php $total_earnings=0; foreach (salary_items_array($pmt['id']) as $si): ?>
		                <?php if ($si['payroll_calculation']=='addition'): ?>
		                    <?php $total_earnings+=$si['total_amount']; ?>
		                    <tr>
		                        <td style="border:1px solid #cccccc;text-align: left;"><?= get_payroll_field_data($si['payroll_field_id'],"field_name"); ?></td>
		                        <td style="border:1px solid #cccccc;text-align: right;"><?= $si['total_amount'] ?></td> 
		                    </tr>
		                <?php endif ?> 
		            <?php endforeach ?>
		            
		           <tr class="border-top"> 
		                <th style="border:1px solid #cccccc;text-align: left;">Total Earnings</th>
		                <th style="border:1px solid #cccccc;text-align: right;"><?= $pmt['basic_salary']+$total_earnings ?></th>
		            </tr>
		        </tbody>
		    </table>
        </td>

	    <td valign="baseline">
	    	<table style=" width: 100%; height: max-content;" cellpadding="5" cellspacing="0" border="1">
		        <thead >
		            <tr> 
		                <th style="border:1px solid #cccccc;text-align: left;">Deductions</th>
		                <th style="border:1px solid #cccccc;text-align: right;">Amount</th>
		            </tr>
		        </thead>
		        <tbody>
		            <tr>
		                <td style="border:1px solid #cccccc;text-align: left;">Extra leave</td>
		                <td style="border:1px solid #cccccc;text-align: right;"><?= $pmt['extra_leave'] ?></td> 
		            </tr>
		            
		            <?php 
		                $total_deduction=$pmt['extra_leave']+$pmt['pf_amount']+$pmt['esic_amount']; 
		                foreach (salary_items_array($pmt['id']) as $si):   ?>
		                	<?php if ($si['field_name']!=='Gross salary' && $si['field_name']!=='Net salary'): ?>
		                		
		                	
				                <?php if ($si['payroll_calculation']!='addition'): ?>
				                    <?php $total_deduction+=$si['total_amount']; ?>
				                    <tr>
				                        <td style="border:1px solid #cccccc;text-align: left;"><?= get_payroll_field_data($si['payroll_field_id'],"field_name"); ?></td>
				                        <td style="border:1px solid #cccccc;text-align: right;"><?= $si['total_amount'] ?></td> 
				                    </tr>
				                <?php endif ?> 
		                    <?php endif ?>

		                    <?php 
			                    if ($si['field_name']=='Gross salary' || $si['field_name']=='Net salary'){
			                    	$notal_gross=$si['total_amount'];
									$notal_net=$si['total_amount'];
			                    }
		                    ?>

		            <?php endforeach ?>
		            <tr class="border-top"> 
		                <th style="border:1px solid #cccccc;text-align: left;">Total Deductions</th>
		                <th style="border:1px solid #cccccc;text-align: right;"><?= $total_deduction ?></th>
		            </tr>
		        </tbody>
		    </table>
	    </td>
    </tr>


</table>

<div class="d-flex">
    <div class="col-md-4"> <br> <span class="aitsun-fw-bold">Net Pay : <span style="font-family: DejaVu Sans; font-size: 14px;"><?= currency_symbol($payroll_data['company_id']) ?></span> <?= $notal_net ?> /-</span> </div>
    <div class="border col-md-8">
        <div class="d-flex flex-column"> <span><?= currency_symbol2($payroll_data['company_id']) ?></span> <span><?= ucwords(amount_in_words(aitsun_round($notal_net))) ?></span> </div>
    </div>
</div>
<br>

<table style="width:100%;">
    <tr>
    	<td>
	        <div class="d-flex flex-column mt-2"> 
	            <span class="aitsun-fw-bolder">Received By</span> 
	            <div style="height: 100px;"></div>
	            <span class="mt-4"><?= user_name($pmt['employee_id']) ?></span> 
	        </div>
	    </td>

	    <td style="text-align:right;">
	        <div class="d-flex flex-column mt-2"> 
	            <div class="aitsun-fw-bolder">For <?php foreach (my_company($payroll_data['company_id']) as $cmp) { ?><?= $cmp['company_name']; ?><?php } ?></div> 
	            <?php if (!empty(get_setting($payroll_data['company_id'],'payslip_signature'))): ?>
	                <img src="<?= base_url('public'); ?>/images/company_docs/<?= get_setting($payroll_data['company_id'],'payslip_signature'); ?>" style="width: 160px; height: 100px;  object-fit: contain;" class="mt-2">
	            <?php endif ?>
	            <div class="mt-2">Authorised Signatory</div> 
	        </div>
	    </td>
    </tr>
</table>

</body>
</html>