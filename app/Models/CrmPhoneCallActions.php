<?php namespace App\Models;
use CodeIgniter\Model;

class CrmPhoneCallActions extends Model{
  protected $table = 'crm_phone_all_actions';
  protected $allowedFields = ['company_id', 'lead_id', 'stage', 'created_at', 'added_by', 'report', 'deleted','reason_for_loss'];
}