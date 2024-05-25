<?php
    use App\Models\UserModel as UserModel;
    use App\Models\CategoryModel as CategoryModel;
    use App\Models\BookModel as BookModel;
    use App\Models\Classtablemodel as Classtablemodel;
    use App\Models\Companies as Companies;
    use App\Models\ClassModel as ClassModel;
    use App\Models\IssuebookModel as IssuebookModel;
    use App\Models\FeedbackModel as FeedbackModel;
    use App\Models\TeachersModel as TeachersModel;
    use App\Models\SubjectModel as SubjectModel;
    use App\Models\StudentcategoryModel as StudentcategoryModel;
    use App\Models\AttendanceModel as AttendanceModel;
    use App\Models\ProductsModel as ProductsModel;
    use App\Models\PricetableModel as PricetableModel;
    use App\Models\VehicleModel as VehicleModel;
    use App\Models\InvoiceModel as InvoiceModel;
    use App\Models\FeesitemsModal as FeesitemsModal; 
    use App\Models\FinancialYears as FinancialYears; 
    use App\Models\InvoiceitemsModel as InvoiceitemsModel; 
    use App\Models\CompanySettings as CompanySettings; 
    use App\Models\FeesModel as FeesModel; 
    use App\Models\InstallmentsModel as InstallmentsModel;
    use App\Models\AnalyticsModel as AnalyticsModel;
    use App\Models\SportsparticipantModel as SportsparticipantModel;
    use App\Models\SportseventModel as SportseventModel;
    use App\Models\RewardingModel as RewardingModel; 
    use App\Models\AcademicYearModel as AcademicYearModel; 
    use App\Models\MarksModel as MarksModel; 
    use App\Models\HealthModel as HealthModel; 
    use App\Models\MagazineModel as MagazineModel; 
    use App\Models\EcccparticipantModel as EcccparticipantModel;
    use App\Models\PaymentsModel as PaymentsModel;
    use App\Models\TimetableModel as TimetableModel; 
    use App\Models\CompanySettings2 as CompanySettings2; 
    use App\Models\StudentlocationModel as StudentlocationModel; 
    use App\Models\Examcategorymodel as Examcategorymodel; 
    use App\Models\MainexamModel as MainexamModel; 
    use App\Models\ExamModel as ExamModel; 
    use App\Models\AccountingModel as AccountingModel; 
    use App\Models\Main_item_party_table as Main_item_party_table; 


    
    



    function serial_no_timetable($company){
            $TimetableModel = new TimetableModel;
            $TimetableModel->selectMax('serial_no');
            $TimetableModel->where('company_id',$company)->where('deleted',0)->where('academic_year',academic_year($company));
            $get_serial=$TimetableModel->first();
            return $get_serial['serial_no']+1;
        }


    function priority_word($number){
        if ($number=='0') {
           return 'Sunday';
        }elseif ($number=='1') {
            return 'Monday';
        }elseif ($number=='2') {
            return 'Tuesday';
        }elseif ($number=='3') {
            return 'Wednesday';
        }elseif ($number=='4') {
            return 'Thursday';
        }elseif ($number=='5') {
            return 'Firday';
        }elseif ($number=='6') {
            return 'Saturday';
        }

    } 

    function get_student_attendance_data_by_date($employee_id,$dates,$column){
        $AttendanceModel = new AttendanceModel();
        $attddata= $AttendanceModel->where('date',$dates)->where('student_id',$employee_id)->first();
        if ($attddata) {
           return $attddata[$column];
        }else{
            return '-';
        }
    }

    function get_transport_data($company_id){
        $AccountingModel = new Main_item_party_table;
        $AccountingModel->where('company_id',$company_id);
        
        $AccountingModel->where('transport_charge',1); 
        
        $user=$AccountingModel->findAll();
        return $user;
    }


    function academic_year_array($org_id){
        $AcademicYearModel = new AcademicYearModel;
        $yeararray=$AcademicYearModel->where('company_id', $org_id)->where('deleted',0)->findAll();
        return $yeararray;
    }
    function category_sudents($company_id,$category){
        $Classtablemodel=new Classtablemodel();
        $getuse=$Classtablemodel->where('company_id',$company_id)->where('category',$category)->where('academic_year', academic_year(session()->get('id')))->where('deleted','0')->orderBy('first_name','ASC')->findAll();
        return $getuse;
    }
     function no_of_category_sudents($company_id,$category){
        $Classtablemodel=new Classtablemodel();
        $getuse=$Classtablemodel->where('company_id',$company_id)->where('category',$category)->where('academic_year', academic_year(session()->get('id')))->where('deleted','0')->orderBy('first_name','ASC')->countAllResults();
        return $getuse;
    }

    function get_time_table_array($company,$class_id,$week,$user){
            $TimetableModel = new TimetableModel;
            $starray=$TimetableModel->where('company_id', $company)->where('class_id',$class_id)->where('week', $week)->orderBy('start_time', 'ASC')->where('deleted',0)->where('academic_year',academic_year($user))->findAll();
            return $starray;
        }

    function get_paid_challans($company_id,$fees_id,$get_collected,$get_from,$get_to,$classid){
        $InvoiceModel=new InvoiceModel();
        $PaymentsModel=new PaymentsModel();
        $myid=session()->get('id');

         if (!empty($get_from) && empty($get_to)) {
            $PaymentsModel->where('date(datetime)',$get_from);
        }
        if (!empty($get_to) && empty($get_from)) {
            $PaymentsModel->where('date(datetime)',$get_to);
        }

        if (!empty($get_to) && !empty($get_from)) {
            $PaymentsModel->where("date(datetime) BETWEEN '$get_from' AND '$get_to'");
        }

        if (!empty($classid)) {
            $PaymentsModel->where('class_id',$classid);
        }

        $daybookdata=$PaymentsModel->where('company_id',$company_id)->where('fees_id',$fees_id)->where('bill_type','sales')->where('deleted',0)->findAll();

        return $daybookdata;
    }
    
    function student_pro_pic($id){
        $UserModel = new Main_item_party_table;
        $studname=$UserModel->where('id', $id)->first();
        if (trim($studname['profile_pic'])!='') {
            return base_url('public').'/uploads/students/'.$studname['profile_pic']; 
        }else{
            return base_url('public').'/images/avatars/thumb-3.jpg'; 
        }
    }

    function get_roll_no_of_student($company_id,$student_id){
            $Classtablemodel = new Classtablemodel;
        $classtablerollnodata=$Classtablemodel->where('company_id',$company_id)->where('student_id',$student_id)->where('academic_year',academic_year(session()->get('id')))->first();
        if ($classtablerollnodata) {
            return $classtablerollnodata['roll_no'];
        }else{
            return 0;
        }
        
    }

    function get_analytics_data($company_id,$student_id,$column){

            $AnalyticsModel=new AnalyticsModel;
            $analyticsdata=0;
            $anadata=0;
            $totalin=0;
            $healthdata=$AnalyticsModel->where('company_id',$company_id)->where('student_id',$student_id)->where('academic_year',academic_year(session()->get('id')))->findAll();
            foreach ($healthdata as $ad) {
                if ($ad[$column]!=0) {
                    $anadata+=$ad[$column];
                    $totalin+=100;
                }
                
            }

            if ($totalin>0) {
               $analyticsdata=$anadata/$totalin*100;
            }

            return aitsun_round($analyticsdata,2);

    }

    function performance_in_exams($company,$student_id){
        $MarksModel=new MarksModel;
        $mardata=$MarksModel->where('company_id',$company)->where('student_id',$student_id)->where('academic_year',academic_year($company))->findAll();
        $aggregate_mark=0;
        $totalmark=0;

        foreach ($mardata as $md) {
            $aggregate_mark+=$md['marks'];
            $totalmark+=max_mark($company,$md['academic_year'],$md['exam_id'],$md['subject_id']);
        }
        
        if($totalmark<=0){
            return 0;
        }else{
            return $aggregate_mark/$totalmark*100;
        }
        
    }

     function calculate_BMI($weight,$height,$age,$gender,$returnq){
        if($height!=0){
            $height_cm=$height/100;
            $bmi = $weight/($height_cm*$height_cm);
          
            $result = '';
            $bmiStyle='';
            if($bmi<18.5){
                $result = 'Underweight';
                $bmiStyle ='text-info';
             }elseif(18.5<=$bmi&&$bmi<=24.9){
                $result = 'Healthy';
                $bmiStyle ='text-success';
             }elseif(25<=$bmi&&$bmi<=29.9){
                $result = 'Overweight';
                $bmiStyle ='text-primary';
             }elseif(30<=$bmi&&$bmi<=34.9){
                $result = 'Obese';
                $bmiStyle ='text-warning';
             }elseif(35<=$bmi){
                $result = 'Extremely obese';
                $bmiStyle ='text-danger';
             }

             $fatpercentage=0;

             if ($gender=='Male') {
                $fatpercentage=(1.20*$bmi)+(0.23*$age)-16.2;
             }
            
            if ($returnq=='badge') {
                return '<div class="'.$bmiStyle.'">'.$result.' - '.aitsun_round($bmi,2).'</div>';
            }elseif ($returnq=='fat_percentage') {
                return aitsun_round($fatpercentage,2);
               
            }
        }else{
            return 0;
        }
        
    }

    
    function year_of_academic_year($aid){
        $AcademicYearModel = new AcademicYearModel;
        $yaername=$AcademicYearModel->where('id',$aid)->first();
        if($yaername){
            return $yaername['year'];
        }else{
            return'';
        }
                    
    }

