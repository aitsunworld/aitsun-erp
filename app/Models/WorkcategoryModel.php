<?php namespace App\Models;
use CodeIgniter\Model;

class WorkcategoryModel extends Model{
  protected $table = 'work_category';
  protected $allowedFields = ['company_id', 'category_name', 'deleted','parent_id'];
}