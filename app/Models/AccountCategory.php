<?php namespace App\Models;
use CodeIgniter\Model;

class AccountCategory extends Model{
  protected $table = 'account_category';
  protected $allowedFields = ['company_id', 'category_name', 'pos_default', 'slug', 'group_head', 'deleted', 'side', 'customer_id','parent_id'];
}