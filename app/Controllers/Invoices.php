<?php
namespace App\Controllers; 
use App\Models\ProductUnits;
use App\Models\ProductCategories;
use App\Models\ProductSubCategories;
use App\Models\SecondaryCategories;
use App\Models\ProductBrand;
use App\Models\ProductsModel;
use App\Models\ProductsImages;
use App\Models\ProductratingsModel;
use App\Models\AdditionalfieldsModel;
use App\Models\InvoiceModel;
use App\Models\PaymentsModel;
use App\Models\InvoiceitemsModel;
use App\Models\InstallmentsModel;
use App\Models\Main_item_party_table; 
use App\Models\AppointmentsBookings; 


use App\Libraries\PdfLibrary;



class Invoices extends BaseController
{
    public function index()
    {
     return redirect()->to(base_url('invoices/sales'));
 }

 public function sales()
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

       

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $acti=activated_year(company($myid));


        if (!$_GET) {
            $InvoiceModel->where('invoice_date',get_date_format(now_time($myid),'Y-m-d'));
        }else {



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

            if (isset($_GET['from']) && isset($_GET['to'])) {
                $from=$_GET['from'];
                $dto=$_GET['to'];

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




        }

                    // $InvoiceModel->groupStart();
                    // $InvoiceModel->where('deleted',0);
                    // $InvoiceModel->orWhere('deleted',4);
                    // $InvoiceModel->groupEnd();

        $InvoiceModel->groupStart();
        $InvoiceModel->where('invoice_type','sales');
        $InvoiceModel->orWhere('invoice_type','sales_return');
        $InvoiceModel->orWhere('invoice_type','create_sales_order');
        $InvoiceModel->orWhere('invoice_type','sales_order');
        $InvoiceModel->orWhere('invoice_type','sales_delivery_note');
        $InvoiceModel->orWhere('invoice_type','sales_quotation');
        $InvoiceModel->orWhere('invoice_type','proforma_invoice');
        $InvoiceModel->groupEnd();

        $InvoiceModel->where('company_id',company($myid));
        if (get_setting(company($myid),'hide_deleted')) {
            $InvoiceModel->where('deleted',0);
        }
         $InvoiceModel->where('deleted!=',2);
          $InvoiceModel->where('deleted!=',3);
        $InvoiceModel->orderBy('id','desc');

                    // $InvoiceModel->where('financial_year',$acti);

        $all_invoices=$InvoiceModel->findAll();



        $data = [
            'title' => 'Aitsun ERP-Invoices',
            'user'=>$user,
            'all_invoices'=>$all_invoices, 
            'view_type'=>'sales'
        ];

        echo view('header',$data);
        echo view('invoices/invoices_all', $data);
        echo view('footer');     
    }else{
        return redirect()->to(base_url('users/login'));
    }
}



public function details($cusval=""){
    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;

    if ($session->has('isLoggedIn')){

        if ($cusval) {

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

            $ind=$InvoiceModel->where('id',$cusval);

            $inrow=$ind->first();

                            // if ($inrow['deleted']==1) {
                            //     return redirect()->to(base_url('invoices'));
                            // }

            $data = [
                'title' => 'Aitsun ERP-Invoice Details',
                'invoice_id'=>$cusval,
                'user'=>$user,
                'invoice_data'=>$inrow
            ];


            echo view('header',$data);
            echo view('invoices/invoice_details', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('invoices'));
        }

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

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        } 

        $view_type='sales';

        $inquery=$InvoiceModel->where('id',$inv_id)->first();


        if ($inquery['order_status']!='cancelled'){
            if ($inquery['invoice_type']=='sales'){
             $view_type='sales';
         } elseif ($inquery['invoice_type']=='purchase'){
             $view_type='purchase';
         } elseif ($inquery['invoice_type']=='sales_order'){
             $view_type='sales';
         } elseif ($inquery['invoice_type']=='sales_quotation'){
             $view_type='sales';
         } elseif ($inquery['invoice_type']=='sales_return'){
             $view_type='sales';
         } elseif ($inquery['invoice_type']=='sales_delivery_note'){
          $view_type='sales';
      } elseif ($inquery['invoice_type']=='purchase_order'){
          $view_type='purchase';
      } elseif ($inquery['invoice_type']=='purchase_quotation'){
          $view_type='purchase';
      } elseif ($inquery['invoice_type']=='purchase_return'){
         $view_type='purchase';
     } elseif ($inquery['invoice_type']=='purchase_delivery_note'){
         $view_type='purchase';
     } else{
        $view_type='sales';
    } 
}


$multyiple = explode(',', $inv_id);
$data = [
    'title' => 'Aitsun ERP-Edit Invoice',
    'user'=>$user,
    'in_data'=>$inquery,
    'inid'=>$inv_id,
    'invoice_type'=>$inquery['invoice_type'],
    'view_method'=>'edit',
    'view_type'=>$view_type,
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

         

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

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
            'view_type'=>'sales',
            'm_invoices'=>$multyiple
        ];

        echo view('invoices/new_create_invoice', $data);



    }else{
        return redirect()->to(base_url('users/login'));
    }

}



