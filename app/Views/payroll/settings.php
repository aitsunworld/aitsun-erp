 <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
                    <a class="href_loader" href="<?= base_url('hr_manage'); ?>">HR Management</a>
                </li>
             
                <li class="breadcrumb-item">
                    <a class="href_loader" href="<?= base_url('payroll'); ?>">Payroll</a>
                </li>
             
                <li class="breadcrumb-item active" aria-current="page">
                    <b class="page_heading text-dark">Addition/Deduction</b>
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
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="excel" data-table="#payroll_setting_table" data-filename="Payroll addition & deduction data <?= now_time($user['id']) ?>"> 
            <span class="my-auto">Excel</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="csv" data-table="#payroll_setting_table" data-filename="Payroll addition & deduction data <?= now_time($user['id']) ?>"> 
            <span class="my-auto">CSV</span>
        </a>
        <a href="javascript:void(0);" class="aitsun_table_export text-dark font-size-footer me-2" data-type="pdf" data-table="#payroll_setting_table" data-filename="Payroll addition & deduction data <?= now_time($user['id']) ?>"> 
            <span class="my-auto">PDF</span>
        </a>
      
      
        <a href="javascript:void(0);" class="aitsun_table_quick_search text-dark font-size-footer me-2" data-table="#payroll_setting_table"> 
            <span class="my-auto">Quick search</span>
        </a>

        <a href="<?= base_url('payroll/basic_salary'); ?>" class="text-dark font-size-footer me-2 href_loader"> 
            <span class="my-auto">Basic salary</span>
        </a> 

         
    </div>

    <div>
        <a data-bs-toggle="modal" data-bs-target="#add_payroll_settings" class="text-dark font-size-footer my-auto ms-2"> <span class="">+ Add</span></a>
    </div>
    
</div>
<!-- ////////////////////////// TOOL BAR END ///////////////////////// -->
 
 
  <div class="aitsun-modal modal fade" id="add_payroll_settings" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <form method="post" action="<?= base_url('payroll/add_payroll_fields')?>">
                    <?= csrf_field(); ?>
                <div class="modal-body">
                   
                    <div class="form-group mb-3">
                        <label class="form-label">Field name <small class="text-danger">(Numbers not allowed)</small></label>
                        <input type="text" class="form-control" name="field_name" pattern="[a-zA-Z\s]+" required>
                    </div>  

                    <div class="form-group mb-3">
                        <input type="radio" name="amount_type" id="add" value="addition" checked>
                        <label class="form-label" for="add">Earnings</label> 
                        <input type="radio" name="amount_type" id="ded" value="deduction">
                        <label class="form-label" for="ded">Deductions</label>  
                    </div>  

                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="aitsun-primary-btn">Save</button>
                 </div>
                </form>

            </div>
        </div>
    </div>
     

