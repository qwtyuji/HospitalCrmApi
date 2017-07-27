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
Route::group(['middleware' => 'auth:api'], function () {
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
    //文章api
    Route::get('/article', '\App\Api\ArticleController@index')->name('article.view');
    Route::get('/checkarticlename', '\App\Api\ArticleController@checkName');
    Route::post('/article/store', '\App\Api\ArticleController@store')->name('article.add');
    Route::post('/article/pic', '\App\Api\ArticleController@pic');
    Route::post('/article/update', '\App\Api\ArticleController@update')->name('article.edit');
    Route::get('/article/remove', '\App\Api\ArticleController@destroy')->name('article.delete');
    Route::get('/article/batchremove', '\App\Api\ArticleController@batchremove')->name('article.delete');
    //分类管理
    Route::get('/category', '\App\Api\CategoryController@index')->name('category.view');
    Route::get('/categorylist', '\App\Api\CategoryController@list');
    Route::get('/checkcatename', '\App\Api\CategoryController@checkName');
    Route::post('/category/store', '\App\Api\CategoryController@store')->name('category.add');
    Route::post('/category/update', '\App\Api\CategoryController@update')->name('category.edit');
    Route::get('/category/remove', '\App\Api\CategoryController@destroy')->name('category.delete');
    Route::get('/category/batchremove', '\App\Api\CategoryController@batchremove')->name('category.delete');
    //标签管理
    Route::get('/tag', '\App\Api\TagController@index')->name('tag.view');
    Route::get('/taglist', '\App\Api\TagController@list');
    Route::get('/checktagname', '\App\Api\TagController@checkName');
    Route::post('/tag/store', '\App\Api\TagController@store')->name('tag.add');
    Route::post('/tag/update', '\App\Api\TagController@update')->name('tag.edit');
    Route::get('/tag/remove', '\App\Api\TagController@destroy')->name('tag.delete');
    Route::get('/tag/batchremove', '\App\Api\TagController@batchremove')->name('tag.delete');
    //链接管理
    Route::get('/link', '\App\Api\LinkController@index')->name('link.view');
    Route::get('/checklinkname', '\App\Api\LinkController@checkName');
    Route::post('/link/store', '\App\Api\LinkController@store')->name('link.add');
    Route::post('/link/update', '\App\Api\LinkController@update')->name('link.edit');
    Route::get('/link/remove', '\App\Api\LinkController@destroy')->name('link.delete');
    Route::get('/link/batchremove', '\App\Api\LinkController@batchremove')->name('link.delete');
    //评论管理
    Route::get('/comment', '\App\Api\CommentController@index');
    Route::get('/comment/remove', '\App\Api\CommentController@destroy');
    Route::get('/comment/batchremove', '\App\Api\CommentController@batchremove');
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
//移动端首页
Route::group(['middleware' => 'api'], function () {
    Route::get('/getWapCategory', '\App\Api\HomeWapController@getWapCategory');
    Route::get('/getWapArticle', '\App\Api\HomeWapController@getWapArticle');
    Route::get('/getWapArticleById', '\App\Api\HomeWapController@getWapArticleById');
    Route::get('/getWapArticleByCategory', '\App\Api\HomeWapController@getWapArticleByCategory');
});