public function get_invoice($cusval=""){
 $session=session();
 $UserModel=new Main_item_party_table;
 $InvoiceModel=new InvoiceModel;



 $myid=session()->get('id');
 $user=$UserModel->where('id',$myid)->first();

 if ($cusval) {


    $invoice_data=$InvoiceModel->where('id',$cusval)->first();
    if (get_setting($invoice_data['company_id'],'invoice_template')>0) {
        $template=get_setting($invoice_data['company_id'],'invoice_template');
    }else{
        $template=1;
    }

    $data = [
        'title' => 'Aitsun ERP-Invoice Details',
        'invoice_id'=>$cusval,
        'user'=>$user,
        'invoice_data'=>$invoice_data,
        'template'=>$template,
        'page_type'=>'html',
        'last_row_height'=>0,
        'css_url'=>'',
    ];



    echo view('invoices/invoice_templates/invoice_show'.$template, $data);
}else{
                        // return redirect()->to(base_url('invoices'));
} 

}



public function get_invoice_pdf($cusval="",$type='view'){
    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;


    $last_height=0;

    $myid=session()->get('id');
    $user=$UserModel->where('id',$myid)->first();





    if ($cusval) {

        $invoice_data=$InvoiceModel->where('id',$cusval)->first();
        if ($invoice_data) { 

            $page_size='A5';
            $orientation='portrait';

            if (!empty($page_size)) {
                $page_size=strtoupper(get_setting2($invoice_data['company_id'],'invoice_page_size')); 
            }

            if (!empty($page_size)) {
                $orientation=get_setting2($invoice_data['company_id'],'invoice_orientation'); 
            }

            if (get_setting($invoice_data['company_id'],'invoice_template')>0) {
                $template=get_setting($invoice_data['company_id'],'invoice_template');
            }else{
                $template=1;
            }

            $filename="uknown file.pdf";
            $cusname=user_name($invoice_data['customer']);
            if ($invoice_data['alternate_name']!=''){
                $cusname= $invoice_data['alternate_name'];
            }



          $filename=inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']).' - '.$cusname.' - '.inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'.pdf';


          $data = [
            'title' => $filename,
            'invoice_id'=>$cusval,
            'user'=>$user,
            'invoice_data'=>$invoice_data,
            'template'=>$template,
            'page_type'=>'pdf',
            'last_row_height'=>$last_height,
            'css_url'=>base_url().'/public/css/invoice_designs/invoice_html-'.$template.'.css',
        ];




        echo  view('invoices/invoice_designs/invoice_html-'.$template, $data);


    }else{
                    // return redirect()->to(base_url('invoices'));
    } 
}

}

public function view_pdf($inid=0)
    {
        
        $view_method='download';
        $InvoiceModel=new InvoiceModel;
        
        if ($_GET) {
            if (isset($_GET['method'])) {
                if ($_GET['method']!=='download') {
                    $view_method='view';
                }else{
                    $view_method='download';
                }
            }
        } 
        
        $url = pdf_api_url();

        $invoice_data=$InvoiceModel->where('id',$inid)->first();

        $page_size='A4';
        $orientation='portrait';

        if (!empty($page_size)) {
            $page_size=strtoupper(get_setting2($invoice_data['company_id'],'invoice_page_size')); 
        }

        if (!empty($page_size)) {
            $orientation=get_setting2($invoice_data['company_id'],'invoice_orientation'); 
        }

        $filename="uknown file.pdf";
        $cusname=user_name($invoice_data['customer']);
        if ($invoice_data['alternate_name']!=''){
            $cusname= $invoice_data['alternate_name'];
        }
        $filename=inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']).'-'.$cusname.'-'.inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'.pdf';

        // Data to be sent in the POST request (in this example, JSON data)
        $data = array(
            'target_url' => base_url('invoices/get_invoice_pdf').'/'.$inid.'/view',
            'file_name' => $filename,
            'page_type' => $page_size,
            'view_method'=>$view_method,
            'scaling'=>get_setting2($invoice_data['company_id'],'pdf_scaling')
        );
        $data_string = json_encode($data);
        
        // Initialize cURL session
        $curl = curl_init();
        
        // Set the cURL options for POST request
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it directly
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        
        // Execute the cURL request and fetch the response
        $response = curl_exec($curl);
        
        // Check for errors
        if ($response === false) {
            $error = curl_error($curl);
            echo "Error occurred: $error";
        } else {
            header('Content-type: application/pdf');
            if($view_method=='view'){
                header('Content-Disposition: inline; filename="' . $data['file_name'] . '"');
            }else{
                header('Content-Disposition: attachment; filename="' . $data['file_name'] . '"');
            }
            // Handle the response
            echo "Response: $response";
            exit();
        }
        
        // Close cURL session
        curl_close($curl);
    }

