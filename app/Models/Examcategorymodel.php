<?php namespace App\Models;

use CodeIgniter\Model;

class Examcategorymodel extends Model{
  protected $table = 'exam_category';
  protected $allowedFields = ['academic_year','company_id','serial_no','exam_category','deleted', 'datetime'];
}
 