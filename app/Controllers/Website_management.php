<?php
namespace App\Controllers; 
use App\Models\EnquiriesModel;
use App\Models\SocialMediaModel;
use App\Models\CompanySettings;
use App\Models\CompanySettings2;
use App\Models\PostsModel;
use App\Models\PostThumbnail;
use App\Models\PostCategoryModel;
use App\Models\ReviewsModel;
use App\Models\ClientsModel;
use App\Models\Main_item_party_table;



class Website_management extends BaseController
{
     

    public function index(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings2= new CompanySettings2;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
            
            $etqry = $CompanySettings2->where('company_id',company($myid))->first();
            $data = [
                'title' => 'Aitsun ERP- API Details',
                'user' => $user,
                'conf' => $etqry
            ];
          

            if (is_website(company($user['id']))=='0') {
                echo view('header',$data);
                echo view('website_management/website', $data);
                echo view('footer');
            }else{
          
                echo view('header',$data);
                echo view('website_management/website_management', $data);
                echo view('footer');
            }


           if (isset($_POST['save_sms_email'])) {
            $pu_data = [
                'website_url'=>htmlentities(strip_tags(trim($this->request->getVar('website_url')))), 
            ];
            $update_user=$CompanySettings2->update(get_setting(company($myid),'id'),$pu_data);
            if ($update_user) {
                             ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> sms & email configurations changed.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];
                add_log($log_data);
                            ////////////////////////END ACTIVITY LOG/////////////////
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('website_management'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('website_management'));
            }
        }
    }else{
        return redirect()->to(base_url('users/login'));
    }
    }
    public function enquiries()
    {
        $session=session();
        $UserModel=new Main_item_party_table; 
        $EnquiriesModel=new EnquiriesModel; 
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
            
            if ($_GET) {
                if (isset($_GET['display_name'])) {
                    if (!empty(trim($_GET['display_name']))) {
                        $EnquiriesModel->like('name',$_GET['display_name'],'both');
                        $EnquiriesModel->orLike('email',$_GET['display_name'],'both');
                    }
                }
            }
            $enquiries=$EnquiriesModel->where('company_id',company($myid))->where('deleted',0)->where('enquiry_type','website')->findAll();
            $data=[
                'title'=> 'Website enquiries - Aitsun ERP',
                'user'=> $user, 
                'enquiries'=> $enquiries, 
            ];
            echo view('header',$data);
            echo view('website_management/enquiries', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users/login'));
        }               
    }
    public function delete_enquiries($cid=""){
        $session=session();
        $myid=session()->get('id');
        $EnquiriesModel=new EnquiriesModel;
        $eq=$EnquiriesModel->where('id',$cid)->first();
        $data=[
            'deleted'=>1
        ];
        if ($EnquiriesModel->update($cid,$data)) {
            ////////////////////////CREATE ACTIVITY LOG//////////////
            $log_data=[
                'user_id'=>$myid,
                'action'=> 'Enquiry of <b>'.$eq['name'].'</b> is deleted.',
                'ip'=>get_client_ip(),
                'mac'=>GetMAC(),
                'created_at'=>now_time($myid),
                'updated_at'=>now_time($myid),
                'company_id'=>company($myid),
            ];
            add_log($log_data);
            ////////////////////////END ACTIVITY LOG/////////////////
            $session->setFlashdata('pu_msg','Deleted!');
            return redirect()->to(base_url('website_management/enquiries'));
        }else{
            $session->setFlashdata('pu_er_msg','Failed to saved!');
            return redirect()->to(base_url('website_management/enquiries'));
        }
    }
    public function social_media(){
        $session=session();
        $UserModel=new Main_item_party_table; 
        $SocialMediaModel=new SocialMediaModel; 
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
            
            $soc_model=$SocialMediaModel->where('company_id',company($myid))->orderBy('id','desc')->findAll();
            $data=[
                'title'=> 'Social media - Aitsun ERP',
                'user'=> $user,  
                'social_medias'=>$soc_model
            ];
            echo view('header',$data);
            echo view('website_management/social_media', $data);
            echo view('footer');
            if ($this->request->getMethod() == 'post') {
                $catPost_data = [
                    'name'=>strip_tags(trim($this->request->getVar('socname'))), 
                    'company_id'=>company($myid),
                    'link'=>strip_tags(trim($this->request->getVar('soclink'))), 
                    'class'=>strip_tags(trim($this->request->getVar('socclass'))), 
                    'userid'=>strip_tags(trim($this->request->getVar('socuserid'))), 
                    'token'=>strip_tags(trim($this->request->getVar('socaccess')))
                ];
                $SocialMediaModel->save($catPost_data);
                $session = session();
                $session->setFlashdata('pu_msg', 'Social media added successfully');
                return redirect()->to(base_url('website_management/social_media'));
            }
        }else{
            return redirect()->to(base_url('users/login'));
        }  
    }
    public function deletesoc($id=0)
    {
        $model = new Main_item_party_table();
        $socmod = new SocialMediaModel();
        if ($this->request->getMethod() == 'get') {
            $socmod->find($id);
            $socmod->delete($id);
            $session = session();
            $session->setFlashdata('pu_msg', 'Social media deleted successfully');
            return redirect()->to(base_url('website_management/social_media'));
        }else{
            return redirect()->to(base_url('website_management/social_media'));
        }
    }
    public function editsoc($id=0){
        $model = new Main_item_party_table();
        $socmod = new SocialMediaModel();
        if ($this->request->getMethod() == 'post') {
            $editdatasoc = [
                'name'=>$this->request->getVar('socname'),
                'link'=>$this->request->getVar('soclink'),
                'class'=>$this->request->getVar('socclass'),
                'userid'=>$this->request->getVar('socuserid'),
                'token'=>$this->request->getVar('socaccess')
            ];
            $socmod->update($this->request->getVar('sid'),$editdatasoc);
            $session = session();
            $session->setFlashdata('pu_msg', 'Social media saved');
            return redirect()->to(base_url('website_management/social_media'));
        }else{
            return redirect()->to(base_url('website_management/social_media'));
        }
    }
    public function email_integration(){
        $session=session();
        if($session->has('isLoggedIn')){
            $UserModel= new Main_item_party_table;
            $CompanySettings= new CompanySettings;
            $myid=session()->get('id');
            $con = array( 
                'id' => session()->get('id') 
            );
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) { return redirect()->to(base_url('app_error'));}
            
           
            $etqry = $CompanySettings->where('company_id',company($myid))->first();
            $data = [
                'title' => 'Aitsun ERP- Email integration',
                'user' => $user,
                'conf' => $etqry
            ];
                echo view('header',$data);
                echo view('website_management/email_integration', $data);
                echo view('footer');
       
           if (isset($_POST['save_sms_email'])) {
            $pu_data = [
                'sms_sender'=>htmlentities(strip_tags(trim($this->request->getVar('sms_sender')))),
                'receivers_phone'=>htmlentities(strip_tags(trim($this->request->getVar('receivers_phone')))),
                'source_ref'=>htmlentities(strip_tags(trim($this->request->getVar('source_ref')))),
                'smtp_host'=>htmlentities(strip_tags(trim($this->request->getVar('smtp_host')))),
                'smtp_port'=>htmlentities(strip_tags(trim($this->request->getVar('smtp_port')))),
                'smtp_user'=>htmlentities(strip_tags(trim($this->request->getVar('smtp_user')))),
                'smtp_password'=>htmlentities(strip_tags(trim($this->request->getVar('smtp_password')))),
                'from_name'=>htmlentities(strip_tags(trim($this->request->getVar('from_name')))),
                'email_receiver'=>htmlentities(strip_tags(trim($this->request->getVar('email_receiver'))))
            ];
            $update_user=$CompanySettings->update(get_setting(company($myid),'id'),$pu_data);
            if ($update_user) {
                         ////////////////////////CREATE ACTIVITY LOG//////////////
                $log_data=[
                    'user_id'=>$myid,
                    'action'=>'Company/branch (#'.company($myid).') <b>'.my_company_name(company($myid)).'</b> sms & email configurations changed.',
                    'ip'=>get_client_ip(),
                    'mac'=>GetMAC(),
                    'created_at'=>now_time($myid),
                    'updated_at'=>now_time($myid),
                    'company_id'=>company($myid),
                ];
                add_log($log_data);
                        ////////////////////////END ACTIVITY LOG/////////////////
                $session->setFlashdata('pu_msg', 'Saved!');
                return redirect()->to(base_url('website_management/email_integration'));
            }else{
                $session->setFlashdata('pu_er_msg', 'Failed to save!');
                return redirect()->to(base_url('website_management/email_integration'));
            }
        }
    }else{
        return redirect()->to(base_url('users/login'));
    }
}

