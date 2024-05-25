<?php


namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\FinancialYears;
use App\Models\CompanySettings;
use App\Models\AccountCategory;
use App\Models\ExgroupheadsModel;

class Ac_group_head extends BaseController
{
    public function index()
    {

        $session=session();
        $ExgroupheadsModel=new ExgroupheadsModel;
        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            $group_data=$ExgroupheadsModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();


            $data = [
                'title' => 'Aitsun ERP-Settings',
                'user'=>$user,   
                'group_data'=>$group_data,
            ];

            echo view('header',$data);
            echo view('settings/ac_account', $data);
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }

    }

    public function save_group_head(){
        $session=session();
        
        $UserModel=new Main_item_party_table;
        $ExgroupheadsModel=new ExgroupheadsModel;
        $Companies= new Companies;
      
        
        $myid=session()->get('id');
        $companyid=company($myid);
        $word=strtolower(strip_tags($this->request->getVar('grouphead_name')));
        $slug=str_replace(' ', '_', $word);

        if ($this->request->getMethod('post')) {  
            $groupdata=[
                'user_id'=>$myid,
                'company_id'=>$companyid,
                'grouphead_name'=>strip_tags($this->request->getVar('grouphead_name')),
                'effect_to'=>strip_tags($this->request->getVar('effect_to')),
                'side'=>strip_tags($this->request->getVar('side')), 
                'slug'=>$slug,

            ];

            if ($ExgroupheadsModel->save($groupdata)) {
                $session->setFlashdata('success_message','Saved!');
                return redirect()->to(base_url('ac_group_head'));
            }else{
                $session->setFlashdata('error_message','Failed to saved!');
                return redirect()->to(base_url('ac_group_head'));
            }
        }

    }

    public function delete_group_head($gid=""){
        $session=session();
        $UserModel=new Main_item_party_table;
        $ExgroupheadsModel=new ExgroupheadsModel();

        $data=[
            'deleted'=>1
        ];

        if ($this->request->getMethod('post')) {            
            if ($ExgroupheadsModel->update($gid,$data)) {
                $session->setFlashdata('success_message','Deleted!');
                return redirect()->to(base_url('ac_group_head'));
            }else{
                $session->setFlashdata('error_message','Failed to saved!');
                return redirect()->to(base_url('ac_group_head'));
            }
        }
    }


    public function edit_group_head($cid=""){
        $session=session();
        $ExgroupheadsModel=new ExgroupheadsModel();
        $word=strtolower(strip_tags($this->request->getVar('grouphead_name')));
        $slug=str_replace(' ', '_', $word);

        if ($this->request->getMethod('post')) {
            
            $groupdata=[
                'grouphead_name'=>strip_tags($this->request->getVar('grouphead_name')),
                'effect_to'=>strip_tags($this->request->getVar('effect_to')),
                'side'=>strip_tags($this->request->getVar('side')), 
                'slug'=>$slug,
            ];

            if ($ExgroupheadsModel->update($cid,$groupdata)) {
                $session->setFlashdata('success_message','Saved!');
                return redirect()->to(base_url('ac_group_head'));
            }else{
                $session->setFlashdata('error_message','Failed to saved!');
                return redirect()->to(base_url('ac_group_head'));
            }
        }    
    }


    // category

    public function save_category(){
        $session=session();
        $AccountCategory=new AccountCategory;
        $Companies= new Companies;
      
        
        $myid=session()->get('id');
        $companyid=company($myid);
        $word=strtolower(strip_tags($this->request->getVar('category_name')));
        $slug=str_replace(' ', '_', $word);

        if ($this->request->getMethod('post')) {  
            $catdata=[
                'user_id'=>$myid,
                'company_id'=>$companyid,
                'category_name'=>strip_tags($this->request->getVar('category_name')),
                'side'=>strip_tags($this->request->getVar('side')),
                'parent_id'=>strip_tags($this->request->getVar('parent_id')),
                'slug'=>$slug,

            ];

            if ($AccountCategory->save($catdata)) {
                $session->setFlashdata('success_message','Saved!');
                return redirect()->to(base_url('ac_group_head'));
            }else{
                $session->setFlashdata('error_message','Failed to saved!');
                return redirect()->to(base_url('ac_group_head'));
            }
        }

    }

    public function delete_category($gid=""){
        $session=session();
        $AccountCategory=new AccountCategory();
        $data=[
            'deleted'=>1
        ];

        if ($this->request->getMethod('post')) {            
            if ($AccountCategory->update($gid,$data)) {
                $session->setFlashdata('success_message','Deleted!');
                return redirect()->to(base_url('ac_group_head'));
            }else{
                $session->setFlashdata('error_message','Failed to saved!');
                return redirect()->to(base_url('ac_group_head'));
            }
        }
    }

    public function edit_category($cid=""){
        $session=session();
        $AccountCategory=new AccountCategory();
        $word=strtolower(strip_tags($this->request->getVar('category_name')));
        $slug=str_replace(' ', '_', $word);

        if ($this->request->getMethod('post')) {
            
            $groupdata=[
                'category_name'=>strip_tags($this->request->getVar('category_name')),
                'side'=>strip_tags($this->request->getVar('side')),
                'parent_id'=>strip_tags($this->request->getVar('parent_id')),
                'slug'=>$slug,
            ];

            if ($AccountCategory->update($cid,$groupdata)) {
                $session->setFlashdata('success_message','Saved!');
                return redirect()->to(base_url('ac_group_head'));
            }else{
                $session->setFlashdata('error_message','Failed to saved!');
                return redirect()->to(base_url('ac_group_head'));
            }
        }    
    }

}
