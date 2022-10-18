<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Eventregister;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Authentication and roles     
        //If host redirect to host.index
        if( auth()->user()->role == 'host')
        {
            
                $test = Audit::create([
                    'user_id'    => Auth()->id(),
                    'audit_desc' =>  'Login',
                    'date' => Carbon::now('Asia/Manila'),
                ]);
                return redirect()->route('host.index');
            // if( auth()->user()->status == 1)
            // {
            // }
            // else
            // {
            //     auth()->logout();
            //     return redirect()->route('login')->with('message','Error: Account is not activated. Please try again later');
            // }
        }
        if( auth()->user()->status == 0)
        {
            if( auth()->user()->role == 'admin')
            {
                return redirect()->route('admin.dashboard');
            }
            elseif( auth()->user()->role == 'visitor')
            {
                $test = Audit::create([
                    'user_id'    => Auth()->id(),
                    'audit_desc' =>  'Login',
                    'date' => Carbon::now('Asia/Manila'),
                ]);
                return redirect()->route('visitor.index');
            }
            elseif( auth()->user()->role == 'organizer')
            {
                $test = Audit::create([
                    'user_id'    => Auth()->id(),
                    'audit_desc' =>  'Login',
                    'date' => Carbon::now('Asia/Manila'),
                ]);
                return redirect()->route('organizer.index');   
            }
        }
        else
        {
            auth()->logout();
            return redirect()->route('login')->with('message','Error: Account is not activated. Please try again later');
        }
    }
}
