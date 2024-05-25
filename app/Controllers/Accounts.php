<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\Companies;
use App\Models\FinancialYears;
use App\Models\AccountingModel;
use App\Models\CustomerBalances; 

class Accounts extends BaseController {
    
        public function index()
        {

            $session=session();
            if($session->has('isLoggedIn')){

                $pager = \Config\Services::pager();

                $UserModel=new Main_item_party_table;
                $AccountingModel=new Main_item_party_table;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                $acti=activated_year(company($myid));


                if ($_GET) {
                    if (isset($_GET['account_name'])) {
                        if (!empty($_GET['account_name'])) {
                            $AccountingModel->like('group_head', $_GET['account_name']); 
                    }
                }
            }
                 

        $AccountingModel->groupStart();
        $AccountingModel->where('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Bank Accounts'));
        $AccountingModel->orWhere('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Cash-in-Hand'));
        $AccountingModel->orWhere('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Direct Expenses'));
        $AccountingModel->orWhere('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Direct Incomes'));
        $AccountingModel->orWhere('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Indirect Expenses'));
        $AccountingModel->orWhere('parent_id',id_of_group_head(company($myid),activated_year(company($myid)),'Indirect Incomes'));
        $AccountingModel->groupEnd();

                $ledger_data=$AccountingModel->where('company_id',company($myid))->where('type','ledger')->where('deleted',0)->orderBy('id','DESC')->paginate(12);


                $data = [
                    'title'       => 'Aitsun ERP- Accounts',
                    'user'        => $user,
                    'ledger_data' => $ledger_data,
                    'pager'       => $AccountingModel->pager,
                ];

                echo view('header',$data);
                echo view('accounts/account', $data);
                echo view('footer');
            
        }else{
            return redirect()->to(base_url('users/login'));
            }
        }

        public function group_head()
        {

            $session=session();
            if($session->has('isLoggedIn')){

                $UserModel=new Main_item_party_table;
                $AccountingModel=new Main_item_party_table;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();


                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                
              
                $acti=activated_year(company($myid));

                $group_head=$AccountingModel->where('company_id',company($myid))->where('primary',1)->where('type','group_head')->where('deleted',0)->findAll();
                
                $data = [
                    'title' => 'Aitsun ERP- Accounts',
                    'user'=>$user,
                    'group_head'=>$group_head,
                ];

                echo view('header',$data);
                echo view('accounts/group_head', $data);
                echo view('footer');
            
            }else{
                return redirect()->to(base_url('users/login'));
                }
            }


        public function add_ledger_ajax(){
            $session=session();
            $myid=session()->get('id');
            $AccountingModel=new Main_item_party_table; 

            
             if ($this->request->getMethod()=='post') {
                    
                $ac_data = [
                    'company_id'      => company($myid),
                    'group_head'      => strip_tags(trim($this->request->getVar('ledger_name'))),
                    'parent_id'       => strip_tags(trim($this->request->getVar('group_head'))),
                    'opening_balance' => strip_tags($this->request->getVar('opening_type')).strip_tags($this->request->getVar('opening_balance')),
                    'closing_balance' => strip_tags($this->request->getVar('opening_type')).strip_tags($this->request->getVar('opening_balance')),
                    'opening_type'    => strip_tags($this->request->getVar('opening_type')),
                    'closing_type'    => '',
                    'type'            => 'ledger',
                ];
                $insert_data=$AccountingModel->save($ac_data);
                $ledger_id=$AccountingModel->insertID();
                if ($insert_data) {
                    // $session->setFlashdata('pu_msg', 'Saved!');
                    // return redirect()->to(base_url('accounts'));
                    echo $ledger_id;
                }else{
                    echo 0;
                }
                
            }
        }

        public function get_ledger_ac_form($entype=''){
            $UserModel = new Main_item_party_table();
            $data=[
                'title'=>'Add ledger form - Apanel',
                'entype'=>$entype,
                'user'=> $UserModel->where('id', session()->get('id'))->first(),
            ];

            $session=session();

            if ($session->has('isLoggedIn')){ 
                echo view('accounts/add_ledger_acount_form',$data);
            }
        }

    public function add_group_head(){
             $session=session();
            $myid=session()->get('id');
            $AccountingModel=new Main_item_party_table;

             if ($this->request->getMethod()=='post') {
                    if (strip_tags(trim($this->request->getVar('primary')))!=1) {
                        $parent_id=strip_tags(trim($this->request->getVar('group_head_pr')));
                        $nature='';
                    }else{
                        $parent_id='';
                        $nature=strip_tags(trim($this->request->getVar('nature')));
                    }
                $ac_data = [
                    'company_id' => company($myid),
                    'group_head'=>strip_tags(trim($this->request->getVar('grouphead_name'))),
                    'primary'=>strip_tags(trim($this->request->getVar('primary'))),
                    'type'=>'group_head',
                    'nature'=>$nature,
                    'parent_id'=>$parent_id,
                ];

                if ($AccountingModel->save($ac_data)) {

                    $session->setFlashdata('pu_msg', 'Saved!');
                    return redirect()->to(base_url('accounts/group-head'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to save!');
                    return redirect()->to(base_url('accounts/group-head'));
                }
        }
    }

    public function edit_group_head($gpid=''){
             $session=session();
            $myid=session()->get('id');
            $AccountingModel=new Main_item_party_table;

             if ($this->request->getMethod()=='post') {

                if (strip_tags(trim($this->request->getVar('primary')))!=1) {

                    $parent_id=strip_tags(trim($this->request->getVar('group_head_pr')));
                    $nature='';
                }else{
                    $parent_id='';
                    $nature=strip_tags(trim($this->request->getVar('nature')));
                }


                $ac_data = [
                    'group_head'=>strip_tags(trim($this->request->getVar('grouphead_name'))),
                    'primary'=>strip_tags(trim($this->request->getVar('primary'))),
                    'type'=>'group_head',
                    'nature'=>$nature,
                    'parent_id'=>$parent_id,
                ];

                if ($AccountingModel->update($gpid,$ac_data)) {
                    $session->setFlashdata('pu_msg', 'Saved!');
                    return redirect()->to(base_url('accounts/group-head'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to save!');
                    return redirect()->to(base_url('accounts/group-head'));
                }
        }
    }


     public function delete_gropu_head($gpid=""){
            $AccountingModel = new Main_item_party_table();

            $session=session();

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            $AccountingModel->where('id',$gpid)->first();

                $deledata=[
                    'deleted'=>1
                ];

            $AccountingModel->update($gpid,$deledata);

            $parent_id=$AccountingModel->where('parent_id',$gpid)->findAll();

            foreach ($parent_id as $pid) {
                 $AccountingModel->find($pid['id']);

                    $deledata=[
                            'deleted'=>1
                    ];

                    $d_mg=$AccountingModel->update($pid['id'],$deledata);
            }

                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('accounts/group-head'));
            
        }
        

         public function add_ledger(){
             $session=session();
            $myid=session()->get('id');
            $AccountingModel=new Main_item_party_table; 

             if ($this->request->getMethod()=='post') {
                    
                $ac_data = [
                    'company_id' => company($myid),
                    'group_head'=>strip_tags(trim($this->request->getVar('ledger_name'))),
                    'parent_id'=>strip_tags(trim($this->request->getVar('group_head'))),
                    'opening_balance'=>strip_tags($this->request->getVar('opening_type')).strip_tags($this->request->getVar('opening_balance')),
                    'closing_balance'=>strip_tags($this->request->getVar('opening_type')).strip_tags($this->request->getVar('opening_balance')),
                    'opening_type'=>strip_tags($this->request->getVar('opening_type')),
                    'closing_type'=>'',
                    'type'=>'ledger',
                ];
                $insert_data=$AccountingModel->save($ac_data);
                $ledger_id=$AccountingModel->insertID();
                if ($insert_data) {

                    

                    $session->setFlashdata('pu_msg', 'Saved!');
                    return redirect()->to(base_url('accounts/ledger-accounts'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to save!');
                    return redirect()->to(base_url('accounts/ledger-accounts'));
                }
        }
    }



    public function delete_ledger($gpid=""){
            $AccountingModel = new Main_item_party_table();

            $session=session();

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            $AccountingModel->where('id',$gpid)->first();

                $deledata=[
                    'deleted'=>1
                ];

            $d_mg=$AccountingModel->update($gpid,$deledata);

            $parent_id=$AccountingModel->where('parent_id',$gpid)->findAll();

            foreach ($parent_id as $pid) {
                 $AccountingModel->find($pid['id']);

                    $deledata=[
                            'deleted'=>1
                    ];

                    $d_mg=$AccountingModel->update($pid['id'],$deledata);
            }

           
            if ($d_mg) {

                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('accounts/ledger-accounts'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to delete!');
                return redirect()->to(base_url('accounts/ledger-accounts'));
            }
        }

    public function edit_ledger($gpid=''){
             $session=session();
            $myid=session()->get('id');
            $AccountingModel=new Main_item_party_table; 

             if ($this->request->getMethod()=='post') {

               $leddata=$AccountingModel->where('id',$gpid)->first();

               $old_opening_balance=0;
               $old_closing_balance=0;
               if ($leddata) {
                   $old_opening_balance=$leddata['opening_balance'];
                   $old_closing_balance=$leddata['closing_balance'];
               }
               $opbal=strip_tags($this->request->getVar('opening_type')).strip_tags($this->request->getVar('opening_balance'));

               $final_closing=($old_closing_balance-$old_opening_balance)+$opbal;

                $ac_data = [  
                    'group_head'=>strip_tags(trim($this->request->getVar('ledger_name'))),
                    // 'parent_id'=>strip_tags(trim($this->request->getVar('group_head'))),
                    'opening_balance'=>$opbal,
                    'closing_balance'=>$opbal,
                    'opening_type'=>''
                ];
 
                if ($AccountingModel->update($gpid,$ac_data)) {
                    $session->setFlashdata('pu_msg', 'Saved!');
                    return redirect()->to(base_url('accounts/ledger-accounts'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed to save!');
                    return redirect()->to(base_url('accounts/ledger-accounts'));
                }
        }
    }
}