public function posts(){
    $session=session();
    $UserModel=new Main_item_party_table; 
    $PostsModel=new PostsModel; 
    if ($session->has('isLoggedIn')){
        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();
        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
       
        if ($_GET) {
            if (isset($_GET['post_title'])) {
                if (!empty(trim($_GET['post_title']))) {
                    $PostsModel->like('title',$_GET['post_title'],'both'); 
                }
            }
        }
        $get_pro = $PostsModel->where('company_id',company($myid))->orderBy("id", "desc")->paginate(5); 
        $data=[
            'title'=> 'Posts - Aitsun ERP',
            'user'=> $user,  
            'posts'=> $get_pro,
            'pager' => $PostsModel->pager,
        ];
        echo view('header',$data);
        echo view('website_management/posts', $data);
        echo view('footer');
    }else{
        return redirect()->to(base_url('users/login'));
    }  
}
public function create_post(){
    $session=session();
    $UserModel=new Main_item_party_table; 
    $PostsModel=new PostsModel; 
    if ($session->has('isLoggedIn')){
        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();
        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
        
        $data=[
            'title'=> 'Create Post - Aitsun ERP',
            'user'=> $user,  
        ];
        echo view('header',$data);
        echo view('website_management/create_post', $data);
        echo view('footer');
    }else{
        return redirect()->to(base_url('users/login'));
    }  
}

