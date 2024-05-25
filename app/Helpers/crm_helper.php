<?php 
use App\Models\Main_item_party_table as Main_item_party_table;
use App\Models\LeadModel as LeadModel;
use App\Models\ActivitiesNotes as ActivitiesNotes;
use App\Models\TasksModel as TasksModel;
use App\Models\Notification as Notification;
use App\Models\FollowersModel as FollowersModel;
use App\Models\NotificationsModel as NotificationsModel;
use App\Models\TaskDateModel as TaskDateModel;
use App\Models\MessageFileModel as MessageFileModel;
use App\Models\CrmActions as CrmActions;
use App\Models\RemindersModel as RemindersModel;
use App\Models\LossReasons as LossReasons;
use App\Models\InvoiceModel as InvoiceModel;
use App\Models\CrmActionInventories as CrmActionInventories;
use App\Models\CrmPhoneCallActions as CrmPhoneCallActions;
use App\Models\CrmExpenses as CrmExpenses;
use App\Models\Companies as Companies;
use App\Models\CrmEngineers as CrmEngineers;
use App\Models\ProjectType as ProjectType;
use App\Models\AttendanceEventModel as AttendanceEventModel;
use App\Models\RenewFiles as RenewFiles;


    function feed_back_link($company,$project_id){
        return 'https://utechoman.com/feedback/?projectid='.$project_id;
    }


    

    function inventories_of_renew($rnid){
        $InvoiceModel = new InvoiceModel;
        $farray=$InvoiceModel->where('renew_id', $rnid)->where('deleted', 0)->orderby('id','desc')->findAll();
        return $farray;
    }
 
    function renew_files($rnid){
        $RenewFiles = new RenewFiles;
        $farray=$RenewFiles->where('renew_id', $rnid)->orderby('id','desc')->findAll();
        return $farray;
    }

    function notes_of_lead($leadid){
        $ActivitiesNotes = new ActivitiesNotes;
        $farray=$ActivitiesNotes->where('lead_id', $leadid)->where('type', 'note')->orderby('id','desc')->findAll();
        return $farray;
    }
    

    function check_attendance_event($company,$event_date){
        $AttendanceEventModel = new AttendanceEventModel;
        $farray=$AttendanceEventModel->where('company_id', $company)->where('event_date', $event_date)->where('type', 'event')->where('deleted',0)->first();
        if ($farray) {
           return 1;
        }else{
            return 0;
        }
    }

    
    function additional_attendance_fields($company){
        $AttendanceEventModel = new AttendanceEventModel;
        $farray=$AttendanceEventModel->where('company_id', $company)->where('type', 'field')->where('deleted', 0)->orderby('id','desc')->findAll();
        return $farray;
    }
    
    function get_attendance_field_data($company,$id,$column){
        $AttendanceEventModel = new AttendanceEventModel;
        $farray=$AttendanceEventModel->where('company_id', $company)->where('id', $id)->orderby('id','desc')->first();
        if ($farray) {
           return $farray[$column];
        }else{
            return '';
        }
    }

    function get_attendance_event($company,$event_date,$column){
        $AttendanceEventModel = new AttendanceEventModel;
        $farray=$AttendanceEventModel->where('company_id', $company)->where('event_date', $event_date)->where('deleted',0)->orderby('id','desc')->first();
        if ($farray) {
           return $farray[$column];
        }else{
            return '';
        }
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    function doc_type($type){
        $ftype='document';
        if ($type=='image/jpeg' || $type=='image/png' || $type=='image/gif') {
           $ftype='image';
        }elseif($type=='application/pdf' || $type=='application/vnd.ms-excel' || $type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $type=='text/plain'){
            $ftype='document';
        }
        return $ftype;
    }

    function get_files_of_message($mes_id){
        $MessageFileModel = new MessageFileModel;
        $farray=$MessageFileModel->where('note_id', $mes_id)->orderby('id','desc')->findAll();
        return $farray;
    }

    function get_lead_data($lead_id,$column){
        $LeadModel = new LeadModel;
        $farray=$LeadModel->where('id',$lead_id)->first();
        return $farray[$column];

    }

    
    function project_types_array($company_id){
        $ProjectType=new ProjectType;
        $reps=$ProjectType->where('company_id',$company_id)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

    function name_of_project_type($id){
        $ProjectType=new ProjectType;
        $reps=$ProjectType->where('id',$id)->first();
        if ($reps) {
            return $reps['project_type'];
        }else{
            return '';
        }
        
    }
    

    function get_task_data($task_id,$column){
        $TasksModel = new TasksModel;
        $farray=$TasksModel->where('id',$task_id)->first();
        return $farray[$column];

    }

    function get_inventories_array($company_id,$type){
        $InvoiceModel=new InvoiceModel;
        $acti=activated_year($company_id);
        $reps=$InvoiceModel->where('company_id',$company_id)->where('invoice_type',$type)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

    function get_loss_reasons_array($company,$stage){
        $LossReasons=new LossReasons;
        $reps=$LossReasons->where('company_id',$company)->where('stage',$stage)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

    function reason_name($id){
        $LossReasons=new LossReasons;
        $reps=$LossReasons->where('id',$id)->first();
        if ($reps) {
            return $reps['reason'];
        }else{
            return 'Unknown';
        }
        
    }

    function crm_inventories_array($invoice_type,$lead_id,$how='no_all'){
        $CrmActionInventories=new CrmActionInventories;
        if ($how!='all') {
            $reps=$CrmActionInventories->where('lead_id',$lead_id)->where('invoice_type',$invoice_type)->where('deleted',0)->orderBy('id','desc')->findAll();
        }else{
            $reps=$CrmActionInventories->where('lead_id',$lead_id)->where('deleted',0)->orderBy('id','desc')->findAll();
        }
        
        return $reps;
    }

    function stage_crm_inventories_array($invoice_type,$lead_id){
        $CrmActionInventories=new CrmActionInventories;
        $reps=$CrmActionInventories->where('lead_id',$lead_id)->where('invoice_type!=',$invoice_type)->where('deleted',0)->orderBy('id','desc')->findAll(); 
        return $reps;
    }

    
    function crm_expenses_array($company_id,$lead_id){
        $CrmExpenses=new CrmExpenses;
        $reps=$CrmExpenses->where('company_id',$company_id)->where('lead_id',$lead_id)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

    function crm_engineers_array($company_id,$lead_id){
        $CrmEngineers=new CrmEngineers;
        $reps=$CrmEngineers->where('company_id',$company_id)->where('lead_id',$lead_id)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

    function action_reports($stage,$lead_id,$orderby="desc"){
        $CrmActions=new CrmActions;
        $reps=$CrmActions->where('stage',$stage)->where('lead_id',$lead_id)->where('deleted',0)->orderBy('id',$orderby)->findAll();
        return $reps;
    }

    function phone_call_action_reports($stage,$lead_id){
        $CrmPhoneCallActions=new CrmPhoneCallActions;
        $reps=$CrmPhoneCallActions->where('stage',$stage)->where('lead_id',$lead_id)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

    

    function action_reminders($stage,$lead_id){
        $RemindersModel=new RemindersModel;
        $reps=$RemindersModel->where('stage',$stage)->where('lead_id',$lead_id)->where('deleted',0)->orderBy('id','desc')->findAll();
        return $reps;
    }

function task_dates($taskid){
    $TaskDateModel = new TaskDateModel;
    $folreq=$TaskDateModel->where('task_id',$taskid)->findAll();
    return $folreq;
}



function get_followers_of_lead($leadid){
    $followers='';
    $FollowersModel = new FollowersModel;
    $this_key=0;
    $lead_followers=$FollowersModel->where('lead_id',$leadid)->findAll();
    return $lead_followers;
    
}


function lead_followers($leadid){
    $followers='';
    $FollowersModel = new FollowersModel;
    $this_key=0;
    $tasks=$FollowersModel->where('lead_id',$leadid)->findAll();

    if (count($tasks)>0) {
        $last_key=count($tasks);

        foreach ($tasks as $lf) {
            $com='';
            $this_key++;
            
            if ($last_key!=$this_key) {
               $com=',';
            }
          
            $followers.=' '.trim(user_name($lf['follower_id'])).''.$com;
        }
        return $followers;
    }else{
        return '<i class="bx bx-revision"></i> Follow Up';
    }
}

function is_have_follower($flr,$leadid){
    $FollowersModel = new FollowersModel;
    $folreq=$FollowersModel->where('lead_id',$leadid)->where('follower_id',$flr)->first();
    if ($folreq) {
        return 1;
    }else{
        return 0;
    }
}

function create_log($leadid,$action,$myid){
    $ActivitiesNotes = new ActivitiesNotes;
    $data = [
        'lead_id' => $leadid,
        'activities' => $action,
        'type' => 'log',          
        'note' => '',
        'user_id' =>$myid,
        'created_at' => now_time($myid),
        'updated_at' => now_time($myid)
    ];
    $save = $ActivitiesNotes->insert($data);
}


function no_of_tasks($lead){
    $count=0;
    $TasksModel = new TasksModel;
    $tasks=$TasksModel->where('lead_id',$lead)->findAll();
    return count($tasks);
}



function lead_status_name($lead_status){
    if ($lead_status=='entry') {
        $lead='Entry';
    }elseif ($lead_status=='site_visit') {
        $lead='Site Visit';
    }elseif ($lead_status=='direct_loss') {
        $lead='Direct Loss';
    }elseif ($lead_status=='quotation') {
        $lead='Quotation';
    }elseif ($lead_status=='follow_up') {
        $lead='Follow Up';
    }elseif ($lead_status=='loss') {
        $lead='Loss';
    }elseif ($lead_status=='sales_order') {
        $lead='Sales Order';
    }elseif ($lead_status=='deliver_note') {
        $lead='Deliver Note';
    }elseif ($lead_status=='delivery') {
        $lead='Delivery';
    }elseif ($lead_status=='invoice') {
        $lead='Invoice';
    }elseif ($lead_status=='payment_followup') {
        $lead='Payment Followup';
    }elseif ($lead_status=='complete') {
        $lead='Complete';
    }else{
        $lead='Unknown';
    }
    return $lead;
}

function purchase_lead_status_name($lead_status){
    if ($lead_status=='entry') {
        $lead='ENTRY';
    }elseif ($lead_status=='site_visit') {
        $lead='PROCEDURE';
    }elseif ($lead_status=='direct_loss') {
        $lead='PROBLEMS';
    }elseif ($lead_status=='quotation') {
        $lead='HOLD';
    }elseif ($lead_status=='follow_up') {
        $lead='PROCESSING';
    }elseif ($lead_status=='loss') {
        $lead='COMPLETED';
    }elseif ($lead_status=='cancelled') {
        $lead='CANCELLED';
    }else{
        $lead='Unknown';
    }

    return $lead;
}
 
function purchase_status_bg($lead_status){
    if ($lead_status=='entry') {
        $lead='entry_bg_span';
    }elseif ($lead_status=='site_visit') {
        $lead='site_bg_span';
    }elseif ($lead_status=='direct_loss') {
        $lead='diloss_bg_span';
    }elseif ($lead_status=='quotation') {
        $lead='quo_bg_span';
    }elseif ($lead_status=='follow_up') {
        $lead='follw_up_bg_span';
    }elseif ($lead_status=='loss') {
        $lead='complete_bg_span';
    }elseif ($lead_status=='sales_order') {
        $lead='so_bg_span';
    }elseif ($lead_status=='deliver_note') {
        $lead='delnote_bg_span';
    }elseif ($lead_status=='delivery') {
        $lead='deli_bg_span';
    }elseif ($lead_status=='invoice') {
        $lead='invoice_bg_span';
    }elseif ($lead_status=='payment_followup') {
        $lead='pay_bg_span';
    }elseif ($lead_status=='complete') {
        $lead='complete_bg_span';
    }else{
        $lead='Unknown';
    }
    return $lead;
}


function status_bg($lead_status){
    if ($lead_status=='entry') {
        $lead='entry_bg_span';
    }elseif ($lead_status=='site_visit') {
        $lead='site_bg_span';
    }elseif ($lead_status=='direct_loss') {
        $lead='diloss_bg_span';
    }elseif ($lead_status=='quotation') {
        $lead='quo_bg_span';
    }elseif ($lead_status=='follow_up') {
        $lead='follw_up_bg_span';
    }elseif ($lead_status=='loss') {
        $lead='lost_bg_span';
    }elseif ($lead_status=='sales_order') {
        $lead='so_bg_span';
    }elseif ($lead_status=='deliver_note') {
        $lead='delnote_bg_span';
    }elseif ($lead_status=='delivery') {
        $lead='deli_bg_span';
    }elseif ($lead_status=='invoice') {
        $lead='invoice_bg_span';
    }elseif ($lead_status=='payment_followup') {
        $lead='pay_bg_span';
    }elseif ($lead_status=='complete') {
        $lead='complete_bg_span';
    }else{
        $lead='Unknown';
    }
    return $lead;
}

function crm_customer_array($company){
    $UserModel = new Main_item_party_table;
    $UserModel->where('company_id',$company)->where('deleted',0);
    $UserModel->groupStart();
    $UserModel->where('u_type','customer');
    $UserModel->orWhere('u_type','vendor');
    $UserModel->groupEnd();
    return $UserModel->orderBy('display_name','asc')->findAll();
}

function followers_array($company){
    $myid=session()->get('id');
    $UserModel = new Main_item_party_table;
    $UserModel->where('main_compani_id',main_company_id($myid))->where('deleted',0);
    $UserModel->where('u_type','staff');
    return $UserModel->findAll();
}

function all_branches($myid){
    $Companies = new Companies;
    $get_branches=$Companies->where('parent_company', main_company_id($myid))->findAll();
    return $get_branches;
}

function admin_array($company){
    $UserModel = new Main_item_party_table;
    $UserModel->where('company_id',$company)->where('deleted',0);
    $UserModel->where('u_type','admin');
    return $UserModel->findAll();
}

function leads_array(){
    $LeadModel = new LeadModel;
    return $LeadModel->findAll();
}

function active_notification_array(){
    $Notification = new Notification;
    return $Notification->where('nread',0)->where('notified',0)->findAll();
}

function date_of($when){
    if ($when=='tomorrow') {
        return date( "Y-m-d", strtotime( "+1 days" ));
    }elseif ($when=='dayaftertomorrow') {
        return date( "Y-m-d", strtotime( "+2 days" ));
    }elseif ($when=='yesterday') {
        return date( "Y-m-d", strtotime( "-1 days" ));
    }elseif ($when=='daybeforeyesterday') {
        return date( "Y-m-d", strtotime( "-2 days" ));
    }else{
        return date( "Y-m-d");
    }
}


function add_notification($title, $url,$taskid)
{
    $Notification = new Notification;
    $data=[
        'title'=>$title,
        'message'=>'',
        'url'=>$url,
        'icon'=>'',
        'taskid'=>$taskid,
        'n_datetime'=>now_time(),
        'nread'=>0,
        'notified'=>0
    ];
     $notify = $Notification->insert($data);
}

function notify_task($taskid){
    $TasksModel = new TasksModel();
    $data=[
        'notified'=>1
    ];
    $TasksModel->update($taskid,$data);
}

function read_notification($notifyid){
    $Notification = new Notification();
    $data=[
        'nread'=>1
    ];
    $Notification->update($notifyid,$data);
}


function lead_name($id){
    $LeadModel = new LeadModel;
    $user=$LeadModel->where('id', $id)->first();
    $fn=$user['lead_name'];
    return $fn;
}

function lead_serial(){
    $LeadModel = new LeadModel;
    $LeadModel->selectMax('serial_number');
    $gse = $LeadModel->first();
    return (int)$gse['serial_number']+1;
}





  function mydate($date){
        $date_arr= explode(" ", $date);
        $newdate= $date_arr[0];
        $newtime= $date_arr[1]; 
        $newdate_arr= explode("-", $newdate);
        $a_date=$newdate_arr[2];
        $a_month=$newdate_arr[1];
        $a_year=$newdate_arr[0];
        $dateObj = DateTime::createFromFormat('!m', $a_month); 
        $monthName = $dateObj->format('M');
        $new_my_date=$a_date.' '.$monthName.' '.$a_year.' '.$newtime;
        return $new_my_date; 
    }
    function aitsun_date_month_year($date){
        $date_arr= explode(" ", $date);
        $newdate= $date_arr[0];
        $newtime= $date_arr[1]; 
        $newdate_arr= explode("-", $newdate);
        $a_date=$newdate_arr[2];
        $a_month=$newdate_arr[1];
        $a_year=$newdate_arr[0];
        $dateObj = DateTime::createFromFormat('!m', $a_month); 
        $monthName = $dateObj->format('M');
        $new_my_date=$a_date.' '.$monthName.' '.$a_year;
        return $new_my_date; 
    }

    function mydateonly($date){
        $newdate_arr= explode("-", $date);
        $a_date=$newdate_arr[2];
        $a_month=$newdate_arr[1];
        $a_year=$newdate_arr[0];
        $dateObj = DateTime::createFromFormat('!m', $a_month); 
        $monthName = $dateObj->format('M');
        $new_my_date=$a_date.' '.$monthName.' '.$a_year;
        return $new_my_date; 
    }

    function aitsun_date($date){
        $date_arr= explode(" ", $date);
        $newdate= $date_arr[0];
        $newdate_arr= explode("-", $newdate); 
        return $newdate_arr[2];
    }
    function aitsun_month($date){
        $date_arr= explode(" ", $date);
        $newdate= $date_arr[0];
        $newdate_arr= explode("-", $newdate);
        $a_month=$newdate_arr[1];
        $dateObj = DateTime::createFromFormat('!m', $a_month); 
        return $dateObj->format('M'); 
    }
     function count_unread_notification(){
        $no_of_not=0;
        $Notification= new Notification;
        $notif=$Notification->where('nread',0)->findAll();
        if (count($notif)>0) {
           $no_of_not= count($notif);
        }
        return $no_of_not;
     }

     function check_notification()
     {
        $TaskModel = new TasksModel();

       $task_data=$TaskModel->where('notified',0)->where('task_date',get_date_format(now_time(),'Y-m-d'))->findAll();
       foreach ($task_data as $td) {
          $nurl=base_url('leads/details').'/'.$td['lead_id'];
          $ntitle="You have a task to follow!- ".$td['task'];
          add_notification($ntitle,$nurl,$td['id']);
          notify_task($td['id']);
       }

     }

     function get_session(){
        return session()->get('id');
     }

    function notify($title,$message,$url,$icon,$userid,$nread,$for_who,$notid){
        $myid=session()->get('id');
        $NotificationsModel =new NotificationsModel;
        $notifydata = [
            'company_id' => company($myid),
            'title' => $title, 
            'message' => $message, 
            'url' => $url, 
            'icon' => $icon, 
            'n_datetime' => now_time($myid), 
            'user_id' => $userid, 
            'nread' => $nread,
            'for_who' => $for_who ,
            'notid' => $notid ,
        ] ;

        $query=$NotificationsModel->save($notifydata);

          if ($query) {
            return $NotificationsModel->getInsertID();
          }
      }


       function timeAgo($time_agomain,$now_time)
        {
            $time_ago = strtotime($time_agomain);
            $cur_time   = strtotime($now_time);
            $time_elapsed   = $cur_time - $time_ago;
            $seconds    = $time_elapsed ;
            $minutes    = aitsun_round($time_elapsed / 60 );
            $hours      = aitsun_round($time_elapsed / 3600);
            $days       = aitsun_round($time_elapsed / 86400 );
            $weeks      = aitsun_round($time_elapsed / 604800);
            $months     = aitsun_round($time_elapsed / 2600640 );
            $years      = aitsun_round($time_elapsed / 31207680 );
            // Seconds
            if($seconds <= 60){
                return "just now";
            }
            //Minutes
            else if($minutes <=60){
                if($minutes==1){
                    return "one minute ago";
                }
                else{
                    return "$minutes minutes ago";
                }
            }
            //Hours
            else if($hours <=24){
                if($hours==1){
                    return "an hour ago";
                }else{
                    return "$hours hrs ago";
                }
            }
            //Days
            else if($days <= 7){
                if($days==1){
                    return "yesterday";
                }else{
                    return get_date_format($time_agomain,'d M Y');
                }
            }
            //Weeks
            else if($weeks <= 4.3){
                if($weeks==1){
                    return "a week ago";
                }else{
                    return get_date_format($time_agomain,'d M Y');
                }
            }
            //Months
            else if($months <=12){
                if($months==1){
                    return "a month ago";
                }else{
                    return get_date_format($time_agomain,'d M Y');
                }
            }
            //Years
            else{
                if($years==1){
                    return "one year ago";
                }else{
                    return get_date_format($time_agomain,'d M Y');
                }
            }
        }

    function no_of_notifications($u_con,$for_who){
        $NotificationsModel =new NotificationsModel;
        $Companies =new Companies;
        
        $get_branches=$Companies->where('parent_company', main_company_id($u_con));
                
        $NotificationsModel->where('nread',0);
        $NotificationsModel->groupStart();
            $NotificationsModel->where('user_id',$u_con);
            $NotificationsModel->orWhere('user_id','all');
        $NotificationsModel->groupEnd();
        $NotificationsModel->groupStart();
        $NotificationsModel->where('company_id',company($u_con));
        foreach($get_branches->findAll() as $ci){
            if ($ci['id']!=company($u_con)) {
                $NotificationsModel->orWhere('company_id',$ci['id']);
            }
        }
        $NotificationsModel->groupEnd();
        $notificationss_data=$NotificationsModel->orderBy('id','desc')->findAll();

        return count($notificationss_data);
      }
    function notification_icons($icon){
        if (!empty($icon)) {
            return base_url().'/public/images/notifications/'.$icon.'.png';
        }else{
             return base_url().'/public/images/notifications/alt.png';
        }

    }

