<?php namespace App\Models;
use CodeIgniter\Model;

class LeaveManagement extends Model{
  protected $table = 'leave_management';
  protected $allowedFields = ['staff_id', 'comapany_id', 'leave_status', 'date'];
}