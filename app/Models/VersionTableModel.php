<?php namespace App\Models;
use CodeIgniter\Model;

class VersionTableModel extends Model{
  protected $table = 'version_table';
  protected $allowedFields = ['project_id', 'version_name', 'details', 'datetime', 'filename', 'file_path', 'added_by', 'deleted'];
}
