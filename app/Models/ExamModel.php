<?php namespace App\Models;

use CodeIgniter\Model;

class ExamModel extends Model{
  protected $table = 'exams';
  protected $allowedFields = ['academic_year','company_id', 'exam_name', 'date', 'from', 'to', 'description','marksvaluate','exam_logo','exam_for_subject','exam_for_class','exam_type', 'max_marks', 'min_marks', 'deleted','main_exam_id','exammarks','max_grade','min_grade'];
}


