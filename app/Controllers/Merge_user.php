<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\InvoiceModel;
use App\Models\InvoiceitemsModel; 
use App\Models\FinancialYears;
use App\Models\PaymentsModel;
use App\Models\LeadModel; 
use App\Models\ActivitiesNotes;
use App\Models\AccountingModel;
use App\Models\Companies;
use App\Models\InvoiceTaxes;
use App\Models\MainCompanies; 
use App\Models\AttendanceModel;  
use App\Models\CarryForwardedLeaves;
use App\Models\CrmActions;
use App\Models\CrmEngineers;
use App\Models\CrmExpenses;
use App\Models\CrmPhoneCallActions;
use App\Models\ErrorSolutionsModel;
use App\Models\FollowersModel; 
use App\Models\InvoiceSubmitModel; 
use App\Models\LeaveManagement;
use App\Models\Logs;
use App\Models\NotificationsModel;
use App\Models\PayrollitemsModel;
use App\Models\PermissionModel;
use App\Models\ProductsModel;
use App\Models\ProjectTableModel;
use App\Models\RemindersModel;
use App\Models\SalaryTable;
use App\Models\TasksModel;
use App\Models\TaskreportModel;
use App\Models\VersionTableModel;
use App\Models\WorkUpdatesModel;


class Merge_user extends BaseController
{
    public function index()
    {

        $session=session();

        if ($session->has('isLoggedIn')){ 
            $myid=session()->get('id'); 
            $ntt=now_time($myid);

            $UserModel=new Main_item_party_table;

            $all_users=$UserModel->where('u_type!=','seller')->where('u_type!=','delivery')->where('u_type!=','customer')->where('u_type!=','vendor')->findAll();

            echo "<table>";
            foreach ($all_users as $us) {
                echo "<tr>";
                echo "<td>";
                 echo $us['id'];
                echo "</td>";

                echo "<td>";
                 echo user_name($us['id']);
                echo "</td>";

                echo "<td>";
                 echo $us['email'];
                echo "</td>";

                echo "<td>";
                 echo my_company_name(company($us['id']));
                echo "</td>";

                echo "</tr>";
                // echo $us['id'].'=>'.user_name($us['id']).'('.my_company_name(company($us['id'])).')<br>';
            }
            echo "</table>";
        }
    }


