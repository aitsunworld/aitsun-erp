<?php namespace App\Models;

use CodeIgniter\Model;

class InvoiceSettings extends Model{
  protected $table = 'invoice_settings';
  protected $allowedFields = ['company_id','show_header','show_logo','invoice_header','show_invoice_header','show_due_date','show_date','show_bill_to','show_customer_address','show_qr_code','show_bank_details','show_footer','show_declaration','show_terms','invoice_footer','invoice_declaration','invoice_terms','show_batch_no', 'show_price','show_tax','show_discount','show_quantity','show_expiry_date','show_uom','show_hsncode_no','billing_style','show_validity','show_mrn_num','tinnumber','taxnumber','barcode_settings','cursor_position','invoice_template','upi','bank_details','invoice_qr_code','invoice_signature','invoice_seal','payslip_signature','invoice_color','invoice_font_color','show_seal','show_signature','show_payslip_signature','invoice_type','show_bill_number','show_amount','show_invoice_header','round_off','mode_of_payment','due_amount','invoice_num','show_reciver_sign','show_tax_tin_num','show_vehicle_number','show_pro_desc','show_business_name','show_business_address','show_tax_details','show_footer_image','footer_image'];
}
 