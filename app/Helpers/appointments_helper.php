<?php 
	use App\Models\AppointmentsModel as AppointmentsModel;
	use App\Models\ResourcesModel as ResourcesModel;


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
		$resource_data=new resource_data;
		$app_array=$resource_data->where('id',$resid)->first();
		if ($app_array) {
			return $app_array[$column];
		}else{
			return '';
		}
	}
	

	function isValidDate($date, $format = 'Y-m-d') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) === $date;
	}

 ?>