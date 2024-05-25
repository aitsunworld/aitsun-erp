<?php

namespace App\Models;
use CodeIgniter\Model;

class DocumentRenewModel extends Model{
	protected $table = 'renews';
	protected $allowedFields = ['company_id','r_category', 'ref_no', 'r_phone', 'r_description', 'r_description', 'r_notes', 'r_file', 'r_due_on', 'r_date', 'r_status', 'deleted','notified','r_customer','payment_status'];

}