<?php namespace App\Models;
use CodeIgniter\Model;

class AttendanceEventModel extends Model{
  protected $table = 'attendance_events';
  protected $allowedFields = ['company_id', 'event_name', 'event_date', 'deleted','effect_to','type','font_color','bg_color'];
}