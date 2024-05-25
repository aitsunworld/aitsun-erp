<?php namespace App\Models;
use CodeIgniter\Model;
class AnalyticsModel extends Model{
  protected $table = 'analytics_details';
  protected $allowedFields = ['company_id', 'academic_year', 'student_id','sports_eccc_id','involve_sports', 'involve_eccc'];
}