function get_health_data($company_id,$student_id,$column){
    $HealthModel=new HealthModel;
    $healthdata=$HealthModel->where('company_id',$company_id)->where('student_id',$student_id)->where('academic_year',academic_year(session()->get('id')))->first();
    if ($healthdata) {
        return $healthdata[$column];
    }else{
        return 0;
    }
}

function total_articles_of_student($company_id,$std_id,$status){
        $MagazineModel = new MagazineModel();
        $artarray=
        $MagazineModel->where('company_id', $company_id)->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->where('student_id',$std_id);
        if (!empty($status)) {
            if ($status!='all') {
                $MagazineModel->where('status',$status);
            }
        }
        

        $artarray=$MagazineModel->findAll();

        return count($artarray);
}

function total_issued_books_of_student($company_id,$std_id,$status){
        $IssuebookModel = new IssuebookModel();
        $artarray=
        $IssuebookModel->where('company_id', $company_id)->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->where('student_id',$std_id);
        if (!empty($status)) {
            if ($status!='all') {
                $IssuebookModel->where('status',$status);
            }
        }
        
        $artarray=$IssuebookModel->findAll();

        return count($artarray);
}

function sports_student_participate_array($company_id,$student_id){
    $SportsparticipantModel = new SportsparticipantModel;
    $starray=$SportsparticipantModel->where('company_id', $company_id)->where('type','sports')->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->where('student_id',$student_id)->findAll();
    return $starray;
}

function sports_student_event_array($company_id,$student_id){
    $RewardingModel = new RewardingModel;
    $starray=$RewardingModel->where('company_id', $company_id)->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->where('student_id',$student_id)->where('type','sports')->where('reward!=','')->where('reward!=','not participated')->findAll();
    return $starray;
}

function eccc_student_participate_array($company_id,$student_id){
    $SportsparticipantModel = new SportsparticipantModel;
    $starray=$SportsparticipantModel->where('company_id', $company_id)->where('type','eccc')->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->where('student_id',$student_id)->findAll();
    return $starray;
}
 function eccc_student_event_array($company_id,$student_id){
        $RewardingModel = new RewardingModel;
        $starray=$RewardingModel->where('company_id', $company_id)->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->where('student_id',$student_id)->where('type','eccc')->where('reward!=','')->where('reward!=','not participated')->findAll();
        return $starray;
    }

    function get_fees_data($company,$id,$column){
        $FeesModel = new FeesModel;
        $farray=$FeesModel->where('company_id', $company)->where('id', $id)->orderby('id','desc')->first();
        if ($farray) {
           return $farray[$column];
        }else{
            return '0';
        }
    }

    function feeses_array($company){
        $FeesModel= new FeesModel();
        $username=$FeesModel->where('company_id',$company)->where('academic_year',academic_year($company))->where('deleted',0);
        $get_res= $username->findAll();
        return $get_res;
    }

    function current_academic_year($ft,$company_id){
        $AcademicYearModel = new AcademicYearModel;
        $gs=$AcademicYearModel->where('company_id',$company_id)->first();

        if ($gs) {
            return $gs[$ft];
        }else{
            return 'no_academic_years';
        }
    }

    function drivers_array($company_id){
        $UserModel=new Main_item_party_table();
        $getuse=$UserModel->where('company_id',$company_id)->where('u_type','driver')->where('deleted',0)->orderBy('id','DESC')->findAll();
        return $getuse;
    }


    function vehicle_students_array($org_id){
        $StudentlocationModel = new StudentlocationModel;
        $tarray=$StudentlocationModel->where('company_id', $org_id)->where('deleted',0)->findAll();
        return $tarray;
    }


    function subject_array($sub_id){
        $SubModel = new SubjectModel;
        $starray=$SubModel->where('company_id', $sub_id)->where('sub_type', 'main_sub')->where('deleted',0)->findAll();
        return $starray;
    }


