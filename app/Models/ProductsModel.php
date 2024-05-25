<?php namespace App\Models;
use CodeIgniter\Model;

class ProductsModel extends Model{
  protected $table = 'products';
  protected $allowedFields = ['slug', 'company_id', 'product_name', 'unit', 'price', 'discounted_price', 'tax', 'description', 'stock', 'created_at', 'purchased_price', 'category', 'barcode', 'deleted', 'product_type', 'sub_category', 'sec_category', 'fav', 'online', 'deals_of_day', 'pro_img', 'brand', 'serial_no', 'view_as', 'expiry_date', 'batch_no', 'rich_description', 'added_by', 'delivery_days', 'top', 'keywords', 'top_seller', 'product_color', 'product_code', 'pro_in','product_method','latest_product','flash_seller','upsell_product','product_group1','scrapped_by','purchase_tax', 'sale_tax','tax_percent','mrp', 'purchase_margin', 'sale_margin','category_name','brand_name','at_price','effected', 'edit_effected', 'opening_balance','sub_unit','conversion_unit_rate','bin_location','class_id','editable','vehicle','product_name_with_category','is_manufactured','pro_ap_code','department_cat_code','barcode_type','custom_barcode','created_by','user_token','ready_to_update'];


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
      return $data;
  }
}