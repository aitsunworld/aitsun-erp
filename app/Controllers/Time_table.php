<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\TimetableModel;
use App\Models\ClassModel;

class Time_table extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $TimetableModel = new TimetableModel();
	    $myid=session()->get('id');

	    $pager = \Config\Services::pager();

	    $results_per_page = 12; 
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		


	    		 if (check_permission($myid,'manage_timetable')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}

	    		 $timetable_data=$TimetableModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->paginate(25);

	    		$data=[
	    			'title'=>'Time Table | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'timetable_data'=>$timetable_data,
	    			'pager' => $TimetableModel->pager,
	    		];
		    		echo view('header',$data);
		    		echo view('time_table/time_table');
		    		echo view('footer');

	    	}else{
	   			return redirect()->to(base_url('users'));
	   		}		
	}


	public function tab_time_table()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();
	        
	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	          

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          
	          
	          $data=[
	            'title'=>'Time Table | Erudite ERP',
	            'user'=>$usaerdata
	            
	          ];
	              echo view('header',$data);
	              echo view('time_table/tab_time_table',$data);
	              echo view('footer');
	         
	        
	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }

	public function add_time_table($org=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$table = new TimetableModel();
				$myid=session()->get('id');

				$newData = [
					'company_id' =>$org,
					'academic_year' => academic_year($myid),
					'week' => strip_tags($this->request->getVar('week')),
					'subject' => strip_tags($this->request->getVar('subject')),
					'class_id' => strip_tags($this->request->getVar('classes')),
					'start_time' => twelve_to_24(strip_tags($this->request->getVar('start_time'))),
					'end_time' => twelve_to_24(strip_tags($this->request->getVar('end_time'))),
					'datetime' => now_time($myid),
					
					
				];

				$table->save($newData);

			}
		

	}


	public function update_time_table($tb_id){
	

		if ($this->request->getMethod() == 'post') {
			
				$table = new TimetableModel();
				$myid=session()->get('id');

				$newData = [
					
					'week' => strip_tags($this->request->getVar('week')),
					'subject' => strip_tags($this->request->getVar('subject')),
					'class_id' => strip_tags($this->request->getVar('classes')),
					'start_time' => twelve_to_24(strip_tags($this->request->getVar('start_time'))),
					'end_time' => twelve_to_24(strip_tags($this->request->getVar('end_time'))),
					'datetime' => now_time($myid),
					
				];

				$table->update($tb_id,$newData);

			}
		

	}
	public function deletetime_table($tid=0)
	{
		$table = new TimetableModel();
		

		if ($this->request->getMethod() == 'get') {
				$table->find($tid);

				$deledata=[
                    'deleted'=>1
                ];

				$table->update($tid,$deledata);
				$session = session();
				$session->setFlashdata('socsuccess', 'deleted successfully');
				return redirect()->to(base_url('time_table'));

		}else{
   			return redirect()->to(base_url('time_table'));
		}

	}

	public function pdf_timetable($clsid="")
	{
		
		if (!empty($clsid)) {
			$class = new ClassModel();
			$user = new Main_item_party_table();
			$myid=session()->get('id');
			$usaerdata=$user->where('id', $myid)->first();
			$cls_da=$class->where('id', $clsid)->first();

			if ($cls_da) {
				$data=[
					'user'=> $usaerdata,
					'cls_da'=> $cls_da
					
				];

				$mpdf = new \Mpdf\Mpdf([
					    'margin_left' => 5,
					    'margin_right' => 5,
					    'margin_top' => 5,
					    'margin_bottom' => 5,
					]);

				// echo view('timetable/timetablepdf',$data);

				$html = view('timetable/timetablepdf',$data);
	            $mpdf->WriteHTML($html);
	            $this->response->setHeader('Content-Type', 'application/pdf');
	            $mpdf->Output($cls_da['class'] .now_time($myid).'.pdf','I');

				}else{
				return redirect()->to(base_url());
			}

		}else{
			return redirect()->to(base_url());
		}
			

		
	}


	public function notify_time_table(){
		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
		    $title='Time table updated. Check now!';
		    $message='';
		    $url=main_base_url().'time_table/'; 
		    $icon=notification_icons('timetable');
		    $userid='all';
		    $nread=0;
		    $for_who='student';
		    $notid='exam';
		    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
		    echo 1;
	}
}