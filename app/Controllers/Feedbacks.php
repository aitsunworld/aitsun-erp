<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\FeedbackModel;



class Feedbacks extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $feed =new FeedbackModel();
	    $myid=session()->get('id');

	    $pager = \Config\Services::pager();

	    $results_per_page = 12; 
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    
	    	

	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		$feedback=$feed->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(50);

	    		
	    		$data=[
	    			'title'=>'Feedbacks | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'feedbacks'=>$feedback,
	    			'pager' => $feed->pager,

	    		];
	    		
		    		echo view('header',$data);
		    		echo view('feedbacks/feedback');
		    		echo view('footer');
		    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}

	public function delete_feedback($fid=0)
	{
		$feed=new FeedbackModel();

		if ($this->request->getMethod() == 'post') {
				$feed->find($fid);

				$deledata=[
                    'deleted'=>1
                ];

				$feed->update($fid,$deledata);

				$fdata=$feed->where('id',$fid)->first();

				////////////////////////CREATE ACTIVITY LOG//////////////
	            $log_data=[
	                'user_id'=>session()->get('id'),
	                'action'=>'Feedback of <b>'.user_name($fdata['student_id']).'(#'.$fid.')</b> is deleted.',
	                'ip'=>get_client_ip(),
	                'mac'=>GetMAC(),
	                'created_at'=>now_time(session()->get('id')),
	                'updated_at'=>now_time(session()->get('id')),
	                'company_id'=>company(session()->get('id')),
	            ];

	            add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
				
		}
	}
}