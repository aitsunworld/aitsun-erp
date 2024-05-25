<?php namespace App\Models;
use CodeIgniter\Model;

class TransactionModel extends Model{
  protected $table = 'transactions';
  protected $allowedFields = ['company_id', 'user_id', 'transaction_id', 'amount', 'datetime', 'order_id', 'signature'];
}