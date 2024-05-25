<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\FeedbackModel;
use App\Models\Classtablemodel;
use App\Models\HealthModel;

class Health extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $Classtablemodel=new Classtablemodel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		$students=[];


	    		if ($_GET) {
            if (isset($_GET['class'])) {
                if (!empty($_GET['class'])) {
                    $students=$Classtablemodel->where('academic_year',academic_year($myid))->where('deleted',0)->where('class_id',$_GET['class'])->where('company_id',company($myid))->orderby('first_name','asc')->findAll();
                }
            }
             
     
        }  

	    		

	    		

	    		
	    		$data=[
	    			'title'=>'Health | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'students'=>$students

	    		];
	    		
	    		$etype='';
                if ($_GET) {
                  if (isset($_GET['etype'])) {
                      if (!empty($_GET['etype'])) {
                          $etype=$_GET['etype'];
                      }
                  }
                }
                if ($etype=='ajaxex') {
                  echo view('health/health',$data);
                }else{
		    		echo view('header',$data);
            echo view('health/health');
            echo view('footer');
		    	}


	    	
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function add_health_weight(){
		$session=session();
	    $user=new Main_item_party_table();
	    $HealthModel=new HealthModel();
	    $myid=session()->get('id');
			if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('student_id')) {

				$ac_data = [
					'company_id'=>company($myid),
					'academic_year'=>academic_year($myid),
					'student_id'=>$this->request->getVar('student_id'),
					'weight'=>$this->request->getVar('weight')
				];
				
				$checkexits=$HealthModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('deleted',0)->first();

				if ($checkexits) {
					$health_exec=$HealthModel->update($checkexits['id'],$ac_data);
					echo 1;
				}else{
					$health_exec=$HealthModel->save($ac_data);
					echo 1;
				}
				

				if ($health_exec) {
					// echo 1;
				}else{
					// echo 0;
				}
			}
		}
	}


	public function add_health_height(){
		$session=session();
	    $user=new Main_item_party_table();
	    $HealthModel=new HealthModel();
	    $myid=session()->get('id');
			if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('student_id')) {

				$ac_data = [
					'company_id'=>company($myid),
					'academic_year'=>academic_year($myid),
					'student_id'=>$this->request->getVar('student_id'),
					'height'=>$this->request->getVar('height')
				];
				
				$checkexits=$HealthModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('deleted',0)->first();


				if ($checkexits) {
					$health_exec=$HealthModel->update($checkexits['id'],$ac_data);
				}else{
					$health_exec=$HealthModel->save($ac_data);
				}
				

				if ($health_exec) {
					echo 1;
				}else{
					echo 0;
				}
			}
		}
	}


}