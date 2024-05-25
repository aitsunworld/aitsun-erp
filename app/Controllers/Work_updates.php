<?php namespace App\Controllers;

use App\Models\Main_item_party_table;
use App\Models\WorkUpdatesModel;
use App\Models\Companies;
use App\Models\WorkDepartmentModel;
use App\Models\WorkcategoryModel;


class Work_updates extends BaseController{


	public function index(){
		

		$session=session();

	    if ($session->has('isLoggedIn')){

	        $UserModel=new Main_item_party_table;
	        $WorkUpdatesModel=new WorkUpdatesModel();


	        $myid=session()->get('id');
	        $con = array( 
	            'id' => session()->get('id') 
	        );
	        $user=$UserModel->where('id',$myid)->first();

	        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	        


	        if (usertype($myid)=='customer') {
	            return redirect()->to(base_url('customer_dashboard'));
	        }
	        if (is_aitsun(company($myid))==0) {

	        	return redirect()->to(base_url());
	        }




			if($_GET){
				if(isset($_GET['from']) && isset($_GET['to'])){
					$from=$_GET['from'];
					$to=$_GET['to'];
			
					if(!empty($from) && empty($to)){
						$WorkUpdatesModel->where('date',$from);
					}
					if(!empty($to) && empty($from)){
						$WorkUpdatesModel->where('date',$to);
					}
					if (!empty($from) && !empty($to)) {
						$WorkUpdatesModel->where("date BETWEEN '$from' AND '$to'");
		
					}
				}

				if (isset($_GET['category'])) {
					if (!empty($_GET['category'])) {
						$WorkUpdatesModel->where('category',trim($_GET['category']));
					}
				}

				if (isset($_GET['staffid'])) {
					if (!empty($_GET['staffid'])){
						$WorkUpdatesModel->where('user_id',trim($_GET['staffid']));
					}
				}
				if (isset($_GET['department_name'])) {
					if (!empty($_GET['department_name'])){
						$WorkUpdatesModel->where('department',trim($_GET['department_name']));
					}
				}

				if (check_permission($myid,'manage_work_updates')==true || usertype($myid)=='admin') {
				$work_update=$WorkUpdatesModel->where('company_id',company($myid))->orderBy('id','DESC')->findAll();
				}else{

					$work_update=$WorkUpdatesModel->where('company_id',company($myid))->orderBy('id','DESC')->where('user_id',$user['id'])->findAll();
				}


			}else{
				if (check_permission($myid,'manage_work_updates')==true || usertype($myid)=='admin') {
					$work_update=$WorkUpdatesModel->where('company_id',company($myid))->where('MONTH(date)',get_date_format(now_time($myid),'m'))->orderBy('id','DESC')->findAll();
					}else{

						$work_update=$WorkUpdatesModel->where('company_id',company($myid))->where('MONTH(date)',get_date_format(now_time($myid),'m'))->orderBy('id','DESC')->where('user_id',$user['id'])->findAll();
					}
			}
 
	        
	         $data = [
	            'title' => 'Aitsun ERP-Work Updates',
	            'work_update'=>$work_update,
	            'user'=>$user
	         ];

	         if (isset($_POST['get_excel'])) {
                        

                $fileName = "Work Updates-".now_time($myid). ".xls"; 
                 
                // Column names 
                $fields = array('NAME', 'CATEGORY', 'DESCRIPTION', 'DATE'); 

                
                 
                 // print_r($fields);

                // Display column names as first row 
                $excelData = implode("\t", array_values($fields)) . "\n"; 
                 
                // Fetch records from database 
                $query = $work_update; 
                if(count($query) > 0){ 
                    // Output each row of the data 
                    foreach ($query as $row) {

                        $name=user_name($row['user_id']);
                        $colllumns=array($name,work_category_name($row['category']),$row['description'],$row['date']);
                        
                        array_walk($colllumns, 'filterData');
                        $excelData .= implode("\t", array_values(str_replace('\n', '', $colllumns))) . "\n"; 
                    }
                }else{ 
                    $excelData .= 'No records found...'. "\n"; 
                } 
                 
                // // Headers for download 
                header("Content-Type: application/vnd.ms-excel"); 
                header("Content-Disposition: attachment; filename=\"$fileName\""); 
                 
                // Render excel data 
                echo $excelData; 
                 
                exit;
            }


				echo view('header',$data);
				echo view('work_updates/work_updates');
				echo view('footer');
			

		}else{
	            return redirect()->to(base_url('users/login'));
	    }
	    
	}

