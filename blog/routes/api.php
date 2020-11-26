<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'blog_categories'], function (){
    Route::get('/',[App\Http\Controllers\BlogCategoryController::class, 'index']);
    Route::post('/',[App\Http\Controllers\BlogCategoryController::class, 'create']);
    //Route::get('/{id}',[App\Http\Controllers\BlogCategoryController::class, 'find']);
    Route::post('/{id}',[App\Http\Controllers\BlogCategoryController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\BlogCategoryController::class, 'delete']);
    Route::get('/{search}',[App\Http\Controllers\BlogCategoryController::class, 'search']);
});

Route::group(['prefix' => 'comments'], function (){
    Route::get('/',[App\Http\Controllers\CommentController::class, 'index']);
    Route::post('/',[App\Http\Controllers\CommentController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\CommentController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\CommentController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\CommentController::class, 'destroy']);
});

Route::group(['prefix' => 'blogs'], function (){
    Route::get('/',[App\Http\Controllers\BlogController::class, 'index']);
    Route::post('/',[App\Http\Controllers\BlogController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\BlogController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\BlogController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\BlogController::class, 'destroy']);
});

Route::group(['prefix' => 'categories'], function (){
    Route::get('/',[App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/',[App\Http\Controllers\CategoryController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\CategoryController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'products'], function (){
    Route::get('/',[App\Http\Controllers\ProductController::class, 'index']);
    Route::post('/',[App\Http\Controllers\ProductController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\ProductController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\ProductController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\ProductController::class, 'destroy']);
});

Route::group(['prefix' => 'promotions'], function (){
    Route::get('/',[App\Http\Controllers\PromotionController::class, 'index']);
    Route::post('/',[App\Http\Controllers\PromotionController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\PromotionController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\PromotionController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\PromotionController::class, 'destroy']);
});

Route::group(['prefix' => 'product_promotions'], function (){
    Route::get('/',[App\Http\Controllers\ProductPromotionController::class, 'index']);
    Route::post('/',[App\Http\Controllers\ProductPromotionController::class, 'create']);
    Route::get('/{id}',[App\Http\Controllers\ProductPromotionController::class, 'show']);
    Route::post('/{id}',[App\Http\Controllers\ProductPromotionController::class, 'update']);
    Route::delete('/{id}',[App\Http\Controllers\ProductPromotionController::class, 'destroy']);
});

Route::post('/',[App\Http\Controllers\ContactController::Class,'store']);