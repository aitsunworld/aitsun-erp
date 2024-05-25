<?php namespace App\Models;

use CodeIgniter\Model;

class IssuebookModel extends Model{
  protected $table = 'issued_books';
  protected $allowedFields = ['academic_year','serial_no','company_id', 'student_id', 'book_id', 'issued_date', 'return_date', 'deleted', 'status'];
}


