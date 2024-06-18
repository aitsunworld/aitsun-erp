<?php
namespace App\Controllers;  
use App\Models\Main_item_party_table; 
use App\Models\PosSessions; 
use App\Models\CompanySettings; 
use App\Models\InvoiceModel; 
use App\Models\PosRegisters; 
use App\Models\PosFloors; 
use App\Models\PosTables; 


 
 

class Pos extends BaseController
{
 
     public function index($delete_id='')
     {
        $session=session();
        $UserModel=new Main_item_party_table; 
        $PosSessions=new PosSessions; 
        $PosRegisters=new PosRegisters;  


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $acti=activated_year(company($myid)); 

            $all_registers=$PosRegisters->where('company_id',company($myid))->where('deleted',0)->findAll();

            $data = [
                'title' => 'POS - Aitsun ERP',
                'user'=>$user,      
                'all_registers'=>$all_registers,
                'page_name'=>'pos'
            ];

            echo view('header',$data);
            echo view('pos/index', $data);
            echo view('footer');    


            if ($delete_id>0) {
                $delete_reg_data=[ 
                    'id'=>$delete_id,
                    'deleted'=>1, 
                ]; 

                if ($PosRegisters->save($delete_reg_data)) {
                    $session->setFlashdata('pu_msg', 'Register deleted!');
                    return redirect()->to(base_url('pos'));

                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                    return redirect()->to(base_url('pos'));
                }
            }

            if ($this->request->getMethod()=='post') {
                if ($this->request->getVar('register_name')) {
                    $reg_data=[ 
                        'company_id'=>company($myid),
                        'register_name'=>trim(strip_tags($this->request->getVar('register_name'))),
                        'register_type'=>trim(strip_tags($this->request->getVar('register_type'))),
                    ];

                    if (trim(strip_tags($this->request->getVar('register_id')))!='') {
                        $reg_data['id']=trim(strip_tags($this->request->getVar('register_id')));
                    }
 

                    if ($PosRegisters->save($reg_data)) {
                        $session->setFlashdata('pu_msg', 'Register saved!');
                        return redirect()->to(base_url('pos'));
 
                    }else{
                        $session->setFlashdata('pu_er_msg', 'Failed to save!');
                        return redirect()->to(base_url('pos'));
                    }
                }
            }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function create($page_register_id=0){
        if ($page_register_id>0) { 
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

                

                if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

                $acti=activated_year(company($myid));
                
                $view_type='sales';
                $invoice_type='sales';

              
                    

 
                $data = [
                    'title' => 'POS - Aitsun ERP',
                    'user'=>$user,  
                    'view_method'=>'create',
                    'view_type'=>'sales',
                    'invoice_type'=>'sales',
                    'page_register_id'=>$page_register_id,
                    'in_data'=>null,
                    'inid'=>0,
                    'invoice_type'=>$invoice_type,
                    'm_invoices'=>[],
                    'page_name'=>'pos'

                ];
     
                echo view('pos/create', $data);    
                
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }else{
            return redirect()->to(base_url('pos'));
        }
    }

    public function edit($page_register_id=0,$load_type='create',$invoice_id=0){
        if ($page_register_id>0) { 
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

                

                if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

                $acti=activated_year(company($myid));
                
                $view_type='sales';
                $invoice_type='sales';

                $invoice_data=$InvoiceModel->where('id',$invoice_id)->first();

                if ($invoice_data) {
                    if ($invoice_data['order_status']!='cancelled'){
                        if ($invoice_data['invoice_type']=='sales'){
                         $view_type='sales';
                         } elseif ($invoice_data['invoice_type']=='purchase'){
                             $view_type='purchase';
                         } elseif ($invoice_data['invoice_type']=='sales_order'){
                             $view_type='sales';
                         } elseif ($invoice_data['invoice_type']=='sales_quotation'){
                             $view_type='sales';
                         } elseif ($invoice_data['invoice_type']=='sales_return'){
                             $view_type='sales';
                         } elseif ($invoice_data['invoice_type']=='sales_delivery_note'){
                              $view_type='sales';
                          } elseif ($invoice_data['invoice_type']=='purchase_order'){
                              $view_type='purchase';
                          } elseif ($invoice_data['invoice_type']=='purchase_quotation'){
                              $view_type='purchase';
                          } elseif ($invoice_data['invoice_type']=='purchase_return'){
                             $view_type='purchase';
                          } elseif ($invoice_data['invoice_type']=='purchase_delivery_note'){
                             $view_type='purchase';
                          } else{
                            $view_type='sales';
                         } 
                    }

                    $invoice_type=$invoice_data['invoice_type'];
                }
                    


            $multyiple = explode(',', $invoice_id);

                $data = [
                    'title' => 'POS - Aitsun ERP',
                    'user'=>$user,  
                    'view_method'=>$load_type,
                    'view_type'=>'sales',
                    'invoice_type'=>'sales',
                    'page_register_id'=>$page_register_id,
                    'in_data'=>$invoice_data,
                    'inid'=>$invoice_id,
                    'invoice_type'=>$invoice_type,
                    'm_invoices'=>$multyiple, 
                    'page_name'=>'pos'

                ];
     
                echo view('pos/create', $data);    
                
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }else{
            return redirect()->to(base_url('pos'));
        }
    }


    
    public function open_session(){

        $session=session();
        $UserModel=new Main_item_party_table; 
        $ProductsModel = new Main_item_party_table();
        $PosSessions = new PosSessions();


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 

            if ($this->request->getMethod()=='post') {
                $sesdata=[ 
                    'date'=>now_time($myid),
                    'closing_balance'=>aitsun_round(strip_tags(htmlentities(trim($this->request->getVar('opening_cash')))),get_setting(company($myid),'round_of_value')),
                    'Note'=>strip_tags(htmlentities(trim($this->request->getVar('opening_note')))),
                    'register_id'=>strip_tags(htmlentities(trim($this->request->getVar('register_id')))),
                    'company_id'=>company($myid),
                    'session_serial'=>session_serial(company($myid)), 
                    'deleted'=>0,
                    'user_id'=>$myid
                ];


                if ($PosSessions->save($sesdata)) { 

                    $insert_id=$PosSessions->insertID();

                    $ProductsModel = new Main_item_party_table(); 
                    $acti=activated_year($sesdata['company_id']);

                    

                    
                    $set_data=[ 
                        'date'=>now_time($myid),
                        'closing_balance'=>aitsun_round(strip_tags(htmlentities(trim($this->request->getVar('opening_cash')))),get_setting(company($myid),'round_of_value')),
                        'Note'=>strip_tags(htmlentities(trim($this->request->getVar('opening_note')))),
                        'register_id'=>strip_tags(htmlentities(trim($this->request->getVar('register_id')))),
                        'company_id'=>company($myid),
                        'deleted'=>0,
                        'user_id'=>$myid,
                        'products'=>[], 
                        'session_id'=>$insert_id,
                        'page_name'=>'pos'
                    ];

                    if ($this->setPosSession(strip_tags(htmlentities(trim($this->request->getVar('register_id')))),$set_data)) {
                        echo 1;
                    }else{
                        echo 0;
                    }  
                }else{
                    echo 0;
                }
            }else{
                echo 0;
            }
            
        }else{
            echo 0;
        }

    }

