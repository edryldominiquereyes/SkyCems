<?php

namespace App\Http\Controllers;


use App\Models\Eventregister;
use Illuminate\Support\Facades\Auth;
use App\Models\Audit;
use App\Models\User;
use App\Notifications\BookNotification;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EventStatusController extends Controller
{
    //Display organizers reservation status
    public function index() {

        //Reminders:
        //ToCheck sql structure
        //Replace ->get to ->toSql();

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('status', 'Pending')
            ->get();

        $approved = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            //->join('users', 'eventregisters.user_id', '=', 'users.id')
            ->where('facility_management.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();
            
        $denies = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('status','Denied')
            ->get();

        $pending = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('status','Pending')
            ->paginate(5);

        //conflict = Carbon::now('Asia/Singapore')->format('Y-m-d');
        $conflict = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('status', 'Approved')
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();
        
        Eventregister::where('status','Approved')->where('end_datetime', '<' ,(Carbon::now('Asia/Manila')))->delete();
        
        Eventregister::where('status','Denied')->where('start_datetime', '<' ,(Carbon::now('Asia/Manila')))->forceDelete();
    
        return view('dashboards.host.eventstatus', ['countNoti'=>$countNoti,'conflict'=>$conflict,'datas'=>$noti,'approves' => $approved, 'pending'=>$pending, 'denies'=>$denies], array('user' => Auth::user()));
    }

    //Update reservation status of organizer to approved
    public function approve($id, Request $request){

        //Send emails to users that user is approved.
        $user = Eventregister::join('users', 'event_register_detail.user_id', '=', 'users.id')
            ->first();
         
        //Email content
        $bookData = [
            'greeting' => 'Hi '.$user->firstname.',',
            'body' => 'You received an new notification. Your reservation has been successfuly approved by ' . Auth::user()->firstname . 
            ' ' . Auth::user()->lastname.  ' ',
        ];

        //send emailNotification
        $user->notify(new BookNotification($bookData));

        //Get the Eventregister id
        $data = Eventregister::where('event_id', $id)->first();

        //Replace the status from 'Pending' to 'Approved'
        $data->status='Approved';

        //send live notification
        $ids = User::join('event_register_detail', 'users.id', '=','event_register_detail.user_id')
            ->where('users.role', 'organizer')
            ->first();

        $liveNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->first();
        
        $ids->notify(new UserNotification($liveNoti));
        
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Approved a visitor',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        //Save the data 
        $data->save();

        return Redirect()->route('status.index', ['data'=>$data])->with('success', $data->name."Status updated successfully!");
    }

    //Update reservation status of organizer to denied
    public function deny($id, Request $request){

        //Get the Eventregister id
        $data = Eventregister::where('event_id', $id)->first();
        //Replace the status from 'Pending' to 'Denied'
        $data->status='Denied';
        $test = $data->remark = $request->remark;

        //Send emails to users that user is approved.
        $user = Eventregister::join('users', 'event_register_detail.user_id', '=', 'users.id')->first();
        
        //Email content
        $bookData = [
            'greeting' => 'Hi '.$user->firstname.',',
            'body' => 'You received an new notification. Your reservation has been denied by the barangay. Remarks: ' . $data->remark . '',
        ];

        $user->notify(new BookNotification($bookData));

        //send live notification
        $ids = User::join('event_register_detail', 'users.id', '=','event_register_detail.user_id')
            ->where('event_register_detail.user_id', $id)
            ->first();

        $liveNoti = Eventregister::join('users', 'event_register_detail.user_id','=', 'users.id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->first();
        
        $ids->notify(new UserNotification($liveNoti));
     
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Denied a visitor',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        //Save the data
        $data->save();

        return Redirect()->route('status.index')->with('success', $data->name."Status updated successfully!");
    }

    //Delete organizer request
    public function delete($id){

        Eventregister::destroy($id);
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Deleted a request from organizer',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        return Redirect()->back()->with('delete', "Request has been deleted");
    }
}
