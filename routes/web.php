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
    return view('welcome');
});

Route::get('scann', 'ScannController@Scan');

Route::get('scanner', 'ScannController@manageQrScan');

Route::get('index', 'EmployeController@home')->middleware('employe');

Route::get('login', 'EmployeController@index');
Route::post('log', 'EmployeController@login'); 

Route::get('logout', 'EmployeController@logout');

Route::get('liste', 'EmployeController@lister')->middleware('employe');
Route::get('form-employe', 'EmployeController@form')->middleware('employe');
Route::post('ajouter', 'EmployeController@store')->middleware('employe');
Route::get('modifier/{id}', 'EmployeController@editer')->middleware('employe');
Route::post('update/{id}', 'EmployeController@update')->middleware('employe');
Route::get('delete/{id}', 'EmployeController@destroy')->name('delete')->middleware('employe');