<?php namespace App\Models;
use CodeIgniter\Model;

class OrdertrackingModel extends Model{
  protected $table = 'order_tracking';
  protected $allowedFields = ['invoice_id', 'track', 'after', 'datetime', 'viewable'];
}