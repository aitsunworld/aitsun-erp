<?php namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model{
  protected $table = 'chat_messages';
  protected $allowedFields = ['company_id', 'academic_year', 'user_id', 'class_id', 'message', 'reply_to', 'datetime', 'user_type', 'deleted'];
}
 