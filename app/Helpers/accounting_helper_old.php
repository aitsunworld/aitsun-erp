<?php
    use App\Models\AccountingModel as AccountingModel;
    use App\Models\CustomerBalances as CustomerBalances;
    use App\Models\PaymentsModel as PaymentsModel;
    use App\Models\TaxtypeModel as TaxtypeModel;
    use App\Models\ProductsModel as ProductsModel;
    use App\Models\InvoiceModel as InvoiceModel;
    use App\Models\FinancialYears as FinancialYears;
    use App\Models\Main_item_party_table as Main_item_party_table;
    use App\Models\Item_party_meta_1 as Item_party_meta_1;
    use App\Models\Item_party_meta_2 as Item_party_meta_2;



    
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
        
        $last_year_accounts=$AccountingModel->where('company_id',$company_id)->where('financial_year',$old_year)->where('deleted',0)->findAll();
  

        foreach ($last_year_accounts as $lya) {
            $accounts_exist=$AccountingModel->where('company_id',$company_id)->where('financial_year',$financial_year)->where('group_head',$lya['group_head'])->where('deleted',0)->first();

            if ($accounts_exist) {
                $nfa_data=[  
                    'opening_balance'=>$lya['closing_balance'],
                    'closing_balance'=>$lya['closing_balance'],
                    'opening_value'=>$lya['closing_value'],
                    'closing_value'=>$lya['closing_value'],
                    'stock'=>$lya['closing_balance'],
                    'at_price'=>get_products_data($lya['customer_id'],'purchased_price'),
                    'category_name'=>get_products_data($lya['customer_id'],'category_name'),
                    'product_name'=>get_products_data($lya['customer_id'],'product_name'),
                    'ready_to_update'=>1,
                ];
                $AccountingModel->update($accounts_exist['id'],$nfa_data);

                 

            }else{
                $nfa_data=[
                    'company_id'=>$company_id,
                    'financial_year'=>$financial_year,
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
                    'opening_value'=>$lya['closing_value'],
                    'closing_value'=>$lya['closing_value'],
                    'stock'=>$lya['closing_balance'], 
                    'category_name'=>get_products_data($lya['customer_id'],'category_name'),
                    'product_name'=>get_products_data($lya['customer_id'],'product_name'),
                    'at_price'=>get_products_data($lya['customer_id'],'purchased_price'),
                    'ready_to_update'=>1
                ];
                $AccountingModel->save($nfa_data);
 
            }
            
        }
 

    }

    function parent_id_of_group_head($company_id,$old_parent_id,$old_year,$financial_year){
        $AccountingModel=new Main_item_party_table;
        $parent_name='';
        $new_parent_id=0;
        $parent_name_q=$AccountingModel->where('company_id',$company_id)->where('financial_year',$old_year)->where('id',$old_parent_id)->where('deleted',0)->first();

        if ($parent_name_q) {
            $parent_name=$parent_name_q['group_head'];
        }

        $new_parent_id=0;

        if ($parent_name!='') {
            $new_parent_id_q=$AccountingModel->where('company_id',$company_id)->where('financial_year',$financial_year)->where('group_head',$parent_name)->where('deleted',0)->first();
            $new_parent_id=$new_parent_id_q['id'];
        }
         return $new_parent_id;
    }


    function group_head_main_array($company_id){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('financial_year',activated_year($company_id))->where('deleted',0)->where('primary',1)->where('type','group_head')->findAll();
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
        $user=$AccountingModel->where('financial_year',activated_year($company_id))->where('deleted',0)->where('type','group_head')->findAll();
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
        $user=$AccountingModel->where('company_id',$company_id)->where('financial_year',activated_year($company_id))->where('customer_id',$customer_id)->where('deleted',0)->where('type',$type)->first();
        if ($user) {
            return true;
        }else{
            return false;
        } 
    }

    function id_of_group_head($company_id,$financial_year,$group_head_name){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('financial_year',activated_year($company_id))->where('group_head',$group_head_name)->first();
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
        // $AccountingModel->where('financial_year',activated_year($company_id));
        
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
        $user=$AccountingModel->where('company_id',$company_id)->where('financial_year',activated_year($company_id))->where('deleted',0)->where('type','ledger')->Where('parent_id!=',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'))->where('parent_id!=',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'))->findAll();
        return $user;
    }

     function ledgers_of_parent($company_id,$parent_id){
        $AccountingModel = new Main_item_party_table;
        $user=$AccountingModel->where('company_id',$company_id)->where('financial_year',activated_year($company_id))->where('deleted',0)->where('type','ledger')->Where('parent_id',$parent_id)->findAll();
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
                'childs'=>array()
            ),
            array(
                'group_head'=>'Capital Account',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'childs'=>array( 
                    array(
                        'group_head'=>'Reserves & Surplus', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    )
                )
            ),
            array(
                'group_head'=>'Current Assets',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'childs'=>array(
                    array(
                        'group_head'=>'Bank Accounts', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Cash-in-Hand', 
                        'type'=>'group_head', 
                        'default'=>'1',
                        'sub_childs'=>array(
                            array(
                                'group_head'=>'Cash', 
                                'type'=>'ledger', 
                                'default'=>'1',
                            ),
                        ),
                    ),
                    array(
                        'group_head'=>'Deposits (Asset)', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Loans & Advances (Asset)', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Stock-in-Hand', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Sundry Debtors', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    )
                )
            ),
            array(
                'group_head'=>'Current Liabilities',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'childs'=>array(
                    array(
                        'group_head'=>'Duties & Taxes', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Provisions', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Sundry Creditors', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    )
                )
            ),
            array(
                'group_head'=>'Direct Expenses',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'expenses',
                'default'=>'1',
                'childs'=>array(
                    array(
                        'group_head'=>'Fuel Charges', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Service Charges', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Vehicle Insurance', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Other vehicle expenses', 
                        'type'=>'ledger',
                        'transport_charge'=>'1', 
                        'default'=>'1',
                    )
                )
            ),
            array(
                'group_head'=>'Direct Incomes',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'income',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Fixed Assets',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Indirect Expenses',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'expenses',
                'default'=>'1',
                'childs'=>array(
                    array(
                        'group_head'=>'Discount allowed', 
                        'type'=>'ledger', 
                        'default'=>'1',
                    ),
                )
            ),
            array(
                'group_head'=>'Indirect Incomes',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'income',
                'default'=>'1',
                'childs'=>array(
                    array(
                        'group_head'=>'Discount received', 
                        'type'=>'ledger', 
                        'default'=>'1',
                    ),
                )
            ),
            array(
                'group_head'=>'Investments',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Loans (Liability)',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'childs'=>array(
                    array(
                        'group_head'=>'Bank OD A/C', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Secured Loans', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    ),
                    array(
                        'group_head'=>'Unsecured Loans', 
                        'type'=>'group_head', 
                        'default'=>'1',
                    )
                )
            ),
            array(
                'group_head'=>'Misc. Expenses (ASSET)',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'assets',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Purchase Accounts',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'expenses',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Sales Accounts',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'income',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Suspense A/c',
                'primary'=>'1',
                'type'=>'group_head',
                'nature'=>'liabilties',
                'default'=>'1',
                'childs'=>array()
            ),
            array(
                'group_head'=>'Profit & Loss A/c',
                'primary'=>'1',
                'type'=>'ledger',
                'nature'=>'liabilties',
                'default'=>'1',
                'childs'=>array()
            )
        );

        foreach ($primary_group_heads as $gh) { 

            $ac_data=[
                'company_id'=>$company_id,
                'financial_year'=>$financial_year,
                'group_head'=>$gh['group_head'],
                'primary'=>$gh['primary'],
                'type'=>$gh['type'],
                'nature'=>$gh['nature'], 
                'default'=>$gh['default'], 
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
                    'financial_year'=>$financial_year,
                    'group_head'=>$child['group_head'], 
                    'type'=>$child['type'],  
                    'default'=>$child['default'], 
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
                                'financial_year'=>$financial_year,
                                'group_head'=>$child_ch['group_head'], 
                                'type'=>$child_ch['type'],  
                                'default'=>$child_ch['default'], 
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