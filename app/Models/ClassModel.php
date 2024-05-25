<?php namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model{
  protected $table = 'classes';
  protected $allowedFields = ['class','strength','teacher', 'leader1', 'leader2','rewarding', 'datetime','company_id','serial_no','deleted'];
}


