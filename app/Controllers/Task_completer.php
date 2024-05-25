<?php namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\OrganisationModel;
use App\Models\ExportexcelModel;

class Task_completer extends BaseController
{
    public function index()
    {
    	// $ExportexcelModel = new ExportexcelModel;
        // $myid = session()->get('id');

        // $status = $ExportexcelModel->where('status', 'ready')->first();

        // if ($status) {
        //     $filePath = rtrim($status['file_path']). ltrim($status['file_name']);
		//         $response = [
		//             'status' => 'ready',
		//             'file_path' => $filePath,
		//         ];
        // } else {
        //     $response = [
        //         'status' => 'pending',
        //     ];
        // }

        // return $this->response->setJSON($response);
    }

     public function markascomplete()
    {
        
        // $ExportexcelModel = new ExportexcelModel;
        // $ExportexcelModel->set(['status' => 'complete'])->where('status', 'ready')->update();

        // return $this->response->setJSON(['status' => 'success']);
    }
}