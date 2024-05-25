<?php namespace App\Models;
use CodeIgniter\Model;

class FinancialYears extends Model{
  protected $table = 'financial_years';
  protected $allowedFields = ['company_id', 'financial_from', 'financial_to', 'status', 'activated'];
}