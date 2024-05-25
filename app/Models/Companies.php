<?php namespace App\Models;
use CodeIgniter\Model;

class Companies extends Model{
  protected $table = 'companies';
  protected $allowedFields = ['uid', 'created_at', 'updated_at', 'company_logo', 'company_name', 'company_phone', 'country', 'state', 'city', 'postal_code', 'email', 'parent_company', 'active', 'gstin_vat_no','website','company_telephone','contact','address','additional_contacts','fax','about','start_time','end_time','datetime','academic_year','feedback','allow_massanger','sc_code','lc_code','sports_id','eccc_id','deleted'];
}