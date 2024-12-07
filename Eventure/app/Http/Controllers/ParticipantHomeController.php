<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

        // Fetch crew data
        $resultCrew = DB::table('event_crews')
            ->join('events', 'event_crews.event_id', '=', 'events.event_id')
            ->select(
                'event_crews.crew_id',
                'event_crews.event_id',
                'events.status',
                'events.organizer',
                'events.club_id',
                'events.event_name',
                'event_crews.role',
                'event_crews.application_status',
                'event_crews.created_at',
                'event_crews.updated_at'
            )
            ->where('event_crews.id', $user->id)
            ->get();

        // Fetch participant data
        $resultParticipant = DB::table('event_participants as ep')
            ->join('events as e', 'ep.event_id', '=', 'e.event_id')
            ->select(
                'ep.participant_id',
                'e.organizer',
                'e.club_id',
                'e.status',
                'ep.event_id',
                'e.event_name',
                'ep.registration_status',
                'ep.created_at',
                'ep.updated_at'
            )
            ->where('ep.id', $user->id)
            ->get();

        $participant_ids = DB::table('event_participants')
            ->where('id', $user->id) // Replace `$user->id` with the authenticated user's ID
            ->pluck('participant_id');

        // Fetch feedback for participants
        $feedback_participant = collect();
        if ($participant_ids->isNotEmpty()) {
            $feedback_participant = DB::table('feedbackevent as fe')
                ->join('events as e', 'fe.event_id', '=', 'e.event_id')
                ->whereIn('fe.participant_id', $participant_ids)
                ->select('fe.feedbackevent_id', 'e.event_name', 'fe.feedback', 'fe.rating', 'fe.feedback_date')
                ->get();
        }

        // Fetch crew IDs
        $crew_ids = DB::table('event_crews')
            ->where('id', $user->id)
            ->pluck('crew_id');

        // Fetch feedback for the organizer's crew
        $feedback_organizer_crew = collect();
        if ($crew_ids->isNotEmpty()) {
            $feedback_organizer_crew = DB::table('feedbackcrew as fc')
                ->join('events as e', 'fc.event_id', '=', 'e.event_id')
                ->whereIn('fc.crew_id', $crew_ids)
                ->select('fc.crew_id', 'e.event_name', 'fc.feedback', 'fc.rating', 'fc.feedback_date')
                ->get();
        }

        $feedback_crew = collect();

        if (!empty($crew_ids)) {
            $feedback_crew = DB::table('feedbackevent as fe')
                ->join('events as e', 'fe.event_id', '=', 'e.event_id')
                ->whereIn('fe.crew_id', $crew_ids)
                ->select('fe.feedbackevent_id', 'e.event_name', 'fe.feedback', 'fe.rating', 'fe.feedback_date')
                ->get();
        }

        // Pass data to the view
        return view('participant.participantdashboard', compact('resultCrew', 'resultParticipant', 'feedback_participant', 'feedback_organizer_crew', 'feedback_crew'));
    }

    public function viewcrewApplication($event_id)
    {
        // Get the event
        $event = DB::table('events')->where('event_id', $event_id)->first();
        Log::info('Event fetched:', ['event' => $event]);
    
        $user = Auth::user();
        Log::info('Authenticated user:', ['user' => $user]);
    
        // Get the student's details for this event
        $student = DB::table('students as s')
            ->join('event_crews as ec', 's.id', '=', 'ec.id')
            ->where('ec.event_id', $event_id)
            ->where('ec.id', $user->id)
            ->select(
                's.student_photo',
                's.first_name',
                's.last_name',
                's.email',
                's.matric_no',
                's.phone',
                's.ic',
                's.college',
                's.year_course',
                's.gender',
                'ec.crew_id',
                'ec.past_experience',
                'ec.role',
                'ec.commitment',
                'ec.application_status'
            )
            ->first();
    
        // Check if the student exists
        if (!$student) {
            Log::warning('No student found for event ID:', ['event_id' => $event_id, 'user_id' => $user->id]);
            return redirect()->route('participantdashboard')->with('error', 'Student data not found for this event.');
        }
    
        // Return the view with the data
        return view('participant.viewcrewapplication', compact('student', 'event'));
    }
    
    
    

}
