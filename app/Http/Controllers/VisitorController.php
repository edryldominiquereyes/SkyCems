<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Eventregister;
use App\Models\Facility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    //View visitor index
    public function index(){

        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();

        $events = Eventregister::join('facility_management', 'event_register_detail.facility_id','facility_management.facility_id')
            ->where('status', 'Approved')
            ->get();

        $hide = Carbon::now('Asia/Manila')->format('Y-m-d H:i:s a');

        $host = User::where('role','host')->where('status', 1)->get();
        
        return view('dashboards.visitor.index', ['hide'=>$hide,'event'=>$events,'notifications'=>$notification, 'host'=>$host] , array('user' => Auth::user()));
    }
    

    public function brgy($id){
        $count = Eventregister::where('user_id', $id)->where('status','Approved')->get()->count();
  
        $data = Facility::join('users','facility_management.user_id','users.id')->where('facility_management.user_id',$id)->get();
        // Eventregister::join('users', 'event_register_detail.user_id','users.id')
        //     ->join('facilities', 'event_register_detail.facility_id', '=', 'facilities.facility_id')
        //     ->where('event_register_detail.user_id', $id)
        //     ->where('event_register_detail.status','Approved')->get();
        
        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();

        $hide = Carbon::now('Asia/Singapore')->format('Y-m-d h:i:s a');

        return view('dashboards.visitor.brgy',['count'=>$count,'notifications'=>$notification, 'facilities'=>$data, 'hide'=>$hide], array('user' => Auth::user()));
    }

    public function viewEvents($id){
        
        $count = Eventregister::where('user_id', $id)->where('status','Approved')->get()->count();
  
        $data = Eventregister::join('facility_management','event_register_detail.facility_id','facility_management.facility_id')
            ->join('users','event_register_detail.user_id','users.id')
            ->where('event_register_detail.status', 'Approved')
            ->where('facility_management.facility_id',$id)
            ->get();

        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();

        $hide = Carbon::now('Asia/Manila')->format('Y-m-d h:i:s a');

        return view('dashboards.visitor.viewEvent',['hide'=>$hide,'count'=>$count,'notifications'=>$notification, 'facilities'=>$data, 'hide'=>$hide], array('user' => Auth::user()));
    }

    public function join($id){
       
        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
        ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
        ->where('attendees.user_id', Auth::id())
        ->where('event_register_detail.status', 'Approved')
        ->get();

        $facility = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('status', 'Approved')
            ->where('event_register_detail.user_id', $id)->onlyTrashed()->get();

        $data = Eventregister::where('event_id', $id)->first();
         
        $attendees = Attendee::where('event_id', $id)->get();

        $booked = Attendee::where('user_id',  Auth::id())->get();

        $count = Attendee::where('event_id', $id)->where('status','Approved')->get()->count();
        
        return view('dashboards.visitor.attendee', ['notifications'=>$notification,'event_id'=>$id, 'books'=>$booked,'event_id'=>$id, 'data'=>$data, 'attendees'=>$attendees, 'count'=>$count, 'facility'=>$facility], array('user' => Auth::user()));
    }

}
