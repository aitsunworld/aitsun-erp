<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	
	<link rel="icon" href="<?= base_url('public'); ?>/images/app_icon.ico" type="image/png" />
  
	<!-- Bootstrap CSS -->
	<link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	
	<title><?= $title; ?></title>
</head>

<body>
<?php 
        $filename='';
        $filename=inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'-';

        if ($invoice_data['customer']=='CASH') {
            if ($invoice_data['alternate_name']=='') {
                $filename.=langg(get_setting($invoice_data['company_id'],'language'),'CASH CUSTOMER');
            }else{
                $filename.=$invoice_data['alternate_name'];
            }
        }else{
            $filename.=user_name($invoice_data['customer']);
        }
    ?>

    <style type="text/css">
    	body{
    		overflow: hidden;
    	}
    	.main_buttons{
    		height: 100vh;

    	}
    	.downloading_mes{
    		display: none;
    		position: absolute;
		    top: 0;
		    left: 0;
		    height: 100vh;
		    width: 100%;
		    background: white;
		    z-index: 9999999;
    	}
      a{
        text-decoration: none;
      }
    </style>

    <div class="downloading_mes">
    	<div class="d-flex" style="height: 100vh;">
    		<div class="m-auto down_text">
	    		Downloading...
	    	</div>
    	</div>
    </div>

    <div class="main_buttons  justify-content-between">
 
        <div class="d-flex py-2 justify-content-center">
 
          <a class="font-size-footer btn-sm btn-dark cursor-pointer aitsun-print me-2" data-url="<?= base_url('invoices/get_invoice_pdf/'.$invoice_id.'/view#toolbar=0&navpanes=0&scrollbar=0')?>">
              <i class="bx bx-printer"></i> 
              <span class="hidden-xs"><?= langg(get_setting($invoice_data['company_id'],'language'),'Print'); ?></span>
          </a>


          <a class="font-size-footer btn-sm btn-dark cursor-pointer aitsun-print me-2" data-url="<?= base_url('invoices/view_pdf/'.$invoice_id.'?method=view'); ?>">
              <i class="bx bx-printer"></i> 
              <span class="hidden-xs"><?= langg(get_setting($invoice_data['company_id'],'language'),'PDF Print'); ?></span>
          </a>
 

          <a href="<?= base_url('invoices/view_pdf/'.$invoice_id.'?method=download'); ?>" class="font-size-footer btn-sm btn-dark cursor-pointer download_complete">
                <i class="bx bx-download"></i>
                <span class="hidden-xs"><?= langg(get_setting($invoice_data['company_id'],'language'),'Download PDF'); ?></span>
          </a>
 
        </div>

    		<div class="mb-2">
    			<iframe style="border: 0;width: 100%;height: 100vh;" src="https://docs.google.com/gview?embedded=true&url=<?= base_url('invoices/view_pdf/'.$invoice_id.'?method=view'); ?>"></iframe>
    		</div>
    		
    	</div> 


<div class="position-relative">
	<div class="bg-white" style="    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;"></div>
	<div id="pdfthis" class="pdfthis"></div>
</div>

  
<script src="<?= base_url('public'); ?>/js/pos_print.js?v=<?= script_version(); ?>"></script>
 
<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url: "<?= base_url('invoices/get_invoice_pdf'); ?>/<?= $invoice_id ?>/view",
      success:function(response) {
        $('#pdfthis').html(response);
     },
     error:function(){
      alert("error");
     }
    }); 
  });
</script>
</body>
</html>