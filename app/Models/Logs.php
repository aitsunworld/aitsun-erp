<?php namespace App\Models;
use CodeIgniter\Model;

class Logs extends Model{
  protected $table = 'log';
  protected $allowedFields = ['user_id', 'action', 'ip', 'mac', 'created_at', 'updated_at', 'company_id', 'deleted'];
}