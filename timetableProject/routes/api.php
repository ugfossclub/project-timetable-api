<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/owen', function (Request $request) {
    return "sdfljsdf";
});

Route::group([
    'prefix' => 'accounts',
], function () {
    Route::get('/', 'Api\AccountsController@index')
         ->name('api.accounts.account.index');
    Route::get('/show/{account}','Api\AccountsController@show')
         ->name('api.accounts.account.show');
    Route::post('/', 'Api\AccountsController@store')
         ->name('api.accounts.account.store');    
    Route::put('account/{account}', 'Api\AccountsController@update')
         ->name('api.accounts.account.update');
    Route::delete('/account/{account}','Api\AccountsController@destroy')
         ->name('api.accounts.account.destroy');
});

Route::group([
    'prefix' => 'timetables',
], function () {
    Route::get('/', 'Api\TimetablesController@index')
         ->name('api.timetables.timetable.index');
    Route::get('/show/{timetable}','Api\TimetablesController@show')
         ->name('api.timetables.timetable.show');
    Route::post('/', 'Api\TimetablesController@store')
         ->name('api.timetables.timetable.store');    
    Route::put('timetable/{timetable}', 'Api\TimetablesController@update')
         ->name('api.timetables.timetable.update');
    Route::delete('/timetable/{timetable}','Api\TimetablesController@destroy')
         ->name('api.timetables.timetable.destroy');
});
