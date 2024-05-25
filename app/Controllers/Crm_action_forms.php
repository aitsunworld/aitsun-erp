<?php

namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\CrmActions;
use App\Models\RemindersModel;
use App\Models\CrmActionInventories;
use App\Models\CrmPhoneCallActions;
use App\Models\CrmExpenses;
use App\Models\CrmEngineers;
use App\Models\FeedbackModel;
use App\Models\LeadModel;


class Crm_action_forms extends BaseController
{
    public function index()
    {
        return redirect()->to(base_url());
    }

    public function forms($form="",$lead_id=""){

        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $user=$UserModel->where('id',$myid)->first();
        
        $data=[
            'form'=>$form,
            'lead_id'=>$lead_id,
            'user'=>$user
        ];

        echo view('crm/forms',$data);
    }


    public function send_sms($lead_id){

        $LeadModel= new LeadModel;

        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['phone'])) {

            $myid=session()->get('id');
        
            $text_Message = $_POST['message'];
            $sendsns=send_sms(get_setting(company($myid),'sms_sender'),$_POST['phone'],$text_Message,1,date('Y-m-d H:i:s'),1,get_setting(company($myid),'source_ref'));
            if ($sendsns) {

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'SMS sent to customer(<b>'.$_POST['phone'].'</b>) in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Email',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////






                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo 0;
        }
    }

    public function send_email($lead_id){
        $LeadModel= new LeadModel;

        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['to_email'])) {

            $myid=session()->get('id');

            $to=strip_tags(trim($_POST['to_email']));
            $subject=strip_tags(trim($_POST['subject']));
            $message=strip_tags(trim($_POST['email_messages']));
            $attached='';

            if (unique_send_email(company($myid),$to,$subject,$message,$attached)) {

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Email sent to customer(<b>'.strip_tags(trim($_POST['to_email'])).'</b>) in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Email',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo 0;
        }
    }

    



    ///////////////////////////////////////// SITE VISIT BACKENDS /////////////////////////////////////////
    public function add_site_visit_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmActions=new CrmActions;
        $RemindersModel=new RemindersModel;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'company_id'=>company($myid),
                'lead_id'=>strip_tags($lead_id),
                'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                'added_by'=>$myid,
                'report'=>strip_tags(trim($this->request->getVar('report'))),
                'created_at'=>now_time($myid),
            ];
            if (!empty(strip_tags(trim($this->request->getVar('report'))))) {

                $saveaction=$CrmActions->save($action_data);


                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Reminder report is added in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Set Reminder',
                   'report'=>strip_tags(trim($this->request->getVar('report'))),
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////
            }
            
            
            foreach ($_POST['reminder_date'] as $i => $value) {
                if (!empty($_POST['reminder_date'][$i])) {
                    $reminder_data = [
                    'company_id'=>company($myid),
                    'lead_id'=>strip_tags($lead_id),
                    'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                    'added_by'=>$myid,
                    'date'=>$_POST['reminder_date'][$i],
                    'time'=>$_POST['reminder_time'][$i],
                    'created_at'=>now_time($myid),
                ];

               

                if (!empty($_POST['reminder_time'][$i])) {

                    $tm='and Time:<b>'.get_date_format('0000-00-00 '.$_POST['reminder_time'][$i],'h:i a');

                }else{
                    $tm='';
                }

                $saveaction=$RemindersModel->save($reminder_data);

                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'New Reminder date:<b>'.get_date_format($_POST['reminder_date'][$i],'d M').'</b> '.$tm.'</b> has been added to the lead <b>"'.$lead_data['lead_name'].'"</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Set Reminder',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////

                }
            }

            if ($saveaction) {


            }

        }
    }

    public function display_site_visit_reports($stage="",$lead_id=""){
        ?>
            <label><b>Reports</b></label>
                <table class="table table-bordered w-100">
                    <?php $ii=0; foreach (action_reports('site_visit',$lead_id) as $reps): $ii++; ?>
                        
                        <tr>
                            <td>
                                <p class="mb-0 text-dark">
                                    <b><?= $reps['report'] ?></b>
                                </p>
                                <small class="text-muted d-md-flex justify-content-between">
                                    <div class="d-block">
                                        By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                                    </div>

                                    <a class="delete_site_visit_report cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_site_visit_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($ii<1): ?>
                            <tr>
                                <td>
                                    <small class="text-muted d-flex justify-content-center">No Reports</small>
                                </td>
                            </tr>
                        <?php endif ?>
                </table>
           
                <label><b>Reminders</b></label>
                <table class="table table-bordered w-100">
                    <?php $i=0; foreach (action_reminders('site_visit',$lead_id) as $rems): $i++; ?>
                        
                        <tr>
                            <td>
                                <p class="mb-0 text-dark">
                                    <b><?= get_date_format($rems['date'],'d M') ?> 
                                        <?php if ($rems['time']!='00:00:00'): ?>
                                           <?= get_date_format($rems['time'],'h:i a') ?> 
                                        <?php endif ?> 
                                    </b>
                                </p>
                                <small class="text-muted d-md-flex justify-content-between">
                                    <div class="d-block">
                                        By <?= user_name($rems['added_by']) ?> on <?= get_date_format($rems['created_at'],'d M h:i a') ?>
                                    </div>

                                    <a class="delete_site_visit_reminder cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_site_visit_reminder') ?>/<?= $rems['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($i<1): ?>
                            <tr>
                                <td>
                                   
                                    <small class="text-muted d-flex justify-content-center">No Reminders</small>
                                </td>
                            </tr>
                        <?php endif ?>
                </table>
        <?php
    }

    public function delete_site_visit_report($id="",$lead_id=""){


       $CrmActions=new CrmActions;
       $RemindersModel=new RemindersModel;
       $LeadModel= new LeadModel;

       $myid=session()->get('id');
        $lead_data=$LeadModel->where('id',$lead_id)->first();


       $CrmActions->where('id',$id)->delete();

       //  //////////////////////////////////////////////////////
       //                    ADD TASK REPORT                 //
       // //////////////////////////////////////////////////////
       $task_report_data=[
           'company_id'=>company($myid),
           'lead_id'=>$lead_id,
           'task'=>'Reminder report is deleted in lead <b>'.$lead_data['lead_name'].'</b>',
           'datetime'=>now_time($myid),
           'created_by'=>$myid,
           'ip'=>get_client_ip(),
           'mac'=>GetMAC(),
           'grid_no'=>$lead_data['lead_status'],
           'task_type'=>'Report delete',
           'report'=>'',
       ];

       add_task_report($task_report_data);

       // //////////////////////////////////////////////////////
       //                    END TASK REPORT                 //
       // //////////////////////////////////////////////////////
    }

    public function delete_site_visit_reminder($id="",$lead_id=""){
        $CrmActions=new CrmActions;
        $RemindersModel=new RemindersModel;
        $LeadModel= new LeadModel;

        $myid=session()->get('id');
        $lead_data=$LeadModel->where('id',$lead_id)->first();


        $RemindersModel->where('id',$id)->delete();

        //  //////////////////////////////////////////////////////
       //                    ADD TASK REPORT                 //
       // //////////////////////////////////////////////////////
       $task_report_data=[
           'company_id'=>company($myid),
           'lead_id'=>$lead_id,
           'task'=>'Reminder is deleted in lead <b>'.$lead_data['lead_name'].'</b>',
           'datetime'=>now_time($myid),
           'created_by'=>$myid,
           'ip'=>get_client_ip(),
           'mac'=>GetMAC(),
           'grid_no'=>$lead_data['lead_status'],
           'task_type'=>'Reminder delete',
           'report'=>'',
       ];

       add_task_report($task_report_data);

       // //////////////////////////////////////////////////////
       //                    END TASK REPORT                 //
       // //////////////////////////////////////////////////////     
    }

    public function delete_phone_call_report($id="",$lead_id=""){
        $CrmPhoneCallActions =new CrmPhoneCallActions;

        $LeadModel= new LeadModel;

        $myid=session()->get('id');
        $lead_data=$LeadModel->where('id',$lead_id)->first();

        $CrmPhoneCallActions->where('id',$id)->delete();

        //  //////////////////////////////////////////////////////
       //                    ADD TASK REPORT                 //
       // //////////////////////////////////////////////////////
       $task_report_data=[
           'company_id'=>company($myid),
           'lead_id'=>$lead_id,
           'task'=>'Call report is deleted in lead <b>'.$lead_data['lead_name'].'</b>',
           'datetime'=>now_time($myid),
           'created_by'=>$myid,
           'ip'=>get_client_ip(),
           'mac'=>GetMAC(),
           'grid_no'=>$lead_data['lead_status'],
           'task_type'=>'Call report delete',
           'report'=>'',
       ];

       add_task_report($task_report_data);

       // //////////////////////////////////////////////////////
       //                    END TASK REPORT                 //
       // //////////////////////////////////////////////////////        
    }

    public function delete_expense_report($id="",$lead_id=""){
        $CrmExpenses =new CrmExpenses ;
        $LeadModel= new LeadModel;

        $myid=session()->get('id');
        $lead_data=$LeadModel->where('id',$lead_id)->first();

        $CrmExpenses->where('id',$id)->delete();

        

        //  //////////////////////////////////////////////////////
       //                    ADD TASK REPORT                 //
       // //////////////////////////////////////////////////////
       $task_report_data=[
           'company_id'=>company($myid),
           'lead_id'=>$lead_id,
           'task'=>'Expense report is deleted in lead <b>'.$lead_data['lead_name'].'</b>',
           'datetime'=>now_time($myid),
           'created_by'=>$myid,
           'ip'=>get_client_ip(),
           'mac'=>GetMAC(),
           'grid_no'=>$lead_data['lead_status'],
           'task_type'=>'Expense report delete',
           'report'=>'',
       ];

       add_task_report($task_report_data);

       // //////////////////////////////////////////////////////
       //                    END TASK REPORT                 //
       // ////////////////////////////////////////////////////// 


    }

    public function delete_engineer_report($id="",$lead_id=""){
        $CrmEngineers =new CrmEngineers ;

        $LeadModel= new LeadModel;

        $myid=session()->get('id');
        $lead_data=$LeadModel->where('id',$lead_id)->first();


        $CrmEngineers->where('id',$id)->delete();

        //  //////////////////////////////////////////////////////
       //                    ADD TASK REPORT                 //
       // //////////////////////////////////////////////////////
       $task_report_data=[
           'company_id'=>company($myid),
           'lead_id'=>$lead_id,
           'task'=>'Engineer details is deleted in lead <b>'.$lead_data['lead_name'].'</b>',
           'datetime'=>now_time($myid),
           'created_by'=>$myid,
           'ip'=>get_client_ip(),
           'mac'=>GetMAC(),
           'grid_no'=>$lead_data['lead_status'],
           'task_type'=>'Engineer details delete',
           'report'=>'',
       ];

       add_task_report($task_report_data);

       // //////////////////////////////////////////////////////
       //                    END TASK REPORT                 //
       // //////////////////////////////////////////////////////      
    }
    

    
    ///////////////////////////////////////// SITE VISIT BACKENDS /////////////////////////////////////////









    ///////////////////////////////////////// DIRECT LOSS BACKENDS /////////////////////////////////////////
    public function add_direct_loss_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmActions=new CrmActions;
        $RemindersModel=new RemindersModel;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'company_id'=>company($myid),
                'lead_id'=>strip_tags($lead_id),
                'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                'added_by'=>$myid,
                'report'=>strip_tags(trim($this->request->getVar('report'))),
                'reason_for_loss'=>strip_tags(trim($this->request->getVar('reason'))),
                'created_at'=>now_time($myid),
            ];
            if (!empty(strip_tags(trim($this->request->getVar('report'))))) {
                $saveaction=$CrmActions->save($action_data);
            }

            //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Reason is added in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Reason',
                   'report'=>strip_tags(trim($this->request->getVar('report'))),
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////
            

        }
    }

    public function display_direct_loss_reports($stage="",$lead_id=""){
        ?>
            <label><b>Reports</b></label>
                <table class="table table-bordered w-100">
                    <?php $ii=0; foreach (action_reports('direct_loss',$lead_id) as $reps): $ii++; ?>
                        
                        <tr>
                            <td>
                                <b><?= reason_name($reps['reason_for_loss']) ?></b>
                                <p class="mb-0 text-dark">
                                    <?= $reps['report'] ?>
                                </p>
                                <small class="text-muted d-md-flex justify-content-between">
                                    <div class="d-block">
                                        By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                                    </div>

                                    <a class="delete_site_visit_report cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_site_visit_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($ii<1): ?>
                            <tr>
                                <td>
                                    <small class="text-muted d-flex justify-content-center">No Reports</small>
                                </td>
                            </tr>
                        <?php endif ?>
                </table>
                
        <?php
    }

   
    ///////////////////////////////////////// DIRECT LOSS BACKENDS /////////////////////////////////////////



    ///////////////////////////////////////// LOSS BACKENDS /////////////////////////////////////////
    public function add_loss_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmActions=new CrmActions;
        $RemindersModel=new RemindersModel;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'company_id'=>company($myid),
                'lead_id'=>strip_tags($lead_id),
                'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                'added_by'=>$myid,
                'report'=>strip_tags(trim($this->request->getVar('report'))),
                'reason_for_loss'=>strip_tags(trim($this->request->getVar('reason'))),
                'created_at'=>now_time($myid),
            ];
            if (!empty(strip_tags(trim($this->request->getVar('report'))))) {
                $saveaction=$CrmActions->save($action_data);
            }


                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Reason is added in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Reason',
                   'report'=>strip_tags(trim($this->request->getVar('report'))),
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////
            

        }
    }

    public function display_loss_reports($stage="",$lead_id=""){
        ?>
            <label><b>Reports</b></label>
                <table class="table table-bordered w-100">
                    <?php $ii=0; foreach (action_reports('loss',$lead_id) as $reps): $ii++; ?>
                        
                        <tr>
                            <td>
                                <b><?= reason_name($reps['reason_for_loss']) ?></b>
                                <p class="mb-0 text-dark">
                                    <?= $reps['report'] ?>
                                </p>
                                <small class="text-muted d-md-flex justify-content-between">
                                    <div class="d-block">
                                        By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                                    </div>

                                    <a class="delete_site_visit_report cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_site_visit_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($ii<1): ?>
                            <tr>
                                <td>
                                    <small class="text-muted d-flex justify-content-center">No Reports</small>
                                </td>
                            </tr>
                        <?php endif ?>
                </table>
                
        <?php
    }

   
    ///////////////////////////////////////// LOSS BACKENDS /////////////////////////////////////////








    ///////////////////////////////////////// QUOTATAION BACKENDS /////////////////////////////////////////
    public function add_quotation_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmActionInventories=new CrmActionInventories;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            foreach ($_POST['quotations'] as $i => $value) {
                $action_data = [
                    'company_id'=>company($myid),
                    'lead_id'=>strip_tags($lead_id),
                    'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                    'added_by'=>$myid,
                    'invoice_id'=>$_POST['quotations'][$i],
                    'invoice_type'=>'sales_quotation',
                    'created_at'=>now_time($myid),
                ];

                $check_exist=$CrmActionInventories->where('lead_id',$lead_id)->where('invoice_type','sales_quotation')->where('invoice_id',$_POST['quotations'][$i])->where('deleted',0)->first();
                if (!$check_exist) {
                    $saveaction=$CrmActionInventories->save($action_data);
                }

                 //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Quotation (<b>#'.inventory_prefix(company($myid),'sales_quotation').''.serial_no_of_id($_POST['quotations'][$i]).'</b>) is created in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Quotation',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////
                
                
            }

        }
    }

    public function display_crm_quotations($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Quotations <a id="refreshinvent" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales_quotation',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                <?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                            </a>
                           <div class="d-flex">
                               <a href="<?= base_url('invoices/edit') ?>/<?= $quotes['invoice_id']; ?>" target="_blank" class="btn-info btn-sm mx-1"><i class="bx bx-pencil"></i></a>
                               <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-share-alt"></i></button>

                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li>
                                        <a class="mr-4 dropdown-item" data-bs-toggle="modal" data-bs-target="#email<?= $quotes['invoice_id']; ?>" href="#">
                                            <i class="bx bx-mail-send"></i>
                                            Email
                                        </a>
                                    </li>
                                    <li>
                                         <a class="ml-4 dropdown-item whatsapp_share" data-invoice_id="<?= $quotes['invoice_id'];?>"><i class="lni lni-whatsapp"></i> WhatsApp</a>
                                    </li>
                                </ul>


                                <!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal fade" id='email<?= $quotes['invoice_id']; ?>' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
            <button type="button" class="closeemail" data-mid="<?= $quotes['invoice_id']; ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
                <label for="to-input">To</label>
                <input type="email" class="form-control" id="emailto<?= $quotes['invoice_id']; ?>"  placeholder="To" value="<?= user_email(invoice_data($quotes['invoice_id'],'customer')); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group">
                <label for="subject-input">Subject</label>
                <input type="text" class="form-control" id="subject<?= $quotes['invoice_id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
            </div>
            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" value="" id='message<?= $quotes['invoice_id']; ?>' rows="10">
Dear <?php if(invoice_data($quotes['invoice_id'],'customer') == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name(invoice_data($quotes['invoice_id'],'customer'));}  ?>,

<?php foreach (my_company(company($myid)) as $cmp) { ?>
    <?= $cmp['company_name']; ?> <?php } ?>truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'total'); ?> 
