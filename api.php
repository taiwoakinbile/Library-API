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
//List Books
Route::get('books', 'BookController@index');
//list single book
Route::get('book/{bookid}', 'BookController@show');
//add new book
Route::post('book', 'BookController@store');
//update new book
Route::put('book/{bookid}', 'BookController@update');
//delete book
Route::delete('book/{id}', 'BookController@destroy');
//List users
Route::get('users', 'UserController@index');
//list single users
Route::get('user/{userid}', 'UserController@show');

