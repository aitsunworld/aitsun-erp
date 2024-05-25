<?php namespace App\Models;
use CodeIgniter\Model;

class InvoiceSubmitModel extends Model{
  protected $table = 'invoice_submits';
  protected $allowedFields = ['company_id', 'financial_year', 'customer_id', 'invoice_date', 'invoice_number', 'amount', 'responsible_person', 'deleted', 'status', 'received','created_at'];
}