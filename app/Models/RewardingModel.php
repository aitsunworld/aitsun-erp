<?php namespace App\Models;

use CodeIgniter\Model;

class RewardingModel extends Model{
  protected $table = 'rewardings';
  protected $allowedFields = ['company_id', 'academic_year', 'student_id', 'event_id', 'type', 'mark', 'reward', 'deleted'];
}
 