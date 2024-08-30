<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ChequeDepartmentsModel;
use App\Models\ChequesModel;


 


class Cheque_management extends BaseController {

 
  public function index()
     {
        $session=session();
        $user=new Main_item_party_table();
        $ChequesModel=new ChequesModel();
    
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
          $usaerdata=$user->where('id', session()->get('id'))->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));} 
            $department = $this->request->getGet('department');
            $status = $this->request->getGet('status');

            $cheque_data = $ChequesModel->where('company_id', company($myid))
                                        ->where('deleted', 0);

            if (!empty($department) && $department != 'all') {
                $cheque_data->where('cheque_department', $department);
            }

             if (!empty($status)) {
                if ($status === 'pending') {
                    $cheque_data->where('status', 'pending'); // Assuming 0 represents 'pending'
                } elseif ($status === 'cleared') {
                    $cheque_data->where('status', 'cleared'); // Assuming 1 represents 'cleared'
                }elseif ($status === 'bounced') {
                    $cheque_data->where('status', 'bounced'); // Assuming 1 represents 'cleared'
                }elseif ($status === 'cancelled') {
                    $cheque_data->where('status', 'cancelled'); // Assuming 1 represents 'cleared'
                }
            }


            if ($_GET) { 
 
                if (isset($_GET['cheque_no'])) {
                    if (!empty($_GET['cheque_no'])) {
                        $cheque_data->where('cheque_no',$_GET['cheque_no']);
                    }
                }
 
     

                if (isset($_GET['cheque_title'])) {
                    if (!empty($_GET['cheque_title'])) {
                        $cheque_data->like('cheque_title',$_GET['cheque_title'],'both');
                    }
                } 

                if (isset($_GET['cheque_category'])) {
                    if ($_GET['cheque_category']!='') {
                        $cheque_data->where('cheque_category',$_GET['cheque_category'],'both');
                    }
                } 

                if (isset($_GET['from']) && isset($_GET['to'])) {
                    $from=$_GET['from'];
                    $dto=$_GET['to'];

                    if (!empty($from) && empty($dto)) {
                        $cheque_data->where('cheque_date',$from);
                    }
                    if (!empty($dto) && empty($from)) {
                        $cheque_data->where('cheque_date',$dto);
                    }

                    if (!empty($dto) && !empty($from)) {
                        $cheque_data->where("cheque_date BETWEEN '$from' AND '$dto'");
                    }
 
                } 

            }

            $cheque_data = $cheque_data->orderBy('cheque_date','asc')->findAll();
            $data=[
               'title'=>'Cheque Management | Aitsun ERP',
               'user'=>$usaerdata, 
               'cheque_data'=>$cheque_data
            ];

                
            echo view('header',$data);
            echo view('cheque-management/cheque_index');
            echo view('footer');
                
    
                
        
      }else{
        return redirect()->to(base_url('users'));
      }   
  }

  public function department()
     {
        $session=session();
        $user=new Main_item_party_table();
        $ChequeDepartmentsModel= new ChequeDepartmentsModel();
    
        $myid=session()->get('id');
        
        if ($session->has('isLoggedIn')) {
          $usaerdata=$user->where('id', session()->get('id'))->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));} 

            $cheque_department=$ChequeDepartmentsModel->where('company_id',company($myid))->where('deleted',0)->findAll();
            $data=[
               'title'=>'Cheque Department | Aitsun ERP',
               'user'=>$usaerdata,
               'cheque_department'=>$cheque_department 
            ];

                
            echo view('header',$data);
            echo view('cheque-management/department');
            echo view('footer');
                
    
                
        
      }else{
        return redirect()->to(base_url('users'));
      }   
  }


  public function add_cheque_department() {
        if ($this->request->getMethod() == 'post') {
            $myid = session()->get('id');
            $ChequeDepartmentsModel = new ChequeDepartmentsModel();

            $chequedepartment_data = [
                'company_id' => company($myid),
                'department_name' => strip_tags($this->request->getVar('department_name')),
                'bank_id' => strip_tags($this->request->getVar('bank')),
                'responsible_person' => strip_tags($this->request->getVar('responsible_person')),
            ];

                if ($ChequeDepartmentsModel->save($chequedepartment_data)) {
                    echo 1; 
                }else {
                    echo 0; 
                }
            }
      } 

  public function update_department($chid="") {
      if ($this->request->getMethod() == 'post') {
          $myid = session()->get('id');
          $ChequeDepartmentsModel = new ChequeDepartmentsModel();

          $chequedepartment_data = [
              'department_name' => strip_tags($this->request->getVar('department_name')),
              'bank_id' => strip_tags($this->request->getVar('bank')),
              'responsible_person' => strip_tags($this->request->getVar('responsible_person')),
          ];

              if ($ChequeDepartmentsModel->update($chid,$chequedepartment_data)) {
                  echo 1; 
              }else {
                  echo 0; 
              }
          }
      } 

  public function delete_department($cdid=0)
  {
    $ChequeDepartmentsModel = new ChequeDepartmentsModel();
    $myid=session()->get('id');
    

    if ($this->request->getMethod() == 'post') {
        $deledata=[
                    'deleted'=>1,
                ];

        $ChequeDepartmentsModel->update($cdid,$deledata);
        echo 1;


        
    }else{
        return redirect()->to(base_url('cheque-management/department'));
    }

  }

  public function add_cheque() {
        if ($this->request->getMethod() == 'post') {
            $myid = session()->get('id');
            $ChequesModel = new ChequesModel();

            $cheque_data = [
                'company_id' => company($myid),
                'cheque_no' => strip_tags($this->request->getVar('cheque_no')),
                'cheque_date' => strip_tags($this->request->getVar('cheque_date')),
                'cheque_department' => strip_tags($this->request->getVar('cheque_department')),
                'cheque_title' => strip_tags($this->request->getVar('cheque_title')),
                'cheque_customer' => strip_tags($this->request->getVar('cheque_customer')),
                'amount' => strip_tags($this->request->getVar('amount')),
                'status' => strip_tags($this->request->getVar('remarks')),
                'cheque_category' => strip_tags($this->request->getVar('cheque_category')),
                'cheque_note' => trim(strip_tags($this->request->getVar('cheque_note'))),  
                'created_date'=>now_time($myid),
                'added_by'=>$myid
            ];

                if ($ChequesModel->save($cheque_data)) {
                    echo 1; 
                }else {
                    echo 0; 
                }
            }
  }

  public function update_cheque($chid="") {
      if ($this->request->getMethod() == 'post') {
          $myid = session()->get('id');
          $ChequesModel = new ChequesModel();

            $cheque_data = [
                'cheque_no' => strip_tags($this->request->getVar('cheque_no')),
                'cheque_date' => strip_tags($this->request->getVar('cheque_date')),
                'cheque_department' => strip_tags($this->request->getVar('cheque_department')),
                'cheque_title' => strip_tags($this->request->getVar('cheque_title')),
                'cheque_customer' => strip_tags($this->request->getVar('cheque_customer')),
                'amount' => strip_tags($this->request->getVar('amount')),
                'status' => strip_tags($this->request->getVar('remarks')), 
                'cheque_category' => strip_tags($this->request->getVar('cheque_category')),
                'cheque_note' => trim(strip_tags($this->request->getVar('cheque_note'))),  
            ];

              if ($ChequesModel->update($chid,$cheque_data)) {
                  echo 1; 
              }else {
                  echo 0; 
              }
          }
      }

  public function delete_cheque($cdid=0)
  {
    $ChequesModel = new ChequesModel();
    $myid=session()->get('id');
    

    if ($this->request->getMethod() == 'post') {
        $deledata=[
                    'deleted'=>1,
                ];

        $ChequesModel->update($cdid,$deledata);
        echo 1;


        
    }else{
        return redirect()->to(base_url('cheque-management'));
    }

  } 


  public function confirm_cheque($cheque_id=0,$cheque_value=0){
    $session=session();
    if($session->has('isLoggedIn')){
        $UserModel= new Main_item_party_table;
        $ChequesModel= new ChequesModel();
        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();
        if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
                 
            $cheque_data = [ 
                'id' => $cheque_id,  
                'status' => $cheque_value,
            ];

            if ($ChequesModel->save($cheque_data)) {
                echo 1;
            }else{
                echo 0;
            }
        
    }else{
        echo 0;
    }  
}
   

}