<?php namespace App\Models;
use CodeIgniter\Model;

class ExpensesModel extends Model{
  protected $table = 'expenses';
  protected $allowedFields = ['company_id','academic_year', 'ex_name', 'ac_category', 'grp_heads', 'pos_default', 'deleted'];
}