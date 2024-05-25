<?php namespace App\Models;
use CodeIgniter\Model;

class TaxModel extends Model{
  protected $table = 'taxes';
  protected $allowedFields = ['tax_id', 'invoice_id', 'tax_percent', 'tax_name', 'tax_amount'];
}