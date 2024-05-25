<?php namespace App\Models;
use CodeIgniter\Model;

class ProductUnits extends Model{
  protected $table = 'product_units';
  protected $allowedFields = ['company_id', 'name', 'deleted', 'check_default'];
}