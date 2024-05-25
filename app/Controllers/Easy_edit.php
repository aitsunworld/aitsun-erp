<?php
    namespace App\Controllers;

    use App\Models\Main_item_party_table;
    use App\Models\ProductsModel;



    class Easy_edit extends BaseController
    {
        public function index()
        {
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();
            $session=session();
            
            if ($session->has('isLoggedIn')){ 

            $myid=session()->get('id');
            $acti=activated_year(company($myid));

            $pager = \Config\Services::pager();
            
            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $results_per_page = 10; 

            if ($_GET) {
                if (isset($_GET['product_name'])) {
                    $keywords = explode(' ', $_GET['product_name']);
                     

                    // Start building the WHERE clause
                    $whereClause = '';

                    foreach ($keywords as $keyword) { 
                        $whereClause .= "(product_name_with_category LIKE '%$keyword%' OR brand_name LIKE '%$keyword%') AND ";
                    }

                    // Remove the trailing 'AND'
                    $whereClause = rtrim($whereClause, ' AND ');

                    // Perform the search
                     $ProductsModel->where($whereClause);

                   
                }


                    
                 
            } 
            // PRODUCTS FETCHING AND PAGINATION END


        $get_pro = $ProductsModel->where('company_id',company($myid))->where('product_type!=','fees')->where('deleted',0)->where('main_type','product')->orderBy("id", "desc")->paginate(20);

         
            

                $data=[
                    'title'=>'Products - Aitsun ERP',
                    'user'=> $UserModel->where('id', session()->get('id'))->first(),
                    // 'page'=>$page,
                    'product_data'=> $get_pro,
                    // 'number_of_page'=>$number_of_page,
                    'pager' => $ProductsModel->pager,
                ];

                echo view('header',$data);
                echo view('products/easy_edit',$data);
                echo view('footer');
            }else{
                return redirect()->to(base_url('users'));
            }
            
        }


        public function update_product($proid=""){
            $session=session();
            $user=new Main_item_party_table();
            $ProductsModel=new Main_item_party_table();
            $myid=session()->get('id');
            if ($this->request->getMethod() == 'post') {

                $pele=strip_tags(trim($this->request->getVar('p_element')));

                $pro_data=$ProductsModel->where('id',$proid)->first();

                if ($this->request->getVar('p_element')=='at_price') {
                    $input_at_price=strip_tags(trim($this->request->getvar('p_element_val'))); 
                }else{
                    $input_at_price=$pro_data['at_price']; 
                }

                if ($this->request->getVar('p_element')=='opening_balance') {
                    $opstock=strip_tags(trim($this->request->getvar('p_element_val'))); 
                }else{
                    $opstock=$pro_data['opening_balance']; 
                }


                $at_price=aitsun_round($input_at_price,get_setting(company($myid),'round_of_value'));

                $current=strip_tags(trim($pro_data['opening_balance']));
                $current_at_price=get_products_data($proid,'at_price');
                
                $current_fullstock=strip_tags(trim($pro_data['closing_balance']));
                $minnn=$current_fullstock-$current;
                $fullstock=$minnn+$opstock;

                $old_clsing_value=$current*$current_at_price;
                $current_closing_value=get_products_data($proid,'final_closing_value');
                $current_closing_value_fifo=get_products_data($proid,'final_closing_value_fifo');
                $new_closing_value=$opstock*aitsun_round($input_at_price,get_setting(company($myid),'round_of_value'));
                $final_closing_value=($current_closing_value-$old_clsing_value)+$new_closing_value;


                $final_closing_value_fifo=($current_closing_value_fifo-$old_clsing_value)+$new_closing_value;


                if ($this->request->getVar('p_element')=='product_name') {
                    $ac_data = [
                        $pele=>strip_tags(trim($this->request->getVar('p_element_val'))),
                        'slug'=> preg_replace('/[^A-Za-z0-9\-]/', '-', htmlentities(strip_tags(trim($this->request->getVar('p_element_val'))))),
                        'edit_effected'=>0, 
                        'closing_balance'=>$fullstock,
                        'final_closing_value'=>$final_closing_value,
                        'final_closing_value_fifo'=>$final_closing_value_fifo,
                    ];
                }else{
                    $ac_data = [
                        $pele=>strip_tags(trim($this->request->getVar('p_element_val'))),
                        'edit_effected'=>0, 
                        'opening_balance'=>$opstock,
                        'closing_balance'=>$fullstock,
                        'final_closing_value'=>$final_closing_value,
                        'final_closing_value_fifo'=>$final_closing_value_fifo,
                    ];
                }
                
                
               
                    $save_pro_data=$ProductsModel->update($proid,$ac_data);
                
                    
                
               
                if ($save_pro_data) {
                    echo 1;
                }else{
                    echo 0;
                }
               
            }
        }


        public function barcode_customization()
        {
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();
            $session=session();
            
            if ($session->has('isLoggedIn')){ 

            $myid=session()->get('id');
            $acti=activated_year(company($myid));

            $pager = \Config\Services::pager();
            
            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $results_per_page = 10; 

            if ($_GET) {
                if (isset($_GET['product_name'])) {
                    $keywords = explode(' ', $_GET['product_name']);
                     

                    // Start building the WHERE clause
                    $whereClause = '';

                    foreach ($keywords as $keyword) { 
                        $whereClause .= "(product_name_with_category LIKE '%$keyword%' OR brand_name LIKE '%$keyword%') AND ";
                    }

                    // Remove the trailing 'AND'
                    $whereClause = rtrim($whereClause, ' AND ');

                    // Perform the search
                    $products = $ProductsModel->where($whereClause);

                   
                }
    
                 
            } 
            // PRODUCTS FETCHING AND PAGINATION END


        $get_pro = $ProductsModel->where('company_id',company($myid))->where('main_type','product')->where('product_type!=','fees')->where('deleted',0)->orderBy("id", "desc")->paginate(20);


            

                $data=[
                    'title'=>'Products - Aitsun ERP',
                    'user'=> $UserModel->where('id', session()->get('id'))->first(),
                    'product_data'=> $get_pro,
                    'pager' => $ProductsModel->pager,
                ];

                echo view('header',$data);
                echo view('products/barcode_customization',$data);
                echo view('footer');
            }else{
                return redirect()->to(base_url('users'));
            }
            
        }



    public function generate_ap_code(){

        $ProductsModel = new Main_item_party_table();
        $myid=session()->get('id');

        

        $product_data=$ProductsModel->where('company_id',company($myid))->where('main_type','product')->where('product_type!=','fees')->orderBy("id", "ASC")->findAll();

        $pro_ap_code=0;
        foreach ($product_data as $pd) {
            $pro_ap_code++;
            $data_roo=[
                'pro_ap_code'=>$pro_ap_code
            ];
            $ProductsModel->update($pd['id'],$data_roo);
        }
        
    }

    public function generate_dpc_code(){

        $ProductsModel = new Main_item_party_table();
        $myid=session()->get('id');

        

        $product_data=$ProductsModel->where('company_id',company($myid))->where('main_type','product')->where('product_type!=','fees')->where('deleted',0)->orderBy("id", "ASC")->findAll();

        foreach ($product_data as $pd) {
            $data_roo=[
                'department_cat_code'=>get_product_category($pd['category'],'cat_department')
            ];
            $ProductsModel->update($pd['id'],$data_roo);
        }
        
    }


    public function generate_pro_barcode($proid=""){
            $session=session();
            $user=new Main_item_party_table();
            $ProductsModel=new Main_item_party_table();
            $myid=session()->get('id');

            if ($this->request->getMethod() == 'post') {


                $ffffrom=$this->request->getVar('from');
                if ($ffffrom=='all') {
                    $multyiple = $ProductsModel->where('company_id',company($myid))->where('main_type','product')->where('deleted',0)->findAll();
                }else{
                    $multyiple = explode(',', $proid);
                }
                 
                

                 foreach ($multyiple as $pid) {

                    if ($ffffrom=='all') {
                        $prodata=$pid;
                    }else{
                        $prodata=$ProductsModel->where('id',$pid)->first();
                    }
                

                if ($prodata) {


                    $brc=barcode_array();
                    $aaa=array_search($this->request->getVar('barcode_type'), array_column($brc, 'Barcode Type')); 
                    $barcode_value='0';  
                    
                    $Department='';
                    $Code='';
                    $LFCode='';
                    $Price='';
                    $Unit_Price='';
                    $Weight='';
                    $Batch_No='';
                    $DisCount='';
                    $checkSum='';
                    $length=13;

                    if (trim($brc[$aaa]['length'])!='') {
                        if (trim($brc[$aaa]['length'])>0) {
                            $length=$length;
                        }
                    }

                    if (trim($brc[$aaa]['Department'])!='') {
                        if (trim($brc[$aaa]['Department'])>0) {
                            $Department=str_pad($prodata['department_cat_code'], trim($brc[$aaa]['Department']), '0', STR_PAD_LEFT);
                        }
                    }


                    if (trim($brc[$aaa]['Code'])!='') {
                        if (is_numeric(trim($brc[$aaa]['Code']))) {
                            if (trim($brc[$aaa]['Code'])>0) {
                                $Code=str_pad($prodata['pro_ap_code'], trim($brc[$aaa]['Code']), '0', STR_PAD_LEFT);
                            } 
                        }
                    }

                    if (trim($brc[$aaa]['LFCode'])!='') {
                        if (trim($brc[$aaa]['LFCode'])>0) {
                            $LFCode=str_pad($prodata['pro_ap_code'], trim($brc[$aaa]['LFCode']), '0', STR_PAD_LEFT);
                        }
                    }

                    if (trim($brc[$aaa]['Price'])!='') {
                        if (trim($brc[$aaa]['Price'])>0) {
                            $Price=str_pad(0, trim($brc[$aaa]['Price']), '0', STR_PAD_LEFT);
                        }
                    }

                    if (trim($brc[$aaa]['Unit Price'])!='') {
                        if (trim($brc[$aaa]['Unit Price'])>0) {
                            $Unit_Price=str_pad($prodata['price'], trim($brc[$aaa]['Unit Price']), '0', STR_PAD_LEFT);
                        }
                    }

                    if (trim($brc[$aaa]['Weight'])!='') {
                        if (trim($brc[$aaa]['Weight'])>0) {
                            $Weight=str_pad(0, trim($brc[$aaa]['Weight']), '0', STR_PAD_LEFT);
                        }
                    }

                    if (trim($brc[$aaa]['Batch No'])!='') {
                        if (trim($brc[$aaa]['Batch No'])>0) {
                            $Batch_No=str_pad($prodata['batch_no'], trim($brc[$aaa]['Batch No']), '0', STR_PAD_LEFT);
                        }
                    }

                    if (trim($brc[$aaa]['DisCount'])!='') {
                        if (trim($brc[$aaa]['DisCount'])>0) {
                            $DisCount=str_pad(0, trim($brc[$aaa]['DisCount']), '0', STR_PAD_LEFT);
                        }
                    }

                    if (trim($brc[$aaa]['checkSum'])!='') {
                        if (trim($brc[$aaa]['checkSum'])>0) {
                            $checkSum=str_pad(0, trim($brc[$aaa]['checkSum']), '0', STR_PAD_LEFT);
                        }
                    }

                    

                    


                    

                    // str_pad($prodata['pro_ap_code'], $Code, '0', STR_PAD_LEFT)

                    $barcode_value=$Department.$Code.$LFCode.$Price.$Unit_Price.$Batch_No.$DisCount.$checkSum.$Weight;
                    
                    $frombar=$this->request->getVar('from');

                    $is_custom=1;
                       if ($frombar=='all') {
                        $proii=$prodata['id'];
                    }else{
                        $proii=$pid;
                    }


                    if ($frombar!='single') {
                        $pddd=$ProductsModel->where('id',$proii)->first();
                        if ($pddd['custom_barcode']==1) {
                            $is_custom=1;
                            $barcode_value=$pddd['barcode'];
                        }else{
                            $is_custom=0;
                        }
                    }else{
                        $is_custom=0;
                    }

                    $ac_data = [
                        'barcode'=>$barcode_value,
                        'barcode_type'=>$this->request->getVar('barcode_type'),
                        'custom_barcode'=>$is_custom
                    ];
                    
                 
                    $pro_data=$ProductsModel->update($proii,$ac_data);
                   
                    if ($pro_data) {
                        echo 1;
                    }else{
                        echo 0;
                    }







                }else{
                    echo 0;
                }
               
            }
            }else{
                echo 0;
            }
        }
    }