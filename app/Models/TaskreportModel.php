<?php namespace App\Models;
use CodeIgniter\Model;

class TaskreportModel extends Model{
  protected $table = 'task_report';
  protected $allowedFields = ['company_id', 'financial_year', 'task', 'lead_id', 'datetime', 'created_by', 'ip', 'mac', 'grid_no','task_type','report'];
}