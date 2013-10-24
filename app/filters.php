<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('administrator')->with('error' , 'login to continue');
	
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('getprivilagefilter', function()
{
	//-----------GET THE URI--------------------//
	$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
	$data = $uri_parts[0];
	
	
	$data = explode('/', $data);
	$counter =  count($data);
	//-----------counter up to 3 means we are at the root of our admin, no need for privs here--------------------//
	if($counter<=3) return;
	
	//-----------Future reference: every cms request to the admin should have either 3 parameters--------------------//
	//-----------Future reference: ooor have the model the model injected as its final parameter--------------------//
	else if($counter==4){
		$model = $data[3];
		$privileges = Privilege::has_privilege($model , 'r_privilege_lvl');
	}else{
		$model = $data[$counter-1];
		$privileges = Privilege::has_privilege($model , 'r_privilege_lvl');
	}
	if(!$privileges){
		echo $_SERVER['REQUEST_URI'];
		die('Yo dawg, i heard you need more privileges to carry on' );
	}
});
Route::filter('postprivilagefilter', function()
{
	//-----------GET THE URI--------------------//
	$data = $_SERVER['REQUEST_URI'];
	$data = explode('/', $data);
	$counter =  count($data);
	//-----------counter up to 3 means we are at the root of our admin, no need for privs here--------------------//
	if($counter<=3) return;
	
	//-----------Future reference: every cms request to the admin should have either 3 parameters--------------------//
	//-----------Future reference: ooor have the model the model injected as its final parameter--------------------//
	else{
		$model = $data[3];
		$privileges = Privilege::has_privilege($model , 'w_privilege_lvl');
	}
	if(!$privileges){
		die('Yo dawg, i heard you need more privileges to carry on' );
	}
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Event::listen('user.login', function($user)
{
	if (Auth::user()->is_banned==1){
		Auth::logout();
		return 'banned';
	}
	if(Blacklistip::isIpBanned()){
		Auth::logout();
		return 'banned';
	}
	
	Loglogin::resetBlacklists();
	Loglogin::record('login');
	$data = User::where('username' , '=' , $user)->firstorFail();
	$data->touch();	
	
});
Event::listen('login.fail' , function($user){
	if(User::where('username' , '=' , $user)->count()>0)
		Blacklistuser::updateLoginFail($user);
	Blacklistip::updateLoginFail($user);	
});