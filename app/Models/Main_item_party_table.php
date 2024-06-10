<?php namespace App\Models;
use CodeIgniter\Model;

class Main_item_party_table extends Model{
  protected $table = 'main_item_party_table';
   protected $primaryKey = 'id';
  protected $allowedFields = ['company_id', 'display_name', 'email', 'contact_name', 'phone', 'created_at', 'deleted', 'first_name', 'last_name', 'password', 'status', 'author', 'profile_pic', 'u_type', 'updated_at', 'serial_no', 'datetime', 'max_user', 'app_status', 'app', 'country', 'effected', 'edit_effected', 'opening_balance', 'price', 'main_compani_id', 'allowed_branches', 'is_branch_changed', 'academic_year', 'message_credits', 'sender_name', 'category', 'subcategory', 'product_type', 'sub_category', 'sec_category', 'slug', 'product_name', 'unit', 'discounted_price', 'tax', 'stock', 'purchased_price', 'barcode', 'staff_type', 'school', 'activated_financial', 'activated_academic', 'employee_category', 'transfer', 'activated_financial_year', 'created_by', 'user_token', 'default_user', 'credit_limit', 'brand', 'added_by', 'purchase_tax', 'sale_tax', 'tax_percent', 'mrp', 'purchase_margin', 'sale_margin', 'category_name', 'brand_name', 'at_price', 'sub_unit', 'conversion_unit_rate', 'editable', 'product_name_with_category', 'is_manufactured', 'pro_ap_code', 'department_cat_code', 'barcode_type', 'custom_barcode', 'ready_to_update', 'gst_no', 'financial_year', 'group_head', 'type', 'parent_id', 'customer_id', 'closing_balance', 'opening_value', 'closing_value', 'customer_default_user', 'transport_charge', 'final_closing_value','final_closing_value_fifo','max_branch', 'is_concept_user', 'main_type', 'primary', 'nature', 'default', 'pro_img', 'm2_id', 'main_id2', 'staff_code', 'shifts', 'gender', 'part_category', 'medical', 'landmark', 'district', 'modified', 'password_2', 'access', 'main_subject', 'date_of_join', 'suspended_on', 'rewarding', 'date_of_birth', 'stdage', 'father_name', 'mother_name', 'class', 'roll_no', 'admission_no', 'blood_group', 'ration_card_no', 'nature_of_appointment', 'qualification', 'religion', 'country_code', 'is_website', 'description', 'fav', 'online', 'deals_of_day', 'view_as', 'expiry_date', 'batch_no', 'rich_description', 'delivery_days', 'top', 'keywords', 'top_seller', 'product_color', 'product_code', 'pro_in', 'product_method', 'latest_product', 'flash_seller', 'upsell_product', 'product_group1', 'scrapped_by', 'bin_location', 'class_id', 'vehicle', 'm1_id', 'main_id', 'website', 'billing_name', 'billing_mail', 'billing_country', 'billing_state', 'billing_city', 'billing_postalcode', 'billing_address', 'shipping_name', 'shipping_mail', 'shipping_country', 'shipping_state', 'shipping_city', 'shipping_postatlcode', 'shipping_address', 'lc_key', 'validity', 'soft_status', 'packdate', 'ip', 'exp_notified', 'hosting', 'address1', 'address2', 'company_name', 'city', 'state', 'pincode', 'email_verified', 'phone_verified', 'login_oauth_uid', 'aitsun_user', 'online_shop', 'crm', 'year_end', 'languages', 'phone_2', 'location', 'designation', 'contact_type', 'company', 'area', 'landline', 'saved_as', 'attendance_allowed', 'pan', 'adhar', 'bank_name', 'ifsc', 'account_number', 'pf_no', 'esi_no', 'restaurent', 'hr_manage', 'monthly_billing_date', 'pos_payment_type','waste_column','payment_method','is_static_journal','is_pos','is_appoinments','is_clinic','is_food','is_self_order'];

      
 

 protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];

  protected function beforeInsert(array $data){
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;

    if (isset($data['data']['category_name'])) {
      $cat=$data['data']['category_name'];
    }else{
      $cat='';
    }
    if(isset($data['data']['product_name']))
      $data['data']['product_name_with_category'] =$data['data']['product_name'].' '.$cat;
     
    $data = $this->passwordHash($data);
    $data['data']['created_at'] = date('Y-m-d H:i:s');
    return $data;
  }

  protected function beforeUpdate(array $data){
    $loggedInUserId = session()->get('id');
    $loggedInUserToken = session()->get('user_token'); 
    $data['data']['created_by'] = $loggedInUserId;
    $data['data']['user_token'] = $loggedInUserToken;

    if (isset($data['data']['category_name'])) {
      $cat=$data['data']['category_name'];
    }else{
      $cat='';
    }
    if(isset($data['data']['product_name']))
      $data['data']['product_name_with_category'] =$data['data']['product_name'].' '.$cat;
       
    
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
