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