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
    $l4_sid = Session::getId();
    Log::info("$l4_sid: IncomingRequest: ".Request::__toString());
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
    $l4_sid = Session::getId();
    if (!Session::has("userLogin")) {
        Log::error("L4Session:$l4_sid; Filter:auth; User Object NOT found");
        return Redirect::guest('/')->with('flash_error', 'You must be logged in to view this page!');
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
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('admin_all', function($request)
{
    $l4_sid = Session::getId();
    $routePath = Route::getCurrentRoute()->getPath();
    $module = explode('/', $routePath)[0];
	
    $userLogin = (Session::get("userLogin"));
    if(!isset($userLogin)) {
        return Redirect::to('/error')->with('flash_error', "Access violation : user not logged in");
    }
    $usrRole = $userLogin->user->userRole;
    if(!isset($usrRole)) {
        return Redirect::to('/error')->with('flash_error', "Access violation : user role not available");
    }
	
    if($usrRole != "admin_all") {
        Log::error("L4Session:$l4_sid; Filter:access; Route:$routePath; Role:$usrRole; Module:$module");
	return Redirect::to('/error')->with('flash_error', "Access violation : You dont have access to '/admin/all/*' ($usrRole)");
    }	
});

Route::filter('admin_finance', function($request)
{
    $l4_sid = Session::getId();
    $routePath = Route::getCurrentRoute()->getPath();
    $module = explode('/', $routePath)[0];
	
    $userLogin = (Session::get("userLogin"));
    if(!isset($userLogin)) {
        return Redirect::to('/error')->with('flash_error', "Access violation : user not logged in");
    }
    $usrRole = $userLogin->user->userRole;
    if(!isset($usrRole)) {
        return Redirect::to('/error')->with('flash_error', "Access violation : user role not available");
    }
	
    if($usrRole != "admin_finance") {
        Log::error("L4Session:$l4_sid; Filter:access; Route:$routePath; Role:$usrRole; Module:$module");
	return Redirect::to('/error')->with('flash_error', "Access violation : You dont have access to '/admin/finance/*' ($usrRole)");
    }	
});


Route::filter('admin_customer', function($request)
{
    $l4_sid = Session::getId();
    $routePath = Route::getCurrentRoute()->getPath();
    $module = explode('/', $routePath)[0];
	
    $userLogin = (Session::get("userLogin"));
    if(!isset($userLogin)) {
        return Redirect::to('/error')->with('flash_error', "Access violation : user not logged in");
    }
    $usrRole = $userLogin->user->userRole;
    if(!isset($usrRole)) {
        return Redirect::to('/error')->with('flash_error', "Access violation : user role not available");
    }
	
    if($usrRole != "admin_customer") {
        Log::error("L4Session:$l4_sid; Filter:access; Route:$routePath; Role:$usrRole; Module:$module");
	return Redirect::to('/error')->with('flash_error', "Access violation : You dont have access to '/admin/customer/*' ($usrRole)");
    }	
});