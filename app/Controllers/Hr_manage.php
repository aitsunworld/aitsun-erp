<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\AttendanceModel;
use App\Models\AttendanceEventModel;
use App\Models\CompanySettings;
use App\Models\CarryForwardedLeaves;
use App\Models\LeaveManagement;
use App\Models\WorkshiftModel;
use App\Models\AttendanceAllowedList;
use App\Models\EmployeeCategoriesModel;
use App\Models\PushedAttendanceOfEmployee;


class Hr_manage extends BaseController
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
                'title'=>'HR Management',
                'user'=>$user,
               
            ];

            echo view('header',$data);
            echo view('hr_manage/hr_manage');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }



    public function attendance($type="pushed")
    {
        $session=session();
        $UserModel=new Main_item_party_table;

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $AttendanceModel=new AttendanceModel;
            $PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee;
            

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $user_data = attendance_allowed_list(company($myid));

             if ($_GET) {
                if (!empty($_GET['attend_date'])) {
                    $attend_date=get_date_format($_GET['attend_date'],'Y-m-d');

                }else{
                    $attend_date=get_date_format(now_time($user['id']),'Y-m-d');
                }
                
            }else{
                $attend_date=get_date_format(now_time($user['id']),'Y-m-d');
            }   


            

            if ($type=='pushed') {
                $PushedAttendanceOfEmployee->select('pushed_attendances.*, customers.display_name');
                $PushedAttendanceOfEmployee->join('customers', 'customers.id = pushed_attendances.employee_id', 'left');
                $PushedAttendanceOfEmployee->where('pushed_attendances.company_id',company($myid));
                $PushedAttendanceOfEmployee->where('DATE(pushed_attendances.date)',$attend_date);
                $PushedAttendanceOfEmployee->where('pushed_attendances.deleted',0);
                $PushedAttendanceOfEmployee->orderBy('pushed_attendances.id','desc');  
                $attendance_data=$PushedAttendanceOfEmployee->findAll();
            }else{
                $attendance_data=$AttendanceModel->where('company_id',company($myid))->where('u_type','employee')->where('DATE(punched_time)',$attend_date)->where('deleted',0)->orderBy('punched_time','desc')->findAll();
            } 

            $data=[
                'title'=>'Manage Attendance',  
                'user'=>$user,
                'user_data'=>$user_data, 
                'attendance_data'=>$attendance_data,
                'type'=>$type,
                'attend_date'=>$attend_date,
               
            ];

            echo view('header',$data);
            echo view('hr_manage/attendance');
            echo view('footer');
        
        }else{
                return redirect()->to(base_url('users/login'));
            }
    }

    public function attendance_report($report_type="")
    {

        $session=session();
        $UserModel=new Main_item_party_table;
        $CarryForwardedLeaves=new CarryForwardedLeaves;


        if ($session->has('isLoggedIn')){
                $AttendanceModel=new AttendanceModel;
            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $user_data = attendance_allowed_list(company($myid));

           
            $data=[
                'title'=>'Attendance Report',  
                'user'=>$user,
                'user_data'=>$user_data
            ];



            ////////////////////////////////  Carry forward leaves  ///////////////////////
            foreach ($user_data as $atn){

                $dates=now_time($myid);
                $cur_year=get_date_format($dates,'Y');
                $prev_year=$cur_year-1;
                $prev_dates=$prev_year.'-'.'01'.'-01';

                $leaves_pending=0;

                $leave_of_year=get_user_leave_by_year(company($myid),$atn['user_id'],$prev_dates,$atn['employee_category']);
                $total_leave_of_year=(get_setting(company($myid),'leave_for_month')*12)+carry_forwarded_leave($atn['user_id'],$prev_dates);
                $leaves_pending=$total_leave_of_year-$leave_of_year;

                if ($leaves_pending<0) {
                    $leaves_pending=0;
                }

                // get_user_leave_by_year($atn['user_id'],$prev_dates,'Absent')

                // get_setting(company($user['id']),'leave_for_month')*12)+carry_forwarded_leave($atn['user_id'],$prev_dates)

                
                $carry_data=[
                    'company_id'=>company($myid),
                    'staff_id'=>$atn['user_id'],
                    'year'=>$prev_year,
                    'leave'=>$leaves_pending,
                ];
                $check_exist_carry=$CarryForwardedLeaves->where('company_id',company($myid))->where('staff_id',$atn['user_id'])->where('year',$cur_year-1)->first();
                if (!$check_exist_carry) {
                    $CarryForwardedLeaves->save($carry_data);
                }
                // carry_forwarded_leave($atn['user_id'],$dates);

            }  
            ////////////////////////////////  Carry forward leaves  ///////////////////////

            echo view('header',$data);
            if ($report_type=='leave_report') {
                echo view('hr_manage/attendance_leave_report');
            }else{
                echo view('hr_manage/attendance_report');
            }
            
            echo view('footer');


        }else{
                return redirect()->to(base_url('users/login'));
            }
    }

    
    public function detailed_attendance_report($report_type="")
    {

        $session=session();
        $UserModel=new Main_item_party_table; 

        if ($session->has('isLoggedIn')){
            $AttendanceModel=new AttendanceModel;
            $AttendanceAllowedList=new AttendanceAllowedList();

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            // $user_data = attendance_allowed_list(company($myid)); 

            $UserModel->select('customers.*, 
                attendance_allowed.attendance_allowed,
                employees_categories.category_name');



            $UserModel->join('attendance_allowed', 'attendance_allowed.user_id = customers.id', 'left');
            $UserModel->join('employees_categories', 'employees_categories.id = customers.employee_category', 'left');
            
            $UserModel->where('attendance_allowed.attendance_allowed',1);
            $UserModel->where('attendance_allowed.company_id',company($myid));

            $user_data=$UserModel->orderBy('display_name','asc')->findAll();
           
            $data=[
                'title'=>'Detailed Attendance Report',  
                'user'=>$user,
                'user_data'=>$user_data
            ];
 

            echo view('header',$data);
            echo view('hr_manage/detailed_attendance_report'); 
            echo view('footer');


        }else{
            return redirect()->to(base_url('users/login'));
        }
    }



    public function add_attendance(){
    
        if ($this->request->getMethod() == 'post') {


            foreach ($this->request->getVar('empid') as $i => $value) {
                $attend=new AttendanceModel();
                
                $myid=session()->get('id');

                $att=$_POST['present'][$i];
                $field_id=0;
                
                $ttts=explode('|field|', $att);
                $ate=$ttts[0];
                if (isset($ttts[1])) {
                    $field_id=$ttts[1];
                }

                $newData = [
                    'company_id'=> company($myid),
                    'employee_id' => $_POST['empid'][$i],
                    'event_id' => $_POST['event_id'][$i],
                    'note' => strip_tags(htmlentities($_POST['at_note'][$i])),
                    'created_at'=>now_time($myid),
                    'date' => $_POST['date'],
                    'login_time' => $_POST['login_time'][$i],
                    'logout_time' => $_POST['logout_time'][$i],
                    'attendance' => $ate,
                    'field_id' => $field_id,
                ];

                $checkrollexist=$attend->where('employee_id',$_POST['empid'][$i])->where('DATE(date)',$_POST['date'])->where('company_id',company($myid))->first();

                if ($checkrollexist) {
                    if (empty($att)) {
                        $attend->where('id',$checkrollexist['id'])->delete();
                    }else{
                        $attend->update($checkrollexist['id'],$newData);
                    }
                    
                }else{
                    if (!empty($att)) {
                        $attend->save($newData);
                    }
                    
                }

            }
            
            $session = session();
            $session->setFlashdata('pu_msg','Attendance submitted!');
            return redirect()->to(base_url('hr_manage/attendance').'?attend_date='.$_POST['date']);

            }else{
                $session->setFlashdata('pu_er_msg','Failed to saved!');
                return redirect()->to(base_url('hr_manage/attendance').'?attend_date='.$_POST['date']);
            }
        
    }


    public function push_attendance(){
        $pu_res=1;
        if ($this->request->getMethod() == 'post') {
            // $data = file_get_contents('php://input');
            $attandance_data = json_decode($_POST['data']);
       
           $data = $attandance_data->data;

            foreach ($data as $mat) {
                $punched_time=$mat->recordTime;
                $punch_id=$mat->userSn;
                $state=1;
                $employee_code=$mat->deviceUserId;
                $u_type='employee';
                $ip_address=$mat->ip;

                $punched_time=javascript_date_to_php_date($punched_time);

                $attend=new AttendanceModel();
                $PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee(); 
                
                $myid=session()->get('id');

                $inout_status='';
                $check_is_same_day=$attend->where('DATE(punched_time)',get_date_format($punched_time,'Y-m-d'))->where('employee_id',user_data_by_code($employee_code,'id'))->where('company_id',company($myid))->where('deleted',0)->orderBy('punched_time','DESC')->first();

                if (!$check_is_same_day) {
                    $inout_status='in';
                }else{
                    if ($check_is_same_day['inout_status']=='in') {
                        $inout_status='out';
                    }else{
                        $inout_status='in';
                    }
                }

                if (user_data_by_code($employee_code,'id')>0) {
                    $newData = [
                        'company_id'=> company($myid),
                        'employee_id' => user_data_by_code($employee_code,'id'), 
                        'created_at'=>now_time($myid), 
                        'punched_time'=>$punched_time,
                        'punch_id'=>$punch_id,
                        'state'=>$state,
                        'employee_code'=>$employee_code,
                        'inout_status'=>$inout_status,
                        'u_type'=>$u_type,
                        'ip_address'=>$ip_address,
                    ];

                     $checkrollexist=$attend->where('punch_id',$punch_id)->where('company_id',company($myid))->where('deleted',0)->first();


                    if (!$checkrollexist) { 
                        if($attend->save($newData)){
                            $this->push_log_as_attendance($newData);
                            $result=0;
                        }
                    } 

                }
                 

            }
            
           

        }else{
            $result=0;
        }

        echo $pu_res;
        
    }


    
    public function manual_push_punch(){
        $pu_res=1;
        if ($this->request->getMethod() == 'post') {
           
                $punched_date=strip_tags($this->request->getVar('punch_date'));
                $punched_time=strip_tags($this->request->getVar('punch_time'));
                $punch_employee=strip_tags($this->request->getVar('punch_employee'));
                $punch_id=0;
                $state=0;
                $employee_code=user_data($punch_employee,'staff_code');
                $u_type='employee';
                $ip_address='';

                $punched_datetime=$punched_date.' '.$punched_time ;

                $attend=new AttendanceModel();
                
                $myid=session()->get('id');

                $inout_status='';

                $check_is_same_day=$attend->where('DATE(punched_time)',get_date_format($punched_datetime,'Y-m-d'))->where('employee_id',$punch_employee)->where('company_id',company($myid))->where('deleted',0)->orderBy('punched_time','DESC')->first();
                if (!$check_is_same_day) {
                    $inout_status='in';
                }else{
                    if ($check_is_same_day['inout_status']=='in') {
                        $inout_status='out';
                    }else{
                        $inout_status='in';
                    }
                }


                $newData = [
                    'company_id'=> company($myid),
                    'employee_id' => $punch_employee, 
                    'created_at'=>now_time($myid), 
                    'punched_time'=>$punched_datetime,
                    'punch_id'=>$punch_id,
                    'state'=>$state,
                    'employee_code'=>$employee_code,
                    'u_type'=>$u_type,
                    'inout_status'=>$inout_status,
                    'ip_address'=>$ip_address,
                ];

                 
                if($attend->save($newData)){
                    $this->push_log_as_attendance($newData);
                    $result=1;
                }
               


        }else{
            $result=0;
        }

        echo $pu_res;
        
    }


    private function push_log_as_attendance($logs=[]){
        $PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee(); 
        $AttendanceModel=new AttendanceModel(); 

        $myid=session()->get('id');

        $company_id = $logs['company_id'];
        $employee_id  = $logs['employee_id']; 
        $employee_category  = user_data($logs['employee_id'],'employee_category'); 
        $created_at =$logs['created_at']; 
        $punched_time =$logs['punched_time'];
        $punch_id =$logs['punch_id'];
        $state =$logs['state'];
        $employee_code =$logs['employee_code'];
        $u_type =$logs['u_type'];
        $ip_address =$logs['ip_address'];
        $inout_status =$logs['inout_status'];


        if ($employee_category!='') {
            $check_is_same_day=$PushedAttendanceOfEmployee->where('DATE(date)',get_date_format($punched_time,'Y-m-d'))->where('employee_id',$employee_id)->where('company_id',$company_id)->where('deleted',0)->first();

                $day_status=0;
                $worked_hours=0;
                $overtime_hours=0;
                $late_come=0;

                $total_working_hours=employee_category_data($employee_category,'total_working_hour');
                $hours_to_full_day=employee_category_data($employee_category,'full_day_hour');
                $hours_to_half_day=employee_category_data($employee_category,'half_day_hour');
                $work_starting_time=employee_category_data($employee_category,'from');
         

                $push_data = [
                    'company_id'=>$company_id,
                    'date'=>$punched_time,
                    'employee_id'=>$employee_id,
                    'day_status'=>$day_status,
                    'worked_hours'=>$worked_hours,
                    'overtime_hours'=>$overtime_hours,
                    'late_come'=>$late_come, 
                ];

                

                if ($check_is_same_day) {
                    $PushedAttendanceOfEmployee->update($check_is_same_day['id'],$push_data);
                }else{
                    $PushedAttendanceOfEmployee->save($push_data);
                }
                $this->reset_logs_data($logs);
        }
        

    }



    private function reset_logs_data($logs=[]){
        $PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee(); 
        $AttendanceModel=new AttendanceModel(); 

        $myid=session()->get('id');

        $company_id = $logs['company_id'];
        $employee_id  = $logs['employee_id']; 
        $employee_category  = user_data($logs['employee_id'],'employee_category'); 
        $created_at =$logs['created_at']; 
        $punched_time =$logs['punched_time'];
        $punch_id =$logs['punch_id'];
        $state =$logs['state'];
        $employee_code =$logs['employee_code'];
        $u_type =$logs['u_type'];
        $ip_address =$logs['ip_address'];
        $inout_status =$logs['inout_status'];

        $day_status=0;
        $worked_hours=0;
        $overtime_hours=0;
        $late_come=0;

        $total_working_hours=employee_category_data($employee_category,'total_working_hour');
        $hours_to_full_day=employee_category_data($employee_category,'full_day_hour');
        $hours_to_half_day=employee_category_data($employee_category,'half_day_hour');
        $work_starting_time=employee_category_data($employee_category,'from');

        $get_all_punchdata=$AttendanceModel->where('DATE(punched_time)',get_date_format($punched_time,'Y-m-d'))->where('employee_id',$employee_id)->where('company_id',$company_id)->where('deleted',0)->orderBy('punched_time','asc')->findAll();

        $inout_status='in';
        $last_worked_hour=$worked_hours;
        $last_punched_time=$punched_time;
 
        $el_count=0;
        foreach ($get_all_punchdata as $pd) {
            $up_punch_data = [  
                'inout_status'=>$inout_status, 
            ];
            $AttendanceModel->update($pd['id'],$up_punch_data);
           
            $el_count++;
           
            //calculating worked hours
                if ($inout_status=='out') {
                    
                    $new_punched_time=$pd['punched_time']; 
                    $between_hours=date_diff(date_create($last_punched_time), date_create($new_punched_time));
                    $new_worked_hour = $between_hours->format("%H.%i"); 
                    $worked_hours=$last_worked_hour+$new_worked_hour;

                    //calculating day status
                    if ($worked_hours>=$hours_to_full_day) {
                        $day_status=2;            
                    }elseif ($worked_hours>=$hours_to_half_day) {
                        $day_status=1;
                    } 

                    

                }else{
                    $new_punched_time=$pd['punched_time'];
                }

                $last_worked_hour=$worked_hours;
                $last_punched_time=$new_punched_time; 
            //calculating worked hours


            //calculating overtime hours 
            if ($worked_hours>$total_working_hours) {
                $overtime_hours=$worked_hours-$total_working_hours; 
            }
            //calculating overtime hours


            //calculating late come
            if ($el_count==1) {
                $came_time=get_date_format($pd['punched_time'],'H:i:s');
                $between_hours=date_diff(date_create($work_starting_time), date_create($came_time)); 
                $late_come = $between_hours->format("%H.%i");  

                $startiitime=get_date_format($work_starting_time,'H:i:s');  
                if ($came_time<$startiitime) {
                    $late_come='-'.$late_come;
                } 
            }
            //calculating late come

            if ($inout_status=='in') {
               $inout_status='out';
            }else{
                $inout_status='in';
            }
        }

        $push_data = [
            'company_id'=>$company_id,
            'date'=>$punched_time,
            'employee_id'=>$employee_id,
            'day_status'=>$day_status,
            'worked_hours'=>$worked_hours,
            'overtime_hours'=>$overtime_hours,
            'late_come'=>$late_come, 
        ];

        $is_pushed_exist=$PushedAttendanceOfEmployee->where('DATE(date)',get_date_format($punched_time,'Y-m-d'))->where('employee_id',$employee_id)->where('company_id',$company_id)->where('deleted',0)->first();

        if ($is_pushed_exist) {
            $PushedAttendanceOfEmployee->update($is_pushed_exist['id'],$push_data);
        }else{
            $PushedAttendanceOfEmployee->save($push_data);
        }
    }

    
    public function edit_punch($punch_id=""){
        $pu_res=1;
        if ($this->request->getMethod() == 'post') {
           
                $punched_date=strip_tags($this->request->getVar('punch_date'));
                $punched_time=strip_tags($this->request->getVar('punch_time'));
                 

                $punched_datetime=$punched_date.' '.$punched_time ;

                $attend=new AttendanceModel();
                
                $myid=session()->get('id');
                $newData = [   
                    'punched_time'=>$punched_datetime, 
                ];

                 
                if($attend->update($punch_id,$newData)){
                    $result=1;
                }

        }else{
            $result=0;
        }

        echo $pu_res; 
    }

    public function update_note($punch_id=""){
        $pu_res=1;
        if ($this->request->getMethod() == 'post') {
           
                $note=strip_tags($this->request->getVar('note')); 
  
                $attend=new AttendanceModel();
                
                $myid=session()->get('id');
                $newData = [   
                    'note'=>$note, 
                ];

                 
                if($attend->update($punch_id,$newData)){
                    $result=1;
                }

        }else{
            $result=0;
        } 
        echo $pu_res; 
    }


    public function delete_punch($evid){
        $attend=new AttendanceModel();
        $PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee();
        $myid=session()->get('id');
        
        $session = session();


        $lg_data=$attend->where('id',$evid)->first();

        if ($lg_data) {  
           

            $eda=['deleted'=>1];
            if ($attend->update($evid,$eda)) { 

                $punch_employee=$lg_data['employee_id'];
                $punch_id=$lg_data['punch_id'];
                $state=$lg_data['state'];
                $employee_code=$lg_data['employee_code'];
                $u_type='employee';
                $ip_address=$lg_data['ip_address'];

                $punched_datetime=$lg_data['punched_time'];

                $inout_status=$lg_data['inout_status'];



                $newData = [
                    'company_id'=> company($myid),
                    'employee_id' => $punch_employee, 
                    'created_at'=>now_time($myid), 
                    'punched_time'=>$punched_datetime,
                    'punch_id'=>$punch_id,
                    'state'=>$state,
                    'employee_code'=>$employee_code,
                    'u_type'=>$u_type,
                    'inout_status'=>$inout_status,
                    'ip_address'=>$ip_address,
                ];

                 
                $this->push_log_as_attendance($newData);
                $this->reset_logs_data($newData);

                $session->setFlashdata('pu_msg','Deleted!');
                return redirect()->to(base_url('hr_manage/attendance/logs'));

            }else{
                $session->setFlashdata('pu_er_msg','Failed to delete!');
                return redirect()->to(base_url('hr_manage/attendance/logs'));
            }
        }else{
            return redirect()->to(base_url('hr_manage/attendance/logs'));
        }

            
    }

    
    public function attendance_settings()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $AttendanceEventModel=new AttendanceEventModel;
        $CompanySettings=new CompanySettings;
        $WorkshiftModel= new WorkshiftModel;

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $event_data = $AttendanceEventModel->where('company_id',company($myid))->where("type", 'event')->where("deleted", 0)->orderBy('id','DESC')->findAll();

            $field_data = $AttendanceEventModel->where('company_id',company($myid))->where("type", 'field')->where("deleted", 0)->orderBy('id','DESC')->findAll();


            $work_shift_data = $WorkshiftModel->where('company_id',company($myid))->where("deleted", 0)->orderBy('id','DESC')->findAll();
           
            $data=[
                'title'=>'Attendance Settings',  
                'user'=>$user,
                'field_data'=>$field_data,
                'event_data'=>$event_data,
                'work_shift_data'=>$work_shift_data,
            ];

            echo view('header',$data);
            echo view('hr_manage/attendance_settings');
            echo view('footer');


            if (isset($_POST['save_work_shift'])) { 
                $shift_data=[
                    'company_id'=>company($myid),
                    'shift'=>strip_tags($this->request->getVar('shift')),
                    'from'=>strip_tags($this->request->getVar('from')),
                    'to'=>strip_tags($this->request->getVar('to')),
                ];
                
                $session = session();

                if ($WorkshiftModel->save($shift_data)) { 
                    $session->setFlashdata('pu_msg','Saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));
                }
            }

            if (isset($_POST['edit_work_shift'])) { 
                $shift_data=[
                    'shift'=>strip_tags($this->request->getVar('shift')),
                    'from'=>strip_tags($this->request->getVar('from')),
                    'to'=>strip_tags($this->request->getVar('to')),
                ];
                
                $session = session();

                if ($WorkshiftModel->update(strip_tags($this->request->getVar('shiftid')),$shift_data)) { 
                    $session->setFlashdata('pu_msg','Saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));
                }
            }


            if (isset($_POST['save_attendance_offers'])) { 
                $evedata=[ 
                    'leave_for_month'=>strip_tags($this->request->getVar('leave_for_month')),
                    'carry_forward'=>strip_tags($this->request->getVar('carry_forward')),
                ];
                
                $session = session();

                if ($CompanySettings->update(get_setting(company($myid),'id'),$evedata)) { 
                    $session->setFlashdata('pu_msg','Saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));
                }
            }

            if (isset($_POST['save_attendance_event'])) { 
                $evedata=[
                    'company_id'=>company($myid),
                    'event_name'=>strip_tags($this->request->getVar('event_name')),
                    'event_date'=>strip_tags($this->request->getVar('date')),
                    'effect_to'=>strip_tags($this->request->getVar('effect_to')),
                    'font_color'=>strip_tags($this->request->getVar('font_color')),
                    'bg_color'=>strip_tags($this->request->getVar('bg_color')),
                    'type'=>'event',
                ];
                
                $session = session();

                if ($AttendanceEventModel->save($evedata)) { 
                    $session->setFlashdata('pu_msg','Event Saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));
                }
            } 

            

            if (isset($_POST['edit_save_attendance_event'])) { 
                $evedata=[
                    'event_name'=>strip_tags($this->request->getVar('event_name')),
                    'event_date'=>strip_tags($this->request->getVar('date')),
                    'effect_to'=>strip_tags($this->request->getVar('effect_to')),
                    'font_color'=>strip_tags($this->request->getVar('font_color')),
                    'bg_color'=>strip_tags($this->request->getVar('bg_color')),
                ];
                
                $session = session();

                if ($AttendanceEventModel->update(strip_tags($this->request->getVar('eventid')),$evedata)) { 
                    $session->setFlashdata('pu_msg','Event Saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/attendance_settings'));
                }
            }

             
           
        
        }else{
                return redirect()->to(base_url('users/login'));
            }
    }

    public function delete_event($evid){
        $attend=new AttendanceEventModel();
        $myid=session()->get('id');
        $eda=['deleted'=>1];
        $session = session();
        if ($attend->update($evid,$eda)) { 
        $session->setFlashdata('pu_msg','Deleted!');
        return redirect()->to(base_url('hr_manage/attendance_settings'));

        }else{
            $session->setFlashdata('pu_er_msg','Failed to delete!');
            return redirect()->to(base_url('hr_manage/attendance_settings'));
        }
    }

    public function delete_work_shift($evid){
        $WorkshiftModel=new WorkshiftModel();
        $myid=session()->get('id');
        $eda=[
            'deleted'=>1
        ];
        $session = session();
        if ($WorkshiftModel->update($evid,$eda)) { 

            $session->setFlashdata('pu_msg','Deleted!');
            return redirect()->to(base_url('hr_manage/attendance_settings'));

        }else{
            $session->setFlashdata('pu_er_msg','Failed to delete!');
            return redirect()->to(base_url('hr_manage/attendance_settings'));
        }
    }

    public function delete_leave_date($evid){
        $LeaveManagement=new LeaveManagement();
        $myid=session()->get('id');

        $session = session();
        if ($LeaveManagement->where('id',$evid)->delete()) { 
        $session->setFlashdata('pu_msg','Deleted!');
        return redirect()->to(base_url('hr_manage/leave_management'));

        }else{
            $session->setFlashdata('pu_er_msg','Failed to delete!');
            return redirect()->to(base_url('hr_manage/leave_management'));
        }
    }


    
    public function employee_categories(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $EmployeeCategoriesModel=new EmployeeCategoriesModel;

        if ($session->has('isLoggedIn')){ 
            $UserModel=new Main_item_party_table; 

            $myid=session()->get('id'); 

            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
           

            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
            
            $employee_categories=$EmployeeCategoriesModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();

            $data=[
                'title'=>'Employee categories',  
                'user'=>$user, 
                'employee_categories'=>$employee_categories
            ];

            echo view('header',$data);
            echo view('hr_manage/employee_categories'); 
            echo view('footer');

            if (isset($_POST['add_employees_category'])) {



                $date_data=[ 
                    'company_id'=>company($myid),
                    'category_name'=>strip_tags($this->request->getVar('category_name')), 
                    'leave_for_month'=>strip_tags($this->request->getVar('leave_for_month')), 
                    'carry_forward'=>strip_tags($this->request->getVar('carry_forward')), 
                    'total_working_hour'=>strip_tags($this->request->getVar('total_working_hour')), 
                    'full_day_hour'=>strip_tags($this->request->getVar('full_day_hour')), 
                    'half_day_hour'=>strip_tags($this->request->getVar('half_day_hour')), 
                    'sunday'=>strip_tags($this->request->getVar('sunday')), 
                    'monday'=>strip_tags($this->request->getVar('monday')), 
                    'tuesday'=>strip_tags($this->request->getVar('tuesday')), 
                    'wednesday'=>strip_tags($this->request->getVar('wednesday')), 
                    'thursday'=>strip_tags($this->request->getVar('thursday')), 
                    'friday'=>strip_tags($this->request->getVar('friday')), 
                    'saturday'=>strip_tags($this->request->getVar('saturday')), 
                    'from'=>strip_tags($this->request->getVar('from')),
                    'to'=>strip_tags($this->request->getVar('to')),
                ];
                
                $session = session();
 
               
                if ($EmployeeCategoriesModel->save($date_data)) { 
                    $session->setFlashdata('pu_msg','Category added successfully!');
                    return redirect()->to(base_url('hr_manage/employee_categories'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/employee_categories'));
                }
                 
                
            }


            if (isset($_POST['edit_employees_category'])) {



                $date_data=[  
                    'category_name'=>strip_tags($this->request->getVar('category_name')), 
                    'leave_for_month'=>strip_tags($this->request->getVar('leave_for_month')), 
                    'carry_forward'=>strip_tags($this->request->getVar('carry_forward')), 
                    'total_working_hour'=>strip_tags($this->request->getVar('total_working_hour')), 
                    'full_day_hour'=>strip_tags($this->request->getVar('full_day_hour')), 
                    'half_day_hour'=>strip_tags($this->request->getVar('half_day_hour')), 
                    'sunday'=>strip_tags($this->request->getVar('sunday')), 
                    'monday'=>strip_tags($this->request->getVar('monday')), 
                    'tuesday'=>strip_tags($this->request->getVar('tuesday')), 
                    'wednesday'=>strip_tags($this->request->getVar('wednesday')), 
                    'thursday'=>strip_tags($this->request->getVar('thursday')), 
                    'friday'=>strip_tags($this->request->getVar('friday')), 
                    'saturday'=>strip_tags($this->request->getVar('saturday')), 
                    'from'=>strip_tags($this->request->getVar('from')),
                    'to'=>strip_tags($this->request->getVar('to')),
                ];
                
                $session = session();
 
               
                if ($EmployeeCategoriesModel->update(strip_tags($this->request->getVar('ecid')),$date_data)) { 
                    $session->setFlashdata('pu_msg','Category updated successfully!');
                    return redirect()->to(base_url('hr_manage/employee_categories'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/employee_categories'));
                }
                 
                
            }
 
 



        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
    

    
    public function delete_employee_category($catid=""){
        $EmployeeCategoriesModel=new EmployeeCategoriesModel();
       
        $emp_data=[
            'deleted'=>1
        ];
        $session = session();
        if ($EmployeeCategoriesModel->update($catid,$emp_data)) { 
            $session->setFlashdata('pu_msg','Deleted!');
            return redirect()->to(base_url('hr_manage/employee_categories'));

        }else{
            $session->setFlashdata('pu_er_msg','Failed to delete!');
            return redirect()->to(base_url('hr_manage/employee_categories'));
        }
    }


    public function leave_management(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $CarryForwardedLeaves=new CarryForwardedLeaves;


        if ($session->has('isLoggedIn')){
            $AttendanceModel=new AttendanceModel;
            $UserModel=new Main_item_party_table;
            $LeaveManagement=new LeaveManagement;

            $myid=session()->get('id');

            if (!is_aitsun(company($myid))){
                return redirect()->to(base_url());
            }

            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

          


            if (check_permission($myid,'manage_hr')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}


            $user_data = $UserModel->where('main_compani_id',main_company_id($myid))->where('u_type!=', 'delivery')->where('u_type!=', 'vendor')->where('u_type!=', 'customer')->where('is_concept_user',1)->where("deleted", 0)->orderBy('display_name','ASC')->findAll();

           
            $data=[
                'title'=>'Leave management',  
                'user'=>$user,
                'user_data'=>$user_data
            ];

            echo view('header',$data);
            echo view('hr_manage/leave_management'); 
            echo view('footer');

            if (isset($_POST['save_leave_dates'])) {

                $date_data=[
                    'staff_id'=>strip_tags($this->request->getVar('staff_id')), 
                    'comapany_id'=>company($myid),
                    'leave_status'=>strip_tags($this->request->getVar('leave_status')),
                    'date'=>strip_tags($this->request->getVar('date')),
                ];
                
                $session = session();

                $check_exist=$LeaveManagement->where('staff_id',strip_tags($this->request->getVar('staff_id')))->where('comapany_id',company($myid))->where('leave_status',strip_tags($this->request->getVar('leave_status')))->where('date',strip_tags($this->request->getVar('date')))->first();
                if (!$check_exist) {
                    if ($LeaveManagement->save($date_data)) { 
                        $session->setFlashdata('pu_msg','Leave data Saved!');
                        return redirect()->to(base_url('hr_manage/leave_management'));

                    }else{
                        $session->setFlashdata('pu_er_msg','Failed to saved!');
                        return redirect()->to(base_url('hr_manage/leave_management'));
                    }
                }else{
                    $session->setFlashdata('pu_er_msg','Date exist!');
                    return redirect()->to(base_url('hr_manage/leave_management'));
                }
                
            }

            if (isset($_POST['edit_leave_dates'])) {

                 $date_data=[
                    'date'=>strip_tags($this->request->getVar('date')),
                ];
                
                $session = session();

                if ($LeaveManagement->update($this->request->getVar('lmd_id'),$date_data)) { 
                    $session->setFlashdata('pu_msg','Leave data Saved!');
                    return redirect()->to(base_url('hr_manage/leave_management'));

                }else{
                    $session->setFlashdata('pu_er_msg','Failed to saved!');
                    return redirect()->to(base_url('hr_manage/leave_management'));
                }
            }



            if (isset($_POST['save_attendance_list'])) {
                foreach ($_POST['staffid'] as $l => $value) {
                    $atttt=0;
                    if (isset($_POST['is_concept_user'][$l])) {
                         $atttt=$_POST['is_concept_user'][$l];
                    }
                    $us_data=[
                        'is_concept_user'=>$atttt
                    ];
                    $UserModel->update($_POST['staffid'][$l],$us_data);
                }

                $session = session();
                $session->setFlashdata('pu_msg','List saved!');
                return redirect()->to(base_url('hr_manage/leave_management'));
            }



        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function employee_lists()
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

            

           $employee_data=$UserModel->where('main_compani_id',main_company_id($myid))->where('deleted',0)->where('u_type!=','customer')->where('u_type!=','vendor')->where('u_type!=','seller')->where('u_type!=','delivery')->orderBy('display_name','ASC')->findAll();
            
            $data=[
                'title'=>'Employee lists',
                'user'=>$user,
                'employee_data'=>$employee_data
               
            ];

            echo view('header',$data);
            echo view('hr_manage/employee_lists',$data);
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }



    public function save_staff_data(){

         $session=session();
         $myid=session()->get('id');
         $UserModel= new Main_item_party_table();

        if ($session->has('isLoggedIn')){

           if ($this->request->getMethod()=='post') {

             $staff_data=[
                'company_id'=>company($myid),
                'main_compani_id'=>main_company_id($myid),
                'display_name'=>strip_tags($this->request->getVar('staff_name')),
                'email'=>strip_tags($this->request->getVar('staff_email')),
                'phone'=>strip_tags($this->request->getVar('phone_number')),
                'designation'=>strip_tags($this->request->getVar('designation')),
                'shifts'=>strip_tags($this->request->getVar('shifts')),
                'staff_code'=>strip_tags($this->request->getVar('staff_code')),
                'gender'=>strip_tags($this->request->getVar('staff_gender')),
                'employee_category'=>strip_tags($this->request->getVar('employee_category')), 
                'u_type'=>'staff',
            ];
            
            $checkemail=$UserModel->where('company_id',company($myid))->where('email',strip_tags($this->request->getVar('staff_email')))->where('deleted',0)->first();
            if (!$checkemail) {

                $checkcode=$UserModel->where('company_id',company($myid))->where('staff_code',strip_tags($this->request->getVar('staff_code')))->where('deleted',0)->first();

                 if (!$checkcode) {
                    $save_fields=$UserModel->save($staff_data);

                    if($save_fields) {
                        echo 1;
                    }else{
                        echo 0;
                    }
                     
                 }else{
                    echo 3;
                 }
                
            }else{
                echo 2;
            }
            

           }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }



    public function edit_staff_data($emp_id){

         $session=session();
         $myid=session()->get('id');
         $UserModel= new Main_item_party_table();

        if ($session->has('isLoggedIn')){

           if ($this->request->getMethod()=='post') {

            $old_staff_email=strip_tags($this->request->getVar('old_staff_email'));
            $old_staff_code=strip_tags($this->request->getVar('old_staff_code'));

            $staff_email=strip_tags($this->request->getVar('staff_email'));
            $staff_code=strip_tags($this->request->getVar('staff_code'));


             $staff_data=[
                'display_name'=>strip_tags($this->request->getVar('staff_name')),
                'email'=>$staff_email,
                'phone'=>strip_tags($this->request->getVar('phone_number')),
                'designation'=>strip_tags($this->request->getVar('designation')),
                'shifts'=>strip_tags($this->request->getVar('shifts')),
                'employee_category'=>strip_tags($this->request->getVar('employee_category')), 
                'staff_code'=>$staff_code,
                'gender'=>strip_tags($this->request->getVar('staff_gender')),
            ];

            $status_result=1;
            $echo_result=0;

            if ($old_staff_email!=$staff_email) {
                 $checkemail=$UserModel->where('company_id',company($myid))->where('email',strip_tags($this->request->getVar('staff_email')))->where('deleted',0)->first();
                 if (!$checkemail) {
                    $status_result=1;
                 }else{
                    $status_result=0;
                    $echo_result='email_exist';
                 }
            }

            if ($old_staff_code!=$staff_code) {
                 $checkcode=$UserModel->where('company_id',company($myid))->where('staff_code',strip_tags($this->request->getVar('staff_code')))->where('deleted',0)->first();

                     if (!$checkcode) {
                        $status_result=1;
                     }else{
                        $status_result=0;
                        $echo_result='code_exist';
                     }
            }

            if ($status_result==1) {
                $save_fields=$UserModel->update($emp_id,$staff_data);

                if($save_fields) {
                    echo 1;
                }else{
                    echo 0;
                }
            }else{
                echo $echo_result;
            }
            
            

            

          

           }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function delete_employee_data($emp_id){
        $UserModel=new Main_item_party_table();
        $myid=session()->get('id');
        $emp_data=[
            'deleted'=>1
        ];
        $session = session();
        if ($UserModel->update($emp_id,$emp_data)) { 
            $session->setFlashdata('pu_msg','Deleted!');
            return redirect()->to(base_url('hr_manage/employee_lists'));

        }else{
            $session->setFlashdata('pu_er_msg','Failed to delete!');
            return redirect()->to(base_url('hr_manage/employee_lists'));
        }
    }

    public function allow_emp_attendance($emp_id){
        $session=session();
        $UserModel=new Main_item_party_table;
        $AttendanceAllowedList=new AttendanceAllowedList;

        $myid=session()->get('id');

        if ($this->request->getMethod()=='post') { 

            $chexist=$AttendanceAllowedList->where('company_id',company($myid))->where('user_id',$emp_id)->first();

            if ($chexist) {
                $cdad=[
                    'user_name'=>user_name($chexist['user_id']),
                    'attendance_allowed'=>strip_tags($this->request->getVar('attendance_allowed')),
                ];
                $save_data=$AttendanceAllowedList->update($chexist['id'],$cdad);
            }else{
                $cdad=[
                    'company_id'=>company($myid),
                    'user_id'=>$emp_id,
                    'user_name'=>user_name($emp_id), 
                    'attendance_allowed'=>strip_tags($this->request->getVar('attendance_allowed')),
                ];
                $save_data=$AttendanceAllowedList->save($cdad);
            }
            

            if ($save_data) {
                echo 1;
            }else{
                echo 0;
            }
        }
    }
        
}