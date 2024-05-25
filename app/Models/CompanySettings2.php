<?php namespace App\Models;
use CodeIgniter\Model;

class CompanySettings2 extends Model{
  protected $table = 'company_settings2';
  protected $allowedFields = ['company_id','invoice_page_size', 'invoice_orientation', 'challan_page_size', 'challan_orientation', 'receipt_page_size', 'receipt_orientation', 'voucher_page_size', 'voucher_orientation','footer_title','description','sign_logo','payslip_signature','bank','upi','website_url','pdf_scaling'];
}
