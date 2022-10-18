<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Attendee;
use App\Models\User;
use App\Models\Audit;
use Carbon\Carbon;

use Illuminate\Http\Request;

class VisitorProfileController extends Controller
{
    //View profile
    public function index(){
        $notification = Attendee::join('event_register_detail', 'attendees.event_id', '=', 'event_register_detail.event_id')
            ->join('facility_management', 'event_register_detail.facility_id', '=', 'facility_management.facility_id')
            ->where('attendees.user_id', Auth::id())
            ->where('event_register_detail.status', 'Approved')
            ->get();

        return view('dashboards.visitor.profile',['notifications'=>$notification], array('user' => Auth::user()));
    }

    //Update profile visitor
    public function update(Request $request){
        
        $validateData = $request->validate([
            'avatar'    => ['mimes:jpg,png,jpeg', 'max:10240'],
        ]);

        if ($request->hasFile('avatar')) {
            $newImageName = time() . '-' . $request->name . '.' . $request->avatar->extension();
        
            $request->avatar->move(public_path('/uploads/avatars/'), $newImageName);
            $update = User::find(Auth::user()->id)->update([
                'avatar'    => $newImageName,
            ]);
        }elseif(file_exists( public_path('/uploads/avatars/'))){
            $update = User::find(Auth::user()->id)->update([
                'firstname' =>  $request['firstname'],
                'lastname'  =>  $request['lastname'],
                'address'   =>  $request['address'],
                'phone'     =>  $request['phone'],
                'email'     =>  $request['email'],
            ]);
        }
        //For audit logs (Admin)
        $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Update profile',
            'date' => Carbon::now('Asia/Manila'),
        ]);
        return redirect()->back()->with('success','Profile Updated Successfully');
    }

    //Update password of visior
    public function updatePassword(Request $request){
        
        $validateData = $request->validate([
            'old_password'     => ['required'],
            'password'         => ['required', 'min:8'],
            'confirm_password' => ['required','same:password']
        ]);

        //Since the password is hashed I created this logic where Hash checks the $request(the inputs) to old_password and check it again the $data variable
        //then it will now get the new password and save it in the database. -Jonathan
        $data = Auth::user()->password;
        if(Hash::check($request->old_password, $data)){
            $user = User::find(Auth::id());
            $user ->password = Hash::make($request->password);
            //For audit logs (Admin)
            $test = Audit::create([
            'user_id'    => Auth()->id(),
            'audit_desc' =>  'Changes password',
            'date' => Carbon::now('Asia/Manila'),
            ]);
            $user->save();
    
            return redirect()->back()->with('success','Profile password updated successfully');
        }else{
            return redirect()->back()->with('error','Current password is invalid');
        }
    }

}
