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
        $user = Auth::user(); // Get the authenticated user

        // Fetch activity data based on the user's ID
        $events = \DB::table('event_participants')
            ->join('events', 'event_participants.id', '=', 'events.organizer_id')
            ->where('event_participants.id', $user->id)
            ->select('events.organizer', 'events.event_name', 'events.description')
            ->distinct()
            ->get();

        // Pass the user and events data to the view
        return view('profile.Profileactivity', compact('user', 'events'));
    }


    public function showExperience()
    {
        $user = Auth::user();
        // Fetch experience data
        $user = Auth::user(); // Get the authenticated user

        // Fetch activity data based on the user's ID
        $events = \DB::table('event_crews')
            ->join('events', 'event_crews.event_id', '=', 'events.event_id')
            ->where('event_crews.id', $user->id)
            ->select('event_crews.role', 'events.organizer', 'events.event_name', 'events.description')
            ->distinct()
            ->get();

        return view('profile.Profileexperience', compact('user', 'events'));
    }


    /**
     * Delete the user's account.
     */
    public function showClub()
    {
        $user = Auth::user();

        $events = \DB::table('event_crews')
            ->join('club_memberships', 'event_crews.id', '=', 'club_memberships.user_id')
            ->join('events', 'club_memberships.club_id', '=', 'events.club_id')
            ->where('event_crews.id', $user->id)
            ->select('club_memberships.club_id', 'events.organizer', 'events.description')
            ->distinct()
            ->get();
        // Fetch experience data
        return view('profile.Profileclub', compact('user', 'events'));
    }


     //Delete the user's club memberships.
     
    public function deleteClubMembership(Request $request)
    {
        // Validate the request
        $request->validate([
            'club_id' => 'required|integer',
        ]);

        $user = Auth::user(); // Get the authenticated user

        // Attempt to delete the club membership
        $deleted = \DB::table('club_memberships')
            ->where('club_id', $request->club_id)
            ->where('user_id', $user->id)
            ->delete();

        // Check if the deletion was successful
        if ($deleted) {
            return back()->with('success', 'Club membership removed successfully.');
        } else {
            return redirect()->route('profileclub')->with('error', 'Failed to remove club membership.');
        }
    }
}
