<?php namespace App\Models;

use CodeIgniter\Model;

class PushedAttendanceOfEmployee extends Model{
  protected $table = 'pushed_attendances';
  protected $allowedFields = ['company_id','date','employee_id','day_status','worked_hours','overtime_hours','late_come','deleted'];
}
 