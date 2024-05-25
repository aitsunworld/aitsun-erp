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
                    <b class="page_heading text-dark">Reports</b>
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
<div class="main_page_content special_reports_page">
    
    <div class="aitsun-row">
        <div class="col-md-4 special_reports_block">
            <div class="pe-1 pb-5">
                <h6 class="sr_heading">Transaction report</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/sale') ?>">Sale</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/purchase') ?>">Purchase</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/day-book') ?>">Day book</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/all-transactions') ?>">All Transactions</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/profit-and-loss') ?>">Profit And Loss</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/bill-wise-profit') ?>">Bill Wise Profit</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/cash-flow') ?>">Cash flow</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/trial-balance-report') ?>">Trial Balance Report</a>
                    </li>
                    <li>
                        <a href="<?= base_url('special_reports/balance-sheet') ?>">Balance Sheet</a>
                    </li>
                </ul>


             

                 <h6 class="sr_heading">Expense report</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/expense') ?>">Expense</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/expense-category-report') ?>">Expense Category Report</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/expense-item-report') ?>">Expense Item Report</a>
                    </li> 
                </ul>

                <h6 class="sr_heading">Sale/ Purchase Order report</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/sale-purchase-orders') ?>">Sale/ Purchase Orders</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/sale-purchase-order-item') ?>">Sale/ Purchase Order Item</a>
                    </li>
                </ul>



                
            </div> 
        </div>


        <div class="col-md-4 special_reports_block">
            <div class="pe-1">
                <h6 class="sr_heading">Party report</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/party-statement') ?>">Party Statement</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/party-wise-profit-loss') ?>">Party wise Profit & Loss</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/all-parties') ?>">All parties</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/party-report-by-item') ?>">Party Report By Item</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/sale-purchase-by-party') ?>">Sale Purchase By Party</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/sale-purchase-by-party-group') ?>">Sale Purchase By Party Group</a>
                    </li> 

                </ul>



                <h6 class="sr_heading">Item/Stock report</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/stock-summaryt') ?>">Stock summary</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/item-serial-report') ?>">Item Serial Report</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/item-batch-report') ?>">Item Batch Report</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/party-item-report') ?>">Item Report By Party</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/item-profit-loss') ?>">Item Wise Profit And Loss</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/low-stock-summary') ?>">Low Stock Summary</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/stock-detail') ?>">Stock Detail</a>
                    </li>

                     <li>
                        <a href="<?= base_url('special_reports/item-detail') ?>">Item Detail</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/item-category-sales-purchase-report') ?>">Sale/ Purchase Report By Item Category</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/stock-summary-report-by-item-category') ?>">Stock Summary Report By Item Category</a>
                    </li>

                    <li>
                        <a href="<?= base_url('item-wise-discount') ?>">Item Wise Discount</a>
                    </li>
                </ul>

         
                


            </div> 
        </div>


        <div class="col-md-4 special_reports_block">
            <div class="pe-1">
                <h6 class="sr_heading">GST reports</h6>
                <ul>
           
                    
                    <li>
                        <a href="<?= base_url('special_reports/gstr-1') ?>">GSTR 1</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/gstr-2') ?>">GSTR 2</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/gstr-3b') ?>">GSTR 3 B</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/gstr-9') ?>">GSTR 9</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/sale-summary-by-hsn') ?>">Sale Summary By HSN</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/sac-report') ?>">SAC Report</a>
                    </li> 

                </ul>

                <h6 class="sr_heading">Taxes</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/gst-report') ?>">GST Report</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/gst-rate-report') ?>">GST Rate Report</a>
                    </li>

                    <li>
                        <a href="<?= base_url('special_reports/form-no-27EQ') ?>">Form No. 27EQ</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/tcs-receivable') ?>">TCS Receivable</a>
                    </li>
                </ul>

                <h6 class="sr_heading">Business Status</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/bank-statement') ?>">Bank Statement</a>
                    </li> 

                    <li>
                        <a href="<?= base_url('special_reports/discount-report') ?>">Discount Report</a>
                    </li>  
                </ul>

                
                <h6 class="sr_heading">Loan Accounts</h6>
                <ul>
                    <li>
                        <a href="<?= base_url('special_reports/loan-statement   ') ?>">Loan Statement</a>
                    </li> 
                </ul>



            </div> 
        </div>




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


 