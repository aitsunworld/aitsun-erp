<?php namespace App\Models;
use CodeIgniter\Model;

class FieldsNameModel extends Model{
  protected $table = 'fields_names';
  protected $allowedFields = ['company_id', 'fields_name','deleted'];
}