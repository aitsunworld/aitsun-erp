<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\IssuebookModel;

class Library_management extends BaseController
{
	public function index()
	{
		$session=session();
	    $user=new Main_item_party_table();
	    $myid=session()->get('id');
	    $BookModel= new BookModel();
	    
	    $pager = \Config\Services::pager();

	    $results_per_page = 12; 
	    
	    if ($session->has('isLoggedIn')) {
	    	$usaerdata=$user->where('id', session()->get('id'))->first();
	    	

	    		if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	    		

	    		if (check_permission($myid,'manage_library')==true || usertype($myid)=='admin') {}else{return redirect()->to(base_url('app_error/permission_denied'));}


	    		if ($_GET) {
		            if (isset($_GET['serachbook'])) {
		                if (!empty($_GET['serachbook'])) {
		                    $BookModel->like('book_title', $_GET['serachbook'], 'both'); 
		                }
		            }
		            if (isset($_GET['bookcategory'])) {
		                if (!empty($_GET['bookcategory'])) {
		                    $BookModel->like('category', $_GET['bookcategory'], 'both'); 
		                }
		            }
		            
		     
		        }



	    		$books_data=$BookModel->where('company_id',company($myid))->where('deleted',0)->orderBy('id','DESC')->paginate(25);
	    		
	    		$data=[
	    			'title'=>'Library Management | Aitsun ERP',
	    			'user'=>$usaerdata,
	    			'books_data'=>$books_data,
	    			'pager' => $BookModel->pager,

	    		];

	    		
		    	echo view('header',$data);
		    	echo view('library/books');
		    	echo view('footer');


	    	
	    	
	    }else{
	   		return redirect()->to(base_url('users'));
	   	}		
	}




	 public function issuedbooks()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $IssuebookModel = new IssuebookModel();



	      $myid=session()->get('id');
	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();

	        $pager = \Config\Services::pager();

	    	$results_per_page = 12; 
	        

	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	         

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          $issue_book_data=$IssuebookModel->where('company_id',company($myid))->where('deleted',0)->where('status','Not Returned Yet')->paginate(25);

	          $issuedbooks=$IssuebookModel->where('company_id',company($myid))->where('deleted',0)->where('status','Not Returned Yet')->findAll();

