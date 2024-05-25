<?php namespace App\Models;

use CodeIgniter\Model;

class Classtablemodel extends Model{
  protected $table = 'class_table';
  protected $allowedFields = ['company_id','academic_year','student_id', 'class_id', 'deleted','first_name','roll_no','gender','category','transfer'];
}


