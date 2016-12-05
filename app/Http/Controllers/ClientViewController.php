<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\ODT;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ClientViewController extends Controller
{
    public function showIndex()
	{
		return view('client.index');
	}
	public function redirectToHome()
	{
		if(Sentinel::inRole('admins'))
		{
			return redirect('admin');
		}
		else
		{
			$user = Sentinel::getUser();
			return redirect("cliente/".$user->client->slug);
		}
	}
	public function showClientODTS($slug)
    {
    	$client = Client::where('slug', $slug)->first();
    	return view('client.odts')->with('client', $client);
    }
    public function showViewCreateODT($slug)
    {
    	$client = Client::where('slug', $slug)->first();
    	return view('client.createODT')->with('client', $client);
    }
    public function showViewDetailsODT($slug, $id)
    {
    	$odt = ODT::find($id);
    	return view('client.viewDetailsODT')->with('odt', $odt);
    }
}
