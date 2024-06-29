


 

</main>
        

<!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal aitsun-modal fade" id="aitsun_modal"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content" id="aitsun-content">
             
        </div>
    </div>
</div>
<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->

<?php 
    $name_of_page='';
    if (isset($page_name)) {
        $name_of_page=$page_name; 
    } 
  ?> 




       <div class="fade modal modal-fullscreen fade" id="add_new_party_from_selector"  aria-hidden="true">
        <div class=" modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class=" px-0 py-1">
                <!-- //////////////FORMMMMM/////////////////// -->
                  
                  <!-- //////////////FORMMMMM/////////////////// -->
              </div>
            </div>
          </div>
        </div>
      </div>

        <input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
        <input type="hidden" id="app_state" value="<?= APP_STATE ?>"/>

        <div class="nointernetbody d-none" id="nointernetbody">
            <div class="nointernetmiddle m-auto text-center">
                <img  class="nointimg mb-2" src="<?= base_url('public/images/logo_full.png'); ?>" alt="asms" draggable="false">
                <h4 class="mb-2">No Internet Connection</h4>
                <p>You are not connected to the internet. <br>Make sure Wi-Fi is on, Airplane Mode is off and try again.</p>
            </div>
        </div>
 

       

        <!-- ////////////////////////////HIDDEN DATAS//////////////////////////// -->
        <input type="hidden" id="base_url" value="<?= base_url(); ?>">
        <input type="hidden" id="round_of_value" value="<?= get_setting(company($user['id']),'round_of_value'); ?>">
        <input type="hidden" id="current_branch" value="<?= company($user['id']); ?>">

        <input type="hidden" id="loc" value="<?= get_setting(company($user['id']),'loc'); ?>"><input type="hidden" id="base_url" value="<?= base_url(); ?>">
        <input type="hidden" id="loc" value="<?= get_setting(company($user['id']),'loc'); ?>">
        <input type="hidden" id="thermalcheck" value="<?= get_setting(company($user['id']),'print_thermal'); ?>">
        <input type="hidden" value="<?= get_setting(company($user['id']),'printer1'); ?>" id="installedPrinterName">
        <input type="hidden" value="0" id="automatic_share">


         <?php 
            $uri = new \CodeIgniter\HTTP\URI(str_replace('/index.php','',current_url()));
         ?>

    

      <!--   <php if (current_financial_year('financial_from',company($user['id']))!='no_financial_years') { ?> 
            <script type="text/javascript">
                $(document).ready(function(){  
                    $.ajax({
                      url: "<= base_url('accounting_library'); ?>", 
                      success: function(dataResult){ 
                      }
                    }); 
                }); 
            </script> 
        <php } ?> -->

        <script type="text/javascript">
            $(document).ready(function(){  
                $.ajax({
                  url: "<?= base_url('cron_jobs'); ?>", 
                  success: function(dataResult){ 
                  }
                }); 
            }); 
        </script> 

      <div id="asm_toast"></div>
    
<div id="sidebar">  
  <div class="list"> 
       
        <?php 
            foreach (menus_array($user['id'],$user['u_type']) as $side_item) {
                if (!isset($side_item['condition']) || $side_item['condition']) {
        ?>
            <div class="item" onclick="location.href='<?= $side_item["url"] ?>'">
                <img src="<?= $side_item['icon'] ?>" class=" my-auto me-2">
                <?= $side_item['title'] ?>
            </div> 
        <?php
                }
            } 
        ?> 
  </div>  
  <?php 
   
    $is_home=false;
    if (isset($page_name)) {
        if ($page_name=='home') {
            $is_home=true;
        } 
    } 
  ?> 
   
  <?php if ($is_home==false): ?>
      <div class="main_menu_toggler" onclick="toggleSidebar()">
          Main Menu 
      </div>
  <?php endif ?>
         
 <script type="text/javascript">
    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle('active');
    }
</script>   
        