function user_password($id){
        $UserModel = new Main_item_party_table;
        $fn='xxxxxxxx';
        if (trim($id)!=0) {
            $user=$UserModel->where('id', $id)->first();
            if ($user) {
                $fn=$user['password_2'];
            }
            
        }
        return $fn;
    }
    
    function academic_year_value($ft,$year){
        $xyear=explode('-',$year);

        if ($ft=='from') {
            return $xyear[0];
        }elseif ($ft=='to') {
            return $xyear[1];
        }else{
            return 'Undefined';
        }

    }

    function pstat_of_install($inid){
        $InstallmentsModel = new InstallmentsModel();
        $all_installments=$InstallmentsModel->where('id',$inid)->where('deleted',0)->first();
        if ($all_installments) {
            return $all_installments['paid_status'];
        }else{
            return '';
        }
    }

    function currency_symbol_for_sms($company){
        return 'Rs.';
    }

    function sports_name($sp_id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $sp_id)->first();
        $name=$orname['sports_id'];
        return $name;
    }

function eccc_name($ec_id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $ec_id)->first();
        $name=$orname['eccc_id'];
        return $name;
    }

function serial_sports($company,$sub){
    $SubjectModel = new SubjectModel;
    $username=$SubjectModel->where('company_id',$company)->where('id', $sub)->where('sub_type','sports_sub');
    $get_res= $username->findAll();
    foreach ($get_res as $get_r) {
        $name=$get_r['serial_no'];
        return $name;
    } 
}
function serial_no_sports($company){
    $SubjectModel = new SubjectModel;
    $SubjectModel->selectMax('serial_no');
    $SubjectModel->where('company_id',$company)->where('sub_type','sports_sub')->where('deleted',0);
    $get_serial=$SubjectModel->first();
    return $get_serial['serial_no']+1;
}


function get_subject_data($sub_id,$column){
        $SubjectModel = new SubjectModel();
        $bcarry=$SubjectModel->where('id', $sub_id)->first();
        return $bcarry[$column];
    }


function sports_array($sub_id){
        $SubModel = new SubjectModel;
        $starray=$SubModel->where('company_id', $sub_id)->where('sub_type', 'sports_sub')->where('deleted',0)->findAll();
        return $starray;
    }
function subjects_name($sub_id){
        $SubModel = new SubjectModel;
        $subarray=$SubModel->where('id', $sub_id)->where('deleted',0)->first();
        if ($subarray) {
            $subname=$subarray['subject_name'];
        }else{
            $subname='';
        }
        return $subname;
    }

function get_analytics_subject_data($company_id,$student_id,$sports_id,$column){

        $AnalyticsModel=new AnalyticsModel;
        $analyticsdata=0;
        $anadata=0;
        $totalin=0;
        $healthdata=$AnalyticsModel->where('company_id',$company_id)->where('student_id',$student_id)->where('sports_eccc_id',$sports_id)->where('academic_year',academic_year(session()->get('id')))->first();
        if ($healthdata) {
            return $healthdata[$column];
        }else{
            return 0;
        }
    }


