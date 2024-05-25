<?php namespace App\Models;
use CodeIgniter\Model;

class ManufacturesModel extends Model{
  protected $table = 'invoices';
  protected $allowedFields = ['company_id', 'financial_year', 'product_id','product_name', 'manufactured_date', 'total_cost', 'total_additional_cost', 'type', 'effected', 'edit_effected', 'deleted', 'old_total_cost', 'old_total_additional_cost', 'additional_cost_payment_type', 'total_manufactured_cost','old_total_manufactured_cost','manufactured_quantity','manufactured_in_unit','manufactured_unit','manufactured_sub_unit','manufactured_unit_rate','old_manufactured_quantity','base_unit_rate'];

  protected $beforeInsert = ['beforeInsert']; 
  protected $primaryKey = 'id';

  protected function beforeInsert(array $data){ 
    $data['data']['product_name'] =product_name($data['data']['product_id']);
    // $data['data']['old_total_cost'] =$data['data']['total_cost']; 
    // $data['data']['old_total_additional_cost'] =$data['data']['total_additional_cost'];
    // $data['data']['old_total_manufactured_cost'] =$data['data']['total_manufactured_cost'];

    return $data;
  }


} 