Due Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'due_amount'); ?>




Thanks & Regards,
<?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>



                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mt-2">
                    <button class="btn btn-primary waves-effect waves-light inventory_email" data-id="<?= invoice_data($quotes['invoice_id'],'id'); ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
            </div>

      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->
                           </div>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }

   
    ///////////////////////////////////////// QUOTATAION BACKENDS /////////////////////////////////////////




    ///////////////////////////////////////// Follow Up BACKENDS /////////////////////////////////////////
    public function add_follow_up_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmActions=new CrmActions;
        $RemindersModel=new RemindersModel;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'company_id'=>company($myid),
                'lead_id'=>strip_tags($lead_id),
                'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                'added_by'=>$myid,
                'report'=>strip_tags(trim($this->request->getVar('report'))),
                'created_at'=>now_time($myid),
            ];
            if (!empty(strip_tags(trim($this->request->getVar('report'))))) {
                $saveaction=$CrmActions->save($action_data);

                 //  //////////////////////////////////////////////////////
                //                    ADD TASK REPORT                 //
                // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'Reminder report is added in lead <b>'.$lead_data['lead_name'].'</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Set Reminder',
                   'report'=>strip_tags(trim($this->request->getVar('report'))),
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////
            }
            
            
            foreach ($_POST['reminder_date'] as $i => $value) {
                if (!empty($_POST['reminder_date'][$i])) {
                    $reminder_data = [
                    'company_id'=>company($myid),
                    'lead_id'=>strip_tags($lead_id),
                    'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                    'added_by'=>$myid,
                    'date'=>$_POST['reminder_date'][$i],
                    'time'=>$_POST['reminder_time'][$i],
                    'created_at'=>now_time($myid),
                ];


                if (!empty($_POST['reminder_time'][$i])) {

                     $tm='and Time:<b>'.get_date_format('0000-00-00 '.$_POST['reminder_time'][$i],'h:i a');

                }else{
                    $tm='';
                }


                $saveaction=$RemindersModel->save($reminder_data);


                //  //////////////////////////////////////////////////////
               //                    ADD TASK REPORT                 //
               // //////////////////////////////////////////////////////
               $task_report_data=[
                   'company_id'=>company($myid),
                   'lead_id'=>$lead_id,
                   'task'=>'New Reminder date:<b>'.get_date_format($_POST['reminder_date'][$i],'d M').'</b> '.$tm.'</b> has been added to the lead <b>"'.$lead_data['lead_name'].'"</b>',
                   'datetime'=>now_time($myid),
                   'created_by'=>$myid,
                   'ip'=>get_client_ip(),
                   'mac'=>GetMAC(),
                   'grid_no'=>$lead_data['lead_status'],
                   'task_type'=>'Set Reminder',
                   'report'=>'',
               ];

               add_task_report($task_report_data);

               // //////////////////////////////////////////////////////
               //                    END TASK REPORT                 //
               // //////////////////////////////////////////////////////


                }
            }

            if ($saveaction) {

                  

            }

        }
    }

    public function add_phone_call_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmPhoneCallActions=new CrmPhoneCallActions;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'company_id'=>company($myid),
                'lead_id'=>strip_tags($lead_id),
                'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                'added_by'=>$myid,
                'report'=>strip_tags(trim($this->request->getVar('cl_report'))),
                'created_at'=>now_time($myid),
            ];
            if (!empty(strip_tags(trim($this->request->getVar('cl_report'))))) {
                $saveaction=$CrmPhoneCallActions->save($action_data);
            }
            

            if ($saveaction) {

                 //  //////////////////////////////////////////////////////
                   //                    ADD TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                   $task_report_data=[
                       'company_id'=>company($myid),
                       'lead_id'=>$lead_id,
                       'task'=>'New call report <b>'.strip_tags(trim($this->request->getVar('cl_report'))).'</b> is added in lead <b>'.$lead_data['lead_name'].'</b>',
                       'datetime'=>now_time($myid),
                       'created_by'=>$myid,
                       'ip'=>get_client_ip(),
                       'mac'=>GetMAC(),
                       'grid_no'=>$lead_data['lead_status'],
                       'task_type'=>'Call Report',
                       'report'=>strip_tags(trim($this->request->getVar('cl_report'))),
                   ];

                   add_task_report($task_report_data);

                   // //////////////////////////////////////////////////////
                   //                    END TASK REPORT                 //
                   // //////////////////////////////////////////////////////

            }

        }
    }

    public function edit_phone_call_action($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmPhoneCallActions=new CrmPhoneCallActions;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'report'=>strip_tags(trim($this->request->getVar('cl_report')))
            ];
            if (!empty(strip_tags(trim($this->request->getVar('cl_report'))))) {
                $saveaction=$CrmPhoneCallActions->update(strip_tags(trim($this->request->getVar('action_id'))),$action_data);
            }
            
            
            if ($saveaction) {

                    //  //////////////////////////////////////////////////////
                   //                    ADD TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                   $task_report_data=[
                       'company_id'=>company($myid),
                       'lead_id'=>$lead_id,
                       'task'=>'Call report <b>'.strip_tags(trim($this->request->getVar('cl_report'))).'</b> is updated in lead <b>'.$lead_data['lead_name'].'</b>',
                       'datetime'=>now_time($myid),
                       'created_by'=>$myid,
                       'ip'=>get_client_ip(),
                       'mac'=>GetMAC(),
                       'grid_no'=>$lead_data['lead_status'],
                       'task_type'=>'Call Report',
                       'report'=>strip_tags(trim($this->request->getVar('cl_report'))),
                   ];

                   add_task_report($task_report_data);

                   // //////////////////////////////////////////////////////
                   //                    END TASK REPORT                 //
                   // //////////////////////////////////////////////////////

            }

        }
    }

    

    public function display_follow_up_reports($stage="",$lead_id=""){
        ?>
            <label><b>Reports</b></label>
                <table class="table table-bordered w-100">
                    <?php $ii=0; foreach (action_reports($stage,$lead_id) as $reps): $ii++; ?>
                        
                        <tr>
                            <td>
                                <p class="mb-0 text-dark">
                                    <b><?= $reps['report'] ?></b>
                                </p>
                                <small class="text-muted d-md-flex justify-content-between">
                                    <div class="d-block">
                                        By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                                    </div>

                                    <a class="delete_site_visit_report cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_site_visit_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($ii<1): ?>
                            <tr>
                                <td>
                                    <small class="text-muted d-flex justify-content-center">No Reports</small>
                                </td>
                            </tr>
                        <?php endif ?>
                </table>
           
                <label><b>Reminders</b></label>
                <table class="table table-bordered w-100">
                    <?php $i=0; foreach (action_reminders($stage,$lead_id) as $rems): $i++; ?>
                        
                        <tr>
                            <td>
                                <p class="mb-0 text-dark">
                                    <b><?= get_date_format($rems['date'],'d M') ?> 
                                        <?php if ($rems['time']!='00:00:00'): ?>
                                           <?= get_date_format($rems['time'],'h:i a') ?> 
                                        <?php endif ?> 
                                    </b>
                                </p>
                                <small class="text-muted d-md-flex justify-content-between">
                                    <div class="d-block">
                                        By <?= user_name($rems['added_by']) ?> on <?= get_date_format($rems['created_at'],'d M h:i a') ?>
                                    </div>

                                    <a class="delete_site_visit_reminder cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_site_visit_reminder') ?>/<?= $rems['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($i<1): ?>
                            <tr>
                                <td>
                                   
                                    <small class="text-muted d-flex justify-content-center">No Reminders</small>
                                </td>
                            </tr>
                        <?php endif ?>
                </table>
        <?php
    }



    public function display_phone_call_reports($stage="",$lead_id=""){
        ?>


        <div class="mt-2">
            <label>Phone Call Report</label>

            <ul class="list-group">
                <?php $ii=0; foreach (phone_call_action_reports($stage,$lead_id) as $reps): $ii++; ?>
                <li class="list-group-item ">
                    <div class="d-flex justify-content-between">
                        <div class="me-2 my-auto">
                            <p class="mb-0 text-dark">
                                <b><?= $reps['report'] ?></b>
                            </p>
                            
                       </div>
                       <div class="d-flex my-auto">
                            <a class="btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#ed_report<?= $reps['id'] ?>">
                              <i class="bx bx-pencil"></i>
                            </a>

                            <a class="delete_site_visit_report btn-danger btn-sm cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_phone_call_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"> <i class="bx bx-trash"></i></a>
                        </div>
                    </div>
                   

                    <small class="text-muted d-md-flex justify-content-between">
                        <div class="d-block">
                            By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                        </div>
                    </small>


                     <!-- /////////////////////////////////////////////////////edit call///////////////////////////////////////// -->
                        <div class="modal fade" id='ed_report<?= $reps['id'] ?>' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header p-2">
                                        <h5 class="modal-title mt-0" id="mySmallModalLabel">Edit Report</h5>
                                        <button type="button" class="closephone" data-mid="<?= $reps['id'] ?>">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="phone_call_action_form<?= $reps['id'] ?>" action="<?= base_url('crm_action_forms/edit_phone_call_action'); ?>/<?= $lead_id; ?>">
                                            <?= csrf_field(); ?>
                                             <input type="hidden" name="stage" value="<?= $stage; ?>" id="stage1<?= $reps['id'] ?>">
                                             <input type="hidden" name="action_id" value="<?= $reps['id'] ?>">
                                             <div class="form-group col-md-12 mb-2">
                                                <input type="text" class="form-control" placeholder="Enter phone call report" name="cl_report" id="cl_report<?= $reps['id'] ?>" value="<?= $reps['report'] ?>">
                                             </div>
                                             <div class="form-group col-md-12 mb-0 text-center">
                                               <button class="btn btn-facebook btn-sm sent_call_report" data-id="<?= $reps['id'] ?>" type="button" name="sent_call_report" id="sent_call_report<?= $reps['id'] ?>">Save</button>
                                             </div>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- /////////////////////////////////////////////////////edit call///////////////////////////////////////// -->

                </li>
                <?php endforeach ?>
                <?php if ($ii<1): ?>
                    <li class="list-group-item text-center">
                       <small class="text-muted d-flex justify-content-center">No Reports</small>
                    </li>
                <?php endif ?>
                
                
            </ul>
           
       </div>

        <?php
    }

    ///////////////////////////////////////// Follow Up BACKENDS /////////////////////////////////////////




    ///////////////////////////////////// PAYMENT FOLLOW UP BACKENDS //////////////////////////////////
    public function display_crm_invoices($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Invoices <a id="refreshinvent" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                <?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                            </a>
                           <div class="d-flex">
                               <a href="<?= base_url('invoices/edit') ?>/<?= $quotes['invoice_id']; ?>" target="_blank" class="btn-info btn-sm mx-1"><i class="bx bx-pencil"></i></a>
                               <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-share-alt"></i></button>

                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li>
                                        <a class="mr-4 dropdown-item" data-bs-toggle="modal" data-bs-target="#email<?= $quotes['invoice_id']; ?>" href="#">
                                            <i class="bx bx-mail-send"></i>
                                            Email
                                        </a>
                                    </li>
                                    <li>
                                         <a class="ml-4 dropdown-item whatsapp_share" data-invoice_id="<?= $quotes['invoice_id'];?>"><i class="lni lni-whatsapp"></i> WhatsApp</a>
                                    </li>
                                </ul>


                                <!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal fade" id='email<?= $quotes['invoice_id']; ?>' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
            <button type="button" class="closeemail" data-mid="<?= $quotes['invoice_id']; ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
                <label for="to-input">To</label>
                <input type="email" class="form-control" id="emailto<?= $quotes['invoice_id']; ?>"  placeholder="To" value="<?= user_email(invoice_data($quotes['invoice_id'],'customer')); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group">
                <label for="subject-input">Subject</label>
                <input type="text" class="form-control" id="subject<?= $quotes['invoice_id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
            </div>
            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" value="" id='message<?= $quotes['invoice_id']; ?>' rows="10">

Dear <?php if(invoice_data($quotes['invoice_id'],'customer') == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name(invoice_data($quotes['invoice_id'],'customer'));}  ?>,

We at <?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?> truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'total'); ?> 
Due Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'due_amount'); ?>


