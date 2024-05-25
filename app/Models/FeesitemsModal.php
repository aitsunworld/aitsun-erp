<?php namespace App\Models;

use CodeIgniter\Model;

class FeesitemsModal extends Model{
  protected $table = 'fees_items';
  protected $allowedFields = ['company_id','fees_id', 'product_id'];
}




