<?php namespace App\Models;
use CodeIgniter\Model;

class DeliverylocationModel extends Model{
  protected $table = 'delivery_location';
  protected $allowedFields = ['company_id', 'region_name', 'location_type', 'parent_id', 'pincode', 'shipping_charge', 'deleted', 'delivery_days'];
}