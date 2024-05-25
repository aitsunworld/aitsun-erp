<?php namespace App\Models;
use CodeIgniter\Model;

class MessageModel extends Model{
  protected $table = 'email_msg';
  protected $allowedFields = ['name', 'email', 'subject', 'mblno', 'msg', 'datetime','read'];
}