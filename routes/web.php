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

Route::group(["prefix" => "admin", "middleware" => "auth"], function () {
    Route::get("salut", function () {
        return "Salut les gens";
    });
});

Route::get('salut', function () {
    return "Salut les gens";
});

Route::get('salut/{slug}-{id}', ["as" => "salut", function ($slug, $id) {
    // return "Slug : $slug, ID: $id";
    // return "Lien : /salut/$slug-$id";
    return "Lien : " . route("salut", ["slug" => $slug, "id" => $id]);
}])->where('slug', '[a-z0-9\-]+')->where('id', '[0-9]+');
