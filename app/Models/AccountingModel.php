<?php namespace App\Models;
use CodeIgniter\Model;

class AccountingModel extends Model{
  protected $table = 'accounts';
  protected $allowedFields = ['company_id', 'financial_year', 'group_head', 'primary', 'type','nature','parent_id', 'default', 'deleted','customer_id','opening_balance','closing_balance','opening_value','closing_value','customer_default_user','transport_charge','transfer','final_closing_value'];
}