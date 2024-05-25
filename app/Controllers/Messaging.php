<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\Classtablemodel;
use App\Models\SmslistModel;
use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\Examcategorymodel;
use App\Models\MainexamModel;
use App\Models\MarksModel;



class Messaging extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
        $Classtablemodel= new Classtablemodel();

        $pager = \Config\Services::pager();
	    $myid=session()->get('id');
        
	    
	    if ($session->has('isLoggedIn')) {


            $results_per_page = 12; 
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                if (check_permission($myid,'manage_messaging')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}

	    		$students=$user->where('company_id',company($myid))->where('u_type','student')->where('deleted','0')->findAll();

                if ($_GET) {
                    
                    if (isset($_GET['searchname'])) {
                        if (!empty($_GET['searchname'])) {
                            $Classtablemodel->like('first_name', $_GET['searchname'], 'both'); 
                        }
                    }
                    if (isset($_GET['sel_class'])) {
                        if (!empty($_GET['sel_class'])) {
                            $Classtablemodel->like('class_id', $_GET['sel_class'], 'both'); 
                        }
                    }
                    if (isset($_GET['sele_gender'])) {
                        if (!empty($_GET['sele_gender'])) {
                            $Classtablemodel->like('gender', $_GET['sele_gender'], 'both'); 
                        }
                    }
                }

	    		
	    		$students_data=$Classtablemodel->where('company_id',company($myid))->where('academic_year', academic_year($myid))->where('deleted','0')->paginate(25);

                
                $data=[
                    'title'=>'Messaging | Erudite ERP',
                    'user'=>$usaerdata,
                    'students_data'=>$students_data,
                    'pager' => $Classtablemodel->pager,           
                ];
                
    
    	    		echo view('header',$data);
    	    		
    	    		echo view('message/message');
    	    		echo view('footer');
                


	    	
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	

    public function messaging_sucmes()
    {
        $session = session();
        $session->setFlashdata('pu_msg', 'SMS Sent');

        return redirect()->to(base_url('messaging'));
    }

	public function message()
    {   
        $user=new Main_item_party_table();
        $SmslistModel= new SmslistModel();

        $myid=session()->get('id');
       
        if (message_credits(company($myid))>0) {
            $mobileNumber = strip_tags(trim($_POST['phone']));
            $senderId = "ABCDEF";
            // str_replace("array("\n", "\r","<br>","</br>","%0a""), '', trim($_POST['smsmessage']))
            $message = strip_tags(trim($_POST['smsmessage']));
            
            $result=send_sms(company($myid),$message,$mobileNumber);

           

            if ($result) {

                return redirect()->to(base_url('messaging/messaging_sucmes'));

                $smsdata=[
                'company_id' =>company($myid),
                'number' => $mobileNumber,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,
                ];

                $SmslistModel->save($smsdata);


            } else {
                $session = session();
                $session->setFlashdata('pu_er_msg', 'Failed');

                return redirect()->to(base_url('messaging'));
            }

        }else{
            $session = session();
            $session->setFlashdata('pu_er_msg', 'No sufficient credits');

            return redirect()->to(base_url('messaging'));
        }
            

        
    }

    public function send_credentials()
    {   
        $user=new Main_item_party_table();
        $SmslistModel= new SmslistModel();

        $myid=session()->get('id');
       
        if (message_credits(company($myid))>0) {
            $mobileNumber = strip_tags(trim($_GET['phone']));
            $uid = strip_tags(trim($_GET['uid']));
            $senderId = "ABCDEF";
            // str_replace("array("\n", "\r","<br>","</br>","%0a""), '', trim($_POST['smsmessage']))
            $message = 'Hi '.user_name(strip_tags(trim($_GET['uid']))).', %0a Username: '.user_email(strip_tags(trim($_GET['uid']))).'%0a Password: '.user_password(strip_tags(trim($_GET['uid']))).' %0a From: '.my_company_name(company($myid)).'%0a Thank You!';
            
            $result=send_sms_school(company($myid),$message,$mobileNumber);

           

            if ($result) {

               $resp_data=[
                    'status'=>true,
                    'message'=>'Sent to '.user_name($uid),
                ];
                echo json_encode($resp_data);

                

                $smsdata=[

                'company_id' =>company($myid),
                'number' => $mobileNumber,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,

                ];

                $SmslistModel->save($smsdata);



            } else {
                
               $resp_data=[
                    'status'=>false,
                    'message'=>'Sending failed to '.user_name($uid),
                ];

                echo json_encode($resp_data);
            }

        }else{
            $resp_data=[
                'status'=>false,
                'message'=>'No sufficient credits',
            ];

            echo json_encode($resp_data);
        }
            
        
    }

    public function send_bookreturn()
    {   
        $user=new Main_item_party_table();
        $SmslistModel=new SmslistModel();

        $myid=session()->get('id');
       
        if (message_credits(company($myid))>0) {
            $mobileNumber = strip_tags(trim($_GET['phone']));
            $uid = strip_tags(trim($_GET['uid']));
            $senderId = "ABCDEF";
            // str_replace("array("\n", "\r","<br>","</br>","%0a""), '', trim($_POST['smsmessage']))
            $message = 'Hi '.user_name(strip_tags(trim($_GET['uid']))).', %0aThe return date of book you bought from school library is expired. Please return book to library as soon as possible.%0a %0aBook name: "'.$_GET['bookname'].'"%0a%0aFrom: Library - '.my_company_name(company($myid)).'%0aThank You!';
            
            $result=send_sms_school(company($myid),$message,$mobileNumber);

           
            $resp_data=array();

            if ($result) {
                $resp_data=[
                    'status'=>true,
                    'message'=>'Sent to '.user_name($uid),
                ];
                echo json_encode($resp_data);

                $smsdata=[

                'company_id' =>company($myid),
                'number' => $mobileNumber,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,

                ];

                $SmslistModel->save($smsdata);

            } else {
                $resp_data=[
                    'status'=>false,
                    'message'=>'Sending failed to '.user_name($uid),
                ];

                echo json_encode($resp_data);
            }

        }else{
            $resp_data=[
                'status'=>false,
                'message'=>'No sufficient credits',
            ];

            echo json_encode($resp_data);
           
        }
            

        
    }


    public function send_absent()
    {   
        $user=new Main_item_party_table();
        $SmslistModel= new SmslistModel();

        $myid=session()->get('id');
       
        if (message_credits(company($myid))>0) {
            $mobileNumber = strip_tags(trim($_GET['phone']));
            $uid = strip_tags(trim($_GET['uid']));
            $senderId = "ABCDEF";
            // str_replace("array("\n", "\r","<br>","</br>","%0a""), '', trim($_POST['smsmessage']))
            $message = 'Hi '.user_name(strip_tags(trim($_GET['uid']))).', %0a %0aYou are not attended class today.%0a %0aDate: '.get_date_format($_GET['date'],'d M Y l').'%0a%0aFrom: '.organisation_name(company($myid)).'%0aThank You!';
            
            $result=send_sms(company($myid),$message,$mobileNumber);

           

            if ($result) {

                echo '<div class="alert alert-success">Sent to '.user_name($uid).'</div>';

                $smsdata=[

                'company_id' =>company($myid),
                'number' => $mobileNumber,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,

                ];

                $SmslistModel->save($smsdata);

            } else {
               echo '<div class="alert alert-danger p-2">Sending failed to '.user_name($uid).'</div>';
            }

        }else{
            echo '<div class="alert alert-danger">No sufficient credits</div>';
        }
            

        
    }


    public function send_reward()
    {   
        $user=new Main_item_party_table();
        $SmslistModel= new SmslistModel();

        $myid=session()->get('id');
       
        if (message_credits(company($myid))>0) {
            $mobileNumber = strip_tags(trim($_GET['phone']));
            $uid = strip_tags(trim($_GET['uid']));
            $senderId = "ABCDEF";
            // str_replace("array("\n", "\r","<br>","</br>","%0a""), '', trim($_POST['smsmessage']))
            $message = 'Hi '.user_name(strip_tags(trim($_GET['uid']))).', %0a %0aNew achievement recorded in your profile.%0a %0aEvent: '.$_GET['event']. '%0a%0aFrom: '.my_company_name(company($myid)).'%0aThank You!';
            
            $result=send_sms_school(company($myid),$message,$mobileNumber);

           
            $resp_data=array();
            
            if ($result) {

                $resp_data=[
                    'status'=>true,
                    'message'=>'Sent to '.user_name($uid),
                ];
                echo json_encode($resp_data);

                $smsdata=[

                'company_id' =>company($myid),
                'number' => $mobileNumber,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,

                ];

                $SmslistModel->save($smsdata);

            } else {
               $resp_data=[
                    'status'=>false,
                    'message'=>'Sending failed to '.user_name($uid),
                ];

                echo json_encode($resp_data);
            }

        }else{
            $resp_data=[
                'status'=>false,
                'message'=>'No sufficient credits',
            ];

            echo json_encode($resp_data);
        }
            

        
    }

    


    public function send_bulk_sms()
    {
        $user=new Main_item_party_table();
        $myid=session()->get('id');
        $SmslistModel= new SmslistModel();

        // var_dump($_POST);
       

            $message=strip_tags($_GET['smessages']);

            foreach ($_GET['studentid'] as $i => $value) {

                
                if (message_credits(company($myid))>0) {
                    $student_id=$_GET['studentid'][$i];
                    $phone_number=$_GET['cb'][$i];

                     $result=send_bundle_sms(company($myid),$message,$phone_number);

                   

                    if ($result=='true') {

                        echo '<div class="alert alert-success">Sent to '.user_name($student_id).'</div>';

                        $smsdata=[

                        'company_id' =>company($myid),
                        'number' => $phone_number,
                        'message' => $message,
                        'datetime' => now_time($myid),
                        'sender_id' => $myid,

                        ];

                        $SmslistModel->save($smsdata);



                    }else{
                        echo '<div class="alert alert-danger p-2">Sending failed to '.user_name($student_id).'('.$result.')</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger p-2">No sufficient credits</div>';
                }


                


                 

            }

        
    }


    public function send_student_pass_sms()
    {
        $user=new Main_item_party_table();
        $myid=session()->get('id');
        $SmslistModel= new SmslistModel();

        // var_dump($_POST);
       

            $message='';

            foreach ($_GET['studentid'] as $i => $value) {

                
                if (message_credits(company($myid))>0) {
                    $student_id=$_GET['studentid'][$i];
                    $phone_number=$_GET['cb'][$i];

                    $message = 'Hi '.user_name(strip_tags(trim($student_id))).', %0aPhone: '.user_phone(strip_tags(trim($student_id))).'%0aPassword: '.user_password(strip_tags(trim($student_id))).' %0aApp download link %0a'.app_link().'%0aFrom: '.organisation_name(company($myid)).'%0a Thank You!';

                     $result=send_bundle_sms(company($myid),$message,$phone_number);

                   

                    if ($result=='true') {
                        echo '<div class="alert alert-success">Sent to '.user_name($student_id).'</div>';

                        $smsdata=[

                        'company_id' =>company($myid),
                        'number' => $phone_number,
                        'message' => $message,
                        'datetime' => now_time($myid),
                        'sender_id' => $myid,

                        ];

                        $SmslistModel->save($smsdata);

                        

                    }else{
                        echo '<div class="alert alert-danger p-2">Sending failed to '.user_name($student_id).'('.$result.')</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger p-2">No sufficient credits</div>';
                }


            }

        
    }



    public function publish_exam_via_sms($exid=""){

            

            $session=session();
            $user=new Main_item_party_table();
            $ExamModel= new ExamModel();
            $MainexamModel= new MainexamModel();
            $SmslistModel= new SmslistModel();
            $myid=session()->get('id');
            
            if ($session->has('isLoggedIn')) {
                $usaerdata=$user->where('id', session()->get('id'))->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                     
               

                $class=$_GET['classid'];

                $claswise_exam_data=$ExamModel->where('exam_type','normal')->where('main_exam_id',$exid)->where('exam_for_class',$class)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->findAll();

                $main_exam_data=$MainexamModel->where('id',$exid)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->first();

                 foreach (students_array_of_class(company($myid),$class) as $std){
                    

        if (message_credits(company($myid))>0) {
            $student_id=$std['student_id'];
            $phone_number=user_phone($std['student_id']);

             $message = 'Hi '.user_name(strip_tags(trim($student_id))).'%0a';

             $message .='You have '.$main_exam_data['exam_name'].' from '.get_date_format($main_exam_data['start_date'],'d M Y l').' to '.get_date_format($main_exam_data['end_date'],'d M Y l').'%0a%0a';
             $message.='Time table:%0a';

             foreach ($claswise_exam_data as $exxx){
                $message.=subjects_name($exxx['exam_for_subject']).' - '.get_date_format($exxx['date'],'d M Y l').'('.get_date_format($exxx['from'],'h:i A').'-'.get_date_format($exxx['to'],'h:i A').')%0a';
             }

             $message .='%0aFrom: '.my_company_name(company($myid)).'%0a Thank You!';

             $result=send_bundle_sms(company($myid),$message,$phone_number);


           

            if ($result=='true') {
                echo '<div class="alert alert-success p-1 mb-1" style="font-size:13px;"> <i class="bx bxs-check-circle me-1"></i> Sent to '.user_name($student_id).'</div>';

                 $smsdata=[

                'company_id' =>company($myid),
                'number' => $phone_number,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,

                ];

                $SmslistModel->save($smsdata);

                

            }else{
                echo '<div class="alert alert-danger p-1 mb-1" style="font-size:13px;"><i class="bx bxs-error me-1"></i> Sending failed to '.user_name($student_id).'('.$result.')</div>';
            }
        }else{
            echo '<div class="alert alert-danger p-1 mb-1" style="font-size:13px;"><i class="bx bxs-error me-1"></i> No sufficient credits</div>';
        }


        
                 }  
                    
                    

                
            }

        }



        public function publish_online_exam_via_sms($exid=""){

            

            $session=session();
            $user=new Main_item_party_table();
            $ExamModel= new ExamModel();
            $MainexamModel= new MainexamModel();
            $SmslistModel= new SmslistModel();
            $myid=session()->get('id');
            
            if ($session->has('isLoggedIn')) {
                $usaerdata=$user->where('id', session()->get('id'))->first();
                if (is_organisation($usaerdata['company_id'])) {
                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    

                

            $claswise_exam_data=$ExamModel->where('id',$exid)->where('exam_type','online')->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->first();


                 foreach (students_array_of_class(company($myid),$claswise_exam_data['exam_for_class']) as $std){
                    

        if (message_credits(company($myid))>0) {
            $student_id=$std['student_id'];
            $phone_number=user_phone($std['student_id']);

             $message = 'Hi '.user_name(strip_tags(trim($student_id))).'%0a';

             $message .='You have '.$claswise_exam_data['exam_name'].' on '.get_date_format($claswise_exam_data['date'],'d M Y l').' through app.%0a';
             $message.='Time:%0a'.get_date_format($claswise_exam_data['from'],'h:i A').' - '.get_date_format($claswise_exam_data['to'],'h:i A');

             $message .='%0aFrom: '.organisation_name(company($myid)).'%0a Thank You!';

             $result=send_bundle_sms(company($myid),$message,$phone_number);

           

            if ($result=='true') {
                echo '<div class="alert alert-success">Sent to '.user_name($student_id).'</div>';

                 $smsdata=[

                    'company_id' =>company($myid),
                    'number' => $phone_number,
                    'message' => $message,
                    'datetime' => now_time($myid),
                    'sender_id' => $myid,

                    ];

                    $SmslistModel->save($smsdata);

                

            }else{
                echo '<div class="alert alert-danger p-2">Sending failed to '.user_name($student_id).'('.$result.')</div>';
            }
        }else{
            echo '<div class="alert alert-danger p-2">No sufficient credits</div>';
        }


        
                 }  
                    
                    


                }

                
            }

        }


        



        public function publish_exam_result_via_sms($exid=""){

            

            $session=session();
            $user=new Main_item_party_table();
            $ExamModel= new ExamModel();
            $MainexamModel= new MainexamModel();
            $SmslistModel= new SmslistModel();
            $myid=session()->get('id');
            
            if ($session->has('isLoggedIn')) {
                $usaerdata=$user->where('id', session()->get('id'))->first();
                
                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    


               

                $class=$_GET['classid'];

                $claswise_exam_data=$ExamModel->where('exam_type','normal')->where('main_exam_id',$exid)->where('exam_for_class',$class)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->findAll();

                $main_exam_data=$MainexamModel->where('id',$exid)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->first();

                 foreach (students_array_of_class(company($myid),$class) as $std){
                    

        if (message_credits(company($myid))>0) {
            $student_id=$std['student_id'];
            $phone_number=user_phone($std['student_id']);

             $message = 'Hi '.user_name(strip_tags(trim($student_id))).'%0a';

             $message .='Result of '.$main_exam_data['exam_name'].' is published. Please check your app or contact your class head.%0a';
             
             $message .='%0aFrom: '.my_company_name(company($myid)).'%0a Thank You!';

             $result=send_bundle_sms(company($myid),$message,$phone_number);

           

            if ($result=='true') {
                echo '<div class="alert alert-success p-1 mb-1" style="font-size:13px;"> <i class="bx bxs-check-circle me-1"></i> Sent to '.user_name($student_id).'</div>';


                $smsdata=[

                'company_id' =>company($myid),
                'number' => $phone_number,
                'message' => $message,
                'datetime' => now_time($myid),
                'sender_id' => $myid,

                ];

                $SmslistModel->save($smsdata);

                

            }else{
                echo '<div class="alert alert-danger  p-1 mb-1" style="font-size:13px;"><i class="bx bxs-error me-1"></i> Sending failed to '.user_name($student_id).'('.$result.')</div>';
            }
        }else{
            echo '<div class="alert alert-danger  p-1 mb-1" style="font-size:13px;"><i class="bx bxs-error me-1"></i> No sufficient credits</div>';
        }


        
                 }  
                    
                    


                
            }

        }


        


public function fees_remind($student_id='')
    {   
        
        if ($this->request->getMethod() == 'post') {
            $user=new Main_item_party_table();
             $SmslistModel= new SmslistModel();

            $myid=session()->get('id');

            if (message_credits(company($myid))>0) {
                $mobileNumber = strip_tags(trim($this->request->getVar('phone')));
                $uid = strip_tags(trim($student_id));
                $senderId = "ABCDEF";
                // str_replace("array("\n", "\r","<br>","</br>","%0a""), '', trim($_POST['smsmessage']))
                $message = strip_tags(trim($this->request->getVar('fees_message')));
                
                $result=send_bundle_sms(company($myid),$message,$mobileNumber);

               

                if ($result=='true') {

                    echo 1;

                     $smsdata=[

                        'company_id' =>company($myid),
                        'number' => $mobileNumber,
                        'message' => $message,
                        'datetime' => now_time($myid),
                        'sender_id' => $myid,

                        ];

                    $SmslistModel->save($smsdata);

                } else {
                   echo 0;
                }

            }else{
                echo 0;
            }
        }
            

        
    }




    public function message_history()
    {
        $session=session();
        $user=new Main_item_party_table();
        $myid=session()->get('id');
        $SmslistModel= new SmslistModel();
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
        
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

if (check_permission($myid,'manage_messaging')==true || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied'));}



                $message_data=$SmslistModel->where('company_id',company($myid))->orderBy('id','ASC')->findAll();

                
                $data=[
                    'title'=>'Message History | Erudite ERP',
                    'user'=>$usaerdata,
                    'message_data'=>$message_data
                    
                ];

             
                    echo view('header',$data);
                    echo view('message/message_history');
                    echo view('footer');
                


            
            
        }else{
            return redirect()->to(base_url('users'));
        }       
    }


            
    

}