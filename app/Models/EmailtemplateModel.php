<?php namespace App\Models;
use CodeIgniter\Model;

class EmailtemplateModel extends Model{
  protected $table = 'email_templates';
  protected $allowedFields = ['company_id','invoice_subject', 'invoice_content', 'estimate_subject', 'estimate_content', 'payment_subject', 'payment_content'];
}