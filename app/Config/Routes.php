<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/submenu', 'Submenu::index');
$routes->get('/get_states/(:any)', 'Home::get_states/$1');

$routes->get('/users/login', 'Users::login');
$routes->get('/users', 'Users::login');
$routes->post('/users/login', 'Users::login');
$routes->get('/users/logout', 'Users::logout'); 
$routes->get('/accounting_library', 'Accounting_library::index');
$routes->get('/cron_jobs', 'Cron_jobs::index');

$routes->get('/notifications/display_notifications', 'Notifications::display_notifications'); 
$routes->get('/notifications/not_indic', 'Notifications::not_indic'); 
$routes->get('/notifications/fees_remind/(:any)', 'Notifications::fees_remind/$1'); 

$routes->get('/home/search/(:any)', 'Home::search/$1'); 
$routes->get('/notifications', 'Notifications::index'); 
$routes->get('/redirect_notify', 'redirect_notify::index');


$routes->get('/users/student_suggestions/(:any)', 'Users::student_suggestions/$1'); 
$routes->get('/users/get_unpaid_fees_of_student/(:any)', 'Users::get_unpaid_fees_of_student/$1'); 
$routes->get('/users/get_all_standard_fees_of_student/(:any)', 'Users::get_all_standard_fees_of_student/$1'); 
$routes->get('/users/get_all_transport_fees_of_student/(:any)', 'Users::get_all_transport_fees_of_student/$1'); 
$routes->get('/users/get_all_transport_locations/(:any)', 'Users::get_all_transport_locations/$1'); 
 
////////// Parties /////////////
$routes->get('/appointments', 'Appointments::index');
$routes->get('/appointments/create', 'Appointments::create');
$routes->get('/appointments/create/(:any)', 'Appointments::create/$1');
$routes->get('/appointments/resources', 'Appointments::resources');
$routes->post('/appointments/add_resources', 'Appointments::add_resources');
$routes->post('/appointments/update_resources/(:any)', 'Appointments::update_resources/$1');
$routes->get('/appointments/book_persons', 'Appointments::book_persons');
$routes->get('/appointments/book_persons/my_appointments', 'Appointments::book_persons/person/my_appointments');

$routes->get('/appointments/book_resources', 'Appointments::book_persons/resource');

$routes->get('/appointments/delete_resource/(:any)', 'Appointments::delete_resource/$1');
$routes->get('/appointments/get_timings/(:any)', 'Appointments::get_timings/$1');

$routes->get('/appointments/get_booking_form/(:any)/(:any)/(:any)', 'Appointments::get_booking_form/$1/$2/$3');
$routes->get('/appointments/get_booking_edit_form/(:any)', 'Appointments::get_booking_edit_form/$1');
$routes->post('/appointments/save_booking/(:any)', 'Appointments::save_booking/$1');
$routes->get('/appointments/delete_booking/(:any)', 'Appointments::delete_booking/$1');

$routes->get('/appointments/get_booking_form', 'Appointments::get_booking_form');
$routes->post('/appointments/save_appointments', 'Appointments::save_appointments');
$routes->post('/appointments/delete_appointment/(:any)', 'Appointments::delete_appointment/$1');
 
$routes->get('/appointments/confirm_checkin/(:any)/(:any)', 'Appointments::confirm_checkin/$1/$2');
$routes->get('/appointments/reports', 'Appointments::reports');
 
$routes->post('/appointments/update_resource_img/(:any)', 'Appointments::update_resource_img/$1');
 
//rental management 
$routes->get('/rental', 'Rental::index');

////////// Parties /////////////
$routes->get('/customers', 'Customers::index'); 
$routes->get('/customers/add', 'Customers::add'); 
$routes->get('/customers/add_customer_form', 'Customers::add_customer_form'); 
$routes->post('/customers/save_customer', 'Customers::save_customer');
$routes->post('/customers/add_party_from_selector', 'Customers::add_party_from_selector');
 
$routes->get('/customers/details/(:any)', 'Customers::details/$1'); 
$routes->post('/customers/details/(:any)', 'Customers::details/$1'); 
$routes->get('/customers/delete/(:any)', 'Customers::delete/$1'); 
$routes->post('/customers/add_part_cate_from_ajax', 'Customers::add_part_cate_from_ajax'); 

////////// Import & export /////////////
$routes->get('/import_and_export/parties', 'Import_and_export::parties'); 
$routes->get('/import_and_export/export_parties', 'Import_and_export::export_parties');  
$routes->get('/import_and_export/students', 'Import_and_export::students');
$routes->get('/import_and_export/export_students', 'Import_and_export::export_students');
$routes->post('/import_and_export/import_students', 'Import_and_export::import_students');
$routes->post('/import_and_export/import_parties', 'Import_and_export::import_parties');
$routes->post('/import_and_export/import_parties_ajax', 'Import_and_export::import_parties_ajax');

////////// POS /////////////
$routes->get('/pos', 'Pos::index'); 
$routes->post('/pos', 'Pos::index'); 
$routes->get('/pos/delete_register/(:num)', 'Pos::index/$1'); 

$routes->get('/pos/create/(:any)', 'Pos::create/$1'); 
$routes->post('/pos/open_session', 'Pos::open_session'); 
$routes->get('/pos/close_register/(:any)', 'Pos::close_register/$1');
$routes->post('/pos/change_pos_mode/(:any)', 'Pos::change_pos_mode/$1');
$routes->get('/pos/orders', 'Pos::orders');
$routes->get('/pos/floors', 'Pos::floors');
$routes->get('/pos/floors/new_floor', 'Pos::new_floor');
$routes->post('/floors/save_floors', 'Pos::save_floors');
  

////////// Inventories /////////////
$routes->get('/invoices/sales', 'Invoices::sales'); 
$routes->get('/purchases/purchases', 'Purchases::purchases'); 
$routes->get('/invoices/create_invoice', 'Invoices::create_invoice'); 
$routes->get('/sales/display_products', 'Sales::display_products'); 
$routes->post('/sales', 'Sales::index'); 
$routes->get('/invoices/get_invoice/(:any)', 'Invoices::get_invoice/$1'); 
$routes->get('/invoices/convert_to_sale/(:any)', 'Invoices::convert_to_sale/$1'); 
$routes->get('/invoices/convert_invoice/(:any)', 'Invoices::convert_invoice/$1'); 
$routes->get('/invoices/convert_to_sale_delivery_note/(:any)', 'Invoices::convert_to_sale_delivery_note/$1'); 


$routes->post('/sales/change_rental_status/(:any)/(:any)', 'Sales::change_rental_status/$1/$2'); 


