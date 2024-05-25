<?php namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model{
  protected $table = 'tasks';
  protected $allowedFields = ['lead_id', 'task', 'user_id', 'followers', 'task_type', 'created_at', 'notified', 'task_status', 'deleted','notification_notified','company_id'];
}