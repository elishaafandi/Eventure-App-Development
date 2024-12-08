<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\User;
use App\Models\Crew;
use App\Models\Student; 

class ParticipantHomeController extends Controller
{
    public function showParticipantHome(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        $students = Student::where('id', Auth::id())->firstOrFail();

        // Retrieve filter inputs
        $club_name = $request->input('club_name', ''); // Default to an empty string if not set
        $club_type = $request->input('club_type', '0'); // Default to '0' (Choose Club Type) if not set
        $start_date = $request->input('start_date', 'anytime'); // Default to 'anytime'
        $location = $request->input('location'); // Can be null or 'on-campus' / 'off-campus'
        $event_role = $request->input('event_role'); // 'crew' or 'participant'
        $event_format = $request->input('event_format'); // 'in-person' or 'online'

        // Initialize query and isFiltered flag
        $query = Event::query(); // Ensure only approved events are considered
        $isFiltered = false;

        // Apply filters and set the flag
        if (!empty($club_name)) {
            $query->whereHas('club', function ($q) use ($club_name) {
                $q->where('club_name', 'like', '%' . $club_name . '%');
            });
            $isFiltered = true;
        }

        if ($club_type !== '0') {
            $query->whereHas('club', function ($q) use ($club_type) {
                $q->where('club_type', $club_type);
            });
            $isFiltered = true;
        }

        if ($start_date && $start_date !== 'anytime') {
            $isFiltered = true;
            if ($start_date === 'last-week') {
                $query->where('start_date', '>=', now()->subWeek());
            } elseif ($start_date === 'this-month') {
                $query->where('start_date', '>=', now()->subMonth());
            }
        }

        if ($location) {
            $isFiltered = true;
            if ($location === 'on-campus') {
                $query->where('location', 'like', '%UTM%');
            } elseif ($location === 'off-campus') {
                $query->where('location', 'not like', '%UTM%');
            }
        }

        if ($event_role) {
            $query->where('event_role', $event_role);
            $isFiltered = true;
        }

        if ($event_format) {
            $query->where('event_format', $event_format);
            $isFiltered = true;
        }

        // Retrieve all events if no filters are applied
        $events = $query->get(); // Always get approved events, with or without filters


        // Pass variables to the view
        return view('participant.participanthome', compact(
            'students',
            'events', 
            'start_date', 
            'location', 
            'event_role', 
            'event_format', 
            'club_name', 
            'club_type', 
            'isFiltered'
        ));
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
