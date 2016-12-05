<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Sentinel;
use App\Client;

class SentinelController extends Controller
{
    public function createAdmin(Request $request)
    {
    	$input = $request->only('email', 'password', 'first_name', 'last_name');
    	$user = Sentinel::registerAndActivate($input);
    	$adminRole = Sentinel::findRoleByName('Admins');
    	$adminRole->users()->attach($user);
    	return response()->json(['success' => true, 'msg' => 'Usuario creado']);
    }
    public function createClientUser(Request $request)
    {
    	$client = Client::where('slug', '=', $request->input("cliente"))->first();
    	$input = $request->only('email', 'password', 'first_name', 'last_name');
    	$user = Sentinel::registerAndActivate($input);
    	$user->client_id = $client->id;
    	$user->save();
    	$usersRole = Sentinel::findRoleByName('Usuarios');
    	$usersRole->users()->attach($user);
    	return response()->json(['success' => true, 'msg' => 'Usuario creado']);
    }
    public function createUser(Request $request)
    {
        $input = $request->only('email', 'password', 'first_name', 'last_name');
        if($request->input('tipo') == "admin")
        {
            $user = Sentinel::registerAndActivate($input);
            $adminRole = Sentinel::findRoleByName('Admins');
            $adminRole->users()->attach($user);
            return redirect('admin/crearUsuario')->with('message', 'Administrador creado correctamente');
        }
        else
        {
            $client = Client::where('slug', '=', $request->input("cliente"))->first();
            $user = Sentinel::registerAndActivate($input);
            $user->client_id = $client->id;
            $user->save();
            $usersRole = Sentinel::findRoleByName('Usuarios');
            $usersRole->users()->attach($user);
            return redirect('admin/crearUsuario')->with('message', 'Usuario creado correctamente');
        }

    }
    public function login(Request $request)
    {
    	$input = $request->only('email', 'password');
    	$data = array();
    	try
    	{
            $user = Sentinel::authenticate($input);
    		if($user)
    		{
                $isAdmin = Sentinel::inRole('admins');
                if($isAdmin)
                    return redirect('admin');
                else
                {
                    $slug = $user->client->slug;
                    return redirect('cliente/'.$slug);
                }
    		}
    		else
    		{
                return redirect("/")->with('message','Datos incorrectos');
    		}
    	}
    	catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e)
    	{
            return redirect("/")->with('message','Usuario no activado');
        }
    }
    public function logout()
    {
        Sentinel::logout(null, true);
        return redirect('/');
    }
    public function getUsers()
    {
        $role = Sentinel::findRoleByName('Usuarios');
        $users = $role->users()->get();
        $data = array();
        foreach ($users as $user)
        {
            array_push($data, $user['attributes']);
        }
        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getUsersByClient($slug)
    {
        $client = Client::with('users')->where('slug', '=', $slug)->first();
        $users = $client->users;
        $data = array();
        foreach ($users as $user)
        {
            array_push($data, $user['attributes']);
        }
        return response()->json(['success' => true, 'msg' => $data]);
    }
    public function checkLogin()
    {
        if($user = Sentinel::check())
        {
            return response()->json(['success' => true, 'user' => $user]);
        }
        else
        {
            return response()->json(['success' => false, 'msg' => 'User is not logged in']);
        }
    }
}
