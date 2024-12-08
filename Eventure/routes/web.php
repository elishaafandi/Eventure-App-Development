<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\AuthController; // Correctly import AuthController
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\ParticipantHomeController;
use App\Http\Controllers\ParticipantDashController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Default home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (protected by auth and verified middleware)
Route::get('/dashboard', function () {
    return view('Homepage');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes for managing user profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
    
    Route::get('/profilepage', [ProfileController::class, 'index'])->name('profilepage');

    //Route::get('/profileactivity', [ProfileController::class, 'activity'])->name('profileactivity');
    Route::get('/Profileactivity', [ProfileController::class, 'showActivity'])->name('profileactivity');
    Route::get('/Profileexperience', [ProfileController::class, 'showExperience'])->name('profileexperience');
    
});

Route::view('/login', 'auth.login')->name('login'); // Route for showing the login form
Route::post('/login', [AuthController::class, 'login']); // Route for handling the login post request

Route::view('/Homepage', 'Homepage')->name('Homepage'); // Route for showing the login forM

Route::view('/resetpassword', 'auth.resetpassword')->name('resetpasswordform');
Route::post('/resetpassword', [ResetpasswordController::class, 'Resetemailpass'])->name('resetpassword');


Route::post('/profilepage', [ProfileController::class, 'update'])->name('profileEdit');
Route::get('/Profileclub', [ProfileController::class, 'showClub'])->name('profileclub');
Route::post('/profileclub/delete', [ProfileController::class, 'deleteClubMembership'])->name('deleteClubMembership');

Route::get('/organizerclubevent', [DashboardController::class, 'organizerclubevent'])->name('organizer');
Route::view('/addclub', 'addclub')->name('addclub'); 
Route::post('/addclub', [ClubController::class, 'createclub'])->name('createclub');

//Route::get('/participanthome', [ParticipantHomeController::class, 'index'])->name('participanthome');
Route::view('/participanthome', 'participant.participanthome')->name('participanthome');

// Route::view('/participantdashboard', 'participant.participantdashboard')->name('participantdashboard');
Route::get('/participantdashboard', [ParticipantHomeController::class, 'display'])->name('participantdashboard');
Route::get('/participant/viewcrew/{event_id}', [ParticipantDashController::class, 'viewCrewApplication'])->name('participantviewcrew');
Route::get('/participant/viewparticipant/{event_id}', [ParticipantDashController::class, 'viewParticipantApplication'])->name('participantviewparticipant');

// Route::view('/editparticipant', 'participant.editparticipant')->name('editparticipant');
Route::match(['get', 'post'], '/participant/edit-participant/{event_id}', [ParticipantDashController::class, 'editParticipant'])->name('editParticipant');
Route::match(['get', 'post'], '/participant/edit-crew/{event_id}', [ParticipantDashController::class, 'editCrew'])->name('editCrew');

Route::delete('/delete-crew/{event_id}', [ParticipantDashController::class, 'deleteCrew'])->name('deleteCrew'); 
Route::delete('/delete-participant/{event_id}', [ParticipantDashController::class, 'deleteParticipant'])->name('deleteParticipant'); 

//Route::view('/participanthome', 'participant.participanthome')->name('participanthome');
Route::get('/participanthome', [ParticipantHomeController::class, 'showParticipantHome'])->name('participanthome');

Route::middleware(['auth'])->group(function () {
    Route::get('/crewform', [CrewController::class, 'showCrewForm'])->name('crewform');
    Route::post('/crewform/submit', [CrewController::class, 'submitCrewForm'])->name('crewform.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/participantform', [ParticipantController::class, 'showParticipantForm'])->name('participantform');
    Route::post('/participantform/submit', [ParticipantController::class, 'submitParticipantForm'])->name('participantform.submit');
});

Route::get('/feedback/{eventId}/{clubId}', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.event');
Route::post('/feedback/crew', [FeedbackController::class, 'submitCrewFeedback'])->name('feedback.crew.submit');
Route::post('/feedback/crews', [FeedbackController::class, 'getCrewsByEvent'])->name('feedback.crews');

Route::get('/feedback-form/{eventId}/{clubId}', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.form');
Route::post('/submit-feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');

//Route::get('/participantdashboard', [ParticipantHomeController::class, 'display']);
//Route::get('/reset-password/{token}',[ResetpasswordController::class, 'passwordreset'] )->name('password.reset');
// Additional authentication routes provided by Laravel (register, reset password, etc.)
require __DIR__ . '/auth.php';
