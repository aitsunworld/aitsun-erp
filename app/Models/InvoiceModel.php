<?php namespace App\Models;
use CodeIgniter\Model;

class InvoiceModel extends Model{
  protected $table = 'invoices';
  protected $allowedFields = ['company_id', 'customer', 'waiter', 'table_no', 'invoice_date', 'notes', 'private_notes', 'order_notes', 'tax', 'created_at', 'updated_at', 'discount', 'sub_total', 'total', 'status', 'paid_status', 'paid_amount', 'due_amount', 'deleted', 'invoice_type', 'bill_number', 'secondary_invoice_id', 'converted', 'converted_id', 'serial_no', 'order_type', 'country', 'fullname', 'company_name', 'address1', 'address2', 'city', 'state', 'pincode', 'email', 'phone', 'order_status', 'shipping_charge', 'billed_by', 'delivery_person', 'cancel_reason', 'geo_location', 'latitude', 'longitude', 'financial_year', 'alternate_name','round_type','round_off','vehicle_number','company_state','state_of_supply','effected','edit_effected','old_total','old_concession','cash_discount_percent','additional_discount_percent','additional_discount','due_date','responsible_person','renew_id','renew_effected','inv_referal','validity','mrn_number','doctor_name','counted','fees_id','main_total','concession_for','is_installment','success_payment_id','payment_method','vehicle_id','driver_id','class_id','fees_type','closing_effected','is_custom','created_by','user_token','transport_charge','booking_id','bill_from','rental_status', 'invoice_address', 'delivery_address', 'rent_from', 'rent_to', 'rental_duration','session_id','register_id','pos_receipt_no'];

  protected $beforeInsert = ['beforeInsert']; 
  protected $beforeUpdate = ['beforeUpdate']; 
  protected $primaryKey = 'id';

  protected function beforeInsert(array $data){ 
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;

    $data['data']['old_total'] =$data['data']['total'];
    $data['data']['old_concession'] =$data['data']['discount'];
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