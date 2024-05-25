<?php namespace App\Models;

use CodeIgniter\Model;

class AcademicYearModel extends Model{
  protected $table = 'academic_years';
  protected $allowedFields = ['company_id','year','deleted'];
}
 