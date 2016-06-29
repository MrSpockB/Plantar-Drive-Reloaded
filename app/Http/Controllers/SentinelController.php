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
    public function createUser(Request $request)
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
    public function login(Request $request)
    {
    	$input = $request->only('email', 'password');
    	$data = array();
    	try
    	{
    		if(Sentinel::authenticate($input))
    		{
    			$data['success'] = true;
    			$data['msg'] = "Logueado exitosamente";
    		}
    		else
    		{
    			$data['success'] = false;
    			$data['msg'] = "Datos invalidos";
    		}
    	}
    	catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) 
    	{
            $data['success'] = false;
            $data['msg'] = "Usuario no activado";
        }
        catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e)
        {
            $data['success'] = true;
    		$data['msg'] = $e->getMessage();
        }
        return response()->json(['data'=>$data]);
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
            return response()->json(['success' => false, 'msg' => 'No esta logueado']);
        }
    }
    public function searchUserbyEmail($email)
    {
        $credentials = [
            'login' => $email,
        ];

        $user = Sentinel::findByCredentials($credentials);
        if($user)
        {
            return response()->json(['success' => true, 'user' => $user]);
        }
        else
        {
            return response()->json(['success' => false, 'msg' => "No se encontro el usuario"]);
        }
    }
}
