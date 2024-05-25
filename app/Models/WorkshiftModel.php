<?php namespace App\Models;

use CodeIgniter\Model;

class WorkshiftModel extends Model{
  protected $table = 'work_shift';
  protected $allowedFields = [ 'company_id', 'financial_year', 'shift', 'from', 'to', 'deleted'];
}