public function post_categories(){
    $session=session();
    $UserModel=new Main_item_party_table; 
    $PostCategoryModel=new PostCategoryModel; 
    if ($session->has('isLoggedIn')){
        $myid=session()->get('id');
        $user=$UserModel->where('id',$myid)->first();
        if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
        
        $data=[
            'title'=> 'Post categories - Aitsun ERP',
            'user'=> $user,
            'postcategories'=> $PostCategoryModel->where('company_id',company($myid))->findAll()  
        ];
        echo view('header',$data);
        echo view('website_management/post_categories', $data);
        echo view('footer');

        if ($this->request->getMethod() == 'post') {
            $cat_find = array(" ","&","/","(",")");
            $cat_replace = array("-");
            $cat_slug=str_replace($cat_find,$cat_replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('cat_name'))))));
    
                $catPost_data = [
                    'company_id'=>company($myid),
                    'category_name'=>$this->request->getVar('cat_name'),
                    'slug'=>$cat_slug, 
                ];
                $PostCategoryModel->save($catPost_data);
                 
                $session->setFlashdata('pu_msg', 'Category added successfully');
                return redirect()->to(base_url('website_management/categories'));
        }

    }else{
        return redirect()->to(base_url('users/login'));
    }  
}

public function add_cat_from_ajax(){
    $model = new Main_item_party_table();
    $myid=session()->get('id');
    $PostCategoryModel = new PostCategoryModel();
    if ($this->request->getMethod() == 'post') {
        $cat_find = array(" ","&","/","(",")");
        $cat_replace = array("-");
        $cat_slug=str_replace($cat_find,$cat_replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('cat_name'))))));

        $cat_data = [
            'company_id'=>company($myid),
            'category_name'=>$this->request->getVar('cat_name'), 
            'parent'=>$this->request->getVar('parent'), 
            'slug'=>$cat_slug, 
        ];
        if ($PostCategoryModel->save($cat_data)) {
            $catid=$PostCategoryModel->insertID();
            echo $catid;
        }else{
            echo 0;
        } 
    }else{
        echo 0;
    }
}

public function deletecat($id=0)
{
    $model = new Main_item_party_table();
    $catmodel = new PostCategoryModel();
    if ($this->request->getMethod() == 'get') {
            $catmodel->find($id);
            $catmodel->delete($id);
            $session = session();
            $session->setFlashdata('pu_msg', 'Category deleted successfully');
            return redirect()->to(base_url('website_management/categories'));
    }else{
        return redirect()->to(base_url('website_management/categories'));
    }
}

