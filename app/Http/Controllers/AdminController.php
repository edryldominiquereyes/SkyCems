<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\User;
use App\Models\Report;
use App\Models\Audit;
use App\Models\Proof;
use App\Notifications\AccountNotification;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    //dashboard (homepage)
    public function index() {

        $users = User::where('role', 'host')->paginate(5);

        //$proof = Proof::all();
        return view('dashboards.admin.index', ['users' => $users]);

    }

    //Active and Inactive host accounts
    public function status(Request $request, $id){

        $data = User::find($id);

       
        
        if($data->status == 0) 
        {
            $user = User::find($id);

            $accountData = [
                'body' => 'Your account has been approved',
                'buttonText' => 'Login',
                'url' => url('/'),
                'end' => 'Thank you!'
            ];
        
            $user->notify(new AccountNotification($accountData));

            $data->status=1;
        }
        else
        {
            $user = User::find($id);

            $accountData = [
                'body' => 'Your account has been Denied. If you have any question please email skycems09@gmail.com',
                'buttonText' => 'Go back to the website',
                'url' => url('/'),
                'end' => 'Thank you!'
            ];
        
            $user->notify(new AccountNotification($accountData));

            $data->status=0;
        }

        $data->save();

        return Redirect()->route('admin.dashboard')->with('message', $data->name." Status has been changed successfully!");
    }

    //Delete Host Account
    public function delete($id){

        $user = User::find($id);

        $bookData = [
            'body' => 'Your account has been Deleted by the admin. If you have any question please email skycems09@gmail.com',
            'bookText' => 'Go back to website',
            'url' => url('/'),
            'thankyou' => 'Thank you!'
        ];
    
        $user->notify(new AccountNotification($bookData));
 
        User::destroy($id);

        return Redirect()->route('admin.dashboard')->with('message', "User has been deleted");
        
    }

    //view listingReport
    public function view(){
        //$data = Facility::all();

        $data = Facility::join('users', 'facility_management.user_id', '=', 'users.id')->paginate(3);

        return view('dashboards.admin.view',['facilities'=>$data], array('user' => Auth::user()));
    }

    //View facility in report page
    public function report(){

        //$data = Facility::all();

        $data = Facility::join('users', 'facility_management.user_id', '=', 'users.id')->paginate(3);

        return view('dashboards.admin.report',['facilities'=>$data], array('user' => Auth::user()));
    }

    //View reports
    public function viewReport($id){

        $data = Facility::join('users', 'facility_management.user_id', '=', 'users.id')
            ->where('facility_id', $id)
            ->get();

        $report = Report::join('facility_management', 'report_listing.facility_id', '=', 'facility_management.facility_id')
            ->join('users', 'report_listing.user_id', '=', 'users.id')
            ->where('facility_management.facility_id', $id)
            ->get();

        return view('dashboards.admin.viewReport',['reports'=>$data, 'view'=>$report], array('user' => Auth::user()));
    }

    //delete facility
    public function deleteFacility($id){

        Facility::destroy($id);

        return Redirect()->route('admin.view')->with('message', "Facility has been deleted");
    }

    public function audit(){
       
        $logs = Audit::join('users', 'audits.user_id', '=', 'users.id')->orderBy('audits.audit_id', 'DESC')->paginate(10);
        

        return view('dashboards.admin.audit',['log'=>$logs], array('user' => Auth::user()));
    }

    public function deleteLogs($id){

        Audit::destroy($id);
        
        return redirect()->back()->with('success','Deleted');
    }

    public function proof(){

        return view('dashboards.admin.proof', array('user' => Auth::user()));
    }

    public function deleteProof($id){
        Proof::destroy($id);

        return redirect()->back()->with('success','Deleted');
    }
}
