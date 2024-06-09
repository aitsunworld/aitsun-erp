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
                    <a href="<?= base_url('pos/floors'); ?>" class="href_loader">Floors</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Add floor</b>
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
    <div class="d-flex">
          
        <a href="<?= base_url('pos/floors') ?>" class="href_loader text-dark my-auto font-size-footer me-2"><i class="bx bx-home"></i> <span class="my-auto">Floors & Tables</span></a> 

    </div>
 
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
  

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
        <form method="post" id="add_floor_form" action="<?= base_url('floors/save_floors'); ?>" class="w-100">
            
            <?= csrf_field(); ?> 

            <?php if (isset($floor) && $floor): ?>
                <input type="hidden" name="floor_id" id="floor_id" value="<?= $floor['id']; ?>">
            <?php endif; ?>
            <div class="row">
                
                <div class="col-md-6">
                     <div class="row"> 
                       <div class=" col-md-12 mb-2"> 
                        <label for="input-1" class="modal_lab">Floor name</label>
                        <input type="text" class="form-control modal_inpu" name="floor_name" id="floor_name" value="<?= $floor['floor_name'] ?? ''; ?>">
                       </div>
                    
                       

                        <div class="form-group col-md-12 mb-2">
                            <label for="person">Register </label>
                            
                            <div class="aitsun_select position-relative">
                                                   
                                <input type="text" class="form-control d-none" data-select_url="<?= base_url('selectors/all_pos_registers'); ?>">
                                <a class="select_close d-none"><i class="bx bx-x"></i></a>
                     
                                <select class="form-select" name="register_id" id="register_id">
                                    <option value="">Select Register</option> 
                                    <option value="<?= isset($floor['register_id']) ? $floor['register_id'] : ''; ?>" <?= isset($floor['register_id']) && $floor['register_id'] ? 'selected' : ''; ?>><?= isset($floor['register_id']) ? user_name($floor['register_id']) : ''; ?></option>  
                                   
                                </select>
                                <div class="aitsun_select_suggest">
                                </div>
                            </div>
                        </div>
 
 
                    </div> 

                    <div class="pt-3">
                        <button type="button" id="save_floor" class="aitsun-primary-btn w-25">Save</button>
                    </div>
                </div>

            <div class="col-md-6">
                <div class="row"> 
                   <div class=" col-md-12 mb-2"> 
                        <label for="input-1" class="modal_lab">Table</label>
 
                        <div class="form-group col-md-12 d-none-on-bill ">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th class="align-content-center">Table name</th>
                                <th class="align-content-center" style="width: 135px;">Seat</th>
                                <th class="align-content-center" style="width: 135px;" colspan="2">Shape</th>
                              </tr>
                            </thead>
                            <tbody class="after-add-more-table">
                                <?php if (isset($floor) && $floor): ?>
                                    <?php foreach (floor_tables_array($floor['id']) as $table): ?>
                                    <tr class="after-add-more-table-tr">
                                      <td>
                                        <input type="text" name="table_name[]" class="form-control position-relative" id="table_name"> 
                                      </td>
                                      <td>
                                        <input type="number" name="seats[]" min="1" class="form-control" id="seats" value="<?= $table['from']; ?>">
                                      </td>
                                      <td style="width:135px;">
                                             <select name="shape[]" class="form-select position-relative" id="shape">
                                                <option value="0" <?= $table['shape'] == 0 ? 'selected' : ''; ?>>Square</option>
                                                <option value="1" <?= $table['shape'] == 1 ? 'selected' : ''; ?>>Circle</option> 
                                            </select> 
                                      </td>
                                      <td class="change text-center" style="width:25px;"><a class="btn btn-danger btn-sm no_load  remove-table text-white"><b>-</b></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                   <tr class="after-add-more-table-tr">
                                      <td>
                                        <input type="text" name="table_name[]" value="Table 1" class="form-control position-relative" id="table_name"> 
                                      </td>
                                      <td>
                                        <input type="number" name="seats[]" min="1" value="4" class="form-control" id="seats">
                                      </td>
                                      <td style="width:135px;">
                                             <select name="shape[]" class="form-select position-relative" id="shape">
                                                <option value="0">Square</option>
                                                <option value="1">Circle</option> 
                                            </select> 
                                      </td>
                                      <td class="change text-center" style="width:25px;"><a class="btn btn-danger btn-sm no_load  remove-table text-white"><b>-</b></a></td>
                                    </tr>

                                <?php endif; ?>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="p-0"><button class="no_load btn btn-dark w-100 add-more-table  btn-sm" type="button"><b>+</b></button></th>
                                </tr>
                                
                            </tfoot>
                          </table>
                      </div>
             




                   </div>
               </div>
               
            </div>

               

            </div>

        </form>  
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// --> 