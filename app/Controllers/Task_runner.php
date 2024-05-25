<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\ExportexcelModel;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\Response;

class Task_runner extends BaseController
{
    public function index()
    {
        $ExportexcelModel = new ExportexcelModel;
        $myid=session()->get('id');
        $ProductsModel = new Main_item_party_table;

        foreach ($ExportexcelModel->where('status', 'pending')->findAll() as $tsk) {

        	$get_pro = $ProductsModel->where('company_id',company($myid))->where('product_type!=','fees')->orderBy("id", "desc")->where('deleted',0)->findAll(100); 

            $fileName = $tsk['task_name'] . ".xls";
            $fields = array('#PRODUCT', 'DESC', 'PRODUCT METHOD', 'PRODUCT CODE', 'PRODUCT TYPE', 'PRICE', 'SELLING PRICE', 'UNIT', 'BRAND', 'CATEGORY', 'SUB CATEGORY', 'SECONDARY CATEGORY', 'BARCODE', 'EXPIRY DATE', 'BATCH NO', 'PRODUCT IDENTIFIERS', 'TAX', 'BIN LOCATION');
            $query = $get_pro;

            $excelData = implode("\t", array_values($fields)) . "\n";

            if (count($query) > 0) {
                foreach ($query as $row) {
                    $pro_brand = name_of_brand($row['brand']);
                    $pro_unit = name_of_unit($row['unit']);
                    $pro_cat = name_of_category($row['category']);
                    $pro_sub_cat = name_of_sub_category($row['sub_category']);
                    $pro_sec_sub_cat = name_of_sec_category($row['sec_category']);
                    $tax = tax_name($row['tax']) . '-' . percent_of_tax($row['tax']) . '%';

                    $colllumns = array($row['product_name'], $row['description'], $row['product_method'], $row['product_code'], $row['product_type'], $row['discounted_price'], $row['price'], $pro_unit, $pro_brand, $pro_cat, $pro_sub_cat, $pro_sec_sub_cat, $row['barcode'], $row['expiry_date'], $row['batch_no'], $row['pro_in'], $tax, $row['bin_location']);

                    array_walk($colllumns, 'filterData');
                    $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n";
                }
            } else {
                $excelData .= 'No records found...' . "\n";
            }

             // Save the file to the public directory
            $newFilePath = 'public/uploads/crone_files/' . $fileName;
            write_file($newFilePath, $excelData);

           

            $ExportexcelModel->update($tsk['id'], ['status' => 'ready','file_name' =>$fileName]);

            // return $this->response->download($newFilePath, null, true);
            return ;
        }
    }
}
