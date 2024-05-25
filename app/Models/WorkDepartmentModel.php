<?php 
  namespace App\Models;
  use CodeIgniter\Model;

  class WorkDepartmentModel extends Model{
    protected $table = 'work_departments';
    protected $allowedFields = ['company_id', 'department_name', 'department_head', 'deleted'];
  }