<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProductsModel;
use App\Models\CompanySettings;


class Seo extends BaseController
{

	public function index()
    {
    	$session=session();

        if($session->has('isLoggedIn')){
        	$UserModel=new Main_item_party_table;
 


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
                'title' => 'Aitsun ERP-SEO',
                'user'=>$user,
            ];

            if (is_aitsun(company($myid))) {
            	echo view('header',$data);
	            echo view('seo/seo');
	            echo view('footer');
            }else{
	        	return redirect()->to(base_url());
	        }
            

        }else{
        	return redirect()->to(base_url('users/login'));
        }
    }




    public function site_map()
    {
    	$session=session();

        if($session->has('isLoggedIn')){
        	$UserModel=new Main_item_party_table;
            $ProductsModel= new Main_item_party_table;
            


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 


            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           
        
            
            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }


            if ($_GET) {
                if (isset($_GET['show'])) {
                    if ($_GET['show']=='custom') {
                        if (isset($_GET['product_name'])) {
                            $ProductsModel->like('product_name', $_GET['product_name'], 'both'); 
                        }

                        if (isset($_GET['from']) && isset($_GET['to'])) {
                            $from=$_GET['from'];
                            $dto=$_GET['to'];

                            if (!empty($from) && empty($dto)) {
                                $ProductsModel->where('date(created_at)',$from);
                            }
                            if (!empty($dto) && empty($from)) {
                                $ProductsModel->where('date(created_at)',$dto);
                            }

                            if (!empty($dto) && !empty($from)) {
                                $ProductsModel->where("date(created_at) BETWEEN '$from' AND '$dto'");
                            }

                            if (empty($dto) && empty($from)) {
                                $ProductsModel->where('date(created_at)',get_date_format(now_time($myid),'Y-m-d'));
                            }
                        }
                    }
                }
                

            }else{
                $ProductsModel->where('date(created_at)',get_date_format(now_time($myid),'Y-m-d'));
            }

            $all_products=$ProductsModel->where('company_id',company($myid))->where('deleted',0)->findAll();

            



            $data = [
                'title' => 'Aitsun ERP-Sitemap',
                'user'=>$user,
                'product_urls'=>$all_products
            ];

            if (is_aitsun(company($myid))) {
            	echo view('header',$data);
	            echo view('seo/site_map');
	            echo view('footer');
            }else{
	        	return redirect()->to(base_url());
	        }
            

        }else{
        	return redirect()->to(base_url('users/login'));
        }
    }



    public function seo_merchant($cid=""){
        $session=session();

        $UserModel=new Main_item_party_table;
        $CompanySettings= new CompanySettings;


         $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
        $user=$UserModel->where('id',$myid)->first();
        $message='';

       
        if ($this->request->getMethod('post')) {

            if (!empty($_FILES['content_api_key']['name'])) {
                    $target_dir = "public/user_files/";
                    $target_file = $target_dir . time().basename($_FILES["content_api_key"]["name"]);
                    $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    
                    
                    if($FileType =='json'){
                        $fileName = time().basename($_FILES["content_api_key"]["name"]);
                        move_uploaded_file($_FILES["content_api_key"]["tmp_name"], $target_file);


                        $seo_data = [
                            'merchant_id'=>strip_tags($this->request->getVar('merchant_id')),
                            'content_language'=>strip_tags($this->request->getVar('content_language')),
                            'target_country'=>strip_tags($this->request->getVar('target_country')),
                            'merchant_currency'=>strip_tags($this->request->getVar('merchant_currency')),
                            'content_api_key'=>$fileName,
                        ];
                        
                    }else{
                         $seo_data = [
                            'merchant_id'=>strip_tags($this->request->getVar('merchant_id')),
                            'content_language'=>strip_tags($this->request->getVar('content_language')),
                            'target_country'=>strip_tags($this->request->getVar('target_country')),
                            'merchant_currency'=>strip_tags($this->request->getVar('merchant_currency')),

                        ];

                        $message='But file not uploaded ';
                    }
                    
                }else{
                    $seo_data = [
                        'merchant_id'=>strip_tags($this->request->getVar('merchant_id')),
                        'content_language'=>strip_tags($this->request->getVar('content_language')),
                        'target_country'=>strip_tags($this->request->getVar('target_country')),
                        'merchant_currency'=>strip_tags($this->request->getVar('merchant_currency')),
                    ];
                }

                $update_user=$CompanySettings->update(get_setting(company($myid),'id'),$seo_data);
        
                    if ($update_user) {
                        ////////////////////////CREATE ACTIVITY LOG//////////////
                        $seo_data=[
                            'user_id'=>$myid,
                            'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> seo updated.',
                            'ip'=>get_client_ip(),
                            'mac'=>GetMAC(),
                            'created_at'=>now_time($myid),
                            'updated_at'=>now_time($myid),
                            'company_id'=>company($myid),
                        ];

                    add_log($seo_data);
                         $session->setFlashdata('pu_msg','Details Saved! '.$message);
                         return redirect()->to(base_url('seo'));
                         

                    }else{
                        $session->setFlashdata('pu_er_msg','Failed!');
                         return redirect()->to(base_url('seo'));
                    
                    }
                }
        }
}
