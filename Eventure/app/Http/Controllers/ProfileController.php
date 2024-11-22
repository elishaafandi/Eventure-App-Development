<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        //dd($user->username); 
        if (!$user) {
            abort(404, 'User not found');
        }

        $username = $user->username;
        $email = $user->email;
        $role = $user->role;

        $student = \DB::table('students')->where('id', $user->id)->first();

        // Access student details
        $firstname = $student ? $student->first_name : null;
        $lastname = $student ? $student->last_name : null;
        $ic = $student ? $student->ic : null;
        $matricno = $student ? $student->matric_no : null;
        $gender = $student ? $student->gender : null;
        //dd($user->name); 
        return view('profile.Profilepage', compact('username', 'email', 'role', 'firstname', 'lastname', 'ic', 'matricno', 'gender'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'faculty' => 'required|string',
            'sem' => 'required|integer',
            'college' => 'required|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Find and update the student's information using DB query builder
        $updated = \DB::table('students')
            ->where('id', $user->id)
            ->update([
                'faculty_name' => $request->input('faculty'),
                'sem_of_study' => $request->input('sem'),
                'college' => $request->input('college'),
            ]);

        // Check if the update was successful
        if (!$updated) {
            return back()->withErrors(['error' => 'Failed to update student data']);
        }

        // Redirect back with success message
        return redirect()->route('profilepage')->with('status', 'Profile updated successfully!');
    }

    public function showDetails()
    {
        $user = Auth::user();
        // Fetch personal details from the database (or use hardcoded values)
        return view('profile.Profilepage', compact('user'));
    }

    public function showActivity()
    {
        $user = Auth::user();
        // Fetch activity data
        return view('profile.Profileactivity', compact('user'));
    }

    public function showExperience()
    {
        $user = Auth::user();
        // Fetch experience data
        return view('profile.Profileexperience', compact('user'));
    }


    /**
     * Delete the user's account.
     */
    public function showClub()
    {
        $user = Auth::user();
        // Fetch experience data
        return view('profile.Profileclub', compact('user'));
    }
}
