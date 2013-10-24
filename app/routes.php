<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::when('administrator/*' , 'auth');
Route::controller('administrator', 'AdministratorController');

Route::controller('front', 'FrontController');


Route::any('logout' , function(){
	Loglogin::record('logout');
	Auth::logout();
	return Redirect::to('administrator')->with('message' , 'Succesful logout');
});