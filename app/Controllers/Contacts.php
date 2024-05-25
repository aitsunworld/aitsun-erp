<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;

class Contacts extends BaseController
{

    public function index()
    {
        $UserModel =new Main_item_party_table();
        

        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

           

            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            
            $all_contacts=$UserModel->findAll();

            $data=[
                'title'=>'Contacts',  
                'user'=>$user,     
                'all_contacts'=>$all_contacts     
            ];
            
            echo view('header',$data);
            echo view('customers/contacts');
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }  


    public function display(){

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
        
            $limit=$_GET['limit'];
            $start=$_GET['start'];

            $UserModel = new Main_item_party_table();

           

            if (isset($_GET['search'])) {

                $ser=$_GET['search'];
                if ($ser=='') {

                    $uq=$UserModel->where('company_id',company($myid))->where('saved_as','contact')->orderBy('id','desc')->where('deleted',0)->findAll(); 

                    }else{
                        
                    $uq=$UserModel->where('company_id',company($myid))->where('saved_as','contact')->groupStart()->like('display_name',$ser,'both')->orLike('phone',$ser,'both')->orLike('company',$ser,'both')->orLike('area',$ser,'both')->groupEnd()->orderBy('id','desc')->where('deleted',0)->findAll(); 

                   }
                }else{
                    $uq=$UserModel->where('company_id',company($myid))->where('saved_as','contact')->orderBy('id','desc')->where('deleted',0)->first();
                   
                }
            
            ?>

            <?php if (count ($uq) == 0): ?>
                <div class="d-flex mt-3" style="color: red;"><span class="m-auto"> No contacts</span></div>
                
            <?php endif ?>

            <?php
                foreach ($uq as $cp_data) {
            ?>

            <div class="phone_box">
                <div class="d-flex justify-content-between my-auto name_box" data-id="<?php echo $cp_data['id']; ?>">
                    <div class="d-flex justify-content-between">
                        <div data-bs-toggle="collapse" data-bs-target="#coll<?php echo $cp_data['id']; ?>" >
                            <div  class="my-auto letter_box" style="background: <?= c_color(first_letter($cp_data['display_name'],1)) ?>;">
                                <span class="lett text-uppercase"><?= first_letter($cp_data['display_name'],2); ?></span>

                            </div>
                        </div>

                        <div class="nc pl-10">
                            <div data-bs-toggle="collapse" data-bs-target="#coll<?php echo $cp_data['id']; ?>" aria-expanded="false" aria-controls="collapseExample">
                                <h3 class="m-0 num_font text-capitalize"><?php echo $cp_data['display_name']; ?></h3>
                                
                                <!-- //new -->
                            </div>
                            <small>
                                <i class="pr-2 bx bx-envelope"></i>
                                <a href="mailto:<?php echo $cp_data['email']; ?>">
                                    <?php echo  $cp_data['email']; ?>
                                </a>
                            </small>
                        </div>
                    </div>

                    <a href="tel:<?php echo  $cp_data['phone']; ?>" class="my-auto call_box"><i class="bx call_icon bxs-phone"></i></a>
                </div>

                          
                <div class="collapse collapse_contact_details mt-2" id="coll<?php echo $cp_data['id']; ?>">
                    <div class="d-flex justify-content-between shadow_color">

                            <div class="pl-10 mt-3 cl-size">
                                <ul class="clist">

                                    <?php if (trim($cp_data['landline'])!='' || trim($cp_data['landline'])!=''): ?>
                                        <li>
                                            <i class="pr-2 bx bx-phone"></i>
                                            <a href="tel:<?php echo  $cp_data['landline']; ?>,<?php echo  $cp_data['phone_2']; ?>">
                                            <?php if (trim($cp_data['landline'])!='') {
                                               echo  $cp_data['landline'].',';
                                            } ?>
                                            <?php echo  $cp_data['phone_2']; ?>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                   
                                   <?php if (trim($cp_data['area'])!=''): ?>
                                        <li>
                                            <i class="pr-2 bx bx-map"></i>
                                            <?php echo  $cp_data['area']; ?>
                                        </li>
                                   <?php endif ?>
                                    <?php if (trim($cp_data['designation'])!=''): ?>
                                       <li> 
                                            <span class="text-capitalize cp_color"><i class="pr-2 bx bx-briefcase" ></i> <b class="desig_color">Designation :</b> <?php echo designation($cp_data['designation']); ?></span>
                                        </li>
                                    <?php endif ?>
                                    <?php if (trim($cp_data['company'])!=''): ?>
                                        <li>
                                   
                                        <span class="text-capitalize cp_color"><i class="pr-2 bx bx-chevron-right"></i><b class="desig_color">Company :</b> <?php echo  $cp_data['company']; ?></span>
                                    </li>

                                    <?php endif ?>
                                    <?php if (trim($cp_data['contact_type'])!=''): ?>
                                            
                                        <li class="clist">
                                            <span class="text-capitalize cp_color"><i class="pr-2 bx bx-chevron-right"></i><b class="desig_color">Contact Type :</b> <?php echo contact_type($cp_data['contact_type']); ?></span>
                                        </li>
                                   <?php endif ?>
                                </ul>
                            </div>
                            

                        <div class="">
                            <a class="d-block ti_edt_blc" data-toggle="collapse" data-target="#up_item_form<?php echo  $cp_data['id']; ?>" aria-expanded="false" aria-controls="collapseExample">
                            <span class="ti_edt ti-pencil-alt"></span>
                            </a>
                            <a  class="d-block ti_blc delete_item" data-id="<?php echo  $cp_data['id']; ?>" data-name="<?php echo  $cp_data['display_name']; ?>">
                            <span class="ti_trs ti-trash"></span>
                            </a>   
                        </div>
                        <?php if (trim($cp_data['location'])!=''): ?>
                        <div class="d-flex justify-content-between mt-4 mb-4" style="margin-right:4px;">

                            <a class="location d-flex" href="http://maps.google.com/maps?q=<?php echo  $cp_data['location']; ?>" target="_blank"><i class="bx m-auto bx-map"></i> </a>
                            
                        </div>
                        <?php endif ?>

                    </div>

                    <!--  <div class="d-flex justify-content-between con_auth">
                        <div>Added by <php echo user_name($cp_data->c_added_by); ?></div>
                        <div><php echo mydateonly(mydinamka($cp_data->datetime)); ?></div>
                    </div> -->
                </div>

 
            </div>
            <?php
            }
        }
    
}