public function get_invoice_pdf_old($cusval="",$type='view'){
        $session=session();
        $UserModel=new Main_item_party_table;
        $InvoiceModel=new InvoiceModel;


        $last_height=0;

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();


        if ($cusval) {

            $invoice_data=$InvoiceModel->where('id',$cusval)->first();

            $page_size='A4';
            $orientation='portrait';

            if (!empty($page_size)) {
                $page_size=strtoupper(get_setting2($invoice_data['company_id'],'invoice_page_size')); 
            }

            if (!empty($page_size)) {
                $orientation=get_setting2($invoice_data['company_id'],'invoice_orientation'); 
            }

            if (get_setting($invoice_data['company_id'],'invoice_template')>0) {
                $template=get_setting($invoice_data['company_id'],'invoice_template');
            }else{
                $template=1;
            }

            $filename="uknown file.pdf";
            $cusname="CASH CUSTOMER";

            if ($invoice_data['customer']!='CASH'){
              $cusname=user_name($invoice_data['customer']);
          }elseif ($invoice_data['alternate_name']!=''){
              $cusname= $invoice_data['alternate_name'];
          } 



        $filename=inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']).' - '.$cusname.' - '.inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'.pdf';


        $data = [
            'title' => $filename,
            'invoice_id'=>$cusval,
            'user'=>$user,
            'invoice_data'=>$invoice_data,
            'template'=>$template,
            'page_type'=>'pdf',
            'last_row_height'=>$last_height,
            'css_url'=>base_url().'/public/css/invoice/inpdf/invoice_show'.$template.'.css',
        ];


        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isJavascriptEnabled', TRUE);
        $dompdf->set_option('isRemoteEnabled', TRUE); 

        $dompdf->loadHtml(view('invoices/invoice_templates/invoice_show'.$template, $data));
        $dompdf->setPaper($page_size, $orientation);
        $dompdf->render();

        if ($type=='download') {
            $dompdf->stream($filename, array("Attachment" => true));
        }else{
            $dompdf->stream($filename, array("Attachment" => false));
        }


      exit(); 

    }else{
                        // return redirect()->to(base_url('invoices'));
    } 

}


public function get_thermal_invoice($cusval=""){
 $session=session();
 $UserModel=new Main_item_party_table;
 $InvoiceModel=new InvoiceModel;

 if ($session->has('isLoggedIn')){

    $myid=session()->get('id');
    $user=$UserModel->where('id',$myid)->first();

    if ($cusval) { 

        $data = [
            'title' => 'Aitsun ERP-Invoice Details',
            'invoice_id'=>$cusval,
            'user'=>$user,
            'invoice_data'=>$InvoiceModel->where('id',$cusval)->first()
        ];

        echo view('invoices/invoice_thermal_show', $data);
    }else{
        return redirect()->to(base_url('invoices'));
    }

}else{
    return redirect()->to(base_url('users/login'));
}


}


public function get_thermal_script($cusval=""){
 $session=session();
 $UserModel=new Main_item_party_table;
 $InvoiceModel=new InvoiceModel;

 if ($session->has('isLoggedIn')){

    $myid=session()->get('id');
    $user=$UserModel->where('id',$myid)->first();

    if ($cusval) {



        $data = [
            'title' => 'Aitsun ERP-Invoice Details',
            'invoice_id'=>$cusval,
            'user'=>$user,
            'invoice_data'=>$InvoiceModel->where('id',$cusval)->first()
        ];

        echo view('invoices/invoice_templates/invoice_thermal_script', $data);
    }else{
        return redirect()->to(base_url('invoices'));
    }

}else{
    return redirect()->to(base_url('users/login'));
}


}






public function create_invoice(){
    $session=session();
    $UserModel=new Main_item_party_table;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $data = [
            'title' => 'Aitsun ERP-Create Sales',
            'user'=>$user,
            'invoice_type'=>'sales',
            'view_method'=>'create',
            'view_type'=>'sales',
        ];

        echo view('invoices/new_create_invoice', $data);

    }else{
        return redirect()->to(base_url('users/login'));
    }

}


public function create_proforma_invoice(){
    $session=session();
    $UserModel=new Main_item_party_table;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $data = [
            'title' => 'Aitsun ERP-Create Proforma Invoice',
            'user'=>$user,
            'invoice_type'=>'proforma_invoice',
            'view_method'=>'create',
            'view_type'=>'sales',
        ];

        echo view('invoices/new_create_invoice', $data);

    }else{
        return redirect()->to(base_url('users/login'));
    }

}



public function create_sales_quotation(){
    $session=session();
    $UserModel=new Main_item_party_table;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $data = [
            'title' => 'Aitsun ERP-Create Sales quotation',
            'user'=>$user,
            'invoice_type'=>'sales_quotation',
            'view_method'=>'create',
            'view_type'=>'sales',
        ];

        echo view('invoices/new_create_invoice', $data);

    }else{
        return redirect()->to(base_url('users/login'));
    }

}

public function create_sales_order(){
    $session=session();
    $UserModel=new Main_item_party_table;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $data = [
            'title' => 'Aitsun ERP-Create Sales Order',
            'user'=>$user,
            'invoice_type'=>'sales_order',
            'view_method'=>'create',
            'view_type'=>'sales',
        ];

        echo view('invoices/new_create_invoice', $data);

    }else{
        return redirect()->to(base_url('users/login'));
    }

}

public function create_sales_delivery_note(){
    $session=session();
    $UserModel=new Main_item_party_table;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $data = [
            'title' => 'Aitsun ERP-Create Sales Delivery Note',
            'user'=>$user,
            'invoice_type'=>'sales_delivery_note',
            'view_method'=>'create',
            'view_type'=>'sales',
        ];

        echo view('invoices/new_create_invoice', $data);

    }else{
        return redirect()->to(base_url('users/login'));
    }

}


