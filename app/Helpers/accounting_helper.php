<?php 
    use App\Models\CustomerBalances as CustomerBalances;
    use App\Models\PaymentsModel as PaymentsModel;
    use App\Models\TaxtypeModel as TaxtypeModel;
    use App\Models\ProductsModel as ProductsModel;
    use App\Models\InvoiceModel as InvoiceModel;
    use App\Models\FinancialYears as FinancialYears;
    use App\Models\Main_item_party_table as Main_item_party_table; 
    use App\Models\InvoiceitemsModel as InvoiceitemsModel;


    function calculate_sale_value_average($product_id){
        $myid=session()->get('id');
        //opening stock and value 
        $Main_item_party_table=new Main_item_party_table;
        $InvoiceitemsModel=new InvoiceitemsModel;

        $purch_value=0;
        $purch_quantity=0;
        $average_price_of_item_before_sale=0;
        $final_stock_value_of_item_before_sale_return=0;
        $final_stock_value_of_item=0;

        $pro_data=$Main_item_party_table->where('id',$product_id)->first();
        $at_price=$pro_data['at_price'];
        $opening_stock=$pro_data['opening_balance'];
        $opening_stock_value=$opening_stock*$at_price;

        $current_year=get_date_format(now_time($myid),'Y');

        $all_purchase_price=0;
        $purchase_return_price=0;
        $total_stock_quantity=0;

        $total_stock_quantity+=$opening_stock;

        // purchase manipulation
        $get_purchase_value=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) as total_quantity')->where('product_id',$product_id)->where('invoice_type','purchase')->where('YEAR(invoice_date)',$current_year)->where('deleted',0)->first();

        if (!empty($get_purchase_value['total_quantity'])) {
            if ($get_purchase_value['total_quantity']>0) {
                $total_stock_quantity+=$get_purchase_value['total_quantity'];
            } 
        }

        if (!empty($get_purchase_value['total'])) {
            if ($get_purchase_value['total']>0) {
                $all_purchase_price+=$get_purchase_value['total'];
            } 
        }

        // purchase return manipulation
         $get_purchase_return_value=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) as total_quantity')->where('product_id',$product_id)->where('invoice_type','purchase_return')->where('YEAR(invoice_date)',$current_year)->where('deleted',0)->first();
        
         if (!empty($get_purchase_return_value['total_quantity'])) {
            if ($get_purchase_return_value['total_quantity']>0) {
                $total_stock_quantity-=$get_purchase_return_value['total_quantity'];
            } 
        }

        if (!empty($get_purchase_return_value['total'])) {
            if ($get_purchase_return_value['total']>0) {
                $all_purchase_price-=$get_purchase_return_value['total'];
            } 
        }
        

          if (is_numeric($total_stock_quantity) && $total_stock_quantity>0) {
           
            $average_price_of_item_before_sale=($opening_stock_value+($all_purchase_price-$purchase_return_price))/$total_stock_quantity;
            
        }else{
            $average_price_of_item_before_sale=($opening_stock_value+($all_purchase_price-$purchase_return_price))/1;
        }
        


        $stock_value_before_sale=$average_price_of_item_before_sale*$total_stock_quantity;
        // echo '<br>';

        $get_sales_value=$InvoiceitemsModel->select('sum(amount) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) AS total_qty')->where('product_id',$product_id)->where('invoice_type','sales')->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->first();
        $sales_quantity=0;

         if (!empty($get_sales_value['total_qty'])) {
            if ($get_sales_value['total_qty']>0) {
                $sales_quantity+=$get_sales_value['total_qty'];
            } 
        }

        $stock_quantity_after_sales=$total_stock_quantity-=$sales_quantity;
        // echo $total_stock_quantity; echo '<br>';
        $final_stock_value_of_item=$average_price_of_item_before_sale*$sales_quantity;

        $stock_value_after_sales=$stock_value_before_sale-$final_stock_value_of_item;
    
 
        $tempstock_quantity_after_sales=0;

$get_sales_return_value=$InvoiceitemsModel->select('sum(amount) as total,sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) AS total_qty')->where('product_id',$product_id)->where('invoice_type','sales_return')->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->first();
     

        if (!empty($get_sales_return_value['total_qty'])) {
            if ($get_sales_return_value['total_qty']>0) {
                $tempstock_quantity_after_sales+=$get_sales_return_value['total_qty'];
            } 
        }
        
         if (!empty($stock_quantity_after_sales) && $stock_quantity_after_sales!=0) {
           $final_avg_price=$stock_value_after_sales/$stock_quantity_after_sales;
        }else{
            $final_avg_price=$stock_value_after_sales/1;
        }

 
