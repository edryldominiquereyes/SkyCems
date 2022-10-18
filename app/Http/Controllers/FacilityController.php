<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Audit;
use App\Models\Eventregister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FacilityController extends Controller
{
    //Create Facility
    public function create(Request $request)
    {
        $test = $request->validate([
            'facility'      =>    ['required', 'string', 'max:50'],
            'description'   =>    ['required', 'string', 'max:120'],
            'address'       =>    ['required', 'string'],
            'lat'           =>    ['required', 'numeric'],
            'lng'           =>    ['required', 'numeric'],
            'capacity'      =>    ['required', 'integer', 'max:200', 'min:0'],
            'image'         =>    ['required', 'mimes:jpg,png,jpeg', 'max:10240'],
        ]);

        if (is_array($request->itemList)) {
            $arr = implode(',', $request->itemList);
        } else {
            $arr = 'None';
        }

        if (!$request->has('image')) {
            return redirect()->back()->with('message', 'Please input picture of the facility');
        }

        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();

        $request->image->move(public_path('image'), $newImageName);

        $create = Facility::create([
            'user_id'       => auth()->id(),
            'facility'      => $request->input('facility'),
            'description'   => $request->input('description'),
            'address'       => $request->input('address'),
            'lat'           => $request->input('lat'),
            'lng'           => $request->input('lng'),
            'itemList'      => $arr,
            'capacity'      => $request->input('capacity'),
            'image'         => $newImageName
        ]);

        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Added a facility',
            'date' => Carbon::now('Asia/Manila'),
        ]);

        return Redirect()->route('facility.index', array('user' => Auth::user()))->with('success', "Added");
    }

    //View Facility page
    function index()
    {

        $data = Facility::where('user_id', Auth::id())->get();

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();
        
            $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();

        return view('dashboards.host.add', ['countNoti'=>$countNoti,'facilities' => $data, 'datas' => $noti], array('user' => Auth::user()));
    }

    //Store new facility
    public function store()
    {
        $data = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();
        
        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();
        return view('dashboards.host.facility', ['countNoti'=>$countNoti,'datas' => $data], array('user' => Auth::user()));
    }



    //Update facility
    public function update(Request $request)
    {
        $data = Facility::find($request->id);

        if (is_array($request->itemList)) {
            $arr = implode(',', $request->itemList);
        } else {
            $arr = 'None';
        }
        $data->facility    =   $request->facility;
        $data->description =   $request->description;
        $data->address     =   $request->address;
        $data->lat         =   $request->lat;
        $data->lng         =   $request->lng;
        $data->capacity    =   $request->capacity;
        $data->itemList    =   $arr;

        if ($request->hasFile('image')) {
            $destination = 'image' . $data->image;
            $file        =  $request->file('image');
            $extension   =  $file->getClientOriginalExtension();
            $filename    =  time() . '.' . $extension;
            $file->move('image', $filename);
            $data->image = $filename;
        }

        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Updated a Facility',
            'date'       => Carbon::now('Asia/Manila'),
        ]);

        $data->update();

        return Redirect()->route('facility.index', array('user' => Auth::user()))->with('success', "Facility Updated");
    }

    //Update facility
    public function edit($id)
    {

        $data = Facility::find($id);

        $countNoti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->count();

        $noti = Eventregister::join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('facility_management.user_id', Auth::id())->where('status', 'Pending')
            ->get();

        return view('dashboards.host.edit', ['countNoti'=>$countNoti,'facilities' => $data, 'datas' => $noti], array('user' => Auth::user()));
    }

    //Delete facility
    public function delete($id)
    {

        Facility::destroy($id);

        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Deleted a Facility',
            'date' => Carbon::now('Asia/Manila'),
        ]);

        return Redirect()->route('facility.index')->with('delete', "Facility has been deleted");
    }
}
