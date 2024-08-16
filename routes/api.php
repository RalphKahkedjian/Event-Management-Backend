<?php

use App\Http\Controllers\User\Attendee\AttendeeController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\Organizer\OrganizerController;
use App\Http\Controllers\User\Ticket\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//FOR USER AUTH
Route::put('/User/auth' , [AuthController::class, 'register']);
Route::post('/User/auth' , [AuthController::class, 'login']);
Route::get('/User/auth', [AuthController::class , 'ListUsers']);

//FOR ORGANIZER (CREATE, DELETE, AND GET)
//Route::post('/User/Organizer' , [OrganizerController::class, 'store']);
Route::delete('/User/Organizer/{id}', [OrganizerController::class, 'destroy']);
Route::get('/User/Organizer/{id?}', [OrganizerController::class, 'list']);

//For ATTENDEE (CREATE, DELETE, AND GET)
//Route::post('/User/Attendee', [AttendeeController::class, 'store']);
Route::delete('/User/Attendee/{id}', [AttendeeController::class, 'destroy']);
Route::get('/User/Attendee/{id?}', [AttendeeController::class, 'list']);

//For TICKET (CREATE, DELETE, AND GET)
Route::middleware('auth:sanctum')->post('/User/Ticket', [TicketController::class, 'store']);
Route::middleware('auth/sanctum')->delete('/User/Ticket/{id?}', [TicketController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/User/Ticket', [TicketController::class, 'list']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

