<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\SubjectModel;
use App\Models\SportsparticipantModel;
use App\Models\SportseventModel;
use App\Models\EventModel;
use App\Models\AnalyticsModel;
use App\Models\RewardingModel;

class School_activities extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $myid=session()->get('id');
	    
	  
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	

	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		if (check_permission($myid,'manage_library')==true || usertype($myid)=='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));}

	    		
	    		$data=[
	    			'title'=>'School activities management | Aitsun ERP',
	    			'user'=>$usaerdata,

	    		];

	    		
		    	echo view('header',$data);
		    	echo view('school_activities/school_activities');
		    	echo view('footer');


	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}



	public function sports()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $myid=session()->get('id');
	    $SubjectModel = new SubjectModel();
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		 if (check_permission($myid,'manage_sports')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}


	    		 $sports_data=$SubjectModel->where('sub_type','sports_sub')->where('deleted',0)->where('company_id',company($myid))->findAll();
	    		
	    		$data=[
	    			'title'=>'Sports Management | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'sports_data'=>$sports_data
	    			

	    		];
	    		

		    		echo view('header',$data);
		    		echo view('school_activities/sports');
		    		echo view('footer');
		    	

	    		//complete exam after date is complete
	    		$SportseventModel= new SportseventModel();

	    		$main_exam_data=$SportseventModel->where('company_id',company($myid))->where('status!=','completed')->where('academic_year',academic_year($myid))->where('deleted',0)->findAll();
				$count=0;
				foreach ($main_exam_data as $ex) {
					$exam_date = strtotime(get_date_format($ex['to'],'Y-m-d'));
					$current_date = strtotime(get_date_format(now_time($myid),'Y-m-d')); 
					
					if ($current_date>$exam_date) { 
						$dataev=[
							'status'=>'completed'
						];

						$SportseventModel->update($ex['id'],$dataev);
					}

				}
	    		//complete exam after date is complete


	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}



	public function add_sports($cmp=""){
		
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$model = new SubjectModel();

			$newData = [
				'subject_name' => strip_tags($this->request->getVar('sportsname')),
				'subject_code' => strip_tags($this->request->getVar('sportscode')),
				'company_id' => $cmp,
				'datetime' => now_time($myid),
				'sub_type'=>'sports_sub',
				'parent_id' => strip_tags($this->request->getVar('sports_id')),
				'serial_no' => serial_no_sports(company($myid)),
				

			];

			
				$model->save($newData);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New sports <b>'.strip_tags($this->request->getVar('sportsname')).'</b> is added.',
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



	public function update_sports($sp_id=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new SubjectModel();

				$newData = [
					'subject_name' => strip_tags($this->request->getVar('sportsname')),
					'subject_code' => strip_tags($this->request->getVar('sportscode'))

				];

				
					$model->update($sp_id,$newData);

					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'Sports <b>'.strip_tags($this->request->getVar('sportsname')).'</b> details is updated.',
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


	public function deletesports($spid=0)
	{
		
		$subject = new SubjectModel();
		$myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
				$subject->find($spid);
				$deledata=[
                    'deleted'=>1
                ];
				$subject->update($spid, $deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Sports <b>'.get_subject_data($spid,'subject_name').'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

				

		}else{
   			return redirect()->to(base_url('sports'));
		}

	}


	public function sports_participants()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      $SportsparticipantModel = new SportsparticipantModel();

	      $pager = \Config\Services::pager();

	      $results_per_page = 12; 
	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();
	        

	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	          

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          if ($_GET) {
		            if (isset($_GET['sports_category'])) {
		                if (!empty($_GET['sports_category'])) {
		                    $SportsparticipantModel->like('sports_id', $_GET['sports_category'], 'both'); 
		                }
		            }
		            if (isset($_GET['students'])) {
		                if (!empty($_GET['students'])) {
		                    $SportsparticipantModel->like('student_id', $_GET['students'], 'both'); 
		                }
		            }
		            
		     
		        }

	          $sports_participants_data=$SportsparticipantModel->where('deleted',0)->where('company_id',company($myid))->where('type','sports')->where('academic_year',academic_year($myid))->paginate(25);
	          
	          $data=[
	            'title'=>'Sports | Erudite ERP',
	            'user'=>$usaerdata,
	            'sports_participants_data'=>$sports_participants_data,
	            'pager' => $SportsparticipantModel->pager,
	            
	          ];

	         
	              echo view('header',$data);
	              echo view('school_activities/sports_participants',$data);
	              echo view('footer');
	         
	        
	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }



	public function add_sports_participants($cmp=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new SportsparticipantModel();
				$sports_cat =strip_tags($this->request->getVar('sports'));
				$std_id = strip_tags($this->request->getVar('student'));

				$newData = [
					'student_id' => $std_id,
					'sports_id' => $sports_cat,
					'company_id' => $cmp,
					'academic_year' => academic_year($myid),
					'datetime' => now_time($myid),
					'serial_no' => serial_no_participant(company($myid)),
					'type' => 'sports',
					

				];


				$checksports=$model->where('student_id',$std_id)->where('sports_id',$sports_cat)->where('deleted',0)->where('type','sports')->where('academic_year',academic_year($myid))->first();

				if (!$checksports) {

					$model->save($newData);
							echo 'passed';

					// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
					    $title='Congratulations!, you joined '.subjects_name($this->request->getVar('sports')).' today';
					    $message='';
					    $url=main_base_url(); 
					    $icon=notification_icons('sports');
					    $userid=$this->request->getVar('student');
					    $nread=0;
					    $for_who='student';
					    $notid='sports';
					    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
					// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]


					    ////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'<b>'.user_name($std_id).'</b>joined to <b>'.subjects_name($sports_cat).'</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
							
						}else{
								echo 'sports_exist';
						}



					
					
				}

			}


	public function update_sports_participants($pt_id=""){
		
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$model = new SportsparticipantModel();
			$std_id = strip_tags($this->request->getVar('student'));
			$sports_cat = strip_tags($this->request->getVar('sports'));

			$newData = [
				'student_id' => $std_id,
				'sports_id' => $sports_cat,

			];

				$sprts=$model->where('id',$pt_id)->first();

				if ($sprts['student_id']==$std_id || $sprts['sports_id']==$sports_cat) {
					$model->update($pt_id,$newData);
					////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'<b>'.user_name($std_id).'</b>joined to <b>'.subjects_name($sports_cat).'</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
				}else{

					$checksports=$model->where('student_id',$std_id)->where('sports_id',$sports_cat)->where('deleted',0)->where('type','sports')->where('academic_year',academic_year($myid))->first();

					if (!$checksports) {
						$model->update($pt_id,$newData);

						////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'<b>'.user_name($std_id).'</b>joined to <b>'.subjects_name($sports_cat).'</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
					}else{
						echo 'email_exist';
					}
				
				}

				
			}

		}



	public function delete_sports_participants($psid=0)
	{
		
		$model = new SportsparticipantModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {
				$model->find($psid);
				$deledata=[
                    'deleted'=>1
                ];
				$model->update($psid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'<b>'.user_name(get_sports_participant_data($psid,'student_id')).'</b> removed to <b>'.subjects_name(get_sports_participant_data($psid,'sports_id')).'</b>',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

				

		}else{
   			return redirect()->to(base_url('sports'));
		}

	}

	public function add_involve_sports(){
		$session=session();
	    $user=new Main_item_party_table();
	    $AnalyticsModel=new AnalyticsModel();
	    $myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('student_id')) {

				$ac_data = [
					'company_id'=>company($myid),
					'academic_year'=>academic_year($myid),
					'student_id'=>$this->request->getVar('student_id'),
					'sports_eccc_id'=>$this->request->getVar('sports_id'),
					'involve_sports'=>$this->request->getVar('involve_sports')
				];
				
				$checkexits=$AnalyticsModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('sports_eccc_id',$this->request->getVar('sports_id'))->where('deleted',0)->first();

				if ($checkexits) {
					$health_exec=$AnalyticsModel->update($checkexits['id'],$ac_data);
				}else{
					$health_exec=$AnalyticsModel->save($ac_data);
				}
				

				if ($health_exec) {
					echo 1;
				}else{
					echo 0;
				}
			}
		}
	}


	public function sports_events()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      $SportseventModel = new SportseventModel();

	      $pager = \Config\Services::pager();

	      $results_per_page = 12;

	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();
	       
	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	          

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          $sportsevents_data=$SportseventModel->where('deleted',0)->where('company_id',company($myid))->where('type','sports')->where('academic_year',academic_year($myid))->paginate(25);
	          
	          $data=[
	            'title'=>'Sports | Erudite ERP',
	            'user'=>$usaerdata,
	            'sportsevents_data'=>$sportsevents_data,
	            'pager' => $SportseventModel->pager,
	            
	          ];

	          
	              echo view('header',$data);
	              echo view('school_activities/sports_events',$data);
	              echo view('footer');
	          

	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }




	public function add_spevents($spvcmp=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new SportseventModel();
				$event = new EventModel();

				$newData = [
					'company_id' => $spvcmp,
					'academic_year' => academic_year($myid),
					'events_name' => strip_tags($this->request->getVar('events_name')),
					'from' => strip_tags($this->request->getVar('from')),
					'to' => strip_tags($this->request->getVar('to')),
					'related_to' => strip_tags($this->request->getVar('related_to')),
					'c_type' => strip_tags($this->request->getVar('c_type')),
					'place' => strip_tags($this->request->getVar('place')),
					'subject_id' => strip_tags($this->request->getVar('subject_id')),
					'serial_no' => serial_no_sportsevent(company($myid)),
					'type'=>'sports'
					

				];

				
					$model->save($newData);
					$spevent_id = $model->getInsertID();


					$newevent = [

					'company_id' => $spvcmp,
					'academic_year' => academic_year($myid),
					'title' => strip_tags($this->request->getVar('events_name')),
					'start_event' => strip_tags($this->request->getVar('from')),
					'end_event' => get_date_format($this->request->getVar('to'),'Y-m-d').' 23:00:00',
					'secondary_id'=> $spevent_id,
					

				];
				$event->save($newevent);

				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='New event <b>'.strip_tags($this->request->getVar('events_name')).'</b> added.';
				    $message='';
				    $url=main_base_url().'calendar'; 
				    $icon=notification_icons('event');
				    $userid='all';
				    $nread=0;
				    $for_who='student';
				    $notid='event';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

			    // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='New event <b>'.strip_tags($this->request->getVar('events_name')).'</b> added.';
				    $message='';
				    $url=base_url().'/calendar'; 
				    $icon=notification_icons('event');
				    $userid='all';
				    $nread=0;
				    $for_who='admin';
				    $notid='event';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]


				    ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New sports event <b>'.strip_tags($this->request->getVar('events_name')).'</b> is added',
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



	public function update_sportsevents($spe_id=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new SportseventModel();
				$event = new EventModel();

				$newData = [
					
					'events_name' => strip_tags($this->request->getVar('events_name')),
					'from' => strip_tags($this->request->getVar('from')),
					'to' => strip_tags($this->request->getVar('to')),
					'related_to' => strip_tags($this->request->getVar('related_to')),
					'c_type' => strip_tags($this->request->getVar('c_type')),
					'place' => strip_tags($this->request->getVar('place')),
					
					

				];

				
					$model->update($spe_id,$newData);

					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'Sports event <b>'.strip_tags($this->request->getVar('events_name')).'</b> details is updated',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
	                ////////////////////////END ACTIVITY LOG/////////////////


					$event_id =$event->where('secondary_id',$spe_id)->first();
					


					$newevent = [
					
					'title' => strip_tags($this->request->getVar('events_name')),
					'start_event' => strip_tags($this->request->getVar('from')),
					'end_event' => get_date_format($this->request->getVar('to'),'Y-m-d').' 23:00:00',
					
					
					

				];
				$event->update($event_id,$newevent);

				echo 1;
					
				}

			}



	public function deletesportsevent($speid=0)
	{
		
		$SportseventModel = new SportseventModel();
		$event = new EventModel();
		$myid=session()->get('id');


		if ($this->request->getMethod() == 'post') {

				$SportseventModel->find($speid);
				$deledata=[
                    'deleted'=>1
                ];
				$SportseventModel->update($speid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Sports event <b>'.get_sports_event_data(company($myid),$speid,'events_name').'</b> is deleted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////


				$event_id=$event->where('secondary_id',$speid)->first();


				$event->find($event_id);
				$event->delete($event_id);


				

		}else{
   			return redirect()->to(base_url('school_activities/sports_events'));
		}

	}	



	public function reward($event_id=""){
		if (!empty($event_id)) {
			$session=session();
		    $user=new Main_item_party_table();
		    $SportsparticipantModel = new SportsparticipantModel();
		    $myid=session()->get('id');
		    
		    if ($session->has('isLoggedIn')) {
		    	$usaerdata=$user->where('id', session()->get('id'))->first();
		    	

		    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

		    		

		    		 if (check_permission($myid,'manage_sports')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}

		    		$SportseventModel = new SportseventModel();
					$sportsevents_data=$SportseventModel->where('deleted',0)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('id',$event_id)->first();

		    		$participants_data=$SportsparticipantModel->where('deleted',0)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('sports_id',$sportsevents_data['related_to'])->findAll();

		    		$data=[
		    			'title'=>'Rewarding | Erudite ERP',
		    			'user'=>$usaerdata,
		    			'event_data'=>$sportsevents_data,
		    			'participants_data'=>$participants_data
		    		];

		    		
			    		echo view('header',$data);
			    		echo view('school_activities/rewarding');
			    		echo view('footer');
			    	


		    	
		    }else{
		   		return redirect()->to(base_url('users'));
		   	}
		}else{
	   		return redirect()->to(base_url('users'));
	   	}
				
	}



	public function add_reward_mark(){
		$session=session();
	    $user=new Main_item_party_table();
	    $RewardingModel=new RewardingModel();
	    $AnalyticsModel=new AnalyticsModel();
	    $myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('student_id')) {

				if (get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='sports') {
					

					$ac_data = [
						'company_id'=>company($myid),
						'academic_year'=>academic_year($myid),
						'student_id'=>$this->request->getVar('student_id'),
						'mark'=>$this->request->getVar('reward_mark'),
						'event_id'=>$this->request->getVar('event_id'),
						'type'=>'sports'
					];
					
					$checkexits=$RewardingModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('type','sports')->where('event_id',$this->request->getVar('event_id'))->where('deleted',0)->first();

				}else if(get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='eccc'){

					$ac_data = [
						'company_id'=>company($myid),
						'academic_year'=>academic_year($myid),
						'student_id'=>$this->request->getVar('student_id'),
						'mark'=>$this->request->getVar('reward_mark'),
						'event_id'=>$this->request->getVar('event_id'),
						'type'=>'eccc'
					];

					$checkexits=$RewardingModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('type','eccc')->where('event_id',$this->request->getVar('event_id'))->where('deleted',0)->first();

				}

				if ($checkexits) {
					$health_exec=$RewardingModel->update($checkexits['id'],$ac_data);
				}else{
					$health_exec=$RewardingModel->save($ac_data);
				}
				

				if ($health_exec) {
					echo 1;
				}else{
					echo 0;
				}
			}
		}
	}



	public function add_reward_status(){
		$session=session();
	    $user=new Main_item_party_table();
	    $RewardingModel=new RewardingModel();
	    $AnalyticsModel=new AnalyticsModel();
	    $myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('student_id')) {
				if (get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='sports') {
					$ac_data = [
						'company_id'=>company($myid),
						'academic_year'=>academic_year($myid),
						'student_id'=>$this->request->getVar('student_id'),
						'reward'=>$this->request->getVar('reward_status'),
						'event_id'=>$this->request->getVar('event_id'),
						'type'=>'sports'
					];
					
					$checkexits=$RewardingModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('type','sports')->where('event_id',$this->request->getVar('event_id'))->where('deleted',0)->first();
				}else if(get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='eccc'){


					$ac_data = [
						'company_id'=>company($myid),
						'academic_year'=>academic_year($myid),
						'student_id'=>$this->request->getVar('student_id'),
						'reward'=>$this->request->getVar('reward_status'),
						'event_id'=>$this->request->getVar('event_id'),
						'type'=>'eccc'
					];
					
					$checkexits=$RewardingModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('type','eccc')->where('event_id',$this->request->getVar('event_id'))->where('deleted',0)->first();

				}
				if ($checkexits) {
					$health_exec=$RewardingModel->update($checkexits['id'],$ac_data);

					if (get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='sports') {
						////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'Sports event<b>('.get_sports_event_data(company($myid),$this->request->getVar('event_id'),'events_name').')</b> reward added to <b>'.user_name($this->request->getVar('student_id')).'('.ucfirst($this->request->getVar('reward_status')).')</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
					}else if(get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='eccc'){

						////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'EC/CC event<b>('.get_sports_event_data(company($myid),$this->request->getVar('event_id'),'events_name').')</b> reward added to <b>'.user_name($this->request->getVar('student_id')).'('.ucfirst($this->request->getVar('reward_status')).')</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////

					}
				}else{
					$health_exec=$RewardingModel->save($ac_data);

					if (get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='sports') {

						////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'Sports event<b>('.get_sports_event_data(company($myid),$this->request->getVar('event_id'),'events_name').')</b> reward added to <b>'.user_name($this->request->getVar('student_id')).'('.ucfirst($this->request->getVar('reward_status')).')</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
					}else if(get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='eccc'){

						////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'EC/CC event<b>('.get_sports_event_data(company($myid),$this->request->getVar('event_id'),'events_name').')</b> reward added to <b>'.user_name($this->request->getVar('student_id')).'('.ucfirst($this->request->getVar('reward_status')).')</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
					}
				}
				

				if ($health_exec) {
					echo 1;
				}else{
					echo 0;
				}

				if (get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='sports') {
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='Congratulations!, new achievement recorded in your profile.';
				    $message='';
				    $url=main_base_url().'about_me'; 
				    $icon=notification_icons('sports');
				    $userid=$this->request->getVar('student_id');
				    $nread=0;
				    $for_who='student';
				    $notid='event';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				}else if(get_sports_event_data(company($myid),$this->request->getVar('event_id'),'type')=='eccc'){

					// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
					    $title='Congratulations!, new achievement recorded in your profile.';
					    $message='';
					    $url=main_base_url().'about_me'; 
					    $icon=notification_icons('eccc');
					    $userid=$this->request->getVar('student_id');
					    $nread=0;
					    $for_who='student';
					    $notid='event';
					    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
					// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				}
			}
		}
	}




	public function eccc()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $myid=session()->get('id');
	    $SubjectModel = new SubjectModel();
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		 if (check_permission($myid,'manage_sports')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}


	    		 $eccc_data=$SubjectModel->where('sub_type','eccc_sub')->where('deleted',0)->where('company_id',company($myid))->findAll();
	    		
	    		$data=[
	    			'title'=>'EC/CC Management | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'eccc_data'=>$eccc_data
	    			

	    		];
	    		

		    		echo view('header',$data);
		    		echo view('school_activities/eccc');
		    		echo view('footer');
		    	

	    		//complete exam after date is complete
	    		$SportseventModel= new SportseventModel();

	    		$main_exam_data=$SportseventModel->where('company_id',company($myid))->where('status!=','completed')->where('deleted',0)->where('academic_year',academic_year($myid))->findAll();
				$count=0;
				foreach ($main_exam_data as $ex) {
					$exam_date = strtotime(get_date_format($ex['to'],'Y-m-d'));
					$current_date = strtotime(get_date_format(now_time($myid),'Y-m-d')); 
					
					if ($current_date>$exam_date) { 
						$dataev=[
							'status'=>'completed'
						];

						$SportseventModel->update($ex['id'],$dataev);
					}

				}
	    		


	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	public function add_activity($cmp=""){
		
	
		if ($this->request->getMethod() == 'post') {
				
			$myid=session()->get('id');
			$model = new SubjectModel();

			$newData = [
				'subject_name' => strip_tags($this->request->getVar('activityname')),
				'subject_code' => strip_tags($this->request->getVar('activitycode')),
				'company_id' => $cmp,
				'academic_year' => academic_year($myid),
				'datetime' => now_time($myid),
				'sub_type'=>'eccc_sub',
				'parent_id' => strip_tags($this->request->getVar('eccc_id')),
				'serial_no' => serial_no_activity(company($myid)),


			];

			$model->save($newData);

			////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=>'New EC/CC activity <b>'.strip_tags($this->request->getVar('activityname')).'</b> is added.',
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


	public function update_activity($ac_id=""){
		
	
		$myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
			
			$myid=session()->get('id');
			$model = new SubjectModel();

			$newData = [
				'subject_name' => strip_tags($this->request->getVar('activityname')),
				'subject_code' => strip_tags($this->request->getVar('activitycode'))

			];

			
				$model->update($ac_id,$newData);
				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'EC/CC activity <b>'.strip_tags($this->request->getVar('activityname')).'</b> details is updated.',
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



	public function deleteactivity($ecid=0)
	{
		
		$subject = new SubjectModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {
				$subject->find($ecid);
				$deledata=[
                    'deleted'=>1
                ];
				$subject->update($ecid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'EC/CC activity <b>'.get_subject_data($ecid,'subject_name').'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
				
		}

	}


	public function eccc_participants()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      $SportsparticipantModel = new SportsparticipantModel();

	      $pager = \Config\Services::pager();

	      $results_per_page = 12; 
	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();
	        

	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	          

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          if ($_GET) {
		            if (isset($_GET['eccc_category'])) {
		                if (!empty($_GET['eccc_category'])) {
		                    $SportsparticipantModel->like('sports_id', $_GET['eccc_category'], 'both'); 
		                }
		            }
		            if (isset($_GET['students'])) {
		                if (!empty($_GET['students'])) {
		                    $SportsparticipantModel->like('student_id', $_GET['students'], 'both'); 
		                }
		            }
		            
		     
		        }

	          $eccc_participants_data=$SportsparticipantModel->where('deleted',0)->where('company_id',company($myid))->where('type','eccc')->where('academic_year',academic_year($myid))->paginate(25);
	          
	          $data=[
	            'title'=>'EC/CC | Erudite ERP',
	            'user'=>$usaerdata,
	            'eccc_participants_data'=>$eccc_participants_data,
	            'pager' => $SportsparticipantModel->pager,
	            
	          ];

	         
	              echo view('header',$data);
	              echo view('school_activities/eccc_participants',$data);
	              echo view('footer');
	         
	        
	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }



	public function add_actparticipants($cmp=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$SportsparticipantModel = new SportsparticipantModel();

				$std_id = strip_tags($this->request->getVar('student'));
				$activity_cat = strip_tags($this->request->getVar('activity'));

				$newData = [
					'student_id' => $std_id,
					'sports_id' => $activity_cat,
					'company_id' => $cmp,
					'academic_year' => academic_year($myid),
					'datetime' => now_time($myid),
					'serial_no' => serial_no_actparticipant(company($myid)),
					'type'=>'eccc'
					

				];

				$checkactivity=$SportsparticipantModel->where('student_id',$std_id)->where('sports_id',$activity_cat)->where('deleted',0)->where('type','eccc')->where('academic_year',academic_year($myid))->first();

				if (!$checkactivity) {

							$SportsparticipantModel->save($newData);
							echo 'passed';

					// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
					    $title='Congratulations!, you joined '.subjects_name($this->request->getVar('activity')).' today';
					    $message='';
					    $url=main_base_url(); 
					    $icon=notification_icons('eccc');
					    $userid=$this->request->getVar('student');
					    $nread=0;
					    $for_who='student';
					    $notid='eccc';
					    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
					// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]


					    ////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'<b>'.user_name($std_id).'</b>joined to <b>'.subjects_name($activity_cat).'</b>',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////

					    }else{
								echo 'activity_exist';
							}
					
				}

	}



public function update_actparticipants($pt_id=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$SportsparticipantModel = new SportsparticipantModel();
				$std_id = strip_tags($this->request->getVar('student'));
				$eccc_cat = strip_tags($this->request->getVar('activity'));

				$newData = [
					'student_id' => $std_id,
					'sports_id' => $eccc_cat,

				];

				$sprts=$SportsparticipantModel->where('id',$pt_id)->first();

				if ($sprts['student_id']==$std_id || $sprts['sports_id']==$eccc_cat) {
						$SportsparticipantModel->update($pt_id,$newData);
						////////////////////////CREATE ACTIVITY LOG//////////////
			                $log_data=[
			                    'user_id'=>$myid,
			                    'action'=>'<b>'.user_name($std_id).'</b>joined to <b>'.subjects_name($eccc_cat).'</b>',
			                    'ip'=>get_client_ip(),
			                    'mac'=>GetMAC(),
			                    'created_at'=>now_time($myid),
			                    'updated_at'=>now_time($myid),
			                    'company_id'=>company($myid),
			                ];

			                add_log($log_data);
			                ////////////////////////END ACTIVITY LOG/////////////////
					}else{

						$checkeccc=$SportsparticipantModel->where('student_id',$std_id)->where('sports_id',$eccc_cat)->where('deleted',0)->where('type','eccc')->where('academic_year',academic_year($myid))->first();

						if (!$checkeccc) {
							$SportsparticipantModel->update($pt_id,$newData);

							////////////////////////CREATE ACTIVITY LOG//////////////
			                $log_data=[
			                    'user_id'=>$myid,
			                    'action'=>'<b>'.user_name($std_id).'</b>joined to <b>'.subjects_name($eccc_cat).'</b>',
			                    'ip'=>get_client_ip(),
			                    'mac'=>GetMAC(),
			                    'created_at'=>now_time($myid),
			                    'updated_at'=>now_time($myid),
			                    'company_id'=>company($myid),
			                ];

			                add_log($log_data);
			                ////////////////////////END ACTIVITY LOG/////////////////
						}else{
							echo 'email_exist';
						}
					
					}
				
					
					
				}

	}



	public function deletesactparticipants($ecid=0)
	{
		
		$SportsparticipantModel = new SportsparticipantModel();
		$myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
				$SportsparticipantModel->find($ecid);
				$deledata=[
                    'deleted'=>1
                ];
				$SportsparticipantModel->update($ecid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'<b>'.user_name(get_sports_participant_data($ecid,'student_id')).'</b> removed to <b>'.subjects_name(get_sports_participant_data($ecid,'sports_id')).'</b>',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
				
		}

	}


	public function add_involve_eccc(){
		$session=session();
	    $user=new Main_item_party_table();
	    $AnalyticsModel=new AnalyticsModel();
	    $myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('student_id')) {

				$ac_data = [
					'company_id'=>company($myid),
					'academic_year'=>academic_year($myid),
					'student_id'=>$this->request->getVar('student_id'),
					'sports_eccc_id'=>$this->request->getVar('activities_id'),
					'involve_eccc'=>$this->request->getVar('involve_eccc')
				];
				
				$checkexits=$AnalyticsModel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('student_id',$this->request->getVar('student_id'))->where('sports_eccc_id',$this->request->getVar('activities_id'))->where('deleted',0)->first();

				if ($checkexits) {
					$health_exec=$AnalyticsModel->update($checkexits['id'],$ac_data);
				}else{
					$health_exec=$AnalyticsModel->save($ac_data);
				}
				

				if ($health_exec) {
					echo 1;
				}else{
					echo 0;
				}
			}
		}
	}




	public function eccc_events()
	  {
	      $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      $SportseventModel = new SportseventModel();

	      $pager = \Config\Services::pager();

	      $results_per_page = 12;

	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();
	       
	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	          

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          $ecccevents_data=$SportseventModel->where('deleted',0)->where('company_id',company($myid))->where('type','eccc')->where('academic_year',academic_year($myid))->paginate(25);
	          
	          $data=[
	            'title'=>'Ec/cc | Erudite ERP',
	            'user'=>$usaerdata,
	            'ecccevents_data'=>$ecccevents_data,
	            'pager' => $SportseventModel->pager,
	            
	          ];

	          
	              echo view('header',$data);
	              echo view('school_activities/eccc_events',$data);
	              echo view('footer');
	          

	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }




	public function add_ecevents($ecvcmp=""){
		

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new SportseventModel();
				$event = new EventModel();

				$newData = [
					'company_id' => $ecvcmp,
					'academic_year' => academic_year($myid),
					'events_name' => strip_tags($this->request->getVar('events_name')),
					'from' => strip_tags($this->request->getVar('from')),
					'to' => strip_tags($this->request->getVar('to')),
					'related_to' => strip_tags($this->request->getVar('related_to')),
					'c_type' => strip_tags($this->request->getVar('c_type')),
					'place' => strip_tags($this->request->getVar('place')),
					'subject_id' => strip_tags($this->request->getVar('subject_id')),
					'serial_no' => serial_no_ecccevent(company($myid)),
					'type'=>'eccc'
					

				];

				
					$model->save($newData);
					$ecevent_id = $model->getInsertID();


					$newevent = [

					'company_id' => $ecvcmp,
					'academic_year' => academic_year($myid),
					'title' => strip_tags($this->request->getVar('events_name')),
					'start_event' => strip_tags($this->request->getVar('from')),
					'end_event' => get_date_format($this->request->getVar('to'),'Y-m-d').' 23:00:00',
					'secondary_id'=> $ecevent_id,
					

				];
				$event->save($newevent);

				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='New event <b>'.strip_tags($this->request->getVar('events_name')).'</b> added.';
				    $message='';
				    $url=main_base_url().'calendar'; 
				    $icon=notification_icons('event');
				    $userid='all';
				    $nread=0;
				    $for_who='student';
				    $notid='event';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

			    // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='New event <b>'.strip_tags($this->request->getVar('events_name')).'</b> added.';
				    $message='';
				    $url=base_url().'/calendar'; 
				    $icon=notification_icons('event');
				    $userid='all';
				    $nread=0;
				    $for_who='admin';
				    $notid='event';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]


				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New ec/cc event <b>'.strip_tags($this->request->getVar('events_name')).'</b> is added',
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


	public function update_ecccevents($ecc_id=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$model = new SportseventModel();
				$event = new EventModel();

				$newData = [
					
					'events_name' => strip_tags($this->request->getVar('events_name')),
					'from' => strip_tags($this->request->getVar('from')),
					'to' => strip_tags($this->request->getVar('to')),
					'related_to' => strip_tags($this->request->getVar('related_to')),
					'c_type' => strip_tags($this->request->getVar('c_type')),
					'place' => strip_tags($this->request->getVar('place')),
					
					

				];

				
					$model->update($ecc_id,$newData);

					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'EC/CC event <b>'.strip_tags($this->request->getVar('events_name')).'</b> details is updated',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
	                ////////////////////////END ACTIVITY LOG/////////////////


					$event_id =$event->where('secondary_id',$ecc_id)->first();
					


					$newevent = [
					
					'title' => strip_tags($this->request->getVar('events_name')),
					'start_event' => strip_tags($this->request->getVar('from')),
					'end_event' => get_date_format($this->request->getVar('to'),'Y-m-d').' 23:00:00',
					
					
					

				];
				$event->update($event_id,$newevent);

				echo 1;
					
				}

			}


	public function deleteecccevent($eceid=0)
	{
		
		$model = new SportseventModel();
		$event = new EventModel();
		$myid=session()->get('id');


		if ($this->request->getMethod() == 'post') {
				$model->find($eceid);
				$deledata=[
                    'deleted'=>1
                ];
				$model->update($eceid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'EC/CC event <b>'.get_sports_event_data(company($myid),$eceid,'events_name').'</b> is deleted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////


				$event_id =$event->where('secondary_id',$eceid)->first();


				$event->find($event_id);
				$event->delete($event_id);


		}else{
   			return redirect()->to(base_url('school_activities/eccc_events'));
		}

	}



	public function sports_report()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $SportseventModel = new SportseventModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

	    		$sports_events=$SportseventModel->where('company_id',company($myid))->where('deleted',0)->where('status','completed')->where('academic_year',academic_year($myid))->findAll();


	    		
	    		$data=[
	    			'title'=>'Sports Report | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'sports_events'=>$sports_events,
	    			
	    		];
                
                
                    
               
	    		echo view('header',$data);
	    		echo view('school_activities/sports_reports');
	    		echo view('footer');
                
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function eccc_report()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $SportseventModel = new SportseventModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

	    		$eccc_data_events=$SportseventModel->where('company_id',company($myid))->where('deleted',0)->where('status','completed')->where('academic_year',academic_year($myid))->findAll();

	    		
	    		
	    		$data=[
	    			'title'=>'EC/CC Report | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'eccc_data_events'=>$eccc_data_events,
	    			
	    		];
                
               
    	    		echo view('header',$data);
    	    	
    	    		echo view('school_activities/eccc_reports');
    	    		echo view('footer');
               


	    	
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}
}