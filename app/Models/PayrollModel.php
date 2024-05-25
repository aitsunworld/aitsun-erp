<?php namespace App\Models;
use CodeIgniter\Model;

class PayrollModel extends Model{
  protected $table = 'payroll_table';
  protected $allowedFields = ['company_id', 'financial_year', 'month', 'total_salary', 'created_at', 'deleted','payment_type'];
}

