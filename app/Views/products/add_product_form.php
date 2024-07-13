<form method="post" id="add_product_form" action="<?= base_url('products/add_product') ?>" enctype="multipart/form-data">
	<?= csrf_field(); ?>
  <div class="form-body">

    <div class="row">

    	

	   <div class="col-lg-8">
       <div class="rounded">

       	<div id="url_msg"></div>   
				<div>
					<input type="hidden" class="form-control" id="scrapped_by" name="scrapped_by" value="0">
					<input type="hidden" class="form-control" id="from_import" name="from_import" value="0">
					
				</div>

		  <div class="mb-3">
			<label for="inputProductTitle" class="form-label">Product Title <small class="font-weight-bold text-danger">*</small></label>
			<input type="text" class="form-control" id="title" name="title" placeholder="Enter product title">
		  </div>
		  <div class="mb-3">
			<label for="inputProductTitle" class="form-label">Slug <small class="font-weight-bold text-danger">*</small></label>
			<input type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
		  </div>


		  <div class="mb-3">
		  	 
        <span class="my-auto">Type: <small class="font-weight-bold text-danger">*</small></span>
        <div class="d-flex mt-2">
          
        
          <div class="d-flex my-auto me-4">
            <input type="radio" name="product_method" class="form-check-input" value="product"  checked id="product_method_product">
            <label class="my-auto ms-2">Product</label>
          </div>

          <div class="d-flex my-auto ">
            <input type="radio" name="product_method" class="form-check-input" value="service" id="product_method_service">
            <label class="my-auto ms-2">Service</label>
          </div>
        </div>
		  </div>


		  <div class="remove_service"> 

			  <div class="mb-3">
	        
	        <div class="d-flex w-100">
	        	<div class="my-auto w-100">
			        <label for="input-2" class="form-label">Opening Stock</label>
			        <input type="number" name="stock" min="0" class="form-control" id="pstock" value="0" required>
	        	</div>
	        	<div class="my-auto" style="max-width:200px;">
			        <label for="input-2" class="form-label">At price</label>
			        <input type="number" name="at_price" min="0" class="form-control" id="at_price" value="0" required >
		        </div>
	        </div>
			  </div> 
		  </div>


		  <div class="mb-3 d-none-on-bill">
		  	<div class="form-check form-switch " > 
            <label for="is_rental"><input type="checkbox" class="form-check-input is_rental" id="is_rental" name="is_rental" value="1"> Is rental product</label>
        </div>


        <div id="pricelist_block" class="d-none">
        	<div class="aitsun_table">
	        		<table class="erp_table aitsun_table table-bordered">
	              <thead>
	                <tr>
	                  <th>Period</th> 
	                  <th>Price</th>
	                  <th><button class="no_load btn btn-outline-light rental_price_add-more  btn-sm" type="button"><b>+</b></button></th>
	                </tr>
	              </thead>
	              <tbody class="after-rental_price_add-more">
	                  <tr class="after-rental_price_add-more-tr">
	                   
	                    <td class="w-100">
	                    	<div class="d-flex w-100">
	                    		<div class="position-relative fsc field_select_container w-100">
	                    			<select name="period_id[]" class="form-select position-relative w-100" data-blockid="" > 
	                    				
	                    				<?php foreach (rental_periods_array(company($user['id'])) as $rp): ?>
	                    					<option value="<?= $rp['id'] ?>"><?= $rp['period_name'] ?></option> 
	                    				<?php endforeach ?>
	                        	</select>  
	                    		</div> 
	                    	</div>
	                    </td>
	                    <td><input type="number" step="any" name="rental_price[]" class="form-control " style="width: 200px;"></td>
	                    <td class="change"></td>
	                  </tr>
	              </tbody>
	            </table>
        	</div> 
        </div>
		  </div>

		  <div class="mb-3 ">
			<label for="inputProductDescription" class="form-label">Description</label>
			<textarea class="form-control" name="description" id="description" rows="3"></textarea>
		  </div>


		  <div class="mb-3 d-none-on-bill">
			
			<label for="inputProductDescription" class="form-label">Featured Image (320 X 320)</label>
			<br>
			

			<div class="row web_pageeefro" id="featured_upload_form">
        <input type="file" accept="image/*" id="featured_image" name="featured_image">
        <p id="p_text">Featured Image</p>
      </div>
			<br>
			<input type="hidden" name="scrapped_product_image" id="scrapped_product_image">
			<label for="inputProductDescription" class="form-label">Thumbnail Images (320 X 320)</label>
			<br>


			<div class="row web_pageeefro <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>" id="thumb_upload_form">
        <input type="file" id="thumbnail_images" name="thumbnail_images[]" accept="image/*" multiple>
        <p id="p_text">Thumbnail Image</p>
      </div>

		  </div>

		  <div class="remove_service">
		  <div class="mb-3 d-none-on-bill <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
			<label for="inputProductDescription" class="form-label">Long Description</label>
			<textarea class="form-control" id="long_description" name="long_description" rows="3"></textarea>
		  </div>


		  <div class="mb-3 d-none-on-bill <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
			<label for="inputProductDescription" class="form-label">Keywords (word1,word2,...n)</label>
			<textarea class="form-control" name="keywords" id="keywords" rows="3"></textarea>
		  </div>


		  <div class="mb-3 bg-no" style=" background: #dadbdd; border-radius: 10px;">
              <div class="row p-2">
                  <div class="form-group col-md-12 mb-3">
                    <label for="input-4" class="">Product Code</label>
                    <input name="product_code" type="text" class="form-control">
                    <input name="product_color" type="hidden" class="form-control">
                	</div>

                	<div class="d-none d-none-on-bill ">
                		<select class="d-none" id="add_field_items">
                		<?php foreach (fields_name_array(company($user['id'])) as $fn): ?>
                			<option value="<?= $fn['fields_name'] ?>" data-fid="<?= $fn['id'] ?>"><?= $fn['fields_name'] ?></option>
                		<?php endforeach ?> 
                	</select>
                	</div>

                  <div class="form-group col-md-12 d-none-on-bill ">
                      <label for="input-4" class="">Additional fields</label>
                      <table class="table table-light table-bordered">
                        <thead>
                          <tr>
                            <th>Switch</th>
                            <th>
                            	<div class="d-flex justify-content-between">
                            		<div class="my-auto">Field <small>(Ex: RAM)</small></div>
                            		
                            	</div>
                            </th>
                            <th>Value <small>(Ex: 2GB)</small></th>
                            <th><button class="no_load btn btn-outline-dark add_field_add-more  btn-sm" type="button"><b>+</b></button></th>
                          </tr>
                        </thead>
                        <tbody class="after-add_field_add-more">
                            <tr class="after-add_field_add-more-tr">
                              <td>
                              	<div class="form-check form-switch">
																	<input class="form-check-input checkingrollbox" type="checkbox" id="switchableid">
																	<input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="switchable[]" type="hidden" value="0">
																	<label class="form-check-label" for="switchableid"></label>
																</div>
                              </td>
                              <td>
                              	<div class="d-flex">
                              		<div class="position-relative fsc field_select_container">
                              			<select name="field_name[]" class="form-select position-relative" data-blockid="" id="field_select" style="width: 200px;">
		                              		<option value="" data-fid="">Search</option>
		                              		<?php foreach (fields_name_array(company($user['id'])) as $fn): ?>
		                              			<option value="<?= $fn['fields_name'] ?>" data-fid="<?= $fn['id'] ?>"><?= $fn['fields_name'] ?></option>
		                              		<?php endforeach ?> 
		                              	</select> 

                              		</div>
                              	<a class="ml-2 my-auto btn btn-sm btn-info add_fields_input" id="add_fields_input" data-blockid="">+</a>
                              	<a class="ml-2 d-none my-auto btn btn-sm adddd_unit_btn save_fields_input " id="save_add_field" data-blockid=""><i class="bx bx-x"></i></a>
                              	</div>
                              </td>
                              <td><input type="text" name="field_value[]" class="form-control " ></td>
                              <td class="change"><a class="btn btn-danger btn-sm no_load  remove text-white"><b>-</b></a></td>
                            </tr>
                        </tbody>
                      </table>
                  </div>
             	</div>
      </div> 


      <!-- //////////////////////////////////////ITEM KIT SELECTOR/////////////////////////////// -->
       <div class="mb-3 d-none-on-bill d-none" style=" background: #dadbdd; border-radius: 10px;">
              <div class="row p-2">
                  <div class="form-group col-md-12 mb-3">
                    <label for="input-4" class="">Product Type</label>
                    <select class="form-select product_type" name="product_type">
                    	<option value="single">Single</option>
                    	<option value="item_kit">Item Kit</option>
                    </select>
                	</div>

                  <div class="form-group col-md-12 d-none" id="product_selector">
                     <a type="button" data-bs-toggle="modal" data-bs-target="#product_selecting_modal" class="btn btn-facebook d-block text-center">Select product</a>
                  </div>
                  <div class="form-group col-md-12" id="product_container">
                     	
                  </div>

             	</div>
      </div> 

      <div class="modal fade" id="product_selecting_modal"  aria-hidden="true">
      	<div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <input type="text" class="d-block form-control product_selector_search w-100" placeholder="Search product...">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


						<div class="modal-body" >
						  <div class="form-group col-md-12 " id="product_list">
                    
              </div>

              <div class="text-center">
              	<button id="saveitems" type="button" class="btn btn-facebook btn-sm mb-2 d-none w-50">
              		Save Items
              	</button>
              </div>

              <div id="show_pro">
	              	
              </div>

						</div>
					</div>
				</div>
			</div>

		</div>
			 <!-- //////////////////////////////////////ITEM KIT SELECTOR/////////////////////////////// -->


        </div>
	   </div>
	   <div class="col-lg-4">
		<div class="rounded">
                    <div class="row g-3">
			<div class="col-md-12">
				<div class="remove_service">

					<div class="col-md-12 mb-3">
						
						<label for="inputProductTitle" class="form-label">MRP <small class="font-weight-bold text-danger">*</small></label>
						<div class="">
							<input type="number" min="0" step="any" class="form-control" id="pmrp" name="mrp" placeholder="Max Retail Price">
							<div class="d-flex mt-2 w-100">
								 <div class="w-100">
								 	<label>Pur. margin (%)</label>
								 	<input type="number" min="0" step="any" class="form-control me-1" id="p_margin" name="purchase_margin" placeholder="Pur. Disc %">
								 </div>
								 <div class="w-100">
								 	<label>Sale margin (%)</label>
								 	<input type="number" min="0" step="any" class="form-control ms-1" id="s_margin" name="sale_margin" placeholder="Sale. Disc %">
								 </div>
							</div>
						</div>
						
				</div>

				<div class="col-md-12 mb-3">
						
						<label for="inputProductTitle" class="form-label">Purchase Price <small class="font-weight-bold text-danger">*</small></label>
						<div class="d-flex">
							<input type="number" min="0" step="any" class="form-control" id="pprice" name="purchased_price" placeholder="Price">
							<div style="width: 134px;">
								<select class="form-control" name="purchase_tax">
									<option value="1">With Tax</option>
									<option value="0">Without Tax</option>
								</select>
							</div>
						</div>
						
				</div>
			</div>

				<div class="col-md-12 mb-2">
					<div class="d-flex justify-content-between">
						<label for="inputProductTitle" class="form-label">Selling Price <small class="font-weight-bold text-danger">*</small></label>
						<div>
							<a class="btn btn-sm-primary p-0" id="add_pro_diss" style="font-size: 14px;">
              Discounted price 
            </a>
            <span id="showprice"><input type="checkbox" id="checkbooox" class="checkbooox" data-proid=""><span id="showspan" class="ps-1"></span></span>
            </div>
					</div>

         <div  class="d-flex">
          <div id="discout_container_product" class=" mb-2 " style="display: none;">
            <input type="number" name="discounted_price" id="discounted" class="ad_u">
            <button class="mr-2 adddd_discountbtn_b
            tn adddd_unit_btn  save_dis" id="save_dis" data-proid="" type="button">Ok</button>
          </div>
        </div>
        <div class="d-flex">
					<input type="number" min="0" step="any" class="form-control" id="psellprice" name="price" placeholder="Selling Price">
						<div style="width: 134px;">
							<select class="form-control" name="sale_tax">
								<option value="1">With Tax</option>
								<option value="0">Without Tax</option>
							</select>
						</div>
					</div>
				</div>

			  <div class="col-12 mb-2">
			  	 
						<label for="inputProductType" class="form-label my-auto">Unit <small class="font-weight-bold text-danger">*</small></label>
					
						<select class="ssselect form-select" data-proid="" name="unit" id="unit">
							<option value="">Select Unit</option>
							<?php foreach (products_units_array(company($user['id'])) as $pu): ?>
							<option value="<?= $pu['value']; ?>" <?= ($pu['value']=='Nos')?'selected':''; ?>><?= $pu['name']; ?></option>
							<?php endforeach ?>
						 </select>
			  </div>


			  <div class="col-12 mb-2">
					<label for="inputCollection" class="form-label my-auto">Sub Unit <small class=" text-danger" id="subuer">*</small></label>

					<select class="form-select subu"  data-proid=""  name="sub_unit" id="sub_unit">
					<option value="">None</option>
					<?php foreach (products_units_array(company($user['id'])) as $pu): ?>
							<option value="<?= $pu['value']; ?>"><?= $pu['name']; ?></option>
							<?php endforeach ?>
				  </select>
			  </div>


			  <div class="col-12 mb-2 add_conversion d-none">
					<label for="inputCollection" class="form-label my-auto">Conversion Rate</label>

					<input type="number" min="0" step="any" class="form-control" id="conversion_unit_rate" name="conversion_unit_rate" placeholder="Conversion Rate">
			  </div>






			  <div class="remove_service">
				  <div class="col-12 mb-2">
				  	<div class="d-flex justify-content-between">
							<label for="inputVendor" class="form-label my-auto">Brand <small class="font-weight-bold text-danger">*</small></label>
							 <a class="p-0 add_pro_brand" id="add_pro_brand" data-proid=""><i class="bx bxs-plus-square " style="font-size: 25px;"></i></a>
						</div>

						<div  class="d-flex">
	            <div id="brand_container_product" class=" mb-2 " style="display: none;">
	              <input type="text" name="brand_name" id="brand_name" class="ad_u">
	              <button class="mr-2 adddd_unit_btn addd_brand" id="addd_brand" data-proid="" type="button">Add</button>
	            </div>
	          </div>

					<select class="form-select single-select" name="brand" id="brand"> 
						<?php foreach (products_brands_array(company($user['id'])) as $pb): ?>
						<option value="<?= $pb['id']; ?>"><?= $pb['brand_name']; ?></option>
						<?php endforeach ?>
					  </select>
				  </div>
				</div>
			  <div class="col-12 mb-2">
			  	<div class="d-flex justify-content-between">
					<label for="inputCollection" class="form-label my-auto">Category <small class="font-weight-bold text-danger">*</small></label>
					<a class=" p-0 add_pro_cat" id="add_pro_cat" data-proid=""><i class="bx bxs-plus-square" style="font-size: 25px;"></i></a>
				</div>
				
				<div  class="d-flex">
          <div id="cat_container_product" class=" mb-2" style="display: none;">
            <input type="text" name="cat_name" id="cat_name" class="ad_u">
            <button class="mr-2 adddd_unit_btn addd_cate" id="addd_cate" data-proid="" type="button">Add</button>
          </div>
         </div>

					<select class="form-select parc" data-proid="" name="category" id="category"> 
						<?php foreach (product_categories_array(company($user['id'])) as $pc): ?>
							<option value="<?= $pc['id']; ?>"><?= $pc['cat_name']; ?></option>
						<?php endforeach ?>
					  </select>
			  </div>


			  <div class="col-12 mb-2">
			  	<div class="d-flex justify-content-between">
					<label for="inputCollection" class="form-label my-auto">Sub Category</label>
					<a class="p-0 add_pro_subcat" id="add_pro_subcat" data-proid=""><i class="bx bxs-plus-square " style="font-size: 25px;"></i></a>
					</div>

					<div  class="d-flex">
            <div id="subcat_container_product" class=" mb-2 " style="display: none;">
              <input type="text" name="subcat_name" id="subcat_name" class="ad_u">
              <button class="mr-2 adddd_unit_btn addd_subcate" id="addd_subcate" data-proid="" type="button">Add</button>
              <label id="subcater"></label>
            </div>
            
         </div>
					<select class="form-select subc" data-proid="" name="sub_category" id="sub_category">
					<option value="">Select Sub Category</option>
				  </select>
			  </div>
			  <div class="col-12 mb-2">
			  	<div class="d-flex justify-content-between">
					<label for="inputCollection" class="form-label my-auto">Secondary Category</label>
						 <a class=" p-0 add_pro_seccat" id="add_pro_seccat" data-proid=""><i class="bx bxs-plus-square " style="font-size: 25px;"></i></a>
        </div>
        	<div  class="d-flex">
            <div id="seccat_container_product" class=" mb-2 " style="display: none;">
              <input type="text" name="subcat_name" id="seccat_name" class="ad_u">
              <button class="mr-2 adddd_unit_btn addd_seccate" id="addd_seccate" data-proid="" type="button">Add</button>
              <label id="seccater"></label>
            </div>
         </div>
					<select class="form-select" name="secondary_category" id="secondary_category">
						<option value="">Select Secondary Category</option>
					  </select>
			  </div>
			  

			 <div class="remove_service">
			  <div class="col-12 mb-2">
          <label for="input-4" class="form-label">Barcode</label>
          <input type="text" name="barcode" class="form-control modal_inpu" id="barcode">
        </div>

        <div class="col-12 mb-2">
        <label for="input-4" class="form-label">Expiry date</label>
        <input type="date" name="ex_date" class="form-control modal_inpu" >
       </div>

       <div class="col-12 mb-2">
        <label for="input-4" class="form-label">Batch No</label>
        <input type="text" name="batch_no" class="form-control modal_inpu">
       </div>

       <div class="col-12 mb-2 <?php if(!is_medical(company($user['id']))){echo "d-none";} ?> ">
        <label for="input-4" class="form-label">Bin Location</label>
        <input type="text" name="bin_location" class="form-control modal_inpu">
       </div>

       <div class="col-12 mb-2">
          <label for="input-4" class="form-label">Product identifiers (GTIN, UPC, EAN, JAN or ISBN)</label>
          <input name="pro_in" type="text" class="form-control">
      </div>
    </div>

      <div class="col-12 mb-2">
        <label for="input-4" class="form-label">Tax</label>
        <select class="form-select" name="tax" id="tax" > 
           <?php foreach (tax_array(company($user['id'])) as $tx): ?>
             <option value="<?= $tx['name']; ?>"><?= $tx['name']; ?></option>
           <?php endforeach ?>
        </select>
      </div>

      <div class="remove_service">
			  <div class="col-12 mb-3 d-none-on-bill <?php if (is_online_shop(company($user['id']))!=1) {echo "d-none";} ?>">
					<label for="inputProductTitle" class="form-label">Delivery Days</label>
					<input type="number" min="1" class="form-control" id="delivery_days" name="delivery_days" placeholder="Delivery Days" value="<?= get_delivery_days(company($user['id'])); ?>">
				</div>
			</div>

			  <div class="col-12">
			  	<div id="error_display" class="mb-2 text-danger"></div>
				  <div class="d-grid">
               <button type="button" id="save_product" class="aitsun-primary-btn w-100">Complete</button>
				  </div>
			  </div>
		  </div> 
	  </div>
	  </div>
   </div><!--end row-->
