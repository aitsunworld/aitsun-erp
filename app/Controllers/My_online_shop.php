<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\FinancialYears;
use App\Models\ProductsModel;
use App\Models\InvoiceModel;
use App\Models\PaymentsModel;
use App\Models\DeliverylocationModel;
use App\Models\OrdertrackingModel;


class My_online_shop extends BaseController
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

                

                if (check_permission($myid,'manage_orders')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

                

                

                     if ($_GET) {
                        $from=$_GET['from'];
                        $dto=$_GET['to'];

                        if (isset($_GET['invoice_no'])) {
                            if (!empty($_GET['invoice_no'])) {
                                $InvoiceModel->where('serial_no',$_GET['invoice_no']);
                            }
                        }

                        if (isset($_GET['customer'])) {
                            if (!empty($_GET['customer'])) {
                                $InvoiceModel->where('customer',$_GET['customer']);
                            }
                        }

                        if (isset($_GET['order_status'])) {
                            if (!empty($_GET['order_status'])) {
                                $InvoiceModel->where('order_status',$_GET['order_status']);
                            }
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

                    $acti=activated_year(company($myid));
                    
                    $all_invoices=$InvoiceModel->where('company_id',company($myid))->where('deleted',0)->where('order_type','order')->where('invoice_type','sales_delivery_note')->orderBy('id','DESC')->findAll();

                    $amounttt=0;
                    $due_amounttt=0;

                    foreach ($all_invoices as $sv) {
                        $amounttt+=$sv['total'];
                        $due_amounttt+=$sv['due_amount'];
                    }

                    $data = [
                        'title' => 'Aitsun ERP-Orders',
                        'user'=>$user,
                        'all_invoices'=>$all_invoices,
                        'data_count'=>count($all_invoices),
                        'total_amount'=>$amounttt,
                        'total_due_amount'=>$due_amounttt,
                    ];


                    if (isset($_POST['get_excel'])) {
                        

                        $fileName = "PRODUCT ORDERS". ".xls"; 
                         
                        // Column names 
                        $fields = array('#ID', 'DATE', 'CUSTOMER', 'AMOUNT', 'STATUS', 'DELIVERY PERSON'); 

                        
                         
                         // print_r($fields);

                        // Display column names as first row 
                        $excelData = implode("\t", array_values($fields)) . "\n"; 
                         
                        // Fetch records from database 
                        $query = $all_invoices; 
                        if(count($query) > 0){ 
                            // Output each row of the data 
                            foreach ($query as $row) {

                                $pinid= get_setting(company($user['id']),'invoice_prefix').''.get_setting(company($user['id']),'sales_delivery_prefix').''.$row['serial_no'];

                               $date=get_date_format($row['invoice_date'],'d M Y');

                               $customer='';
                               if($row['customer'] == 'CASH'){
                                $customer= 'CASH CUSTOMER';
                                }else{ 
                                $customer= customer_name($row['customer']);
                                } 

                                $del_person='';

                                if ($row['delivery_person']=='0') {
                                   $del_person='Not assigned';
                                }else{
                                    
                                   $del_person=$row['delivery_person'];
                                 }

                                $colllumns=array($pinid, $date, $customer, $row['total'], $row['order_status'],$del_person);
                                

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
                    echo view('online_shop/myshop', $data);
                    echo view('footer');

                }else{
                    return redirect()->to(base_url('users/login'));
                }

    }


    public function delivery_location()
    {
        $session=session();
       if($session->has('isLoggedIn')){
            $UserModel=new Main_item_party_table;


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

       if (usertype($myid)=='admin') {
            
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

             

             if (check_permission($myid,'manage_orders')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
            

            $data = [
                    'title' => 'Aitsun ERP-Delivery Location',
                    'user'=>$user,
            ];

            echo view('header',$data);
            echo view('online_shop/delivery_location', $data);
            echo view('footer');


        } else{
            return redirect()->to(base_url());
        }
       
       }else{
        return redirect()->to('users/login'); 
       }
    }


    public function add_region()
        {
            $session=session();
        if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $DeliverylocationModel=new DeliverylocationModel;


                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (isset($_POST['save_regin'])) {

                     
                    
                    $region_data = [
                        'company_id'=>company($myid),
                        'region_name'=>strip_tags($this->request->getVar('region')),
                        'location_type'=>'region'
                        
                    ];

                   $saveregion=$DeliverylocationModel->save($region_data);
                       
                   if ($saveregion) {
                        session()->setFlashdata('sucmsg', 'Added successfully!');
                        return redirect()->to(base_url('my_online_shop/delivery_location'));
                    }else{
                        session()->setFlashdata('failmsg', 'Failed to save!');
                        return redirect()->to(base_url('my_online_shop/delivery_location'));
                    }

                }else{
                    return redirect()->to(base_url('users/login'));
                }
            }
    }


    public function add_post_pin()
        {
            $session=session();
        if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $DeliverylocationModel=new DeliverylocationModel;


                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (isset($_POST['save_post'])) {

                     
                    
                    $region_data = [
                        'company_id'=>company($myid),
                        'parent_id'=>strip_tags($this->request->getVar('sel_region')),
                        'location_type'=>'post',
                        'region_name'=>strip_tags($this->request->getVar('post_office')),
                        'pincode'=>strip_tags($this->request->getVar('pincode')),
                        'shipping_charge'=>strip_tags($this->request->getVar('shipping_charge')),

                        
                    ];

                   $savepost=$DeliverylocationModel->save($region_data);
                       
                   if ($savepost) {
                        session()->setFlashdata('sucmsg', 'Added successfully!');
                        return redirect()->to(base_url('my_online_shop/delivery_location'));
                    }else{
                        session()->setFlashdata('sucmsg', 'Failed to save!');
                        return redirect()->to(base_url('my_online_shop/delivery_location'));
                    }

                }else{
                    return redirect()->to(base_url('users'));
                }
            }
    }

  public function save_delivery_days()
        {
            $session=session();
            if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $DeliverylocationModel=new DeliverylocationModel;


                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();

                    if (isset($_POST['location_id'])) {
                        $delivery_data = [
                            'delivery_days'=>strip_tags($this->request->getVar('location_val'))
                        ];

                       $saveregion=$DeliverylocationModel->update($_POST['location_id'],$delivery_data);
                           
                       if ($saveregion) {
                            echo 1;
                        }else{
                           echo 0;
                        }

                    }else{
                        echo 0;
                    }
                }
    }



    public function edit_region($rid='')
        {
            $session=session();
            if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $DeliverylocationModel=new DeliverylocationModel;


                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();


                    if (isset($_POST['edit_region'])) {
                        
                        $region_data = [
                            
                            'region_name'=>strip_tags($this->request->getVar('region')),
                        ];

                       $saveregion=$DeliverylocationModel->update($rid,$region_data);
                           
                       if ($saveregion) {
                            session()->setFlashdata('sucmsg', 'Updated successfully!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }else{
                            session()->setFlashdata('failmsg', 'Failed to save!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }

                    }else{
                        return redirect()->to(base_url('users'));
                    }
                }
    }


    public function remove_region($rid='')
        {
            $session=session();
            if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $DeliverylocationModel=new DeliverylocationModel;


                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();
                    
                         
                        $region_data = [
                            
                            'deleted'=> 1,
                            
                            
                        ];

                       $del=$DeliverylocationModel->update($rid,$region_data);
                           
                       if ($del) {
                            session()->setFlashdata('sucmsg', 'Deleted!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }else{
                            session()->setFlashdata('failmsg', 'Failed to delete!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }

                    }else{
                        return redirect()->to(base_url('users'));
                    }
               
    }


    public function edit_post($pid='')
        {
            $session=session();
            if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $DeliverylocationModel=new DeliverylocationModel;


                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();


                    if (isset($_POST['edit_post'])) {

                        
                        $region_data = [
                            
                            'parent_id'=>strip_tags($this->request->getVar('sel_region')),
                            'region_name'=>strip_tags($this->request->getVar('post_office')),
                            'pincode'=>strip_tags($this->request->getVar('pincode')),
                            'shipping_charge'=>strip_tags($this->request->getVar('shipping_charge')),
                            
                        ];

                       $saveregion=$DeliverylocationModel->update($pid,$region_data);
                           
                       if ($saveregion) {
                            session()->setFlashdata('sucmsg', 'Updated successfully!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }else{
                            session()->setFlashdata('failmsg', 'Failed to save!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }

                    }else{
                        return redirect()->to(base_url('users'));
                    }
                }
    }


    public function remove_post($pid='')
        {
             $session=session();
            if($session->has('isLoggedIn')){

                    $UserModel=new Main_item_party_table;
                    $DeliverylocationModel=new DeliverylocationModel;


                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();
                    
                         
                    $post_data = [
                        
                        'deleted'=> 1,
                        
                    ];

                    $del=$DeliverylocationModel->update($pid,$post_data);
                           
                       if ($del) {
                            session()->setFlashdata('sucmsg', 'Deleted!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }else{
                            session()->setFlashdata('failmsg', 'Failed to delete!');
                            return redirect()->to(base_url('my_online_shop/delivery_location'));
                        }

                    }else{
                        return redirect()->to(base_url('users'));
                    }
               
    }

    public function delete_order($inid=""){

            $session=session();
            $UserModel=new Main_item_party_table;
            $InvoiceModel=new InvoiceModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if ($session->has('isLoggedIn')){

                if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                update_stock_when_delete($inid);
                update_item_stock_of_sales_when_delete($inid);
                delete_from_payments($inid);

                
                $deledata=[
                    'deleted'=>1
                ];
                $del=$InvoiceModel->update($inid,$deledata);
                
                if ($del) {


                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



                    $session->setFlashdata('sucmsg', 'Order deleted');
                    
                    return redirect()->to(base_url('my_online_shop'));
                }else{
                    $session->setFlashdata('failmsg', 'Failed to delete!');
                    return redirect()->to(base_url('my_online_shop'));
                }
            }else{
                return redirect()->to(base_url('users/login'));
            }
        }



    public function change_order_status($iddd=''){
        $session=session();
        $UserModel=new Main_item_party_table;
        $InvoiceModel=new InvoiceModel;

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if (!empty($iddd)) {
            $ordrow=$InvoiceModel->where('id',$iddd)->first();
             $orddata = [
                'order_status'=>strip_tags($_POST['order_status']),
                'delivery_person'=>strip_tags($_POST['delivery_person']),
                'updated_at'=>now_time($myid)
            ];
            if ($InvoiceModel->update($iddd,$orddata)) {


//////////////////////////////// EMAIL ////////////////////////////////////////////                    
                    $to=$ordrow['email'];
                    $subject=strip_tags($_POST['order_status']);
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
<div id="main_div" style="background-color: rgb(242, 242, 242);border-radius: 50px 50px 50px 50px;">
<div>
<center><img src="https://control.utechoman.com/public/images/company_docs/1623748091utechlogo.png" style="width:auto; height: 60px; padding: 15px;"></center>
</div>


<div style="text-align: center;background: #1d96d3;color: white; padding: 30px;">
<h2 style="text-transform: capitalize;">'.ucfirst(strip_tags($_POST['order_status'])).'</h2>
</div>


<div style="margin: 27px 5px;box-shadow: 0px 4px 11px -2px #1d96d3;padding: 30px;border-radius: 21px;background: white;">
<center>
    <p style="color: black;">Hii <b>'.user_name($ordrow['customer']).',</b></p>
    <p style="color: black;">Your order has been '.strip_tags($_POST['order_status']).', Login to <a href="https://utechoman.com/">utechoman.com</a> and track your order.<br></p>


    <div>
      <table style="width:100%; margin-bottom: 15px;"  border="1" cellspacing="0" cellpadding="3">
        <tr>
          <td style="text-align:left;">OrderID: '.get_setting(company($myid),'invoice_prefix').get_setting(company($myid),'sales_delivery_prefix').serial(company($myid),$iddd).'</td>
          <td style="text-align:left;">Date: '.get_date_format(now_time($myid),"d M Y h:m a").'</td>
        </tr>';

        $taxcount=0;

        $shipchhhr=$ordrow['shipping_charge'];
        if (!empty($shipchhhr)): 
          $shich=currency_symbol(company($myid)).' '.$ordrow['shipping_charge']; 
        else: 
            $shich='Free';
        endif;

        foreach (invoice_items_array($iddd) as $it): 
            if (percent_of_tax($it['tax'])!=''){
                $proprice=$it['price'];
                $taxcount+=$proprice*percent_of_tax($it['tax'])/100;
            }
            if(product_image($it['product_id']) !=''){
                $imgname=product_image($it['product_id']); 
            }else{
                $imgname='prod.png';
            }
            $promg='https://control.utechoman.com/public/images/products/'.$imgname;

        $message.='
        <tr>
          <td colspan="2" class="compare-column-productinfo">
              <div style="display: flex; justify-content: start;">
                  <div>
                      <img src="'.$promg.'" style="height: 80px; width: 100px; max-width: 100px; object-fit: contain;">
                  </div>
                  <div style="margin-top: auto; margin-bottom: auto; text-align: left; line-height: 1.5;">
                      <h6 style="margin: 0;">'.$it['product'].'</h6>
                      <small style="margin: 0; display: block;">Qty: '.$it['quantity'].' X '.currency_symbol(company($myid)).$it['price'].'</small>
                      <small style="margin: 0; display: block; color: #146c43 !important;">'.currency_symbol(company($myid)).$it['quantity']*$it['price'].'</small>
                  </div>

              </div>
          </td>
        </tr>';
        endforeach;


        $message.='<tr>
            <td style="text-align: left;">Tax: </td>
            <td><span style="display:block; margin-bottom: 0; color: #333 !important;">'.currency_symbol(company($myid)).$taxcount.'</span></td>
        </tr>

        <tr>
            <td style="text-align: left;">Shipping Charge: </td>
            <td><span style="display:block; margin-bottom: 0; color: #333 !important;">'.$shich.'</span></td>
        </tr>

        <tr>
            <td style="text-align: left;">Total: </td>
            <td><span style="display:block; margin-bottom: 0; color: #146c43 !important;">'.currency_symbol(company($myid)).$ordrow['total'].'</span></td>
        </tr>

        <tr>
            <td style="text-align: left;">Payment: </td>
            <td><span style="display:block; margin-bottom: 0; color: #333 !important;">Cash on delivery</span></td>
        </tr>

        



      </table>
    </div>


    <div>
    <button style=" padding: 12px;background: #1d96d3;color: white;font-size: 15px;font-weight: bolder;border: none;border-radius: 5px;"><a href="https://utechoman.com/profile/order/'.$ordrow['id'].'" style="color: white; text-decoration: none;">View Details</a></button>
    </div>
</center>
</div>


<div style="background: #1d96d3; color:white; padding: 17px; border-radius: 0px 0px 50px 50px;">
<center>
    <p>Unique Technologies,<br>
    P.O.BOX 1608, Postal Code 133,<br>
    Sultanate of Oman,
    C.R.135970170.</p>
    <p>Email : <a style="text-decoration: none; color: white;" href="mailto:sales@utechoman.com">sales@utechoman.com</a></p>
    <p>Phone : <a style="text-decoration: none; color: white;" href="tel://+968 9552 5399">+968 9552 5399</a></p>
</center>


</div>

</div>
</body>
</html>';
                            
                    $attached='';

                     if (unique_send_email(company($myid),$to,$subject,$message,$attached)) {
                        
                     }else{
                        
                     }
//////////////////////////////// EMAIL ////////////////////////////////////////////

                $session->setFlashdata('sucmsg', 'Status updated!');
                return redirect()->to(base_url('my_online_shop'));
            }else{
                $session->setFlashdata('failmsg', 'Failed to save');
                return redirect()->to(base_url('my_online_shop'));
            }

        }
    }


        public function  add_track($iniid=''){

            $session=session();
            $UserModel=new Main_item_party_table;
            $OrdertrackingModel=new OrdertrackingModel;
            if (!empty($iniid)) {
                if($session->has('isLoggedIn')){
                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );
                    $user=$UserModel->where('id',$myid)->first();
                    if (isset($_POST['track'])) {

                        $trackdata=[
                            'invoice_id'=>$iniid,
                            'track'=>strip_tags($this->request->getVar('track')),
                            'after'=>strip_tags($this->request->getVar('after')),
                            'datetime'=>now_time($myid)
                       ];

                       if ($OrdertrackingModel->save($trackdata)) {
                           $session->setFlashdata('sucmsg', 'Order tracking updated');
                           return redirect()->to(base_url('my_online_shop'));
                       }else{
                           $session->setFlashdata('failmsg', 'Failed');
                           return redirect()->to(base_url('my_online_shop'));
                       } 

                    }
                    
                }else{
                    return redirect()->to(base_url());
                }
           }
       }


   public function  edit_track($trackid=''){
         $session=session();
         $UserModel=new Main_item_party_table;
         $OrdertrackingModel=new OrdertrackingModel;

        if (!empty($trackid)) {
            if($session->has('isLoggedIn')){
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();
                if (isset($_POST['track'])) {

                    $trackdata=[
                        'track'=>strip_tags($this->request->getVar('track'))
                    ];

                    $uptrack=$OrdertrackingModel->update($trackid,$trackdata);

                   if ($uptrack) {
                       $session->setFlashdata('sucmsg', 'Order tracking updated');
                       return redirect()->to(base_url('my_online_shop'));
                   }else{
                       $session->setFlashdata('failmsg', 'Failed');
                       return redirect()->to(base_url('my_online_shop'));
                   } 

                }
                
            }else{
                return redirect()->to(base_url());
            }
       }
   }

   public function delete_track($trkid=0){
        $session=session();
        $OrdertrackingModel=new OrdertrackingModel;
        if (!empty($trkid)) {
            if ($OrdertrackingModel->delete($trkid)) {
                $session->setFlashdata('sucmsg', 'Order tracking deleted');
                return redirect()->to(base_url('my_online_shop'));
            }else{
                $session->setFlashdata('failmsg', 'Failed');
                return redirect()->to(base_url('my_online_shop'));
            }
        }else{
            $session->setFlashdata('failmsg', 'Failed');
            return redirect()->to(base_url('my_online_shop'));
        }
    }


 public function add_to_viewable($pid=""){

    $OrdertrackingModel=new OrdertrackingModel;

    if (!empty($pid)) {
        $ad=['viewable'=>1];
        if ($OrdertrackingModel->update($pid,$ad)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}

public function remove_to_viewable($pid=""){
    $OrdertrackingModel=new OrdertrackingModel;
    if (!empty($pid)) {
       
        $ad=['viewable'=>0];
        if ($OrdertrackingModel->update($pid,$ad)) {
            echo 1;
        }else{
            echo 0;
        }
    }
}


}

