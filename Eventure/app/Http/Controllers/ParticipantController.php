<?php 

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\User;
use App\Models\Participant;
use App\Models\Student; 

class ParticipantController extends Controller
{
    public function showParticipantForm(Request $request)
    {
        $event_id = $request->query('event_id'); 

        $events = Event::where('event_id', $event_id)->firstOrFail();
        $students = Student::where('id', Auth::id())->firstOrFail();

        return view('participant.participantform', compact('events', 'students'));
    }

    public function submitParticipantForm(Request $request)
    {
        Log::info('Submitting form data', ['data' => $request->all()]);

        // Validate the form data
        $request->validate([
        'event_id' => 'required|exists:events,event_id',
        'attendance' => 'required|in:Yes,No',
        'requirements' => 'required|string',
        ]);

        $event_id = $request->event_id;
        $user_id = Auth::id();

        // Log to check if user is already registered
        Log::info("Checking registration for user $user_id in event $event_id");

        // Check if the user is already registered
        $existingParticipant = Participant::where('id', $user_id)
        ->where('event_id', $event_id)
        ->exists();

        if ($existingParticipant) {
            Log::info("User already registered for event $event_id");
            return redirect()->route('participanthome')
            ->with('error', 'You are already registered for this event.');
        }

        $participant = new Participant([
            'event_id' => $request->input('event_id'),
            'commitment' => $request->input('commitment'),
            'requirements' => $request->input('requirements'),
        ]);
    
        $participant->save();

        // Update available slots
        $event = Event::find($event_id);
        if ($event && $event->available_slots > 0) {
            $event->decrement('available_slots');
            Log::info("Decremented available slots for event $event_id");
        } else {
            Log::info("No available slots for event $event_id");
            return redirect()->route('participanthome')
                ->with('error', 'No slots available for this event.');
        }

        Log::info("Registration successful for event $event_id");

            return redirect()->route('participanthome')
            ->with('success', 'Registration successful!');
    }

}
