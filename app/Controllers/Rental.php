<?php
namespace App\Controllers;  
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\InvoiceitemsModel;
use App\Models\RentalLogsModel;


use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

class Rental extends BaseController
{  
    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $InvoiceModel= new InvoiceModel;

            $myid=session()->get('id');
            $pager = \Config\Services::pager();
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}

            if ($_GET) {
                if (isset($_GET['status'])) {
                    if ($_GET['status']!='') {
                        $InvoiceModel->where('rental_status',$_GET['status']);
                    }
                }

                if (isset($_GET['invoice_status'])) {
                    if ($_GET['invoice_status']!='') {
                        $InvoiceModel->where('invoice_type','sales');
                    }else{ 
                        $InvoiceModel->where('invoice_type!=','sales'); 
                    }
                }else{ 
                    $InvoiceModel->where('invoice_type!=','sales'); 
                }
            }else{
                $InvoiceModel->where('invoice_type!=','sales');
            }
               
            $all_rentals=$InvoiceModel->where('company_id',company($myid))->where('deleted',0)->where('bill_from','rental')->orderBy('id','desc')->findAll();
            
                $data = [
                    'title' => 'Aitsun ERP- Rental',
                    'user' => $user, 
                    'all_rentals'=>$all_rentals
                ];
               
                echo view('header',$data);
                echo view('rental/rental_index', $data);
                echo view('footer'); 

           
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function get_rental_items($invoice_id=0,$action="",$status=""){
        $session=session();
        $InvoiceitemsModel=new InvoiceitemsModel;
        if($session->has('isLoggedIn')){
            if ($invoice_id>0) { 
                $data=[
                    'status'=>$status,
                    'action'=>$action,
                    'invoice_id'=>$invoice_id,
                ];

                echo view('rental/rental_items',$data);
            }else{
                echo 'no-data';
            }
        }else{
            echo 'no-data';
        }
    }

    public function save_rental_items($action=''){
        $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;
            $InvoiceitemsModel=new InvoiceitemsModel;
            $RentalLogsModel=new RentalLogsModel;

         
            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first(); 

                    
            if ($this->request->getMethod()=='post') {  
                
                $inid=$this->request->getVar('invoice_id');
                $final_rental_status=$this->request->getVar('status');

                
                foreach ($_POST["product_id"] as $i => $value ) { 
                    $id=$_POST["id"][$i]; 
                    $product_id=$_POST["product_id"][$i];
                    $in_quantity=$_POST["in_quantity"][$i];
                    $total_picked_quantity=$_POST["total_picked_quantity"][$i];
                    $total_returned_quantity=$_POST["total_returned_quantity"][$i];


                    if (empty($_POST["quantity"][$i])) {
                        $quantity=1;
                    }else{
                        $quantity=$_POST["quantity"][$i];
                    }

                    $in_unit=$_POST["in_unit"][$i];

                    $rental_logs_data=[
                        'invoice_id'=>$inid,
                        'item_id'=>$product_id,
                        'log_type'=>$action,
                        'user_id'=>$myid,
                        'datetime'=>now_time($myid),
                        'quantity'=>$quantity,
                        'in_unit'=>$in_unit,
                    ];

                    $RentalLogsModel->save($rental_logs_data);

                    $in_item=[   
                        'id'=> $id 
                    ];

                    if ($action=='pickup') {
                        $in_item['picked_qty']=$in_quantity-($total_picked_quantity+$quantity); 
                        $in_item['picked_in_unit']=$in_unit; 
                    }else{
                        $in_item['returned_qty']=$in_quantity-($total_returned_quantity+$quantity);
                        $in_item['returned_in_unit']=$in_unit;
                    }

                    $InvoiceitemsModel->save($in_item);
                }

                if (total_picked_quantity_of_invoice($inid,'pickup')>=total_actual_quantity_of_invoice($inid)) {
                    $in_data=[ 
                        'rental_status'=>2,  
                    ]; 

                    $in_ins=$InvoiceModel->update($inid,$in_data);
                }

                if (total_picked_quantity_of_invoice($inid,'return')>=total_actual_quantity_of_invoice($inid)) {
                    $in_data=[ 
                        'rental_status'=>3,  
                    ]; 

                    $in_ins=$InvoiceModel->update($inid,$in_data);
                }
                 
                $in_ins=1;
                if ($in_ins) {
                    echo 1;
                } 

            }

                            
            }else{
                echo 0;
            }
    }
}