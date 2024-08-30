<?php namespace App\Models;
use CodeIgniter\Model;

class PermissionsModel extends Model{
  protected $table = 'permissions';
  protected $allowedFields = ['company_id', 'user_id', 'permission_name', 'is_allowed'];
}