    // public function delete_users(){
    //     $id_lists=[
    //         [
    //             'name'=>'Praneeth',
    //             'ids_array'=>[22,140,153],
    //             'merge_to'=>22
    //         ],
    //         [
    //             'name'=>'Niharika S',
    //             'ids_array'=>[58,1589,1569,2393],
    //             'merge_to'=>58
    //         ],
    //         [
    //             'name'=>'Shwetha',
    //             'ids_array'=>[64,1565,2394,67],
    //             'merge_to'=>64
    //         ],
    //         [
    //             'name'=>'Vaishali',
    //             'ids_array'=>[66,1531,1568],
    //             'merge_to'=>66
    //         ],
    //         [
    //             'name'=>'Megha',
    //             'ids_array'=>[68,152,160,138],
    //             'merge_to'=>68
    //         ],
    //         [
    //             'name'=>'Monisha',
    //             'ids_array'=>[127,1536,139,1535],
    //             'merge_to'=>127
    //         ],
    //         [
    //             'name'=>'Supraja',
    //             'ids_array'=>[128,134,158],
    //             'merge_to'=>128
    //         ],
    //         [
    //             'name'=>'Ramya',
    //             'ids_array'=>[129,168],
    //             'merge_to'=>129
    //         ],
    //         [
    //             'name'=>'Anusha',
    //             'ids_array'=>[130,159],
    //             'merge_to'=>130
    //         ],
    //         [
    //             'name'=>'Sudheer',
    //             'ids_array'=>[131,144,156],
    //             'merge_to'=>131
    //         ],
    //         [
    //             'name'=>'Bharath',
    //             'ids_array'=>[135,162,2396],
    //             'merge_to'=>135
    //         ],
    //         [
    //             'name'=>'Rajesh',
    //             'ids_array'=>[136,167,2395],
    //             'merge_to'=>136
    //         ],
    //         [
    //             'name'=>'Sandeep',
    //             'ids_array'=>[142,154],
    //             'merge_to'=>142
    //         ],
    //         [
    //             'name'=>'Praveen',
    //             'ids_array'=>[143,155],
    //             'merge_to'=>143
    //         ],
    //         [
    //             'name'=>'Akshay',
    //             'ids_array'=>[146,161],
    //             'merge_to'=>146
    //         ],
    //         [
    //             'name'=>'Dhanush',
    //             'ids_array'=>[147,163],
    //             'merge_to'=>147
    //         ],
    //         [
    //             'name'=>'Ajay',
    //             'ids_array'=>[149,164],
    //             'merge_to'=>149
    //         ],
    //         [
    //             'name'=>'Salahudeen',
    //             'ids_array'=>[169,1585],
    //             'merge_to'=>169
    //         ],
    //         [
    //             'name'=>'Shasthara',
    //             'ids_array'=>[150,1590],
    //             'merge_to'=>150
    //         ],
    //         [
    //             'name'=>'Sooraj',
    //             'ids_array'=>[1591,1575],
    //             'merge_to'=>1575
    //         ],
    //         [
    //             'name'=>'shiva india',
    //             'ids_array'=>[60,1567,1539],
    //             'merge_to'=>60
    //         ],
    //         [
    //             'name'=>'Dinesh',
    //             'ids_array'=>[141,1624],
    //             'merge_to'=>141
    //         ]
             
    //     ];

    //     $UserModel=new Main_item_party_table();

    //     foreach ($id_lists as $dsdsd) {
    //         foreach ($dsdsd['ids_array'] as $iae) {
    //             if ($iae!=$dsdsd['merge_to']) {
    //                 $UserModel->where('id',$iae)->delete();
    //             } 
    //         }
            
    //     }
        
    // }



    // function merge_all_users(){
    //     $myid=session()->get('id');
    //     $MainCompanies= new MainCompanies();
    //     $Companies= new Companies();
    //     $UserModel= new Main_item_party_table();
    //     $AccountingModel= new AccountingModel();
    //     $ActivitiesNotes= new ActivitiesNotes();
    //     $AttendanceModel= new AttendanceModel();

    //     $CarryForwardedLeaves=new CarryForwardedLeaves();
    //     $CrmActions=new CrmActions();
    //     $CrmEngineers=new CrmEngineers();
    //     $CrmExpenses=new CrmExpenses();
    //     $CrmPhoneCallActions=new CrmPhoneCallActions();
    //     $ErrorSolutionsModel=new ErrorSolutionsModel();
    //     $FollowersModel=new FollowersModel();
    //     $InvoiceModel=new InvoiceModel();
    //     $InvoiceSubmitModel=new InvoiceSubmitModel();
    //     $LeadModel=new LeadModel();
    //     $LeaveManagement=new LeaveManagement();
    //     $Logs=new Logs();
    //     $NotificationsModel=new NotificationsModel();
    //     $PayrollitemsModel=new PayrollitemsModel();
    //     $PermissionModel=new PermissionModel();
    //     $ProductsModel=new Main_item_party_table();
    //     $ProjectTableModel=new ProjectTableModel();
    //     $RemindersModel=new RemindersModel();
    //     $SalaryTable=new SalaryTable();
    //     $TasksModel=new TasksModel();
    //     $TaskreportModel=new TaskreportModel();
    //     $VersionTableModel=new VersionTableModel();
    //     $WorkUpdatesModel=new WorkUpdatesModel();





        

