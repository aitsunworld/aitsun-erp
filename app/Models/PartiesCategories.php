<?php namespace App\Models;
use CodeIgniter\Model;

class PartiesCategories extends Model{
  protected $table = 'parties_categories';
  protected $allowedFields = ['parties_cat_name', 'company_id', 'deleted'];
}