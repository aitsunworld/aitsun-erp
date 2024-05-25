<?php namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model{
  protected $table = 'feedback';
  protected $allowedFields = ['name', 'email', 'review', 'projectid','datetime','company_id','academic_year','student_id','subject','deleted'];
}