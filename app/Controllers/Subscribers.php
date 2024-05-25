<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\SubscribersModel;


class Subscribers extends BaseController
{
    public function index()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $SubscribersModel = new SubscribersModel();

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_appearance')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
           
            $user_data=$SubscribersModel->findAll();
            $data=[
                'title'=>'Manage',
                'user'=>$user,
                'user_data'=>$user_data,
            ];

            echo view('header',$data);
            echo view('subscribers/subscribers');
            echo view('footer');

        }else{
                return redirect()->to(base_url('users/login'));
            }
    }
    public function send_bulk_mail()
    {
        $UserModel=new Main_item_party_table();
        $SubscribersModel = new SubscribersModel();

        $myid=session()->get('id');

        $user=$UserModel->where('id',$myid)->first();

        // var_dump($_POST);
       

        $offer_subject=strip_tags($_GET['offer_subject']);
        $offer_message=$_GET['smessages'];

        foreach ($_GET['subid'] as $i => $value) {

           
                $subid=$_GET['subid'][$i];
                $email=$_GET['cb'][$i];

                $to=$email;
                $subject=$offer_subject;
                $message=$offer_message;
                        
                $attached='';


               
                if (unique_send_email(company($myid),$to,$subject,$message,$attached)) {
                    echo '<div class="alert border-0 border-start border-5 border-success bg-light-success alert-dismissible fade show">
                            <div>Sent to <b>'.$email.'</b></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }else{
                    echo '<div class="alert border-0 border-start border-5 border-danger bg-light-danger alert-dismissible fade show">
                            <div>Sending failed to <b>'.$email.'</b></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }



        }  
    }
}