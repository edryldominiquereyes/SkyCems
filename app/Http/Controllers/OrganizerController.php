<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Support\Facades\Auth;

use App\Models\Facility;
use App\Models\Eventregister;
use App\Models\User;

class OrganizerController extends Controller
{
    //View dashboard Page
    public function index(){

        $barangay = User::where('role','host')->where('status', 1)->get();
        //Facility::join('users', 'facilities.user_id', 'users.id')->get();

        $events = Eventregister::join('facility_management', 'event_register_detail.facility_id','facility_management.facility_id')
            ->where('status', 'Approved')
            ->get();

        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status','Approved')
            ->get();
            
        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();

        return view('dashboards.organizer.index',['countNoti'=>$countNoti,'notifications'=>$notification, 'brgy'=>$barangay, 'event'=>$events], array('user' => Auth::user()));

    }
    
    public function barangay($id){
  
        $events = Facility::join('users','facility_management.user_id','users.id')->where('user_id', $id)->get();
        //Eventregister::join('facilities', 'event_register_detail.facility_id', 'facilities.facility_id')->where('event_register_detail.facility_id', $id)->get();
        

        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();

        return view('dashboards.organizer.brgy',['countNoti'=>$countNoti,'notifications'=>$notification, 'brgy'=>$events], array('user' => Auth::user()));
    }


    

    //Unused function?
    // public function form() {

    //     $data = Facility::all();

    //     $notification = Eventregister::join('facilities', 'event_register_detail.facility_id', '=', 'facilities.facility_id')
    //         ->where('event_register_detail.user_id', Auth::id())
    //         ->get();
       
    //     return view('dashboards.organizer.form', ['facilities'=>$data, 'notifications'=>$notification], array('user' => Auth::user()));
    // }


}


//Todo: create a function that stores the attendees to another table and display a description that will show in the visitor notification.
    //(Example: Name: Description: 'description'=>$request  'You have been kicked from the event') -> show to notifications
    //You can copy it from deleteRequest function here in OrganizerController.
    //Deadline til saturday. -Jonathan
    //Don't create this function anymore since the visitor has status that shows pending, approved, and denied same as the eventregisters function
    //We can just call the denied status and show it in the visitor notification.
    //- Jonathan