    //     $id_lists=[
    //         // [
    //         //     'name'=>'Praneeth',
    //         //     'ids_array'=>[22,140,153],
    //         //     'merge_to'=>22
    //         // ],
    //         // [
    //         //     'name'=>'Niharika S',
    //         //     'ids_array'=>[58,1589,1569,2393],
    //         //     'merge_to'=>58
    //         // ],
    //         // [
    //         //     'name'=>'Shwetha',
    //         //     'ids_array'=>[64,1565,2394,67],
    //         //     'merge_to'=>64
    //         // ],
    //         // [
    //         //     'name'=>'Vaishali',
    //         //     'ids_array'=>[66,1531,1568],
    //         //     'merge_to'=>66
    //         // ],
    //         // [
    //         //     'name'=>'Megha',
    //         //     'ids_array'=>[68,152,160,138],
    //         //     'merge_to'=>68
    //         // ],
    //         // [
    //         //     'name'=>'Monisha',
    //         //     'ids_array'=>[127,1536,139,1535],
    //         //     'merge_to'=>127
    //         // ],
    //         // [
    //         //     'name'=>'Supraja',
    //         //     'ids_array'=>[128,134,158],
    //         //     'merge_to'=>128
    //         // ],
    //         // [
    //         //     'name'=>'Ramya',
    //         //     'ids_array'=>[129,168],
    //         //     'merge_to'=>129
    //         // ],
    //         // [
    //         //     'name'=>'Anusha',
    //         //     'ids_array'=>[130,159],
    //         //     'merge_to'=>130
    //         // ],
    //         // [
    //         //     'name'=>'Sudheer',
    //         //     'ids_array'=>[131,144,156],
    //         //     'merge_to'=>131
    //         // ],
    //         // [
    //         //     'name'=>'Bharath',
    //         //     'ids_array'=>[135,162,2396],
    //         //     'merge_to'=>135
    //         // ],
    //         // [
    //         //     'name'=>'Rajesh',
    //         //     'ids_array'=>[136,167,2395],
    //         //     'merge_to'=>136
    //         // ],
    //         // [
    //         //     'name'=>'Sandeep',
    //         //     'ids_array'=>[142,154],
    //         //     'merge_to'=>142
    //         // ],
    //         // [
    //         //     'name'=>'Praveen',
    //         //     'ids_array'=>[143,155],
    //         //     'merge_to'=>143
    //         // ],
    //         // [
    //         //     'name'=>'Akshay',
    //         //     'ids_array'=>[146,161],
    //         //     'merge_to'=>146
    //         // ],
    //         // [
    //         //     'name'=>'Dhanush',
    //         //     'ids_array'=>[147,163],
    //         //     'merge_to'=>147
    //         // ],
    //         // [
    //         //     'name'=>'Ajay',
    //         //     'ids_array'=>[149,164],
    //         //     'merge_to'=>149
    //         // ],
    //         // [
    //         //     'name'=>'Salahudeen',
    //         //     'ids_array'=>[169,1585],
    //         //     'merge_to'=>169
    //         // ],
    //         // [
    //         //     'name'=>'Shasthara',
    //         //     'ids_array'=>[150,1590],
    //         //     'merge_to'=>150
    //         // ],
    //         // [
    //         //     'name'=>'Sooraj',
    //         //     'ids_array'=>[1591,1575],
    //         //     'merge_to'=>1575
    //         // ],
    //         // [
    //         //     'name'=>'shiva india',
    //         //     'ids_array'=>[60,1567,1539],
    //         //     'merge_to'=>60
    //         // ],
    //         [
    //             'name'=>'Dinesh',
    //             'ids_array'=>[148],
    //             'merge_to'=>175
    //         ]
             
    //     ];

        
    //     foreach ($id_lists as $ids) {
    //         $ids_array=[];
    //         $merge_to=0;

    //         $ids_array=$ids['ids_array'];
    //         $merge_to=$ids['merge_to'];



