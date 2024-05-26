<?php namespace App\Models;
use CodeIgniter\Model;

class AppointmentsModel extends Model{
  protected $table = 'appointments';
  protected $allowedFields = ['company_id', 'added_by', 'datetime', 'title', 'duration', 'availability_on', 'hours_before', 'days_before', 'allow_cancelling_before', 'person', 'resource', 'is_image_show', 'assign_method', 'deleted'];
}