<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\VehicleModel;
use App\Models\StudentlocationModel;
use App\Models\AccountingModel;
use App\Models\PaymentsModel;
use App\Models\VoucherListModel;

class School_transport extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $VehicleModel = new VehicleModel();
	    $AccountingModel = new AccountingModel();
	    $StudentlocationModel=new StudentlocationModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$pager = \Config\Services::pager();
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	

	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		if ($_GET) {
		            if (isset($_GET['student'])) {
		                if (!empty($_GET['student'])) {
		                    $StudentlocationModel->like('student_id', $_GET['student'], 'both'); 
		                }
		            }
		            if (isset($_GET['location'])) {
		                if (!empty($_GET['location'])) {
		                    $StudentlocationModel->like('item_id', $_GET['location'], 'both'); 
		                }
		            }
		            
		        }

	    		$vehicle_data=$VehicleModel->where('deleted',0)->where('company_id',company($myid))->findAll();

	    		$std_location_data=$StudentlocationModel->where('deleted',0)->where('company_id',company($myid))->paginate(25);

	    		$entry_type='expense';


	    		$data=[
	    			'title'=>'Transport Management | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'vehicle_data'=>$vehicle_data,
	    			'std_location_data'=>$std_location_data,
	    			'entry_type'=>$entry_type,
	    			'view_method'=>'add',
                    'voucher_type'=>'',
	    			'pager'=> $StudentlocationModel->pager,

	    		];
	    		
	    		echo view('header',$data);
	    		echo view('school_transport/vehicle');
	    		echo view('footer');
		    	


	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	public function add_vehicle(){
		
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$VehicleModel = new VehicleModel();
			$AccountingModel = new AccountingModel();

			$newData = [
				'company_id' => company($myid),
				'vehicle_name' => strip_tags($this->request->getVar('vehiclename')),
				'vehicle_number' => strip_tags($this->request->getVar('vehiclenumber')),
				'driver' => strip_tags($this->request->getVar('driver')),
				'contact'=>strip_tags($this->request->getVar('contact')),
				'deleted' => 0,
			];

			
				$VehicleModel->save($newData);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New vehicle <b>'.strip_tags($this->request->getVar('vehiclename')).'('.strip_tags($this->request->getVar('vehiclenumber')).')</b> is added.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
                echo 'passed';
				
			}

		}


	public function update_vehicle($sp_id=""){
		
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$VehicleModel = new VehicleModel();

			$newData = [
				'vehicle_name' => strip_tags($this->request->getVar('vehiclename')),
				'vehicle_number' => strip_tags($this->request->getVar('vehiclenumber')),
				'driver' => strip_tags($this->request->getVar('driver')),
				'contact'=>strip_tags($this->request->getVar('contact')),

			];

			
				$VehicleModel->update($sp_id,$newData);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Vehicle <b>'.strip_tags($this->request->getVar('vehiclename')).'</b> details is updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
				
			echo 'passed';
		}

	}


	public function deletevehicle($spid=0)
	{
		
		$VehicleModel = new VehicleModel();
		$myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
				$VehicleModel->find($spid);
				$deledata=[
                    'deleted'=>1
                ];
				$VehicleModel->update($spid, $deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Vehicle <b>'.get_vehicle_data($spid,'vehicle_name').'</b> is deleted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

				
				

		}else{
   			return redirect()->to(base_url('school_transport'));
		}

	}


	

	public function add_std_location(){
		
	
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$StudentlocationModel=new StudentlocationModel();

			$newData = [
				'company_id' => company($myid),
				'student_id' => strip_tags($this->request->getVar('students')),
				'item_id' => strip_tags($this->request->getVar('location')),
				'vehicle_id' => strip_tags($this->request->getVar('vehicle')),

				'deleted' => 0
				

			];

			$checklocation=$StudentlocationModel->where('student_id',strip_tags($this->request->getVar('students')))->where('deleted',0)->first();

			if (!$checklocation) {
			
				$StudentlocationModel->save($newData);

                
				
				}else{
							echo 'location_exist';
						}
			}

		}




	public function update_std_location($pt_id=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$StudentlocationModel = new StudentlocationModel();

				$newData = [ 
					'item_id' => strip_tags($this->request->getVar('location')),

				];
 
					$StudentlocationModel->update($pt_id,$newData);

					
				}

			}


	public function deletestdlocation($spid=0)
	{
		$StudentlocationModel = new StudentlocationModel();
		$myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
				$StudentlocationModel->find($spid);
				$deledata=[
                    'deleted'=>1
                ];
				$StudentlocationModel->update($spid, $deledata);

				

		}else{
   			return redirect()->to(base_url('school_transport'));
		}
	}

	public function add_driver_from_ajax(){
        $session=session();
        $myid=session()->get('id');

        $con = array( 
            'id' => session()->get('id') 
        );

        $UserModel= new Main_item_party_table;

         if (isset($_POST['display_name'])) {
            $ps_data = [
                'company_id' => company($myid),
                'display_name'=>$this->request->getVar('display_name'),
                'u_type' => 'driver',
                'main_compani_id'=>main_company_id($myid),
                'phone' => strip_tags($this->request->getVar('contact_number')),
                
            ];

            $sc=$UserModel->save($ps_data);
            $sinserid=$UserModel->insertID();

            if ($sc) {
               echo $sinserid;
            }else{
                echo 0;
            }
        }
    }

    
}