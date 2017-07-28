<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//登录
Route::post('/user/login', '\App\Api\LoginController@login')->name('login');
//Route::group(['middleware' => 'auth:api'], function () {
//关闭登录检测
Route::group(['middleware' => 'api'], function () {
    //部门管理
    Route::get('/depart', '\App\Api\DepartController@index')->name('depart.view');

    //医院管理
    Route::get('/hospital', '\App\Api\HospitalController@index')->name('hospital.view');

    //科室管理
    Route::get('/department', '\App\Api\DepartmentController@index')->name('department.view');
    //疾病管理
    Route::get('/disease', '\App\Api\DiseaseController@index')->name('disease.view');
    //媒体管理
    Route::get('/media', '\App\Api\MediaController@index')->name('media.view');
    //预约管理
    Route::get('/patient', '\App\Api\PatientController@index')->name('patient.view');
    //医生管理
    Route::get('/doctor', '\App\Api\DoctorController@index')->name('doctor.view');

    //获取用户登录信息
    Route::get('/userinfo', '\App\Api\UserController@userInfo');
    //获取用户权限
    Route::get('/userauth', '\App\Api\UserController@userAuth');
    //用户api
    Route::get('/user', '\App\Api\UserController@index')->name('user.view');
    Route::get('/checkusername', '\App\Api\UserController@checkName');
    Route::post('/user/upavatar', '\App\Api\UserController@upAvatar');
    Route::get('/checkuseremail', '\App\Api\UserController@checkEmail');
    Route::post('/user/store', '\App\Api\UserController@store')->name('user.add');
    Route::post('/user/update', '\App\Api\UserController@update')->name('user.edit');
    Route::get('/user/remove', '\App\Api\UserController@destroy')->name('user.delete');
    Route::get('/user/batchremove', '\App\Api\UserController@batchremove')->name('user.delete');

    //角色管理
    Route::get('/role', '\App\Api\RoleController@index')->name('role.view');
    Route::get('/checkrolename', '\App\Api\RoleController@checkName');
    Route::get('/getallpermissions', '\App\Api\RoleController@getAllPermissions');
    Route::post('/role/store', '\App\Api\RoleController@store')->name('role.add');
    Route::post('/role/update', '\App\Api\RoleController@update')->name('role.edit');
    Route::get('/role/remove', '\App\Api\RoleController@destroy')->name('role.delete');
    Route::get('/role/batchremove', '\App\Api\RoleController@batchremove')->name('role.delete');
    //权限管理
    Route::get('/permission', '\App\Api\PermissionController@index')->name('permission.view');
    Route::get('/checkpermissionname', '\App\Api\PermissionController@checkName');
    Route::post('/permission/store', '\App\Api\PermissionController@store')->name('permission.add');
    Route::post('/permission/update', '\App\Api\PermissionController@update')->name('permission.edit');
    Route::get('/permission/remove', '\App\Api\PermissionController@destroy')->name('permission.delete');
    Route::get('/permission/batchremove', '\App\Api\PermissionController@batchremove')->name('permission.delete');

    //日志管理
    Route::get('/log', '\App\Api\LogController@index')->name('log.view');
    Route::get('/log/remove', '\App\Api\LogController@destroy')->name('log.delete');
    Route::get('/log/batchremove', '\App\Api\LogController@batchremove')->name('log.delete');
});
