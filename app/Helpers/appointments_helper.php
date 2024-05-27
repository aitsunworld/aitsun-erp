<?php 
	use App\Models\AppointmentsModel as AppointmentsModel;

	function appointments_array($company_id){
		$AppointmentsModel=new AppointmentsModel;
		$app_array=$AppointmentsModel->where('company_id',$company_id)->where('deleted',0)->orderBy('id','desc')->findAll();
		return $app_array;
	}

	function isValidDate($date, $format = 'Y-m-d') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) === $date;
	}

 ?>