<!-- ////////////////////////// MAIN PAGE START ///////////////////////// -->
<div class="sub_main_page_content">
    <div class="aitsun-row"> 

        

        <div class="aitsun_table col-12 w-100 pt-0 pb-5">
            
            <table id="payroll_setting_table" class="erp_table no-hover">
             <thead>
                <tr>
                    <th class="text-center"><i class="bx bx-move"></i></th>
                    <th class="">Salary Rules<small>(Variables)</small></th>
                    <th class="">
                        <div class="d-flex justify-content-between">
                            <span class="my-auto">Formula</span> 
                            <a class="my-auto aitsun_link" data-bs-toggle="modal" data-bs-target="#help_modal"><i class="bx bx-info-circle"></i> Help</a>
                        </div>
                    </th>
                    <th class=" text-end" data-tableexport-display="none">Action</th> 
                </tr>
             
             </thead>
              <tbody class="row_position">
                <tr class="grabtr">
                    <td></td> 
                    <td class="vhover">
                        <div class="position-relative">
                            <span id="fname">Basic</span> 
                            <a class="click-to-copy vshow font-sm text-muted" data-selector="#fname">Click to copy</a>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <?php $fielddd=['Basic']; foreach ($payroll_fields as $prf): array_push($fielddd, $prf['field_name']); ?>
                <tr class="grabtr grabable" id="<?= $prf['id']; ?>">
                    <td class="text-center grab" style="width: 30px;">&#9776;</td>
                    <td class="vhover">
                        <div class="position-relative">
                            <span id="fname<?= $prf['id']; ?>"><?= $prf['field_name']; ?></span> 
                            <a class="click-to-copy vshow font-sm text-muted" data-selector="#fname<?= $prf['id']; ?>">Click to copy</a>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <input type="text" name="" class="formula_input" id="formula_input<?= $prf['id'] ?>" value="<?= $prf['formula'] ?>" placeholder="Leave blank for customization" data-id="<?= $prf['id'] ?>">
                            <button class="formula_save" data-id="<?= $prf['id'] ?>"><i class="bx bx-check"></i></button> 
                        </div>
                    </td>
                    <td class="" data-tableexport-display="none">
                        <?php if ($prf['deletable']!=1): ?>
                            <div class="d-flex justify-content-end my-auto">
                                <a class="text-info me-2" data-bs-toggle="modal" data-bs-target="#ed_payroll_fields<?= $prf['id']; ?>">
                                  <i class="bx bx-pencil"></i>
                                </a>



                                <a class="text-danger delete" data-url="<?= base_url('payroll/delete_payroll_fields'); ?>/<?= $prf['id']; ?>">
                                  <i class="bx bx-trash"></i>
                                </a>
                            </div>
                        <?php endif ?> 

                        <div class="aitsun-modal modal fade aitposmodal" id="ed_payroll_fields<?= $prf['id']; ?>"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Edit </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                  
                                </button>
                              </div>
                              <form method="post" action="<?= base_url('payroll/edit_payroll_fields')?>/<?= $prf['id']; ?>" id="ed_payroll_form<?= $prf['id']; ?>">
                                    <?= csrf_field(); ?>
                                <div class="modal-body">
                                   
                                        <div class="form-group mb-3">
                                            <label class="form-label">Field name <small class="text-danger">(Numbers not allowed)</small></label>
                                            <input type="text" class="form-control" name="field_name" pattern="[a-zA-Z\s]+" value="<?= $prf['field_name']; ?>" required>

                                            <input type="hidden" value="<?= $prf['field_name']; ?>" id="ed_field_name<?= $prf['id']; ?>">
                                        </div>

                                      

                                        <div class="form-group mb-3">
                                            <input type="radio" name="amount_type" id="add<?= $prf['id']; ?>" value="addition" <?php if($prf['amount_type']=='addition') echo "checked"; ?>>
                                            <label class="form-label" for="add<?= $prf['id']; ?>">Earnings</label> 
                                            <input type="radio" name="amount_type" id="ded<?= $prf['id']; ?>" value="deduction" <?php if($prf['amount_type']=='deduction') echo "checked"; ?>>
                                            <label class="form-label" for="ded<?= $prf['id']; ?>">Deductions</label>  
                                        </div>  

                                      
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="aitsun-primary-btn edit_payfield" data-id="<?= $prf['id']; ?>" name="edit_payfield" >Save</button>
                                 </div>
                                </form>
                            </div>

                          </div>
                        </div>
                    </td>
                </tr>
               <?php endforeach; ?>
               <tr>
                   <td colspan="4"><div style="height: 20px;"></div></td>
               </tr>
              </tbody>
            </table>
        </div>

        <textarea id="json_fields" class="d-none" value=""><?= json_encode($fielddd) ?></textarea>

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