function serial_sports_students($company,$part){
        $SportsparticipantModel = new SportsparticipantModel;
        $username=$SportsparticipantModel->where('company_id',$company)->where('id', $part)->where('type','sports')->where('academic_year',academic_year($company));
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
function serial_no_participant($company){
        $SportsparticipantModel = new SportsparticipantModel;
        $SportsparticipantModel->selectMax('serial_no');
        $SportsparticipantModel->where('company_id',$company)->where('deleted',0)->where('type','sports')->where('academic_year',academic_year($company));
        $get_serial=$SportsparticipantModel->first();
        return $get_serial['serial_no']+1;
    }

 function get_sports_participant_data($particpant_id,$column){
        $SportsparticipantModel = new SportsparticipantModel();
        $particidata=$SportsparticipantModel->where('id',$particpant_id)->first();
        if ($particidata) {
           return $particidata[$column];
        }else{
            return '';
        }
    }


function serial_sportsevents($company,$spven){
        $SportseventModel = new SportseventModel;
        $username=$SportseventModel->where('company_id',$company)->where('id', $spven)->where('type','sports')->where('academic_year',academic_year($company));
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
    function serial_no_sportsevent($company){
        $SportseventModel = new SportseventModel;
        $SportseventModel->selectMax('serial_no');
        $SportseventModel->where('company_id',$company)->where('deleted',0)->where('type','sports')->where('academic_year',academic_year($company));
        $get_serial=$SportseventModel->first();
        return $get_serial['serial_no']+1;
    }


function get_sports_event_data($company_id,$event_id,$column){
        $SportseventModel = new SportseventModel();
        $eventdata= $SportseventModel->where('id',$event_id)->where('company_id',$company_id)->where('academic_year',academic_year(session()->get('id')))->first();
        if ($eventdata) {
           return $eventdata[$column];
        }else{
            return '';
        }
    }


function get_reward_data($company_id,$student_id,$event_id,$column,$type){
        $RewardingModel=new RewardingModel;
        $healthdata=$RewardingModel->where('company_id',$company_id)->where('student_id',$student_id)->where('type',$type)->where('event_id',$event_id)->where('academic_year',academic_year(session()->get('id')))->first();
        if ($healthdata) {
            return $healthdata[$column];
        }else{
            return 0;
        }
    }

function serial_activity($company,$sub){
        $SubjectModel = new SubjectModel;
        $username=$SubjectModel->where('company_id',$company)->where('id', $sub)->where('sub_type','eccc_sub');
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
    function serial_no_activity($company){
        $SubjectModel = new SubjectModel;
        $SubjectModel->selectMax('serial_no');
        $SubjectModel->where('company_id',$company)->where('sub_type','eccc_sub')->where('deleted',0);
        $get_serial=$SubjectModel->first();
        return $get_serial['serial_no']+1;
    }

function activities_array($sub_id){
        $SubModel = new SubjectModel;
        $starray=$SubModel->where('company_id', $sub_id)->where('sub_type', 'eccc_sub')->where('deleted',0)->findAll();
        return $starray;
    }


    function serial_eccc_students($company,$part){
        $SportsparticipantModel = new SportsparticipantModel;
        $username=$SportsparticipantModel->where('company_id',$company)->where('id', $part)->where('type','eccc')->where('academic_year',academic_year($company));
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }

    function serial_no_actparticipant($company){
        $SportsparticipantModel = new SportsparticipantModel;
        $SportsparticipantModel->selectMax('serial_no');
        $SportsparticipantModel->where('company_id',$company)->where('type','eccc')->where('deleted',0)->where('academic_year',academic_year($company));
        $get_serial=$SportsparticipantModel->first();
        return $get_serial['serial_no']+1;
    }



    function serial_ecccevents($company,$ecven){
        $SportseventModel = new SportseventModel;
        $username=$SportseventModel->where('company_id',$company)->where('id', $ecven)->where('type','eccc')->where('academic_year',academic_year($company));
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
    function serial_no_ecccevent($company){
        $SportseventModel = new SportseventModel;
        $SportseventModel->selectMax('serial_no');
        $SportseventModel->where('company_id',$company)->where('deleted',0)->where('type','eccc')->where('academic_year',academic_year($company));
        $get_serial=$SportseventModel->first();
        return $get_serial['serial_no']+1;
    }


    function installments_array($invoice_id){
        $InstallmentsModel = new InstallmentsModel();
        $all_installments=$InstallmentsModel->where('invoice_id',$invoice_id)->where('deleted',0)->findAll();
        return $all_installments;
    }


    function organisation_name($id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $id)->first();
        $name=$orname['company_name'];
        return $name;
    }

    function organisation_address($id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $id)->first();
        $name=''; 
        $name.=($orname['address'] != '') ? $orname['address'].'<br>' : '';
        $name.=($orname['city'] != '') ? $orname['city'].', ' : '';
        $name.=($orname['state'] != '') ? $orname['state'].', ' : '';
        $name.=($orname['country'] != '') ? $orname['country'].', ' : '';
        $name.=($orname['postal_code'] != '') ? $orname['postal_code'].'' : '';  
        return $name;
    }

    function organisation_phone($id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $id)->first();
        $name=$orname['company_phone'];
        return $name;
    }

    function organisation_email($id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $id)->first();
        $name=$orname['email'];
        return $name;
    }

    function organisation_logo($id){
        $Companies = new Companies;
        $orname=$Companies->where('id', $id)->first();
        if (trim($orname['company_logo'])!='') {
            return base_url('public').'/images/company_docs/'.$orname['company_logo']; 
        }else{
            return base_url('public').'/images/avatars/thumb-3.jpg'; 
        }
    }

    function get_organisation_settings($company_id,$column){
        $CompanySettings = new CompanySettings;
        $orname=$CompanySettings->where('company_id',$company_id)->first();
        return $orname[$column];
    }

    function  transport_items($company_id){
        $ProductsModel=new Main_item_party_table();
        $items=$ProductsModel->where('company_id',$company_id)->where('product_method','service')->where('main_type','product')->where('view_as','transport')->where('deleted',0)->orderBy('id','DESC')->findAll();
        return $items;
    }

     function students_array_of_class($org_id,$class){
        $Classtablemodel = new Classtablemodel;
        $tarray=$Classtablemodel->where('company_id', $org_id)->where('academic_year', academic_year(session()->get('id')))->where('class_id', $class)->where('deleted', 0)->where('transfer','')->orderby('first_name','ASC')->findAll();
        return $tarray;
    }
  

    function fees_of_student($company_id,$category,$class,$item_id){
        $PricetableModel=new PricetableModel;
        $items=$PricetableModel->where('company_id',$company_id)->where('category_id',$category)->where('class',$class)->where('item_id',$item_id)->where('deleted',0)->first();
        if ($items) {
            return $items['price'];
        }else{
            return 0;
        } 
    }
    
    function products_optional_array($company){
        $ProductsModel=new Main_item_party_table;
        $items=$ProductsModel->where('company_id',$company)->where('product_method','service')->where('main_type','product')->where('deleted',0)->orderBy('id','ASC')->findAll();
        return $items;
    }

    function is_exist_in_invoice_items($invoice_id,$invoice_items_id){
        $InvoiceitemsModel = new InvoiceitemsModel();
        $returnval=false;
        $initemsdata= $InvoiceitemsModel->where('invoice_id',$invoice_id)->where('product_id',$invoice_items_id)->first();
        if ($initemsdata) {
            $returnval=true;
        }
        return $returnval;
    }

    function get_exist_in_invoice_items_data($invoice_id,$invoice_items_id,$columnnn){
        $InvoiceitemsModel = new InvoiceitemsModel();
        $returnval=false;
        $initemsdata= $InvoiceitemsModel->where('invoice_id',$invoice_id)->where('product_id',$invoice_items_id)->first();
        if ($initemsdata) {
            $returnval=$initemsdata[$columnnn];
        }
        return $returnval;
    }

    function book_cate_name($bct_id){
        $category = new CategoryModel();
        $bcarry=$category->where('id', $bct_id)->first();
        $bcname=$bcarry['category'];
        return $bcname;
    }

    function book_name($bk_id){
        $book = new BookModel();
        $bcarry=$book->where('id', $bk_id)->first();
        $bcname=$bcarry['book_title'];
        return $bcname;
    }

    function count_books($company_id){
        $BookModel = new BookModel();
        $bkarray=$BookModel->where('company_id', $company_id)->where('deleted',0)->findAll();
        return count($bkarray);
    }

    function class_name($cls_id){
        $ClassModel = new ClassModel;
        $clsarry=$ClassModel->where('id', $cls_id)->first();
        if ($clsarry) {
            $clsname=$clsarry['class'];
        }else{
            $clsname='';
        }
        
        return $clsname;
    }

    function vehicles_array($company_id){
        $VehicleModel=new VehicleModel();
        $getuse=$VehicleModel->where('company_id',$company_id)->where('deleted',0)->orderBy('id','DESC')->findAll();
        return $getuse;
    }

    function products_default_array($company){
        $ProductsModel=new Main_item_party_table;
        $items=$ProductsModel->where('company_id',$company)->where('product_method','service')->where('main_type','product')->where('product_type','fees')->where('deleted',0)->orderBy('id','ASC')->findAll();
        return $items;
    }

    function products_default_only_fees_array($company){
        $ProductsModel=new Main_item_party_table;
        $items=$ProductsModel->where('company_id',$company)->where('product_method','service')->where('main_type','product')->where('product_type','fees')->where('view_as!=','transport')->where('deleted',0)->orderBy('id','ASC')->findAll();
        return $items;
    }

    function get_analytics_item_price_data($company_id,$category_id,$item_id,$class,$column){

        $PricetableModel=new PricetableModel;
        $analyticsdata=0;
        $anadata=0;
        $totalin=0;
        $itempricedata=$PricetableModel->where('company_id',$company_id)->where('category_id',$category_id)->where('class',$class)->where('item_id',$item_id)->first();
        if ($itempricedata) {
            return $itempricedata[$column];
        }else{
            return 0;
        }
    }


    function current_class_of_student($company_id,$student_id){
        $Classtablemodel = new Classtablemodel;
        $classtabledata=$Classtablemodel->where('company_id',$company_id)->where('student_id',$student_id)->where('academic_year',academic_year(session()->get('id')))->where('deleted',0)->where('transfer','')->first();
        if ($classtabledata) {
            return $classtabledata['class_id'];
        }else{
            return 0;
        }
        
    }

    function current_class_of_student_by_year($company_id,$student_id,$year){
        $Classtablemodel = new Classtablemodel;
        $classtabledata=$Classtablemodel->where('company_id',$company_id)->where('student_id',$student_id)->where('academic_year',$year)->where('transfer','')->first();
        if ($classtabledata) {
            return $classtabledata['class_id'];
        }else{
            return 0;
        }
        
    }

    function academic_year($myid){
       $Main_item_party_table = new Main_item_party_table;
       $cus_row=$Main_item_party_table->where('id', $myid)->first();
       if ($cus_row) {
           return $cus_row['activated_academic'];
       }else{
           return 0;
       }
       
    }

    function get_issued_book_data($isue_id,$column){
        $IssuebookModel = new IssuebookModel();
        $bcarry=$IssuebookModel->where('id', $isue_id)->first();
        return $bcarry[$column];
    }


    function send_sms_school($company,$message,$mobileNumber){
        $fields = array(
            "message" => $message,
            "language" => "english",
            "route" => "v3",
            "sender_id" => 'FTWSMS',
            "numbers" => $mobileNumber,
        );



        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: Y9gztp6vla0Z1HbXrmA2ei7LKhnMqCfQojs8RuwFcEySVO3kxGQAhf3c7ubGxL60P9EZOJlv8BtUjYRF",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $manage = json_decode($response, true);

        $sms_status=$manage['return'];
        $sms_message=$manage['message'];

        if ($sms_status=='true') {
             $lstcred=message_credits($company)-1;
            $org_data = [
              'message_credits'=>$lstcred
            ];

            $UserModel = new Main_item_party_table;

            $aurthorid=author_id($company);
            $UserModel->update($aurthorid,$org_data);

            return true;

               
        } else {
            
            return false;
            
        }

    }



    function send_bundle_sms($company,$message,$mobileNumber){
        $fields = array(
            "message" => $message,
            "language" => "english",
            "route" => "v3",
            "sender_id" => 'FTWSMS',
            "numbers" => $mobileNumber,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($fields),
          CURLOPT_HTTPHEADER => array(
            "authorization: Y9gztp6vla0Z1HbXrmA2ei7LKhnMqCfQojs8RuwFcEySVO3kxGQAhf3c7ubGxL60P9EZOJlv8BtUjYRF",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

         // echo $response;

        $manage = json_decode($response, true);

        if (isset($manage['return'])) {
           $sms_status=$manage['return'];
            $sms_message=$manage['message'];

            if ($sms_status=='true') {
                 $lstcred=message_credits($company)-1;
                $org_data = [
                  'message_credits'=>$lstcred
                ];

                $UserModel = new Main_item_party_table;

                $aurthorid=author_id($company);
                $UserModel->update($aurthorid,$org_data);

                return $sms_status;

                   
            } else {
                
                return $sms_message;
                
            }
        }else{
            return $response;
        }
        

    }

function get_next_unpaid_installment_data($invoice_id,$limit){
    $InstallmentsModel = new InstallmentsModel();
    $all_installments=$InstallmentsModel->where('invoice_id',$invoice_id)->where('deleted',0)->where('paid_status','unpaid')->findAll($limit);
     
    return $all_installments;
    
}



function students_array($org_id){
        $UserModel = new Main_item_party_table;
        $myid=session()->get('id');
        $tarray=$UserModel->where('company_id', $org_id)->where('u_type', 'student')->where('main_type', 'user')->where('deleted',0)->where('transfer','')->findAll();
        return $tarray;
    }
    
function book_array($bk_id){
        $book = new BookModel();
        $bkarray=$book->where('company_id', $bk_id)->where('deleted',0)->findAll();
        return $bkarray;
    }

function book_category_array($bk_id){
        $category = new CategoryModel();
        $bkarray=$category->where('company_id', $bk_id)->where('deleted',0)->findAll();
        return $bkarray;
    }

 function main_base_url(){
        return 'https://aitsun.net/asms/student/';
    }

function serial_issuedbook($company,$isubook){
        $issuemodel = new IssuebookModel();
        $username=$issuemodel->where('company_id',$company)->where('id', $isubook)->where('deleted',0);
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
function serial_no_issuedbook($company){
        $issuemodel = new IssuebookModel();
        $issuemodel->selectMax('serial_no');
        $issuemodel->where('company_id',$company)->where('deleted',0);
        $get_serial=$issuemodel->first();
        return $get_serial['serial_no']+1;
    }



    function twelve_to_24($twelve_time){
        // 11 : 34 AM
        $hour='00';
        $min='00';
        $gpl=explode(' ',$twelve_time);
        $spl=explode(':', $gpl[0]);
        $hour=$spl[0];
        $min=$spl[1];
        if ($gpl[1]=='PM') {
            if ($spl[0]==1 || $spl[0]==2 || $spl[0]==3 || $spl[0]==4 || $spl[0]==5 || $spl[0]==6 || $spl[0]==7 || $spl[0]==8 || $spl[0]==9 || $spl[0]==10 || $spl[0]==11) {
                $hour=$spl[0]+12;
            }elseif($spl[0]==12){
                $hour=12;
            }
        }
        if ($gpl[1]=='AM') {
            if ($spl[0]==12) {
                $hour='00';
            }
        }
        return $hour.':'.$min.':00';
    }

function total_feedback($company_id){
        $FeedbackModel = new FeedbackModel;
        $feed=$FeedbackModel->where('company_id', $company_id)->where('deleted',0)->where('academic_year',academic_year(session()->get('id')))->findAll();
        return count($feed);
    }

 function fees_items_array($fees_id){
    $FeesitemsModal=new FeesitemsModal;
    $items=$FeesitemsModal->where('fees_id',$fees_id)->findAll();
    return $items;
}

function get_teacher_of_class($org_id,$class){
        $TeachersModel = new TeachersModel;
        $tarray=$TeachersModel->where('company_id', $org_id)->where('academic_year', academic_year(session()->get('id')))->where('class_id', $class)->first();

        if ($tarray) {
            return $tarray['teacher_id'];
        }else{
            return '';
        }
       
    }


function total_class_students($company_id,$class_id,$gender){
        $Classtablemodel = new Classtablemodel();
        
        $Classtablemodel->where('company_id', $company_id)->where('academic_year', academic_year(session()->get('id')))->where('deleted',0)->where('class_id',$class_id);

        if ($gender=='male') {
            $Classtablemodel->where('gender', 'male');
        }elseif ($gender=='female') {
            $Classtablemodel->where('gender', 'female');
        }elseif ($gender=='others') {
            $Classtablemodel->where('gender', 'others');
        }else{

        }

        $starray=$Classtablemodel->countAllResults(); 
        return $starray; 
    }


function serial_sub($company,$sub){
        $SubjectModel = new SubjectModel;
        $username=$SubjectModel->where('company_id',$company)->where('id', $sub)->where('sub_type','main_sub');
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
    function serial_no_sub($company){
        $SubjectModel = new SubjectModel;
        $SubjectModel->selectMax('serial_no');
        $SubjectModel->where('company_id',$company)->where('sub_type','main_sub')->where('deleted',0);
        $get_serial=$SubjectModel->first();
        return $get_serial['serial_no']+1;
    }

function superusers_array($org_id){
        $UserModel = new Main_item_party_table;
        $myid=session()->get('id');
        $tarray=$UserModel->where('company_id', $org_id)->where('main_type','user')->where('u_type', 'admin')->where('deleted',0)->findAll();
        return $tarray;
    }

function teachers_array($org_id){
        $UserModel = new Main_item_party_table;
         $myid=session()->get('id');
        $tarray=$UserModel->where('company_id', $org_id)->where('main_type','user')->where('u_type', 'teacher')->where('deleted',0)->findAll();
        return $tarray;
    }

function serialclass($company,$class){
        $ClassModel = new ClassModel;
        $username=$ClassModel->where('company_id',$company)->where('id', $class);
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
function serial_no_class($company){
    $ClassModel = new ClassModel;
    $ClassModel->selectMax('serial_no');
    $ClassModel->where('company_id',$company)->where('deleted',0);
    $get_serial=$ClassModel->first();
    return $get_serial['serial_no']+1;
}





function school_code($cmpid){
    $Companies = new Companies;
    $code=$Companies->where('id', $cmpid)->first();
    $codename=$code['sc_code'];
    return $codename;
}
function location_code($cmpid){
    $Companies = new Companies;
    $code=$Companies->where('id', $cmpid)->first();
    $codename=$code['lc_code'];
    return $codename;
}

 

function total_students($company_id){
    $user = new Main_item_party_table();
    $starray=$user->where('company_id', $company_id)->where('u_type', 'student')->where('deleted',0)->findAll();
    return count($starray);
}

function classes_array($clss_id){
    $ClassModel = new ClassModel;
    $starray=$ClassModel->where('company_id', $clss_id)->where('deleted',0)->findAll();
    return $starray;
}

function student_category_array($company_id){
    $StudentcategoryModel = new StudentcategoryModel;
    $starray=$StudentcategoryModel->where('company_id', $company_id)->where('type', 'main')->where('deleted',0)->findAll();
    return $starray;
}
function student_sub_category_array($company_id){
    $StudentcategoryModel = new StudentcategoryModel;
    $starray=$StudentcategoryModel->where('company_id', $company_id)->where('type', 'sub')->where('deleted',0)->findAll();
    return $starray;
}


function student_category_name($stc_id){
    $StudentcategoryModel = new StudentcategoryModel;
    $stdcatarray=$StudentcategoryModel->where('id', $stc_id)->where('deleted',0)->first();
    
    if ($stdcatarray) {
        $catname=$stdcatarray['category_name'];
    }else{
        $catname='';
    }
    return $catname;
}


function serial_student($company,$student){
        $UserModel = new Main_item_party_table;
        $username=$UserModel->where('company_id',$company)->where('id', $student)->where('u_type','student');
        $get_res= $username->findAll();
        foreach ($get_res as $get_r) {
            $name=$get_r['serial_no'];
            return $name;
        } 
    }
    function serial_no_student($company){
        $UserModel = new Main_item_party_table;
        $UserModel->selectMax('serial_no');
        $UserModel->where('company_id',$company)->where('deleted',0)->where('u_type','student');
        $get_serial=$UserModel->first();
        return $get_serial['serial_no']+1;
    }

function date_ulta($date){
        $datedata=explode('-', $date);
        return $datedata[2].'-'.$datedata[1].'-'.$datedata[0];
    }


function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

function age_of_student($date_of_birth,$currentDate){
    $myid=session()->get('id');
    if (!strtotime($date_of_birth)) {
        $age = date_diff(date_create(now_time($myid)), date_create($currentDate));
    }else{
        $age = date_diff(date_create($date_of_birth), date_create($currentDate));
    }
    return $age->format("%y");
}

function get_vehicle_data($sub_id,$column){
    $VehicleModel = new VehicleModel();
    $bcarry=$VehicleModel->where('id', $sub_id)->first();
    if ($bcarry) {
        return $bcarry[$column];
    }else{
        return 0;
    }
    
}

function no_of_challans($fees_id,$myid){ 
    $InvoiceModel=new InvoiceModel;
    $all_invoices=$InvoiceModel->where('company_id',company($myid))->where('invoice_type','challan')->where('deleted',0)->where('fees_id',$fees_id)->orderBy('id','DESC')->countAllResults();
    return $all_invoices;
}

function total_paid_amount_students($company_id,$fees_id){
        $InvoiceModel = new InvoiceModel();
        $paidarry=$InvoiceModel->where('company_id',$company_id)->where('invoice_type','challan')->where('deleted',0)->where('fees_id',$fees_id)->where('paid_status','paid')->orderBy('id','DESC')->findAll();

        return count($paidarry);
    }

    function total_half_paid_amount_students($company_id,$fees_id){
        $InvoiceModel = new InvoiceModel();
        $nof=0;
        $paidarry=$InvoiceModel->where('company_id',$company_id)->where('invoice_type','challan')->where('deleted',0)->where('fees_id',$fees_id)->where('paid_status!=','paid')->orderBy('id','DESC')->findAll();
        foreach ($paidarry as $in) {
            if ($in['due_amount']>0 && $in['due_amount']<$in['total']) {
                $nof++;
            }
        }
        return $nof;
    }

    function total_unpaid_amount_students($company_id,$fees_id){
        $InvoiceModel = new InvoiceModel();
        $nof=0;
        $paidarry=$InvoiceModel->where('company_id',$company_id)->where('invoice_type','challan')->where('deleted',0)->where('fees_id',$fees_id)->where('paid_status!=','paid')->orderBy('id','DESC')->findAll();
        foreach ($paidarry as $in) {
            if ($in['due_amount']>=$in['total']) {
                $nof++;
            }
        } 

        return $nof;
    }

      function is_have_item($fees_id,$itm_id){
        $FeesitemsModal = new FeesitemsModal();
        $pro_data= $FeesitemsModal->where('fees_id',$fees_id)->where('product_id',$itm_id)->first();
        if ($pro_data) {
           return 1;
        }else{
            return 0;
        }

    }

// new school


 
function get_student_data($company_id,$student_id,$column){
    $UserModel = new Main_item_party_table();
    $usaerdata= $UserModel->where('id',$student_id)->where('company_id',$company_id)->first();
    if ($usaerdata) {
       return $usaerdata[$column];
    }else{
        return '';
    }
}
  
 function total_days_of_attendance($classid,$student_id,$company_id){
    $AttendanceModel = new AttendanceModel;

    $totaldays=$AttendanceModel->distinct('date')->select('date')->where('class_id',$classid)->where('student_id',$student_id)->where('company_id',$company_id)->findAll();
    return count($totaldays);        
}

function total_days_of_attended($classid,$student_id,$company_id){
    $AttendanceModel = new AttendanceModel;
    $totalattenddays=0;
     $attedarr=$AttendanceModel->distinct('date')->where('class_id',$classid)->where('student_id',$student_id)->where('company_id',$company_id)->findAll();
     foreach ($attedarr as $td) {
         if ($td['attendance']==1 && $td['attendance2']==1) {
             $totalattenddays+=1;
         }elseif ($td['attendance']==1 && $td['attendance2']==0){
            $totalattenddays+=0.5;
         }elseif ($td['attendance']==0 && $td['attendance2']==1){
            $totalattenddays+=0.5;
         }else{
            $totalattenddays+=0;
         }
     }
    return $totalattenddays;        
}


function percentage_of_attended($classid,$student_id,$company_id){
    $atpercent=0;
    $days_of_attendance=total_days_of_attendance($classid,$student_id,$company_id);
    $days_of_attended=total_days_of_attended($classid,$student_id,$company_id);
    if ($days_of_attended!=0 && $days_of_attendance!=0) {
        $atpercent=$days_of_attended/$days_of_attendance*100;
    }
    return aitsun_round($atpercent);
}


function feeses_array_of_class_for_fee_report($company,$class,$added_by,$group){
        $FeesModel= new FeesModel();
        
        if ($added_by!='') {
            $FeesModel->where('added_by',$added_by);
        }
        if ($group!='') {
            $FeesModel->where('id',$group);
        }

         
        $username=$FeesModel->where('company_id',$company)->where('academic_year',academic_year($company))->where('deleted',0);
        

        $get_res= $username->findAll();
        return $get_res;
    }

    function fees_invoice_data_of_student($company,$fees,$student,$column){
        $InvoiceModel = new InvoiceModel;
        $un=$InvoiceModel->where('company_id',$company)->where('fees_id',$fees)->where('customer',$student)->where('deleted',0)->first();
        if ($un) {
            return $un[$column];
        }else{
            return 0;
        }
        
    }



function count_articles($company_id){
        $MagazineModel = new MagazineModel();
        $subarray=$MagazineModel->where('company_id', $company_id)->where('deleted',0)->findAll();
        return count($subarray);
    }

function exam_cate_array($exam_catid){
        $Examcategorymodel = new Examcategorymodel;
        $starray=$Examcategorymodel->where('company_id', $exam_catid)->where('deleted',0)->findAll();
        return $starray;
    }


function exam_cate_name($exc_id){
        $Examcategorymodel = new Examcategorymodel;
        $orname=$Examcategorymodel->where('id', $exc_id)->first();
        $name=$orname['exam_category'];
        return $name;
    }



function get_main_exam_data($exam_id,$column){
        $MainexamModel = new MainexamModel();
        $mainexam_data= $MainexamModel->where('id',$exam_id)->first();
        if ($mainexam_data) {
           return $mainexam_data[$column];
        }else{
            return '';
        }
    }


function get_exam_time_table_array($cmpid,$class_id,$mainex){
        $ExamModel= new ExamModel();
        $starray=$ExamModel->where('company_id', $cmpid)->where('exam_for_class',$class_id)->where('exam_type','normal')->where('main_exam_id', $mainex)->where('deleted',0)->orderBy('date','ASC')->findAll();
        return $starray;
    }

function is_all_subject_valuated($company_id,$mainexmid,$classid){
        $MainexamModel = new MainexamModel;
        $valuatedstatus=true;
        if (count(exams_of_main_exam($company_id,$mainexmid,$classid))>0) {
            foreach (exams_of_main_exam($company_id,$mainexmid,$classid) as $emex){
                if ($emex['marksvaluate']==0) {
                    $valuatedstatus=false;
                }
            }
        }else{
            $valuatedstatus=false;
        }
        
        return $valuatedstatus;
    }


function exams_of_main_exam($company,$main_exam_id,$classid){
        $ExamModel = new ExamModel;
        $examss=$ExamModel->where('company_id',$company)->where('main_exam_id',$main_exam_id)->where('exam_for_class',$classid)->where('deleted',0)->findAll();
        return $examss;        
    }


function user_gender($id){
        $UserModel = new Main_item_party_table;
        $fn='';
        if (trim($id)!=0) {
            $user=$UserModel->where('id', $id)->first();
            if ($user) {
                $fn=$user['gender'];
            } 
        }
        return $fn;
    }


 function get_marks_valuation_array($company_id,$exam_id,$student_id,$subject_id){
        $MarksModel = new MarksModel();
        $MarksModel->where('company_id',$company_id);
        $MarksModel->where('academic_year',academic_year(session()->get('id')));
        $MarksModel->where('exam_id',$exam_id);
        $MarksModel->where('student_id',$student_id);
        $MarksModel->where('subject_id',$subject_id);
        $marks=$MarksModel->first();
        if ($marks) {
            return $marks['marks'];
        }else{
            return 0;
        }
    }


function sub_exam_absent($company_id,$exam_id,$student_id,$subject_id){
        $MarksModel = new MarksModel();
        $MarksModel->where('company_id',$company_id);
        $MarksModel->where('academic_year',academic_year(session()->get('id')));
        $MarksModel->where('exam_id',$exam_id);
        $MarksModel->where('student_id',$student_id);
        $MarksModel->where('subject_id',$subject_id);
        $marks=$MarksModel->first();

            if ($marks) {
                if ($marks['status']==1) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

    }


function isavaluated($company_id,$exam_id){
        $ExamModel = new ExamModel();
        $ExamModel->where('company_id',$company_id);
        $ExamModel->where('academic_year',academic_year(session()->get('id')));
        $ExamModel->where('id',$exam_id);
        $marks=$ExamModel->first();

            if ($marks) {
                if ($marks['marksvaluate']==1) {
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }

    }



      function aggregate_marks($company,$user_id,$exam_id,$exam_for_subject){
        $MarksModel = new MarksModel;
        $mark=$MarksModel->where('company_id',$company)->where('student_id',$user_id)->where('exam_id',$exam_id)->where('subject_id',$exam_for_subject)->where('deleted',0)->first();
        if ($mark) {
            if ($mark['exam_mark_type']=='grade') {
                 return $mark['grade'];
            }
            else{
                return $mark['marks'];
            }
           
        }else{
            return 'N/A';
        }
    }

 function percentage_to_grade($percentage){
        $grade='';

        if ($percentage>=60) {
            $grade='A';
        }elseif ($percentage>=50 AND $percentage<60) {
            $grade='B';
        }elseif ($percentage>=30 AND $percentage<50) {
            $grade='C';
        }else{
            $grade='D';
        }

        return $grade;

    }


    function percent_of_numbers($number,$number2){
        if (is_numeric($number) && is_numeric($number2)) {
            if (!empty($number) && !empty($number2)) {
                return aitsun_round($number/$number2*100);
            }else{
                return '';
            }
        }else{
            return '';
        }
        
    }

      function subjects_code($sub_id){
        $SubModel = new SubjectModel;
        
        $subarray=$SubModel->where('id', $sub_id)->where('deleted',0)->first();
        if ($subarray) {
            $subname=$subarray['subject_code'];
            return $subname;
        }else{
            return '';
        }
        
    }

    function current_class_of_student_for_progress_card($company_id,$student_id){
        $Classtablemodel = new Classtablemodel;
        $classtabledata=$Classtablemodel->where('student_id',$student_id)->first();
        if ($classtabledata) {
            return $classtabledata['class_id'];
        }else{
            return 0;
        }
        
    }

    function exams_of_main_exam_of_progreecard($company,$main_exam_id,$classid){
        $ExamModel = new ExamModel;
        $examss=$ExamModel->where('company_id',$company)->where('main_exam_id',$main_exam_id)->where('exam_for_class',$classid)->where('deleted',0)->findAll();
        return $examss;        
    }
    function value_of_grade($grade,$company){ 
        $rest=grades_array($company);
        $aaa=array_search($grade, array_column($rest, 'grade')); 
        return $rest[$aaa]['value'];  
    }

 function grades_array($company){
    $grades=[
        [
            'grade'=>'A+',
            'value'=>'5.5'
        ],
        [
            'grade'=>'A',
            'value'=>'5'
        ],
        [
            'grade'=>'B+',
            'value'=>'4.5'
        ],
        [
            'grade'=>'B',
            'value'=>'4'
        ],
        [
            'grade'=>'C+',
            'value'=>'3.5'
        ],
        [
            'grade'=>'C',
            'value'=>'3'
        ],
        [
            'grade'=>'D+',
            'value'=>'2.5'
        ],
        [
            'grade'=>'D',
            'value'=>'2'
        ],
        
        [
            'grade'=>'E+',
            'value'=>'1.5'
        ],
        [
            'grade'=>'E',
            'value'=>'1'
        ],
        [
            'grade'=>'F',
            'value'=>'0'
        ]
    ];
    return $grades;
}
    function total_participant_students($company_id,$event,$type){
        $RewardingModel = new RewardingModel();
        $stparray=$RewardingModel->where('company_id', $company_id)->where('academic_year', academic_year(session()->get('id')))->where('deleted',0)->where('event_id',$event)->where('type',$type)->findAll();
        return count($stparray);
    }
    function event_reward_students($company_id,$event,$type){
        $RewardingModel = new RewardingModel();
        $stparray=$RewardingModel->where('company_id', $company_id)->where('academic_year', academic_year(session()->get('id')))->where('deleted',0)->where('event_id',$event)->where('type',$type)->where('reward!=','')->where('reward!=','not participated')->where('reward!=','participated')->findAll();

        return $stparray;


    }







   
