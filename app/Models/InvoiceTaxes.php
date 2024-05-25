<?php namespace App\Models;
use CodeIgniter\Model;

class InvoiceTaxes extends Model{
  protected $table = 'invoice_taxes';
  protected $allowedFields = ['invoice_id', 'tax_name', 'tax_percent', 'tax_amount','taxable_amount','created_at'];
}