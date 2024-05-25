<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\InvoiceitemsModel;
use App\Models\ProductsModel;
use App\Models\FinancialYears;
use App\Models\PaymentsModel;
use App\Models\LeadModel;
use App\Models\FollowersModel;
use App\Models\ActivitiesNotes;
use App\Models\AccountingModel;
use App\Models\Companies;
use App\Models\InvoiceTaxes;
use App\Models\MainCompanies;
use App\Models\AttendanceAllowedList;
use App\Models\TestModel;
use App\Models\PayrollitemsModel; 
use App\Models\CustomerBalances;
use App\Models\TempStockadjustmodel;


use App\Libraries\PdfLibrary;
use App\Libraries\ConceptOdoo;

use Stripe;


class Testing extends BaseController
{
    public function index()
    {
        $session=session();
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id'); 
            $ntt=now_time($myid);

            if ($file = $this->request->getFile('fileURL')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $originalName = $file->getName();
                    $newName = $file->getName();

                    $destinationDirectory = 'public/csvfile';
                    $destinationPath = $destinationDirectory . '/' . $newName;
 
                    if (file_exists($destinationPath)) { 
                        unlink($destinationPath);
                    }

                    $file->move($destinationDirectory, $newName); 

                    // Load the Excel file
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("public/csvfile/".$newName);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                    $old_file_name='';
                    if (isset($_SESSION['file_name'])) {
                        $old_file_name=$_SESSION['file_name'];
                    }


                    $row_limit=5;
                    $row_count=0;
                    $temp_row_count=0;
                    $starting_row=1;
                    $file_name=$newName;
                    $_SESSION['file_name']=$newName;



                    $total_rows=count($sheetData)-1;
                    $last_key = array_key_last($sheetData);
                    // unset($_SESSION['starting_row']);
                    if (isset($_SESSION['starting_row'])) {
                        $starting_row=$_SESSION['starting_row'];
                        $temp_row_count=$starting_row;
                        // echo   $total_rows.'<br>';
                    }
                    // echo $starting_row.'<br>';
                    

                    if ($old_file_name!=$_SESSION['file_name']) {
                        $starting_row=1;
                        if (isset($_SESSION['starting_row'])) {
                            unset($_SESSION['starting_row']);
                        }
                        
                    } 

                    foreach ($sheetData as $row => $data) {
                        if ($row > $starting_row) {
                            if ($row>1) {

                                if ($row_count<$row_limit) {
                                    $display_name = $data['A'];
                                    echo $display_name.'<br>';
                                     $row_count++; 
                                      $starting_row=$starting_row+1;
                                      $temp_row_count++;
                                     $_SESSION['starting_row']=$starting_row; 
                                }else{ 
                                     $_SESSION['starting_row']=$starting_row;

                                }


                            }

                            if ($total_rows <= $temp_row_count) { 
                                unset($_SESSION['starting_row']);
                            }
                            
                        }
                    }
                }
            }
 

 

            echo view('testing');
            // echo $_SESSION['last_filename']."<br>";
            // echo $_SESSION['last_row']."<br>";

            // //???????/////////////Odoo///////////////////////

            // $ConceptOdoo=new ConceptOdoo;
            
            // //Personal
            // // $url = 'https://exevor.odoo.com';
            // // $db = 'exevor';
            // // $username = "rajbharath533@gmail.com";
            // // $password ='11111111';
            // // $uid=2;
            // // $project_id=1;

            // // Company
            // $url = 'https://erp.ctechoman.com';
            // $db = 'concept';
            // $username = "bharath@conceptgrps.com";
            // $password ='ConceptGroup@2024';
            // $uid=6;
            // $project_id=31;


            // $odoo_data=[ 
            //     'name'=>'Ganesh Kumar',
            //     'email'=>'ganesh@gmail.com',
            //     'subject'=>'Need internet rooter',
            //     'phone'=>'556698558',
            //     'company'=>'Exevor Solutions',
            //     'message'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',  
            //     'document_path'=>base_url('public/uploads/users/profile_av_female.png'),
            //     'document_name'=>'profile_av_female.png',
            //     'enquiry_type'=>'service',
            //     'project_id'=>$project_id
            // ];

            // $odoostatus=$ConceptOdoo->add_data($url,$db,$username,$password,$uid,$odoo_data);
            // echo $odoostatus;
  
            //???????/////////////Odoo///////////////////////

