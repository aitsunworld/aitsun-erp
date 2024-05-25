<?php namespace App\Models;

use CodeIgniter\Model;

class StockValuesTable extends Model{
  protected $table = 'stock_values_table';
  protected $allowedFields = ['company_id','product_id','invoice_id', 'invoice_type', 'quantity', 'price', 'amount', 'deleted', 'effected', 'edit_effected', 'batch_no'];
}