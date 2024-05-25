<?php namespace App\Models;

use CodeIgniter\Model;

class StudentcategoryModel extends Model{
  protected $table = 'student_category';
  protected $allowedFields = ['company_id', 'category_name', 'deleted', 'type','parent_id','default'];
}


