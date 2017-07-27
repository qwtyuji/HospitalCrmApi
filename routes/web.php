<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::group(['prefix'=>'dashboard','namespace'=>'Admin','middleware'=>['auth']],function (){
    Route::get('/', 'DashboardController@index')->name('home');
    Route::get('/home', 'DashboardController@index')->name('home');
    Route::resource('/role','RoleController');
    Route::resource('/user','UserController');
    Route::resource('/permission','PermissionController');
    Route::resource('/menu','MenuController');
});


