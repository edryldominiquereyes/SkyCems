<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use App\Models\Attendee;
use App\Models\Feedback;
use App\Models\Audit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorEventController extends Controller
{
    //View Joined events in visitor
    public function index(){
        
        $notification = Eventregister::join('attendees', 'event_register_detail.event_id', '=', 'attendees.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->withoutTrashed()
            ->get();

        $event = Eventregister::join('attendees', 'event_register_detail.event_id', '=', 'attendees.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('attendees.remark', 'Approved')
            ->where('event_register_detail.status', 'Approved')
            ->withoutTrashed()
            ->paginate(5);
            
        $records = Eventregister::join('attendees', 'event_register_detail.event_id', '=', 'attendees.id')
            ->where('attendees.id', Auth::id())
            ->withTrashed()
            ->paginate(5);

        $todayDate = Carbon::now('Asia/Manila')->format('Y-m-d');

        return view('dashboards.visitor.events',['records'=>$records,'notifications'=>$notification, 'events'=>$event, 'todayDates'=>$todayDate], array('user' => Auth::user()));
    }

    public function view($id){

        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();

        $data = Eventregister::where('id',$id);

        return view('dashboards.visitor.feedback',['event_id'=>$id,'events'=>$data, 'notifications'=>$notification], array('user' => Auth::user()));
    }

    public function store(Request $request){
        
        if($request->validate)([
            'rating'    =>    ['required', 'string', 'max:50'],
            'comments'  =>    ['required', 'string'],
        ]);

        $test = Feedback::create([
            'event_id' => $request->input('event_id'),
            'user_id'  => Auth()->id(),
            'rating'   => $request->input('rating'),
            'comment'  => $request->input('comment'),
        ]);
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Submitted a feedback',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        return Redirect()->route('manage_event.index', array('user' => Auth::user()))->with('success','Feedback submitted');
    }

    // public function records($id){
    //     Attendee::join('event_register_detail', 'attendees.id', '=', 'event_register_detail.event_id')
    //         ->where('attendees.id', Auth::id())
    //         ->get();

        
    // }
}
