<?php namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model{
  protected $table = 'leads';
  protected $allowedFields = ['company_id','financial_year','serial_number', 'lead_name', 'followers', 'lead_status', 'responsible_user', 'contact', 'company_name', 'work_phone', 'work_email', 'position', 'web', 'address', 'skype', 'note', 'file', 'created_at', 'lead_date', 'updated_at', 'deleted', 'start_date', 'end_date', 'description','lead_by','project_type','cr_customer','lead_type','request_id','notified','oldid','lead_department','lpo','quotation_no','amount'];
}