return $stock_value_after_sales+($final_avg_price*$tempstock_quantity_after_sales);


    }

    function calculate_sale_value_fifo($proo_id){
        $Main_item_party_table= new Main_item_party_table;
        $InvoiceModel= new InvoiceModel;
        $InvoiceitemsModel= new InvoiceitemsModel;

         
        $p_data=$Main_item_party_table->where('id',$proo_id)->first();

       
        $myid=session()->get('id');
        $current_year=get_date_format(now_time($myid),'Y');
        $purchase_history = [];

        $total_purchase_value=0;
        $get_purchasess=$InvoiceitemsModel->select('sum(purchased_amount/conversion_unit_rate) as total')->where('product_id',$proo_id)->groupStart()->where('invoice_type','purchase')->orWhere('invoice_type','sales_return')->groupEnd()->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->first();

        if ($get_purchasess['total']!='') {
            $total_purchase_value = $get_purchasess['total'];
        }else{
            $total_purchase_value=0;
        }


        $get_sales_quantity=$InvoiceitemsModel->select('sum(CASE WHEN in_unit=unit THEN quantity ELSE quantity/conversion_unit_rate END) AS total_qty')->where('product_id',$proo_id)->groupStart()->where('invoice_type','sales')->orWhere('invoice_type','purchase_return')->groupEnd()->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->first();
        if ($get_sales_quantity['total_qty']!='') {
            $total_sold_quantity = $get_sales_quantity['total_qty'];
        }else{
            $total_sold_quantity=0;
        }

  
        $inventories=$InvoiceitemsModel->where('product_id',$proo_id)->groupStart()->where('invoice_type','purchase')->orWhere('invoice_type','sales_return')->groupEnd()->where('deleted',0)->where('YEAR(invoice_date)',$current_year)->orderBy('id','desc')->findAll();

        
        $returned_quantity=0;
        $returned_at_price=0;
        $returned_total=0;

        foreach ($inventories as $inventory) { 
                $purchase_history[] = [
                    'product' => 'Mango',
                    'quantity' => $inventory['quantity']/$inventory['conversion_unit_rate'],
                    'at_price' => $inventory['price'],
                    'total' => $inventory['amount'],
                    'invoice_type'=> $inventory['invoice_type']
                ];
           
        }

        if ($p_data) {
            $purchase_history[]=[
                'product' => 'Mango',
                'quantity' => $p_data['opening_balance'],
                'at_price' => $p_data['at_price'],
                'total' => $p_data['opening_balance']*$p_data['at_price'], 
                'invoice_type' => 'opening', 
            ];
            
            $total_purchase_value+=$p_data['opening_balance']*$p_data['at_price'];
        }
        

        $return_filtered_purchase_history=array_reverse($purchase_history);

        $stock_value = 0;
        $sold_quantity = 0;

        foreach ($return_filtered_purchase_history as $purchase) {
            $remaining_quantity = $purchase['quantity'];
            if ($sold_quantity + $remaining_quantity <= $total_sold_quantity) {
                // If the remaining quantity can be sold
                $sold_quantity += $remaining_quantity;
                $stock_value += $purchase['total'];
            } else {
                // If only a part of the remaining quantity can be sold
                $remaining_quantity = $total_sold_quantity - $sold_quantity;
                $stock_value += ($remaining_quantity / $purchase['quantity']) * $purchase['total'];
                break;
            }
        }

        return $total_purchase_value-$stock_value;
    }


    function cash_in_hand($company_id){
        $AccountingModel=new Main_item_party_table;
        $cashin=0;
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'));
        $ledger_data=$AccountingModel->where('company_id',$company_id)->where('type','ledger')->where('deleted',0)->orderBy('id','DESC')->findAll();
        foreach ($ledger_data as $ld) {
            $cashin+=$ld['closing_balance'];
        }
        return aitsun_round($cashin,get_setting($company_id,'round_of_value'));
    }


    function cash_in_bank($company_id){ 
        $AccountingModel=new Main_item_party_table;
        $bankin=0;
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'));
        $ledger_data=$AccountingModel->where('company_id',$company_id)->where('type','ledger')->where('deleted',0)->orderBy('id','DESC')->findAll();
        foreach ($ledger_data as $ld) {
            $bankin+=$ld['closing_balance'];
        }
        return aitsun_round($bankin,get_setting($company_id,'round_of_value'));
    }

    function cash_in_bank_array($company_id){ 
        $AccountingModel=new Main_item_party_table;
        $bankin=[];
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'));
        $ledger_data=$AccountingModel->where('company_id',$company_id)->where('type','ledger')->where('deleted',0)->orderBy('id','DESC')->findAll();
      
        return $ledger_data;
    }

    function cash_in_hand_array($company_id){ 
        $AccountingModel=new Main_item_party_table;
        $bankin=[];
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'));
        $ledger_data=$AccountingModel->where('company_id',$company_id)->where('type','ledger')->where('deleted',0)->orderBy('id','DESC')->findAll();
      
        return $ledger_data;
    }

    function last_financial_year($ft,$company_id){
        $FinancialYears = new FinancialYears;
        $gs=$FinancialYears->where('company_id',$company_id)->where('status','1')->orderBy('id','DESC')->first();

        if ($gs) {
            return $gs[$ft];
        }else{
            return 'not_exist';
        }
    }

   

    function transfer_accounting_heads($company_id,$old_year,$financial_year){
        $AccountingModel=new Main_item_party_table;
        
        $last_year_accounts=$AccountingModel->where('company_id',$company_id)->where('deleted',0)->findAll();
  

        foreach ($last_year_accounts as $lya) {
            $old_nfa_data=[
                'waste_column'=>1
            ];

            $AccountingModel->update($lya['id'],$old_nfa_data);

            $accounts_exist=$AccountingModel->where('company_id',$company_id)->where('group_head',$lya['group_head'])->where('deleted',0)->first();

            if ($accounts_exist) {

                $nfa_data=[  
                    'opening_balance'=>$lya['closing_balance'],
                    'closing_balance'=>$lya['closing_balance'],
                    'opening_value'=>$lya['final_closing_value'],
                    'final_closing_value'=>$lya['final_closing_value'],
                    'stock'=>$lya['closing_balance'],
                    'at_price'=>$lya['purchased_price'],
                    'category_name'=>$lya['category_name'],
                    'product_name'=>$lya['product_name'],
                    'ready_to_update'=>1,
                    'company_id'=>$lya['company_id'],
                    'display_name'=>$lya['display_name'],
                    'email'=>$lya['email'],
                    'contact_name'=>$lya['contact_name'],
                    'phone'=> $lya['contact_name'],
                    'created_at'=> $lya['created_at'], 
                    'deleted'=> $lya['deleted'], 
                    'first_name'=> $lya['first_name'], 
                    'last_name'=> $lya['last_name'], 
                    'password'=> $lya['password'], 
                    'status'=> $lya['status'], 
                    'author'=> $lya['author'], 
                    'profile_pic'=> $lya['profile_pic'], 
                    'u_type'=> $lya['u_type'], 
                    'updated_at'=> $lya['updated_at'], 
                    'serial_no'=> $lya['serial_no'], 
                    'datetime'=> $lya['datetime'], 
                    'max_user'=> $lya['max_user'], 
                    'app_status'=> $lya['app_status'],
                    'app'=> $lya['app'],
                    'country'=> $lya['country'],
                    'effected'=> $lya['effected'],
                    'edit_effected'=> $lya['edit_effected'],
                    'price'=> $lya['price'],
                    'main_compani_id'=> $lya['main_compani_id'],
                    'allowed_branches'=> $lya['allowed_branches'],
                    'is_branch_changed'=> $lya['is_branch_changed'],
                    'academic_year'=> $lya['academic_year'],
                    'message_credits'=> $lya['message_credits'],
                    'sender_name'=> $lya['sender_name'],
                    'category'=> $lya['category'],
                    'subcategory'=> $lya['subcategory'],
                    'product_type'=> $lya['product_type'],
                    'sub_category'=> $lya['sub_category'],
                    'sec_category'=> $lya['sec_category'],
                    'slug'=> $lya['slug'],
                    'unit'=> $lya['unit'],
                    'discounted_price'=> $lya['discounted_price'],
                    'tax'=> $lya['tax'],
                    'purchased_price'=> $lya['purchased_price'],
                    'barcode'=> $lya['barcode'],
                    'staff_type'=> $lya['staff_type'],
                    'school'=> $lya['school'],
                    
                    'activated_academic'=> $lya['activated_academic'],
                    'employee_category'=> $lya['employee_category'],
                    'transfer'=> $lya['transfer'],
                    'created_by'=> $lya['created_by'],
                    'user_token'=> $lya['user_token'],
                    'default_user'=> $lya['default_user'],
                    'credit_limit'=> $lya['credit_limit'],
                    'brand'=> $lya['brand'],
                    'added_by'=> $lya['added_by'],
                    'purchase_tax'=> $lya['purchase_tax'],
                    'sale_tax'=> $lya['sale_tax'],
                    'tax_percent'=> $lya['tax_percent'],
                    'mrp'=> $lya['mrp'],
                    'purchase_margin'=> $lya['purchase_margin'],
                    'sale_margin'=> $lya['sale_margin'],
                    'brand_name'=> $lya['brand_name'],
                    'sub_unit'=> $lya['sub_unit'],
                    'conversion_unit_rate'=> $lya['conversion_unit_rate'],
                    'editable'=> $lya['editable'],
                    'product_name_with_category'=> $lya['product_name_with_category'],
                    'is_manufactured'=> $lya['is_manufactured'],
                    'pro_ap_code'=> $lya['pro_ap_code'],
                    'department_cat_code'=> $lya['department_cat_code'],
                    'barcode_type'=> $lya['barcode_type'],
                    'custom_barcode'=> $lya['custom_barcode'],
                    'gst_no'=> $lya['gst_no'],
                    
                    'group_head'=> $lya['group_head'],
                    'type'=> $lya['type'],
                    'parent_id'=> $lya['parent_id'],
                    'customer_id'=> $lya['customer_id'],
                    'customer_default_user'=> $lya['customer_default_user'],
                    'transport_charge'=> $lya['transport_charge'],
                    'max_branch'=> $lya['max_branch'],
                    'is_concept_user'=> $lya['is_concept_user'],
                    'main_type'=> $lya['main_type'],
                    'primary'=> $lya['primary'],
                    'nature'=> $lya['nature'],
                    'default'=> $lya['default'],
                    'pro_img'=> $lya['pro_img'],
                    'm2_id'=> $lya['m2_id'],
                    'main_id2'=> $lya['main_id2'],
                    'staff_code'=> $lya['staff_code'],
                    'shifts'=> $lya['shifts'],
                    'gender'=> $lya['gender'],
                    'part_category'=> $lya['part_category'],
                    'medical'=> $lya['medical'],
                    'landmark'=> $lya['landmark'],
                    'district'=> $lya['district'],
                    'modified'=> $lya['modified'],
                    'password_2'=> $lya['password_2'],
                    'access'=> $lya['access'],
                    'main_subject'=> $lya['main_subject'],
                    'date_of_join'=> $lya['date_of_join'],
                    'suspended_on'=> $lya['suspended_on'],
                    'rewarding'=> $lya['rewarding'],
                    'date_of_birth'=> $lya['date_of_birth'],
                    'stdage'=> $lya['stdage'],
                    'father_name'=> $lya['father_name'],
                    'mother_name'=> $lya['mother_name'],
                    'class'=> $lya['class'],
                    'roll_no'=> $lya['roll_no'],
                    'admission_no'=> $lya['admission_no'],
                    'blood_group'=> $lya['blood_group'],
                    'ration_card_no'=> $lya['ration_card_no'],
                    'nature_of_appointment'=> $lya['nature_of_appointment'],
                    'qualification'=> $lya['qualification'],
                    'religion'=> $lya['religion'],
                    'country_code'=> $lya['country_code'],
                    'is_website'=> $lya['is_website'],
                    'description'=> $lya['description'],
                    'fav'=> $lya['fav'],
                    'online'=> $lya['online'],
                    'deals_of_day'=> $lya['deals_of_day'],
                    'view_as'=> $lya['view_as'],
                    'expiry_date'=> $lya['expiry_date'],
                    'batch_no'=> $lya['batch_no'],
                    'rich_description'=> $lya['rich_description'],
                    'delivery_days'=> $lya['delivery_days'],
                    'top'=> $lya['top'],
                    'keywords'=> $lya['keywords'],
                    'top_seller'=> $lya['top_seller'],
                    'product_color'=> $lya['product_color'],
                    'product_code'=> $lya['product_code'],
                    'pro_in'=> $lya['pro_in'],
                    'product_method'=> $lya['product_method'],
                    'latest_product'=> $lya['latest_product'],
                    'flash_seller'=> $lya['flash_seller'],
                    'upsell_product'=> $lya['upsell_product'],
                    'product_group1'=> $lya['product_group1'],
                    'scrapped_by'=> $lya['scrapped_by'],
                    'bin_location'=> $lya['bin_location'],
                    'class_id'=> $lya['class_id'],
                    'vehicle'=> $lya['vehicle'],
                    'm1_id'=> $lya['m1_id'],
                    'main_id'=> $lya['main_id'],
                    'website'=> $lya['website'],
                    'billing_name'=> $lya['billing_name'],
                    'billing_mail'=> $lya['billing_mail'],
                    'billing_country'=> $lya['billing_country'],
                    'billing_state'=> $lya['billing_state'],
                    'billing_city'=> $lya['billing_city'],
                    'billing_postalcode'=> $lya['billing_postalcode'],
                    'billing_address'=> $lya['billing_address'],
                    'shipping_name'=> $lya['shipping_name'],
                    'shipping_mail'=> $lya['shipping_mail'],
                    'shipping_country'=> $lya['shipping_country'],
                    'shipping_state'=> $lya['shipping_state'],
                    'shipping_city'=> $lya['shipping_city'],
                    'shipping_postatlcode'=> $lya['shipping_postatlcode'],
                    'shipping_address'=> $lya['shipping_address'],
                    'lc_key'=> $lya['lc_key'],
                    'validity'=> $lya['validity'],
                    'soft_status'=> $lya['soft_status'],
                    'packdate'=> $lya['packdate'],
                    'ip'=> $lya['ip'],
                    'exp_notified'=> $lya['exp_notified'],
                    'hosting'=> $lya['hosting'],
                    'address1'=> $lya['address1'],
                    'address2'=> $lya['address2'],
                    'company_name'=> $lya['company_name'],
                    'city'=> $lya['city'],
                    'state'=> $lya['state'],
                    'pincode'=> $lya['pincode'],
                    'email_verified'=> $lya['email_verified'],
                    'phone_verified'=> $lya['phone_verified'],
                    'login_oauth_uid'=> $lya['login_oauth_uid'],
                    'aitsun_user'=> $lya['aitsun_user'],
                    'online_shop'=> $lya['online_shop'],
                    'crm'=> $lya['crm'],
                    'year_end'=> $lya['year_end'],
                    'languages'=> $lya['languages'],
                    'phone_2'=> $lya['phone_2'],
                    'location'=> $lya['location'],
                    'designation'=> $lya['designation'],
                    'contact_type'=> $lya['contact_type'],
                    'company'=> $lya['company'],
                    'area'=> $lya['area'],
                    'landline'=> $lya['landline'],
                    'saved_as'=> $lya['saved_as'],
                    'attendance_allowed'=> $lya['attendance_allowed'],
                    'pan'=> $lya['pan'],
                    'adhar'=> $lya['adhar'],
                    'bank_name'=> $lya['bank_name'],
                    'ifsc'=> $lya['ifsc'],
                    'account_number'=> $lya['account_number'],
                    'pf_no'=> $lya['pf_no'],
                    'esi_no'=> $lya['esi_no'],
                    'restaurent'=> $lya['restaurent'],
                    'hr_manage'=> $lya['hr_manage'],
                    'monthly_billing_date'=> $lya['monthly_billing_date'],
                    'pos_payment_type'=> $lya['pos_payment_type']
                ];
                $AccountingModel->update($accounts_exist['id'],$nfa_data);

                 

            }else{ 
                $nfa_data=[
                    'company_id'=>$company_id,
                    'group_head'=>$lya['group_head'],
                    'primary'=>$lya['primary'],
                    'type'=>$lya['type'],
                    'nature'=>$lya['nature'],
                    'parent_id'=>parent_id_of_group_head($company_id,$lya['parent_id'],$old_year,$financial_year),
                    'opening_balance'=>$lya['closing_balance'],
                    'closing_balance'=>$lya['closing_balance'],
                    'default'=>$lya['default'],
                    'deleted'=>$lya['deleted'],
                    'customer_id'=>$lya['customer_id'],
                    'opening_value'=>$lya['final_closing_value'],
                    'final_closing_value'=>$lya['final_closing_value'],
                    'stock'=>$lya['closing_balance'], 
                    'category_name'=>$lya['category_name'],
                    'product_name'=>$lya['product_name'],
                    'at_price'=>$lya['purchased_price'],
                    'ready_to_update'=>1,
                    'display_name'=>$lya['display_name'],
                    'email'=>$lya['email'],
                    'contact_name'=>$lya['contact_name'],
                    'phone'=> $lya['contact_name'],
                    'created_at'=> $lya['created_at'], 
                    'first_name'=> $lya['first_name'], 
                    'last_name'=> $lya['last_name'], 
                    'password'=> $lya['password'], 
                    'status'=> $lya['status'], 
                    'author'=> $lya['author'], 
                    'profile_pic'=> $lya['profile_pic'], 
                    'u_type'=> $lya['u_type'], 
                    'updated_at'=> $lya['updated_at'], 
                    'serial_no'=> $lya['serial_no'], 
                    'datetime'=> $lya['datetime'], 
                    'max_user'=> $lya['max_user'], 
                    'app_status'=> $lya['app_status'],
                    'app'=> $lya['app'],
                    'country'=> $lya['country'],
                    'effected'=> $lya['effected'],
                    'edit_effected'=> $lya['edit_effected'],
                    'price'=> $lya['price'],
                    'main_compani_id'=> $lya['main_compani_id'],
                    'allowed_branches'=> $lya['allowed_branches'],
                    'is_branch_changed'=> $lya['is_branch_changed'],
                    'academic_year'=> $lya['academic_year'],
                    'message_credits'=> $lya['message_credits'],
                    'sender_name'=> $lya['sender_name'],
                    'category'=> $lya['category'],
                    'subcategory'=> $lya['subcategory'],
                    'product_type'=> $lya['product_type'],
                    'sub_category'=> $lya['sub_category'],
                    'sec_category'=> $lya['sec_category'],
                    'slug'=> $lya['slug'],
                    'unit'=> $lya['unit'],
                    'discounted_price'=> $lya['discounted_price'],
                    'tax'=> $lya['tax'],
                    'purchased_price'=> $lya['purchased_price'],
                    'barcode'=> $lya['barcode'],
                    'staff_type'=> $lya['staff_type'],
                    'school'=> $lya['school'],
                    
                    'activated_academic'=> $lya['activated_academic'],
                    'employee_category'=> $lya['employee_category'],
                    'transfer'=> $lya['transfer'],
                    'created_by'=> $lya['created_by'],
                    'user_token'=> $lya['user_token'],
                    'default_user'=> $lya['default_user'],
                    'credit_limit'=> $lya['credit_limit'],
                    'brand'=> $lya['brand'],
                    'added_by'=> $lya['added_by'],
                    'purchase_tax'=> $lya['purchase_tax'],
                    'sale_tax'=> $lya['sale_tax'],
                    'tax_percent'=> $lya['tax_percent'],
                    'mrp'=> $lya['mrp'],
                    'purchase_margin'=> $lya['purchase_margin'],
                    'sale_margin'=> $lya['sale_margin'],
                    'brand_name'=> $lya['brand_name'],
                    'sub_unit'=> $lya['sub_unit'],
                    'conversion_unit_rate'=> $lya['conversion_unit_rate'],
                    'editable'=> $lya['editable'],
                    'product_name_with_category'=> $lya['product_name_with_category'],
                    'is_manufactured'=> $lya['is_manufactured'],
                    'pro_ap_code'=> $lya['pro_ap_code'],
                    'department_cat_code'=> $lya['department_cat_code'],
                    'barcode_type'=> $lya['barcode_type'],
                    'custom_barcode'=> $lya['custom_barcode'],
                    'gst_no'=> $lya['gst_no'],
                    'customer_default_user'=> $lya['customer_default_user'],
                    'transport_charge'=> $lya['transport_charge'],
                    'max_branch'=> $lya['max_branch'],
                    'is_concept_user'=> $lya['is_concept_user'],
                    'main_type'=> $lya['main_type'],
                    'pro_img'=> $lya['pro_img'],
                    'm2_id'=> $lya['m2_id'],
                    'main_id2'=> $lya['main_id2'],
                    'staff_code'=> $lya['staff_code'],
                    'shifts'=> $lya['shifts'],
                    'gender'=> $lya['gender'],
                    'part_category'=> $lya['part_category'],
                    'medical'=> $lya['medical'],
                    'landmark'=> $lya['landmark'],
                    'district'=> $lya['district'],
                    'modified'=> $lya['modified'],
                    'password_2'=> $lya['password_2'],
                    'access'=> $lya['access'],
                    'main_subject'=> $lya['main_subject'],
                    'date_of_join'=> $lya['date_of_join'],
                    'suspended_on'=> $lya['suspended_on'],
                    'rewarding'=> $lya['rewarding'],
                    'date_of_birth'=> $lya['date_of_birth'],
                    'stdage'=> $lya['stdage'],
                    'father_name'=> $lya['father_name'],
                    'mother_name'=> $lya['mother_name'],
                    'class'=> $lya['class'],
                    'roll_no'=> $lya['roll_no'],
                    'admission_no'=> $lya['admission_no'],
                    'blood_group'=> $lya['blood_group'],
                    'ration_card_no'=> $lya['ration_card_no'],
                    'nature_of_appointment'=> $lya['nature_of_appointment'],
                    'qualification'=> $lya['qualification'],
                    'religion'=> $lya['religion'],
                    'country_code'=> $lya['country_code'],
                    'is_website'=> $lya['is_website'],
                    'description'=> $lya['description'],
                    'fav'=> $lya['fav'],
                    'online'=> $lya['online'],
                    'deals_of_day'=> $lya['deals_of_day'],
                    'view_as'=> $lya['view_as'],
                    'expiry_date'=> $lya['expiry_date'],
                    'batch_no'=> $lya['batch_no'],
                    'rich_description'=> $lya['rich_description'],
                    'delivery_days'=> $lya['delivery_days'],
                    'top'=> $lya['top'],
                    'keywords'=> $lya['keywords'],
                    'top_seller'=> $lya['top_seller'],
                    'product_color'=> $lya['product_color'],
                    'product_code'=> $lya['product_code'],
                    'pro_in'=> $lya['pro_in'],
                    'product_method'=> $lya['product_method'],
                    'latest_product'=> $lya['latest_product'],
                    'flash_seller'=> $lya['flash_seller'],
                    'upsell_product'=> $lya['upsell_product'],
                    'product_group1'=> $lya['product_group1'],
                    'scrapped_by'=> $lya['scrapped_by'],
                    'bin_location'=> $lya['bin_location'],
                    'class_id'=> $lya['class_id'],
                    'vehicle'=> $lya['vehicle'],
                    'm1_id'=> $lya['m1_id'],
                    'main_id'=> $lya['main_id'],
                    'website'=> $lya['website'],
                    'billing_name'=> $lya['billing_name'],
                    'billing_mail'=> $lya['billing_mail'],
                    'billing_country'=> $lya['billing_country'],
                    'billing_state'=> $lya['billing_state'],
                    'billing_city'=> $lya['billing_city'],
                    'billing_postalcode'=> $lya['billing_postalcode'],
                    'billing_address'=> $lya['billing_address'],
                    'shipping_name'=> $lya['shipping_name'],
                    'shipping_mail'=> $lya['shipping_mail'],
                    'shipping_country'=> $lya['shipping_country'],
                    'shipping_state'=> $lya['shipping_state'],
                    'shipping_city'=> $lya['shipping_city'],
                    'shipping_postatlcode'=> $lya['shipping_postatlcode'],
                    'shipping_address'=> $lya['shipping_address'],
                    'lc_key'=> $lya['lc_key'],
                    'validity'=> $lya['validity'],
                    'soft_status'=> $lya['soft_status'],
                    'packdate'=> $lya['packdate'],
                    'ip'=> $lya['ip'],
                    'exp_notified'=> $lya['exp_notified'],
                    'hosting'=> $lya['hosting'],
                    'address1'=> $lya['address1'],
                    'address2'=> $lya['address2'],
                    'company_name'=> $lya['company_name'],
                    'city'=> $lya['city'],
                    'state'=> $lya['state'],
                    'pincode'=> $lya['pincode'],
                    'email_verified'=> $lya['email_verified'],
                    'phone_verified'=> $lya['phone_verified'],
                    'login_oauth_uid'=> $lya['login_oauth_uid'],
                    'aitsun_user'=> $lya['aitsun_user'],
                    'online_shop'=> $lya['online_shop'],
                    'crm'=> $lya['crm'],
                    'year_end'=> $lya['year_end'],
                    'languages'=> $lya['languages'],
                    'phone_2'=> $lya['phone_2'],
                    'location'=> $lya['location'],
                    'designation'=> $lya['designation'],
                    'contact_type'=> $lya['contact_type'],
                    'company'=> $lya['company'],
                    'area'=> $lya['area'],
                    'landline'=> $lya['landline'],
                    'saved_as'=> $lya['saved_as'],
                    'attendance_allowed'=> $lya['attendance_allowed'],
                    'pan'=> $lya['pan'],
                    'adhar'=> $lya['adhar'],
                    'bank_name'=> $lya['bank_name'],
                    'ifsc'=> $lya['ifsc'],
                    'account_number'=> $lya['account_number'],
                    'pf_no'=> $lya['pf_no'],
                    'esi_no'=> $lya['esi_no'],
                    'restaurent'=> $lya['restaurent'],
                    'hr_manage'=> $lya['hr_manage'],
                    'monthly_billing_date'=> $lya['monthly_billing_date'],
                    'pos_payment_type'=> $lya['pos_payment_type']
                ];
                $AccountingModel->save($nfa_data);
 
            }
            
        }
 

    }

    function parent_id_of_group_head($company_id,$old_parent_id,$old_year,$financial_year){
        $AccountingModel=new Main_item_party_table;
        $parent_name='';
        $new_parent_id=0;
        $parent_name_q=$AccountingModel->where('company_id',$company_id)->where('id',$old_parent_id)->where('deleted',0)->first();

        if ($parent_name_q) {
            $parent_name=$parent_name_q['group_head'];
        }

        $new_parent_id=0;

        if ($parent_name!='') {
            $new_parent_id_q=$AccountingModel->where('company_id',$company_id)->where('group_head',$parent_name)->where('deleted',0)->first();
            $new_parent_id=$new_parent_id_q['id'];
        }
         return $new_parent_id;
    }


    function group_head_main_array($company_id){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('deleted',0)->where('primary',1)->where('type','group_head')->findAll();
        return $user;
    }

    function group_head_income_expense_array($company_id){
        $AccountingModel = new Main_item_party_table;
        
        $user=$AccountingModel->where('company_id',$company_id);
        $AccountingModel->groupStart();
            $AccountingModel->orWhere('group_head','Direct Expenses');
            $AccountingModel->orWhere('group_head','Direct Incomes');
            $AccountingModel->orWhere('group_head','Indirect Expenses');
            $AccountingModel->orWhere('group_head','Indirect Incomes');
            $AccountingModel->orWhere('group_head','Bank Accounts');
        $AccountingModel->groupEnd();
        $user=$AccountingModel->where('deleted',0)->where('type','group_head')->findAll();
        return $user;
    }

    function ledger_id_of_user($company_id,$user){
         return $user;
    }

    function ledger_id_of_product($company_id,$user){
         return $user;
    }


    function group_head_sub_cat_array($parent_id){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('parent_id',$parent_id)->where('deleted',0)->where('type','group_head')->findAll();
        return $user;
    }

    function get_group_data($parent_id,$column){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('id',$parent_id)->first();
        if ($user) {
            return $user[$column];
        }else{
            return '';
        } 
    }

    function is_ledger_exist($company_id,$customer_id,$type){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('customer_id',$customer_id)->where('deleted',0)->where('type',$type)->first();
        if ($user) {
            return true;
        }else{
            return false;
        } 
    }

    function id_of_group_head($company_id,$financial_year,$group_head_name){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('group_head',$group_head_name)->first();
        if ($user) {
            return $user['id'];
        }else{
            return 0;
        }
    }

    function id_of_group_head_global($company_id,$group_head_name){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('group_head',$group_head_name)->first();
        if ($user) {
            return $user['id'];
        }else{
            return 0;
        }
    }

    function only_bank_accounts_of_account($company_id){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('company_id',$company_id);
        
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts')); 
        
        $user=$AccountingModel->findAll();
        return $user;
    }

    function only_cash_accounts_of_account($company_id){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('company_id',$company_id);
      
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'));
       

        $user=$AccountingModel->findAll();
        return $user;
    }

    function only_sundry_debtors_accounts_of_account($company_id){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('company_id',$company_id);
      
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Sundry Debtors'));

        $user=$AccountingModel->findAll();
        return $user;
    }

    function only_sundry_creditors_accounts_of_account($company_id){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('company_id',$company_id);
      
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Sundry Creditors'));

        $user=$AccountingModel->findAll();
        return $user;
    }

    

    function bank_accounts_of_account($company_id){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('company_id',$company_id);
        $AccountingModel->where('deleted',0);  
        $AccountingModel->groupStart();
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'));
        $AccountingModel->orWhere('parent_id',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'));
        $AccountingModel->groupEnd();

        $user=$AccountingModel->orderBy('id','ASC')->findAll();
        return $user;
    }

    function is_bank_account($company_id,$lid){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('id',$lid);
        $AccountingModel->groupStart();
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'));
        $AccountingModel->orWhere('parent_id',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'));
        $AccountingModel->groupEnd();

        $user=$AccountingModel->first();
        if ($user) {
            return true;
        }else{
            return false;
        }
    }

    function is_sundry_account($company_id,$lid){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('id',$lid);
        $AccountingModel->groupStart();
        $AccountingModel->where('parent_id',id_of_group_head($company_id,activated_year($company_id),'Sundry Creditors'));
        $AccountingModel->orWhere('parent_id',id_of_group_head($company_id,activated_year($company_id),'Sundry Debtors'));
        $AccountingModel->groupEnd();

        $user=$AccountingModel->first();
        if ($user) {
            return true;
        }else{
            return false;
        }
    }

    

    

    function ledgers_array($company_id){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('deleted',0)->where('type','ledger')->Where('parent_id!=',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'))->where('parent_id!=',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'))->findAll();
        return $user;
    }

     function ledgers_of_parent($company_id,$parent_id){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('deleted',0)->where('type','ledger')->Where('parent_id',$parent_id)->findAll();
        return $user;
    }


    

    function opening_type_of($group_head){
        return 'debit';
    }

    function add_tax_types($company_id){
        $TaxtypeModel=new TaxtypeModel;
        $taxess=[
            [
                'name'=>'None',
                'percent'=>'0'
            ],
            [
                'name'=>'Exempted',
                'percent'=>'0'
            ],
            [
                'name'=>'GST @ 0%',
                'percent'=>'0'
            ],
            [
                'name'=>'GST @ 0.1%',
                'percent'=>'0.1'
            ],
            [
                'name'=>'GST @ 0.25%',
                'percent'=>'0.25'
            ],
            [
                'name'=>'GST @ 1.5%',
                'percent'=>'1.5'
            ],
            [
                'name'=>'GST @ 3%',
                'percent'=>'3'
            ],
            [
                'name'=>'GST @ 5%',
                'percent'=>'5'
            ],
            [
                'name'=>'GST @ 6%',
                'percent'=>'6'
            ],
            [
                'name'=>'GST @ 12%',
                'percent'=>'12'
            ],
            [
                'name'=>'GST @ 13.8%',
                'percent'=>'13.8'
            ],
            [
                'name'=>'GST @ 18%',
                'percent'=>'18'
            ],
            [
                'name'=>'GST @ 14% + Cess @ 12%',
                'percent'=>'26'
            ],
            [
                'name'=>'GST @ 28%',
                'percent'=>'28'
            ],
            [
                'name'=>'GST @ 28% + Cess @ 12%',
                'percent'=>'40'
            ],
            [
                'name'=>'GST @ 28% + Cess @ 60%',
                'percent'=>'88'
            ],
 
        ];

        foreach ($taxess as $tx) {
            $check_exist_tax=$TaxtypeModel->where('company_id',$company_id)->where('name',$tx['name'])->where('deleted',0)->first();
            if (!$check_exist_tax) {
               $at_data = [
                    'company_id' => $company_id,
                    'name'=>trim($tx['name']),
                    'percent'=>trim($tx['percent']),  
                ];

                $savetax=$TaxtypeModel->save($at_data);
            }
            
        }
        
    }


    function tax_array($company_id){
         
         if (get_company_data($company_id,'country')=='Oman') {
             $taxess=[
                [
                    'name'=>'None',
                    'percent'=>'0'
                ],
                [
                    'name'=>'VAT @ 5%',
                    'percent'=>'5'
                ]
     
            ];
         }elseif (get_company_data($company_id,'country')=='United Arab Emirates') {
             $taxess=[
                [
                    'name'=>'None',
                    'percent'=>'0'
                ],
                [
                    'name'=>'VAT @ 5%',
                    'percent'=>'5'
                ]
     
            ];
         }else{
            $taxess=[
                [
                    'name'=>'None',
                    'percent'=>'0'
                ],
                [
                    'name'=>'Exempted',
                    'percent'=>'0'
                ],
                [
                    'name'=>'GST @ 0%',
                    'percent'=>'0'
                ],
                [
                    'name'=>'GST @ 0.1%',
                    'percent'=>'0.1'
                ],
                [
                    'name'=>'GST @ 0.25%',
                    'percent'=>'0.25'
                ],
                [
                    'name'=>'GST @ 1.5%',
                    'percent'=>'1.5'
                ],
                [
                    'name'=>'GST @ 3%',
                    'percent'=>'3'
                ],
                [
                    'name'=>'GST @ 5%',
                    'percent'=>'5'
                ],
                [
                    'name'=>'GST @ 6%',
                    'percent'=>'6'
                ],
                [
                    'name'=>'GST @ 12%',
                    'percent'=>'12'
                ],
                [
                    'name'=>'GST @ 13.8%',
                    'percent'=>'13.8'
                ],
                [
                    'name'=>'GST @ 18%',
                    'percent'=>'18'
                ],
                [
                    'name'=>'GST @ 14% + Cess @ 12%',
                    'percent'=>'26'
                ],
                [
                    'name'=>'GST @ 28%',
                    'percent'=>'28'
                ],
                [
                    'name'=>'GST @ 28% + Cess @ 12%',
                    'percent'=>'40'
                ],
                [
                    'name'=>'GST @ 28% + Cess @ 60%',
                    'percent'=>'88'
                ]
     
            ];
         }

        

        return $taxess;
    }
    

    function add_base_accounting_heads($company_id,$financial_year){
        $AccountingModel=new Main_item_party_table;
        $CustomerBalances=new CustomerBalances;

        $primary_group_heads=array(
            array(
                'group_head'=>'Branch / Divisions',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'is_static_journal'=>1, 
                'childs'=>array()
            ),
            array(
                'group_head'=>'Capital Account',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'is_static_journal'=>1, 
                'childs'=>array( 
                    array(
                        'group_head'=>'Reserves & Surplus', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    )
                )
            ),
            array(
                'group_head'=>'Current Assets',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array(
                    array(
                        'group_head'=>'Bank Accounts', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Cash-in-Hand', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                        'sub_childs'=>array(
                            array(
                                'group_head'=>'Cash', 
                                'type'=>'ledger', 
                                'default'=>'1',
                                'is_static_journal'=>1,
                            ),
                        ),
                    ),
                    array(
                        'group_head'=>'Deposits (Asset)', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Loans & Advances (Asset)', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Stock-in-Hand', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Sundry Debtors', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    )
                )
            ),
            array(
                'group_head'=>'Current Liabilities',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array(
                    array(
                        'group_head'=>'Duties & Taxes', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Provisions', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Sundry Creditors', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    )
                )
            ),
            array(
                'group_head'=>'Direct Expenses',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'expenses',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array(
                    array(
                        'group_head'=>'Fuel Charges', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                        'is_static_journal'=>0,
                    ),
                    array(
                        'group_head'=>'Service Charges', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                        'is_static_journal'=>0,
                    ),
                    array(
                        'group_head'=>'Vehicle Insurance', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                        'is_static_journal'=>0,
                    ),
                    array(
                        'group_head'=>'Other vehicle expenses', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                        'is_static_journal'=>0,
                    )
                )
            ),
            array(
                'group_head'=>'Direct Incomes',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'income',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Fixed Assets',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Indirect Expenses',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'expenses',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array(
                    array(
                        'group_head'=>'Discount allowed', 
                        'type'=>'ledger', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                )
            ),
            array(
                'group_head'=>'Indirect Incomes',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'income',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array(
                    array(
                        'group_head'=>'Discount received', 
                        'type'=>'ledger', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                )
            ),
            array(
                'group_head'=>'Investments',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Loans (Liability)',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array(
                    array(
                        'group_head'=>'Bank OD A/C', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Secured Loans', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    ),
                    array(
                        'group_head'=>'Unsecured Loans', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'is_static_journal'=>1,
                    )
                )
            ),
            array(
                'group_head'=>'Misc. Expenses (ASSET)',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Purchase Accounts',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'expenses',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Sales Accounts',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'income',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Suspense A/c',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            ),
            array(
                'group_head'=>'Profit & Loss A/c',
                'primary'=>'1',
                'type'=>'ledger',
                'nature'=>'liabilties',
                'default'=>'1',
                'is_static_journal'=>1,
                'childs'=>array()
            )
        );

        foreach ($primary_group_heads as $gh) { 

            $ac_data=[
                'company_id'=>$company_id,
                'group_head'=>$gh['group_head'],
                'primary'=>$gh['primary'],
                'type'=>$gh['type'],
                'nature'=>$gh['nature'], 
                'default'=>$gh['default'], 
                'is_static_journal'=>$gh['is_static_journal'], 
                'main_type'=>'account', 
            ];

            $AccountingModel->save($ac_data);
            $parent_id=$AccountingModel->insertID();
 
             foreach ($gh['childs'] as $child) {
                if (isset($child['transport_charge'])) {
                    $tr_charge=$child['transport_charge'];
                }else{
                    $tr_charge=0;
                }
                $ac_child_data=[
                    'company_id'=>$company_id,
                    'group_head'=>$child['group_head'], 
                    'type'=>$child['type'],  
                    'default'=>$child['default'], 
                    'is_static_journal'=>$child['is_static_journal'], 
                    'transport_charge'=>$tr_charge,
                    'parent_id'=>$parent_id,
                    'main_type'=>'account', 
                ]; 
                $AccountingModel->save($ac_child_data);
                $parent_of_parent_id=$AccountingModel->insertID(); 

           

                    if (isset($child['sub_childs'])) {
                        foreach ($child['sub_childs'] as $child_ch) {
                            $ac_child_of_child_data=[
                                'company_id'=>$company_id,
                                'group_head'=>$child_ch['group_head'], 
                                'type'=>$child_ch['type'],  
                                'default'=>$child_ch['default'], 
                                'is_static_journal'=>$child_ch['is_static_journal'], 
                                'parent_id'=>$parent_of_parent_id,
                                'main_type'=>'account', 
                            ]; 
                            $AccountingModel->save($ac_child_of_child_data);

                            $parent_of_child_parent_id=$AccountingModel->insertID(); 
                            
                            

                         }
                    }
                    

             }

        }


    }