    public function close_register($register_id){
        if (session()->has('pos_session'.+$register_id)) { 
            session()->remove('pos_session'.+$register_id);
            return redirect()->to(base_url('pos'));
        }else{
            return redirect()->to(base_url('pos'));
        }
    }

    private function setPosSession($register_id,$sesdata){ 
        $posdata = $sesdata; 
        session()->set('pos_session'.$register_id,$posdata);
        return true;
    } 

    public function change_pos_mode($mode=0){
        $session=session();
        if($session->has('isLoggedIn')){
            $CompanySettings= new CompanySettings;
            $myid=session()->get('id');
            $etqry = $CompanySettings->where('company_id',company($myid))->first();

            $clientdata=[ 
                'pos_focus_element'=>$mode
            ];

            if ($CompanySettings->update(get_setting(company($myid),'id'),$clientdata)) {
                echo 1;
            }else{
                echo 0;
            }       
        }else{
            echo 0;
        } 
    }


    public function orders()
     {
        $session=session();
        $UserModel=new Main_item_party_table; 
        $PosSessions=new PosSessions; 
        $InvoiceModel=new InvoiceModel; 


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }


            $InvoiceModel->select('invoices.*,pos_registers.register_name,pos_sessions.session_serial');

            $InvoiceModel->join('pos_registers', 'pos_registers.id = invoices.register_id', 'left');
            $InvoiceModel->join('pos_sessions', 'pos_sessions.id = invoices.session_id', 'left');
              