    //         // AccountingModel
    //         $AccountingModel->where('type','ledger');
    //         $AccountingModel->groupStart();
    //            $id_count=0;
    //             foreach ($ids_array as $ids) {
    //                 $id_count++;
    //                 if ($id_count==1) {
    //                     $AccountingModel->where('customer_id',$ids);
    //                 }else{
    //                     $AccountingModel->orWhere('customer_id',$ids); 
    //                 }
    //             }
    //         $AccountingModel->groupEnd(); 
    //         $all_data=$AccountingModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'customer_id'=>$merge_to
    //             ];

    //             // updater
    //             $AccountingModel->update($ad['id'],$updata);

    //         }
    //     // AccountingModel



    //     // ActivitiesNotes  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $ActivitiesNotes->where('user_id',$ids);
    //             }else{
    //                 $ActivitiesNotes->orWhere('user_id',$ids); 
    //             }
    //         } 
    //         $all_data=$ActivitiesNotes->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'user_id'=>$merge_to
    //             ];

    //             // updater
    //             $ActivitiesNotes->update($ad['id'],$updata);

    //         }
    //     // ActivitiesNotes



    //     // AttendanceModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $AttendanceModel->where('employee_id',$ids);
    //             }else{
    //                 $AttendanceModel->orWhere('employee_id',$ids); 
    //             }
    //         } 
    //         $all_data=$AttendanceModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'employee_id'=>$merge_to
    //             ];

    //             // updater
    //             $AttendanceModel->update($ad['id'],$updata);

    //         }
    //     // AttendanceModel



    //     // CarryForwardedLeaves  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $CarryForwardedLeaves->where('staff_id',$ids);
    //             }else{
    //                 $CarryForwardedLeaves->orWhere('staff_id',$ids); 
    //             }
    //         } 
    //         $all_data=$CarryForwardedLeaves->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'staff_id'=>$merge_to
    //             ];

    //             // updater
    //             $CarryForwardedLeaves->update($ad['id'],$updata);

    //         }
    //     // CarryForwardedLeaves


    //     // CrmActions  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $CrmActions->where('added_by',$ids);
    //             }else{
    //                 $CrmActions->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$CrmActions->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $CrmActions->update($ad['id'],$updata);

    //         }
    //     // CrmActions


    //     // CrmEngineers  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $CrmEngineers->where('added_by',$ids);
    //             }else{
    //                 $CrmEngineers->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$CrmEngineers->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $CrmEngineers->update($ad['id'],$updata);

    //         }

    //         $id_count=0;
    //         foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $CrmEngineers->where('engineer',$ids);
    //             }else{
    //                 $CrmEngineers->orWhere('engineer',$ids); 
    //             }
    //         } 
    //         $all_data=$CrmEngineers->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'engineer'=>$merge_to
    //             ];

    //             // updater
    //             $CrmEngineers->update($ad['id'],$updata);

    //         }
    //     // CrmEngineers


    //     // CrmExpenses  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $CrmExpenses->where('added_by',$ids);
    //             }else{
    //                 $CrmExpenses->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$CrmExpenses->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $CrmExpenses->update($ad['id'],$updata);

    //         }
    //     // CrmExpenses


    //     // CrmPhoneCallActions  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $CrmPhoneCallActions->where('added_by',$ids);
    //             }else{
    //                 $CrmPhoneCallActions->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$CrmPhoneCallActions->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $CrmPhoneCallActions->update($ad['id'],$updata);

    //         }
    //     // CrmPhoneCallActions


    //     // ErrorSolutionsModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $ErrorSolutionsModel->where('added_by',$ids);
    //             }else{
    //                 $ErrorSolutionsModel->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$ErrorSolutionsModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $ErrorSolutionsModel->update($ad['id'],$updata);

    //         }
    //     // ErrorSolutionsModel


