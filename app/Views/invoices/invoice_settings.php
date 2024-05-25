<!-- ////////////////////////// TOP BAR START ///////////////////////// -->
<div class="sub_topbar d-flex">
    <div class="right_bar d-flex justify-content-between w-100">
      
         <a class="my-auto ait-ms-2 href_loader cursor-pointer font-size-topbar go_back_or_close text-aitsun-red " title="Back">
            <i class="bx bx-arrow-back"></i>
        </a>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb aitsun-breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>"><i class="bx bx-home-alt text-aitsun-red"></i></a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url('invoices/sales'); ?>">Invoices</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Invoice Settings</b>
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
 <form method="post" enctype="multipart/form-data" action="<?= base_url('save_invoice_settings') ?>/<?= $invoice_type ?>">
            <?= csrf_field(); ?>
<div class="main_page_content pb-5">

        

        
       

            <input type="hidden" name="invoice_type" value="<?= $invoice_type; ?>">
            
            <div class="col-md-12 row m-0">

                <div class="ps-0 form-group col-md-3">
                    <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Select Page Size'); ?></label>
                    <select class="form-control form-control-sm"name="invoice_page_size">
                        <option value="a4" <?php if (get_setting2(company($user['id']),'invoice_page_size') == 'a4') {echo 'selected';} ?>>A4</option>
                        <option value="a5" <?php if (get_setting2(company($user['id']),'invoice_page_size') == 'a5') {echo 'selected';} ?>>A5</option>
                        <option value="a3" <?php if (get_setting2(company($user['id']),'invoice_page_size') == 'a3') {echo 'selected';} ?>>A3</option>
                    </select>
                </div>

                <div class="ps-0 form-group col-md-3">
                    <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'PDF Scale'); ?></label>
                    <input type="number" min="0.1" max="2" step="any" class="form-control" name="pdf_scaling" value="<?= get_setting2(company($user['id']),'pdf_scaling'); ?>" style="height: 35px;">
                </div>


                <div class="ps-0 form-group col-md-3">
                    <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Select Orientation'); ?></label>
                    <select class="form-control form-control-sm"name="invoice_orientation">
                        <option value="portrait" <?php if (get_setting2(company($user['id']),'invoice_orientation') == 'portrait') {echo 'selected';} ?>>Portrait</option>
                        <option value="landscape" <?php if (get_setting2(company($user['id']),'invoice_orientation') == 'landscape') {echo 'selected';} ?> >Landscape</option>
                        
                    </select>
                </div>

                <div class="ps-0 form-group col-md-3 mb-3">
                    <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Background Color'); ?></label>
                    <input type="color" class="form-control" name="invoice_color" id="input-1" value="<?= get_setting(company($user['id']),'Invoice_color'); ?>" style="height: 35px;">
                </div>

                <div class="ps-0 pe-0 form-group col-md-3 mb-3">
                    <label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Font Color'); ?></label>
                    <input type="color" class="form-control" name="invoice_font_color" id="input-1" value="<?= get_setting(company($user['id']),'invoice_font_color'); ?>" style="height: 35px;">
                </div>
           

           </div>
           

            
       
        
     


<div class="mt-3">
  <ul class="nav nav-tabs" role="tablist">

    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='sales'){echo 'active';} ?> " href="<?= base_url('invoice_settings/sales'); ?>">Sales</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='proforma_invoice'){echo 'active';} ?> " href="<?= base_url('invoice_settings/proforma_invoice'); ?>">Proforma Invoice</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='sales_quotation'){echo 'active';} ?> " href="<?= base_url('invoice_settings/sales_quotation'); ?>">Sales Quotation</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link " href="<?= base_url('invoice_settings/sales_order'); ?>">Sales Order</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='sales_delivery_note'){echo 'active';} ?> " href="<?= base_url('invoice_settings/sales_delivery_note'); ?>">Delivery Note</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='sales_return'){echo 'active';} ?> " href="<?= base_url('invoice_settings/sales_return'); ?>">Sales Return</a>
    </li>

    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='purchase'){echo 'active';} ?> " href="<?= base_url('invoice_settings/purchase'); ?>">Purchase</a>
    </li>

    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='purchase_order'){echo 'active';} ?> " href="<?= base_url('invoice_settings/purchase_order'); ?>">Purchase Order</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='purchase_delivery_note'){echo 'active';} ?> " href="<?= base_url('invoice_settings/purchase_delivery_note'); ?>">Delivery Note</a>
    </li>
    <li class="nav-item">
      <a class="nav-link aitsun_link <?php if ($invoice_type=='purchase_return'){echo 'active';} ?> " href="<?= base_url('invoice_settings/purchase_return'); ?>">Purchase Return</a>
    </li>
  </ul>

  

  <!-- Tab panes -->
  <div class="tab-content p-2 pb-5" style="background: #fff;">
    <div id="" class="tab-pane active"><br>
        <div class="settings_form_container">
            
        </div>
    </div>



    
  </div>
</div>







</div>

<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div id="">
        <button type="submit" class="save_invoice_set aitsun-primary-btn w-100">Save</button>
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
</form>

<script type="text/javascript">
    $(document).ready(function(){
        
        $.ajax({
              url:"<?= base_url('settings/get_form')?>/<?= $invoice_type; ?>",
              success:function(response) {
                $('.settings_form_container').html(response);
         
             }
        });
    });

</script>



<style type="text/css">
#mybutton {
  position: fixed;
  top: 45px;
  right: 15px;
}
</style>