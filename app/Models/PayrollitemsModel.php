<?php namespace App\Models;
use CodeIgniter\Model;

class PayrollitemsModel extends Model{
  protected $table = 'payroll_items';
  protected $allowedFields = ['company_id', 'financial_year', 'payroll_id', 'employee_id', 'basic_salary', 'extra_leave', 'overtime', 'allowance','medical','deduction','net_salary','deleted','nod','present_days','gross_salary','pf_amount','esic_amount','effected','edit_effected','old_total','type','formula','created_by','user_token'];


protected $beforeInsert = ['beforeInsert']; 
protected $beforeUpdate = ['beforeUpdate']; 
  protected $primaryKey = 'id';

  protected function beforeInsert(array $data){ 
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;
    $data['data']['old_total'] =$data['data']['net_salary'];
    return $data;
  }

  protected function beforeUpdate(array $data){ 
      $loggedInUserId = session()->get('id');
      $loggedInUserToken = session()->get('user_token'); 
      $data['data']['created_by'] = $loggedInUserId;
      $data['data']['user_token'] = $loggedInUserToken;
      return $data;
    }
}