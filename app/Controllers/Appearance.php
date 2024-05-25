<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProductCategories;
use App\Models\ProductSubCategories;
use App\Models\SecondaryCategories;
use App\Models\ProductBrand;
use App\Models\HomesliderModel;


class Appearance extends BaseController
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

       
                        }
        if (check_permission($myid,'manage_appearance')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

        $data=[
            'title'=>'Aitsun ERP-Appearences',
            'user'=> $UserModel->where('id', session()->get('id'))->first(),
        ];

        $session=session();

        if ($session->has('isLoggedIn')){ 
            echo view('header',$data);
            echo view('appearance/home_design',$data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users'));
        }
        
    }


    public function slider_grids()
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
            'title'=>'Aitsun ERP-Appearences',
            'user'=> $UserModel->where('id', session()->get('id'))->first(),
        ];

        $session=session();

        if ($session->has('isLoggedIn')){ 
            echo view('header',$data);
            echo view('appearance/slider_grids',$data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users'));
        }
        
    }



    public function add_category_image($iddd=''){

        $ProductCategories= new ProductCategories();

        if (isset($_POST['add_cat_image'])) {

            if (!empty($_FILES["catimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $target_file = $target_dir . time().basename($_FILES["catimage"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $imgName = time().basename($_FILES["catimage"]["name"]);
                move_uploaded_file($_FILES["catimage"]["tmp_name"], $target_file);
            }else{
                $imgName=strip_tags($this->request->getVar('oldcatimg'));
            }
            if (!empty($_FILES["menucatimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $targetmenu_file = $target_dir . time().basename($_FILES["menucatimage"]["name"]);
                $imagemenuFileType = pathinfo($targetmenu_file,PATHINFO_EXTENSION);
                $imgmenuName = time().basename($_FILES["menucatimage"]["name"]);
                move_uploaded_file($_FILES["menucatimage"]["tmp_name"], $targetmenu_file);
            }else{
                $imgmenuName=strip_tags($this->request->getVar('oldmenucatimg'));
            }

            if (!empty($_FILES["sectioncatimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $targetsection_file = $target_dir . time().basename($_FILES["sectioncatimage"]["name"]);
                $imagesectionFileType = pathinfo($targetsection_file,PATHINFO_EXTENSION);
                $imgsectionName = time().basename($_FILES["sectioncatimage"]["name"]);
                move_uploaded_file($_FILES["sectioncatimage"]["tmp_name"], $targetsection_file);
            }else{
                $imgsectionName=strip_tags($this->request->getVar('oldsectioncatimg'));
            }

            if (!empty($_FILES["sectioncatimage2"]["name"])) {
                $target_dir = "public/images/myshop/";
                $targetsection2_file = $target_dir . time().basename($_FILES["sectioncatimage2"]["name"]);
                $imagesection2FileType = pathinfo($targetsection2_file,PATHINFO_EXTENSION);
                $imgsection2Name = time().basename($_FILES["sectioncatimage2"]["name"]);
                move_uploaded_file($_FILES["sectioncatimage2"]["tmp_name"], $targetsection2_file);
            }else{
                $imgsection2Name=strip_tags($this->request->getVar('oldsectioncatimg2'));
            }


            $home_data = [
                'cat_img'=>$imgName,
                'menu_cat_img'=>$imgmenuName,
                'section_cat_img'=>$imgsectionName,
                'section_cat_img2'=>$imgsection2Name,
                'title'=>strip_tags($this->request->getVar('title')),
                'keywords'=>strip_tags($this->request->getVar('keywords')),
                'description'=>strip_tags($this->request->getVar('description')),
                'button_class'=>strip_tags($this->request->getVar('button_class')),
                'menulink'=>strip_tags($this->request->getVar('menulink')),
                'sectionlink'=>strip_tags($this->request->getVar('sectionlink')),
                'section_title'=>strip_tags($this->request->getVar('section_title')),
                'section_desc'=>strip_tags($this->request->getVar('section_desc')),
                'button_name'=>strip_tags($this->request->getVar('button_name')),
                'button_background_color'=>strip_tags($this->request->getVar('button_background_color')),
                'button_font_color'=>strip_tags($this->request->getVar('button_font_color')),
                'button_class'=>strip_tags($this->request->getVar('button_class')),
                'sectionlink2'=>strip_tags($this->request->getVar('sectionlink2')),
                'section_title2'=>strip_tags($this->request->getVar('section_title2')),
                'section_desc2'=>strip_tags($this->request->getVar('section_desc2')),
                'button_name2'=>strip_tags($this->request->getVar('button_name2')),
                'button_background_color2'=>strip_tags($this->request->getVar('button_background_color2')),
                'button_font_color2'=>strip_tags($this->request->getVar('button_font_color2')),
                'button_class2'=>strip_tags($this->request->getVar('button_class2')),
            ];

            $savehome=$ProductCategories->update($iddd,$home_data);
            $session=session();
            if ($savehome) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('appearance'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('appearance'));
            }

        }else{
            return redirect()->to(base_url('appearance'));
        }

    }


    public function remove_category_image($iddd=''){
        $ProductCategories= new ProductCategories();
        $home_data = [
            'cat_img'=>'',
        ];

        
        $savehome=$ProductCategories->update($iddd,$home_data);
        $session=session();
        if ($savehome) {
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('appearance'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed');
            return redirect()->to(base_url('appearance'));
        }
    }


    public function remove_menu_add_img($iddd=''){
        $ProductCategories= new ProductCategories();
        $home_data = [
            'menu_cat_img'=>'',
        ];

        
        $savehome=$ProductCategories->update($iddd,$home_data);
        $session=session();
        if ($savehome) {
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('appearance'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed');
            return redirect()->to(base_url('appearance'));
        }
    }


    public function remove_sec_add_img($iddd=''){
        $ProductCategories= new ProductCategories();
        $home_data = [
            'section_cat_img'=>'',
        ];

        
        $savehome=$ProductCategories->update($iddd,$home_data);
        $session=session();
        if ($savehome) {
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('appearance'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed');
            return redirect()->to(base_url('appearance'));
        }
    }

    public function remove_sec_add_img_two($iddd=''){
        $ProductCategories= new ProductCategories();
        $home_data = [
            'section_cat_img2'=>'',
        ];

        
        $savehome=$ProductCategories->update($iddd,$home_data);
        $session=session();
        if ($savehome) {
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('appearance'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed');
            return redirect()->to(base_url('appearance'));
        }
    }


    public function add_sub_category_image($siddd=''){
        $ProductSubCategories= new ProductSubCategories();
        if (isset($_POST['add_sub_cat_image'])) {

            if (!empty($_FILES["subcatimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $target_file = $target_dir . time().basename($_FILES["subcatimage"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $imgName = time().basename($_FILES["subcatimage"]["name"]);
                move_uploaded_file($_FILES["subcatimage"]["tmp_name"], $target_file);
            }else{
                $imgName=strip_tags($this->request->getVar('oldsubimg'));
            }

            $home_data = [
                'sub_cat_img'=>$imgName,
                'title'=>strip_tags($this->request->getVar('title')),
                'keywords'=>strip_tags($this->request->getVar('keywords')),
                'description'=>strip_tags($this->request->getVar('description')),
            ];

            $savehome=$ProductSubCategories->update($siddd,$home_data);
            $session=session();
            if ($savehome) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('appearance'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('appearance'));
            }

        }else{
           return redirect()->to(base_url('appearance'));
        }

    }

    public function remove_sub_category_image($iddd=''){

        $ProductSubCategories= new ProductSubCategories();

        $home_data = [
            'sub_cat_img'=>'',
        ];

        
        $savehome=$ProductSubCategories->update($iddd, $home_data);
        $session=session();
        if ($savehome) {
             $session->setFlashdata('pu_msg', 'Deleted!');
                return redirect()->to(base_url('appearance'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed!');
                return redirect()->to(base_url('appearance'));
        }
    }


    public function add_secsub_category_image($siddd=''){
        $SecondaryCategories= new SecondaryCategories();
        if (isset($_POST['add_secsub_cat_image'])) {

            if (!empty($_FILES["secndcatimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $target_file = $target_dir . time().basename($_FILES["secndcatimage"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $imgName = time().basename($_FILES["secndcatimage"]["name"]);
                move_uploaded_file($_FILES["secndcatimage"]["tmp_name"], $target_file);
            }else{
                $imgName=strip_tags($this->request->getVar('oldsecsubimg'));
            }

            $home_data = [
                'sec_sub_cat_img'=>$imgName,
                'title'=>strip_tags($this->request->getVar('title')),
                'keywords'=>strip_tags($this->request->getVar('keywords')),
                'description'=>strip_tags($this->request->getVar('description')),
            ];

            $savehome=$SecondaryCategories->update($siddd, $home_data);
            $session=session();
            if ($savehome) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('appearance'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('appearance'));
            }

        }else{
            return redirect()->to(base_url('appearance'));
        }

    }


    public function remove_sec_sub_category_image($psciddd=''){
        $SecondaryCategories= new SecondaryCategories();
        $home_data = [
            'sec_sub_cat_img'=>'',
        ];

        $savehome=$SecondaryCategories->update($psciddd, $home_data);
        $session=session();
        if ($savehome) {
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('appearance'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed!');
            return redirect()->to(base_url('appearance'));
        }
    }


    public function add_brand_image($pbiddd=''){
        $ProductBrand= new ProductBrand();
        if (isset($_POST['add_brand_image'])) {

            if (!empty($_FILES["addbrandimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $target_file = $target_dir . time().basename($_FILES["addbrandimage"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $imgName = time().basename($_FILES["addbrandimage"]["name"]);
                move_uploaded_file($_FILES["addbrandimage"]["tmp_name"], $target_file);
            }else{
                $imgName=strip_tags($this->request->getVar('oldbrndimg'));
            }

            if (!empty($_FILES["addbrandimagedark"]["name"])) {
                $target_dirdark = "public/images/myshop/";
                $target_filedark = $target_dirdark . time().basename($_FILES["addbrandimagedark"]["name"]);
                $imageFileTypedark = pathinfo($target_filedark,PATHINFO_EXTENSION);
                $imgNamedark = time().basename($_FILES["addbrandimagedark"]["name"]);
                move_uploaded_file($_FILES["addbrandimagedark"]["tmp_name"], $target_filedark);
            }else{
                $imgNamedark=strip_tags($this->request->getVar('oldbrndimgdark'));
            }

            if (!empty($_FILES["addbrandimagelight"]["name"])) {
                $target_dirlight = "public/images/myshop/";
                $target_filelight = $target_dirlight . time().basename($_FILES["addbrandimagelight"]["name"]);
                $imageFileTypelight = pathinfo($target_filelight,PATHINFO_EXTENSION);
                $imgNamelight = time().basename($_FILES["addbrandimagelight"]["name"]);
                move_uploaded_file($_FILES["addbrandimagelight"]["tmp_name"], $target_filelight);
            }else{
                $imgNamelight=strip_tags($this->request->getVar('oldbrndimglight'));
            }

            $home_data = [
                'brand_img'=>$imgName,
                'brand_img_dark'=>$imgNamedark,
                'brand_img_light'=>$imgNamelight,
                'title'=>strip_tags($this->request->getVar('title')),
                'keywords'=>strip_tags($this->request->getVar('keywords')),
                'description'=>strip_tags($this->request->getVar('description')),
            ];

            
            $savehome=$ProductBrand->update($pbiddd, $home_data);
            $session=session();
            if ($savehome) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('appearance'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('appearance'));
            }

        }else{
            return redirect()->to(base_url('appearance'));
        }

    }


    public function remove_brand_image($pbrid=''){

        $ProductBrand= new ProductBrand();

        $home_data = [
            'brand_img'=>'',
            'brand_img_dark'=>'',
            'brand_img_light'=>'',
        ];

        $savehome=$ProductBrand->update($pbrid, $home_data);
        $session=session();
        if ($savehome) {
            $session->setFlashdata('pu_msg', 'Deleted!');
            return redirect()->to(base_url('appearance'));
        }else{
            $session->setFlashdata('pu_er_msg', 'Failed!');
            return redirect()->to(base_url('appearance'));
        }
    }


    public function save_home_slider_and_grid(){

        $HomesliderModel= new HomesliderModel();

        $myid=session()->get('id');

        if (isset($_POST['save_home'])) {

            $target_dir = "public/images/myshop/";
            $target_file = $target_dir . time().basename($_FILES["homeimage"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imgName = time().basename($_FILES["homeimage"]["name"]);
            move_uploaded_file($_FILES["homeimage"]["tmp_name"], $target_file);


            $target_dir = "public/images/myshop/";
            $targetmbl_file = $target_dir . time().basename($_FILES["mblimage"]["name"]);
            $imagemblFileType = pathinfo($targetmbl_file,PATHINFO_EXTENSION);
            $imgmblName = time().basename($_FILES["mblimage"]["name"]);
            move_uploaded_file($_FILES["mblimage"]["tmp_name"], $targetmbl_file);

            $home_data = [
                'homeimage'=>$imgName,
                'mblimage'=>$imgmblName,
                'company_id'=>company($myid),
                'title'=>strip_tags($this->request->getVar('title')),
                'section'=>strip_tags($this->request->getVar('section')),
                'description'=>strip_tags($this->request->getVar('description')),
                'link'=>strip_tags(trim($this->request->getVar('link'))),
                'use_custom_contain'=>strip_tags(trim($this->request->getVar('use_custom_contain'))),
                'button_name'=>strip_tags(trim($this->request->getVar('button_name'))),
                'button_background_color'=>strip_tags(trim($this->request->getVar('button_background_color'))),
                'button_font_color'=>strip_tags(trim($this->request->getVar('button_font_color'))),
                'bg_gradient'=>strip_tags(trim($this->request->getVar('bg_gradient'))),
                'mockup_shadow'=>strip_tags(trim($this->request->getVar('mockup_shadow'))),
                'position'=>strip_tags(trim($this->request->getVar('position'))),
            ];

            $savehome=$HomesliderModel->save($home_data);
            $session=session();
            if ($savehome) {
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('appearance/slider_grids'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('appearance/slider_grids'));
            }

        }else{
           return redirect()->to(base_url('appearance/slider_grids'));
        }

    }


    public function edit_home_slider_and_grid($hsid=''){

        $HomesliderModel= new HomesliderModel();

            if (isset($_POST['save_home'])) {

            
            if (!empty($_FILES["homeimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $target_file = $target_dir . time().basename($_FILES["homeimage"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $imgName = time().basename($_FILES["homeimage"]["name"]);
                move_uploaded_file($_FILES["homeimage"]["tmp_name"], $target_file);
            }else{
                $imgName=strip_tags($this->request->getVar('old_homeimage'));
            }

            if (!empty($_FILES["mblimage"]["name"])) {
                $target_dir = "public/images/myshop/";
                $targetmbl_file = $target_dir . time().basename($_FILES["mblimage"]["name"]);
                $imagemblFileType = pathinfo($targetmbl_file,PATHINFO_EXTENSION);
                $imgmblName = time().basename($_FILES["mblimage"]["name"]);
                move_uploaded_file($_FILES["mblimage"]["tmp_name"], $targetmbl_file);
            }else{
                $imgmblName=strip_tags($this->request->getVar('old_mblimage'));
            }



            $home_data = [
                'homeimage'=>$imgName,
                'mblimage'=>$imgmblName,
                'title'=>strip_tags($this->request->getVar('title')),
                'section'=>strip_tags($this->request->getVar('section')),
                'description'=>strip_tags($this->request->getVar('description')),
                'button_class'=>strip_tags($this->request->getVar('button_class')),
                'link'=>strip_tags(trim($this->request->getVar('link'))),
                'use_custom_contain'=>strip_tags(trim($this->request->getVar('use_custom_contain'))),
                'button_name'=>strip_tags(trim($this->request->getVar('button_name'))),
                'button_background_color'=>strip_tags(trim($this->request->getVar('button_background_color'))),
                'button_font_color'=>strip_tags(trim($this->request->getVar('button_font_color'))),
                'bg_gradient'=>strip_tags(trim($this->request->getVar('bg_gradient'))),
                'mockup_shadow'=>strip_tags(trim($this->request->getVar('mockup_shadow'))),
                'position'=>strip_tags(trim($this->request->getVar('position'))),
            ];

            $savehome=$HomesliderModel->update($hsid, $home_data);
            $session=session();
            if ($savehome) {
                 $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('appearance/slider_grids'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('appearance/slider_grids'));
            }

        }else{
            return redirect()->to(base_url('appearance/slider_grids'));
        }

    }


    public function delete_home_slider_and_grid($hsid=''){

        $HomesliderModel= new HomesliderModel();
        if (!empty($hsid)) {
            

             $session=session();
            if ($HomesliderModel->delete($hsid)) {

                 $session->setFlashdata('pu_msg', 'Deleted!');
                    return redirect()->to(base_url('appearance/slider_grids'));
                }else{
                    $session->setFlashdata('pu_er_msg', 'Failed!');
                    return redirect()->to(base_url('appearance/slider_grids'));
                }

        }
    }
}