Thanks & Regards
<?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>



                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mt-2">
                    <button class="btn btn-primary waves-effect waves-light inventory_email" data-id="<?= invoice_data($quotes['invoice_id'],'id'); ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
            </div>

      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->
                           </div>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }

    /////////////////////////////////////// PAYMENT FOLLOW UP BACKENDS /////////////////////////////////////





    //////////////////////////// SALES ORDER QUOTATIONS /////////////////////////////////////////////
    public function display_crm_sales_order_quotations($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Quotations <a id="refreshinvent" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales_quotation',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                #<?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                                <?php if (invoice_data($quotes['invoice_id'],'converted')==1): ?>
                                    <small class="text-muted">(converted)</small>
                                <?php endif ?>

                            </a>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }


    
    public function display_sales_order_reports($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Sales orders <a id="refreshinventord" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales_order',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                <?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                            </a>
                           <div class="d-flex">
                               <a href="<?= base_url('invoices/edit') ?>/<?= $quotes['invoice_id']; ?>" target="_blank" class="btn-info btn-sm mx-1"><i class="bx bx-pencil"></i></a>
                               <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-share-alt"></i></button>

                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li>
                                        <a class="mr-4 dropdown-item" data-bs-toggle="modal" data-bs-target="#email<?= $quotes['invoice_id']; ?>" href="#">
                                            <i class="bx bx-mail-send"></i>
                                            Email
                                        </a>
                                    </li>
                                    <li>
                                         <a class="ml-4 dropdown-item whatsapp_share" data-invoice_id="<?= $quotes['invoice_id'];?>"><i class="lni lni-whatsapp"></i> WhatsApp</a>
                                    </li>
                                </ul>


                                <!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal fade" id='email<?= $quotes['invoice_id']; ?>' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>

            <button type="button" class="closeemail" data-mid="<?= $quotes['invoice_id']; ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
                <label for="to-input">To</label>
                <input type="hidden" name="lead_id" value="<?= $lead_id; ?>" id="lead_id">
                <input type="email" class="form-control" id="emailto<?= $quotes['invoice_id']; ?>"  placeholder="To" value="<?= user_email(invoice_data($quotes['invoice_id'],'customer')); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group">
                <label for="subject-input">Subject</label>
                <input type="text" class="form-control" id="subject<?= $quotes['invoice_id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
            </div>
            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" value="" id='message<?= $quotes['invoice_id']; ?>' rows="10">

Dear <?php if(invoice_data($quotes['invoice_id'],'customer') == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name(invoice_data($quotes['invoice_id'],'customer'));}  ?>,

We at <?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?> truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'total'); ?> 
Due Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'due_amount'); ?>


