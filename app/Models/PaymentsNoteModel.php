<?php namespace App\Models;
use CodeIgniter\Model;

class PaymentsNoteModel extends Model{
  protected $table = 'payments_follow_up_note';
  protected $allowedFields = ['invoice_id','datetime', 'note'];
}