$routes->get('/invoices/get_invoice_pdf/(:any)/(:any)', 'Invoices::get_invoice_pdf/$1/$2'); 
$routes->get('/invoices/view_pdf/(:any)', 'Invoices::view_pdf/$1');
$routes->get('/invoices/get_invoice_html/(:any)/(:any)', 'Invoices::get_invoice_html/$1/$2'); 
$routes->get('/invoices/details/(:any)', 'Invoices::details/$1'); 
$routes->get('/invoices/generate_short_link/(:any)', 'Invoices::generate_short_link/$1'); 
$routes->get('/invoices/edit/(:any)', 'Invoices::edit/$1'); 
$routes->get('/invoices/copy/(:any)', 'Invoices::copy/$1'); 
$routes->get('/invoices/pay/(:any)', 'Invoices::pay/$1'); 
$routes->get('/invoices/delete/(:any)', 'Invoices::delete/$1'); 
$routes->get('/payments/delete_from_invoice/(:any)/(:any)', 'Payments::delete_from_invoice/$1/$2');  
$routes->get('/payments/details/(:any)', 'Payments::details/$1');  
$routes->get('/payments/get_receipt/(:any)/(:any)', 'Payments::get_receipt/$1/$2');   
$routes->post('/invoices/update_pay', 'Invoices::update_pay'); 
$routes->post('/sales/update_invoice/(:any)', 'Sales::update_invoice/$1'); 
$routes->get('/invoices/get_thermal_script/(:any)', 'Invoices::get_thermal_script/$1');
$routes->get('/invoices/get_pos_invoice/(:any)', 'Invoices::get_pos_invoice/$1');
$routes->get('/sales/get_barcode_product/(:any)', 'Sales::get_barcode_product/$1'); 
$routes->get('/purchases/create_purchase', 'Purchases::create_purchase'); 
$routes->get('/invoices/create_sales_quotation', 'Invoices::create_sales_quotation'); 
$routes->get('/invoices/create_sales_order', 'Invoices::create_sales_order'); 
$routes->get('/invoices/create_sales_delivery_note', 'Invoices::create_sales_delivery_note'); 
$routes->get('/invoices/sales_return', 'Invoices::sales_return'); 
$routes->get('/purchases/create_purchase_order', 'Purchases::create_purchase_order'); 
$routes->get('/purchases/create_purchase_delivery_note', 'Purchases::create_purchase_delivery_note'); 
$routes->get('/purchases/purchase_return', 'Purchases::purchase_return');
$routes->get('/purchases/convert_to_purchase/(:any)', 'Purchases::convert_to_purchase/$1'); 
$routes->get('/purchases/convert_to_purchase_delivery_note/(:any)', 'Purchases::convert_to_purchase_delivery_note/$1'); 
$routes->get('/invoices/create_proforma_invoice', 'Invoices::create_proforma_invoice');


$routes->post('/products/update_price/(:any)', 'Products::update_price/$1'); 

$routes->get('/invoices/download/(:any)', 'Invoices::download/$1'); 

////////////////////// Vouchers //////////////////////////
$routes->get('/voucher_entries/', 'Voucher_entries::index'); 
$routes->get('/voucher_entries/add', 'Voucher_entries::add/add/receipt'); 
$routes->get('/voucher_entries/edit/(:any)', 'Voucher_entries::edit/$1');  
$routes->get('/voucher_entries/details/(:any)', 'Voucher_entries::details/$1');  
$routes->get('/voucher_entries/delete/(:any)', 'Voucher_entries::delete/$1');   
$routes->get('/voucher_entries/get_voucher/(:any)/(:any)', 'Voucher_entries::get_voucher/$1/$2');   
$routes->get('/voucher_entries/get_voucher/(:any)', 'Voucher_entries::get_voucher/$1');   
$routes->get('/voucher_entries/add/expense', 'Voucher_entries::add/add/expense'); 
$routes->get('/voucher_entries/display_particulars', 'Voucher_entries::display_particulars'); 
$routes->post('/voucher_entries/insert_voucher', 'Voucher_entries::insert_voucher'); 
$routes->post('/voucher_entries/update_voucher/(:any)', 'Voucher_entries::update_voucher/$1'); 
$routes->get('/voucher_entries/get_thermal_script/(:any)', 'Voucher_entries::get_thermal_script/$1'); 
 

///////////////////// Accounts /////////////////
$routes->get('/accounts/get_ledger_ac_form', 'Accounts::get_ledger_ac_form');  
$routes->post('/accounts/add_ledger_ajax', 'Accounts::add_ledger_ajax');

//////////////////// Payments /////////////////
$routes->get('/payments/delete/(:any)', 'Payments::delete/$1');  

////////// Business Operations ///////////// 
$routes->get('/business-operations', 'Business_operations::index'); 


// $routes->get('/crm', 'Crm::index'); 
// $routes->get('/crm/get_against_data', 'Crm::get_against_data'); 

///////////// Website /////////////////
$routes->get('/website_management', 'Website_management::index');  
$routes->post('/website_management', 'Website_management::index');  
$routes->get('/website_management/enquiries', 'Website_management::enquiries'); 
$routes->get('/website_management/social_media', 'Website_management::social_media'); 
$routes->post('/website_management/social_media', 'Website_management::social_media'); 
$routes->get('/website_management/posts', 'Website_management::posts'); 
$routes->get('/website_management/create_post', 'Website_management::create_post'); 
$routes->get('/website_management/categories', 'Website_management::post_categories'); 
$routes->post('/website_management/categories', 'Website_management::post_categories'); 
$routes->post('/website_management/edit_cat', 'Website_management::edit_cat'); 
$routes->post('/website_management/add_cat_from_ajax', 'Website_management::add_cat_from_ajax'); 


 
$routes->post('/website_management/add_post', 'Website_management::add_post'); 
$routes->post('/website_management/update_post', 'Website_management::update_post');  
$routes->get('/website_management/deletepost/(:any)', 'Website_management::deletepost/$1');
$routes->get('/website_management/edit_post/(:any)', 'Website_management::edit_post/$1');
$routes->get('/website_management/deletecat/(:any)', 'Website_management::deletecat/$1');
$routes->get('/website_management/remove_featured/(:any)', 'Website_management::remove_featured/$1');
$routes->get('/website_management/remove_thumbnail/(:any)', 'Website_management::remove_thumbnail/$1');



$routes->get('/website_management/email_integration', 'Website_management::email_integration'); 
$routes->post('/website_management/email_integration', 'Website_management::email_integration'); 
$routes->get('/website_management/api_details', 'Website_management::api_details'); 
$routes->post('/website_management/api_details', 'Website_management::api_details'); 
$routes->get('/website_management/delete_enquiries/(:any)', 'Website_management::delete_enquiries/$1'); 
$routes->get('/website_management/deletesoc/(:any)', 'Website_management::deletesoc/$1'); 
$routes->post('/website_management/editsoc', 'Website_management::editsoc'); 

$routes->get('/website_management/reviews', 'Website_management::reviews');
$routes->post('/website_management/add_review', 'Website_management::add_review');
$routes->post('/website_management/edit_review', 'Website_management::edit_review');
$routes->get('/website_management/delete_review/(:any)', 'Website_management::delete_review/$1');


$routes->get('/website_management/clients', 'Website_management::clients');
$routes->post('/website_management/add_client', 'Website_management::add_client');
$routes->post('/website_management/edit_client', 'Website_management::edit_client');
$routes->get('/website_management/delete_client/(:any)', 'Website_management::delete_client/$1');



///////////// HR Management ////////////////////
$routes->get('/hr_manage', 'Hr_manage::index');
$routes->get('/hr_manage/attendance/', 'Hr_manage::attendance'); 
$routes->get('/hr_manage/attendance/(:any)', 'Hr_manage::attendance/$1'); 
$routes->get('/hr_manage/employee_lists', 'Hr_manage::employee_lists');  
$routes->get('/hr_manage/attendance_settings', 'Hr_manage::attendance_settings');  
$routes->post('/hr_manage/attendance_settings', 'Hr_manage::attendance_settings');  
$routes->post('/hr_manage/add_attendance', 'Hr_manage::add_attendance');
$routes->post('/hr_manage/push_attendance', 'Hr_manage::push_attendance');
$routes->post('/hr_manage/manual_push_punch', 'Hr_manage::manual_push_punch'); 
$routes->get('/hr_manage/delete_punch/(:any)', 'Hr_manage::delete_punch/$1');  
$routes->post('/hr_manage/edit_punch/(:any)', 'Hr_manage::edit_punch/$1'); 
$routes->post('/hr_manage/update_note/(:any)', 'Hr_manage::update_note/$1'); 


 
$routes->get('/hr_manage/attendance_report', 'Hr_manage::attendance_report'); 
$routes->get('/hr_manage/detailed_attendance_report', 'Hr_manage::detailed_attendance_report'); 
 
