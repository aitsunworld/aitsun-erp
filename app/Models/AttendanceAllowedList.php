<?php namespace App\Models;
use CodeIgniter\Model;

class AttendanceAllowedList extends Model{
  protected $table = 'attendance_allowed';
  protected $allowedFields = ['company_id','user_id','user_name','attendance_allowed'];
}