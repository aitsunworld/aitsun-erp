<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\NotificationsModel;



class Redirect_notify extends BaseController
{
	public function index()
	{
		    $NotificationsModel=new NotificationsModel;

	    	$idata =[
	    		'nread' => 1,
	    	];
			$read=$NotificationsModel->update($_GET['nid'],$idata);
			if ($read) {
				return redirect()->to($_GET['nurl']);
			}else{
				return redirect()->to(base_url());
			}


	}
}