<?php namespace App\Models;
use CodeIgniter\Model;

class RequestModel extends Model{
  protected $table = 'requests';
  protected $allowedFields = ['product_name', 'product_id', 'user_id', 'email', 'phone', 'quantity', 'message', 'name', 'datetime', 'status', 'deleted','country'];
}