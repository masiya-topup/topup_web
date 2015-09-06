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

Route::get('/', "HomeController@showWelcome");
Route::get('/topup', "UserController@showGuestTopup");
Route::get('/registration', "UserController@showRegistration");

Route::post('/login', "AuthController@login");
Route::get('/logout', "AuthController@logout");

Route::post('/frm/phone/topup', "TopupController@processTopup");

Route::get('/forgotpassword', "AuthController@showForgotPassword");
Route::post('/frm/forgotpwd', "AuthController@processForgotPwd");
Route::get('/password/reset', "AuthController@showPwdChangeForm");
Route::post('/frm/password/reset', "AuthController@processPwdReset");

Route::get('/callback/topup/err-rc', "TopupController@topupError");

Route::get('/callback/topup/receipt/{id}', function($id) {
    return App::make("TopupController")->topupSuccess($id);
});
Route::post('/callback/topup/success/{id}', function($id) {
    return App::make("TopupController")->topupSuccess($id);
});
Route::post('/callback/topup/error/{id}', function($id) {
    return App::make("TopupController")->topupError($id);
});
Route::get('/callback/topup/error/{id}', function($id) {
    return App::make("TopupController")->topupError($id);
});

Route::get('/api/admin/users/{id}/{resource}', function($id, $resource) {
    return App::make("ApiController")->userDetails($id, $resource);
});
Route::get('/api/admin/{resource}', function($resource) {
    return App::make("ApiController")->fetch($resource);
});
Route::get('/api/guest/{resource}/{id}', function($resource, $id) {
    return App::make("ApiController")->fetchOne("$resource/$id");
});


Route::get('/error', function() {
    return Session::get("flash_error");
});

Route::post('/frm/user/register', "UserController@registerUser");

Route::group(array('before' => 'auth'), function() {
    Route::post('/frm/user/update', "UserController@updateUser");
    
    Route::get('/user/profile', "UserController@showProfile");
    
    Route::get('/user/profile/{resource}', function($resource) {
        return App::make("UserController")->show($resource);
    });
});

Route::group(array('before' => 'auth|admin_all'), function() {
    Route::post('/frm/admin/all/{resource}', function($resource) {
        return App::make("AdminAllController")->process($resource);
    });

    Route::get('/admin/all', function() {
        return Redirect::to("/admin/all/companies");
    });
    Route::get('/admin/all/{resource}', function($resource) {
        return App::make("AdminAllController")->show($resource);
    });
});

Route::group(array('before' => 'auth|admin_finance'), function() {
    Route::get('/admin/finance', function() {
        return App::make("AdminFinanceController")->show();
    });
});

Route::group(array('before' => 'auth|admin_customer'), function() {
    Route::post('/frm/admin/customer/{resource}', function($resource) {
        return App::make("AdminCustomerController")->process($resource);
    });

    Route::get('/admin/customer', function() {
        //return Redirect::to("/admin/customer/tickets");
        return View::make("admin_customer", array("title" => ""));
    });
    Route::get('/admin/customer/{resource}', function($resource) {
        return App::make("AdminCustomerController")->show($resource);
    });
});
