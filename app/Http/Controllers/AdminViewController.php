<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Client;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AdminViewController extends Controller
{
	public function showIndex()
	{
		$clients = Client::all();
		return view('admin.index')->with('clients', $clients);
	}
	public function showViewAllUsers()
	{
		$users = User::all();
		return view('admin.viewUsers')->with('users', $users);
	}
    public function showViewCreateUser()
    {
    	$clients = Client::all();
    	return view('admin.createUser')->with('clients', $clients);
    }
    public function showViewcreateClient()
    {
    	return view('admin.createClient');
    }
}
