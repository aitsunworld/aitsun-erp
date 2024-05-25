<?php namespace App\Models;
use CodeIgniter\Model;

class PaymentsModel extends Model{
  protected $table = 'payments';
  protected $allowedFields = ['invoice_id', 'customer', 'type', 'amount', 'reference_id', 'cheque_no', 'cheque_amount', 'cheque_date', 'payment_note', 'datetime', 'payment_id', 'company_id', 'bill_type', 'receive_status', 'account_name', 'deleted', 'serial_no', 'alternate_name', 'financial_year','voucher_id','quantity','price','effected', 'edit_effected','old_total','collected_by','razorpay_payment_id','razorpay_signature','success_payment_id','payment_method','opening_balance','install_id','fees_id','discount','money_type','class_id','delete_reason','vehicle_id','created_by','user_token'];

  protected $beforeInsert = ['beforeInsert']; 
  protected $beforeUpdate = ['beforeUpdate'];
  protected $primaryKey = 'id';

  protected function beforeInsert(array $data){ 
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;

    // $data['data']['old_total'] =$data['data']['amount'];
    // $data['data']['money_type'] =get_group_data($data['data']['type'],'group_head');

    return $data;
  }


protected function beforeUpdate(array $data){
  $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;
    
    // if(isset($data['data']['type']))
    // $data['data']['money_type'] =get_group_data($data['data']['type'],'group_head'); 
    return $data;
  }
}