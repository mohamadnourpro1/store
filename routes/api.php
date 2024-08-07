<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartsProductsRelationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatuseController;
use App\Http\Controllers\StatuseNameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
  'middleware' => ['api', 'auth:api'],
  'prefix' => 'auth'
], function ($router) {
  Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
  Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware('auth:api');
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/refresh', [AuthController::class, 'refresh']);
  Route::get('/user-profile', [AuthController::class, 'userProfile']);
  
  Route::get('/product',[ProductController::class,'index']);
  Route::get('/product/{id}',[ProductController::class,'show']);
  //
  Route::post('/cart', [CartsProductsRelationController::class, 'store']);

  Route::get('/cart', [CartController::class, 'index']);
  Route::get('/mycart', [CartController::class, 'mycart']);
  Route::delete('/deltemyproducts', [CartController::class, 'deltemyproducts']);
  Route::get('/ordermyproducts', [CartController::class, 'ordermyproducts']);
});
Route::post('/product',[ProductController::class,'store']);
Route::post('/product/update/{id}',[ProductController::class,'update']);
Route::delete('/product/delete/{id}',[ProductController::class,'destroy']);

Route::post('/statusnames',[StatuseNameController::class,'store']);
Route::get('/statusnames',[StatuseNameController::class,'index']);
Route::get('/statusnames/{id}',[StatuseNameController::class,'show']);
Route::post('/statusnames/update/{id}',[StatuseNameController::class,'update']);
Route::delete('/statusnames/delete/{id}',[StatuseNameController::class,'destroy']);

Route::post('/status',[StatuseController::class,'store']);
Route::get('/status',[StatuseController::class,'index']);
Route::get('/status/{id}',[StatuseController::class,'show']);
Route::post('/status/update/{id}',[StatuseController::class,'update']);
Route::delete('/status/delete/{id}',[StatuseController::class,'destroy']);

Route::post('/category',[CategoryController::class,'store']);
Route::get('/category',[CategoryController::class,'index']);
Route::post('/category/update/{id}',[CategoryController::class,'update']);
Route::delete('/category/delete/{id}',[CategoryController::class,'destroy']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
