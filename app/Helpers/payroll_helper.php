<?php
    use App\Models\UserModel as UserModel;
    use App\Models\AttendanceModel as AttendanceModel;
    use App\Models\SalaryTable as SalaryTable;
    use App\Models\PayrollfieldsModel as PayrollfieldsModel;
    use App\Models\SalarySlipItemsModel as SalarySlipItemsModel;
    use App\Models\PayrollitemsModel as PayrollitemsModel;

function formula_assigned_value($formula,$basic_salary){
    if ($formula) {
        // code...
    }
}

function decimal_to_time($num){
    
     $tm=explode('.', $num);
     $hr=$tm[0];
     if (isset($tm[1])) {
         $min=$tm[1];
     }else{
        $min=0;
     }
     
     $minutes = $min+($hr*60);

    
        $hours = floor($minutes / 60); // Extract the whole number of hours
        $remainingMinutes = $minutes % 60; // Calculate the remaining minutes

        // echo "Hours: " . $hours . "<br>";
        // echo "Minutes: " . $remainingMinutes;
    $new_hourrrr='';
    $new_minnnnn='';

    if ($hours>0) {
        if ($hours>1) {
            $new_hourrrr=$hours.' hrs ';
        }else{
            $new_hourrrr=$hours.' hr ';
        }
        
    }

    if ($remainingMinutes>0) { 
        if ($remainingMinutes>1) {
            $new_minnnnn=$remainingMinutes.' mins';
        }else{
            $new_minnnnn=$remainingMinutes.' min';
        }
    }

    return $new_hourrrr.''.$new_minnnnn;
}


function payroll_fields_array($company_id){
    $PayrollfieldsModel = new PayrollfieldsModel();
    $prf_data=$PayrollfieldsModel->where('company_id',$company_id)->where('deleted',0)->orderBy('orderby','ASC')->findAll();
    return $prf_data; 
}


function basic_salary_employee($employee_id,$month,$company){
    $SalaryTable= new SalaryTable;
    $get_value=$SalaryTable->where('company_id',$company)->where('employee_id',$employee_id)->where('MONTH(month)',get_date_format($month,'m'))->where('YEAR(month)',get_date_format($month,'Y'))->where('deleted',0)->first();
    if ($get_value) {
        return $get_value['basic_salary'];
    }else{
        return 0;
    }
} 


function salary_items_array_by_payrollid($payroll_id,$company_id){
    $PayrollitemsModel = new PayrollitemsModel();
    $SalarySlipItemsModel = new SalarySlipItemsModel();
    $prf_data=$PayrollitemsModel->where('payroll_id',$payroll_id)->first();

    $slr_data=$SalarySlipItemsModel->where('payroll_items_id',$prf_data['id'])->findAll();
     
    return $slr_data; 
}

function salary_items_array_by_payrollid_with_employee_id($payroll_id,$employee_id,$company_id){
    $PayrollitemsModel = new PayrollitemsModel();
    $SalarySlipItemsModel = new SalarySlipItemsModel();
    $prf_data=$PayrollitemsModel->where('payroll_id',$payroll_id)->where('employee_id',$employee_id)->first();

    $slr_data=$SalarySlipItemsModel->where('payroll_items_id',$prf_data['id'])->findAll();
     
    return $slr_data; 
}

function salary_items_array($payroll_items_id){ 
    $SalarySlipItemsModel = new SalarySlipItemsModel();  
    $slr_data=$SalarySlipItemsModel->where('payroll_items_id',$payroll_items_id)->findAll(); 
    return $slr_data; 
}



function get_payroll_field_data($id,$column){
    $PayrollfieldsModel = new PayrollfieldsModel(); 
    $prf_data=$PayrollfieldsModel->where('id',$id)->first();
    if ($prf_data) {
        return $prf_data[$column]; 
    }
    
}



function get_payroll_data($id,$column){
    $PayrollfieldsModel = new PayrollfieldsModel(); 
    $prf_data=$PayrollfieldsModel->where('id',$id)->first();
    if ($prf_data) {
        return $prf_data[$column]; 
    } 
}


function get_count_month_attandance_status($employee_id,$dates,$status){
    $AttendanceModel = new AttendanceModel();
    $atnote='';
    $attddata= $AttendanceModel->where('MONTH(date)',get_date_format($dates,'m'))->where('YEAR(date)',get_date_format($dates,'Y'))->where('employee_id',$employee_id)->where('attendance',$status)->findAll();

    if (get_date_format($dates,'Y-m')<=get_date_format(now_time($employee_id),'Y-m')) {
        if ($attddata) {
            if (count($attddata)>1) {
                return count($attddata);
            }else{
                return count($attddata);
            }
            
        }else{
            return '';
        }
    }else{
        return '';
    } 
   
}


function get_count_leave_by_month_status($employee_id,$dates){
    $AttendanceModel = new AttendanceModel();
    $atnote='';
    $attddata= $AttendanceModel->where('MONTH(date)',get_date_format($dates,'m'))->where('YEAR(date)',get_date_format($dates,'Y'))->where('employee_id',$employee_id)->where('attendance','Absent')->findAll();

    $attddatahalf= $AttendanceModel->where('MONTH(date)',get_date_format($dates,'m'))->where('YEAR(date)',get_date_format($dates,'Y'))->where('employee_id',$employee_id)->where('attendance','H.D')->findAll();

    $attddatahalfdevided=count($attddatahalf)/2;
    $total_leaves=count($attddata)+$attddatahalfdevided;

    if (get_date_format($dates,'Y-m')<=get_date_format(now_time($employee_id),'Y-m')) {
        if ($attddata || $attddatahalf) {
            if ($total_leaves>1) {
                return $total_leaves;
            }else{
                return $total_leaves;
            }
        }else{
            return 0;
        }
    }else{
        return 0;
    } 
   
}


function one_day_salary_of_employee($uid,$salary,$month){
    $daysofmonth=0;
    $monttdate=get_date_format(now_time($uid),'Y').'-'.$month.'-1';
    $attend_date=get_date_format($monttdate,'Y-F'); 
    $at_date=$attend_date;

     foreach (get_dates_of_month_array($at_date,'day_number') as $dt){ 
            $daysofmonth+=1;               
        if (get_date_format(timetest($at_date),'d')==$dt){
            break;
        } 
      } 

    if($daysofmonth>0){
       return aitsun_round($salary/$daysofmonth); 
   }else{
    return 0;
   }
    

}