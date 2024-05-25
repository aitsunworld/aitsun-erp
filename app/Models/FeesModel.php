<?php namespace App\Models;

use CodeIgniter\Model;

class FeesModel extends Model{
  protected $table = 'fees_table';
  protected $allowedFields = ['company_id', 'academic_year', 'fees_name', 'class', 'due_date', 'deleted', 'datetime','description','added_by','fees_type'];
}


