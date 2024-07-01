<?php namespace App\Models;
use CodeIgniter\Model;

class ChequeDepartmentsModel extends Model{
  protected $table = 'cheque_departments';
  protected $allowedFields = ['company_id', 'department_name', 'responsible_person', 'deleted'];
}