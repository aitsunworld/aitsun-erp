<?php namespace App\Models;

use CodeIgniter\Model;

class NoticeModel extends Model{
  protected $table = 'notice_book';
  protected $allowedFields = ['academic_year','company_id', 'user_id', 'subject', 'details', 'datetime', 'deleted'];
}


