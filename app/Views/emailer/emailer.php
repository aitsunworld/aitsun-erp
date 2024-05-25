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
                    <b class="page_heading text-dark">E-Mailer</b>
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
<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row">
        <div class="container">
             <div class="row">
                <form method="post" id="send_email_form" >
                    <?= csrf_field() ?>
                    <div class="col-md-12 mb-2">
                      

                       <div class="form-group"> 
                        <label class="form-label">Email To:</label>
                            <div class="input-box mt-0 input_tag_css mb-0"> 
                                <input type="email" class="form-control input_tag_css tags_input input-1" name="email_to" id="email_to" placeholder="Email Address: Type & Hit Enter" data-role="tagsinput" onfocus="setFocus(true)" onblur="setFocus(false)">
                            </div> 
                            <div id="emailmsg"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                       <div class="form-group">
                        <label class="form-label">Subject:</label>
                        <input type="text" name="email_subject" id="email_subject" class="form-control">
                        <div id="em_sub_msg"></div>
                       </div>
                    </div>

                    <div class="col-md-12 mb-2">
                       <div class="form-group">
                        <label class="form-label">Email Template Code:</label>
                        <textarea name="email_template" rows="10" id="email_template" cols="50" class="form-control"></textarea>
                        <div id="em_temp_msg"></div>
                       </div>
                    </div>
                    <div class="col-md-12 text-center">
                       <button type="button" class="aitsun-primary-btn w-25" id="send_email">Send</button>
                    </div>

                    <div id="suc_msg" class="mt-3">                  
                    </div>
               </form>

           </div>
        </div>
     </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->