$routes->get('/hr_manage/delete_employee_data/(:any)', 'Hr_manage::delete_employee_data/$1');  
$routes->get('/hr_manage/delete_event/(:any)', 'Hr_manage::delete_event/$1');  
$routes->get('/hr_manage/delete_work_shift/(:any)', 'Hr_manage::delete_work_shift/$1');  
$routes->get('/hr_manage/attendance_report/leave_report', 'Hr_manage::attendance_report/leave_report');  
$routes->post('/hr_manage/allow_emp_attendance/(:any)', 'Hr_manage::allow_emp_attendance/$1');  
$routes->post('/hr_manage/edit_staff_data/(:any)', 'Hr_manage::edit_staff_data/$1');
$routes->get('/hr_manage/leave_management', 'Hr_manage::leave_management');
$routes->post('/hr_manage/leave_management', 'Hr_manage::leave_management');
$routes->get('/hr_manage/employee_categories', 'Hr_manage::employee_categories');
$routes->post('/hr_manage/employee_categories', 'Hr_manage::employee_categories');
$routes->get('/hr_manage/delete_employee_category/(:any)', 'Hr_manage::delete_employee_category/$1');



//////////// PAYROLL //////////////////////////
$routes->get('/payroll', 'Payroll::index');
$routes->get('/payroll/basic_salary', 'Payroll::basic_salary');
$routes->get('/payroll/settings', 'Payroll::settings');
$routes->get('/payroll/create_payroll', 'Payroll::create_payroll');
$routes->post('/payroll/add_basic_salary', 'Payroll::add_basic_salary');
$routes->post('/payroll/add_payroll', 'Payroll::add_payroll');
$routes->get('/payroll/edit/(:any)', 'Payroll::edit/$1'); 
$routes->post('/payroll/edit_payroll/(:any)', 'Payroll::edit_payroll/$1'); 
$routes->get('/payroll/delete_payroll/(:any)', 'Payroll::delete_payroll/$1'); 
$routes->post('/payroll/edit_payroll_fields/(:any)', 'Payroll::edit_payroll_fields/$1'); 
 $routes->get('/payroll/delete_payroll_fields/(:any)', 'Payroll::delete_payroll_fields/$1'); 
 $routes->get('/payroll/view_payroll_slip/(:any)', 'Payroll::view_payroll_slip/$1');
 $routes->get('/payroll/view_salary_slip/(:any)', 'Payroll::view_salary_slip/$1'); 
 $routes->post('/payroll/save_formula/(:any)', 'Payroll::save_formula/$1'); 
 $routes->post('/payroll/save_field_order', 'Payroll::save_field_order'); 
 $routes->post('/payroll/save_manual_payroll_field_values', 'Payroll::save_manual_payroll_field_values'); 


 $routes->post('/payroll/add_payroll_fields', 'Payroll::add_payroll_fields'); 
$routes->get('/payroll/get_payroll_slip/(:any)/(:any)', 'Payroll::get_payroll_slip/$1/$2');
$routes->get('/payroll/get_salary_slip/(:any)/(:any)', 'Payroll::get_salary_slip/$1/$2');
$routes->get('/payroll/view_salary_slip_design/(:any)/(:any)', 'Payroll::view_salary_slip_design/$1/$2');
 
 

/////////////// Messaging ///////////////////
$routes->get('messaging/display_all_students', 'Messaging::display_all_students');
$routes->post('messaging/message', 'Messaging::message');
$routes->get('messaging/messaging_sucmes', 'Messaging::messaging_sucmes');
$routes->get('messaging/send_bulk_sms', 'Messaging::send_bulk_sms');
$routes->get('messaging/message_history', 'Messaging::message_history');
$routes->post('messaging/fees_remind/(:any)', 'Messaging::fees_remind/$1');
$routes->post('messaging/publish_exam_via_sms/(:any)', 'Messaging::publish_exam_via_sms/$1');
$routes->post('messaging/publish_exam_result_via_sms/(:any)', 'Messaging::publish_exam_result_via_sms/$1');



////////////////////// Fees management ///////////////////////////////
$routes->get('/fees_and_payments', 'Fees_and_payments::index');
$routes->get('/fees_and_payments/price_table', 'Fees_and_payments::price_table');
$routes->get('/fees_and_payments/price_table_transport', 'Fees_and_payments::price_table_transport');
$routes->post('/fees_and_payments/add_items', 'Fees_and_payments::add_items');
$routes->post('/fees_and_payments/add_item_price', 'Fees_and_payments::add_item_price');
$routes->post('/fees_and_payments/add_transport_items', 'Fees_and_payments::add_transport_items');
$routes->post('/fees_and_payments/add_fees_type', 'Fees_and_payments::add_fees_type');
$routes->post('/fees_and_payments/edit_fees_name/(:any)', 'Fees_and_payments::edit_fees_name/$1');


$routes->post('/fees_and_payments/edit_items/(:any)', 'Fees_and_payments::edit_items/$1');
$routes->get('/fees_and_payments/details/(:any)', 'Fees_and_payments::details/$1');
$routes->post('/fees_and_payments/generate_invoices/(:any)/(:any)', 'Fees_and_payments::generate_invoices/$1/$2');

$routes->post('/fees_and_payments/generate_invoices_custom/(:any)/(:any)', 'Fees_and_payments::generate_invoices_custom/$1/$2');



$routes->post('/fees_and_payments/generate_invoices_for_class/(:any)/(:any)', 'Fees_and_payments::generate_invoices_for_class/$1/$2');


$routes->get('/fees_and_payments/delete_invoice/(:any)/(:any)', 'Fees_and_payments::delete_invoice/$1/$2');
$routes->post('/fees_and_payments/generate_challan_for_all/(:any)', 'Fees_and_payments::generate_challan_for_all/$1');
$routes->get('/users/check_challan_transaction_exist/(:any)', 'Users::check_challan_transaction_exist/$1');
$routes->get('/fees_and_payments/view_challan/(:any)', 'Fees_and_payments::view_challan/$1');
$routes->get('/fees_and_payments/get_challan/(:any)/(:any)', 'Fees_and_payments::get_challan/$1/$2'); 
$routes->post('/fees_and_payments/add_concession_fee', 'Fees_and_payments::add_concession_fee');
$routes->post('/fees_and_payments/add_additional_fee', 'Fees_and_payments::add_additional_fee');
 
$routes->post('/fees_and_payments/edit_transport_items/(:any)', 'Fees_and_payments::edit_transport_items/$1');
$routes->post('/fees_and_payments/edit_fees_type/(:any)', 'Fees_and_payments::edit_fees_type/$1');
$routes->get('/fees_and_payments/delete_fees_type/(:any)', 'Fees_and_payments::delete_fees_type/$1');

$routes->get('/fees_and_payments/deleteitem/(:any)', 'Fees_and_payments::deleteitem/$1');
$routes->get('/fees_and_payments/deleteitem_trans/(:any)', 'Fees_and_payments::deleteitem_trans/$1');

$routes->get('/fees_and_payments/deletecat/(:any)', 'Fees_and_payments::deletecat/$1');
$routes->post('/settings/edit_category/(:any)', 'Settings::edit_category/$1');
$routes->get('/fees_and_payments/pdf_fees_challan/(:any)', 'Fees_and_payments::pdf_fees_challan/$1');
$routes->get('/fees_and_payments/payments/(:any)', 'Fees_and_payments::payments/$1');
$routes->get('/fees_and_payments/get_payment_form/(:any)', 'Fees_and_payments::get_payment_form/$1');
$routes->post('/fees_and_payments/add_installments', 'Fees_and_payments::add_installments');
$routes->post('/fees_and_payments/update_pay', 'Fees_and_payments::update_pay');
$routes->get('/fees_and_payments/delete_all_installments/(:any)', 'Fees_and_payments::delete_all_installments/$1');
$routes->get('/fees_and_payments/delete/(:any)/(:any)', 'Fees_and_payments::delete/$1/$2');
$routes->post('/fees_and_payments/generate_invoices_for_transport/(:any)/(:any)/(:any)', 'Fees_and_payments::generate_invoices_for_transport/$1/$2/$3'); 
$routes->post('/fees_and_payments/generate_for_all_transport/(:any)', 'Fees_and_payments::generate_for_all_transport/$1');
$routes->get('/fees_and_payments/consession_report', 'Fees_and_payments::consession_report');
$routes->get('/fees_and_payments/fees_collected', 'Fees_and_payments::fees_collected');
$routes->get('/fees_and_payments/group_wise_fees_collected', 'Fees_and_payments::group_wise_fees_collected');
$routes->get('/fees_and_payments/fees_wise_outstanding', 'Fees_and_payments::fees_wise_outstanding');
$routes->get('/fees_and_payments/transport_report', 'Fees_and_payments::transport_report');
$routes->get('/fees_and_payments/collected_transport_report', 'Fees_and_payments::collected_transport_report');


