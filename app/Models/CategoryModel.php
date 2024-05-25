<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model{
  protected $table = 'book_category';
  protected $allowedFields = ['company_id', 'category', 'datetime', 'deleted'];
}


