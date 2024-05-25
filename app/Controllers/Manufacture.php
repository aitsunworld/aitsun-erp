<?php
    namespace App\Controllers;
    use App\Models\Main_item_party_table;
    use App\Models\ProductUnits;
    use App\Models\ProductCategories;
    use App\Models\ProductSubCategories;
    use App\Models\SecondaryCategories;
    use App\Models\ProductBrand;
    use App\Models\ProductsModel;
    use App\Models\ProductsImages;
    use App\Models\ProductratingsModel;
    use App\Models\AdditionalfieldsModel;
    use App\Models\ProductrequestsModel;
    use App\Models\StockModel;
    use App\Models\RawmwterialsModel;
    use App\Models\Companies;
    use App\Models\QuoteItemsModel;
    use App\Models\FieldsNameModel; 
    use App\Models\ProductSubUnit;
    use App\Models\CompanySettings; 
    use App\Models\ManufacturesModel; 
    use App\Models\InvoiceitemsModel; 
    use App\Models\ManufacturedCosts; 
    use App\Models\AccountingModel; 

    


    class Manufacture extends BaseController
    {
        public function index()
        {
            $UserModel = new Main_item_party_table();
            $ManufacturesModel = new ManufacturesModel();
            $Companies = new Companies();
            $session=session();

            $pager = \Config\Services::pager();
            
            if ($session->has('isLoggedIn')){ 

            $myid=session()->get('id');
            $acti=activated_year(company($myid));
            // PRODUCTS FETCHING AND PAGINATION START
            $results_per_page = 12; 
            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
            

            if ($_GET) {
                if (isset($_GET['product_name'])) {
                    $ManufacturesModel->like('product_name', $_GET['product_name'], 'both'); 
                } 
            }
                
               if (!empty(get_setting(company($myid),'results_per_page'))) {
                $results_per_page = get_setting(company($myid),'results_per_page'); 
            }else{
                $results_per_page = 10; 
            }
                  
                $get_pro = $ManufacturesModel->where('company_id',company($myid))->where('type','manufactured')->orderBy("id", "desc")->where('deleted',0)->paginate($results_per_page); 
              
            $data=[
                'title'=>'Manufacture - Aitsun ERP',
                'user'=> $UserModel->where('id', session()->get('id'))->first(),
                'product_data'=> $get_pro, 
                // 'number_of_page'=>$number_of_page,
                'pager' => $ManufacturesModel->pager,
            ];
 
            
                echo view('header',$data);
                echo view('manufacture/manufactures',$data);
                echo view('footer');
            }else{
                return redirect()->to(base_url('users'));
            }
            
        }

      

        public function create_raw_materials($proid=""){
            $myid=session()->get('id');
            $session=session();

            if ($session->has('isLoggedIn')){ 
            
                if (!empty($proid)) {
                    $UserModel = new Main_item_party_table();
                    $ProductsModel = new Main_item_party_table();

                    if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


                    $prodt=$ProductsModel->where('id',$proid)->where('deleted',0)->first();

                    if ($prodt) {
                        $data=[
                            'title'=>'Add raw materials - Aitsun ERP',
                            'user'=> $UserModel->where('id', session()->get('id'))->first(),
                            'pro'=>$prodt
                        ];

                        
                        
                            echo view('header',$data);
                            echo view('manufacture/create_raw_materials',$data);
                            echo view('footer');
                        
                    }else{
                        return redirect()->to(base_url());
                    }
                    
                }
            }else{
                return redirect()->to(base_url('users'));
            }
        }

        public function create_manufacture($proid=""){
            $myid=session()->get('id');
            $session=session();

            if ($session->has('isLoggedIn')){ 
            
                if (!empty($proid)) {

                    if (count(raw_materials_array($proid))>0) {
                        $UserModel = new Main_item_party_table();
                        $ProductsModel = new Main_item_party_table();

                        if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


                        $prodt=$ProductsModel->where('id',$proid)->where('deleted',0)->first();

                        if ($prodt) {
                            $data=[
                                'title'=>'Manufacture product - Aitsun ERP',
                                'user'=> $UserModel->where('id', session()->get('id'))->first(),
                                'pro'=>$prodt,
                                'view_type'=>'create',
                            ];

                            
                            
                                echo view('header',$data);
                                echo view('manufacture/create_manufacture',$data);
                                echo view('footer'); 
                    
                        
                    }else{
                        return redirect()->to(base_url());
                    }

                    }else{
                        $session->setFlashdata('pu_er_msg', 'Please add atleast 1 raw material!');
                        return redirect()->to(base_url('products/manufacture/create_raw_materials').'/'.$proid);
                    }
                    
                }
            }else{
                return redirect()->to(base_url('users'));
            }
        }

        public function edit_manufacture($man_id=""){
            $myid=session()->get('id');
            $session=session();
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();
            $ManufacturesModel = new ManufacturesModel();

            if ($session->has('isLoggedIn')){ 
 
                $manufacture_data=$ManufacturesModel->where('id',$man_id)->where('deleted',0)->first();
                 
                if ($manufacture_data) {
                    $proid=$manufacture_data['product_id'];
                    if (!empty($proid)) {

                      
                            

                            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


                            $prodt=$ProductsModel->where('id',$proid)->where('deleted',0)->first();

                            if ($prodt) {
                                $data=[
                                    'title'=>'Manufacture product - Aitsun ERP',
                                    'user'=> $UserModel->where('id', session()->get('id'))->first(),
                                    'pro'=>$prodt,
                                    'view_type'=>'edit',
                                    'man_data'=>$manufacture_data
                                ];

                                 
                                echo view('header',$data);
                                echo view('manufacture/create_manufacture',$data);
                                echo view('footer');  
                            
                        }else{
                            $data=[
                                'title'=>'Manufacture product - Aitsun ERP', 
                            ];
                            echo view('manufacture/error',$data);
                        }

                     
                        
                    }
                }
            
                
            }else{
                return redirect()->to(base_url('users'));
            }
        }
        

         public function get_product_for_item_kit($product_name=""){
                $myid=session()->get('id');
                $ProductsModel=new Main_item_party_table;

         
                    $keywords = explode(' ', $product_name);
                     
                    $whereClause = '';

                    foreach ($keywords as $keyword) { 
                        $whereClause .= "(product_name_with_category LIKE '%$keyword%' OR brand_name LIKE '%$keyword%') AND ";
                    }

                    $whereClause = rtrim($whereClause, ' AND ');

                    $products = $ProductsModel->where($whereClause);

                   
                


                $products=$ProductsModel->where('company_id',company($myid))->where('deleted',0)->where('main_type','product')->where('product_method','product')->findAll();

                echo '<ul class="list-group">';
                    $procount=0;
                    foreach ($products as $pro) { $procount++; ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center cursor-pointer">
                            <div class="col-md-10 col-sm-12"><?= $pro['product_name']; ?></div>  
                            <div class="col-md-2 col-sm-12 text-end">
                                <button type="button" class="btn-dark btn add_to_item_kit btn-sm rounded-pill"
                                    data-product_id="<?= $pro['id']; ?>"
                                    data-product_name="<?= str_replace('"','%22',$pro['product_name']); ?>"
                                    data-price="<?= $pro['price']; ?>"
                                    data-unit="<?= $pro['unit']; ?>"
                                    data-sub_unit="<?= $pro['sub_unit']; ?>"
                                    data-purchased_price="<?= $pro['purchased_price']; ?>"
                                    data-tax="<?= $pro['tax']; ?>"
                                    data-description="<?= str_replace('"','%22',$pro['description']); ?>"
                                    data-proconversion_unit_rate="<?= $pro['conversion_unit_rate']; ?>"
                                    data-in_unit_options="<option value='<?= $pro['unit'] ?>'><?= $pro['unit'] ?></option><?php if (!empty($pro['sub_unit']) && $pro['sub_unit']!='None'): ?><option value='<?= $pro['sub_unit'] ?>'><?= $pro['sub_unit'] ?></option><?php endif ?>"


                                 style="min-width: 85px;">+ Add</button>
                            </div>
                        </li>
                    <?php }
                    if ($procount<1) { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center cursor-pointer">
                            <div class="col-md-12 col-sm-12 text-center text-danger">No items</div> 
                        </li>
                    <?php }
                echo "</ul>";
            }


    public function save_raw_material(){
        $myid=session()->get('id');
        $session=session();
        if ($session->has('isLoggedIn')){ 
        
            
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();  
            $RawmwterialsModel = new RawmwterialsModel();
           
            if ($this->request->getMethod()=='post') {
                $main_pro_id=strip_tags(trim($this->request->getVar('product_id')));
                $tres=1;
                $total_cost=0;
                $ProductsModel->update($main_pro_id,array('is_manufactured'=>0));
                ///////////  DELETE REMOVED RAWMATERIALS   ////////////////
                $deledata=$RawmwterialsModel->where('product_id',$main_pro_id); 
                if (isset($_POST["item_product_name"])) { 
                    foreach ($_POST["item_product_name"] as $i => $value ) {
                         $i_idd=$_POST["item_product_id"][$i];
                         $deledata->where('id!=',$i_idd);
                    }
                    $deleting_prows=$deledata->findAll();
                    foreach ($deleting_prows as $dp) { 
                        $RawmwterialsModel->delete($dp['id']);
                    }
                }else{
                    $deleting_prows=$deledata->findAll();
                    foreach ($deleting_prows as $dp) { 
                        $RawmwterialsModel->delete($dp['id']);
                    }
                }



                /////////////////////Raw materials///////////////////////// 
                if (isset($_POST["item_product_name"])) {
                    foreach ($_POST["item_product_name"] as $i => $value ) {
                        $product_name=$_POST["item_product_name"][$i];
                        $quantity=$_POST["item_quantity"][$i];
                        $price=$_POST["item_price"][$i];
                        $amount=$_POST["item_amount"][$i];
                        $p_discount=0;
                        $product_id=$_POST["item_product_id"][$i];
                        $product_desc=$_POST["item_product_desc"][$i];
                        $selling_price=$_POST["item_selling_price"][$i];
                        $tax=$_POST["item_tax"][$i];
                       
                        $unit=$_POST["unit"][$i];
                        $sub_unit=$_POST["sub_unit"][$i];
                        $conversion_unit_rate=$_POST["conversion_unit_rate"][$i];
                        $in_unit=$_POST["in_unit"][$i];
  

                        $in_item=[
                            'product_id'=>$main_pro_id,
                            'product'=>$product_name,
                            'item_id'=>$product_id,
                            'quantity'=> $quantity,
                            'price'=>$price,
                            'selling_price'=>$selling_price,
                            'discount'=>$p_discount,
                            'amount'=>$amount,
                            'desc'=>$product_desc,
                            'unit'=>$unit,
                            'sub_unit'=>$sub_unit,
                            'conversion_unit_rate'=>$conversion_unit_rate,
                            'in_unit'=>$in_unit,
                            'tax'=>$tax
                        ];
                        $chek_raw_exist=$RawmwterialsModel->where('product_id',$main_pro_id)->where('item_id',$product_id)->first();

                        if ($chek_raw_exist) {
                            if (!$RawmwterialsModel->update($chek_raw_exist['id'],$in_item)) {
                                $tres=0;
                            }
                        }else{
                            if (!$RawmwterialsModel->save($in_item)) {
                                $tres=0;
                            }
                        }
                        $total_cost+=$price;
                        //////Product cost update
                        $ProductsModel->update($main_pro_id,array('purchased_price' => $total_cost,'is_manufactured'=>1));

                    }
                } 
                /////////////////////Raw materials/////////////////////////
                echo $tres;

            }else{
                echo 0;
            }
            
        }else{
            echo 0;
        }
    } 


    public function save_manufacture(){
        $myid=session()->get('id');
        $session=session();
        if ($session->has('isLoggedIn')){ 
        
            $respo_man=0;
            $acti=activated_year(company($myid));

            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();  
            $ManufacturesModel = new ManufacturesModel();
            $InvoiceitemsModel = new InvoiceitemsModel();
            $ManufacturedCosts = new ManufacturedCosts();
            $AccountingModel = new AccountingModel();


            if ($this->request->getMethod()=='post') {


                $p_unit=strip_tags(trim($this->request->getVar('manufactured_unit')));
                $in_unit=strip_tags(trim($this->request->getVar('manufactured_in_unit')));
                $p_conversion_unit_rate=1;
                $quantity=strip_tags(trim($this->request->getVar('manufactured_quantity')));



                $old_manufactured_quantity=0;

                $is_sold_in_primary=true; 

                if ($p_unit!=$in_unit) {

                    $is_sold_in_primary=false;
                    if (strip_tags(trim($this->request->getVar('manufactured_unit_rate')))>0) {
                        $p_conversion_unit_rate=strip_tags(trim($this->request->getVar('manufactured_unit_rate')));
                    }
                   
                }
 
                $old_manufactured_quantity=$quantity;

                if (!$is_sold_in_primary) {
                    if ($p_conversion_unit_rate>0) {
                        $old_manufactured_quantity=1*$quantity/$p_conversion_unit_rate;
                    }else{
                        $old_manufactured_quantity=$quantity;
                    } 
                } 
                
                $manufactured_data=[
                    'company_id'=>company($myid),
                    'product_id'=>strip_tags(trim($this->request->getVar('product_id'))),
                    'manufactured_date'=>strip_tags(trim($this->request->getVar('manufactured_date'))),
                    'manufactured_quantity'=>strip_tags(trim($this->request->getVar('manufactured_quantity'))), 
                    'manufactured_in_unit'=>strip_tags(trim($this->request->getVar('manufactured_in_unit'))), 
                    'manufactured_unit'=>strip_tags(trim($this->request->getVar('manufactured_unit'))), 
                    'manufactured_sub_unit'=>strip_tags(trim($this->request->getVar('manufactured_sub_unit'))), 
                    'manufactured_unit_rate'=>$p_conversion_unit_rate, 
                    'total_cost'=>strip_tags(trim($this->request->getVar('total_cost'))),
                    'total_additional_cost'=>strip_tags(trim($this->request->getVar('total_additioanl_cost'))), 
                    'type'=>'manufactured',
                    'effected'=>0,
                    'edit_effected'=>0,
                    'deleted'=>0, 
                    'additional_cost_payment_type'=>strip_tags(trim($this->request->getVar('payment_type'))),
                    'total_manufactured_cost'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                    'old_manufactured_quantity'=>$old_manufactured_quantity,
                    'old_total_manufactured_cost'=>strip_tags(trim($this->request->getVar('total_manufactured_cost'))),
                    'base_unit_rate'=>strip_tags(trim($this->request->getVar('manufactured_unit_rate'))) 
                ];
                
                if ($ManufacturesModel->save($manufactured_data)) {
                    $manufactured_id=$ManufacturesModel->insertID();
                    $respo_man=1;


                   


                    $man_pro_in_unit=strip_tags(trim($this->request->getVar('manufactured_in_unit')));
                    $man_pro_unit=strip_tags(trim($this->request->getVar('manufactured_unit')));
                    $is_manufactured_in_primary=true;

                    $man_purchased_price=0;

                    if ($man_pro_unit!=$man_pro_in_unit) {
                        $is_manufactured_in_primary=false;
                    } 

                    $man_pu_price=strip_tags(trim($this->request->getVar('total_manufacture_cost')))*$p_conversion_unit_rate;

                    if (!$is_manufactured_in_primary) {
                        if ($p_conversion_unit_rate>0) {
                            $ppppr=strip_tags(trim($this->request->getVar('total_manufacture_cost')))/strip_tags(trim($this->request->getVar('manufactured_unit_rate')));
                            $man_pu_price=($ppppr*$p_conversion_unit_rate)*$p_conversion_unit_rate;
                        }
                    }

                    $man_in_items_data=[
                            'invoice_id'=>$manufactured_id,
                            'product_id'=>strip_tags(trim($this->request->getVar('product_id'))),
                            'product'=>product_name(strip_tags(trim($this->request->getVar('product_id')))),
                            'item_id'=>strip_tags(trim($this->request->getVar('product_id'))),
                            'quantity'=>strip_tags(trim($this->request->getVar('manufactured_quantity'))),
                            'base_quantity'=>strip_tags(trim($this->request->getVar('manufactured_quantity'))),
                            'invoice_type'=>'purchase', 
                            'price'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                            'selling_price'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))), 
                            'amount'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),  
                            'purchased_price'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                            'purchased_amount'=>$man_pu_price, 
                            'unit'=>strip_tags(trim($this->request->getVar('manufactured_unit'))),
                            'sub_unit'=>strip_tags(trim($this->request->getVar('manufactured_sub_unit'))),
                            'conversion_unit_rate'=>$p_conversion_unit_rate,
                            'in_unit'=>strip_tags(trim($this->request->getVar('manufactured_in_unit'))),
                            'old_quantity'=>$old_manufactured_quantity,
                            'old_amount'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                            'product_priority'=>1


                        ];

                       $InvoiceitemsModel->save($man_in_items_data);

                    


                    $man_purchased_price=0;
                    $is_primary=true;

                    if ($man_pro_unit!=$man_pro_in_unit) {
                        $is_primary=false;
                    } 

                    $man_purchased_price=strip_tags(trim($this->request->getVar('total_manufacture_cost')))/strip_tags(trim($this->request->getVar('manufactured_quantity')));

                    if (!$is_primary) {
                        if ($p_conversion_unit_rate>0) {
                            $ppppr=strip_tags(trim($this->request->getVar('total_manufacture_cost')))/strip_tags(trim($this->request->getVar('manufactured_quantity')));
                            $man_purchased_price=$ppppr*$p_conversion_unit_rate;
                        }
                        
                    }

                    $pu_data=[
                        'purchased_price'=>$man_purchased_price
                    ];
                    $ProductsModel->update(strip_tags(trim($this->request->getVar('product_id'))),$pu_data);

                    ////////// stock increase start ////// 

                     add_to_price_queue($manufactured_id,
                        strip_tags(trim($this->request->getVar('product_id'))),
                        (strip_tags(trim($this->request->getVar('manufactured_quantity')))/$p_conversion_unit_rate),
                        strip_tags(trim($this->request->getVar('total_manufacture_cost')))/$p_conversion_unit_rate,
                        strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                        'man');

                        $main_pro_id=strip_tags(trim($this->request->getVar('product_id')));
                        $up_pro_unit=strip_tags(trim($this->request->getVar('manufactured_unit')));
                        $up_pro_in_unit=strip_tags(trim($this->request->getVar('manufactured_in_unit')));
                        $up_pro_conversion_unit_rate=strip_tags(trim($this->request->getVar('manufactured_unit_rate')));
                        $up_pro_quantity=strip_tags(trim($this->request->getVar('manufactured_quantity')));
                        
                        $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first();

                        $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                        $at_price=0;
                        $i_closing_balance=0;
                        $final_closing_value=0;

                        $is_sold_in_primary=true;

                        if ($up_pro_unit!=$up_pro_in_unit) {
                            $is_sold_in_primary=false;
                        } 

                        $at_price=accounting_purchase_price($main_pro_id);
                        if ($is_sold_in_primary) {
                            $i_closing_balance=$i_old_closing_balance+$up_pro_quantity; 
                        }else{
                            if ($up_pro_conversion_unit_rate>0) {
                                        $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                                    }else{
                                        $ans_qty=$up_pro_quantity*1;
                                    }   
                            $i_closing_balance=$i_old_closing_balance+$ans_qty; 
                        }
                        
                        $final_closing_value=$i_closing_balance*$at_price;

                        $ac_data = [   
                            'closing_balance'=>$i_closing_balance,  
                            'closing_value'=>$final_closing_value, 
                        ];
                        $AccountingModel->update($pgeac['id'],$ac_data);



                        

                    ////////// stock increase end //////


                    ///////////////// Raw items isert //////////////
                    foreach ($this->request->getVar('item_product_name') as $i => $value ) {


                            $p_unit=strip_tags(trim($_POST['unit'][$i]));
                            $in_unit=strip_tags(trim($_POST['in_unit'][$i]));  
                            $p_conversion_unit_rate=1;
                            $quantity=strip_tags(trim($_POST['item_quantity'][$i]));



                            $old_item_quantity=0;

                            $is_sold_in_primary=true; 

                            if ($p_unit!=$in_unit) {

                                $is_sold_in_primary=false;
                                if (strip_tags(trim($_POST['conversion_unit_rate'][$i]))>0) {
                                    $p_conversion_unit_rate=strip_tags(trim($_POST['conversion_unit_rate'][$i]));
                                }
                               
                            }
             
                            $old_item_quantity=$quantity;

                            if (!$is_sold_in_primary) {
                                if ($p_conversion_unit_rate>0) {
                                    $old_item_quantity=1*$quantity/$p_conversion_unit_rate;
                                }else{
                                    $old_item_quantity=$quantity;
                                } 
                            } 


                        $manufactured_items_data=[
                            'invoice_id'=>$manufactured_id,
                            'product_id'=>strip_tags(trim($_POST['item_product_id'][$i])),
                            'product'=>strip_tags(trim($_POST['item_product_name'][$i])),
                            'item_id'=>strip_tags(trim($_POST['item_product_id'][$i])),
                            'quantity'=>strip_tags(trim($_POST['item_quantity'][$i])),
                            'base_quantity'=>strip_tags(trim($_POST['base_qty'][$i])),
                            'invoice_type'=>'sales', 
                            'price'=>strip_tags(trim($_POST['item_price'][$i])),
                            'selling_price'=>strip_tags(trim($_POST['item_selling_price'][$i])), 
                            'amount'=>strip_tags(trim($_POST['item_amount'][$i])),   
                            'purchased_price'=>strip_tags(trim($_POST['item_price'][$i])),   
                            'purchased_amount'=>strip_tags(trim($_POST['item_amount'][$i])),   
                            'unit'=>strip_tags(trim($_POST['unit'][$i])),
                            'sub_unit'=>strip_tags(trim($_POST['sub_unit'][$i])),
                            'conversion_unit_rate'=>$p_conversion_unit_rate,
                            'in_unit'=>strip_tags(trim($_POST['in_unit'][$i])),
                            'old_quantity'=>$old_item_quantity,
                            'old_amount'=>strip_tags(trim($_POST['item_amount'][$i])),


                        ];

                        if (!$InvoiceitemsModel->save($manufactured_items_data)) {
                            $respo_man=0;
                        }else{
                            ////////// stock decrease start ////// 
                                $main_pro_id=strip_tags(trim($_POST['item_product_id'][$i]));
                                $up_pro_unit=strip_tags(trim($_POST['unit'][$i]));
                                $up_pro_in_unit=strip_tags(trim($_POST['in_unit'][$i]));
                                $up_pro_conversion_unit_rate=strip_tags(trim($_POST['conversion_unit_rate'][$i]));
                                $up_pro_quantity=strip_tags(trim($_POST['item_quantity'][$i]));
                                
                                $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first();

                                remove_from_price_queue($main_pro_id,($up_pro_quantity/$up_pro_conversion_unit_rate));

                                $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                                $at_price=0;
                                $i_closing_balance=0;
                                $final_closing_value=0;

                                $is_sold_in_primary=true;

                                if ($up_pro_unit!=$up_pro_in_unit) {
                                    $is_sold_in_primary=false;
                                } 

                                $at_price=accounting_purchase_price($main_pro_id);
                                if ($is_sold_in_primary) {
                                    $i_closing_balance=$i_old_closing_balance-$up_pro_quantity; 
                                }else{
                                    if ($up_pro_conversion_unit_rate>0) {
                                                $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                                            }else{
                                                $ans_qty=$up_pro_quantity*1;
                                            }   
                                    $i_closing_balance=$i_old_closing_balance-$ans_qty; 
                                }
                                
                                $final_closing_value=$i_closing_balance*$at_price;

                                $ac_data = [   
                                    'closing_balance'=>$i_closing_balance,  
                                    'closing_value'=>$final_closing_value, 
                                ];
                                $AccountingModel->update($pgeac['id'],$ac_data);
                            ////////// stock decrease end //////
                        }
                        

                    }
                    ///////////////// Raw items isert //////////////



                    ///////////////// Raw costs isert //////////////
                    if ($this->request->getVar('additional_charges')) {
                       foreach ($this->request->getVar('additional_charges') as $j => $value ) {
                            if (trim($_POST['additional_cost'][$j])>0) {
                                $manufactured_costs_data=[
                                    'manufacture_id'=>$manufactured_id,
                                    'product_id'=>strip_tags(trim($this->request->getVar('product_id'))), 
                                    'charges'=>strip_tags(trim($_POST['additional_charges'][$j])),
                                    'details'=>strip_tags(trim($_POST['additional_details'][$j])),
                                    'cost'=>strip_tags(trim($_POST['additional_cost'][$j])),
                                    'deleted'=>0,
                                    'old_cost'=>strip_tags(trim($_POST['additional_cost'][$j])),
                                    
                                    
                                ];

                                if (!$ManufacturedCosts->save($manufactured_costs_data)) {
                                    $respo_man=0;
                                }
                            } 
                        }
                    } 
                    ///////////////// Raw costs isert //////////////



                }

                
            }

        }else{
            $respo_man=0;
        }

        echo $respo_man;

    }





    public function update_manufacture($man_id=""){
        $myid=session()->get('id');
        $session=session();
        if ($session->has('isLoggedIn')){ 
        
            $respo_man=0;
            $acti=activated_year(company($myid));

            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();  
            $ManufacturesModel = new ManufacturesModel();
            $InvoiceitemsModel = new InvoiceitemsModel();
            $ManufacturedCosts = new ManufacturedCosts();
            $AccountingModel = new AccountingModel();

            if ($this->request->getMethod()=='post') {
                // $main_pro_id=strip_tags(trim($this->request->getVar('product_id')));

                    $p_unit=strip_tags(trim($this->request->getVar('old_manufactured_unit')));
                    $in_unit=strip_tags(trim($this->request->getVar('old_manufactured_in_unit')));
                    $p_conversion_unit_rate=1;
                    $quantity=strip_tags(trim($this->request->getVar('old_manufactured_quantity')));



                    $old_manufactured_quantity=0;

                    $is_sold_in_primary=true; 

                    if ($p_unit!=$in_unit) {

                        $is_sold_in_primary=false;
                        if (strip_tags(trim($this->request->getVar('old_manufactured_unit_rate')))>0) {
                            $p_conversion_unit_rate=strip_tags(trim($this->request->getVar('old_manufactured_unit_rate')));
                        }
                       
                    }

                    $old_manufactured_quantity=$quantity;

                    if (!$is_sold_in_primary) {
                        if ($p_conversion_unit_rate>0) {
                            $old_manufactured_quantity=1*$quantity/$p_conversion_unit_rate;
                        }else{
                            $old_manufactured_quantity=$quantity;
                        } 
                    } 

                $manufactured_data=[
                    'company_id'=>company($myid),
                    'product_id'=>strip_tags(trim($this->request->getVar('product_id'))),
                    'manufactured_date'=>strip_tags(trim($this->request->getVar('manufactured_date'))),
                    'manufactured_quantity'=>strip_tags(trim($this->request->getVar('manufactured_quantity'))), 
                    'manufactured_in_unit'=>strip_tags(trim($this->request->getVar('manufactured_in_unit'))), 
                    'manufactured_unit'=>strip_tags(trim($this->request->getVar('manufactured_unit'))), 
                    'manufactured_sub_unit'=>strip_tags(trim($this->request->getVar('manufactured_sub_unit'))), 
                    'manufactured_unit_rate'=>$p_conversion_unit_rate, 
                    'total_cost'=>strip_tags(trim($this->request->getVar('total_cost'))),
                    'total_additional_cost'=>strip_tags(trim($this->request->getVar('total_additioanl_cost'))),
                    'type'=>'manufactured', 
                    'edit_efected'=>0, 
                    'old_total_cost'=>strip_tags(trim($this->request->getVar('old_total_cost'))),
                    'old_total_additional_cost'=>strip_tags(trim($this->request->getVar('old_total_additional_cost'))),
                    'additional_cost_payment_type'=>strip_tags(trim($this->request->getVar('payment_type'))),
                    'total_manufactured_cost'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                    'old_total_manufactured_cost'=>strip_tags(trim($this->request->getVar('old_total_manufactured_cost'))),
                    'old_manufactured_quantity'=>$old_manufactured_quantity

                ];
                
                if ($ManufacturesModel->update($man_id,$manufactured_data)) {
                    $manufactured_id=$man_id;
                    $respo_man=1;

 


                    $checkexist_m=$InvoiceitemsModel->where('invoice_id',$manufactured_id)->where('product_id',strip_tags(trim($this->request->getVar('product_id'))))->where('product_priority',1)->where('deleted',0)->first();
                    if ($checkexist_m) {


                     $man_pro_in_unit=strip_tags(trim($this->request->getVar('manufactured_in_unit')));
                    $man_pro_unit=strip_tags(trim($this->request->getVar('manufactured_unit')));

                    $uunit_rate=1;
 


     

                    $is_manufactured_in_primary=true;

                    if ($man_pro_unit!=$man_pro_in_unit) {
                        $is_manufactured_in_primary=false;
                         if (strip_tags(trim($this->request->getVar('old_manufactured_unit_rate_for_main_pro')))>0) {
                            $uunit_rate=strip_tags(trim($this->request->getVar('old_manufactured_unit_rate_for_main_pro')));
                        }
                    } 

                    $man_pu_price=strip_tags(trim($this->request->getVar('total_manufacture_cost')));

                    if (!$is_manufactured_in_primary) {
                        if ($uunit_rate>0) {

                            $ppppr=strip_tags(trim($this->request->getVar('total_manufacture_cost')))/$uunit_rate;
                            $man_pu_price=($ppppr*$uunit_rate)*$uunit_rate;
                        }
                        
                    }
                     


                        

                        $man_in_items_data=[
                            'invoice_id'=>$manufactured_id,
                            'product_id'=>strip_tags(trim($this->request->getVar('product_id'))),
                            'product'=>product_name(strip_tags(trim($this->request->getVar('product_id')))),
                            'item_id'=>strip_tags(trim($this->request->getVar('product_id'))),
                            'quantity'=>strip_tags(trim($this->request->getVar('manufactured_quantity'))),
                            'base_quantity'=>strip_tags(trim($this->request->getVar('manufactured_quantity'))),
                            'invoice_type'=>'purchase', 
                            'price'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                            'selling_price'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))), 
                            'amount'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),   
                            'unit'=>strip_tags(trim($this->request->getVar('manufactured_unit'))),
                            'sub_unit'=>strip_tags(trim($this->request->getVar('manufactured_sub_unit'))),
                            'conversion_unit_rate'=>$uunit_rate,
                            'in_unit'=>strip_tags(trim($this->request->getVar('manufactured_in_unit'))),
                            'old_quantity'=>$old_manufactured_quantity,
                            'old_amount'=>strip_tags(trim($this->request->getVar('total_manufactured_cost'))),
                            'purchased_price'=>strip_tags(trim($this->request->getVar('total_manufacture_cost'))),
                            'purchased_amount'=>$man_pu_price, 
                            'product_priority'=>1


                        ];

                       $InvoiceitemsModel->update($checkexist_m['id'],$man_in_items_data);

                    }
                    


                    $man_purchased_price=0;
                    $is_primary=true;

                    if ($man_pro_unit!=$man_pro_in_unit) {
                        $is_primary=false;
                    } 

                    $man_purchased_price=strip_tags(trim($this->request->getVar('total_manufacture_cost')))/strip_tags(trim($this->request->getVar('manufactured_quantity')));

                    if (!$is_primary) {
                        if ($uunit_rate>0) {
                            $ppppr=strip_tags(trim($this->request->getVar('total_manufacture_cost')))/strip_tags(trim($this->request->getVar('manufactured_quantity')));
                            $man_purchased_price=$ppppr*$uunit_rate;
                        }
                        
                    }

                    $pu_data=[
                        'purchased_price'=>$man_purchased_price
                    ];
 
                    $ProductsModel->update(strip_tags(trim($this->request->getVar('product_id'))),$pu_data);


                    /////////////// stock increase start/////////////////

                    $main_pro_id=strip_tags(trim($this->request->getVar('product_id')));
                    $up_pro_unit=strip_tags(trim($this->request->getVar('manufactured_unit')));
                    $up_pro_in_unit=strip_tags(trim($this->request->getVar('manufactured_in_unit')));
                    $up_pro_conversion_unit_rate=strip_tags(trim($this->request->getVar('manufactured_unit_rate')));
                    $up_pro_quantity=strip_tags(trim($this->request->getVar('manufactured_quantity')));

                    $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first(); 

                    $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 





                    $at_price=0;
                    $i_closing_balance=0;
                    $old_quantity=$old_manufactured_quantity;
                    $final_closing_value=0;
                    
                    $is_sold_in_primary=true; 

                    if ($up_pro_unit!=$up_pro_in_unit) {
                        $is_sold_in_primary=false;
                    }


                    $at_price=accounting_purchase_price($main_pro_id);

                    if ($is_sold_in_primary) {
                        $i_closing_balance=($i_old_closing_balance-$old_quantity)+$up_pro_quantity;
                    }else{
                        if ($up_pro_conversion_unit_rate>0) {
                        $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                    }else{
                        $ans_qty=$up_pro_quantity*1;
                    }
                        $i_closing_balance=($i_old_closing_balance-$old_quantity)+$ans_qty;
                    }

                    
                    $final_closing_value=$i_closing_balance*$at_price;

                    $ac_data = [   
                        'closing_balance'=>$i_closing_balance,  
                        'closing_value'=>$final_closing_value, 
                    ];
                    $AccountingModel->update($pgeac['id'],$ac_data);
                    /////////////// stock increase end ////////////////
































                    ///////////////// Raw items isert //////////////

                    $deledata=$InvoiceitemsModel->where('invoice_id',$manufactured_id)->where('product_priority!=',1); 
                    foreach ($_POST["item_product_name"] as $i => $value ) {
                        $i_idd=$_POST["i_id"][$i];
                        $deledata->where('id!=',$i_idd);
                    }

                    $deleting_prows=$deledata->findAll();
                    foreach ($deleting_prows as $dp) {
                        $dd=[
                            'deleted'=>1,
                        ];
                        $InvoiceitemsModel->update($dp['id'],$dd);



                        //////////// Increase stock on delete /////////////
                        $main_pro_id=$dp['item_id'];
                        $up_pro_unit=$dp['unit'];
                        $up_pro_in_unit=$dp['in_unit'];
                        $up_pro_conversion_unit_rate=$dp['conversion_unit_rate'];
                        $up_pro_quantity=$dp['quantity'];
     
                        $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first(); 

                        $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                        $at_price=0;
                        $i_closing_balance=0;
                        $old_quantity=$dp['old_quantity'];
                        $final_closing_value=0;
                        
                        $is_sold_in_primary=true; 

                        if ($up_pro_unit!=$up_pro_in_unit) {
                            $is_sold_in_primary=false;
                        }

                        $at_price=accounting_purchase_price($main_pro_id);

                        if ($is_sold_in_primary) {
                            $i_closing_balance=($i_old_closing_balance-$old_quantity)-$up_pro_quantity;
                        }else{
                            if ($up_pro_conversion_unit_rate>0) {
                            $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                        }else{
                            $ans_qty=$up_pro_quantity*1;
                        }
                            $i_closing_balance=($i_old_closing_balance-$old_quantity)-$ans_qty;
                        }


                        $final_closing_value=$i_closing_balance*$at_price;

                        $ac_data = [   
                            'closing_balance'=>$i_closing_balance,  
                            'closing_value'=>$final_closing_value, 
                        ];
                        $AccountingModel->update($pgeac['id'],$ac_data);
                        //////////// Increase stock on delete /////////////

                    }

                    foreach ($this->request->getVar('item_product_name') as $i => $value ) {
                        $i_id=$_POST["i_id"][$i];

                        $checkexist=$InvoiceitemsModel->where('id',$i_id)->where('invoice_id',$manufactured_id)->where('deleted',0)->first();
                        if ($checkexist) {



                
                            $p_unit=strip_tags(trim($_POST['old_unit'][$i]));
                            $in_unit=strip_tags(trim($_POST['old_in_unit'][$i]));  
                            $p_conversion_unit_rate=1;
                            $quantity=strip_tags(trim($_POST['old_item_quantity'][$i]));



                            $old_item_quantity=0;

                            $is_sold_in_primary=true; 

                            if ($p_unit!=$in_unit) {

                                $is_sold_in_primary=false;
                                if (strip_tags(trim($_POST['old_conversion_unit_rate'][$i]))>0) {
                                    $p_conversion_unit_rate=strip_tags(trim($_POST['old_conversion_unit_rate'][$i]));
                                }
                               
                            }
             
                            $old_item_quantity=$quantity;

                            if (!$is_sold_in_primary) {
                                if ($p_conversion_unit_rate>0) {
                                    $old_item_quantity=1*$quantity/$p_conversion_unit_rate;
                                }else{
                                    $old_item_quantity=$quantity;
                                } 
                            } 


                            $manufactured_items_data=[
                                'invoice_id'=>$manufactured_id,
                                'product_id'=>strip_tags(trim($_POST['item_product_id'][$i])),
                                'product'=>strip_tags(trim($_POST['item_product_name'][$i])),
                                'item_id'=>strip_tags(trim($_POST['item_product_id'][$i])),
                                'quantity'=>strip_tags(trim($_POST['item_quantity'][$i])),
                                'base_quantity'=>strip_tags(trim($_POST['base_qty'][$i])),
                                'invoice_type'=>'sales', 
                                'price'=>strip_tags(trim($_POST['item_price'][$i])),
                                'selling_price'=>strip_tags(trim($_POST['item_selling_price'][$i])), 
                                'amount'=>strip_tags(trim($_POST['item_amount'][$i])),
                                'purchased_price'=>strip_tags(trim($_POST['item_price'][$i])),   
                                'purchased_amount'=>strip_tags(trim($_POST['item_amount'][$i])),    
                                'unit'=>strip_tags(trim($_POST['unit'][$i])),
                                'sub_unit'=>strip_tags(trim($_POST['sub_unit'][$i])),
                                'conversion_unit_rate'=>$p_conversion_unit_rate,
                                'in_unit'=>strip_tags(trim($_POST['in_unit'][$i])),
                                'old_quantity'=>$old_item_quantity,
                                'old_amount'=>strip_tags(trim($_POST['item_amount'][$i]))
                            ];

                            if (!$InvoiceitemsModel->update($i_id,$manufactured_items_data)) {
                                $respo_man=0;
                            }else{
                                /////////////// stock increase start/////////////////
                                $main_pro_id=strip_tags(trim($_POST['item_product_id'][$i]));
                                $up_pro_unit=strip_tags(trim($_POST['unit'][$i]));
                                $up_pro_in_unit=strip_tags(trim($_POST['in_unit'][$i]));
                                $up_pro_conversion_unit_rate=strip_tags(trim($_POST['conversion_unit_rate'][$i]));
                                $up_pro_quantity=strip_tags(trim($_POST['item_quantity'][$i]));

                                $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first(); 

                                $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                                $new_old_item_quantity=$old_item_quantity;

                                $at_price=0;
                                $i_closing_balance=0;
                                $old_quantity=$new_old_item_quantity;
                                $final_closing_value=0;
                                
                                $is_sold_in_primary=true; 

                                if ($up_pro_unit!=$up_pro_in_unit) {
                                    $is_sold_in_primary=false;
                                }


                                $at_price=accounting_purchase_price($main_pro_id);

                                if ($is_sold_in_primary) {
                                    $i_closing_balance=($i_old_closing_balance+$old_quantity)-$up_pro_quantity;
                                }else{
                                    if ($up_pro_conversion_unit_rate>0) {
                                        $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                                    }else{
                                        $ans_qty=$up_pro_quantity*1;
                                    }
                                    $i_closing_balance=($i_old_closing_balance+$old_quantity)-$ans_qty;
                                }

                                
                                $final_closing_value=$i_closing_balance*$at_price;

                                $ac_data = [   
                                    'closing_balance'=>$i_closing_balance,  
                                    'closing_value'=>$final_closing_value, 
                                ];
                                $AccountingModel->update($pgeac['id'],$ac_data);
                                /////////////// stock increase end ////////////////
                            }


                        }else{

                             $p_unit=strip_tags(trim($_POST['unit'][$i]));
                            $in_unit=strip_tags(trim($_POST['in_unit'][$i]));  
                            $p_conversion_unit_rate=1;
                            $quantity=strip_tags(trim($_POST['item_quantity'][$i]));



                            $old_item_quantity=0;

                            $is_sold_in_primary=true; 

                            if ($p_unit!=$in_unit) {

                                $is_sold_in_primary=false;
                                if (strip_tags(trim($_POST['conversion_unit_rate'][$i]))>0) {
                                    $p_conversion_unit_rate=strip_tags(trim($_POST['conversion_unit_rate'][$i]));
                                }
                               
                            }
             
                            $old_item_quantity=$quantity;

                            if (!$is_sold_in_primary) {
                                if ($p_conversion_unit_rate>0) {
                                    $old_item_quantity=1*$quantity/$p_conversion_unit_rate;
                                }else{
                                    $old_item_quantity=$quantity;
                                } 
                            } 

                            $manufactured_items_data=[
                                'invoice_id'=>$manufactured_id,
                                'product_id'=>strip_tags(trim($_POST['item_product_id'][$i])),
                                'product'=>strip_tags(trim($_POST['item_product_name'][$i])),
                                'item_id'=>strip_tags(trim($_POST['item_product_id'][$i])),
                                'quantity'=>strip_tags(trim($_POST['item_quantity'][$i])),
                                'base_quantity'=>strip_tags(trim($_POST['base_qty'][$i])),
                                'invoice_type'=>'sales', 
                                'price'=>strip_tags(trim($_POST['item_price'][$i])),
                                'selling_price'=>strip_tags(trim($_POST['item_selling_price'][$i])), 
                                'amount'=>strip_tags(trim($_POST['item_amount'][$i])),   
                                'purchased_price'=>strip_tags(trim($_POST['item_price'][$i])),   
                            'purchased_amount'=>strip_tags(trim($_POST['item_amount'][$i])), 
                                'unit'=>strip_tags(trim($_POST['unit'][$i])),
                                'sub_unit'=>strip_tags(trim($_POST['sub_unit'][$i])),
                                'conversion_unit_rate'=>$p_conversion_unit_rate,
                                'in_unit'=>strip_tags(trim($_POST['in_unit'][$i])),
                                 'old_quantity'=>$old_item_quantity,
                                 'old_amount'=>strip_tags(trim($_POST['item_amount'][$i])),
                            ];

                            if (!$InvoiceitemsModel->save($manufactured_items_data)) {
                                $respo_man=0;
                            }else{
                                ////////// stock increase start ////// 
                                    $main_pro_id=strip_tags(trim($_POST['item_product_id'][$i]));
                                    $up_pro_unit=strip_tags(trim($_POST['unit'][$i]));
                                    $up_pro_in_unit=strip_tags(trim($_POST['in_unit'][$i]));
                                    $up_pro_conversion_unit_rate=strip_tags(trim($_POST['conversion_unit_rate'][$i]));
                                    $up_pro_quantity=strip_tags(trim($_POST['item_quantity'][$i]));
                                    
                                    $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first();

                                    $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                                    $at_price=0;
                                    $i_closing_balance=0;
                                    $final_closing_value=0;

                                    $is_sold_in_primary=true;

                                    if ($up_pro_unit!=$up_pro_in_unit) {
                                        $is_sold_in_primary=false;
                                    } 

                                    $at_price=accounting_purchase_price($main_pro_id);
                                    if ($is_sold_in_primary) {
                                        $i_closing_balance=$i_old_closing_balance-$up_pro_quantity; 
                                    }else{
                                        if ($up_pro_conversion_unit_rate>0) {
                                                    $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                                                }else{
                                                    $ans_qty=$up_pro_quantity*1;
                                                }   
                                        $i_closing_balance=$i_old_closing_balance-$ans_qty; 
                                    }
                                    
                                    $final_closing_value=$i_closing_balance*$at_price;

                                    $ac_data = [   
                                        'closing_balance'=>$i_closing_balance,  
                                        'closing_value'=>$final_closing_value, 
                                    ];
                                    $AccountingModel->update($pgeac['id'],$ac_data);
                                ////////// stock increase end //////
                            }
                        }
                         
                        

                    }
                    ///////////////// Raw items isert //////////////



                    ///////////////// Raw costs isert //////////////
                    $co_deledata=$ManufacturedCosts->where('manufacture_id',$manufactured_id); 

                    if ($this->request->getVar('additional_charges')) {
                        foreach ($_POST["additional_charges"] as $i => $value ) {
                            $co_i_idd=$_POST["co_i_id"][$i];
                            $co_deledata->where('id!=',$co_i_idd);
                        }
                    }
                    

                    $co_deleting_prows=$co_deledata->findAll();
                    foreach ($co_deleting_prows as $co_dp) {
                        $co_dd=[
                            'deleted'=>1,
                        ];
                        $ManufacturedCosts->update($co_dp['id'],$co_dd);
                    }

                    if ($this->request->getVar('additional_charges')) {
                       foreach ($this->request->getVar('additional_charges') as $j => $value ) {
                            if (trim($_POST['additional_cost'][$j])>0) {

                                $co_i_idd=$_POST["co_i_id"][$j];

                                $co_checkexist=$ManufacturedCosts->where('id',$co_i_idd)->where('manufacture_id',$manufactured_id)->where('deleted',0)->first();
                                if ($co_checkexist) {
                                    $manufactured_costs_data=[
                                        'manufacture_id'=>$manufactured_id,
                                        'product_id'=>strip_tags(trim($this->request->getVar('product_id'))), 
                                        'charges'=>strip_tags(trim($_POST['additional_charges'][$j])),
                                        'details'=>strip_tags(trim($_POST['additional_details'][$j])),
                                        'cost'=>strip_tags(trim($_POST['additional_cost'][$j])),
                                        'deleted'=>0,
                                        'old_cost'=>strip_tags(trim($_POST['old_additional_cost'][$j])), 
                                        
                                    ];

                                    if (!$ManufacturedCosts->update($co_i_idd,$manufactured_costs_data)) {
                                        $respo_man=0;
                                    }
                                }else{
                                    $manufactured_costs_data=[
                                        'manufacture_id'=>$manufactured_id,
                                        'product_id'=>strip_tags(trim($this->request->getVar('product_id'))), 
                                        'charges'=>strip_tags(trim($_POST['additional_charges'][$j])),
                                        'details'=>strip_tags(trim($_POST['additional_details'][$j])),
                                        'cost'=>strip_tags(trim($_POST['additional_cost'][$j])),
                                        'deleted'=>0,
                                        'old_cost'=>strip_tags(trim($_POST['additional_cost'][$j])), 
                                    ];

                                    if (!$ManufacturedCosts->save($manufactured_costs_data)) {
                                        $respo_man=0;
                                    }

                                }
                                
                            } 
                        }
                    } 
                    ///////////////// Raw costs isert //////////////



                }

                
            }

        }else{
            $respo_man=0;
        }

        echo $respo_man;

    }

 
    public function delete($inid=""){

        $session=session();
        $UserModel=new Main_item_party_table;
        $ManufacturesModel=new ManufacturesModel;
        $InvoiceitemsModel=new InvoiceitemsModel;
        $ManufacturedCosts=new ManufacturedCosts;
        $AccountingModel=new AccountingModel;

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if ($session->has('isLoggedIn')){
  

            $in_type=$ManufacturesModel->where('id',$inid)->first();
            $deledata=[
                'deleted'=>1,
                'edit_effected'=>0
            ];
            $del=$ManufacturesModel->update($inid,$deledata);
            
            if ($del) {


                $checkexist_m=$InvoiceitemsModel->where('invoice_id',$inid)->where('product_id',$in_type['product_id'])->where('product_priority',1)->where('deleted',0)->first();
                    if ($checkexist_m) {
                        $man_in_items_data=[
                            'deleted'=>1

                        ];
                       $InvoiceitemsModel->update($checkexist_m['id'],$man_in_items_data);
                    }



                //////////// Decrease stock on delete /////////////
                    $main_pro_id=$in_type['product_id'];
                    $up_pro_unit=$in_type['manufactured_unit'];
                    $up_pro_in_unit=$in_type['manufactured_in_unit'];
                    $up_pro_conversion_unit_rate=$in_type['base_unit_rate'];
                    $up_pro_manufactured_unit_rate=$in_type['manufactured_unit_rate'];
                    $up_pro_quantity=$in_type['manufactured_quantity'];


                    remove_from_price_queue($main_pro_id,($up_pro_quantity/$up_pro_manufactured_unit_rate));

 
                    $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first(); 

                    $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                    $at_price=0;
                    $i_closing_balance=0;
                    $old_quantity=$in_type['manufactured_quantity'];
                    $final_closing_value=0;
                    
                    $is_sold_in_primary=true; 

                    if ($up_pro_unit!=$up_pro_in_unit) {
                        $is_sold_in_primary=false;
                    }

                    $at_price=accounting_purchase_price($main_pro_id);

                    if ($is_sold_in_primary) {
                        $i_closing_balance=($i_old_closing_balance)-$up_pro_quantity;
                    }else{
                        if ($up_pro_conversion_unit_rate>0) {
                        $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                        }else{
                            $ans_qty=$up_pro_quantity*1;
                        }
                        $i_closing_balance=($i_old_closing_balance)-$ans_qty;
                    }


                    $final_closing_value=$i_closing_balance*$at_price;

                    $ac_data = [   
                        'closing_balance'=>$i_closing_balance,  
                        'closing_value'=>$final_closing_value, 
                    ];
                    $AccountingModel->update($pgeac['id'],$ac_data);
                //////////// Decrease stock on delete /////////////



                $invoice_items_data=$InvoiceitemsModel->where('invoice_id',$inid)->where('product_priority!=',1)->findAll();
                foreach ($invoice_items_data as $intm) {
                    
                    $deleinitem=[
                        'deleted'=>1,
                    ];
                    $InvoiceitemsModel->update($intm['id'],$deleinitem);



                    //////////// Increase stock on delete /////////////
                    $main_pro_id=$intm['item_id'];
                    $up_pro_unit=$intm['unit'];
                    $up_pro_in_unit=$intm['in_unit'];
                    $up_pro_conversion_unit_rate=$intm['conversion_unit_rate'];
                    $up_pro_quantity=$intm['quantity'];

                    add_to_price_queue($inid,$main_pro_id,($up_pro_quantity/$up_pro_conversion_unit_rate),$intm['price'],$intm['amount'],'man');
 
                    $pgeac=$AccountingModel->where('customer_id',$main_pro_id)->where('type','stock')->first(); 

                    $i_old_closing_balance=balance(company($myid),ledger_id_of_product(company($myid),$main_pro_id),'closing_balance','stock'); 

                    $at_price=0;
                    $i_closing_balance=0;
                    $old_quantity=$intm['quantity'];
                    $final_closing_value=0;
                    
                    $is_sold_in_primary=true; 

                    if ($up_pro_unit!=$up_pro_in_unit) {
                        $is_sold_in_primary=false;
                    }

                    $at_price=accounting_purchase_price($main_pro_id);

                    if ($is_sold_in_primary) {
                        $i_closing_balance=($i_old_closing_balance)+$up_pro_quantity;
                    }else{
                        if ($up_pro_conversion_unit_rate>0) {
                            $ans_qty=$up_pro_quantity*1/$up_pro_conversion_unit_rate;
                        }else{
                            $ans_qty=$up_pro_quantity*1;
                        }
                        $i_closing_balance=($i_old_closing_balance)+$ans_qty;
                    }


                    $final_closing_value=$i_closing_balance*$at_price;

                    $ac_data = [   
                        'closing_balance'=>$i_closing_balance,  
                        'closing_value'=>$final_closing_value, 
                    ];
                    $AccountingModel->update($pgeac['id'],$ac_data);
                    //////////// Increase stock on delete /////////////



                    
                }

                $man_cost_invoice_items_data=$ManufacturedCosts->where('manufacture_id',$inid)->findAll();
                foreach ($man_cost_invoice_items_data as $intmcost) {
                    
                    $man_cost_deleinitem=[
                        'deleted'=>1,
                    ];
                    $ManufacturedCosts->update($intmcost['id'],$man_cost_deleinitem);
                }


                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('products/manufacture'));
             

            }else{ 

            }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


}