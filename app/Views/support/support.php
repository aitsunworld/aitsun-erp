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
                    <b class="page_heading text-dark">Support Center</b>
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

<div style="text-align: center;width: 100%;height: 100vh;display: flex;">
    <div style="margin: auto;">
        <div>
            <h1 class="main-text">
                How can we help?
            </h1>
            <h6 style="margin-top: 1.5rem;">If you need any help, come chat with us</h6>
            <img class="img-width" src="<?= base_url('public') ?>/images/support.webp" alt="">

            <div class="d-flex">
                <div class="new-menu">
                     
                    <div class="main-menu text-dark cursor-pointer">
                        <img src="<?= base_url('public/images/email.webp') ?>" class="img-main">
                        <a href="mailto:<?= email_support(company($user['id'])) ?>" style="color:#2c3e65"><b class="mt-1" style="font-size: 17px;"><?= email_support(company($user['id'])) ?></b></a>
                        
                    </div>

                     <div class="main-menu text-dark cursor-pointer" >
                        <img src="<?= base_url('public/images/phone.webp') ?>" class="img-main">

                        <a  href="tel:<?= call_support(company($user['id'])) ?>" style="color:#2c3e65"><b class="mt-1" style="font-size: 17px;"><?= call_support(company($user['id'])) ?></b></a>
                    
                       
                    </div>

                    <div class="main-menu text-dark cursor-pointer" >
                        <img src="<?= base_url('public/images/whatsapp.webp') ?>" class="img-main">

                        <a  href="https://wa.me/<?= call_support(company($user['id'])) ?>" style="color:#2c3e65"><b class="mt-1" style="font-size: 17px;"><?= call_support(company($user['id'])) ?></b></a>
                    
                       
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>




<style type="text/css">
    .main-text {
        font-weight: 600;
        letter-spacing: normal;
        font-size: 3rem;
        margin-top: 0;
        margin-bottom: 0;
    }
    .img-width {
        width: 30%;
    }
    .new-menu{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: auto;
    }
    .main-menu{
        text-align: center;
        margin: 20px;
        background: white;
        border-radius: 5px;
        padding: 10px;
        width: 240px;
        box-shadow: 2px 2px 8px 2px #00000021;
        

    }
    .img-main {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }
</style>