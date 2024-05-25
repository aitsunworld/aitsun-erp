<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\ProductsModel;
use App\Models\AccountCategory;
use App\Models\CustomerBalances;
use App\Models\PaymentsModel;
use App\Models\LeadModel;
use App\Models\FollowersModel;
use App\Models\ActivitiesNotes; 
use App\Models\TasksModel;
use App\Models\TaskDateModel;
use App\Models\MessageFileModel;
use App\Models\ProductrequestsModel;
use App\Models\Companies;



class Purchase_confirmation extends BaseController
{
    public function index()
        {
            $session=session();
            $UserModel=new Main_item_party_table;
            $AccountCategory=new AccountCategory;
            $CustomerBalances=new CustomerBalances;
            $ProductrequestsModel=new ProductrequestsModel;
            $LeadModel = new LeadModel();
            $FollowersModel= new FollowersModel;


            if ($session->has('isLoggedIn')){
                $myid=session()->get('id');
                $user=$UserModel->where('id',$myid)->first();

                if (is_crm(company($myid))) {

                    if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

                  

                    if (usertype($myid)=='customer') {
                        return redirect()->to(base_url('customer_dashboard'));
                    }

                    


                $entry_leads=array();
                $site_leads=array();
                $direct_loss_leads=array();
                $quoatlead=array();
                $follow_uplead=array();
                $lostleads=array();
                $sales_orderlead=array();
                $deliver_notelead=array();
                $deliverylead=array();
                $payment_followuplead=array();
                $completeleads=array();
                $invoicelead=array();
                $cancelledleads=array();


                if($_GET){

                    if(empty($_GET['followers']) && !empty($_GET['search_leads'])){
                        $entry_leads=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'entry')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $site_leads=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'site_visit')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $direct_loss_leads=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'direct_loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $quoatlead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'quotation')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $follow_uplead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'follow_up')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $lostleads=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                    $sales_orderlead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'sales_order')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $deliver_notelead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'deliver_note')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $deliverylead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'delivery')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $invoicelead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'invoice')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $payment_followuplead=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'payment_followup')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $completeleads=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'complete')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                    $cancelledleads=$LeadModel->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_status', 'cancelled')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                    }elseif(!empty($_GET['followers']) && empty($_GET['search_leads'])){

                        $flowers=$FollowersModel->select('lead_id','follower_id')->distinct('lead_id')->where('follower_id',$this->request->getGet('followers'))->findAll();$FollowersModel->where('follower_id',$this->request->getGet('followers'))->findAll();
                        

                        foreach ($flowers as $flr) {

                        $entry_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'entry')->orderBy('id', 'desc')->findAll();

                        foreach ($entry_flow as $fl) {
                            array_push($entry_leads, $fl);
                        }
                         $site_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'site_visit')->orderBy('id', 'desc')->findAll();

                        foreach ($site_flow as $fl) {
                            array_push($site_leads, $fl);
                        }
                         $direct_loss_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'direct_loss')->orderBy('id', 'desc')->findAll();

                        foreach ($direct_loss_flow as $fl) {
                            array_push($direct_loss_leads, $fl);
                        }

