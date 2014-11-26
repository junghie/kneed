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
	// Our own method to defend XSS attacks globally.
	Common::globalXssClean();
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
	if (!(isset(Session::get('user')->MSISDN)))
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('/');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
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
	//if (Auth::check()) return Redirect::to('/');
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

Route::filter('updatevars', function(){
	if(isset(Session::get('user')->MSISDN)){
		//Auth::logout();
		//Auth::loginUsingId(Session::get('user')->ID);
		//Session::put('user',Auth::user());

		//get accounttype
		$accounttypes = Accounttypes::get();
		$keywords_package ="";// SystemInfo::getProperty('KEYWORDPACKAGE');
		Session::put('accounttypes',$accounttypes);
		if(empty($keywords_package)) $keywords_package = json_encode(array(
				array("package"=>"A","amount"=>"10"),
				array("package"=>"B","amount"=>"30"),
				array("package"=>"C","amount"=>"40"),
			));
		
		Session::put('keywordpackage',json_decode($keywords_package));
	}
}
);

App::missing(function($exception)
{
    return Response::view('404', array(), 404);
});


Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^([-a-z0-9_-\s])+$/i', $value);
});