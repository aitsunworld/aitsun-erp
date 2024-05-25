<?php namespace App\Models;
use CodeIgniter\Model;

class StockModel extends Model{
  protected $table = 'stocks';
  protected $allowedFields = ['company_id', 'financial_year', 'product_id', 'opening_stock', 'closing_stock', 'current_stock'];
}