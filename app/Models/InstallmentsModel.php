<?php namespace App\Models;

use CodeIgniter\Model;

class InstallmentsModel extends Model{
  protected $table = 'installments';
  protected $allowedFields = ['fees_id', 'invoice_id','installment_name','amount', 'paid_status', 'deleted', 'date'];
}