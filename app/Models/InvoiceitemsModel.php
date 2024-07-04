<?php namespace App\Models;
use CodeIgniter\Model;

class InvoiceitemsModel extends Model{
  protected $table = 'invoice_items';
  protected $allowedFields = ['invoice_id', 'product', 'product_id','product_method', 'quantity', 'price', 'discount','discount_percent', 'amount', 'desc', 'type', 'item_kit_id', 'tax','unit','split_tax','sale_tax','purchase_tax','mrp','purchase_margin','sale_margin','old_quantity','deleted','sub_unit','conversion_unit_rate','in_unit','batch_number',' editable','invoice_type','purchased_price','purchased_amount','old_purchase_price','old_purchase_amount','item_id','base_quantity','selling_price','old_amount','product_priority','invoice_date','is_custom','entry_type','company_id','picked_qty','returned_qty','picked_in_unit','returned_in_unit','rental_price_type'];
 
  protected $primaryKey = 'id';
 
}