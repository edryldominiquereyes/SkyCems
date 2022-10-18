<?php

namespace App\Http\Controllers;

use App\Events\MessageNotification;
use App\Models\Eventregister;
use App\Models\User;
use App\Models\Facility;
use App\Notifications\BookNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    //View host dashboard
    public function index() {

        event(new MessageNotification('hello world'));

        $users = Facility::where('user_id', Auth::id())->get();
 
        $data = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();

        //$notifications = auth()->user()->unreadNotifications;
            
        $facility = Facility::where('user_id', Auth::id())->get();

        $countFacility = Facility::where('user_id', Auth::id())->count();

        $approvedEvent = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('event_register_detail.status','Approved')
            ->count();

        $pendingEvent = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('event_register_detail.status','Pending')
            ->count();

        $userTime = User::select('created_at')
            ->get();


        $now = Carbon::now('Asia/Manila');
        return view('dashboards.host.index',['nowTime' => $now,'countNoti'=>$countNoti,'facility'=>$countFacility,'approved'=>$approvedEvent,'pending'=>$pendingEvent, 'datas'=>$data,'users'=>$users, 'event'=>$facility], array('user' => Auth::user()));
    }
    
    //Delete userHost in adminPage
    public function deleteUser($id){

        $user = User::find($id);

        $bookData = [
            'body' => 'Your account has been Deleted by the admin. If you have any question please email skycems09@gmail.com',
            'bookText' => 'Go back to website',
            'url' => url('/'),
            'thankyou' => 'Thank you!'
        ];
    
        $user->notify(new BookNotification($bookData));
        
        User::destroy($id);
        
        return Redirect()->route('admin.dashboard')->with('delete', "User has been deleted");

    }

    // public function payment(){

    //     $data = Eventregister::join('facilities', 'event_register_detail.facility_id', '=', 'facilities.facility_id')
    //     ->where('facilities.user_id', Auth::id())->where('status', 'Pending')
    //     ->get();

    //     return view('dashboards.host.payment',['datas'=>$data], array('user'=>Auth::user()));
    // }

    //View host report
    // public function report($id){
    //     //Count registered events by org
    //     $data = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
    //         ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
    //         ->get();

    //     $countFacility = Facility::where('user_id', Auth::id())->count();

    //     $approvedEvent = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
    //         ->where('facility_management.user_id', Auth::id())
    //         ->where('event_register_detail.status','Approved')
    //         ->count();

    //     $pendingEvent = Eventregister::join('facility_management', 'event_register_detail.facility_id', 'facility_management.facility_id')
    //         ->where('facility_management.user_id', Auth::id())
    //         ->where('event_register_detail.status','Pending')
    //         ->count();

    //     $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
    //         ->where('event_register_detail.user_id', Auth::id())
    //         ->get();

    //     return view('dashboards.host.report',['datas'=>$data,'facility'=>$countFacility,'approved'=>$approvedEvent,'pending'=>$pendingEvent, 'notifications'=>$notification], array('user' => Auth::user()));
    // }

}

