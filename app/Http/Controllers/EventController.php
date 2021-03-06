<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function store(Request $request) {
        $event = Event::create($request->all());
        return response($event, 201);
    }
    
    public function getAllEvents() {
        return response()->json(Event::all(), 200);
    }

}
