<?php 
	use App\Models\AppointmentsModel as AppointmentsModel;
	use App\Models\ResourcesModel as ResourcesModel;
	use App\Models\AppointmentsTimings as AppointmentsTimings;


	function appointments_array($company_id){
		$AppointmentsModel=new AppointmentsModel;
		$app_array=$AppointmentsModel->where('company_id',$company_id)->where('deleted',0)->orderBy('id','desc')->findAll();
		return $app_array;
	}

	function appointments_data($appid,$column){
		$AppointmentsModel=new AppointmentsModel;
		$app_array=$AppointmentsModel->where('id',$appid)->first();
		if ($app_array) {
			return $app_array[$column];
		}else{
			return '';
		}
	}

	function resource_data($resid,$column){
		$ResourcesModel=new ResourcesModel;
		$app_array=$ResourcesModel->where('id',$resid)->first();
		if ($app_array) {
			return $app_array[$column];
		}else{
			return '';
		}
	}

	function resource_pic($id){
	    $ResourcesModel = new ResourcesModel;
	    $resource_pic=$ResourcesModel->where('id', $id)->first();
	    if (trim($resource_pic['image'])!='') {
	        return base_url('public').'/images/resources/'.$resource_pic['image']; 
	    }else{
	        return base_url('public').'/images/avatars/avatar-icon.png'; 
	    }
	}
	function appointment_timings_array($appoint_id){
	    $AppointmentsTimings = new AppointmentsTimings;
	    $pc=$AppointmentsTimings->where('appointment_id', $appoint_id);
	    return $pc->findAll();
	}

	function isValidDate($date, $format = 'Y-m-d') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) === $date;
	}


 ?>