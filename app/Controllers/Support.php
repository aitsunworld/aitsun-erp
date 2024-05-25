<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\SubscribersModel;

class Support extends BaseController
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

           

            $data=[
                'title'=>'Support Center',
                'user'=>$user,
            ];

            echo view('header',$data);
            echo view('support/support');
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }
}