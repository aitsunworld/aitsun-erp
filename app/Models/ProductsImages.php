<?php namespace App\Models;
use CodeIgniter\Model;

class ProductsImages extends Model{
  protected $table = 'product_images';
  protected $allowedFields = ['company_id', 'product_id', 'image'];
}