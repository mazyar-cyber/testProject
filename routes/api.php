<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\ServiceController;
use App\Models\admin\OptionController;
use App\Models\Basket;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/deleteoption/{id}', function ($id) {
    // return 'this is delete api'.$id;
    $model = OptionController::find($id);
    if ($model) {
        $model->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

});
Route::post('/deleteService/{id}', function ($id) {
    // return 'this is delete api'.$id;
    $model = Service::find($id);
    if ($model) {
        $model->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

});
Route::post('/deleteProduct/{id}', function ($id) {
    // return 'this is delete api'.$id;
    $model = Basket::find($id);
    if ($model) {
        $model->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

});
Route::post('/addOptionToService/{id}', [ServiceController::class, 'addOptionToService']);
Route::post('/addOptionToService2/{id}', [ServiceController::class, 'addOptionToService2']);
Route::post('/calcPrice/{id}', [FrontController::class, 'calcPrice']);

