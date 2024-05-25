<?php namespace App\Models;
use CodeIgniter\Model;

class RenewFiles extends Model{
  protected $table = 'renew_files';
  protected $allowedFields = ['renew_id','file'];
}