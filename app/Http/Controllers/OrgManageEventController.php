<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use App\Models\Attendee;
use App\Models\Feedback;
use App\Models\Audit;
use App\Notifications\BookNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrgManageEventController extends Controller
{
    //View your registered event and manage event with view button that redirectTo viewEvent.
    public function index(){

        $data = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->where('status', 'Approved')
            ->get();

        $attendees = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')->get();


        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->get();
        
        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();

        return view('dashboards.organizer.eventmanage', ['countNoti'=>$countNoti,'events'=>$data, 'attendees'=>$attendees, 'notifications'=>$notification], array('user' => Auth::user()));
    }

    //View attendees and feedback from the event
    public function view($id){

        $attendees = Attendee::where('event_id', $id)->where('remark','Pending')->get();

        $denied = Attendee::where('event_id', $id)->where('remark','Denied')->get();

        $approved = Attendee::where('event_id', $id)->where('remark', 'Approved')->get();

        $feedback = Feedback::where('event_id', $id)->get();

        $count = Attendee::where('event_id', $id)->where('remark','Approved')->get()->count();

        $capacity = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
            ->where('event_id', $id)->first();
            
        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();
        
        return view('dashboards.organizer.view', ['countNoti'=>$countNoti,'capacity'=>$capacity,'count'=>$count,'attendees'=>$attendees, 'approve'=>$approved, 'denied'=>$denied, 'feedbacks'=>$feedback,'notifications'=>$notification], array('user' => Auth::user()));

    }

    public function attendeeList($id){

        $capacity = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
            ->where('event_id', $id)->first();

        $approved = Attendee::where('event_id', $id)->where('remark', 'Approved')->get();

        $count = Attendee::where('event_id', $id)->where('remark','Approved')->get()->count();

        $feedback = Feedback::where('event_id', $id)->get();

        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
        ->where('event_register_detail.user_id', Auth::id())
        ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();

        return view('dashboards.organizer.attendeeList', ['countNoti'=>$countNoti,'capacity'=>$capacity,'count'=>$count,'approve'=>$approved, 'feedbacks'=>$feedback, 'notifications'=>$notification], array('user' => Auth::user()));
    }

    //Approved visitor 
    public function approve($id, Request $request){
        
        //Get the Eventregister id
        $data = Attendee::where('id', $id)->first();
        //Replace the status from 'Pending' to 'Approved'
        $data->remark='Approved';
        $test = $data->comment = $request->comment;
        
        $data = $request->ids;
        Attendee::whereIn('id', $data)->get();

        //Send emails to users that user is approved.
        $user = Attendee::find($id);

        //Email content
        $bookData = [
            'greeting' => 'Hi '.$user->firstname.',',
            'body' => 'You received an new notification. Your reservation has been successfuly approved by ' . Auth::user()->firstname . 
            ' ' . Auth::user()->lastname.  ' ',
        ];

        //send emailNotification
        $user->notify(new BookNotification($bookData));

        //send notification
        // $localMailVisitor = Eventregister::join('event_register_detail', 'attendees.event_id','=', 'event_register_detail.event_id')
        //     ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
        //     ->first();
        
        // $data->notify(new VisitorController($localMailVisitor));
   
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Approved a visitor',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        //Save the data 
        $data->save();

        return  Redirect()->back()->with('success', $data->name."Status updated successfully!");
    }

     //Deny visitor 
     public function deny($id, Request $request){
        
        //Get the Eventregister id
        $data = Attendee::where('id', $id)->first();
        //Replace the status from 'Pending' to 'Approved'
        $data->remark='Denied';
        $test = $data->comment = $request->comment;

        //Send emails to users that user is approved.
        $user = Attendee::find($id);

        //Email content
        $bookData = [
            'greeting' => 'Hi '.$user->firstname.',',
            'body' => 'You received an new notification. Your reservation has been denied by the barangay. Remarks: ' . $data->comment . '',
        ];

        $user->notify(new BookNotification($bookData));

        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Denied a visitor',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        //Save the data 
        $data->save();

        return  Redirect()->back()->with('success', $data->name."Status updated successfully!");
    }

    //Delete attendee
    public function delete($id){

        Attendee::destroy($id);

        return Redirect()->back()->with('delete', "visitor has been removed");

    }

    //Delete feedback from the event
    public function deleteFeedback($id){

        Feedback::destroy($id);

        return Redirect()->back()->with('delete', "Feedback deleted");

    }
}
