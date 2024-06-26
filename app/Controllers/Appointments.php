<?php
namespace App\Controllers; 
use App\Models\EnquiriesModel;
use App\Models\SocialMediaModel;
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\PostsModel;
use App\Models\PostThumbnail;
use App\Models\PostCategoryModel;
use App\Models\ReviewsModel;
use App\Models\ClientsModel;
use App\Models\Main_item_party_table;
use App\Models\ResourcesModel;
use App\Models\AppointmentsTimings;

use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

class Appointments extends BaseController
{  
    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {
            
                $etqry = $CompanySettings2->where('company_id',company($myid))->first();
                $data = [
                    'title' => 'Aitsun ERP- Appoinments',
                    'user' => $user, 
                ];
               
                echo view('header',$data);
                echo view('appointments/appointments_index', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function book_persons(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {
            
                $etqry = $CompanySettings2->where('company_id',company($myid))->first();
                $data = [
                    'title' => 'Aitsun ERP- Book person',
                    'user' => $user, 
                ];
               
                echo view('header',$data);
                echo view('appointments/book_persons', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function create(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {
            
                $etqry = $CompanySettings2->where('company_id',company($myid))->first();
                $data = [
                    'title' => 'Aitsun ERP- create Appoinments',
                    'user' => $user, 
                ];
               
                echo view('header',$data);
                echo view('appointments/create_appoinment', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function get_booking_form(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 
            
            if (is_appointments(company($user['id']))==1) {
             
                $data = [
                    'title' => 'form',
                    'user' => $user, 
                ];
                
                echo view('appointments/booking_form', $data);
               

            }else{
             
            }
        }else{
             
        }
    }
    

    public function get_timings($app_id=0){
        $time_result='<div class="col-md-12 text-aitsun-red text-start">Timings not available<br>Choose other date/other appointment</div>';
        $session=session();
        if($session->has('isLoggedIn')){
            if (!empty($app_id)) { 
                $myid=session()->get('id');
                $AppointmentsTimings=new AppointmentsTimings;
                $selected_date=now_time($myid);

                if ($_GET) {
                    if (isset($_GET['date'])) {
                        if (!empty($_GET['date'])) {
                            if (isValidDate($_GET['date'])) {
                                $selected_date=$_GET['date'];
                            }
                        }
                    }
                }
                
                $week_of_selected_date=get_date_format($selected_date,'w');
                // echo $week_of_selected_date; 

                $timings=$AppointmentsTimings->where('appointment_id',$app_id)->where('week',$week_of_selected_date)->findAll();
                $timing_box=[];
                foreach ($timings as $tm) {
                    $start_time = new Time($tm['from']);
                    $end_time = new Time($tm['to']); 
                     
                    $interval = new DateInterval('PT30M'); 
                    $result_time= new DatePeriod($start_time, $interval, $end_time->add($interval));
                    foreach ($result_time as $rt) {   
                        array_push($timing_box, $rt->format('H:i'));
                    }
                    
                }
 
                $time_result='';
                $timing_box=array_unique($timing_box);
                sort($timing_box);

                foreach ($timing_box as $time) {
                    $time_result.='<div class="col-md-3">';
                     $time_result.='<input type="radio" class="time_box_radio" name="time" id="time'.str_replace(':','',$time).'">'; 
                    $time_result.='<label class="time_box" data-time="'.$time.'" for="time'.str_replace(':','',$time).'">';
                    $time_result.=get_date_format($time,'h:i A');
                    $time_result.='</label>';
                   
                    $time_result.='</div>'; 
                } 
            }
        }
        echo  $time_result;
    }


    public function resources(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $ResourcesModel= new ResourcesModel();
            $myid=session()->get('id');
            $pager = \Config\Services::pager();
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {

                if ($_GET) {
                    if (isset($_GET['serachresource'])) {
                        if (!empty($_GET['serachresource'])) {
                            $ResourcesModel->like('appointment_resource', $_GET['serachresource'], 'both'); 
                        }
                    }
                    
             
                }


                $resource_data = $ResourcesModel->where('company_id',company($myid))->where('deleted',0)->orderBy("id", "desc")->paginate(20);

                if (isset($_GET['get_excel'])) {
            

                    $fileName = "Appointment Resource". ".xls"; 
                    
                            // Column names 
                    $fields = array( 'Appointment Resource', 'Capacity', 'Description',); 

                    
                    
                             // print_r($fields);

                            // Display column names as first row 
                    $excelData = implode("\t", array_values($fields)) . "\n"; 
                    
                            // Fetch records from database 
                    $query = $resource_data; 
                    if(count($query) > 0){ 
                        // Output each row of the data 
                        foreach ($query as $row) {
                            
                            $colllumns=array($row['appointment_resource'], $row['capacity'], $row['description']);
                            
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
            

                $data = [
                    'title' => 'Aitsun ERP- Resources',
                    'user' => $user, 
                    'resource_data'=>$resource_data,
                    'pager' => $ResourcesModel->pager,
                ];
               
                echo view('header',$data);
                echo view('appointments/resources', $data);
                echo view('footer'); 

            }else{
            return redirect()->to(base_url('users/login'));
        }
        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

     public function add_resources(){

        if ($this->request->getMethod() == 'post'){
                $myid=session()->get('id');
                $ResourcesModel= new ResourcesModel();
                
                $resources_data = [
                    'appointment_resource' => strip_tags($this->request->getVar('appointment_resource')),
                    'company_id' => company($myid),
                    'capacity' => strip_tags($this->request->getVar('capacity')),
                    'description' => strip_tags($this->request->getVar('description')),
                    
                 ];
                $ResourcesModel->save($resources_data);
        }
    }

    public function update_resources($rsoid=""){
        $session=session();
        $user=new Main_item_party_table();
        $ResourcesModel=new ResourcesModel();
        $myid=session()->get('id');
        if ($this->request->getMethod() == 'post') {

            $pele=strip_tags(trim($this->request->getVar('r_element')));

            $pro_data=$ResourcesModel->where('id',$rsoid)->first();

           
                $ac_data = [
                    $pele=>strip_tags(trim($this->request->getVar('r_element_val'))),
                    
                ];
       
                $save_pro_data=$ResourcesModel->update($rsoid,$ac_data);
            
           
            if ($save_pro_data) {
                echo 1;
            }else{
                echo 0;
            }
           
        }
    }


    public function delete_resource($rs_id=""){
        if (!empty($rs_id)) {
            $myid=session()->get('id');
            $ResourcesModel= new ResourcesModel();

            $acti=activated_year(company($myid));
            
             $multyiple = explode(',', $rs_id);

             foreach ($multyiple as $inid) {

                $data=[
                    'deleted'=>1,
                ];

                
                $ResourcesModel->update($inid,$data);

             }

            session()->setFlashdata('pu_msg', 'Deleted successfully');
         
            if (count($multyiple)>=1) {
                return redirect()->to(base_url('appointments/resources'));
            } 
        }
    }
}