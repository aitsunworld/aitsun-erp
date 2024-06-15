<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProductsModel;
use App\Models\StockModel;
use App\Models\ProductUnits;
use App\Models\ProductCategories;
use App\Models\ProductSubCategories;
use App\Models\SecondaryCategories;
use App\Models\ProductBrand;
use App\Models\ItemkitsModel;
use App\Models\Companies;
use App\Models\AccountingModel;
use App\Models\ClassModel;
use App\Models\Classtablemodel;
use App\Models\StudentcategoryModel; 


class Import_and_export extends BaseController
{
    public function index()
        {
            $session=session();
            $UserModel=new Main_item_party_table;

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
                   
                    $data = [
                        'title' => 'Aitsun ERP-Imports and Exports',
                        'user'=>$user,
                    ];

                    if (isset($_SESSION['starting_row'])) {
                        unset($_SESSION['starting_row']);
                    }
                    if (usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                    if (check_main_company($myid)==true) {
                        if (check_branch_of_main_company(company($myid))==true) {
                            if (usertype($myid)=='customer') {
                                return redirect()->to(base_url());
                            }else{
                                echo view('header',$data);
                                echo view('import_and_exports/import_and_exports', $data);
                                echo view('footer');
                            }
                        }else{
                             return redirect()->to(base_url('company'));
                        }
                        
                    }else{
                        return redirect()->to(base_url('company'));
                    }

                        

                }else{
                    return redirect()->to(base_url('users/login'));
                }
                
        }


        public function export() {
            $myid=session()->get('id');
            $ProductsModel=new Main_item_party_table;
            $session=session();

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
 

            // Set column headers
            $sheet->setCellValue('A1', 'Product Name');
            $sheet->setCellValue('B1', 'Unit');
            $sheet->setCellValue('C1', 'Sub Unit');
            $sheet->setCellValue('D1', 'Conversion Unit Rate');
            $sheet->setCellValue('E1', 'Opening Stock');
            $sheet->setCellValue('F1', 'Stock at price');
            $sheet->setCellValue('G1', 'Tax');
            $sheet->setCellValue('H1', 'MRP(optional)');
            $sheet->setCellValue('I1', 'Sale Margin(optional)');
            $sheet->setCellValue('J1', 'Purchase Margin(optional)');
            $sheet->setCellValue('K1', 'Sale Price');
            $sheet->setCellValue('L1', 'Sale Tax');
            $sheet->setCellValue('M1', 'Purchased Price');
            $sheet->setCellValue('N1', 'Purchase Tax');
            $sheet->setCellValue('O1', 'Description');
            $sheet->setCellValue('P1', 'Brand');
            $sheet->setCellValue('Q1', 'Category');
            $sheet->setCellValue('R1', 'Sub Category');
            $sheet->setCellValue('S1', 'Barcode');
            $sheet->setCellValue('T1', 'Type');
            $sheet->setCellValue('U1', 'Product Code');
            $sheet->setCellValue('V1', 'HSNC/GTIN/UPC/EAN/JAN/ISBN');
            $sheet->setCellValue('W1', 'Batch No');
            $sheet->setCellValue('X1', 'Bin Location');


            $products_info = $ProductsModel->where('company_id',company($myid))->where('product_type!=','fees')->where('main_type','product')->where('deleted',0)->findAll(); 

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

            $p_row = 2;
            foreach($products_info as $key=>$element) {
                $sale_tax='without';
                $purchase_tax='without';
                if ($element['sale_tax']==1) {
                    $sale_tax='with';
                }
                if ($element['purchase_tax']==1) {
                    $purchase_tax='with';
                }
                  
                $sheet->setCellValue('A'.$p_row, $element['product_name']);
                $sheet->setCellValue('B'.$p_row, name_of_unit($element['unit']));
                $sheet->setCellValue('C'.$p_row, name_of_subunit($element['sub_unit']));
                $sheet->setCellValue('D'.$p_row, $element['conversion_unit_rate']);
                $sheet->setCellValue('E'.$p_row, $element['stock']);
                $sheet->setCellValue('F'.$p_row, $element['at_price']);
                $sheet->setCellValue('G'.$p_row, percent_of_tax($element['tax']));
                $sheet->setCellValue('H'.$p_row, $element['mrp']);
                $sheet->setCellValue('I'.$p_row, $element['sale_margin']);
                $sheet->setCellValue('J'.$p_row, $element['purchase_margin'] );
                $sheet->setCellValue('K'.$p_row, $element['price']);
                $sheet->setCellValue('L'.$p_row, $sale_tax);
                $sheet->setCellValue('M'.$p_row, $element['purchased_price']);
                $sheet->setCellValue('N'.$p_row, $purchase_tax);
                $sheet->setCellValue('O'.$p_row, $element['description']);
                $sheet->setCellValue('P'.$p_row, name_of_brand($element['brand']));
                $sheet->setCellValue('Q'.$p_row, name_of_category($element['category']));
                $sheet->setCellValue('R'.$p_row, name_of_sub_category($element['sub_category']));
                $sheet->setCellValue('S'.$p_row, sprintf("\t%012d",$element['barcode']));
                $sheet->setCellValue('T'.$p_row, $element['product_method']);
                $sheet->setCellValue('U'.$p_row, $element['product_code']);
                $sheet->setCellValue('V'.$p_row, $element['pro_in']);
                $sheet->setCellValue('W'.$p_row, $element['batch_no']);
                $sheet->setCellValue('X'.$p_row, $element['bin_location']);

                $p_row++;
            }

   
            // validations
            $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
            $validationCriteria = [];
            foreach (products_units_array(company($myid)) as $pu){
                array_push($validationCriteria, $pu['value']);
            }
            $validation = $spreadsheet->getActiveSheet()->getCell('B2')->getDataValidation();
            $validation = $spreadsheet->getActiveSheet()->getCell('C2')->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setShowDropDown(true);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
            $validation->setPromptTitle('Pick from list');
            $validation->setPrompt('Please select a valid option.');
            $validation->setShowInputMessage(false); // Disable input 
            $sheet->setDataValidation('B2:B'.($p_row - 1), $validation);
            $sheet->setDataValidation('C2:C'.($p_row - 1), $validation);



            // validations
            $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
            $validationCriteria = ['product','service'];
             
            $validation = $spreadsheet->getActiveSheet()->getCell('T2')->getDataValidation(); 
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setShowDropDown(true);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
            $validation->setPromptTitle('Pick from list');
            $validation->setPrompt('Please select a valid option.');
            $validation->setShowInputMessage(false); // Disable input 
            $sheet->setDataValidation('T2:T'.($p_row - 1), $validation); 


             // validations
            $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
            $validationCriteria = ['with','without'];
             
            $validation = $spreadsheet->getActiveSheet()->getCell('L2')->getDataValidation(); 
            $validation = $spreadsheet->getActiveSheet()->getCell('N2')->getDataValidation(); 
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setShowDropDown(true);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
            $validation->setPromptTitle('Pick from list');
            $validation->setPrompt('Please select a valid option.');
            $validation->setShowInputMessage(false); // Disable input 
            $sheet->setDataValidation('L2:L'.($p_row - 1), $validation); 
            $sheet->setDataValidation('N2:N'.($p_row - 1), $validation); 


            // validations
            $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
            $validationCriteria = [];
            foreach (products_brands_array(company($myid)) as $pb){
                array_push($validationCriteria, $pb['brand_name']);
            }
            $validation = $spreadsheet->getActiveSheet()->getCell('P2')->getDataValidation(); 
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setShowDropDown(true);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
            $validation->setPromptTitle('Pick from list');
            $validation->setPrompt('Please select a valid option.');
            $validation->setShowInputMessage(false); // Disable input 
            $sheet->setDataValidation('P2:P'.($p_row - 1), $validation); 

            // validations
            $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
            $validationCriteria = [];
            foreach (product_categories_array(company($myid)) as $pc){
                array_push($validationCriteria, $pc['cat_name']);
            }
            $validation = $spreadsheet->getActiveSheet()->getCell('Q2')->getDataValidation(); 
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setShowDropDown(true);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
            $validation->setPromptTitle('Pick from list');
            $validation->setPrompt('Please select a valid option.');
            $validation->setShowInputMessage(false); // Disable input 
            $sheet->setDataValidation('Q2:Q'.($p_row - 1), $validation); 


            // validations
            $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
            $validationCriteria = [];
            foreach (product_subcategories(company($myid)) as $sc){
                array_push($validationCriteria, $sc['sub_cat_name']);
            }
            $validation = $spreadsheet->getActiveSheet()->getCell('R2')->getDataValidation(); 
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setShowDropDown(true);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
            $validation->setPromptTitle('Pick from list');
            $validation->setPrompt('Please select a valid option.');
            $validation->setShowInputMessage(false); // Disable input 
            $sheet->setDataValidation('R2:R'.($p_row - 1), $validation); 


            // Set filename for download
            $filename = 'products_export.xlsx';

            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            // Save Excel file to output
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;


        }



