<?php
namespace App\Controllers;
use App\Models\Main_item_party_table;
use App\Models\ProductsModel;

require 'vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

 

class Large_process extends BaseController
{
     public function index()
    {

        // Function to fetch and process data in chunks
		function processAndStreamData($start, $chunkSize) {
		    // Fetch data from the database based on the start and chunk size
		    // Process the data and return as an array
		    // Adjust this based on your data retrieval and processing logic
		    // ...

		    return $processedData;
		}

		// Set appropriate headers
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="large_data.xlsx"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		// Create a new Spreadsheet object
		$spreadsheet = new Spreadsheet();

		// Get the active sheet
		$sheet = $spreadsheet->getActiveSheet();

		// Chunk size for processing and streaming
		$chunkSize = 100; // Adjust as needed

		// Loop through chunks and add data to the spreadsheet
		for ($start = 0; $start < $totalRowCount; $start += $chunkSize) {
		    $chunk = processAndStreamData($start, $chunkSize);

		    // Add data to the spreadsheet
		    foreach ($chunk as $row) {
		        $sheet->fromArray([$row], null, 'A' . ($sheet->getHighestRow() + 1));
		    }

		    // Clear the memory
		    unset($chunk);
		}

		// Create a new Xlsx Writer and save the spreadsheet to php://output
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
    }
}




