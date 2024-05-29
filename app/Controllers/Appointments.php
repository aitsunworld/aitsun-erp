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

use App\Models\AppointmentsBookings;

use App\Models\AppointmentsModel;



use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

class Appointments extends BaseController
{  
    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $AppointmentsModel= new AppointmentsModel;
            $myid=session()->get('id');
            $pager = \Config\Services::pager();
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {


                if ($_GET) {
                    if (isset($_GET['appointment'])) {
                        if (!empty($_GET['appointment'])) {
                            $AppointmentsModel->like('title', $_GET['appointment'], 'both'); 
                        }
                    }
                    
             
                }
                $app_data = $AppointmentsModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(6);

                $data = [
                    'title' => 'Aitsun ERP- Appoinments',
                    'user' => $user,
                    'appointment_data'=>$app_data,
                    'pager' => $AppointmentsModel->pager,
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
            $AppointmentsBookings= new AppointmentsBookings;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {
                $active_date=get_date_format(now_time($myid),'Y-m-d'); 
                
                if ($_GET) {
                    if (isset($_GET['date'])) {
                        if (!empty($_GET['date'])) {
                            if (strtotime($_GET['date'])) {
                                $active_date=$_GET['date'];
                            } 
                        }
                    }
                }
            
                $todays_booking=$AppointmentsBookings->where('DATE(book_from)',$active_date)->findAll();
                
                $data = [
                    'title' => 'Aitsun ERP- Book person',
                    'user' => $user, 
                    'todays_booking'=>$todays_booking
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


    public function create($appointment_id = null){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            if (is_appointments(company($user['id']))==1) {
            
                $data = [
                    'title' => 'Aitsun ERP- create Appoinments',
                    'user' => $user,
                    'appointment' => null, 
                ];
                
                if ($appointment_id) {
                    $AppointmentsModel = new AppointmentsModel();
                    $data['appointment'] = $AppointmentsModel->where('id', $appointment_id)->first();
                    if (!$data['appointment']) {
                        return redirect()->to(base_url('appointments'));
                    }
                }

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

    public function get_booking_form($date='',$time='',$appointment_id=''){
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
                    'date'=>$date,
                    'time'=>$time,
                    'appointment_id'=>$appointment_id,
                    'form_type'=>'add'
                ];
                
                echo view('appointments/booking_form', $data);
               

            }
        }
    }

    
    public function get_booking_edit_form($booking_id=''){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $AppointmentsBookings= new AppointmentsBookings;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first(); 
            
            if (is_appointments(company($user['id']))==1) {
                $ap_data=$AppointmentsBookings->where('id',$booking_id)->first();
                $data = [
                    'title' => 'form',
                    'user' => $user,   
                    'form_type'=>'edit',
                    'ap_data'=>$ap_data,

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

     public function add_resources() {
    if ($this->request->getMethod() == 'post') {
        $myid = session()->get('id');
        $ResourcesModel = new ResourcesModel();

        $img = $this->request->getFile('resource_img');
        $imagePath = '';

        if ($img && $img->isValid() && !$img->hasMoved()) {
            if ($img->getSize() <= 307200) { // 300 KB = 300 * 1024 bytes = 307200 bytes
                $newName = $img->getRandomName();
                $img->move(ROOTPATH . 'public/images/resources', $newName); 
                $imagePath =$img->getName(); 
            } else {
                echo 0; // File size exceeds the 300 KB limit
                return;
            }
        }

        $resources_data = [
            'appointment_resource' => strip_tags($this->request->getVar('appointment_resource')),
            'company_id' => company($myid),
            'capacity' => strip_tags($this->request->getVar('capacity')),
            'description' => strip_tags($this->request->getVar('description')),
        ];

        if (!empty($imagePath)) {
            $resources_data['image'] = strip_tags($imagePath);
        }

        if ($ResourcesModel->save($resources_data)) {
            echo 1; 
        } else {
            echo 0; 
        }
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



    public function save_booking($booking_id=0){ 
        if ($this->request->getMethod() == 'post'){
            $myid=session()->get('id');
            $AppointmentsBookings= new AppointmentsBookings(); 
            $book_from='';
            $book_to='';

            $book_from_date=strip_tags($this->request->getVar('book_from_date'));
            $book_from_time=strip_tags($this->request->getVar('book_from_time'));
            $book_to_date=strip_tags($this->request->getVar('book_to_date'));
            $book_to_time=strip_tags($this->request->getVar('book_to_time'));
            $book_from=$book_from_date.' '.$book_from_time;
            $book_to=$book_to_date.' '.$book_to_time;


            $person_id=0;
            $resource_id=0;
            $booking_type='person';

            if (appointments_data(strip_tags($this->request->getVar('appointment_id')),'availability_on')==0) {
                $person_id=appointments_data(strip_tags($this->request->getVar('appointment_id')),'person');
            }else{
                $resource_id=appointments_data(strip_tags($this->request->getVar('appointment_id')),'resource');
                $booking_type='resource';
            }

            
            $resources_data = [ 
                'company_id' => company($myid), 
                'booking_name'=> strip_tags($this->request->getVar('booking_name')), 
                'booking_type'=> 'person',
                'resource_id'=> $resource_id,
                'person_id'=> $person_id,
                'customer'=> strip_tags($this->request->getVar('customer_id')),
                'book_from'=> $book_from,
                'book_to'=> $book_to,
                'appointment_id'=> strip_tags($this->request->getVar('appointment_id')),
                'duration'=> strip_tags($this->request->getVar('duration')),
                'booked_by'=> $myid,
                'datetime'=> now_time($myid),
                'note'=> strip_tags($this->request->getVar('note')),
                'deleted' => 0,
            ];

            if ($booking_id>0) { 
               $resources_data['id'] = $booking_id;
            }
             

            if ($AppointmentsBookings->save($resources_data)) {
                echo 1;
            }else{
                echo 0;
            }
        }
    }

     public function save_appointments(){

        if ($this->request->getMethod() == 'post'){
                $myid=session()->get('id');
                $AppointmentsModel= new AppointmentsModel();
                $AppointmentsTimings= new AppointmentsTimings();

                $appointment_id = $this->request->getVar('appointment_id');
                
                $apt_data = [
                    'company_id' => company($myid),
                    'added_by' => $myid,
                    'datetime' => now_time($myid),
                    'title' => strip_tags($this->request->getVar('appointment_title')),
                    'duration' => strip_tags($this->request->getVar('duration')),
                    'allow_cancelling_before' => strip_tags($this->request->getVar('allow_cancelling_before')),
                    'availability_on' => strip_tags($this->request->getVar('availability_on')),
                    'person' => strip_tags($this->request->getVar('person')),
                    'resource' => strip_tags($this->request->getVar('resource')),
                    'hours_before' => strip_tags($this->request->getVar('hours_before')),
                    'days_before' => strip_tags($this->request->getVar('days_before')),
                    'is_image_show' => strip_tags($this->request->getVar('is_image_show')),
                    'assign_method' => strip_tags($this->request->getVar('assign_method')),
                    
                 ];
                

                if ($appointment_id) {
                    // Update existing appointment
                    $AppointmentsModel->update($appointment_id, $apt_data);
                    $apoid = $appointment_id;
                } else {
                    // Add new appointment
                    $AppointmentsModel->save($apt_data);
                    $apoid = $AppointmentsModel->insertID();
                }

                    
                    // foreach (appointment_timings_array($apoid) as $atms){
                    //     $AdditionalfieldsModel->delete($atms);
                    // }

                    $AppointmentsTimings->where('appointment_id', $apoid)->delete();
                    if (!empty($_POST["week"])) {
                        foreach ($_POST["week"] as $i => $value ) {
                            $from=trim(strip_tags($_POST["from"][$i]));
                            $week=trim(strip_tags($_POST["week"][$i]));
                            $to=trim(strip_tags($_POST["to"][$i]));
                            
                            
                            $add_fields=[
                                'appointment_id'=>$apoid,
                                'week'=>$week,
                                'from'=> $from,
                                'to'=>$to,
                            ];

                            if (!empty($from) && !empty($to)) {
                                $AppointmentsTimings->save($add_fields); 
                            }
                        
                    }
                }
                echo 1;
                     

        }
    }

    public function delete_appointment($apid=0)
    {
        $AppointmentsModel = new AppointmentsModel();
        $AppointmentsTimings= new AppointmentsTimings();
        $myid=session()->get('id');
        

        if ($this->request->getMethod() == 'post') {
               
                $deledata=[
                    'deleted'=>1,
                ];

                if ($AppointmentsModel->update($apid,$deledata)) {

                    foreach (appointment_timings_array($apid) as $apt){
                        $AppointmentsTimings->delete($apt);
                    }
                    
                };

                
        }else{
            return redirect()->to(base_url('appointments'));
        }

    }
}