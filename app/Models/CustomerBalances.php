<?php namespace App\Models;
use CodeIgniter\Model;

class CustomerBalances extends Model{
  protected $table = 'customer_balances';
  protected $allowedFields = ['company_id', 'financial_year', 'opening_balance', 'closing_balance', 'opening_type', 'closing_type', 'customer_id','type'];
}