</div>  
    
        <?php 
            $quick_show=true;

            
           

            if ($quick_show) {  
        ?>
 
                

                <?php if (is_school(company($user['id']))): ?>
                <div class="quick_tool">
                    <div class="receipt_q_but ">
                        <a class="no_loader" href="<?= base_url('voucher_entries/add') ?>"><i class="bx bxs-pencil me-2"></i><span class="d-none">Receipt</span></a>
                    </div>
                    <div class="fees_q_but " id="take_fees_btn">
                        <a class="no_loader"><i class="bx bxs-pencil me-2"></i><span class="d-none">Take fees</span></a>
                    </div>
                    <div class="payment_q_but ">
                        <a class="no_loader" href="<?= base_url('voucher_entries/add/expense') ?>"><i class="bx bxs-pencil me-2"></i><span class="d-none">Payment</span></a>
                    </div>


                <div class="quick_menu_container d-flex">
                    <a class="text-white no_loader d-block m-auto" ><i class="bx bx-plus q-plus"></i></a>  
                </div> 

            </div>






              <div class="select_student_container d-none" id="stucontainer">
                  <div class="select_student_center_block">
                      <div class="m-auto text-center position-relative">
                          <label class="d-block text-white">Search student</label>
                          <input type="text" id="student_search_input" class="text-center">

                          <div class="student_suggest">
                              <ul id="sug_ul">
                                    
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="fees_container d-none" id="fees_container">
                  <div class="fees_center_block">

                      <div class="m-auto text-center position-relative" id="fee_show">
                          
                      </div>
                  </div>
              </div>
            <?php endif ?>
             

        <?php }; ?> 

       
       
        <script src="<?= base_url('public'); ?>/js/notify.js"></script>
        <script src="<?= base_url('public/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('public'); ?>/js/sweetalert2.min.js"></script>
    
         
       

        <script type="text/javascript">
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('<?= base_url('service-worker.js'); ?>', {
                    scope: '.' // <--- THIS BIT IS REQUIRED
                }).then(function(registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
            }


           

            // setInterval(function(){
            //     location.href="<?= base_url('sleep_mode') ?>?red=<?= str_replace('/index.php', '', current_url()) ?>"
            // },1000)

            setInterval(function(){
                checkconnection();
            },1000)
     

            function checkconnection() {
                var status = navigator.onLine;
                if (status) {
                    // alert('Internet connected !!');

                    $('#nointernetbody').addClass('d-none');
                    $('#nointernetbody').removeClass('d-flex');
                    
                } else {
                    // alert('No internet Connection !!');
                    $('#nointernetbody').addClass('d-flex');
                    $('#nointernetbody').removeClass('d-none');
                }
            }
        </script>

        <?php if (SLEEP_MODE==true): ?>
            <script type="text/javascript">
                 setInterval(function(){
                    location.href="<?= base_url('sleep_mode') ?>?red=<?= str_replace('/index.php', '', current_url()) ?>"
                },1800000)
            </script>
        <?php endif ?>
<!-- 1800000 -->
        <script src="<?= base_url('public'); ?>/js/pos_print.js?v=<?= script_version(); ?>"></script>

         <script src="<?= base_url('public'); ?>/js/printThis.js?v=<?= script_version(); ?>"></script>

         <script src="<?= base_url('public') ?>/js/canvas2image.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script> 

   <script>  
    $(document).on('click','#create_pdf',function(){
      var filename=$(this).data('filename');
      var invoice_html=$('#pdfthis').html();
      $('body').append('<div style="opacity:0;"><div id="image_pdf" style="position: fixed;width: 850px;padding: 0;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div></div>');

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
      $('body').append('<div style="opacity:0;"><div id="image_pdf_receipt" style="position: fixed;width: 850px;padding: 30px 30px 30px 30px;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div></div>');

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

<?php 
  $make_image_invoice_quality=3;
  $make_image_receipt_quality=3;

  if (get_setting(company($user['id']),'make_image')>0) {
     $make_image_invoice_quality=get_setting(company($user['id']),'make_image');
  }

  if (get_setting(company($user['id']),'make_image_receipt')>0) {
     $make_image_receipt_quality=get_setting(company($user['id']),'make_image_receipt');
  }

 ?>

<script type="text/javascript">

  $(document).on('click','#make_image',function(){
    var filename=$(this).data('filename');
    var invoice_html=$('#pdfthis').html();
    $('body').append('<div style="opacity:0;"><div id="image_pdf" style="position: fixed;width: 850px;padding: 0;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div></div>');

    var div = document.querySelector('#image_pdf');
    var scaleBy = <?= $make_image_invoice_quality; ?>;
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
            // $('#image_pdf').remove();
        }
    });
  });



</script>


