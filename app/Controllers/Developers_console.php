<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProjectTableModel;
use App\Models\VersionTableModel;
use App\Models\ErrorSolutionsModel;
use App\Models\ErrorSolutionsScreenshotModel; 


class Developers_console extends BaseController
{
    public function index()
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $ProjectTableModel=new ProjectTableModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

        

            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

             
           $projects=$ProjectTableModel->where('company_id',company($myid))->where('deleted',0)->orderBy('project_name','ASC')->findAll();
            
            $data=[
                'title'=>'Developers console',
                'user'=>$user, 
                'projects'=>$projects
            ];

            echo view('header',$data);
            echo view('developers_console/developers_console');
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }



    public function project($project_id='')
    {
        $session=session();

        if ($session->has('isLoggedIn')){

            if (!empty($project_id)) {
                $UserModel=new Main_item_party_table;
                $ProjectTableModel=new ProjectTableModel;
                $VersionTableModel=new VersionTableModel;

                $myid=session()->get('id');
                $con = array( 
                    'id' => session()->get('id') 
                );
                $user=$UserModel->where('id',$myid)->first();

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

               

                if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}
 
               $projects=$ProjectTableModel->where('id',$project_id)->where('deleted',0)->first();

               $versions=$VersionTableModel->where('project_id',$project_id)->where('deleted',0)->orderBy('id','desc')->findAll();

                if ($projects) {
                    $data=[
                        'title'=>'Project | Developers console',
                        'user'=>$user, 
                        'pjr'=>$projects,
                        'versions'=>$versions,
                    ];

                    echo view('header',$data);
                    echo view('developers_console/project');
                    echo view('footer');
                 }else{
                    return redirect()->to(base_url());
                }
                

            }else{
                return redirect()->to(base_url());
            }

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    public function add_project(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ProjectTableModel=new ProjectTableModel;

        if ($this->request->getMethod('post')) {  
            $clientdata=[ 
                'company_id'=>company($myid),
                'project_name'=>strip_tags(trim($this->request->getVar('project_name'))),
                'details'=>strip_tags(trim($this->request->getVar('details'))),
                'datetime'=>now_time($myid),
                'last_modified'=>now_time($myid),
                'added_by'=>$myid,
                'deleted'=>0,
            ];

            

            if ($ProjectTableModel->save($clientdata)) {
                $session->setFlashdata('success_message','Project saved!');
                return redirect()->to(base_url('developers_console'));
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console'));
            }

        }
    }

    public function add_version(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $VersionTableModel=new VersionTableModel;
        $ProjectTableModel=new ProjectTableModel;

        $project_id=strip_tags(trim($this->request->getVar('project_id')));

        if ($this->request->getMethod('post')) {  
            $clientdata=[ 
                'company_id'=>company($myid),
                'project_id'=>$project_id,
                'version_name'=>strip_tags(trim($this->request->getVar('version_name'))),
                'details'=>strip_tags(trim($this->request->getVar('details'))),
                'filename'=>strip_tags(trim($this->request->getVar('filename'))),
                'file_path'=>strip_tags(trim($this->request->getVar('file_path'))),
                'datetime'=>now_time($myid),
                'last_modified'=>now_time($myid),
                'added_by'=>$myid,
                'deleted'=>0,
            ];

            

            if ($VersionTableModel->save($clientdata)) {
                 $dsd=[  
                    'last_modified'=>now_time($myid)
                ];
                $ProjectTableModel->update($project_id,$dsd);

                $session->setFlashdata('success_message','New version added!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }

        }
    }

    public function add_problem(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ErrorSolutionsModel=new ErrorSolutionsModel;
        $ErrorSolutionsScreenshotModel=new ErrorSolutionsScreenshotModel;
        

        $project_id=strip_tags(trim($this->request->getVar('project_id')));

        if ($this->request->getMethod('post')) {  
            
            $clientdata=[ 
                'company_id'=>company($myid),
                'project_id'=>strip_tags(trim($this->request->getVar('project_id'))),
                'error_name'=>strip_tags(trim($this->request->getVar('error_name'))),
                'details'=>trim($this->request->getVar('details')), 
                'type'=>'error', 
                'datetime'=>now_time($myid), 
                'added_by'=>$myid,
                'deleted'=>0,
            ];
 

            if ($ErrorSolutionsModel->save($clientdata)) { 

                $proid=$ErrorSolutionsModel->insertID();
                //uploading multiple image
                foreach($this->request->getFileMultiple('screenshots') as $file)
                 {   
                    if ($file->isValid()) {
                        $filename_thumb = $file->getRandomName();
                        $mimetype_thumb=$file->getClientMimeType();
                        $file->move('public/images/error_screenshots/',$filename_thumb);
                        $thumbdata = [
                            'error_id'=>$proid,
                            'screenshot'=>$filename_thumb
                        ];
                        $ErrorSolutionsScreenshotModel->save($thumbdata);
                    }
                    
                }

                $session->setFlashdata('success_message','New problem added!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }

        }
    }


    public function add_solution(){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ErrorSolutionsModel=new ErrorSolutionsModel;
        $ErrorSolutionsScreenshotModel=new ErrorSolutionsScreenshotModel;
        

        $project_id=strip_tags(trim($this->request->getVar('project_id')));

        if ($this->request->getMethod('post')) {  
            
            $clientdata=[ 
                'company_id'=>company($myid),
                'parent_id'=>strip_tags(trim($this->request->getVar('parent_id'))),
                'error_name'=>strip_tags(trim($this->request->getVar('error_name'))),
                'details'=>trim($this->request->getVar('details')), 
                'type'=>'solution', 
                'datetime'=>now_time($myid), 
                'added_by'=>$myid,
                'deleted'=>0,
            ];
 

            if ($ErrorSolutionsModel->save($clientdata)) { 

                $proid=$ErrorSolutionsModel->insertID();
                //uploading multiple image
                foreach($this->request->getFileMultiple('screenshots') as $file)
                {   
                    if ($file->isValid()) {
                        $filename_thumb = $file->getRandomName();
                        $mimetype_thumb=$file->getClientMimeType();
                        $file->move('public/images/error_screenshots/',$filename_thumb);
                        $thumbdata = [
                            'error_id'=>$proid,
                            'screenshot'=>$filename_thumb
                        ];
                        $ErrorSolutionsScreenshotModel->save($thumbdata);
                    }
                    
                }

                $session->setFlashdata('success_message','New solution added!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }

        }
    }


    public function update_problem($problem_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ErrorSolutionsModel=new ErrorSolutionsModel;
        $ErrorSolutionsScreenshotModel=new ErrorSolutionsScreenshotModel;
         

        if ($this->request->getMethod('post')) {  
            
            $clientdata=[  
                'project_id'=>strip_tags(trim($this->request->getVar('project_id'))),
                'error_name'=>strip_tags(trim($this->request->getVar('error_name'))),
                'details'=>trim($this->request->getVar('details')) 
            ];
 

            if ($ErrorSolutionsModel->update($problem_id,$clientdata)) { 

                $proid=$problem_id;
                //uploading multiple image
                foreach($this->request->getFileMultiple('screenshots') as $file)
                 {   
                    if ($file->isValid()) {
                        $filename_thumb = $file->getRandomName();
                        $mimetype_thumb=$file->getClientMimeType();
                        $file->move('public/images/error_screenshots/',$filename_thumb);
                        $thumbdata = [
                            'error_id'=>$proid,
                            'screenshot'=>$filename_thumb
                        ];
                        $ErrorSolutionsScreenshotModel->save($thumbdata);
                    }
                    
                }

                $session->setFlashdata('success_message','Saved!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }

        }
    }


    public function delete_problem($problem_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ErrorSolutionsModel=new ErrorSolutionsModel;
        $ErrorSolutionsScreenshotModel=new ErrorSolutionsScreenshotModel;
         

        if ($this->request->getMethod('post')) {  
            
            $clientdata=[  
                'deleted'=>1,  
            ]; 

            if ($ErrorSolutionsModel->update($problem_id,$clientdata)) { 

                $proid=$problem_id;
               

                $session->setFlashdata('success_message','Deleted!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }

        }
    }

    public function delete_screenshot($screen_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table; 
        $ErrorSolutionsScreenshotModel=new ErrorSolutionsScreenshotModel;
         

        if ($this->request->getMethod('post')) {  
            
              

            if ($ErrorSolutionsScreenshotModel->where('id',$screen_id)->delete()) {  

                $session->setFlashdata('success_message','Deleted!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/errors_solutions'));
            }

        }
    }
    

    



    public function update_version($version_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $VersionTableModel=new VersionTableModel;
        $ProjectTableModel=new ProjectTableModel;

        $project_id=strip_tags(trim($this->request->getVar('project_id')));

        if ($this->request->getMethod('post')) {  
            $clientdata=[   
                'version_name'=>strip_tags(trim($this->request->getVar('version_name'))),
                'details'=>strip_tags(trim($this->request->getVar('details'))),
                'filename'=>strip_tags(trim($this->request->getVar('filename'))),
                'file_path'=>strip_tags(trim($this->request->getVar('file_path'))), 
                'last_modified'=>now_time($myid), 
            ];

            

            if ($VersionTableModel->update($version_id,$clientdata)) {
                  

                $session->setFlashdata('success_message','Version updated!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }else{
                $session->setFlashdata('error_message','Failed to update!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }

        }
    }
    
    public function delete_version($version_id="",$project_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $VersionTableModel=new VersionTableModel;
        $ProjectTableModel=new ProjectTableModel;

        

        if ($this->request->getMethod('post')) {  
            $clientdata=[   
                'deleted'=>1 
            ];
 

            if ($VersionTableModel->update($version_id,$clientdata)) { 
                $session->setFlashdata('success_message','Version deleted!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }else{
                $session->setFlashdata('error_message','Failed to update!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }

        }
    }
 

    public function update_project($project_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ProjectTableModel=new ProjectTableModel;

        if ($this->request->getMethod('post')) {  
            $clientdata=[  
                'project_name'=>strip_tags(trim($this->request->getVar('project_name'))),
                'details'=>strip_tags(trim($this->request->getVar('details'))), 
            ];

            

            if ($ProjectTableModel->update($project_id,$clientdata)) {
                $session->setFlashdata('success_message','Project saved!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }else{
                $session->setFlashdata('error_message','Failed to save!');
                return redirect()->to(base_url('developers_console/project').'/'.$project_id);
            }

        }
    }

    public function delete_project($project_id=""){
        $session=session();

        $myid=session()->get('id');
        $con = array( 
            'id' => session()->get('id') 
        );
        $UserModel=new Main_item_party_table;
        $ProjectTableModel=new ProjectTableModel;

        if (!empty($project_id)) {  

            $clientdata=[  
                'deleted'=>1,
            ]; 

            if ($ProjectTableModel->update($project_id,$clientdata)) {
                $session->setFlashdata('success_message','Project deleted!');
                return redirect()->to(base_url('developers_console'));
            }else{
                $session->setFlashdata('error_message','Failed to delete!');
                return redirect()->to(base_url('developers_console'));
            }

        }else{ 
            return redirect()->to(base_url('developers_console'));
        }
    }

    public function errors_solutions(){
        $session=session();

        if ($session->has('isLoggedIn')){

            $UserModel=new Main_item_party_table;
            $ErrorSolutionsModel=new ErrorSolutionsModel;

            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();

            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}



            if (check_permission($myid,'manage_aitsun_keys')==true || usertype($myid) =='admin') {}else{return redirect()->to(base_url());}

             
           $errors=$ErrorSolutionsModel->where('company_id',company($myid))->where('deleted',0)->where('type','error')->orderBy('id','desc')->findAll();
            
            $data=[
                'title'=>'Errors & Solutions Developers console',
                'user'=>$user, 
                'errors'=>$errors
            ];

            echo view('header',$data);
            echo view('developers_console/error_solutions');
            echo view('footer');

        }else{
            return redirect()->to(base_url('users/login'));
        }
    }

    
}
