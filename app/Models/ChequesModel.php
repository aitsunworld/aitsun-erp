<?php namespace App\Models;
use CodeIgniter\Model;

class ChequesModel extends Model{
  protected $table = 'cheques';
  protected $allowedFields = ['company_id', 'cheque_title', 'cheque_no', 'date', 'amount', 'status', 'deleted', 'added_by'];
}