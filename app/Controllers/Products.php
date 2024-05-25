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
use App\Models\ItemkitsModel;
use App\Models\Companies;
use App\Models\QuoteItemsModel;
use App\Models\FieldsNameModel; 
use App\Models\ProductSubUnit;
use App\Models\CompanySettings; 
use App\Models\AccountingModel;
use App\Models\InvoiceitemsModel;

 


class Products extends BaseController
{
    public function index()
    {
        $UserModel = new Main_item_party_table();
        $ProductsModel = new Main_item_party_table(); 

        

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


                if (isset($_GET['bin_location'])) {
                    $ProductsModel->like('bin_location', $_GET['bin_location'], 'both'); 
                }

                if (isset($_GET['unit'])) {
                    $ProductsModel->like('unit', $_GET['unit'], 'both'); 
                }

                if (isset($_GET['stock'])) {
                    if (!empty($_GET['stock'])) {
                        if ($_GET['stock']=='out_of_stock') {
                            $ProductsModel->where('stock<=', 0);
                        }elseif ($_GET['stock']=='in_stock') {
                            $ProductsModel->where('stock>', 0);
                        }
                    }       
                }


                if (isset($_GET['view_as'])) {
                    if (!empty($_GET['view_as'])) {
                        if (trim($_GET['view_as'])=='food') {
                            $ProductsModel->where('view_as','food');
                        }else{
                           $ProductsModel->where('view_as','retail');
                       }
                       
                   }       
               }

               if (isset($_GET['parent_category'])) {
                if (!empty($_GET['parent_category'])) {
                    $ProductsModel->where('category',$_GET['parent_category']);
                }       
            }

            // if (isset($_GET['product_item'])) {
            //     if (!empty($_GET['product_item'])) {
            //         if ($_GET['product_item']=='offline') {
            //             $ProductsModel->where('online',0);
            //         }else{
            //             $ProductsModel->where($_GET['product_item'],1);
            //         }
                    
            //     }       
            // } 
        }
        
        if (!empty(get_setting(company($myid),'results_per_page'))) {
            $results_per_page = get_setting(company($myid),'results_per_page'); 
        }else{
            $results_per_page = 10; 
        }
        
        $get_pro = $ProductsModel->where('company_id',company($myid))->where('product_type!=','fees')->orderBy("id", "desc")->where('deleted',0)->where('main_type','product')->paginate($results_per_page); 
        
            // PRODUCTS FETCHING AND PAGINATION END
        
        $get_branches=$Companies->where('parent_company', main_company_id($myid))->findAll();

        $data=[
            'title'=>'Products - Aitsun ERP',
            'user'=> $UserModel->where('id', session()->get('id'))->first(),
            'product_data'=> $get_pro,
                // 'page'=>$page,
            'branches'=>$get_branches,
                // 'number_of_page'=>$number_of_page,
            'pager' => $ProductsModel->pager,
        ];



        if (isset($_POST['get_excel'])) {
            

            $fileName = "PRODUCT". ".xls"; 
            
                    // Column names 
            $fields = array('#PRODUCT', 'DESC', 'PRODUCT METHOD', 'PRODUCT CODE', 'PRODUCT TYPE', 'PRICE', 'SELLING PRICE', 'UNIT', 'BRAND', 'CATEGORY', 'SUB CATEGORY', 'SECONDARY CATEGORY', 'BARCODE', 'EXPIRY DATE', 'BATCH NO', 'PRODUCT IDENTIFIERS', 'TAX', 'BIN LOCATION'); 

            
            
                     // print_r($fields);

                    // Display column names as first row 
            $excelData = implode("\t", array_values($fields)) . "\n"; 
            
                    // Fetch records from database 
            $query = $get_pro; 
            if(count($query) > 0){ 
                        // Output each row of the data 
                foreach ($query as $row) {

                    $pro_brand= name_of_brand($row['brand']);

                    $pro_unit=name_of_unit($row['unit']);

                    $pro_cat=name_of_category($row['category']);
                    $pro_sub_cat=name_of_sub_category($row['sub_category']);
                    $pro_sec_sub_cat=name_of_sec_category($row['sec_category']);

                    $tax= tax_name($row['tax']).'-'. percent_of_tax($row['tax']).'%';

                    
                    $colllumns=array($row['product_name'], $row['description'], $row['product_method'], $row['product_code'], $row['product_type'],$row['discounted_price'],$row['price'],$pro_unit,$pro_brand,$pro_cat,$pro_sub_cat,$pro_sec_sub_cat,$row['barcode'],$row['expiry_date'],$row['batch_no'],$row['pro_in'],$tax,$row['bin_location']);
                    

                    array_walk($colllumns, 'filterData');
                    $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
                    
                }
            }else{ 
                $excelData .= 'No records found...'. "\n"; 
            } 
            
                    // // Headers for download 
            header("Content-Type: application/vnd.ms-excel"); 
            header("Content-Disposition: attachment; filename=\"$fileName\""); 
            
                    // Render excel data 
            echo $excelData; 
            
            exit;
        }

        

        
        echo view('header',$data);
        echo view('products/products',$data);
        echo view('footer');
    }else{
        return redirect()->to(base_url('users'));
    }
    
}


public function products_transactions($proid=""){

        $myid=session()->get('id');

   



        if (!empty($proid)) {
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();
            $InvoiceitemsModel= new InvoiceitemsModel();
            $InvoiceitemsModel = new InvoiceitemsModel;


            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}



            $transactions = $InvoiceitemsModel->where('product_id', $proid)->where('deleted',0)->orderBy('id','DESC')->findAll();

            

            $stock_array=$InvoiceitemsModel->where('company_id', company($myid))->where('product_id', $proid)->where('entry_type', 'adjust')->where('deleted',0)->findAll();



                $data=[
                    'title'=>'Transaction Product - Aitsun ERP',
                    'user'=> $UserModel->where('id', session()->get('id'))->first(),
                    'transactions'=>$transactions,
                    'product_id'=>$proid,
                    'stock_array'=> $stock_array,
                ];

                $session=session();

                if ($session->has('isLoggedIn')){ 
                    echo view('header',$data);
                    echo view('products/products_transactions',$data);
                    echo view('footer');
                }else{
                    return redirect()->to(base_url('users'));
                }
            
            
        }
    }

public function add_new(){
    $UserModel = new Main_item_party_table();
    
    $data=[
        'title'=>'Add New Product - Aitsun ERP',
        'user'=> $UserModel->where('id', session()->get('id'))->first(),
    ];

    $session=session();

    if ($session->has('isLoggedIn')){ 
        echo view('header',$data);
        echo view('products/add_new',$data);
        echo view('footer');
    }else{
        return redirect()->to(base_url('users'));
    }
}

public function details($proid=""){
    $myid=session()->get('id');

    
    if (!empty($proid)) {
        $UserModel = new Main_item_party_table();
        $ProductsModel = new Main_item_party_table();

        if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        $prodt=$ProductsModel->where('id',$proid)->where('deleted',0)->first();

        if ($prodt) {
            $data=[
                'title'=>'Product Details - Aitsun ERP',
                'user'=> $UserModel->where('id', session()->get('id'))->first(),
                'pro'=>$prodt
            ];

            $session=session();

            if ($session->has('isLoggedIn')){ 
                echo view('header',$data);
                echo view('products/details',$data);
                echo view('footer');
            }else{
                return redirect()->to(base_url('users'));
            }
        }else{
            return redirect()->to(base_url());
        }
        
    }
}


