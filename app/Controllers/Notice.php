<?php namespace App\Controllers;
use App\Models\Main_item_party_table;

use App\Models\NoticeModel;



class Notice extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $notice=new NoticeModel();

	    $myid=session()->get('id');

	    $pager = \Config\Services::pager();

            $results_per_page = 10;

	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	
	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}


	    		
	    		$notice_data=$notice->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(10);
	    		
	    		$data=[
	    			'title'=>'Notice | Erudite ERP',
	    			'user'=>$usaerdata,
	    			'notice_data'=>$notice_data,
	    			'pager' => $notice->pager

	    		];

	    		
                
		    		echo view('header',$data);
		    		echo view('notice/notice');
		    		echo view('footer');
		    	


	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}


	public function send_notice($org=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$notice = new NoticeModel();
				$myid=session()->get('id');

				$newData = [
					'company_id' => $org,
					'academic_year' => academic_year($myid),
					'subject'=> strip_tags($this->request->getVar('subject')),
					'user_id' => strip_tags($this->request->getVar('uid')),
					'details' => $this->request->getVar('notice'),
					'deleted' => 0,
					'datetime' => now_time($myid),
				];

				$notice->save($newData);

				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='New notice added.';
				    $message='';
				    $url=main_base_url(); 
				    $icon=notification_icons('notice');
				    $userid='all';
				    $nread=0;
				    $for_who='student';
				    $notid='notice';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

			}
		

	}


	public function display_notice (){
		$notice = new NoticeModel();
		$user = new Main_item_party_table();
		$myid=session()->get('id');
		$usaerdata=$user->where('id', $myid)->first();
		$notice_data=$notice->where('company_id',company($myid))->where('academic_year',academic_year(company($myid)))->where('deleted',0)->orderBy('id','DESC')->findAll();
		$count=0;
		foreach ($notice_data as $ntc) {
			$count++;

			?>
		    <div class="card">
	            <div class="card-body">
	                <div id="invoice" class="">
	                    <div class="m-t-15 lh-2 ">
                            

	                        <div>
	                           	<div class="modal asms_modal fade" id="notices_edit<?= $ntc['id'] ?>">
								    <div class="modal-dialog modal-dialog-scrollable">
								        <div class="modal-content">
								            <div class="modal-header">
								                <h5 class="modal-title" id="techerdibt<?= $ntc['id'] ?>">Edit Notice</h5>
								                <button type="button" class="close" data-dismiss="modal">
								                    <i class="anticon anticon-close"></i>
								                </button>
								            </div>
			                            	<div class="modal-body">
								               <form id="edit_notice_form<?= $ntc['id'] ?>" action="<?= base_url('notice/update_notice') ?>/<?= $ntc['id'] ?>" >
								               	<?= csrf_field(); ?>
			                                        <div class="form-row">
			                                        	<div class="form-group col-md-12">
                                       
					                                    <input type="text" name="subject" placeholder="Notice Subject" value="<?= $ntc['subject'] ?>" class="form-control" required>
					                                   </div>
					                                    <div class="form-group col-md-12">
					                                        
					                                    <textarea name="notice" class="form-control summernote" required="required"><?= $ntc['details'] ?></textarea>
					                                   </div>
					                               </div>
			                                       
			                                        <div class="form-row">
			                                            <div class="form-group col-md-12">
			                                               <button class="btn btn-primary edit_notice" type="button" data-id="<?= $ntc['id'] ?>">Save</button>
			                                            </div>
			                                        </div>
			                                    </form>

								            </div>
						          		</div>
							    	</div>
								</div>

	                        </div>

                        </div>
                       
                        <div>
                        	<h5>SUBJECT : <?= $ntc['subject'] ?></h5>
                        </div>
                        <div class="row m-t-20 lh-2">
                            <div class="col-md-12">
                              <?= $ntc['details'] ?>
                            </div>
                            
                        </div>
                        <div class="m-t-20">
                            <hr>
                            <div class="row m-v-20">
                                <div class="col-sm-6">
                                   <p><i>Created At: <?= get_date_format($ntc['datetime'],'d M Y') ?></i></p>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a class="btn btn-dark  btn-sm text-white" data-toggle="modal" data-target="#notices_edit<?= $ntc['id'] ?>">
                                 <i class="anticon anticon-edit"></i> 
                                </a>
                                <a class="btn btn-danger deletenote btn-sm text-white"  data-deleteurl="<?= base_url('notice/deletenotices'); ?>/<?= $ntc['id'] ?>">
                                        <i class="far fa-trash-alt"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
	                </div>
	                
	            </div>
           </div>

                <?php
		}

		if ($count==0) {
			echo '<div class="card">
	            <div class="card-body">
                    <h3  class="text-danger text-center"> No Notices</h3>
               </div>
               </div>';
		}

	}


	public function update_notice($ntid){
		$user = new Main_item_party_table();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {
			
				$notice = new NoticeModel();
				

				$newData = [
					'subject'=> strip_tags($this->request->getVar('subject')),
					'details' => $this->request->getVar('notice'),
					'datetime' => now_time($myid),
				];

				$notice->update($ntid,$newData);

			}
		

	}

	public function deletenotices($nid=0)
	{
		$notice = new NoticeModel();

		if ($this->request->getMethod() == 'get') {
				$notice->find($nid);

				$deledata=[
                    'deleted'=>1
                ];

				$notice->update($nid,$deledata);

		}else{
   			return redirect()->to(base_url('notice'));
		}

	}

}
