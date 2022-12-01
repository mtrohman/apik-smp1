<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

//Backend : Admin Panel
Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 

  Route::get('/', function () {
    return redirect(route('admin.dashboard'));
  });
  
  //naming convention ignored for dashboard as /admin/dashboards sounds inappropriate!
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard'); 
  
  Route::resource('products', 'ProductController'); 
  Route::resource('permissions', 'PermissionController'); 
  Route::resource('roles', 'RoleController'); 
  Route::resource('users', 'UserController'); 

});

//Frontend
Route::group([ 'namespace'=> '\App\Http\Controllers', 'prefix' => '',  'as'=>'', 'middleware' => 'auth' ], function () { 
  Route::resource('products', 'ProductController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::resource('rekening-parent-pendapatans', 'RekeningParentPendapatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::resource('rekening-parent-pengeluarans', 'RekeningParentPengeluaranController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::resource('rekening-pendapatans', 'RekeningPendapatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::resource('rekening-pengeluarans', 'RekeningPengeluaranController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::get('/rekening-kegiatans/parent/{rekeningId}', 'RekeningKegiatanController@search')->name('rekening-kegiatans.parent'); 
  Route::resource('rekening-kegiatans', 'RekeningKegiatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::resource('rka-pendapatans', 'RkaPendapatanController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::resource('rka-pengeluarans', 'RkaPengeluaranController'); 
});

Route::group([ 'namespace'=> '\App\Http\Controllers\Admin', 'prefix' => 'admin',  'as'=>'admin.', 'middleware' => 'auth' ], function () { 
  Route::get('/saldo-berjalan', 'SaldoController@index')->name('saldo');
  Route::get('/saldo-awal', 'SaldoController@saldo_awal')->name('saldo_awal');

  Route::get('/laporan/rkas-bab3', 'LaporanController@rkas_bab3')->name('laporan.rkas_bab3');
  Route::get('/laporan/rkas-bab4', 'LaporanController@rkas_bab4')->name('laporan.rkas_bab4');
  Route::get('/laporan/rkas-bab5', 'LaporanController@rkas_bab5')->name('laporan.rkas_bab5');
  Route::get('/laporan/rkas-bab6', 'LaporanController@rkas_bab6')->name('laporan.rkas_bab6');

  Route::get('/laporan/realisasi-bab3', 'LaporanController@realisasi_bab3')->name('laporan.realisasi_bab3');
  Route::get('/laporan/realisasi-bab4', 'LaporanController@realisasi_bab4')->name('laporan.realisasi_bab4');
  Route::get('/laporan/realisasi-bab5', 'LaporanController@realisasi_bab5')->name('laporan.realisasi_bab5');
  Route::get('/laporan/realisasi-bab6', 'LaporanController@realisasi_bab6')->name('laporan.realisasi_bab6');
   
});