	public function save_workupdate(){
		$session = session();
		$Companies= new Companies;
		$UserModel=new Main_item_party_table;
		$WorkUpdatesModel=new WorkUpdatesModel();

		$myid=session()->get('id');
		$companyid=company($myid);


		if($this->request->getMethod('post')){

			$work_update=[
				'user_id'=>$myid,
				'company_id'=>$companyid,
				'description'=>strip_tags($this->request->getVar('description')),
				'date'=>strip_tags($this->request->getVar('date')),
				'category'=>strip_tags($this->request->getVar('category')),
				'department'=>strip_tags($this->request->getVar('department_name')),
			];

			if($WorkUpdatesModel->save($work_update)){
				$session->setFlashdata('pu_msg','Work saved');
				return redirect()->to(base_url('work_updates'));
			}
			else if($WorkUpdatesModel->save($work_update)){
				$session->setFlashdata('pu_er_msg','Failed to saved!');
				return redirect()->to(base_url('work_updates'));
			}
		}
	}

	 public function details($cid=''){
        $session=session();
        $WorkUpdatesModel=new WorkUpdatesModel;

        $us=$WorkUpdatesModel->where('id',$cid)->first();
        $data=[
            'title'=>' Work Update',
            'us'=>$us
        ];

        echo view('header',$data);
        echo view('work_updates/work_updates');
        echo view('footer');
        
    }

     public function edit_workupdate($cid=""){
        $session=session();
        $WorkUpdatesModel=new WorkUpdatesModel;

        if ($this->request->getMethod('post')) {
            
            $work_update=[
            	'category'=>strip_tags($this->request->getVar('category')),
                'description'=>strip_tags($this->request->getVar('description')),
				'date'=>strip_tags($this->request->getVar('date')),
				'department'=>strip_tags($this->request->getVar('department_name')),
				
            ];

            if ($WorkUpdatesModel->update($cid,$work_update)) {
                $session->setFlashdata('pu_msg','Saved!');
                return redirect()->to(base_url('work_updates'));
            }else{
                $session->setFlashdata('pu_er_msg','Failed to saved!');
                return redirect()->to(base_url('work_updates'));
            }
        }    
    }

	public function delete_workupdate($cid=""){
		$session=session();

		$is_deleted=delete_work_update($cid);

		if ($is_deleted==true) {
            $session->setFlashdata('success_message','Deleted!');
            return redirect()->to(base_url('work_updates'));
        }else{
            $session->setFlashdata('error_message','Failed to saved!');
            return redirect()->to(base_url('work_updates'));
        }
        
    }


