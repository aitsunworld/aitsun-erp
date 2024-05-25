<?php namespace App\Models;
use CodeIgniter\Model;

class TaxtypeModel extends Model{
  protected $table = 'taxtypes';
  protected $allowedFields = ['company_id', 'name', 'percent', 'description', 'deleted', 'default_tax', 'check_default'];
}