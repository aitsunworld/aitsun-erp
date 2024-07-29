<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\SalaryTable;
use App\Models\PayrollModel;
use App\Models\PayrollitemsModel;
use App\Models\PaymentsModel;
use App\Models\CustomerBalances;
use App\Models\InvoiceModel;
use App\Models\PayrollfieldsModel;
use App\Models\SalarySlipItemsModel;
use App\Models\ManualPayrollFieldValues;


class Payroll extends BaseController
{
    public function index()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $SalaryTable= new SalaryTable;
        $PayrollModel= new PayrollModel;
        $PayrollfieldsModel= new PayrollfieldsModel;



        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $payrolls=$PayrollModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();


            $data=[
                'title'=>'Payroll - Aitsun ERP',
                'user'=>$user,
                'pay_rolls'=>$payrolls
            ];
            echo view('header',$data);
            echo view('payroll/payroll');
            echo view('footer');


            //////////////////// Default salary rules /////////////////
            $rules=['Gross salary','Net salary'];
            foreach ($rules as $ru) {
                $rules_exist=$PayrollfieldsModel->where('company_id',company($myid))->where('deleted',0)->where('field_name',$ru)->first();
                if (!$rules_exist) {
                    $pr_data = [
                        'company_id'=>company($myid),
                        'field_name'=>$ru,
                        'deletable'=>1
                    ];
                    $save_fields=$PayrollfieldsModel->save($pr_data);
                } 
            }
            //////////////////// Default salary rules /////////////////

            

        }
                
        
    }

     public function basic_salary()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $SalaryTable= new SalaryTable;

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

           

            // $user_data = attendance_allowed_list(company($myid));
            $user_data=$UserModel->where('company_id',company($myid))->where('u_type!=', 'vendor')->where('u_type!=', 'customer')->where('u_type!=', 'student')->where("deleted", 0)->orderBy('id','DESC')->paginate(25);


            $data=[
                'title'=>'Payroll - Aitsun ERP',
                'user'=>$user,
                'user_data'=>$user_data
            ];
            echo view('header',$data);
            echo view('payroll/basic_salary_table');
            echo view('footer');

        }else{
            return redirect()->to(base_url());
        }
                
        
    }




    public function add_basic_salary(){
        $session=session();
        $user=new Main_item_party_table();
        $SalaryTable=new SalaryTable();
        $myid=session()->get('id');

        
        if ($this->request->getMethod() == 'post') {
           
            if ($this->request->getVar('month')) {

                $ac_data = [
                    'company_id'=>company($myid),
                    'month'=>$this->request->getVar('month'),
                    'basic_salary'=>$this->request->getVar('basic_salary'),
                    'employee_id'=>$this->request->getVar('employee_id'),
                ];
                
                    $checkexits=$SalaryTable->where('company_id',company($myid))->where('employee_id',$this->request->getVar('employee_id'))->where('MONTH(month)',get_date_format($this->request->getVar('month'),'m'))->where('YEAR(month)',get_date_format($this->request->getVar('month'),'Y'))->where('deleted',0)->first();

                    if ($checkexits) {
                        $items_price=$SalaryTable->update($checkexits['id'],$ac_data);
                    }else{
                    $items_price=$SalaryTable->save($ac_data);
                }
                

                if ($items_price) {
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }
    }


    public function create_payroll()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $PayrollModel= new PayrollModel;
        $SalaryTable= new SalaryTable;

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }
 
            $datee=now_time($myid);
            
            if ($_GET) {
                if (isset($_GET['attend_date'])) {
                    if (!empty($_GET['attend_date'])) {
                        $datee=$_GET['attend_date'];
                    }
                }
            }
 

            $monthly_salary=$SalaryTable->where('company_id',company($myid))->where('deleted',0)->where('MONTH(month)',get_date_format($datee,'m'))->where('YEAR(month)',get_date_format($datee,'Y'))->findAll();

            $monthly_salary_count=$SalaryTable->where('company_id',company($myid))->where('deleted',0)->where('MONTH(month)',get_date_format($datee,'m'))->where('YEAR(month)',get_date_format($datee,'Y'))->countAllResults();

            $payroll_data=$PayrollModel->where('company_id',company($myid))->where('deleted',0)->first();


            $data=[
                'title'=>'Payroll - Aitsun ERP',
                'user'=>$user,
                'monthly_salary'=>$monthly_salary,
                'monthly_salary_count'=>$monthly_salary_count,
                'payroll_data'=>$payroll_data
            ];
            echo view('header',$data);
            echo view('payroll/create_payroll');
            echo view('footer');

        }else{
            return redirect()->to(base_url());
        }
                
        
    }

    public function add_payroll(){

         $session=session();
         $UserModel=new Main_item_party_table;
         $PayrollModel= new PayrollModel;
         $PayrollitemsModel= new PayrollitemsModel;
         $SalarySlipItemsModel= new SalarySlipItemsModel;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

               if ($this->request->getMethod()=='post') {


                 $pr_data = [
                    'company_id'=>company($myid),
                    'month'=>$this->request->getVar('month'),
                    'total_salary'=>$this->request->getVar('total_salary'),
                    'created_at'=>now_time($myid),
                    'payment_type'=>$this->request->getVar('type'),
                ];

                $save_payroll=$PayrollModel->save($pr_data);
                $payroll_id=$PayrollModel->insertID();

                if ($save_payroll) {

                 foreach ($this->request->getVar('employee_id') as $i => $value) {
                       $employee_id=$this->request->getVar('employee_id')[$i];
                        $pritm_data = [
                            'company_id'=>company($myid),
                            'payroll_id'=>$payroll_id,
                            'employee_id'=>$employee_id,
                            'basic_salary'=>$this->request->getVar('basic_salary')[$i],
                            'nod'=>$this->request->getVar('nod')[$i], 
                            'present_days'=>$this->request->getVar('present_days')[$i],  
                            'extra_leave'=>$this->request->getVar('extra_leave')[$i],
                            'gross_salary'=>$this->request->getVar('gross_salary')[$i],  
                            'net_salary'=>$this->request->getVar('net_salary')[$i],
                            'formula'=>$this->request->getVar('formula')[$i],
                            'type'=>$this->request->getVar('type'),
                        ]; 

                        $PayrollitemsModel->save($pritm_data);
                        $payroll_items_id=$PayrollitemsModel->insertID();

                            if ($this->request->getVar($employee_id.'salary_item_id')) {
                                foreach ($this->request->getVar($employee_id.'salary_item_id') as $j => $value) { 

                                    $salitems_data = [ 
                                        'payroll_items_id'=>$payroll_items_id,
                                        'payroll_field_id'=>$this->request->getVar($employee_id.'salary_item_id')[$j],
                                        'payroll_calculation'=>$this->request->getVar($employee_id.'salary_item_calculation')[$j],
                                        'payroll_amount_type'=>$this->request->getVar($employee_id.'salary_item_amount_type')[$j], 
                                        'percentage'=>$this->request->getVar($employee_id.'salary_item_percentage')[$j],
                                        'amount'=>$this->request->getVar($employee_id.'salary_item_amount')[$j],
                                        'total_amount'=>$this->request->getVar($employee_id.'salary_item_amount')[$j],
                                        'formula'=>$this->request->getVar($employee_id.'formula')[$j],
                                        'field_name'=>$this->request->getVar($employee_id.'field_name')[$j],
                                        'type'=>$this->request->getVar('type'),

                                    ];
                                    $SalarySlipItemsModel->save($salitems_data);

                                }
                            }
                            
                    }
                    
                 $session->setFlashdata('pu_msg','Saved!');
                 return redirect()->to(base_url('payroll/edit/'.$payroll_id));
                }

               }

            }else{
                return redirect()->to(base_url('users/login'));
            }
    }


    public function edit($pid="")
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $PayrollModel= new PayrollModel;
        $PayrollitemsModel= new PayrollitemsModel;

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $payroll_items=$PayrollitemsModel->where('company_id',company($myid))->where('deleted',0)->where('payroll_id',$pid)->findAll();

            $payroll_data=$PayrollModel->where('company_id',company($myid))->where('deleted',0)->where('id',$pid)->first();

            if ($payroll_data) {
                $data=[
                    'title'=>'Payroll - Aitsun ERP',
                    'user'=>$user,
                    'payroll_items'=>$payroll_items,
                    'payroll_data'=>$payroll_data
                ];
                echo view('header',$data);
                echo view('payroll/edit');
                echo view('footer');
            }else{
                 return redirect()->to(base_url('payroll'));
            }
            

        }else{
            return redirect()->to(base_url());
        }
                
        
    }

    
    public function view_payroll_slip($pid="")
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $PayrollModel= new PayrollModel;
        $PayrollitemsModel= new PayrollitemsModel;

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $payroll_items=$PayrollitemsModel->where('company_id',company($myid))->where('deleted',0)->where('payroll_id',$pid)->findAll();

            $payroll_data=$PayrollModel->where('company_id',company($myid))->where('deleted',0)->where('id',$pid)->first();


            $data=[
                'title'=>'Payroll - Aitsun ERP',
                'user'=>$user,
                'payroll_items'=>$payroll_items,
                'payroll_data'=>$payroll_data
            ];
            echo view('header',$data);
            echo view('payroll/view_payroll_slip');
            echo view('footer');

        }else{
            return redirect()->to(base_url());
        }
                
        
    }



    public function edit_payroll($pid=""){ 
            $session=session();
         $UserModel=new Main_item_party_table;
         $PayrollModel= new PayrollModel;
         $PayrollitemsModel= new PayrollitemsModel;
         $SalarySlipItemsModel= new SalarySlipItemsModel;

            if ($session->has('isLoggedIn')){

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

               if ($this->request->getMethod()=='post') {


                 $pr_data = [
                    'company_id'=>company($myid),
                    'month'=>$this->request->getVar('month'),
                    'total_salary'=>$this->request->getVar('total_salary'),
                    'created_at'=>now_time($myid)
                ];

                $save_payroll=$PayrollModel->update($pid,$pr_data);
                $payroll_id=$pid;

                if ($save_payroll) {

                 foreach ($this->request->getVar('employee_id') as $i => $value) {
                       $employee_id=$this->request->getVar('employee_id')[$i];
                       $p_items_id=$this->request->getVar('p_items_id')[$i];

                        $pritm_data = [
                            'company_id'=>company($myid),
                            'payroll_id'=>$payroll_id,
                            'employee_id'=>$employee_id,
                            'basic_salary'=>$this->request->getVar('basic_salary')[$i],
                            'nod'=>$this->request->getVar('nod')[$i], 
                            'present_days'=>$this->request->getVar('present_days')[$i],  
                            'extra_leave'=>$this->request->getVar('extra_leave')[$i],
                            'gross_salary'=>$this->request->getVar('gross_salary')[$i],
                            
                            'net_salary'=>$this->request->getVar('net_salary')[$i],
                            'formula'=>$this->request->getVar('formula')[$i],
                            'edit_effected'=>0,
                            'old_total'=>get_payroll_data($p_items_id,'net_salary'),
                        ]; 

                        $PayrollitemsModel->update($p_items_id,$pritm_data);
                        $payroll_items_id=$p_items_id;

                        if ($this->request->getVar($p_items_id.'salary_item_id')) {
                            foreach ($this->request->getVar($p_items_id.'salary_item_id') as $j => $value) { 

                                $sl_id=$this->request->getVar($p_items_id.'salary_item_id')[$j];

                                $salitems_data = [ 
                                    'payroll_items_id'=>$p_items_id, 
                                    'payroll_calculation'=>$this->request->getVar($p_items_id.'salary_item_calculation')[$j],
                                    'payroll_amount_type'=>$this->request->getVar($p_items_id.'salary_item_amount_type')[$j], 
                                    'percentage'=>$this->request->getVar($p_items_id.'salary_item_percentage')[$j],
                                    'amount'=>$this->request->getVar($p_items_id.'salary_item_amount')[$j],
                                    'total_amount'=>$this->request->getVar($p_items_id.'salary_item_amount')[$j],
                                    'formula'=>$this->request->getVar($p_items_id.'formula')[$j],
                                    'field_name'=>$this->request->getVar($p_items_id.'field_name')[$j],

                                ];
                                $SalarySlipItemsModel->update($sl_id,$salitems_data);

                                // echo 'salitem -'.$sl_id.'<br>';

                            }
                        }
                            

                            // echo 'Pitem -'.$p_items_id.'<br>';
                    }


                    
                 $session->setFlashdata('pu_msg','Saved!');
                 return redirect()->to(base_url('payroll/edit/'.$pid));
                }

               }

            }else{
                return redirect()->to(base_url('users/login'));
            }
    }

    public function delete_payroll($pid=0)
    {
        
        
         $PayrollModel= new PayrollModel;
         $PayrollitemsModel= new PayrollitemsModel;
         $session = session();
         if ($session->has('isLoggedIn')){

        if ($this->request->getMethod() == 'get') {
                $PayrollModel->find($pid);
                $deledata=[
                    'deleted'=>1
                ];
                $PayrollModel->update($pid,$deledata);
                $payroll_id =$PayrollitemsModel->where('payroll_id',$pid)->findAll();

                foreach ($payroll_id as $prid) {
                    $PayrollitemsModel->find($prid['id']);

                    $ptimdata=[
                        'deleted'=>1,
                        'edit_effected'=>0,
                    ];

                    $PayrollitemsModel->update($prid['id'],$ptimdata);
                }
                

                
                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('payroll'));

        }else{
            return redirect()->to(base_url('users/login'));
        }

        }else{
            return redirect()->to(base_url());
        }

    } 


    public function settings()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $PayrollfieldsModel= new PayrollfieldsModel();

        if ($session->has('isLoggedIn')){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

            if (usertype($myid)=='customer') {
                return redirect()->to(base_url('customer_dashboard'));
            }

            $payroll_fields=$PayrollfieldsModel->where('company_id',company($myid))->where('deleted',0)->orderBy('orderby','asc')->findAll();



            $data=[
                'title'=>'Payroll Settings - Aitsun ERP',
                'user'=>$user,
                'payroll_fields'=>$payroll_fields, 
            ];
            echo view('header',$data);
            echo view('payroll/settings');
            echo view('footer');

        }else{
            return redirect()->to(base_url());
        }
    }


    public function save_formula($fid){
        $session=session();
        $myid=session()->get('id');
        $PayrollfieldsModel= new PayrollfieldsModel();

        if ($session->has('isLoggedIn')){

            if ($this->request->getMethod()=='post') {
                $formula=htmlentities($this->request->getVar('formula'));
 
                $pr_data = [ 
                    'formula'=>trim($formula)
                ];
                $save_fields=$PayrollfieldsModel->update($fid,$pr_data);

                if($save_fields) {
                     echo 1;
                }else{
                    echo 0;
                } 
            }

        }else{
            echo 0;
        }
    }

    public function save_field_order(){
        $session=session();
        $myid=session()->get('id');
        $PayrollfieldsModel= new PayrollfieldsModel();

        if ($session->has('isLoggedIn')){

            if ($this->request->getMethod()=='post') {
                $allData=$_POST['allData'];
                
                $i = 1;
                foreach ($allData as $sss) {
                    if (!empty($sss)) {
                        $pr_data = [ 
                            'orderby'=>$i
                        ];  
                        $save_fields=$PayrollfieldsModel->update($sss,$pr_data);
                        if ($save_fields) {
                            $i++;
                        }

                    } 
                }
                
            }

        }else{
            echo 0;
        }
    }


    public function add_payroll_fields(){

         $session=session();
         $myid=session()->get('id');
         $PayrollfieldsModel= new PayrollfieldsModel();

        if ($session->has('isLoggedIn')){

           if ($this->request->getMethod()=='post') {
            $fname=strip_tags($this->request->getVar('field_name'));
            $amount_type=strip_tags($this->request->getVar('amount_type'));

            $rules_exist=$PayrollfieldsModel->where('company_id',company($myid))->where('deleted',0)->where('field_name',$fname)->first();
                

            if (!$rules_exist) {
                $pr_data = [
                    'company_id'=>company($myid),
                    'amount_type'=>$amount_type,
                    'field_name'=>$fname
                ];
                $save_fields=$PayrollfieldsModel->save($pr_data);

                if($save_fields) {
                     $session->setFlashdata('pu_msg','Saved!');
                     return redirect()->to(base_url('payroll/settings'));
                }
            }else{

                $session->setFlashdata('pu_er_msg','<b>'.$fname.'</b> is already exist!');
                return redirect()->to(base_url('payroll/settings'));
            }
            }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function edit_payroll_fields($prfid=""){

         $session=session();
         $myid=session()->get('id');
         $PayrollfieldsModel= new PayrollfieldsModel();

        if ($session->has('isLoggedIn')){

           if ($this->request->getMethod()=='post') {
            $amount_type=strip_tags($this->request->getVar('amount_type'));

             $pr_data = [
                'field_name'=>strip_tags($this->request->getVar('field_name')), 
                'amount_type'=>$amount_type,
            ];
            $save_fields=$PayrollfieldsModel->update($prfid,$pr_data);

            if($save_fields) {
                 $session->setFlashdata('pu_msg','Saved!');
                 return redirect()->to(base_url('payroll/settings'));
            }

           }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    } 

     public function delete_payroll_fields($pid=0)
    {
        
        $session = session();
        $PayrollfieldsModel= new PayrollfieldsModel;
         if ($session->has('isLoggedIn')){

        if ($this->request->getMethod() == 'get') {
                $PayrollfieldsModel->find($pid);
                $deledata=[
                    'deleted'=>1
                ];
                $PayrollfieldsModel->update($pid,$deledata);

                
                $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('payroll/settings'));

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }else{
            return redirect()->to(base_url());
        }

    }


    public function employee_details($cusval=''){
        if (!empty($cusval)) {
                    $session=session();
        $UserModel=new Main_item_party_table;
        $PaymentsModel=new PaymentsModel;
        $CustomerBalances=new CustomerBalances;
        $InvoiceModel=new InvoiceModel;

        if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $con = array( 
                        'id' => session()->get('id') 
                    );

                    if (app_status(company($myid))==0) {redirect(base_url('app_error'));}

                    
                    if (check_permission($myid,'manage_parties')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
                    $query=$UserModel->where('id',$myid)->first();

                     $acti=activated_year(company($myid));

                    
                    $PaymentsModel->orderBy("id", "desc");
                    $get_cust = $UserModel->where('id',$cusval)->first();
                    $allpayments = $PaymentsModel->where('customer',$cusval);
                        

                    $InvoiceModel->where('company_id',company($myid));
                        
                    $InvoiceModel->where("(customer='$cusval' AND invoice_type='sales' OR invoice_type='sales_order' OR invoice_type='sales_return' OR invoice_type='sales_quotation')", NULL, FALSE);
                    $InvoiceModel->orderBy('id','desc');
                    
                    $InvoiceModel->where('deleted',0);
                   

                    $data = [
                        'title' => 'Aitsun ERP-Customers',
                        'user'=>$query,
                        'cust'=> $get_cust,
                        'all_invoices'=>$InvoiceModel->where('customer',$cusval)->findAll(),
                        'allpayments' => $allpayments->findAll(),
                        'data_count'=>$InvoiceModel->countAllResults(),
                        'pay_count'=>$allpayments->countAllResults()
                    ];

                    if (isset($_POST['edit_customer'])) {

                        $word=strtolower(strip_tags(trim($this->request->getVar('email'))));

                        $customer_data = [ 
                                'pan'=>strip_tags($this->request->getVar('pan')),
                                'adhar'=>strip_tags($this->request->getVar('adhar')),
                                'bank_name'=>strip_tags($this->request->getVar('bank_name')),
                                'ifsc'=>strip_tags($this->request->getVar('ifsc')),
                                'account_number'=>strip_tags($this->request->getVar('account_number')),
                                'pf_no'=>strip_tags($this->request->getVar('pf_no')),
                                'esi_no'=>strip_tags($this->request->getVar('esi_no')),
                                'designation'=>strip_tags($this->request->getVar('designation')),
                            ];


                            $insert_user=$UserModel->update($cusval,$customer_data);

                            if ($insert_user) { 

                                ////////////////////////CREATE ACTIVITY LOG//////////////
                                $log_data=[
                                    'user_id'=>$myid,
                                    'action'=>'Employee <b>'.user_name($cusval).'</b>`s details updated.',
                                    'ip'=>get_client_ip(),
                                    'mac'=>GetMAC(),
                                    'created_at'=>now_time($myid),
                                    'updated_at'=>now_time($myid),
                                    'company_id'=>company($myid),
                                ];

                                add_log($log_data);
                                ////////////////////////END ACTIVITY LOG/////////////////
                                    $session->setFlashdata('pu_msg', 'Saved!');
                                    return redirect()->to(current_url());
                                }else{
                                    $session->setFlashdata('pu_er_msg', 'Failed to save!');
                                    return redirect()->to(current_url());
                                } 
                      
                    }
                        

                        

                        

                    

                        echo view('header',$data);
                        echo view('payroll/employee_details', $data);
                        echo view('footer');

                }else{
                    return redirect()->to(base_url('users/login'));
                }
        }else{
            return redirect()->to(base_url());
        }
    }  



    public function view_salary_slip($cusval=""){
            
            $session=session();
            $UserModel=new Main_item_party_table;
            $PayrollitemsModel=new PayrollitemsModel;
            $PayrollModel=new PayrollModel;

                if ($session->has('isLoggedIn')){

                    $myid=session()->get('id');
                    $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   

                    
                    
                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    $erqry = $PayrollitemsModel->where('id',$cusval)->first(); 
                    $prqry = $PayrollModel->where('id',$erqry['payroll_id'])->first();
                        
                    $data = [
                        'title' => 'Aitsun ERP-Payments Receipt',
                        'user'=>$user,
                        'payroll_data'=>$prqry, 
                        'pmt' => $erqry  
                    ];

                    echo view('header',$data);
                    echo view('payroll/view_salary_slip', $data);
                    echo view('footer');

            }else{
                return redirect()->to(base_url('users/login'));
            }
    
    }




public function get_payroll_slip($pid='',$type='view')
    {
        if (!empty($pid)) {
            $session=session();
            $UserModel=new Main_item_party_table;
            $PayrollModel= new PayrollModel;
            $PayrollitemsModel= new PayrollitemsModel;
            
            if ($session->has('isLoggedIn')) {
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   



                    $payroll_items=$PayrollitemsModel->where('company_id',company($myid))->where('deleted',0)->where('payroll_id',$pid)->findAll();

                    $payroll_data=$PayrollModel->where('company_id',company($myid))->where('deleted',0)->where('id',$pid)->first();

                        $filename="uknown file.pdf";
              


                    $filename='Payroll slip for the month '.get_date_format($payroll_data['month'],'M Y').'.pdf';

                       $data=[
                        'title'=>$filename,
                        'user'=>$user,
                        'payroll_items'=>$payroll_items,
                        'payroll_data'=>$payroll_data
                    ];  
                   
              $dompdf = new \Dompdf\Dompdf();
              $dompdf->set_option('isJavascriptEnabled', TRUE);
              $dompdf->set_option('isRemoteEnabled', TRUE); 

              $dompdf->loadHtml(view('payroll/templates/payroll_slip_design',$data));
              $dompdf->setPaper('A4', 'portrait');
              $dompdf->render();

              if ($type=='download') {
                $dompdf->stream($filename, array("Attachment" => true));
              }else{
                $dompdf->stream($filename, array("Attachment" => false));
              }
                    
                     exit();
                
            }else{
                return redirect()->to(base_url('users'));
            }   
        }else{
            return redirect()->to(base_url());
        }
            
    }

    public function view_salary_slip_design($pid="",$type="view"){
            
            if (!empty($pid)) {
                $session=session();
                $UserModel=new Main_item_party_table;
                $PayrollModel= new PayrollModel;
                $PayrollitemsModel= new PayrollitemsModel;
                
               


                      
                   $pmt = $PayrollitemsModel->where('id',$pid)->first(); 
                    $prqry = $PayrollModel->where('id',$pmt['payroll_id'])->first();

                        $filename="uknown file.pdf";
              


                    $filename=user_name($pmt['employee_id']).'- Payment slip for the month of '.get_date_format($prqry['month'],'F Y').'.pdf';

                        $data = [
                            'title' => $filename, 
                            'payroll_data'=>$prqry, 
                            'pmt' => $pmt  
                        ]; 
                   
              $dompdf = new \Dompdf\Dompdf();
              $dompdf->set_option('isJavascriptEnabled', TRUE);
              $dompdf->set_option('isRemoteEnabled', TRUE); 

              $dompdf->loadHtml(view('payroll/templates/salary_slip_design',$data));
              $dompdf->setPaper('A4', 'portrait');
              $dompdf->render();

              if ($type=='download') {
                $dompdf->stream($filename, array("Attachment" => true));
              }else{
                $dompdf->stream($filename, array("Attachment" => false));
              }
                    
                     exit();
                
              
        } 
           
    }


public function get_salary_slip($cusval='',$type='view')
    {
        if (!empty($cusval)) {
            $session=session();
            $UserModel=new Main_item_party_table;
            $PayrollModel= new PayrollModel;
            $PayrollitemsModel= new PayrollitemsModel;
            
            if ($session->has('isLoggedIn')) {
                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                   



                   $pmt = $PayrollitemsModel->where('id',$cusval)->first(); 
                    $prqry = $PayrollModel->where('id',$pmt['payroll_id'])->first();

                        $filename="uknown file.pdf";
              


                    $filename=user_name($pmt['employee_id']).'- Payment slip for the month of '.get_date_format($prqry['month'],'F Y').'.pdf';

                        $data = [
                            'title' => $filename,
                            'user'=>$user,
                            'payroll_data'=>$prqry, 
                            'pmt' => $pmt  
                        ]; 
                   
              $dompdf = new \Dompdf\Dompdf();
              $dompdf->set_option('isJavascriptEnabled', TRUE);
              $dompdf->set_option('isRemoteEnabled', TRUE); 

              $dompdf->loadHtml(view('payroll/templates/salary_slip_design',$data));
              $dompdf->setPaper('A4', 'portrait');
              $dompdf->render();

              if ($type=='download') {
                $dompdf->stream($filename, array("Attachment" => true));
              }else{
                $dompdf->stream($filename, array("Attachment" => false));
              }
                    
                     exit();
                
            }else{
                return redirect()->to(base_url('users'));
            }   
        }else{
            return redirect()->to(base_url());
        }
            
    }


    public function save_manual_payroll_field_values(){
        $session=session();
        $myid=session()->get('id');
        $ManualPayrollFieldValues= new ManualPayrollFieldValues();

        if ($session->has('isLoggedIn')){

            if ($this->request->getMethod()=='post') {
        
                // $pr_data = [  
                //     'company_id'=>company($myid),
                //     'month_details'=>strip_tags($this->request->getVar('month_details')),
                //     'salary_id'=>strip_tags($this->request->getVar('salary_id')),
                //     'employee_id'=>strip_tags($this->request->getVar('employee_id')),
                //     'field_id'=>strip_tags($this->request->getVar('field_id')),
                //     'manual_value'=>strip_tags($this->request->getVar('manual_value')),

                // ];
                $month_det=strip_tags($this->request->getVar('month_details'));
                $result_o=1;
                foreach ($this->request->getVar('manual_value') as $key => $value) {

                    $var_salary_id=strip_tags($this->request->getVar('salary_id')[$key]);
                    $var_employee_id=strip_tags($this->request->getVar('employee_id')[$key]);
                    $var_field_id=strip_tags($this->request->getVar('field_id')[$key]);

                    $pr_data = [  
                        'company_id'=>company($myid),
                        'month_details'=>$month_det,
                        'salary_id'=>$var_salary_id,
                        'employee_id'=>$var_employee_id,
                        'field_id'=>$var_field_id,
                        'manual_value'=>strip_tags($this->request->getVar('manual_value')[$key]),

                    ];

                    $checkexistman=$ManualPayrollFieldValues->where('MONTH(month_details)',get_date_format($month_det,'m'))->where('YEAR(month_details)',get_date_format($month_det,'Y'))->where('employee_id',$var_employee_id)->where('field_id',$var_field_id)->first();

                    if ($checkexistman) {
                        $update_field=$ManualPayrollFieldValues->update($checkexistman['id'],$pr_data);

                        if($update_field) {
                            $result_o=1;
                        }else{
                            $result_o=0;
                        } 
                    }else{
                        $save_fields=$ManualPayrollFieldValues->save($pr_data);

                        if($save_fields) {
                            $result_o=1;
                        }else{
                            $result_o=0;
                        } 
                    }

                    
                }

               echo $result_o;



            }

        }else{
            echo 0;
        }
    }


}