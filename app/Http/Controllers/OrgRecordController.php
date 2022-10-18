<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use App\Models\Orgrecord;
use Illuminate\Http\Request;

class OrgRecordController extends Controller
{
    //View Record Reservation
    public function index(Request $request) {

        //$record = Orgrecord::where('user_id', Auth::id())->get();

        $record = Eventregister::where('user_id', Auth::id())->onlyTrashed()->get();

        $eventreg = Eventregister::withTrashed()->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();
        
        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();
        
        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();
       
        return view('dashboards.organizer.record',['countNoti'=>$countNoti,'events'=>$eventreg,'records'=> $record, 'notifications'=>$notification], array('user' => Auth::user()));
    }

    //Delete organizer record reservation
    public function delete($id){

        $record = Eventregister::where('event_id', $id)->forceDelete();

        return Redirect()->back()->with('delete', "Record has been deleted");
    }
}
