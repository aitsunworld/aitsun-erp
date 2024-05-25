<?php namespace App\Models;

use CodeIgniter\Model;

class SportsparticipantModel extends Model{
  protected $table = 'sports_participants';
  protected $allowedFields = ['academic_year','company_id', 'student_id', 'sports_id', 'deleted', 'datetime', 'serial_no','type'];
}


