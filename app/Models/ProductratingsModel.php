<?php namespace App\Models;
use CodeIgniter\Model;

class ProductratingsModel extends Model{
  protected $table = 'product_rating';
  protected $allowedFields = ['userid', 'productid', 'rating', 'review', 'datetime', 'review_type'];
}