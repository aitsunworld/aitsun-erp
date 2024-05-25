<?php 
            $uri = new \CodeIgniter\HTTP\URI(str_replace('index.php','',current_url()));
         ?>
 

    <div class="settings_sidebar">
        <div class="aitsun_side_bar">
            <ul>
            <h6 class="mb-3">Options</h6>

                <li class="<?= ($uri->getSegment(sn4())=='') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-link-external'></i></div>
                        <div class="icon-title">Site Details</div>
                    </a>
                </li>  


                <li class="<?= ($uri->getSegment(sn4())=='enquiries') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/enquiries'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-comment-check'></i></div>
                        <div class="icon-title">Enquiries</div>
                    </a>
                </li>

                <li class="<?= ($uri->getSegment(sn4())=='posts') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/posts'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-package'></i></div>
                        <div class="icon-title">Posts</div>
                    </a>
                </li>



                <li class="<?= ($uri->getSegment(sn4())=='categories') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/categories'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-category'></i></div>
                        <div class="icon-title">Categories</div>
                    </a>
                </li>

                <li class="<?= ($uri->getSegment(sn4())=='clients') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/clients'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-outline'></i></div>
                        <div class="icon-title">Clients</div>
                    </a>
                </li>  
 

                <li class="<?= ($uri->getSegment(sn4())=='social_media') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/social_media'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-message-rounded-dots'></i></div>
                        <div class="icon-title">Social Media</div>
                    </a>
                </li> 


                <li class="<?= ($uri->getSegment(sn4())=='email_integration') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/email_integration'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-mail-send'></i></div>
                        <div class="icon-title">Email Integration</div>
                    </a>
                </li>  


                <li class="<?= ($uri->getSegment(sn4())=='reviews') ? 'active' : '' ?>">
                    <a href="<?= base_url('website_management/reviews'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-star'></i></div>
                        <div class="icon-title">Reviews</div>
                    </a>
                </li>  


                             

                

            </ul>

        </div>
    </div>


