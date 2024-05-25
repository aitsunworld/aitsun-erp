<?php namespace App\Models;
use CodeIgniter\Model;

class DoccategoryModel extends Model{
  protected $table = 'doc_renew_category';
  protected $allowedFields = ['company_id', 'category_name', 'name', 'deleted'];
}