public function convert_to_sale($inv_id=''){
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

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        $inquery=$InvoiceModel->where('id',$inv_id)->first();
        $multyiple = explode(',', $inv_id);
        $data = [
            'title' => 'Aitsun ERP-Convert to sale',
            'user'=>$user,
            'in_data'=>$inquery,
            'inid'=>$inv_id,
            'invoice_type'=>$inquery['invoice_type'],
            'view_method'=>'convert',
            'convert_to'=>'sales',
            'view_type'=>'sales',
            'm_invoices'=>$multyiple
        ];

        if (has_converted($inv_id)) {
            return redirect()->to(base_url('invoices/sales'));
        }else{
            echo view('invoices/new_create_invoice', $data);  
        }




    }else{
        return redirect()->to(base_url('users/login'));
    }

}




public function convert_to_sale_order($inv_id=''){
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

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        $inquery=$InvoiceModel->where('id',$inv_id)->first();
        $multyiple = explode(',', $inv_id);
        $data = [
            'title' => 'Aitsun ERP-Convert to sales order',
            'user'=>$user,
            'in_data'=>$inquery,
            'inid'=>$inv_id,
            'invoice_type'=>$inquery['invoice_type'],
            'view_method'=>'convert',
            'view_type'=>'sales',
            'convert_to'=>'sales_order',
            'm_invoices'=>$multyiple
        ];

        if (has_converted($inv_id)) {
            return redirect()->to(base_url('invoices/sales'));
        }else{
            echo view('invoices/new_create_invoice', $data);  
        }




    }else{
        return redirect()->to(base_url('users/login'));
    }

}


public function convert_to_sale_delivery_note($inv_id=''){
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

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        $inquery=$InvoiceModel->where('id',$inv_id)->first();
        $multyiple = explode(',', $inv_id);
        $data = [
            'title' => 'Aitsun ERP-Convert to sales order',
            'user'=>$user,
            'in_data'=>$inquery,
            'inid'=>$inv_id,
            'invoice_type'=>$inquery['invoice_type'],
            'view_method'=>'convert',
            'view_type'=>'sales',
            'convert_to'=>'sales_delivery_note',
            'm_invoices'=>$multyiple
        ];

        if (has_converted($inv_id)) {
            return redirect()->to(base_url('invoices/sales'));
        }else{
            echo view('invoices/new_create_invoice', $data);  
        }




    }else{
        return redirect()->to(base_url('users/login'));
    }

}


public function sales_return(){
    $session=session();
    $UserModel=new Main_item_party_table;

    if ($session->has('isLoggedIn')){

        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


        if (usertype($myid)=='customer') {
            return redirect()->to(base_url('customer_dashboard'));
        }

        $data = [
            'title' => 'Aitsun ERP-Create Sales Return',
            'user'=>$user,
            'invoice_type'=>'sales_return',
            'view_method'=>'create',
            'view_type'=>'sales',
        ];

        echo view('invoices/new_create_invoice', $data);

    }else{
        return redirect()->to(base_url('users/login'));
    }

}


