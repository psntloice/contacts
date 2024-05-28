<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupController;
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


// Routes for managing contacts
Route::get('contacts', [ContactController::class, 'index']);
Route::post('contacts', [ContactController::class, 'store']);
Route::get('contacts/{contact}', [ContactController::class, 'show']);
Route::put('contacts/{contact}', [ContactController::class, 'update']);
Route::delete('contacts/{contact}', [ContactController::class, 'destroy']);

// Routes for managing groups
Route::get('groups', [GroupController::class, 'index']);
Route::post('groups', [GroupController::class, 'store']);
Route::get('groups/{group}', [GroupController::class, 'show']);
Route::put('groups/{group}', [GroupController::class, 'update']);
Route::delete('groups/{group}', [GroupController::class, 'destroy']);

// Add contacts to a group
Route::post('groups/{group}/contacts', [GroupController::class, 'addContacts']);
// Remove contacts from a group
Route::delete('groups/{group}/contacts', [GroupController::class, 'removeContacts']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