$routes->get('/fees_and_payments/get_all_fees_list/(:any)/(:any)/(:any)', 'Fees_and_payments::get_all_fees_list/$1/$2/$3');
$routes->get('/fees_and_payments/remove_signature/(:any)/(:any)', 'Fees_and_payments::remove_signature/$1/$2');
$routes->get('/fees_and_payments/remove_pay_slip_signature/(:any)/(:any)', 'Fees_and_payments::remove_pay_slip_signature/$1/$2');
$routes->get('/fees_and_payments/remove_qr_code/(:any)/(:any)', 'Fees_and_payments::remove_qr_code/$1/$2');

$routes->post('/fees_and_payments/add_reason/(:any)', 'Fees_and_payments::add_reason/$1');

$routes->post('/fees_and_payments/delete_concession/(:any)', 'Fees_and_payments::delete_concession/$1');

// /////////////Invoice Submit///////////
$routes->get('/invoice_submit', 'Invoice_submit::index');
$routes->get('/invoice_submit/invoice_submit_report', 'Invoice_submit::reports');
$routes->post('/invoice_submit/add_invoice', 'Invoice_submit::add_invoice');
$routes->post('/invoice_submit/edit_invoice/(:any)', 'Invoice_submit::edit_invoice/$1');
$routes->get('/invoice_submit/delete_invoice/(:any)', 'Invoice_submit::delete_invoice/$1');
$routes->post('/invoice_submit/update_status', 'Invoice_submit::update_status');
 
  

// products //
$routes->get('/products', 'Products::index');
$routes->get('/products/import_and_export', 'Import_and_export::index');
$routes->get('/products/add_new', 'Products::add_new'); 
$routes->get('/products/get_form', 'Products::get_form'); 
$routes->get('products/delete/(:any)', 'Products::delete/$1');
$routes->post('products/add_to_top/(:any)', 'Products::add_to_top/$1'); 
$routes->post('is_pos/(:any)', 'Products::is_pos/$1'); 

$routes->post('products/remove_to_top/(:any)', 'Products::remove_to_top/$1'); 
$routes->post('products/add_to_deals/(:any)', 'Products::add_to_deals/$1');
$routes->post('products/remove_to_deals/(:any)', 'Products::remove_to_deals/$1');
$routes->post('products/add_to_top_seller/(:any)', 'Products::add_to_top_seller/$1');
$routes->post('products/remove_to_top_seller/(:any)', 'Products::remove_to_top_seller/$1');
$routes->post('products/add_to_online/(:any)', 'Products::add_to_online/$1');
$routes->post('products/remove_to_online/(:any)', 'Products::remove_to_online/$1');
$routes->post('products/add_to_latest_product/(:any)', 'Products::add_to_latest_product/$1');
$routes->post('products/remove_to_latest_product/(:any)', 'Products::remove_to_latest_product/$1');
$routes->post('products/add_to_flash_seller/(:any)', 'Products::add_to_flash_seller/$1');
$routes->post('products/remove_to_flash_seller/(:any)', 'Products::remove_to_flash_seller/$1');
$routes->post('products/add_to_upsell_product/(:any)', 'Products::add_to_upsell_product/$1');
$routes->post('products/remove_to_upsell_product/(:any)', 'Products::remove_to_upsell_product/$1');
$routes->post('products/add_to_product_group/(:any)', 'Products::add_to_product_group/$1');
$routes->post('products/remove_to_product_group/(:any)', 'Products::remove_to_product_group/$1');
$routes->post('/products', 'Products::index');
$routes->get('/import_and_export/export', 'Import_and_export::export');
$routes->post('/import_and_export/save', 'Import_and_export::save');
$routes->get('/products/easy_edit', 'Easy_edit::index');
$routes->post('/easy_edit/update_product/(:any)', 'Easy_edit::update_product/$1');
$routes->post('/import_and_export/sync_products_to_branch/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Import_and_export::sync_products_to_branch/$1/$2/$3/$4/$5/$6/$7');
$routes->get('/products/get_sub_select/(:any)', 'Products::get_sub_select/$1');
$routes->get('products/get_sec_select/(:any)', 'Products::get_sec_select/$1');
$routes->get('/products/get_sub_select', 'Products::get_sub_select');
$routes->get('products/get_sec_select', 'Products::get_sec_select');
$routes->post('products/add_product', 'Products::add_product');
$routes->get('/products/edit/(:any)', 'Products::edit/$1');
$routes->post('products/update_product/(:any)', 'Products::update_product/$1');
$routes->get('products/long_edit/(:any)', 'Products::long_edit/$1');
$routes->post('products/rich_update_product/(:any)', 'Products::rich_update_product/$1');
$routes->get('products/product_rating/(:any)', 'Products::product_rating/$1');
$routes->post('products/add_rate/(:any)', 'Products::add_rate/$1');

$routes->get('products/delete_review/(:any)/(:any)', 'Products::delete_review/$1/$2');

$routes->get('products/requests', 'Products::requests');

$routes->post('products/requests', 'Products::requests');

$routes->post('products/requested_not_available/(:any)', 'Products::requested_not_available/$1');
$routes->get('products/requested_arranged/(:any)', 'Products::requested_arranged/$1');

$routes->get('products/requests-rejetcted', 'Products::requests_rejetcted');
$routes->get('products/requests-approved', 'Products::requests_approved');

$routes->post('products/requests-rejetcted', 'Products::requests_rejetcted');
$routes->post('products/requests-approved', 'Products::requests_approved');

$routes->get('product_scrapper', 'Products::index');
$routes->post('product_scrapper', 'Products::index');
$routes->post('settings/add_brand_from_ajax', 'Settings::add_brand_from_ajax');
$routes->post('settings/add_cate_from_ajax', 'Settings::add_cate_from_ajax');
$routes->post('settings/add_subcate_from_ajax', 'Settings::add_subcate_from_ajax');
$routes->post('settings/add_seccate_from_ajax', 'Settings::add_seccate_from_ajax');
$routes->post('products/add_new_field', 'Products::add_new_field');
$routes->post('products/edit_new_field', 'Products::edit_new_field');

$routes->get('products/delete_thumb/(:any)/(:any)', 'Products::delete_thumb/$1/$2');
$routes->post('products/add_barcode', 'Products::add_barcode');
$routes->get('generate_barcode', 'Generate_barcode::index');

$routes->post('/products/add_results_page', 'Products::add_results_page');

$routes->get('/products/download_plu', 'Products::download_plu');
$routes->post('products/add_adjust_stck/(:any)', 'Products::add_adjust_stck/$1');
$routes->get('products/get_adjust_stock/(:any)', 'Products::get_adjust_stock/$1');
$routes->get('products/delete_adjust_stock/(:any)', 'Products::delete_adjust_stock/$1');

$routes->get('products/products_transactions/(:any)', 'Products::products_transactions/$1');

// products //


