<?php namespace App\Models;
use CodeIgniter\Model;

class OnlineResultModel extends Model{
  protected $table = 'online_results';
  protected $allowedFields = ['id', 'exam_id', 'student_id', 'question_id', 'selected_answer', 'correct_answer'];
}


