<?php namespace App\Models;
use CodeIgniter\Model;

class PermissionModel extends Model{
  protected $table = 'permission_pos';
  protected $allowedFields = ['user', 'company_id', 'manage_sales', 'manage_sales_order','manage_sales_return', 'manage_sales_delivery_note', 'manage_sales_quotation', 'manage_purchase', 'manage_purchase_order', 'manage_purchase_return', 'manage_purchase_delivery_note','manage_cash_ex', 'manage_pro_ser', 'manage_reports', 'manage_parties','manage_orders','manage_appearance','manage_trash','manage_product_requestes','manage_settings','manage_aitsun_keys','manage_enquires','manage_crm','manage_document_renew','manage_work_updates','manage_hr','manage_invoice_submit','manage_branch','manage_library','manage_messaging','manage_sports','manage_eccc','  manage_configuration','manage_timetable','manage_notices','manage_health','import_export','manage_fees','manage_academic_year','manage_financial_year','manage_team','manage_sms_config','manage_account_setting','stock_management','delete_receipts_and_payments'];
}