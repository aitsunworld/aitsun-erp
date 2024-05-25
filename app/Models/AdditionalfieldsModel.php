<?php namespace App\Models;
use CodeIgniter\Model;

class AdditionalfieldsModel extends Model{
  protected $table = 'additional_fields';
  protected $allowedFields = ['product_id', 'product_code', 'field', 'field_name', 'field_value','switchable'];
}