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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index']);

// Route::get('a-propos', [\App\Http\Controllers\PagesController::class, 'about'])->name("about");

// Route::group(["prefix" => "admin", "middleware" => "auth"], function () {
//     Route::get("salut", function () {
//         return "Salut les gens";
//     });
// });

// Route::get('salut', function () {
//     return "Salut les gens";
// })->middleware("ip");

// Route::get('salut/{slug}-{id}', ["as" => "salut", function ($slug, $id) {
//     // return "Slug : $slug, ID: $id";
//     // return "Lien : /salut/$slug-$id";
//     return "Lien : " . route("salut", ["slug" => $slug, "id" => $id]);
// }])->where('slug', '[a-z0-9\-]+')->where('id', '[0-9]+');

// Route::controller(WelcomeController::class)->group(function () {
//     Route::get('welcome', 'index');
// });

// Route::get('links/create', [\App\Http\Controllers\LinksController::class, 'create']);

// Route::post('links/create', [\App\Http\Controllers\LinksController::class, 'store']);

// Route::get('r/{id}', [\App\Http\Controllers\LinksController::class, 'show'])->where('id', '[0-9]+')->name("show");

Route::resource('link', \App\Http\Controllers\LinksController::class, ["only" => ["create", "store"]]);
// Route::get('r/{id}', [\App\Http\Controllers\LinksController::class, 'show'])->where('id', '[0-9]+')->name("show");
Route::get('r/{link}', [\App\Http\Controllers\LinksController::class, 'show'])->where('link', '[0-9]+')->name("link.show");
