<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;

class Aitsun_share extends BaseController
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
 
            $data=[
                'title'=>'Manage User',
                'user'=>$user,
                
            ];

            echo view('header',$data);
            echo view('share');
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }


    public function get_form(){
        $session=session(); 
        if ($session->has('isLoggedIn')){ 
            if ($this->request->getMethod() == 'post') {  

                $data=[
                    'to'=>$this->request->getVar('to'),
                    'subject'=>$this->request->getVar('subject'),
                    'message'=>$this->request->getVar('message'),
                ];

                if ($this->request->getVar('share_type')=='email') {
                    echo view('aitsun_share/email_form',$data);
                }elseif ($this->request->getVar('share_type')=='sms') {
                    echo view('aitsun_share/sms_form',$data);
                }elseif ($this->request->getVar('share_type')=='whatsapp') {
                    echo view('aitsun_share/whatsapp_form',$data);
                }else{
                    echo 'no-data';
                } 
                
            }
        }
    }
}