<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel-deleted extends Model{

  protected $table = 'customers';
  protected $allowedFields = ['company_id', 'display_name', 'email', 'contact_name', 'phone', 'website', 'billing_name', 'billing_mail', 'billing_country', 'billing_state', 'billing_city', 'billing_postalcode', 'billing_address', 'shipping_name', 'shipping_mail', 'shipping_country', 'shipping_state', 'shipping_city', 'shipping_postatlcode', 'shipping_address', 'created_at', 'deleted', 'first_name', 'last_name', 'password', 'status', 'profile_pic', 'u_type', 'updated_at', 'serial_no', 'gst_no', 'lc_key', 'datetime', 'validity', 'soft_status', 'packdate', 'ip', 'exp_notified', 'author', 'hosting', 'max_user', 'app_status', 'app', 'country', 'address1', 'address2', 'company_name', 'city', 'state', 'pincode', 'email_verified', 'phone_verified', 'login_oauth_uid', 'aitsun_user', 'online_shop', 'crm', 'year_end', 'languages', 'phone_2', 'location', 'designation', 'contact_type', 'company', 'area', 'landline', 'saved_as', 'attendance_allowed', 'pan', 'adhar', 'bank_name', 'ifsc', 'account_number', 'pf_no', 'esi_no', 'restaurent', 'hr_manage', 'monthly_billing_date', 'pos_payment_type','effected','edit_effected','opening_balance','max_branch','is_concept_user','price','staff_code','shifts','gender','main_compani_id','allowed_branches','part_category','medical','is_branch_changed','academic_year','landmark','district','modified','password_2','access','message_credits', 'sender_name','main_subject','date_of_join','suspended_on','rewarding','date_of_birth','stdage','father_name','mother_name','class','roll_no','category','subcategory','admission_no','blood_group','ration_card_no','nature_of_appointment','qualification','religion','staff_type','school','activated_financial','activated_academic','employee_category','country_code','default_user','credit_limit','transfer','is_website','activated_financial_year','created_by','user_token'];

  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];

  protected function beforeInsert(array $data){
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;

    $data = $this->passwordHash($data);
    $data['data']['created_at'] = date('Y-m-d H:i:s');
    return $data;
  }

  protected function beforeUpdate(array $data){
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;
    
    $data = $this->passwordHash($data);
    $data['data']['updated_at'] = date('Y-m-d H:i:s');
    return $data;
  }

  protected function passwordHash(array $data){
    if(isset($data['data']['password']))
    $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    return $data;
  }


}