<?php namespace App\Models;
use CodeIgniter\Model;

class MessageTemplatesModel extends Model{
  protected $table = 'message_templates';
  protected $allowedFields = ['company_id', 'template_name', 'subject', 'message'];
}