<?php namespace App\Models;
use CodeIgniter\Model;

class PriceQueue extends Model{
  protected $table = 'price_queue';
  protected $allowedFields = ['product_id', 'qty', 'amt','price', 'invoice_id','type'];
}