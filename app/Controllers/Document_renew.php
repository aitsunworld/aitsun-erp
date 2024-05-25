<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\DocumentRenewModel;
use App\Models\DoccategoryModel;
use App\Models\RenewFiles;
use App\Models\InvoiceModel;


class Document_renew extends BaseController{

	public function index(){
        $DocumentRenewModel=new DocumentRenewModel();
		$InvoiceModel=new InvoiceModel(); 

		$session=session();

        $pager = \Config\Services::pager();

        $results_per_page = 12; 

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $RenewFiles=new RenewFiles;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();



            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_document_renew')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (is_crm(company($myid))==0) {

                return redirect()->to(base_url());
            }
            // $key_user_data=$UserModel->where('company_id',company($myid))->where('author',1)->where('deleted',0)->findAll();


            //alert when due date
            $dateq=$DocumentRenewModel->where('company_id',company($myid))->where('deleted',0)->findAll();
             
                    foreach ($dateq as $ri) {
                        $renew_period=$ri['renew_period'];

                        if ($renew_period==0) {
                       $week_before=one_week_before($ri['r_due_on']);
                       $month_before=one_month_before($ri['r_due_on']); 
                       $curr_date=now_time($myid);
                       if ($curr_date>=$week_before && $curr_date<=$ri['r_due_on']) {
                            $rddt = array('r_status' => 'critical','notified'=>1);
                            $DocumentRenewModel->update($ri['id'],$rddt);
                                if ($ri['notified']==0) {

                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                $title='Reference no <b>'.$ri['ref_no'].'</b> on critical';
                                $message='';
                                $url=base_url().'/document_renew'; 
                                $icon=notification_icons('user');
                                $userid='all';
                                $nread=0;
                                $for_who='admin';
                                $notid='user';
                                notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                                   
                                }
                            
                       }elseif($curr_date>$ri['r_due_on']){
                            $rddt = array('r_status' => 'over due','notified'=>1);
                            $DocumentRenewModel->update($ri['id'],$rddt);

                            if ($ri['notified']==0) {

                             // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                $title='Reference no <b>'.$ri['ref_no'].'</b> on over due';
                                $message='';
                                $url=base_url().'/document_renew'; 
                                $icon=notification_icons('user');
                                $userid='all';
                                $nread=0;
                                $for_who='admin';
                                $notid='user';
                                notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                            }

                       }elseif($curr_date>=$month_before && $curr_date<=$ri['r_due_on']){
                            $rddt = array('r_status' => 'due');
                            $DocumentRenewModel->update($ri['id'],$rddt);
                       }else{
                            $rddt = array('r_status' => 'pending');
                            $DocumentRenewModel->update($ri['id'],$rddt);
                       }



                    }else{
                        $three_days_before=three_days_before($ri['r_due_on']);
                       $one_week_before=before_one_week($ri['r_due_on']); 
                       $curr_date=now_time($myid);
                       if ($curr_date>=$three_days_before && $curr_date<=$ri['r_due_on']) {
                            $rddt = array('r_status' => 'critical','notified'=>1);
                            $DocumentRenewModel->update($ri['id'],$rddt);
                                if ($ri['notified']==0) {

                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                $title='Reference no <b>'.$ri['ref_no'].'</b> on critical';
                                $message='';
                                $url=base_url().'/document_renew'; 
                                $icon=notification_icons('user');
                                $userid='all';
                                $nread=0;
                                $for_who='admin';
                                $notid='user';
                                notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                                   
                                }
                            


                       }elseif($curr_date>$ri['r_due_on']){
                            $rddt = array('r_status' => 'over due','notified'=>1);
                            $DocumentRenewModel->update($ri['id'],$rddt);

                            if ($ri['notified']==0) {

                             // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                $title='Reference no <b>'.$ri['ref_no'].'</b> on over due';
                                $message='';
                                $url=base_url().'/document_renew'; 
                                $icon=notification_icons('user');
                                $userid='all';
                                $nread=0;
                                $for_who='admin';
                                $notid='user';
                                notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                            // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                            }

                       }elseif($curr_date>=$one_week_before && $curr_date<=$ri['r_due_on']){
                            $rddt = array('r_status' => 'due');
                            $DocumentRenewModel->update($ri['id'],$rddt);
                       }else{
                            $rddt = array('r_status' => 'pending');
                            $DocumentRenewModel->update($ri['id'],$rddt);
                       }
                    }
           
            }
           
            
            // alert for month

            //alert when due date 



            //  auto renew against
            $renew_invoices=$InvoiceModel->where('company_id',company($myid))->where('deleted',0)->where('renew_effected',0)->where('renew_id!=',0)->findAll();
            foreach ($renew_invoices as $ri) {
                if ($ri['paid_status']=='paid') {
                    $redata=[
                        'renew_effected'=>1,
                        'payment_status'=>'received'
                    ];
                    $DocumentRenewModel->update($ri['renew_id'],$redata);

                    $InvoiceModel->update($ri['id'],array('renew_effected'=>1));
                }
                
            }
            //  auto renew against



            if($_GET){

                if (isset($_GET['cat'])) {
                    if (!empty($_GET['cat'])) {
                        $cat=$_GET['cat'];
                         $rqry=$DocumentRenewModel->where('company_id',company($myid))->where('r_category',$cat)->orderBy('id','DESC')->where('deleted',0);
                        $document_renew=$rqry->paginate(25);
                    }else{
                        $rqry=$DocumentRenewModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0);
                        $document_renew=$rqry->paginate(25);
                    }
                }elseif (isset($_GET['status'])) {
                    if (!empty($_GET['status'])) {
                        $status=$_GET['status'];
                        if ($status!='all') {
                            $rqry=$DocumentRenewModel->where('company_id',company($myid))->where('r_status',$status)->orderBy('id','DESC')->where('deleted',0);
                            $document_renew=$rqry->paginate(25);
                        }else{
                            $rqry=$DocumentRenewModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0);
                        $document_renew=$rqry->paginate(25);
                        }
                        
                    }else{
                        $rqry=$DocumentRenewModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0);
                        $document_renew=$rqry->paginate(25);
                    }
                }elseif (isset($_GET['cancel'])) {
                        $rqry=$DocumentRenewModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',1);
                        $document_renew=$rqry->paginate(25);

                }else{
                    $rqry=$DocumentRenewModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0);
                    $document_renew=$rqry->paginate(25);
                }

            }else{
                $rqry=$DocumentRenewModel->where('company_id',company($myid))->orderBy('id','DESC')->where('deleted',0)->where('r_status!=','pending');
                    $document_renew=$rqry->paginate(25);
            }

            $data=[
                'title'=>'Document renew',	
                'document_renew'=>$document_renew,	
                'user'=>$user,
                'pager' => $DocumentRenewModel->pager,
                // 'key_user_data'=>$key_user_data
            ];



            echo view('header',$data);
            echo view('document_renew/document_renew');
            echo view('footer');


            if (isset($_POST['addnewrenew'])) {
                $r_category = $_POST['r_category'];
                $r_ref_no = $_POST['ref_no'];
                $r_phone_no = $_POST['r_phone'];
                $r_desc = $_POST['r_description'];
                //$r_file = $_POST['r_file'];
                $r_due_date = $_POST['r_due_on'];
                $r_notes = $_POST['r_notes'];
                $renew_period = $_POST['renew_period'];
                $r_customer = $_POST['cr_customer'];

                $insdoc =[
                    'company_id'=>company($myid),
                    'r_category'=>$r_category,
                    'r_customer'=>$r_customer,
                    'ref_no'=>$r_ref_no,
                    'r_description'=>$r_desc,
                    'r_notes'=>$r_notes, 
                    'r_due_on'=>$r_due_date,
                    'renew_period'=>$renew_period,
                    'r_phone'=>$r_phone_no,
                    'r_date'=>now_time($myid),
                    'r_status'=>'due'
                ];

                $insert_renw=$DocumentRenewModel->save($insdoc);
                $renid=$DocumentRenewModel->insertID();

                 if ($insert_renw) {



                    foreach($this->request->getFileMultiple('r_file') as $file)
                     {   
                        if ($file->isValid()) {
                            $filename_thumb = rand_string(4).'-'.$file->getName();
                            $mimetype_thumb=$file->getClientMimeType();
                            $file->move('public/renew_docs/',$filename_thumb);
                            $thumbdata = [
                                'renew_id'=>$renid,
                                'file'=>$filename_thumb
                            ];
                            $RenewFiles->save($thumbdata);
                        }
                        
                     }

                        $session->setFlashdata('pu_msg', 'New renew document added successfully');
                        return redirect()->to($_SERVER['HTTP_REFERER']);
                    }else{
                        $session->setFlashdata('pu_er_msg', 'Failed!');
                        return redirect()->to($_SERVER['HTTP_REFERER']);
                    }
            }


            if (isset($_POST['editrenew'])) {
                $r_category = $_POST['r_category'];
                $r_ref_no = $_POST['ref_no'];
                $r_desc = $_POST['r_description'];
                $r_phone_no = $_POST['r_phone'];
                //$r_file = $_POST['r_file'];
                $r_due_date = $_POST['r_due_on'];
                $r_notes = $_POST['r_notes'];
                $rnid = $_POST['rnid'];
                $r_status = $_POST['r_status'];
                $renew_period = $_POST['renew_period'];




                 $iupdoc = [
                    'r_category'=>$r_category ,
                    'ref_no'=>$r_ref_no ,
                    'r_description'=>$r_desc ,
                    'r_notes'=>$r_notes , 
                    'r_phone'=>$r_phone_no,
                    'r_status'=>$r_status ,
                    'r_due_on'=>$r_due_date,
                    'renew_period'=>$renew_period,
                    'payment_status'=>''

                ];
                 $up_ren=$DocumentRenewModel->update($rnid,$iupdoc);

                 
                 if ($up_ren) {

                    foreach($this->request->getFileMultiple('r_file') as $file)
                     {   
                        if ($file->isValid()) {
                            $filename_thumb = rand_string(4).'-'.$file->getName();
                            $mimetype_thumb=$file->getClientMimeType();
                            $file->move('public/renew_docs/',$filename_thumb);
                            $thumbdata = [
                                'renew_id'=>$rnid,
                                'file'=>$filename_thumb
                            ];
                            $RenewFiles->save($thumbdata);
                        }
                        
                     }


                        $session->setFlashdata('pu_msg', 'Renew document updated successfully');
                        return redirect()->to($_SERVER['HTTP_REFERER']);
                    }else{
                        $session->setFlashdata('pu_er_msg', 'Failed!');
                         return redirect()->to($_SERVER['HTTP_REFERER']);
                    }

                }

                
            

        }else{
                return redirect()->to(base_url('users/login'));
        }
    }

    


    public function delete_file($rnid=""){
        $session=session();
        $RenewFiles=new RenewFiles;
        if ($RenewFiles->where('id',$rnid)->delete()) {
            $session->setFlashdata('pu_msg','File Deleted!');
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }else{
            $session->setFlashdata('pu_er_msg','Failed to delete!');
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }

    

    public function delete_r_file($rid=""){
        $session=session();
        $DocumentRenewModel=new DocumentRenewModel;
        if ($this->request->getMethod('post')) {  
            $redata=[
                'r_file'=>''
            ];          
            if ($DocumentRenewModel->update($rid,$redata)) {
                $session->setFlashdata('pu_msg','File Deleted!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }else{
                $session->setFlashdata('pu_er_msg','Failed to delete!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
    }




     public function delete_renew($rid=""){
        $session=session();
        $DocumentRenewModel=new DocumentRenewModel;
        if ($this->request->getMethod('get')) {  
            $redata=[
                'deleted'=>2
            ];          
            if ($DocumentRenewModel->update($rid,$redata)) {
                $session->setFlashdata('pu_msg','Deleted!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }else{
                $session->setFlashdata('pu_er_msg','Failed to delete!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function cancel_renew($rid=""){
        $session=session();
        $DocumentRenewModel=new DocumentRenewModel;
        if ($this->request->getMethod('get')) {  
        	$redata=[
        		'deleted'=>1
        	];          
            if ($DocumentRenewModel->update($rid,$redata)) {
                $session->setFlashdata('pu_msg','Cancelled!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }else{
                $session->setFlashdata('pu_er_msg','Failed!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function restore_renew($rid=""){
        $session=session();
        $DocumentRenewModel=new DocumentRenewModel;
        if ($this->request->getMethod('post')) {  
            $redata=[
                'deleted'=>0
            ];          
            if ($DocumentRenewModel->update($rid,$redata)) {
                $session->setFlashdata('pu_msg','Restored!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }else{
                $session->setFlashdata('pu_er_msg','Failed!');
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
    }




public function category(){
    
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $DoccategoryModel= new DoccategoryModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

            


            if (check_permission($myid,'manage_document_renew')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

            if (usertype($myid) == 'customer'){
                    return redirect()->to(base_url());

               }


                $doc_category=$DoccategoryModel->where('company_id',company($myid))->where('deleted',0)->findAll();

                    $data= [
                        'title'=>'Document renew category',
                        'user'=>$user,
                        'doc_category'=>$doc_category,

                    ];

                    if (isset($_POST['addcategory'])) {

        
                        $at_data = [
                            'company_id'=>company($myid),
                            'category_name'=>strip_tags($this->request->getVar('category')),
                            'name'=>strip_tags($this->request->getVar('category')),

                        ];

                    $update_user=$DoccategoryModel->save($at_data);

                     if ($update_user) {
                        session()->setFlashdata('pu_msg', 'Saved!');
                        return redirect()->to(base_url('document_renew/category'));
                    }else{
                        session()->setFlashdata('pu_er_msg', 'Failed!');
                        return redirect()->to(base_url('document_renew/category'));
                    }
                }


                if (isset($_POST['editcategory'])) {

                    
                        $pu_data = [
                             'category_name'=>strip_tags($this->request->getVar('category')),
                             'name'=>strip_tags($this->request->getVar('category')),
                        ];

                    
                     $update_user=$DoccategoryModel->update($this->request->getVar('dcid'),$pu_data);

                    if ($update_user) {
                       
                        session()->setFlashdata('pu_msg', 'Category Updated!');
                        return redirect()->to(base_url('document_renew/category'));
                    }else{
                        session()->setFlashdata('pu_er_msg', 'Failed to save!');
                        return redirect()->to(base_url('document_renew/category'));
                    }
                }

                    echo view('header',$data);
                    echo view('document_renew/category', $data);
                    echo view('footer');

    }


}



public function savecategory(){
        $session=session();
        $UserModel=new Main_item_party_table;
        $DoccategoryModel= new DoccategoryModel;


        $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
        $user=$UserModel->where('id',$myid)->first();


               
        if ($this->request->getMethod('post')) {            
            $clientdata=[
                'company_id'=>company($myid),
                'category_name'=>strip_tags($this->request->getVar('category_name')),
                'name'=>strip_tags($this->request->getVar('category_name')),
            ];

            if ($DoccategoryModel->save($clientdata)) {
                echo '<div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success">Success</h6>
                        <div>Saved</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }else{
                echo '<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-danger">Failed</h6>
                        <div>Failed to save</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        }
    }

    public function display_documentrenew(){
        $DoccategoryModel= new DoccategoryModel;
         $myid=session()->get('id');
        $user_data=$DoccategoryModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','desc')->findAll();

        foreach ($user_data as $us){
            ?>
        
                 <li class="">
                    <div class="position-relative ">
                         <a href="<?= base_url('document_renew'); ?>?cat=<?= $us['id']; ?>"class="mb-2 href_loader btn si_btn w-100" name="<?= $us['name']; ?>" type="submit" style="text-align:left;" value="<?= $us['name']; ?>"><?= $us['category_name']; ?></a>
                         

                         <div class="position-absolute me-1 d-flex my-auto"style="right: 0;top: 4px;">

                            <a class=" btn-edit-dark me-2 action_btn my-auto cursor-pointer" data-bs-toggle="modal" data-bs-target="#edit_docrenew<?= $us['id']; ?>"><i class="bx bxs-edit-alt"></i></a>
                                    
                            <a class="delete_doc_category btn-delete-red action_btn my-auto cursor-pointer my-auto"  data-deleteurl="<?= base_url('document_renew/delete_doc_category'); ?>/<?= $us['id']; ?>"><i class="bx bxs-trash"></i></a>
                        </div>
                    </div>



                 <div class="modal fade" id="edit_docrenew<?= $us['id']?>"  aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post"  action="<?= base_url('document_renew/edit_doc_category'); ?>/<?=$us['id'];?>" id="edit_document_cat<?= $us['id']; ?>">
                            
                                <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-12" >
                                    <div class="form-group mb-2">
                                        <label for="input-2" class="form-label">Category Name</label>
                                        <input type="text" class="form-control " id="doc_category_name" name="category_name" value="<?= $us['category_name']?>" >
                                    </div>

                                  </div>
                               
                                </div>
                              </div>
                              <div class="modal-footer">
                                
                                <button type="button" class="aitsun-primary-btn editcategory" data-catgryid="<?= $us['id'];?>" name="editcategory">Save Category</button>

                              </div>
                                                                    
                            </form>

                            <p id="result1"></p>   

                        </div>  
                    </div>
                </div>
            </li>
              

               
            <?php
        }
    }


    // public function delete_doc_category($dc_id=""){
    // $DoccategoryModel = new DoccategoryModel;
    // $session=session();
    // if ($this->request->getMethod('post')) {            
    //         if ($DoccategoryModel->delete($dc_id)) {
    //             echo 1;
    //         }else{
    //             echo 0;
    //         }
    //     }





        public function delete_doc_category($dc_id=""){
            $DoccategoryModel = new DoccategoryModel;
            $session=session();

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );

            $cate_name=$DoccategoryModel->where('id',$dc_id)->first();
            $deledata=[
                'deleted'=>1
            ];

          if ($DoccategoryModel->update($dc_id,$deledata)) {

                ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Product category (#'.$dc_id.') <b>'.$cate_name['category_name'].'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////

               echo 1;
               
            }else{
                echo 0;
                
            }
        }
        

    // $deledata=[
    //     'deleted'=>1
    // ];


    // if ($DoccategoryModel->update($dc_id,$deledata)) {
       
    //     $session->setFlashdata('pu_msg', 'Deleted!');
    //     return redirect()->to(base_url('document_renew/category'));
    // }else{
    //     $session->setFlashdata('pu_er_msg', 'Failed to delete!');
    //     return redirect()->to(base_url('document_renew/category'));
    // }


public function edit_doc_category ($cid=""){
        $session=session();
       
        $DoccategoryModel=  new DoccategoryModel;

        if ($this->request->getMethod('post')) {            
            $clientdata=[
                'category_name'=>strip_tags($this->request->getVar('category_name')),
                'name'=>strip_tags($this->request->getVar('category_name')),
            ];
        
            if ($DoccategoryModel->update($cid,$clientdata)) {
                echo '<div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success">Success</h6>
                        <div>Saved</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }else{
                echo '<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-danger">Failed</h6>
                        <div>Failed to save</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        }
    }
    

}

   
    