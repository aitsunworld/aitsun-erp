<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\PermissionsModel;
use App\Models\Permissionlist;
use App\Models\Companies;



class Permission extends BaseController
{
	public function index($staff_id)
	{
		$session=session(); 
	    $myid=session()->get('id');
	    $Main_item_party_table=new Main_item_party_table; 
	    $Permissionlist=new Permissionlist; 

	   	$pager = \Config\Services::pager();

	    $results_per_page = 12; 
	    
	    if ($session->has('isLoggedIn')) {
	    
			if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

			$data=[
				'title'=>'Permission',
				'user'=>$Main_item_party_table->where('id', session()->get('id'))->first(),
				'staff'=>$Main_item_party_table->where('id', $staff_id)->where('deleted',0)->first(),
				'permission_lists'=>$Permissionlist->paginate(18),
				'pager' =>$Permissionlist->pager,

			];
			
	    		echo view('header',$data);
	    		echo view('user_master/permission',$data);
	    		echo view('footer');
		    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function is_permission_allowed(){

        $PermissionsModel = new PermissionsModel();
         $myid=session()->get('id');
            if ($this->request->getMethod()=='post') {

			$existingPermission = $PermissionsModel->where('user_id', $this->request->getVar('user_id'))->where('permission_name', $this->request->getVar('permission_name'))->first();

                $ad=[
                    'company_id'=>company($myid),
                    'user_id'=>strip_tags($this->request->getVar('user_id')),
                    'permission_name'=>strip_tags($this->request->getVar('permission_name')),
                    'is_allowed'=>strip_tags($this->request->getVar('is_permission_allowed'))
                ];

                if ($existingPermission) {

                	 if ($PermissionsModel->update($existingPermission['id'],$ad)) {
	                	echo 1;
	                }else{
	                    echo 0;
	                }
                }else{
                	 if ($PermissionsModel->save($ad)) {
	                	echo 1;
	                }else{
	                    echo 0;
	                }
                }


            }else{
                echo 0;
            }

    }

}