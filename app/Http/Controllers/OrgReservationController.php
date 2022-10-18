<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use App\Models\Facility;
use App\Models\Report;
use App\Models\Audit;
use App\Models\Orgrecord;
use App\Models\User;
use App\Notifications\BookNotification;
use App\Notifications\UserNotification;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrgReservationController extends Controller
{
    //Calendar view data
    public function calendar($id)
    {

        $events = array();
        $facility = Facility::findOrFail($id);

        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();

        $bookings = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.facility_id', $id)->where('event_register_detail.status', 'Pending')
            ->get();

        $bookingApproves = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.facility_id', $id)->where('event_register_detail.status', 'Approved')
            ->get();
        
        $listItem = Facility::where('facility_id', $id)->pluck('itemList')->first();

        foreach ($bookings as $booking) {
            $color = null;
            $color = '#F29339';
            $events[] = [
                'title'       => $booking->reason,
                'start'       => $booking->start_datetime,
                'end'         => $booking->end_datetime,
                'color'       => $color,
            ];
        }

        foreach ($bookingApproves as $bookingApprove) {
            $color = null;
            $color = '#008000';
            $events[] = [
                'title'       => $bookingApprove->reason,
                'start'       => $bookingApprove->start_datetime,
                'end'         => $bookingApprove->end_datetime,
                'color'       => $color,
            ];
        }

        return view('dashboards.organizer.calendar', ['listItem'=>$listItem,'countNoti'=>$countNoti,'events' => $events, 'facility' => $facility, 'facility_id' => $id, 'notifications' => $notification], array('user' => Auth::user()));
    }

    //Reserving a facility
    public function create(Request $request)
    {

        $test = $request->validate([
            'reason'            =>    ['required', 'string', 'max:50'],
            //'borrow'            =>    ['required'],
            'start_datetime'    =>    ['required', 'date', 'after:tomorrow'],
            'end_datetime'      =>    ['required', 'date', 'after:start_datetime'],
        ]);

        if (is_array($request->borrow)) {
            $arr = implode(',', $request->borrow);
        } else {
            $arr = 'None';
        }
        $book = Eventregister::create([
            'facility_id' => $request->input('facility_id'),
            'user_id'     => auth()->id(),
            'organizer'   => Auth::user()->firstname,
            'contact'     => Auth::user()->phone,
            'reason'      => $request->input('reason'),
            'borrow'      => $arr,
            'start_datetime'  => $request->input('start_datetime'),
            'end_datetime'    => $request->input('end_datetime'),
            'status'      => 'Pending',
        ]);

        //Notification to host via EMAIL

        //Send email to host that user is approved.

        //Get the event and facility foreign keys to get the user id email
        $user = Eventregister::Join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->join('users', 'facility_management.user_id', 'users.id')
            ->first();
            
        $notify = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->join('users', 'facility_management.user_id', '=', 'users.id')
            ->first();
        //Email content
        $bookData = [
            'greeting' => 'Hi ' . $user->firstname . ',',
            'body' => 'You received an new notification. You have pending reservation in the barangay from ' . $user->organizer .
                ', for ' . $user->reason . ', at ' . $user->start_datetime . ', ' . $user->end_datetime,
        ];

        //send emailNotification
        $user->notify(new BookNotification($bookData));

        //send live notification testing..
        $id = User::join('facility_management', 'users.id', '=','facility_management.user_id')->first();
        
        $liveNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->first();
        
        $id->notify(new UserNotification($liveNoti));

        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Reserved a facility',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        return redirect()->back()->with('success', 'Please wait for the host to approve your reservation.');
    }

    //Report facility
    public function report(Request $request)
    {

        $test = $request->validate([
            'issue' => ['required', 'string', 'max:150'],
        ]);

        Report::create([
            'facility_id' => $request->input('facility_id'),
            'user_id'     => auth()->id(),
            'issue' => $request->input('issue'),
        ]);
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Reported a facility',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        return redirect()->back()->with('success', 'Report Submitted');
    }
}
