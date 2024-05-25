<?php namespace App\Models;
use CodeIgniter\Model;

class CarryForwardedLeaves extends Model{
  protected $table = 'carry_forwarded_leaves';
  protected $allowedFields = ['company_id', 'staff_id', 'year','leave'];
}