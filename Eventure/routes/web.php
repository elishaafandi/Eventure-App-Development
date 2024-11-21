<?php
namespace App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController; // Correctly import AuthController
use App\Http\Controllers\ResetpasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController; // This might be unnecessary if not used
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
});

// Login routes
Route::view('/login', 'auth.login')->name('login'); // Route for showing the login form
Route::post('/login', [AuthController::class, 'login']); // Route for handling the login post request
Route::view('/Homepage', 'Homepage')->name('Homepage'); // Route for showing the login form
Route::view('/resetpassword', 'auth.resetpassword')->name('resetpasswordform');
Route::post('/resetpassword', [ResetpasswordController::class, 'Resetemailpass'])->name('resetpassword');

Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

//Route::get('/reset-password/{token}',[ResetpasswordController::class, 'passwordreset'] )->name('password.reset');
// Additional authentication routes provided by Laravel (register, reset password, etc.)
require __DIR__.'/auth.php';
