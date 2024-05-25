<?php namespace App\Models;
use CodeIgniter\Model;

class AlertSessionModel extends Model{
  protected $table = 'alert_session';
  protected $allowedFields = ['bill_id','datetime', 'status'];
}