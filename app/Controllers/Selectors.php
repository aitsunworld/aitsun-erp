<?php
namespace App\Controllers; 
use App\Models\ClassModel; 
use App\Models\SubjectModel; 
use App\Models\ProductsModel; 
use App\Models\BookModel; 
use App\Models\Classtablemodel; 
use App\Models\AccountingModel; 
use App\Models\Main_item_party_table;
use App\Models\ResourcesModel; 


class Selectors extends BaseController {

    public function index()
    {  
        return redirect()->to(base_url());
    }

    public function classes($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                $ClassModel = new ClassModel;

                $ClassModel->like('class',$search_text,'both');
                $starray=$ClassModel->where('company_id', company($myid))->where('deleted',0)->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['class'].'">'.$li['class'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }


    public function subjects($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();
                $SubModel = new SubjectModel;

                $SubModel->like('subject_name',$search_text,'both');
                $starray=$SubModel->where('company_id', company($myid))->where('sub_type', 'main_sub')->where('deleted',0)->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['subject_name'].'">'.$li['subject_name'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }



    public function students($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $Classtablemodel=new Classtablemodel;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$Classtablemodel->where('id',$myid)->first();
                

                $Classtablemodel->like('first_name',$search_text,'both');
                $starray=$Classtablemodel->where('company_id', company($myid))->where('academic_year', academic_year($myid))->where('deleted',0)->where('transfer','')->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['student_id'].'" data-text="'.$li['first_name'].'">'.$li['first_name'].'- '.class_name(current_class_of_student(company($user['id']),$li['student_id'])).'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }


    
    public function all_parties($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
              
                

                $UserModel->like('display_name',$search_text,'both');
                $starray=$UserModel->where('company_id', company($myid))->where('deleted',0)->where('main_type','user')->where('transfer','')->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['display_name'].'">'.$li['display_name'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center bg-success">
                        <a data-tranname="'.$search_text.'" id="tranname" class="d-block add_new_party_from_selector tranname ml-5 text-white">
                            <i class="bx bx-plus"></i> New party - <b>"'.$search_text.'"</b>
                        </a></li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }


    public function all_parties_for_create_invoice($view_type='',$search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                ); 

                $UserModel->like('display_name',$search_text,'both');
                if ($view_type!='sales') {
                    $UserModel->where('default_user!=', 1);
                }
                $starray=$UserModel->where('company_id', company($myid))->where('deleted',0)->where('transfer','')->where('main_type','user')->findAll();

                $lis='';
                $lis.='<ul>'; 

                $lis.='<li class="bg-gradient-done position-sticky" style="top:0;"><a data-bs-toggle="modal" data-view_type="'.$view_type.'" data-tranname="'.$search_text.'" data-bs-target="#addcus" id="tranname" class="d-block tranname ml-5 text-dark">
                  <i class="bx bx-plus"></i> New party - <b>"'.$search_text.'"</b>
                </a></li>'; 

                
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $closing_balance=aitsun_round($li['closing_balance'],get_setting(company($myid),'round_of_value'));

                    $lis.='<li class="select_li" data-credit_limit="'.$li['credit_limit'].'" data-closing_balance="'.$closing_balance.'" data-value="'.$li['id'].'" data-text="'.$li['display_name'].'">'.$li['display_name'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center"></li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }


    public function locations($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                $ProductsModel=new Main_item_party_table();

                $ProductsModel->like('product_name',$search_text,'both');
                $starray=$ProductsModel->where('company_id', company($myid))->where('product_method','service')->where('view_as','transport')->where('deleted',0)->where('main_type','product')->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['product_name'].'">'.$li['product_name'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }


    public function library_books($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                $BookModel=new BookModel();

                $BookModel->like('book_title',$search_text,'both');
                $starray=$BookModel->where('company_id', company($myid))->where('deleted',0)->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['book_title'].'">'.$li['book_title'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }

    public function employees($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                
                $starray=$UserModel->like('display_name',$search_text,'both')->where('main_compani_id',main_company_id($myid))->where('deleted',0)->where('u_type!=','customer')->where('u_type!=','vendor')->where('u_type!=','seller')->where('u_type!=','delivery')->orderBy('display_name','ASC')->where('transfer','')->findAll();;

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['display_name'].'">'.$li['display_name'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }



    public function accounts($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $AccountingModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();
                $company_id=company($myid);
                
                // $starray=$UserModel->where('main_compani_id',main_company_id($myid))->where('deleted',0)->where('u_type!=','customer')->where('u_type!=','vendor')->where('u_type!=','seller')->where('u_type!=','delivery')->orderBy('display_name','ASC')->findAll();

                $starray=$AccountingModel->like('group_head',$search_text,'both')->where('company_id',$company_id)->where('deleted',0)->where('type','ledger')->Where('parent_id!=',id_of_group_head($company_id,activated_year($company_id),'Cash-in-Hand'))->where('parent_id!=',id_of_group_head($company_id,activated_year($company_id),'Bank Accounts'))->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['group_head'].'">'.$li['group_head'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }


    public function all_staffs($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $UserModel=new Main_item_party_table;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
              
                

                $UserModel->like('display_name',$search_text,'both');
                $starray=$UserModel->where('company_id', company($myid))->where('deleted',0)->where('u_type','staff')->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['display_name'].'">'.$li['display_name'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }

    public function all_resources($search_text=''){
        if (!empty($search_text)) { 
            $session=session(); 
            if($session->has('isLoggedIn')){ 

                $ResourcesModel=new ResourcesModel;
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
              
                

                $ResourcesModel->like('appointment_resource',$search_text,'both');
                $starray=$ResourcesModel->where('company_id', company($myid))->where('deleted',0)->findAll();

                $lis='';
                $lis.='<ul>'; 
                $sc=0;
                foreach ($starray as $li) {
                    $sc++;
                    $lis.='<li class="select_li" data-value="'.$li['id'].'" data-text="'.$li['appointment_resource'].'">'.$li['appointment_resource'].'</li>';
                }
                if ($sc<1) {
                    $lis.='<li class="text-center">No result</li>';
                }
                $lis.='</ul>';

                echo $lis;

            }
        } 
    }

}