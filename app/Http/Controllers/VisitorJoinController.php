<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use App\Models\Attendee;
use App\Models\Audit;
use App\Models\User;
use App\Notifications\UserNotification;
use App\Notifications\VisitorEmailNotification;
use App\Notifications\VisitorNotification;
use Carbon\Carbon;

use Illuminate\Http\Request;

class VisitorJoinController extends Controller
{
    //View the event info
    public function view($id) {

        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();

        $facility = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('status', 'Approved')
            ->where('facility_management.facility_id', $id)->get();

        //$data = Eventregister::find($id);

        $data = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
            ->where('event_register_detail.event_id', $id)->first();

        //Check user if exist
        $attendees = Attendee::where('event_id', $id)->get();
        
        $isAttended = Attendee::where('user_id', Auth::id())
            ->where('event_id', $id)
            ->first();
            
        $booked = Attendee::where('user_id',  Auth::id())->get();

        $count = Attendee::where('event_id', $id)->where('remark','Approved')->get()->count();

        return view('dashboards.visitor.attendee', [ 'isAttended'=> $isAttended, 'notifications'=>$notification,'id'=>$id,'books'=>$booked,'event_id'=>$id, 'data'=>$data, 'attendees'=>$attendees, 'count'=>$count, 'facility'=>$facility], array('user' => Auth::user()));
    }

    //Join the event -> stores it to the database
    public function store(Request $request){

        $join = Attendee::create([
            'event_id'  => $request->input('event_id'),
            'user_id'   => Auth()->id(),
            'firstname' => Auth::user()->firstname,
            'lastname'  => Auth::user()->lastname,
            'phone'     => Auth::user()->phone,
            'email'     => Auth::user()->email,
            'address'   => Auth::user()->address,
            'remark'    => 'Pending',
        ]);

        //Notification to host via EMAIL

        //Send email to host that user is approved.

        //Get the event and facility foreign keys to get the user id email
        $user = Eventregister::join('users', 'event_register_detail.user_id','=', 'users.id')
            ->first();
   
        //Email content
        $notify = [
            'greeting' => 'Hi ' . $user->organizer . ',',
            'body' => 'You received an new notification. You have pending attendees in the barangay ' .  Auth::user()->firstname . ' ' .  Auth::user()->lastname,
        ];

        //send emailNotification
        $user->notify(new VisitorEmailNotification($notify));

        //send live notification testing..
        $ids = User::join('event_register_detail', 'users.id', '=','event_register_detail.user_id')
            ->first();
    
        $localMailVisitor = Attendee::join('users', 'attendees.user_id', '=', 'users.id')
            ->join('event_register_detail', 'attendees.event_id','=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->first();
        
        $ids->notify(new VisitorNotification($localMailVisitor));
        
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Join an event',
            'date' => Carbon::now('Asia/Manila'),
        ]);
      
        return redirect()->back()->with('success','You have succesfully requested to join to this event. Note you are not yet approved please visit the page again.');
    }

    //leave event = delete
    public function cancel($id){
//Notification to host via EMAIL

        //Send email to host that user is approved.

        //Get the event and facility foreign keys to get the user id email
        $user = Eventregister::join('users', 'event_register_detail.user_id','=', 'users.id')
            ->first();
   
        //Email content
        $notify = [
            'greeting' => 'Hi ' . $user->organizer . ',',
            'body' =>  'You received an new notification. ' .  Auth::user()->firstname . ' ' .  Auth::user()->lastname .' has left the event in the barangay' ,
        ];

        //send emailNotification
        $user->notify(new VisitorEmailNotification($notify));

        Attendee::destroy($id);

        return  Redirect()->back()->with('success', "You have left the event.");
    }
}
