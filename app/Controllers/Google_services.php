<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;

use App\Libraries\Google;





class Google_services extends BaseController
{
    public function index()
    {
          return redirect()->to(base_url());
    }



    public function sync_product_to_google($cusval=""){

            $session=session();
            $UserModel=new Main_item_party_table;
            $ProductsModel=new Main_item_party_table;

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


                    $product_data=$ProductsModel->where('id',$cusval)->where('product_method','product')->first();


                    $offerid=$product_data['id']; 
                    $title=$product_data['product_name']; 
                    $description=$product_data['description']; 
                    $pro_price=$product_data['price'];
                    $image_link=base_url('public/images/products').'/'.product_image($product_data['id']);
                    $category=name_of_category($product_data['category']);
                    $brand=name_of_brand($product_data['brand']);
                    $landlink='https://utechoman.com/'.$product_data['slug'];
                    $pro_in=$product_data['pro_in'];



                    /////////////////////////////// Shop  /////////////////////////////////
                    

                    $merchantUrl=get_setting(company($myid),'content_api_key');
                    $merchantId=get_setting(company($myid),'merchant_id');
                    $merchantcontentLang=get_setting(company($myid),'content_language');
                    $merchanttargetCountry=get_setting(company($myid),'target_country');
                    $merchantcurrency=get_setting(company($myid),'merchant_currency');


                    if ($merchantUrl!='' && $merchantId!='' && $merchantcontentLang!='' && $merchanttargetCountry!='' && $merchantcurrency!='') {

                        $client = new \Google();


                        putenv('GOOGLE_APPLICATION_CREDENTIALS=public/user_files/'.$merchantUrl.'');
                        $client->useApplicationDefaultCredentials();

                        $client->addScope('https://www.googleapis.com/auth/content');

                        $service = new \Google_Service_ShoppingContent($client);


                        $product = new \Google_Service_ShoppingContent_Product();
                        $product->setOfferId($offerid);
                        $product->setTitle($title);
                        $product->setDescription($description);
                        $product->setLink($landlink);
                        $product->setBrand($brand);
                        $product->setImageLink($image_link);
                        $product->setContentLanguage($merchantcontentLang);
                        $product->setTargetCountry($merchanttargetCountry);
                        $product->setChannel('online');
                        $product->setAvailability('in stock');
                        $product->setCondition('new');
                        $product->setGoogleProductCategory('');
                        $product->setGtin($pro_in);
                        $product->setGoogleProductCategory($category);



                        $price = new \Google_Service_ShoppingContent_Price();
                        $price->setValue($pro_price);
                        $price->setCurrency($merchantcurrency);

                        // $shipping_price = new Google_Service_ShoppingContent_Price();
                        // $shipping_price->setValue('0.99');
                        // $shipping_price->setCurrency('OMR');

                        // $shipping = new Google_Service_ShoppingContent_ProductShipping();
                        // $shipping->setPrice($shipping_price);
                        // $shipping->setCountry('OM');
                        // $shipping->setService('Standard shipping');

                        // $shipping_weight = new Google_Service_ShoppingContent_ProductShippingWeight();
                        // $shipping_weight->setValue(200);
                        // $shipping_weight->setUnit('grams');

                        $product->setPrice($price);
                        // $product->setShipping(array($shipping));
                        // $product->setShippingWeight($shipping_weight);

                    
                        $result = $service->products->insert($merchantId, $product);
                        echo 1;

                    }else{

                        echo 0;
                    }




                    // print_r($result);
                    /////////////////////////////// Shop  /////////////////////////////////

                    

                    

                    
        }
    }

}