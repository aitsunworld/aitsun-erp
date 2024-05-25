<?php namespace App\Models;

use CodeIgniter\Model;

class VoucherListModel extends Model{
  protected $table = 'voucher_lists';
  protected $allowedFields = ['company_id', 'financial_year','financial_year','total','payment_type','datetime', 'deleted','voucher_type','voucher_date','notes','private_notes'];
}