Thanks & Regards
<?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>



                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mt-2">
                    <button class="btn btn-primary waves-effect waves-light inventory_email" data-id="<?= invoice_data($quotes['invoice_id'],'id'); ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
            </div>

      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->
                           </div>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }
    //////////////////////////// SALES ORDER QUOTATIONS ////////////////////////////////////////////




    //////////////////////////// SALES DELIVERY QUOTATIONS /////////////////////////////////////////////


    public function display_crm_deliver_note_orders($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Sales orders <a id="refreshinvent" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales_order',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                #<?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                                <?php if (invoice_data($quotes['invoice_id'],'converted')==1): ?>
                                    <small class="text-muted">(converted)</small>
                                <?php endif ?>

                            </a>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }


    
    public function display_deliver_note_reports($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Sales deliver notes <a id="refreshinventord" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales_delivery_note',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                <?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                            </a>
                           <div class="d-flex">
                               <a href="<?= base_url('invoices/edit') ?>/<?= $quotes['invoice_id']; ?>" target="_blank" class="btn-info btn-sm mx-1"><i class="bx bx-pencil"></i></a>
                               <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-share-alt"></i></button>

                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li>
                                        <a class="mr-4 dropdown-item" data-bs-toggle="modal" data-bs-target="#email<?= $quotes['invoice_id']; ?>" href="#">
                                            <i class="bx bx-mail-send"></i>
                                            Email
                                        </a>
                                    </li>
                                    <li>
                                         <a class="ml-4 dropdown-item whatsapp_share" data-invoice_id="<?= $quotes['invoice_id'];?>"><i class="lni lni-whatsapp"></i> WhatsApp</a>
                                    </li>
                                </ul>


                                <!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal fade" id='email<?= $quotes['invoice_id']; ?>' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
            <button type="button" class="closeemail" data-mid="<?= $quotes['invoice_id']; ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
                <label for="to-input">To</label>
                <input type="email" class="form-control" id="emailto<?= $quotes['invoice_id']; ?>"  placeholder="To" value="<?= user_email(invoice_data($quotes['invoice_id'],'customer')); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group">
                <label for="subject-input">Subject</label>
                <input type="text" class="form-control" id="subject<?= $quotes['invoice_id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
            </div>
            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" value="" id='message<?= $quotes['invoice_id']; ?>' rows="10">

Dear <?php if(invoice_data($quotes['invoice_id'],'customer') == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name(invoice_data($quotes['invoice_id'],'customer'));}  ?>,

We at <?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?> truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'total'); ?> 
Due Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'due_amount'); ?>


