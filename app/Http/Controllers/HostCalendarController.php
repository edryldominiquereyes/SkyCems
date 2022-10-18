<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HostCalendarController extends Controller
{
     //Book facility view page
     public function index() {

        $data = Facility::where('user_id', Auth::id())->get();

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())
            ->where('status', 'Pending')
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();

        return view('dashboards.host.book', ['countNoti'=>$countNoti,'datas'=>$noti,'facilities'=>$data], array('user' => Auth::user()));

    }

    //Calendar view data
    public function view($id) {

        $events = array();

        $data = Facility::find($id);

        $bookings = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.facility_id', $id)->where('event_register_detail.status', 'Pending')->get();

        $bookingApproves = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.facility_id', $id)->where('event_register_detail.status', 'Approved')
            ->get();

        $facility = Facility::all();

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();

        foreach($bookings as $booking) {
            $color = null;
            $color = '#F29339';
            $events[] = [
                'title'  => $booking ->  reason,
                'start'  => $booking ->  start_datetime,
                'end'    => $booking ->  end_datetime,
                'color'  => $color,
            ];
        }

        foreach($bookingApproves as $bookingApprove) {
            $color = null;
            $color = '#008000';
            $events[] = [
                'title'  => $bookingApprove ->  reason,
                'start'  => $bookingApprove ->  start_datetime,
                'end'    => $bookingApprove ->  end_datetime,
                'color'  => $color,
            ];
        }

        return view('dashboards.host.calendar', ['countNoti'=>$countNoti,'events' => $events, 'rooms' => $facility, 'facility_id'=>$id,'datas'=>$noti,'maps'=>$data], array('user' => Auth::user()));
    }

    //Host facility reservation
    public function create(Request $request) {
    
        $test = $request->validate([
            'reason'         =>    ['required', 'string', 'max:120'],
            'start_datetime' =>    ['required', 'date', 'after:tomorrow'],
            'end_datetime'   =>    ['required', 'date', 'after:start_datetime'],
        ]);

        $test = Eventregister::create([
            'facility_id' => $request->input('facility_id'),
            'user_id'     => auth()->id(),
            'organizer'   => Auth::user()->firstname,
            'contact'     => Auth::user()->phone,
            'reason'      => $request->input('reason'),
            'borrow'      => 'None',
            'start_datetime'  => $request->input('start_datetime'),
            'end_datetime'    => $request->input('end_datetime'),
            'status'      => 'Approved',
        ]);
        
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Reserve a facility',
            'date' => Carbon::now('Asia/Manila'),
        ]);

        return redirect()->back()->with('success','Reservation Success!');
    }
    
}
