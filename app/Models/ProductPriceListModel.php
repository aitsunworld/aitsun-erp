<?php namespace App\Models;
use CodeIgniter\Model;

class ProductPriceListModel extends Model{
  protected $table = 'product_price_list';
  protected $allowedFields = ['company_id','product_id', 'period_id', 'price','deleted'];
}