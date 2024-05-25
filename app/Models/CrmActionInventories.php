<?php namespace App\Models;
use CodeIgniter\Model;

class CrmActionInventories extends Model{
  protected $table = 'crm_action_inventories';
  protected $allowedFields = ['company_id','invoice_id', 'lead_id', 'deleted','invoice_type','created_at'];
}