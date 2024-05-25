<?php namespace App\Models;

use CodeIgniter\Model;

class ClientsModel extends Model{
  protected $table = 'clients';
  protected $allowedFields = [ 'company_id', 'client_logo', 'client_name', 'url'];
}