            // $TempStockadjustmodel=new TempStockadjustmodel;
            // $InvoiceitemsModel=new InvoiceitemsModel;
            // $ProductsModel=new Main_item_party_table;
            // $AccountingModel=new AccountingModel;

            // $all_stocks=$AccountingModel->where('company_id',company($myid))->where('type','stock')->findAll();

            // foreach ($all_stocks as $as) {
            //     $pds=[
            //         'stock'=>$as['opening_balance'],
            //         'at_price'=>get_products_data($as['customer_id'],'purchased_price'),
            //         'ready_to_update'=>1
            //     ];
            //     $ProductsModel->update($as['customer_id'],$pds);
            // }

            // foreach ($TempStockadjustmodel->findAll() as $sa) {
            //     $in_type='';
            //     if ($sa['adjust_type']=='add') {
            //         $in_type='purchase';
            //     }else{
            //         $in_type='sales';
            //     }

            //     $in_item=[  
            //         'product_id'=>$sa['product_id'],
            //         'quantity'=> $sa['qty'],
            //         'price'=>$sa['at_price'], 
            //         'amount'=>$sa['amount'], 
            //         'type'=>'single', 
            //         'invoice_date'=>$sa['datetime'],   
            //         'unit'=>$sa['unit'],
            //         'sub_unit'=>$sa['sub_unit'],
            //         'conversion_unit_rate'=>$sa['conversion_unit_rate'],
            //         'in_unit'=>$sa['in_unit'],
            //         'invoice_type'=>$in_type, 
            //         'purchased_price'=>$sa['at_price'],
            //         'purchased_amount'=>$sa['at_price']*$sa['qty'],
            //         'entry_type'=>'adjust',
            //         'company_id'=>$sa['company_id']
            //     ];

