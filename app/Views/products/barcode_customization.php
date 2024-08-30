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
                    <b class="page_heading text-dark">Barcode generator</b>
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
    <div>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-bs-toggle="collapse" data-bs-target="#barcode_customization_fliter"> 
            <span class="my-auto">Filter</span>
        </a>
        <a data-bs-toggle="modal" data-bs-target="#barcode_design" data-action="open" id="preference_close_button" class="aitsun_table_export text-dark font-size-footer me-2">Barcode Design</a>
    </div>
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->

        

<!-- ////////////////////////// MODAL ///////////////////////// -->

<div class="modal fade" id="barcode_design" tabindex="-1" data-bs-backdrop="static" aria-labelledby="barcodedesign" aria-hidden="true">
    <div class="w-100 modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" style="max-width:100%;">
        <div class="modal-content" style="height: 100vh!important;">
          <div class="modal-header">
            <h5 class="modal-title" id="barcode design">Barcode Settings</h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-7">
                        <form method="post" action="<?= base_url('settings/save_barcode_settings'); ?>" id="side_bar_form">
                            <?= csrf_field(); ?>
                            
                            <div class="row">
                                <div class="form-group col-md-6 mb-3 my-auto">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="price_for_barcode">Show Price</label>
                                        <input class="form-check-input save_side_bar_click" type="checkbox" name="price_for_barcode" id="price_for_barcode" value="1" <?php if (get_setting(company($user['id']),'price_for_barcode') == '1') {echo 'checked';} ?> onclick="mybarcodepreview()" >
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-sm-12 mb-3 px-0 form-barcode">
                                    <label for="input-5" class="form-label">Margin(px): </label>
                                    <input type="number" step="any" name="bar_margin1"  value="<?= get_setting(company($user['id']),'bar_margin1'); ?>" style="width: 60px;" placeholder="T" class="text-center form_input mt-1 barcode_backgrnd save_side_bar_input" onblur="mybarcodepreview()">
                                        <span>X</span>
                                    <input type="number" step="any" name="bar_margin2" style="width: 60px;" value="<?= get_setting(company($user['id']),'bar_margin2'); ?>" placeholder="R" class="text-center form_input save_side_bar_input barcode_backgrnd" onblur="mybarcodepreview()">
                                        <span>X</span>
                                    <input type="number" step="any" name="bar_margin3" style="width: 60px;" value="<?= get_setting(company($user['id']),'bar_margin3'); ?>" placeholder="B" class="text-center form_input save_side_bar_input barcode_backgrnd" onblur="mybarcodepreview()">
                                        <span>X</span>
                                    <input type="number" step="any" name="bar_margin4" style="width: 60px;" value="<?= get_setting(company($user['id']),'bar_margin4'); ?>" placeholder="L" class="save_side_bar_input text-center form_input barcode_backgrnd" onblur="mybarcodepreview()">
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex mb-3">
                                        <div class="my-auto">
                                            <label for="input-5" class="form-label">Barcode height : </label>
                                        </div>
                                        <div class="my-auto ms-2 form-barcode">
                                            <input type="number" step="any" name="barcode_height"  value="<?= get_setting(company($user['id']),'barcode_height'); ?>"  class="form-control form_input barcode_backgrnd save_side_bar_input" onblur="mybarcodepreview()">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-6 px-0">
                                    <div class="d-flex mb-3">
                                        <div class="my-auto">
                                            <label for="input-5" class="form-label">Body width:</label>
                                        </div>
                                        <div class="my-auto ms-2 form-barcode">
                                            <input type="number" step="any" name="bar_body_width"  value="<?= get_setting(company($user['id']),'bar_body_width'); ?>"  class="form-control form_input barcode_backgrnd save_side_bar_input " onblur="mybarcodepreview()">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 mb-3 my-auto">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="border">Show Border</label>
                                        <input class="form-check-input save_side_bar_click" type="checkbox" name="border" id="border" value="1" <?php if (get_setting(company($user['id']),'border') == '1') {echo 'checked';} ?> onclick="mybarcodepreview()" >
                                    </div>
                                </div>

                                <div class="col-lg-6 px-0">
                                    <div class="d-flex mb-3">
                                        <div class="my-auto">
                                            <label for="input-5" class="form-label">Border Width:</label>
                                        </div>
                                        <div class="my-auto ms-2 form-barcode">
                                            <input type="number" step="any" name="border-width"  value="<?= get_setting(company($user['id']),'border-width'); ?>"  class="form-control form_input barcode_backgrnd save_side_bar_input " onblur="mybarcodepreview()">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-sm-12 mb-3 form-barcode">
                                    <label for="input-5" class="form-label">Padding(px): </label>
                                    <input type="number" step="any" name="bar_padding1"  value="<?= get_setting(company($user['id']),'bar_padding1'); ?>" style="width: 60px;" placeholder="TB" class="text-center form_input mt-1 barcode_backgrnd save_side_bar_input" onblur="mybarcodepreview()">
                                        <span>X</span>
                                    <input type="number" step="any" name="bar_padding2" style="width: 60px;" value="<?= get_setting(company($user['id']),'bar_padding2'); ?>" placeholder="RL" class="text-center form_input save_side_bar_input barcode_backgrnd" onblur="mybarcodepreview()">
                                </div>

                                <div class="col-lg-6 px-0">
                                    <div class="d-flex mb-3">
                                        <div class="my-auto">
                                            <label for="input-5" class="form-label">Font size(px):</label>
                                        </div>
                                        <div class="my-auto ms-2 form-barcode">
                                            <input type="number" step="any" name="font_size"  value="<?= get_setting(company($user['id']),'font_size'); ?>"  class="form-control form_input barcode_backgrnd save_side_bar_input " onblur="mybarcodepreview()">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-sm-12 mb-3  form-barcode">
                                    <label for="input-5" class="form-label">Gap Between(px): </label>
                                    <input type="number" step="any" name="margin_top"  value="<?= get_setting(company($user['id']),'margin_top'); ?>" style="width: 60px;" placeholder="T" class="text-center form_input mt-1 barcode_backgrnd save_side_bar_input" onblur="mybarcodepreview()">
                                        <span>X</span>
                                    <input type="number" step="any" name="margin_bot" style="width: 60px;" value="<?= get_setting(company($user['id']),'margin_bot'); ?>" placeholder="B" class="text-center form_input save_side_bar_input barcode_backgrnd" onblur="mybarcodepreview()">
                                       

                                </div>




                            </div>
                        
                    </form>
                </div>
                    <div class="col-md-5">
                        <iframe src="<?= base_url(); ?>/products/barcode_preview/0" style="height: 50vh;" class="w-100"  id="iframeid"></iframe>
                    </div>

                    
                </div>
            </div>
            <div class="modal-footer text-start py-1"> 
            </div> 
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->


        
<div id="barcode_customization_fliter" class=" accordion-collapse col-12 border-0 collapse">
    <div class="filter_bar">
        <!-- FILTER -->
        <form method="get" class="d-flex">
            <?= csrf_field(); ?>

            <input type="text" name="product_name" placeholder="<?= langg(get_setting(company($user['id']),'language'),'Product Name'); ?>" class=" filter-control form-control  w-100">

            <button class="href_long_loader btn-dark btn-sm">
                <?= langg(get_setting(company($user['id']),'language'),'Filter'); ?>
            </button>
            
            <a class="btn btn-outline-dark my-auto" href="<?= base_url('easy_edit/barcode_customization') ?>"><?= langg(get_setting(company($user['id']),'language'),'Clear'); ?></a>
          
        </form>
        <!-- FILTER -->
    </div>  
