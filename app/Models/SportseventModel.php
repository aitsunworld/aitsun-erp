<?php namespace App\Models;

use CodeIgniter\Model;

class SportseventModel extends Model{
  protected $table = 'sports_events';
  protected $allowedFields = ['academic_year','company_id', 'events_name', 'from', 'to', 'related_to', 'c_type', 'place', 'subject_id', 'serial_no', 'deleted','status','type'];
}


