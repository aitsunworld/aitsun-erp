<?php namespace App\Models;
use CodeIgniter\Model;

class ExpensestypeModel extends Model{
  protected $table = 'expense_types';
  protected $allowedFields = ['company_id', 'expense_name', 'pos_default', 'deleted'];
}