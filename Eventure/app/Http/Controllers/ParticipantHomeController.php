<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
