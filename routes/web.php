<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventStatusController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HostCalendarController;
use App\Http\Controllers\HostLogController;
use App\Http\Controllers\HostProfileController;
use App\Http\Controllers\OrgManageEventController;
use App\Http\Controllers\OrgManageStatusController;
use App\Http\Controllers\OrgProfileController;
use App\Http\Controllers\OrgRecordController;
use App\Http\Controllers\OrgReservationController;
use App\Http\Controllers\VisitorEventController;
use App\Http\Controllers\VisitorJoinController;
use App\Http\Controllers\VisitorProfileController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function (){
    Auth::routes(['verify'=>true]);
});


Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('markAsRead', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markRead');

//----------------------------------------------Start of guest routes-------------------------------------------------------------

//Upload Proof of payment for Host
Route::group(['prefix'=>'guest'], function(){
    Route::get('payment', [GuestController::class, 'payment'])->name('guest.payment');
    Route::get('upload', [GuestController::class, 'upload'])->name('guest.upload');
    Route::post('create', [GuestController::class, 'create'])->name('guest.create');
    Route::get('accounts', [GuestController::class, 'accounts'])->name('guest.accounts');
});

//----------------------------------------------End of guest routes---------------------------------------------------------------
//----------------------------------------------Start of admin routes-------------------------------------------------------------

//Admin
Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin', 'auth', 'PreventBackHistory']], function(){
    // View page
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('view', [AdminController::class, 'view'])->name('admin.view');
    Route::get('report', [AdminController::class, 'report'])->name('admin.report');
    Route::get('audit', [AdminController::class, 'audit'])->name('admin.audit');
    // Status of host
    Route::get('status/{id}', [AdminController::class, 'status'])->name('status');
    //Delete host account
    Route::get('deleteUser/{id}', [HostController::class, 'deleteUser'])->name('deleteUser');
    //Delete host facility
    Route::get('deleteFacility/{id}', [AdminController::class, 'deleteFacility'])->name('deleteFacility');
    //Manage reports
    Route::get('viewReport/{id}', [AdminController::class, 'viewReport'])->name('admin.viewReport');
    //Delete logs 
    Route::get('deleteLogs/{id}', [AdminController::class, 'deleteLogs'])->name('admin.deleteLogs');
    //Delete Proof of payments
    Route::get('deleteProof/{id}', [AdminController::class, 'deleteProof'])->name('admin.deleteProof');
    
});       

//----------------------------------------------End of admin routes---------------------------------------------------------------
//----------------------------------------------Start of host routes--------------------------------------------------------------

//Host
Route::group(['prefix'=>'host', 'middleware'=>['isHost', 'auth', 'PreventBackHistory', 'verified']], function(){
    // View page
    Route::get('index', [HostController::class, 'index'])->name('host.index');
});

//Facility Controller 
Route::group(['prefix'=>'facility', 'middleware'=>['isHost', 'auth', 'PreventBackHistory', 'verified']], function(){
    //Create new facility
    Route::post('create', [FacilityController::class, 'create'])->name('facility.create');
    Route::get('store', [FacilityController::class, 'store'])->name('facility.store');
    //View facility
    Route::get('index',[FacilityController::class, 'index'])->name('facility.index');
    //Update facility
    Route::put('update', [FacilityController::class, 'update'])->name('facility.update');
    Route::get('edit/{id}', [FacilityController::class, 'edit'])->name('facility.edit');
    //Delete Facility
    Route::get('delete/{id}', [FacilityController::class, 'delete'])->name('facility.delete');
});

//Event Status 
Route::group(['prefix'=>'status', 'middleware'=>['isHost', 'auth', 'PreventBackHistory', 'verified']], function(){
    //View manage request status
    Route::get('index',[EventStatusController::class, 'index'])->name('status.index');
    //eventStatus approve and deny
    Route::get('approve/{id}', [EventStatusController::class, 'approve'])->name('status.approve');
    Route::post('deny/{id}', [EventStatusController::class, 'deny'])->name('status.deny');
    //Delete organizer request
    Route::get('delete/{id}', [EventStatusController::class, 'delete'])->name('status.delete');
});

