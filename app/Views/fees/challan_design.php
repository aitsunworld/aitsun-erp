<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?></title>
</head>
<body>
	 <style type="text/css">
    @page {
            margin: 20px;
        } 
    /*@font-face {
        font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;

    } */
    .company_logo{
      height: 50px;
    } 
    .div_flex {
	    display: -webkit-box; /* wkhtmltopdf uses this one */
	    display: flex;
	    -webkit-box-pack: center; /* wkhtmltopdf uses this one */
	    justify-content: center;
	}

	.div_flex > div {
	    -webkit-box-flex: 1;
	    -webkit-flex: 1;
	    flex: 1;
	}

	.div_flex > div:last-child {
	    margin-right: 0;
	}
    table{width: 100%;}      
    body{
/*        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;            */
    }
 </style>

 <table border="1" cellspacing="0" cellpadding="5" style="width:100%;font-size: 14px;" class="challan_sheet_tb">
	<tr>
		<td colspan="3">
			
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td> 
						<div style="margin:0; font-size: 1.17em ;"><b><?= organisation_name($invoice['company_id']); ?></b></div>
						<p style="margin:0;font-size: 13px;">
							<?= organisation_address($invoice['company_id']); ?>

							<br>
							Phone: <?= organisation_phone($invoice['company_id']); ?>
							<br>
							Email: <?= organisation_email($invoice['company_id']); ?>
						</p> 
				    </td>
					<td style="text-align:right;">
						<img src="<?= organisation_logo($invoice['company_id']); ?>" class="company_logo">
					</td>
				</tr>
			</table>

		</td>
	</tr>
	<tr bgcolor="#0e0e0e">
		<td colspan="3" style="text-align:center;" >
			<h4 style="margin:0; color: white;">
				CHALLAN
			</h4>
		</td>
	</tr>
	<tr>
		<td colspan="3">

			<table cellspacing="0" cellpadding="0" border="0" style="font-size: 14px;">
				<tr>
					<td >
					<div>
						Challan No : <span style=""><?= inventory_prefix($invoice['company_id'],$invoice['invoice_type']) ?><?= $invoice['serial_no'] ?></span> <br>
						Name of Student : <span style=""><?= user_name($invoice['customer']) ?></span> <br>
						Admission No : <span style=""><?= get_student_data($invoice['company_id'],$invoice['customer'],'admission_no') ?></span> <br>
						Class : <span style=""><?= class_name(current_class_of_student($invoice['company_id'],$invoice['customer'])) ?></span><br>
						
					</div>

					</td>
					<td style="text-align:left; width: 40%;">
						<div class="my-auto mr-5">
							Date: <span style=""><?= get_date_format($invoice['invoice_date'],'d M Y') ?></span><br>
							For the period: <span style=""><?= get_date_format($ft['due_date'],'d M Y') ?></span><br>
							Payment mode: <span style="">
								<?php if ($invoice['invoice_type']=='challan' || $invoice['invoice_type']=='sales_return' || $invoice['invoice_type']=='purchase' || $invoice['invoice_type']=='purchase_return'): ?>
			                      <?= mode_of_payment($invoice['company_id'],$invoice['id']); ?>
			                    <?php else: ?>
			                      ---
			                    <?php endif ?>
							</span>

						</div>

					</td>
				</tr>
		</td>
	</tr>
	
	<tr>
		<td colspan="3"><center><div class="mb-0"><b><?= $ft['fees_name']; ?></b></div></center></td>
	</tr>
	
	<tr bgcolor="#0e0e0e">
		<td  style="width:50px;color:white;">Sr. No.</td>
		<td  style="color:white;">Particulars</td>
		<td  style="color:white; text-align: right;">Amount</td>
	</tr>

	<?php $i=0; $total=0; foreach (invoice_items_array($invoice['id']) as $ii): $i++; ?>
		<tr>
			<td style="padding:3px 3px 3px 4px;"><?= $i; ?>.</td>
			<td style="width:63%;padding:3px 3px 3px 4px;"><?= $ii['product']; ?></td>
			<td style="text-align:right; padding:3px 3px 3px 4px;"><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice['company_id']) ?></span> <?= number_format($ii['amount'],get_setting(company($user['id']),'round_of_value'),'.', ''); ?> <?php $total+=$ii['amount']; ?></td>
		</tr>
	<?php endforeach ?>


	<tr bgcolor="#0e0e0e">
		<td colspan="2" style="color:white;padding:3px 3px 3px 4px;"><span style="">Total</span></td>
		<td style="text-align:right; color:white;padding:3px 3px 3px 4px;"><span style=""> <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice['company_id']) ?></span> <?= number_format($invoice['main_total'],get_setting(company($user['id']),'round_of_value'),'.',''); ?></span></td>
	</tr>

	<?php if ($invoice['discount']>0): ?>
		<tr>
			<td colspan="2" style="padding:3px 3px 3px 4px;">Concession (<?= $invoice['concession_for']; ?>)</td>
			<td style="text-align:right;padding:3px 3px 3px 4px;"> <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice['company_id']) ?></span> <?= number_format($invoice['discount'],get_setting(company($user['id']),'round_of_value'),'.',''); ?></td>
		</tr>
		<tr>
			<td colspan="2" style="padding:3px 3px 3px 4px;">Payable</td>
			<td style="text-align:right;padding:3px 3px 3px 4px;"><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice['company_id']) ?></span> <?= number_format($invoice['total'],get_setting(company($user['id']),'round_of_value'),'.',''); ?></td>
		</tr>
			
	<?php endif ?>

	<tr>
		<td colspan="2" style="padding:3px 3px 3px 4px;"><span style="">Paid</span></td>
		<td style="text-align:right; padding:3px 3px 3px 4px;"><span style=""> <span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice['company_id']) ?></span> <?= number_format($invoice['paid_amount'],get_setting(company($user['id']),'round_of_value'),'.',''); ?></span></td>
	</tr>
	<tr>
		<td colspan="2" style="padding:3px 3px 3px 4px;">Balance</td>
		<td style="text-align:right; padding:3px 3px 3px 4px;"><span style="font-family: DejaVu Sans;"><?= currency_symbol($invoice['company_id']) ?></span> <?= number_format($invoice['due_amount'],get_setting(company($user['id']),'round_of_value'),'.',''); ?></td>
	</tr>
	
	
	<?php if ($invoice['paid_amount']!=0): ?>
		
		<tr>
			<td colspan="3" style="padding:3px 3px 3px 4px;">Amount in Words: <span style="text-transform: capitalize; "><?= numberTowords(aitsun_round($invoice['paid_amount'],get_setting(company($user['id']),'round_of_value')),$invoice['company_id']); ?></span></td>
		</tr>
	<?php endif ?>

	


	<tr>
		<td colspan="3" style="padding:3px 3px 3px 1px;">

			<table cellspacing="0" cellpadding="0" border="0" style="font-size: 14px;">
				<tr>
					<td style="padding:3px 3px 3px 3px; vertical-align: baseline;">
						<h5 style="margin:0; font-size: 15px;"><?= get_organisation_settings2(company($user['id']),'footer_title'); ?></h5>
						<ol style="margin: 0; list-style-type: none; padding-left: 0; margin-bottom: 10px;">
							<li>
								<?= nl2br(get_organisation_settings2(company($user['id']),'description')); ?>
							</li>
						</ol>
					</td>
					<td style="width: 40%;padding:3px 4px 3px 3px; vertical-align: baseline;text-align: center;">
						<?php if (!empty(get_organisation_settings2(company($user['id']),'sign_logo'))): ?>
						<h5 style="margin:0;font-size: 15px;">Signature </h5>
						<div>
							<img style="width: auto; height: 55px;" src="<?= base_url('public'); ?>/uploads/signature/<?= get_organisation_settings2(company($user['id']),'sign_logo'); ?> ">
						</div>
						<?php endif ?>
					</td>
				</tr>

				<tr>
					<td style="padding:3px 4px 3px 3px; vertical-align: baseline;">
						<h5 style="margin:0; font-size: 15px; padding: 0;">Bank: </h5>
						<p class="text-dark" style="margin: 0"><?= nl2br(get_organisation_settings2(company($user['id']),'bank')); ?></p>
					</td>
					<td style="width: 40%;padding:3px 4px 3px 3px; vertical-align: baseline;text-align: center;">
						<?php if (!empty(get_organisation_settings2(company($user['id']),'upi'))): ?>
						<h5 style="margin:0;font-size: 15px; ">Scan to pay </h5>
						<div style="">
							<img style="width: auto; height:55px;" src="<?= base_url('public'); ?>/uploads/signature/<?=get_organisation_settings2(company($user['id']),'upi'); ?> ">
						</div>
						<?php endif ?>
					</td>
				</tr>
			</table>

		</td>
	</tr>

	<tr >
		<td colspan="3" style="padding:3px 3px 3px 4px;">
			Notes: <?= $ft['description']; ?>
		</td>
	</tr>



</table>
</body>
</html>