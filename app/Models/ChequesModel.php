<?php namespace App\Models;
use CodeIgniter\Model;

class ChequesModel extends Model{
  protected $table = 'cheques';
  protected $allowedFields = ['company_id', 'cheque_title', 'cheque_no', 'created_date','cheque_customer', 'amount', 'status', 'deleted', 'added_by','cheque_date','cheque_department','cheque_category','cheque_note'];
}