</div>



<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 
 

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="product_edit_table" class="erp_table">
                 <thead>
                    <tr>
                        <th>Products Name</th>
                        <th>
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">AP Code</div>
                                <button id="generate_ap_code" class="btn btn-sm btn-light "><i class="bx bx-refresh"></i></button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">Category Code</div>
                                <button id="generate_dpc_code" class="btn btn-sm btn-light "><i class="bx bx-refresh"></i></button>
                            </div>
                        </th> 
                        <th class="text-center">Barcode</th> 
                        <th class="text-end">

                            <div class="d-flex justify-content-between">
                                <div class="my-auto">Action</div>
                                <button data-bs-toggle="modal" data-bs-target="#generate_barcode_for_all" class="btn btn-sm btn-light "><i class="bx bx-barcode-reader"></i></button>  
                            </div>

                              <!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="generate_barcode_for_all" tabindex="-1" data-bs-backdrop="static" aria-labelledby="studentaddmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="studentaddmodalLabel">Barcode types <small>(click to generate)</small></h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
            <div class="modal-body">
                <div class="row">

                    <div class="aitsun-row"> 
                        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
                            <table id="" class="erp_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Barcode Name</th>
                                        <th class="text-center">Code</th> 
                                        <th class="text-center">Department</th> 
                                        
                                        <th class="text-center">LFCode</th> 
                                        <th class="text-center">CheckSum</th> 
                                        <th class="text-center">Weight</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (barcode_array() as $abarc) { ?>
                                        <tr class="cursor-pointer update_all_bar_type" data-bar_type="<?= $abarc['Barcode Type'] ?>">
                                            <td class="text-center">
                                                <?= $abarc['Barcode Type'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $abarc['Barcode Name'] ?>
                                            </td>
                                           
                                            <td class="text-center">
                                                <?= $abarc['Code'] ?>
                                            </td>
                                             <td class="text-center">
                                                <?= $abarc['Department'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $abarc['LFCode'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $abarc['checkSum'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $abarc['Weight'] ?>
                                            </td> 

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     
                </div>
            </div>
            <div class="modal-footer text-start py-1"> 
            </div> 
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->

                        </th> 
                        
                    </tr>
                 
                 </thead>
                <tbody>
                    

                    
                    <?php $i=0; foreach ($product_data as $p_data): $i++; ?>

                    <tr class="bar_pros" data-proid="<?= $p_data['id']; ?>">
                        
                        <td style="width:500px;">
                            <?= $p_data['product_name']; ?>
                        </td>
                        <td style="width:200px; text-align: center;">
                            <?= $p_data['pro_ap_code']; ?>
                        </td>
                        <td style="width:200px; text-align: center;">
                            <?= $p_data['department_cat_code']; ?>
                        </td>
                        <td class="text-center"> 
                            
                            <div class="position-relative">
                                <input type="text" name="barcode" value="<?= $p_data['barcode']; ?>" data-product_id="<?= $p_data['id']; ?>" class="form-control me-2 add_barcode" pattern="^[a-zA-Z0-9 ]+$" id="bar_inp<?= $p_data['id']; ?>" placeholder="Scan / Type & enter" data-product_name="<?= $p_data['product_name']; ?>">
                                <?php if ($p_data['custom_barcode']): ?>
                                    <span class="badge bg-dark cus_bar_badge">Custom</span>
                                <?php endif ?>
                            </div>
                            
                        </td>
                        <td class="text-center">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#generate_pro_barcode<?= $p_data['id']; ?>" class="btn btn-sm btn-back"> <span class="my-auto">Generate</span></a>


    <!-- ////////////////////////// MODAL ///////////////////////// -->

    <div class="modal fade" id="generate_pro_barcode<?= $p_data['id']; ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="studentaddmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="studentaddmodalLabel">Barcode types <small>(click to generate)</small></h5>    
            <button type="button" class="btn-close close_school" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
            <div class="modal-body">
                <div class="row">

                    <div class="aitsun-row"> 
                        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
                            <table id="parties_table" class="erp_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Barcode Name</th>
                                        <th class="text-center">Code</th> 
                                        <th class="text-center">Department</th> 
                                        
                                        <th class="text-center">LFCode</th> 
                                        <th class="text-center">CheckSum</th> 
                                        <th class="text-center">Weight</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (barcode_array() as $barc) { ?>
                                        <tr class="cursor-pointer update_bar_type" data-product_id="<?= $p_data['id']; ?>" data-bar_type="<?= $barc['Barcode Type'] ?>">
                                            <td class="text-center">
                                                <?= $barc['Barcode Type'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $barc['Barcode Name'] ?>
                                            </td>
                                           
                                            <td class="text-center">
                                                <?= $barc['Code'] ?>
                                            </td>
                                             <td class="text-center">
                                                <?= $barc['Department'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $barc['LFCode'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $barc['checkSum'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $barc['Weight'] ?>
                                            </td>

                                            

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     
                </div>
            </div>
            <div class="modal-footer text-start py-1"> 
            </div> 
        </div>
      </div>
    </div>
<!-- ////////////////////////// MODAL ///////////////////////// -->

                        </td>
                        
                    </tr>

                    <?php endforeach ?>

                    <?php if ($i==0): ?>
                        <tr>
                            <td colspan="7"><h6 class="p-4 text-center text-danger">No Products Found... </h6></td>
                        </tr>
                    <?php endif ?>
                     
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ////////////////////////// MAIN PAGE END ///////////////////////// -->
<div class="sub_footer_bar d-flex justify-content-end">
    <div class="aitsun_pagination">  
        <?= $pager->links() ?>
    </div>
</div> 

<script type="text/javascript">
   
   
    function mybarcodepreview() {
        setTimeout(function(){
            document.getElementById('iframeid').src += '';
        },2000);
    }
                                                                                              

 
       
</script>

