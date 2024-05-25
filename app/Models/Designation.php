<?php 
namespace App\Models;
use CodeIgniter\Model;

class Designation extends Model{
  protected $table = 'designation';
  protected $allowedFields = ['company_id', 'designation', 'deleted'];
}