//////////////////////// Settings ////////////
$routes->get('/settings', 'Settings::index');
$routes->post('/settings/save_profile/(:any)', 'Settings::save_profile/$1');
$routes->post('/settings/changepassword/(:any)', 'Settings::changepassword/$1');
$routes->get('/settings/caste_category', 'Settings::caste_category');
$routes->post('/settings/add_caste_category', 'Settings::add_caste_category');
$routes->post('/settings/edit_caste_category/(:any)', 'Settings::edit_caste_category/$1');
$routes->post('/settings/deletestdcat/(:any)', 'Settings::deletestdcat/$1');
$routes->post('/settings/add_caste_sub_category', 'Settings::add_caste_sub_category');
$routes->post('/settings/edit_caste_sub_category/(:any)', 'Settings::edit_caste_sub_category/$1');
$routes->post('/settings/deletestdsubcat/(:any)', 'Settings::deletestdsubcat/$1');
$routes->get('/settings/prefixes', 'Settings::prefixes');
$routes->post('/settings/prefixes', 'Settings::prefixes');
$routes->get('/settings/payment_gateway', 'Settings::payment_gateway');
$routes->post('/settings/save_paymentway/(:any)', 'Settings::save_paymentway/$1');

$routes->get('settings/invoice_settings', 'Settings::invoice'); 
$routes->post('settings/invoice_settings', 'Settings::invoice');




// new app settings
$routes->get('/app_info', 'Settings::app_info'); 
$routes->get('/settings/product-scrapper', 'Product_scrapper::configuration'); 
$routes->get('/settings/sms_and_emails', 'Settings::sms_and_emails'); 
$routes->get('/settings/printers', 'Settings::printers');
$routes->post('/settings/printers', 'Settings::printers/0');
$routes->post('/settings/printers/(:any)', 'Settings::printers/$1');
$routes->get('/settings/set_default_printer/(:any)', 'Settings::set_default_printer/$1');
$routes->get('/settings/delete_printer/(:any)', 'Settings::delete_printer/$1');

$routes->get('/settings/printing_and_devices', 'Settings::printing_and_devices'); 
$routes->get('/settings/preferences', 'Settings::preferences'); 
$routes->post('/settings/sms_and_emails', 'Settings::sms_and_emails'); 
$routes->post('/settings/printing_and_devices', 'Settings::printing_and_devices'); 
$routes->post('/settings/preferences', 'Settings::preferences'); 
$routes->post('/product_scrapper/add_site', 'Product_scrapper::add_site'); 
$routes->post('/product_scrapper/update_site/(:any)', 'Product_scrapper::update_site/$1'); 
$routes->get('/product_scrapper/delete_site/(:any)', 'Product_scrapper::delete_site/$1'); 
$routes->get('/product_scrapper/update_rate', 'Product_scrapper::update_rate'); 
$routes->get('/product_scrapper/update_profit', 'Product_scrapper::update_profit'); 
$routes->get('/settings/organisation-setting', 'Settings::organisation_setting');
$routes->post('/settings/save-organisation/(:any)', 'Settings::save_organisation/$1');




$routes->get('/library-management', 'Library_management::index');
$routes->post('/library-management/add-books/(:any)', 'Library_management::add_books/$1');
$routes->post('/library-management/update-books/(:any)', 'Library_management::update_books/$1');
$routes->post('/library-management/deletebook/(:any)', 'Library_management::deletebook/$1');
$routes->get('/library-management/issuedbooks', 'Library_management::issuedbooks');
$routes->post('/library-management/add-issue-books/(:any)', 'Library_management::add_issue_books/$1');
$routes->post('/library-management/update-issue-books/(:any)', 'Library_management::update_issue_books/$1');
$routes->post('/library-management/delete-issue-book/(:any)', 'Library_management::delete_issue_book/$1');
$routes->get('/library-management/returnedbooks', 'Library_management::returnedbooks');
$routes->post('/library-management/received-book/(:any)', 'Library_management::received_book/$1');
$routes->get('/library-management/bookcategory', 'Library_management::bookcategory');
$routes->post('/library-management/add-category/(:any)', 'Library_management::add_category/$1');
$routes->post('/library-management/update-category/(:any)', 'Library_management::update_category/$1');
$routes->post('/library-management/deletecategory/(:any)', 'Library_management::deletecategory/$1');

$routes->get('/messaging', 'Messaging::index');
$routes->get('/messaging/send-bookreturn', 'Messaging::send_bookreturn');



//////////// Feedbacks /////////////////
$routes->get('/feedbacks', 'Feedbacks::index');
$routes->post('/feedbacks/delete-feedback/(:any)', 'Feedbacks::delete_feedback/$1');


//////////// Class & Subjects /////////////////
$routes->get('/class-and-subjects', 'Class_and_subjects::index');
$routes->get('/class-and-subjects/subjects', 'Class_and_subjects::subjects');
$routes->post('/class-and-subjects/add-subject/(:any)', 'Class_and_subjects::add_subject/$1');
$routes->post('/class-and-subjects/update-subject/(:any)', 'Class_and_subjects::update_subject/$1');
$routes->post('/class-and-subjects/deletesubject/(:any)', 'Class_and_subjects::deletesubject/$1');
$routes->post('/class-and-subjects/add-class/(:any)', 'Class_and_subjects::add_class/$1');
$routes->post('/class-and-subjects/update-class/(:any)', 'Class_and_subjects::update_class/$1');
$routes->post('/class-and-subjects/deleteclasses/(:any)', 'Class_and_subjects::deleteclasses/$1');
$routes->post('class_and_subjects/add_teacher_from_ajax', 'Class_and_subjects::add_teacher_from_ajax');


//////////// Student masters /////////////////
$routes->get('/student-master', 'Student_master::index');
$routes->get('/student-master/student_details/(:any)', 'Student_master::student_details/$1');
$routes->get('/student-master/student_fees_details/(:any)/(:any)', 'Student_master::student_fees_details/$1/$2');
$routes->post('/student-master/add_student/(:any)', 'Student_master::add_student/$1');
$routes->get('/student-master/get_subcat_select/(:any)', 'Student_master::get_subcat_select/$1');
$routes->get('/student-master/get_subcat_select', 'Student_master::get_subcat_select');
$routes->post('/student-master/add_student/(:any)', 'Student_master::add_student/$1');
$routes->post('/student-master/update_student/(:any)', 'Student_master::update_student/$1');
$routes->post('/student-master/deletestudent/(:any)', 'Student_master::deletestudent/$1');
$routes->post('/student-master/check_transaction_exist/(:any)', 'Student_master::check_transaction_exist/$1');
$routes->get('/student-master/get_fees_list_of_student/(:any)', 'Student_master::get_fees_list_of_student/$1');
$routes->get('/student-master/easy_edit', 'Student_master::students_easy_edit');
$routes->post('/student-master/student_easyedit/(:any)/(:any)', 'Student_master::update_student_easyedit/$1/$2');
$routes->post('/student-master/promote/(:any)', 'Student_master::promote/$1');
$routes->post('/student-master/transfer_student/(:any)', 'Student_master::transfer_student/$1');
$routes->get('student-master/get_student_other_data/(:any)', 'Student_master::get_student_other_data/$1');

$routes->get('student-master/get_promote_student_data/(:any)', 'Student_master::get_promote_student_data/$1');

$routes->get('student-master/get_edit_student_data/(:any)', 'Student_master::get_edit_student_data/$1');

/////////// Errors /////////
$routes->get('/tutorial_coming_soon', 'App_error::tutorial_coming_soon');
$routes->get('/app_error/permission_denied', 'App_error::permission_denied');

