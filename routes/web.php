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

Route::get('/', function(){
	return view('auth.login');
});

Auth::routes();

Route::match(["GET", "POST"], "/register", function(){
	return redirect("/login");
})->name("register");

Route::resource("users", "UserController");

Route::get('/foods/{id}/restore', 'FoodController@restore')->name('foods.restore');
Route::delete('/foods/{id}/delete-permanent', 'FoodController@deletePermanent')->name('foods.delete-permanent');
Route::get('/foods/trash', 'FoodController@trash')->name('foods.trash');

Route::resource('foods', 'FoodController');

Route::get('/drinks/{id}/restore', 'DrinkController@restore')->name('drinks.restore');
Route::delete('/drinks/{id}/delete-permanent', 'DrinkController@deletePermanent')->name('drinks.delete-permanent');
Route::get('/drinks/trash', 'DrinkController@trash')->name('drinks.trash');

Route::resource('drinks', 'DrinkController');

Route::get('/home', 'HomeController@index')->name('home');