Thanks & Regards
<?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>



                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mt-2">
                    <button class="btn btn-primary waves-effect waves-light inventory_email" data-id="<?= invoice_data($quotes['invoice_id'],'id'); ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
            </div>

      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->
                           </div>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }
    //////////////////////////// SALES DELIVERY QUOTATIONS ////////////////////////////////////////////



    ///////////////////////////// DELIVERY BACKENDS  /////////////////////////////////////////////////


     public function add_expense($lead_id=""){
        $myid=session()->get('id');
        $UserModel=new Main_item_party_table;
        $CrmExpenses=new CrmExpenses;
        $CrmEngineers=new CrmEngineers;
        $LeadModel= new LeadModel;


        $lead_data=$LeadModel->where('id',$lead_id)->first();

        if (isset($_POST['stage'])) {

            $action_data = [
                'company_id'=>company($myid),
                'lead_id'=>strip_tags($lead_id),
                'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                'added_by'=>$myid,
                'expense'=>strip_tags(trim($this->request->getVar('account_name'))),
                'created_at'=>now_time($myid),
            ];
            if (!empty(strip_tags(trim($this->request->getVar('account_name'))))) {
                $saveaction=$CrmExpenses->save($action_data);

                //  //////////////////////////////////////////////////////
                   //                    ADD TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                   $task_report_data=[
                       'company_id'=>company($myid),
                       'lead_id'=>$lead_id,
                       'task'=>'New expense <b>'.expense_type_name(strip_tags(trim($this->request->getVar('account_name')))).'</b> is added in lead <b>'.$lead_data['lead_name'].'</b>',
                       'datetime'=>now_time($myid),
                       'created_by'=>$myid,
                       'ip'=>get_client_ip(),
                       'mac'=>GetMAC(),
                       'grid_no'=>$lead_data['lead_status'],
                       'task_type'=>'Expenses',
                       'report'=>'',
                   ];

                   add_task_report($task_report_data);

                   // //////////////////////////////////////////////////////
                   //                    END TASK REPORT                 //
                   // //////////////////////////////////////////////////////
            }
            



            
            foreach ($_POST['engineer'] as $i => $value) {
                if (!empty($_POST['engineer'][$i])) {
                    $reminder_data = [
                    'company_id'=>company($myid),
                    'lead_id'=>strip_tags($lead_id),
                    'stage'=>strip_tags(trim($this->request->getVar('stage'))),
                    'added_by'=>$myid,
                    'engineer'=>$_POST['engineer'][$i],
                    'day'=>$_POST['day'][$i],
                    'hrs'=>$_POST['hrs'][$i],
                    'min'=>$_POST['min'][$i],
                    'created_at'=>now_time($myid),
                ];

                $saveaction=$CrmEngineers->save($reminder_data);

                //  //////////////////////////////////////////////////////
                   //                    ADD TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                   $task_report_data=[
                       'company_id'=>company($myid),
                       'lead_id'=>$lead_id,
                       'task'=>'Engineer <b>'.user_name($_POST['engineer'][$i]).'</b> details is added in lead <b>'.$lead_data['lead_name'].'</b>',
                       'datetime'=>now_time($myid),
                       'created_by'=>$myid,
                       'ip'=>get_client_ip(),
                       'mac'=>GetMAC(),
                       'grid_no'=>$lead_data['lead_status'],
                       'task_type'=>'Engineer',
                       'report'=>'',
                   ];

                   add_task_report($task_report_data);

                   // //////////////////////////////////////////////////////
                   //                    END TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                }
            }



            echo 1;

        }
    }

    public function display_expenses($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Expenses </label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_expenses_array(company($myid),$lead_id) as $reps): $ii++; ?>
                   <tr>
                       <td>
                            <p class="mb-0 text-dark">
                                <b><?= expense_type_name($reps['expense']) ?></b>
                            </p>
                            <small class="text-muted d-md-flex justify-content-between">
                                <div class="d-block">
                                    By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                                </div>

                                <a class="delete_site_visit_report cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_expense_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                            </small>
                        </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>

           <div class="mt-2">
                <label class="d-flex justify-content-between">Engineers</label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_engineers_array(company($myid),$lead_id) as $reps): $ii++; ?>
                   <tr>
                        <td>
                            <p class="mb-0 text-dark">
                                <b class="d-block"><?= user_name($reps['engineer']) ?></b>
                                <small><?= $reps['day'] ?> days <?= $reps['hrs'] ?> hrs <?= $reps['min'] ?> mins</small>
                            </p>
                            <small class="text-muted d-md-flex justify-content-between">
                                <div class="d-block">
                                    By <?= user_name($reps['added_by']) ?> on <?= get_date_format($reps['created_at'],'d M h:i a') ?>
                                </div>

                                <a class="delete_site_visit_report cursor-pointer" data-uurl="<?= base_url('crm_action_forms/delete_engineer_report') ?>/<?= $reps['id'] ?>/<?= $lead_id; ?>"><i class="bx bx-trash text-danger"></i></a>
                            </small>
                        </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }


    ///////////////////////////// DELIVERY BACKENDS  /////////////////////////////////////////////////



    //////////////////////////// INVOICES /////////////////////////////////////////////


    public function display_sales_sales_delivery_reports($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Sales delivery note <a id="refreshinvent" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales_delivery_note',$lead_id) as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                #<?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                                <?php if (invoice_data($quotes['invoice_id'],'converted')==1): ?>
                                    <small class="text-muted">(converted)</small>
                                <?php endif ?>

                            </a>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }

    

    public function display_sales_reports($stage="",$lead_id=""){
        $myid=session()->get('id');
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Inventories <a id="refreshinventord" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>
               <table class="table table-bordered">
                <?php $ii=0; foreach (crm_inventories_array('sales',$lead_id,'all') as $quotes): $ii++; ?>
                   <tr>
                       <td class="d-flex justify-content-between">
                            <a href="<?= base_url('invoices/details'); ?>/<?= $quotes['invoice_id']; ?>" class="my-auto">
                                #<?= inventory_prefix($quotes['company_id'],$quotes['invoice_type']); ?><?= serial_no_of_id($quotes['invoice_id']); ?>
                                 - <span class="badge bg-dark text-capitalize" style="font-weight: 100!important;"><?= str_replace('_', ' ', $quotes['invoice_type']) ?></span>
                            </a>
                           <div class="d-flex">
                               <a href="<?= base_url('invoices/edit') ?>/<?= $quotes['invoice_id']; ?>" target="_blank" class="btn-info btn-sm mx-1"><i class="bx bx-pencil"></i></a>
                               <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-share-alt"></i></button>

                                <ul class="dropdown-menu" style="margin: 0px;">
                                    <li>
                                        <a class="mr-4 dropdown-item" data-bs-toggle="modal" data-bs-target="#email<?= $quotes['invoice_id']; ?>" href="#">
                                            <i class="bx bx-mail-send"></i>
                                            Email
                                        </a>
                                    </li>
                                    <li> 
                                          <a class="ml-4 dropdown-item whatsapp_share" data-invoice_id="<?= $quotes['invoice_id'];?>"><i class="lni lni-whatsapp"></i> WhatsApp</a>
                                    </li>
                                </ul>


                                <!-- /////////////////////////////////////////////////////email///////////////////////////////////////// -->
<div class="modal fade" id='email<?= $quotes['invoice_id']; ?>' tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">Send Email</h5>
            <button type="button" class="closeemail" data-mid="<?= $quotes['invoice_id']; ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
                <label for="to-input">To</label>
                <input type="email" class="form-control" id="emailto<?= $quotes['invoice_id']; ?>"  placeholder="To" value="<?= user_email(invoice_data($quotes['invoice_id'],'customer')); ?>" required>
                <div class="text-danger mt-2" id="ermsg"></div>
            </div>

            <div class="form-group">
                <label for="subject-input">Subject</label>
                <input type="text" class="form-control" id="subject<?= $quotes['invoice_id']; ?>" placeholder="Subject" value="Your Purchase invoice details">
            </div>
            <div class="form-group ">
                <label for="message-input">Message</label>
                  <textarea class="form-control" value="" id='message<?= $quotes['invoice_id']; ?>' rows="10">
Dear <?php if(invoice_data($quotes['invoice_id'],'customer') == 'CASH'){echo 'CASH CUSTOMER';}else{ echo user_name(invoice_data($quotes['invoice_id'],'customer'));}  ?>,

<?php foreach (my_company(company($myid)) as $cmp) { ?>
    <?= $cmp['company_name']; ?> <?php } ?>truly appreciate your business, and we’re so grateful for the trust you’ve placed in us. We sincerely hope you are satisfied with your purchase, and look forward to serving you again.

Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'total'); ?> 
Due Amount: <?= currency_symbol(company($myid)); ?> <?= invoice_data($quotes['invoice_id'],'due_amount'); ?>




