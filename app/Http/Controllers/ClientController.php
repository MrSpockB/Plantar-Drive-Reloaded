<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Client;
use App\ODT;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json(['data'=>$clients]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->input('nombre');
        $client->slug = str_slug($client->name, '-');
        ///////
        $file = $request->file('logo');
        $destination_path = 'img/uploads/';
        $filename = str_random(6).'_'.$file->getClientOriginalName();
        $file->move($destination_path, $filename);
        /////
        $client->path_image = $destination_path . $filename;
        $client->save();
        if($request->ajax)
            return response()->json(['success' => true, 'msg'=>'Cliente creado']);
        else
            return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(is_numeric($id))
            $client = Client::with('odts')->find($id);
        else
            $client = Client::with('odts')->where('slug', '=', $id)->first();

        if(is_null($client))
            return response()->json(['success' => false, 'msg'=>'No existe ese cliente']);
        else
            return response()->json(['success' => true, 'data'=>$client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $destination_path = 'imgs/uploads/';
            $filename = str_random(6).'_'.$file->getClientOriginalName();
            $file->move($destination_path, $filename);
            $client->path_image = $destination_path . $filename;
        }
        $client->name = $request->input('nombre');
        $client->slug = str_slug($client->name, '-');
        $client->save();
        return response()->json(['success' => true, 'msg'=>'Cliente actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if(is_null($client))
        {
            $client->delete();
            return response()->json(['success' => true, 'msg' => 'Cliente eliminado']);
        }
        else
            return response()->json(['success' => false, 'msg' => 'No existe ese cliente']);
    }
}
