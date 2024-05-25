<?php namespace App\Models;

use CodeIgniter\Model;

class HealthModel extends Model{
  protected $table = 'health_details';
  protected $allowedFields = ['company_id', 'academic_year', 'student_id', 'weight', 'height', 'chest','deleted'];
}


