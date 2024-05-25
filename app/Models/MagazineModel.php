<?php namespace App\Models;

use CodeIgniter\Model;

class MagazineModel extends Model{
  protected $table = 'magazines';
  protected $allowedFields = ['academic_year','company_id', 'student_id', 'teacher_id', 'magazine_img', 'title', 'description', 'datetime', 'deleted', 'status'];
}

