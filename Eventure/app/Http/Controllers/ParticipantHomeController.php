<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ParticipantHomeController extends Controller
{
    public function index(Request $request)
    {
        // // Ensure user is authenticated
        // if (!Auth::check()) {
        //     return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        // }

        // // Get the authenticated user's ID
        // $user_id = Auth::id();

        // // Fetch student details for autofill
        // $user = User::find($user_id);

        // // Base query for events
        // $eventsQuery = Event::where('event_status', 'approved')
        //                     ->where('application', 'open');

        // // Apply filters if provided
        // if ($request->filled('organizer')) {
        //     $eventsQuery->where('organizer', 'like', '%' . $request->organizer . '%');
        // }
        // if ($request->filled('event_type') && $request->event_type !== '0') {
        //     $eventsQuery->where('event_type', $request->event_type);
        // }

        // if ($request->filled('start_date')) {
        //     $start_date = $request->start_date;
        //     if ($start_date == 'last-week') {
        //         $eventsQuery->where('start_date', '>=', now()->subWeek());
        //     } elseif ($start_date == 'this-month') {
        //         $eventsQuery->where('start_date', '>=', now()->subMonth());
        //     } elseif ($start_date !== 'anytime') {
        //         $eventsQuery->whereDate('start_date', $start_date);
        //     }
        // }

        // if ($request->filled('location')) {
        //     $location = $request->location;
        //     if ($location === 'on-campus') {
        //         $eventsQuery->where('location', 'like', '%UTM%');
        //     } elseif ($location === 'off-campus') {
        //         $eventsQuery->where('location', 'not like', '%UTM%');
        //     }
        // }

        // if ($request->filled('event_role')) {
        //     $eventsQuery->where('event_role', $request->event_role);
        // }

        // if ($request->filled('event_format')) {
        //     $eventsQuery->where('event_format', $request->event_format);
        // }

        // // Always order by start_date descending
        // $eventsQuery->orderBy('start_date', 'desc');

        // // Execute query and get results
        // $events = $eventsQuery->get();

        // return view('participanthome', compact('user', 'events'));
    }

    public function display(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Fetch data from the database
        $resultCrew = DB::table('event_crews')
            ->join('events', 'event_crews.event_id', '=', 'events.event_id')
            ->select(
                'event_crews.crew_id',
                'event_crews.event_id',
                'events.status',
                'events.organizer',
                'events.event_name',
                'event_crews.role',
                'event_crews.application_status',
                'event_crews.created_at',
                'event_crews.updated_at'
            )
            ->where('event_crews.id', $user->id) // Use the user's ID
            ->get();

        // Log or debug the result
        if ($resultCrew->isEmpty()) {
            logger('No data found for user ID: ' . $user->id);
        }

        $resultParticipant = DB::table('event_participants as ep')
            ->join('events as e', 'ep.event_id', '=', 'e.event_id')
            ->select(
                'ep.participant_id',
                'e.organizer',
                'e.status',
                'ep.event_id',
                'e.event_name',
                'ep.registration_status',
                'ep.created_at',
                'ep.updated_at'
            )
            ->where('ep.id', $user->id)
            ->get();

        $feedbackOrganizerCrew = [];

        // Assuming $user is the authenticated user
        $user = Auth::user();

        // Use Laravel Query Builder to perform the query
        $feedbackOrganizerCrew = DB::table('feedbackcrew as fc')
            ->join('events as e', 'fc.event_id', '=', 'e.event_id')
            ->select(
                'fc.feedback_crew_id',
                'e.event_name',
                'fc.feedback_text',
                'fc.rating',
                'fc.created_at'
            )
            ->where('fc.from_id', $user->id) // Changed from whereIn to where
            ->get();




        // $feedbackParticipant = [];

        // // Assuming $participant_ids is an array that contains the participant IDs
        // $participant_ids = [1, 2, 3]; // Example participant IDs

        // if (!empty($participant_ids)) {
        //     // Use Laravel Query Builder to perform the query
        //     $feedbackParticipant = DB::table('feedbackevent as fe')
        //         ->join('events as e', 'fe.event_id', '=', 'e.event_id')
        //         ->select(
        //             'fe.feedbackevent_id', 
        //             'e.event_name', 
        //             'fe.feedback', 
        //             'fe.rating', 
        //             'fe.feedback_date'
        //         )
        //         ->whereIn('fe.participant_id', $participant_ids)
        //         ->get();
        // }


        // Pass data to the view
        return view('participant.participantdashboard', compact('resultCrew', 'resultParticipant', 'feedbackOrganizerCrew'));
    }
}
