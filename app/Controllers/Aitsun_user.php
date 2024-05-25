<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;

class Aitsun_user extends BaseController
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
            echo view('aitsun_keys/user_details');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
        }
    }
}