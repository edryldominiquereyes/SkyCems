<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\Captcha;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname'     => ['required', 'regex:/^[a-zA-Z]+$/u', 'string', 'max:50'],
            'lastname'      => ['required', 'regex:/^[a-zA-Z]+$/u', 'string', 'max:50'],
            'brgy'          => ['nullable', 'regex:/^(\d|\w)+$/','string', 'max:255'],
            'address'       => ['nullable', 'regex:/^(\d|\w)+$/','string', 'max:255'],
            'proofPayment'  => ['nullable', 'mimes:jpg,png,jpg', 'max:5048'],
            'phone'         => ['required', 'regex:/^(09|\+639)\d{9}$/' ,'min:11', 'max:11', 'unique:users'],
            'role'          => ['required', 'string','max:20'],
            'terms_and_conditions' => ['required'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            'g-recaptcha-response' => new Captcha(),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    { 
        $newImageName = null;
        $request = app('request');
        if($request->hasfile('proofPayment')){
            $newImageName = time() . '-' . $request->name . '.' . $request->proofPayment->extension();
            $request->proofPayment->move(public_path('proof'), $newImageName);
        }

        if($request->hasfile('brgyID')){
            $newbrgyID = time() . '-' . $request->name . '.' . $request->brgyID->extension();
            $request->brgyID->move(public_path('proof'), $newbrgyID);
        }

        return User::create([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'address'   => $data['address'],
            'proofPayment' => $newImageName,
            'brgyID'    => $newbrgyID,
            'phone'     => $data['phone'],
            'role'      => $data['role'],
            'terms_and_conditions' =>$data['terms_and_conditions'],
            'email'     => $data['email'],
            'brgy'      => $data['brgy'],
            'status'    => false,
            'password'  => Hash::make($data['password']),
        ]);
 
    }

    // public function Registration(){
        
    //     return view('auth.host-registration');
    // }

}
