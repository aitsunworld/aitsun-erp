<?php namespace App\Models;
use CodeIgniter\Model;

class RemindersModel extends Model{
  protected $table = 'reminders';
  protected $allowedFields = ['company_id', 'lead_id', 'date', 'time', 'deleted', 'stage','added_by','created_at','notified'];
}