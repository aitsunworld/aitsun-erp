<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\NotificationsModel;
use App\Models\ProductrequestsModel;
use App\Models\Companies;
use App\Models\EnquiriesModel;
use App\Models\LeadModel;
use App\Models\TasksModel;
use App\Models\ActivitiesNotes;
use App\Models\RemindersModel;
use App\Models\TaskDateModel;



class Notifications extends BaseController
{
	public function index()
	{
		$session=session();
	    
	    if ($session->has('isLoggedIn')) {

	    	$UserModel=new Main_item_party_table;
	    	$NotificationsModel=new NotificationsModel;
	    	$Companies=new Companies;

	    	$myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

	    		

	    	

	    		$get_branches=$Companies->where('parent_company', main_company_id($myid));
                
                // $NotificationsModel->where('notified',0);
                $NotificationsModel->groupStart();
	                $NotificationsModel->where('user_id',$myid);
	                $NotificationsModel->orWhere('user_id','all');
                $NotificationsModel->groupEnd();
                $NotificationsModel->groupStart();
                $NotificationsModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$NotificationsModel->orWhere('company_id',$ci['id']);
                	}
                }
                $NotificationsModel->groupEnd();
                $notifications_data=$NotificationsModel->orderBy('id','desc')->findAll(100);


	    		
	    		$data=[
	    			'title'=>'Aitsun ERP-Notifications',
	    			'user'=>$user,
	    			'notifications_data'=>$notifications_data
	    		];


