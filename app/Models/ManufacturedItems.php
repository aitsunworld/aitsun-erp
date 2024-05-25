<?php namespace App\Models;
use CodeIgniter\Model;

class ManufacturedItems extends Model{
  protected $table = 'manufactured_items';
  protected $allowedFields = ['manufacture_id','product_id', 'product', 'item_id', 'quantity','base_quantity','price', 'selling_price', 'discount', 'amount', 'desc', 'deleted', 'tax', 'unit', 'sub_unit', 'conversion_unit_rate', 'in_unit', 'old_quantity', 'old_amount'];

  protected $beforeInsert = ['beforeInsert']; 
  protected $primaryKey = 'id';

  protected function beforeInsert(array $data){  
    // $data['data']['old_amount'] =$data['data']['amount'];  
    return $data;
  }


} 