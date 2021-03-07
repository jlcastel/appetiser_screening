<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;

// STORE Event
Route::post('event/add', [EventController::class, 'store']);

// GET all Event
Route::get('events/', [EventController::class, 'getAllEvents']);