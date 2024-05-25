<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProductUnits;
use App\Models\ProductCategories;
use App\Models\ProductSubCategories;
use App\Models\SecondaryCategories;
use App\Models\ProductBrand;
use App\Models\ProductsModel;
use App\Models\ProductsImages;
use App\Models\ProductratingsModel;
use App\Models\AdditionalfieldsModel;
use App\Models\ScrapModel;
use App\Models\ScrapCurrencyTable;


class Product_scrapper extends BaseController
{
     public function index()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            
            $ntt=now_time($myid);

            $UserModel=new Main_item_party_table;
            $ScrapModel=new ScrapModel;

            
            $user=$UserModel->where('id',$myid)->first();

            $data = [
                'title' => 'Aitsun ERP-Scraptest',
                'user'=>$user,
            ];


            if (isset($_GET['scrap_url'])) {

                $site_id=$_GET['siteid'];
                $scrap_data=$ScrapModel->where('id',$site_id)->first();

                if ($scrap_data) {
                    $doc = new \DOMDocument;

                        
                    libxml_use_internal_errors(true);
                    $doc->loadHTML('...');
                    libxml_clear_errors();

                    // We don't want to bother with white spaces
                    $doc->preserveWhiteSpace = false;

                    // Most HTML Developers are chimps and produce invalid markup...
                    $doc->strictErrorChecking = false;
                    $doc->recover = true;


                    $feed = new \DOMDocument();  
                    $res= @$doc->loadHTMLFile(strip_tags($_GET['scrap_url']));

                    if($res==1){
                      
                        $xpath = new \DOMXPath($doc);

                        $q_product_name = $xpath->query($scrap_data['product_name']);
                        $q_description = $xpath->query($scrap_data['description']);
                        $q_breif_description = $xpath->query($scrap_data['rich_description']);
                        $q_keywords = $xpath->query($scrap_data['keywords']);
                        $q_image = $xpath->query($scrap_data['product_image']);
                        $q_pricee = $xpath->query($scrap_data['price']);
                        $currency=$scrap_data['currency'];
                        $q_brand=$xpath->query($scrap_data['brand']);
                        $q_thumb_image=$xpath->query($scrap_data['thumb_image']);
                        
                        $q_category=$xpath->query($scrap_data['category']);
                        $q_sub_category=$xpath->query($scrap_data['sub_category']);
                        $q_sec_category=$xpath->query($scrap_data['sec_category']);

                        
                        //image scrap
                        $feed->loadHTML(curl_get_file_contents($_GET['scrap_url']));
                        $zxpath = new \DOMXPath($feed);
                        $src = $zxpath->evaluate('string('.$scrap_data['product_image'].'/@src)');
                        //image scrap


                        $product_name='';
                        $description='';
                        $breif_description='';
                        $keywords='';
                        $before_pprice=0;
                        $brandd='';

                        if ($q_product_name) {
                            if ($q_product_name->length!=0) {
                                $product_name=$q_product_name->item(0)->textContent;
                            }
                        }
                        

                        if ($q_description) {
                            if ($q_description->length!=0) {
                                $description=$q_description->item(0)->textContent;
                            }
                        }
                        

                        if ($q_breif_description) {
                            if ($q_breif_description->length!=0) {
                                $breif_description=$doc->saveHTML($q_breif_description->item(0));
                            }
                        }

                        if ($q_brand) {
                            if ($q_brand->length!=0) {
                                $brandd=$q_brand->item(0)->textContent;
                            }
                        }

                        
                        if ($q_keywords) {
                            if ($q_keywords->length!=0) {
                                $keywords=$q_keywords->item(0)->textContent;
                            }
                        }
                        
                       
                       if ($q_pricee) {
                           if ($q_pricee->length!=0) {
                               $before_pprice=trim(preg_replace("/[^.0-9\s]/", "", $q_pricee->item(0)->textContent));
                           }
                       }

          
                        


                        if ($before_pprice>0) {
                            if ($currency=='usd') {
                                $pprice=($before_pprice*data_of_currency('usd','rate'))+data_of_currency('usd','profit');
                            }elseif ($currency=='aed') {
                                $pprice=($before_pprice*data_of_currency('aed','rate'))+data_of_currency('aed','profit');
                            }elseif ($currency=='inr') {
                                $pprice=($before_pprice*data_of_currency('inr','rate'))+data_of_currency('inr','profit');
                            }else{
                                $pprice=$before_pprice;
                            }
                            
                        }else{
                            $pprice=0;
                        }
                 
                        $prod_img='';
                        $thumb_img='';

                        $pro_data=[
                            'product_name'=>strip_tags(trim($product_name)),
                            'description'=>strip_tags(trim($description)),
                            
                            'keywords'=>strip_tags(trim($keywords)),
                            'pprice'=>strip_tags(trim($pprice,3)),
                            'psellprice'=>strip_tags(trim($pprice,3)),
                            'prod_img'=>strip_tags(trim($src)),
                            'thumb_img'=>strip_tags(trim($thumb_img)),
                            'brand'=>get_id_of_brand(company($myid),strip_tags(trim($brandd))),
                            'rich_description'=>strip_tags(trim($breif_description),'<b><h1><h2><h3><h4><h5><h6><ul><li><p><div><span><br><table><tr><td><th><img>'),
                        ];

                        // echo get_id_of_brand(company($myid),strip_tags(trim($brandd)));

                        echo json_encode($pro_data);
                       //  // echo $breif_description;

                       
                        
                       



                       
                    }
                }
                
            }
         
        }
    
    }

    public function configuration(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $ScrapModel=new ScrapModel;
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

            $data = [
                'title' => 'Product scrapper',
                'user'=>$user,
                'sites'=>$ScrapModel->where('company_id',company($myid))->orderBy('id','desc')->findAll()
            ];

            echo view('header',$data);
            echo view('settings/product_scrapper',$data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users'));
        }
    }



    public function add_site(){
        if (isset($_POST['save_site'])) {
            $session=session();
            $ScrapModel=new ScrapModel;
            $myid=session()->get('id');

            $ac_data = [
                'company_id'=>company($myid),
                'site_name'=>strip_tags($this->request->getVar('site_name')),
                'product_name'=>strip_tags($this->request->getVar('product_name')),
                'price'=>strip_tags($this->request->getVar('price')),
                'currency'=>strip_tags($this->request->getVar('currency')),
                'description'=>strip_tags($this->request->getVar('description')),
                'rich_description'=>strip_tags($this->request->getVar('rich_description')),
                'keywords'=>strip_tags($this->request->getVar('keywords')),
                'product_image'=>strip_tags($this->request->getVar('product_image')),
                'thumb_image'=>strip_tags($this->request->getVar('thumb_image')),
                'brand'=>strip_tags($this->request->getVar('brand')),
                'category'=>strip_tags($this->request->getVar('category')),
                'sub_category'=>strip_tags($this->request->getVar('sub_category')),
                'sec_category'=>strip_tags($this->request->getVar('sec_category'))
            ];

            $savesiet=$ScrapModel->save($ac_data);

            if ($savesiet) {

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New scrap site (<b>'.strip_tags($this->request->getVar('site_name')).'</b>) created.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                session()->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('settings/product-scrapper'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('settings/product-scrapper'));
            }
        }else{
            return redirect()->to(base_url('settings/product-scrapper'));
        }
    }


    public function update_site($siteid=''){
        if (isset($_POST['save_site'])) {
            $session=session();
            $ScrapModel=new ScrapModel;
            $myid=session()->get('id');

            if (isset($_POST['set_as_default'])) {
                $setas=1;

                $uscrap=$ScrapModel->where('company_id',company($myid))->orderBy('id','desc')->findAll();
                foreach ($uscrap as $us) {
                    $usup=['check_default'=>0];
                    $ScrapModel->update($us['id'],$usup);
                }
            }else{
                $setas=0;
            }

            $ac_data = [
                'company_id'=>company($myid),
                'site_name'=>strip_tags($this->request->getVar('site_name')),
                'product_name'=>strip_tags($this->request->getVar('product_name')),
                'price'=>strip_tags($this->request->getVar('price')),
                'currency'=>strip_tags($this->request->getVar('currency')),
                'description'=>strip_tags($this->request->getVar('description')),
                'rich_description'=>strip_tags($this->request->getVar('rich_description')),
                'keywords'=>strip_tags($this->request->getVar('keywords')),
                'product_image'=>strip_tags($this->request->getVar('product_image')),
                'thumb_image'=>strip_tags($this->request->getVar('thumb_image')),
                'brand'=>strip_tags($this->request->getVar('brand')),
                'category'=>strip_tags($this->request->getVar('category')),
                'sub_category'=>strip_tags($this->request->getVar('sub_category')),
                'sec_category'=>strip_tags($this->request->getVar('sec_category')),
                'check_default'=>$setas
            ];

            $savesiet=$ScrapModel->update($siteid,$ac_data);

            if ($savesiet) {

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'scrap site (<b>'.strip_tags($this->request->getVar('site_name')).'</b>) is updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                session()->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('settings/product-scrapper'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('settings/product-scrapper'));
            }
        }else{
            return redirect()->to(base_url('settings/product-scrapper'));
        }
    }

    public function delete_site($siteid=''){
            $session=session();
            $ScrapModel=new ScrapModel;
            $myid=session()->get('id');

            $deletyesite=$ScrapModel->where('id',$siteid)->delete();

            if ($deletyesite) {

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'scrap site (<b>'.strip_tags($this->request->getVar('site_name')).'</b>) is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                session()->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('settings/product-scrapper'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to delete!');
                return redirect()->to(base_url('settings/product-scrapper'));
            }
    }

    public function update_rate(){
        $session=session();
        $ScrapCurrencyTable=new ScrapCurrencyTable;
        $myid=session()->get('id');

            $crdata=['rate'=>$_GET['rate']];

            $upcur=$ScrapCurrencyTable->update($_GET['cid'],$crdata);

            if ($upcur) {

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'scrap currency rate is updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                
            }else{
                
            }
    }

    public function update_profit(){
        $session=session();
        $ScrapCurrencyTable=new ScrapCurrencyTable;
        $myid=session()->get('id');

            $crdata=['profit'=>$_GET['rate']];

            $upcur=$ScrapCurrencyTable->update($_GET['cid'],$crdata);

            if ($upcur) {

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'scrap currency profit is updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

                
            }else{
                
            }
    }

}
