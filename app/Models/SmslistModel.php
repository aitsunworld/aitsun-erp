<?php namespace App\Models;
use CodeIgniter\Model;
class SmslistModel extends Model{
  protected $table = 'sms_list';
  protected $allowedFields = ['company_id', 'number', 'message','datetime','sender_id'];
}

