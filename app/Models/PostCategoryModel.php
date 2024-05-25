<?php namespace App\Models;

use CodeIgniter\Model;

class PostCategoryModel extends Model{
  protected $table = 'post_categories';
  protected $allowedFields = ['category_name','slug','parent','company_id'];
}