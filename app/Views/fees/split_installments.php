<?php
    $etype=''; 
    if ($_GET) {
        if (isset($_GET['etype'])) {
            if (!empty($_GET['etype'])) {
                $etype=$_GET['etype'];
            }
        }
    }
?>

 <?php if ($etype!='ajaxex'): ?>
 <!-- Page Container START -->
<div class="page-container">

   

    <!-- Content Wrapper START -->
    <div class="main-content">


 <?php endif ?> 
        <div class="page-header">
            <div class="d-flex justify-content-between">
                <div class="my-auto">
                    <h2 class="header-title mr-0 mb-0 ">Create Installment for <?= inventory_prefix(company($user['id']),$invoice_data['invoice_type']) ?><?= $invoice_data['serial_no'] ?></h2>
                </div>
                <div class="my-auto">
                    <?php if ($invoice_data['is_installment']!=1): ?>
                        <a class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#split_installment_modal"><span>Create</span></a>
                    <?php endif ?> 
                </div>
            </div> 
            

            <!-- Modal -->
                     <div class="modal fade" id="split_installment_modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addteamLabel">Installment</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="anticon anticon-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    
                                    <form method="post" action="<?= base_url('fees_and_payments/add_installments'); ?>">
                                        <?= csrf_field() ?>

                                        <h6>Payable amount: <span class="text-success"><?= currency_symbol(company($user['id'])) ?> <?= number_format($invoice_data['due_amount'],2,'.',''); ?></span></h6>

                                        <div class="form-group">
                                            <input type="hidden" name="invoice_id" value="<?= $invoice_data['id']; ?>">
                                            <input type="hidden" id="due_amount" name="due_amount" value="<?= $invoice_data['due_amount']; ?>">
                                            <input type="hidden" id="cursymb" value="<?= currency_symbol(company($user['id'])) ?>">
                                            
                                            <label>No. of installments</label>
                                            <select class="form-control" name="no_of_installments" id="no_of_installments" required>
                                                <option value="">Choose</option> 
                                                <option value="2">2 installments</option> 
                                                <option value="3">3 installments</option> 
                                                <option value="4">4 installments</option> 
                                                <option value="6">6 installments</option> 
                                                <option value="12">12 installments</option> 
                                            </select> 
                                        </div>

                                        <div class="form-group">
                                            <label>Day for payment</label> 
                                            <select class="form-control" name="day_for_payment" id="day_for_payment" required>
                                                <option value="1">1st</option>  
                                                <option value="2">2nd</option>  
                                                <option value="3">3rd</option>  
                                                <option value="4">4th</option> 
                                                <option value="5">5th</option> 
                                                <option value="6">6th</option> 
                                                <option value="7">7th</option> 
                                                <option value="8">8th</option> 
                                                <option value="9">9th</option> 
                                                <option value="10">10th</option> 
                                                <option value="11">11th</option> 
                                                <option value="12">12th</option> 
                                                <option value="13">13th</option> 
                                                <option value="14">14th</option> 
                                                <option value="15">15th</option> 
                                                <option value="16">16th</option> 
                                                <option value="17">17th</option> 
                                                <option value="18">18th</option> 
                                                <option value="19">19th</option> 
                                                <option value="20">20th</option> 
                                                <option value="21">21th</option> 
                                                <option value="22">22th</option> 
                                                <option value="23">23rd</option> 
                                                <option value="24">24th</option> 
                                                <option value="25">25th</option> 
                                                <option value="26">26th</option> 
                                                <option value="27">27th</option> 
                                                <option value="28">28th</option>  
                                            </select>  
                                        </div>

                                        <div class="form-group">
                                            <label>EMI Calculator</label>
                                            <table id="emi_calcultor" class="w-100 table table-sm">
                                                
                                            </table>
                                        </div>

                                        <div class="form-group"> 
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </div> 
                                    </form>
                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
            
        </div>
        <div class="row">

            <div class="col-lg-12 pt-3">
            <?php if (session()->get('sosubctsuccess')): ?>
                    <div class="alert alert-success">
                        <div class="d-flex align-items-center justify-content-start">
                            <span class="alert-icon">
                                <i class="anticon anticon-check-o"></i>
                            </span>
                            <span><?= session()->get('sosubctsuccess') ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('sosubcterror')): ?>
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center justify-content-start">
                            <span class="alert-icon">
                                <i class="anticon anticon-check-o"></i>
                            </span>
                            <span><?= session()->get('sosubcterror') ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-12"> 
                <div class="d-flex justify-content-between">
                    <label><?= count($all_installments) ?> Installments</label>
                    <a data-url="<?= base_url('fees_and_payments/delete_all_installments') ?>/<?= $invoice_data['id'] ?>" class="text-danger delete cursor-pointer">Delete All</a>
                </div>
                <table class="w-100 table table-sm">
                    <tr>
                        <th>#</th>
                        <th>-</th>
                        <th>Amount</th>
                        <th>Due on</th>
                        <th>Payment</th>
                        <th class="text-right">Action</th>
                    </tr>
                    <?php $i=0; foreach ($all_installments as $ai): $i++; ?>
                        <tr>
                            <td>Installment <?= $ai['installment_name'] ?></td>
                            <td>-</td>
                            <td><?= currency_symbol(company($user['id'])) ?> <?= $ai['amount'] ?></td>
                            <td><?= get_date_format($ai['date'],'d M Y') ?></td>
                            <td>
                                <?php if ($ai['paid_status']=='paid'): ?>
                                    <span class="badge badge-pill badge-success">Paid</span>
                                <?php endif ?>

                                <?php if ($ai['paid_status']=='unpaid'): ?>
                                    <span class="badge badge-pill badge-danger">Unpaid</span>
                                <?php endif ?>
                            </td>
                            <td class="text-right">
                                <?php if ($ai['paid_status']=='unpaid'): ?>
                                <a href="<?= base_url('fees_and_payments/payments') ?>/<?= $invoice_data['id'] ?>" class="btn btn-sm btn-success rounded-pill">Pay</a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>



            
            
                   
            
        </div>
       
        
 <?php if ($etype!='ajaxex'): ?>

    </div>
    <!-- Content Wrapper END -->


</div>
<!-- Page Container END -->
<?php endif ?>