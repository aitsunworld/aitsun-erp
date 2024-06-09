
 <?php
    $report_date=get_date_format(now_time($user['id']),'d M Y');
    $customer_name='';
    $from=get_date_format(now_time($user['id']),'Y-m-01');
    $to=get_date_format(now_time($user['id']),'Y-m-t');;

   if ($_GET) { 

        if (isset($_GET['accounts'])) {
            if (!empty($_GET['accounts'])) {
                $customer_name=user_name($_GET['accounts']).' -';
            } 
        }

        if (isset($_GET['from'])) {
            $from=$_GET['from'];
        }

        if (isset($_GET['to'])) {
            $to=$_GET['to'];
        }

        if (!empty($from) && empty($to)) {
            $report_date=get_date_format($from,'l').' - '.get_date_format($from,'d M Y');
        }
        if (!empty($to) && empty($from)) {
            $report_date=get_date_format($to,'l').' - '.get_date_format($to,'d M Y');
        }
        if (!empty($to) && !empty($from)) {
            $report_date=''.get_date_format($from,'d M Y').' to '.get_date_format($to,'d M Y');
        }

     }else{
        $report_date=''.get_date_format(now_time($user['id']),'F Y');
     }
?>

<div class="main_page_content ps-0 d-flex">
    <?= view('sidebar_menus') ?>
    <div class="menu_box ms-4  mt-4">
        
    <div class="d-flex">
        <div>
                <div class="d-flex mb-3 justify-content-between w-100">
                    <h6 class="text-white my-auto"><?=  $report_date ?></h6>
                    <div class="home-filters my-auto d-flex">
                        <a class="btn-back text-white my-auto ms-2" style="height:max-content;" href="<?= base_url() ?>?from=<?= get_date_format(now_time($user['id']),'Y-m-01') ?>&to=<?= get_date_format(now_time($user['id']),'Y-m-t') ?>">This month</a>

                        <a class="btn-back text-white my-auto ms-2" style="height:max-content;" href="<?= base_url() ?>?from=<?= date('Y-m-d', strtotime('-7 days', strtotime(get_date_format(now_time($user['id']),'Y-m-d')))) ?>&to=<?= get_date_format(now_time($user['id']),'Y-m-d') ?>">Last 7 days</a>

                        <a class="btn-back text-white my-auto ms-2" style="height:max-content;" href="<?= base_url() ?>?from=<?= get_date_format(now_time($user['id']),'Y-m-d') ?>&to=">Today</a>
                    </div>
                </div>
            <div class="aitsun-row">
                    
                    <div class="col-md-6">
                    <div class="row ">
                        <div class="col-md-6 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content sales_bg">
                                    <div class=" d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= round(get_inventories_summary($user['id'],'sales','quantity','',$from,$to,$customer_name)); ?></span>
                                        </div> 

                                        <div class="my-auto text-end">
                                            <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> <?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'sales','value','total',$from,$to,$customer_name); ?> </span> 
                                            <p class="text-white mb-0">Total Sales</p> 
                                        </div>
                                        
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <div class="col-md-6 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content purchase_bg">
                                    <div class=" d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= round(get_inventories_summary($user['id'],'purchase','quantity','',$from,$to,$customer_name)); ?></span>
                                        </div> 

                                        <div class="my-auto text-end">
                                            <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"><?= currency_symbol(company($user['id'])) ?> <?= get_inventories_summary($user['id'],'purchase','value','total',$from,$to,$customer_name); ?></span> 
                                            <p class="text-white mb-0">Total Purchases</p>
                                        </div>
                                        
                                    </div>
                                </div> 
                            </div>
                        </div>


                        <div class="col-md-6 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content income_bg">
                                    <div class=" d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= round(get_payments_summary($user['id'],'receipt','quantity','',$from,$to,$customer_name)); ?></span>
                                        </div> 

                                        <div class="my-auto text-end">
                                            <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> <?= currency_symbol(company($user['id'])) ?> <?= round(get_payments_summary($user['id'],'receipt','value','amount',$from,$to,$customer_name)); ?> </span> 
                                            <p class="mb-0 text-white">Other Incomes</p>
                                        </div>
                                        
                                    </div>
                                </div> 
                            </div>
                        </div>


                        <div class="col-md-6 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content expense_bg">
                                    <div class=" d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= round(get_payments_summary($user['id'],'expense','quantity','',$from,$to,$customer_name)); ?></span>
                                        </div> 

                                        <div class="my-auto text-end">
                                            <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> <?= currency_symbol(company($user['id'])) ?> <?= round(get_payments_summary($user['id'],'expense','value','amount',$from,$to,$customer_name)); ?> </span> 
                                            <p class="mb-0 text-white">Total Expenses</p>
                                        </div>
                                        
                                    </div>
                                </div> 
                            </div>
                        </div>


                        <div class="col-md-6 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content customer_bg">
                                    <div class="mb-0 d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= round(get_total_parties_data($user['id'],'customer','quantity')); ?></span>
                                        </div> 

                                        <div class="my-auto text-end"> 
                                            <p class="mb-0 text-white">Total Customers</p>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>



                        <div class="col-md-6 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content customer_bg">
                                    <div class="mb-0 d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= round(get_total_parties_data($user['id'],'vendor','quantity')); ?></span>
                                        </div> 

                                        <div class="my-auto text-end">  
                                            <p class="mb-0 text-white">Total Vendors</p>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                         <div class="col-md-12 ">
                           <div class="mb-3 card mini-stats ">
                                <div class="p-3 mini-stats-content products_bg">
                                    <div class="mb-0 d-flex justify-content-between"> 
                                        <div class=" number_box my-auto d-flex">
                                            <span class="m-auto"><?= total_products_of_company(company($user['id'])) ?></span>
                                        </div> 

                                        <div class="my-auto text-end">
                                            <span class="badge bg-light text-success my-2 cursor-pointer" title="Profit"> Stock value <?= currency_symbol(company($user['id'])) ?> <?= company_stock_value($user['id'],'average'); ?></span> 
                                            <p class="mb-0 text-white">Total Products/Services</p>
                                        </div>
                                        
                                    </div>
                                </div> 
                            </div>
                        </div>

                         
                    </div>
                </div>

                <div class="col-md-6 px-3">
                    <div class="row">
                        <div class="col-md-12 pe-0">
                            <div class="card mb-3">
                                <div 
                                    id="chart7"
                                    data-datetimes="'<?= get_chart_data($user['id'],'datetimes',$from,$to,$customer_name) ?>'"
                                    data-sales_incomes="<?= get_chart_data($user['id'],'sales_incomes',$from,$to,$customer_name) ?>"
                                    data-purchase_expenses="<?= get_chart_data($user['id'],'purchase_expenses',$from,$to,$customer_name) ?>" 
                                ></div>
         

                            </div> 
                        </div>

                        <div class="col-md-6">
                            <div class="alert alert-light d-flex justify-content-between" role="alert">
                              <div class="text-dark" style="font-weight:400;">Cash in Hand</div>
                              <b class="text-dark" style="font-weight: bold;"><?= currency_symbol(company($user['id'])) ?> <?= cash_in_hand(company($user['id'])) ?></b>
                            </div>
                        </div>

                        <div class="col-md-6 pe-0">
                             <div class="alert alert-light d-flex justify-content-between" role="alert">
                              <div class="text-dark" style="font-weight:400;">Cash in Bank</div>
                              <b class="text-dark" style="font-weight: bold;"><?= currency_symbol(company($user['id'])) ?> <?= cash_in_bank(company($user['id'])) ?></b>
                            </div>
                        </div>

                        <?php 
                            $to_receive=company_balance($user['id'],'receive');
                            $to_pay=company_balance($user['id'],'pay');
                            
                             
                         ?>

                        <div class="col-md-6">
                            <div class="alert alert-light d-flex justify-content-between" role="alert">
                              <div class="text-success">⇩ To Collect</div>
                              <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= str_replace('','', $to_receive); ?></b>
                            </div>
                        </div>

                        <div class="col-md-6 pe-0">
                             <div class="alert alert-light d-flex justify-content-between" role="alert">
                              <div class="text-danger">⇧ To Pay</div>
                              <b class="text-dark"><?= currency_symbol(company($user['id'])) ?> <?= str_replace('','', $to_pay); ?></b>
                            </div>
                        </div>

                       
                    </div>
                </div>
                 
            </div>
       </div>

        <div>
            <?php if (count($my_appointments)>0): ?> 
            <div class="appointments_notification ms-3">
                <h6 class="text-dark">My Appointments Today</h6>
                <div>
                    <ul>
                        <?php $aps=0;  foreach ($my_appointments as $bk): $aps++;?> 
                        <li>
                             <div class="mb-1">
                                <b><?= $aps ?>. <?= $bk['booking_name'] ?></b>   
                            </div>
                            <div class="d-flex">
                                <b class="text-success">
                                 <?= get_date_format($bk['book_from'],'h:i A') ?>
                                </b> 
                                <i class="bx bx-arrow-back d-block mx-2" style="transform: rotate(180deg);"></i> 
                               <div><?= user_data($bk['customer'],'display_name') ?></div>  
                            </div>
                        </li>
                        <?php endforeach ?>
                        <li class="text-center">
                            <a class="btn btn-back-dark btn-sm text-center" href="<?= base_url('appointments/book_persons/my_appointments') ?>">Manage All</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>

    </div>
</div>
 <script src="<?= base_url('public') ?>/js/chartjs/apexcharts.min.js"></script>
<script src="<?= base_url('public') ?>/js/chartjs/apex-custom.js"></script>