<?php 
	use App\Models\PushedAttendanceOfEmployee as PushedAttendanceOfEmployee;
	use App\Models\AttendanceEventModel as AttendanceEventModel;
	use App\Models\EmployeeCategoriesModel as EmployeeCategoriesModel; 
	use App\Models\AttendanceModel as AttendanceModel; 




	function get_full_present_of_employee($date,$emp_id){
		$PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee;
		$att_res=0;

		$att_res=$PushedAttendanceOfEmployee->where('MONTH(date)',get_date_format($date,'m'))->where('YEAR(date)',get_date_format($date,'Y'))->where('employee_id',$emp_id)->where('day_status',2)->where('deleted',0)->countAllResults();

		return $att_res;
	}

	function get_half_present_of_employee($date,$emp_id){
		$PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee;
		$att_res=0;

		$att_res=$PushedAttendanceOfEmployee->where('MONTH(date)',get_date_format($date,'m'))->where('YEAR(date)',get_date_format($date,'Y'))->where('employee_id',$emp_id)->where('day_status',1)->where('deleted',0)->countAllResults();

		return $att_res;
	}


	function get_on_time_of_employee($date,$emp_id){
		$PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee;
		$att_res=0;

		$att_res=$PushedAttendanceOfEmployee->where('MONTH(date)',get_date_format($date,'m'))->where('YEAR(date)',get_date_format($date,'Y'))->where('employee_id',$emp_id)->where('late_come<=',0)->where('deleted',0)->countAllResults();

		return $att_res;
	}

	function get_late_of_employee($date,$emp_id){
		$PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee;
		$att_res=0;

		$att_res=$PushedAttendanceOfEmployee->where('MONTH(date)',get_date_format($date,'m'))->where('YEAR(date)',get_date_format($date,'Y'))->where('employee_id',$emp_id)->where('late_come>',0)->where('deleted',0)->countAllResults();

		return $att_res;
	}

	function get_overtime_of_employee($date,$emp_id){
		$PushedAttendanceOfEmployee=new PushedAttendanceOfEmployee;
		$att_res=0;

		$att_res=$PushedAttendanceOfEmployee->where('MONTH(date)',get_date_format($date,'m'))->where('YEAR(date)',get_date_format($date,'Y'))->where('employee_id',$emp_id)->where('overtime_hours>',0)->where('deleted',0)->countAllResults();

		return $att_res;
	}


	 
	function get_total_leaves_of_employee($company_id,$attend_date,$emp_id){
		$get_total_days_of_month=get_total_days_of_month($company_id,$attend_date,$emp_id,get_cust_data($emp_id,'employee_category'));
        $get_full_present_of_employee=get_full_present_of_employee($attend_date,$emp_id);
        $get_half_present_of_employee=get_half_present_of_employee($attend_date,$emp_id);
        $get_on_time_of_employee=get_on_time_of_employee($attend_date,$emp_id);
        $get_late_of_employee=get_late_of_employee($attend_date,$emp_id);
        $get_overtime_of_employee =get_overtime_of_employee($attend_date,$emp_id);

        $total_leaves=$get_total_days_of_month-($get_full_present_of_employee+($get_half_present_of_employee/2));
        return $total_leaves;
	}

	function get_total_days_of_month($company_id,$date,$emp_id,$emp_category){

		$AttendanceEventModel=new AttendanceEventModel;
		$EmployeeCategoriesModel=new EmployeeCategoriesModel;

		$total_days=0;
		$total_week_offs=0;
		$total_events_affects_to_weekoff=0;

		$year = get_date_format($date,'Y');
		$month = get_date_format($date,'m'); // August

		$yda=get_date_format($date,'Y-m');
		$nda=get_date_format(now_time_of_company($company_id),'Y-m');

		if ($yda==$nda) {
			$startDate = new DateTime($nda.'-01');
			$endDate = new DateTime(get_date_format(now_time_of_company($company_id),'Y-m-d'));

			$from_startDate=$nda.'-01';
			$from_endDate=get_date_format(now_time_of_company($company_id),'Y-m-d');

			$interval = $startDate->diff($endDate); 
			$totalmonthdays=$interval->days;

			//// get events week off
		$total_events_affects_to_weekoff=$AttendanceEventModel->where('company_id',$company_id)->where('deleted',0)->where('effect_to','week_off')->where("event_date BETWEEN '$from_startDate' AND '$from_endDate'")->countAllResults();

		 
		}else{
			$totalmonthdays=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			//// get events week off
			$total_events_affects_to_weekoff=$AttendanceEventModel->where('company_id',$company_id)->where('deleted',0)->where('effect_to','week_off')->where('MONTH(event_date)',get_date_format($date,'m'))->where('YEAR(event_date)',get_date_format($date,'Y'))->countAllResults();
		}

		

		$total_days =$total_days+$totalmonthdays;

		


		//// get week off's
		$sunday='';
		$monday='';
		$tuesday='';
		$wednesday='';
		$thursday='';
		$friday='';
		$saturday='';

		$get_sunday=0;
		$get_monday=0;
		$get_tuesday=0;
		$get_wednesday=0;
		$get_thursday=0;
		$get_friday=0;
		$get_saturday=0;

		$ep_cat=$EmployeeCategoriesModel->where('id',$emp_category)->where('deleted',0)->first();
		if ($ep_cat) { 
			$sunday=$ep_cat['sunday'];
			$monday=$ep_cat['monday'];
			$tuesday=$ep_cat['tuesday'];
			$wednesday=$ep_cat['wednesday'];
			$thursday=$ep_cat['thursday'];
			$friday=$ep_cat['friday'];
			$saturday=$ep_cat['saturday'];
		}

		$yearr=get_date_format($date,'Y');
		$mont=get_date_format($date,'m');
		 
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Sun',$sunday);
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Mon',$monday);
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Tue',$tuesday);
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Wed',$wednesday);
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Thu',$thursday);
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Fri',$friday);
		$total_week_offs+=getAllWeekOffsOfMonth($company_id,$yearr,$mont,'Sat',$saturday);

		return $total_days-($total_week_offs+$total_events_affects_to_weekoff);
	}



	function getAllWeekOffsOfMonth($company_id,$year,$month,$week_name,$type) {
	    $sundays = array();

	    $is_this_current_month=false;
	    
	    if ($year==get_date_format(now_time_of_company($company_id),'Y') && $month==get_date_format(now_time_of_company($company_id),'m')) {
	    	$is_this_current_month=true;
	    }


	    // Get the first and last day of the month
	    $firstDay = new DateTime(''.$year.'-'.$month.'-01');
	    $lastDay = new DateTime("$year-$month-" . $firstDay->format('t'));

	    // Loop through the days of the month
	    $currentDay = $firstDay;
	    while ($currentDay <= $lastDay) {
	        if ($currentDay->format('D') === $week_name) {
	            $sundays[] = $currentDay->format('Y-m-d');
	        }
	        $currentDay->modify('+1 day');
	    }
	    


	    $tdays=0;
	    if ($is_this_current_month) {
	    	$no = 0;
	    	$today_date=get_date_format(now_time_of_company($company_id),'d');
			$start = new DateTime(''.$year.'-'.$month.'-01');
			$end   = new DateTime(''.$year.'-'.$month.'-'.$today_date);
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($start, $interval, $end);


			if (!empty($type)) {
		    	if ($type!='all') {

		    		$ex_type=explode(',', $type);
		    		$no_week=0;

			    	foreach ($period as $dt)
					{
					    if ($dt->format('D') == $week_name)
					    {
					    	$no_week++;

					    	$wexist = array_count_values($ex_type)[$no_week] ?? 0;
					    	if ($wexist==1) {
					    		$no++;
					    	}
					        
					    }
					}


			    }else{
			    	foreach ($period as $dt)
					{
					    if ($dt->format('D') == $week_name)
					    {
					        $no++;
					    }
					}
			    }
		    }

			
			 

		    $tdays+=$no;
		    
	    }else{
	    	if (!empty($type)) {
		    	if ($type!='all') {
			    	$explll=explode(',', $type);
			    	$tdays+=count($explll);
			    }else{
			    	$tdays=count($sundays);
			    }
		    }
	    }
	    
	    
	    return $tdays;
	}

	function get_user_attendance_data_by_date($employee_id,$dates,$column){
	    $PushedAttendanceOfEmployee = new PushedAttendanceOfEmployee();
	    $attddata= $PushedAttendanceOfEmployee->where('DATE(date)',$dates)->where('employee_id',$employee_id)->first();
	    if ($attddata) {
	    	return $attddata[$column];
	    }else{
	    	return '-';
	    }
	}

	function get_user_leave_by_year($company_id,$employee_id,$attend_date,$employee_category){
	    $get_total_days_of_month=get_total_days_of_month($company_id,$attend_date,$employee_id,$employee_category);
        $get_full_present_of_employee=get_full_present_of_employee($attend_date,$employee_id);
        $get_half_present_of_employee=get_half_present_of_employee($attend_date,$employee_id);
        $get_on_time_of_employee=get_on_time_of_employee($attend_date,$employee_id);
        $get_late_of_employee=get_late_of_employee($attend_date,$employee_id);
        $get_overtime_of_employee =get_overtime_of_employee($attend_date,$employee_id);

        $total_leaves=$get_total_days_of_month-($get_full_present_of_employee+($get_half_present_of_employee/2));
	    return $total_leaves;
	}

	function get_user_leave_by_month_status($company_id,$employee_id,$attend_date,$employee_category){
	    $get_total_days_of_month=get_total_days_of_month($company_id,$attend_date,$employee_id,$employee_category);
	    $get_full_present_of_employee=get_full_present_of_employee($attend_date,$employee_id);
	    $get_half_present_of_employee=get_half_present_of_employee($attend_date,$employee_id);
	    $get_on_time_of_employee=get_on_time_of_employee($attend_date,$employee_id);
	    $get_late_of_employee=get_late_of_employee($attend_date,$employee_id);
	    $get_overtime_of_employee =get_overtime_of_employee($attend_date,$employee_id);

	    $total_leaves=$get_total_days_of_month-($get_full_present_of_employee+($get_half_present_of_employee/2));

	     $today_date=get_date_format(now_time_of_company($company_id),'Y-m');
	     $fildate=get_date_format($attend_date,'Y-m');
	    if ($fildate<$today_date) {
	    	return $total_leaves;
	    }else{
	    	return 'up_month';
	    }
	    
	}

	function get_user_attendance_note_by_month($employee_id,$dates){
	    $AttendanceModel = new AttendanceModel();
	    $atnote='';
	    $attddata= $AttendanceModel->where('MONTH(punched_time)',get_date_format($dates,'m'))->where('YEAR(punched_time)',get_date_format($dates,'Y'))->where('employee_id',$employee_id)->findAll();
	    $last=end($attddata);
	    foreach ($attddata as $atd) {
	        if (!empty(trim($atd['note']))) {
	            $comma=', ';
	            if ($last==$atd) {
	                $comma='';
	            }
	            $atnote.=$atd['note'].$comma;
	        }
	        
	    }
	    return $atnote;
	    
	}
	
 ?>