<?php namespace App\Models;
use CodeIgniter\Model;

class ProductrequestsModel extends Model{
  protected $table = 'product_requests';
  protected $allowedFields = ['product_name', 'pro_quantity', 'description', 'user_id', 'datetime', 'deleted', 'type', 'email', 'phone','name','status','moved_to_crm','company_id','notified','country','reason'];
}