<?php namespace App\Models;
use CodeIgniter\Model;

class LossReasons extends Model{
  protected $table = 'loss_reasons';
  protected $allowedFields = ['company_id', 'stage', 'reason', 'deleted'];
}