    public function save() {
        $myid=session()->get('id');
        $ProductsModel=new Main_item_party_table;
        $UserModel=new Main_item_party_table;
        $StockModel=new StockModel;
        $session=session();

        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        helper(['form']);
        $validation =  \Config\Services::validation();

        
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

            try {
            // Load the Excel file
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("public/csvfile/".$newName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Transpose the sheet data
            $transposedData = transpose($sheetData);
             

            // Count valid columns
            $validColumnCount = 0;
            foreach ($transposedData as $column) {
                if (isValidColumn($column)) {
                    $validColumnCount++;
                }
            } 
            
           
           if ($validColumnCount<24) {
               session()->setFlashdata('pu_er_msg', 'Invalid format!');
               return redirect()->to(base_url('products/import_and_export')); 
           }
            $old_file_name='';
            if (isset($_SESSION['file_name'])) {
                $old_file_name=$_SESSION['file_name'];
            }

            $import_report='';
            $resubmit_form='';

            $row_limit=100;
            $row_count=0;
            $count=0;
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

            // Loop through rows of Excel data
            foreach ($sheetData as $row => $data) {
                if ($row > $starting_row) {
                    if ($row>1) {

                        if ($row_count<$row_limit) {
                             
                            $product_name=$data['A'];
                            $unit=$data['B'];
                            $sub_unit=$data['C'];
                            $conversion_unit_rate=$data['D'];
                            $opening_stock=$data['E'];
                            $stock_at_price=$data['F'];
                            $tax=$data['G'];
                            $mrp_optional=$data['H'];
                            $sale_margin_optional=$data['I'];
                            $purchase_margin_optional=$data['J'];
                            $sale_price=$data['K'];
                            $sale_tax=$data['L'];
                            $purchased_price=$data['M'];
                            $purchase_tax=$data['N'];
                            $description=$data['O'];
                            $brand=$data['P'];
                            $category=$data['Q'];
                            $sub_category=$data['R'];
                            $barcode=$data['S'];
                            $type=$data['T'];
                            $product_code=$data['U'];
                            $hsnc_gtin_upc_ean_jan_isbn=$data['V'];
                            if (empty($data['V'])) {
                               $hsnc_gtin_upc_ean_jan_isbn='';
                            }
                            $batch_no=$data['W'];
                            $bin_location=$data['X'];  
                            /////////////////// IMPORTION START ///////////////////
                            if (!empty($product_name)) {

                                $product_name= preg_replace('/^[\s\x00]+|[\s\x00]+$/u', '', $product_name);

                                $units_array=products_units_array(company($myid));

                                $unit=preg_replace('/\s+/', '', trim(ucfirst($unit)));

                                $result=array_search($unit, array_column($units_array, 'value'));
                                    if ($units_array[$result]['value']) {
                                        $unit_res=preg_replace('/\s+/', '', trim(ucfirst($unit)));
                                    }else{
                                        $unit_res="Nos";
                                    }

                                if (empty(trim($unit_res))) {
                                   $unit_res="Nos";
                                }
                                
                               

                               $sub_unit=preg_replace('/\s+/', '', trim(ucfirst($sub_unit)));

                               

                                if (is_numeric(preg_replace('/\s+/', '', trim($conversion_unit_rate)))) {
                                    $conversion_unit_rate=preg_replace('/\s+/', '', trim($conversion_unit_rate));
                                }

                                $mrp=0;
                                $sale_margin=0;
                                $purchase_margin=0;
                                $price=0;
                                // $purchased_price=0;

                                if (is_numeric(preg_replace('/\s+/', '', trim($mrp_optional)))) {
                                    $mrp=preg_replace('/\s+/', '', trim($mrp_optional));
                                }

                                if (is_numeric(preg_replace('/\s+/', '', trim($sale_margin_optional)))) {
                                    $sale_margin=preg_replace('/\s+/', '', trim($sale_margin_optional));
                                }

                                if (is_numeric(preg_replace('/\s+/', '', trim($purchase_margin_optional)))) {
                                    $purchase_margin=preg_replace('/\s+/', '', trim($purchase_margin_optional));
                                }

                                if (is_numeric(preg_replace('/\s+/', '', trim($sale_price)))) {
                                    $price=preg_replace('/\s+/', '', trim($sale_price));
                                }

                                if (is_numeric(preg_replace('/\s+/', '', trim($purchased_price)))) {
                                    $purchased_price=preg_replace('/\s+/', '', trim($purchased_price));
                                }
     
                                
                                // if ($price>0) {
                                //     $price=preg_replace('/\s+/', '', trim($sale_price));
                                // }elseif($mrp>0){
                                //     $price=$mrp-($mrp*$sale_margin/100);
                                // }

                                // if ($purchased_price>0) {
                                //     $purchased_price=preg_replace('/\s+/', '', trim($purchased_price));
                                // }elseif($mrp>0){
                                //     $purchased_price=$mrp-($mrp*$purchase_margin/100);
                                // }

                                if ($mrp>0) {
                                    if ($sale_margin>0) {
                                       $price=$mrp-($mrp*$sale_margin/100);
                                    }else{
                                        $price=preg_replace('/\s+/', '', trim($sale_price));
                                    }
                                    if ($purchase_margin>0) {
                                        $purchased_price=$mrp-($mrp*$purchase_margin/100);
                                    }else{
                                        $purchased_price=preg_replace('/\s+/', '', trim($purchased_price));
                                    } 
                                }else{
                                    $price=preg_replace('/\s+/', '', trim($sale_price));
                                    $purchased_price=preg_replace('/\s+/', '', trim($purchased_price));
                                }
                                
                                

                              
                               if (get_company_data(company($user['id']),'country')=='India') {

                                    $taaax=preg_replace('/\s+/', '', trim($tax));

                                   
                                   if ($taaax==18) {
                                       $tax='GST @ 18%';
                                   }elseif($taaax=='None'){
                                        $tax='None';
                                   }elseif($taaax=='Exempted'){
                                        $tax='Exempted';
                                   }elseif($taaax==0){
                                        $tax='GST @ 0%';
                                   }elseif($taaax==0.1){
                                        $tax='GST @ 0.1%';
                                   }elseif($taaax==0.25){
                                        $tax='GST @ 0.25%';
                                   }elseif($taaax==1.5){
                                        $tax='GST @ 1.5%';
                                   }elseif($taaax==3){
                                        $tax='GST @ 3%';
                                   }elseif($taaax==5){
                                        $tax='GST @ 5%';
                                   }elseif($taaax==6){
                                        $tax='GST @ 6%';
                                   }elseif($taaax==12){
                                        $tax='GST @ 12%';
                                   }elseif($taaax==13.8){
                                        $tax='GST @ 13.8%';
                                   }elseif($taaax==26){
                                        $tax='GST @ 14% + Cess @ 12%';
                                   }elseif($taaax==28){
                                        $tax='GST @ 28%';
                                   }elseif($taaax==40){
                                        $tax='GST @ 28% + Cess @ 12%';
                                   }elseif($taaax==88){
                                        $tax='GST @ 28% + Cess @ 60%';
                                   }else{
                                        $tax='None';
                                   }
                               }elseif(get_company_data(company($user['id']),'country')=='Oman'){
                                     $taaax=preg_replace('/\s+/', '', trim($tax));
                                     
                                    if($taaax==5){
                                        $tax='VAT @ 5%';
                                    }else{
                                        $tax='None';
                                    }
                               }

                                 
                               $stock=$opening_stock;
                               $at_price=$stock_at_price;
                               
                               $category=check_category_during_import(company($myid),$category);
                               $sub_category=check_sub_category_during_import(company($myid),$sub_category,check_category_during_import(company($myid),$category));
                               $brand=check_brand_category_during_import(company($myid),$brand);
                               $barcode=$barcode;
                               $product_code=$product_code;
                               $batch_no=$batch_no;
                               $bin_location=$bin_location;


                               

                               $pro_in=$hsnc_gtin_upc_ean_jan_isbn;

                               if (strtolower(trim($sale_tax))=='with') {
                                    $sale_tax=1;
                               }else{
                                    $sale_tax=0;
                               }

                               if (strtolower(trim($purchase_tax))=='with') {
                                   $purchase_tax=1;
                               }else{
                                   $purchase_tax=0;
                               }

                               $product_method=$type;
                               if ($type=='service') {
                                   $product_method=$type;
                               }else{
                                $product_method='product';
                               }

                               $ProductsModel = new Main_item_party_table();

                               if (!is_numeric($stock)) {
                                   $stock=0;
                               }
                               if (!is_numeric($at_price)) {
                                   $at_price=0;
                               }

                                $check_product=$ProductsModel->where('product_name',$product_name)->where('company_id',company($myid))->where('deleted',0)->first();
                               if (!$check_product) {
                                    $prodata=[
                                        'company_id'=>company($myid),
                                        'product_name'=>htmlentities(strip_tags(trim($product_name))),
                                        'slug'=>str_replace(array(',',' ','&','"',"'",'.'), '-', htmlentities(strip_tags(trim($product_name)))),
                                        'unit'=>htmlentities(strip_tags(trim($unit_res))),
                                        'sub_unit'=>htmlentities(strip_tags(trim($sub_unit))),
                                        'conversion_unit_rate'=>htmlentities(strip_tags(trim((int)$conversion_unit_rate))),

                                        'mrp'=>htmlentities(strip_tags(trim($mrp))),
                                        'sale_margin'=>htmlentities(strip_tags(trim($sale_margin))),
                                        'purchase_margin'=>htmlentities(strip_tags(trim($purchase_margin))),
                                        'price'=>htmlentities(strip_tags(trim($price))),
                                        'tax'=>htmlentities(strip_tags(trim($tax))),
                                        'description'=>htmlentities(strip_tags(trim($description))),
                                        'opening_balance'=>htmlentities(strip_tags(trim($stock))),
                                        'at_price'=>htmlentities(strip_tags(trim($at_price))),
                                        'closing_balance'=>htmlentities(strip_tags(trim($stock))),
                                        'final_closing_value'=>htmlentities(strip_tags(trim($stock*$at_price))),
                                        'final_closing_value_fifo'=>htmlentities(strip_tags(trim($stock*$at_price))),
                                        'purchased_price'=>htmlentities(strip_tags(trim($purchased_price))),
                                        'category'=>htmlentities(strip_tags(trim($category))),
                                        'sub_category'=>htmlentities(strip_tags(trim($sub_category))),
                                        'brand'=>htmlentities(strip_tags(trim($brand))),
                                        'barcode'=>htmlentities(strip_tags(trim($barcode))),
                                        'product_code'=>htmlentities(strip_tags(trim($product_code))),
                                        'pro_in' => $pro_in,
                                        'batch_no' => htmlentities(strip_tags(trim($batch_no))),
                                        'bin_location'=>htmlentities(strip_tags(trim($bin_location))),
                                        'sale_tax' => $sale_tax,
                                        'purchase_tax' => $purchase_tax,
                                        'product_method'=>htmlentities(strip_tags(trim($product_method))),
                                        'added_by'=>htmlentities(strip_tags(trim($myid))),
                                        'main_type'=>'product',
                                   ];
                                   if ($ProductsModel->save($prodata)) {
                                       $proid=$ProductsModel->insertID();
                                       $count++;
                                        $import_report .= ' <tr class="" id="imported_tr">
                                            <td class="text-center"><b><i class="bx bx-check text-success" style="font-size: 20px;"></i></b></td> 
                                            <td>'.htmlentities(strip_tags(trim($product_name))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($unit_res))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($sub_unit))).'</td>
                                            <td>'.htmlentities(strip_tags(trim((int)$conversion_unit_rate))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($stock))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($at_price))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($tax))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($mrp))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($sale_margin))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($purchase_margin))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($price))).'</td>
                                            <td>'.$sale_tax.'</td>
                                            <td>'.htmlentities(strip_tags(trim($purchased_price))).'</td>
                                            <td>'.$purchase_tax.'</td>
                                            <td>'.htmlentities(strip_tags(trim($description))).'</td>
                                            <td>'.htmlentities(strip_tags(trim(name_of_brand($brand)))).'</td>
                                            <td>'.htmlentities(strip_tags(trim(name_of_category($category)))).'</td>
                                            <td>'.htmlentities(strip_tags(trim(name_of_category($sub_category)))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($barcode))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($product_method))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($product_code))).'</td>
                                            <td>'.$pro_in.'</td>
                                            <td>'.htmlentities(strip_tags(trim($batch_no))).'</td>
                                            <td>'.htmlentities(strip_tags(trim($bin_location))).'</td> 
 

                                            <td></td>
                                        </tr>';
     

                                   }
                               }else{
                                    $count++;
                            $cu_a_class='';
                            $op_type_a_class='';
                            $unit_options='';
                            $unit_val=htmlentities(strip_tags(trim($unit_res)));

                            $sub_unit_options='';
                            $sub_unit_val=htmlentities(strip_tags(trim($sub_unit)));

                            foreach (products_units_array(company($myid)) as $pu) {
                                $unit_a_class='';
                                if ($pu['value']==$unit_val) {
                                    $unit_a_class='selected';
                                }
                                $unit_options.='<option value="'.$pu['value'].'" '.$unit_a_class.'>'.$pu['name'].'</option>';

                                $sub_unit_a_class='';
                                if ($pu['value']==$sub_unit_val) {
                                    $sub_unit_a_class='selected';
                                }
                                $sub_unit_options.='<option value="'.$pu['value'].'" '.$sub_unit_a_class.'>'.$pu['name'].'</option>';
                            }

                            $tax_options='';
                            $tax_val=htmlentities(strip_tags(trim($tax)));
                            foreach (tax_array(company($myid)) as $tx) {
                                $tax_a_class='';
                                if ($tx['name']==$tax_val) {
                                    $tax_a_class='selected';
                                }
                                $tax_options.='<option value="'.$tx['name'].'" '.$tax_a_class.'>'.$tx['name'].'</option>';
 
                            }

                            $sale_tax_options='';
                            $saletax_a_class='';
                            $sale_tax_val=htmlentities(strip_tags(trim($sale_tax)));
                            if ($sale_tax_val==0) {
                                $saletax_a_class='selected';
                            }
                            $sale_tax_options='<option value="1">With</option><option value="0" '.$saletax_a_class.'>Without Tax</option>';

                            $purchase_tax_options='';
                            $purchasetax_a_class='';
                            $purchase_tax_val=htmlentities(strip_tags(trim($purchase_tax)));
                            if ($purchase_tax_val==0) {
                                $purchasetax_a_class='selected';
                            }
                            $purchase_tax_options='<option value="1">With</option><option value="0" '.$purchasetax_a_class.'>Without Tax</option>';
 
                            $product_method_options='';
                            $product_method_a_class='';
                            $product_method_val=htmlentities(strip_tags(trim($product_method)));
                            if ($product_method_val=='service') {
                                $product_method_a_class='selected';
                            }
                            $product_method_options='<option value="product">Product</option><option value="service" '.$product_method_a_class.'>Service</option>';



                            $brand_options='';
                            $brand_val=htmlentities(strip_tags(trim($brand)));

                            foreach (products_brands_array(company($myid)) as $pb) {
                            
                                $brand_a_class='';
                                if ($pb['id']==$brand_val) {
                                    $brand_a_class='selected';
                                }
                                $brand_options.='<option value="'.$pb['id'].'" '.$brand_a_class.'>'.$pb['brand_name'].'</option>';
                            }

                            $category_options='';
                            $category_val=htmlentities(strip_tags(trim($category)));

                            foreach (product_categories_array(company($myid)) as $pc) {
                            
                                $category_a_class='';
                                if ($pc['id']==$category_val) {
                                    $category_a_class='selected';
                                }
                                $category_options.='<option value="'.$pc['id'].'" '.$category_a_class.'>'.$pc['cat_name'].'</option>';
                            }

                            $sub_category_options='';
                            $sub_category_val=htmlentities(strip_tags(trim($sub_category)));

                            foreach (product_subcategories(company($myid)) as $ps) {
                            
                                $sub_category_a_class='';
                                if ($ps['id']==$sub_category_val) {
                                    $sub_category_a_class='selected';
                                }
                                $sub_category_options.='<option value="'.$ps['id'].'" '.$sub_category_a_class.'>'.$ps['sub_cat_name'].'</option>';
                            }
                        

                            




                       
$import_report .= '<tr class="" id="imported_tr'.$row.'">
    <td class="text-center" title="Display name already exist"><b><i id="display_status'.$row.'" class="bx bx-error text-danger" style="font-size: 20px;"></i></b></td>
    <td>
        <input type="text" class="form-control px-2 py-1" style="border:1px solid red;" id="product_name'.$row.'" value="'.htmlentities(strip_tags(trim($product_name))).'">
    </td>

    <td>
    <select class="form-control px-2 py-1" id="unit_res'.$row.'">
        '.$unit_options.'
    </select>

         
    </td>

    <td>
    <select class="form-control px-2 py-1" id="sub_unit'.$row.'">
        '.$sub_unit_options.'
    </select>
       
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="conversion_unit_rate'.$row.'" value="'.htmlentities(strip_tags(trim((int)$conversion_unit_rate))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="stock'.$row.'" value="'.htmlentities(strip_tags(trim($stock))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="at_price'.$row.'" value="'.htmlentities(strip_tags(trim($at_price))).'">
    </td>

    <td>
    <select class="form-control px-2 py-1" id="tax'.$row.'">
        '.$tax_options.'
    </select>
        
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="mrp'.$row.'" value="'.htmlentities(strip_tags(trim($mrp))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="sale_margin'.$row.'" value="'.htmlentities(strip_tags(trim($sale_margin))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="purchase_margin'.$row.'" value="'.htmlentities(strip_tags(trim($purchase_margin))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="price'.$row.'" value="'.htmlentities(strip_tags(trim($price))).'">
    </td>

    <td>
    <select class="form-control px-2 py-1" id="sale_tax'.$row.'">
        '.$sale_tax_options.'
    </select> 
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="purchased_price'.$row.'" value="'.htmlentities(strip_tags(trim($purchased_price))).'">
    </td>

    <td>
        <select class="form-control px-2 py-1" id="purchase_tax'.$row.'">
        '.$purchase_tax_options.'
    </select>  
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="description'.$row.'" value="'.htmlentities(strip_tags(trim($description))).'">
    </td>

    <td>
    
    <select class="form-control px-2 py-1" id="brand'.$row.'">
        '.$brand_options.'
    </select> 
       
    </td>

    <td>
    

    <select class="form-control px-2 py-1" id="category'.$row.'">
        '.$category_options.'
    </select> 
       
    </td>

    <td>
    
    <select class="form-control px-2 py-1" id="sub_category'.$row.'">
        '.$sub_category_options.'
    </select> 
       
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="barcode'.$row.'" value="'.htmlentities(strip_tags(trim($barcode))).'">
    </td>

    <td>
     <select class="form-control px-2 py-1" id="product_method'.$row.'">
        '.$product_method_options.'
    </select>  
       
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="product_code'.$row.'" value="'.htmlentities(strip_tags(trim($product_code))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="pro_in'.$row.'" value="'.$pro_in.'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="batch_no'.$row.'" value="'.htmlentities(strip_tags(trim($batch_no))).'">
    </td>

    <td>
        <input type="text" class="form-control px-2 py-1" style="" id="bin_location'.$row.'" value="'.htmlentities(strip_tags(trim($bin_location))).'"> 

    </td>
    
    <td class="text-center">
        <button class="btn-erp-small erp_round save_product_import" data-element_id="'.$row.'">Import</button>
    </td>
</tr>';

                               }

                            }
                            /////////////////// IMPORTION END ///////////////////
 

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
                        $count=0;
                    }
                    
                }
            }

            


            $data = [
                'title' => 'Import report',
                'user' => $user,
                'import_report' => $import_report,
                
                'resubmit_form' => $resubmit_form,
                'importmsg2' => '',
                'count' => $count 
            ];

            echo view('header', $data); 
            echo view('import_and_exports/import_report_product');
            echo view('footer');  

            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                session()->setFlashdata('pu_er_msg', 'Invalid format!');
               return redirect()->to(base_url('products/import_and_export')); 
            }

        }
    }  

                   
                          
    }

public function sync_products_to_branch($branch_id="",$product_id="",$unit="",$brand="",$category="",$sub_category="",$sec_category=""){



        $UserModel=new Main_item_party_table;
        $ProductsModel=new Main_item_party_table;
        $StockModel=new StockModel;
        $ProductUnits=new ProductUnits;
        $ProductCategories=new ProductCategories;
        $ProductSubCategories=new ProductSubCategories;
        $SecondaryCategories=new SecondaryCategories;
        $ProductBrand=new ProductBrand;
        $Companies=new Companies;

        $session=session();

        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');

            $row=$ProductsModel->where('id',$product_id)->where('company_id',company($myid))->first();

            $checkproductexists=$ProductsModel->where('product_name',$row['product_name'])->where('company_id',$branch_id)->first();
            
                $last_unit=0;
                $last_category=0;
                $last_sub_category=0;
                $last_secondary_category=0;
                $last_brand=0;

                $check_unit=$ProductUnits->where('company_id',$branch_id)->where('name',$unit)->where('deleted',0)->first();
                $check_category=$ProductCategories->where('company_id',$branch_id)->where('cat_name',$category)->where('deleted',0)->first();
                $check_sub_category=$ProductSubCategories->where('company_id',$branch_id)->where('sub_cat_name',$sub_category)->where('deleted',0)->first();
                $check_secondary_category=$SecondaryCategories->where('company_id',$branch_id)->where('second_cat_name',$sec_category)->where('deleted',0)->first();
                $check_brand=$ProductBrand->where('company_id',$branch_id)->where('brand_name',$brand)->where('deleted',0)->first();

                if ($unit!='no_val') {
                    if ($check_unit) {
                        $last_unit=$check_unit['id'];
                    }else{
                        $udata=[
                            'company_id'=>$branch_id,
                            'name'=>$unit
                        ];
                        $ProductUnits->save($udata);
                        $last_unit=$ProductUnits->insertID();
                    }
                }
                
                

                if ($brand!='no_val') {
                    if ($check_brand) {
                        $last_brand=$check_brand['id'];
                    }else{
                        $bdata=[
                            'company_id'=>$branch_id,
                            'brand_name'=>$brand,
                            'slug'=>cat_title_to_slug($brand)
                        ];
                        $ProductBrand->save($bdata);
                        $last_brand=$ProductBrand->insertID();
                    }
                }

                if ($category!='no_val') {
                    if ($check_category) {
                        $last_category=$check_category['id'];
                    }else{
                        $cdata=[
                            'company_id'=>$branch_id,
                            'cat_name'=>$category,
                            'slug'=>cat_title_to_slug($category)
                        ];
                        $ProductCategories->save($cdata);
                        $last_category=$ProductCategories->insertID();
                    }
                }

                if ($sub_category!='no_val') {
                    if ($check_sub_category) {
                        $last_sub_category=$check_sub_category['id'];
                    }else{
                        $subdata=[
                            'company_id'=>$branch_id,
                            'sub_cat_name'=>$sub_category,
                            'parent_id'=>$last_category,
                            'slug'=>cat_title_to_slug($sub_category)
                        ];
                        $ProductSubCategories->save($subdata);
                        $last_sub_category=$ProductSubCategories->insertID();
                    }
                }

                if ($sec_category!='no_val') {
                    if ($check_secondary_category) {
                        $last_secondary_category=$check_secondary_category['id'];
                    }else{
                        $secdata=[
                            'company_id'=>$branch_id,
                            'second_cat_name'=>$sec_category,
                            'parent_id'=>$last_sub_category,
                            'slug'=>cat_title_to_slug($sec_category)
                        ];
                        $SecondaryCategories->save($secdata);
                        $last_secondary_category=$SecondaryCategories->insertID();
                    }
                }

                



                $product_data=[
                    'company_id'=>$branch_id,
                    'slug'=>$row['slug'],
                    'product_name'=>$row['product_name'],
                    'unit'=>$last_unit,
                    'description'=>$row['description'],
                    'created_at'=>now_time($myid),
                    'category'=>$last_category,
                    'product_type'=>$row['product_type'],
                    'product_method'=>$row['product_method'],
                    'sub_category'=>$last_sub_category,
                    'sec_category'=>$last_secondary_category,
                    'online'=>1,
                    'pro_img'=>$row['pro_img'],
                    'brand'=>$last_brand,
                    'rich_description'=>$row['rich_description'],
                    'keywords'=>$row['keywords'],
                    'product_code'=>$row['product_code'],
                    'discounted_price'=>$row['discounted_price'],
                    'purchased_price'=>$row['purchased_price'],
                    'price'=>$row['price'],
                    'delivery_days'=>$row['delivery_days'],
                    'barcode'=>$row['barcode'],
                    'expiry_date'=>$row['expiry_date'],
                    'pro_in'=>$row['pro_in'],
                    'tax'=>$row['tax'],
                    'batch_no'=>$row['batch_no'],
                    'stock'=>$row['stock'],
                    'added_by'=>$myid,
                ];

                if (!$checkproductexists) {
                    if ($ProductsModel->save($product_data)) {
                        echo 'done';
                    }
                }else{
                    if ($ProductsModel->update($checkproductexists['id'],$product_data)) {
                        echo 'done';
                    }
                }
            

        }

    }



public function parties()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
                unset($_SESSION['starting_row']);
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
                   
