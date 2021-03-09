<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carvon;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'sunday' => 'required',
            'monday' => 'required',
            'tuesday' => 'required',
            'wednesday' => 'required',
            'thursday' => 'required',
            'friday' => 'required',
            'saturday' => 'required'
        ]);

        $event = Event::create($request->all());
        return response($event, 201);
    }
    
    
    public function getAllEvents() {
        return response()->json(Event::all(), 200);
    }

}
