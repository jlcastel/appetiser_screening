<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    // Receives - 
    public function store(Request $request) {
        $event = Event::create($request->all());
        return response($event, 201);
    }

}