//////////// SCHOOL ACTIVITIES/////////////////
$routes->get('/school_activities', 'School_activities::index');
$routes->get('/school_activities/sports', 'School_activities::sports');
$routes->post('/school_activities/add_sports/(:any)', 'School_activities::add_sports/$1');
$routes->post('/school_activities/update_sports/(:any)', 'School_activities::update_sports/$1');
$routes->post('/school_activities/deletesports/(:any)', 'School_activities::deletesports/$1');
$routes->get('/school_activities/sports_participants', 'School_activities::sports_participants');
$routes->post('/school_activities/add_sports_participants/(:any)', 'School_activities::add_sports_participants/$1');
$routes->post('/school_activities/update_sports_participants/(:any)', 'School_activities::update_sports_participants/$1');
$routes->post('/school_activities/delete_sports_participants/(:any)', 'School_activities::delete_sports_participants/$1');
$routes->post('/school_activities/add_involve_sports', 'School_activities::add_involve_sports');
$routes->get('/school_activities/sports_events', 'School_activities::sports_events');
$routes->post('/school_activities/add_spevents/(:any)', 'School_activities::add_spevents/$1');
$routes->post('/school_activities/update_sportsevents/(:any)', 'School_activities::update_sportsevents/$1');
$routes->post('/school_activities/deletesportsevent/(:any)', 'School_activities::deletesportsevent/$1');
$routes->get('/school_activities/reward/(:any)', 'School_activities::reward/$1');
$routes->post('/school_activities/add_reward_mark', 'School_activities::add_reward_mark');
$routes->post('/school_activities/add_reward_status', 'School_activities::add_reward_status');
$routes->get('/sports_report', 'School_activities::sports_report');
$routes->get('/eccc_report', 'School_activities::eccc_report');



$routes->get('/school_activities/eccc', 'School_activities::eccc');
$routes->post('/school_activities/add_activity/(:any)', 'School_activities::add_activity/$1');
$routes->post('/school_activities/update_activity/(:any)', 'School_activities::update_activity/$1');
$routes->post('/school_activities/deleteactivity/(:any)', 'School_activities::deleteactivity/$1');
$routes->get('/school_activities/eccc_participants', 'School_activities::eccc_participants');
$routes->post('/school_activities/add_actparticipants/(:any)', 'School_activities::add_actparticipants/$1');
$routes->post('/school_activities/update_actparticipants/(:any)', 'School_activities::update_actparticipants/$1');
$routes->post('/school_activities/deletesactparticipants/(:any)', 'School_activities::deletesactparticipants/$1');
$routes->post('/school_activities/add_involve_eccc', 'School_activities::add_involve_eccc');
$routes->get('/school_activities/eccc_events', 'School_activities::eccc_events');
$routes->post('/school_activities/add_ecevents/(:any)', 'School_activities::add_ecevents/$1');
$routes->post('/school_activities/update_ecccevents/(:any)', 'School_activities::update_ecccevents/$1');
$routes->post('/school_activities/deleteecccevent/(:any)', 'School_activities::deleteecccevent/$1');

$routes->get('/messaging/send_reward', 'Messaging::send_reward');


// accounts
$routes->get('accounts/ledger-accounts', 'Accounts::index');
$routes->post('accounts/add_ledger', 'Accounts::add_ledger');
$routes->get('accounts/delete_ledger/(:any)', 'Accounts::delete_ledger/$1');
$routes->post('accounts/edit_ledger/(:any)', 'Accounts::edit_ledger/$1');
$routes->get('accounts/group-head', 'Accounts::group_head');
$routes->post('accounts/add_group_head', 'Accounts::add_group_head');
$routes->get('accounts/delete_gropu_head/(:any)', 'Accounts::delete_gropu_head/$1');
$routes->post('accounts/edit_group_head/(:any)', 'Accounts::edit_group_head/$1');


////////////////////////// Company /////////////////////
$routes->get('company', 'Company::index');
$routes->post('company', 'Company::index');


// document renew//
$routes->get('/document_renew', 'Document_renew::index');
$routes->post('/document_renew', 'Document_renew::index');
$routes->get('/document_renew/category/(:any)', 'Document_renew::category/$1');
$routes->post('/document_renew/savecategory', 'Document_renew::savecategory');
$routes->get('/document_renew/display_documentrenew', 'Document_renew::display_documentrenew');
$routes->get('/document_renew/delete_doc_category/(:any)', 'Document_renew::delete_doc_category/$1');
$routes->post('/document_renew/edit_doc_category/(:any)', 'Document_renew::edit_doc_category/$1');
$routes->post('/document_renew/restore_renew/(:any)', 'Document_renew::restore_renew/$1');
$routes->get('/document_renew/cancel_renew/(:any)', 'Document_renew::cancel_renew/$1');
$routes->get('/document_renew/delete_renew/(:any)', 'Document_renew::delete_renew/$1');
$routes->post('/document_renew/delete_r_file/(:any)', 'Document_renew::delete_r_file/$1');
$routes->post('/document_renew/delete_file/(:any)', 'Document_renew::delete_file/$1');
$routes->get('/document_renew/restore_renew/(:any)', 'Document_renew::restore_renew/$1');
$routes->get('/document_renew/delete_file/(:any)', 'Document_renew::delete_file/$1');



$routes->get('/crm/get_against_data_from_renew', 'Crm::get_against_data_from_renew');


// finacial year & Academic Year
// $routes->get('settings/financial_years', 'Settings::financial_years');
// $routes->get('settings/start_new_financial_year', 'Settings::start_new_financial_year');
$routes->post('settings/activate_f_year/(:any)', 'Settings::activate_f_year/$1');
$routes->get('settings/academic_year', 'Settings::academic_year');
$routes->post('settings/academic_year', 'Settings::academic_year');
$routes->get('settings/delete_academic_year/(:any)', 'Settings::delete_academic_year/$1');
$routes->post('settings/edit_academic_year/(:any)', 'Settings::edit_academic_year/$1');
$routes->get('settings/change_academic_year/(:any)', 'Settings::change_academic_year/$1');

// Branch Manager
$routes->get('branch_manager', 'Branch_manager::index'); 
$routes->get('branch_manager/add_new_branch', 'Branch_manager::index');
$routes->post('branch_manager/add_new_branch', 'Branch_manager::add_new_branch');
$routes->get('branch_manager/change_branch/(:any)', 'Branch_manager::change_branch/$1/normal');
$routes->post('branch_manager/change_branch_ajax/(:any)', 'Branch_manager::change_branch/$1/ajax');


//////////// USER MANAGEMENT/////////////////
$routes->get('/user_master', 'User_master::index');
$routes->post('/user_master/add_staff/(:any)', 'User_master::add_staff/$1');
$routes->post('/user_master/update_staff/(:any)', 'User_master::update_staff/$1');
$routes->post('/user_master/delete_staff/(:any)', 'User_master::delete_staff/$1');
$routes->post('/user_master/user_permission/(:any)', 'User_master::user_permission/$1');
$routes->post('/user_master/save_branch_permission/(:any)', 'User_master::save_branch_permission/$1');

$routes->get('/permission/(:any)', 'Permission::index/$1');
$routes->post('/is_permission_allowed', 'Permission::is_permission_allowed');


$routes->get('/messaging/send_credentials', 'Messaging::send_credentials');

///////////////// Testings ///////////////
$routes->get('/testing', 'Testing::index');
$routes->post('/testing', 'Testing::index');
$routes->get('/send_sms_oman', 'Testing::send_sms_oman');
$routes->get('/price_counting', 'Testing::price_counting');
$routes->get('/reset_accounts', 'Testing::reset_accounts');
$routes->get('/invoice_item_reset', 'Testing::invoice_item_reset');
$routes->get('/total_working_days', 'Testing::total_working_days');
$routes->get('/invoice_item_fees_id_update', 'Testing::invoice_item_fees_id_update');




$routes->get('/pdf_preview', 'Testing::pdf_preview');
$routes->get('/product_name_with_category', 'Testing::product_name_with_category');
$routes->get('/change_stock_to_ledger', 'Testing::change_stock_to_ledger');
$routes->get('/money_type_merge', 'Testing::money_type_merge');
$routes->get('/thermal', 'Testing::thermal');
$routes->get('/update_pay_class', 'Testing::update_pay_class');
$routes->get('/stripe', 'Testing::stripe');
$routes->post('/stripe/payment', 'Testing::payment');

 


