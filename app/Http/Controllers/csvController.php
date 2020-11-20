<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class csvController extends Controller
{
    public function csvFileDuplicates(Request $request)
    {
     //check if a csv file was passed
    $validator =  Validator::make($request->all(),[
    'file' => 'required|mimes:csv,txt',
    ]);

    // if no csv file passed, return below error message
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "message" => $validator->errors(),
        ], 422);
    }

	$open_file = @fopen($request->file('file')->getRealPath(), "r");//open file
	if ($open_file) {
		 $content = $this->add_headers_to_rows($open_file);
   }else{
   	   return response()->json("error", 500);
   }

//group rows by age
    $group_by_age = collect($content[0])->groupBy('age');

//merge same age rows into one and build repsonce to user
 foreach($group_by_age as $index=>$opt){

 	$i = 0;//used to count rows, 1 = not a dup, > 1 = dup

     foreach($opt as $key => $value)
     {
     	$i++;

     	//if greater than one it means that they are dups
     	if($i > 1){
      		$optvar[$index]['age'] = $index;
      		$optvar[$index]['dups'] = $i;
      		$optvar[$index]['precentage'] = ($i / $content[1]) * 100 ;
     }
   }
 }
 		//get rid of index in json response
 		$re_index = array_values($optvar);

 		//return json response
     return response()->json($re_index, 201);
    }

 public function add_headers_to_rows($open_file){
    	$count_rows = -1;
		
		$count = 0;
 		while (($row = fgetcsv($open_file, 4096)) !== false) {
    		$count_rows++;

        	if (empty($fields)) {
            	$fields = $row;
           		continue;
        	}

        	// add headers to each row of data with values
        	foreach ($row as $k=>$value) {
            	$array[$count][$fields[$k]] = $value;
        	}
        	$count++;
    }

    if (!feof($open_file)) {
       //Error: unexpected fgets() fail
    }
    fclose($open_file);

  return [$array, $count_rows]; // return array with row headers + row count

    }
}  
