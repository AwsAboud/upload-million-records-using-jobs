<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function index(){
        return view('upload-file');
    }

    public function upload(Request $request){
        $request->validate([
            'csvFileUpload' => 'required|file|mimes:csv|max:10240', // Maximum size is 10MB
        ]);
        $data = file(request()->csvFileUpload);
        $header = $data[0];
        //Chunking file
        $chunks = array_chunk($data, 1000);

        //Convert each 1000 records into a new csv file
        foreach($chunks as $key => $chunk ){
            $chunkFileName = "temp{$key}.csv";
            $path = public_path("temp");
            file_put_contents($path.'/'.$chunkFileName, $chunk);
        }
       return 'Done';
    }
    public function store(){
        $path = public_path("temp");
        $files = glob("$path/*.csv");
        // Initialize an empty array to store the column names for the Sale table
        $header = [];
        // Iterate through each CSV file
        foreach($files as $key => $file){
            // Read the CSV file and parse its contents into an array of arrays
            $data = array_map('str_getcsv', file($file));
            if($key == 0){
                //store the column names for the Sale table
                $header = array_shift($data);
            }
            // Iterate through each row of the sales data and store it in the database
            foreach($data as $sale){
                $saleData = array_combine($header, $sale);
                Sale::create($saleData);
            }
            unlink($file);
        }

        return response()->json(['message' => 'Upload successful'], 200);
     }

}
