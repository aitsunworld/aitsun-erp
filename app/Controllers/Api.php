<?php 
namespace App\Controllers; 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EnquiriesModel; 

class Api extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        return  redirect()->to(base_url());
    }

    public function enquiries($operation='create'){ 

        $EnquiriesModel=new EnquiriesModel; 
        $company_id=10;

        $checkenquiry=$EnquiriesModel->where('email',strip_tags($this->request->getVar('email')))->where('token',strip_tags($this->request->getVar('token')))->where('deleted',0)->where('company_id',$company_id)->first();

        $link=$this->request->getVar('email');
        $token=$this->request->getVar('token');
        $campaign_type=$this->request->getVar('campaign_type');

        $valid_token='CSLWBEMMAR9900537726573763omanindiamarket';
        

      

        $linkdata=[
            'email'=>$link,
            'name'=>$link,
            'message'=>'',
            'datetime'=>now_time_of_company($company_id),
            'subject'=> $campaign_type,
            'token'=>$token,
            'company_id'=>$company_id,
            'campaign_type'=>$campaign_type
        ];

        if (!empty(trim($link))) {
            if ($operation=='create') {
                if (!$checkenquiry) {
                    if ($token==$valid_token) {
                        if ($EnquiriesModel->insert($linkdata)) {
                            $response = [
                                'status'   => 201,
                                'error'    => null,
                                'messages' => [
                                    'success' => 'Enquiry Saved', 
                                ]
                            ];
                        }else{
                            $response = [
                                'status'   => 404,
                                'error'    => null,
                                'messages' => [
                                    'success' => 'Failed', 
                                ]
                            ];
                        }
                    }else{
                        $response = [
                                'status'   => 404,
                                'error'    => null,
                                'messages' => [
                                    'success' => 'Invalid token', 
                                ]
                            ];
                    }
                    
                }else{
                    $response = [
                        'status'   => 404,
                        'error'    => null,
                        'messages' => [
                            'success' => 'Data exist', 
                        ]
                    ];
                }

            }else{
                $response = [
                    'status'   => 404,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Failed', 
                    ]
                ];
            }
        }else{
            $response = [
                'status'   => 404,
                'error'    => null,
                'messages' => [
                    'success' => 'Email is blank', 
                ]
            ];
        }
        

      

        return $this->respondCreated($response); 
    }



    public function link($short_link=""){
        $EnquiriesModel=new EnquiriesModel; 
        $resultpage="Link expired!";

        if (!empty(trim($short_link))) {
            $get_link=$EnquiriesModel->where('email',trim($short_link))->first();
            if ($get_link) { 
                $data=[
                    'get_link'=>$get_link['url'],
                ];

                echo view('short_link',$data);  
            }else{
                echo $resultpage;
            }
        }else{
            echo $resultpage;
        }  
        
    }
}