<?php namespace App\Models;
use CodeIgniter\Model;

class ProjectTableModel extends Model{
  protected $table = 'project_table';
  protected $allowedFields = ['company_id', 'project_name', 'details', 'datetime', 'added_by', 'deleted','last_modified'];
}