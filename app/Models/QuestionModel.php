<?php namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model{
  protected $table = 'questions';
  protected $allowedFields = ['company_id', 'exam_id', 'question', 'mark','seconds', 'option1', 'option2', 'option3', 'option4', 'correct1', 'correct2','correct3', 'correct4', 'deleted'];
}