//////////// SCHOOL TARNSPORT MANAGEMENT/////////////////
$routes->get('/school_transport', 'School_transport::index');
$routes->post('/school_transport/add_vehicle', 'School_transport::add_vehicle');
$routes->post('/school_transport/update_vehicle/(:any)', 'School_transport::update_vehicle/$1');
$routes->post('/school_transport/deletevehicle/(:any)', 'School_transport::deletevehicle/$1');
$routes->get('/school_transport/student_location', 'School_transport::student_location');
$routes->post('/school_transport/add_std_location', 'School_transport::add_std_location');
$routes->post('/school_transport/deletestdlocation/(:any)', 'School_transport::deletestdlocation/$1');
$routes->post('/school_transport/add_driver_from_ajax', 'School_transport::add_driver_from_ajax');
$routes->post('/school_transport/add_expense', 'School_transport::add_expense');


// reports
$routes->get('reports_selector', 'Reports_selector::index');
$routes->get('reports_selector2', 'Reports_selector::new');
$routes->get('item_wise_sales_report', 'Reports::item_wise_sales_report');
$routes->get('expense_report', 'Reports::expense_report');

$routes->get('discount_report', 'Reports::discount_reports');
$routes->get('stock_report', 'Reports::stock_reports');


$routes->post('stock_report', 'Reports::stock_reports');
$routes->get('gst_report', 'Gst_report::index');
$routes->get('gst_report/vat_report', 'Gst_report::vat_report');
$routes->get('credit_statement/(:any)', 'Reports::credit_statement/$1');
$routes->get('credit_statement/(:any)', 'Reports::credit_statement/$1');
$routes->get('/day_book', 'Reports::index');
$routes->get('/cash_book', 'Reports::cash_book');
$routes->get('/bank_book', 'Reports::bank_book');
$routes->get('/sales_report', 'Reports::sales_report');
$routes->get('/time_flow_sales_report', 'Time_flow_sales_report::index');
$routes->get('/item_reports', 'Reports::item_reports');
$routes->get('/reports/vendors_report', 'Reports::vendors_report');


$routes->get('/student-reports', 'Student_master::student_report');
$routes->get('/category-report', 'Student_master::category_wise_student_report');
$routes->post('/add_challan_settings/(:any)', 'Fees_and_payments::add_challan_settings/$1');
$routes->post('/add_voucher_settings/(:any)', 'Voucher_entries::add_voucher_settings/$1');
$routes->post('/add_receipt_settings/(:any)', 'Payments::add_receipt_settings/$1');

 
$routes->get('/reports/user_wise_report', 'Reports::user_wise_report');
$routes->get('/reports/referral_report', 'Reports::referral_reports');
$routes->get('/reports/student_attendance_reports', 'Reports::student_attendance_reports');

$routes->get('fees-wise-outstanding', 'Reports::fees_outstanding_statement');



// //////timetable//////////

$routes->get('/time_table', 'Time_table::index');
$routes->get('/time_table/display_time_table', 'Time_table::display_time_table');
$routes->post('/time_table/add_time_table/(:any)', 'Time_table::add_time_table/$1');
$routes->post('/time_table/update_time_table/(:any)', 'Time_table::update_time_table/$1');
$routes->get('/time_table/deletetime_table/(:any)', 'Time_table::deletetime_table/$1');
$routes->get('/time_table/tab_time_table', 'Time_table::tab_time_table');
$routes->get('/time_table/notify_time_table', 'Time_table::notify_time_table');


////////  SELECTORS /////// 
$routes->get('/selectors/classes/(:any)', 'Selectors::classes/$1');
$routes->get('/selectors/subjects/(:any)', 'Selectors::subjects/$1');
$routes->get('/selectors/students/(:any)', 'Selectors::students/$1');
$routes->get('/selectors/locations/(:any)', 'Selectors::locations/$1');
$routes->get('/selectors/library_books/(:any)', 'Selectors::library_books/$1');
$routes->get('/selectors/employees/(:any)', 'Selectors::employees/$1');
$routes->get('/selectors/accounts/(:any)', 'Selectors::accounts/$1');
$routes->get('/selectors/all_parties/(:any)', 'Selectors::all_parties/$1');
$routes->get('/selectors/all_parties_for_create_invoice/(:any)/(:any)', 'Selectors::all_parties_for_create_invoice/$1/$2');
$routes->get('/selectors/all_staffs/(:any)', 'Selectors::all_staffs/$1');
$routes->get('/selectors/all_resources/(:any)', 'Selectors::all_resources/$1');
$routes->get('/selectors/all_pos_registers/(:any)', 'Selectors::all_pos_registers/$1');


 
$routes->get('/reports/activity_logs', 'Reports::activity_logs');
$routes->get('/reports/clear_20', 'Reports::clear_20');
$routes->get('/reports/clear_all', 'Reports::clear_all');
$routes->get('/reports/receipt_payment', 'Reports::receipt_payment');


// //// CALENDAR/////////
$routes->get('/calender', 'Calendar::index');
$routes->post('/calendar/add_cal_event', 'Calendar::add_cal_event');
$routes->post('/calendar/edit_cal_event/(:any)', 'Calendar::edit_cal_event/$1');
$routes->get('/calendar/delete_event/(:any)', 'Calendar::delete_event/$1');


// Aitsun Keys
$routes->get('/aitsun_keys', 'Aitsun_keys::index');
$routes->post('/aitsun_keys/client_status/(:any)', 'Aitsun_keys::client_status/$1');
$routes->get('/aitsun_keys/add_clients', 'Aitsun_keys::add_clients');
$routes->post('/aitsun_keys/save_client', 'Aitsun_keys::save_client');
$routes->get('/aitsun_keys/details/(:any)', 'Aitsun_keys::details/$1');
$routes->post('/aitsun_keys/edit_client/(:any)', 'Aitsun_keys::edit_client/$1');
$routes->get('/aitsun_keys/delete_users/(:any)', 'Aitsun_keys::delete_users/$1');



// Invoice settings
$routes->get('/invoice_settings/(:any)', 'Settings::invoice_settings/$1');
$routes->get('/invoice_settings', 'Settings::invoice_settings');
$routes->get('/settings/get_form/(:any)', 'Settings::get_form/$1'); 
$routes->post('/save_invoice_settings/(:any)', 'Settings::save_invoice_settings/$1');



//// Magazine////
$routes->get('/magazine_request', 'Magazine_request::index');
$routes->get('/magazines/articles', 'Magazine_request::articles');
$routes->get('/magazines/view_article/(:any)', 'Magazine_request::view_article/$1');


$routes->get('/exams', 'Exams::index');
$routes->get('/exams/main_exam', 'Exams::main_exam');
$routes->get('/exams/exam_configuration', 'Exams::exam_configuration');
$routes->post('/exams/add_exam_category/(:any)', 'Exams::add_exam_category/$1');
$routes->post('/exams/update_exam_cate/(:any)', 'Exams::update_exam_cate/$1');
$routes->post('/exams/update_exam_cate/(:any)', 'Exams::update_exam_cate/$1');
$routes->post('/exams/deleteexamcate/(:any)', 'Exams::deleteexamcate/$1');
$routes->post('/exams/add_main_exam/(:any)', 'Exams::add_main_exam/$1');
$routes->post('/exams/update_main_exam/(:any)', 'Exams::update_main_exam/$1');
$routes->post('/exams/delete_main_exam/(:any)', 'Exams::delete_main_exam/$1');
$routes->get('/exams/pdf_main_exam_time_table/(:any)', 'Exams::pdf_main_exam_time_table/$1');
$routes->get('/exams/main_exam_time_table/(:any)', 'Exams::main_exam_time_table/$1');
$routes->post('/exams/add_main_exam_subject/(:any)', 'Exams::add_main_exam_subject/$1');
$routes->post('/exams/edit_main_exam_subject/(:any)', 'Exams::edit_main_exam_subject/$1');
$routes->post('/exams/delete_main_exam_subject/(:any)', 'Exams::delete_main_exam_subject/$1');
$routes->get('/exams/pdf_main_exam_subject/(:any)', 'Exams::pdf_main_exam_subject/$1');
$routes->get('/exams/main_exam_marks/(:any)', 'Exams::main_exam_marks/$1');
$routes->post('/exams/add_main_exam_mark', 'Exams::add_main_exam_mark');
$routes->post('/exams/notify_main_exam_result/(:any)', 'Exams::notify_main_exam_result/$1');
$routes->get('/exams/exam_report', 'Exams::exam_report');
$routes->get('/exams/view_exam_report/(:any)', 'Exams::view_exam_report/$1');