    //     // FollowersModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $FollowersModel->where('follower_id',$ids);
    //             }else{
    //                 $FollowersModel->orWhere('follower_id',$ids); 
    //             }
    //         } 
    //         $all_data=$FollowersModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'follower_id'=>$merge_to
    //             ];

    //             // updater
    //             $FollowersModel->update($ad['id'],$updata);

    //         }
    //     // FollowersModel


    //     // InvoiceModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $InvoiceModel->where('billed_by',$ids);
    //             }else{
    //                 $InvoiceModel->orWhere('billed_by',$ids); 
    //             }
    //         } 
    //         $all_data=$InvoiceModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'billed_by'=>$merge_to
    //             ];

    //             // updater
    //             $InvoiceModel->update($ad['id'],$updata);

    //         }
    //     // InvoiceModel


    //     // InvoiceSubmitModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $InvoiceSubmitModel->where('responsible_person',$ids);
    //             }else{
    //                 $InvoiceSubmitModel->orWhere('responsible_person',$ids); 
    //             }
    //         } 
    //         $all_data=$InvoiceSubmitModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'responsible_person'=>$merge_to
    //             ];

    //             // updater
    //             $InvoiceSubmitModel->update($ad['id'],$updata);

    //         }
    //     // InvoiceSubmitModel


    //     // LeadModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $LeadModel->where('followers',$ids);
    //             }else{
    //                 $LeadModel->orWhere('followers',$ids); 
    //             }
    //         } 
    //         $all_data=$LeadModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'followers'=>$merge_to
    //             ];

    //             // updater
    //             $LeadModel->update($ad['id'],$updata);

    //         }

    //         $id_count=0;
    //         foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $LeadModel->where('responsible_user',$ids);
    //             }else{
    //                 $LeadModel->orWhere('responsible_user',$ids); 
    //             }
    //         } 
    //         $all_data=$LeadModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'responsible_user'=>$merge_to
    //             ];

    //             // updater
    //             $LeadModel->update($ad['id'],$updata);

    //         }

    //         $id_count=0;
    //         foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $LeadModel->where('lead_by',$ids);
    //             }else{
    //                 $LeadModel->orWhere('lead_by',$ids); 
    //             }
    //         } 
    //         $all_data=$LeadModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'lead_by'=>$merge_to
    //             ];

    //             // updater
    //             $LeadModel->update($ad['id'],$updata);

    //         }
    //     // LeadModel


    //     // LeaveManagement  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $LeaveManagement->where('staff_id',$ids);
    //             }else{
    //                 $LeaveManagement->orWhere('staff_id',$ids); 
    //             }
    //         } 
    //         $all_data=$LeaveManagement->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'staff_id'=>$merge_to
    //             ];

    //             // updater
    //             $LeaveManagement->update($ad['id'],$updata);

    //         }
    //     // LeaveManagement


    //     // Logs  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $Logs->where('user_id',$ids);
    //             }else{
    //                 $Logs->orWhere('user_id',$ids); 
    //             }
    //         } 
    //         $all_data=$Logs->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'user_id'=>$merge_to
    //             ];

    //             // updater
    //             $Logs->update($ad['id'],$updata);

    //         }
    //     // Logs


    //     // NotificationsModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $NotificationsModel->where('user_id',$ids);
    //             }else{
    //                 $NotificationsModel->orWhere('user_id',$ids); 
    //             }
    //         } 
    //         $all_data=$NotificationsModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'user_id'=>$merge_to
    //             ];

    //             // updater
    //             $NotificationsModel->update($ad['id'],$updata);

    //         }
    //     // NotificationsModel


    //     // PayrollitemsModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $PayrollitemsModel->where('employee_id',$ids);
    //             }else{
    //                 $PayrollitemsModel->orWhere('employee_id',$ids); 
    //             }
    //         } 
    //         $all_data=$PayrollitemsModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'employee_id'=>$merge_to
    //             ];

    //             // updater
    //             $PayrollitemsModel->update($ad['id'],$updata);