            if (!$_GET) {
                $InvoiceModel->where('invoices.invoice_date',get_date_format(now_time($myid),'Y-m-d'));
            }else {



                if (isset($_GET['invoice_no'])) {
                    if (!empty($_GET['invoice_no'])) {
                        $InvoiceModel->where('invoices.serial_no',$_GET['invoice_no']);
                    }
                } 


                if (isset($_GET['customer'])) {
                    if (!empty($_GET['customer'])) {
                        $InvoiceModel->where('invoices.customer',$_GET['customer']);
                    }
                }
                if (isset($_GET['cust_name'])) {
                    if (!empty($_GET['cust_name'])) {
                        $InvoiceModel->like('invoices.alternate_name',$_GET['cust_name']);
                    }
                }

                if (isset($_GET['from']) && isset($_GET['to'])) {
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if (!empty($from) && empty($dto)) {
                        $InvoiceModel->where('invoices.invoice_date',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $InvoiceModel->where('invoices.invoice_date',$dto);
                    }

                    if (!empty($dto) && !empty($from)) {
                        $InvoiceModel->where("invoices.invoice_date BETWEEN '$from' AND '$dto'");
                    }

                                // if (empty($dto) && empty($from)) {
                                //     $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
                                // }
                } 

            }
 
          
            $InvoiceModel->where('invoices.invoice_type','sales');
            $InvoiceModel->where('invoices.bill_from','pos');
            $InvoiceModel->where('invoices.company_id',company($myid));
            $InvoiceModel->orderBy('invoices.id','desc');

                        // $InvoiceModel;

            $all_invoices=$InvoiceModel->findAll();


            $data = [
                'title' => 'POS - Orders',
                'user'=>$user,
                'all_invoices'=>$all_invoices, 
                'view_type'=>'sales', 
                'page_name'=>'pos'    
            ];

            echo view('header',$data);
            echo view('pos/orders', $data);
            echo view('footer');     
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function floors(){
        $session=session();
        $UserModel=new Main_item_party_table; 
        $PosSessions=new PosSessions; 
        $PosFloors=new PosFloors; 
        $PosRegisters=new PosRegisters; 


        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            $PosFloors->select('pos_floors.*,pos_registers.register_name');

            $PosFloors->join('pos_registers', 'pos_registers.id = pos_floors.register_id', 'left');
            $all_floors=$PosFloors->where('pos_floors.company_id',company($myid))->where('pos_floors.deleted',0)->findAll(); 

            $data = [
                'title' => 'POS - Floors & Tables',
                'user'=>$user, 
                'all_floors'=>$all_floors, 
                'page_name'=>'pos'
            ];

            echo view('header',$data);
            echo view('pos/floors_and_tables', $data);
            echo view('footer');     
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function new_floor($floor_id=0){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {
            
                $data = [
                    'title' => ($floor_id<1)?'Add floor':'Edit floor',
                    'user' => $user,
                    'floor' => null, 
                    'floor_id'=>$floor_id, 
                    'page_name'=>'pos'
                ];
                
                if ($floor_id) {
                    $PosFloors = new PosFloors();
                    $data['floor'] = $PosFloors->where('id', $floor_id)->first();
                    if (!$data['floor']) {
                        return redirect()->to(base_url('pos/floors'));
                    }
                }

                echo view('header',$data);
                echo view('pos/add_edit_floors', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function save_floors(){

        if ($this->request->getMethod() == 'post'){
                $myid=session()->get('id');
                $PosFloors= new PosFloors();
                $PosTables= new PosTables();

                $floor_id = $this->request->getVar('floor_id');
                
                $apt_data = [
                    'company_id' => company($myid), 
                    'floor_name' => strip_tags($this->request->getVar('floor_name')),
                    'register_id' => strip_tags($this->request->getVar('register_id'))
                 ];
                

                if ($floor_id) {
                    // Update existing appointment
                    $PosFloors->update($floor_id, $apt_data);
                    $apoid = $floor_id;
                } else {
                    // Add new appointment
                    $PosFloors->save($apt_data);
                    $apoid = $PosFloors->insertID();
                }

                    
                    // foreach (appointment_timings_array($apoid) as $atms){
                    //     $AdditionalfieldsModel->delete($atms);
                    // }

               

                $deledata=$PosTables->where('floor_id',$apoid); 
                foreach ($_POST["table_name"] as $ll => $value ) {
                    $i_idd=$_POST["i_id"][$ll];
                    $deledata->where('id!=',$i_idd); 
                }

                $deleting_prows=$deledata->where('deleted',0)->findAll();
                foreach ($deleting_prows as $dp) {
                    $PosTables->update($dp['id'],['deleted'=>1]);
                }

                 
                if (!empty($_POST["table_name"])) {
                    foreach ($_POST["table_name"] as $i => $value ) {
                        $table_name=trim(strip_tags($_POST["table_name"][$i]));
                        $seats=trim(strip_tags($_POST["seats"][$i]));
                        $shape=trim(strip_tags($_POST["shape"][$i]));
                        
                        $add_fields=[
                            'floor_id'=>$apoid,
                            'table_name'=>$table_name,
                            'seats'=> $seats,
                            'shape'=>$shape,
                        ];

                        $i_id=$_POST["i_id"][$i]; 
                        $checkexist=$PosTables->where('id',$i_id)->where('deleted',0)->first();
                        if ($checkexist) {
                            $add_fields['id']=$checkexist['id'];
                        }
 
                        $PosTables->save($add_fields); 
                       
                        
                    }
                }
                echo 1;
                     

        }
    }

    public function delete_floor($apid=0)
    {
         $session=session();
        if($session->has('isLoggedIn')){
            $PosFloors = new PosFloors();
            $PosTables= new PosTables();
            $myid=session()->get('id'); 
            $deledata=[
                'deleted'=>1,
            ];

            if ($PosFloors->update($apid,$deledata)) {
                echo 1;
                foreach (floor_tables_array($apid) as $apt['id']){
                    $PosTables->delete($apt['id']);
                } 
            
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }

    }

}
