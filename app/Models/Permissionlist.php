<?php namespace App\Models;
use CodeIgniter\Model;

class Permissionlist extends Model{
  protected $table = 'permission_list';
  protected $allowedFields = ['permission_name', 'permission_heading', 'description', 'module'];
}