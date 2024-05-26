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
                    <b class="page_heading text-dark">Appointments</b>
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
<?php 
    function appoints(){
        $arrr=[
            [
                'name'=>'Dental department',
                'duration'=>'30:00',
                'images'=>[ 
                        'url'=>'https://i.pravatar.cc/150?img=1',
                        'name'=>'Nazriya Nazim'
                    
                ],
                'meetings'=>'2',
                'total_meetings'=>'36',
            ],
            [
                'name'=>'Orthopedic surgeon',
                'duration'=>'1:00',
                'images'=>[ 
                        'url'=>'https://i.pravatar.cc/150?img=11',
                        'name'=>'Ganesh Bhat'
                  
                ],
                'meetings'=>'45',
                'total_meetings'=>'150',
            ],
            [
                'name'=>'Cardiothoracic Department',
                'duration'=>'15:00',
                'images'=>[ 
                        'url'=>'https://i.pravatar.cc/150?img=3',
                        'name'=>'Murali Kumar'
                    
                ],
                'meetings'=>'0',
                'total_meetings'=>'10',
            ],
            [
                'name'=>'Plastic surgeon',
                'duration'=>'9:00',
                'images'=>[ 
                        'url'=>'https://i.pravatar.cc/150?img=4',
                        'name'=>'John Abrahm'
                   
                ],
                'meetings'=>'6',
                'total_meetings'=>'25',
            ]

        ];
        return $arrr;
    }
 ?>
<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">
    <div class="d-flex">
          
        <a href="<?= base_url('appointments') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-home"></i> <span class="my-auto">Appointments</span></a>

        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer   " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-calendar"></i> Bookings
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/book_resources') ?>">
                    <span class="">Book resources</span>
                </a>
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/book_persons') ?>">
                    <span class="">Book a person</span>
                </a>  
            </div>
        </div> 

        <a href="<?= base_url('parties_category') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-file"></i> <span class="my-auto">Reports</span></a>



        <div class="dropdown  my-auto me-2">
            <a class="text-dark cursor-pointer font-size-footer   " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-calendar"></i> Configuration
            </a>
            <div class="dropdown-menu" style="">  
                <a class="dropdown-item href_loader" href="<?= base_url('appointments/resources') ?>">
                    <span class="">Resources</span>
                </a>
                 
            </div>
        </div> 


    </div>

    <a href="<?= base_url('appointments/create') ?>" class=" btn-back font-size-footer my-auto ms-2 href_loader"> <span class="">+ New Appointment</span></a>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
        
        <div id="filter" class=" accordion-collapse col-12 border-0 collapse">
            <div class="filter_bar">
                <!-- FILTER -->
                  <form method="get" class="d-flex">
                    <?= csrf_field(); ?>
                    
                      <input type="text" name="display_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Display Name'); ?>" class="form-control form-control-sm filter-control ">
                    
     
                      <select class="form-control form-control-sm" name="party_type">
                          <option value="">Type</option>
                          <option value="customer">Customer</option>
                          <option value="vendor">Vendor</option>
                          <option value="delivery">Delivery</option>
                          <option value="seller">Seller</option>
                      </select> 
                     
                      <button class=" btn-dark btn-sm"><?= langg(get_setting(company($user['id']),'language'),'Filter'); ?></button>
                      <a class=" btn-outline-dark btn btn-sm" href="<?= base_url('customers') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
                    
                    
                  </form>
                <!-- FILTER -->
            </div>  
        </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 
        <table class="appointments_table">
            <?php $slno=0; foreach (appoints() as $aps): $slno++; ?> 
            <tr class="ap_tr" style="background: <?php echo ($slno % 2 == 0) ? "white" : "#ffffff54"; ?>;">
                <td>
                    <h6><?= $aps['name'] ?></h6>
                </td>
                <td>
                    <div class="duration">
                        <div class="time-span"><?= $aps['duration'] ?> minutes</div>
                        <div class="time-head">Duration</div>
                    </div>
                </td>
                <td>
                    <div class="d-flex">
                        <img src="<?= $aps['images']['url'] ?>" class="me-2 res_per_img"> 
                        <div class="my-auto"><?= $aps['images']['name'] ?></div>
                    </div>
                </td>
                <td>
                    <div class="duration">
                        <div class="time-span"><?= $aps['meetings'] ?> meetings</div>
                        <div class="time-head">Scheduled</div>
                    </div>
                </td>
                <td>
                    <div class="duration">
                        <div class="time-span"><?= $aps['total_meetings'] ?> Total meetings</div>
                        <div class="time-head">(Last 30 days)</div>
                    </div>
                </td>
                <td class="app_padding">
                    <div class="dropdown dropdown-animated ">
                        <a class="text-dark cursor-pointer font-size-footer ms-2 my-auto " href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-cog"></i> Action
                        </a>
                        <div class="dropdown-menu" style="">  
                            <a class="dropdown-item href_loader" href="http://localhost/aitsun-erp/products/manufacture/create_raw_materials/18675">
                                <span class="">Orders</span>
                            </a>
                            <a class="dropdown-item href_loader" href="http://localhost/aitsun-erp/products/manufacture/create_raw_materials/18675">
                                <span class="">Sales</span>
                            </a> 
                            <a class="dropdown-item href_loader" href="http://localhost/aitsun-erp/products/manufacture/create_raw_materials/18675">
                                <span class="">Session report</span>
                            </a> 
                        </div>
                    </div>
                
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->



<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-between">
    <div>
        <a href="<?= base_url('app_info') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-info-circle"></i> <span class="my-auto">App info</span></a>
        <a href="<?= base_url('tutorial_coming_soon') ?>" class="href_loader text-dark font-size-footer"><i class="bx bx-right-arrow ms-2"></i> <span class="my-auto">Tutorial</span></a>
    </div>
    <div class="aitsun_pagination">  
      
    </div>
</div> 
<!-- ////////////////////////// PAGE FOOTER END ///////////////////////// -->


 