	    		echo view('header',$data); 
	    		echo view('notifications/notifications'); 
	    		echo view('footer');

	    		 


	    }else{
	   		return redirect()->to(base_url('users'));
	   	}	


	}


	public function display_notifications(){
		$NotificationsModel= new NotificationsModel();
		$user = new Main_item_party_table();
		$Companies = new Companies();
		$myid=session()->get('id');
		$usaerdata=$user->where('id', $myid)->first();
		// $notificationss_data=$Notifications->where('user_id',$myid)->orWhere('user_id','all')->where('company_id',company($myid))->where('nread',0)->where('for_who','admin')->orderBy('id','desc')->findAll();

		

		$get_branches=$Companies->where('parent_company', main_company_id($myid));
                
        $NotificationsModel->where('nread',0);
        $NotificationsModel->groupStart();
            $NotificationsModel->where('user_id',$myid);
            $NotificationsModel->orWhere('user_id','all');
        $NotificationsModel->groupEnd();
        $NotificationsModel->groupStart();
        $NotificationsModel->where('company_id',company($myid));
        foreach($get_branches->findAll() as $ci){
        	if ($ci['id']!=company($myid)) {
        		$NotificationsModel->orWhere('company_id',$ci['id']);
        	}
        }
        $NotificationsModel->groupEnd();
        $notificationss_data=$NotificationsModel->orderBy('id','desc')->findAll();

		$count=0;
		foreach ($notificationss_data as $nti) {
			$count++;

			?>

            <a class="dropdown-item" href="<?= base_url(); ?>/redirect_notify?nurl=<?php echo $nti['url']; ?>&nid=<?php echo $nti['id']; ?>">
				<div class="d-flex align-items-center">
					<div class="">
						<img src="<?= $nti['icon']; ?>" class="msg-avatar" alt="r">
					</div>
					<div class="flex-grow-1">
						<h6 class="msg-name white-initial"><?= str_replace(array('&lt;br&gt;','<br>'),'',$nti['title']); ?></h6>
						<span class="msg-time"><?= timeAgo($nti['n_datetime'],now_time($myid)); ?></span>
					</div>
				</div>
			</a>
                <?php
		}

		if ($count==0) {
			echo '<div class="p-5">
                        <p class="m-b-0 text-danger text-center ">0 Notifications</p>
                    </div>';
		}

	}

	public function not_indic(){
		$session=session();
	    $user=new Main_item_party_table();
	  	$NotificationsModel= new NotificationsModel();
	  	$UserModel= new Main_item_party_table;
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {

	    	$user=$UserModel->where('id',$myid)->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		
	    			if (no_of_notifications($user['id'],'admin')!='') { ?>
	    				<?php if (no_of_notifications($user['id'],'admin')==0): ?>
               				<span class="alert-count">0</span>
               			<?php else if (no_of_notifications($user['id'],'admin')>9): ?>
               				<span class="alert-count">9+</span>
               			<?php else: ?>
               				<span class="alert-count"><?= no_of_notifications($user['id'],'admin'); ?></span>
               			<?php endif ?>
	               	 
	            		<?php 
	            	}
	    		 
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}	
 
	}


	public function notification_count(){
		$session=session();
		if ($session->has('isLoggedIn')) {
			  $myid=session()->get('id');
			// if (current_financial_year('financial_from',company($myid))!='no_financial_years') {
				$NotificationsModel= new NotificationsModel();
				$user = new Main_item_party_table();
				$Companies = new Companies();
				$myid=session()->get('id');
				$usaerdata=$user->where('id', $myid)->first();
			

				$get_branches=$Companies->where('parent_company', main_company_id($myid));
                
		        $NotificationsModel->where('nread',0);
		        $NotificationsModel->groupStart();
		            $NotificationsModel->where('user_id',$myid);
		            $NotificationsModel->orWhere('user_id','all');
		        $NotificationsModel->groupEnd();
		        $NotificationsModel->groupStart();
		        $NotificationsModel->where('company_id',company($myid));
		        foreach($get_branches->findAll() as $ci){
		        	if ($ci['id']!=company($myid)) {
		        		$NotificationsModel->orWhere('company_id',$ci['id']);
		        	}

		        }
		        $NotificationsModel->groupEnd();
		        $notificationss_data=$NotificationsModel->orderBy('id','desc')->findAll();

				$row = count($notificationss_data);

				echo json_encode(array("rows"=>$row,"notdata"=>$notificationss_data));
			// }else{
			// 	echo json_encode(array("rows"=>0,"notdata"=>array()));
			// }
			
		}else{
			echo json_encode(array("rows"=>0,"notdata"=>array()));
		}
		

	}

	public function notified(){
		$NotificationsModel= new NotificationsModel();
		if (isset($_POST['fetch'])) {
			$idata =[
	    		'notified' => 1,
	    	];
			$read=$NotificationsModel->update($_POST['noid'],$idata);
			if ($read) {
				echo 'success';
			}else{
				echo 'failed';
			}
		}
	}



	public function generate_notification(){

		$session=session();
	    
	    if ($session->has('isLoggedIn')) {

	    	$UserModel=new Main_item_party_table;
	    	$NotificationsModel=new NotificationsModel;
	    	$ProductrequestsModel=new ProductrequestsModel;
	    	$Companies=new Companies;
	    	$LeadModel=new LeadModel;
	    	$TasksModel=new TasksModel;
	    	$ActivitiesNotes=new ActivitiesNotes;
	    	$RemindersModel=new RemindersModel;
	    	$TaskDateModel=new TaskDateModel;


	    	$EnquiriesModel=new EnquiriesModel;

	    	$myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();


	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }


                $get_branches=$Companies->where('parent_company', main_company_id($myid));

                /////////////////  PRODUCT REQUEST NOTIFICATIONS ///////////////

                $ProductrequestsModel->where('notified',0);
                $ProductrequestsModel->groupStart();
                $ProductrequestsModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$ProductrequestsModel->orWhere('company_id',$ci['id']);
                	}
                }
                $ProductrequestsModel->groupEnd();
                $get_product_request_of_all_branch=$ProductrequestsModel->findAll();

                foreach ($get_product_request_of_all_branch as $pr) {

                	foreach($get_branches->findAll() as $ci){
	                	foreach(get_admins_of_company($ci['id']) as $cid){
                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    $title='New product request from <b>'.htmlentities(get_company_data($pr['company_id'],'company_name')).'</b>';
						    $message='';
						    $url=base_url().'/products/requests?requestid='.$pr['id']; 
						    $icon=notification_icons('product_request');
						    $userid=$cid['id'];
						    $nread=0;
						    $for_who='admin';
						    $notid='user';
						    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
						// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    	
                	}
                }

                	foreach(get_users_by_permission($pr['company_id'],'manage_product_requestes') as $use){
                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    $title='New product request from <b>'.htmlentities(get_company_data($pr['company_id'],'company_name')).'</b>';
						    $message='';
						    $url=base_url().'/products/requests?requestid='.$pr['id']; 
						    $icon=notification_icons('product_request');
						    $userid=$use['user'];
						    $nread=0;
						    $for_who='admin';
						    $notid='user';
						    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
						// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                	}
                	$prud=['notified'=>1];
                	$ProductrequestsModel->update($pr['id'],$prud);
                }


                /////////////////  PRODUCT REQUEST NOTIFICATIONS ///////////////



                /////////////////  ENQUIRIES NOTIFICATIONS ///////////////

                $EnquiriesModel->where('notified',0);
                $EnquiriesModel->groupStart();
                $EnquiriesModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$EnquiriesModel->orWhere('company_id',$ci['id']);
                	}
                }
                $EnquiriesModel->groupEnd();
                $get_enquiries_of_all_branch=$EnquiriesModel->findAll();

                foreach ($get_enquiries_of_all_branch as $enq) {

                	foreach($get_branches->findAll() as $ci){
	                	foreach(get_admins_of_company($ci['id']) as $cid){
	                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							    $title='New enquiry from <b>'.htmlentities(get_company_data($enq['company_id'],'company_name')).'</b>';
							    $message='';
							    $url=base_url().'/enquiries'; 
							    $icon=notification_icons('enquires');
							    $userid=$cid['id'];
							    $nread=0;
							    $for_who='admin';
							    $notid='user';
							    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
							// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							    	
	                	}
                	}

                	foreach(get_users_by_permission($enq['company_id'],'manage_enquires') as $use){
                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    $title='New enquiry from <b>'.htmlentities(get_company_data($enq['company_id'],'company_name')).'</b>';
						    $message='';
						    $url=base_url().'/enquiries'; 
						    $icon=notification_icons('enquires');
						    $userid=$use['user'];
						    $nread=0;
						    $for_who='admin';
						    $notid='user';
						    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
						// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                	}
                	$prud=['notified'=>1];
                	$EnquiriesModel->update($enq['id'],$prud);
                }


                /////////////////  ENQUIRIES NOTIFICATIONS ///////////////




                /////////////////  NEW LEAD NOTIFICATIONS ///////////////

                $LeadModel->where('notified',0);
                $LeadModel->groupStart();
                $LeadModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$LeadModel->orWhere('company_id',$ci['id']);
                	}
                }
                $LeadModel->groupEnd();
                $get_leads_of_all_branch=$LeadModel->findAll();

                foreach ($get_leads_of_all_branch as $led) {


                	if ($led['lead_by']!=0) {
                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    $title='You are going to lead <b>'.htmlentities(get_lead_data($led['id'],'lead_name')).'</b> of <b>'.get_company_data($led['company_id'],'company_name').'</b>';
						    $message='';
						    $url=base_url().'/crm/details/'.$led['id']; 
						    $icon=notification_icons('leads');
						    $userid=$led['lead_by'];
						    $nread=0;
						    $for_who='admin';
						    $notid='user';
						    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
						// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                	}

                	
                	foreach($get_branches->findAll() as $ci){
	                	foreach(get_admins_of_company($ci['id']) as $cid){
	                		if ($led['lead_by']!=$cid['id']) {
		                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
								    $title='New lead is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
								    $message='';
								    $url=base_url().'/crm/details/'.$led['id']; 
								    $icon=notification_icons('leads');
								    $userid=$cid['id'];
								    $nread=0;
								    $for_who='admin';
								    $notid='user';
								    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
								// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							}
							    	
	                	}
	                }

                	foreach(get_users_by_permission($led['company_id'],'manage_crm') as $use){
                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    $title='New lead is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
						    $message='';
						    $url=base_url().'/crm/details/'.$led['id']; 
						    $icon=notification_icons('leads');
						    $userid=$use['user'];
						    $nread=0;
						    $for_who='admin';
						    $notid='user';
						    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
						// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                	}

                	foreach(get_followers_of_lead($led['id']) as $fol){
                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
						    $title='You are the follower of <b>'.htmlentities(get_lead_data($led['id'],'lead_name')).'</b> lead of <b>'.get_company_data($led['company_id'],'company_name').'</b>';
						    $message='';
						    $url=base_url().'/crm/details/'.$led['id']; 
						    $icon=notification_icons('leads');
						    $userid=$fol['follower_id'];
						    $nread=0;
						    $for_who='admin';
						    $notid='user';
						    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
						// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                	}

                	$prud=['notified'=>1];
                	$LeadModel->update($led['id'],$prud);
                }
                


                /////////////////  NEW LEAD NOTIFICATIONS ///////////////




                /////////////////  NEW TASK NOTIFICATIONS ///////////////
                $TasksModel->where('deleted',0)->where('notification_notified',0);
                $TasksModel->groupStart();
                $TasksModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$TasksModel->orWhere('company_id',$ci['id']);
                	}
                }
                $TasksModel->groupEnd();
                $tasksofmain=$TasksModel->findAll();

                foreach ($tasksofmain as $tom) {
                	
                
                $LeadModel->where('id',$tom['lead_id']);
               
                $get_leads_of_all_branch=$LeadModel->findAll();

                foreach ($get_leads_of_all_branch as $led) {

                	$alltasks=$TasksModel->where('lead_id',$led['id'])->where('deleted',0)->where('notification_notified',0)->findAll();

                	foreach ($alltasks as $tsk) {

                		if ($tsk['followers']!=0) {
	                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							    $title='You are going to task <b>'.get_task_data($tsk['id'],'task').'</b> of <b>'.get_company_data($led['company_id'],'company_name').'</b>';
							    $message='';
							    $url=base_url().'/crm/details/'.$led['id']; 
							    $icon=notification_icons('task');
							    $userid=$tsk['followers'];
							    $nread=0;
							    $for_who='admin';
							    $notid='user';
							    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
							// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
	                	}

	                	

	                	foreach($get_branches->findAll() as $ci){
	                		foreach(get_admins_of_company($ci['id']) as $cid){
		                		if ($tsk['followers']!=$cid['id']) {
		                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
								    $title='New task is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
								    $message='';
								    $url=base_url().'/crm/details/'.$led['id']; 
								    $icon=notification_icons('task');
								    $userid=$cid['id'];
								    $nread=0;
								    $for_who='admin';
								    $notid='user';
								    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
								// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
								    }
								    	
		                	}
		                }

	                	foreach(get_users_by_permission($led['company_id'],'manage_crm') as $use){
	                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							    $title='New task is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
							    $message='';
							    $url=base_url().'/crm/details/'.$led['id']; 
							    $icon=notification_icons('task');
							    $userid=$use['user'];
							    $nread=0;
							    $for_who='admin';
							    $notid='user';
							    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
							// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
	                	}

	                	foreach(get_followers_of_lead($led['id']) as $fol){
	                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							    $title='New task is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
							    $message='';
							    $url=base_url().'/crm/details/'.$led['id']; 
							    $icon=notification_icons('task');
							    $userid=$fol['follower_id'];
							    $nread=0;
							    $for_who='admin';
							    $notid='user';
							    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
							// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
	                	}

	                	$trud=['notification_notified'=>1];
	                	$TasksModel->update($tsk['id'],$trud);
                	}
                }
              }

                


                /////////////////  NEW TASK NOTIFICATIONS ///////////////




                /////////////////  NOTE NOTIFICATIONS ///////////////
         		$ActivitiesNotes->where('deleted',0)->where('notified',0);
                $ActivitiesNotes->groupStart();
                $ActivitiesNotes->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$ActivitiesNotes->orWhere('company_id',$ci['id']);
                	}
                }
                $ActivitiesNotes->groupEnd();
                $actofmain=$ActivitiesNotes->findAll();

                foreach ($actofmain as $aom) {
                	
                
                $LeadModel->where('id',$aom['lead_id'])->where('company_id',$aom['company_id']);
               
                $get_leads_of_all_branch=$LeadModel->findAll();

                foreach ($get_leads_of_all_branch as $led) {

                	$allnotes=$ActivitiesNotes->where('lead_id',$led['id'])->where('deleted',0)->where('notified',0)->findAll();

                	foreach ($allnotes as $ntk) {

                		if ($ntk['type']=='note') {
                			foreach($get_branches->findAll() as $ci){
		                	    foreach(get_admins_of_company($ci['id']) as $cid){
			                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
									    $title='New note is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
									    $message='';
									    $url=base_url().'/crm/details/'.$led['id']; 
									    $icon=notification_icons('note');
									    $userid=$cid['id'];
									    $nread=0;
									    $for_who='admin';
									    $notid='user';
									    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
									// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
									    	
			                	}
			                }

		                	foreach(get_users_by_permission($led['company_id'],'manage_crm') as $use){
		                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
								    $title='New note is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
								    $message='';
								    $url=base_url().'/crm/details/'.$led['id']; 
								    $icon=notification_icons('note');
								    $userid=$use['user'];
								    $nread=0;
								    $for_who='admin';
								    $notid='user';
								    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
								// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
		                	}

		                	foreach(get_followers_of_lead($led['id']) as $fol){
		                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
								    $title='New note is added to <b>'.get_company_data($led['company_id'],'company_name').'</b>';
								    $message='';
								    $url=base_url().'/crm/details/'.$led['id']; 
								    $icon=notification_icons('note');
								    $userid=$fol['follower_id'];
								    $nread=0;
								    $for_who='admin';
								    $notid='user';
								    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
								// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
		                	}

		                	$trud=['notified'=>1];
		                	$ActivitiesNotes->update($ntk['id'],$trud);
                		}

	                	
                	}
                }
            }

                


                /////////////////  NOTE NOTIFICATIONS ///////////////



                /////////////////  REMINDER NOTIFICATIONS ///////////////

                $RemindersModel->where('deleted',0)->where('notified',0);
                $RemindersModel->groupStart();
                $RemindersModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$RemindersModel->orWhere('company_id',$ci['id']);
                	}
                }
                $RemindersModel->groupEnd();
                $remofmain=$RemindersModel->findAll();

                foreach ($remofmain as $rom) {
                	
                
                $LeadModel->where('id',$rom['lead_id']);
               
                $get_leads_of_all_branch=$LeadModel->findAll();

                foreach ($get_leads_of_all_branch as $led) {
             
                	$allreminders=$RemindersModel->where('lead_id',$led['id'])->where('deleted',0)->where('notified',0)->findAll();

                	foreach ($allreminders as $rtk) {
                		if ($rtk['date']==get_date_format(now_time($myid),'Y-m-d')) {

                			if ($led['lead_by']!=0) {
	                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                				if ($rtk['time']=='00:00:00') {
                					$title='Today <small>('.get_date_format($rtk['date'],'d M').')</small> you have a reminder for the <b>'.$rtk['stage'].'</b> of lead '.htmlentities(get_lead_data($led['id'],'lead_name')).'';
                				}else{
                					$title='Today <small>('.get_date_format($rtk['date'],'d M').')</small> at <b>'.get_date_format($rtk['time'],'h:i a').'</b> you have a reminder for the <b>'.$rtk['stage'].'</b> of lead '.htmlentities(get_lead_data($led['id'],'lead_name')).'';
                				}
							    

							    $message='';
							    $url=base_url().'/crm/details/'.$led['id']; 
							    $icon=notification_icons('reminder');
							    $userid=$led['lead_by'];
							    $nread=0;
							    $for_who='admin';
							    $notid='user';
							    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
							// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
	                	}

                		foreach(get_followers_of_lead($led['id']) as $fol){
	                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
							    if ($rtk['time']=='00:00:00') {
                					$title='Today <small>('.get_date_format($rtk['date'],'d M').')</small> you have a reminder for the <b>'.$rtk['stage'].'</b> of lead '.htmlentities(get_lead_data($led['id'],'lead_name')).'';
                				}else{
                					$title='Today <small>('.get_date_format($rtk['date'],'d M').')</small> at <b>'.get_date_format($rtk['time'],'h:i a').'</b> you have a reminder for the <b>'.$rtk['stage'].'</b> of lead '.htmlentities(get_lead_data($led['id'],'lead_name')).'';
                				}
							    
							    $message='';
							    $url=base_url().'/crm/details/'.$led['id']; 
							    $icon=notification_icons('reminder');
							    $userid=$fol['follower_id'];
							    $nread=0;
							    $for_who='admin';
							    $notid='user';
							    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
							// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
	                	}
                			
                		}

                		$lerm=['notified'=>1];
	                	$RemindersModel->update($rtk['id'],$lerm);
                		
                	}
                }
                }
                
                /////////////////  REMINDER NOTIFICATIONS ///////////////




                /////////////////  TASK DATE NOTIFICATIONS ///////////////
                $TaskDateModel->where('notification_notified',0);
                $TaskDateModel->groupStart();
                $TaskDateModel->where('company_id',company($myid));
                foreach($get_branches->findAll() as $ci){
                	if ($ci['id']!=company($myid)) {
                		$TaskDateModel->orWhere('company_id',$ci['id']);
                	}
                }
                $TaskDateModel->groupEnd();
                $taskdatefmain=$TaskDateModel->findAll();

                foreach ($taskdatefmain as $tdom) {
                	
                
                $LeadModel->where('id',$tdom['lead_id']);
               
                $get_leads_of_all_branch=$LeadModel->findAll();

                foreach ($get_leads_of_all_branch as $led) {
             
                	$allltasks=$TasksModel->where('lead_id',$led['id'])->where('deleted',0)->findAll();

                	foreach ($allltasks as $tdk) {

                		$all_task_dates=$TaskDateModel->where('task_id',$tdk['id'])->where('notification_notified',0)->findAll();
                		foreach ($all_task_dates as $atd) {


                			if ($atd['task_type']=='single day') {
	                			if ($atd['from']==get_date_format(now_time($myid),'Y-m-d')) {
	                				if ($tdk['followers']!=0) {
				                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
			                				$title='Today <small>('.get_date_format($atd['from'],'d M').')</small> you have a task <b>'.htmlentities($tdk['task']).'</b> of lead '.htmlentities(get_lead_data($led['id'],'lead_name')).'';

										    $message='';
										    $url=base_url().'/crm/details/'.$led['id']; 
										    $icon=notification_icons('task-date');
										    $userid=$tdk['followers'];
										    $nread=0;
										    $for_who='admin';
										    $notid='user';
										    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
										// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

				                	}
	                			}	
		                	}

		                	if ($atd['task_type']=='multiple day') {
	                			if ($atd['from']==get_date_format(now_time($myid),'Y-m-d')) {
	                				if ($tdk['followers']!=0) {
				                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
			                				$title='Today <small>('.get_date_format($atd['from'],'d M').')</small> you have a task <b>'.htmlentities($tdk['task']).'</b> of lead '.htmlentities(get_lead_data($led['id'],'lead_name')).'';

										    $message='';
										    $url=base_url().'/crm/details/'.$led['id']; 
										    $icon=notification_icons('task-date');
										    $userid=$tdk['followers'];
										    $nread=0;
										    $for_who='admin';
										    $notid='user';
										    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
										// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

				                	}
	                			}	
		                	}


		                	if ($atd['task_type']=='day repeat') {

	                			if ($atd['from']>=get_date_format(now_time($myid),'Y-m-d')) {

	                				if ($tdk['followers']!=0) {
				                		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
			                				$title='You have a task <b>'.htmlentities($tdk['task']).'</b> of lead <b>'.htmlentities(get_lead_data($led['id'],'lead_name')).'</b> from today till <b>'.get_date_format($atd['to'],'d M').'</b>';

										    $message='';
										    $url=base_url().'/crm/details/'.$led['id']; 
										    $icon=notification_icons('task-date');
										    $userid=$tdk['followers'];
										    $nread=0;
										    $for_who='admin';
										    $notid='user';
										    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
										// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				                	}
	                			}	
		                	}

		                	$lerm=['notification_notified'=>1];
	                		$TaskDateModel->update($atd['id'],$lerm);

                		}

                		

                		
                		
                	}
                }
            }
                	
                
                
                /////////////////  TASK DATE NOTIFICATIONS ///////////////


            }else{
            	return redirect()->to(base_url());
            }

	}



	public function fees_remind($student_id='')
    {   
        $user=new Main_item_party_table();

        $myid=session()->get('id');
        $due_amount=strip_tags($_GET['due_amount']);
        $fees_id=strip_tags($_GET['fees_id']);
        $fees_name=get_fees_data(company($myid),$fees_id,'fees_name');

        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
		    $title=$fees_name.' amount '.currency_symbol(company($myid)).''.$due_amount.' is pending to pay. Click here to pay the due amount';
		    $message='';
		    $url=main_base_url().'/fees_and_payments/pay/'.strip_tags($_GET['invoice_id']); 
		    $icon=notification_icons('fees');
		    $userid=$student_id;
		    $nread=0;
		    $for_who='student';
		    $notid='fees_remind';
		    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
		    echo 1;
		// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
            

        
    }

}