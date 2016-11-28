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

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'api'], function () {
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('/getID','UserController@getLoginID');
    Route::get('/home', 'HomeController@index');
    Route::post('/crearmensaje','MessageController@create');
    Route::post('/getemail','MessageController@viewMails');
    Route::get('/folder','FolderController@index');
    Route::post('/signup','RegisterController@signup');
    Route::post('/countries','RegisterController@countries');
    Route::post('/provinces','RegisterController@provinces');
    Route::post('/cities','RegisterController@cities');
});