                         $quoatlead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'quotation')->orderBy('id', 'desc')->findAll();

                        foreach ($quoatlead_flow as $fl) {
                            array_push($quoatlead, $fl);
                        }

                         $uplead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'follow_up')->orderBy('id', 'desc')->findAll();

                        foreach ($uplead_flow as $fl) {
                            array_push($follow_uplead, $fl);
                        }
                         $lostleads_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'loss')->orderBy('id', 'desc')->findAll();

                        foreach ($lostleads_flow as $fl) {
                            array_push($lostleads, $fl);
                        }
                        $sales_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'sales_order')->orderBy('id', 'desc')->findAll();

                        foreach ($sales_flow as $fl) {
                            array_push($sales_orderlead, $fl);
                        }
                        $deliver_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'deliver_note')->orderBy('id', 'desc')->findAll();

                        foreach ($deliver_flow as $fl) {
                            array_push($deliver_notelead, $fl);
                        }
                         $deliverylead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'delivery')->orderBy('id', 'desc')->findAll();

                        foreach ($deliverylead_flow as $fl) {
                            array_push($deliverylead, $fl);
                        }
                        $payment_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'payment_followup')->orderBy('id', 'desc')->findAll();

                        foreach ($payment_flow as $fl) {
                            array_push($payment_followuplead, $fl);
                        }
                        $completeleads_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'complete')->orderBy('id', 'fldesc')->findAll();

                        foreach ($completeleads_flow as $fl) {
                            array_push($completeleads, $fl);
                        }

                        $cancelledleads_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'cancelled')->orderBy('id', 'fldesc')->findAll();

                        foreach ($cancelledleads_flow as $fl) {
                            array_push($cancelledleads, $fl);
                        }

                        $invoicelead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'invoice')->orderBy('id', 'desc')->findAll();

                        foreach ($invoicelead_flow as $fl) {
                            array_push($invoicelead, $fl);
                        }
                        }


                    }elseif($_GET['followers'] && $_GET['search_leads']) {

                        $flowers=$FollowersModel->where('follower_id',$this->request->getGet('followers'))->findAll();
                        foreach ($flowers as $flr) {

                            $entry_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'entry')->orderBy('id', 'desc')->findAll();

                            foreach ($entry_flow as $fl) {
                                array_push($entry_leads, $fl);
                            }
                             $site_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'site_visit')->orderBy('id', 'desc')->findAll();

                            foreach ($site_flow as $fl) {
                                array_push($site_leads, $fl);
                            }
                             $direct_loss_flow=$LeadModel->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->where('lead_status', 'direct_loss')->orderBy('id', 'desc')->findAll();

                            foreach ($direct_loss_flow as $fl) {
                                array_push($direct_loss_leads, $fl);
                            }

                             $quoatlead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('company_id',company($myid))->where('lead_status', 'quotation')->orderBy('id', 'desc')->findAll();

                            foreach ($quoatlead_flow as $fl) {
                                array_push($quoatlead, $fl);
                            }

                             $uplead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'follow_up')->orderBy('id', 'desc')->findAll();

                            foreach ($uplead_flow as $fl) {
                                array_push($follow_uplead, $fl);
                            }
                             $lostleads_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'loss')->orderBy('id', 'desc')->findAll();

                            foreach ($lostleads_flow as $fl) {
                                array_push($lostleads, $fl);
                            }
                            $sales_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'sales_order')->orderBy('id', 'desc')->findAll();

                            foreach ($sales_flow as $fl) {
                                array_push($sales_orderlead, $fl);
                            }
                            $deliver_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'deliver_note')->orderBy('id', 'desc')->findAll();

                            foreach ($deliver_flow as $fl) {
                                array_push($deliver_notelead, $fl);
                            }
                             $deliverylead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'delivery')->orderBy('id', 'desc')->findAll();

                            foreach ($deliverylead_flow as $fl) {
                                array_push($deliverylead, $fl);
                            }
                            $payment_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'payment_followup')->orderBy('id', 'desc')->findAll();

                            foreach ($payment_flow as $fl) {
                                array_push($payment_followuplead, $fl);
                            }
                            $completeleads_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'complete')->orderBy('id', 'fldesc')->findAll();

                            foreach ($completeleads_flow as $fl) {
                                array_push($completeleads, $fl);
                            }

                            $cancelledleads_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'cancelled')->orderBy('id', 'fldesc')->findAll();

                            foreach ($cancelledleads_flow as $fl) {
                                array_push($cancelledleads, $fl);
                            }

                            $invoicelead_flow=$LeadModel->where('deleted', 0)->where('lead_department','purchase')->where('id', $flr['lead_id'])->where('company_id',company($myid))->groupStart()->like('lead_name',$_GET['search_leads'],'both')->orLike('company_name',$_GET['search_leads'])->groupEnd()->where('lead_status', 'invoice')->orderBy('id', 'desc')->findAll();

                            foreach ($invoicelead_flow as $fl) {
                                array_push($invoicelead, $fl);
                            }
                        }

                    }else{
                       $entry_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'entry')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $site_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'site_visit')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $direct_loss_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'direct_loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $quoatlead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'quotation')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $follow_uplead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'follow_up')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $lostleads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                        $sales_orderlead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'sales_order')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $deliver_notelead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'deliver_note')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $deliverylead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'delivery')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $invoicelead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'invoice')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $payment_followuplead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'payment_followup')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                        $completeleads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'complete')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                        $cancelledleads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'cancelled')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);
                    }
                }else{

                    $entry_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'entry')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $site_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'site_visit')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $direct_loss_leads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'direct_loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $quoatlead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'quotation')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $follow_uplead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'follow_up')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $lostleads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                    $sales_orderlead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'sales_order')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $deliver_notelead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'deliver_note')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $deliverylead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'delivery')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $invoicelead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'invoice')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $payment_followuplead=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'payment_followup')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll();

                    $completeleads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'complete')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                    $cancelledleads=$LeadModel->where('deleted', 0)->where('company_id',company($myid))->where('lead_status', 'cancelled')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150);

                    }

                    if ($user['u_type']=='admin' || check_permission($myid,'manage_crm')==true) {
                      $data=[
                        'title'=> 'Aitsun ERP-Purchase confirmation',
                        'user'=> $user,
                        'entry_leads'=> $entry_leads,
                        'site_visit_leads'=> $site_leads,
                        'direct_loss_leads'=>$direct_loss_leads,
                        'quoation_leads'=> $quoatlead,
                        'follow_uplead'=> $follow_uplead,
                        'lost_leads'=> $lostleads,
                        'sales_orderlead'=>$sales_orderlead,
                        'deliver_notelead'=>$deliver_notelead,
                        'deliverylead'=>$deliverylead,
                        'invoicelead'=>$invoicelead,
                        'payment_followuplead'=>$payment_followuplead,
                        'completeleads'=> $completeleads,
                        'cancelledleads'=> $cancelledleads,

                        
                      ];
                    }else{

                      $data=[
                        'title'=> 'Aitsun ERP-Purchase confirmation',
                        'user'=> $user,
                        'entry_leads'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'entry')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'site_visit_leads'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'site_visit')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'direct_loss_leads'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'direct_loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'quoation_leads'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'quotation')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'follow_uplead'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'follow_up')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'lost_leads'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'loss')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150),

                        'sales_orderlead'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'sales_order')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'deliver_notelead'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'deliver_note')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'deliverylead'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'delivery')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'invoicelead'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'invoice')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'payment_followuplead'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'payment_followup')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(),

                        'completeleads'=> $LeadModel->where('deleted', 0)->where('company_id',company($myid))->groupStart()->where('followers', $user['id'])->orWhere('followers',0)->groupEnd()->where('lead_status', 'complete')->where('lead_department','purchase')->orderBy('id', 'DESC')->findAll(150),
                        
                      ];

                    }
                    echo view('header',$data);
                    echo view('purchase_confirmation/crm', $data);
                    echo view('footer');
                }else{
                    return redirect()->to(base_url());
                }

            }else{
                return redirect()->to(base_url('users/login'));
            }               
    }

    public function store()
    {  
         $session=session();

         $UserModel= new Main_item_party_table();
         $LeadModel = new LeadModel();
         $FollowersModel = new FollowersModel();

        if ($session->has('isLoggedIn')){
            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

              

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

            $data=[
              'title'=> 'Aitsun ERP-CRM',
              'user'=> $user,
            ];

        $data = [
            'company_id'=>company($myid),
            'cr_customer'=>strip_tags($this->request->getVar('cr_customer')),
            'lead_name' => strip_tags($this->request->getVar('lead_name')),
            'description'=> strip_tags($this->request->getVar('lead_description')),  
            'lead_status' => 'entry', 
            'responsible_user' =>$myid, 
            'created_at' => now_time($myid),
            'lead_date' => strip_tags($this->request->getVar('date')),
            'updated_at' => now_time($myid),  
            'lead_department' => 'purchase',
            'lpo' => strip_tags($this->request->getVar('lpo')),
            'quotation_no' => strip_tags($this->request->getVar('quotation')),
            'amount' => strip_tags($this->request->getVar('amount'))   

        ];
       
        $save = $LeadModel->save($data);
        $inserid=$LeadModel->insertID();
        if ($save) {

            //adding multiplae followers
            if ($this->request->getVar('followers')) {
                foreach ($this->request->getVar('followers') as $i => $value) {
                    $folloers_data=[
                        'follower_id'=>$this->request->getVar('followers')[$i],
                        'lead_id'=>$inserid
                    ];
                    if ($this->request->getVar('followers')[$i]!=0) {
                        $FollowersModel->insert($folloers_data);
                    }
                    
                }
            }
                
            //adding multiplae followers


          $action='Purchase lead created: '.strip_tags($this->request->getVar('lead_name'));
          create_log($inserid,$action,$myid);

          $ActivitiesNotes = new ActivitiesNotes();
          $notedata = [
              'company_id'=>company($myid),
              'lead_id' => $inserid,
              'activities' => '',
              'type' => 'note',          
              'note' => strip_tags($this->request->getVar('note')),
              'user_id' =>$myid,
              'created_at' => now_time($myid),
              'updated_at' => now_time($myid)
          ];
          if (!empty(trim(strip_tags($this->request->getVar('note'))))) {
            $save = $ActivitiesNotes->insert($notedata);
          }


        // // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
        //     $title='New Project <b>'.strip_tags($this->request->getVar('lead_name')).'</b> added.';
        //     $message='';
        //     $url=base_url().'/crm'; 
        //     $icon=notification_icons('user');
        //     $userid='all';
        //     $nread=0;
        //     $for_who='admin';
        //     $notid='project';
        //     notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
        // // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]



           //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$inserid,
               'task'=>'New lead <b>'.strip_tags($this->request->getVar('lead_name')).'</b> is created',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>strip_tags($this->request->getVar('lead_status')),
               'task_type'=>'Creation',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////


            session()->setFlashdata('sucmsg', 'Saved!');
            return redirect()->to(base_url('purchase_confirmation/details/'.$inserid));

        }else{
            session()->setFlashdata('failmsg', 'Failed to save!');
            return redirect()->to(base_url('purchase_confirmation'));
        }

        }else{
                return redirect()->to(base_url());
            }
        }
        return redirect()->to(base_url('users/login'));
    }


    public function update_status()
    {  
 
        helper(['form', 'url']);
         
        $usermodel= new Main_item_party_table();
        $model = new LeadModel();
        $LeadModel = new LeadModel();
        $Companies = new Companies();

        $leadid=strip_tags($this->request->getVar('lead'));
        $lead_status=strip_tags($this->request->getVar('status'));
        $data = [];
        $myid=session()->get('id');

        $llldat=$model->where('id', $leadid)->first();
        $fromstatus=purchase_lead_status_name($llldat['lead_status']);

        $data = [
            'lead_status' => $lead_status
        ];

        $save = $model->update($leadid,$data);

        $status=purchase_lead_status_name($lead_status);
        $statusclass=purchase_status_bg($lead_status);
        
        if ($status!=$fromstatus) {
          $action='Moved to: <span class="note_span '.$statusclass.'">'.$status.'</span> from '.$fromstatus;
          create_log($leadid,$action,$myid);
        }

         //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'Purchase lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b>',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>$lead_status,
               'task_type'=>'Lead Moved',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////


           /////////////////  MOVE LEAD NOTIFICATIONS ///////////////
           // $get_branches=$Companies->where('parent_company', main_company_id($myid));
           //      $LeadModel->where('company_id',company($myid));
           //      $LeadModel->groupStart();
                
           //      foreach($get_branches->findAll() as $ci){
           //          if ($ci['id']!=company($myid)) {
           //              $LeadModel->orWhere('company_id',$ci['id']);
           //          }
           //      }
           //      $LeadModel->groupEnd();
                $get_leads_of_all_branch=$LeadModel->where('id',$llldat['id'])->findAll();

                foreach ($get_leads_of_all_branch as $led) {


                    if ($led['lead_by']!=0) {
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]

                            $title='Purchase lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
                            $message='';
                            $url=base_url().'/crm/details/'.$led['id']; 
                            $icon=notification_icons('leads');
                            $userid=$led['lead_by'];
                            $nread=0;
                            $for_who='admin';
                            $notid='user';
                            notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                    }

                    

                        foreach(get_admins_of_company($led['company_id']) as $cid){
                            if ($led['lead_by']!=$cid['id']) {
                                // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                                    $title='Purchase lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
                                    $message='';
                                    $url=base_url().'/crm/details/'.$led['id']; 
                                    $icon=notification_icons('leads');
                                    $userid=$cid['id'];
                                    $nread=0;
                                    $for_who='admin';
                                    $notid='user';
                                    notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                                // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            }
                                    
                        }
                    
                    

                    foreach(get_users_by_permission($led['company_id'],'manage_crm') as $use){
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='Purchase lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
                            $message='';
                            $url=base_url().'/crm/details/'.$led['id']; 
                            $icon=notification_icons('leads');
                            $userid=$use['user'];
                            $nread=0;
                            $for_who='admin';
                            $notid='user';
                            notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                    }

                    foreach(get_followers_of_lead($led['id']) as $fol){
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                            $title='Purchase lead <b>'.$llldat['lead_name'].'</b> is moved to: <b>'.$status.'</b> from <b>'.$fromstatus.'</b> in '.htmlentities(get_company_data(company($myid),'company_name'));
                            $message='';
                            $url=base_url().'/crm/details/'.$led['id']; 
                            $icon=notification_icons('leads');
                            $userid=$fol['follower_id'];
                            $nread=0;
                            $for_who='admin';
                            $notid='user';
                            notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid); 
                        // [[[[[[[[[[[[[[[[[[[[[[[[[NOTIFICATION]]]]]]]]]]]]]]]]]]]]]]]]]
                    }

                
                }



        
    }


    public function details($leadid="")
    {   
      $session=session(); 
       if ($session->has('isLoggedIn')){

            $UserModel = new Main_item_party_table();
            $LeadModel = new LeadModel();
            $ActivitiesNotes = new ActivitiesNotes();
            $TasksModel = new TasksModel();

            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

              

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }

            if (!empty($leadid)) {
              $leadsdata=$LeadModel->where('id', $leadid)->where('deleted',0)->first();
              if ($leadsdata) {
                  $data=[
                    'title'=> 'Project Details | Aitsun Projects',
                    'user'=> $user,
                    'lead_data'=>$leadsdata,
                    'activities'=>$ActivitiesNotes->where('lead_id',$leadid)->where('deleted',0)->findAll(),
                    'tasks'=>$TasksModel->where('lead_id',$leadid)->where('deleted',0)->findAll(),
                  ];

                  echo view('header',$data);   
                  echo view('purchase_confirmation/details');
                  echo view('footer');
              }else{
                return redirect()->to(base_url('purchase_confirmation'));
              }
            }else{
              return redirect()->to(base_url('purchase_confirmation'));
            }

        }else{
                    return redirect()->to(base_url());
                }
            
            
          }else{
            return redirect()->to(base_url('users'));

          }
        
    }


    public function delete($lead_id=""){
            
            $session=session();
            $myid=session()->get('id');

            $LeadModel= new LeadModel;
            $lead_data=$LeadModel->where('id',$lead_id)->first();


            $deledata=[
                'deleted'=>1
            ];
            $del=$LeadModel->update($lead_id,$deledata);



            if ($del) {
                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Lead <b>'.htmlentities($lead_data['lead_name']).'</b> is deleted',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Delete',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                $session->setFlashdata('sucmsg', 'Deleted!');
                return redirect()->to(base_url('purchase_confirmation'));
            }else{
                $session->setFlashdata('failmsg', 'Failed to delete!');
                return redirect()->to(base_url('purchase_confirmation'));
            }
            

         
        }



    public function delete_task($task_id="",$lead_id=""){
            
            $session=session();
            $myid=session()->get('id');

            $TasksModel= new TasksModel;
            $LeadModel= new LeadModel;

            $task_data=$TasksModel->where('id',$task_id)->first();
            $lead_data=$LeadModel->where('id',$lead_id)->first();

            $deledata=[
                'deleted'=>1
            ];
            $del=$TasksModel->update($task_id,$deledata);

            if ($del) {

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Task <b>'.$task_data['task'].'</b> is deleted under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Task delete',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////

                $session->setFlashdata('sucmsg', 'Deleted!');
                return redirect()->to(base_url('purchase_confirmation/details/'.$lead_id));
            }else{

                $session->setFlashdata('failmsg', 'Failed to delete!');
                return redirect()->to(base_url('purchase_confirmation/details/'.$lead_id));
            }
            

         
        }


    public function delete_note($note_id="",$lead_id=""){
            
            $session=session();
            $myid=session()->get('id');

            $ActivitiesNotes= new ActivitiesNotes;
            $LeadModel= new LeadModel;
            $lead_data=$LeadModel->where('id',$lead_id)->first();

            $note_data=$ActivitiesNotes->where('id',$note_id)->first();

            $deledata=[
                'deleted'=>1
            ];

            $del=$ActivitiesNotes->update($note_id,$deledata);

            if ($del) {

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Note <b>'.$note_data['note'].'</b> is deleted under lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Note delete',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                $session->setFlashdata('sucmsg', 'Deleted!');
                return redirect()->to(base_url('purchase_confirmation/details/'.$lead_id));
            }else{

                $session->setFlashdata('failmsg', 'Failed to delete!');
                return redirect()->to(base_url('purchase_confirmation/details/'.$lead_id));
            }
            

         
        }


    public function update($leadid="")
    {  
        $session=session(); 
           if ($session->has('isLoggedIn')){

            $UserModel = new Main_item_party_table();
            $LeadModel = new LeadModel();
            $TasksModel = new TasksModel();

            $myid=session()->get('id');
            $user=$UserModel->where('id',$myid)->first();

            $FollowersModel = new FollowersModel();

            if (is_crm(company($myid))) {

                if (app_status(company($myid))==0) {return redirect()->to(base_url('app_error'));}

              

                if (usertype($myid)=='customer') {
                    return redirect()->to(base_url('customer_dashboard'));
                }


        $llldat=$LeadModel->where('id', $leadid)->first();
        $fromstatus=purchase_lead_status_name($llldat['lead_status']);

        $data = [
            'cr_customer'=>strip_tags($this->request->getVar('cr_customer')),
            'lead_name' => strip_tags($this->request->getVar('lead_name')),
            'description'=> strip_tags($this->request->getVar('lead_description')),  
            'lead_status' => strip_tags($this->request->getVar('lead_status')), 
            'updated_at' => now_time($myid), 
            'lead_date' => strip_tags($this->request->getVar('date')),
            'lpo' => strip_tags($this->request->getVar('lpo')),
            'quotation_no' => strip_tags($this->request->getVar('quotation')),
            'amount' => strip_tags($this->request->getVar('amount')) 
        ];

         
        
        $save = $LeadModel->update($leadid,$data);


        //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'Purchase lead <b>'.strip_tags($this->request->getVar('lead_name')).'</b> is updated',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>strip_tags($this->request->getVar('lead_status')),
               'task_type'=>'Update',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////



        if ($save) {

            $FollowersModel->where('id',$leadid)->delete();

            $deletebeforeupdate=$FollowersModel->where('lead_id',$leadid)->delete();

        //adding multiplae followers
            if ($this->request->getVar('followers')) {
                foreach ($this->request->getVar('followers') as $i => $value) {
                    $folloers_data=[
                        'follower_id'=>$this->request->getVar('followers')[$i],
                        'lead_id'=>$leadid
                    ];
                    if ($this->request->getVar('followers')[$i]!=0) {
                        $FollowersModel->insert($folloers_data);
                    }
                    
                }
            }
                
            //adding multiplae followers

        $status=purchase_lead_status_name(strip_tags($this->request->getVar('lead_status')));
        $statusclass=purchase_status_bg(strip_tags($this->request->getVar('lead_status')));
        
        if ($status!=$fromstatus) {
          $action='Moved to: <span class="note_span '.$statusclass.'">'.$status.'</span> from '.$fromstatus;
          create_log($leadid,$action,$myid);
        }

        $session->setFlashdata('sucmsg', 'Saved!');
        return redirect()->to(base_url('purchase_confirmation/details/'.$leadid));
            
        }else{

        $session->setFlashdata('sucmsg', 'Failed to save!');
        return redirect()->to(base_url('purchase_confirmation/details/'.$leadid));


        }

        
        }else{
                return redirect()->to(base_url());
            }

        }else{
            return redirect()->to(base_url('users'));

          }
    }





    public function add_note($leadid="")
    {  
        $session=session(); 
           if ($session->has('isLoggedIn')){

            $Usermodel = new Main_item_party_table();
            $ActivitiesNotes = new ActivitiesNotes();
            $MessageFileModel = new MessageFileModel();

            $LeadModel = new LeadModel();
            $lead_data=$LeadModel->where('id',$leadid)->first();


            $myid=session()->get('id');

            $countfile=0;
             foreach ($this->request->getFileMultiple('messagefile') as $file) {
                if ($file->isValid()) {
                    $countfile++;
                }
                
             }
            
            $data = [
                'lead_id' => $leadid,
                'company_id'=>company($myid),
                'activities' => '',
                'type' => 'note',          
                'note' => strip_tags($this->request->getVar('note')),
                'user_id' =>$myid,
                'created_at' => now_time($myid),
                'updated_at' => now_time($myid)
            ];
            if (!empty(trim(strip_tags($this->request->getVar('note')))) || $countfile>0) {
              $save = $ActivitiesNotes->insert($data);


              $noteid=$ActivitiesNotes->insertID();


            //  //////////////////////////////////////////////////////
           //                    ADD TASK REPORT                 //
           // //////////////////////////////////////////////////////
           $task_report_data=[
               'company_id'=>company($myid),
               'lead_id'=>$leadid,
               'task'=>'New note <b>'.strip_tags($this->request->getVar('note')).'</b> is created under purchase lead <b>'.htmlentities($lead_data['lead_name']).'</b>',
               'datetime'=>now_time($myid),
               'created_by'=>$myid,
               'ip'=>get_client_ip(),
               'mac'=>GetMAC(),
               'grid_no'=>$lead_data['lead_status'],
               'task_type'=>'Note',
               'report'=>'',
           ];

           add_task_report($task_report_data);

           // //////////////////////////////////////////////////////
           //                    END TASK REPORT                 //
           // //////////////////////////////////////////////////////





                echo "0";
              if (!empty($this->request->getFileMultiple('messagefile'))) {
                echo "1";
                foreach ($this->request->getFileMultiple('messagefile') as $file) {
                  
                  echo "2";
                  if ($file->isValid()) {
                    echo "3";
                      $filename = $file->getClientName();
                      $mimetype=$file->getClientMimeType();
                      $size= $file->getSize();
                      $file->move('public/images/',$filename);

                
                        $filedata = [
                          'note_id'=>$noteid,
                          'type'=>$mimetype,
                          'size'=>$size,
                          'file'=>$filename,
                      ];
                      $MessageFileModel->save($filedata);
                  }

                      
                }
                    

              }

            }
        
            return redirect()->to(base_url('purchase_confirmation/details/'.$leadid));
        }else{
                return redirect()->to(base_url('users'));

              }
          }


   

}
