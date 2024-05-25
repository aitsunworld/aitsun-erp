<?php namespace App\Models;
use CodeIgniter\Model;

class ConfigurationModel extends Model{
  protected $table = 'configurations';
  protected $allowedFields = ['company_id','smtp_user', 'password', 'smtp_host', 'from_email', 'smtp_port'];
}