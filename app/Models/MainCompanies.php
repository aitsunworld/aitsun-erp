<?php namespace App\Models;
use CodeIgniter\Model;

class MainCompanies extends Model{
  protected $table = 'main_companies';
  protected $allowedFields = ['uid', 'created_at', 'updated_at', 'company_logo', 'company_name', 'company_phone', 'country', 'state', 'city', 'postal_code', 'email', 'active_branch','academic_year','start_time','end_time','sc_code','lc_code'];
}