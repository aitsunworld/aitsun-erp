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
                
                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('fees_and_payments'); ?>">Fees management</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Transport price table</b>
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
<div class="main_page_content">
    <div class="aitsun-row"> 
         <?php foreach (classes_array(company($user['id'])) as $cls): ?>
                    <div class="col-md-12 mt-2 class_box">
                        <h5><?= $cls['class'] ?></h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered price_center_tb">
                                <thead>
                                    <tr>
                                        <th scope="col"><a class="text-blue" data-bs-toggle="modal" data-bs-target="#additems" title="Add Items"><i class="bx bx-plus-circle"></i></a> Locations</th>
                                         <?php $i=0; foreach ($student_cat as $stct): $i++; ?>

                                            <th scope="col my-auto">
                                                <div class="d-flex justify-content-between"> 
                                                    <div class="my-auto">
                                                       <?= $stct['category_name']; ?> 
                                                    </div>

                                                    <div>
                                                        <?php if($stct['category_name']=='General'):  ?>
                                                        

                                                        <!-- Button with icon and tooltip -->
                                                        <a class="btn paste_all" data-toggle="tooltip" data-placement="top" title="Price to paste" data-input_class="input_<?= $stct['category_name'] ?><?= $cls['id']; ?>">
                                                            <i class="bx bx-chevron-down-circle mr-1 text-blue myDIV"></i>
                                                        </a>

                                                        <script>
                                                            // Initialize Bootstrap Tooltip
                                                            $(document).ready(function(){
                                                                $('[data-toggle="tooltip"]').tooltip();
                                                            });
                                                        </script>

                                                        <?php endif ?>

                                                        
                                                    </div>


                                                    


                                                </div> 
                                            </th>
                                         <?php endforeach ?>
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                     <?php $i=0; foreach ($items as $it): $i++; ?>
                                      <tr>
                                        <td style="min-width: 250px;"><a class="text-primary" data-bs-toggle="modal" data-bs-target="#edititem<?= $it['id']; ?>"><small><i class="bx bx-pencil mr-1 text-blue"></i></small></a>
                                            <?php if ($it['editable']==0): ?>
                                            <?= $it['product_name'] ?> - <i class="fa fa-bus"></i> <?= get_vehicle_data($it['vehicle'],'vehicle_name'); ?>
                                            <?php else : ?>
                                            <?= $it['product_name'] ?>(Optional) - <i class="fa fa-bus"></i> <?= get_vehicle_data($it['vehicle'],'vehicle_name'); ?>
                                            <?php endif ?>

                                            <!-- Modal -->
                                             <div class="modal fade" id="edititem<?= $it['id']; ?>">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addteamLabel">Edit Items</h5>
                                                            <button type="button" class="close" data-ba-dismiss="modal">
                                                                <i class="bx bx-x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="<?= base_url('fees_and_payments/edit_transport_items'); ?>/<?= $it['id']; ?>">
                                                                <?= csrf_field() ?>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">

                                                                        <label class="font-weight-semibold" for="itemname">Item Name</label>
                                                                        <input type="text" class="form-control" name="itemname" value="<?= $it['product_name']; ?>" placeholder="Item Name " required>
                                                                    </div>

                                                                    <div class="form-group col-md-12 d-none" >
                                                                        <label for="inputState">Item Type</label>
                                                                        <select class="select2"  name="editable"  required>
                                                                            <option value="0"  <?php if ($it['editable']=='0'){echo "selected";} ?>>Required For All Students</option>
                                                                            <option value="1"  <?php if ($it['editable']=='1'){echo "selected";} ?>>Optional</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-12 ">
                                                                    <label for="">Vehicle</label>
                                                                    <select class="form-control"  name="vehicle" required>
                                                                        <option value="">Select Vehicle</option>
                                                                        <?php foreach (vehicles_array(company($user['id'])) as $vh): ?>
                                                                            <option value="<?= $vh['id']; ?>" <?php if ($it['vehicle']==$vh['id']){echo "selected";} ?>><?= $vh['vehicle_name']; ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>

                                                                    <div class="form-group col-md-12">
                                                                        <label class="font-weight-semibold" for="description">Description (optional)</label>
                                                                        <textarea class="form-control" name="description"><?= $it['description']; ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                       <button class="aitsun-primary-btn mt-2" type="submit" >Save</button>
                                                                       <a class="btn delete btn-outline-danger" style="border: 1px solid;" data-url="<?= base_url('fees_and_payments/deleteitem_trans'); ?>/<?= $it['id']; ?>"><i class="bx bx-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal -->

                                        </td>


                                        <?php $i=0; foreach ($student_cat as $stct): $i++; ?>

                                          <td><input type="number" min="1" class="analytics_fees aitsun-simple-input input_row<?= $it['id']; ?><?= $cls['id']; ?> input_<?= $stct['category_name'] ?><?= $cls['id']; ?>"  data-category_id="<?= $stct['id']; ?>" data-item_id="<?= $it['id'] ?>" data-classid="<?= $cls['id']; ?>" data-row_class='input_row<?= $it['id']; ?><?= $cls['id']; ?>' value="<?= get_analytics_item_price_data(company($user['id']),$stct['id'],$it['id'],$cls['id'],'price') ?>" style="max-width: 80px;"></td>
                                        <?php endforeach ?>

                                    </tr>
                                     <?php endforeach ?>
                                     <?php if ($i==0): ?>
                                         <tr>
                                            <td><h6 class="text-danger">No Locations</h6></td>
                                        </tr>

                                    <?php endif ?>

                                   

                                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <?php endforeach ?>

       

        

    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->


  <!-- Modal -->
                     <div class="modal fade" id="addstdcaste">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addteamLabel">Add Category</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="anticon anticon-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?= base_url('settings/add_category'); ?>">
                                        <?= csrf_field() ?>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <input type="hidden" name="redirect_url" value="<?= base_url('fees_and_payments/price_table'); ?>">
                                                <label class="font-weight-semibold" for="stdcategory">Category</label>
                                                <input type="text" class="form-control" name="stdcategory"  placeholder="Student Category " required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                               <button class="aitsun-primary-btn mt-2" type="submit" >Save</button>
                                            </div>
                                        </div>
                                    </form>
                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->


                    <!-- Modal -->
                     <div class="modal fade" id="additems">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addteamLabel">Add Items</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?= base_url('fees_and_payments/add_transport_items'); ?>">
                                        <?= csrf_field() ?>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">

                                                <label class="font-weight-semibold" for="itemname">Item Name</label>
                                                <input type="text" class="form-control" name="itemname"  placeholder="Item Name " required>
                                            </div>
                                            <div class="form-group col-md-12 d-none">
                                                <label for="inputState">Priority</label>
                                                <select class="select2" name="editable" required> 
                                                    <option value="1">Optional</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12 ">
                                                <label for="">Vehicle</label>
                                                <select class="form-control"  name="vehicle" required>
                                                    <option value="">Select Vehicle</option>
                                                    <?php foreach (vehicles_array(company($user['id'])) as $vh): ?>
                                                        <option value="<?= $vh['id']; ?>"><?= $vh['vehicle_name']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>




                                            <div class="form-group col-md-12">
                                                <label class="font-weight-semibold" for="description">Description (optional)</label>
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                               <button class="aitsun-primary-btn mt-2" type="submit" >Save</button>
                                            </div>
                                        </div>
                                    </form>
                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->





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


 