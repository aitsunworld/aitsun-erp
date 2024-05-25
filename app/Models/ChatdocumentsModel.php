<?php namespace App\Models;

use CodeIgniter\Model;

class MessageFileModel extends Model{
  protected $table = 'chat_documents';
  protected $allowedFields = ['company_id', 'academic_year', 'class_id', 'message_id', 'type', 'size', 'file'];
}
