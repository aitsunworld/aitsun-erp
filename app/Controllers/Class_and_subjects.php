<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\TimetableModel;
use App\Models\TeachersModel;




class Class_and_subjects extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $ClassModel = new ClassModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		$class_data=$ClassModel->where('company_id',company($myid))->where('deleted',0)->findAll();

	    		
	    		$data=[
	    			'title'=>'Classes | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'class_data'=>$class_data,

	    		];
	    		
		    		echo view('header',$data);
		    		echo view('class_and_subjects/classes');
		    		echo view('footer');
		    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function add_teacher_from_ajax(){
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
                'u_type' => 'teacher',
                'main_compani_id'=>main_company_id($myid),
                'phone' => strip_tags($this->request->getVar('contact_number')),
                'main_type'=>'user',
                
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

	public function subjects()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $SubjectModel=new SubjectModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		
	    		$sub_data=$SubjectModel->where('sub_type', 'main_sub')->where('deleted',0)->where('company_id',company($myid))->findAll();

	    		
	    		$data=[
	    			'title'=>'Classes | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'sub_data'=>$sub_data,

	    		];
	    		
		    		echo view('header',$data);
		    		echo view('class_and_subjects/subjects');
		    		echo view('footer');
		    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	public function add_subject($cmp=""){
		if ($this->request->getMethod() == 'post') {
			
				$SubjectModel = new SubjectModel();
				$myid=session()->get('id');
				
				$newData = [
					'subject_name' => strip_tags($this->request->getVar('subname')),
					'subject_code' => strip_tags($this->request->getVar('subcode')),
					'company_id' => $cmp,
					'datetime' => now_time($myid),
					'serial_no' => serial_no_sub(company($myid)),
					'sub_type'=>'main_sub'
					
				];

				$result=$SubjectModel->save($newData);
				if ($result) {
					echo 1;
					////////////////////////CREATE ACTIVITY LOG//////////////
		            $log_data=[
		                'user_id'=>$myid,
		                'action'=>'New subject <b>'.strip_tags($this->request->getVar('subname')).'</b> is added.',
		                'ip'=>get_client_ip(),
		                'mac'=>GetMAC(),
		                'created_at'=>now_time($myid),
		                'updated_at'=>now_time($myid),
		                'company_id'=>company($myid),
		            ];

		            add_log($log_data);
		            ////////////////////////END ACTIVITY LOG/////////////////
				}else{
					echo 0;
				}

			}
		

	}


	public function update_subject($subid=""){
	
		if ($this->request->getMethod() == 'post') {
			
				$subject = new SubjectModel();
				$myid=session()->get('id');
				

				$newData = [
					'subject_name' => strip_tags($this->request->getVar('subname')),
					'subject_code' => strip_tags($this->request->getVar('subcode')),
					
				];

				$result=$subject->update($subid,$newData);

				if ($result) {
					echo 1;
					////////////////////////CREATE ACTIVITY LOG//////////////
		            $log_data=[
		                'user_id'=>$myid,
		                'action'=>'Subject <b>'.strip_tags($this->request->getVar('subname')).'</b> details is updated.',
		                'ip'=>get_client_ip(),
		                'mac'=>GetMAC(),
		                'created_at'=>now_time($myid),
		                'updated_at'=>now_time($myid),
		                'company_id'=>company($myid),
		            ];

		            add_log($log_data);
		            ////////////////////////END ACTIVITY LOG/////////////////
				}else{
					echo 0;
				}
				

			}
		

	}


	public function deletesubject($suid=0)
	{
		$model = new Main_item_party_table();
		$subject = new SubjectModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {

			$checkdele=$subject->where('id',$suid)->first();
			if ($checkdele) {
				if ($checkdele['deletable']!=1) {
					$subject->find($suid);
					$deledata=[
	                    'deleted'=>1
	                ];
					$subject->update($suid,$deledata);


						////////////////////////CREATE ACTIVITY LOG//////////////
			            $log_data=[
			                'user_id'=>$myid,
			                'action'=>'Subject <b>'.$checkdele['subject_name'].'</b> is deleted.',
			                'ip'=>get_client_ip(),
			                'mac'=>GetMAC(),
			                'created_at'=>now_time($myid),
			                'updated_at'=>now_time($myid),
			                'company_id'=>company($myid),
			            ];

			            add_log($log_data);
			            ////////////////////////END ACTIVITY LOG/////////////////


					
				}else{

		   			return redirect()->to(base_url('class-and-subjects/subjects'));
				}
			}else{
	   			return redirect()->to(base_url('class-and-subjects/subjects'));
			}

				

		}else{
   			return redirect()->to(base_url('class-and-subjects/subjects'));
		}

	}



	public function deleteclasses($cid=0)
	{
		$table = new TimetableModel();
		$class = new ClassModel();
		$TeachersModel = new TeachersModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {
				$class->find($cid);

				$deledata=[
                    'deleted'=>1
                ];

				$class->update($cid,$deledata);
				$cls_id =$TeachersModel->where('class_id',$cid)->first();

				if ($cls_id) {
					$deleteacher=[
	                    'deleted'=>1
	                ];

					$TeachersModel->update($cls_id['id'],$deleteacher);
				}
				


				$time_table_id =$table->where('class_id',$cid)->findAll();

				foreach ($time_table_id as $ttdd) {
					
					$deletetimetable=[
	                    'deleted'=>1
	                ];
					$table->update($ttdd['id'],$deletetimetable);
				}

				////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'Class <b>'.class_name($cid).'</b> is deleted.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////

		}else{
   			return redirect()->to(base_url('class-and-subjects'));
		}

	}


	public function add_class($org=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$class = new ClassModel();
				$TeachersModel = new TeachersModel();
				$myid=session()->get('id');

				$newData = [
					'class' => strip_tags($this->request->getVar('class')),
					'strength' => strip_tags($this->request->getVar('strength')),
					'teacher' => strip_tags($this->request->getVar('teacher')),
					'leader1' => strip_tags($this->request->getVar('leader1')),
					'leader2' => strip_tags($this->request->getVar('leader2')),
					'rewarding' => strip_tags($this->request->getVar('rewarding')),
					'company_id' => company($org),
					'datetime' => now_time($myid),
					'serial_no' => serial_no_class(company($myid))
				];

				$class->save($newData);
				$class_id=$class->getInsertID();

				$newteacher = [

					'company_id' => company($org),
					'academic_year' => academic_year($myid),
					'class_id' => $class_id,
					'teacher_id' => strip_tags($this->request->getVar('teacher')),
					'deleted' => 0,
						];
				$TeachersModel->save($newteacher);

				////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'New Class <b>'.class_name($class_id).'</b> is added.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////

	            echo 1;
				

			}
		

	}

	public function update_class($classid=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$class = new ClassModel();
				$TeachersModel = new TeachersModel();
				$myid=session()->get('id');

				$newData = [
					'class' => strip_tags($this->request->getVar('class')),
					'strength' => strip_tags($this->request->getVar('strength')),
					'teacher' => strip_tags($this->request->getVar('teacher')),
					'leader1' => strip_tags($this->request->getVar('leader1')),
					'leader2' => strip_tags($this->request->getVar('leader2')),
					'rewarding' => strip_tags($this->request->getVar('rewarding'))
				];

				

				$class->update($classid,$newData);
				

				////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'Class <b>'.class_name($classid).'</b> details is updated.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////

				$classt_data =$TeachersModel->where('class_id',$classid)->where('academic_year',academic_year($myid))->where('company_id',company($myid))->first();

				if ($classt_data) {
					$newteacher = [
						'teacher_id' => strip_tags($this->request->getVar('teacher')),
					];
					$TeachersModel->update($classt_data['id'],$newteacher);
					
				}else{
					$newteacher = [
						'company_id' => company($myid),
						'academic_year' => academic_year($myid),
						'class_id' => $classid,
						'teacher_id' => strip_tags($this->request->getVar('teacher')),
						'deleted' => 0,
					];
					$TeachersModel->save($newteacher);

				}
				echo 1;

			}
		

	}
}