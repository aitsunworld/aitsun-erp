<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
 
class Cheque_management extends BaseController {
  public function index()
  {
    $session=session();
    $user=new Main_item_party_table();

    $myid=session()->get('id');
    
    if ($session->has('isLoggedIn')) {
      $usaerdata=$user->where('id', session()->get('id'))->first();
        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));} 

        $data=[
           'title'=>'Cheque Management | Aitsun ERP',
           'user'=>$usaerdata, 
        ];
        $etype='';

        echo view('header',$data);
        echo view('cheque-management/cheque_index');
        echo view('footer');
               
    }else{
      return redirect()->to(base_url('users'));
    }   
  }
}