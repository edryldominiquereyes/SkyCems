<?php

namespace App\Http\Controllers;
use App\Models\Eventregister;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendee;
use App\Models\Feedback;
use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HostLogController extends Controller
{
    //View reservation logs
    public function index(){

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();

        $data = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            //->join('users', 'event_register_detail.user_id', '=', 'users.id')
            ->where('event_register_detail.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            //->where('users.role', 'organizer')
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();
            
        return view('dashboards.host.logs',['countNoti'=>$countNoti,'logs'=>$data,'datas'=>$noti], array('user' => Auth::user()));
    }

    //View attendee list and feedbacks
    public function view($id){

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();

        $attendees = Attendee::where('event_id', $id)->where('remark','Pending')->get();

        $approved = Attendee::where('event_id', $id)->where('remark', 'Approved')->get();

        $denied = Attendee::where('event_id', $id)->where('remark', 'Denied')->get();

        $feedback = Feedback::where('event_id', $id)->get();

        $count = Attendee::where('event_id', $id)->where('remark','Approved')->get()->count();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();

        $capacity = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
            ->where('event_id', $id)->first();
        
        return view('dashboards.host.view', ['countNoti'=>$countNoti,'denied'=>$denied,'capacity'=>$capacity,'count'=>$count,'attendees'=>$attendees, 'approve'=>$approved, 'feedbacks'=>$feedback, 'datas'=>$noti], array('user' => Auth::user()));

    }

    //Approved visitor 
    public function approve($id){
        
        //Get the Eventregister id
        $data = Attendee::where('id', $id)->first();
        //Replace the status from 'Pending' to 'Approved'
        $data->remark='Approved';
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
     public function deny($id){
        
        //Get the Eventregister id
        $data = Attendee::where('id', $id)->first();
        //Replace the status from 'Pending' to 'Approved'
        $data->remark='Denied';
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

    //Delete host reservation
    public function delete($id){

        Eventregister::destroy($id);

        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Deleted a reservation',
            'date' => Carbon::now('Asia/Manila'),
        ]);
            
        return Redirect()->back()->with('delete', "Your reservation has been deleted");

    }

    //Delete attendee
    public function deleteAttendee($id){

        Attendee::destroy($id);

        return Redirect()->back()->with('delete', "visitor has been removed");

    }

    //Delete feedback from the event
    public function deleteFeedback($id){

        Feedback::destroy($id);

        return Redirect()->back()->with('delete', "Feedback deleted");

    }
}