public function delete($inid=""){

    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;
    $InvoiceitemsModel=new InvoiceitemsModel;
    $AppointmentsBookings=new AppointmentsBookings;


    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );
    $user=$UserModel->where('id',$myid)->first();

    if ($session->has('isLoggedIn')){

        

        if (no_of_invoice_payemts($inid)>0) {
           $in_type=$InvoiceModel->where('id',$inid)->first();

            if ($in_type['bill_from']=='appointment') {
                $resources_data = [ 
                    'id' => $in_type['booking_id'],  
                    'status' => 1,
                ]; 
                $AppointmentsBookings->save($resources_data);
            }


           if ($in_type['invoice_type']=='sales' || $in_type['invoice_type']=='proforma_invoice' || $in_type['invoice_type']=='sales_return' || $in_type['invoice_type']=='sales_order' || $in_type['invoice_type']=='sales_quotation' || $in_type['invoice_type']=='sales_delivery_note') {

            $session->setFlashdata('pu_er_msg', 'Failed to delete!, Please delete all receipts/payments of this '.full_invoice_type($in_type['invoice_type']));
            return redirect()->to(base_url('invoices/sales'));
        }else{

            $session->setFlashdata('pu_er_msg', 'Failed to delete!, Please delete all receipts/payments of this '.full_invoice_type($in_type['invoice_type']));
            return redirect()->to(base_url('purchases/purchases'));

        }


    }else{
                    // update_item_stock_of_sales_when_delete($inid);
                    // update_item_stock_of_purchase_when_delete($inid);
        delete_from_payments($inid);

        $in_type=$InvoiceModel->where('id',$inid)->first();
        $deledata=[
            'deleted'=>1,
            'edit_effected'=>0
        ];
        $del=$InvoiceModel->update($inid,$deledata);

        if ($del) {



           // ??????????????????????????  customer and cash balance calculation start ????????????
            // ??????????????????????????  customer and cash balance calculation start ????????????
            //CUSTOMER
            $bal_customer=$in_type['customer'];

            $current_closing_balance=user_data($bal_customer,'closing_balance');
            $new_closing_balance=$current_closing_balance;

            if ($in_type['invoice_type']=='sales' || $in_type['invoice_type']=='proforma_invoice' || $in_type['invoice_type']=='purchase_return') {
                $new_closing_balance=$new_closing_balance-aitsun_round($in_type['due_amount'],get_setting(company($myid),'round_of_value'));
            }elseif ($in_type['invoice_type']=='purchase' || $in_type['invoice_type']=='sales_return'){
                $new_closing_balance=$new_closing_balance+aitsun_round($in_type['due_amount'],get_setting(company($myid),'round_of_value'));
            }


            $bal_customer_data=[ 
                'closing_balance'=>$new_closing_balance,
            ];
            $UserModel->update($bal_customer,$bal_customer_data);
            // ??????????????????????????  customer and cash balance calculation end ??????????????
            // ??????????????????????????  customer and cash balance calculation end ??????????????



            $invoice_items_data=$InvoiceitemsModel->where('invoice_id',$inid)->where('deleted!=',3)->findAll();
            foreach ($invoice_items_data as $intm) {

                $deleinitem=[
                    'deleted'=>1,
                ];
                $InvoiceitemsModel->update($intm['id'],$deleinitem);

                //////////////////////////////Stock calculation/////////////////////////
                ////////////////////////////////////////////////////////////////////////

                 if ($in_type['invoice_type']=='sales' || $in_type['invoice_type']=='proforma_invoice' || $in_type['invoice_type']=='purchase_return') {
                      

                        $product_id=$intm['product_id'];
                        $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                        $current_closing_value=get_products_data($product_id,'final_closing_value');
                        $final_quantity=$intm['quantity'];

                        $is_sold_in_primary=true;

                        if ($intm['unit']!=$intm['in_unit']) {
                            $is_sold_in_primary=false;
                        }


                        if (!$is_sold_in_primary) { 
                            $final_quantity=$intm['quantity']/$intm['conversion_unit_rate'];
                        }

                        $stock_data=[
                            'closing_balance'=>$old_cl_stock+$final_quantity, 
                            'final_closing_value'=>calculate_sale_value_average($product_id),
                            'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                        ];

                        $UserModel->update($product_id,$stock_data);



                }elseif ($in_type['invoice_type']=='purchase' || $in_type['invoice_type']=='sales_return'){
                    $product_id=$intm['product_id'];
                    $old_cl_stock=get_products_data($product_id,'closing_balance'); 
                    $current_closing_value=get_products_data($product_id,'final_closing_value');
                    $final_quantity=$intm['quantity'];

                    $is_sold_in_primary=true;

                    if ($intm['unit']!=$intm['in_unit']) {
                        $is_sold_in_primary=false;
                    }


                    if (!$is_sold_in_primary) { 
                        $final_quantity=$intm['quantity']/$intm['conversion_unit_rate'];
                    }

                    $stock_data=[
                        'closing_balance'=>$old_cl_stock-$final_quantity,
                        'final_closing_value'=>calculate_sale_value_average($product_id),
                        'final_closing_value_fifo'=>calculate_sale_value_fifo($product_id)
                    ];

                    $UserModel->update($product_id,$stock_data);

                  
                } 

                //////////////////////////////Stock calculation/////////////////////////
                ////////////////////////////////////////////////////////////////////////
            }

                    ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=> full_invoice_type($in_type['invoice_type']).' Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> is deleted.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];

            add_log($log_data);
                    ////////////////////////END ACTIVITY LOG/////////////////



            if ($in_type['invoice_type']=='sales' || $in_type['invoice_type']=='proforma_invoice' || $in_type['invoice_type']=='sales_return' || $in_type['invoice_type']=='sales_order' || $in_type['invoice_type']=='sales_quotation' || $in_type['invoice_type']=='sales_delivery_note') {

                $session->setFlashdata('pu_msg', 'Invoice deleted');
                return redirect()->to(base_url('invoices/sales'));
            }else{

                $session->setFlashdata('pu_msg', 'Invoice deleted');
                return redirect()->to(base_url('purchases/purchases'));

            }


        }else{

            if ($in_type['invoice_type']=='sales' || $in_type['invoice_type']=='proforma_invoice' || $in_type['invoice_type']=='sales_return' || $in_type['invoice_type']=='sales_order' || $in_type['invoice_type']=='sales_quotation' || $in_type['invoice_type']=='sales_delivery_note') {

                $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                return redirect()->to(base_url('invoices/sales'));

            }else{

                $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                return redirect()->to(base_url('purchases/purchases'));
            }
        }
    } 
}else{
    return redirect()->to(base_url('users/login'));
}
}



