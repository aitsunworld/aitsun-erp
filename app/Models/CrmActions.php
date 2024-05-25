<?php namespace App\Models;
use CodeIgniter\Model;

class CrmActions extends Model{
  protected $table = 'crm_actions';
  protected $allowedFields = ['company_id', 'lead_id', 'stage', 'created_at', 'added_by', 'report', 'deleted','reason_for_loss'];
}