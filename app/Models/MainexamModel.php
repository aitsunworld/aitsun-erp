<?php namespace App\Models;

use CodeIgniter\Model;

class MainexamModel extends Model{
  protected $table = 'main_exam';
  protected $allowedFields = ['academic_year','company_id', 'exam_name', 'category', 'start_date', 'end_date', 'description', 'exam_logo','deleted','exam_status'];
}