public function cancel($inid=""){

    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;
    $InvoiceitemsModel=new InvoiceitemsModel;

    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );
    $user=$UserModel->where('id',$myid)->first();

    if ($session->has('isLoggedIn')){

        if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{redirect(base_url());}


                // update_item_stock_of_sales_when_delete($inid);
        delete_from_payments($inid);


        $deledata=[
            'deleted'=>4,
            'edit_effected'=>0
        ];
        $del=$InvoiceModel->update($inid,$deledata);

        if ($del) {

           $invoice_items_data=$InvoiceitemsModel->where('invoice_id',$inid)->findAll();
           foreach ($invoice_items_data as $intm) {

            $deleinitem=[
                'deleted'=>1,
            ];
            $InvoiceitemsModel->update($intm['id'],$deleinitem);
        }



                ////////////////////////CREATE ACTIVITY LOG//////////////
        $log_data=[
            'user_id'=>$myid,
            'action'=>'Inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> is cancelled.',
            'ip'=>get_client_ip(),
            'mac'=>GetMAC(),
            'created_at'=>now_time($myid),
            'updated_at'=>now_time($myid),
            'company_id'=>company($myid),
        ];

        add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////



        $session->setFlashdata('pu_msg', 'Invoice canceled');

        return redirect()->to(base_url('invoices/details').'/'.$inid);
    }else{
        $session->setFlashdata('pu_er_msg', 'Failed to cancel!');
        return redirect()->to(base_url('invoices/details').'/'.$inid);
    }
}else{
    return redirect()->to(base_url('users/login'));
}
}



public function restore($inid=""){

    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;
    $InvoiceitemsModel=new InvoiceitemsModel;

    $myid=session()->get('id');
    $con = array( 
        'id' => session()->get('id') 
    );
    $user=$UserModel->where('id',$myid)->first();

    if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


    if ($session->has('isLoggedIn')){

        update_stock_when_restore($inid);
        update_item_stock_of_sales_when_restore($inid);
        restore_from_payments($inid);


        $deledata=[
            'deleted'=>0,
            'edit_effected'=>0
        ];
        $del=$InvoiceModel->update($inid,$deledata);

        if ($del) {

            $invoice_items_data=$InvoiceitemsModel->where('invoice_id',$inid)->findAll();
            foreach ($invoice_items_data as $intm) {

                $deleinitem=[
                    'deleted'=>0,
                ];
                $InvoiceitemsModel->update($intm['id'],$deleinitem);
            }
                    ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>'Canceled inventory <b>#'.prefixof(company($myid),$inid).serial(company($myid),$inid).'</b> restored.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];

            add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
            $session->setFlashdata('pu_msg', 'Invoice restored');
            return redirect()->to(base_url('invoices/details').'/'.$inid);
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed to delete!');
            return redirect()->to(base_url('invoices/details').'/'.$inid);
        }
    }else{
        return redirect()->to(base_url('users/login'));
    }
}