    //         }
    //     // PayrollitemsModel


    //     // PermissionModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $PermissionModel->where('user',$ids);
    //             }else{
    //                 $PermissionModel->orWhere('user',$ids); 
    //             }
    //         } 
    //         $all_data=$PermissionModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'user'=>$merge_to
    //             ];

    //             // updater
    //             $PermissionModel->update($ad['id'],$updata);

    //         }
    //     // PermissionModel


    //     // ProductsModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $ProductsModel->where('added_by',$ids);
    //             }else{
    //                 $ProductsModel->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$ProductsModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $ProductsModel->update($ad['id'],$updata);

    //         }
    //     // ProductsModel


    //     // ProjectTableModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $ProjectTableModel->where('added_by',$ids);
    //             }else{
    //                 $ProjectTableModel->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$ProjectTableModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $ProjectTableModel->update($ad['id'],$updata);

    //         }
    //     // ProjectTableModel


    //     // RemindersModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $RemindersModel->where('added_by',$ids);
    //             }else{
    //                 $RemindersModel->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$RemindersModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $RemindersModel->update($ad['id'],$updata);

    //         }
    //     // RemindersModel


    //     // SalaryTable  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $SalaryTable->where('employee_id',$ids);
    //             }else{
    //                 $SalaryTable->orWhere('employee_id',$ids); 
    //             }
    //         } 
    //         $all_data=$SalaryTable->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'employee_id'=>$merge_to
    //             ];

    //             // updater
    //             $SalaryTable->update($ad['id'],$updata);

    //         }
    //     // SalaryTable


    //     // TasksModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $TasksModel->where('user_id',$ids);
    //             }else{
    //                 $TasksModel->orWhere('user_id',$ids); 
    //             }
    //         } 
    //         $all_data=$TasksModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'user_id'=>$merge_to
    //             ];

    //             // updater
    //             $TasksModel->update($ad['id'],$updata);

    //         }

    //         $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $TasksModel->where('followers',$ids);
    //             }else{
    //                 $TasksModel->orWhere('followers',$ids); 
    //             }
    //         } 
    //         $all_data=$TasksModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'followers'=>$merge_to
    //             ];

    //             // updater
    //             $TasksModel->update($ad['id'],$updata);

    //         }
    //     // TasksModel


    //     // TaskreportModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $TaskreportModel->where('created_by',$ids);
    //             }else{
    //                 $TaskreportModel->orWhere('created_by',$ids); 
    //             }
    //         } 
    //         $all_data=$TaskreportModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'created_by'=>$merge_to
    //             ];

    //             // updater
    //             $TaskreportModel->update($ad['id'],$updata);

    //         }
    //     // TaskreportModel


    //     // VersionTableModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $VersionTableModel->where('added_by',$ids);
    //             }else{
    //                 $VersionTableModel->orWhere('added_by',$ids); 
    //             }
    //         } 
    //         $all_data=$VersionTableModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'added_by'=>$merge_to
    //             ];

    //             // updater
    //             $VersionTableModel->update($ad['id'],$updata);

    //         }
    //     // VersionTableModel


    //     // WorkUpdatesModel  
    //        $id_count=0;
    //        foreach ($ids_array as $ids) {
    //             $id_count++;
    //             if ($id_count==1) {
    //                 $WorkUpdatesModel->where('user_id',$ids);
    //             }else{
    //                 $WorkUpdatesModel->orWhere('user_id',$ids); 
    //             }
    //         } 
    //         $all_data=$WorkUpdatesModel->findAll();

    //         foreach ($all_data as $ad) {
    //             $updata=[
    //                 'user_id'=>$merge_to
    //             ];

    //             // updater
    //             $WorkUpdatesModel->update($ad['id'],$updata);

    //         }
    //     // WorkUpdatesModel 

    //     }



        





    


    // }


}