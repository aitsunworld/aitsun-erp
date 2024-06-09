<?php namespace App\Models;

use CodeIgniter\Model;

class PosSessions extends Model{
  protected $table = 'pos_sessions';
  protected $allowedFields = [ 'date', 'closing_balance', 'Note', 'company_id', 'deleted','user_id','register_id'];
}