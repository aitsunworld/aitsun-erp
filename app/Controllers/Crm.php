<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\AccountCategory;
use App\Models\CustomerBalances;
use App\Models\PaymentsModel;
use App\Models\LeadModel;
use App\Models\FollowersModel;
use App\Models\ActivitiesNotes; 
use App\Models\TasksModel;
use App\Models\TaskDateModel;
use App\Models\MessageFileModel;
use App\Models\ProductrequestsModel;
use App\Models\Companies;



class Crm extends BaseController
{
    public function index()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $AccountCategory=new AccountCategory;
            $CustomerBalances=new CustomerBalances;
            $ProductrequestsModel=new ProductrequestsModel;
            $LeadModel = new LeadModel();
            $FollowersModel= new FollowersModel;


            if ($session->has('isLoggedIn')){
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();

                if (is_crm(company($myid))) {

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   

                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    if (check_permission($myid,'manage_crm')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

                     

                    $data=[
                        'title'=> 'Aitsun ERP-CRM',
                        'user'=> $user, 
                    ];

                    
 
                    echo view('header',$data);
                    echo view('crm/crm', $data);
                    echo view('footer');
                }else{
                    return redirect()->to(base_url());
                }

            }else{
                return redirect()->to(base_url('users/login'));
            }               
    }

