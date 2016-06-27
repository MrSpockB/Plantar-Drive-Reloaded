<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\File;

class FileController extends Controller
{
    public function testUpload(Request $request)
    {
    	$file = new File;
    	$uploadedFile = $request->file('file');
    	$file->name = $uploadedFile->getClientOriginalName();

    	$destination_path = 'uploads/';
        $filename = str_random(6).'_'.$uploadedFile->getClientOriginalName();
        $uploadedFile->move($destination_path, $filename);
        $file->path = $destination_path . $filename;
        $file->type = $uploadedFile->getClientMimeType();
        $file->save();

    	return response()->json(['success'=>true, 'id'=>$file->id]);
    }
}
