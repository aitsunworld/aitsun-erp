<?php namespace App\Models;
use CodeIgniter\Model;

class PosRegisters extends Model{
  protected $table = 'pos_registers';
  protected $allowedFields = ['company_id', 'register_name', 'register_type', 'deleted'];
}