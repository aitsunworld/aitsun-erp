<?php namespace App\Models;
use CodeIgniter\Model;

class ProductSubCategories extends Model{
  protected $table = 'product_sub_categories';
  protected $allowedFields = ['company_id', 'sub_cat_name', 'parent_id', 'sub_cat_img', 'deleted', 'description', 'keywords', 'title', 'slug'];
}