<?php 
namespace App\Models;
use CodeIgniter\Model;

class ProjectType extends Model{
  protected $table = 'project_types';
  protected $allowedFields = ['company_id', 'project_type', 'deleted'];
}