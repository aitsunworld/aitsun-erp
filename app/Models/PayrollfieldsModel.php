<?php namespace App\Models;
use CodeIgniter\Model;

class PayrollfieldsModel extends Model{
  protected $table = 'payroll_fields';
  protected $allowedFields = ['company_id', 'financial_year', 'field_name', 'calculation', 'amount_type','percentage','amount','deleted','deletable','formula','orderby'];
}