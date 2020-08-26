<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('car')->middleware('auth')->group(function()
{
    Route::name('car.')->namespace('Car')->group(function()
    {
        Route::get('/', 'CarController@index')->name('index');
        Route::get('/create', 'CarController@create')->name('create');
        Route::post('/create', 'CarController@store')->name('store');
        Route::middleware('check_car_owner')->group(function()
        {
            Route::get('/edit/{id}', 'CarController@edit')->name('edit');
            Route::put('/edit/{id}', 'CarController@update')->name('update');
            Route::get('/request_date/{id}', 'CarController@createDate')->name('request_date');  
            Route::post('/request_date/{id}', 'CarController@storeDate')->name('store_date');
            Route::delete('/{id}', 'CarController@destroy')->name('destroy');
            Route::delete('/photo/{id}', 'CarController@deleteCarPhoto')->name('photo_delete');
        });
    });
});
Route::prefix('user')->middleware('auth', 'check_user')->group(function(){
    Route::name('user.')->namespace('User')->group(function(){
        Route::get('/edit/{id}', 'UserController@edit')->name('edit');
        Route::put('/edit/{id}', 'UserController@update')->name('update');

    });
}); 

Route::prefix('admin')->middleware('admin_check')->group(function()
{
    Route::name('admin.')->namespace('Admin')->group(function()
    {
        Route::get('/car', 'AdminController@carIndex')->name('car');
        Route::put('/car/{id}', 'AdminController@carUpdate')->name('car_update');
        Route::delete('/car/{id}', 'AdminController@deleteCar')->name('car_delete');
        Route::delete('/car/photo/{id}', 'AdminController@deleteCarPhoto')->name('car_photo_delete');
        Route::get('/mot_index', 'AdminController@motIndex')->name('mot_index');
        Route::post('/mot', 'AdminController@setMot')->name('set_mot');
        Route::get('/mot_calendar', 'AdminController@motCalendar')->name('mot_calendar');
        Route::get('/mot_seven', 'AdminController@motSeven')->name('mot_seven');
        
    });
});


