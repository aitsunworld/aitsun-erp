<?php namespace App\Models;
use CodeIgniter\Model;

class SalarySlipItemsModel extends Model{
  protected $table = 'salary_slip_items';
  protected $allowedFields = ['payroll_items_id', 'payroll_field_id', 'payroll_calculation','payroll_amount_type','percentage', 'amount', 'total_amount','field_name','formula'];
}