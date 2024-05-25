<?php

namespace App\Models;

use CodeIgniter\Model;

class EnquiriesModel extends Model
{
    protected $table = 'enquiry';
    protected $allowedFields = ['company_id', 'name', 'email', 'message', 'datetime', 'deleted','phone','subject','notified','enquiry_type']; 
}
    
