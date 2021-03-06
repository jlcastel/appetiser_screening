<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;


Route::post('event/add', [EventController::class, 'store']);
Route::get('events/', [EventController::class, 'getAllEvents']);
Route::get('events/events/', [EventController::class, 'getAllEvents']);