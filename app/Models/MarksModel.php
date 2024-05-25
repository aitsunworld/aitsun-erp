<?php namespace App\Models;

use CodeIgniter\Model;

class MarksModel extends Model{
  protected $table = 'mark_sheet';
  protected $allowedFields = ['academic_year','company_id', 'exam_id','student_id', 'subject_id', 'marks', 'status', 'datetime', 'deleted','grade','exam_mark_type'];
}


