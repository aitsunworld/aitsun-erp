<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ExamModel;
use App\Models\Examcategorymodel;
use App\Models\MainexamModel;
use App\Models\ClassModel;
use App\Models\MarksModel;
use App\Models\TeachersModel;






class Exams extends BaseController
{
    public function index()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}



            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
           
            
            $data=[
                'title'=>'Exams',
                'user'=>$user,
               
            ];

            echo view('header',$data);
            echo view('exams/exams');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }



    public function main_exam()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $MainexamModel= new MainexamModel();
            $pager = \Config\Services::pager();


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
           
           $main_exam_data=$MainexamModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(22);
            
            $data=[
                'title'=>'Exams',
                'user'=>$user,
                'main_exam_data'=>$main_exam_data,
                'pager' => $MainexamModel->pager
               
            ];


            //complete exam after date is complete

                $main_exam_data=$MainexamModel->where('company_id',company($myid))->where('exam_status!=','completed')->where('academic_year',academic_year($myid))->where('deleted',0)->findAll();
                $count=0;
                foreach ($main_exam_data as $ex) {
                    $exam_date = strtotime(get_date_format($ex['end_date'],'Y-m-d'));
                    $current_date = strtotime(get_date_format(now_time($myid),'Y-m-d')); 
                    
                    if ($current_date>$exam_date) { 
                        $sttchangeexam=[
                            'exam_status'=>'completed'
                        ];

                        $MainexamModel->update($ex['id'],$sttchangeexam);
                    }

                }

            echo view('header',$data);
            echo view('exams/main_exam');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }


    public function exam_configuration()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $Examcategorymodel= new Examcategorymodel();


            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
           
          $exam_cate_data=$Examcategorymodel->where('deleted',0)->where('company_id',company($myid))->findAll();
            
            $data=[
                'title'=>'Exams',
                'user'=>$user,
                'exam_cate_data'=>$exam_cate_data
               
            ];

            echo view('header',$data);
            echo view('exams/exam_configuration');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }


    public function add_exam_category($org=""){
    

        if ($this->request->getMethod() == 'post') {
            
                $Examcategorymodel = new Examcategorymodel();
                $myid=session()->get('id');

                $newData = [
                    'company_id' => $org,
                    'academic_year' => academic_year($myid),
                    'exam_category'=> strip_tags($this->request->getVar('exam_cate_name')),
                    'deleted' => 0,
                    'datetime' => now_time($myid),

                ];

                $Examcategorymodel->save($newData);
                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'New exam category <b>'.$this->request->getVar('exam_cate_name').'</b> is added',
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

    public function update_exam_cate($excatid=""){
    

        if ($this->request->getMethod() == 'post') {
            
                $Examcategorymodel = new Examcategorymodel();
                $myid=session()->get('id');


                $newData = [
                    
                    'exam_category' => strip_tags($this->request->getVar('exam_cate_name'))
                ];

                $Examcategorymodel->update($excatid,$newData);

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Exam category <b>'.$this->request->getVar('exam_cate_name').'(#'.($excatid).')</b> details is updated',
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



    public function deleteexamcate($exmcatid=0)
    {
        
        $Examcategorymodel= new Examcategorymodel();
    

        if ($this->request->getMethod() == 'post') {
                $Examcategorymodel->find($exmcatid);

                $myid=session()->get('id');

                $deledata=[
                    'deleted'=>1
                ];
                $Examcategorymodel->update($exmcatid,$deledata);

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Exam category <b>'.exam_cate_name($exmcatid).'(#'.($exmcatid).')</b> is deleted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////


        }else{
            return redirect()->to(base_url('exams'));
        }

    }



    public function add_main_exam($org="")
    {
        
        if ($this->request->getMethod() == 'post') {
            
                $myid=session()->get('id');
                $MainexamModel= new MainexamModel();

                    $newData = [
                        'company_id' => $org,
                        'academic_year' => academic_year($myid),
                        'exam_name' => strip_tags($this->request->getVar('exam_name')),
                        'category' => strip_tags($this->request->getVar('category')),
                        'start_date' => strip_tags($this->request->getVar('start_date')),
                        'end_date' => strip_tags($this->request->getVar('end_date')),
                        'description' => strip_tags($this->request->getVar('description')),
                    ];


                    $MainexamModel->save($newData);

                    // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                        $title='New exam <b>'.strip_tags($this->request->getVar('exam_name')).'</b> added.';
                        $message='';
                        $url=main_base_url().'exams/'; 
                        $icon=notification_icons('exam');
                        $userid='all';
                        $nread=0;
                        $for_who='student';
                        $notid='exam';
                        notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                    // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]


                        ////////////////////////CREATE ACTIVITY LOG//////////////
                        $log_data=[
                            'user_id'=>$myid,
                            'action'=>'New exam <b>'.strip_tags($this->request->getVar('exam_name')).'</b> is added',
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



    public function update_main_exam($exid="")
    {
        $session=session();
        $user=new Main_item_party_table();
        $MainexamModel= new MainexamModel();
        $myid=session()->get('id');
        
      
                
        if ($this->request->getMethod() == 'post') {
        

                $users_data = [
                    'exam_name' => strip_tags($this->request->getVar('exam_name')),
                    'category' => strip_tags($this->request->getVar('category')),
                    'start_date' => strip_tags($this->request->getVar('start_date')),
                    'end_date' => strip_tags($this->request->getVar('end_date')),
                    'description' => strip_tags($this->request->getVar('description')),
                    
                ];
               
                $MainexamModel->update($exid,$users_data);

                 ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Exam <b>'.strip_tags($this->request->getVar('exam_name')).'(#'.$exid.')</b> details is updated',
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


    public function delete_main_exam($exmnrid=0)
    {
        
        $MainexamModel= new MainexamModel();
        $myid=session()->get('id');

        if ($this->request->getMethod() == 'post') {
                $MainexamModel->find($exmnrid);
                $deledata=[
                    'deleted'=>1
                ];
                $MainexamModel->update($exmnrid,$deledata);

                 ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Exam <b>'.get_main_exam_data($exmnrid,'exam_name').'(#'.$exmnrid.')</b> is deleted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////


        }else{
            return redirect()->to(base_url('exams'));
        }

    }



    public function pdf_main_exam_time_table($exid="")

    {
        if (!empty($exid)) {
            $ExamModel= new ExamModel();
            $MainexamModel= new MainexamModel();
            $user = new Main_item_party_table();
            $myid=session()->get('id');
            $usaerdata=$user->where('id', $myid)->first();
            $main_exam_da=$MainexamModel->where('id', $exid)->first();
            $page_size='A4';
            $orientation='portrait';
            $type='download';
            
            $filename="uknown file.pdf";

            if ($main_exam_da) {
                $data=[
                    'user'=> $usaerdata,
                    'main_exam_da'=> $main_exam_da
                    
                ];

              
                $filename=$main_exam_da['exam_name'].'.pdf';

                // $mpdf = new \Mpdf\Mpdf([
                //         'margin_left' => 5,
                //         'margin_right' => 5,
                //         'margin_top' => 5,
                //         'margin_bottom' => 5,
                //     ]);

                 $dompdf = new \Dompdf\Dompdf();
                    $dompdf->set_option('isJavascriptEnabled', TRUE);
                    $dompdf->set_option('isRemoteEnabled', TRUE); 

                    $dompdf->loadHtml(view('exams/main_exam_timetable_pdf', $data));
                    $dompdf->setPaper($page_size, $orientation);
                    $dompdf->render();

                     if ($type=='download') {
                          $dompdf->stream($filename, array("Attachment" => true));
                      }else{
                          $dompdf->stream($filename, array("Attachment" => false));
                      }

                // echo view('exams/alltimetable_exam_pdf',$data);

                // $html = view('exams/main_exam_timetable_pdf',$data);
                // $mpdf->WriteHTML($html);
                // $this->response->setHeader('Content-Type', 'application/pdf');
                // $mpdf->Output($main_exam_da['exam_name'].now_time($myid).'.pdf','I');
            }else{
                return redirect()->to(base_url());
            }

        }else{
            return redirect()->to(base_url());
        }
    }


   public function pdf_main_exam_subject($exid="")
    {
        if (!empty($exid)) {

            if ($_GET) {

            if (isset($_GET['main'])) {
            if (!empty($_GET['main'])) {
        
    


            $exam= new ExamModel();
            $user = new Main_item_party_table();
            $myid=session()->get('id');
            $usaerdata=$user->where('id', $myid)->first();
            $MainexamModel= new MainexamModel();
            $main_exam=$MainexamModel->where('id',$_GET['main'])->first();
            $exam_data=$exam->where('exam_type','normal')->where('exam_for_class',$exid)->where('main_exam_id',$_GET['main'])->where('company_id',company($myid))->where('deleted',0)->orderBy('date','ASC')->findAll();

            $page_size='A4';
            $orientation='portrait';
            $type='download';

            $filename="uknown file.pdf";

            if ($exam_data) {
                $data=[
                    'user'=> $usaerdata,
                    'main_exam'=>$main_exam,
                    'time_ex'=> $exam_data
                ];

                $filename=$main_exam['exam_name'].now_time($myid).'.pdf';

                // $mpdf = new \Mpdf\Mpdf([
                //         'margin_left' => 5,
                //         'margin_right' => 5,
                //         'margin_top' => 5,
                //         'margin_bottom' => 5,
                //     ]);

                // // echo view('exams/timetable_exam_pdf',$data);

                // $html = view('exams/pdf_main_exam_subject',$data);
                // $mpdf->WriteHTML($html);
                // $this->response->setHeader('Content-Type', 'application/pdf');
                // $mpdf->Output($main_exam['exam_name'].now_time($myid).'.pdf','I');


                $dompdf = new \Dompdf\Dompdf();
                $dompdf->set_option('isJavascriptEnabled', TRUE);
                $dompdf->set_option('isRemoteEnabled', TRUE); 

                $dompdf->loadHtml(view('exams/pdf_main_exam_subject', $data));
                $dompdf->setPaper($page_size, $orientation);
                $dompdf->render();

                 if ($type=='download') {
                      $dompdf->stream($filename, array("Attachment" => true));
                  }else{
                      $dompdf->stream($filename, array("Attachment" => false));
                  }
            }

            }
        }
        }

        }
    }



    public function main_exam_time_table($exid="")
    {
        $session=session();
        $user=new Main_item_party_table();
        $MainexamModel= new MainexamModel();
        $ExamModel= new ExamModel();
        $ClassModel= new ClassModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
            
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

            $main_exam_id=$MainexamModel->where('id',$exid)->where('company_id',company($myid))->where('deleted',0)->first();

           


                
                $data=[
                    'title'=>'Exams | Erudite ERP',
                    'user'=>$usaerdata,
                    'main_exam_id'=>$main_exam_id,
                    

                ];
                    echo view('header',$data);
                    echo view('exams/main_exam_time_table');
                    echo view('footer');
              

            
        }else{
            return redirect()->to(base_url('users'));
        }       
    }



    public function add_main_exam_subject($org=""){
    

        if ($this->request->getMethod() == 'post') {
            
                $ExamModel = new ExamModel();
                $myid=session()->get('id');

                $newData = [
                    'company_id' => $org,
                    'academic_year' => academic_year($myid),
                    'main_exam_id'=> strip_tags($this->request->getVar('main_exam_id')),
                    'date' => strip_tags($this->request->getVar('date')),
                    'from' => twelve_to_24(strip_tags($this->request->getVar('from'))),
                    'to' => twelve_to_24(strip_tags($this->request->getVar('to'))),
                    'exam_for_subject' => strip_tags($this->request->getVar('exam_for_subject')),
                    'exam_for_class' => strip_tags($this->request->getVar('exam_for_class')),
                    'max_marks' => strip_tags($this->request->getVar('max_marks')),
                    'min_marks' => strip_tags($this->request->getVar('min_marks')),
                    'exam_type' => 'normal',
                    'exammarks' => strip_tags($this->request->getVar('exammarks')),
                    'max_grade' => strip_tags($this->request->getVar('max_grade')),
                    'min_grade' => strip_tags($this->request->getVar('min_grade')),

                ];

                $ExamModel->save($newData);

            }
        
    }


    public function edit_main_exam_subject($ac_id=""){
        
    

        if ($this->request->getMethod() == 'post') {
            
                $myid=session()->get('id');
                $model = new ExamModel();

                $newData = [
                    'date' => strip_tags($this->request->getVar('date')),
                    'from' => twelve_to_24(strip_tags($this->request->getVar('from'))),
                    'to' => twelve_to_24(strip_tags($this->request->getVar('to'))),
                    'exam_for_subject' => strip_tags($this->request->getVar('exam_for_subject')),
                    'exam_for_class' => strip_tags($this->request->getVar('exam_for_class')),
                    'max_marks' => strip_tags($this->request->getVar('max_marks')),
                    'min_marks' => strip_tags($this->request->getVar('min_marks')),

                ];

                
                    $model->update($ac_id,$newData);
                    
                }

    }



    public function delete_main_exam_subject($exmclsid=0)
    {
        
        $ExamModel= new ExamModel();
    

        if ($this->request->getMethod() == 'post') {
                $ExamModel->find($exmclsid);
                $deledata=[
                    'deleted'=>1
                ];
                $ExamModel->update($exmclsid,$deledata);

        }else{
            return redirect()->to(base_url('exams'));
        }

    }



    public function main_exam_marks($exid="")
    {
        $session=session();
        $user=new Main_item_party_table();
        $ExamModel= new ExamModel();
        $MainexamModel= new MainexamModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
            
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                

                $exam_class_sub=$ExamModel->where('id',$exid)->where('company_id',company($myid))->where('deleted',0)->first();
                
                
                $data=[
                    'title'=>'Exams | Erudite ERP',
                    'user'=>$usaerdata,
                    'exam_class_sub'=>$exam_class_sub,
                    
                ];

                echo view('header',$data);
                echo view('exams/main_exam_marks');
                echo view('footer');
              
            
        }else{
            return redirect()->to(base_url('users'));
        }       
    }



    public function add_main_exam_mark(){
    

        if ($this->request->getMethod() == 'post') {

            foreach ($this->request->getVar('student_id') as $i => $value) {


            $ExamModel= new ExamModel();
            $MarksModel = new MarksModel();
            $myid=session()->get('id');
                $marksab=$_POST['marks'][$i];
                $gradee='';

                if (isset($_POST['absent'][$i])) {
                   $absnt=$_POST['absent'][$i];
                }

                if ($absnt==1) {
                    $marksab=0;
                }

                if ($_POST['exam_mark_type']=='grade') {
                    $marksab=0;
                    $gradee=$_POST['marks'][$i];
                }else{
                    $gradee='';
                }



            $newData = [
                'company_id' => company($myid),
                'academic_year' => academic_year($myid),
                'student_id' => $_POST['student_id'][$i],
                'subject_id' => $_POST['subject_id'],
                'exam_id' => $_POST['exam_id'],
                'marks' => $marksab,
                'status' => $absnt,
                'datetime' => now_time($myid),
                'deleted' => 0,
                'exam_mark_type'=>$_POST['exam_mark_type'],
                'grade'=>$gradee,
            ];

            $markexist=$MarksModel->where('subject_id',$_POST['subject_id'])->where('student_id',$_POST['student_id'][$i])->where('exam_id',$_POST['exam_id'])->where('company_id',company($myid))->where('academic_year',academic_year($myid))->first();

                if ($markexist) {
                    $MarksModel->update($markexist['id'],$newData);
                }else{
                    $MarksModel->save($newData);
                }

                $isvaluated=0;
                if (isset($_POST['markvaluate'])) {
                    $isvaluated=1;
                }

                $newvalue =[
                   'marksvaluate' => $isvaluated,
                ];

                $ExamModel->update($_POST['exam_id'],$newvalue);


            
        }
            $session = session();
            $session->setFlashdata('pu_msg', 'Marks submitted');
            return redirect()->to($_SERVER['HTTP_REFERER']);

            }else{
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        
    }


    public function notify_main_exam_result($exid=""){

        
        $session=session();
        $user=new Main_item_party_table();
        $ExamModel= new ExamModel();
        $MainexamModel= new MainexamModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
             
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                


           

            $class=$_GET['classid'];

            $main_exam_data=$MainexamModel->where('id',$exid)->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->first();

             foreach (students_array_of_class(company($myid),$class) as $std){
                // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                    $title='Check result of <b>'.$main_exam_data['exam_name'].'</b>.';
                    $message='';
                    $url=main_base_url().'exams/result/'.$exid; 
                    $icon=notification_icons('exam');
                    $userid=$std['student_id'];
                    $nread=0;
                    $for_who='student';
                    $notid='exam';
                    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
             }  
                
                

                echo "1";
                


            
        }else{
            return redirect()->to(base_url('users'));
        }
    
        

    }



    public function exam_report(){
        $session=session();
        $user=new Main_item_party_table();
        $class=new ClassModel();
        $TeachersModel=new TeachersModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
            
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                
                $aca=academic_year($myid);

                if ($usaerdata['u_type']=='admin') {
                    $myclass=$TeachersModel->where('company_id',company($myid))->where('deleted',0)->findAll();
                }else{
                    $myclass=$TeachersModel->where('company_id',company($myid))->where('teacher_id',$usaerdata['id'])->where('deleted',0)->findAll();
                }

                

                
                $data=[
                    'title'=>'Select class - Exam reports | Erudite ERP',
                    'user'=>$usaerdata,
                    'my_classes'=>$myclass

                ];

                    echo view('header',$data);
                    echo view('exams/exam_reports_select_class');
                    echo view('footer');
                
            
        }else{
            return redirect()->to(base_url('users'));
        }   
    }




    public function view_exam_report($class_id=""){
        $session=session();
        $user=new Main_item_party_table();
        $class=new ClassModel();
        $MainexamModel=new MainexamModel();
        $TeachersModel=new TeachersModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {

            if (!empty($class_id)) {
                $usaerdata=$user->where('id', session()->get('id'))->first();
                
                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                    
                    $aca=academic_year($myid);

                    $all_exams_of_class=$MainexamModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','DESC')->findAll();

                    $data=[
                        'title'=>class_name($class_id).' - Exam reports | Erudite ERP',
                        'user'=>$usaerdata,
                        'all_exams_of_class'=>$all_exams_of_class,
                        'class_id'=>$class_id

                    ];

                    echo view('header',$data);
                    echo view('exams/view_exam_report');
                    echo view('footer');
                    


            }else{
                return redirect()->to(base_url());
            }
            
        }else{
            return redirect()->to(base_url('users'));
        }
    }

    public function progress_card($exam_id='',$student_id='',$company='',$printtype=''){

        $session=session();
        $user=new Main_item_party_table();
        $ExamModel= new ExamModel();
        $MainexamModel= new MainexamModel();
        $myid=$student_id;
        
            $usaerdata=$user->where('id', $student_id)->first();
            
            $page_size='A4';
                $orientation='portrait';

                if (!empty($page_size)) {
                    $page_size=strtoupper(get_setting2(company($myid),'invoice_page_size')); 
                }

                if (!empty($page_size)) {
                    $orientation=get_setting2(company($myid),'invoice_orientation'); 
                }
                
                $mexam_data1=$ExamModel->where('id',$exam_id)->where('deleted',0)->first();

            if (!empty($company)) {
                $mexam_data=$MainexamModel->where('id',$exam_id)->where('deleted',0)->first();

 
            if ($mexam_data) {
                
                $student_data=$user->where('id',$student_id)->first();

                if ($student_data) {

                    $filename=$mexam_data['exam_name'].now_time($myid).'.pdf';
                    
                    $data=[
                        'title'=>$filename,
                        'company'=>$company,
                        'printtype'=>$printtype,
                        'main_exam_data'=>$mexam_data,
                        'student'=>$student_data,
                        'user'=>$usaerdata,
                        'mexam_data1'=>$mexam_data1
                    ];

                    $dompdf = new \Dompdf\Dompdf();
                    $dompdf->set_option('isJavascriptEnabled', TRUE);
                    $dompdf->set_option('isRemoteEnabled', TRUE); 

                    $dompdf->loadHtml(view('exams/progress_card', $data));
                    $dompdf->setPaper($page_size, $orientation);
                    $dompdf->render();

                    if ($printtype=='download') {
                      $dompdf->stream($filename, array("Attachment" => true));
                    }else{
                      $dompdf->stream($filename, array("Attachment" => false));
                    }
                    exit();
                   
                }
                
                
            }
            }

    }

    public function pdf_progress_card($exid="",$student_id="",$company='')
    {
        if (!empty($exid)) {
            $ExamModel= new ExamModel();
            $MainexamModel= new MainexamModel();
            $user = new Main_item_party_table();
            $myid=session()->get('id');
            $usaerdata=$user->where('id', $myid)->first();
            $main_exam_da=$MainexamModel->where('id', $exid)->first();
            $student_data=$user->where('id',$student_id)->first();
            

            if ($main_exam_da) {
                $data=[
                    'user'=> $usaerdata,
                    'main_exam_da'=> $main_exam_da,
                    'student'=>$student_data,
                    'company'=>$company,
                    
                ];

                $mpdf = new \Mpdf\Mpdf([
                        'margin_left' => 5,
                        'margin_right' => 5,
                        'margin_top' => 5,
                        'margin_bottom' => 5,
                    ]);

                // echo view('exams/exam_result_pdf',$data);

                $html = view('exams/progress_card_pdf',$data);
                $mpdf->WriteHTML($html);
                $this->response->setHeader('Content-Type', 'application/pdf');
                $mpdf->Output($main_exam_da['exam_name'].now_time($myid).'.pdf','I');
            }else{
                return redirect()->to(base_url());
            }

        }else{
            return redirect()->to(base_url());
        }
    }

    public function result($exid="",$studid='')
    {
        $session=session();
        $user=new Main_item_party_table();
        
        $myid=session()->get('id');
        $ExamModel= new ExamModel();
        $MainexamModel= new MainexamModel();

        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();
            
                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                $main_exam_data=$MainexamModel->where('id',$exid)->where('deleted',0)->first();
                $student_data=$user->where('id',$studid)->first();


                
                $data=[
                    'title'=>'Result | Aitsun School',
                    'user'=>$usaerdata,
                    'main_exam_data'=>$main_exam_data,
                    'student_data'=>$student_data

                ];

                echo view('header',$data);
                echo view('exams/result');
                echo view('footer');


           
            
        }else{
            return redirect()->to(base_url('users'));
        }       
    }

}

