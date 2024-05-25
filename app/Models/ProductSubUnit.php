<?php namespace App\Models;
use CodeIgniter\Model;

class ProductSubUnit extends Model{
  protected $table = 'product_sub_unit';
  protected $allowedFields = ['company_id', 'sub_unit_name', 'parent_id','deleted','slug'];
}