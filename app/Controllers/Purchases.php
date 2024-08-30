<?php
    namespace App\Controllers;
     
    use App\Models\ProductUnits;
    use App\Models\ProductCategories;
    use App\Models\ProductSubCategories;
    use App\Models\SecondaryCategories;
    use App\Models\ProductBrand;
    use App\Models\Main_item_party_table;
    use App\Models\ProductsImages;
    use App\Models\ProductratingsModel;
    use App\Models\AdditionalfieldsModel;
    use App\Models\InvoiceModel;
    use App\Models\PaymentsModel;



    class Purchases extends BaseController
    {
        public function index()
        {
           return redirect()->to(base_url('purchases/purchases'));
        }

        public function purchases()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                
                

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

                $acti=activated_year(company($myid));

                    
                    if (!$_GET) {
                        $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                    }else {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];
                        

                        if (isset($_GET['invoice_no'])) {
                            if (!empty($_GET['invoice_no'])) {
                                $InvoiceModel->where('serial_no',$_GET['invoice_no']);
                            }
                        }

                        if (isset($_GET['payment'])) {
                            if (!empty($_GET['payment'])) {
                                $InvoiceModel->where('paid_status',$_GET['payment']);
                            }
                        }

                        if (isset($_GET['type'])) {
                            if (!empty($_GET['type'])) {
                                $InvoiceModel->where('invoice_type',$_GET['type']);
                            }
                        }


                        if (isset($_GET['customer'])) {
                            if (!empty($_GET['customer'])) {
                                $InvoiceModel->where('customer',$_GET['customer']);
                            }
                        }
                        if (isset($_GET['cust_name'])) {
                            if (!empty($_GET['cust_name'])) {
                                $InvoiceModel->like('alternate_name',$_GET['cust_name']);
                            }
                        }

                        if (!empty($from) && empty($dto)) {
                            $InvoiceModel->where('invoice_date',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $InvoiceModel->where('invoice_date',$dto);
                        }

                        if (!empty($dto) && !empty($from)) {
                            $InvoiceModel->where("invoice_date BETWEEN '$from' AND '$dto'");
                        }

                        // if (empty($dto) && empty($from)) {
                        //     $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                        // }
                        
                    }
                    
                    // $InvoiceModel->groupStart();
                    // $InvoiceModel->where('deleted',0);
                    // $InvoiceModel->orWhere('deleted',4);
                    // $InvoiceModel->groupEnd();

                    $InvoiceModel->groupStart();
                    $InvoiceModel->where('invoice_type','purchase');
                    $InvoiceModel->orWhere('invoice_type','purchase_return');
                    $InvoiceModel->orWhere('invoice_type','create_purchase_order');
                    $InvoiceModel->orWhere('invoice_type','purchase_order');
                    $InvoiceModel->orWhere('invoice_type','purchase_delivery_note');
                    $InvoiceModel->orWhere('invoice_type','purchase_quotation');
                    $InvoiceModel->groupEnd();

                    $InvoiceModel->where('company_id',company($myid));
                    if (get_setting(company($myid),'hide_deleted')) {
                        $InvoiceModel->where('deleted',0);
                    }
                    $InvoiceModel->orderBy('id','desc');

                    // $InvoiceModel->where('financial_year',$acti);
                    
                    $all_invoices=$InvoiceModel->findAll();



                    $amounttt=0;
                    $due_amounttt=0;

                    foreach ($all_invoices as $sv) {
                        $amounttt+=$sv['total'];
                        $due_amounttt+=$sv['due_amount'];
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Purchases',
                        'user'=>$user,
                        'all_invoices'=>$all_invoices,
                        'total_amount'=>$amounttt,
                        'total_due_amount'=>$due_amounttt,
                        'view_type'=>'purchase'
                    ];

                    echo view('header',$data);
                    echo view('invoices/invoices_all', $data);
                    echo view('footer');     
                }else{
                    return redirect()->to(base_url('users/login'));
                }
        }


        

        public function create_purchase(){
            $session=session();
            $UserModel=new Main_item_party_table;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    


                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Create Purchase',
                        'user'=>$user,
                        'invoice_type'=>'purchase',
                        'view_method'=>'create',
                        'view_type'=>'purchase',
                    ];

                    echo view('invoices/new_create_invoice', $data);
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }

        }


        public function create_purchase_order(){
            $session=session();
            $UserModel=new Main_item_party_table;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    


                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Create Purchase Order',
                        'user'=>$user,
                        'invoice_type'=>'purchase_order',
                        'view_method'=>'create',
                        'view_type'=>'purchase',
                    ];

                    echo view('invoices/new_create_invoice', $data);
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }

        }

        public function create_purchase_delivery_note(){
            $session=session();
            $UserModel=new Main_item_party_table;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    


                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Create Purchase Delivery Note',
                        'user'=>$user,
                        'invoice_type'=>'purchase_delivery_note',
                        'view_method'=>'create',
                        'view_type'=>'purchase',
                    ];

                    echo view('invoices/new_create_invoice', $data);
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }

        }


        public function purchase_return(){
            $session=session();
            $UserModel=new Main_item_party_table;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    


                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Create purchase Return',
                        'user'=>$user,
                        'invoice_type'=>'purchase_return',
                        'view_method'=>'create',
                        'view_type'=>'purchase',
                    ];

                    echo view('invoices/new_create_invoice', $data);
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }

        }


        public function edit($inv_id=''){

            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                } 


                $inquery=$InvoiceModel->where('id',$inv_id)->first();
                
                $multyiple = explode(',', $inv_id);
                $data = [
                    'title' => 'Aitsun ERP-Edit Invoice',
                    'user'=>$user,
                    'in_data'=>$inquery,
                    'inid'=>$inv_id,
                    'invoice_type'=>$inquery['invoice_type'],
                    'view_method'=>'edit',
                    'view_type'=>'purchase',
                    'm_invoices'=>$multyiple
                ];

                echo view('invoices/new_create_invoice', $data);

                  
                        
            }else{
                return redirect()->to(base_url('users/login'));
            }
            
        }

        public function copy($inv_id=''){

            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                } 


                $inquery=$InvoiceModel->where('id',$inv_id)->first();
                
                $multyiple = explode(',', $inv_id);
                $data = [
                    'title' => 'Aitsun ERP-Copy Invoice',
                    'user'=>$user,
                    'in_data'=>$inquery,
                    'inid'=>$inv_id,
                    'invoice_type'=>$inquery['invoice_type'],
                    'view_method'=>'copy',
                    'view_type'=>'purchase',
                    'm_invoices'=>$multyiple
                ];

                echo view('invoices/new_create_invoice', $data);

                  
                        
            }else{
                return redirect()->to(base_url('users/login'));
            }
            
        }

        public function convert_to_purchase($inv_id=''){
            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    

                    $inquery=$InvoiceModel->where('id',$inv_id)->first();
                    $multyiple = explode(',', $inv_id);
                    $data = [
                        'title' => 'Aitsun ERP-Convert to purchase',
                        'user'=>$user,
                        'in_data'=>$inquery,
                        'inid'=>$inv_id,
                        'invoice_type'=>$inquery['invoice_type'],
                        'view_method'=>'convert',
                        'convert_to'=>'purchase',
                        'view_type'=>'purchase',
                        'm_invoices'=>$multyiple
                    ];

                    if (has_converted($inv_id)) {
                        return redirect()->to(base_url('purchases/purchases'));
                    }else{
                        echo view('invoices/new_create_invoice', $data);  
                    }
                    

                      
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }
        
    }



    public function convert_to_purchase_delivery_note($inv_id=''){
            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    

                    $inquery=$InvoiceModel->where('id',$inv_id)->first();
                    $multyiple = explode(',', $inv_id);
                    $data = [
                        'title' => 'Aitsun ERP-Convert to purchase',
                        'user'=>$user,
                        'in_data'=>$inquery,
                        'inid'=>$inv_id,
                        'invoice_type'=>$inquery['invoice_type'],
                        'view_method'=>'convert',
                        'convert_to'=>'purchase_delivery_note',
                        'view_type'=>'purchase',
                        'm_invoices'=>$multyiple
                    ];

                    if (has_converted($inv_id)) {
                        return redirect()->to(base_url('purchases/purchases'));
                    }else{
                        echo view('invoices/new_create_invoice', $data);  
                    }
                    

                      
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }
        
    }



    }