Thanks & Regards
<?php foreach (my_company(company($myid)) as $cmp) { ?>
<?= $cmp['company_name']; ?>
<?php } ?>



                  </textarea>
            </div>

            

            <div class="btn-toolbar form-group mt-2">
                    <button class="btn btn-primary waves-effect waves-light inventory_email" data-id="<?= invoice_data($quotes['invoice_id'],'id'); ?>"> <span>Send</span> <i class="lni lni-telegram-original ml-1"></i> </button>
            </div>

      
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /////////////////////////////////////////////////////End email///////////////////////////////////////// -->
                           </div>
                       </td>
                   </tr>
                <?php endforeach ?>
               </table>
           </div>
                
        <?php
    }

    //////////////////////////// INVOICES /////////////////////////////////////////////



    //////////////////////////// COMPLETE /////////////////////////////////////////////
    public function display_feedback_reports($stage="",$lead_id=""){
        $myid=session()->get('id');
        $FeedbackModel=new FeedbackModel;
        $feedbacks=$FeedbackModel->where('projectid',$lead_id)->orderBy('id','desc')->findAll();
        ?>
            <div class="mt-2">
                <label class="d-flex justify-content-between">Feedbacks <a id="refreshinvent" class="cursor-pointer"><i class="bx bx-revision"> Refresh</i></a></label>

                <ul class="list-group">
                    <?php foreach ($feedbacks as $fd): ?>
                        <li class="list-group-item p-2">
                            <small style="font-size:12px;font-weight: 500; display: block;"><?= $fd['name'] ?> | <?= $fd['email'] ?></small>
                            <small style="font-size:12px;font-weight: 500; display: block;"><?= get_date_format($fd['datetime'],'d M  h:m A') ?></small>
                           <div class=""> 
                            <b><?= $fd['review'] ?></b>
                           </div>
                        </li>
                    <?php endforeach ?>
                    
                </ul>
               
           </div>
                
        <?php
    }
    //////////////////////////// COMPLETE /////////////////////////////////////////////


    public function send_email_from_invoivoice($lead_id){

        $LeadModel= new LeadModel;
        $lead_data=$LeadModel->where('id',$lead_id)->first();

        
        if (isset($_GET['to'])) {
            $myid=session()->get('id');

            $to=strip_tags(trim($_GET['to']));
            $subject=strip_tags(trim($_GET['subject']));
            $message=nl2br($_GET['message']);
            $attached='';


            if (unique_send_email(company($myid),$to,$subject,$message,$attached)) {

                if (!empty($lead_data['id'])) {
                    //  //////////////////////////////////////////////////////
                   //                    ADD TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                   $task_report_data=[
                       'company_id'=>company($myid),
                       'lead_id'=>$lead_id,
                       'task'=>'Email sent to customer(<b>'.$to.'</b>) in lead <b>'.$lead_data['lead_name'].'</b>',
                       'datetime'=>now_time($myid),
                       'created_by'=>$myid,
                       'ip'=>get_client_ip(),
                       'mac'=>GetMAC(),
                       'grid_no'=>$lead_data['lead_status'],
                       'task_type'=>'Email',
                       'report'=>'',
                   ];

                   add_task_report($task_report_data);

                   // //////////////////////////////////////////////////////
                   //                    END TASK REPORT                 //
                   // //////////////////////////////////////////////////////
                }

    
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    

    
}