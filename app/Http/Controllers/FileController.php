<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\File;
use App\Client;

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
    public function uploadFileToClientAccount(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->first();
        $file = new File;
        $uploadedFile = $request->file('file');
        $file->name = $uploadedFile->getClientOriginalName();
        $file->client_id = $client->id;

        $destination_path = 'uploads/';
        $filename = str_random(6).'_'.$uploadedFile->getClientOriginalName();
        $uploadedFile->move($destination_path, $filename);
        $file->path = $destination_path . $filename;
        $file->type = $uploadedFile->getClientMimeType();
        $file->save();

        return response()->json(['success'=>true, 'id'=>$file->id]);
    }
}
