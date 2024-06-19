<?php namespace App\Models;
use CodeIgniter\Model;

class RentalLogsModel extends Model{
  protected $table = 'rental_logs';
  protected $allowedFields = ['invoice_id', 'item_id', 'log_type', 'user_id', 'datetime', 'quantity','deleted','in_unit'];
}