public function pay($cusval=""){

    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;
    $PaymentsModel=new PaymentsModel;

    $myid=session()->get('id');

    $user=$UserModel->where('id',$myid)->first();

    if ($session->has('isLoggedIn')){
        if ($cusval) {

            $PaymentsModel->where('deleted',0);
            $PaymentsModel->orderBy('id','desc');
            $allpayments = $PaymentsModel->where('company_id',company($myid))->where('invoice_id',$cusval)->findAll();


            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            if (check_permission($myid,'manage_sales')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $ind=$InvoiceModel->where('id',$cusval)->first();
            $data = [
                'title' => 'Aitsun ERP-Pay Due',
                'invoice_id'=>$cusval,
                'user'=>$user,
                'allpayments' => $allpayments,
                'data_count' => count($allpayments),
                'invoice_data'=>$ind
            ];


            echo view('header',$data);
            echo view('payments/pay', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('invoices'));
        }

    }else{
        return redirect()->to(base_url('users/login'));
    }

}

public function update_pay(){

    $session=session();

    if ($session->has('isLoggedIn')){

        $UserModel=new Main_item_party_table;
        $InvoiceModel=new InvoiceModel;
        $PaymentsModel=new PaymentsModel;

        $myid=session()->get('id');

        $user=$UserModel->where('id',$myid)->first();


        if (isset($_POST['payment_type'])) {


            $payeeamou=0;
            $payeeamou=$_POST['cash_amount'];

            $invoice=strip_tags($_POST['invoice']);

            if ($payeeamou<=due_amount_of_invoice(company($myid),$_POST['invoice'])) {
                $payment_type=strip_tags($_POST['payment_type']);

                $customer=strip_tags($_POST['customer']);

                $invoice=strip_tags($_POST['invoice']);
                $payment_note=strip_tags($_POST['payment_note']);
                $billtype=strip_tags($_POST['biltype']);
                $total=strip_tags($_POST['total']);


                if($billtype=='sales') {
                    $billtype_for_pay='sales';
                }elseif($billtype=='purchase') {
                    $billtype_for_pay='purchase';
                }elseif($billtype=='sales_return') {
                    $billtype_for_pay='sale return';
                }elseif($billtype=='purchase_return') {
                    $billtype_for_pay='purchase return';
                }else{
                    $billtype_for_pay='';
                }



                $ro_amt=0;
                $check_nomber='';
                $check_date='';
                $payment_id=receipt_no_generate(5);



                $ro_amt=$_POST['cash_amount'];
                $id_payment_id=add_payment($invoice,$payment_type,$_POST['cash_amount'],'---',$customer,$_POST['alternate_name'],$payment_note,now_time($myid),$payment_id,company($myid),$billtype_for_pay);
                $new_paid_amount=$_POST['cash_amount']+paid_amount($invoice);

                if ($new_paid_amount<$total) {
                    $paid_status='unpaid';
                }else{
                    $paid_status='paid';
                }



                    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New Payment <b>'.$payment_id.'</b> is added.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                $pay_qry=update_paid_amount($invoice,$new_paid_amount,$paid_status);

                if ($pay_qry) { 
                    ?>



                    <?php if ( get_setting(company($myid),'receipt_template')==1): ?>
                      <?php  receipt_show($id_payment_id,company($myid),$myid,'sales',$customer,$_POST['alternate_name'],$payment_type,$ro_amt,$payment_note,account_name_of_cus($customer,company($myid)),now_time($myid)); ?>
                  <?php elseif ( get_setting(company($user['id']),'receipt_template')==2): ?>

                    <?php  receipt_show1($id_payment_id,company($myid),$myid,'sales',$customer,$_POST['alternate_name'],$payment_type,$ro_amt,$payment_note,account_name_of_cus($customer,company($myid)),now_time($myid)); ?>
                <?php endif; ?>


                <?php
            }

        }else{
            echo 'morethandue';

        }


    }

}else{
    return redirect()->to(base_url('users/login'));
}
}


public function pdf($cusval=""){
    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;

    if ($session->has('isLoggedIn')){

        if ($cusval) {
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first(); 

            $invoice_data=$InvoiceModel->where('id',$cusval)->first();;
            $data = [
                'title' => 'Aitsun ERP-Invoice Details',
                'invoice_id'=>$cusval,
                'user'=>$user,
                'invoice_data'=>$invoice_data
            ];


            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 0,
                'margin_bottom' => 0,
            ]);


            $pdfname='';

            if ($invoice_data['customer']=='CASH'):
                $pdfname.='CASH CUSTOMER';
            else:
                $pdfname.=user_name($invoice_data['customer']);
            endif;

            $pdfname.='-#'.get_setting(company($myid),'invoice_prefix'); 

            if ($invoice_data['invoice_type']=='sales'): 
             $pdfname.=get_setting(company($myid),'sales_prefix'); 
         elseif ($invoice_data['invoice_type']=='purchase'): 
             $pdfname.=get_setting(company($myid),'purchase_prefix'); 
         elseif ($invoice_data['invoice_type']=='sales_order'): 
             $pdfname.=get_setting(company($myid),'sales_order_prefix'); 
         elseif ($invoice_data['invoice_type']=='sales_quotation'): 
             $pdfname.=get_setting(company($myid),'sales_quotation_prefix'); 
         elseif ($invoice_data['invoice_type']=='sales_return'): 
             $pdfname.=get_setting(company($myid),'sales_return_prefix'); 
         elseif ($invoice_data['invoice_type']=='sales_delivery_note'): 
             $pdfname.=get_setting(company($myid),'sales_delivery_prefix'); 
         elseif ($invoice_data['invoice_type']=='purchase_order'): 
          $pdfname.=get_setting(company($myid),'purchase_order_prefix'); 
      elseif ($invoice_data['invoice_type']=='purchase_quotation'): 
         $pdfname.=get_setting(company($myid),'purchase_quotation_prefix'); 
     elseif ($invoice_data['invoice_type']=='purchase_return'): 
         $pdfname.=get_setting(company($myid),'purchase_return_prefix'); 
     elseif ($invoice_data['invoice_type']=='purchase_delivery_note'): 
         $pdfname.=get_setting(company($myid),'purchase_delivery_prefix'); 
     else: 
     endif; 


     $pdfname.=$invoice_data['serial_no'];



     $html = view('invoices/invoice_show_pdf',$data);
     $mpdf->WriteHTML($html);
     $mpdf->Output($pdfname.'.pdf','I');

                        //for view pdf in web page
                        // header("Content-type:application/pdf");
                        // header("Content-Disposition:attachment;filename='downloaded.pdf'");
                        // readfile($mpdf->Output($pdfname.'.pdf','I'));


 }else{
    return redirect()->to(base_url('invoices'));
}

}else{
    return redirect()->to(base_url('users/login'));
}

}






public function convert_invoice($cusval=""){
   $session=session();
   $myid=session()->get('id');
   $InvoiceModel=new InvoiceModel;
   $PaymentsModel=new PaymentsModel;
   $InstallmentsModel=new InstallmentsModel;

   $intype=''; 
   $intype=invoice_data($cusval,'invoice_type');

   $udt=[
    'converted'=>1
];
$InvoiceModel->update($cusval,$udt);  

if ($intype=='proforma_invoice') {
   $inss=$PaymentsModel->where('invoice_id',$cusval)->findAll();
   foreach ($inss as $pid) { 
    $inid=$pid['id'];

    $deledata=[
        'deleted'=>1,
        'edit_effected'=>0 
    ];

    $del=$PaymentsModel->update($inid,$deledata);

    if ($del) {
        $rec_amt=get_payment_data($inid,'amount');
        $old_paid_amount=invoice_data($cusval,'paid_amount');
        $old_due_amount=invoice_data($cusval,'due_amount');

        $paid_amount=$old_paid_amount-$rec_amt;
        $due_amount=$old_due_amount+$rec_amt;
                                        /////////////// RESET INVOICE DATA/////////////////////
        $resindata=[
            'paid_amount'=>$paid_amount,
            'due_amount'=>$due_amount,
            'paid_status'=>'unpaid',
        ];
        $InvoiceModel->update($cusval,$resindata);
                                        /////////////// RESET INVOICE DATA/////////////////////







        if (get_payment_data($inid,'install_id')!='') {

            $inex=explode(',', get_payment_data($inid,'install_id'));
            foreach ($inex as $iex) {
                if (trim($iex)!='') {
                    $indsata=[
                        'paid_status'=>'unpaid'
                    ];
                    $InstallmentsModel->update($iex,$indsata);
                }
            }

        }




                                    ////////////////////////CREATE ACTIVITY LOG//////////////
        $log_data=[
            'user_id'=>$myid,
            'action'=>'Payment <b>#'.$inid.'</b> is deleted.',
            'ip'=>get_client_ip(),
            'mac'=>GetMAC(),
            'created_at'=>now_time($myid),
            'updated_at'=>now_time($myid),
            'company_id'=>company($myid),
        ];

        add_log($log_data);
                                    ////////////////////////END ACTIVITY LOG/////////////////
    }

}
}
}