                    $data = [
                        'title' => 'Aitsun ERP-Imports and Exports',
                        'user'=>$user,
                    ];

                    if (usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                    if (check_main_company($myid)==true) {
                        if (check_branch_of_main_company(company($myid))==true) {
                            if (usertype($myid)=='customer') {
                                return redirect()->to(base_url());
                            }else{
                                echo view('header',$data);
                                echo view('import_and_exports/parties', $data);
                                echo view('footer');
                            }
                        }else{
                             return redirect()->to(base_url('company'));
                        }
                        
                    }else{
                        return redirect()->to(base_url('company'));
                    }

                        

                }else{
                    return redirect()->to(base_url('users/login'));
                }
                
        }



 public function export_parties() {

    $Main_item_party_table=new Main_item_party_table;   
    $myid=session()->get('id');
    $session=session();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0);
    $sheet = $spreadsheet->getActiveSheet();

    $Main_item_party_table->where('u_type!=','admin');
    $Main_item_party_table->where('u_type!=','superuser');
    $Main_item_party_table->where('u_type!=','staff');
    $Main_item_party_table->where('u_type!=','driver');
    $Main_item_party_table->where('u_type!=','teacher');
    $Main_item_party_table->where('u_type!=','delivery');
    $Main_item_party_table->where('u_type!=','seller');
    $Main_item_party_table->where('u_type!=','student');
    $Main_item_party_table->where('default_user !=', 1);

     // Set column headers
    $sheet->setCellValue('A1', 'Name');
    $sheet->setCellValue('B1', 'Email/Username');
    $sheet->setCellValue('C1', 'Contact');
    $sheet->setCellValue('D1', 'Address');
    $sheet->setCellValue('E1', 'Type');
    $sheet->setCellValue('F1', 'GST/VAT NO');
    $sheet->setCellValue('G1', 'State');
    $sheet->setCellValue('H1', 'Opening Balance');
    $sheet->setCellValue('I1', 'Opening Type'); // Adding the "Opening Type" column as the last column   



    $partiesinfo = $Main_item_party_table->where('company_id',company($myid))->where('main_type','user')->orderBy('id','DESC')->where('deleted',0)->findAll(); 

     ////////////////////////CREATE ACTIVITY LOG//////////////
        $log_data=[
            'user_id'=>$myid,
            'action'=>'Parties Exported.',
            'ip'=>get_client_ip(),
            'mac'=>GetMAC(),
            'created_at'=>now_time($myid),
            'updated_at'=>now_time($myid),
            'company_id'=>company($myid),
        ];

        add_log($log_data);
        ////////////////////////END ACTIVITY LOG/////////////////

        
    $row = 2;
    foreach ($partiesinfo as $element) {
        $openingType = $element['opening_balance'] < 0 ? 'To Pay' : 'To Collect';
        $sheet->setCellValue('A' . $row, $element['display_name']);
        $sheet->setCellValue('B' . $row, $element['email']);
        $sheet->setCellValue('C' . $row, $element['phone']); // Contact
        $sheet->setCellValue('D' . $row, $element['billing_address']); // Address
        $sheet->setCellValue('E' . $row, $element['u_type']); // Type
        $sheet->setCellValue('F' . $row, $element['gst_no']); // GST/VAT NO
        $sheet->setCellValue('G' . $row, $element['billing_state']); // State
        $sheet->setCellValue('H' . $row, str_replace('-', '', $element['opening_balance'])); // Opening Balance
        $sheet->setCellValue('I' . $row, $openingType);
        $row++;
    }


    // Set data validation for 'Opening Type' column
    $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
    $validationCriteria = ['To Pay', 'To Collect'];
    $validation = $spreadsheet->getActiveSheet()->getCell('I2')->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setShowDropDown(true);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
    $validation->setShowErrorMessage(true);
    $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
    $validation->setPromptTitle('Pick from list');
    $validation->setPrompt('Please select a valid option (To Pay or To Collect).');
    $validation->setShowInputMessage(false); // Disable input 
    $sheet->setDataValidation('I2:I'.($row - 1), $validation);


    $validationRule = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
    $validationCriteria = ['customer', 'vendor'];
    $validation = $spreadsheet->getActiveSheet()->getCell('E2')->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setShowDropDown(true);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
    $validation->setShowErrorMessage(true);
    $validation->setFormula1('"'.implode(',', $validationCriteria).'"');
    $validation->setPromptTitle('Pick from list');
    $validation->setPrompt('Please select a valid option (customer or vendor).');
    $validation->setShowInputMessage(false); // Disable input 
    $sheet->setDataValidation('E2:E'.($row - 1), $validation);

    // Set filename for download
    $filename = 'parties_export.xlsx';

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'"');
    header('Cache-Control: max-age=0');

    // Save Excel file to output
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;


}