//Calendar 
Route::group(['prefix'=>'calendar', 'middleware'=>['isHost', 'auth', 'PreventBackHistory', 'verified']], function(){
    //View facility
    Route::get('index',[HostCalendarController::class, 'index'])->name('calendar.index');
    //calendar
    Route::get('view/{id}',[HostCalendarController::class, 'view'])->name('calendar.view');
    //Host facility reservation
    Route::post('create', [HostCalendarController::class, 'create'])->name('calendar.create');
});

//Profile
Route::group(['prefix'=>'host_profile', 'middleware'=>['isHost', 'auth', 'PreventBackHistory', 'verified']], function(){
    //View users profile
    Route::get('index', [HostProfileController::class, 'index'])->name('host_profile.index');
    //Update password
    Route::put('updatePassword', [HostProfileController::class, 'updatePassword'])->name('host_profile.updatePassword');
    //Update profile
    Route::put('updateProfile', [HostProfileController::class, 'updateProfile'])->name('host_profile.updateProfile');
});

//Reservation Logs 
Route::group(['prefix'=>'reservation', 'middleware'=>['isHost', 'auth', 'PreventBackHistory', 'verified']], function(){
    //View reservation logs
    Route::get('index', [HostLogController::class, 'index'])->name('reservation.index');
    //VIew event details
    Route::get('view/{id}',[HostLogController::class, 'view'])->name('reservation.view');
    //Delete host reservation
    Route::get('delete/{id}', [HostLogController::class, 'delete'])->name('reservation.delete');
    //Approve and deny attendees
    Route::get('approve/{id}', [HostLogController::class, 'approve'])->name('reservation.approve');
    Route::get('deny/{id}', [HostLogController::class, 'deny'])->name('reservation.deny');
    //Delete attendees
    Route::get('deleteAttendee/{id}', [HostLogController::class, 'deleteAttendee'])->name('reservation.deleteAttendee');
    //Delete Feedback
    Route::get('deleteFeedback/{id}', [HostLogController::class, 'deleteFeedback'])->name('reservation.deleteFeedback');

});

//----------------------------------------------End of host routes---------------------------------------------------------------
//----------------------------------------------Start of visitor routes----------------------------------------------------------

//Visitor
Route::group(['prefix'=>'visitor', 'middleware'=>['isVisitor', 'auth', 'PreventBackHistory', 'verified']], function(){
    // View page index
    Route::get('index', [VisitorController::class, 'index'])->name('visitor.index');
    Route::get('brgy/{id}', [VisitorController::class, 'brgy'])->name('visitor.brgy');
    Route::get('join/{id}', [VisitorController::class, 'join'])->name('visitor.join');
    Route::get('viewEvents/{id}', [VisitorController::class, 'viewEvents'])->name('visitor.viewEvents');
    Route::get('hide/{id}', [VisitorController::class, 'hide'])->name('visitor.hide');
});

//Profile
Route::group(['prefix'=>'visitor_profile', 'middleware'=>['isVisitor', 'auth', 'PreventBackHistory', 'verified']], function(){

    // View page
    Route::get('index', [VisitorProfileController::class, 'index'])->name('visitor_profile.index');
    // Update profile
    Route::put('update', [VisitorProfileController::class, 'update'])->name('visitor_profile.update');
    Route::put('updatePassword', [VisitorProfileController::class, 'updatePassword'])->name('visitor_profile.updatePassword');
});

Route::group(['prefix'=>'join', 'middleware'=>['isVisitor', 'auth', 'PreventBackHistory', 'verified']], function(){

    //View event
    Route::get('view/{id}', [VisitorJoinController::class, 'view'])->name('join.view');
    //Join event
    Route::post('store', [VisitorJoinController::class, 'store'])->name('join.store');
    //leave event
    Route::get('cancel/{id}', [VisitorJoinController::class, 'cancel'])->name('join.cancel');
});

