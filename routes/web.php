<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OptionControllerController;
use App\Http\Controllers\ServiceController;
use App\Models\Basket;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.master.master');
});
Route::resource('option', OptionControllerController::class);
Route::resource('service', ServiceController::class);
Route::resource('product', FrontController::class)->middleware('auth');

Route::get('/test', function () {
    $basket = Basket::find(3);
    return json_decode($basket->options);
    $user = Auth::user();
    return $user->basket();
    $s = Service::find(11);
    return json_decode($s->specifications, true);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->back();
});
Route::get('testVue',function(){
    return view('layouts.test.test');
});
