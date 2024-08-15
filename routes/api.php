<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\Organizer\OrganizerController;
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

//FOR USER AUTH
Route::put('/User/auth' , [AuthController::class, 'register']);
Route::post('/User/auth' , [AuthController::class, 'login']);
Route::get('/User/auth', [AuthController::class , 'ListUsers']);

//FOR ORGANIZER (CREATE, DELETE, AND GET)
Route::post('/User/Organizer' , [OrganizerController::class, 'store']);
Route::delete('/User/Organizer/{id}', [OrganizerController::class, 'destroy']);
Route::get('/User/Organizer/{id?}', [OrganizerController::class, 'list']);

//For ATTENDEE (CREATE, DELETE, AND GET)

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
