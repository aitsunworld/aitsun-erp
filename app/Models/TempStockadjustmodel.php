<?php namespace App\Models;

use CodeIgniter\Model;

class TempStockadjustmodel extends Model{
  protected $table = 'stock_adjust_table';
  protected $allowedFields = ['company_id', 'product_id', 'adjust_type', 'qty', 'deleted', 'effected', 'edit_effected', 'datetime', 'unit', 'sub_unit', 'conversion_unit_rate', 'in_unit', 'at_price', 'amount'];
}