	          $data=[
	            'title'=>'Library Management | Erudite ERP',
	            'user'=>$usaerdata,
	            'issue_book_data'=>$issue_book_data,
	            'issuedbooks'=>$issuedbooks,
	    		'pager' => $IssuebookModel->pager,
	            
	          ];

	          
              echo view('header',$data);
              echo view('library/issuedbooks');
              echo view('footer');
	         

	        
	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }





	public function returnedbooks()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      $IssuebookModel = new IssuebookModel();
	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();


	        $pager = \Config\Services::pager();

	    	$results_per_page = 12;
	        

	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	         

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          $return_books=$IssuebookModel->where('company_id',company($myid))->where('return_date <=', now_time($myid))->where('deleted',0)->where('status','Not Returned Yet')->paginate(25);
	          
	          $data=[
	            'title'=>'Library Management | Erudite ERP',
	            'user'=>$usaerdata,
	            'return_books'=>$return_books,
	    		'pager' => $IssuebookModel->pager,
	            
	          ];

	              echo view('header',$data);
	              echo view('library/returnedbooks');
	              echo view('footer');
	         
	        
	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }

	

	public function bookcategory()
	  {
	    $session=session();
	      $user=new Main_item_party_table();
	      $myid=session()->get('id');
	      $CategoryModel= new CategoryModel();
	      
	      if ($session->has('isLoggedIn')) {
	        $usaerdata=$user->where('id', session()->get('id'))->first();
	        

	          if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

	          

	          if ( usertype($myid)=='staff' || usertype($myid)=='admin') {}else{ return redirect()->to(base_url('app_error/permission_denied')); }

	          $book_category=$CategoryModel->where('company_id',company($myid))->where('deleted',0)->orderby('id','desc')->findAll();
	          
	          $data=[
	            'title'=>'Library Management | Erudite ERP',
	            'user'=>$usaerdata,
	            'book_category'=>$book_category
	            
	          ];

	         
              echo view('header',$data);
              echo view('library/bookcategory',$data);
              echo view('footer');
	        

	        
	      }else{
	        return redirect()->to(base_url('users'));
	      }   
	  }


	public function add_books($org=""){
		
	

		if ($this->request->getMethod() == 'post') {
			
				$myid=session()->get('id');
				$bookmodel = new BookModel();

				if (!empty($_FILES['book_img']['name'])) {
					if($_FILES['book_img']['size'] > 500000) { //10 MB (size is also in bytes)
				        
				    } else {

			            $target_dir = "public/uploads/library/";
			            $target_file = $target_dir . time().basename($_FILES["book_img"]["name"]);
			            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			            $imgName = time().basename($_FILES["book_img"]["name"]);
			            move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file);

		                $newData = [
		                    
		                    'book_img'=>$imgName,
		                    'company_id' => $org,
		                    'book_number' => strip_tags($this->request->getVar('book_number')),
							'book_title' => strip_tags($this->request->getVar('book_title')),
							'author' => strip_tags($this->request->getVar('author_name')),
							'category' => strip_tags($this->request->getVar('category')),
							'no_of_books' => strip_tags($this->request->getVar('no_of_books')),
							'datetime'=>now_time($myid),
							
		           		 ];
	           		}

			        }else{
			           
			        $newData = [
			        	'company_id' => $org,
	                    'book_number' => strip_tags($this->request->getVar('book_number')),
						'book_title' => strip_tags($this->request->getVar('book_title')),
						'author' => strip_tags($this->request->getVar('author_name')),
						'category' => strip_tags($this->request->getVar('category')),
						'no_of_books' => strip_tags($this->request->getVar('no_of_books')),
						'datetime'=>now_time($myid),

			            ];

			        }

				if (!empty($_FILES['book_img']['name'])) {
					if ($_FILES['book_img']['size'] < 500000) {

						$bookmodel->save($newData);

						////////////////////////CREATE ACTIVITY LOG//////////////
		                $log_data=[
		                    'user_id'=>$myid,
		                    'action'=>'New book <b>'.strip_tags($this->request->getVar('book_title')).'</b> is added.',
		                    'ip'=>get_client_ip(),
		                    'mac'=>GetMAC(),
		                    'created_at'=>now_time($myid),
		                    'updated_at'=>now_time($myid),
		                    'company_id'=>company($myid),
		                ];

		                add_log($log_data);
		                ////////////////////////END ACTIVITY LOG/////////////////
		                echo 1;

					}else{

						echo 2;
					}

				}else{
					$bookmodel->save($newData);

					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'New book <b>'.strip_tags($this->request->getVar('book_title')).'</b> is added.',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
	                ////////////////////////END ACTIVITY LOG/////////////////
	                 echo 1;
				}
				
					
					
			}

	}


	


	public function update_books($bkid=""){
		if ($this->request->getMethod() == 'post') {
				$myid=session()->get('id');
				$bookmodel = new BookModel();
				$session=session();
					$img = $this->request->getFile('book_img');
					
					if (!empty(trim($img))) {

						if($_FILES['book_img']['size'] > 500000) { //10 MB (size is also in bytes)
				        $filename = '';
					    } else {
 
						$filename = $img->getRandomName();
						$mimetype=$img->getClientMimeType();
			            $img->move('public/uploads/library',$filename);

			            }

			            	
							$users_data = [
								'book_number' => strip_tags($this->request->getVar('book_number')),
								'book_title' => strip_tags($this->request->getVar('book_title')),
								'author' => strip_tags($this->request->getVar('author_name')),
								'category' => strip_tags($this->request->getVar('category')),
								'no_of_books' => strip_tags($this->request->getVar('no_of_books')),
								'book_img'=>$filename,
								'datetime'=>now_time($myid),
							];


					}else{
							
							$users_data = [
								'book_number' => strip_tags($this->request->getVar('book_number')),
								'book_title' => strip_tags($this->request->getVar('book_title')),
								'author' => strip_tags($this->request->getVar('author_name')),
								'category' => strip_tags($this->request->getVar('category')),
								'no_of_books' => strip_tags($this->request->getVar('no_of_books')),
								'datetime'=>now_time($myid),
								
							];
					}
				if (!empty(trim($img))) {
				
				if ($_FILES['book_img']['size'] < 500000) {

					$bookmodel->update($bkid,$users_data);

					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'Book <b>'.strip_tags($this->request->getVar('book_title')).'</b> details is updated.',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
	                ////////////////////////END ACTIVITY LOG/////////////////
	                echo 1;

				}else{
					echo 2;
				}
			}else

			{
				$bookmodel->update($bkid,$users_data);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Book <b>'.strip_tags($this->request->getVar('book_title')).'</b> details is updated.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
	            echo 1;
				
		
		}
			}
	}




	public function add_category($org=""){
		
		$category = new CategoryModel();
				$myid=session()->get('id');
				$session=session();

			if ($this->request->getMethod() == 'post') {
			
				$newData = [
					'category' => strip_tags($this->request->getVar('book_category')),
					'company_id' => $org,
					'datetime' => now_time($myid),
				];

				
				$result=$category->save($newData);


				if($result){
					echo 1;

					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'New book category <b>'.$this->request->getVar('book_category').'</b> is added .',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
		            ////////////////////////END ACTIVITY LOG/////////////////

				}
				else{
					echo 0;
					
				}

			}
		

	}
	



	
	

	public function update_category($ctid=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$category = new CategoryModel();
				$myid=session()->get('id');

				$newData = [
					'category' => strip_tags($this->request->getVar('book_category')),
					'datetime' => now_time($myid),
				];

				$result=$category->update($ctid,$newData);
				if ($result) {
					echo 1;
					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'Book category <b>'.$this->request->getVar('book_category').'</b> is updated .',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
		            ////////////////////////END ACTIVITY LOG/////////////////
				}else{
					echo 0;
				}
				

			}
		

	}

	public function add_issue_books($org=""){
	

		if ($this->request->getMethod() == 'post') {
			
				$issuemodel = new IssuebookModel();
				$BookModel = new BookModel();

				$myid=session()->get('id');
				

				$newData = [
					'company_id' => $org,
					'academic_year' => academic_year($myid),
					'student_id' => strip_tags($this->request->getVar('student')),
					'book_id' => strip_tags($this->request->getVar('issue_book_id')),
					'issued_date' => now_time($myid),
					'return_date' => strip_tags($this->request->getVar('return_date')),
					'status' => 'Not Returned Yet',
					'serial_no' => serial_no_issuedbook(company($myid))
				];

				$issuemodel->save($newData);
				 echo 1;
				$boodata=$BookModel->where('id',strip_tags($this->request->getVar('issue_book_id')))->first();

				$nobo=$boodata['no_of_books']-1;

				$boostk=[
					'no_of_books'=>$nobo
				];

				$BookModel->update($boodata['id'],$boostk);

				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='New book issued from library';
				    $message='';
				    $url=main_base_url().'books'; 
				    $icon=notification_icons('book');
				    $userid=$this->request->getVar('student');
				    $nread=0;
				    $for_who='student';
				    $notid='library';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]	


				   ////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'Book <b>'.book_name(strip_tags($this->request->getVar('issue_book_id'))).'</b> issued to <b>'.user_name(strip_tags($this->request->getVar('student'))).'</b>',
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
	public function update_issue_books($isuid){
	

		if ($this->request->getMethod() == 'post') {
			
				$issuemodel = new IssuebookModel();
				$myid=session()->get('id');

				$newData = [
					'student_id' => strip_tags($this->request->getVar('student')),
					'book_id' => strip_tags($this->request->getVar('book')),
					'return_date' => strip_tags($this->request->getVar('return_date')),
					'status' => 'Not Returned Yet',
				];

				$result=$issuemodel->update($isuid,$newData);
				if ($result) {

					echo 1;
					////////////////////////CREATE ACTIVITY LOG//////////////
	                $log_data=[
	                    'user_id'=>$myid,
	                    'action'=>'The book <b>'.book_name(strip_tags($this->request->getVar('book'))).'</b> that was given to <b>'.user_name(strip_tags($this->request->getVar('student'))).'</b> has been updated',
	                    'ip'=>get_client_ip(),
	                    'mac'=>GetMAC(),
	                    'created_at'=>now_time($myid),
	                    'updated_at'=>now_time($myid),
	                    'company_id'=>company($myid),
	                ];

	                add_log($log_data);
	                ////////////////////////END ACTIVITY LOG/////////////////
				}else{
					echo 0;
				}

			}
		

	}


	

	

	public function notify_return_book(){
		$issuemodel = new IssuebookModel();
		$user = new Main_item_party_table();
		$myid=session()->get('id');
		$usaerdata=$user->where('id', $myid)->first();
		$return_book_data=$issuemodel->where('company_id',company($myid))->where('academic_year',academic_year($myid))->where('return_date <=', now_time())->where('deleted',0)->where('status','Not Returned Yet')->findAll();
		$count=0;
		foreach ($return_book_data as $isb) {
			$count++;

                // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
				    $title='Return date of book <b>'.book_name($isb['book_id']).'</b> is expired';
				    $message='';
				    $url=main_base_url().'books'; 
				    $icon=notification_icons('book');
				    $userid=$isb['student_id'];
				    $nread=0;
				    $for_who='student';
				    $notid='library';
				    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
				// [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]	
		}

		echo '1';

	}

	

	public function deletebook($bid=0)
	{
		$bookmodel = new BookModel();
		$myid=session()->get('id');
		if ($this->request->getMethod() == 'post') {
				$bookmodel->find($bid);
				$deledata=[
                    'deleted'=>1
                ];
				$bookmodel->update($bid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Book <b>'.book_name($bid).'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////


		}else{
   			return redirect()->to(base_url('library_management'));
		}

	}

	public function deletecategory($bcid=0)
	{
		$category = new CategoryModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {
				$category->find($bcid);
				
				$deledata=[
                    'deleted'=>1
                ];
				$category->update($bcid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Book category <b>'.book_cate_name($bcid).'</b> is deleted.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////


		}else{
   			return redirect()->to(base_url('library_management'));
		}

	}
	public function delete_issue_book($isid=0)
	{
		$issuemodel = new IssuebookModel();
		$myid=session()->get('id');


		if ($this->request->getMethod() == 'post') {
				$issuemodel->find($isid);
				$deledata=[
                    'deleted'=>1
                ];
				$issuemodel->update($isid,$deledata);

				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'The book <b>'.book_name(get_issued_book_data($isid,'book_id')).'</b> that was given to <b>'.user_name(get_issued_book_data($isid,'student_id')).'</b> has been deleted',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
                ////////////////////////END ACTIVITY LOG/////////////////


		}else{
   			return redirect()->to(base_url('library_management'));
		}

	}

	public function received_book($revid=0)
	{
		$issuemodel = new IssuebookModel();
		$BookModel = new BookModel();
		$myid=session()->get('id');

		if ($this->request->getMethod() == 'post') {
				$iboo=$issuemodel->where('id',$revid)->first();
				$receivedata=[
                    'status'=>'received'
                ];
				$issuemodel->update($revid,$receivedata);



				$boodata=$BookModel->where('id',$iboo['book_id'])->first();
				$nobo=$boodata['no_of_books']+1;
				$boostk=['no_of_books'=>$nobo];
				$BookModel->update($iboo['book_id'],$boostk);


				////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Book <b>'.book_name(get_issued_book_data($revid,'book_id')).'</b> has been received from <b>'.user_name(get_issued_book_data($revid,'student_id')).'</b>.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];

                add_log($log_data);
	            ////////////////////////END ACTIVITY LOG/////////////////
				
				

		}else{
   			return redirect()->to(base_url('library_management'));
		}

	}
}