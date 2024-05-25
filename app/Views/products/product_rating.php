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
                    <b class="page_heading text-dark">Produts Rating</b>
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



<!-- ////////////////////////// TOOL BAR START ///////////////////////// -->
<div class="toolbar d-flex justify-content-between">

        <div class="my-auto">
            <a class="my-auto text-dark font-size-footer me-2" data-bs-toggle="modal" data-bs-target="#rate<?= $pro['id']; ?>">
                <span class="my-auto">+ Rate</span>
            </a>
        </div>

        <div class=" my-auto">
            <div class="btn-group" role="group" aria-label="Basic example">
                <?php if (next_product($pro['id'],'prev',company($user['id']))!='no product'): ?>
                    <a href="<?= base_url('products/product_rating') ?>/<?= next_product($pro['id'],'prev',company($user['id'])); ?>" class="aitsun-primary-btn-topbar  font-size-footer font-size href_loader me-1">
                        <i class="bx bx-left-arrow"></i> Prev
                    </a>
                <?php endif ?>
                <?php if (next_product($pro['id'],'next',company($user['id']))!='no product'): ?>
                    <a href="<?= base_url('products/product_rating') ?>/<?= next_product($pro['id'],'next',company($user['id'])); ?>" class="aitsun-primary-btn-topbar  font-size-footer font-size href_loader">
                    Next
                    <i class="bx bx-right-arrow"></i> 
                </a>
                <?php endif ?>
            
            </div>
        </div>
            
    
        
    </div>




<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->


<div class="sub_main_page_content">

    <div class="row ">
        <div class="col-12 col-lg-12 col-md-12">
            
            <h6 class=" my-auto text-uppercase text_over_flow1 mb-3"><?= $pro['product_name']; ?></h6>
            


            <!-- ////////////////////////////////PRODUCT RATING MODAL///////////////////////////////// -->

            <div class="modal fade aitsun-modal" id="rate<?= $pro['id']; ?>"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $pro['product_name']; ?></h5>
                            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                  
                            </button>
                        </div>
                        <form method="post" action="<?= base_url('products/add_rate'); ?>/<?= $pro['id']; ?>">
                        <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-12 pb-3">
                                        <label for="input-4" class="">Rating</label>
                                        <div id="full-stars-example-two">
                                            <div class="rating-group">
                                                <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
                                                <label aria-label="1 star" class="rating__label" for="rating3-1"><i style="color:orange;" class="rating__icon rating__icon--star bx bxs-star"></i></label>

                                                <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                                                <label aria-label="2 stars" class="rating__label" for="rating3-2" checked><i class="rating__icon rating__icon--star bx bxs-star"></i></label>

                                                <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                                                <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star bx bxs-star"></i></label>

                                                <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                                                <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star bx bxs-star"></i></label>

                                                <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                                                <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star bx bxs-star"></i></label>

                                                <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                                            </div>
                                        </div>                                  
                                    </div>
                                

                                    <div class="form-group col-md-12 pb-3">
                                        <label for="input-4" class="">Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="input-4" class="">review</label>
                                        <textarea rows="5" name="review" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="aitsun-primary-btn spinner_btn" name="save_rate">Save Rating</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- ////////////////////////////////PRODUCT RATING MODAL///////////////////////////////// -->

    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="rating_table" class="erp_table">
             <thead>
                <tr>
                    <th>User Name</th>
                    <th>Rating</th>
                    <th>Review</th> 
                    <th>Date</th> 
                    <th>Action</th> 
                   
                </tr>
             
             </thead>
              <tbody>
                <?php if (count($reviess)==0): ?>
                      <tr>
                        <td colspan="5" class="text-center noExl">
                          <div class="m-5">
                            <i class="zmdi font-33 zmdi-receipt d-block"></i>
                            <h5 >No Ratings</h5>
                          </div>
                        </td>
                      </tr>
                    <?php endif ?>

                    <?php foreach ($reviess as $rev): ?>
                      <tr>
                        <td>
                          <?php 
                              if ($rev['review_type']=='dummy') {
                                  echo $rev['userid'];
                              }else{
                                  echo user_name($rev['userid']);
                              } 
                          ?>
                        </td>
                        <td>

                          <div class="Stars" style="--rating: <?= $rev['rating']; ?>;" aria-label="Rating of this product is 2.3 out of 5."></div>

                        </td>
                        <td style="width:10px;"><?= nl2br($rev['review']); ?></td>
                        <td><?= get_date_format($rev['datetime'],'d M Y h:i A'); ?></td>
                        <td>
                          <a data-url="<?= base_url('products'); ?>/delete_review/<?= $rev['id']; ?>/<?= $rev['productid']; ?>" class="delete_product_cat">
                            <i class="bx bx-trash text-danger font-18"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach ?>
                 
              </tbody>
            </table>
        </div>

        

    </div>

            </div>
        </div>
</div>