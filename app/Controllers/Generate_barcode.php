<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProductsModel;

 

class Generate_barcode extends BaseController
{
     public function index()
    {

        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
            $ntt=now_time($myid);

            $UserModel=new Main_item_party_table; 
            
            $user=$UserModel->where('id',$myid)->first();

            $data = [
                'title' => 'Aitsun ERP-Barcode',
                'user'=>$user, 
            ];
           
        $filepath = (isset($_GET["filepath"])?$_GET["filepath"]:"");
        $text = (isset($_GET["text"])?$_GET["text"]:"0");
        $size = (isset($_GET["size"])?$_GET["size"]:"20");
        $orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
        $code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
        $print = (isset($_GET["print"])&&$_GET["print"]=='true'?true:false);
        $SizeFactor = (isset($_GET["SizeFactor"])?$_GET["SizeFactor"]:"1");
        $code_string = "";

        // Accecpted types
        // TYPE_CODE_32 (italian pharmaceutical code 'MINSAN')
        // TYPE_CODE_39
        // TYPE_CODE_39_CHECKSUM
        // TYPE_CODE_39E
        // TYPE_CODE_39E_CHECKSUM
        // TYPE_CODE_93
        // TYPE_STANDARD_2_5
        // TYPE_STANDARD_2_5_CHECKSUM
        // TYPE_INTERLEAVED_2_5
        // TYPE_INTERLEAVED_2_5_CHECKSUM
        // TYPE_CODE_128
        // TYPE_CODE_128_A
        // TYPE_CODE_128_B
        // TYPE_CODE_128_C
        // TYPE_EAN_2
        // TYPE_EAN_5
        // TYPE_EAN_8
        // TYPE_EAN_13
        // TYPE_UPC_A
        // TYPE_UPC_E
        // TYPE_MSI
        // TYPE_MSI_CHECKSUM
        // TYPE_POSTNET
        // TYPE_PLANET
        // TYPE_RMS4CC
        // TYPE_KIX
        // TYPE_IMB
        // TYPE_CODABAR
        // TYPE_CODE_11
        // TYPE_PHARMA_CODE
        // TYPE_PHARMA_CODE_TWO_TRACKS

        $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();

        // $generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG(); // Vector based SVG
        // $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG(); // Pixel based PNG
        // $generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG(); // Pixel based JPG
        // $generatorHTML = new Picqer\Barcode\BarcodeGeneratorHTML(); // Pixel based HTML
        // $generatorHTML = new Picqer\Barcode\BarcodeGeneratorDynamicHTML(); // Vector based HTML

        echo $generator->getBarcode($text, $generator::TYPE_CODE_128);

            
         
        }else{
            return redirect()->to(base_url('users/login'));
        }
    
    }

    public function barcode_preview($proid=""){
        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
            $ntt=now_time($myid);

            $UserModel=new Main_item_party_table; 
            $ProductsModel=new Main_item_party_table; 
            
            
            $user=$UserModel->where('id',$myid)->first();
            $sample_product='';


            $get_pro = $ProductsModel->where('id',$proid)->where('company_id',company($myid))->where('product_type!=','fees')->orderBy("id", "desc")->where('main_type','product')->where('deleted',0)->first();
            if (!$get_pro) {
                $get_pro=[];
                $sample_product='yes';
            }

            $data = [
                'title' => 'Aitsun ERP-Barcode',
                'user'=>$user, 
                'get_pro'=>$get_pro,
                'sample_product'=>$sample_product
            ];


            echo view('products/barcode_preview',$data);
            

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
  
}