Route::group(['prefix'=>'manage_event', 'middleware'=>['isVisitor', 'auth', 'PreventBackHistory', 'verified']], function(){

    //View joined eventes
    Route::get('index', [VisitorEventController::class, 'index'])->name('manage_event.index');
    //Feedback
    Route::get('view/{id}', [VisitorEventController::class, 'view'])->name('manage_event.view');
    //Post feedback
    Route::post('store', [VisitorEventController::class, 'store'])->name('manage_event.store');
});

//----------------------------------------------End of visitor routes-----------------------------------------------------------
//----------------------------------------------Start of Organizer routes-------------------------------------------------------

//Organizer  
Route::group(['prefix'=>'organizer', 'middleware'=>['isOrg', 'auth', 'PreventBackHistory', 'verified']], function(){

    // View page
    Route::get('index', [OrganizerController::class, 'index'])->name('organizer.index');

    Route::get('barangay/{id}', [OrganizerController::class, 'barangay'])->name('organizer.barangay');

    //Route::get('form', [OrganizerController::class, 'form'])->name('organizer.form');

});

//Organizer profile
Route::group(['prefix'=>'org_profile', 'middleware'=>['isOrg', 'auth', 'PreventBackHistory', 'verified']], function(){

    // View page
    Route::get('index', [OrgProfileController::class, 'index'])->name('org_profile.index');
    //Update profile
    Route::put('update', [OrgProfileController::class, 'update'])->name('org_profile.update');
    Route::put('updatePassword', [OrgProfileController::class, 'updatePassword'])->name('org_profile.updatePassword');
});

//Organizer reservation/calendar
Route::group(['prefix'=>'reserve', 'middleware'=>['isOrg', 'auth', 'PreventBackHistory', 'verified']], function(){
    //Calendar
    Route::get('calendar/{id}', [OrgReservationController::class, 'calendar'])->name('reserve.calendar');
    //Book facility
    Route::post('create', [OrgReservationController::class, 'create'])->name('reserve.create');
    //Report facility
    Route::post('report', [OrgReservationController::class,'report'])->name('reserve.report');
});

//Organizer manage reservation status
Route::group(['prefix'=>'manage', 'middleware'=>['isOrg', 'auth', 'PreventBackHistory', 'verified']], function(){

    //View page
    Route::get('index', [OrgManageStatusController::class, 'index'])->name('manage.index');
    //finished registered events
    Route::delete('delete/{id}', [OrgManageStatusController::class, 'delete'])->name('manage.delete');
    //cancel registered events
    Route::get('cancel/{id}', [OrgManageStatusController::class, 'cancel'])->name('manage.cancel');
});

//Organizer manage event
Route::group(['prefix'=>'event', 'middleware'=>['isOrg', 'auth', 'PreventBackHistory', 'verified']], function(){

    //View page
    Route::get('index',[OrgManageEventController::class, 'index'])->name('event.index');
    //View facility attendees/feedback
    Route::get('view/{id}',[OrgManageEventController::class, 'view'])->name('event.view');
    Route::get('attendeeList/{id}', [OrgManageEventController::class, 'attendeeList'])->name('event.attendeeList');
    //Approve and deny visitor
    Route::post('approve/{id}', [OrgManageEventController::class, 'approve'])->name('event.approve');
    Route::post('deny/{id}', [OrgManageEventController::class, 'deny'])->name('event.deny');
    //Remove Attendee
    Route::get('delete/{id}', [OrgManageEventController::class, 'delete'])->name('event.delete');
    //Delete Feedback
    Route::get('deleteFeedback/{id}', [OrgManageEventController::class, 'deleteFeedback'])->name('event.deleteFeedback');
});

//Organizer reservation record
Route::group(['prefix'=>'record', 'middleware'=>['isOrg', 'auth', 'PreventBackHistory', 'verified']], function(){

    //View page
    Route::get('index', [OrgRecordController::class, 'index'])->name('record.index');
    //Remove record reservation
    Route::get('delete/{id}', [OrgRecordController::class, 'delete'])->name('record.delete');
   
});

//----------------------------------------------End of organizer routes----------------------------------------------------------