            //     $InvoiceitemsModel->save($in_item);
            // }
         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    } 

    public function price_counting(){
        $ProductsModel=new Main_item_party_table;
        $products=[];
        if ($_GET) {
            if (isset($_GET['product_name'])) {
                $keywords = explode(' ', $_GET['product_name']);
                 

                // Start building the WHERE clause
                $whereClause = '';

                foreach ($keywords as $keyword) {
                    // Add wildcard before and after each keyword
                    $whereClause .= "product_name LIKE '%$keyword%' AND ";
                }

                // Remove the trailing 'AND'
                $whereClause = rtrim($whereClause, ' AND ');

                // Perform the search
                $products = $ProductsModel->where($whereClause)->findAll();

                // Output the results
                foreach ($products as $product) {
                    echo $product['product_name'] . "<br>";
                }
            }
        }
        
       

    }

    public function total_working_days(){
        
        // $first_date='2023-08-01';
        // $last_date='2023-08-11';
        
        echo getAllWeekOffsOfMonth(10,'2023','08','Sun','2,4');


// echo user_token();
            // echo session()->get('user_token');

             // transfer_accounting_heads(company($myid),last_financial_year('id',company($myid)),activated_year(company($myid)));

//  function generateBinaryPatterns($pattern, $length, &$patterns) {
//     if (strlen($pattern) == $length) {
//         $patterns[] = $pattern;
//         return;
//     }

//     generateBinaryPatterns($pattern . '0', $length, $patterns);
//     generateBinaryPatterns($pattern . '1', $length, $patterns);
// }

// // Example: Generate binary patterns for length 10
// $length = 10;
// $binaryPatterns = [];
// generateBinaryPatterns('', $length, $binaryPatterns);

// // Display generated binary patterns
// $n=0;
// foreach ($binaryPatterns as $pattern) { $n++;
//     echo $n.'-'.$pattern .'<br>'. PHP_EOL;
// }


            
// function generateBinaryPatterns($pattern, $length, &$patterns) {
//     if (strlen($pattern) == $length) {
//         $patterns[] = $pattern;
//         return;
//     }

//     generateBinaryPatterns($pattern . '0', $length, $patterns);
//     generateBinaryPatterns($pattern . '1', $length, $patterns);
// }

// // Example: Generate binary patterns for length 10
// $length = 10;
// $binaryPatterns = [];
// generateBinaryPatterns('', $length, $binaryPatterns);

// // Open a file for writing
// $file = fopen('binary_patterns.csv', 'w');

// // Write the patterns to the CSV file
// foreach ($binaryPatterns as $pattern) {
//     fputcsv($file, str_split($pattern));
// }

// // Close the file
// fclose($file);

// echo "CSV file generated successfully: binary_patterns.csv\n";

//             $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=Y9gztp6vla0Z1HbXrmA2ei7LKhnMqCfQojs8RuwFcEySVO3kxGQAhf3c7ubGxL60P9EZOJlv8BtUjYRF&variables_values=5599&route=otp&numbers=".urlencode('8943868855'),
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_SSL_VERIFYHOST => 0,
//   CURLOPT_SSL_VERIFYPEER => 0,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => array(
//     "cache-control: no-cache"
//   ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }


    }


    public function _remove_invoice_item_fees_id_update(){

        $PaymentsModel = new PaymentsModel(); 

        $company_id=0; 

    

            $in_items=$PaymentsModel->findAll();

            $in_sl=0;

            foreach ($in_items as $iit) {
                 
                    $in_data=[ 
                        'fees_id'=>invoice_data($iit['invoice_id'],'fees_id'),
                    ];

                    if ($PaymentsModel->update($iit['id'],$in_data)) {
                        $in_sl++;
                        echo $in_sl.' payments done <br>';
                    }else{
                        $in_sl++;
                        echo $in_sl.' payments <b>failed</b> <br>';
                    } 
                
                
            }
        
    }



    public function _remove_invoice_item_reset(){

        $InvoiceModel = new InvoiceModel();
        $InvoiceitemsModel = new InvoiceitemsModel();

        $company_id=0; 

        $all_invoices=$InvoiceModel->where('company_id',$company_id)->findAll();
        $in_sl=0;
        foreach ($all_invoices as $in) {

            $in_items=$InvoiceitemsModel->where('invoice_id',$in['id'])->where('product_method','')->findAll();

            foreach ($in_items as $iit) {
                

                if (trim($iit['product_method'])=='') {
                    $in_data=[
                        'product_method'=>'product',
                        'deleted'=>3,
                    ];
                    if ($InvoiceitemsModel->update($iit['id'],$in_data)) {
                        $in_sl++;
                        echo $in_sl.' invoice done <br>';
                    }else{
                        $in_sl++;
                        echo $in_sl.' invoice <b>failed</b> <br>';
                    }
                }
                
                
            }
            
        }
    }

    public function _remove_reset_accounts(){

        $UserModel = new Main_item_party_table();
        $InvoiceModel = new InvoiceModel();
        $ProductsModel = new Main_item_party_table();
        $PaymentsModel = new PaymentsModel();
        $AccountingModel = new AccountingModel();
        $PayrollitemsModel = new PayrollitemsModel();

        $company_id=28;

        //reset all accounts
        echo '<h2>Accounts reset</h2> <br>';
        $all_accounts=$AccountingModel->where('company_id',$company_id)->findAll();
        $aa_sl=0;
        foreach ($all_accounts as $aa) {
            $aa_data=[
                'opening_balance'=>0,
                'closing_balance'=>0
            ];
            
            if ($AccountingModel->update($aa['id'],$aa_data)) {
                $aa_sl++;
                echo $aa_sl.' accounts done <br>';
            }else{
                $aa_sl++;
                echo $aa_sl.' accounts <b>failed</b> <br>';
            }
        }



        //reset all customers
        echo '<h2>Customers reset</h2> <br>';
        $all_customers=$UserModel->where('company_id',$company_id)->findAll();
        $cs_sl=0;
        foreach ($all_customers as $cs) {
            $cs_data=[
                'effected'=>0,
                'edit_effected'=>0
            ];
            
            if ($UserModel->update($cs['id'],$cs_data)) {
                $cs_sl++;
                echo $cs_sl.' customer done <br>';
            }else{
                $cs_sl++;
                echo $cs_sl.' customer <b>failed</b> <br>';
            }
        }



        //reset all products
        echo '<h2>Products reset</h2> <br>';
        $all_products=$ProductsModel->where('company_id',$company_id)->findAll();
        $pd_sl=0;
        foreach ($all_products as $pd) {
            $pd_data=[
                'effected'=>0,
                'edit_effected'=>0
            ];
            
            if ($ProductsModel->update($pd['id'],$pd_data)) {
                $pd_sl++;
                echo $pd_sl.' product done <br>';
            }else{
                $pd_sl++;
                echo $pd_sl.' product <b>failed</b> <br>';
            }
        }



        //reset all invoices
        echo '<h2>Invoices reset</h2> <br>';
        $all_invoices=$InvoiceModel->where('company_id',$company_id)->where('deleted',0)->findAll();
        $in_sl=0;
        foreach ($all_invoices as $in) {
            $in_data=[
                'effected'=>0,
                'edit_effected'=>0
            ];
            
            if ($InvoiceModel->update($in['id'],$in_data)) {
                $in_sl++;
                echo $in_sl.' invoice done <br>';
            }else{
                $in_sl++;
                echo $in_sl.' invoice <b>failed</b> <br>';
            }
        }


        //reset all payments
        echo '<h2>Payments reset</h2> <br>';
        $all_payments=$PaymentsModel->where('company_id',$company_id)->where('deleted',0)->findAll();
        $pm_sl=0;
        foreach ($all_payments as $pm) {
            $pm_data=[
                'effected'=>0,
                'edit_effected'=>0
            ];
            
            if ($PaymentsModel->update($pm['id'],$pm_data)) {
                $pm_sl++;
                echo $pm_sl.' payment done <br>';
            }else{
                $pm_sl++;
                echo $pm_sl.' payment <b>failed</b> <br>';
            }
        }


        //reset all payroll items reset
        echo '<h2>Payroll items reset</h2> <br>';
        $all_payroll_items=$PayrollitemsModel->where('company_id',$company_id)->findAll();
        $pri_sl=0;
        foreach ($all_payroll_items as $pri) {
            $pri_data=[
                'effected'=>0,
                'edit_effected'=>0
            ];
            
            if ($PayrollitemsModel->update($pri['id'],$pri_data)) {
                $pri_sl++;
                echo $pri_sl.' payroll item done <br>';
            }else{
                $pri_sl++;
                echo $pri_sl.' payroll item <b>failed</b> <br>';
            }
        }




    }
 
    public function send_sms_oman(){ 
        // $InvoiceModel=new InvoiceModel;
        // $InvoiceitemsModel=new InvoiceitemsModel;

        // foreach ($InvoiceModel->findAll() as $invoice) {
        //         $all_items=$InvoiceitemsModel->where('invoice_id',$invoice['id'])->findAll();
        //         foreach ($all_items as $ai) {
        //                 $indata=['invoice_date'=>$invoice['invoice_date']];
        //                 $InvoiceitemsModel->update($ai['id'],$indata);
        //         }
                
        // }

    //     $PaymentsModel=new PaymentsModel;

    //   $data=[
    //     [
    //         'id'=>6725,
    //         'date'=>'2023-03-31 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'

    //     ],

    //     [
    //         'id'=>6727,
    //         'date'=>'2023-03-31 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6728,
    //         'date'=>'2023-03-31 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6730,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6731,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6733,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6734,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6736,
    //         'date'=>'2023-03-31 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6737,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6738,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-05 00:00:00'
    //     ],
    //             [
    //         'id'=>6813,
    //         'date'=>'2023-03-22 00:00:00',
    //         'new_date'=>'2023-04-08 00:00:00'
    //     ],
    //             [
    //         'id'=>7012,
    //         'date'=>'2023-03-16 00:00:00',
    //         'new_date'=>'2023-04-19 00:00:00'
    //     ],
    //             [
    //         'id'=>7020,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7021,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7022,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7023,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7024,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7025,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7026,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7027,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7028,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7029,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7030,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7031,
    //         'date'=>'2023-02-07 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7032,
    //         'date'=>'2023-03-09 00:00:00',
    //         'new_date'=>'2023-04-20 00:00:00'
    //     ],
    //             [
    //         'id'=>7085,
    //         'date'=>'2023-02-04 00:00:00',
    //         'new_date'=>'2023-05-03 00:00:00'
    //     ],
    //             [
    //         'id'=>9016,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9017,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9018,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9019,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9020,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9021,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9022,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9023,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9026,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9029,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9030,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9031,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9032,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9034,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9038,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9039,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9041,
    //         'date'=>'2023-03-30 00:00:00',
    //         'new_date'=>'2023-06-17 00:00:00'
    //     ],
    //             [
    //         'id'=>9645,
    //         'date'=>'2022-08-10 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>9646,
    //         'date'=>'2022-08-10 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>9647,
    //         'date'=>'2022-11-10 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>9648,
    //         'date'=>'2022-02-28 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>9649,
    //         'date'=>'2022-12-10 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>9650,
    //         'date'=>'2022-11-11 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>9651,
    //         'date'=>'2023-03-28 00:00:00',
    //         'new_date'=>'2023-06-27 00:00:00'
    //     ],
    //             [
    //         'id'=>10054,
    //         'date'=>'2023-03-07 00:00:00',
    //         'new_date'=>'2023-07-03 00:00:00'
    //     ],
    //             [
    //         'id'=>10636,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10637,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10638,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10639,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10640,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10641,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10642,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10643,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10644,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10645,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10646,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10647,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10648,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10649,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10650,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10651,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10652,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10653,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10654,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10655,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10656,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10657,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10658,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10659,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10660,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10661,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10662,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10663,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10664,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10665,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10666,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10667,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10668,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10669,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10670,
    //         'date'=>'2023-02-14 00:00:00',
    //         'new_date'=>'2023-07-12 00:00:00'
    //     ],
    //             [
    //         'id'=>10672,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10673,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10674,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10675,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10676,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10677,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10678,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10679,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10680,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10681,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10682,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10683,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10684,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10688,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10689,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10691,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10692,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10693,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10694,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10695,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10696,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10698,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10699,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10700,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10701,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10702,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10703,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10704,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10705,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10706,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>10707,
    //         'date'=>'2023-03-14 00:00:00',
    //         'new_date'=>'2023-07-14 00:00:00'
    //     ],
    //             [
    //         'id'=>11282,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11283,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11284,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11285,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11286,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11287,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11288,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11289,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11290,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11291,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11292,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11293,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11294,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11295,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11296,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11297,
    //         'date'=>'2023-02-21 00:00:00',
    //         'new_date'=>'2023-07-21 00:00:00'
    //     ],
    //             [
    //         'id'=>11391,
    //         'date'=>'2023-03-22 00:00:00',
    //         'new_date'=>'2023-07-22 00:00:00'
    //     ],
            

    // ];

    // $sl=0;
    // foreach ($data as $pd) {
        
    //     $pd_data=[
    //         // 'datetime'=>$pd['date']
    //         'datetime'=>$pd['new_date']
    //     ];
    //     if ($PaymentsModel->update($pd['id'],$pd_data)) {
    //         $sl++;
    //         echo $sl.'--'.$pd['id'].'<br>';
    //     }
    // }


        

       //  $employee_category  = user_data(5894,'employee_category'); 
        
       // $total_working_hours=employee_category_data($employee_category,'total_working_hour');
       //  $hours_to_full_day=employee_category_data($employee_category,'full_day_hour');
       //  $hours_to_half_day=employee_category_data($employee_category,'half_day_hour');
       //  echo $hours_to_full_day;
       //  echo "<br>";
       //  echo $hours_to_half_day;
        // $overtime_hours=0;
        // $worked_hours=12.10;
        // $total_working_hours=8;

        // $overtime_hours=$worked_hours-$total_working_hours;
        // echo $overtime_hours;
        
        // $came_time=get_date_format('9:35:00','h:i:s');
        // $start=get_date_format('09:00:00','h:i:s'); 

        // if ($came_time<$start) {
        //     echo "Bega batuda";
        // }else{
        //     echo "bvc late";
        // }

         

        // $age = date_diff(date_create('2023-07-13 09:06:44'), date_create('2023-07-13 11:37:44'));
        // echo $age->format("%h.%i");

        // https://ndssms.com/user/smspush.aspx?username=concept&password=concept123&phoneno=79903941&message=hi&sender=1&source=TEST
        //   $text_Message = 'Hi I am Bharathraj';
        //   $this->user->send_sms('Bharathraj','97832821',$text_Message,1,date('Y-m-d H:i:s'),1,'Concept'); 
        // echo number_format('2583.50',2,'.','');
        // $otp=12544;
        // $text_Message = 'Hello Suraj, Your OTP is: ' .$otp.' Thank you for picking the Concept Technologies LLC!';
        // $text_Message="hello";
        // echo send_sms_oman('ConceptTech','79903941',$text_Message,1,date('Y-m-d H:i:s'),1,'Concept');

        // set post fields
      

        

        // try{
        //     $soapclient = new \SoapClient("https://ndssms.com/User/bulkpush.asmx?wsdl");
        //     $param = array(
        //         'UserName'=>'concept',
        //         'Password'=>'concept123',
        //         'Message'=>$Message,
        //         'Priority'=>$Priority,
        //         'Schdate'=>$Schdate,
        //         'Sender'=>$Sender,
        //         'AppID'=>$AppID,
        //         'SourceRef'=>$SourceRef,
        //         'MSISDNs'=>$MSISDNs
        //     );
        //     $response =$soapclient->SendSMS($param);
        // }catch(Exception $e){
        //     echo $e->getMessage();
        // }  
        

        // $myid=session()->get('id');
        // $company_id=company($myid);
        // $financial_year=activated_year($company_id);


        // $AccountingModel=new AccountingModel;
        // $CustomerBalances=new CustomerBalances;

        // $primary_group_heads=array(
        //     array(
        //         'group_head'=>'Direct Expenses',
        //         'primary'=>'1',
        //         'type'=>'group_head',
        //         'nature'=>'expenses',
        //         'default'=>'1',
        //         'childs'=>array(
        //             array(
        //                 'group_head'=>'Fuel Charges', 
        //                 'type'=>'ledger',
        //                 'transport_charge'=>'1', 
        //                 'default'=>'1',
        //             ),
        //             array(
        //                 'group_head'=>'Service Charges', 
        //                 'type'=>'ledger',
        //                 'transport_charge'=>'1', 
        //                 'default'=>'1',
        //             ),
        //             array(
        //                 'group_head'=>'Vehicle Insurance', 
        //                 'type'=>'ledger',
        //                 'transport_charge'=>'1', 
        //                 'default'=>'1',
        //             ),
        //             array(
        //                 'group_head'=>'Other vehicle expenses', 
        //                 'type'=>'ledger',
        //                 'transport_charge'=>'1', 
        //                 'default'=>'1',
        //             )
        //         )
        //     )
        // );

        // $parent_id=id_of_group_head($company_id,$financial_year,'Direct Expenses');

        // foreach ($primary_group_heads as $gh) { 

            
  

        //      foreach ($gh['childs'] as $child) {
        //         $ac_child_data=[
        //             'company_id'=>$company_id,
        //             'financial_year'=>$financial_year,
        //             'group_head'=>$child['group_head'], 
        //             'type'=>$child['type'],  
        //             'transport_charge'=>$child['transport_charge'],
        //             'default'=>$child['default'], 
        //             'parent_id'=>$parent_id
        //         ]; 
        //         $AccountingModel->save($ac_child_data);
        //         $parent_of_parent_id=$AccountingModel->insertID(); 

        //         if ($child['type']=='ledger') {

        //             ////////ADDING OPENING BALANCE/////////////////
        //             $op_data=[
        //                 'company_id'=>$company_id,
        //                 'financial_year'=>$financial_year,
        //                 'opening_balance'=>0,
        //                 'closing_balance'=>0,
        //                 'opening_type'=>opening_type_of($child['group_head']),
        //                 'closing_type'=>'',
        //                 'customer_id'=>$parent_of_parent_id,
        //                 'type'=>'ledger'
        //             ];
        //             $CustomerBalances->save($op_data);
        //             ////////ADDING OPENING BALANCE/////////////////
        //         }

        //             if (isset($child['sub_childs'])) {
        //                 foreach ($child['sub_childs'] as $child_ch) {
        //                     $ac_child_of_child_data=[
        //                         'company_id'=>$company_id,
        //                         'financial_year'=>$financial_year,
        //                         'group_head'=>$child_ch['group_head'], 
        //                         'type'=>$child_ch['type'],  
        //                         'default'=>$child_ch['default'], 
        //                         'parent_id'=>$parent_of_parent_id
        //                     ]; 
        //                     $AccountingModel->save($ac_child_of_child_data);

        //                     $parent_of_child_parent_id=$AccountingModel->insertID(); 
                            
        //                     if ($child_ch['type']=='ledger') {
        //                         ////////ADDING OPENING BALANCE/////////////////
        //                         $op_data=[
        //                             'company_id'=>$company_id,
        //                             'financial_year'=>$financial_year,
        //                             'opening_balance'=>0,
        //                             'closing_balance'=>0,
        //                             'opening_type'=>opening_type_of($child_ch['group_head']),
        //                             'closing_type'=>'',
        //                             'customer_id'=>$parent_of_child_parent_id,
        //                             'type'=>'ledger'
        //                         ];
        //                         $CustomerBalances->save($op_data);
        //                         ////////ADDING OPENING BALANCE/////////////////
        //                     }

        //                  }
        //             }
                    

        //      }
        //  }


        

    }
 


}