<div class="aitsun-modal modal fade aitposmodal" id="help_modal"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formula helper </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body help-modal">
    <h5><b>Rule 1:</b> 
        <br>
        <!-- <h5>Add the Salary Rule with the specification weather to (+) earnings or to (-) deduction. </h5> -->
            Add the Salary Rule <br>
            While adding, select earnings (+) or deduction (-).  
        </h5>
        
        <h5><b>Rule 2:</b> <br>
            Copy text from salary rule column and paste it while creating formula.<br>
            If you are typing the formula, <strong>need to follow the below condition.</strong>
        </h5>
            <img style="width: 100%;" src="<?= base_url() ?>/public/images/screen.jpeg">
            <ul style="list-style: none; margin-top: 10px;">
                <li><i class="bx bx-check-circle text-success" style="margin-right: 10px;"> </i>Formula not accepted if the spelling mentioned Uppercase instead lowercase. </li>
                <li> <i class="bx bx-check-circle text-success" style="margin-right: 10px;"> </i>Only mathematical characters are accepted while creating formula( no other special characters accepted).</li>
            </ul>

        <h5><b>Rule 3:</b><br>
            Formula accepted only if the syntax (format) is correct.
        </h5>
            <span><b>Example:</b></span>
            <ul style="list-style: none;">
                <li><i class="bx bx-check-circle text-success" style="margin-right: 10px;"></i>(Basic+Add on+Incentive)-Penalty</li>
                <li><i class="bx bx-x-circle text-danger" style="margin-right: 10px;"></i>(Basic+Add on?Incentive)-penalty</li>
            </ul>

        <h5><b>Rule 4:</b> <br>
            Salary will be calculated in the same order as created in Salary rule column.
            <br>
            If you want to change the order, click the below marked button and just drag to make changes.
        </h5>
            <img style="width: 100%;" src="<?= base_url() ?>/public/images/screen1.webp">
      </div>
    </div> 
  </div>
</div>



 <script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','.amount_type',function(){ 
            var did=$(this).data('did');
            var type_value=$(this).val();
            if (type_value=='percentage') {
                $('#amount'+did).addClass('d-none');
                $('#percentage'+did).removeClass('d-none');
            }else{
                $('#amount'+did).removeClass('d-none');
                $('#percentage'+did).addClass('d-none');
            }
        });
    })
</script>

<script type="text/javascript">
 $(".grab").mousedown(function(e) {
  var tr = $(e.target).closest("TR"),
    si = tr.index(),
    sy = e.pageY,
    b = $(document.body),
    drag;
  if (si == 0) return;
  b.addClass("grabCursor").css("userSelect", "none");
  tr.addClass("grabbed");

  function move(e) {
    if (!drag && Math.abs(e.pageY - sy) < 10) return;
    drag = true;
    tr.siblings().each(function() {
      var s = $(this),
        i = s.index(),
        y = s.offset().top;
      if (i > 0 && e.pageY >= y && e.pageY < y + s.outerHeight()) {
        if (i < tr.index())
          tr.insertAfter(s);
        else
          tr.insertBefore(s);
        return false;
      }
    });
  }

  function up(e) {
    if (drag && si != tr.index()) {
      drag = false;
       var selectedData = new Array();
            $(".grabable").each(function() {
                if ($(this).attr("id")!='') {
                    selectedData.push($(this).attr("id"))
                };
            });
            updateOrder(selectedData);
    }
    $(document).unbind("mousemove", move).unbind("mouseup", up);
    b.removeClass("grabCursor").css("userSelect", "none");
    tr.removeClass("grabbed");
  }
  $(document).mousemove(move).mouseup(up);
});
 
    function updateOrder(aData) {

        var csrfName = $('#csrf_token').attr('name'); // CSRF Token name
        var csrfHash = $('#csrf_token').val(); // CSRF hash
        
        $.ajax({
            url: '<?= base_url('payroll/save_field_order') ?>',
            type: 'POST',
            data: {
                allData: aData,
                [csrfName]: csrfHash
            },
            success: function(resss) { 
                popup_message('success','Sort order updated!','');
            }
        });
    }
</script>
