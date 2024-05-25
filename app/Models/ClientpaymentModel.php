<?php namespace App\Models;
use CodeIgniter\Model;

class ClientpaymentModel extends Model{
  protected $table = 'billing_table';
  protected $allowedFields = ['company_id','client_id','billing_date', 'date1', 'date2', 'date3', 'date4', 'status','deleted', 'datetime'];
}