</div>
</div>
                       	
</form>

<input type="hidden" id="check_default" value="<?= default_unit(company($user['id'])) ?>">



<script type="text/javascript">

	$(document).on('click','.is_rental',function(){
		if ($(this).is(':checked')) {
        $('#pricelist_block').removeClass('d-none');
    } else {
        $('#pricelist_block').addClass('d-none');
    }  
	});


	var no=0;


	$(document).on("click",".add_field_add-more",function(){  

			var options_fields=$('#add_field_items').html();

			no++;


      var html = '<tr class="after-add_field_add-more-tr"><td><div class="form-check form-switch"><input class="form-check-input checkingrollbox" type="checkbox" id="switchableid'+no+'"><input class="mt-1 mr-1 rollcheckinput checkBoxmrngAll" name="switchable[]" type="hidden" value="0"><label class="form-check-label" for="switchableid'+no+'"></label></div></td><td><div class="d-flex"><div class="position-relative fsc field_select_container'+no+'"><select name="field_name[]" class="form-select select2 field_select newsele" data-blockid="'+no+'" id="field_select'+no+'" style="width: 200px;"><option value="">Search</option>'+options_fields+'</select></div><a class="ml-2 my-auto btn btn-sm btn-info add_fields_input" id="add_fields_input'+no+'" data-blockid="'+no+'">+</a><a class="ml-2 d-none my-auto btn btn-sm btn-facebook save_fields_input" id="save_add_field'+no+'" data-blockid="'+no+'"><i class="bx bx-x"></i></a></div></td><td><input type="text" name="field_value[]" class="form-control" ></td><td class="change"><a class="btn btn-danger btn-sm no_load  remove text-white"><b>-</b></a></td></tr>'; 
      
      $(".after-add_field_add-more").append(html);

      $('.newsele').select2();

    });

    $(document).on("click",".remove",function(){ 
      $(this).parents(".after-add_field_add-more-tr").remove();
    });


  


	var rental_no=0;


	$(document).on("click",".rental_price_add-more",function(){  

			var options_fields=$('#add_field_items').html();

			rental_no++;


      var html = `<tr class="after-rental_price_add-more-tr">
        <td class="w-100">
        	<div class="d-flex w-100">
        		<div class="position-relative fsc field_select_container w-100">
        			<select name="period_id[]" class="form-select position-relative w-100" data-blockid="" > 
        				<?php foreach (rental_periods_array(company($user['id'])) as $rp): ?>
        					<option value="<?= $rp['id'] ?>"><?= $rp['period_name'] ?></option> 
        				<?php endforeach ?>
            	</select>  
        		</div> 
        	</div>
        </td>
        <td><input type="number" step="any" name="rental_price[]" class="form-control " style="width: 200px;"></td>
        <td class="change"><a class="btn btn-danger btn-sm no_load rental_remove text-white"><b>-</b></a></td>
      </tr>`; 
      
      $(".after-rental_price_add-more").append(html);

      $('.newsele').select2();

    });

    $(document).on("click",".rental_remove",function(){ 
      $(this).parents(".after-rental_price_add-more-tr").remove();
    });

    $(document).on("click",".removeitemkit",function(){ 
      $(this).parents(".itemparent").remove();
      var no_of_pros=$(".itemparent").length;
	
			if (no_of_pros!=0) {
				$('#product_container').html('<h6 class="text-center mt-2" style="color: #0fae2f;">'+no_of_pros+' items added!</h6>');
			}else{
				$('#product_container').html('');
			}
    });

    
    


       $(document).on('click','.pro_close',function(){
          var btn_id=$(this).data('row');
          $('#close'+btn_id).remove();
       });


       $(function() {
	        $('#product_method_service').click(function() {
	            $('.remove_service').addClass('d-none');
	        });           
	        $('#product_method_product').click(function() {
	            $('.remove_service').removeClass('d-none');
	        });
	    });

       $(document).on('change','.checkingrollbox',function(){
            if($(this).prop('checked')){
                $(this).siblings(".rollcheckinput").val(1);
            }else{
                $(this).siblings(".rollcheckinput").val(0);
            }
        });




