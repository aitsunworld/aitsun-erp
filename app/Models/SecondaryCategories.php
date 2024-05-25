<?php namespace App\Models;
use CodeIgniter\Model;

class SecondaryCategories extends Model{
  protected $table = 'secondary_categories';
  protected $allowedFields = ['company_id', 'second_cat_name', 'parent_id', 'sec_sub_cat_img', 'deleted', 'description', 'keywords', 'title', 'slug'];
}