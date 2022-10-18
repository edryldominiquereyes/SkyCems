<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Eventregister;
use App\Models\Audit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrgManageStatusController extends Controller
{
    //View Manage Reservation Status
    public function index(Request $request) {

        $eventreg = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->paginate(8);

        $notification = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->get();

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())->where('event_register_detail.status', 'Approved')
            ->count();
        
        $query = Eventregister::query();
        if($request->ajax()){
            $event = $query->where(['event_id'=>$request->filter])->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();
            return response()->json(['events'=>$event]);
        }
        $filter = $query->get();

        $filter = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('event_register_detail.user_id', Auth::id())
            ->get();
       
        Eventregister::where('status','Approved')->where('end_datetime', '<' ,(Carbon::now('Asia/Manila')))->delete();

        Eventregister::where('status','Denied')->where('start_datetime', '<' ,(Carbon::now('Asia/Manila')))->forceDelete();

        Eventregister::where('status','Pending')->where('start_datetime', '<' ,(Carbon::now('Asia/Manila')))->forceDelete();

        return view('dashboards.organizer.manage', ['filter'=>$filter,'countNoti'=>$countNoti,'events'=>$eventreg, 'notifications'=>$notification], array('user' => Auth::user()));
    }

    //From Manage Reservation Status -> Record Reservation.
    //Delete registered(From Manage Reservation Status) events and copy the deleted data passing it to another table in the database. <-- Removed
    //Changes to softDelete
    public function delete($id){

        //$datetime1 = Eventregister::select('start_datetime')->get();
        
        Eventregister::where('event_id', $id)->delete();

        //$reservation = Eventregister::where('event_id', $id)->first();
        //For reservation records(Org)
        // $test = Orgrecord::insert([
        //     'user_id' => Auth()->id(),
        //     'name'    =>  $reservation->organizer,
        //     'contact' => $reservation->contact, 
        //     'date'    => $reservation->start_datetime,
        //     'description' => $reservation->reason,
        // ]);
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Deleted a event',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        
        //$reservation->delete();

        return Redirect()->back()->with('delete', "Your event is done!");
    }

    public function cancel($id){
        
        $record = Eventregister::where('event_id', $id)->forceDelete();

        return Redirect()->back()->with('delete', "Request has been deleted");
    }
}
