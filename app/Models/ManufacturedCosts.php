<?php namespace App\Models;
use CodeIgniter\Model;

class ManufacturedCosts extends Model{
  protected $table = 'manufactured_costs';
  protected $allowedFields = ['manufacture_id','product_id', 'charges', 'details', 'cost', 'deleted', 'old_cost', 'effected', 'edit_effected'];

  protected $beforeInsert = ['beforeInsert']; 
  protected $primaryKey = 'id';

  protected function beforeInsert(array $data){ 
    $data['data']['old_cost'] =$data['data']['cost']; 
    return $data;
  }


} 