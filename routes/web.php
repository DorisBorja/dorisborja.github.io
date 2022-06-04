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

// Registered and Activated User Routes
Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', ['uses' => 'App\Http\Controllers\Auth\LoginController@logout'])->name('logout');

});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    //Users
    Route::get('usuarios', '\App\Http\Controllers\UserController@showView')->name('usuarios');
    Route::resource('/users', \App\Http\Controllers\UserController::class);

    //Get Roles
    Route::post('roles', '\App\Http\Controllers\UserController@getRoles')->name('roles');

    //Livestock
    Route::get('ganado', '\App\Http\Controllers\LivestockController@showView')->name('ganado');
    Route::resource('/livestocks', \App\Http\Controllers\LivestockController::class);

    //Medicines
    Route::get('medicinas', '\App\Http\Controllers\MedicineController@showView')->name('medicinas');
    Route::resource('/medicines', \App\Http\Controllers\MedicineController::class);

    //Marks
    Route::get('marcas', '\App\Http\Controllers\MarkController@showView')->name('marcas');
    Route::resource('/marks', \App\Http\Controllers\MarkController::class);

    //Categories
    Route::get('categorias', '\App\Http\Controllers\CategoryController@showView')->name('categorias');
    Route::resource('/categories', \App\Http\Controllers\CategoryController::class);

    //Breeds
    Route::get('razas', '\App\Http\Controllers\BreedController@showView')->name('razas');
    Route::resource('/breeds', \App\Http\Controllers\BreedController::class);

});

Route::group(['middleware' => ['auth', 'role:trabajador, admin']], function () {

    //Livestock
    Route::get('ganado', '\App\Http\Controllers\LivestockController@showView')->name('ganado');
    Route::resource('/livestocks', \App\Http\Controllers\LivestockController::class);

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
