<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('data/clientes', 'ClientController',['except'=>['create', 'edit']]);
Route::resource('data/clientes.odts', 'ODTController',['except'=>['create', 'edit'], 'parameters'=>'singular']);
Route::get('data/users', 'SentinelController@getUsers');
Route::get('data/users/{client}', 'SentinelController@getUsersbyClient');
Route::get('data/user/{email}', 'SentinelController@searchUserbyEmail');
Route::get('/checkLogin', 'SentinelController@checkLogin');
Route::post('/registerUser', 'SentinelController@createUser');
Route::post('/registerAdmin', 'SentinelController@createAdmin');
Route::post('/login', 'SentinelController@login');

Route::post('/upload', 'FileController@testUpload');

Route::get('/', function ()
{
   return view('index');
});

Route::get('admin', function ()
{
   return view('admin');
});

Route::get('demo', function ()
{
	return view('demoFiles');

});


Route::get('routes', function()
{
	$routeCollection = Route::getRoutes();
	echo "<table style='width:100%'>";
	    echo "<tr>";
	        echo "<td width='10%'><h4>HTTP Method</h4></td>";
	        echo "<td width='10%'><h4>Route</h4></td>";
	        echo "<td width='80%'><h4>Corresponding Action</h4></td>";
	    echo "</tr>";
	    foreach ($routeCollection as $value) {
	        echo "<tr>";
	            echo "<td>" . $value->getMethods()[0] . "</td>";
	            echo "<td>" . $value->getPath() . "</td>";
	            echo "<td>" . $value->getActionName() . "</td>";
	        echo "</tr>";
	    }
	echo "</table>";
});