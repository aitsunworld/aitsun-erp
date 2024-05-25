<?php namespace App\Models;
use CodeIgniter\Model;

class AttendanceModel extends Model{
  protected $table = 'attendances';
  protected $allowedFields = ['company_id', 'financial_year', 'date', 'attendance', 'attendance2', 'employee_id', 'student_id','created_at','note','event_id','field_id','login_time','logout_time','class_id','academic_year','punched_time', 'punch_id', 'state', 'employee_code', 'u_type','ip_address','deleted','inout_status'];
}