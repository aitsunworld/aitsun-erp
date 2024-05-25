<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	
	<link rel="icon" href="<?= base_url('public'); ?>/images/app_icon.ico" type="image/png" />
 
	<!-- loader-->
	<link href="<?= base_url('public'); ?>/css/pace.min.css" rel="stylesheet" />
	<script src="<?= base_url('public'); ?>/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?= base_url('public'); ?>/css/app.css" rel="stylesheet">
	<link href="<?= base_url('public'); ?>/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/dark-theme.css" />
	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/custom.css?ver=<?= style_version(); ?>" />
	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/crm.css?ver=<?= style_version(); ?>" />
	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/invoice_design.css?ver=<?= style_version(); ?>" />
	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/semi-dark.css" />
	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/header-colors.css" />

	<link rel="stylesheet" href="<?= base_url('public'); ?>/css/dark.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="<?= base_url('public'); ?>/js/popper.min.js"></script>
	
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
    </style>

    <div class="downloading_mes">
    	<div class="d-flex" style="height: 100vh;">
    		<div class="m-auto down_text">
	    		Downloading...
	    	</div>
    	</div>
    </div>

    <div class="main_buttons d-flex justify-content-between">

    	<div class="m-auto text-center">
    		<div class="mb-2">
    			Download  as
    		</div>
    		<div class="d-flex">

          <a class="btn downloading_mes_press btn-dark btn-sm me-1 download_complete" href="<?= base_url('invoices/get_invoice_pdf'); ?>/<?= $invoice_id ?>/view">
              <i class="bx bx-image"></i> 
              <span class="hidden-xs"><?= langg(get_setting($invoice_data['company_id'],'language'),'Open PDF'); ?></span>
          </a>

          <a class="btn downloading_mes_press btn-dark btn-sm me-1 download_complete" href="<?= base_url('invoices/get_invoice_pdf'); ?>/<?= $invoice_id ?>/download">
              <i class="bx bx-image"></i> 
              <span class="hidden-xs"><?= langg(get_setting($invoice_data['company_id'],'language'),'Download PDF'); ?></span>
          </a>
 
    		</div>
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

 

<script type="text/javascript" src="<?= base_url('public'); ?>/js/printThis.js?v=<?= script_version(); ?>"></script> 
<script src="<?= base_url('public/js/jspm'); ?>/zip-full.min.js"></script>
<script src="<?= base_url('public/js/jspm'); ?>/JSPrintManager.js"></script>
<script src="<?= base_url('public/js/jspm'); ?>/html2canvas.min.js"></script>
<script src="<?= base_url('public'); ?>/js/pos_print.js?v=<?= script_version(); ?>"></script>

<script src="<?= base_url('public') ?>/js/htmltoimage.js"></script>
  <script src="<?= base_url('public') ?>/js/canvas2image.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script> 

   <script>
   	$(document).on('click','.downloading_mes_press',function(){
   		$('.downloading_mes').css("display","block");
   		setTimeout(function(){
   			// $('.downloading_mes').css("display","none");
   			$('.down_text').html('Downloaded 👍🏻');

   		},2000);
   	});
   </script>
   <script>  
    $(document).on('click','#create_pdf',function(){
      var filename=$(this).data('filename');
      var invoice_html=$('#pdfthis').html();
      $('body').append('<div id="image_pdf" style="position: fixed;width: 850px;padding: 30px 30px 30px 30px;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div>');

      var div = document.querySelector('#image_pdf');
      var scaleBy = 1.5;
      var w = 860;
      var h = $('#pdfthis').height()+100;
     
      var canvas = document.createElement('canvas');
      canvas.width = w * scaleBy;
      canvas.height = h * scaleBy;
      canvas.style.width = w + 'px';
      canvas.style.height = h + 'px';
      var context = canvas.getContext('2d');
      context.scale(scaleBy, scaleBy);

      html2canvas(div, {
          canvas:canvas,
          useCORS: true,
          onrendered: function (canvas) {
              var width = canvas.width;
                  var height = canvas.height;
                  var millimeters = {};
                  millimeters.width = Math.floor(width * 0.264583);
                  millimeters.height = Math.floor(height * 0.264583);

                  var imgData = canvas.toDataURL(
                      'image/png');
                  var doc = new jsPDF("p", "mm", "a4");
                  doc.deletePage(1);
                  doc.addPage(millimeters.width, millimeters.height);
                  doc.addImage(imgData, 'PNG', 0, 0);
                  doc.save(filename+'.pdf');
                  $('#image_pdf').remove();
          }
      });
  });
