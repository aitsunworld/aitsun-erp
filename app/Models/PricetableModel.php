<?php namespace App\Models;
use CodeIgniter\Model;

class PricetableModel extends Model{
  protected $table = 'price_table';
  protected $allowedFields = ['company_id', 'category_id', 'item_id', 'deleted', 'price','class'];
}