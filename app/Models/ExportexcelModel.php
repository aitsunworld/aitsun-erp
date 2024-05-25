<?php namespace App\Models;
use CodeIgniter\Model;

class ExportexcelModel extends Model{
  protected $table = 'export_execel';
  protected $allowedFields = ['company_id', 'task_name', 'table_name', 'from', 'to', 'formate', 'file_path', 'file_name', 'status'];
}