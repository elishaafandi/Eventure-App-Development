<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController; // Correctly import AuthController
use App\Http\Controllers\ResetpasswordController;
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
//Route::get('/reset-password/{token}',[ResetpasswordController::class, 'passwordreset'] )->name('password.reset');
// Additional authentication routes provided by Laravel (register, reset password, etc.)
require __DIR__ . '/auth.php';
