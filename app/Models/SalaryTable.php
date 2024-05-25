<?php namespace App\Models;

use CodeIgniter\Model;

class SalaryTable extends Model{
  protected $table = 'salary_table';
  protected $allowedFields = ['company_id', 'financial_year', 'month', 'employee_id', 'basic_salary', 'deleted'];
}