public function edit($proid=""){

   $myid=session()->get('id');
   



   if (!empty($proid)) {
    $UserModel = new Main_item_party_table();
    $ProductsModel = new Main_item_party_table();


    if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

 

    $prodt=$ProductsModel->where('id',$proid)->where('company_id',company($myid))->where('deleted',0)->first();

    if ($prodt) {
        $data=[
            'title'=>'Edit Product - Aitsun ERP',
            'user'=> $UserModel->where('id', session()->get('id'))->first(),
            'pro'=>$prodt
        ];

        $session=session();

        if ($session->has('isLoggedIn')){ 
            echo view('header',$data);
            echo view('products/product_edit',$data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users'));
        }
    }else{
        return redirect()->to(base_url());
    }
    
}
}

public function long_edit($proid=""){

   $myid=session()->get('id');
   



   if (!empty($proid)) {
    $UserModel = new Main_item_party_table();
    $ProductsModel = new Main_item_party_table();


    if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

    $prodt=$ProductsModel->where('id',$proid)->where('company_id',company($myid))->where('deleted',0)->first();

    if ($prodt) {
        $data=[
            'title'=>'Rich edit product - Aitsun ERP',
            'user'=> $UserModel->where('id', session()->get('id'))->first(),
            'pro'=>$prodt
        ];

        $session=session();

        if ($session->has('isLoggedIn')){ 
            echo view('header',$data);
            echo view('products/product_long_edit',$data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users'));
        }
    }else{
        return redirect()->to(base_url());
    }
    
}
}



public function add_product(){ 
    $ProductsModel = new Main_item_party_table(); 
    $ProductsImages = new ProductsImages();
    $AdditionalfieldsModel = new AdditionalfieldsModel(); 
    
    if ($this->request->getMethod()=='post') {


        $session=session();
        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );


                // Product Unit CRUD

        $file=$this->request->getFile('featured_image');
        
        $imgName='';

        
        if (!empty($_FILES['featured_image']['name'])) {

                        if($_FILES['featured_image']['size'] > 500000) { //10 MB (size is also in bytes)
                            
                        } else {
                            // $target_dir = "public/images/products/";
                            // $target_file = $target_dir . time().basename($_FILES["featured_image"]["name"]);
                            // $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                            // $imgName = time().basename($_FILES["featured_image"]["name"]);
                            // move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file);

                            $img = $this->request->getFile('featured_image');
                            $imgName=time().$img->getName();
                            $image = \Config\Services::image()
                            ->withFile($img)
                            ->resize(350, 350, true, 'height')
                            ->withResource()
                            ->save('public/images/products/'.$imgName);

                        }
                    }else{
                        if (!empty(strip_tags(trim($this->request->getVar('scrapped_product_image'))))) {


                           $url=strip_tags(trim($this->request->getVar('scrapped_product_image')));
                           $data = file_get_contents($url);
                           $imgName=time().reduce_chars(htmlentities(strip_tags(trim($this->request->getVar('title')))),30).'.jpg';
                           $new = 'public/images/products/'.$imgName;
                           file_put_contents($new, $data);


                           $image = \Config\Services::image()
                           ->withFile(FCPATH.'/'.$new)
                           ->resize(350, 350, false, 'height')
                           ->withResource()
                           ->save($new);
                           

                       }else{
                        $imgName='';
                    }
                }
                

                $sllug=preg_replace('/[^A-Za-z0-9\-]/', '-', htmlentities(strip_tags(trim($this->request->getVar('slug')))));
                
                $riiich=preg_replace(array('/class=".*?"/','/style=".*?"/','/alt=".*?"/','/title=".*?"/'), '',$this->request->getVar('long_description'));

                $brand_id=strip_tags(trim($this->request->getVar('brand')));
                if(empty($brand_id)){
                    $brand_id=0;
                }

                $is_custom=0;
                if (!empty(strip_tags(trim($this->request->getVar('barcode'))))) {
                    $is_custom=1;
                }
                
                if ($this->request->getVar('title')) {
                    $pu_data = [
                        'company_id'=>company($myid),
                        'slug'=>$sllug,
                        'product_name'=>str_replace('"', '&#34;', htmlentities(strip_tags(trim($this->request->getVar('title'))))),
                        'unit'=>strip_tags(trim($this->request->getVar('unit'))),
                        'sub_unit'=>strip_tags(trim($this->request->getVar('sub_unit'))),
                        'conversion_unit_rate'=>aitsun_round(strip_tags(trim($this->request->getVar('conversion_unit_rate'))),get_setting(company($myid),'round_of_value')),
                        'created_at'=>now_time($myid),
                        'category'=>strip_tags(trim($this->request->getVar('category'))),
                        'category_name'=>name_of_category(strip_tags(trim($this->request->getVar('category')))),
                        'main_type'=>'product',
                        'product_type'=>strip_tags(trim($this->request->getVar('product_type'))),
                        'sub_category'=>strip_tags(trim($this->request->getVar('sub_category'))),
                        'sec_category'=>strip_tags(trim($this->request->getVar('secondary_category'))),
                        'pro_img'=>$imgName,
                        'brand'=>$brand_id,
                        'brand_name'=>name_of_brand($brand_id),
                        'discounted_price'=>aitsun_round(strip_tags(trim($this->request->getVar('discounted_price'))),get_setting(company($myid),'round_of_value')), 
                        'price'=>aitsun_round(strip_tags(trim($this->request->getVar('price'))),get_setting(company($myid),'round_of_value')),
                        'purchased_price'=>aitsun_round(strip_tags(trim($this->request->getVar('purchased_price'))),get_setting(company($myid),'round_of_value')),
                        'barcode'=>strip_tags(trim($this->request->getVar('barcode'))),
                        'tax'=>strip_tags(trim($this->request->getVar('tax'))),

                        'opening_balance'=>strip_tags(trim($this->request->getVar('stock'))),
                        'closing_balance'=>strip_tags(trim($this->request->getVar('stock'))),
                        'at_price'=>aitsun_round(strip_tags(trim($this->request->getvar('at_price'))),get_setting(company($myid),'round_of_value')),
                        'final_closing_value'=>strip_tags(trim($this->request->getVar('stock')))*aitsun_round(strip_tags(trim($this->request->getvar('at_price'))),get_setting(company($myid),'round_of_value')),
                        'final_closing_value_fifo'=>strip_tags(trim($this->request->getVar('stock')))*aitsun_round(strip_tags(trim($this->request->getvar('at_price'))),get_setting(company($myid),'round_of_value')),
                        'added_by'=>$myid,
                        'purchase_tax'=>strip_tags(trim($this->request->getvar('purchase_tax'))),
                        'sale_tax'=>strip_tags(trim($this->request->getvar('sale_tax'))),
                        'tax_percent'=>percent_of_tax(strip_tags(trim($this->request->getvar('tax')))),
                        'mrp'=>aitsun_round(strip_tags(trim($this->request->getvar('mrp'))),get_setting(company($myid),'round_of_value')),
                        'purchase_margin'=>aitsun_round(strip_tags(trim($this->request->getvar('purchase_margin'))),get_setting(company($myid),'round_of_value')),
                        'sale_margin'=>aitsun_round(strip_tags(trim($this->request->getvar('sale_margin'))),get_setting(company($myid),'round_of_value')), 
                        'custom_barcode'=>$is_custom,
                        'description'=>strip_tags(trim($this->request->getVar('description'))),
                        'product_method'=>strip_tags(trim($this->request->getVar('product_method'))),
                        'rich_description'=>$riiich,
                        'keywords'=>htmlentities(strip_tags(trim($this->request->getVar('keywords')))),
                        'product_code'=>htmlentities(strip_tags($this->request->getVar('product_code'))),
                        'delivery_days'=>strip_tags(trim($this->request->getVar('delivery_days'))),
                        'expiry_date'=>strip_tags(trim($this->request->getVar('ex_date'))),
                        'pro_in'=>strip_tags(trim($this->request->getVar('pro_in'))),
                        'batch_no'=>strip_tags(trim($this->request->getVar('batch_no'))),
                        'bin_location'=>strip_tags(trim($this->request->getVar('bin_location'))),
                        'scrapped_by'=>strip_tags(trim($this->request->getvar('scrapped_by'))),

                        

                    ];

                    $check_slug=$ProductsModel->where('company_id',company($myid))->where('slug',$sllug)->where('main_type','product')->where('deleted',0)->first();
                    $check_name=$ProductsModel->where('company_id',company($myid))->where('deleted',0)->where('main_type','product')->where('product_name',str_replace('"', '&#34;', htmlentities(strip_tags(trim($this->request->getVar('title'))))))->first();
                    if($check_name){
                        echo 2;
                    }elseif ($check_slug) {
                        echo 3;
                    }else{
                        if ($ProductsModel->save($pu_data)) {
                            $proid=$ProductsModel->insertID(); 
                               
                         

                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>'New '.product_type_name(strip_tags(trim($this->request->getVar('product_type')))).' <b>'.htmlentities(strip_tags(trim($this->request->getVar('title')))).'</b> is added.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////


                            
                            if ($this->request->getVar('from_import')==0) {
                                    //uploading multiple image
                                    foreach($this->request->getFileMultiple('thumbnail_images') as $file)
                                    {   
                                        if ($file->isValid()) {
                                            $filename_thumb = $file->getRandomName();
                                            $mimetype_thumb=$file->getClientMimeType();
                                            $file->move('public/images/products/',$filename_thumb);
                                            $thumbdata = [
                                                'product_id'=>$proid,
                                                'image'=>$filename_thumb
                                            ];
                                            $ProductsImages->save($thumbdata);
                                        }
                                        
                                    }

                                    //////////////add additional fields////////////

                                    foreach (additional_fields_array($proid) as $pd){
                                        $AdditionalfieldsModel->delete($pd);
                                    }

                                    foreach ($_POST["field_name"] as $i => $value ) {
                                        $field_value=trim(strip_tags($_POST["field_value"][$i]));
                                        $field_name=trim(strip_tags($_POST["field_name"][$i]));
                                        $switchable=trim(strip_tags($_POST["switchable"][$i]));
                                        
                                        
                                        
                                        $add_fields=[
                                            'product_id'=>$proid,
                                            'product_code'=>strip_tags($this->request->getVar('product_code')),
                                            'field'=>$field_name,
                                            'field_name'=> $field_name,
                                            'field_value'=>$field_value,
                                            'switchable'=>$switchable,
                                        ];

                                        if (!empty($field_name) && !empty($field_value)) {
                                            $AdditionalfieldsModel->save($add_fields); 
                                        }
                                        
                                    }
                                    //////////////add additional fields////////////
                            } 
                            
                            //uploading multiple image
                            echo 1;
                        }else{
                            echo 0;
                        }
                    }
                    
                }


            }

        }

        



        public function update_product($proid=''){
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();
            $ProductsImages = new ProductsImages(); 

            $AdditionalfieldsModel = new AdditionalfieldsModel();
            $session=session();

            if ($this->request->getMethod()=='post') {


                // Product Unit CRUD

                $session=session();
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );

                $file=$this->request->getFile('featured_image');
                
                $imgName=strip_tags(trim($this->request->getVar('old_featured_image')));

                if (!empty($_FILES['featured_image']['name'])) {

                    if($_FILES['featured_image']['size'] > 500000) { //10 MB (size is also in bytes)
                        
                    } else {
                        $img = $this->request->getFile('featured_image');
                        $imgName=time().$img->getName();
                        $image = \Config\Services::image()
                        ->withFile($img)
                        ->resize(350, 350, true, 'height')
                        ->text('Aitsun ERP', [
                            'color'      => '#fff',
                            'opacity'    => 0.8,
                            'withShadow' => true,
                            'vAlign'     => 'middle',
                            'hAlign'     => 'center',
                            'fontSize'   => 25
                        ])
                        ->withResource()
                        ->save('public/images/products/'.$imgName);
                    }
                }


                $at_price=aitsun_round(strip_tags(trim($this->request->getvar('at_price'))),get_setting(company($myid),'round_of_value'));

                $current=strip_tags(trim($this->request->getVar('current_opening_balance')));
                $current_at_price=get_products_data($proid,'at_price');
                $opstock=strip_tags($this->request->getVar('stock'));
                $current_fullstock=strip_tags(trim($this->request->getVar('current_closing_balance')));
                $minnn=$current_fullstock-$current;
                $fullstock=$minnn+$opstock;

                $old_clsing_value=$current*$current_at_price;
                $current_closing_value=get_products_data($proid,'final_closing_value');
                $current_closing_value_fifo=get_products_data($proid,'final_closing_value_fifo');
                $new_closing_value=$opstock*aitsun_round(strip_tags(trim($this->request->getvar('at_price'))),get_setting(company($myid),'round_of_value'));
                $final_closing_value=($current_closing_value-$old_clsing_value)+$new_closing_value;


                $final_closing_value_fifo=($current_closing_value_fifo-$old_clsing_value)+$new_closing_value;


                $sllug=preg_replace('/[^A-Za-z0-9\-]/', '-', htmlentities(strip_tags(trim($this->request->getVar('slug')))));
                $riiich=preg_replace(array('/class=".*?"/','/style=".*?"/','/alt=".*?"/','/title=".*?"/'), '',$this->request->getVar('long_description'));


                


                if ($this->request->getVar('title')) {
                    $pu_data = [
                        'slug'=>$sllug,
                        'product_name'=>str_replace('"', '&#34;', htmlentities(strip_tags(trim($this->request->getVar('title'))))),
                        'unit'=>strip_tags(trim($this->request->getVar('unit'))),
                        'sub_unit'=>strip_tags(trim($this->request->getVar('sub_unit'))),
                        'conversion_unit_rate'=>aitsun_round(strip_tags(trim($this->request->getVar('conversion_unit_rate'))),get_setting(company($myid),'round_of_value')),
                        'description'=>strip_tags(trim($this->request->getVar('description'))),
                        'created_at'=>now_time($myid),
                        'category'=>strip_tags(trim($this->request->getVar('category'))),
                        'category_name'=>name_of_category(strip_tags(trim($this->request->getVar('category')))),
                        'product_type'=>strip_tags(trim($this->request->getVar('product_type'))),
                        'sub_category'=>strip_tags(trim($this->request->getVar('sub_category'))),
                        'sec_category'=>strip_tags(trim($this->request->getVar('secondary_category'))),
                        'pro_img'=>$imgName,
                        'brand'=>strip_tags(trim($this->request->getVar('brand'))),
                        'brand_name'=>name_of_brand(strip_tags(trim($this->request->getVar('brand')))),
                        // 'rich_description'=>$riiich,
                        'purchased_price'=>aitsun_round(strip_tags(trim($this->request->getVar('purchased_price'))),get_setting(company($myid),'round_of_value')),
                        'discounted_price'=>aitsun_round(strip_tags(trim($this->request->getVar('discounted_price'))),get_setting(company($myid),'round_of_value')),
                        'price'=>aitsun_round(strip_tags(trim($this->request->getVar('price'))),get_setting(company($myid),'round_of_value')), 
                        'tax'=>strip_tags(trim($this->request->getVar('tax'))),
                        'opening_balance'=>$opstock,
                        'closing_balance'=>$fullstock,
                        'final_closing_value'=>$final_closing_value,
                        'final_closing_value_fifo'=>$final_closing_value_fifo,
                        'purchase_tax'=>strip_tags(trim($this->request->getvar('purchase_tax'))),
                        'sale_tax'=>strip_tags(trim($this->request->getvar('sale_tax'))),
                        'tax_percent'=>percent_of_tax(strip_tags(trim($this->request->getvar('tax')))),
                        'mrp'=>aitsun_round(strip_tags(trim($this->request->getvar('mrp'))),get_setting(company($myid),'round_of_value')),
                        'purchase_margin'=>aitsun_round(strip_tags(trim($this->request->getvar('purchase_margin'))),get_setting(company($myid),'round_of_value')),
                        'sale_margin'=>aitsun_round(strip_tags(trim($this->request->getvar('sale_margin'))),get_setting(company($myid),'round_of_value')),
                        'at_price'=>aitsun_round(strip_tags(trim($this->request->getvar('at_price'))),get_setting(company($myid),'round_of_value')),
                        'edit_effected'=>0,
                        'product_method'=>strip_tags(trim($this->request->getVar('product_method'))),
                        'product_code'=>htmlentities(strip_tags($this->request->getVar('product_code'))),
                        'keywords'=>htmlentities(strip_tags(trim($this->request->getVar('keywords')))),
                        'delivery_days'=>strip_tags(trim($this->request->getVar('delivery_days'))),
                        'expiry_date'=>strip_tags(trim($this->request->getVar('ex_date'))),
                        'pro_in'=>strip_tags(trim($this->request->getVar('pro_in'))),
                        'batch_no'=>strip_tags(trim($this->request->getVar('batch_no'))),
                        'bin_location'=>strip_tags(trim($this->request->getVar('bin_location'))),
                    ];

                    $checkslugsame=$ProductsModel->where('id',$proid)->where('deleted',0)->first();
                    if (strip_tags(trim($this->request->getVar('slug')))==$checkslugsame['slug']) {
                        $check_slug=false;
                    }else{
                        $check_slug=$ProductsModel->where('slug',$sllug)->where('deleted',0)->first();
                    }
                    

                    if ($check_slug) {
                        echo 2;
                    }else{
                        if ($ProductsModel->update($proid,$pu_data)) {

                        
 
                          

                            ////////////////////////CREATE ACTIVITY LOG//////////////
                            $log_data=[
                                'user_id'=>$myid,
                                'action'=>product_type_name(strip_tags(trim($this->request->getVar('product_type')))).' (#'.$proid.') <b>'.htmlentities(strip_tags(trim($this->request->getVar('title')))).'</b> is updated.',
                                'ip'=>get_client_ip(),
                                'mac'=>GetMAC(),
                                'created_at'=>now_time($myid),
                                'updated_at'=>now_time($myid),
                                'company_id'=>company($myid),
                            ];

                            add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////


                            

                            //////////////add additional fields////////////

                            foreach (additional_fields_array($proid) as $pd){
                                $AdditionalfieldsModel->delete($pd);
                            }

                            
                            if (isset($_POST["field_name"])) {
                                foreach ($_POST["field_name"] as $i => $value ) {
                                    $field_value=trim(strip_tags($_POST["field_value"][$i]));
                                    $field_name=trim(strip_tags($_POST["field_name"][$i]));
                                    $switchable=trim(strip_tags($_POST["switchable"][$i]));
                                    $add_fields=[
                                        'product_id'=>$proid,
                                        'product_code'=>strip_tags($this->request->getVar('product_code')),
                                        'field'=>$field_name,
                                        'field_name'=> $field_name,
                                        'field_value'=>$field_value,
                                        'switchable'=>$switchable,
                                    ];

                                    if (!empty($field_name) && !empty($field_value)) {
                                        $AdditionalfieldsModel->save($add_fields); 
                                    }
                                    
                                }
                            }

                            
                            //////////////add additional fields////////////
                            if (strip_tags(trim($this->request->getVar('product_type')))=='item_kit') {
                                /////////////////////ITEM KITS/////////////////////////
                                $itemmss=$ItemkitsModel->where('item_kit_id',$proid)->findAll();
                                foreach ($itemmss as $ditem) {
                                    $ItemkitsModel->where('id',$ditem['id'])->delete();
                                }
                                if (strip_tags(trim($this->request->getVar('product_type')))=='item_kit') {
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


                                            $in_item=[
                                                'item_kit_id'=>$proid,
                                                'product'=>$product_name,
                                                'product_id'=>$product_id,
                                                'quantity'=> $quantity,
                                                'price'=>$price,
                                                'selling_price'=>$selling_price,
                                                'discount'=>$p_discount,
                                                'amount'=>$amount,
                                                'desc'=>$product_desc,
                                                'tax'=>$tax
                                            ];

                                            $ItemkitsModel->save($in_item);

                                        }
                                    }
                                }
                                    /////////////////////ITEM KITS/////////////////////////
                            }
                            

                            //uploading multiple image
    // If files are selected to upload 


                            

                            foreach($this->request->getFileMultiple('thumbnail_images') as $file)
                            {   
                                if ($file->isValid()) {
                                    $filename_thumb = $file->getRandomName();
                                    $mimetype_thumb=$file->getClientMimeType();
                                    $file->move('public/images/products/',$filename_thumb);
                                    $thumbdata = [
                                        'product_id'=>$proid,
                                        'image'=>$filename_thumb
                                    ];
                                    $ProductsImages->save($thumbdata);
                                }
                                
                            }
                            //uploading multiple image
                            echo 1;
                        }else{
                            echo 0;
                        }
                    }
                    
                }


            }

        }

        
        public function rich_update_product($proid=''){
            $UserModel = new Main_item_party_table();
            $ProductsModel = new Main_item_party_table();
            $StockModel = new StockModel();
            $ProductsImages = new ProductsImages();
            
            $AdditionalfieldsModel = new AdditionalfieldsModel();
            $session=session();

            if ($this->request->getMethod()=='post') {


                // Product Unit CRUD

                $session=session();
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );  
                
                
                $riiich=preg_replace(array('/class=".*?"/','/style=".*?"/','/alt=".*?"/','/title=".*?"/'), '',$this->request->getVar('long_description'));

                if ($this->request->getVar('long_description')) {
                    $pu_data = [ 
                        'rich_description'=>$riiich 
                    ];
                    if ($ProductsModel->update($proid,$pu_data)) { 

                        $session->setFlashdata('pu_msg', 'Rich text saved!');
                        return redirect()->to(base_url('products/long_edit').'/'.$proid); 
                    }else{
                        $session->setFlashdata('pu_er_msg', 'Failed to save!');
                        return redirect()->to(base_url('products/long_edit').'/'.$proid);
                    } 

                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to save!');
                    return redirect()->to(base_url('products/long_edit').'/'.$proid);
                }

            }

        }

        

        public function delete($proval=""){
            $ProductsModel = new Main_item_party_table();

            $session=session();
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            $pro_name=$ProductsModel->where('id',$proval)->first();

            $deledata=[
                'deleted'=>1,
                'edit_effected'=>0,
            ];


            if ($ProductsModel->update($proval,$deledata)) {

            ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>product_type_name($pro_name['product_type']).' (#'.$proval.') <b>'.$pro_name['product_name'].'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
            ////////////////////////END ACTIVITY LOG/////////////////

                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('products?page=1'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                return redirect()->to(base_url('products').'/'.$proval);
            }
        }

        public function get_sub_select($parent=""){
            $ProductSubCategories = new ProductSubCategories();

            $ProductSubCategories->where('parent_id',$parent);
            $ProductSubCategories->where('deleted',0);
            $scs=$ProductSubCategories->findAll();
            echo '<option value="">Select Sub Category</option>';
            foreach ($scs as $sc) {
                echo '<option value="'.$sc['id'].'">'.$sc['sub_cat_name'].'</option>';
            }
        }

        public function get_sec_select($parent=""){
            $SecondaryCategories = new SecondaryCategories();

            $SecondaryCategories->where('parent_id',$parent);
            $SecondaryCategories->where('deleted',0);
            $scs=$SecondaryCategories->findAll();
            echo '<option value="">Select Secondary Category</option>';
            foreach ($scs as $sc) {
                echo '<option value="'.$sc['id'].'">'.$sc['second_cat_name'].'</option>';
            }
        }

        

        public function delete_thumb($proval="",$proid=''){
            $ProductsImages = new ProductsImages();

            $session=session();

            


            if ($ProductsImages->delete($proval)) {
                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('products/edit').'/'.$proid);
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                return redirect()->to(base_url('products/edit').'/'.$proid);
            }
        }

        

        public function is_pos($pid=""){

            $ProductsModel = new Main_item_party_table();

            if (!empty($pid)) {

                if ($this->request->getMethod()=='post') {
                    $ad=[
                        'is_pos'=>strip_tags($this->request->getVar('is_pos'))
                    ];


                    if ($ProductsModel->update($pid,$ad)) {
                        echo 1;
                    }else{
                        echo 0;
                    }
                }else{
                    echo 0;
                }
                
            }

        }

        public function add_to_top($pid=""){

            $ProductsModel = new Main_item_party_table();

            if (!empty($pid)) {


                $ad=[
                    'top'=>1
                ];


                if ($ProductsModel->update($pid,$ad)) {
                    echo 1;
                }else{
                    echo 0;
                }
            }

        }

        public function remove_to_top($pid=""){
            $ProductsModel = new Main_item_party_table();
            if (!empty($pid)) {

                $ad=['top'=>0];

                $add_top_product=$ProductsModel->update($pid,$ad);

                if ($add_top_product) {
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }



        public function add_to_deals($pid=""){
            $ProductsModel = new Main_item_party_table();
            if (!empty($pid)) {
             
                $ad=['deals_of_day'=>1];
                if ($ProductsModel->update($pid,$ad)) {
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }

        public function remove_to_deals($pid=""){
            $ProductsModel = new Main_item_party_table();
            if (!empty($pid)) {
                
                $ad=['deals_of_day'=>0];
                if ($ProductsModel->update($pid,$ad)) {
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }


        public function add_to_top_seller($pid=""){
           $ProductsModel = new Main_item_party_table();
           if (!empty($pid)) {
            
            $ad=['top_seller'=>1];

            if ($ProductsModel->update($pid,$ad)) {
                echo 1;
            }else{
                echo 0;
            }
        }
    }

    public function remove_to_top_seller($pid=""){
       $ProductsModel = new Main_item_party_table();
       if (!empty($pid)) {
        
        $ad=['top_seller'=>0];

        if ($ProductsModel->update($pid,$ad)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}


public function add_to_online($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['online'=>1];

        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function remove_to_online($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['online'=>0];
        
        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}



public function product_rating($proid=""){
    if (!empty($proid)) {
        $UserModel = new Main_item_party_table();
        $ProductsModel = new Main_item_party_table();
        $ProductratingsModel=new ProductratingsModel();

        $session=session();
        $myid=session()->get('id');

        
        $prodt=$ProductsModel->where('company_id',company($myid))->where('id',$proid)->where('deleted',0)->first();

        $reveiews=$ProductratingsModel->where('productid',$proid)->where('review_type','dummy')->orderBy('id','DESC')->findAll();

        if ($prodt) {
            $data=[
                'title'=>'Product Ratings - Aitsun ERP',
                'user'=> $UserModel->where('id', session()->get('id'))->first(),
                'pro'=>$prodt,
                'reviess'=>$reveiews
            ];

            $session=session();

            if ($session->has('isLoggedIn')){ 
                echo view('header',$data);
                echo view('products/product_rating',$data);
                echo view('footer');
            }else{
                return redirect()->to(base_url('users'));
            }
        }else{
            return redirect()->to(base_url());
        }
        
    }
}



public function add_rate($proid=''){

    $session=session();
    $ProductratingsModel=new ProductratingsModel();
    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );

    if (!empty($proid)) {
        
        
        if (isset($_POST['save_rate'])) {

            $checkexist=$ProductratingsModel->where('productid',$proid)->where('userid',strip_tags($this->request->getVar('username')))->first();
            $session=session();
            if ($checkexist) {

                $session->setFlashdata('up_er_msg', 'Sorry, you already rated this');
                return redirect()->to(base_url('products/product_rating/'.$proid));
            }else{
                if ($this->request->getVar('rating3')) {
                    $ratte=$this->request->getVar('rating3');
                }else{
                    $ratte=1;
                }
                $reviews_data=[
                    'userid'=>strip_tags($this->request->getVar('username')),
                    'productid'=>$proid,
                    'rating'=>$ratte,
                    'review_type'=>'dummy',
                    'review'=>strip_tags($this->request->getVar('review')),
                    'datetime'=>now_time($myid)
                    
                ];

                if ($ProductratingsModel->save($reviews_data)) {
                 $session->setFlashdata('pu_msg', 'Thank you, successfully rated this product');
                 return redirect()->to(base_url('products/product_rating/'.$proid));
             }else{
                 $session->setFlashdata('pu_er_msg', 'failed');
                 return redirect()->to(base_url('products/product_rating/'.$proid));
             } 
         }
         
     }

     
 }else{
    return redirect()->to(base_url());
}
}




public function delete_review($reviid=0,$proid=0){

    $ProductratingsModel=new ProductratingsModel();
    $session=session();

    if (!empty($reviid)) {


       if ($ProductratingsModel->delete($reviid)) {
        $session->setFlashdata('pu_msg', 'Deleted!');
        return redirect()->to(base_url('products/product_rating/'.$proid));
    }else{
        $session->setFlashdata('pu_er_msg', 'Failed to delete!');
        return redirect()->to(base_url('products/product_rating/'.$proid));
    }
}else{
    return redirect()->to(base_url());
}
}


public function update_price($pid=""){
    $myid=session()->get('id');
    $ProductsModel=new Main_item_party_table;
    
    if (!empty($pid)) {
        $af=[
            'unit'=>strip_tags($this->request->getVar('unit')),
            'tax'=>strip_tags($this->request->getVar('tax')),
            'tax_percent'=>percent_of_tax(strip_tags($this->request->getVar('tax'))),
            'purchased_price'=>aitsun_round(strip_tags($this->request->getVar('purchased_price')),get_setting(company($myid),'round_of_value')),
            'price'=>aitsun_round(strip_tags($this->request->getVar('price')),get_setting(company($myid),'round_of_value')),
            'purchase_tax'=>strip_tags($this->request->getVar('purchase_tax')),
            'sale_tax'=>strip_tags($this->request->getVar('sale_tax')),
            'mrp'=>aitsun_round(strip_tags($this->request->getVar('mrp')),get_setting(company($myid),'round_of_value')),
            'purchase_margin'=>aitsun_round(strip_tags($this->request->getVar('purchase_margin')),get_setting(company($myid),'round_of_value')),
            'sale_margin'=>aitsun_round(strip_tags($this->request->getVar('sale_margin')),get_setting(company($myid),'round_of_value')), 
            'sub_unit'=>strip_tags($this->request->getVar('subunit')),
            'conversion_unit_rate'=>aitsun_round(strip_tags($this->request->getVar('conversion_unit')),get_setting(company($myid),'round_of_value')),
        ];
        if ($ProductsModel->update($pid,$af)) {

                        ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>'Product <b>#'.$pid.'</b> price & unit changed.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];

            add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////
            echo 1;
        }else{
            echo 0;
        }
    }
}


public function requests(){

    $session=session();
    if($session->has('isLoggedIn')){

        $UserModel=new Main_item_party_table;
        $ProductrequestsModel=new ProductrequestsModel;

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        if (check_permission($myid,'manage_product_requestes')==true || usertype($myid) =='admin' || usertype($myid)=='seller') {}else{return redirect()->to(base_url());}
        
        if($_GET){
            if (isset($_GET['requestid'])) {
                if (!empty($_GET['requestid'])) {
                    $ProductrequestsModel->where('id',$_GET['requestid']);
                }
            }
        }

        $get_pro=$ProductrequestsModel->where('company_id',company($myid))->where('status','sent')->where('deleted',0)->orderBy('id','DESC')->findAll();
        

        $data = [
            'title' => 'Aitsun ERP-Product Requests',
            'user'=>$user,
            'product_data'=> $get_pro,
            'data_count'=> count($get_pro),
        ];


        if (isset($_POST['get_excel'])) {
            

            $fileName = "ALL PRODUCT REQUESTS". ".xls"; 
            
                            // Column names 
            $fields = array('#ID', 'REQUESTED BY', 'PRODUCT', 'QTY', 'TYPE', 'DATE', 'EMAIL', 'PHONE', 'DESCRIPTION','STATUS'); 

            
            
                             // print_r($fields);

                            // Display column names as first row 
            $excelData = implode("\t", array_values($fields)) . "\n"; 
            
                            // Fetch records from database 
            $query = $get_pro; 
            if(count($get_pro) > 0){ 
                                // Output each row of the data 
                foreach ($get_pro as $row) {

                    
                    
                    $requested_by= '';
                    if ($row['type']=='quote'){

                        $requested_by=$row['name']; 
                    }else{

                       $requested_by=user_name($row['user_id']);
                   }

                   $product_name='';
                   $product_quantity=0;

                   foreach (pro_request_items_array($row['id'],'unlimited') as $pit ) {
                     $product_name.=$pit['product_name'].',';
                     $product_quantity.=$pit['quantity'].','; 
                 }

                 

                 $date=get_date_format($row['datetime'],'d M Y h:i a');

                 
                 $colllumns=array($row['id'],$requested_by,$product_name,$product_quantity,$row['type'],$date,$row['email'],$row['phone'],$row['description'],$row['status']);


                 
                 array_walk($colllumns, 'filterData');
                 $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
             }
         }else{ 
            $excelData .= 'No records found...'. "\n"; 
        } 
                            // // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
                            // Render excel data 
        echo $excelData; 
        
        exit;
    }

    echo view('header',$data);
    echo view('products/requests', $data);
    echo view('footer');

}else{
    return redirect()->to(base_url('users/login'));
}
}

public function requested_arranged($reqid=''){

    $session=session();
    $myid=session()->get('id');
    if (!empty($reqid)) {

        $ProductrequestsModel=new ProductrequestsModel;
        $QuoteItemsModel= new QuoteItemsModel;
        $UserModel=new Main_item_party_table;
        $user=$UserModel->where('id',$myid)->first();

        $get_req_data=$ProductrequestsModel->where('id',$reqid)->first();
        $get_req_item_data=$QuoteItemsModel->where('request_id',$get_req_data['id'])->first();
        
        
        $reqdata=[
            'status'=>'arranged'
        ];

        if ($ProductrequestsModel->update($reqid,$reqdata)) {

            if ($get_req_data['type']=='request') {

                $user_name=user_name($get_req_data['user_id']);

                $totalitems=count(pro_request_items_array($get_req_data['id'],'unlimited'));
                $tminus=1;

                if ($totalitems>1) {

                    foreach (pro_request_items_array($get_req_data['id'],'unlimited') as $pit ) {

                     $product_name=product_name($pit['product_id']).' and <b>'.$totalitems-$tminus.'</b> more items';
                 }
                 
                 
             }else{

                $product_name=product_name($get_req_item_data['product_id']);
            }
            
            $product_link='<button style=" padding: 12px;background: #1d96d3;color: white;font-size: 15px;font-weight: bolder;border: none;border-radius: 5px;"><a href="https://'.get_company_data(company($user['id']),'website').'" style="color: white; text-decoration: none;"> View Item</a></button>';

            $to=user_email($get_req_data['user_id']);

        }elseif ($get_req_data['type']=='quote') {
            $user_name=$get_req_data['name'];
            $to=$get_req_data['email'];
            
            $totalitems=count(pro_request_items_array($get_req_data['id'],'unlimited'));
            $tminus=1;

            if ($totalitems>1) {

                foreach (pro_request_items_array($get_req_data['id'],'unlimited') as $pit ) {

                 $product_name=product_name($pit['product_id']).' and <b>'.$totalitems-$tminus.'</b> more items';
             }
             
             
         }else{

            $product_name=product_name($get_req_item_data['product_id']);
        }
        
        $product_link='<button style=" padding: 12px;background: '.get_setting(company($user['id']),'primary_color').';color: white;font-size: 15px;font-weight: bolder;border: none;border-radius: 5px;"><a href="https://'.get_company_data(company($user['id']),'website').'" style="color: white; text-decoration: none;"> View Item</a></button>';

    }else{
        $user_name='';
        $product_name='';
        $product_link='';
        $to='mail@example.com';
    }

    

    $subject='Requested product available';
    $message='
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style type="text/css">
#main_div{
    margin: 0% 10% 0% 10%;
}

@media screen and (max-width: 767px) {
  #main_div{
    margin:  0%;
}
}
</style>
</head>
<body style="font-family: sans-serif; ">
<div id="main_div" style="background-color: '.get_setting(company($user['id']),'secondary_color').';border-radius: 50px 50px 50px 50px;">
<div>
<center><img src="https://control.utechoman.com/public/images/company_docs/'.get_company_data(company($user['id']),'company_logo').'" style="width:auto; height: 60px; padding: 15px;"></center>
</div>


<div style="text-align: center;background: '.get_setting(company($user['id']),'primary_color').';color: white; padding: 30px;">
<h2 style="text-transform: capitalize;">Requested product available</h2>
</div>


<div style="margin: 27px;box-shadow: 0px 4px 11px -2px #1d96d3;padding: 30px;border-radius: 21px;background: white;">
<center>
<p style="color: black;">Hii <b>'.$user_name.',</b></p>
<p style="color: black;">
Thank you very much for your interest in our products.<br>
The item you requested <b>'.$product_name.'</b> is available.
</p>
<div>'.$product_link.'</div>
</center>
</div>


<div style="background: '.get_setting(company($user['id']),'primary_color').'; color:white; padding: 17px; border-radius: 0px 0px 50px 50px;">

<center>
<h4>'.get_company_data(company($user['id']),'company_name').'</h4>
<p>Email : <a style="text-decoration: none; color: white;" href="mailto:'.get_company_data(company($user['id']),'email').'">'.get_company_data(company($user['id']),'email').'</a></p>
<p>Phone : <a style="text-decoration: none; color: white;" href="tel://'.get_company_data(company($user['id']),'company_phone').'">'.get_company_data(company($user['id']),'company_phone').'</a></p>
</center>


</div>

</div>
</body>
</html>';

$attached='';

unique_send_email(company($myid),$to,$subject,$message,$attached);

$session->setFlashdata('sucmsg', 'Product Arranged!');
}else{
    $session->setFlashdata('failmsg', 'Failed!');
}
return redirect()->to(base_url('products/requests'));
}else{
    return redirect()->to(base_url('products/requests'));
}
}


public function requested_not_available($reqid=''){

    $session=session();
    $myid=session()->get('id');
    if (!empty($reqid)) {

       $ProductrequestsModel=new ProductrequestsModel;
       $UserModel=new Main_item_party_table;
       $QuoteItemsModel= new QuoteItemsModel;
       $user=$UserModel->where('id',$myid)->first();

       $get_req_data=$ProductrequestsModel->where('id',$reqid)->first();
       $get_req_item_data=$QuoteItemsModel->where('request_id',$get_req_data['id'])->first();


       if ($this->request->getMethod()=='post') {
           $reqdata=[
            'status'=>'rejected',
            'reason'=>strip_tags($this->request->getVar('reason')),
        ];
        if ($ProductrequestsModel->update($reqid,$reqdata)) {

          if ($get_req_data['type']=='request') {
            $user_name=user_name($get_req_data['user_id']);

            $totalitems=count(pro_request_items_array($get_req_data['id'],'unlimited'));
            $tminus=1;

            if ($totalitems>1) {

                foreach (pro_request_items_array($get_req_data['id'],'unlimited') as $pit ) {

                 $product_name=product_name($pit['product_id']).' and <b>'.$totalitems-$tminus.'</b> more items';
             }
             
             
         }else{

            $product_name=product_name($get_req_item_data['product_id']);
        }

        $product_link='<button style=" padding: 12px;background: #1d96d3;color: white;font-size: 15px;font-weight: bolder;border: none;border-radius: 5px;"><a href="https://utechoman.com/shop?pc=&search='.$get_req_data['product_name'].'" style="color: white; text-decoration: none;"> View Item</a></button>';
        $to=user_email($get_req_data['user_id']);
    }elseif ($get_req_data['type']=='quote') {
        $user_name=$get_req_data['name'];
        $to=$get_req_data['email'];
        
        $totalitems=count(pro_request_items_array($get_req_data['id'],'unlimited'));
        $tminus=1;

        if ($totalitems>1) {

            foreach (pro_request_items_array($get_req_data['id'],'unlimited') as $pit ) {

             $product_name=product_name($pit['product_id']).' and <b>'.$totalitems-$tminus.'</b> more items';
         }
         
         
     }else{

        $product_name=product_name($get_req_item_data['product_id']);
    }

    $product_link='<button style=" padding: 12px;background: #1d96d3;color: white;font-size: 15px;font-weight: bolder;border: none;border-radius: 5px;"><a href="https://utechoman.com/home/product/'.product_slug($get_req_data['product_name']).'" style="color: white; text-decoration: none;"> View Item</a></button>';
}else{
    $user_name='';
    $product_name='';
    $product_link='';
    $to='mail@example.com';
}


$subject='Requested product not available';
$message='
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<style type="text/css">
#main_div{
margin: 0% 10% 0% 10%;
}

@media screen and (max-width: 767px) {
  #main_div{
    margin:  0%;
}
}
</style>
</head>
<body style="font-family: sans-serif; ">
<div id="main_div" style="background-color: '.get_setting(company($user['id']),'secondary_color').';border-radius: 50px 50px 50px 50px;">
<div>
<center><img src="https://control.utechoman.com/public/images/company_docs/'.get_company_data(company($user['id']),'company_logo').'" style="width:auto; height: 60px; padding: 15px;"></center>
</div>


<div style="text-align: center;background: '.get_setting(company($user['id']),'primary_color').';color: white; padding: 30px;">
<h2 style="text-transform: capitalize;">Requested product not available</h2>
</div>


<div style="margin: 27px;box-shadow: 0px 4px 11px -2px #1d96d3;padding: 30px;border-radius: 21px;background: white;">
<center>
<p style="color: black;">Hii <b>'.$user_name.',</b></p>
<p style="color: black;">
Thank you very much for your interest in our products.<br>
We received your recent request for <b>'.$product_name.'</b>. I regret to inform you that this item is currently not available. We expect to receive a shipment by this weekend. But, We will replace it with other model till next shipment and we would be more than happy to reserve a quantity for you.
</p>
<div>Thank you</div>
</center>
</div>


<div style="background: '.get_setting(company($user['id']),'primary_color').'; color:white; padding: 17px; border-radius: 0px 0px 50px 50px;">
<center>
<h4>'.get_company_data(company($user['id']),'company_name').'</h4>
<p>Email : <a style="text-decoration: none; color: white;" href="mailto:'.get_company_data(company($user['id']),'email').'">'.get_company_data(company($user['id']),'email').'</a></p>
<p>Phone : <a style="text-decoration: none; color: white;" href="tel://'.get_company_data(company($user['id']),'company_phone').'">'.get_company_data(company($user['id']),'company_phone').'</a></p>
</center>


</div>

</div>
</body>
</html>';

$attached='';

unique_send_email(company($myid),$to,$subject,$message,$attached);

$session->setFlashdata('sucmsg', 'Product Rejected!');
}else{
    $session->setFlashdata('failmsg', 'Failed!');
}
}
return redirect()->to(base_url('products/requests'));
}else{
    return redirect()->to(base_url('products/requests'));
}
}


public function get_form(){
    $UserModel = new Main_item_party_table();
    
    $data=[
        'title'=>'Add New Product - Aitsun ERP',
        'user'=> $UserModel->where('id', session()->get('id'))->first(),
    ];

    $session=session();

    if ($session->has('isLoggedIn')){ 
        echo view('products/add_product_form',$data);
    }
}

public function add_to_latest_product($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['latest_product'=>1];

        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function remove_to_latest_product($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['latest_product'=>0];
        
        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function add_to_flash_seller($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['flash_seller'=>1];

        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function remove_to_flash_seller($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['flash_seller'=>0];
        
        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function add_to_upsell_product($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['upsell_product'=>1];

        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function remove_to_upsell_product($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['upsell_product'=>0];
        
        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function add_to_product_group($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['product_group1'=>1];

        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function remove_to_product_group($pid=""){
    $ProductsModel = new Main_item_party_table();
    if (!empty($pid)) {
        
        $af=['product_group1'=>0];
        
        if ($ProductsModel->update($pid,$af)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function add_new_field(){
    $session=session();
    $myid=session()->get('id');
    

    $FieldsNameModel=new FieldsNameModel;   

    if ($this->request->getMethod()=='post') {
        $fname=strip_tags(trim($this->request->getVar('field_name')));

        $checkexistf=$FieldsNameModel->where('fields_name',$fname)->where('deleted',0)->first();
        if (!$checkexistf) {
            $fdata=[
                'company_id'=>company($myid), 
                'fields_name'=>$fname,   
            ];
            
            if ($FieldsNameModel->save($fdata)) {
                echo $FieldsNameModel->insertID();
            }else{
                echo 0;
            }
        }else{
            echo 1;
        }
        
        
        
    }else{
        echo 0;
    }
}


public function edit_new_field(){
    $session=session();
    $myid=session()->get('id');
    

    $FieldsNameModel=new FieldsNameModel;   

    if ($this->request->getMethod()=='post') {
        $fname=strip_tags(trim($this->request->getVar('field_name')));
        $fid=strip_tags(trim($this->request->getVar('fid')));

        $fdata=[
            'company_id'=>company($myid), 
            'fields_name'=>$fname,   
        ];
        
        if ($FieldsNameModel->update($fid,$fdata)) {
            echo 1;
        }else{
            echo 0;
        }
        
    }else{
        echo 0;
    }
}


public function add_barcode(){
    $session=session();
    $myid=session()->get('id');
    

    $ProductsModel=new Main_item_party_table;   

    if ($this->request->getMethod()=='post') {
        $pid=strip_tags(trim($this->request->getVar('product_id')));

        $fdata=[
            'barcode'=>strip_tags(trim($this->request->getVar('barcode'))),   
            'custom_barcode'=>1,   
        ];
        
        if ($ProductsModel->update($pid,$fdata)) {
            echo 1;
        }else{
            echo 0;
        }
        
    }else{
        echo 0;
    }
}


public function get_subunit_select($parent=""){
    $ProductSubUnit = new ProductSubUnit();

    $ProductSubUnit->where('parent_id',$parent);
    $ProductSubUnit->where('deleted',0);
    $scs=$ProductSubUnit->findAll();
    echo '<option value="">Select Sub unit</option>';
    foreach ($scs as $sc) {
        echo '<option value="'.$sc['id'].'">'.$sc['sub_unit_name'].'</option>';
    }
}



public function requests_rejetcted(){

    $session=session();
    if($session->has('isLoggedIn')){

        $UserModel=new Main_item_party_table;
        $ProductrequestsModel=new ProductrequestsModel;

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        if (check_permission($myid,'manage_product_requestes')==true || usertype($myid) =='admin' || usertype($myid)=='seller') {}else{return redirect()->to(base_url());}
        
        if($_GET){
            if (isset($_GET['requestid'])) {
                if (!empty($_GET['requestid'])) {
                    $ProductrequestsModel->where('id',$_GET['requestid']);
                }
            }
        }

        $get_pro=$ProductrequestsModel->where('company_id',company($myid))->where('status','rejected')->where('deleted',0)->orderBy('id','DESC')->findAll();
        

        $data = [
            'title' => 'Aitsun ERP-Product Requests',
            'user'=>$user,
            'product_data'=> $get_pro,
            'data_count'=> count($get_pro),
        ];


        if (isset($_POST['get_excel'])) {
            

            $fileName = "PRODUCT REQUESTS REJECTED". ".xls"; 
            
                            // Column names 
            $fields = array('#ID', 'REQUESTED BY', 'PRODUCT', 'QTY', 'TYPE', 'DATE', 'EMAIL', 'PHONE', 'DESCRIPTION','STATUS'); 

            
            
                             // print_r($fields);

                            // Display column names as first row 
            $excelData = implode("\t", array_values($fields)) . "\n"; 
            
                            // Fetch records from database 
            $query = $get_pro; 
            if(count($get_pro) > 0){ 
                                // Output each row of the data 
                foreach ($get_pro as $row) {

                    
                    
                    $requested_by= '';
                    if ($row['type']=='quote'){

                        $requested_by=$row['name']; 
                    }else{

                       $requested_by=user_name($row['user_id']);
                   }

                   $product_name='';
                   $product_quantity=0;

                   foreach (pro_request_items_array($row['id'],'unlimited') as $pit ) {
                     $product_name.=$pit['product_name'].',';
                     $product_quantity.=$pit['quantity'].','; 
                 }

                 $date=get_date_format($row['datetime'],'d M Y h:i a');

                 
                 $colllumns=array($row['id'],$requested_by,$product_name,$product_quantity,$row['type'],$date,$row['email'],$row['phone'],$row['description'],$row['status']);


                 
                 array_walk($colllumns, 'filterData');
                 $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
             }
         }else{ 
            $excelData .= 'No records found...'. "\n"; 
        } 
                            // // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
                            // Render excel data 
        echo $excelData; 
        
        exit;
    }

    echo view('header',$data);
    echo view('products/request_reject', $data);
    echo view('footer');

}else{
    return redirect()->to(base_url('users/login'));
}
}


public function requests_approved(){

    $session=session();
    if($session->has('isLoggedIn')){

        $UserModel=new Main_item_party_table;
        $ProductrequestsModel=new ProductrequestsModel;

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        if (check_permission($myid,'manage_product_requestes')==true || usertype($myid) =='admin' || usertype($myid)=='seller') {}else{return redirect()->to(base_url());}
        
        if($_GET){
            if (isset($_GET['requestid'])) {
                if (!empty($_GET['requestid'])) {
                    $ProductrequestsModel->where('id',$_GET['requestid']);
                }
            }
        }

        $get_pro=$ProductrequestsModel->where('company_id',company($myid))->where('status','arranged')->where('deleted',0)->orderBy('id','DESC')->findAll();
        

        $data = [
            'title' => 'Aitsun ERP-Product Requests',
            'user'=>$user,
            'product_data'=> $get_pro,
            'data_count'=> count($get_pro),
        ];


        if (isset($_POST['get_excel'])) {
            

            $fileName = "PRODUCT REQUESTS APPROVED". ".xls"; 
            
                            // Column names 
            $fields = array('#ID', 'REQUESTED BY', 'PRODUCT', 'QTY', 'TYPE', 'DATE', 'EMAIL', 'PHONE', 'DESCRIPTION','STATUS'); 

            
            
                             // print_r($fields);

                            // Display column names as first row 
            $excelData = implode("\t", array_values($fields)) . "\n"; 
            
                            // Fetch records from database 
            $query = $get_pro; 
            if(count($get_pro) > 0){ 
                                // Output each row of the data 
                foreach ($get_pro as $row) {

                    
                    
                    $requested_by= '';
                    if ($row['type']=='quote'){

                        $requested_by=$row['name']; 
                    }else{

                       $requested_by=user_name($row['user_id']);
                   }

                   $product_name='';
                   $product_quantity=0;

                   foreach (pro_request_items_array($row['id'],'unlimited') as $pit ) {
                     $product_name.=$pit['product_name'].',';
                     $product_quantity.=$pit['quantity'].','; 
                 }

                 $date=get_date_format($row['datetime'],'d M Y h:i a');

                 
                 $colllumns=array($row['id'],$requested_by,$product_name,$product_quantity,$row['type'],$date,$row['email'],$row['phone'],$row['description'],$row['status']);


                 
                 array_walk($colllumns, 'filterData');
                 $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
             }
         }else{ 
            $excelData .= 'No records found...'. "\n"; 
        } 
                            // // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
                            // Render excel data 
        echo $excelData; 
        
        exit;
    }

    echo view('header',$data);
    echo view('products/request_approve', $data);
    echo view('footer');

}else{
    return redirect()->to(base_url('users/login'));
}
}



public function add_results_page(){

    $session=session();

    if($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $CompanySettings= new CompanySettings;
        $UserModel = new Main_item_party_table;
        
        $results_per_page = 12; 
        
        if (isset($_POST['add_results_per_page'])) {
            $ac_data = [
                'results_per_page'=>$this->request->getVar('results_per_page'), 
                'barcode_settings'=>$this->request->getVar('barcode_settings'),         
                
            ];


            $update_user=$CompanySettings->update(get_setting(company($myid),'id'),$ac_data);
            if ($update_user){
                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> Challan settings updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                session()->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('products?page=1'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('products?page=1'));
            }
        }

        
    }else{
        return redirect()->to(base_url('users/login'));
    }
}

public function download_plu(){

        $myid=session()->get('id');
        $ProductsModel=new Main_item_party_table;
        $session=session();
        $acti=activated_year(company($myid));
       

        $storData = array();

        $metaData[] = array(
            'hotkey' => 'Hotkey',
            'product_name' => 'PLU name',
            'lf_code' => 'LF Code',
            'code' => 'Code',
            'barcode_type' => 'Barcode type',
            'unit' => 'Unit Price',
            'weight_unit' => 'Weight unit',
            'quantity_type' => 'Quantity type',
            'department' => 'Department', 
            'tare' => 'Tare',
            'shift_time' => 'Shelf time',
            'package_type' => 'Package type',
            'package_weight' => 'Package Weight',
            'tolerance' => 'Tolerance (%)',
            'message1' => 'Message 1',
            'message2' => 'Message 2',
            'label' => 'Label',
            'discount' => 'Discount/Schedule',
            'nutrition' => 'Nutrition',
        );       



        $customerInfo = $ProductsModel->where('company_id',company($myid))->where('product_type!=','fees')->where('deleted',0)->where('main_type','product')->findAll(); 

        ////////////////////////CREATE ACTIVITY LOG//////////////
        $log_data=[
            'user_id'=>$myid,
            'action'=>'Products Exported.',
            'ip'=>get_client_ip(),
            'mac'=>GetMAC(),
            'created_at'=>now_time($myid),
            'updated_at'=>now_time($myid),
            'company_id'=>company($myid),
        ];

        add_log($log_data);
        ////////////////////////END ACTIVITY LOG/////////////////

    
        foreach($customerInfo as $key=>$element) {
            $sale_tax='without';
            $purchase_tax='without';
            if ($element['sale_tax']==1) {
                $sale_tax='with';
            }
            if ($element['purchase_tax']==1) {
                $purchase_tax='with';
            }
            
            $storData[] = array(  
                'hotkey' => $element['pro_ap_code'],
                'product_name' => $element['product_name'],
                'lf_code' => $element['pro_ap_code'],
                'code' => $element['pro_ap_code'],
                'barcode_type' => $element['barcode_type'],
                'unit' =>  aitsun_round($element['price'],get_setting(company($myid),'round_of_value')),
                'weight_unit' => 4,
                'quantity_type' => 0,
                'department' =>  $element['department_cat_code'],
                'tare' => 0,
                'shelf_time' => 15,
                'package_type' => 0,     
                'package_weight' => 0,
                'tolerance'=> 0,
                'message1'=> 0,
                'message2'=> 0,
                'label'=> 0,
                'discount'=> 0,
                'nutrition'=> 0 
            );
        }      
       
        $data = array_merge($metaData,$storData);
        $fileName = "Product PLU" . rand(1,100) . ".xls";
        if ($data) {
            function filterData(&$str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }
            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");
            $flag = false;
            foreach($data as $row) {
                if(!$flag) {
                    // display column names as first row 
                    $flag = true;
                }
                // filter data
                array_walk($row, 'filterData');
                echo implode("\t", array_values($row)) . "\n";
            }
            exit;            
        }
            
    }


    public function add_adjust_stck($proid=''){

    $session=session();
    $InvoiceitemsModel=new InvoiceitemsModel();
    $AccountingModel= new Main_item_party_table();
    $myid=session()->get('id');
    

    if (!empty($proid)) {
        
       if($this->request->getMethod('post')){

                $a_unit=strip_tags($this->request->getVar('unit'));
                $a_in_unit=strip_tags($this->request->getVar('in_unit'));
                $a_rate=strip_tags($this->request->getVar('conversion_unit_rate'));
                $ad_qty=strip_tags($this->request->getVar('adjust_stock_qty'));
                $at_price=strip_tags($this->request->getVar('at_price'));
                $purchased_amt=strip_tags($this->request->getVar('at_price'));
                

                $f__is_sold_in_primary=true;

                if ($a_unit!=$a_in_unit) {
                    $f__is_sold_in_primary=false;
                } 

                if (!$f__is_sold_in_primary) {
                    if ($a_rate<1) {
                        $a_rate=1;
                    }
                    $at_price=$at_price/$a_rate;
                }else{
                    $a_rate=1;
                }

                $amount=$at_price*$ad_qty;

                $stock_data=[
                    'company_id'=>company($myid),
                    'product_id'=>$proid,
                    'invoice_type'=>strip_tags($this->request->getVar('adjust_type')),
                    'quantity'=>$ad_qty,
                    'unit'=>$a_unit,
                    'sub_unit'=>strip_tags($this->request->getVar('sub_unit')),
                    'price'=>$at_price,
                    'amount'=>$amount,
                    'purchased_amount'=>$purchased_amt*$ad_qty,
                    'conversion_unit_rate'=>$a_rate,
                    'in_unit'=>$a_in_unit,
                    'entry_type'=>'adjust',
                    'invoice_date'=>now_time($myid)
                    
                ];

                if ($InvoiceitemsModel->save($stock_data)) {
                    // init_update_final_closing_product($proid);

                // Ledger update
                $pgeac=$AccountingModel->where('id',$proid)->first(); 
                    if ($pgeac) {

                        $adjust_qty=$this->request->getVar('adjust_stock_qty');

                       
                        if ($this->request->getVar('adjust_type')=='purchase') {
                            $old_op_stock=get_products_data($proid,'opening_balance');
                            $old_at_price=get_products_data($proid,'at_price');  
                            $old_cl_stock=get_products_data($proid,'closing_balance'); 
                            $old_cl_value=get_products_data($proid,'final_closing_value');  
                            $old_op_value=$old_op_stock*$old_at_price;
                            
                            $is_sold_in_primary=true;

                            if ($a_unit!=$a_in_unit) {
                                $is_sold_in_primary=false;
                            }


                            if (!$is_sold_in_primary) { 
                                $new_quantity=$adjust_qty/$a_rate;
                            }else{
                                $new_quantity=$adjust_qty;
                            }

                            $final_cl_balance=$new_quantity;
                            $final_cl_value=$adjust_qty*$at_price;

                            $stock_data=[
                                'closing_balance'=>$old_cl_stock+$final_cl_balance,
                                'final_closing_value'=>calculate_sale_value_average($proid),
                                'final_closing_value_fifo'=>calculate_sale_value_fifo($proid)
                            ];

                            $AccountingModel->update($proid,$stock_data);
                        }elseif($this->request->getVar('adjust_type')=='sales'){
                            $old_op_stock=get_products_data($proid,'opening_balance');
                            $old_at_price=get_products_data($proid,'at_price');  
                            $old_cl_stock=get_products_data($proid,'closing_balance'); 
                            $old_cl_value=get_products_data($proid,'final_closing_value');  
                            $old_op_value=$old_op_stock*$old_at_price;
                            
                            $is_sold_in_primary=true;

                            if ($a_unit!=$a_in_unit) {
                                $is_sold_in_primary=false;
                            }


                            if (!$is_sold_in_primary) { 
                                $new_quantity=$adjust_qty/$a_rate;
                            }else{
                                $new_quantity=$adjust_qty;
                            }

                            $final_cl_balance=$new_quantity;
                            $final_cl_value=$adjust_qty*$at_price;

                            $stock_data=[
                                'closing_balance'=>$old_cl_stock-$final_cl_balance,
                                'final_closing_value'=>calculate_sale_value_average($proid),
                                'final_closing_value_fifo'=>calculate_sale_value_fifo($proid)
                            ];

                            $AccountingModel->update($proid,$stock_data);
                        }

                     

                    }
  




                 $session->setFlashdata('pu_msg', 'Added successfully');
                 return redirect()->to(base_url('products'));
             }else{
                 $session->setFlashdata('pu_er_msg', 'failed');
                 return redirect()->to(base_url('products'));
             } 
         
         
     }

     
     }else{
    return redirect()->to(base_url());
    }
}


public function get_adjust_stock($proid){
        if (!empty($proid)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();
                $InvoiceitemsModel = new InvoiceitemsModel;

                $stock_array=$InvoiceitemsModel->where('company_id', company($myid))->where('product_id', $proid)->where('deleted',0)->findAll();

                $data=[
                    'proid'=>$proid,
                    'stock_array'=> $stock_array,
                ];
                echo view('products/stock_adjust_product',$data);

            }
        } 
    }


     public function delete_adjust_stock($pid)
        {
            $myid=session()->get('id');
            $InvoiceitemsModel = new InvoiceitemsModel();
            $AccountingModel= new Main_item_party_table();
          

            $pro_adjust_stock=$InvoiceitemsModel->where('id',$pid)->first();

            $a_unit=$pro_adjust_stock['unit'];
            $a_in_unit=$pro_adjust_stock['in_unit'];
            $a_rate=$pro_adjust_stock['conversion_unit_rate'];

            $deledata=[
                'deleted'=>1,
                'edit_effected'=>0
            ];


            if ($InvoiceitemsModel->update($pid,$deledata)) {
                 
                // // Ledger update
                $pgeac=$AccountingModel->where('id',$pro_adjust_stock['product_id'])->first(); 
                    if ($pgeac) {

                        $adjust_qty=$pro_adjust_stock['quantity'];

                        $is_sold_in_primary=true;

                        if ($a_unit!=$a_in_unit) {
                            $is_sold_in_primary=false;
                        }
                        $full_qty=$adjust_qty;

                        if (!$is_sold_in_primary) {
                            $full_qty=$adjust_qty/$a_rate;
                        }

                        if ($pro_adjust_stock['invoice_type']=='purchase') {
                            $product_id=$pro_adjust_stock['product_id'];
                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                            $current_closing_value=get_products_data($product_id,'final_closing_value');
                            $final_quantity=$full_qty;

                            $is_sold_in_primary=true;

                            if ($a_unit!=$a_in_unit) {
                                $is_sold_in_primary=false;
                            }


                            if (!$is_sold_in_primary) { 
                                $final_quantity=$full_qty/$a_rate;
                            }

                            $stock_data=[
                                'closing_balance'=>$old_cl_stock-$final_quantity,
                                'final_closing_value'=>calculate_sale_value_average($product_id),
                                'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                            ];

                            $AccountingModel->update($product_id,$stock_data);
                        }elseif($pro_adjust_stock['invoice_type']=='sales'){
                            $product_id=$pro_adjust_stock['product_id'];
                            $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                            $current_closing_value=get_products_data($product_id,'final_closing_value');
                            $final_quantity=$full_qty;

                            $is_sold_in_primary=true;

                            if ($a_unit!=$a_in_unit) {
                                $is_sold_in_primary=false;
                            }


                            if (!$is_sold_in_primary) { 
                                $final_quantity=$full_qty/$a_rate;
                            }

                            $stock_data=[
                                'closing_balance'=>$old_cl_stock+$final_quantity, 
                                'final_closing_value'=>calculate_sale_value_average($product_id),
                                'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                            ];

                            $AccountingModel->update($product_id,$stock_data);
                        }
 
                    } 

                 echo 1;
            }else{
                
                echo 0;
            }
           

        }


    public function get_product_details($proid){
        if (!empty($proid)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first(); 
                $InvoiceitemsModel = new InvoiceitemsModel;
                $AccountingModel = new Main_item_party_table;



                $stock_array=$InvoiceitemsModel->where('company_id', company($myid))->where('product_id', $proid)->where('entry_type', 'adjust')->where('deleted',0)->findAll();
 

                $stock=$AccountingModel->where('id',$proid)->where('main_type','product')->where('deleted',0)->first();

                $data=[
                    'proid'=>$proid,
                    'stock_array'=> $stock_array,
                    'stock'=>$stock, 
                    'user'=>$user
                ];
                echo view('products/product_details',$data);

            }
        } 
    }


}

