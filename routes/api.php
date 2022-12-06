<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
  Route::post('register', 'AuthController@register');
  Route::post('login', 'AuthController@login');

  Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', 'AuthController@logout');
  });
});

//Backend (/admin prefix)
Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/products/search/{title}', 'ProductController@search')->name('products.search'); 
  Route::apiResource('products', 'ProductController'); 

  Route::get('/permissions/search/{name}', 'PermissionController@search')->name('permissions.search'); 
  Route::apiResource('permissions', 'PermissionController'); 

  Route::get('/roles/search/{name}', 'RoleController@search')->name('roles.search'); 
  Route::apiResource('roles', 'RoleController'); 

  Route::get('/users/search/{title}', 'UserController@search')->name('users.search'); 
  Route::apiResource('users', 'UserController'); 
});

//Frontend (no /admin prefix)
Route::group([ 'namespace'=> '\App\Http\Controllers\Api', 'prefix' => '',  'as'=>'', 'middleware' => ['auth:api']], function () { 
  Route::get('/products/search/{title}', 'ProductController@search')->name('products.search'); 
  Route::apiResource('products', 'ProductController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rekening-parent-pendapatans/search/{title}', 'RekeningParentPendapatanController@search')->name('rekening-parent-pendapatans.search'); 
  Route::apiResource('rekening-parent-pendapatans', 'RekeningParentPendapatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rekening-parent-pengeluarans/search/{title}', 'RekeningParentPengeluaranController@search')->name('rekening-parent-pengeluarans.search'); 
  Route::apiResource('rekening-parent-pengeluarans', 'RekeningParentPengeluaranController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rekening-pendapatans/search/{title}', 'RekeningPendapatanController@search')->name('rekening-pendapatans.search'); 
  Route::apiResource('rekening-pendapatans', 'RekeningPendapatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rekening-pengeluarans/search/{title}', 'RekeningPengeluaranController@search')->name('rekening-pengeluarans.search'); 
  Route::apiResource('rekening-pengeluarans', 'RekeningPengeluaranController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rekening-kegiatans/search/{title}', 'RekeningKegiatanController@search')->name('rekening-kegiatans.search'); 
  Route::apiResource('rekening-kegiatans', 'RekeningKegiatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rka-pendapatans/search/{title}', 'RkaPendapatanController@search')->name('rka-pendapatans.search'); 
  Route::apiResource('rka-pendapatans', 'RkaPendapatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/rka-pengeluarans/search/{title}', 'RkaPengeluaranController@search')->name('rka-pengeluarans.search'); 
  Route::apiResource('rka-pengeluarans', 'RkaPengeluaranController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/penerimaans/search/{title}', 'PenerimaanController@search')->name('penerimaans.search'); 
  Route::apiResource('penerimaans', 'PenerimaanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Api\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => ['auth:api']], function () { 
  Route::get('/belanjas/search/{title}', 'BelanjaController@search')->name('belanjas.search'); 
  Route::apiResource('belanjas', 'BelanjaController'); 
});