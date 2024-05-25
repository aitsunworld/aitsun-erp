<?php namespace App\Models;
use CodeIgniter\Model;

class ProductBrand extends Model{
  protected $table = 'product_brand';
  protected $allowedFields = ['company_id', 'brand_name', 'deleted', 'brand_img', 'brand_img_dark' ,'brand_img_light', 'description', 'keywords', 'title', 'slug'];
}