<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\PaymentsModel;
use App\Models\Classtablemodel;
use App\Models\InvoiceModel; 
use App\Models\FeesModel; 
 

class Users extends BaseController
{

    protected $Aclibrary;

    public function index()
    {
        return redirect()->to(base_url('users/login'));
    }

    public function login(){ 
        $data = [];
        helper(['form']);

        if ($this->request->getMethod() == 'post') {

            

        $session=session(); 
        if (!$session->has('isLoggedIn')){ 

            //let's do the validation here
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => 'Email or Password don\'t match'
                ]
            ];

            

            if (!$this->validate($rules, $errors)) {

                $data['validation'] = $this->validator;


            }else{

                
                   $model = new Main_item_party_table();

                   

                    if (!RECAPTCHA) {
                        $capc=1;
                    }else{
                         $secretKey = secret_key();
                        $response = $_POST['g-recaptcha-response'];     
                        $remoteIp = $_SERVER['REMOTE_ADDR'];


                        $reCaptchaValidationUrl = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$remoteIp");
                        $result = json_decode($reCaptchaValidationUrl, TRUE);

                        //get response along side with all results
                        print_r($result);

                        $capc=$result['success'];
                    }

                    if ($capc==1) {

                    $user = $model->where('email', $this->request->getVar('email'))
                                                ->first();

                    $this->setUserSession($user);
                    //$session->setFlashdata('success', 'Successful Registration');

                    if (company($user['id'])) {
                        $comp=company($user['id']);
                    }else{
                        $comp='';
                    }

                    ////////////////////////CREATE ACTIVITY LOG//////////////
                    $log_data=[
                        'user_id'=>$user['id'],
                        'action'=>'User <b>'.user_name($user['id']).'</b> is logged in.',
                        'ip'=>get_client_ip(),
                        'mac'=>GetMAC(),
                        'created_at'=>now_time($user['id']),
                        'updated_at'=>now_time($user['id']),
                        'company_id'=>$comp,
                    ];

                    add_log($log_data);
                    ////////////////////////END ACTIVITY LOG/////////////////

                    return redirect()->to(base_url());
                
                }else{
                    session()->setFlashdata('failmsg', 'Sorry Google Recaptcha Unsuccessful!!');
                    return redirect()->to(base_url('users/login'));
                }


            }
        }else{
            return redirect()->to(base_url());
        }

        
        }

        $data['title']="Login | Aitsun ERP";

        $session=session(); 
        if (!$session->has('isLoggedIn')){ 
            // echo view('layout/header_one',$data);
            echo view('users/login',$data);
            // echo view('layout/footer');
        }else{
            return redirect()->to(base_url());
        }  
    }

    public function check_challan_transaction_exist($challan_id=0)
    {
        $model = new Main_item_party_table(); 
        $PaymentsModel = new PaymentsModel();
        $myid=session()->get('id');
        $acti=activated_year(company($myid));

        $result='';

         
        
        $check_payments=$PaymentsModel->where('invoice_id',$challan_id)->where('deleted',0)->first();

        if ($check_payments) {
            $result='exist';
        }


        echo  $result;
    }

    public function student_suggestions($searched_student=""){
        $Classtablemodel = new Classtablemodel(); 
        $user=new Main_item_party_table();
        $myid=session()->get('id');
        $usaerdata=$user->where('id', $myid)->first();
        $acti=academic_year($myid);
      
        $stud_data=$Classtablemodel->where('academic_year',$acti)->where('deleted',0)->like('first_name',$searched_student,'both')->where('company_id',company($myid))->where('transfer','')->findAll(10);
     
        foreach ($stud_data as $st) { 
        ?> 
            <li class="open_feeses_of_student" data-stid="<?= $st['student_id'] ?>"><?= user_name($st['student_id']) ?> - <?= class_name(current_class_of_student(company($myid),$st['student_id'])) ?></li>
        <?php
        }

    }

    public function get_unpaid_fees_of_student($student_id=''){
        $session=session();
        $user=new Main_item_party_table();
        $InvoiceModel= new InvoiceModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first();  

                $invoicessss=$InvoiceModel->where('company_id',company($myid))->where('paid_status','unpaid')->where('customer',$student_id)->where('deleted',0)->orderBy('id','DESC')->findAll();

                
                
                if (count($invoicessss)>0) { 
                    $cou=0;
                    foreach ($invoicessss as $ft) { $cou++;
                        ?> 

                        <?php if ($cou==1): ?>
                            <li class="d-flex justify-content-between px-1 mb-2">
                                <h6 class="my-auto"><?= user_name($student_id) ?></h6> 
                                <div class="my-auto">
                                    <button class="aitsun-primary-btn-topbar generate_new_challan" data-std_id="<?= $student_id ?>">+ Generate</button>
                                </div>
                            </li>
                        <?php endif ?>
                        
                        <li class="feesli text-start <?php if ($ft['due_amount']>0): ?><?php else: ?>bg-success<?php endif ?> px-3" data-invoice_id="<?= $ft['id'] ?>" data-due_amount="<?= $ft['due_amount'] ?>">
                          <h3><?= get_fees_data(company($myid),$ft['fees_id'],'fees_name'); ?></h3>

                          <?php if ($ft['due_amount']>0): ?>
                                <div class="d-flex justify-content-between">
                                  <div class="text-secondary">Total: <?= currency_symbol(company($myid)); ?> <?= $ft['total'] ?></div>
                                  <div class="text-success">Paid: <?= currency_symbol(company($myid)); ?> <?= $ft['paid_amount'] ?></div>
                                  <div class="text-danger">Due: <?= currency_symbol(company($myid)); ?> <?= $ft['due_amount'] ?></div>
                                </div>
                          <?php else: ?>
                                <div class="d-flex justify-content-between">
                                  <div class="text-body">Total: <?= currency_symbol(company($myid)); ?> <?= $ft['total'] ?></div> 
                                  <div class="text-white">Fully paid</div>
                                </div>
                          <?php endif ?>
                          
                      </li>
                        <?php
                    }
                }else{ ?>
                    <li class="d-flex justify-content-between px-1 mb-2">
                                <h6 class="my-auto"><?= user_name($student_id) ?></h6> 
                                <div class="my-auto">
                                    <button class="btn btn-blue btn-sm generate_new_challan" data-std_id="<?= $student_id ?>">+ Generate</button>
                                </div>
                            </li>
                    <li class=" text-start px-3"> 
                      <div class="d-flex justify-content-between"> 
                          <b class="text-success">No pending fees</b> 
                      </div>
                    </li>
                <?php }


                         
        } 
    }





    public function get_all_standard_fees_of_student($student_id=''){
        $session=session();
        $user=new Main_item_party_table();
        $FeesModel= new FeesModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first(); 

                $fees=$FeesModel->where('company_id',company($myid))->where('fees_type',0)->where('deleted',0)->orderBy('id','DESC')->findAll();

                
                
                if (count($fees)>0) { 
                    $cou=0;
                    foreach ($fees as $ft) { $cou++;
                        ?> 

                        <?php if ($cou==1): ?>
                            <li class="d-flex justify-content-between px-1 mb-2">
                                <h6 class="my-auto">Select fees</h6> 
                                <div class="my-auto">
                                    <?= user_name($student_id) ?> - <?= class_name(current_class_of_student(company($myid),$student_id)) ?>
                                </div>
                            </li>
                        <?php endif ?>
                        
                        <li class="st_fees_list text-start px-3" data-fees_id="<?= $ft['id'] ?>" data-std_id="<?= $student_id ?>">
                          <h3 class="mb-0"><i class="bx bx-chevron-right-circle my-auto"></i> <?=$ft['fees_name']; ?></h3> 
                          
                      </li>
                        <?php
                    }
                }else{ ?>
                    <li class="d-flex justify-content-between px-1 mb-2">
                        <h6 class="my-auto">Select fees</h6> 
                        <div class="my-auto">
                            <?= user_name($student_id) ?> - <?= class_name(current_class_of_student(company($myid),$student_id)) ?>
                        </div>
                    </li>
                    <li class=" text-start px-3"> 
                      <div class="d-flex justify-content-between"> 
                          <b class="text-success">No pending fees</b> 
                      </div>
                    </li>
                <?php }

 
        } 
    }

    public function get_all_transport_fees_of_student($student_id=''){
        $session=session();
        $user=new Main_item_party_table();
        $FeesModel= new FeesModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first(); 

                $fees=$FeesModel->where('company_id',company($myid))->where('fees_type',1)->where('deleted',0)->orderBy('id','DESC')->findAll();

                
                
                if (count($fees)>0) { 
                    $cou=0;
                    foreach ($fees as $ft) { $cou++;
                        ?> 

                        <?php if ($cou==1): ?>
                            <li class="d-flex justify-content-between px-1 mb-2">
                                <h6 class="my-auto">Select fees</h6> 
                                <div class="my-auto">
                                    <?= user_name($student_id) ?> - <?= class_name(current_class_of_student(company($myid),$student_id)) ?>
                                </div>
                            </li>
                        <?php endif ?>
                        
                        <li class="tr_fees_list text-start px-3" data-fees_id="<?= $ft['id'] ?>" data-std_id="<?= $student_id ?>">
                          <h3 class="mb-0"><i class="bx bx-chevron-right-circle my-auto"></i> <?=$ft['fees_name']; ?></h3> 
                          
                      </li>
                        <?php
                    }
                }else{ ?>
                    <li class="d-flex justify-content-between px-1 mb-2">
                        <h6 class="my-auto">Select fees</h6> 
                        <div class="my-auto">
                            <?= user_name($student_id) ?> - <?= class_name(current_class_of_student(company($myid),$student_id)) ?>
                        </div>
                    </li>
                    <li class=" text-start px-3"> 
                      <div class="d-flex justify-content-between"> 
                          <b class="text-success">No pending fees</b> 
                      </div>
                    </li>
                <?php }
 
            
        } 
    }

    public function get_all_transport_locations($student_id='',$fees_id=''){
        $session=session();
        $user=new Main_item_party_table();
        $FeesModel= new FeesModel();
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
            $usaerdata=$user->where('id', session()->get('id'))->first(); 

                 

                
                
                $fees=transport_items(company($myid));

                if (count($fees)>0) { 
                    $cou=0;
                    foreach ($fees as $ft) { $cou++;
                        ?> 

                        <?php if ($cou==1): ?>
                            <li class="d-flex justify-content-between px-1 mb-2">
                                <h6 class="my-auto">Select location</h6> 
                                <div class="my-auto">
                                    <?= user_name($student_id) ?> - <?= class_name(current_class_of_student(company($myid),$student_id)) ?>
                                </div>
                            </li>
                        <?php endif ?>
                        
                        <li class="tr_location_list text-start px-3" data-location_id="<?= $ft['id'] ?>" data-fees_id="<?= $fees_id ?>" data-student_id="<?= $student_id ?>">
                          <h3 class="d-flex justify-content-between mb-0"><?= $ft['product_name'] ?> <i class="bx bx-bus-school my-auto"></i></h3> 
                          
                      </li>
                        <?php
                    }
                }else{ ?>
                    <li class=" text-start px-3"> 
                      <div class="d-flex justify-content-between"> 
                          <b class="text-success">No locations to select</b> 
                      </div>
                    </li>
                <?php }
 
            
        } 
    }

    private function setUserSession($user){
        $data = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'lastn_ame' => $user['last_name'],
            'email' => $user['email'],
            'isLoggedIn' => true,
            'user_token' => user_token(),

        ];

        session()->set($data);
        return true;
    } 

    public function logout(){
        $Main_item_party_table=new Main_item_party_table();
        $myid=session()->get('id');
        $uldata=[
            'is_logout'=>1,
            'created_by'=>session()->get('id'),
            'user_token'=>session()->get('user_token'),
            'updated_at'=>now_time($myid), 
        ];
        echo $myid;
        $Main_item_party_table->update($myid,$uldata);
        
        // $this->Aclibrary=new Accounting_library();
        // $this->Aclibrary; 

        session()->destroy();
        return redirect()->to(base_url('users'));
    }
}
