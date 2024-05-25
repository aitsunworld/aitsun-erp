<?php namespace App\Models;
use CodeIgniter\Model;

class StudentlocationModel extends Model{
  protected $table = 'student_location';
  protected $allowedFields = ['company_id', 'student_id', 'item_id','deleted','serial_no'];
}


