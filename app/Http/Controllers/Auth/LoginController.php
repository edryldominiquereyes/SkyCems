<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Eventregister;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo(){
        
        if( Auth()->user()->role == 'admin')
        {
            return route('admin.dashboard');
        }
        else if( Auth()->user()->role == 'host')
        {
            return route('host.index');
        }
        else if( Auth()->user()->role == 'visitor')
        {
            return route('visitor.index');
        }
        else if( Auth()->user()->role == 'organizer')
        {
            return route('organizer.index');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

        $input =  $request->all();
        $this  -> validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if( auth()->attempt(array('email'=>$input['email'], 'password'=>$input['password'])))
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
        else
        {
            return redirect()->route('login')->with('message','Email or Password is incorrect');
        }
    }
}


