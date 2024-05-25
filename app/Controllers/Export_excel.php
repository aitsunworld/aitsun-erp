<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\ExportexcelModel;

class Export_excel extends BaseController
{
	public function index()
	{
		 if ($this->request->getMethod() == 'post') {
            
            $ExportexcelModel = new ExportexcelModel();
            $myid=session()->get('id');

            $newData = [
                'company_id' => company($myid),
                'task_name'=> 'Down',
				'table_name'=> 'Stcok',
				'from'=>now_time($myid),
				'to'=> now_time($myid),
				'formate'=> 'execel',
				'file_path'=> 'public/uploads/crone_files/',
				'status'=> 'pending',

            ];

            $ExportexcelModel->save($newData);
            echo 1;

        }	
	}

	
}