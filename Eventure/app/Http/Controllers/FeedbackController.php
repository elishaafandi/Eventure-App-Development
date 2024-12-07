<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FeedbackController extends Controller
{


    public function showEventFeedback(Request $request, $eventId, $clubId)
{
    // Log or debug parameters to ensure correct values are received
    if (!$clubId) {
        abort(404, 'Club ID is missing.');
    }

    if (!$eventId) {
        abort(404, 'Club ID is missing.');
    }

    //dd($clubId, $eventId);

    // Fetch all events for the given club
    $allEvents = DB::table('events')
        ->where('club_id', $clubId)
        ->get();

    // Fetch events specifically for crew rating
    $crewEvents = DB::table('events')
        ->where('club_id', $clubId)
        ->where('event_role', 'crew')
        ->get();

    // Fetch feedback for the specified event
    $feedbacks = DB::table('feedbackevent')
        ->leftJoin('event_participants', 'feedbackevent.participant_id', '=', 'event_participants.participant_id')
        ->leftJoin('users as participants', 'event_participants.id', '=', 'participants.id')
        ->where('feedbackevent.event_id', $eventId)
        ->select(
            'feedbackevent.*',
            'participants.username as participant_name'
        )
        ->orderBy('feedbackevent.feedback_date', 'desc')
        ->get();

    return view('participant.feedbackcrew', compact('feedbacks', 'allEvents', 'crewEvents'));
}




    public function submitCrewFeedback(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
            'crew_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|max:255',
        ]);

        $existingFeedback = DB::table('feedbackcrew')
            ->where('event_id', $request->event_id)
            ->where('crew_id', $request->crew_id)
            ->exists();

        if ($existingFeedback) {
            return redirect()->back()->with('error', 'You have already rated this crew member for this event.');
        }

        DB::table('feedbackcrew')->insert([
            'event_id' => $request->event_id,
            'crew_id' => $request->crew_id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'feedback_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    public function getCrewsByEvent(Request $request)
    {
        $eventId = $request->input('event_id');

        $crews = DB::table('event_crews')
            ->join('users', 'event_crews.id', '=', 'users.id')
            ->where('event_crews.event_id', $eventId)
            ->select('event_crews.crew_id', 'users.name', 'event_crews.role')
            ->get();

        return response()->json($crews);
    }


    public function showFeedbackForm(Request $request,  $eventId, $clubId)
    {
        $user_id = Auth::id();
        //dd($user,  $eventId, $request, $clubId);
        if (!$user_id || !$eventId) {
            return redirect()->back()->with('error', 'You must be logged in or event ID is missing.');
        }

        // Fetch user details
        $student = DB::selectOne("SELECT * FROM students WHERE id = ?", [$user_id]);

        // Fetch event details
        $event = DB::selectOne("SELECT * FROM events WHERE event_id = ?", [$eventId]);
        //dd( $student, $event);
        // Check if feedback exists
        $existing_feedback = DB::selectOne(
            "SELECT * FROM feedbackevent WHERE event_id = ? AND (participant_id = ? OR crew_id = ?)",
            [$eventId, session('participant_id'), session('crew_id')]
        );

        return view('participant.feedback_form', compact('student', 'event', 'existing_feedback'));
    }

    public function submitFeedback(Request $request, $event_id)
    {
        $user_id = Auth::id();
        $rating = intval($request->input('rating'));
        $feedback = $request->input('feedback');

        if (!$user_id || !$event_id || !$rating || !$feedback) {
            return redirect()->back()->with('error', 'Please fill out all required fields.');
        }

        // Check if feedback already exists
        $existing_feedback = DB::selectOne(
            "SELECT * FROM feedbackevent WHERE event_id = ? AND (participant_id = ? OR crew_id = ?)",
            [$event_id, session('participant_id'), session('crew_id')]
        );

        if ($existing_feedback) {
            return redirect()->back()->with('error', 'You have already submitted feedback for this event.');
        }

        $participant_id = session('participant_id');
        $crew_id = session('crew_id');

        if ($participant_id) {
            DB::insert(
                "INSERT INTO feedbackevent (participant_id, event_id, rating, feedback) VALUES (?, ?, ?, ?)",
                [$participant_id, $event_id, $rating, $feedback]
            );
        } elseif ($crew_id) {
            DB::insert(
                "INSERT INTO feedbackevent (crew_id, event_id, rating, feedback) VALUES (?, ?, ?, ?)",
                [$crew_id, $event_id, $rating, $feedback]
            );
        } else {
            return redirect()->back()->with('error', 'Error: Neither participant nor crew ID is set.');
        }

        return redirect()->route('feedback.success')->with('success', 'Feedback submitted successfully!');
    }
}