    public function crm_configurations(){
	    $session=session();

	   if($session->has('isLoggedIn')){

	        $CompanySettings= new CompanySettings;
	        $LossReasons= new LossReasons;
	        $UserModel = new Main_item_party_table;
	        $WorkcategoryModel= new WorkcategoryModel;
	        $Designation=new Designation;
	        $ContactType=new ContactType;
	        $WorkDepartmentModel=new WorkDepartmentModel;
	        $ProjectType=new ProjectType;

	      
	        $myid=session()->get('id');
	        $con = array( 
	            'id' => session()->get('id') 
	        );

	        $user=$UserModel->where('id',$myid)->first();

	        if (check_permission($myid,'manage_settings')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

	        if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}

	        

	       $cquery = $CompanySettings->where('company_id', company($myid))->first();
	       $work_category_data= $WorkcategoryModel->where('company_id', company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();

	        $data = [
	            'title' => 'Aitsun ERP- CRM Configurations',
	            'user' => $user,
	            'c_set' => $cquery,
	            'work_category_data' => $work_category_data,
	            'work_department'=> $WorkDepartmentModel->where('company_id', company($myid))->where('deleted',0)->orderBy('id','desc')->findAll(),
	            'reasons' => $LossReasons->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll(),
	            'designation' => $Designation->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll(),
	            'contact_type' => $ContactType->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll(),
	            'project_types' => $ProjectType->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll(),
	            
	        ];

	            if (is_crm(company($myid))) {
	                echo view('header',$data);
	                echo view('settings/crm_configurations', $data);
	                echo view('footer');
	            }else{
	                return redirect()->to(base_url());
	            }


	    if (isset($_POST['save_crm_grids'])) {

	        $entry=1;
	        $site_visit=1;
	        $direct_loss=1;
	        $quotation=1;
	        $follow_up=1;
	        $loss=1;
	        $sales_order=1;
	        $deliver_note=1;
	        $delivery=1;
	        $invoice=1;
	        $payment_followup=1;
	        $complete=1;

	        if (strip_tags($this->request->getVar('entry'))) {
	            $entry=0;
	        }

	        if (strip_tags($this->request->getVar('site_visit'))) {
	            $site_visit=0;
	        }

	        if (strip_tags($this->request->getVar('direct_loss'))) {
	            $direct_loss=0;
	        }

	        if (strip_tags($this->request->getVar('quotation'))) {
	            $quotation=0;
	        }

	        if (strip_tags($this->request->getVar('follow_up'))) {
	            $follow_up=0;
	        }

	        if (strip_tags($this->request->getVar('loss'))) {
	            $loss=0;
	        }

	        if (strip_tags($this->request->getVar('sales_order'))) {
	            $sales_order=0;
	        }

	        if (strip_tags($this->request->getVar('deliver_note'))) {
	            $deliver_note=0;
	        }

	        if (strip_tags($this->request->getVar('delivery'))) {
	            $delivery=0;
	        }

	        if (strip_tags($this->request->getVar('invoice'))) {
	            $invoice=0;
	        }

	        if (strip_tags($this->request->getVar('payment_followup'))) {
	            $payment_followup=0;
	        }

	        if (strip_tags($this->request->getVar('complete'))) {
	            $complete=0;
	        }


	        $ac_data = [
	            'company_id'=>company($myid),
	            'show_entry'=>$entry,
	            'show_site_visit'=>$site_visit,
	            'show_direct_loss'=>$direct_loss,
	            'show_quotation'=>$quotation,
	            'show_follow_up'=>$follow_up,
	            'show_loss'=>$loss,
	            'show_sales_order'=>$sales_order,
	            'show_deliver_note'=>$deliver_note,
	            'show_delivery'=>$delivery,
	            'show_invoice'=>$invoice,
	            'show_payment_followup'=>$payment_followup,
	            'show_complete'=>$complete
	        ];

	        $crmhide=$CompanySettings->update(get_setting(company($myid),'id'),$ac_data);
	        if ($crmhide) {
	            session()->setFlashdata('sucmsg', 'Saved!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }

	    }


	    if (isset($_POST['save_department'])) {
	        $dept_data = [
	            'company_id'=>company($myid),
	            'department_name'=>strip_tags($this->request->getVar('department_name')),
	            'department_head'=>strip_tags($this->request->getVar('staffid')),
	        ];
	       
	        if ($WorkDepartmentModel->save($dept_data)) {
	           
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	    }


	    if (isset($_POST['edit_work_department'])) {
	        $dept_data = [
	            'department_name'=>strip_tags($this->request->getVar('department_name')),
	            'department_head'=>strip_tags($this->request->getVar('staffid')),
	        ];

	        if ($WorkDepartmentModel->update(strip_tags($this->request->getVar('wpid')),$dept_data)) {
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	    }
	       

	     if (isset($_POST['save_reasons'])) {
	        $ac_data = [
	            'company_id'=>company($myid),
	            'stage'=>strip_tags($this->request->getVar('stage')),
	            'reason'=>strip_tags($this->request->getVar('reason')),
	        ];

	       

	        if ($LossReasons->save($ac_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'New loss reason (<b>#'.strip_tags($this->request->getVar('reason')).'</b>) added.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }


	     if (isset($_POST['edit_reason'])) {
	        $ac_data = [
	            'stage'=>strip_tags($this->request->getVar('stage')),
	            'reason'=>strip_tags($this->request->getVar('reason')),
	        ];

	       

	        if ($LossReasons->update(strip_tags($this->request->getVar('reason_id')),$ac_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>$myid,
	                'action'=>'Loss reason (#'.strip_tags($this->request->getVar('reason_id')).') <b>'.strip_tags($this->request->getVar('reason')).'</b> is updated.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }

	     
	     if (isset($_POST['save_work_category'])) {
	        $ac_data = [
	            'company_id'=>company($myid),
	            'category_name'=>strip_tags($this->request->getVar('category_name')),
	            'parent_id'=>strip_tags($this->request->getVar('parent_id')),
	        ];

	       
	        if ($WorkcategoryModel->save($ac_data)) {
	           
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }


	     if (isset($_POST['edit_work_category'])) {
	        $ac_data = [
	            'category_name'=>strip_tags($this->request->getVar('category_name')),
	            'parent_id'=>strip_tags($this->request->getVar('parent_id')),
	        ];

	       

	        if ($WorkcategoryModel->update(strip_tags($this->request->getVar('wcid')),$ac_data)) {
	            
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }


	    if (isset($_POST['save_category'])) {
	        $cc_data = [
	            'company_id'=>company($myid),
	            'designation'=>strip_tags($this->request->getVar('designation')),
	        ];


	        if ($Designation->save($cc_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $category_data=[
	                'user_id'=>$myid,
	                'action'=>'New contact category (<b>#'.strip_tags($this->request->getVar('designation')).'</b>) added.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($category_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }



	     if (isset($_POST['edit_category'])) {
	        $cc_data = [
	            'designation'=>strip_tags($this->request->getVar('designation')),
	        ];


	        if ($Designation->update(strip_tags($this->request->getVar('contact_id')),$cc_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $category_data=[
	                'user_id'=>$myid,
	                'action'=>'Contact Category (#'.strip_tags($this->request->getVar('contact_id')).') <b>'.strip_tags($this->request->getVar('designation')).'</b> is updated.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($category_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }


	    
	     if (isset($_POST['save_type'])) {
	        $ct_data = [
	            'company_id'=>company($myid),
	            'contact_type'=>strip_tags($this->request->getVar('contact_type')),
	        ];


	        if ($ContactType->save($ct_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $type_data=[
	                'user_id'=>$myid,
	                'action'=>'New contact type (<b>#'.strip_tags($this->request->getVar('contact_type')).'</b>) added.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($type_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }

	     if (isset($_POST['edit_type'])) {
	        $ct_data = [
	            'contact_type'=>strip_tags($this->request->getVar('contact_type')),

	        ];

	        if ($ContactType->update(strip_tags($this->request->getVar('type_id')),$ct_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $type_data=[
	                'user_id'=>$myid,
	                'action'=>'Contact Type(#'.strip_tags($this->request->getVar('type_id')).') <b>'.strip_tags($this->request->getVar('contact_type')).'</b> is updated.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($type_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }




	     if (isset($_POST['save_project_type'])) {
	        $pt_data = [
	            'company_id'=>company($myid),
	            'project_type'=>strip_tags($this->request->getVar('project_type')),
	        ];


	        if ($ProjectType->save($pt_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $projecttype_data=[
	                'user_id'=>$myid,
	                'action'=>'New project type (<b>#'.strip_tags($this->request->getVar('project_type')).'</b>) is added.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($projecttype_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }

	     

	     if (isset($_POST['edit_project_type'])) {
	        $pted_data = [
	            'project_type'=>strip_tags($this->request->getVar('project_type')),
	        ];


	        if ($ProjectType->update(strip_tags($this->request->getVar('project_type_id')),$pted_data)) {
	                ////////////////////////CREATE ACTIVITY LOG//////////////
	            $ptcategory_data=[
	                'user_id'=>$myid,
	                'action'=>'Project type (#'.strip_tags($this->request->getVar('project_type_id')).') <b>'.strip_tags($this->request->getVar('project_type')).'</b> is updated.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time($myid),
	                'updated_at'=>now_time($myid),
	                'company_id'=>company($myid),
	            ];

	            add_log($ptcategory_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	             session()->setFlashdata('sucmsg', 'Saved!');
	             return redirect()->to(base_url('settings/crm_configurations'));
	        }else{
	            session()->setFlashdata('pu_er_msg', 'Failed to save!');
	            return redirect()->to(base_url('settings/crm_configurations'));
	        }
	     }

	  
	    }else{
	        return redirect()->to(base_url('users/login'));
	    }
	}

	public function work_updates_settings(){
		$session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $WorkDepartmentModel= new WorkDepartmentModel;
            $WorkcategoryModel= new WorkcategoryModel;


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            //$key_user_data=$UserModel->where('company_id',company($myid))->where('author',1)->where('deleted',0)->findAll();
            $user_data=$UserModel->where('author',1)->where('deleted',0)->where('aitsun_user!=',1)->orderBy('id','desc')->findAll();
            $work_category_data= $WorkcategoryModel->where('company_id', company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();
           
            
            $data=[
                'title'=>'Manage clients',
                'user'=>$user,
                'user_data'=>$user_data,
                'work_category_data' => $work_category_data,
                'work_department'=> $WorkDepartmentModel->where('company_id', company($myid))->where('deleted',0)->orderBy('id','desc')->findAll(),
            ];

            echo view('header',$data);
            echo view('work_updates/work_updates_settings');
            echo view('footer');

    	}else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function save_department(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $WorkDepartmentModel = new WorkDepartmentModel;
       

        if ($this->request->getMethod('post')) { 

            $dept_data = [
                'company_id'=>company($myid),
                'department_name'=>strip_tags($this->request->getVar('department_name')),
                'department_head'=>strip_tags($this->request->getVar('staffid')),
            ];
           
            if ($WorkDepartmentModel->save($dept_data)) {
               
                 session()->setFlashdata('pu_msg', 'Saved!');
                 return redirect()->to(base_url('work_updates/work_updates_settings'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('work_updates/work_updates_settings'));
            }
        }
    }

    public function save_work_category(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $WorkcategoryModel = new WorkcategoryModel;
       

        if ($this->request->getMethod('post')) { 

            $ac_data = [
                'company_id'=>company($myid),
                'category_name'=>strip_tags($this->request->getVar('category_name')),
                'parent_id'=>strip_tags($this->request->getVar('parent_id')),
            ];

           
            if ($WorkcategoryModel->save($ac_data)) {
               
                session()->setFlashdata('pu_msg', 'Saved!');
                 return redirect()->to(base_url('work_updates/work_updates_settings'));
            }else{
                 session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('work_updates/work_updates_settings'));
            }
        }
    }

    public function edit_work_category($id=''){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $WorkcategoryModel = new WorkcategoryModel;
       

        if ($this->request->getMethod('post')) { 
        	$ac_data = [
                'category_name'=>strip_tags($this->request->getVar('category_name')),
                'parent_id'=>strip_tags($this->request->getVar('parent_id')),
            ];

           

            if ($WorkcategoryModel->update($id,$ac_data)) {
                
                 session()->setFlashdata('pu_msg', 'Saved!');
                 return redirect()->to(base_url('work_updates/work_updates_settings'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('work_updates/work_updates_settings'));
            }
            
        }
    }
    public function edit_work_department($id=''){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $WorkDepartmentModel = new WorkDepartmentModel;
       

        if ($this->request->getMethod('post')) { 
        	$dept_data = [
                'department_name'=>strip_tags($this->request->getVar('department_name')),
                'department_head'=>strip_tags($this->request->getVar('staffid')),
            ];

            if ($WorkDepartmentModel->update($id,$dept_data)) {
                 session()->setFlashdata('pu_msg', 'Saved!');
                 return redirect()->to(base_url('work_updates/work_updates_settings'));
            }else{
                session()->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('work_updates/work_updates_settings'));
            }
        }
    }

    public function get_catgry_select($parent=""){
        $WorkcategoryModel = new WorkcategoryModel();
        $WorkcategoryModel->where('parent_id',$parent);
        $WorkcategoryModel->where('deleted',0);
        $scs=$WorkcategoryModel->findAll();
        echo '<option value="">Select Work Category</option>';
        foreach ($scs as $sc) {
            echo '<option value="'.$sc['id'].'">'.$sc['category_name'].'</option>';
        }
    }

}