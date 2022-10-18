<?php

namespace App\Http\Controllers;

use App\Models\Proof;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    //For host payment option
    public function payment()
    {
        return view('guest.payment');
    }

    public function upload()
    {
        return view('guest.upload');
    }

    public function accounts()
    {
        return view('guest.userlist');
    }

    public function create(Request $request)
    {    
        $test = $request->validate([
            'firstname'     =>    ['required', 'string', 'max:50'],
            'lastname'      =>    ['required', 'string', 'max:50'],
            'email'         =>    ['required', 'string', 'max:50'],
            'brgy'          =>    ['required', 'string', 'max:120'],
            'payment'       =>    ['required', 'string', 'max:50'],
            'image'         =>    ['required', 'mimes:jpg,png,jpg', 'max:5048'],
        ]);
       
        if (!$request->has('image')) {
            return redirect()->back()->with('message','Please input picture of the facility');
        }
        
        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();

        $request->image->move(public_path('proof'), $newImageName);

        $test = Proof::create([
            'firstname'     => $request->input('firstname'),
            'lastname'      => $request->input('lastname'),
            'email'         => $request->input('email'),
            'brgy'          => $request->input('brgy'),
            'payment'       => $request->input('payment'),
            'image'         => $newImageName
        ]);

       
        return Redirect()->route('guest.upload')->with('success', "Submitted");
    }
  
}
