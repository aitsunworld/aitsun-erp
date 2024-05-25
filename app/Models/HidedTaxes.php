<?php namespace App\Models;
use CodeIgniter\Model;

class HidedTaxes extends Model{
  protected $table = 'hided_taxes';
  protected $allowedFields = ['company_id', 'tax_name'];
}