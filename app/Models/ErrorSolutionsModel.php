<?php namespace App\Models;
use CodeIgniter\Model;

class ErrorSolutionsModel extends Model{
  protected $table = 'error_solutions';
  protected $allowedFields = ['company_id', 'project_id', 'version_id', 'error_name', 'details', 'screenshot', 'type', 'deleted','datetime','added_by','parent_id'];
}