    public function store()
    {  
         $session=session();

         $UserModel= new Main_item_party_table();
         $LeadModel = new LeadModel();
         $FollowersModel = new FollowersModel();

        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

              

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

            $data=[
              'title'=> 'Aitsun ERP-CRM',
              'user'=> $user,
            ];

        $data = [
            'company_id'=>company($myid),
            'cr_customer'=>strip_tags($this->request->getVar('cr_customer')),
            'lead_name' => strip_tags($this->request->getVar('lead_name')),
            'description'=> strip_tags($this->request->getVar('lead_description')), 
            'company_name' => strip_tags($this->request->getVar('company_name')),
            'work_phone' => strip_tags($this->request->getvar('work_phone')),
            'work_email' => strip_tags($this->request->getVar('work_email')),
            'address' => strip_tags($this->request->getvar('address')),
            'web' => strip_tags($this->request->getvar('web')),
            'position' => strip_tags($this->request->getvar('position')),
            'skype' => strip_tags($this->request->getVar('skype')),
            'note' => strip_tags($this->request->getVar('note')),
            'serial_number' => lead_serial(),
            'lead_status' => strip_tags($this->request->getVar('lead_status')),
            'project_type'=> strip_tags($this->request->getVar('project_type')),
            'lead_by'=> strip_tags($this->request->getVar('lead_by')),
            'responsible_user' =>$myid,
            'contact' =>strip_tags( $this->request->getVar('work_phone')),
            'created_at' => now_time($myid),
            'lead_date' => now_time($myid),
            'updated_at' => now_time($myid),
            'start_date' => strip_tags($this->request->getvar('start_date')),
            'end_date'=> strip_tags($this->request->getvar('end_date'))
        ];
       
        $save = $LeadModel->save($data);
        $inserid=$LeadModel->insertID();
        if ($save) {

            //adding multiplae followers
            if ($this->request->getVar('followers')) {
                foreach ($this->request->getVar('followers') as $i => $value) {
                    $folloers_data=[
                        'follower_id'=>$this->request->getVar('followers')[$i],
                        'lead_id'=>$inserid
                    ];
                    if ($this->request->getVar('followers')[$i]!=0) {
                        $FollowersModel->insert($folloers_data);
                    }
                    
                }
            }
                
            //adding multiplae followers


          $action='Lead created: '.strip_tags($this->request->getVar('lead_name'));
          create_log($inserid,$action,$myid);

          $ActivitiesNotes = new ActivitiesNotes();
          $notedata = [
              'company_id'=>company($myid),
              'lead_id' => $inserid,
              'activities' => '',
              'type' => 'note',          
              'note' => strip_tags($this->request->getVar('note')),
              'user_id' =>$myid,
              'created_at' => now_time($myid),
              'updated_at' => now_time($myid)
          ];
          if (!empty(trim(strip_tags($this->request->getVar('note'))))) {
            $save = $ActivitiesNotes->insert($notedata);
          }


        // // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
        //     $title='New Project <b>'.strip_tags($this->request->getVar('lead_name')).'</b> added.';
        //     $message='';
        //     $url=base_url().'/crm'; 
        //     $icon=notification_icons('user');
        //     $userid='all';
        //     $nread=0;
        //     $for_who='admin';
        //     $notid='project';
        //     notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
        // // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]



           //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$inserid,
               'task'=>'New lead <b>'.strip_tags($this->request->getVar('lead_name')).'</b> is created',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>strip_tags($this->request->getVar('lead_status')),
               'task_type'=>'Creation',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////


            session()->setFlashdata('sucmsg', 'Saved!');
            return redirect()->to(base_url('crm/details/'.$inserid));

        }else{
            session()->setFlashdata('failmsg', 'Failed to save!');
            return redirect()->to(base_url('crm'));
        }

        }else{
                return redirect()->to(base_url());
            }
        }
        return redirect()->to(base_url('users/login'));
    }


    public function update_status()
    {  
 
        helper(['form', 'url']);
         
        $usermodel= new Main_item_party_table();
        $model = new LeadModel();
        $LeadModel = new LeadModel();
        $Companies = new Companies();

        $leadid=strip_tags($this->request->getVar('lead'));
        $lead_status=strip_tags($this->request->getVar('status'));
        $data = [];
        $myid=session()->get('id');

        $llldat=$model->where('id', $leadid)->first();
        $fromstatus=lead_status_name($llldat['lead_status']);

        $data = [
            'lead_status' => $lead_status
        ];

        $save = $model->update($leadid,$data);

        $status=lead_status_name($lead_status);
        $statusclass=status_bg($lead_status);
        
        if ($status!=$fromstatus) {
          $action='Moved to: <span class="note_span '.$statusclass.'">'.$status.'</span> from '.$fromstatus;
          create_log($leadid,$action,$myid);
        }

         //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'Lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b>',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>$lead_status,
               'task_type'=>'Lead Moved',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////


           /////////////////  MOVE LEAD NOTIFICATIONS ///////////////
           // $get_branches=$Companies->where('parent_company', main_company_id($myid));
           //      $LeadModel->where('company_id',company($myid));
           //      $LeadModel->groupStart();
                
           //      foreach($get_branches->findAll() as $ci){
           //          if ($ci['id']!=company($myid)) {
           //              $LeadModel->orWhere('company_id',$ci['id']);
           //          }
           //      }
           //      $LeadModel->groupEnd();
                $get_leads_of_all_branch=$LeadModel->where('id',$llldat['id'])->findAll();

                foreach ($get_leads_of_all_branch as $led) {


                    if ($led['lead_by']!=0) {
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                            $title='Lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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

                    

                        foreach(get_admins_of_company($led['company_id']) as $cid){
                            if ($led['lead_by']!=$cid['id']) {
                                // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                    $title='Lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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
                    
                    

                    foreach(get_users_by_permission($led['company_id'],'manage_crm') as $use){
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='Lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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
                            $title='Lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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

                
                }



        
    }


    public function details($leadid="")
    {   
      $session=session(); 
       if ($session->has('isLoggedIn')){

            $UserModel = new Main_item_party_table();
            $LeadModel = new LeadModel();
            $ActivitiesNotes = new ActivitiesNotes();
            $TasksModel = new TasksModel();

            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

              

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

                if (check_permission($myid,'manage_crm')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (!empty($leadid)) {
              $leadsdata=$LeadModel->where('id', $leadid)->where('deleted',0)->first();
              if ($leadsdata) {
                  $data=[
                    'title'=> 'Project Details | Aitsun Projects',
                    'user'=> $user,
                    'lead_data'=>$leadsdata,
                    'activities'=>$ActivitiesNotes->where('lead_id',$leadid)->where('deleted',0)->findAll(),
                    'tasks'=>$TasksModel->where('lead_id',$leadid)->where('deleted',0)->findAll(),
                  ];

                  echo view('header',$data);   
                  echo view('crm/details');
                  echo view('footer');
              }else{
                return redirect()->to(base_url('crm'));
              }
            }else{
              return redirect()->to(base_url('crm'));
            }

        }else{
                    return redirect()->to(base_url());
                }
            
            
          }else{
            return redirect()->to(base_url('users'));

          }
        
    }


    public function delete($lead_id=""){
            
            $session=session();
            $myid=session()->get('id');

            $LeadModel= new LeadModel;
            $lead_data=$LeadModel->where('id',$lead_id)->first();


            $deledata=[
                'deleted'=>1
            ];
            $del=$LeadModel->update($lead_id,$deledata);



            if ($del) {
                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Lead <b>'.htmlentities($lead_data['lead_name']).'</b> is deleted',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Delete',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                $session->setFlashdata('sucmsg', 'Deleted!');
                return redirect()->to(base_url('crm'));
            }else{
                $session->setFlashdata('failmsg', 'Failed to delete!');
                return redirect()->to(base_url('crm'));
            }
            

         
        }



    public function delete_task($task_id="",$lead_id=""){
            
            $session=session();
            $myid=session()->get('id');

            $TasksModel= new TasksModel;
            $LeadModel= new LeadModel;

            $task_data=$TasksModel->where('id',$task_id)->first();
            $lead_data=$LeadModel->where('id',$lead_id)->first();

            $deledata=[
                'deleted'=>1
            ];
            $del=$TasksModel->update($task_id,$deledata);

            if ($del) {

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Task <b>'.$task_data['task'].'</b> is deleted under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Task delete',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////

                $session->setFlashdata('sucmsg', 'Deleted!');
                return redirect()->to(base_url('crm/details/'.$lead_id));
            }else{

                $session->setFlashdata('failmsg', 'Failed to delete!');
                return redirect()->to(base_url('crm/details/'.$lead_id));
            }
            

         
        }


    public function delete_note($note_id="",$lead_id=""){
            
            $session=session();
            $myid=session()->get('id');

            $ActivitiesNotes= new ActivitiesNotes;
            $LeadModel= new LeadModel;
            $lead_data=$LeadModel->where('id',$lead_id)->first();

            $note_data=$ActivitiesNotes->where('id',$note_id)->first();

            $deledata=[
                'deleted'=>1
            ];

            $del=$ActivitiesNotes->update($note_id,$deledata);

            if ($del) {

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Note <b>'.$note_data['note'].'</b> is deleted under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Note delete',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                $session->setFlashdata('sucmsg', 'Deleted!');
                return redirect()->to(base_url('crm/details/'.$lead_id));
            }else{

                $session->setFlashdata('failmsg', 'Failed to delete!');
                return redirect()->to(base_url('crm/details/'.$lead_id));
            }
            

         
        }


    public function update($leadid="")
    {  
        $session=session(); 
           if ($session->has('isLoggedIn')){

            $UserModel = new Main_item_party_table();
            $LeadModel = new LeadModel();
            $TasksModel = new TasksModel();

            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            $FollowersModel = new FollowersModel();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }


        $llldat=$LeadModel->where('id', $leadid)->first();
        $fromstatus=lead_status_name($llldat['lead_status']);

        $data = [
            'cr_customer'=>strip_tags($this->request->getVar('cr_customer')),
            'lead_name' => strip_tags($this->request->getVar('lead_name')),
            'description'=> strip_tags($this->request->getVar('lead_description')), 
            'company_name' => strip_tags($this->request->getVar('company_name')),
            'work_phone' => strip_tags($this->request->getvar('work_phone')),
            'work_email' => strip_tags($this->request->getVar('work_email')),
            'address' => strip_tags($this->request->getvar('address')),
            'web' => strip_tags($this->request->getvar('web')),
            'position' => strip_tags($this->request->getvar('position')),
            'skype' => strip_tags($this->request->getVar('skype')),
            'note' => strip_tags($this->request->getVar('note')),
            'project_type'=> strip_tags($this->request->getVar('project_type')),
            'lead_by'=> strip_tags($this->request->getVar('lead_by')),
            'lead_status' => strip_tags($this->request->getVar('lead_status')),
            'contact' =>strip_tags( $this->request->getVar('work_phone')),
            'updated_at' => now_time($myid),
            'start_date' => strip_tags($this->request->getvar('start_date')),
            'end_date'=> strip_tags($this->request->getvar('end_date'))
        ];

         
        
        $save = $LeadModel->update($leadid,$data);


        //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'Lead <b>'.strip_tags($this->request->getVar('lead_name')).'</b> is updated',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>strip_tags($this->request->getVar('lead_status')),
               'task_type'=>'Update',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////



        if ($save) {

            $FollowersModel->where('id',$leadid)->delete();

            $deletebeforeupdate=$FollowersModel->where('lead_id',$leadid)->delete();

        //adding multiplae followers
            if ($this->request->getVar('followers')) {
                foreach ($this->request->getVar('followers') as $i => $value) {
                    $folloers_data=[
                        'follower_id'=>$this->request->getVar('followers')[$i],
                        'lead_id'=>$leadid
                    ];
                    if ($this->request->getVar('followers')[$i]!=0) {
                        $FollowersModel->insert($folloers_data);
                    }
                    
                }
            }
                
            //adding multiplae followers

        $status=lead_status_name(strip_tags($this->request->getVar('lead_status')));
        $statusclass=status_bg(strip_tags($this->request->getVar('lead_status')));
        
        if ($status!=$fromstatus) {
          $action='Moved to: <span class="note_span '.$statusclass.'">'.$status.'</span> from '.$fromstatus;
          create_log($leadid,$action,$myid);
        }

        $session->setFlashdata('sucmsg', 'Saved!');
        return redirect()->to(base_url('crm/details/'.$leadid));
            
        }else{

        $session->setFlashdata('sucmsg', 'Failed to save!');
        return redirect()->to(base_url('crm/details/'.$leadid));


        }

        
        }else{
                return redirect()->to(base_url());
            }

        }else{
            return redirect()->to(base_url('users'));

          }
    }



    public function add_task($leadid=""){

        $session=session(); 
           if ($session->has('isLoggedIn')){

          $UserModel= new Main_item_party_table();
          $TasksModel = new TasksModel();
          $TaskDateModel = new TaskDateModel();
          $LeadModel = new LeadModel();

          $myid=session()->get('id');
          $user=$UserModel->where('id',$myid)->first();
          $lead_data=$LeadModel->where('id',$leadid)->first();


          $data = [
              'lead_id' => $leadid,
              'company_id'=>company($myid),
              'task'=>strip_tags($this->request->getVar('task')),
              'user_id'=>$myid,
              'followers'=>strip_tags($this->request->getVar('followers')),
              'task_type'=>strip_tags($this->request->getVar('task_type')),
              'created_at'=>now_time($myid),
              'notified'=>0,
              'task_status'=>strip_tags($this->request->getVar('task_status')),
              'deleted'=>0
          ];

          $save = $TasksModel->insert($data);

          if ($save) {


            $taskid=$TasksModel->insertID();

            //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'New task <b>'.strip_tags($this->request->getVar('task')).'</b> is created under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>$lead_data['lead_status'],
               'task_type'=>'Task',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////


            if (strip_tags($this->request->getVar('task_type'))=='day repeat') {
              $datedata=[
                'task_id'=>$taskid,
                'company_id'=>company($myid),
                'task_type'=>strip_tags($this->request->getVar('task_type')),
                'from'=>strip_tags($this->request->getVar('date_from')),
                'to'=>strip_tags($this->request->getVar('date_to')),
                'lead_id'=>$leadid,
                'notified'=>0
              ];
              $TaskDateModel->save($datedata);
            }elseif (strip_tags($this->request->getVar('task_type'))=='single day') {
              $datedata=[
                'task_id'=>$taskid,
                'company_id'=>company($myid),
                'task_type'=>strip_tags($this->request->getVar('task_type')),
                'from'=>strip_tags($this->request->getVar('single_date')),
                'lead_id'=>$leadid,
                'notified'=>0
              ];
              $TaskDateModel->save($datedata);
            }elseif (strip_tags($this->request->getVar('task_type'))=='multiple day') {
              
              foreach ($this->request->getVar('multiple_date') as $i => $value) {
                if (!empty($this->request->getVar('multiple_date')[$i])) {
                  $datedata=[
                    'task_id'=>$taskid,
                    'company_id'=>company($myid),
                    'task_type'=>strip_tags($this->request->getVar('task_type')),
                    'from'=>strip_tags($this->request->getVar('multiple_date')[$i]),
                    'lead_id'=>$leadid,
                    'notified'=>0
                  ];
                  $TaskDateModel->save($datedata);
                }
                  
              }

            }

            $session->setFlashdata('sucmsg', 'Task added!');
            return redirect()->to(base_url('crm/details/'.$leadid));

          }else{
            $session->setFlashdata('failmsg', 'Failed to save!');
            return redirect()->to(base_url('crm/details/'.$leadid));
          }

          }else{
            return redirect()->to(base_url('users'));

          }
          
          
    }



    public function edit_task($leadid="",$task_id=""){

        $session=session(); 
           if ($session->has('isLoggedIn')){

          $UserModel= new Main_item_party_table();
          $TasksModel = new TasksModel();
          $TaskDateModel = new TaskDateModel();
          $LeadModel = new LeadModel();

          $myid=session()->get('id');
          $user=$UserModel->where('id',$myid)->first();
          $lead_data=$LeadModel->where('id',$leadid)->first();


          $data = [
              'lead_id' => $leadid,
              'company_id'=>company($myid),
              'task'=>strip_tags($this->request->getVar('task')),
              'user_id'=>$myid,
              'followers'=>strip_tags($this->request->getVar('followers')),
              'task_type'=>strip_tags($this->request->getVar('task_type')),
              'created_at'=>now_time($myid),
              'notified'=>0,
              'task_status'=>strip_tags($this->request->getVar('task_status')),
              'deleted'=>0
          ];

          $save = $TasksModel->update($task_id,$data);

          if ($save) {


            $taskid=$task_id;

            $TaskDateModel->where('task_id',$taskid)->delete();

            if (strip_tags($this->request->getVar('task_type'))=='day repeat') {
              $datedata=[
                'task_id'=>$taskid,
                'company_id'=>company($myid),
                'task_type'=>strip_tags($this->request->getVar('task_type')),
                'from'=>strip_tags($this->request->getVar('date_from')),
                'to'=>strip_tags($this->request->getVar('date_to')),
                'lead_id'=>$leadid,
                'notified'=>0
              ];
              $TaskDateModel->save($datedata);
            }elseif (strip_tags($this->request->getVar('task_type'))=='single day') {
              $datedata=[
                'task_id'=>$taskid,
                'company_id'=>company($myid),
                'task_type'=>strip_tags($this->request->getVar('task_type')),
                'from'=>strip_tags($this->request->getVar('single_date')),
                'lead_id'=>$leadid,
                'notified'=>0
              ];
              $TaskDateModel->save($datedata);
            }elseif (strip_tags($this->request->getVar('task_type'))=='multiple day') {
              
              foreach ($this->request->getVar('multiple_date') as $i => $value) {
                if (!empty($this->request->getVar('multiple_date')[$i])) {
                  $datedata=[
                    'task_id'=>$taskid,
                    'company_id'=>company($myid),
                    'task_type'=>strip_tags($this->request->getVar('task_type')),
                    'from'=>strip_tags($this->request->getVar('multiple_date')[$i]),
                    'lead_id'=>$leadid,
                    'notified'=>0
                  ];
                  $TaskDateModel->save($datedata);
                }
                  
              }

            }


             //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'Task <b>'.strip_tags($this->request->getVar('task')).'</b> is updated under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>$lead_data['lead_status'],
               'task_type'=>'Task update',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////


            $session->setFlashdata('sucmsg', 'Task updated!');
            return redirect()->to(base_url('crm/details/'.$leadid));

          }else{
            $session->setFlashdata('failmsg', 'Failed to save!');
            return redirect()->to(base_url('crm/details/'.$leadid));
          }

          }else{
            return redirect()->to(base_url('users'));

          }
          
          
    }


    


    public function add_note($leadid="")
    {  
        $session=session(); 
           if ($session->has('isLoggedIn')){

            $Usermodel = new Main_item_party_table();
            $ActivitiesNotes = new ActivitiesNotes();
            $MessageFileModel = new MessageFileModel();

            $LeadModel = new LeadModel();
            $lead_data=$LeadModel->where('id',$leadid)->first();

             $needle = 'send_to_all_leads///';
            $myid=session()->get('id');

            $countfile=0;
            foreach ($this->request->getFileMultiple('messagefile') as $file) {
                if ($file->isValid()) {
                    $countfile++;
                }   
            }
            
            $data = [
                'lead_id' => $leadid,
                'company_id'=>company($myid),
                'activities' => '',
                'type' => 'note',          
                'note' => str_replace($needle, '', strip_tags($this->request->getVar('note'))),
                'user_id' =>$myid,
                'created_at' => now_time($myid),
                'updated_at' => now_time($myid)
            ];

            if (!empty(trim(strip_tags($this->request->getVar('note')))) || $countfile>0) {
              $save = $ActivitiesNotes->insert($data); 
              $noteid=$ActivitiesNotes->insertID();

            //////////// send to all notes ////////////
                $notetext = strip_tags($this->request->getVar('note'));
               
                if(strpos($notetext,$needle)!==false) {

                    $this_lead_data=$LeadModel->where('lead_by',$lead_data['lead_by'])->where('deleted',0)->where('company_id',company($myid))->where('id!=',$leadid)->findAll();

                    foreach ($this_lead_data as $tld) {
                        $new_data = [
                            'lead_id' => $tld['id'],
                            'company_id'=>company($myid),
                            'activities' => '',
                            'type' => 'note',          
                            'note' => str_replace($needle, '', strip_tags($this->request->getVar('note'))),
                            'user_id' =>$myid,
                            'created_at' => now_time($myid),
                            'updated_at' => now_time($myid)
                        ];
                        $new_save = $ActivitiesNotes->insert($new_data); 
                        $new_noteid=$ActivitiesNotes->insertID();
                         $task_report_data=[
                           'company_id'=>company($myid),
                           'lead_id'=>$leadid,
                           'task'=>'New note <b>'.str_replace($needle, '', strip_tags($this->request->getVar('note'))).'</b> is created under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
                           'datetime'=>now_time($myid),
                           'created_by'=>$myid,
                           'ip'=>get_client_ip(),
                           'mac'=>GetMAC(),
                           'grid_no'=>$lead_data['lead_status'],
                           'task_type'=>'Note',
                           'report'=>'',
                       ];

                       add_task_report($task_report_data);
                    }
                    
                }
            //////////// send to all notes ////////////

              


             //////////////////////////////////////////////////////////
            //                    ADD TASK REPORT                   //
           //////////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'New note <b>'.strip_tags($this->request->getVar('note')).'</b> is created under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>$lead_data['lead_status'],
               'task_type'=>'Note',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////





                echo "0";
              if (!empty($this->request->getFileMultiple('messagefile'))) {
                echo "1";
                foreach ($this->request->getFileMultiple('messagefile') as $file) {
                  
                  echo "2";
                  if ($file->isValid()) {
                    echo "3";
                      $filename = $file->getClientName();
                      $mimetype=$file->getClientMimeType();
                      $size= $file->getSize();
                      $file->move('public/images/',$filename);

                
                        $filedata = [
                          'note_id'=>$noteid,
                          'type'=>$mimetype,
                          'size'=>$size,
                          'file'=>$filename,
                      ];
                      $MessageFileModel->save($filedata);
                  }

                      
                }
                    

              }

            }
        
            return redirect()->to(base_url('crm/details/'.$leadid));
        }else{
                return redirect()->to(base_url('users'));

              }
          }


  public function tasks()
    {   


      $session=session(); 
      if ($session->has('isLoggedIn')){
       
        $UserModel = new Main_item_party_table();
        $TasksModel = new TasksModel();


        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();

        if (is_crm(company($myid))) {

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }
       

        if ($_GET) {
          

          if (!empty($_GET['followers']) && empty($_GET['search_leads'])) {
            $entry_leads=$TasksModel->where('company_id',company($myid))->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'to_do')->orderBy('task', 'ASC')->findAll();
            $site_leads=$TasksModel->where('company_id',company($myid))->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'do')->orderBy('task', 'ASC')->findAll();
            $quoatlead=$TasksModel->where('company_id',company($myid))->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'testing')->orderBy('task', 'ASC')->findAll();
            $wonleads=$TasksModel->where('company_id',company($myid))->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'done')->orderBy('task', 'ASC')->findAll();
            $lostleads=$TasksModel->where('company_id',company($myid))->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'failed')->orderBy('task', 'ASC')->findAll();


          }elseif (empty($_GET['followers']) && !empty($_GET['search_leads'])) {
            
            $entry_leads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('deleted', 0)->where('task_status', 'to_do')->orderBy('task', 'ASC')->findAll();
            $site_leads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('deleted', 0)->where('task_status', 'do')->orderBy('task', 'ASC')->findAll();
            $quoatlead=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('deleted', 0)->where('task_status', 'testing')->orderBy('task', 'ASC')->findAll();
            $wonleads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('deleted', 0)->where('task_status', 'done')->orderBy('task', 'ASC')->findAll();
            $lostleads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('deleted', 0)->where('task_status', 'failed')->orderBy('task', 'ASC')->findAll();
          }elseif(!empty($_GET['followers']) && !empty($_GET['search_leads'])){
            $entry_leads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'to_do')->orderBy('task', 'ASC')->findAll();
            $site_leads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'do')->orderBy('task', 'ASC')->findAll();
            $quoatlead=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'testing')->orderBy('task', 'ASC')->findAll();
            $wonleads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'done')->orderBy('task', 'ASC')->findAll();
            $lostleads=$TasksModel->where('company_id',company($myid))->like('task',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->where('followers',$_GET['followers'])->where('deleted', 0)->where('task_status', 'failed')->orderBy('task', 'ASC')->findAll();
          }else{

            $entry_leads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'to_do')->orderBy('task', 'ASC')->findAll();
            $site_leads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'do')->orderBy('task', 'ASC')->findAll();
            $quoatlead=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'testing')->orderBy('task', 'ASC')->findAll();
            $wonleads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'done')->orderBy('task', 'ASC')->findAll();
            $lostleads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'failed')->orderBy('task', 'ASC')->findAll();
          }
        
        }else{

        $entry_leads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'to_do')->orderBy('task', 'ASC')->findAll();
        $site_leads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'do')->orderBy('task', 'ASC')->findAll();
        $quoatlead=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'testing')->orderBy('task', 'ASC')->findAll();
        $wonleads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'done')->orderBy('task', 'ASC')->findAll();
        $lostleads=$TasksModel->where('company_id',company($myid))->where('deleted', 0)->where('task_status', 'failed')->orderBy('task', 'ASC')->findAll();


        }


        if ($user['u_type']=='superuser') {
          $data=[
            'title'=> 'Aitsun ERP-CRM | Tasks',
            'user'=> $user,
            'entry_leads'=> $entry_leads,
            'site_visit_leads'=> $site_leads,
            'quoation_leads'=> $quoatlead,
            'won_leads'=> $wonleads,
            'lost_leads'=> $lostleads,
          ];
        }else{

          $data=[
            'title'=> 'Aitsun ERP-CRM | Tasks',
            'user'=> $user,
            'entry_leads'=> $TasksModel->where('company_id',company($myid))->where('deleted', 0)->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('task_status', 'to_do')->orderBy('task', 'ASC')->findAll(),
            'site_visit_leads'=> $TasksModel->where('company_id',company($myid))->where('deleted', 0)->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('task_status', 'do')->orderBy('task', 'ASC')->findAll(),
            'quoation_leads'=> $TasksModel->where('company_id',company($myid))->where('deleted', 0)->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('task_status', 'testing')->orderBy('task', 'ASC')->findAll(),
            'won_leads'=> $TasksModel->where('company_id',company($myid))->where('deleted', 0)->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('task_status', 'done')->orderBy('task', 'ASC')->findAll(),
            'lost_leads'=> $TasksModel->where('company_id',company($myid))->where('deleted', 0)->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('task_status', 'failed')->orderBy('task', 'ASC')->findAll(),
          ];

        }

        echo view('header',$data); 
        echo view('crm/tasks');
        echo view('footer');

        }else{
                    return redirect()->to(base_url());
                }

      }else{
        return redirect()->to(base_url('users'));

      }
        
   }

   public function update_task_status()
    {  
 
        helper(['form', 'url']);
         
         $usermodel= new Main_item_party_table();
         $TasksModel = new TasksModel();
         $LeadModel = new LeadModel();


         $taskidd=strip_tags($this->request->getVar('lead'));
         $lead_status=strip_tags($this->request->getVar('status'));
          $data = [];
          $myid=session()->get('id');

        $llldat=$TasksModel->where('id', $taskidd)->first();
        $fromstatus=$llldat['task_status'];
        $lead_id=$llldat['lead_id'];
        $lead_data=$LeadModel->where('id',$lead_id)->first();

        $data = [
            'task_status' => $lead_status
        ];

         
        
        $save = $TasksModel->update($taskidd,$data);

        if ($lead_status!=$fromstatus) {
            $tostat='';
            $fromstat='';
            if ($lead_status=='done'){
                $tostat='<span class="badge rounded-pill bg-gradient-lush text-capitalize">'.$lead_status.'</span>';
                $tostat_rcls=$lead_status;
            }else{
                $tostat='<span class="badge rounded-pill bg-gradient-blues text-capitalize">'.$lead_status.'</span>';
                $tostat_rcls=$lead_status;
            }

            if ($fromstatus=='done'){
                $fromstat='<span class="badge rounded-pill bg-gradient-lush text-capitalize">'.$fromstatus.'</span>';
                $fromstat_rcls=$fromstatus;
            }else{
                $fromstat='<span class="badge rounded-pill bg-gradient-blues text-capitalize">'.$fromstatus.'</span>';
                $fromstat_rcls=$fromstatus;
            }

          $action='Task moved to: <span class="note_span">'.$tostat.'</span> from '.$fromstat;
          create_log($lead_id,$action,$myid);
        }


        //  //////////////////////////////////////////////////////
       //                    ADD TASK REPORT                 //
       // //////////////////////////////////////////////////////
       $task_report_data=[
           'company_id'=>company($myid),
           'lead_id'=>$lead_id,
           'task'=>'Task <b>'.htmlentities($llldat['task']).'</b> is moved to: <b class="text-capitalize">'.$tostat_rcls.'</b> from <b class="text-capitalize">'.$fromstat_rcls.'</b> under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
           'datetime'=>now_time($myid),
           'created_by'=>$myid,
           'ip'=>get_client_ip(),
           'mac'=>GetMAC(),
           'grid_no'=>$lead_data['lead_status'],
           'task_type'=>'Task moved',
           'report'=>'',
       ];

       add_task_report($task_report_data);

       // //////////////////////////////////////////////////////
       //                    END TASK REPORT                 //
       // //////////////////////////////////////////////////////


       /////////////////  MOVE LEAD NOTIFICATIONS ///////////////
           // $get_branches=$Companies->where('parent_company', main_company_id($myid));
           //      $LeadModel->where('company_id',company($myid));
           //      $LeadModel->groupStart();
                
           //      foreach($get_branches->findAll() as $ci){
           //          if ($ci['id']!=company($myid)) {
           //              $LeadModel->orWhere('company_id',$ci['id']);
           //          }
           //      }
           //      $LeadModel->groupEnd();
                $get_leads_of_all_branch=$LeadModel->where('id',$lead_id)->findAll();

                foreach ($get_leads_of_all_branch as $led) {

                    $alltasks=$TasksModel->where('lead_id',$led['id'])->where('deleted',0)->findAll();

                    foreach ($alltasks as $tsk) {



                    if ($tsk['followers']!=0) {
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                            $title='Task <b>'.$tsk['task'].'</b> is moved to: <b>'.$tostat_rcls.'</b> from <b>'.$fromstat_rcls.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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

                    

                    foreach(get_admins_of_company($led['company_id']) as $cid){
                        if ($tsk['followers']!=$cid['id']) {
                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                $title='Task <b>'.htmlentities($llldat['task']).'</b> is moved to: <b>'.$tostat_rcls.'</b> from <b>'.$fromstat_rcls.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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

                    foreach(get_users_by_permission($led['company_id'],'manage_crm') as $use){
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='Task <b>'.htmlentities($llldat['task']).'</b> is moved to: <b>'.$tostat_rcls.'</b> from <b>'.$fromstat_rcls.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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
                            $title='Task <b>'.htmlentities($llldat['task']).'</b> is moved to: <b>'.$tostat_rcls.'</b> from <b>'.$fromstat_rcls.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
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
                }
        }
        
    } 


    public function get_against_data(){
        $myid=session()->get('id');
        $LeadModel = new LeadModel();
        $leads=$LeadModel->where('company_id',company($myid))->where('deleted',0)->where('lead_status!=','complete')->orderBy('id','desc')->findAll();
        if ($_GET) {
            if (isset($_GET['redirect_url'])) {
                if (!empty($_GET['redirect_url'])) { 

                ?>

                    <div class="agin_data_cs">
                        <ul class="list-unstyled against_ul">
                            <?php foreach ($leads as $ld): ?>
                                <li class="list-group-item">
                                    <a class="d-block button_loader" href="<?= $_GET['redirect_url'] ?>?from_lead=<?= $ld['id']; ?>&from_stage=<?= $_GET['from_stage'] ?>">
                                        <span class="d-block text-dark">Project ID: <?= $ld['id']; ?></span>
                                        <small><?= $ld['lead_name']; ?></small>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <div>
                        <a href="<?= $_GET['redirect_url']; ?>" class="aitsun-primary-btn d-block text-center href_loader">+ Create new</a>
                    </div>

                <?php }
            }
        }
    }


    public function get_against_data_from_renew(){
        $myid=session()->get('id');
        $LeadModel = new LeadModel();
        $leads=$LeadModel->where('company_id',company($myid))->where('deleted',0)->where('lead_status!=','complete')->orderBy('id','desc')->findAll();
        if ($_GET) {
            if (isset($_GET['redirect_url'])) {
                if (!empty($_GET['redirect_url'])) { 

                ?>

                    <div class="agin_data_cs">
                        <ul class="list-unstyled">
                            <?php foreach ($leads as $ld): ?>
                                <li class="list-group-item">
                                    <a class="d-block button_loader" href="<?= $_GET['redirect_url'] ?>&from_lead=<?= $ld['id']; ?>&from_stage=<?= $_GET['from_stage'] ?>">
                                        <span class="d-block text-dark">Project ID: <?= $ld['id']; ?></span>
                                        <small><?= $ld['lead_name']; ?></small>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <div>
                        <a href="<?= $_GET['redirect_url']; ?>" class="aitsun-primary-btn button_loader d-block text-center w-100 href_loader">+ Create new</a>
                    </div>

                <?php }
            }
        }
    }


    
}
