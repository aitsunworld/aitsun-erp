<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OffersModel;



class Offers extends BaseController
{
    public function index()
    {
        $UserModel = new Main_item_party_table();
        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $user=$UserModel->where('id',$myid)->first();

        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        
        if (check_permission($myid,'manage_appearance')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        $data=[
            'title'=>'Aitsun ERP-Offers',
            'user'=> $UserModel->where('id', session()->get('id'))->first(),
        ];

        $session=session();

        if ($session->has('isLoggedIn')){ 
            echo view('header',$data);
            echo view('offers/offers',$data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users'));
        }
        
    }
     public function save_offer_image(){

        $OffersModel= new OffersModel();

        $myid=session()->get('id');

        if (isset($_POST['save_offer'])) {

            $target_dir = "public/images/offers/";
            $target_file = $target_dir . time().basename($_FILES["offerimage"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imgName = time().basename($_FILES["offerimage"]["name"]);
            move_uploaded_file($_FILES["offerimage"]["tmp_name"], $target_file);

            $offer_data = [
                'offerimage'=>$imgName,
                'company_id'=>company($myid),
                'title'=>strip_tags($this->request->getVar('title')),
                'section'=>strip_tags($this->request->getVar('section')),
                'link'=>strip_tags(trim($this->request->getVar('link')))
            ];

            $saveoffer=$OffersModel->save($offer_data);
            $session=session();
            if ($saveoffer) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('offers'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('offers'));
            }

        }else{
           return redirect()->to(base_url('offers/offers'));
        }

    }

    public function edit_offer_image($hsid=''){

        $OffersModel= new OffersModel();

            if (isset($_POST['save_offer'])) {

            if (!empty($_FILES["offerimage"]["name"])) {
                $target_dir = "public/images/offers/";
                $target_file = $target_dir . time().basename($_FILES["offerimage"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $imgName = time().basename($_FILES["offerimage"]["name"]);
                move_uploaded_file($_FILES["offerimage"]["tmp_name"], $target_file);
            }else{
                $imgName=strip_tags($this->request->getVar('old_offerimage'));
            }

            $offer_data = [
                'offerimage'=>$imgName,
                'title'=>strip_tags($this->request->getVar('title')),
                'section'=>strip_tags($this->request->getVar('section')),
                'link'=>strip_tags(trim($this->request->getVar('link')))
            ];

            $saveoffer=$OffersModel->update($hsid, $offer_data);
            $session=session();
            if ($saveoffer) {
                 $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('offers'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('offers'));
            }

        }else{
            return redirect()->to(base_url('appearance/slider_grids'));
        }
    }
  
    public function delete_offer_image($cid=""){
        $session=session();
        $OffersModel= new OffersModel();
        if ($this->request->getMethod('post')) {            
            if ($OffersModel->delete($cid)) {
                $session->setFlashdata('pu_msg','Deleted!');
                return redirect()->to(base_url('offers'));
            }else{
                $session->setFlashdata('pu_er_msg','Failed to saved!');
                return redirect()->to(base_url('offers'));
            }
        }
    }
}