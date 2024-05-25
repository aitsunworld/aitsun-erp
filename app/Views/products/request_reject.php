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
                    <a href="<?= base_url('products'); ?>" class="href_loader">Products</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Rejected Request</b>
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

<div class="main_page_content">
    <div class="sidebar_for_request">
        <div class="">
            <ul>
            <!-- <h6 class="mb-3">Product Request</h6> -->

                <li>
                    <a href="<?= base_url('products/requests'); ?>" class="href_loader active">
                        <div class="icon_parent"><i class='bx bx-question-mark'></i></div>
                        <div class="">All Request</div>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('products/requests-approved'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-check-double'></i></div>
                        <div class="">Arranged</div>
                    </a>
                </li>

                
                <li>
                    <a href="<?= base_url('products/requests-rejetcted'); ?>" class="href_loader">
                        <div class="icon_parent"><i class='bx bx-error'></i></div>
                        <div class="">Rejected</div>
                    </a>
                </li>

                
               
            </ul>

        </div>
    </div>




    <div class="rquest_margin">
        <?php $i=0; foreach ($product_data as $pr ): $i++; ?>
        <div class="row">
            
       
        <div class="col-md-2">
            <div class="">
               <p class="mb-0 text-facebook aitsun-fw-bold">
                    <?php if ($pr['type']=='quote'): ?>
                      <?= $pr['name']; ?>
                    <?php else: ?>
                     <a href="<?= base_url('customers/details') ?>/<?= $pr['user_id']; ?>"><?= user_name($pr['user_id']); ?></a>
                    <?php endif ?>
                </p>
            </div>
        </div>


            <div class="col-md-10">
                <div class="row">
                    
                
                <div style="" class="my-auto col-md-9">
                    <?php
                    $totalitems=count(pro_request_items_array($pr['id'],'unlimited'));
                     foreach (pro_request_items_array($pr['id'],'1') as $pit ): 
                    ?>
                        

                        <div class="">
                            <a class="btn-link cursor-pointer text_over_flow_1" style="text-decoration: none; color: black;" data-bs-toggle="collapse"  data-bs-target="#product_rq_list<?= $pr['id']; ?>"> 
                            <?php if ($totalitems>1): ?>
                                    <?= $totalitems-1; ?> more items
                                <?php else: ?>
                                    <?= $pit['product_name']; ?>
                                <?php endif ?>
                            </a>
                        </div>
                    <?php endforeach; ?>


                </div>
            
                <div style="" class="col-md-3 text-end">
                    <small class="text-muted my-auto" style="font-size: 12px;"><?= get_date_format($pr['datetime'],'d M Y h:i a'); ?></small>
                </div>


                            <div id="product_rq_list<?= $pr['id']; ?>" class=" accordion-collapse col-12 border-0 collapse">
                        <div>
                            <?php foreach (pro_request_items_array($pr['id'],'unlimited') as $pit ): ?>

                            <div class="p-2 mb-3" style="border: 1px solid #3b599830; border-radius: 5px; box-shadow: 1px 4px 3px 0px #3b59984f;">

                                <div class="mt-2">
                                    <div class="d-flex justify-content-between ">
                                        <h6 class="card-title text-facebook mb-0">#<?= $pr['id']; ?></h6>

                                        <?php if ($pr['type']=='quote'): ?>
                                            <span class=" px-2 rounded " style="font-size: 12px;border: 1px solid; color: #0a8a97;">Quote</span>
                                        <?php elseif($pr['type']=='request'): ?>
                                            <span class=" px-2 rounded " style="font-size: 12px;border: 1px solid; color: #0a8a97;">Request</span>
                                        <?php endif ?>
                                    </div>
                                </div>

                                <hr>
                                <p class=" mb-2 mt-2" style="font-size:14px;font-weight: 500; ">
                                    
                                      <?= $pit['product_name']; ?>
                                    
                                </p>
                                
                                <p class=" mb-0" style="font-size:15px;">
                                    <span>QTY : <strong class="text-facebook"><?= $pit['quantity']; ?></strong></span>
                                </p>

                                <span>
                                    <?php if ($pr['type']=='quote'): ?>
                                    <span><a href="mailto:<?= $pr['email']; ?>"><i class="bx bx-envelope-open"></i> : <?= $pr['email']; ?></a></span><br>
                                    <span><a href="tel:<?= $pr['phone']; ?>"><i class="bx bx-phone-outgoing"></i> : <?= $pr['phone']; ?></a></span><br>
                                    <span><?= $pr['description']; ?></span>
                                    <?php else: ?>
                                      <?= $pr['description']; ?>
                                    <?php endif ?>
                                </span>

                                <hr class="mt-2 mb-2"> 
                                

                           <div class="">

                        
                                  <?php if ($pr['status']=='arranged'): ?>
                                  <div class="text-center">
                                    <span style="color: green;">Arranged</span>
                                  </div>
                                  <?php elseif($pr['status']=='rejected'): ?>
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item request_reject">
                                        <h6 class="accordion-header text-center" id="headingTwo3<?= $pr['id']; ?>">
                                          <button class="btn btn-link collapsed custom-accordion-button p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse33<?= $pr['id']; ?>" aria-expanded="false" aria-controls="collapse33<?= $pr['id']; ?>" style="font-size: 13px; text-decoration: none; color: gray;"><span style="color:red">Rejected <i class="bx bx-error-alt" style="font-size:14px;color: red;"></i></span>
                                          </button>
                                        </h6>
                                                <div id="collapse33<?= $pr['id']; ?>" class="collapse" aria-labelledby="headingTwo3<?= $pr['id']; ?>" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body px-0 py-1">
                                                        <p class="mb-0"><?= $pr['reason']; ?></p>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                  <?php else: ?>
                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-sm aitsun-primary-btn product_arrange" data-url="<?= base_url('products/requested_arranged') ?>/<?=  $pr['id']; ?>">Arrange</a>

                                        <a class="ms-2 btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_reason<?=  $pr['id']; ?>">Reject</a>

                                        <!-- <a class="ms-2 btn btn-sm btn-danger w-100 product_reject" data-url="<= base_url('products/requested_not_available') ?>/<?= $pr['id']; ?>">Reject</a> -->
                                    </div>
                                    <?php endif ?>

                            <!-- Modal -->
                                <div class="modal fade" id="reject_reason<?=  $pr['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reason</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form id="add_reject_reson<?= $pr['id']; ?>"  method="post" action="<?= base_url('products/requested_not_available') ?>/<?= $pr['id']; ?>">
                                                <?= csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="reason" id="reason<?=  $pr['id']; ?>" rows="3" required></textarea>
                                                    <div id="error_mes<?=  $pr['id']; ?>" class="mt-1"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer ">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary product_reject" data-prorqid="<?= $pr['id'];?>">Save changes</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <!-- Modal -->
                                
                                
                            </div>

                                        </div>
                                        
                                    <?php endforeach ?>

                                    <?php if ($i==0): ?>
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <h4 class="m-5 text-danger">No Requests </h4>
                                            </div>
                                        </div>
                                    <?php endif ?>
                        </div> 
                    </div>

            </div>
            </div>

        </div>

        <hr>



        <?php endforeach; ?>

         
    </div>
</div>



<div class="sub_footer_bar d-flex justify-content-between">
    
        <div class="my-auto">
            <form method="post">
                <?= csrf_field(); ?>
                <button type="submit" class="text-dark btn font-size-footer me-2" name="get_excel"> 
                    <span class="my-auto">Excel</span>
                </button>
            </form>
        </div>
    
    
    
</div> 