$(document).on('click','#save_product',function(){
		var form_data = new FormData($('#add_product_form')[0]);

		$('#error_display').html('');

		var title=$.trim($('#title').val());
		var slug=$.trim($('#slug').val());
		var description=$.trim($('#description').val());
		var pprice=$.trim($('#pprice').val());
		var psellprice=$.trim($('#psellprice').val());
		var unit=$.trim($('#unit').val());
		var brand=$.trim($('#brand').val());
		var category=$.trim($('#category').val());
		var def_unit=$('#check_default').val();

		var subunit=$('#sub_unit').val();
 
		var conversion_unit_rate=$('#conversion_unit_rate').val();

		var product_method='product';

		var approve=true;
 
		if ($("#product_method_service").prop("checked")) {

				product_method='service';
		}

		if (product_method=='product') {

			if (title=='' || slug=='') {
				$('#error_display').html('Title & slug is required!');
				approve=false;

			}else if (pprice=='' || psellprice=='') {
				$('#error_display').html('Price & Selling Price is required!');
				approve=false;
			}else if (unit=='' || category=='' || brand=='') {
				$('#error_display').html('Unit, Brand & category is required!');
				approve=false;
			}

			if (subunit!='') {

					if (conversion_unit_rate=='') {
							$('#error_display').html('Conversion rate is required!');
							approve=false;
					}else if(conversion_unit_rate<1) {
						  $('#error_display').html('Value must be greater than or equal to 1');
							approve=false;
					}

			}

		}else{

			if (title=='' || slug=='') {
				$('#error_display').html('Title & slug is required!');
				approve=false;

			}else if (psellprice=='') {
				$('#error_display').html('Selling Price is required!');
				approve=false;
			}else if (unit=='' || category=='') {
				$('#error_display').html('Unit & category is required!');
				approve=false;
			}

			if (subunit!='') {

					if (conversion_unit_rate=='') {
							$('#error_display').html('Conversion rate is required!');
							approve=false;
					}else if(conversion_unit_rate==0) {
						  $('#error_display').html('Value must be greater than or equal to 1');
							approve=false;
					}

			}
		}




 
			if (approve==true) {
				var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
      	var csrfHash = $('#csrf_token').val(); // CSRF hash

				$.ajax({
	          type: 'POST',
	          url: $('#add_product_form').prop('action'),
	          data: form_data,
	          processData: false,
	          contentType: false,
	          beforeSend: function() {
	              $('#save_product').html('<div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span></div>');
	          },
	          success: function(result) {
	          	$('#save_product').html('Save Product');
	          	if ($.trim(result)==1) {
	               $('#add_product_form')[0].reset();

	               
	               // if (def_unit==0) {
	               // 	$("#unit").val('').trigger('change');
	               // }else{
	               //  $("#unit").val(def_unit).trigger('change');
	               // }
	               

	                $("#tax").val('0').trigger('change');
	                $("#brand").val('').trigger('change');
	                $("#category").val('').trigger('change');
	                $("#sub_category").val('').trigger('change');
	                $("#secondary_category").val('').trigger('change');
	               
		              $('#description').html('');
									$('#long_description').html('');

									// $("#long_description").summernote('code',''); affecting in sales

	                $('#featured_upload_form p').html('Featured Image');
									$('#thumb_upload_form p').html('Thumbnail Image');
	                $('#error_display').html('');

	                Swal.fire(
							      'Saved!',
							      'Product has been saved.',
							      'success'
							    )
	          	}else if ($.trim(result)==2) {
	          		Swal.fire(
						      'Product title already exist!',
						      'Product not saved.',
						      'error'
						    )
	          	}else if ($.trim(result)==3) {
	          		Swal.fire(
						      'Slug already exist!',
						      'Product not saved.',
						      'error'
						    )
	          	}else{
	          		Swal.fire(
						      'Failed!',
						      'Product not saved.',
						      'error'
						    )
	          	}

	          }
	      });
			}
		   

	});
</script>

