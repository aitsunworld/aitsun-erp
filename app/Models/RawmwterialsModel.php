<?php namespace App\Models;
use CodeIgniter\Model;

class RawmwterialsModel extends Model{
  protected $table = 'item_kits';
  protected $allowedFields = ['product_id', 'product', 'item_id', 'quantity', 'price', 'selling_price', 'discount', 'amount', 'desc', 'deleted', 'tax','unit','sub_unit','conversion_unit_rate','in_unit'];
 
}