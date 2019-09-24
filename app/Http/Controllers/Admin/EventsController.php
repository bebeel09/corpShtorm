<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Event;

class EventsController extends Controller
{
    //

    function getPage(){
        $eventData= json_encode(Event::all());
        return view('admin.calendarHTML', compact('eventData'));
    }

    function getFrontPage(){
        $eventData= json_encode(Event::all());
        return view('calendar', compact('eventData'));
    }
  

    function addEvent(Request $request){
        $dataEvent= json_decode($request->all()["data"]);
        $eventModel= new Event();
        $eventModel->title= $dataEvent->title;
        $eventModel->className=$dataEvent->className;
        $eventModel->end=$dataEvent->end;
        $eventModel->start=$dataEvent->start;
        $eventModel->repeats=$dataEvent->repeats;
        $eventModel->save();

        echo $eventModel->id;
    }

    function deleteEvent(Request $request){
        // dd($request->all());
        Event::destroy($request->all()['id']);
    }

    function updateEvent(Request $request){
        $data=$request->all();
        $modelEvent = Event::find($data["id"]);
        $modelEvent->title=$data["title"];
        $modelEvent->save();
    }

}
