<?php namespace App\Models;

use CodeIgniter\Model;

class EmployeeCategoriesModel extends Model{
  protected $table = 'employees_categories';
  protected $allowedFields = ['company_id','category_name','leave_for_month','carry_forward','total_working_hour','full_day_hour','half_day_hour','sunday','monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','deleted','from','to'];
}
 