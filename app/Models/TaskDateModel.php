<?php namespace App\Models;

use CodeIgniter\Model;

class TaskDateModel extends Model{
  protected $table = 'task_dates';
  protected $allowedFields = ['task_id','task_type','from','to','lead_id','notified','notification_notified','company_id'];
}