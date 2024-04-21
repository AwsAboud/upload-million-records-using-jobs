<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Jobs\SalesCsvProcess;
use Illuminate\Http\Response;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function index(){
        return view('upload-file');
    }

    public function store(StoreRequest $request){

        $data = file($request->csvFileUpload);
        $chunks = array_chunk($data, 1000);
        $header = [];
        foreach($chunks as $key => $chunk){
            // Read the CSV file and parse its contents into an array of arrays
            $data = array_map('str_getcsv', $chunk);
            if($key == 0){
                //store the column names for the Sales table
                $header = array_shift($data);
            }
            SalesCsvProcess::dispatch($data, $header);
        }

        return response()->json(['message' => 'Upload successful'], 200);
     }

}
