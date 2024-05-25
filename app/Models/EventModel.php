<?php namespace App\Models;
use CodeIgniter\Model;

class EventModel extends Model{
  protected $table = 'events';
  protected $allowedFields = ['academic_year','company_id','title','start_event','end_event','secondary_id','deletable'];
}