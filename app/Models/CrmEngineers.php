<?php namespace App\Models;
use CodeIgniter\Model;

class CrmEngineers extends Model{
  protected $table = 'crm_engineers';
  protected $allowedFields = ['company_id', 'lead_id', 'stage', 'created_at', 'added_by', 'deleted', 'engineer','day','hrs','min'];
}