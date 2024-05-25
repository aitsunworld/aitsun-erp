<?php namespace App\Models;
use CodeIgniter\Model;

class ScrapModel extends Model{
  protected $table = 'scrap_sites';
  protected $allowedFields = ['company_id','site_name', 'product_name', 'price', 'currency', 'description', 'rich_description', 'keywords', 'product_image', 'thumb_image', 'brand', 'category', 'sub_category', 'sec_category','check_default'];
}