<?php
namespace App\Models;
use CodeIgniter\Model;

class WorkUpdatesModel extends Model {
	protected $table = 'work_updates';
	protected $allowedFields = ['company_id', 'user_id', 'description', 'date', 'category','financial_year','department'];
}