public function edit_cat($id=0){
    $model = new Main_item_party_table();
    $PostCategoryModel = new PostCategoryModel();
    if ($this->request->getMethod() == 'post') {
        $cat_find = array(" ","&","/","(",")");
        $cat_replace = array("-");
        $cat_slug=str_replace($cat_find,$cat_replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('cat_name'))))));

        $editdatasoc = [
            'category_name'=>$this->request->getVar('cat_name'), 
            'slug'=>$cat_slug, 
        ];
        $PostCategoryModel->update($this->request->getVar('sid'),$editdatasoc);
        $session = session();
        $session->setFlashdata('pu_msg', 'Category saved');
        return redirect()->to(base_url('website_management/categories'));
    }else{
        return redirect()->to(base_url('website_management/categories'));
    }
}


    public function add_post(){
        $session=session();
        $UserModel=new Main_item_party_table; 
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
            if ($this->request->getMethod() == 'post') {
                    $model = new PostsModel();
                    $thummodel= new PostThumbnail();
                    $post_status='published';
                    if (isset($_POST['draft'])) {
                        $post_status='drafted';
                    }
                    if ($this->request->getVar('post_type')=='image') {
                        $img = $this->request->getFile('featured_img');
                        if (!empty(trim($img))) {
                            $filename = $img->getRandomName();
                            $mimetype=$img->getClientMimeType();
                            $img->move('public/images/posts/',$filename);
                            $orginal_size     = $img->getSizeByUnit('mb');
                            $width="";
                            $height="";

                          

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(270, 200, 'center')
                        ->save(FCPATH.'/public/images/posts/big_size'.$filename);

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(100, 80, 'center')
                        ->save(FCPATH.'/public/images/posts/medium_size'.$filename);

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(80, 70, 'center')
                        ->save(FCPATH.'/public/images/posts/small_size'.$filename);

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(1200, 627, 'center')
                        ->save(FCPATH.'/public/images/posts/og_size'.$filename);



                            
                        }else{
                            $filename="";
                            $mimetype="";
                        }
                    }elseif ($this->request->getVar('post_type')=='video') {
                        $video = $this->request->getFile('featured_video');
                        if (!empty(trim($video))) {
                            $filename = $video->getRandomName();
                            $video->move('public/images/posts/',$filename);
                            $mimetype=$video->getClientMimeType();
                        }else{
                            $filename="";
                            $mimetype="";
                        }
                    }elseif ($this->request->getVar('post_type')=='text') {
                        $filename="";
                        $mimetype="";
                    }else{
                        $filename="";
                        $mimetype="";
                    }
                    $find = array(" ","&","/","(",")");
                    $replace = array("-");
                    $slug=str_replace($find,$replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('title'))))));
                    $meta_keyword_slug=str_replace($find,$replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('meta_key'))))));
                    $Post_data = [
                        'company_id'=>company($myid),
                        'title'=>$this->request->getVar('title'),
                        'post_type'=>$this->request->getVar('post_type'), 
                        'category'=>$this->request->getVar('post_category'),
                        'cat_name'=>cat_data($this->request->getVar('post_category'),'category_name'),
                        'cat_slug'=>cat_data($this->request->getVar('post_category'),'slug'),
                        'short_description'=>$this->request->getVar('short_desc'),
                        'description'=>$this->request->getVar('long_desc'),
                        'meta_keyword'=>$this->request->getVar('meta_key'),
                        'meta_keyword_slug'=>$meta_keyword_slug,
                        'video_link'=>$this->request->getVar('video_link'),
                        'post_name'=>$this->request->getVar('post_name'),
                        'project_date'=>$this->request->getVar('project_date'), 
                        'location'=>$this->request->getVar('location'),
                        'meta_description'=>'',
                        'featured'=>$filename,
                        'file_type'=>$mimetype,
                        'alt'=>'',
                        'status'=>$post_status,
                        'slug'=>$slug,
                        'datetime'=>now_time($myid)
                    ];
                    $model->save($Post_data);
                    $insid=$model->insertID();
                    if ($this->request->getVar('post_type')=='image') {
                             foreach($this->request->getFileMultiple('tumbimages') as $file)
                             {   
                                if ($file->isValid()) {
                                    $filename_thumb = $file->getRandomName();
                                    $mimetype_thumb=$file->getClientMimeType();
                                    $file->move('public/images/posts/',$filename_thumb);

                                    $orginal_size     = $file->getSizeByUnit('mb');
                                    $width="";
                                    $height="";


                                    \Config\Services::image()
                                    ->withFile(FCPATH.'/public/images/posts/'.$filename_thumb)
                                    ->fit(270, 200, 'center')
                                    ->save(FCPATH.'/public/images/posts/big_size'.$filename_thumb);

                                    \Config\Services::image()
                                    ->withFile(FCPATH.'/public/images/posts/'.$filename_thumb)
                                    ->fit(100, 80, 'center')
                                    ->save(FCPATH.'/public/images/posts/medium_size'.$filename_thumb);


                                    $thumbdata = [
                                        'post_id'=>$insid,
                                        'thumbnail'=>$filename_thumb
                                    ];
                                    $thummodel->save($thumbdata);
                                }
                             }
                    }
                    $session = session();
                    $session->setFlashdata('pu_msg', 'Post '.ucfirst($post_status).' successfully');
                    return redirect()->to(base_url('website_management/create_post'));
            }
        }
    }
    public function update_post(){
        if ($this->request->getMethod() == 'post') {
                $model = new PostsModel();
                $thummodel= new PostThumbnail(); 

                    $img = $this->request->getFile('featured_img');
                    if (!empty(trim($img))) {
                        $filename = $img->getRandomName();
                        $mimetype=$img->getClientMimeType();
                        $img->move('public/images/posts/',$filename);

                        $orginal_size     = $img->getSizeByUnit('mb');
                            $width="";
                            $height="";

                          

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(270, 200, 'center')
                        ->save(FCPATH.'/public/images/posts/big_size'.$filename);

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(100, 80, 'center')
                        ->save(FCPATH.'/public/images/posts/medium_size'.$filename);

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(80, 70, 'center')
                        ->save(FCPATH.'/public/images/posts/small_size'.$filename);

                        \Config\Services::image()
                        ->withFile(FCPATH.'/public/images/posts/'.$filename)
                        ->fit(1200, 627, 'center')
                        ->save(FCPATH.'/public/images/posts/og_size'.$filename);
                    }else{
                        $filename=$this->request->getVar('old_featured');
                        $mimetype=$this->request->getVar('old_file_type');
                    }
                

                $post_status='published';
                if (isset($_POST['draft'])) {
                    $post_status='drafted';
                }

                $postid=$this->request->getVar('postid');
                $find = array(" ","&","/","(",")");
                $replace = array("-");
                $slug=str_replace($find,$replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('title'))))));
                $meta_keyword_slug=str_replace($find,$replace,strtolower(trim(strip_tags(htmlentities($this->request->getVar('meta_key'))))));
                $Post_data = [
                    'title'=>$this->request->getVar('title'),
                    'post_type'=>$this->request->getVar('post_type'),
                    'category'=>$this->request->getVar('post_category'),
                    'cat_name'=>cat_data($this->request->getVar('post_category'),'category_name'),
                    'cat_slug'=>cat_data($this->request->getVar('post_category'),'slug'),
                    'short_description'=>$this->request->getVar('short_desc'),
                    'description'=>$this->request->getVar('long_desc'),
                    'meta_keyword'=>$this->request->getVar('meta_key'),
                    'meta_keyword_slug'=>$meta_keyword_slug,
                    'video_link'=>$this->request->getVar('video_link'),
                    'post_name'=>$this->request->getVar('post_name'),
                    'project_date'=>$this->request->getVar('project_date'), 
                    'location'=>$this->request->getVar('location'),
                    'meta_description'=>'',
                    'featured'=>$filename,
                    'file_type'=>$mimetype,
                    'alt'=>'',
                    'slug'=>$slug,
                    'status'=>$post_status,
                ];
                $model->update($postid,$Post_data);
                $insid=$postid;
                if ($this->request->getVar('post_type')=='image') {
                         foreach($this->request->getFileMultiple('tumbimages') as $file)
                         {   
                            if ($file->isValid()) {
                                $filename_thumb = $file->getRandomName();
                                $mimetype_thumb=$file->getClientMimeType();
                                $file->move('public/images/posts/',$filename_thumb);

                                $orginal_size     = $file->getSizeByUnit('mb');
                                $width="";
                                $height="";


                                \Config\Services::image()
                                ->withFile(FCPATH.'/public/images/posts/'.$filename_thumb)
                                ->fit(270, 200, 'center')
                                ->save(FCPATH.'/public/images/posts/big_size'.$filename_thumb);

                                \Config\Services::image()
                                ->withFile(FCPATH.'/public/images/posts/'.$filename_thumb)
                                ->fit(100, 80, 'center')
                                ->save(FCPATH.'/public/images/posts/medium_size'.$filename_thumb);

                                    
                                $thumbdata = [
                                    'post_id'=>$insid,
                                    'thumbnail'=>$filename_thumb
                                ];
                                $thummodel->save($thumbdata);
                            }
                         }
                }
                $session = session();
                $session->setFlashdata('pu_msg', 'Post edited successfully');
                return redirect()->to(base_url('website_management/edit_post/'.$postid));
        }
    }

    public function remove_featured($postid=0){
        if ($postid!=0) { 
            $model = new PostsModel();   
            $Post_data = [ 
                'featured'=>'', 
            ];
            if ($model->update($postid,$Post_data)) {
                echo 1;
            }else{
                echo 0;
            }   
        }else{
            echo 0;
        }  
    }


    public function remove_thumbnail($thumid=0){ 
        $PostThumbnail = new PostThumbnail();
        if ($this->request->getMethod() == 'get') {
                $PostThumbnail->find($thumid);
                if ($PostThumbnail->delete($thumid)) {
                    echo 1;
                }
        }else{
           echo 0;
        }
    }

    

    public function edit_post($id=0)
    {
        $session=session();
        $UserModel=new Main_item_party_table; 
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
 
            $PostsModel= new PostsModel();
            $PostThumbnail= new PostThumbnail();
            $single_post=$PostsModel->where('id', $id)->first();

            if ($single_post) {
                $data = [
                    'title'=>'Edit Post | Aitsun',
                    'user'=>$user,
                    'po'=>$single_post,
                    'id_of_post'=>$id
                ]; 
                echo view('header', $data);
                echo view('website_management/edit_post');
                echo view('footer');
                
            }else{
                return redirect()->to(base_url('website_management/posts'));
            }
        }else{
            return redirect()->to(base_url('users'));
        }
        
    }


    public function deletepost($id=0)
    {
        $model = new Main_item_party_table();
        $post_model = new PostsModel();
        if ($this->request->getMethod() == 'get') {
                $post_model->find($id);
                $post_model->delete($id);
                $session = session();
                $session->setFlashdata('pu_msg', 'Post deleted successfully');
                return redirect()->to(base_url('website_management/posts'));
        }else{
            return redirect()->to(base_url('website_management/posts'));
        }
    }


    public function reviews()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $ReviewsModel = new ReviewsModel();
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
            

            $reviews=$ReviewsModel->where('company_id',company($myid))->findAll();
            $data=[
                'title'=> 'Website Management - Aitsun ERP',
                'user'=> $user, 
                'reviews'=>$reviews
            ];
            echo view('header',$data);
            echo view('website_management/reviews', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users/login'));
        }               
    }


    public function add_review(){
    $model = new Main_item_party_table();
    $ReviewsModel = new ReviewsModel();
    $myid=session()->get('id');
    if ($this->request->getMethod() == 'post') {

        $img = $this->request->getFile('profile_pic');
        $filename = $img->getRandomName();
        $mimetype=$img->getClientMimeType();
        $img->move('public/images/review/',$filename);

        $cat_data = [
            'company_id'=>company($myid), 
            'profile_pic'=>$filename, 
            'user_name'=>htmlentities($this->request->getVar('user_name')), 
            'designation'=>htmlentities($this->request->getVar('designation')), 
            'ratings'=>htmlentities($this->request->getVar('ratings')), 
            'review'=>htmlentities($this->request->getVar('review')), 
        ];
        $ReviewsModel->save($cat_data);
        $session = session();
        $session->setFlashdata('pu_msg', 'Review added successfully');
        return redirect()->to(base_url('website_management/reviews'));
 
        }
    }


    public function edit_review()
    {
        $model = new Main_item_party_table();
        $ReviewsModel=new ReviewsModel();

        if ($this->request->getMethod() == 'post') {

            if ($this->request->getFile('profile_pic')!='') {
                $img = $this->request->getFile('profile_pic');
                $filename = $img->getRandomName();
                $mimetype=$img->getClientMimeType();
                $img->move('public/images/review/',$filename);


                $reviewdata = [
                    'profile_pic'=>$filename, 
                    'user_name'=>htmlentities($this->request->getVar('user_name')), 
                    'designation'=>htmlentities($this->request->getVar('designation')), 
                    'ratings'=>htmlentities($this->request->getVar('ratings')), 
                    'review'=>htmlentities($this->request->getVar('review')),

                ];

                }else{

                    $reviewdata = [
                        'user_name'=>htmlentities($this->request->getVar('user_name')), 
                        'designation'=>htmlentities($this->request->getVar('designation')), 
                        'ratings'=>htmlentities($this->request->getVar('ratings')), 
                        'review'=>htmlentities($this->request->getVar('review')),
                    ];
                }
                
                $ReviewsModel->update($this->request->getVar('rid'),$reviewdata);
                $session = session();
                $session->setFlashdata('pu_msg', 'Review updated successfully');
                return redirect()->to(base_url('website_management/reviews'));

        }else{
            return redirect()->to(base_url('website_management/reviews'));
        }
    }


    public function delete_review($id=0)
    {
        $model = new Main_item_party_table();
        $ReviewsModel=new ReviewsModel();

        if ($this->request->getMethod()=='get') {
                $ReviewsModel->find($id);
                $ReviewsModel->delete($id);
                $session = session();
                $session->setFlashdata('pu_msg', 'Review deleted successfully');
                return redirect()->to(base_url('website_management/reviews'));

        }else{
            return redirect()->to(base_url('website_management/reviews'));
        }

    }


    public function clients()
    {
        $session=session();
        $UserModel=new Main_item_party_table;
        $ClientsModel = new ClientsModel();
        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();
            if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}
            

            $clients=$ClientsModel->where('company_id',company($myid))->findAll();
            $data=[
                'title'=> 'Website Management - Aitsun ERP',
                'user'=> $user, 
                'clients'=>$clients
            ];
            echo view('header',$data);
            echo view('website_management/clients', $data);
            echo view('footer');
        }else{
            return redirect()->to(base_url('users/login'));
        }               
    }


    public function add_client(){
    $model = new Main_item_party_table();
    $ClientsModel = new ClientsModel();
    $myid=session()->get('id');
    if ($this->request->getMethod() == 'post') {

        $img = $this->request->getFile('client_logo');
        $filename = $img->getRandomName();
        $mimetype=$img->getClientMimeType();
        $img->move('public/images/client/',$filename);

        $cat_data = [
            'company_id'=>company($myid), 
            'client_logo'=>$filename, 
            'client_name'=>htmlentities($this->request->getVar('client_name')), 
            'url'=>htmlentities($this->request->getVar('url')),
        ];
        $ClientsModel->save($cat_data);
        $session = session();
        $session->setFlashdata('pu_msg', 'Client added successfully');
        return redirect()->to(base_url('website_management/clients'));
 
        }
    }


    public function edit_client()
    {
        $model = new Main_item_party_table();
        $ClientsModel=new ClientsModel();

        if ($this->request->getMethod() == 'post') {

            if ($this->request->getFile('client_logo')!='') {
                $img = $this->request->getFile('client_logo');
                $filename = $img->getRandomName();
                $mimetype=$img->getClientMimeType();
                $img->move('public/images/client/',$filename);


                $reviewdata = [
                    'client_logo'=>$filename, 
                    'client_name'=>htmlentities($this->request->getVar('client_name')), 
                    'url'=>htmlentities($this->request->getVar('url')),

                ];

                }else{

                    $reviewdata = [
                        'client_name'=>htmlentities($this->request->getVar('client_name')), 
                        'url'=>htmlentities($this->request->getVar('url')),
                    ];
                }
                
                $ClientsModel->update($this->request->getVar('cid'),$reviewdata);
                $session = session();
                $session->setFlashdata('pu_msg', 'Client updated successfully');
                return redirect()->to(base_url('website_management/clients'));

        }else{
            return redirect()->to(base_url('website_management/clients'));
        }
    }


    public function delete_client($id=0)
    {
        $model = new Main_item_party_table();
        $ClientsModel=new ClientsModel();

        if ($this->request->getMethod()=='get') {
                $ClientsModel->find($id);
                $ClientsModel->delete($id);
                $session = session();
                $session->setFlashdata('pu_msg', 'Client deleted successfully');
                return redirect()->to(base_url('website_management/clients'));

        }else{
            return redirect()->to(base_url('website_management/clients'));
        }

    }

}