public function import_parties() {
    $Main_item_party_table = new Main_item_party_table;   

    $myid = session()->get('id');
    
    $session = session();

    $con = array( 
        'id' => session()->get('id') 
    );
    $user = $Main_item_party_table->where('id', $myid)->first();

    helper(['form']);
    $validation =  \Config\Services::validation();


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

           // Transpose the array to switch rows and columns


            // Transpose the sheet data
            $transposedData = transpose($sheetData);
             

            // Count valid columns
            $validColumnCount = 0;
            foreach ($transposedData as $column) {
                if (isValidColumn($column)) {
                    $validColumnCount++;
                }
            } 

           if ($validColumnCount<9) {
                session()->setFlashdata('pu_er_msg', 'Invalid format!');
                return redirect()->to(base_url('import_and_export/parties'));
           }else{
             $old_file_name='';
            if (isset($_SESSION['file_name'])) {
                $old_file_name=$_SESSION['file_name'];
            }

            $import_report='';
            $resubmit_form='';

            $row_limit=5;
            $row_count=0;
            $count=0;
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

            // Loop through rows of Excel data
            foreach ($sheetData as $row => $data) {
                if ($row > $starting_row) {
                    if ($row>1) {

                        if ($row_count<$row_limit) {
                            $display_name = $data['A'];
                            $email = $data['B'];
                            $phone = $data['C'];
                            $address = $data['D'];
                            $gst_no = $data['F']; // Adjust column index based on your Excel file
                            $opening_balance = str_replace('-','',$data['H']); // Adjust column index based on your Excel file
                            $u_type = isset($data['E']) ? $data['E'] : 'customer'; // Adjust column index based on your Excel file
                            $billing_state = isset($data['G']) ? $data['G'] : ''; // Adjust column index based on your Excel file
                            $openingType = $data['I']; 

                            /////////////////// IMPORTION START /////////////////
                            if ($u_type!='vendor') {
                                $u_type='customer';
                            }

                            if (!empty(trim($display_name))) {
                                if ($openingType == 'To Pay') {
                                    $value_of_opening = '-'.$opening_balance;  // Make opening balance negative for "pay" type
                                }else{
                                    $openingType='To Collect';
                                    $value_of_opening=$opening_balance;
                                }

                                $statesar = states_array(company($myid));
                                if (!empty($gst_no) && isset($statesar[substr($gst_no, 0, 2)])) {
                                    // If GST number is provided and valid, use it to determine billing state
                                    $bs = $statesar[substr($gst_no, 0, 2)];
                                } else {
                                    // If GST number is not provided or invalid, fallback to using state name
                                    $bs = $billing_state;
                                }

                                $check_email = $Main_item_party_table->where('display_name', $display_name)->where('company_id', company($myid))->where('deleted', 0)->first();

                                if (!$check_email) {
                                        $statesar = states_array(company($myid));
                                        $bs = isset($statesar[substr($gst_no, 0, 2)]) ? $statesar[substr($gst_no, 0, 2)] : $billing_state;

                                        // Define $group_head_name based on $u_type
                                        if (!empty($u_type)) {
                                            if ($u_type == 'customer' || $u_type == 'vendor') {
                                                if (strip_tags($u_type) != 'vendor') {
                                                    $group_head_name = 'Sundry Debtors';
                                                } else {
                                                    $group_head_name = 'Sundry Creditors';
                                                }
                                            }
                                        } else {
                                            $group_head_name = ''; // Define a default value or handle the case when $u_type is empty
                                        }

                                        // Save the party data
                                        $partydata = [
                                            'company_id' => company($myid),
                                            'display_name' => htmlentities(strip_tags(trim($display_name))),
                                            'email' => htmlentities(strip_tags(trim($email))),
                                            'phone' => htmlentities(strip_tags(trim($phone))),
                                            'gst_no' => htmlentities(strip_tags(trim($gst_no))),
                                            'u_type' => htmlentities(strip_tags(trim($u_type))),
                                            'created_at'=>now_time($myid),
                                            'main_type' => 'user',
                                            'billing_address' => htmlentities(strip_tags(trim($address))),
                                            'billing_state' => htmlentities(strip_tags(trim($bs))),
                                            'opening_balance' => aitsun_round(htmlentities(strip_tags(trim($value_of_opening))), get_setting(company($myid),'round_of_value')),
                                            'closing_balance' => aitsun_round(htmlentities(strip_tags(trim($value_of_opening))), get_setting(company($myid),'round_of_value')),
                                            
                                        ];


                                        $saveparty = $Main_item_party_table->save($partydata);
                                        $insidd = $Main_item_party_table->insertID();
                                        // $saveparty=true;
                                        if ($saveparty) { 
                                            $count++;
                                            $import_report .= ' <tr class="">
                                                <td class="text-center"><b><i class="bx bx-check text-success" style="font-size: 20px;"></i></b></td>
                                                <td>'.htmlentities(strip_tags(trim($display_name))).'</td>
                                                <td>'.htmlentities(strip_tags(trim($email))).'</td>
                                                <td>'.htmlentities(strip_tags(trim($phone))).'</td>
                                                <td>'.htmlentities(strip_tags(trim($address))).'</td>
                                                <td>'.htmlentities(strip_tags(trim($u_type))).'</td>
                                                <td>'.htmlentities(strip_tags(trim($gst_no))).'</td>
                                                <td>'.htmlentities(strip_tags(trim($bs))).'</td>
                                                <td>'.aitsun_round(htmlentities(strip_tags(trim(str_replace('-','',$value_of_opening)))), get_setting(company($myid),'round_of_value')).'</td>
                                                <td>'.$openingType.'</td> 
                                                <td></td>
                                            </tr>';
                                        }
                                    } else {
                                        $count++;
                                        $cu_a_class='';
                                        $op_type_a_class='';

                                        if (htmlentities(strip_tags(trim($u_type)))=='vendor') {
                                            $cu_a_class='selected';
                                        }

                                        if (htmlentities(strip_tags(trim($value_of_opening)))<0) {
                                            $op_type_a_class='selected';
                                        }

                                        $import_report .= '<tr class="" id="imported_tr'.$row.'">
            <td class="text-center" title="Display name already exist"><b><i id="display_status'.$row.'" class="bx bx-error text-danger" style="font-size: 20px;"></i></b></td>
            <td><input type="text" class="form-control px-2 py-1" style="border:1px solid red;" id="display_name'.$row.'" value="'.htmlentities(strip_tags(trim($display_name))).'"></td>
            <td><input type="text" class="form-control px-2 py-1" id="email'.$row.'" value="'.htmlentities(strip_tags(trim($email))).'"></td>
            <td><input type="text" class="form-control px-2 py-1" id="phone'.$row.'" value="'.htmlentities(strip_tags(trim($phone))).'"></td>
            <td><input type="text" class="form-control px-2 py-1" id="address'.$row.'" value="'.htmlentities(strip_tags(trim($address))).'"></td>

            <td>
                <select class="form-control px-2 py-1" id="u_type'.$row.'">
                    <option value="customer">Customer</option>
                    <option value="vendor" '.$cu_a_class.'>Vendor</option>
                </select>
            </td>
             <td><input type="text" class="form-control px-2 py-1" id="gst_no'.$row.'" value="'.htmlentities(strip_tags(trim($gst_no))).'"></td>

            <td><input type="text" class="form-control px-2 py-1" id="bs'.$row.'" value="'.htmlentities(strip_tags(trim($bs))).'"></td>
            <td><input type="number" class="form-control px-2 py-1" step="any" id="value_of_opening'.$row.'" value="'.aitsun_round(htmlentities(strip_tags(trim(str_replace('-','',$value_of_opening)))), get_setting(company($myid),'round_of_value')).'"></td>
            <td>
                <select class="form-control px-2 py-1" id="op_type'.$row.'"> 
                      <option value="">To Collect</option>
                      <option value="-" '.$op_type_a_class.'>To Pay</option> 
                </select>
            </td> 
            <td class="text-center">
                <button class="btn-erp-small erp_round save_import" data-element_id="'.$row.'">Import</button>
            </td>
                                            </tr>';
                                    }
                            }
                            /////////////////// IMPORTION END ///////////////////
 

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
                        $count=0;
                    }

                    
                    
                }

            }

            $data = [
                'title' => 'Import report',
                'user' => $user,
                'import_report' => $import_report,
                'redi' => 'party',
                'resubmit_form' => $resubmit_form,
                'importmsg2' => '',
                'count' => $count 
            ];

            echo view('header', $data); 
            echo view('import_and_exports/import_report');
            echo view('footer'); 

           }

           
            


             

        }
    }         
}






