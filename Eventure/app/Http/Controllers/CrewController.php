<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use App\Models\Crew;
use App\Models\Student; 

class CrewController extends Controller
{
    public function showCrewForm(Request $request)
    {
        // Retrieve event_id from the query string
        $event_id = $request->query('event_id'); 

        $events = Event::findOrFail($event_id);
        $user = User::where('id', Auth::id())->firstOrFail();
        $students = Student::where('id', Auth::id())->firstOrFail();

        return view('participant.crewform', compact('events', 'students'));
    }

    public function submitCrewForm(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'past_experience' => 'required|string',
            'role' => 'required|string',
            'commitment' => 'required|in:Yes,No',
        ]);

        $event_id = $request->event_id;
        $user_id = Auth::id();

        // Check if the user is already registered as a crew for the event
        $existingCrew = Crew::where('user_id', Auth::id())
        ->where('event_id', $request->event_id)
        ->exists();

        if ($existingCrew) {
            return redirect()->route('participant.participanthome')->with('error', 'You are already registered for this event.');
        }

        // Insert into the database
        Crew::create([
            'event_id' => $event_id,
            'id' => $user_id,
            'role' => $request->role,
            'commitment' => $request->commitment,
            'past_experience' => $request->past_experience,
        ]);

        // Save data to event_crews table
        $crew = new Crew();
        $crew->event_id = $request->event_id;
        $crew->user_id = Auth::id(); // Authenticated user
        $crew->role = $request->role;
        $crew->save();

        // Decrease available slots
        $events = Event::find($event_id);
        if ($events && $events->available_slots > 0) {
            $events->decrement('available_slots');
        } else {
            return redirect()->route('participant.participanthome')->with('error', 'No slots available for this event.');
        }

        return redirect()->route('participant.participanthome')->with('success', 'Registration successful!');
    }
}

