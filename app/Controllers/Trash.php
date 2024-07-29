<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;




class Trash extends BaseController
{
     public function index()
    {

          $session=session();

          if ($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $InvoiceModel=new InvoiceModel;



                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }


                 if ($_GET) {
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if ($_GET['invoice_no']!='') {
                         $InvoiceModel->where('id',$_GET['invoice_no']);
                    }

                    if (!empty($from) && empty($dto)) {
                        $InvoiceModel->where('date(created_at)',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $InvoiceModel->where('date(created_at)',$dto);
                    }

                    if (!empty($dto) && !empty($from)) {
                        $InvoiceModel->where("date(created_at) BETWEEN '$from' AND '$dto'");
                    }
                }

                 $due_invoices=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','purchase')->where('invoice_type!=','purchase_order')->where('invoice_type!=','purchase_return')->where('invoice_type!=','purchase_delivery_note')->orderBy('id','DESC')->findAll();

                $data = [
                    'title' => 'Aitsun ERP-Trash',
                    'user'=>$user,
                    'trash_invoices'=>$due_invoices,
                ];

                    echo view('header',$data);
                    echo view('trash/invoices', $data);
                    echo view('footer');

                }else{
                    return redirect()->to(base_url('users/login'));
                }

    }


    public function invoices()
        {
                $session=session();

                  if ($session->has('isLoggedIn')){

                        $UserModel=new Main_item_party_table;
                        $InvoiceModel=new InvoiceModel;

                        $myid=session()->get('id');
                        $con = array( 
                            'id' => session()->get('id') 
                        );
                        $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    

                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                   
                    
                    if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if ($_GET['invoice_no']!='') {
                             $InvoiceModel->where('id',$_GET['invoice_no']);
                        }

                        if (!empty($from) && empty($dto)) {
                            $InvoiceModel->where('date(created_at)',$from);
                        }
                        if (!empty($dto) && empty($from)) {
                            $InvoiceModel->where('date(created_at)',$dto);
                        }

                        if (!empty($dto) && !empty($from)) {
                            $InvoiceModel->where("date(created_at) BETWEEN '$from' AND '$dto'");
                        }
                    }

                     $due_invoices=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','purchase')->where('invoice_type!=','purchase_order')->where('invoice_type!=','purchase_return')->where('invoice_type!=','purchase_delivery_note')->orderBy('id','DESC')->findAll();

                     $cnt_invoices=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','purchase')->where('invoice_type!=','purchase_order')->where('invoice_type!=','purchase_return')->where('invoice_type!=','purchase_delivery_note')->orderBy('id','DESC')->findAll();

                    $data = [
                        'title' => 'Aitsun ERP-Trash',
                        'user'=>$user,
                        'trash_invoices'=>$due_invoices,
                        'data_count'=>count($cnt_invoices)
                    ];

                        echo view('header',$data);
                        echo view('trash/invoices', $data);
                        echo view('footer');
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }
                
        }



    public function restore($inid=""){


            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            

            


            if($session->has('isLoggedIn')){

                update_stock_when_restore($inid);
                update_item_stock_of_sales_when_restore($inid);
                restore_from_payments($inid);
                
                $in_type=$InvoiceModel->where('id',$inid)->first();

                $deledata=[
                    'deleted'=>0
                ];
                $del=$InvoiceModel->update($inid,$deledata);
                
                if ($del) {

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=> full_invoice_type($in_type['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> restored from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                    session()->setFlashdata('sucmsg', 'Invoice restored!');
                    return redirect()->to(base_url('trash/invoices'));
                }else{
                    session()->setFlashdata('sucmsg', 'Failed to restore!');
                    return redirect()->to(base_url('trash/invoices'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



     public function delete_permanent($inid=""){

            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


            


            if($session->has('isLoggedIn')){
               
                $in_type=$InvoiceModel->where('id',$inid)->first();

                $deledata=[
                    'deleted'=>3
                ];
                $del=$InvoiceModel->update($inid,$deledata);
                
                if ($del) {

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>full_invoice_type($in_type['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> deleted from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                    session()->setFlashdata('sucmsg', 'Invoice deleted permanently!');
                    return redirect()->to(base_url('trash/invoices'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to delete!');
                    return redirect()->to(base_url('trash/invoices'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }


        public function empty($inid=""){

            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


            

            if($session->has('isLoggedIn')){

                 $in_data=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','purchase')->where('invoice_type!=','purchase_order')->where('invoice_type!=','purchase_return')->where('invoice_type!=','purchase_delivery_note')->findAll();
                
                foreach ($in_data as $ind) {
                    $deledata=[
                        'deleted'=>3
                    ];

                $del=$InvoiceModel->update($ind['id'],$deledata);
                
               

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>full_invoice_type($ind['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$ind['id']).serial(company($myid),$ind['id']).'</b> delete from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                }

                 if ($del) {
                    session()->setFlashdata('sucmsg', 'Cleared');
                    return redirect()->to(base_url('trash/invoices'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to delete!');
                    return redirect()->to(base_url('trash/invoices'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }


        public function restore_all($inid=""){

            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            


            if($session->has('isLoggedIn')){
                
                $inr=$InvoiceModel->where('company_id',company($myid))->where('invoice_type!=','purchase')->where('invoice_type!=','purchase_order')->where('invoice_type!=','purchase_return')->where('invoice_type!=','purchase_delivery_note')->where('deleted',1)->findAll();



                foreach ($inr as $innr) {
                    $deledata=[
                        'deleted'=>0
                    ];
                    $del=$InvoiceModel->update($innr['id'],$deledata);
                    update_stock_when_restore($innr['id']);
                    update_item_stock_of_sales_when_restore($innr['id']);
                    restore_from_payments($innr['id']);

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                    $log_data=[
                        'user_id'=>$myid,
                        'action'=>full_invoice_type($innr['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$innr['id']).serial(company($myid),$innr['id']).'</b> restored from trash.',
                        'ip'=>get_client_ip(),
                        'mac'=>GetMAC(),
                        'created_at'=>now_time($myid),
                        'updated_at'=>now_time($myid),
                        'company_id'=>company($myid),
                    ];

                    add_log($log_data);
                    ////////////////////////END ACTIVITY LOG/////////////////

                }
                
                
                
                if ($del) {
                    session()->setFlashdata('sucmsg', 'Restored successfully');
                    return redirect()->to(base_url('trash/invoices'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to restore');
                    return redirect()->to(base_url('trash/invoices'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



    public function purchases()
        {
            $session=session();
            if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $InvoiceModel=new InvoiceModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();



                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
                

                

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                } 

                
                if ($_GET) {
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if ($_GET['invoice_no']!='') {
                         $InvoiceModel->where('id',$_GET['invoice_no']);
                    }

                    if (!empty($from) && empty($dto)) {
                        $InvoiceModel->where('date(created_at)',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $InvoiceModel->where('date(created_at)',$dto);
                    }

                    if (!empty($dto) && !empty($from)) {
                        $InvoiceModel->where("date(created_at) BETWEEN '$from' AND '$dto'");
                    }
                }
                

                $due_purchases=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','sales')->where('invoice_type!=','sales_order')->where('invoice_type!=','sales_return')->where('invoice_type!=','sales_delivery_note')->orderBy('id','DESC')->findAll();

                     $cnt_purchases=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','sales')->where('invoice_type!=','sales_order')->where('invoice_type!=','sales_return')->where('invoice_type!=','sales_delivery_note')->orderBy('id','DESC')->findAll();

                    $data = [
                        'title' => 'Aitsun ERP-Trash',
                        'user'=>$user,
                        'trash_purchases'=>$due_purchases,
                        'data_count'=>count($cnt_purchases)
                    ];

                    echo view('header',$data);
                    echo view('trash/purchases', $data);
                    echo view('footer');
                        
            }else{
                return redirect()->to(base_url('users/login'));
            }
            
    }


    public function restore_purchase($inid=""){

            $session=session();

            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


            


            if($session->has('isLoggedIn')){

                purchase_update_stock_when_restore($inid);
                update_item_stock_of_purchase_when_restore($inid);
                restore_from_payments($inid);
                

                $in_type=$InvoiceModel->where('id',$inid)->first();


                $deledata=[
                    'deleted'=>0
                ];

                $del=$InvoiceModel->update($inid,$deledata);
                
                if ($del) {
                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=> full_invoice_type($in_type['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> restored from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                    session()->setFlashdata('sucmsg', 'Purchase restored');
                    return redirect()->to(base_url('trash/purchases'));
                }else{
                    session()->setFlashdata('failmsg', 'Purchase restored');
                    return redirect()->to(base_url('trash/purchases'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }


        public function delete_permanent_purchase($inid=""){
            $session=session();

            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


            

            if($session->has('isLoggedIn')){
                $in_type=$InvoiceModel->where('id',$inid)->first();

                $deledata=[
                    'deleted'=>3
                ];
                $del=$InvoiceModel->update($inid,$deledata);
                
                if ($del) {
                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>full_invoice_type($in_type['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> deleted from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                    session()->setFlashdata('sucmsg', 'Purchase deleted permanently');
                    return redirect()->to(base_url('trash/purchases'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to delete!');
                    return redirect()->to(base_url('trash/purchases'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



        public function empty_purchase($inid=""){

            $session=session();

            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


        

            if($session->has('isLoggedIn')){




                 $pur_data=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','sales')->where('invoice_type!=','sales_order')->where('invoice_type!=','sales_return')->where('invoice_type!=','sales_delivery_note')->findAll();
                
                foreach ($pur_data as $pnd) {
                    $deledata=[
                        'deleted'=>3
                    ];

                $del=$InvoiceModel->update($pnd['id'],$deledata);
                

                

                
                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>full_invoice_type($pnd['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$pnd['id']).serial(company($myid),$pnd['id']).'</b> deleted from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                 ////////////////////////END ACTIVITY LOG/////////////////
            }
                if ($del) {
               
                    session()->setFlashdata('sucmsg', 'Cleared');
                    return redirect()->to(base_url('trash/purchases'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to restore!');
                    return redirect()->to(base_url('trash/purchases'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



    public function restore_all_purchase($inid=""){

            $session=session();

            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


            


            if($session->has('isLoggedIn')){
                
                 $inr=$InvoiceModel->where('company_id',company($myid))->where('deleted',1)->where('invoice_type!=','sales')->where('invoice_type!=','sales_order')->where('invoice_type!=','sales_return')->where('invoice_type!=','sales_delivery_note')->findAll();

                foreach ($inr as $innr) {
                    $deledata=[
                        'deleted'=>0
                    ];
                    $del=$InvoiceModel->update($innr['id'],$deledata);
                    purchase_update_stock_when_restore($innr['id']);
                    update_item_stock_of_purchase_when_restore($innr['id']);
                    restore_from_payments($innr['id']);

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>full_invoice_type($innr['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$innr['id']).serial(company($myid),$innr['id']).'</b> restored from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                }
                
                if ($del) {
                    session()->setFlashdata('sucmsg', 'Restored successfully');
                    return redirect()->to(base_url('trash/purchases'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to restore!');
                    return redirect()->to(base_url('trash/purchases'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



    public function products()
        {
            $session=session();
                if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $InvoiceModel=new InvoiceModel;
                    $ProductsModel=new Main_item_party_table;

                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();



                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                    if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                    if (usertype($myid)=='customer') {
                        redirect(base_url('customer_dashboard'));
                    } 

                    
                    $product_data=$ProductsModel->where('company_id',company($myid))->where('deleted',1)->orderBy('id','DESC')->findAll();

                    $data = [
                        'title' => 'Aitsun ERP-Trash',
                        'user'=>$user,
                        'trash_products'=>$product_data,
                        'data_count'=>count($product_data)
                    ];

                    echo view('header',$data);
                    echo view('trash/products', $data);
                    echo view('footer');
                            
                }else{
                    return redirect()->to(base_url('users/login'));
                }
                
        }



    public function restore_product($inid=""){

            $session=session();

             $UserModel=new Main_item_party_table;
             $InvoiceModel=new InvoiceModel;
             $ProductsModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            if($session->has('isLoggedIn')){

                $pro_name=$ProductsModel->where('id',$inid)->first();

                $deledata=[
                    'deleted'=>0
                ];
                $del=$ProductsModel->update($inid,$deledata);
                
                if ($del) {
                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>product_type_name($pro_name['product_type']).' (#'.$inid.') <b>'.$pro_name['product_name'].'</b> restored from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                    session()->setFlashdata('sucmsg', 'Product restored');
                    return redirect()->to(base_url('trash/products'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed');
                    return redirect()->to(base_url('trash/products'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



    public function delete_permanent_product($inid=""){
            $session=session();

             $UserModel=new Main_item_party_table;
             $InvoiceModel=new InvoiceModel;
             $ProductsModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if($session->has('isLoggedIn')){
                
                $pro_name=$ProductsModel->where('id',$inid)->first();

                $deledata=[
                    'deleted'=>3
                ];
                $del=$ProductsModel->update($inid,$deledata);
                
                if ($del) {
                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>product_type_name($pro_name['product_type']).' (#'.$inid.') <b>'.$pro_name['product_name'].'</b> deleted from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                    session()->setFlashdata('sucmsg', 'Product deleted permanently');
                    return redirect()->to(base_url('trash/products'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to delete');
                    return redirect()->to(base_url('trash/products'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }




    public function empty_product($inid=""){
            $session=session();

             $UserModel=new Main_item_party_table;
             $InvoiceModel=new InvoiceModel;
             $ProductsModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            $user=$UserModel->where('id',$myid)->first();


            if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if($session->has('isLoggedIn')){
                

                $pro_data=$ProductsModel->where('company_id',company($myid))->where('deleted',1)->findAll();
                
                foreach ($pro_data as $pd) {
                    $deledata=[
                        'deleted'=>3
                    ];


                $del=$ProductsModel->update($pd['id'],$deledata);
                
                

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=> product_type_name($pd['product_type']).' (#'.$pd['id'].') <b>'.$pd['product_name'].'</b> deleted from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                }


                if ($del) {
                    session()->setFlashdata('sucmsg', 'Cleared');
                    return redirect()->to(base_url('trash/products'));
                }else{
                    session()->setFlashdata('failmsg', 'Failed to delete!');
                    return redirect()->to(base_url('trash/products'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



         public function restore_all_product($inid=""){
           

            $session=session();

            if($session->has('isLoggedIn')){
                

                 $UserModel=new Main_item_party_table;
                 $InvoiceModel=new InvoiceModel;
                 $ProductsModel=new Main_item_party_table;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );

                 $user=$UserModel->where('id',$myid)->first();

                 if (check_permission($myid,'manage_pro_ser')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                $inr=$ProductsModel->where('company_id',company($myid))->where('deleted',1)->findAll();

                foreach ($inr as $innr) {
                    $deledata=[
                        'deleted'=>0
                    ];

                $del=$ProductsModel->update($innr['id'],$deledata);

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>product_type_name($innr['product_type']).' (#'.$innr['id'].') <b>'.$innr['product_name'].'</b> restored from trash.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                }
                
                if ($del){
                    session()->setFlashdata('sucmsg', 'Restored successfully');
                    return redirect()->to(base_url('trash/products'));
                }else{
                    session()->setFlashdata('sucmsg', 'Failed to restore!');
                    return redirect()->to(base_url('trash/products'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }




    }
