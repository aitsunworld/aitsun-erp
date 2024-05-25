<?php namespace App\Models;

use CodeIgniter\Model;

class ActivitiesNotes extends Model{
  protected $table = 'activities_notes';
  protected $allowedFields = [ 'lead_id', 'activities', 'user_id', 'note', 'created_at', 'updated_at', 'deleted', 'type','notified','company_id'];
}