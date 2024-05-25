<?php namespace App\Models;

use CodeIgniter\Model;

class ManualPayrollFieldValues extends Model{
  protected $table = 'manual_payroll_field_values';
  protected $allowedFields = ['company_id', 'month_details', 'salary_id', 'employee_id', 'field_id','manual_value'];
}