public function download($cusval=""){
    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;



    if ($cusval) {

        $ind=$InvoiceModel->where('id',$cusval);

        $inrow=$ind->first();

        $myid=$inrow['customer'];
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();




                            // if ($inrow['deleted']==1) {
                            //     return redirect()->to(base_url('invoices'));
                            // }

        $data = [
            'title' => 'Aitsun ERP-Invoice Details',
            'invoice_id'=>$cusval,
            'user'=>$user,
            'invoice_data'=>$inrow
        ];


                            // echo view('header',$data);
        echo view('invoices/invoice_download', $data);
                            // echo view('footer');
    }else{

    }



}

public function generate_short_link($inid=''){
    $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;



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


    $url = 'https://aitsun.com/link/create';
    $data = array('link_to_short' => base_url('invoices/download').'/'.$inid);

    $query = http_build_query($data);
    $ch    = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);     

    $response = curl_exec($ch);
    curl_close($ch);



    if(invoice_data($inid,'customer') == 'CASH'){
        $username='CASH CUSTOMER';
    }else{ 
        $username=user_name(invoice_data($inid,'customer'));
    }

    $resp_ar=json_decode($response,true);

    if ($resp_ar['short_link']) {


     echo 'https://api.whatsapp.com/send?phone='.str_replace('+','',user_country_code(invoice_data($inid,'customer'))).''.user_phone(invoice_data($inid,'customer')).'&text=Dear '.$username.',%0D%0A %0D%0AWe at '.my_company_name(invoice_data($inid,'company_id')).' truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.%0D%0A %0D%0AAmount: '.currency_symbol2(company($myid)).' '. aitsun_round(invoice_data($inid,'total')).'%0D%0ADue Amount: '.currency_symbol2(company($myid)).' '.aitsun_round(invoice_data($inid,'due_amount')).'%0D%0ADownload link:%0D%0A'.urlencode('https://aitsun.com/sl/'.$resp_ar['short_link']).'%0D%0A %0D%0AThanks %26 Regards %0D%0A'.my_company_name(invoice_data($inid,'company_id'));

 }else{
    echo 'failed';
}




}



public function reposnible_person($billid=""){
    $session=session();
    $InvoiceModel=new InvoiceModel;

    if ($this->request->getMethod('post')) {

        $clientdata=[

            'responsible_person'=>$_POST['responsible_person'],

        ];

        if ($InvoiceModel->update($billid,$clientdata)) {
          echo 1;

      }else{
         echo 0;
     }

 }
}


public function due_date($billid=""){
    $session=session();
    $InvoiceModel=new InvoiceModel;

    if ($this->request->getMethod('post')) {

        $clientdata=[


            'due_date'=>$_POST['due_date']
        ];

        if ($InvoiceModel->update($billid,$clientdata)) {
          echo 1;

      }else{
         echo 0;
     }

 }
}


public function get_pos_invoice($cusval=""){
         $session=session();
    $UserModel=new Main_item_party_table;
    $InvoiceModel=new InvoiceModel;


    $last_height=0;

    $myid=session()->get('id');
    $user=$UserModel->where('id',$myid)->first();


    if ($cusval) {

        $invoice_data=$InvoiceModel->where('id',$cusval)->first();
        if ($invoice_data) { 

         

            $filename="uknown file.pdf";
            $cusname="CASH CUSTOMER";

            if ($invoice_data['customer']!='CASH'){
              $cusname=user_name($invoice_data['customer']);
          }elseif ($invoice_data['alternate_name']!=''){
              $cusname= $invoice_data['alternate_name'];
          } 



          $filename=inventory_heading($invoice_data['company_id'],$invoice_data['invoice_type']).' - '.$cusname.' - '.inventory_prefix($invoice_data['company_id'],$invoice_data['invoice_type']).$invoice_data['serial_no'].'.pdf';


          $data = [
            'title' => $filename,
            'invoice_id'=>$cusval,
            'user'=>$user,
            'invoice_data'=>$invoice_data,  
        ];




        echo  view('invoices/invoice_templates/pos_invoice', $data);


    }else{
                    // return redirect()->to(base_url('invoices'));
    } 
}
}




}
