<?php namespace App\Models;
use CodeIgniter\Model;

class PosFloors extends Model{
  protected $table = 'pos_floors';
  protected $allowedFields = ['company_id', 'floor_name', 'register_id', 'deleted'];
}