<?php namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model{
  protected $table = 'vehicle_details';
  protected $allowedFields = ['company_id','vehicle_name','vehicle_number','driver','contact','deleted','serial_no'];
}


