<?php namespace App\Models;
use CodeIgniter\Model;

class CrmExpenses extends Model{
  protected $table = 'crm_expenses';
  protected $allowedFields = ['company_id', 'lead_id', 'stage', 'created_at', 'added_by', 'deleted', 'expense'];
}