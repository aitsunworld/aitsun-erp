<?php namespace App\Models;

use CodeIgniter\Model;

class TeachersModel extends Model{
  protected $table = 'teachers_tables';
  protected $allowedFields = ['company_id','academic_year','class_id', 'teacher_id', 'deleted','first_name'];
}


