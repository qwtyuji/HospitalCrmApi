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
//Route::get('/hospitalgroup', '\App\Api\HospitalController@group');
Route::group(['middleware' => 'auth:api'], function () {
    //部门管理
    Route::get('/depart', '\App\Api\DepartController@index')->name('depart.view');

    //医院管理
    Route::get('/hospital', '\App\Api\HospitalController@index')->name('hospital.view');
    Route::get('/hospitalgroup', '\App\Api\HospitalController@group');
    Route::get('/checkhospitalname', '\App\Api\HospitalController@checkHospitalName');
    Route::post('/hospital/store', '\App\Api\HospitalController@store')->name('hospital.add');
    Route::post('/hospital/update', '\App\Api\HospitalController@update')->name('hospital.edit');
    Route::get('/hospital/remove', '\App\Api\HospitalController@destroy')->name('hospital.delete');
    Route::get('/hospital/batchremove', '\App\Api\HospitalController@batchremove')->name('hospital.delete');
    //科室管理
    Route::get('/department', '\App\Api\DepartmentController@index')->name('department.view');
    Route::get('/hospital/list', '\App\Api\HospitalController@list');
    Route::get('/checkdepartmentname', '\App\Api\DepartmentController@checkDepartmentName');
    Route::get('/hospitaldepartment', '\App\Api\DoctorController@getHospitalDepartment');
    Route::post('/department/store', '\App\Api\DepartmentController@store')->name('department.add');
    Route::post('/department/update', '\App\Api\DepartmentController@update')->name('department.edit');
    Route::get('/department/remove', '\App\Api\DepartmentController@destroy')->name('department.delete');
    Route::get('/department/batchremove', '\App\Api\DepartmentController@batchremove')->name('department.delete');
    //疾病管理
    Route::get('/disease', '\App\Api\DiseaseController@index')->name('disease.view');
    Route::get('/disease/list', '\App\Api\DiseaseController@list');
    Route::get('/checkdiseasename', '\App\Api\DiseaseController@checkDiseaseName');
    Route::post('/disease/store', '\App\Api\DiseaseController@store')->name('disease.add');
    Route::post('/disease/update', '\App\Api\DiseaseController@update')->name('disease.edit');
    Route::get('/disease/remove', '\App\Api\DiseaseController@destroy')->name('disease.delete');
    Route::get('/disease/batchremove', '\App\Api\DiseaseController@batchremove')->name('disease.delete');
    //媒体管理

    Route::get('/media', '\App\Api\MediaController@index')->name('media.view');
    Route::get('/checkmedianame', '\App\Api\MediaController@checkMediaName');
    Route::post('/media/store', '\App\Api\MediaController@store')->name('media.add');
    Route::post('/media/update', '\App\Api\MediaController@update')->name('media.edit');
    Route::get('/media/remove', '\App\Api\MediaController@destroy')->name('media.delete');
    Route::get('/media/batchremove', '\App\Api\MediaController@batchremove')->name('media.delete');


    //预约管理
    Route::get('/patient', '\App\Api\PatientController@index')->name('patient.view');
    Route::post('/patient/store', '\App\Api\PatientController@store')->name('patient.add');

    Route::get('/patient/medialist', '\App\Api\PatientController@mediaLIst');
    Route::get('/patient/departmentlist', '\App\Api\PatientController@departmentLIst');
    Route::get('/patient/doctorlist', '\App\Api\PatientController@doctorLIst');
    Route::get('/patient/diseaselist', '\App\Api\PatientController@diseaseLIst');
    //医生管理
    Route::get('/doctor', '\App\Api\DoctorController@index')->name('doctor.view');
    Route::get('/checkdoctorname', '\App\Api\DoctorController@checkDoctorName');
    Route::get('/hospitaldepartment', '\App\Api\DoctorController@getHospitalDepartment');
    Route::post('/doctor/store', '\App\Api\DoctorController@store')->name('doctor.add');
    Route::post('/doctor/update', '\App\Api\DoctorController@update')->name('doctor.edit');
    Route::get('/doctor/remove', '\App\Api\DoctorController@destroy')->name('doctor.delete');
    Route::get('/doctor/batchremove', '\App\Api\DoctorController@batchremove')->name('doctor.delete');
    //获取用户登录信息
    Route::get('/userinfo', '\App\Api\UserController@userInfo');
    //获取用户权限
    Route::get('/userauth', '\App\Api\UserController@userAuth');
    //用户api
    Route::get('/user', '\App\Api\UserController@index')->name('user.view');
    Route::get('/checkusername', '\App\Api\UserController@checkUserName');
    Route::post('/user/upavatar', '\App\Api\UserController@upAvatar');
    Route::get('/checkuseremail', '\App\Api\UserController@checkEmail');
    Route::post('/user/store', '\App\Api\UserController@store')->name('user.add');
    Route::post('/user/update', '\App\Api\UserController@update')->name('user.edit');
    Route::get('/user/remove', '\App\Api\UserController@destroy')->name('user.delete');
    Route::get('/user/batchremove', '\App\Api\UserController@batchremove')->name('user.delete');
    Route::post('/userset', '\App\Api\UserController@userSet');
    //部门管理
    Route::get('/depart', '\App\Api\DepartController@index')->name('depart.view');
    Route::get('/depart/list', '\App\Api\DepartController@list');
    Route::get('/checkdepartname', '\App\Api\DepartController@checkDepartName');
    Route::post('/depart/store', '\App\Api\DepartController@store')->name('depart.add');
    Route::post('/depart/update', '\App\Api\DepartController@update')->name('depart.edit');
    Route::get('/depart/remove', '\App\Api\DepartController@destroy')->name('depart.delete');
    Route::get('/depart/batchremove', '\App\Api\DepartController@batchremove')->name('depart.delete');
    //角色管理
    Route::get('/role', '\App\Api\RoleController@index')->name('role.view');
    Route::get('/checkrolename', '\App\Api\RoleController@checkRoleName');
    Route::get('/getallpermissions', '\App\Api\RoleController@getAllPermissions');
    Route::post('/role/store', '\App\Api\RoleController@store')->name('role.add');
    Route::post('/role/update', '\App\Api\RoleController@update')->name('role.edit');
    Route::get('/role/remove', '\App\Api\RoleController@destroy')->name('role.delete');
    Route::get('/role/batchremove', '\App\Api\RoleController@batchremove')->name('role.delete');
    //权限管理
    Route::get('/permission', '\App\Api\PermissionController@index')->name('permission.view');
    Route::get('/checkpermissionname', '\App\Api\PermissionController@checkPermissionName');
    Route::post('/permission/store', '\App\Api\PermissionController@store')->name('permission.add');
    Route::post('/permission/update', '\App\Api\PermissionController@update')->name('permission.edit');
    Route::get('/permission/remove', '\App\Api\PermissionController@destroy')->name('permission.delete');
    Route::get('/permission/batchremove', '\App\Api\PermissionController@batchremove')->name('permission.delete');

    //日志管理
    Route::get('/log', '\App\Api\LogController@index')->name('log.view');
    Route::get('/log/remove', '\App\Api\LogController@destroy')->name('log.delete');
    Route::get('/log/batchremove', '\App\Api\LogController@batchremove')->name('log.delete');
});
