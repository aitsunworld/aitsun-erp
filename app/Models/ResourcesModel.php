<?php namespace App\Models;

use CodeIgniter\Model;

class ResourcesModel extends Model{
  protected $table = 'resources';
  protected $allowedFields = ['company_id','appointment_resource','capacity','description','deleted'];
}
 