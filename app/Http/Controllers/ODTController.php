<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ODT;

use App\Client;

use App\File;

class ODTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cliente)
    {
        if(is_numeric($cliente))
            $client = Client::with('odts.users')->find($cliente);
        else
            $client = Client::with('odts.users')->where('slug', '=', $cliente)->first();

        $odts = $client->odts;
        return response()->json(['data'=>$odts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cliente)
    {
        $client = $client = Client::where('slug', '=', $cliente)->first();
        $odt = new ODT;
        $odt->name = $request->input('nombre');
        $odt->creationDate = $request->input('fechaCreacion');
        $odt->area = $request->input('area');
        $odt->description = $request->input('descripcion');
        $odt->startDate = $request->input('fechaInicio');
        $odt->endDate = $request->input('fechaFin');
        $odt->progress_estimated = 0;
        $odt->progress_real = 0;
        $odt->status = 'Pendiente';
        $odt->client_id = $client->id;
        //
        $idsUsers = $request->input('usuarios');
        $idsU = explode(',', $idsUsers);
        $odt->save();
        foreach ($idsU as $value) 
        {
            $odt->users()->attach($value);
        }
        //
        $idsFiles = $request->input('archivos');
        $idsF = explode(',', $idsFiles);
        foreach ($idsF as $value) 
        {
            $file = File::find($value);
            $file->odt_id = $odt->id;
            $file->save();
        }
        $odt->save();
        return response()->json(['success' => true, 'msg'=>'Orden de trabajo agregada']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cliente, $odt)
    {
        $odt = ODT::with('users')->find($odt);
        return response()->json(['data'=>$odt]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
