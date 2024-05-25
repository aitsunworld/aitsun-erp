<?php namespace App\Models;

use CodeIgniter\Model;

class MessageFileModel extends Model{
  protected $table = 'task_files';
  protected $allowedFields = ['note_id', 'type', 'size', 'file'];
}