</script> 


<script>  
    $(document).on('click','#create_pdf_receipt',function(){
      var filename=$(this).data('filename');
      var invoice_html=$('#pdfthis').html();
      $('body').append('<div id="image_pdf_receipt" style="position: fixed;width: 850px;padding: 30px 30px 30px 30px;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div>');

      var div = document.querySelector('#image_pdf_receipt');
      var scaleBy = 1.5;
      var w = 860;
      var h = $('#pdfthis').height()+100;
     
      var canvas = document.createElement('canvas');
      canvas.width = w * scaleBy;
      canvas.height = h * scaleBy;
      canvas.style.width = w + 'px';
      canvas.style.height = h + 'px';
      var context = canvas.getContext('2d');
      context.scale(scaleBy, scaleBy);

      html2canvas(div, {
          canvas:canvas,
          useCORS: true,
          onrendered: function (canvas) {
              var width = canvas.width;
                  var height = canvas.height;
                  var millimeters = {};
                  millimeters.width = Math.floor(width * 0.264583);
                  millimeters.height = Math.floor(height * 0.264583);

                  var imgData = canvas.toDataURL(
                      'image/png');
                  var doc = new jsPDF("p", "mm", "a4");
                  doc.deletePage(1);
                  doc.addPage(millimeters.width, millimeters.height);
                  doc.addImage(imgData, 'PNG', 0, 0);
                  doc.save(filename+'.pdf');
                  $('#image_pdf_receipt').remove();
          }
      });
  });
</script> 

<script type="text/javascript">

  $(document).on('click','#make_image',function(){
    var filename=$(this).data('filename');
    var invoice_html=$('#pdfthis').html();
    $('body').append('<div id="image_pdf" style="position: fixed;width: 850px;padding: 30px 30px 30px 30px;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div>');

    var div = document.querySelector('#image_pdf');
    var scaleBy = 3;
    var w = 860;
    var h = $('#pdfthis').height()+100;
   
    var canvas = document.createElement('canvas');
    canvas.width = w * scaleBy;
    canvas.height = h * scaleBy;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    var context = canvas.getContext('2d');
    context.scale(scaleBy, scaleBy);

    html2canvas(div, {
        canvas:canvas,
        useCORS: true,
        onrendered: function (canvas) {
            theCanvas = canvas;
            // document.body.appendChild(canvas);

            Canvas2Image.saveAsPNG(canvas);
            // $(body).append(canvas);
            $('#image_pdf').remove();
        }
    });
  });



</script>


<script type="text/javascript">

  $(document).on('click','#make_image_receipt',function(){
    var filename=$(this).data('filename');
    var invoice_html=$('#pdfthis').html();
    $('body').append('<div id="image_pdf_receipt" style="position: fixed;width: 850px;padding: 30px 30px 30px 30px;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div>');

    var div = document.querySelector('#image_pdf_receipt');
    var scaleBy = 3;
    var w = 860;
    var h = $('#pdfthis').height()+100;
   
    var canvas = document.createElement('canvas');
    canvas.width = w * scaleBy;
    canvas.height = h * scaleBy;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    var context = canvas.getContext('2d');
    context.scale(scaleBy, scaleBy);

    html2canvas(div, {
        canvas:canvas,
        useCORS: true,
        onrendered: function (canvas) {
            theCanvas = canvas;
            // document.body.appendChild(canvas);

            Canvas2Image.saveAsPNG(canvas);
            // $(body).append(canvas);
            $('#image_pdf_receipt').remove();
        }
    });
  });



</script>

<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url: "<?= base_url('invoices/get_invoice'); ?>/<?= $invoice_id ?>",
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