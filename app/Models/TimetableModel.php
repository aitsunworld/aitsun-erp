<?php namespace App\Models;

use CodeIgniter\Model;

class TimetableModel extends Model{
  protected $table = 'time_table';
  protected $allowedFields = ['academic_year','company_id', 'week', 'subject', 'class_id', 'start_time', 'end_time', 'datetime', 'deleted', 'serial_no'];
}

