<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Barcode Preview
	</title>

	<style media="print">
		@page { size: auto;  margin: 20px; }
	</style>
</head>
<body>



		<?php 
			if ($sample_product=='yes') {
				$pro_product_name='Product name';
				$pro_id=0;
				$pro_barcode='895588555225';
				$pro_price='250.50';
			}else{
				$pro_product_name=$get_pro['product_name'];
				$pro_id=$get_pro['id'];
				$pro_barcode=$get_pro['barcode'];
				$pro_price=$get_pro['price'];
			}
			
		 ?>

		
		<div style="width: <?= get_setting(company($user['id']),'bar_body_width') ?>px;margin:<?= get_setting(company($user['id']),'bar_margin1') ?>px <?= get_setting(company($user['id']),'bar_margin2') ?>px <?= get_setting(company($user['id']),'bar_margin3') ?>px <?= get_setting(company($user['id']),'bar_margin4') ?>px;text-align:center;border-radius:5px;
			
			<?php if (get_setting(company($user['id']),'border')==1): ?>
				border: <?= get_setting(company($user['id']),'border-width') ?>px solid;
			<?php endif ?>

			padding: <?= get_setting(company($user['id']),'bar_padding1') ?>px <?= get_setting(company($user['id']),'bar_padding2') ?>px;

			">
			
			<h6 style="margin:<?= get_setting(company($user['id']),'margin_top') ?>px 0 <?= get_setting(company($user['id']),'margin_bot') ?>px 0;font-size: <?= get_setting(company($user['id']),'font_size') ?>px;"><?= $pro_product_name; ?></h6>

			<img style="margin:<?= get_setting(company($user['id']),'margin_top') ?>px 0 <?= get_setting(company($user['id']),'margin_bot') ?>px 0;width:100%;height:<?= get_setting(company($user['id']),'barcode_height') ?>px;" src="<?= base_url('generate_barcode') ?>?text=<?= $pro_barcode; ?>&size=80&SizeFactor=4&print=true" id="bar_img<?= $pro_id; ?>" class="w-100">

			<h6 style="margin:<?= get_setting(company($user['id']),'margin_top') ?>px 0 <?= get_setting(company($user['id']),'margin_bot') ?>px 0; font-size: <?= get_setting(company($user['id']),'font_size') ?>px;">
				<?= $pro_barcode; ?>
			</h6>

			<h6 style="margin:<?= get_setting(company($user['id']),'margin_top') ?>px 0 <?= get_setting(company($user['id']),'margin_bot') ?>px 0; font-size: <?= get_setting(company($user['id']),'font_size') ?>px;">
				<?php if (get_setting(company($user['id']),'price_for_barcode')==1): ?>
					Price: <?= currency_symbol($user['company_id']); ?> <?=  $pro_price; ?> 
				<?php endif ?>
			</h6>

	</div>


</body>
</html>