$routes->get('/exams/progress_card/(:any)/(:any)/(:any)/(:any)', 'Exams::progress_card/$1/$2/$3/$4');
$routes->get('/exams/pdf_progress_card/(:any)/(:any)/(:any)', 'Exams::progress_card/$1/$2/$3');


$routes->get('/exams/result/(:any)/(:any)', 'Exams::result/$1/$2');


/////// work updates /////////////
$routes->get('/work_updates', 'Work_updates::index');
$routes->post('/work_updates', 'Work_updates::index');
$routes->post('/work_updates/save_workupdate', 'Work_updates::save_workupdate');
$routes->get('/work_updates/work_updates_settings', 'Work_updates::work_updates_settings');
$routes->post('/work_updates/save_department', 'Work_updates::save_department');
$routes->post('/work_updates/save_work_category', 'Work_updates::save_work_category');
$routes->post('/work_updates/edit_work_category/(:any)', 'Work_updates::edit_work_category/$1');
$routes->post('/work_updates/edit_work_department/(:any)', 'Work_updates::edit_work_department/$1');
$routes->get('/settings/get_catgry_select/(:any)', 'Work_updates::get_catgry_select/$1');
$routes->post('/work_updates/edit_workupdate/(:any)', 'Work_updates::edit_workupdate/$1');
$routes->get('/work_updates/delete_workupdate/(:any)', 'Work_updates::delete_workupdate/$1');


//// Health ////
$routes->get('/health', 'Health::index');
$routes->post('/health/add_health_weight', 'Health::add_health_weight');
$routes->post('/health/add_health_height', 'Health::add_health_height');
$routes->get('/enquiries', 'Enquiries::index');
$routes->get('/enquiries/delete_enquiries/(:any)', 'Enquiries::delete_enquiries/$1');


//// Online  shop  /////
$routes->get('/online_shop', 'Online_shop::index');
$routes->get('/offers', 'Offers::index');
$routes->post('/offers/save_offer_image', 'Offers::save_offer_image');
$routes->post('/offers/edit_offer_image/(:any)', 'Offers::edit_offer_image/$1');
$routes->get('/offers/delete_offer_image/(:any)', 'Offers::delete_offer_image/$1');

//// Notice ////
$routes->get('/notice', 'Notice::index');
$routes->post('/notice/send_notice/(:any)', 'Notice::send_notice/$1');
$routes->post('/notice/update_notice/(:any)', 'Notice::update_notice/$1');
$routes->get('/notice/deletenotices/(:any)', 'Notice::deletenotices/$1');


//////////// Manufacture ///////
$routes->get('/products/manufacture', 'Manufacture::index');
$routes->get('/products/manufacture/create_raw_materials/(:any)', 'Manufacture::create_raw_materials/$1');
$routes->get('/products/manufacture/create_manufacture/(:any)', 'Manufacture::create_manufacture/$1');
$routes->get('/products/manufacture/edit_manufacture/(:any)', 'Manufacture::edit_manufacture/$1');


$routes->get('/products/get_product_for_item_kit/(:any)', 'Manufacture::get_product_for_item_kit/$1');
$routes->get('/manufacture/delete/(:any)', 'Manufacture::delete/$1');
$routes->post('/manufacture/save_raw_material', 'Manufacture::save_raw_material');
$routes->post('/manufacture/save_manufacture', 'Manufacture::save_manufacture');
$routes->post('/manufacture/update_manufacture/(:any)', 'Manufacture::update_manufacture/$1');



$routes->get('/parties_category', 'Customers::parties_category');
$routes->get('/customers/delete_product_cate/(:any)', 'Customers::delete_product_cate/$1');
$routes->post('/customers/edit_cat/(:any)', 'Customers::edit_category/$1');
$routes->post('/customers/add_category', 'Customers::add_category');

$routes->get('/settings/product', 'Settings::product');
$routes->post('/settings/product', 'Settings::product');
$routes->get('/settings/delete_product_subcat/(:any)', 'Settings::delete_product_subcat/$1');
$routes->get('/settings/delete_product_cat/(:any)', 'Settings::delete_product_cat/$1');
$routes->get('/settings/delete_product_brand/(:any)', 'Settings::delete_product_brand/$1');
$routes->get('/settings/delete_product_seccat/(:any)', 'Settings::delete_product_seccat/$1');

$routes->post('/google_services/sync_product_to_google/(:any)', 'Google_services::sync_product_to_google/$1');

$routes->get('/sales/get_date_format', 'Sales::get_date_format');


$routes->get('/easy_edit/barcode_customization', 'Easy_edit::barcode_customization');
$routes->get('/easy_edit/generate_ap_code', 'Easy_edit::generate_ap_code');
$routes->get('/easy_edit/generate_dpc_code', 'Easy_edit::generate_dpc_code');
$routes->post('/easy_edit/generate_pro_barcode/(:any)', 'Easy_edit::generate_pro_barcode/$1');
$routes->get('/products/barcode_preview/(:any)', 'Generate_barcode::barcode_preview/$1');
$routes->post('settings/save_barcode_settings', 'Settings::save_barcode_settings');

///// Aitsun ERP Special reports 
$routes->get('/day_end_summary', 'Aitsun_special_reports::day_end_summary');


$routes->get('special_reports/sale', 'Aitsun_special_reports::sale');
$routes->get('special_reports/purchase', 'Aitsun_special_reports::purchase');
$routes->get('special_reports/day-book', 'Aitsun_special_reports::day_book');
$routes->get('special_reports/all-transactions', 'Aitsun_special_reports::all_transactions');
$routes->get('special_reports/profit-and-loss', 'Aitsun_special_reports::profit-and-loss');
$routes->get('special_reports/bill-wise-profit', 'Aitsun_special_reports::bill_wise_profit');
$routes->get('special_reports/cash-flow', 'Aitsun_special_reports::cash-flow');
$routes->get('special_reports/trial-balance-report', 'Aitsun_special_reports::trial-balance-report');
$routes->get('special_reports/balance-sheet', 'Aitsun_special_reports::balance-sheet');


///// Aitsun ERP Special reports 


////////// Emailer /////////////
$routes->get('/e-mailer', 'E_mailer::index'); 
$routes->post('/e-mailer/send-email', 'E_mailer::send_email'); 
$routes->get('/e-mailer/etest', 'E_mailer::etest');


///// other routes
$routes->get('/support', 'Support::index');

$routes->get('/export_excel/', 'Export_excel::index');
$routes->post('/export_excel/', 'Export_excel::index');
$routes->get('/task_runner/', 'Task_runner::index');
$routes->get('/task_completer/', 'Task_completer::index');
$routes->post('/task_completer/markascomplete', 'Task_completer::markascomplete');

$routes->get('/profit_and_loss_report', 'Reports::profit_and_loss_report');
 
$routes->get('products/get_product_details/(:any)', 'Products::get_product_details/$1');

$routes->post('home/get_adjust_payment/(:any)', 'Home::get_adjust_payment/$1');


//sleep
$routes->get('/sleep_mode', 'Calendar::sleep_mode');

//sleep
$routes->get('/reminder', 'Reminders::index');


////// REST API ////
$routes->resource('link',[]);
$routes->resource('api',[]);

$routes->get('/link','Api::index'); 
$routes->post('/api/enquiry/create','Api::enquiries/create'); 
$routes->get('/sl/(:any)', 'Api::link/$1');
////// REST API ////
 
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
