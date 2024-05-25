<?php namespace App\Models;
use CodeIgniter\Model;

class RequestitemsModel extends Model{
  protected $table = 'requests_items';
  protected $allowedFields = ['request_id', 'product_name', 'product_id', 'quantity'];
}