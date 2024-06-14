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
<div class="main_page_content ">
 
        

    <div class="report_menu_box">

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('day_end_summary'); ?>">
            <img src="<?= base_url('public/images/menu_icons/day_end_summary.webp') ?>" class="menu_img">
            <div class="menu-title">Day End Summary</div>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('cash_book'); ?>">
            <img src="<?= base_url('public/images/menu_icons/cash_book.webp') ?>" class="menu_img">
            <div class="menu-title">Cash Book</div>
        </a>
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('day_book'); ?>">
            <img src="<?= base_url('public/images/menu_icons/day_book.webp') ?>" class="menu_img">
            <div class="menu-title">Day Book</div>
        </a> 
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('bank_book'); ?>">
            <img src="<?= base_url('public/images/menu_icons/bank_book.webp') ?>" class="menu_img">
            <div class="menu-title">Bank Book</div>
        </a>
          
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('item_wise_sales_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/profit_report.webp') ?>" class="menu_img">
            <div class="menu-title">Item wise sales Report</div>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('profit_and_loss_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/profit_loss_report.webp') ?>" class="menu_img">
            <div class="menu-title">Profit & Loss Report</div>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('reports/vendors_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/vendor.webp') ?>" class="menu_img">
            <div class="menu-title">Vendors Report</div>
        </a>
         
  <!--       <a class="menu_icon text-dark cursor-pointer href_loader" href="<= base_url('item_reports'); ?>">
            <img src="<= base_url('public/images/menu_icons/vendor.webp') ?>" class="menu_img">
            <div class="menu-title">Items Report</div>
        </a> -->

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('expense_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/expense_report.webp') ?>" class="menu_img">
            <div class="menu-title">Expense Report</div>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('discount_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/discount_report.webp') ?>" class="menu_img">
            <div class="menu-title">Discount Report</div>
        </a>
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('stock_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/stock_report.webp') ?>" class="menu_img">
            <div class="menu-title">Stock Report</div>
        </a>

        <?php if (get_company_data(company($user['id']),'country')=='India'): ?>

            <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('gst_report'); ?>">
                <img src="<?= base_url('public/images/menu_icons/gst_report.webp') ?>" class="menu_img">
                <div class="menu-title">GST Report</div>
            </a>  

        <?php else: ?>

             <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('gst_report/vat_report'); ?>">
                <img src="<?= base_url('public/images/menu_icons/gst_report.webp') ?>" class="menu_img">
                <div class="menu-title">VAT Report</div>
            </a>    
        <?php endif ?>

        <?php if (is_school(company($user['id']))): ?>
         <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('fees-wise-outstanding'); ?>">
            <img src="<?= base_url('public/images/menu_icons/outstanding.webp') ?>" class="menu_img">
            <div class="menu-title">Fees Outstanding Statement</div>
        </a>
       <?php endif ?>
       
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('credit_statement/sales'); ?>">
            <img src="<?= base_url('public/images/menu_icons/outstanding.webp') ?>" class="menu_img">
            <div class="menu-title">Outstanding Statement</div>
        </a>
        
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('sales_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/sales_report.webp') ?>" class="menu_img">
            <div class="menu-title">Sales Report</div>
        </a> 

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('time_flow_sales_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/sales_report.webp') ?>" class="menu_img">
            <div class="menu-title">Time flow sales report</div>
        </a> 

         <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('reports/receipt_payment'); ?>">
            <img src="<?= base_url('public/images/menu_icons/receipt_payment.png') ?>" class="menu_img">
            <div class="menu-title">Receipt & Payment</div>
        </a> 

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('reports/activity_logs'); ?>?page=1">
            <img src="<?= base_url('public/images/menu_icons/attendance.webp') ?>" class="menu_img">
            <div class="menu-title">Activity Logs</div>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('reports/user_wise_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/profit_report.webp') ?>" class="menu_img">
            <div class="menu-title">User wise Report</div>
        </a>

        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('reports/referral_report'); ?>">
            <img src="<?= base_url('public/images/menu_icons/profit_report.webp') ?>" class="menu_img">
            <div class="menu-title">Referral Report</div>
        </a>

        <?php if (is_school(company($user['id']))): ?>
        <a class="menu_icon text-dark cursor-pointer href_loader" href="<?= base_url('reports/student_attendance_reports'); ?>">
            <img src="<?= base_url('public/images/menu_icons/profit_report.webp') ?>" class="menu_img">
            <div class="menu-title">Students Attendance Report</div>
        </a>
        <?php endif ?>
         
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


 