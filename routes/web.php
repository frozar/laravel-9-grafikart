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

Route::get('/', [\App\Http\Controllers\LinksController::class, 'index']);

Route::resource('link', \App\Http\Controllers\LinksController::class, ["only" => ["index", "store", "destroy", "edit", "update"]]);
Route::get('r/{link}', [\App\Http\Controllers\LinksController::class, 'show'])->where('link', '[0-9]+')->name("link.show");