public function students()
    {
        $session=session();
        $user=new Main_item_party_table();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
            
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
                
             

                if (check_permission($myid,'import_export')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}

                
                $data=[
                    'title'=>'Import and Export | Erudite ERP',
                    'user'=>$usaerdata,
                ];
                
                    echo view('header',$data);
                    echo view('import_and_exports/students');
                    echo view('footer');
               

            
        }else{
            return redirect()->to(base_url('users'));
        }       
    }
    

    public function export_students() {
        $UserModel = new Main_item_party_table;
        $myid=session()->get('id');
        $usaerdata=$UserModel->where('id', session()->get('id'))->first();
        

        $storData = array();
        $metaData[] = array(
            'first_name' => 'Fullname',
            'date_of_birth' => 'DOB',
            'father_name' => 'Father',
            'mother_name' => 'Mother',
            'gender' => 'Gender',
            'password' => 'Password',
            'billing_address' => 'Address',
            'phone' => 'Phone',
            'date_of_join' => 'DOJ',
            'class' => 'Class',
            'category'=>'Category',
            'subcategory'=>'Sub Category',
            'admission_no' => 'Admission No',
            'adhar' => 'Adhar No',
            'blood_group' => 'Blood Group',
        );     

        $customerInfo = $UserModel->where('company_id',company($myid))->where('transfer','')->where('u_type','student')->where('deleted',0)->findAll(); 

        foreach($customerInfo as $element) {
            $storData[] = array(
                'first_name' => $element['display_name'],
                'date_of_birth' => $element['date_of_birth'],
                'father_name' => $element['father_name'],
                'mother_name' => $element['mother_name'],
                'gender' => $element['gender'],
                'password' => '',
                'billing_address' => $element['billing_address'],
                'phone' => $element['phone'],
                'date_of_join' => get_date_format($element['date_of_join'],'Y-m-d'),
                'class' => class_name(current_class_of_student(company($myid),$element['id'])),
                'category' => student_category_name($element['category']),
                'subcategory' => student_category_name($element['subcategory']),
                'admission_no' => $element['admission_no'],
                'adhar' => $element['adhar'],
                'blood_group' => $element['blood_group'],
            );
        }

        ////////////////////////CREATE ACTIVITY LOG//////////////
        $log_data=[
            'user_id'=>session()->get('id'),
            'action'=>'Students exported.',
            'ip'=>get_client_ip(),
            'mac'=>GetMAC(),
            'created_at'=>now_time(session()->get('id')),
            'updated_at'=>now_time(session()->get('id')),
            'company_id'=>company(session()->get('id')),
        ];

        add_log($log_data);
        ////////////////////////END ACTIVITY LOG/////////////////

        $data = array_merge($metaData,$storData);
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Students-".now_time($myid)."".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
            fclose($handle);
        exit;

    }



   public function import_students()
    {

            $UserModel = new Main_item_party_table;
            $ClassModel = new ClassModel;
            $Classtablemodel= new Classtablemodel;
            $StudentcategoryModel= new StudentcategoryModel;

            $myid=session()->get('id');
            $usaerdata=$UserModel->where('id', session()->get('id'))->first();

            helper(['form']);
            $validation =  \Config\Services::validation();

            $count = 0;

                    $import_message="";

          


                if($file = $this->request->getFile('fileURL')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('public/csvfile', $newName);
                    $file = fopen("public/csvfile/".$newName,"r");
                    $i = 0;
                    $numberOfFields = 15;

                    $csvArr = array();


                    
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if($i > 0 && $num == $numberOfFields){

                            if (!empty(trim($filedata[5]))) {
                                $passcode=trim($filedata[5]);
                            }else{

                                $passcode=generateRandomString(8);
                            }

                            if (!empty(trim($filedata[8]))) {
                                $dateofjoin=date_ulta(get_date_format(trim($filedata[8]),'d-m-Y'));
                            }else{
                                $dateofjoin='0000-00-00 00:00:00';
                            }

                            if (!empty(trim($filedata[1]))) {
                                $dateofbirth=date_ulta(trim(get_date_format(trim($filedata[1]),'d-m-Y')));
                            }else{
                                $dateofbirth='0000-00-00 00:00:00';
                            }

                            if (!empty(trim($filedata[9]))) {
                               $class=trim($filedata[9]);
                            }else{
                                $class='';
                            }

                            $cat_name_id=0;
                            $sub_cat_name_id=0;

                            if (!empty(trim($filedata[10]))) {
                                $check_category_exist=$StudentcategoryModel->where('company_id', company($myid))->where('category_name', trim($filedata[10]))->where('deleted',0)->first();
                                if ($check_category_exist) {
                                    $cat_name_id=$check_category_exist['id'];
                                }else{
                                    $catnamedata=[
                                        'company_id'=>company($myid),
                                        'category_name'=>strip_tags(trim($filedata[10])),
                                        'type'=>'main',
                                    ];
                                    $StudentcategoryModel->save($catnamedata);
                                    $cat_name_id=$StudentcategoryModel->insertID();
                                }

                                    if (!empty(trim($filedata[11]))) {
                                        $check_subcategory_exist=$StudentcategoryModel->where('company_id', company($myid))->where('category_name', trim($filedata[11]))->where('deleted',0)->first();

                                        if ($check_subcategory_exist) {
                                            $sub_cat_name_id=$check_subcategory_exist['id'];
                                        }else{
                                            $catnamedata=[
                                                'company_id'=>company($myid),
                                                'category_name'=>strip_tags(trim($filedata[11])),
                                                'type'=>'sub',
                                                'parent_id'=>$cat_name_id
                                            ];
                                            $StudentcategoryModel->save($catnamedata);
                                            $sub_cat_name_id=$StudentcategoryModel->insertID();
                                        }


                                    }
                            }

                            
                            

                            $csvArr[$i]['first_name'] = strip_tags(trim($filedata[0]));
                            $csvArr[$i]['display_name'] = strip_tags(trim($filedata[0]));
                            $csvArr[$i]['date_of_birth'] = strip_tags($dateofbirth); 
                            $csvArr[$i]['stdage'] = age_of_student(trim(trim($filedata[1])),now_time($myid));
                            $csvArr[$i]['father_name'] = strip_tags(trim($filedata[2]));
                            $csvArr[$i]['mother_name'] = strip_tags(trim($filedata[3]));
                            $csvArr[$i]['gender'] = strip_tags(strtolower(trim($filedata[4]))); 
                            $csvArr[$i]['password'] = strip_tags($passcode);
                            $csvArr[$i]['password_2'] = strip_tags($passcode);
                            $csvArr[$i]['class'] = strip_tags($class);
                            $csvArr[$i]['billing_address'] = strip_tags(trim($filedata[6]));
                            $csvArr[$i]['phone'] = trim(strip_tags(trim($filedata[7])));
                            $csvArr[$i]['date_of_join'] = strip_tags($dateofjoin);
                            $csvArr[$i]['company_id'] = company($myid);
                            $csvArr[$i]['u_type'] = 'student';
                            $csvArr[$i]['main_type'] = 'user';
                            $csvArr[$i]['serial_no'] = 0;
                            $csvArr[$i]['status'] =1;
                            $csvArr[$i]['category'] =strip_tags($cat_name_id);
                            $csvArr[$i]['subcategory'] =strip_tags($sub_cat_name_id);
                            $csvArr[$i]['admission_no'] =strip_tags(trim($filedata[12]));
                            $csvArr[$i]['adhar'] =strip_tags(trim($filedata[13]));
                            $csvArr[$i]['blood_group'] =strip_tags(trim($filedata[14]));

                        }
                        $i++;
                    }
                    fclose($file);

                    

                    

                    foreach($csvArr as $us){
                        $students = new Main_item_party_table();

                        $findRecord = $students->where('phone', $us['phone'])->where('deleted',0)->countAllResults();
                        $us['serial_no']=serial_no_student(company($myid));
                        if($findRecord == 0){
                        // $d=1;
                        // if($d == 1){
                            if (!empty($us['phone']) && !empty($us['first_name'])) {
                                $maxuser=user_limit(company($myid));
                                $current_user=total_user(company($myid));
                                if ($current_user>=$maxuser) {
                                    $import_message.='Maximun user limit reached!<br>';
                                }else{
                                    if($students->save($us)){
                                        $count++;
                                        $import_message.='<span class="text-success"><b>'.$us['first_name'].'-'.$us['class'].'</b> imported!</span><br>';

                                        $std_id = $students->getInsertID();


                                       
                                    



                                        //class adding and assigning student to class
                                        $classname=trim($us['class']);
                                        if (!empty($classname)) {
                                              $check_class_exist=$ClassModel->where('class',$classname)->where('company_id',company($myid))->where('deleted',0)->first();
                                        if ($check_class_exist) {

                                            

                                            $newclass = [
                                                'company_id' => company($myid),
                                                'academic_year' => academic_year($myid),
                                                'student_id' => $std_id,
                                                'first_name' => $us['first_name'],
                                                'gender' => $us['gender'],
                                                'class_id' => $check_class_exist['id'],
                                                'category'=>$us['category'],
                                                'deleted' => 0,
                                            ];
                                            $Classtablemodel->save($newclass);

                                        }else{

                                            $newCClass = [
                                                'class' => $us['class'],
                                                'company_id' => company($myid),
                                                'datetime' => now_time($myid),
                                                'serial_no' => serial_no_class(company($myid))
                                            ];

                                            $ClassModel->save($newCClass);
                                            $class_id=$ClassModel->getInsertID();


                                            $std_id = $students->getInsertID();

                                            $newclass = [
                                                'company_id' => company($myid),
                                                'academic_year' => academic_year($myid),
                                                'student_id' => $std_id,
                                                'first_name' => $us['first_name'],
                                                'gender' => $us['gender'],
                                                'class_id' => $class_id,
                                                'deleted' => 0,
                                            ];
                                            $Classtablemodel->save($newclass);

                                        }
                                        }
                                      
                                        
                                        //class adding and assigning student to class


                                    }
                                }
                            }
                            
                        }else{
                            $import_message.='<span style="color:#ff0000c4;">Failed!, Mobile <b>"'.$us['phone'].'"</b> is exist of <b>'.$us['first_name'].'-'.$us['class'].'</b></span><br>';
                        }
                    }
                    
                }
                else{
                  
                    $import_message.='<span style="color:#ff0000c4;">CSV file coud not be imported.</span><br>';
                }
                }else{
              
                 $import_message.='<span style="color:#ff0000c4;">CSV file coud not be imported.</span><br>';
                }

         


            ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>session()->get('id'),
                'action'=>$count.' students imported.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time(session()->get('id')),
                'updated_at'=>now_time(session()->get('id')),
                'company_id'=>company(session()->get('id')),
            ];

            add_log($log_data);
            ////////////////////////END ACTIVITY LOG/////////////////

            $import_message.=$count.' students successfully added.';

            $data=[
                'title'=>'Import report | Erudite ERP',
                'user'=>$usaerdata,
                'import_report'=>$import_message,
                'redi'=>'student'
            ];

            
                echo view('header',$data);
                echo view('import_and_exports/import_report');
                echo view('footer');
            

        
    }
    


}