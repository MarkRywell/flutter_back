<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\UserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// USERS

Route::post('/register', [AuthController::class, 'register']); //User registration

Route::post('/login', [AuthController::class, 'login']); //User login

Route::get('/users', [UserController::class, 'index']); //Fetch all users


// ITEMS

Route::get('/items', [ItemController::class, 'index']); //Fetch all items

Route::get('/items/{id}', [ItemController::class, 'fetchOtherItems']); //Fetch items from other users

Route::get('/item/{id}', [ItemController::class, 'fetchItemSeller']); //Fetch name of item seller

Route::get('/picture/{picture}', [ItemController::class, 'fetchPicture']); //Fetch picture of the item

Route::post('/picture/{id}', [ItemController::class, 'updatePicture']);

Route::post('/items', [ItemController::class, 'store']); //Store item

Route::delete('/items/{id}', [ItemController::class, 'destroy']); //Delete item

Route::put('/items/{id}', [ItemController::class, 'update']); //Update item

Route::patch('/item/{id}', [ItemController::class, 'remove']); //Remove item from myListings