<script type="text/javascript">

  $(document).on('click','#make_image_receipt',function(){
    var filename=$(this).data('filename');
    var invoice_html=$('#pdfthis').html();
    $('body').append('<div style="opacity:0;"><div id="image_pdf_receipt" style="position: fixed;width: 850px;padding: 30px 30px 30px 30px;background: white;height: max-content;z-index: 15;top: 0;">'+invoice_html+'</div></div>');

    var div = document.querySelector('#image_pdf_receipt');
    var scaleBy = <?= $make_image_receipt_quality; ?>;
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



<script src="<?= base_url('public'); ?>/js/sortable.js"></script> 
<script src="<?= base_url('public'); ?>/js/tableexport.min.js"></script>  
 <script src="<?= base_url('public'); ?>/js/custom.js?v=<?= script_version(); ?>"></script>
     <script src="<?= base_url('public'); ?>/js/common.js?v=<?= script_version(); ?>"></script>
     <script src="<?= base_url('public'); ?>/js/pdf.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/custom_erp.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/custom_erp_additional.js?v=<?= script_version(); ?>"></script>


 
 
<?php if ($name_of_page=='pos'): ?>
   <script src="<?= base_url('public'); ?>/js/pos_index.js?v=<?= script_version(); ?>"></script>
<?php endif ?>



<script src="<?= base_url('public'); ?>/js/appoinments.js?v=<?= script_version(); ?>"></script>




<script src="<?= base_url('public'); ?>/js/payroll.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/tags.js?v=<?= script_version(); ?>"></script>
<script src="<?= base_url('public'); ?>/js/jspdf/jspdf.umd.min.js?v=<?= script_version(); ?>"></script>

<script src="<?= base_url('public'); ?>/js/bundles/knob.bundle.js"></script><!-- Custom Js -->
<script src="<?= base_url('public'); ?>/js/bundles/index2.js"></script>
<script src="<?= base_url('public'); ?>/js/bundles/jvectormap.bundle.js"></script>
<script src="<?= base_url('public'); ?>/js/bundles/morrisscripts.bundle.js"></script>
 

<script src="<?= base_url('public'); ?>/js/jquery-validation/jquery.validate.min.js"></script>


<script src="<?= base_url('public/js/lozad.js') ?>"></script>

 

  <script type="text/javascript">
    $(".tags_input").tagsinput('items');
    // toastr.options = {
    //     "progressBar": true,
    //     "timeOut": "1500"
    // }
    // Initialize library to lazy load images
    var observer = lozad('.lozad', {
        threshold: 0.1,
        enableAutoReload: true,
        load: function(el) {
            el.src = el.getAttribute("data-src");
            el.onload = function() {
              el.classList.add('imfade')
                // toastr["success"](el.localName.toUpperCase() + " " + el.getAttribute("data-index") + " lazy loaded.")
            }
        }
    })

    // Picture observer
    // with default `load` method
    var pictureObserver = lozad('.lozad-picture', {
        threshold: 0.1
    })

    window.onload = function () {
        setTimeout(function () {
            // document.querySelector('#mutativeImg1').dataset.src = 'images/thumbs/02.jpg'
            // document.querySelector('#mutativeImg2').dataset.src = 'images/thumbs/02.jpg'
            // toastr["success"]("Once data-src change, the element render again.")
        }, 3000)
    }
    // Background observer
    // with default `load` method
    var backgroundObserver = lozad('.lozad-background', {
        threshold: 0.1
    })

    observer.observe()
    pictureObserver.observe()
    backgroundObserver.observe()

    </script>


    <script src="<?= base_url('public'); ?>/js/timepicker.js"></script>
<script>
$(document).ready(function(){
  $('.timepicker').timepicker({
        showInputs: false
    });
  $('body').click(function(event) {
     $('.timepicker').timepicker({
        showInputs: false
    })
  });
  
});
</script>


<script type="text/javascript">

      $(document).on('change','.custom-click',function() {
        filename = this.files[0].name;
        $(this).siblings('.custom-file-label').html(filename);
      });

        $(document).on('change','.date_of_birth',function(){

          var bxid=$(this).data('bxid');

          var today = new Date();
          var birthDate = new Date($('#date_of_birth'+bxid).val());
          var age = today.getFullYear() - birthDate.getFullYear();
          var m = today.getMonth() - birthDate.getMonth();
          if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
              age--;
          }
         return $('#age'+bxid).val(age);
         
      });

   </script>

   <?php if ($_GET): ?>
       <?php if (isset($_GET['trigger-modal'])): ?>
            <script type="text/javascript">
               $(document).ready(function() {
                   $('#<?= $_GET['trigger-modal'] ?>').modal('show');
               }); 
            </script>  
       <?php endif ?>
   <?php endif ?>




    </body>
</html>