<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\MagazineModel;

class Magazine_request extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $myid=session()->get('id');
	    $magazinemodel = new MagazineModel();

	    $pager = \Config\Services::pager();

            $results_per_page = 12;
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		$articles=$magazinemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(25);

	    		
	    		$data=[
	    			'title'=>'Magazine | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'articles'=>$articles,
	    			'pager' => $magazinemodel->pager

	    		];
		    		echo view('header',$data);
		    		echo view('magazines/magazine');
		    		echo view('footer');
		    
	    	
	    }else{
	   		return redirect()->to(base_url('users/login'));
	   	}		
	}


	public function display_magazine_request(){
		$magazinemodel = new MagazineModel();
		$user = new Main_item_party_table();
		$myid=session()->get('id');
		$usaerdata=$user->where('id', $myid)->first();
		$magazine_data=$magazinemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('teacher_id',$usaerdata['id'])->where('status', 'waiting')->where('deleted',0)->orderBy('id','DESC')->findAll();
		$count=0;
		foreach ($magazine_data as $mgz) {
			$count++;

			?>
				<div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class=" m-b-10"><?= $mgz['title'] ?></h5>
                                        <div class="d-flex m-b-30">
                                            <div class="avatar avatar-cyan avatar-img">
                                                <img src="<?= student_pro_pic($mgz['student_id']) ?>" alt="">
                                            </div>
                                            <div class="m-l-15">
                                                <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold"><?= user_name($mgz['student_id']) ?></a>
                                                <p class="m-b-0 text-muted font-size-13"><?= get_date_format($mgz['datetime'],'d M Y') ?> | Class : <?= class_name(current_class_of_student(company($myid),$mgz['student_id'])) ?></p>
                                            </div>
                                        </div>
                                        <img alt="" class="img-fluid w-100" src="<?= base_url('public'); ?>/uploads/articles/<?php if($mgz['magazine_img'] != ''){echo $mgz['magazine_img']; }else{ echo 'img-8.jpg';} ?>">

                                        <div class="m-t-10">
                                            <h6>Description:</h6>
                                            <p><?= nl2br($mgz['description']); ?></p>
                                        </div>
                                        <div class="m-t-30 text-center ">
                                            
                                            <a class="btn btn-primary acceptmagazine text-white" data-deleteurl="<?= base_url('magazine_request/accept_magazine'); ?>/<?= $mgz['id']; ?>">Accept</a>
                                            <a class="btn btn-danger rejectmagazine text-white" data-deleteurl="<?= base_url('magazine_request/reject_magazine'); ?>/<?= $mgz['id']; ?>">Reject</a>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                   
                                </div>
                            </div>


		<?php
		}

		if ($count==0) {
			echo '<div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                    <h3 class="text-danger text-center">No article request</h3>
                </div> </div> </div>';
		}

	}

	  public function accept_magazine($mgid=0)
	{
		$magazinemodel = new MagazineModel();
		$myid=session()->get('id');


		if ($this->request->getMethod() == 'get') {
				$magazinemodel->find($mgid);
				$acceptdata=[
                    'status'=>'accepted'
                ];
				$magazinemodel->update($mgid,$acceptdata);

				$getmagdata=$magazinemodel->where('id',$mgid)->first();
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='You recently requested article is accepted';
				    $message='';
				    $url=main_base_url().'magazines'; 
				    $icon=notification_icons('article');
				    $userid=$getmagdata['student_id'];
				    $nread=0;
				    $for_who='student';
				    $notid='article';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Article request <b>(#'.$mgid.')</b> is accepted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
			

	}
	
}

public function reject_magazine($mgid=0)
	{
		$magazinemodel = new MagazineModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'get') {
				$magazinemodel->find($mgid);
				$rejectdata=[
                    'status'=>'rejected'
                ];
				$magazinemodel->update($mgid,$rejectdata);

				$getmagdata=$magazinemodel->where('id',$mgid)->first();
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='You recently requested article is rejected';
				    $message='';
				    $url=main_base_url().'magazines'; 
				    $icon=notification_icons('article');
				    $userid=$getmagdata['student_id'];
				    $nread=0;
				    $for_who='student';
				    $notid='article';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Article request <b>(#'.$mgid.')</b> is rejected',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////
			

		}
	
	}

	public function articles()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $magazinemodel = new MagazineModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

               

	    		$articles=$magazinemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->findAll();

	    		$data=[
	    			'title'=>'Article Reports | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'articles'=>$articles
	    		];

                

    	    		echo view('header',$data);
    	    		echo view('magazines/articles');
    	    		echo view('footer');
                
	    	
	    


	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function view_article($artid)
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $magazinemodel = new MagazineModel();
	    $myid=session()->get('id');
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	   
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

               

	    		$view_article=$magazinemodel->where('id',$artid)->where('company_id',company($myid))->where('deleted',0)->first();

	    		$magzine=$magazinemodel->where('id',$artid)->where('deleted',0)->first();
	    		
	    		$data=[
	    			'title'=>'Article Reports | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'view_article'=>$view_article,
	    			'magzine'=>$magzine
	    		];

               
    	    		echo view('header',$data);
    	    		echo view('magazines/view_article');
    	    		echo view('footer');
              
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}
}