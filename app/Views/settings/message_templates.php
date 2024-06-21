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
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Message templates</b>
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



<div class="main_page_content ">
    <?= view('settings/settings_sidebar') ?>
    <div class="row setting_margin">
          
        <!-- Inventory share -->
        <div class="col-md-12" >
            <h6 class="text-aitsun-red">Inventory share</h6>    
        </div>

        <div class="form-group col-md-6 mb-3">
            <label for="input-5" class="form-label d-block"><b><i class="lni lni-envelope text-danger"></i></b> Email</label>
            <input type="text" name="subject" class="message_template_update form-control mb-2" data-template_name="" data-element_name="" placeholder="Subject">
            <textarea rows="5" name="message" class="message_template_update form-control" placeholder="Message"></textarea>
        </div> 

        <div class="form-group col-md-6 mb-3">
            <label for="input-5" class="form-label d-block"><b><i class="lni lni-whatsapp text-success"></i></b> WhatsApp</label>
            <input type="text" name="subject" class="message_template_update form-control mb-2" placeholder="Subject">
            <textarea rows="5" name="message" class="message_template_update form-control" placeholder="Message"></textarea>
        </div> 
        <hr>
         
    </div>
</div>