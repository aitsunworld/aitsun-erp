<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model{
  protected $table = 'subjects';
  protected $allowedFields = ['academic_year','subject_name','subject_code','datetime','company_id','serial_no','deleted','sub_type', 'deletable', 'parent_id'];
}


